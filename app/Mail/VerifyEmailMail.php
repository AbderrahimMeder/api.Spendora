<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $token,
    ) {}

    public function build()
    {
        $verificationUrl =
            config('app.frontend_url')
            . '/verify-email?token='
            . urlencode($this->token);

        return $this
            ->subject('Verify your Finora email')
            ->view('emails.verify-email')
            ->with([
                'user' => $this->user,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}