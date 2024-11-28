<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Posts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="container">
        <h1>Liste des Posts</h1>
    
        @foreach($postList as $post)
            <div class="row mb-3">
                <div class="col-md-8 m-1 p-1 post-container card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->content }}</p>
                        <p class="card-text">Auteur : {{ $post->author }}</p>
                        <p class="card-text">Valeur : {{ $post->value }}</p>
    
                        <div class="d-flex justify-content-end">
                            <!-- Bouton Modifier -->
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary me-2"
                                @if(auth()->user()->role->name !== 'admin' || !auth()->user()->hasPermission('modify-todos'))
                                    style="pointer-events: none; opacity: 0.5;"
                                @endif
                            >Modifier</a>
    
                            <!-- Bouton Supprimer -->
                            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-primary"
                                    type="submit"
                                    @if(auth()->user()->role->name !== 'admin' || !auth()->user()->hasPermission('modify-todos'))
                                        disabled
                                    @endif
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce post ?');"
                                >Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
  

    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Déconnexion</button>
    </form>

</body>
</html>
