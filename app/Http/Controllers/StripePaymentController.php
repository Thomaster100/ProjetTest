<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    // Affiche la page avec le bouton de paiement
    public function showCheckoutForm() {
        return view('payment.checkout'); 
    }

    // Crée une session Stripe et redirige
    public function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'eBook Laravel',
                    ],
                    'unit_amount' => 1000, // 10€ = 1000 cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function paymentSuccess(Request $request) {
        return view('payment.success');
    }

    public function paymentCancel() {
        return view('payment.cancel');
    }
}
