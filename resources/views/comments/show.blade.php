<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>Commentaire de {{ $comment->author }}</h1>
    <p>{{ $comment->content }}</p>
    <a href="{{ route('comments.index', $comment->post_id) }}">Retour à la liste</a>
    
</body>
</html>