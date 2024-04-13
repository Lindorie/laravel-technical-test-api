<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdministrateurController extends Controller
{
    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
                'errors' => $validateUser->errors(),
            ], 401);
        }

        $user = Administrateur::where('email', $request['email'])->firstOrFail();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
                'errors' => $validateUser->errors(),
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:administrateurs,email',
                'password' => 'required',
            ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
                'errors' => $validateUser->errors(),
            ], 401);
        }

        $user = Administrateur::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 201,
            'user' => $user,
            'message' => 'Administrateur created successfully.',
        ]);

    }
}
