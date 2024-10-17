<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mettre à jour un Post</title>
</head>
<body>

    <h1>Mettre à jour un Post</h1>

    {{-- FORMULAIRE POUR LE ROUTE MODEL BINDING --}}
    {{-- Fonctionne en utilisant directement l'instance du modèle Post passée à la vue --}}
    <h2>Mise à jour du Post (Route Model Binding)</h2>
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf  {{-- Token CSRF pour sécuriser le formulaire --}}
        @method('PUT')  {{-- Méthode HTTP PUT pour indiquer qu'il s'agit d'une mise à jour --}}
        
        {{-- Champ pour le titre --}}
        <div>
            <label for="title">Titre :</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
            @error('title') <div>{{ $message }}</div> @enderror  {{-- Affichage des erreurs de validation --}}
        </div>

        {{-- Champ pour le contenu --}}
        <div>
            <label for="content">Contenu :</label>
            <textarea name="content">{{ old('content', $post->content) }}</textarea>
            @error('content') <div>{{ $message }}</div> @enderror  {{-- Affichage des erreurs de validation --}}
        </div>

        {{-- Champ pour l'auteur --}}
        <div>
            <label for="author">Auteur :</label>
            <input type="text" name="author" value="{{ old('author', $post->author) }}">
            @error('author') <div>{{ $message }}</div> @enderror
        </div>

        {{-- Champ pour la valeur --}}
        <div>
            <label for="value">Valeur :</label>
            <input type="number" name="value" min="0" max="5" value="{{ old('value', $post->value) }}">
            @error('value') <div>{{ $message }}</div> @enderror
        </div>

        <button type="submit">Mettre à jour (Route Model Binding)</button>
    </form>

    <hr>

    {{-- FORMULAIRE POUR LA MISE À JOUR AVEC L'ID --}}
    {{-- Ce formulaire fonctionne en utilisant l'ID du post directement --}}
    <h2>Mise à jour du Post (Par ID)</h2>
    <form action="{{ route('posts.update.byId', $post->id) }}" method="POST">
        @csrf  {{-- Token CSRF pour sécuriser le formulaire --}}
        @method('PUT')  {{-- Méthode HTTP PUT pour indiquer qu'il s'agit d'une mise à jour --}}
        
        {{-- Champ pour le titre --}}
        <div>
            <label for="title">Titre :</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
            @error('title') <div>{{ $message }}</div> @enderror  {{-- Affichage des erreurs de validation --}}
        </div>

        {{-- Champ pour le contenu --}}
        <div>
            <label for="content">Contenu :</label>
            <textarea name="content">{{ old('content', $post->content) }}</textarea>
            @error('content') <div>{{ $message }}</div> @enderror  {{-- Affichage des erreurs de validation --}}
        </div>

        {{-- Champ pour l'auteur --}}
        <div>
            <label for="author">Auteur :</label>
            <input type="text" name="author" value="{{ old('author', $post->author) }}">
            @error('author') <div>{{ $message }}</div> @enderror
        </div>

        {{-- Champ pour la valeur --}}
        <div>
            <label for="value">Valeur :</label>
            <input type="number" name="value" min="0" max="5" value="{{ old('value', $post->value) }}">
            @error('value') <div>{{ $message }}</div> @enderror
        </div>

        <button type="submit">Mettre à jour (Par ID)</button>
    </form>

</body>
</html>
