<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

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
        <p class="h1 mb-5 text-center">Postlist - Connexion</p>
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
        <div class="position-fixed bottom-0 end-0 m-4">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg" title="Ajouter un compte utilisateur">
                + Ajouter un utilisateur
            </a>
        </div>
    </div>

    @if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
   @endif


</body>
</html>
