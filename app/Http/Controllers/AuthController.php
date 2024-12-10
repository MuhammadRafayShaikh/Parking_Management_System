<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $authValidation = validator($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($authValidation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'error' => $authValidation->errors()->all()
            ], 401);
        }

        $admin = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($admin) {
            return response()->json([
                'status' => true,
                'message' => 'Admin Created Successfully',
                'admin' => $admin->name
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin Not Create',
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $loginValidation = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($loginValidation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Validation Failed',
                    'errors' => $loginValidation->errors()
                ],
                400
            );
        }

        // Assuming login attempt
        $admin = ['email' => $request->email, 'password' => $request->password];

        if (Auth::attempt($admin)) {
            return response()->json([
                'status' => true,
                'message' => 'Login Successfully',
                'token' => Auth::user()->createToken('API TOKEN')->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Login Failed'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'User Logout Successfully',
                'user' => $user
            ],
            200
        );
    }
}
