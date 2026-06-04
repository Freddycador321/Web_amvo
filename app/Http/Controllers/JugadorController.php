<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Club;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\HistorialPas;
use App\Models\Jugador;
use App\Models\Rama;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class JugadorController extends Controller
{
    // Listar jugadores
    public function index()
    {
        $jugadores = Jugador::Index();
        $clubes = Club::all();
        $equipos = Equipo::all();
        $categorias = Categoria::all();
        $ramas = Rama::all();
        //Parte1 Visualizacion
        return response()->json(['jugadores'=> $jugadores, 'clubes'=> $clubes, 'equipos'=>$equipos,'categorias'=>$categorias,'ramas'=>$ramas]);
    }

    // Crear jugador
    public function store(Request $request)
    {
        // CI único
        if (Jugador::where('ci', $request->ci)->exists()) {
            return response()->json([
                'errors' => ['ci' => ['Ya existe un jugador registrado con esta Cédula de Identidad.']]
            ], 422);
        }

        $errorEdad = $this->validarEdadCategoria(
            $request->fecha_nacimiento,
            $request->categoria_id
        );
        if ($errorEdad) {
            return response()->json(['errors' => ['edad' => [$errorEdad]]], 422);
        }

        Jugador::create($request->all());
        return $this->index();
    }

    // Actualizar jugador
    public function update(Request $request, Jugador $jugador)
    {
        // CI único excluyendo el jugador actual
        if ($request->has('ci') && Jugador::where('ci', $request->ci)->where('id', '!=', $jugador->id)->exists()) {
            return response()->json([
                'errors' => ['ci' => ['Ya existe otro jugador registrado con esta Cédula de Identidad.']]
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'nombre'           => 'sometimes|required|string|max:100',
            'apellido'         => 'sometimes|required|string|max:100',
            'ci'               => 'sometimes|required|string|max:100',
            'club_id'          => 'sometimes|required|exists:clubes,id',
            'equipo_id'        => 'sometimes|required|exists:equipos,id',
            'categoria_id'     => 'sometimes|required|exists:categorias,id',
            'rama_id'          => 'sometimes|required|exists:ramas,id',
            'fecha_nacimiento' => 'sometimes|required|date',
            'posicion'         => 'nullable|string|max:50',
            'estado'           => 'nullable|in:activo,suspendido,retirado',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Auto-registrar en historial si cambian club / equipo / categoría / rama
        $cambia =
            ($request->has('club_id')      && (int)$request->club_id      !== (int)$jugador->club_id)      ||
            ($request->has('equipo_id')    && (int)$request->equipo_id    !== (int)$jugador->equipo_id)    ||
            ($request->has('categoria_id') && (int)$request->categoria_id !== (int)$jugador->categoria_id) ||
            ($request->has('rama_id')      && (int)$request->rama_id      !== (int)$jugador->rama_id);

        if ($cambia) {
            HistorialPas::create([
                'jugador_id'           => $jugador->id,
                'club_anterior_id'     => $jugador->club_id,
                'equipo_anterior_id'   => $jugador->equipo_id,
                'categoria_anterior_id'=> $jugador->categoria_id,
                'rama_anterior_id'     => $jugador->rama_id,
                'club_id'              => $request->club_id      ?? $jugador->club_id,
                'equipo_id'            => $request->equipo_id    ?? $jugador->equipo_id,
                'categoria_id'         => $request->categoria_id ?? $jugador->categoria_id,
                'rama_id'              => $request->rama_id      ?? $jugador->rama_id,
                'user_id'              => $this->getAuthUserId(),
                'fecha_cambio'         => now(),
            ]);
        }

        $fechaNac    = $request->fecha_nacimiento ?? $jugador->fecha_nacimiento;
        $categoriaId = $request->categoria_id    ?? $jugador->categoria_id;
        $errorEdad   = $this->validarEdadCategoria($fechaNac, $categoriaId);
        if ($errorEdad) {
            return response()->json(['errors' => ['edad' => [$errorEdad]]], 422);
        }

        $jugador->update($request->all());
        return $this->index();
    }

    // Eliminar jugador
    public function destroy(Jugador $jugador)
    {
        try {
            $jugador->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar el jugador: ' . $e->getMessage()
            ], 500);
        }
        return $this->index();
    }

    // Registrar pase/traspaso manual
    public function traspaso(Request $request, Jugador $jugador)
    {
        $validator = Validator::make($request->all(), [
            'club_id'      => 'required|exists:clubes,id',
            'equipo_id'    => 'required|exists:equipos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'rama_id'      => 'required|exists:ramas,id',
            'fecha_cambio' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        HistorialPas::create([
            'jugador_id'            => $jugador->id,
            'club_anterior_id'      => $jugador->club_id,
            'equipo_anterior_id'    => $jugador->equipo_id,
            'categoria_anterior_id' => $jugador->categoria_id,
            'rama_anterior_id'      => $jugador->rama_id,
            'club_id'               => $request->club_id,
            'equipo_id'             => $request->equipo_id,
            'categoria_id'          => $request->categoria_id,
            'rama_id'               => $request->rama_id,
            'user_id'               => $this->getAuthUserId(),
            'fecha_cambio'          => $request->fecha_cambio ?? now(),
        ]);

        $jugador->update([
            'club_id'      => $request->club_id,
            'equipo_id'    => $request->equipo_id,
            'categoria_id' => $request->categoria_id,
            'rama_id'      => $request->rama_id,
        ]);

        return $this->historial($jugador);
    }

    // Obtener historial de pases de un jugador
    public function historial(Jugador $jugador)
    {
        $historial = HistorialPas::where('historial_pases.jugador_id', $jugador->id)
            // Joins nuevos (actuales)
            ->join('clubes     as cn', 'historial_pases.club_id',      '=', 'cn.id')
            ->join('equipos    as en', 'historial_pases.equipo_id',    '=', 'en.id')
            ->join('categorias as catn', 'historial_pases.categoria_id','=', 'catn.id')
            ->join('ramas      as rn', 'historial_pases.rama_id',      '=', 'rn.id')
            // Joins anteriores (nullable)
            ->leftJoin('clubes     as ca', 'historial_pases.club_anterior_id',      '=', 'ca.id')
            ->leftJoin('equipos    as ea', 'historial_pases.equipo_anterior_id',    '=', 'ea.id')
            ->leftJoin('categorias as cata', 'historial_pases.categoria_anterior_id','=', 'cata.id')
            ->leftJoin('ramas      as ra', 'historial_pases.rama_anterior_id',      '=', 'ra.id')
            // Join usuario
            ->leftJoin('users', 'historial_pases.user_id', '=', 'users.id')
            ->select(
                'historial_pases.id',
                'historial_pases.jugador_id',
                'historial_pases.fecha_cambio',
                // Nuevos
                'cn.nombre   as nombre_club',
                'en.nombre   as nombre_equipo',
                'catn.nombre as nombre_categoria',
                'rn.nombre   as nombre_rama',
                // Anteriores
                'ca.nombre   as nombre_club_anterior',
                'ea.nombre   as nombre_equipo_anterior',
                'cata.nombre as nombre_categoria_anterior',
                'ra.nombre   as nombre_rama_anterior',
                // Usuario
                DB::raw("CONCAT(COALESCE(users.nombre,''), ' ', COALESCE(users.apellido,'')) as nombre_usuario")
            )
            ->orderBy('historial_pases.fecha_cambio', 'desc')
            ->get();

        return response()->json([
            'jugador'   => $jugador,
            'historial' => $historial,
        ]);
    }

    // Verificar edades y suspender jugadores fuera de rango
    public function verificarEdades()
    {
        $suspendidos = 0;
        $jugadores   = Jugador::where('estado', 'activo')->with('categoria')->get();

        foreach ($jugadores as $jugador) {
            if (!$jugador->categoria || is_null($jugador->categoria->edad_max)) continue;
            $edad = \Carbon\Carbon::parse($jugador->fecha_nacimiento)->age;
            if ($edad > $jugador->categoria->edad_max) {
                $jugador->update(['estado' => 'suspendido']);
                $suspendidos++;
            }
        }

        return response()->json([
            'message'     => "Verificación completada: {$suspendidos} jugador(es) suspendidos por mayoría de edad.",
            'suspendidos' => $suspendidos,
        ]);
    }

    // Validar edad del jugador contra los límites de la categoría
    private function validarEdadCategoria(?string $fechaNacimiento, $categoriaId): ?string
    {
        if (!$fechaNacimiento || !$categoriaId) return null;

        $categoria = Categoria::find($categoriaId);
        if (!$categoria || is_null($categoria->edad_min) || is_null($categoria->edad_max)) return null;

        $edad    = Carbon::parse($fechaNacimiento)->age;
        $edadMin = (int) $categoria->edad_min;
        $edadMax = (int) $categoria->edad_max;

        if ($edad < $edadMin) {
            return "El jugador tiene {$edad} años y es menor de edad para la categoría {$categoria->nombre} (mín. {$edadMin} años).";
        }
        if ($edad > $edadMax) {
            return "El jugador tiene {$edad} años y es mayor de edad para la categoría {$categoria->nombre} (máx. {$edadMax} años).";
        }

        return null;
    }

    // Obtener el ID del usuario autenticado via JWT (nullable)
    private function getAuthUserId(): ?int
    {
        try {
            $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
            return $user ? $user->id : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    // Subir imagen
    public function imageUpload(Request $request)
    {
        $imagen = $request->file('image');
        if (!$imagen) {
            return response()->json(['error' => 'No file provided'], 400);
        }
        $path_img = 'jugadores';
        $imageName = $imagen->getClientOriginalName();
        $fullPath = $path_img . '/' . $imageName;
        try {
            Storage::disk('public')->put($fullPath, File::get($imagen));
        } catch (\Exception $exception) {
            return response('error',400);
        }
        // Devolver solo el nombre del archivo
        return response()->json(['image' => $imageName]);
    }

    // Descargar imagen
    public function image($nombre)
    {
        try {
            $fullPath = public_path('storage') . '/jugadores/' . $nombre;
            return response()->file($fullPath);
        } catch(\Exception $exception) {
            return response()->json("error",400);
        }
    }
}
