<?php

namespace App\Http\Controllers;

use App\Models\Arbitro;
use Illuminate\Http\Request;

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
}
