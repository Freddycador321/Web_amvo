<?php

namespace App\Http\Controllers;

use App\Models\HistorialJugador;
use Illuminate\Http\Request;

class HistorialJugadorController extends Controller
{
    // Buscar historial por nombre o CI
    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $historial = HistorialJugador::with(['jugador', 'club', 'equipo'])
            ->whereHas('jugador', function($q) use ($query) {
                $q->where('nombre', 'like', "%$query%")
                  ->orWhere('ci', 'like', "%$query%");
            })
            ->orderBy('created_at','desc')
            ->get();

        return response()->json($historial);
    }

    // Listar todo el historial (opcional)
    public function index()
    {
        $historial = HistorialJugador::with(['jugador','club','equipo'])
            ->orderBy('created_at','desc')
            ->get();

        return response()->json($historial);
    }

    // Crear historial
    public function store(Request $request)
    {
        $request->validate([
            'jugador_id' => 'required|exists:jugadores,id',
            'club_id' => 'required|exists:clubes,id',
            'equipo_id' => 'required|exists:equipos,id',
            'temporada' => 'required|string|max:20',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $historial = HistorialJugador::create($request->all());

        return response()->json($historial);
    }
}
