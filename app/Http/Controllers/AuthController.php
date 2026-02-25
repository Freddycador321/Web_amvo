<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::guard('api')->user();
            $access_token = JWTAuth::attempt($credentials);
            
            return response()->json([
                'access_token' => $access_token,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }
    }

    public function logout(Request $request){
        try {
            // Invalidar el token actual
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            // Si hay error invalidando, continuamos de todas formas
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ], 200);
    }  
}
