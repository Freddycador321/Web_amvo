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
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\HistorialJugadorController;
use App\Http\Controllers\NivelArbitroController;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\RamaController;
use App\Http\Controllers\TorneoEquipoController;
use App\Http\Controllers\TablaController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// -------------------- CRUD BÁSICO --------------------
Route::apiResource('users', UserController::class);
Route::apiResource('jugadores', JugadorController::class);
Route::apiResource('torneos', TorneoController::class);
Route::apiResource('inscripciones', InscripcionController::class);
Route::apiResource('niveles-arbitro', NivelArbitroController::class);
Route::apiResource('arbitros', ArbitroController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('clubes', ClubController::class);
Route::apiResource('equipos', EquipoController::class);
Route::apiResource('jugador-equipo-categorias', JugadorEquipoCategoriaController::class);
Route::apiResource('entrenadores', EntrenadorController::class);
Route::apiResource('ramas', RamaController::class);
//Route::apiResource('torneos-equipos', TorneoEquipoController::class);
Route::apiResource('partidos', PartidoController::class);
Route::apiResource('historial-jugadores', HistorialJugadorController::class);


// -------------------- JUGADOR RUTAS PERSONALIZADAS --------------------
Route::prefix('jugadores')->group(function () {
    Route::post('{jugador}/traspaso', [JugadorController::class, 'traspaso']);
    Route::post('{jugador}/inscribir', [JugadorController::class, 'inscribirTorneo']);
    Route::post('image', [JugadorController::class, 'imageUpload']);
    Route::get('image/{nombre}', [JugadorController::class, 'image']);
});

// -------------------- ARBITRO RUTAS PERSONALIZADAS --------------------
Route::prefix('arbitros')->group(function () {
    Route::post('image', [ArbitroController::class, 'imageUpload']);
    Route::get('image/{nombre}', [ArbitroController::class, 'image']);
});

// -------------------- CLUBES RUTAS PERSONALIZADAS --------------------
Route::prefix('clubes')->group(function () {
    Route::post('image', [ClubController::class, 'imageUpload']);
    Route::get('image/{nombre}', [ClubController::class, 'image']);
});

// -------------------- RUTA PROTEGIDA --------------------
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//-------------------TABLAS----------------------------
Route::get('tablas', [TablaController::class, 'index']);
Route::post('tablas', [TablaController::class, 'store']);
Route::put('tablas/{id}', [TablaController::class, 'update']);
Route::delete('tablas/{id}', [TablaController::class, 'destroy']);
Route::post('/tablas/buscar', [TablaController::class, 'buscar']);
//---------------HISTORIAL JUGADOR------------------------------
Route::get('historial-jugadores', [HistorialJugadorController::class, 'index']);
Route::get('historial-jugadores/buscar', [HistorialJugadorController::class, 'buscar']);
Route::post('historial-jugadores', [HistorialJugadorController::class, 'store']);

///////////LOGIN
Route::post('/login', [AuthController::class, 'login']);

