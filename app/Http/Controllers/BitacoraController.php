<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BitacoraController extends Controller
{
    private function checkAdmin()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            abort(401, 'No autenticado');
        }

        if (!$user || $user->rol !== 'ADMIN') {
            abort(403, 'No autorizado');
        }

        return $user;
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Bitacora::with('user:id,nombre,apellido')
            ->orderByDesc('created_at');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('modelo')) {
            $query->where('modelo', $request->modelo);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $paginated = $query->paginate(20);

        return response()->json([
            'data'         => $paginated->items(),
            'total'        => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page'    => $paginated->lastPage(),
        ]);
    }

    public function usuarios()
    {
        $this->checkAdmin();
        $usuarios = User::select('id', 'nombre', 'apellido')->orderBy('nombre')->get();
        return response()->json($usuarios);
    }

    public function modelos()
    {
        $this->checkAdmin();

        $modelos = Bitacora::whereNotNull('modelo')
            ->distinct()
            ->pluck('modelo')
            ->sort()
            ->values();

        return response()->json($modelos);
    }
}
