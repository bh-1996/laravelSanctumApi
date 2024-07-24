<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Define validation rules
        $validatorUser = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if validation fails
        if ($validatorUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validatorUser->errors()->all(),
            ], 401);
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return successful response
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user
        ], 200);
    }

    /**
     * Login api
     */
    public function login(Request $request)
    {
        // Define validation rules
        $validatorUser = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);

        // Check if validation fails
        if ($validatorUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed !',
                'errors' => $validatorUser->errors()->all(),
            ], 404);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json([
                'message' => 'User Logged in successfully !',
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Email and password does not matched.!',
            ], 401);
        }
    }

    /**
     * Logout api
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logged out successfully!'
        ]);
    }
}
