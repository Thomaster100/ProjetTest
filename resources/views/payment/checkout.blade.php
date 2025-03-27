<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stripe Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container text-center mt-5">
        <h2>Procéder au paiement</h2>
        <p>Vous allez être redirigé vers un terminal Stripe sécurisé.</p>
    
        <form action="{{ route('stripe.checkout') }}" method="POST">
            @csrf
            <button class="btn btn-primary">Payer 10€ pour le PostList Premium</button>
        </form>
    </div>
    
    <a href="{{ route('login') }}" class="btn btn-primary">Retour</a>
</body>
</html>
