<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\JugadorEquipoCategoria;
use App\Models\Equipo;
use App\Models\Categoria;
use App\Models\Torneo;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class JugadorController extends Controller
{
    // Listar todos los jugadores
    public function index()
    {
        $jugadores = Jugador::with('jugadorEquipoCategorias.equipo','jugadorEquipoCategorias.categoria')->get();
        return response()->json($jugadores);
    }

    // Crear un nuevo jugador
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci' => 'required|string|unique:jugadores,ci',
            'fecha_naci' => 'required|date',
            'rama' => 'required|in:MASCULINO,FEMENINO'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $jugador = Jugador::create($request->all());
        return $this->index();
    }

    // Editar jugador
    public function update(Request $request, Jugador $jugador)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'ci' => "sometimes|required|string|unique:jugadores,ci,{$jugador->id}",
            'fecha_naci' => 'sometimes|required|date',
            'rama' => 'sometimes|required|in:MASCULINO,FEMENINO'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $jugador->update($request->all());
        return $this->index();
    }

    // Traspaso de jugador a otro equipo/categoría
    public function traspaso(Request $request, Jugador $jugador)
    {
        $validator = Validator::make($request->all(), [
            'equipo_id' => 'required|exists:equipos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'fecha_inicio' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        // Cerrar la relación anterior si existe
        $relacionActual = JugadorEquipoCategoria::where('jugador_id', $jugador->id)
            ->whereNull('fecha_fin')
            ->first();

        if ($relacionActual) {
            $relacionActual->fecha_fin = $request->fecha_inicio;
            $relacionActual->save();
        }

        // Crear nueva relación
        $nuevaRelacion = JugadorEquipoCategoria::create([
            'jugador_id' => $jugador->id,
            'equipo_id' => $request->equipo_id,
            'categoria_id' => $request->categoria_id,
            'fecha_inicio' => $request->fecha_inicio
        ]);

        return response()->json($nuevaRelacion, 201);
    }

    // Inscribir jugador a un torneo
    public function inscribirTorneo(Request $request, Jugador $jugador)
    {
        $validator = Validator::make($request->all(), [
            'torneo_id' => 'required|exists:torneos,id',
            'equipo_id' => 'required|exists:equipos,id',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        // Buscar relación jugador-equipo-categoria
        $relacion = JugadorEquipoCategoria::where('jugador_id', $jugador->id)
            ->where('equipo_id', $request->equipo_id)
            ->where('categoria_id', $request->categoria_id)
            ->whereNull('fecha_fin')
            ->first();

        if (!$relacion) {
            return response()->json(['error'=>'El jugador no pertenece a ese equipo/categoría actualmente.'], 422);
        }

        // Crear inscripción
        $inscripcion = Inscripcion::create([
            'jugador_equipo_categoria_id' => $relacion->id,
            'torneo_id' => $request->torneo_id,
            'estado' => 'CONFIRMADA'
        ]);

        return response()->json($inscripcion, 201);
    }
        public function destroy(string $id)
    {
        //
        $jugador = Jugador::find($id);

        if ($jugador) {
            $jugador->delete();

            return $this->index();
        }

        return response()->json(['message' => 'No existe el jugador'], 404);
    }
        public function imageUpload(Request $request){
        $imagen=$request->file('image');
        $path_img='jugadores';
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
             return response()->download(public_path('storage').'/jugadores/'.$nombre,$nombre);
       }
       catch(\Exception $exception){
            return response()->json("error",400);
       }

    }
};