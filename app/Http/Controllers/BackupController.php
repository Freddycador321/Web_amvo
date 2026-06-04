<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionBackup;
use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class BackupController extends Controller
{
    private function checkAdmin()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            abort(401, 'No autenticado');
        }

        if (!$user || $user->rol !== 'ADMIN') {
            abort(403, 'No autorizado');
        }

        return $user;
    }

    public function index()
    {
        $this->checkAdmin();

        $files = [];
        $disk = Storage::disk('local');

        if ($disk->exists('backups')) {
            foreach ($disk->files('backups') as $file) {
                $files[] = [
                    'nombre'  => basename($file),
                    'tamano'  => $disk->size($file),
                    'fecha'   => date('Y-m-d H:i:s', $disk->lastModified($file)),
                ];
            }
        }

        usort($files, fn($a, $b) => strcmp($b['fecha'], $a['fecha']));

        return response()->json($files);
    }

    public function crear()
    {
        $user = $this->checkAdmin();

        $resultado = static::ejecutarBackup();

        if (!$resultado['ok']) {
            return response()->json(['error' => $resultado['mensaje']], 500);
        }

        BitacoraService::registrar(
            'CREAR',
            'Backup',
            null,
            "Se creó un backup manual: {$resultado['archivo']}"
        );

        return response()->json(['mensaje' => 'Backup creado exitosamente', 'archivo' => $resultado['archivo']]);
    }

    public function download(string $filename)
    {
        $this->checkAdmin();

        $filename = basename($filename);
        $path = storage_path("app/backups/{$filename}");

        if (!file_exists($path) || !str_ends_with($filename, '.sql')) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        return response()->download($path);
    }

    public function eliminar(string $filename)
    {
        $this->checkAdmin();

        $filename = basename($filename);

        if (!str_ends_with($filename, '.sql')) {
            return response()->json(['error' => 'Archivo no válido'], 400);
        }

        if (!Storage::disk('local')->exists("backups/{$filename}")) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        Storage::disk('local')->delete("backups/{$filename}");

        return response()->json(['mensaje' => 'Backup eliminado']);
    }

    public function restaurar(string $filename)
    {
        $this->checkAdmin();

        $filename = basename($filename);
        if (!str_ends_with($filename, '.sql')) {
            return response()->json(['error' => 'Archivo no válido'], 400);
        }

        $path = storage_path("app/backups/{$filename}");
        if (!file_exists($path)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        try {
            $sql = file_get_contents($path);
            $pdo = DB::connection()->getPdo();

            // Deshabilitar verificación de claves foráneas
            $pdo->exec('SET FOREIGN_KEY_CHECKS=0');

            // Dividir en sentencias individuales (líneas que terminan con ;)
            $statements = [];
            $current    = '';

            foreach (explode("\n", $sql) as $line) {
                $line = rtrim($line);
                if (str_starts_with($line, '--') || $line === '') continue;
                $current .= ' ' . $line;
                if (str_ends_with($line, ';')) {
                    $s = trim($current);
                    if ($s !== '') $statements[] = $s;
                    $current = '';
                }
            }

            foreach ($statements as $statement) {
                $pdo->exec($statement);
            }

            $pdo->exec('SET FOREIGN_KEY_CHECKS=1');

            BitacoraService::registrar(
                'ACTUALIZAR',
                'Backup',
                null,
                "Restauración de backup: {$filename}"
            );

            return response()->json(['mensaje' => "Base de datos restaurada desde {$filename}"]);

        } catch (\Throwable $e) {
            return response()->json(['error' => 'Error al restaurar: ' . $e->getMessage()], 500);
        }
    }

    public function getConfig()
    {
        $this->checkAdmin();
        return response()->json(ConfiguracionBackup::first());
    }

    public function updateConfig(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'frecuencia' => 'required|in:DESACTIVADO,SEMANAL,MENSUAL',
            'dia_semana' => 'nullable|integer|min:0|max:6',
            'dia_mes'    => 'nullable|integer|min:1|max:31',
            'hora'       => ['required', 'regex:/^\d{2}:\d{2}$/'],
        ]);

        $config = ConfiguracionBackup::first();
        $config->update($validated);

        return response()->json($config);
    }

    /**
     * Genera un backup SQL usando PHP puro (sin depender de mysqldump en PATH).
     */
    public static function ejecutarBackup(): array
    {
        $backupDir = storage_path('app/backups');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backupDir . DIRECTORY_SEPARATOR . $filename;

        try {
            $pdo = DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();

            $sql  = "-- Backup AMVO: {$dbName}\n";
            $sql .= "-- Generado: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- --------------------------------------------------------\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            // Obtener todas las tablas
            $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // DROP + CREATE
                $createRow = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                $createStmt = $createRow['Create Table'] ?? $createRow[array_key_last($createRow)];

                $sql .= "\n-- Tabla: {$table}\n";
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                $sql .= $createStmt . ";\n\n";

                // Datos
                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                if (!empty($rows)) {
                    $columns = '`' . implode('`, `', array_keys($rows[0])) . '`';
                    $sql .= "INSERT INTO `{$table}` ({$columns}) VALUES\n";

                    $valueLines = [];
                    foreach ($rows as $row) {
                        $values = array_map(function ($v) use ($pdo) {
                            if ($v === null) return 'NULL';
                            return $pdo->quote((string) $v);
                        }, array_values($row));
                        $valueLines[] = '(' . implode(', ', $values) . ')';
                    }

                    $sql .= implode(",\n", $valueLines) . ";\n\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($filepath, $sql);

            if (!file_exists($filepath) || filesize($filepath) === 0) {
                return ['ok' => false, 'mensaje' => 'El archivo de backup se generó vacío.'];
            }

            return ['ok' => true, 'archivo' => $filename];

        } catch (\Throwable $e) {
            return ['ok' => false, 'mensaje' => 'Error al generar backup: ' . $e->getMessage()];
        }
    }
}
