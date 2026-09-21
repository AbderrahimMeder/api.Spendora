<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $token
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = config('app.frontend_url')
            . '/api/auth/verify-email?token='
            . urlencode($this->token);

        return (new MailMessage)
            ->subject('Verify your Finora email')
            ->greeting("Welcome to Finora, {$notifiable->name}!")
            ->line('Please verify your email address to activate your account.')
            ->action('Verify Email', $url)
            ->line('This verification link will expire in 60 minutes.')
            ->line('If you did not create this account, you can ignore this email.');
    }
}