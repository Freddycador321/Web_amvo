<?php

namespace App\Http\Controllers;

use App\Models\Arbitro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArbitroController extends Controller
{
    public function index(){
        $arbitros = Arbitro::get();
        return response()->json($arbitros);
    }//CRUD
    public function destroy($id){
        $arbitro=Arbitro::find($id);
        if($arbitro){
            $arbitro->delete();
            return response()->json('Eliminado Eliminado',200);
        }
        else
            return response()->json('No existe el Arbitro',409);
    }
    public function store(Request $request){
        $arbitro=Arbitro::create($request->all());
        return response()->json(($arbitro));
    }
    public function update(Request $request,$id){
        $arbitro=Arbitro::find($id);
        if($arbitro){
            $arbitro->update($request->all());
            return response()->json('Arbitro Actualizado',200);

        }
        else{
            return response()->json('No existe el Arbitro',409);
        }

    }
    public function show($id){
        $arbitro=Arbitro::find($id);
        return response()->json($arbitro);
    }

    // Subir imagen
    public function imageUpload(Request $request)
    {
        $imagen = $request->file('image');
        if (!$imagen) {
            return response()->json(['error' => 'No file provided'], 400);
        }
        $path_img = 'arbitros';
        $imageName = $imagen->getClientOriginalName();
        $fullPath = $path_img . '/' . $imageName;
        try {
            Storage::disk('public')->put($fullPath, File::get($imagen));
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Storage error'], 400);
        }
        // Devolver solo el nombre de archivo (frontend construye la URL o llama al endpoint de descarga con el nombre)
        return response()->json(['image' => $imageName]);
    }

    // Descargar imagen
    public function image($nombre)
    {
        try {
            return response()->download(public_path('storage') . '/arbitros/' . $nombre, $nombre);
        } catch (\Exception $exception) {
            return response()->json('error', 400);
        }
    }
}
