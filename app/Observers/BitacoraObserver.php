<?php

namespace App\Observers;

use App\Services\BitacoraService;
use Illuminate\Database\Eloquent\Model;

class BitacoraObserver
{
    public function created(Model $model): void
    {
        $nombre = class_basename($model);
        BitacoraService::registrar(
            'CREAR',
            $nombre,
            $model->id,
            "Se creó un registro de {$nombre} (ID: {$model->id})",
            null,
            $model->toArray()
        );
    }

    public function updated(Model $model): void
    {
        $nombre = class_basename($model);
        BitacoraService::registrar(
            'ACTUALIZAR',
            $nombre,
            $model->id,
            "Se actualizó un registro de {$nombre} (ID: {$model->id})",
            $model->getOriginal(),
            $model->toArray()
        );
    }

    public function deleted(Model $model): void
    {
        $nombre = class_basename($model);
        BitacoraService::registrar(
            'ELIMINAR',
            $nombre,
            $model->id,
            "Se eliminó un registro de {$nombre} (ID: {$model->id})",
            $model->toArray(),
            null
        );
    }
}
