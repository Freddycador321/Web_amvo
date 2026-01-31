<?php

namespace App\Http\Controllers;

use App\Models\Tabla;
use Illuminate\Http\Request;

class TablaController extends Controller
{
    // 🔍 BUSCAR TABLA DE POSICIONES
    public function index(Request $request)
    {
        $request->validate([
            'torneo_id'    => 'required|integer',
            'categoria_id' => 'required|integer',
            'rama_id'      => 'required|integer',
        ]);

        $tablas = Tabla::with('equipo')
            ->where('torneo_id', $request->torneo_id)
            ->where('categoria_id', $request->categoria_id)
            ->where('rama_id', $request->rama_id)
            ->orderBy('puntos', 'desc')
            ->orderByRaw('(sets_favor - sets_contra) DESC')
            ->get();

        return response()->json($tablas);
    }

    // ➕ CREAR REGISTRO
    public function store(Request $request)
    {
        $data = $request->validate([
            'torneo_id'    => 'required',
            'equipo_id'    => 'required',
            'categoria_id' => 'required',
            'rama_id'      => 'required',
        ]);

        return Tabla::create($data);
    }
    public function buscar(Request $request)
{
    $request->validate([
        'torneo_id' => 'required|exists:torneos,id',
        'categoria_id' => 'required|exists:categorias,id',
        'rama_id' => 'required|exists:ramas,id',
    ]);

    $tablas = \App\Models\Tabla::with([
        'equipo',
        'equipo.club',
        'categoria',
        'rama'
    ])
    ->where('torneo_id', $request->torneo_id)
    ->where('categoria_id', $request->categoria_id)
    ->where('rama_id', $request->rama_id)
    ->orderByDesc('puntos')
    ->orderByDesc('sets_favor')
    ->get();

    return response()->json($tablas);
}

}
