<?php

namespace App\Providers;

use App\Events\PaymentSucceeded;
use App\Listeners\SendPaymentConfirmationEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentSucceeded::class => [
            SendPaymentConfirmationEmail::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}