<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return response()->json($users);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // 🔐 Hashear contraseña SOLO al crear
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        User::create($data);

        return $this->index();
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if ($user) {
            $data = $request->all();

            // 🔐 Hashear contraseña SOLO si se envía
            if (isset($data['password']) && $data['password'] !== '') {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); // evita sobreescribir
            }

            $user->update($data);

            return $this->index();
        } else {
            return response()->json('No existe el usuario', 409);
        }
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return $this->index();
        }

        return response()->json(['message' => 'No existe el usuario'], 404);
    }
}
