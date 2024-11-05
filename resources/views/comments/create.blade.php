<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create comment</title>
</head>
<body>
    
    <h1>Ajouter un Commentaire pour {{ $post->title }}</h1>

    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <input type="text" name="author" placeholder="Votre nom" required>
        <textarea name="content" placeholder="Votre commentaire" required></textarea>
        <button type="submit">Ajouter le commentaire</button>
    </form>

</body>
</html>