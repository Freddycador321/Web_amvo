<?php

namespace App\Console\Commands;

use App\Models\Jugador;
use App\Models\Categoria;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class VerificarEdadesJugadores extends Command
{
    protected $signature   = 'jugadores:verificar-edades';
    protected $description = 'Suspende a los jugadores que superaron la edad máxima de su categoría';

    public function handle(): void
    {
        $suspendidos = 0;
        $activos     = 0;

        $jugadores = Jugador::where('estado', 'activo')
            ->with('categoria')
            ->get();

        foreach ($jugadores as $jugador) {
            if (!$jugador->categoria || is_null($jugador->categoria->edad_max)) {
                continue;
            }

            $edad = Carbon::parse($jugador->fecha_nacimiento)->age;

            if ($edad > $jugador->categoria->edad_max) {
                $jugador->update(['estado' => 'suspendido']);
                $suspendidos++;
                $this->line("  ⚠ Suspendido: {$jugador->nombre} {$jugador->apellido} (edad {$edad}, máx {$jugador->categoria->edad_max} en {$jugador->categoria->nombre})");
            } else {
                $activos++;
            }
        }

        $this->info("Verificación completa:");
        $this->info("  → {$suspendidos} jugador(es) suspendidos por mayoría de edad.");
        $this->info("  → {$activos} jugador(es) dentro del rango.");
    }
}
