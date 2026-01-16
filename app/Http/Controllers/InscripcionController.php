<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $incripciones= Inscripcion::get();
        return response()->json($incripciones);
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
        $inscripcion=Inscripcion::create($request->all());
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
        $inscripcion=Inscripcion::find($id);
        if($inscripcion){
            $inscripcion->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el inscripcion',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $inscripcion = Inscripcion::find($id);

        if ($inscripcion) {
            $inscripcion->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el inscripcion'], 404);
    }
}
