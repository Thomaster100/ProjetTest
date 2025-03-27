<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PaymentSucceeded;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeWebhookController extends Controller {

    public function handle(Request $request) {
        
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = Session::retrieve($event->data->object->id, []);
            $email = $session->customer_details['email'] ?? null;

            event(new PaymentSucceeded($session));
        }

        return response()->json(['status' => 'received']);
    }
}
