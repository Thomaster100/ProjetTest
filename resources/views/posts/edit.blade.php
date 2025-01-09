<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mettre à jour un Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <p class="h2 text-center mb-4">Modifier le Post</p>
    
        <div class="card">
            <div class="card-body">
                <!-- Utilisation de ROUTE MODEL BINDING pour passer automatiquement le post à modifier -->
                <!-- Le formulaire met à jour le post existant en utilisant son ID -->
                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf
                    @method('PUT')
    
                    <!-- Champ pour le titre -->
                    <!-- Ce champ utilise directement le modèle de données grâce au binding -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du Post</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="form-control" 
                            value="{{ old('title', $post->title) }}" 
                            required>
                    </div>
    
                    <!-- Champ pour le contenu -->
                    <!-- Ce champ est prérempli avec le contenu du post existant -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea 
                            name="content" 
                            id="content" 
                            class="form-control" 
                            rows="5" 
                            required>{{ old('content', $post->content) }}</textarea>
                    </div>
    
                    <!-- Champ pour l'auteur -->
                    <!-- L'auteur est un champ texte modifiable directement -->
                    <div class="mb-3">
                        <label for="author" class="form-label">Auteur</label>
                        <input 
                            type="text" 
                            name="author" 
                            id="author" 
                            class="form-control" 
                            value="{{ old('author', $post->author) }}" 
                            required>
                    </div>
    
                    <!-- Champ pour la valeur -->
                    <!-- Ce champ est prérempli avec la valeur actuelle enregistrée en base de données -->
                    <div class="mb-3">
                        <label for="value" class="form-label">Valeur</label>
                        <input 
                            type="text" 
                            name="value" 
                            id="value" 
                            class="form-control" 
                            value="{{ old('value', $post->value) }}" 
                            required>
                    </div>
    
                    <!-- Boutons pour annuler ou enregistrer -->
                    <!-- Bouton Annuler : revient à la liste des posts -->
                    <!-- Bouton Enregistrer : valide et met à jour le post avec son ID -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('postList') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
