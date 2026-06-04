<?php

namespace App\Providers;

use App\Models\Arbitro;
use App\Models\Categoria;
use App\Models\Club;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\JugadorEquipoCategoria;
use App\Models\NivelArbitro;
use App\Models\Rama;
use App\Models\User;
use App\Observers\BitacoraObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        Jugador::observe(BitacoraObserver::class);
        Club::observe(BitacoraObserver::class);
        Equipo::observe(BitacoraObserver::class);
        Arbitro::observe(BitacoraObserver::class);
        Categoria::observe(BitacoraObserver::class);
        Rama::observe(BitacoraObserver::class);
        User::observe(BitacoraObserver::class);
        NivelArbitro::observe(BitacoraObserver::class);
        JugadorEquipoCategoria::observe(BitacoraObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
