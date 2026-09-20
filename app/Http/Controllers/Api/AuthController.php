<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);
        if($user !==null){
            $user->account()->create();
        }
        return response()->json([
            'status' => 201,
            'message' => 'user created successfully',
            'user' => $user
        ], 201);
    }
    
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);
        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials'
            ], 401);
        }
        $token = $user->createToken(
            'authToken',
            ['*'],
            now()->addMonths(1)
        )->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'user logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function getCurrentUser(Request $request)
    {
        $req = $request->header('Authorization');
        return response()->json([
            'status' =>200,
            'user' => $request->user()
        ], 200);
    }


    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'status' => $status,
            'message' => __($status),
        ], 400);
    }
    public function resetPassword(Request $request)
        {
        $fields = $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $fields,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                $user->tokens()->delete();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 200,
                'message' => 'Password reset successfully.',
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => __($status),
        ], 400);
    }
}
