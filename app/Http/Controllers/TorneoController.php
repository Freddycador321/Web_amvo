<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TorneoController extends Controller
{
    // Listar torneos
    public function index()
{
    $torneos = Torneo::with([
        'tablas.equipo',
        'tablas.categoria',
        'tablas.rama'
    ])->get();

    return response()->json($torneos);
}


    // Crear torneo
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'lugar'        => 'nullable|string|max:150',
            'estado'       => 'nullable|in:activo,finalizado,cancelado'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        Torneo::create($request->all());
        return $this->index();
    }

    // Mostrar torneo
    public function show(string $id)
    {
        $torneo = Torneo::with(['equipos','partidos'])->find($id);

        if ($torneo) {
            return response()->json($torneo);
        }

        return response()->json(['message'=>'No existe el torneo'],404);
    }

    // Actualizar torneo
    public function update(Request $request, string $id)
    {
        $torneo = Torneo::find($id);

        if (!$torneo) {
            return response()->json(['message'=>'No existe el torneo'],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'       => 'sometimes|required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'lugar'        => 'nullable|string|max:150',
            'estado'       => 'nullable|in:activo,finalizado,cancelado'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $torneo->update($request->all());
        return $this->index();
    }

    // Eliminar torneo
    public function destroy(string $id)
    {
        $torneo = Torneo::find($id);

        if ($torneo) {
            $torneo->delete();
            return $this->index();
        }

        return response()->json(['message'=>'No existe el torneo'],404);
    }
}
