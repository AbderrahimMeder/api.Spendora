<?php

namespace App\Services;

use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailVerificationService
{
    public function create(User $user): string
    {
        return DB::transaction(function () use ($user) {

            // Delete old verification tokens
            $user->emailVerifications()->delete();

            // Generate raw token
            $token = Str::random(64);

            // Store only hash in database
            EmailVerification::create([
                'user_id' => $user->id,
                'token_hash' => hash('sha256', $token),
                'expires_at' => now()->addMinutes(60),
            ]);

            return $token;
        });
    }
}