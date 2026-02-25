<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Club;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\Rama;
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

        Jugador::create($request->all());
        return $this->index();
    }

    // Actualizar jugador
    public function update(Request $request, Jugador $jugador)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'ci' => 'sometimes|required|string|max:100',
            'club_id' => 'sometimes|required|exists:clubes,id',
            'equipo_id' => 'sometimes|required|exists:equipos,id',
            'categoria_id' => 'sometimes|required|exists:categorias,id',
            'rama_id' => 'sometimes|required|exists:ramas,id',
            'fecha_nacimiento' => 'sometimes|required|date',
            'posicion' => 'nullable|string|max:50',
            'estado' => 'nullable|in:activo,suspendido,retirado'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $jugador->update($request->all());
        return $this->index();
    }

    // Eliminar jugador
    public function destroy(Jugador $jugador)
    {
        $jugador->delete();
        return $this->index();
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
