<?php

namespace App\Http\Controllers;

use App\Models\JugadorEquipoCategoria;
use Illuminate\Http\Request;

class JugadorEquipoCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jugadorEquipoCategorias= JugadorEquipoCategoria::get();
        return response()->json($jugadorEquipoCategorias);
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
        $jugadorEquipoCategoria=JugadorEquipoCategoria::create($request->all());
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
        $jugadorEquipoCategoria=JugadorEquipoCategoria::find($id);
        if($jugadorEquipoCategoria){
            $jugadorEquipoCategoria->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el Jugador Equipo Categoria',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $jugadorEquipoCategoria = JugadorEquipoCategoria::find($id);

        if ($jugadorEquipoCategoria) {
            $jugadorEquipoCategoria->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el jugadorEquipoCategoria'], 404);
    }
}
