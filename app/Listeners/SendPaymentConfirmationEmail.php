<?php

namespace App\Listeners;

use App\Events\PaymentSucceeded;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentConfirmationNotification;

class SendPaymentConfirmationEmail {
    
    public function handle(PaymentSucceeded $event) {

        Notification::route('mail', $event->email)->notify(new PaymentConfirmationNotification($event->stripeId));
    }
}
