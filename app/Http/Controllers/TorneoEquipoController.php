<?php

namespace App\Http\Controllers;

use App\Models\TorneoEquipo;
use Illuminate\Http\Request;

class TorneoEquipoController extends Controller
{
    // Obtener tabla de posiciones filtrada por torneo, categoría y rama
    public function tablaPosiciones(Request $request)
    {
        $request->validate([
            'torneo_id' => 'required|integer',
            'categoria_id' => 'required|integer',
            'rama_id' => 'required|integer'
        ]);

        $tabla = TorneoEquipo::with('equipo')
            ->where('torneo_id', $request->torneo_id)
            ->where('categoria_id', $request->categoria_id)
            ->where('rama_id', $request->rama_id)
            ->orderByDesc('puntos')
            ->orderByDesc('sets_favor')
            ->get();

        return response()->json($tabla);
    }

    // Opcional: agregar equipo a un torneo
    public function agregar(Request $request)
    {
        $request->validate([
            'torneo_id' => 'required|integer',
            'equipo_id' => 'required|integer',
            'categoria_id' => 'required|integer',
            'rama_id' => 'required|integer'
        ]);

        $equipo = TorneoEquipo::create($request->all());

        return response()->json($equipo);
    }
}
