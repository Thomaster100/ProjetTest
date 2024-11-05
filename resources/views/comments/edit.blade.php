<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editer commentaires</title>
</head>
<body>

    <h1>Modifier le Commentaire</h1>
    <form action="{{ route('comments.update', [$comment->post_id, $comment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="author" value="{{ $comment->author }}" required>
        <textarea name="content" required>{{ $comment->content }}</textarea>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>