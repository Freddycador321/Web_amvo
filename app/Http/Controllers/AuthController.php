<?php

namespace App\Http\Controllers;

use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = Auth::user();
        $access_token = JWTAuth::fromUser($user);

        BitacoraService::registrar(
            'LOGIN',
            'User',
            $user->id,
            "Inicio de sesión: {$user->nombre} {$user->apellido} ({$user->email})"
        );

        return response()->json([
            'access_token' => $access_token,
            'user'         => $user,
        ], 200);
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token inválido'], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user) {
                BitacoraService::registrar(
                    'LOGOUT',
                    'User',
                    $user->id,
                    "Cierre de sesión: {$user->nombre} {$user->apellido} ({$user->email})"
                );
            }
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            // Continuar aunque falle
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente',
        ], 200);
    }
}
