<?php

namespace App\Http\Controllers;

use App\Models\Rama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RamaController extends Controller
{
    // Listar ramas
    public function index()
    {
        $ramas = Rama::get();
        return response()->json($ramas);
    }

    // Crear rama
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        Rama::create($request->all());
        return $this->index();
    }

    // Mostrar rama
    public function show(string $id)
    {
        $rama = Rama::find($id);

        if ($rama) {
            return response()->json($rama);
        }

        return response()->json(['message'=>'No existe la rama'],404);
    }

    // Actualizar rama
    public function update(Request $request, string $id)
    {
        $rama = Rama::find($id);

        if (!$rama) {
            return response()->json(['message'=>'No existe la rama'],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $rama->update($request->all());
        return $this->index();
    }

    // Eliminar rama
    public function destroy(string $id)
    {
        $rama = Rama::find($id);

        if ($rama) {
            $rama->delete();
            return $this->index();
        }

        return response()->json(['message'=>'No existe la rama'],404);
    }
}
