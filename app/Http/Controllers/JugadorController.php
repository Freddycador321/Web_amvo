<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugador;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class JugadorController extends Controller
{
    // Listar jugadores
    public function index()
    {
        $jugadores = Jugador::with('club','equipo','categoria','rama')->get();
        return response()->json($jugadores);
    }

    // Crear jugador
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'club_id' => 'required|exists:clubes,id',
            'equipo_id' => 'required|exists:equipos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'rama_id' => 'required|exists:ramas,id',
            'fecha_nacimiento' => 'required|date',
            'posicion' => 'nullable|string|max:50',
            'estado' => 'nullable|in:activo,suspendido,retirado'


        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

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
        $path_img = 'jugadores';
        $imageName = $path_img.'/'.$imagen->getClientOriginalName();
        try {
            Storage::disk('public')->put($imageName, File::get($imagen));
        } catch (\Exception $exception) {
            return response('error',400);
        }
        return response()->json(['image'=>$imageName]);
    }

    // Descargar imagen
    public function image($nombre)
    {
        try {
            return response()->download(public_path('storage').'/jugadores/'.$nombre,$nombre);
        } catch(\Exception $exception) {
            return response()->json("error",400);
        }
    }
}
