<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\KosarTermek;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vezeteknev' => 'required|string|max:255',
            'keresztnev' => 'required|string|max:255',
            'jelszo' => 'required|string|min:6',
            'email' => 'required|string|email|max:255|unique:users',
            'telefonszam' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::create([
            'vezeteknev' => $request->vezeteknev,
            'keresztnev' => $request->keresztnev,
            'jelszo' => Hash::make($request->jelszo), // Hash the password
            'email' => $request->email,
            'telefonszam' => $request->telefonszam,
        ]);

        return response()->json([
            'message' => 'Sikeres regisztráció!',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'jelszo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();
        
        // Check if user exists and password matches
        if (!$user || !Hash::check($request->jelszo, $user->jelszo)) {
            return response()->json([
                'message' => 'Hibás email vagy jelszó!'
            ], 401);
        }
        
        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Sikeres bejelentkezés!',
            'token' => $token,
            'user' => $user
        ]);
    }
}