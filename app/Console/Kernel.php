<?php

namespace App\Console;

use App\Models\ConfiguracionBackup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('backup:crear')->hourly()->when(function () {
            $cfg = ConfiguracionBackup::first();
            if (!$cfg || $cfg->frecuencia === 'DESACTIVADO') {
                return false;
            }

            [$h] = explode(':', $cfg->hora);
            if ((int) now()->format('H') !== (int) $h) {
                return false;
            }

            if ($cfg->frecuencia === 'SEMANAL') {
                return now()->dayOfWeek === (int) $cfg->dia_semana;
            }

            if ($cfg->frecuencia === 'MENSUAL') {
                return now()->day === (int) $cfg->dia_mes;
            }

            return false;
        });
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
