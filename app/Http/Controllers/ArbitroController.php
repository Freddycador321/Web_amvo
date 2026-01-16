<?php

namespace App\Http\Controllers;

use App\Models\Arbitro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Symfony\Component\HttpKernel\HttpCache\Store;

use function Laravel\Prompts\error;

class ArbitroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $arbitros= Arbitro::get();
        return response()->json($arbitros);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $arbitro=Arbitro::create($request->all());
        return response()->json($arbitro);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $arbitro=Arbitro::find($id);
        if($arbitro){
            $arbitro->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el arbitro',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $arbitro = Arbitro::find($id);

        if ($arbitro) {
            $arbitro->delete();

            return response()->json(['message' => 'Arbitro eliminado correctamente'], 200);
        }

        return response()->json(['message' => 'No existe el arbitro'], 404);
    }
    public function imageUpload(Request $request){
        $imagen=$request->file('image');
        $path_img='arbitros';
        $imageName=$path_img.'/'.$imagen->getClientOriginalName();
        try{
            Storage::disk('public')->put($imageName,File::get($imagen));
        }
        catch (\Exception $exception){
            return response('error',400);
        }
        return response()->json(['image'=>$imageName]);
    }
    public function image($nombre){
       try{
             return response()->download(public_path('storage').'/arbitros/'.$nombre,$nombre);
       }
       catch(\Exception $exception){
            return response()->json("error",400);
       }

    }
}
