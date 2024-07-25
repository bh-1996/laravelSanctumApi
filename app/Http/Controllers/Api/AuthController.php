<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $imageUpload;

    /**
     * Construct method
     */

     public function __construct(MediaHelper $imageUpload)
     {
        $this->imageUpload = $imageUpload;
     }
    public function register(Request $request)
    {
        try{

            // Define validation rules
            $validatorUser = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Check if validation fails
            if ($validatorUser->fails()) {
                return  $this->imageUpload->sendErrorResponse('Validation failed', ['error' =>  $validatorUser->errors()->all()], 401);
            }

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Return successful response
            return  $this->imageUpload->sendSuccessResponse($user, 'User registered successfully.');
        } catch (Exception $e) {
            return  $this->imageUpload->sendErrorResponse('Failed to create posts', ['error' => $e->getMessage()], 500);
        }
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
            return  $this->imageUpload->sendErrorResponse('Authentication failed', ['error' =>  $validatorUser->errors()->all()], 401);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $logdata = [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer'
            ];
            return  $this->imageUpload->sendSuccessResponse($logdata, 'User Logged in successfully !');
        }else {
            return $this->imageUpload->sendErrorResponse('Email and password does not matched.!', 401);
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
