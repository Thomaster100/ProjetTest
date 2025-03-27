
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stripe success</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container text-center mt-5">
        <h2> Paiement effectué </h2>
        <p>Un email de confirmation vous a été envoyé.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Retour</a>
    </div>
    
</body>
</html>

