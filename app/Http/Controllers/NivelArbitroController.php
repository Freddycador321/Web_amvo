<?php

namespace App\Http\Controllers;

use App\Models\NivelArbitro;
use Illuminate\Http\Request;

class NivelArbitroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $nivelArbitros= NivelArbitro::get();
        return response()->json($nivelArbitros);
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
        $nivelArbitro=NivelArbitro::create($request->all());
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
        $nivelArbitro=NivelArbitro::find($id);
        if($nivelArbitro){
            $nivelArbitro->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el nivel arbitro',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $nivelArbitro = NivelArbitro::find($id);

        if ($nivelArbitro) {
            $nivelArbitro->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el nivel arbitro'], 404);
    }
}
