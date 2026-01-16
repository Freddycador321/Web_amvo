<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $equipos= Equipo::get();
        return response()->json($equipos);
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
        $equipo=Equipo::create($request->all());
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
        $equipo=Equipo::find($id);
        if($equipo){
            $equipo->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el equipo',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $equipo = Equipo::find($id);

        if ($equipo) {
            $equipo->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el equipo'], 404);
    }
}
