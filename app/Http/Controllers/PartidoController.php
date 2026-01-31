<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartidoController extends Controller
{
    // Listar partidos
    public function index()
    {
        $partidos = Partido::with(['torneo','equipoA','equipoB','categoria','rama'])->get();
        return response()->json($partidos);
    }

    // Crear partido
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'torneo_id'     => 'required|exists:torneos,id',
            'equipo_a_id'   => 'required|exists:equipos,id|different:equipo_b_id',
            'equipo_b_id'   => 'required|exists:equipos,id|different:equipo_a_id',
            'categoria_id'  => 'required|exists:categorias,id',
            'rama_id'       => 'required|exists:ramas,id',
            'fecha'         => 'nullable|date',
            'marcador_a'    => 'nullable|integer|min:0',
            'marcador_b'    => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        Partido::create($request->all());
        return $this->index();
    }

    // Mostrar partido
    public function show(string $id)
    {
        $partido = Partido::with(['torneo','equipoA','equipoB','categoria','rama'])->find($id);

        if ($partido) {
            return response()->json($partido);
        }

        return response()->json(['message'=>'No existe el partido'],404);
    }

    // Actualizar partido
    public function update(Request $request, string $id)
    {
        $partido = Partido::find($id);

        if (!$partido) {
            return response()->json(['message'=>'No existe el partido'],404);
        }

        $validator = Validator::make($request->all(), [
            'torneo_id'     => 'sometimes|required|exists:torneos,id',
            'equipo_a_id'   => 'sometimes|required|exists:equipos,id|different:equipo_b_id',
            'equipo_b_id'   => 'sometimes|required|exists:equipos,id|different:equipo_a_id',
            'categoria_id'  => 'sometimes|required|exists:categorias,id',
            'rama_id'       => 'sometimes|required|exists:ramas,id',
            'fecha'         => 'nullable|date',
            'marcador_a'    => 'nullable|integer|min:0',
            'marcador_b'    => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $partido->update($request->all());
        return $this->index();
    }

    // Eliminar partido
    public function destroy(string $id)
    {
        $partido = Partido::find($id);

        if ($partido) {
            $partido->delete();
            return $this->index();
        }

        return response()->json(['message'=>'No existe el partido'],404);
    }
}
