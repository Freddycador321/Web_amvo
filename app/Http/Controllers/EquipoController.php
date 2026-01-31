<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoController extends Controller
{
    // Listar equipos
    public function index()
    {
        $equipos = Equipo::with(['club','categoria','rama','entrenador','jugadores'])->get();
        return response()->json($equipos);
    }

    // Crear equipo
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'        => 'required|string|max:150',
            'club_id'       => 'required|exists:clubes,id',
            'categoria_id'  => 'required|exists:categorias,id',
            'rama_id'       => 'required|exists:ramas,id',
            'entrenador_id' => 'nullable|exists:entrenadores,id',
            'estado'        => 'nullable|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

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
