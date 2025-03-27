<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stripe annulation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container text-center mt-5">
        <h2> Paiement annulé</h2>
        <p>Veuillez réesayer.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Retour</a>
    </div>

    <a href="{{ route('login') }}" class="btn btn-primary">Retour</a>
</body>
</html>


