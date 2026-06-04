<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ClubController extends Controller
{
    // Listar clubes
    public function index()
    {
        $clubes = Club::with('equipos')->get();
        return response()->json($clubes);
    }

    // Crear club
    public function store(Request $request)
    {
        // Validación de campos
        $validator = Validator::make($request->all(), [
            'nombre'             => 'required|string|max:150',
            'logo'               => 'nullable|string|max:255',
            'sigla'              => 'nullable|string|max:50',
            'direccion'          => 'nullable|string|max:255',
            'telefono'           => 'nullable|string|max:30',
            'email'              => 'nullable|email|max:100',
            'presidente'         => 'nullable|string|max:100',
            'fecha_fundacion'    => 'nullable|date',
            'colores_oficiales'  => 'nullable|string|max:100',
            'municipio'          => 'nullable|string|max:100',
            'departamento'       => 'nullable|string|max:100',
            'estado'             => 'nullable|in:activo,inactivo'
        ]);

        // Si falla la validación
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear club usando solo los datos validados
        $club = Club::create($validator->validated());

        return response()->json($club, 201);
    }

    // Mostrar un club
    public function show(string $id)
    {
        $club = Club::with('equipos')->find($id);

        if ($club) {
            return response()->json($club);
        }

        return response()->json(['message' => 'No existe el club'], 404);
    }

    // Actualizar club
    public function update(Request $request, string $id)
    {
        $club = Club::find($id);

        if (!$club) {
            return response()->json(['message' => 'No existe el club'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'             => 'sometimes|required|string|max:150',
            'logo'               => 'nullable|string|max:255',
            'sigla'              => 'nullable|string|max:50',
            'direccion'          => 'nullable|string|max:255',
            'telefono'           => 'nullable|string|max:30',
            'email'              => 'nullable|email|max:100',
            'presidente'         => 'nullable|string|max:100',
            'fecha_fundacion'    => 'nullable|date',
            'colores_oficiales'  => 'nullable|string|max:100',
            'municipio'          => 'nullable|string|max:100',
            'departamento'       => 'nullable|string|max:100',
            'estado'             => 'nullable|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $club->update($validator->validated());

        return response()->json($club);
    }

    // Eliminar club
    public function destroy(string $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->delete();
            return response()->json(['message' => 'Club eliminado correctamente']);
        }

        return response()->json(['message' => 'No existe el club'], 404);
    }

    // Subir logo
    public function imageUpload(Request $request)
    {
        $imagen = $request->file('image');
        $path_img = 'clubes';
        $imageName = $path_img.'/'.$imagen->getClientOriginalName();
        try {
            Storage::disk('public')->put($imageName, File::get($imagen));
        } catch (\Exception $exception) {
            return response('error',400);
        }
        return response()->json(['image'=>$imageName]);
    }

    // Ver logo
    public function image($nombre)
    {
        try {
            return response()->download(public_path('storage').'/clubes/'.$nombre,$nombre);
        } catch(\Exception $exception) {
            return response()->json("error",400);
        }
    }
}
