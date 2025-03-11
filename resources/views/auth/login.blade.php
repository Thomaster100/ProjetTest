<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Postlist - {{ __('app.home.connexion') }} </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- STRATEGIE DE TRADUCTION AVEC LES FICHIERS PHP --}}
    {{-- POUR LE JSON, - voir exemple dans le projet actuel du dossier lang-JSON) --}}

        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-5">

        @include('lang.switcher')

        <p class="h1 mb-5 text-center">Postlist - {{ __('app.home.connexion') }} - {{ __('app.home.year', ['current_year' => '2025']) }}</p>
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('app.home.email') }}</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('app.home.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('app.home.connexion') }}</button>
        </form>

        <div class="social-auth-btns mt-4">
            <a href="{{ route('social.redirect', 'google') }}" class="btn btn-danger">{{ __('app.home.login-google') }}</a>
            <a href="{{ route('social.redirect', 'facebook') }}" class="btn btn-primary disabled">{{ __('app.home.login-facebook') }}</a>
            <a href="{{ route('social.redirect', 'x') }}" class="btn btn-dark disabled">{{ __('app.home.login-twitter') }}</a>
            <a href="{{ route('social.redirect', 'linkedin-openid') }}" class="btn btn-info disabled">{{ __('app.home.login-linkedin') }}</a>
        </div>

        <div class="mt-4">
            <a href="{{ route('password.request') }}" class="btn btn-primary">{{ __('app.home.lost-password') }}</a>
        </div>

        <div class="map-routes-container mt-3">
            <a href="{{ route('map.index') }}" class="btn btn-success"> {{ __('app.home.view-map') }}</a>
            <a href="{{ route('map.multiple_markers') }}" class="btn btn-success">{{ __('app.home.view-map-pins') }}</a>
        </div>

    </div>
        <div class="position-fixed bottom-0 end-0 m-4">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg" title="Ajouter un compte utilisateur">
                {{ __('app.home.add-user') }}
            </a>
        </div>
    </div>

</body>
</html>
