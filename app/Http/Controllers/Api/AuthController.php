<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Str;
class AuthController extends Controller
{   
    public function SendEmailVerification(User $user=null,Request $request=null)
    {
        if($user === null){
            $request->validate([
                'email' => 'required|string|email',
            ]);
            $user = User::where('email', $request->email)->first();
        }
        $tokenVerification = Str::random(64);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }
        $user->emailVerifications()->delete();
        EmailVerification::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $tokenVerification),
            'expires_at' => now()->addMinutes(60),
        ]);
        $user->notify(
            new VerifyEmailNotification($tokenVerification)
        );
        return response()->json([
            'status' => 200,
            'message' => 'Email verification sent successfully',
        ], 200);
    }
    
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
            'status' => 200,
            'message' => 'user created successfully',
            'user' => $user
        ], 200);
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
        if($user->email_verified_at === null){
            $this->SendEmailVerification($user,null);
        }
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

    public function verifieEmailToken(Request $request)
    {
    $fields = $request->validate([
        'token' => ['required', 'string'],
    ]);
    $verification = EmailVerification::where(
        'token_hash',
        hash('sha256', $fields['token'])
    )->first();
    if (!$verification || $verification->expires_at->isPast()) {
        return response()->json([
            'status' => 404,
            'message' => 'Invalid or expired token',
        ], 404);
    }
    $user = $verification->user;
    if (!$user) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found',
        ], 404);
    }
    if ($user->email_verified_at !== null) {
        $verification->delete();

        return response()->json([
            'status' => 400,
            'message' => 'Email already verified',
        ], 400);
    }
    $user->markEmailAsVerified();
    $verification->delete();
    return response()->json([
        'status' => 200,
        'message' => 'Email verified successfully',
        'user' => $user,
        'token' => $user->createToken('authToken')->plainTextToken
    ], 200);
    }
}
