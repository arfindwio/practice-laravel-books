<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     // Register user baru
     public function register(Request $request)
     {
         $request->validate([
             'name'     => 'required|string|max:255',
             'email'    => 'required|string|email|unique:users',
             'password' => 'required|string|min:6|confirmed',
         ]);
 
         $user = User::create([
             'name'     => $request->name,
             'email'    => $request->email,
             'password' => bcrypt($request->password),
         ]);
 
         $token = $user->createToken('auth_token')->plainTextToken;
 
         return response()->json([
             'message' => 'Register berhasil',
             'token'   => $token,
             'user'    => $user
         ], 201);
     }
 
     // Login
     public function login(Request $request)
     {
         $request->validate([
             'email'    => 'required|email',
             'password' => 'required'
         ]);
 
         $user = User::where('email', $request->email)->first();
 
         if (! $user || ! Hash::check($request->password, $user->password)) {
             return response()->json(['message' => 'Login gagal'], 401);
         }
 
         $token = $user->createToken('auth_token')->plainTextToken;
 
         return response()->json([
             'message' => 'Login berhasil',
             'token'   => $token,
             'user'    => $user
         ]);
     }
 
     // Logout
     public function logout(Request $request)
     {
         $request->user()->currentAccessToken()->delete();
 
         return response()->json(['message' => 'Logout berhasil']);
     }
 
     // Info user login
     public function authenticate(Request $request)
     {
         return response()->json($request->user());
     }
}
