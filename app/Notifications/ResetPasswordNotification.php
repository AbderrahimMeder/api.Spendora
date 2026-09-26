<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $token
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = 'http://localhost:3000/reset-password?token='
            . $this->token
            . '&email='
            . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Reset your Finora password')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You requested to reset your Finora password.')
            ->action('Reset Password', $url)
            ->line('This password reset link will expire soon.')
            ->line('If you did not request this, you can ignore this email.');
    }
}