<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Club;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Rama;
use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class JugadorImportController extends Controller
{
    /** Descarga la plantilla Excel con datos de referencia */
    public function plantilla()
    {
        $clubes     = Club::orderBy('nombre')->pluck('nombre')->toArray();
        $equipos    = Equipo::orderBy('nombre')->pluck('nombre')->toArray();
        $categorias = Categoria::orderBy('nombre')->pluck('nombre')->toArray();
        $ramas      = Rama::orderBy('nombre')->pluck('nombre')->toArray();

        $spreadsheet = new Spreadsheet();

        // ── Hoja 1: JUGADORES ──────────────────────────────────────
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('JUGADORES');

        $headers = ['Nombre', 'Apellido', 'CI', 'Fecha_Nacimiento', 'Posicion', 'Club', 'Equipo', 'Categoria', 'Rama'];

        // Encabezados
        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        // Estilo encabezados
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F3C6E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);

        // Fila de ejemplo
        $ejemplo = ['Juan', 'Pérez García', '12345678', '2005-03-15', 'Libero',
                    $clubes[0] ?? 'Club Ejemplo', $equipos[0] ?? 'Equipo Ejemplo',
                    $categorias[0] ?? 'Sub-18', $ramas[0] ?? 'Varones'];
        $sheet->fromArray([$ejemplo], null, 'A2');

        $sheet->getStyle('A2:I2')->applyFromArray([
            'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F4FD']],
            'font'    => ['italic' => true, 'color' => ['rgb' => '64748B']],
        ]);

        // Anchos de columna
        $widths = [18, 20, 14, 18, 14, 22, 22, 16, 14];
        foreach ($widths as $i => $w) {
            $sheet->getColumnDimensionByColumn($i + 1)->setWidth($w);
        }

        // ── Hoja 2: REFERENCIA ─────────────────────────────────────
        $ref = $spreadsheet->createSheet();
        $ref->setTitle('REFERENCIA');

        $cols = [
            ['Clubes',      $clubes],
            ['Equipos',     $equipos],
            ['Categorias',  $categorias],
            ['Ramas',       $ramas],
        ];

        foreach ($cols as $c => $data) {
            [$title, $values] = $data;
            $col = chr(65 + $c);

            $ref->setCellValue($col . '1', $title);
            $ref->getStyle($col . '1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A6BC4']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $ref->getColumnDimension($col)->setWidth(24);

            foreach ($values as $row => $val) {
                $ref->setCellValue($col . ($row + 2), $val);
                if ($row % 2 === 0) {
                    $ref->getStyle($col . ($row + 2))->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('F0F7FF');
                }
            }
        }

        // Nota instructiva en hoja 1
        $maxRow = max(count($clubes), count($equipos), count($categorias), count($ramas)) + 3;
        $sheet->setCellValue('A' . ($maxRow + 2), '⚠ Los nombres de Club, Equipo, Categoría y Rama deben coincidir exactamente con los listados en la hoja REFERENCIA.');
        $sheet->getStyle('A' . ($maxRow + 2))->applyFromArray([
            'font'      => ['italic' => true, 'color' => ['rgb' => 'B45309'], 'size' => 9],
        ]);
        $sheet->mergeCells('A' . ($maxRow + 2) . ':I' . ($maxRow + 2));

        // Volver a hoja 1
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Plantilla_Jugadores_AMVO.xlsx';

        // streamDownload pasa por el middleware de Laravel (incluye CORS)
        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $filename,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control'       => 'max-age=0',
            ]
        );
    }

    /** Importa jugadores desde Excel */
    public function importar(Request $request)
    {
        if (!$request->hasFile('archivo')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 422);
        }

        $file = $request->file('archivo');

        // Cargar catálogos para lookups (case-insensitive)
        $clubes     = Club::all()->keyBy(fn($c) => mb_strtolower(trim($c->nombre)));
        $equipos    = Equipo::all()->keyBy(fn($e) => mb_strtolower(trim($e->nombre)));
        $categorias = Categoria::all()->keyBy(fn($c) => mb_strtolower(trim($c->nombre)));
        $ramas      = Rama::all()->keyBy(fn($r) => mb_strtolower(trim($r->nombre)));

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
        } catch (\Throwable $e) {
            return response()->json(['error' => 'No se pudo leer el archivo: ' . $e->getMessage()], 422);
        }

        $sheet = $spreadsheet->getActiveSheet();
        $rows  = $sheet->toArray(null, true, true, false);

        $importados = 0;
        $errores    = [];

        foreach ($rows as $idx => $row) {
            if ($idx === 0) continue; // encabezado

            // Ignorar filas completamente vacías
            $fila = array_map(fn($v) => trim((string) ($v ?? '')), $row);
            if (array_filter($fila) === []) continue;

            $lineNum = $idx + 1;

            [$nombre, $apellido, $ci, $fechaNac, $posicion, $clubNombre, $equipoNombre, $categoriaNombre, $ramaNombre]
                = array_pad($fila, 9, '');

            $rowErrors = [];

            // Validaciones básicas
            if (!$nombre)   $rowErrors[] = 'Nombre requerido';
            if (!$apellido) $rowErrors[] = 'Apellido requerido';
            if (!$ci)       $rowErrors[] = 'CI requerido';
            if (!$fechaNac) $rowErrors[] = 'Fecha_Nacimiento requerida';

            // Normalizar fecha: acepta YYYY-MM-DD, DD/MM/YYYY, DD-MM-YYYY, número de serie Excel
            $fechaFinal = null;
            if ($fechaNac) {
                $fechaFinal = $this->normalizarFecha($fechaNac, $row, $idx);
                if (!$fechaFinal) {
                    $rowErrors[] = "Fecha inválida: \"$fechaNac\". Usa formato AAAA-MM-DD o DD/MM/AAAA";
                }
            }

            // Lookup relaciones
            $clubId = $equipoId = $categoriaId = $ramaId = null;

            if ($clubNombre) {
                $club = $clubes[mb_strtolower($clubNombre)] ?? null;
                $club ? $clubId = $club->id : $rowErrors[] = "Club no encontrado: \"$clubNombre\"";
            }
            if ($equipoNombre) {
                $equipo = $equipos[mb_strtolower($equipoNombre)] ?? null;
                $equipo ? $equipoId = $equipo->id : $rowErrors[] = "Equipo no encontrado: \"$equipoNombre\"";
            }
            if ($categoriaNombre) {
                $categoria = $categorias[mb_strtolower($categoriaNombre)] ?? null;
                $categoria ? $categoriaId = $categoria->id : $rowErrors[] = "Categoría no encontrada: \"$categoriaNombre\"";
            }
            if ($ramaNombre) {
                $rama = $ramas[mb_strtolower($ramaNombre)] ?? null;
                $rama ? $ramaId = $rama->id : $rowErrors[] = "Rama no encontrada: \"$ramaNombre\"";
            }

            // CI duplicado
            if ($ci && Jugador::where('ci', $ci)->exists()) {
                $rowErrors[] = "CI \"$ci\" ya está registrado";
            }

            if (!empty($rowErrors)) {
                $errores[] = ['fila' => $lineNum, 'nombre' => "$nombre $apellido", 'errores' => $rowErrors];
                continue;
            }

            // Crear jugador — envuelto en try-catch para que un error no detenga el resto
            try {
                Jugador::create([
                    'nombre'           => $nombre,
                    'apellido'         => $apellido,
                    'ci'               => $ci,
                    'fecha_nacimiento' => $fechaFinal,
                    'posicion'         => $posicion ?: null,
                    'club_id'          => $clubId,
                    'equipo_id'        => $equipoId,
                    'categoria_id'     => $categoriaId,
                    'rama_id'          => $ramaId,
                    'estado'           => 'activo',
                ]);
                $importados++;
            } catch (\Throwable $e) {
                $errores[] = ['fila' => $lineNum, 'nombre' => "$nombre $apellido", 'errores' => ['Error al guardar: ' . $e->getMessage()]];
            }
        }

        BitacoraService::registrar(
            'CREAR',
            'Jugador',
            null,
            "Importación masiva: $importados jugadores importados, " . count($errores) . ' errores.'
        );

        return response()->json([
            'importados' => $importados,
            'errores'    => $errores,
            'total_filas'=> $importados + count($errores),
        ]);
    }

    /**
     * Convierte cualquier formato de fecha a YYYY-MM-DD.
     * Acepta: YYYY-MM-DD, DD/MM/YYYY, DD-MM-YYYY, M/D/YYYY, número de serie Excel.
     */
    private function normalizarFecha(string $valor, array $rawRow, int $rowIdx): ?string
    {
        $v = trim($valor);
        if ($v === '') return null;

        // Ya está en formato correcto YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
            return $v;
        }

        // Número de serie Excel (ej. 36809 = 10/10/2000)
        if (is_numeric($v)) {
            try {
                $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $v);
                return $dt->format('Y-m-d');
            } catch (\Throwable $e) {}
        }

        // DD/MM/YYYY o D/M/YYYY
        if (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{4})$#', $v, $m)) {
            return sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        }

        // DD-MM-YYYY
        if (preg_match('#^(\d{1,2})-(\d{1,2})-(\d{4})$#', $v, $m)) {
            return sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        }

        // Intentar parseo genérico con Carbon como último recurso
        try {
            return \Carbon\Carbon::parse($v)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
