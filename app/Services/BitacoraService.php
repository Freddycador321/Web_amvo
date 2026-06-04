<?php

namespace App\Services;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BitacoraService
{
    public static function registrar(
        string $accion,
        ?string $modelo = null,
        ?int $modeloId = null,
        string $descripcion = '',
        ?array $datosAnteriores = null,
        ?array $datosNuevos = null
    ): void {
        try {
            // Intentar obtener usuario autenticado (puede no haber en comandos artisan)
            $userId = null;
            try {
                $user = JWTAuth::parseToken()->authenticate();
                $userId = $user?->id;
            } catch (\Throwable $e) {
                // Contexto sin JWT (artisan command, scheduler, etc.)
            }

            Bitacora::create([
                'user_id'          => $userId,
                'accion'           => $accion,
                'modelo'           => $modelo,
                'modelo_id'        => $modeloId,
                'descripcion'      => $descripcion,
                'ip'               => Request::ip(),
                'datos_anteriores' => $datosAnteriores,
                'datos_nuevos'     => $datosNuevos,
                'created_at'       => now(),
            ]);
        } catch (\Throwable $e) {
            // No interrumpir la operación principal si falla el log
        }
    }
}
