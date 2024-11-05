<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List comments</title>
</head>
<body>
    <h1>Commentaires pour {{ $post->title }}</h1>

<a href="{{ route('comments.create', $post->id) }}">Ajouter un commentaire</a>

    @foreach ($comments as $comment)
        <p><strong>{{ $comment->author }}</strong>: {{ $comment->content }}</p>
        <a href="{{ route('comments.show', [$post->id, $comment->id]) }}">Voir</a>
        <a href="{{ route('comments.edit', [$post->id, $comment->id]) }}">Modifier</a>
        <form action="{{ route('comments.destroy', [$post->id, $comment->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>
    @endforeach

</body>
</html>