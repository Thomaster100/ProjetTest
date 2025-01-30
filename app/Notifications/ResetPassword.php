<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = URL::temporarySignedRoute(
            'password.reset', 
            Carbon::now()->addMinutes(config('auth.passwords.users.expire', 60)), 
            ['token' => $this->token, 'email' => $notifiable->email]
        );

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Vous avez demandé une réinitialisation de mot de passe.')
            ->action('Réinitialiser mon mot de passe', $resetUrl)
            ->line('Si vous n\'avez pas demandé de réinitialisation, ignorez cet email.');
    }
}
