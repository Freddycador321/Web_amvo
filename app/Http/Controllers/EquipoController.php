<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Club;
use App\Models\Entrenador;
use App\Models\Equipo;
use App\Models\Rama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoController extends Controller
{
    // Listar equipos
    public function index()
{
    $equipos = Equipo::index();
    $clubes = Club::all();
    $categorias = Categoria::all();
    $ramas = Rama::all();
    $entrenadores = Entrenador::all();

    return response()->json([
        'equipos' => $equipos,
        'clubes' => $clubes,
        'categorias' => $categorias,
        'ramas' => $ramas,
        'entrenadores' => $entrenadores, // <- aquí
    ]);
}


    // Crear equipo
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'nombre'        => 'required|string|max:150',
        //     'club_id'       => 'required|exists:clubes,id',
        //     'categoria_id'  => 'required|exists:categorias,id',
        //     'rama_id'       => 'required|exists:ramas,id',
        //     'entrenador_id' => 'nullable|exists:entrenadores,id',
        //     'estado'        => 'nullable|in:activo,inactivo'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors'=>$validator->errors()],422);
        // }

        Equipo::create($request->all());
        return $this->index();
    }

    // Actualizar equipo
    public function update(Request $request, string $id)
    {
        $equipo = Equipo::find($id);

        if (!$equipo) {
            return response()->json(['message'=>'No existe el equipo'],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'        => 'sometimes|required|string|max:150',
            'club_id'       => 'sometimes|required|exists:clubes,id',
            'categoria_id'  => 'sometimes|required|exists:categorias,id',
            'rama_id'       => 'sometimes|required|exists:ramas,id',
            'entrenador_id' => 'nullable|exists:entrenadores,id',
            'estado'        => 'nullable|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $equipo->update($request->all());
        return $this->index();
    }

    // Eliminar equipo
    public function destroy(string $id)
    {
        $equipo = Equipo::find($id);

        if ($equipo) {
            $equipo->delete();
            return $this->index();
        }

        return response()->json(['message'=>'No existe el equipo'],404);
    }
}
