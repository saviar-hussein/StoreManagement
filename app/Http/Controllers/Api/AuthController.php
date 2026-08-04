<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
{
    
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'remember' => 'sometimes|boolean', 
    ]);

  
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $expiration = $request->boolean('remember') ? now()->addDays(30) : now()->addHours(24);

    $token = $user->createToken('api-token', ['*'], $expiration)->plainTextToken;

    
    return response()->json([
        'success' => true,
        'user' => $user,
        'token' => $token,
        'expires_in' => $request->boolean('remember') ? '30 days' : '24 hours'
    ], 200);
}

            // Delete the current token
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    }

