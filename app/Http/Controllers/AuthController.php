<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    
    public function login(LoginRequest $req) {
        $userData = $req->validated();
        if (!Auth::attempt($userData)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api_token')->plainTextToken;
        
        return response()->json([
            'user'  => new UserResource($user),
            'token' => $token,
        ]);

    }


    public function register(RegisterRequest $req) {
        $validInputs = $req->validated();
        $user = User::create([
            'name' => $validInputs['name'],
            'email' => $validInputs['email'],
            'password' => bcrypt($validInputs['password']),
        ]);
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }



    public function logout(Request $req) {
        $user = $req->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            "message" => 'Token  deleted!',
        ]);
    }


    
}
