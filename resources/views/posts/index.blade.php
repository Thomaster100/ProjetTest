<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Posts</title>
</head>
<body>

    {{-- Boucle templating blade  --}}
    @foreach($postList as $post)
        <div class="row">
            <div class="col-md-8 post-container">
                <p>{{ $post->title }}</p>
                <p>{{ $post->content }}</p>
                <p>{{ $post->author }}</p>
                <p>{{ $post->value }}</p>

                {{-- Mauvaise pratique --}}
                {{-- 
                <a href="/posts/{{ $post->id }}/edit">Modifier</a>
                <form method="POST" action="/posts/{{ $post->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
                --}}

                {{-- Bonne pratique --}}
                <a href="{{ route('posts.edit', $post) }}">Modifier</a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce post ?');">Supprimer</button>
                </form>

                {{-- Bonne pratique avec l'ID --}}
                {{-- <a href="{{ route('posts.edit.byId', $post->id) }}">Modifier</a>
                <form method="POST" action="{{ route('posts.destroy.byId', $post->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce post ?');">Supprimer</button>
                </form> --}}

            </div>
        </div>
    @endforeach

</body>
</html>
