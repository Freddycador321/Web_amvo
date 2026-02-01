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
        // dd($jugadores);
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
