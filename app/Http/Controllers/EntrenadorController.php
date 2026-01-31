<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EntrenadorController extends Controller
{
    // Listar entrenadores
    public function index()
    {
        $entrenadores = Entrenador::with('equipos')->get();
        return response()->json($entrenadores);
    }

    // Crear entrenador
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:150',
            'telefono' => 'nullable|string|max:50',
            'foto'     => 'nullable|string|max:250',
            'estado'   => 'nullable|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        Entrenador::create($request->all());
        return $this->index();
    }

    // Mostrar entrenador
    public function show(string $id)
    {
        $entrenador = Entrenador::with('equipos')->find($id);

        if ($entrenador) {
            return response()->json($entrenador);
        }

        return response()->json(['message'=>'No existe el entrenador'],404);
    }

    // Actualizar entrenador
    public function update(Request $request, string $id)
    {
        $entrenador = Entrenador::find($id);

        if (!$entrenador) {
            return response()->json(['message'=>'No existe el entrenador'],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'   => 'sometimes|required|string|max:150',
            'telefono' => 'nullable|string|max:50',
            'foto'     => 'nullable|string|max:250',
            'estado'   => 'nullable|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $entrenador->update($request->all());
        return $this->index();
    }

    // Eliminar entrenador
    public function destroy(string $id)
    {
        $entrenador = Entrenador::find($id);

        if ($entrenador) {
            $entrenador->delete();
            return $this->index();
        }

        return response()->json(['message'=>'No existe el entrenador'],404);
    }

    // Subir foto
    public function imageUpload(Request $request)
    {
        $imagen = $request->file('image');
        $path_img = 'entrenadores';
        $imageName = $path_img.'/'.$imagen->getClientOriginalName();

        try {
            Storage::disk('public')->put($imageName, File::get($imagen));
        } catch (\Exception $exception) {
            return response('error',400);
        }

        return response()->json(['image'=>$imageName]);
    }

    // Ver foto
    public function image($nombre)
    {
        try {
            return response()->download(
                public_path('storage').'/entrenadores/'.$nombre,
                $nombre
            );
        } catch(\Exception $exception) {
            return response()->json("error",400);
        }
    }
}
