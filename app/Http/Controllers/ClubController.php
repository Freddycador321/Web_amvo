<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Illuminate\Support\Facades\File;


class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Clubs= Club::get();
        return response()->json($Clubs);
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
        $club=Club::create($request->all());
        return $this->index();
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
        $club=Club::find($id);
        if($club){
            $club->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el club',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $club = Club::find($id);

        if ($club) {
            $club->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el club'], 404);
    }
    public function imageUpload(Request $request){
        $imagen=$request->file('image');
        $path_img='clubes';
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
             return response()->download(public_path('storage').'/clubes/'.$nombre,$nombre);
       }
       catch(\Exception $exception){
            return response()->json("error",400);
       }

    }
}
