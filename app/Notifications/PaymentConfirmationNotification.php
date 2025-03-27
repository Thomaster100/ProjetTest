<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentConfirmationNotification extends Notification {
    
    protected string $stripeId;

    public function __construct(string $stripeId) {
        $this->stripeId = $stripeId;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Confirmation de paiement')
            ->greeting('Bonjour !')
            ->line('Votre paiement a été confirmé avec succès.')
            ->line('Merci pour votre confiance.')
            ->line('ID Stripe : ' . $this->stripeId)
            ->salutation('Cordialement, l\'équipe');
    }
}
