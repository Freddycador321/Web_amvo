<?php

namespace App\Console\Commands;

use App\Http\Controllers\BackupController;
use Illuminate\Console\Command;

class CrearBackup extends Command
{
    protected $signature = 'backup:crear';
    protected $description = 'Crea un backup de la base de datos';

    public function handle(): int
    {
        $this->info('Creando backup...');

        $resultado = BackupController::ejecutarBackup();

        if (!$resultado['ok']) {
            $this->error($resultado['mensaje']);
            return Command::FAILURE;
        }

        $this->info("Backup creado: {$resultado['archivo']}");
        return Command::SUCCESS;
    }
}
