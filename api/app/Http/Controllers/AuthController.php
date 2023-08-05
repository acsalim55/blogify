<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function register(AuthRequest $req)
    {

        User::create($req->all());

        return response()->json([
            'message' => 'User successfully registered'
        ], 201);
    }

    public function login(AuthRequest $req)
    {
        $user = User::where($req->all())->first();

        if (!$user) {
            return response()->json([
                'message' => 'login failed: username or password incorrect'
            ], 404);
        }

        return response()->json([
            'message' => 'User successfully logged in',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 201);
    }


    public function logout(AuthRequest $req)
    {

        if (!auth()->check()) {
            return response()->json([
                'message' => 'User not logged in'
            ], 401);
        }

        $req->user()->tokens()->delete();

        return response()->json([
            'message' => 'User successfully logged out'
        ], 201);

    }

    public function me(Request $req)
    {
        return $req->user();
    }
}
