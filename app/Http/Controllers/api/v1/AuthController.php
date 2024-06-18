<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'credenciales incorrectas',
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'usuario autenticado correctamente',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'usuario creado correctamente',
            'user' => $user,
        ], 201);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'sesión cerrada correctamente',
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ], 200);
    }
}
