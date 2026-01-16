<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;

class TorneoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $torneos= Torneo::get();
        return response()->json($torneos);
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
        $torneo=Torneo::create($request->all());
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
        $torneo=Torneo::find($id);
        if($torneo){
            $torneo->update($request->all());
            return $this->index();
        }
        else{
            return response()->json('No existe el usuario',409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $torneo = Torneo::find($id);

        if ($torneo) {
            $torneo->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el torneo'], 404);
    }
}
