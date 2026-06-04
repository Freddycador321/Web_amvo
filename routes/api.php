<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\JugadorEquipoCategoriaController;
use App\Http\Controllers\ArbitroController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NivelArbitroController;
use App\Http\Controllers\RamaController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\JugadorImportController;

/*
|--------------------------------------------------------------------------
| API Routes
| IMPORTANTE: las rutas estáticas deben ir ANTES que los apiResource
| para que Laravel no las confunda con parámetros dinámicos {id}.
|--------------------------------------------------------------------------
*/

// ---- Rutas estáticas de jugadores (deben ir ANTES del apiResource) ----
Route::get('jugadores/plantilla-excel', [JugadorImportController::class, 'plantilla']);
Route::post('jugadores/importar-excel', [JugadorImportController::class, 'importar']);
Route::post('jugadores/verificar-edades', [JugadorController::class, 'verificarEdades']);
Route::post('jugadores/image',            [JugadorController::class, 'imageUpload']);
Route::get('jugadores/image/{nombre}',    [JugadorController::class, 'image']);

// -------------------- CRUD BÁSICO --------------------
Route::apiResource('users', UserController::class);
Route::apiResource('jugadores', JugadorController::class)->parameters(['jugadores' => 'jugador']);
Route::apiResource('niveles-arbitro', NivelArbitroController::class);
Route::apiResource('arbitros', ArbitroController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('clubes', ClubController::class);
Route::apiResource('equipos', EquipoController::class);
Route::apiResource('jugador-equipo-categorias', JugadorEquipoCategoriaController::class);
Route::apiResource('ramas', RamaController::class);

// -------------------- JUGADOR: rutas con parámetro dinámico --------------------
Route::post('jugadores/{jugador}/traspaso', [JugadorController::class, 'traspaso']);
Route::get('jugadores/{jugador}/historial', [JugadorController::class, 'historial']);

// -------------------- ARBITRO RUTAS PERSONALIZADAS --------------------
Route::prefix('arbitros')->group(function () {
    Route::post('image',         [ArbitroController::class, 'imageUpload']);
    Route::get('image/{nombre}', [ArbitroController::class, 'image']);
});

// -------------------- CLUBES RUTAS PERSONALIZADAS --------------------
Route::prefix('clubes')->group(function () {
    Route::post('image',         [ClubController::class, 'imageUpload']);
    Route::get('image/{nombre}', [ClubController::class, 'image']);
});

// -------------------- BACKUP --------------------
Route::prefix('backup')->group(function () {
    Route::get('/',                  [BackupController::class, 'index']);
    Route::post('/',                 [BackupController::class, 'crear']);
    Route::get('/download/{file}',   [BackupController::class, 'download'])->where('file', '.+');
    Route::delete('/{file}',         [BackupController::class, 'eliminar'])->where('file', '.+');
    Route::get('/config',            [BackupController::class, 'getConfig']);
    Route::put('/config',            [BackupController::class, 'updateConfig']);
    Route::post('/restaurar/{file}', [BackupController::class, 'restaurar'])->where('file', '.+');
});

// -------------------- BITÁCORA --------------------
Route::get('/bitacora',          [BitacoraController::class, 'index']);
Route::get('/bitacora/usuarios', [BitacoraController::class, 'usuarios']);
Route::get('/bitacora/modelos',  [BitacoraController::class, 'modelos']);

// -------------------- AUTH --------------------
Route::post('/login',  [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me',      [AuthController::class, 'me']);
