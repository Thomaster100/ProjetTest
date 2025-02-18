<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@section('content')
<div class="container">
    <h1 class="text-center">Tableau de Bord</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Posts</div>
                <div class="card-body">
                    <h5 class="card-title">Gérer les Posts</h5>
                    <p class="card-text">Créer, modifier ou supprimer des posts.</p>
                    <a href="{{ route('posts.index') }}" class="btn btn-light">Voir les posts</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Utilisateurs</div>
                <div class="card-body">
                    <h5 class="card-title">Gestion des Utilisateurs</h5>
                    <p class="card-text">Ajouter, modifier ou supprimer des utilisateurs.</p>
                    <a href="{{ route('users.create') }}" class="btn btn-light">Gérer les utilisateurs</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Paramètres</div>
                <div class="card-body">
                    <h5 class="card-title">Paramètres du Compte</h5>
                    <p class="card-text">Modifier les paramètres de votre profil.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light">Modifier</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
