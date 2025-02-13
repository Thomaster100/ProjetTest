<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Créer un Post</title>
</head>
<body>
    
    {{-- Mauvaise pratique --}}
    {{-- Mauvaise implémentation : pas de protection CSRF et champs incomplets --}}
    
    {{-- <form action="{{route('createPost')}}" method="POST">

        <br>
           <label for="title">TITLE : </label>
           <input name="title" type="text" class="title-field">
        </br>

        <br>
        <label for="title">CONTENT : </label>
            <input name="content" type="text" class="content-field">
        </br>

     <br>
        <label for="author">AUTHOR : </label>
        <input name="author" type="text" class="author-field">
    </br>

    <br>
        <label for="value">VALUE : </label>
        <input name="value" type="number" class="value-field">
    </br>

     <input type="submit" value="Creer">
    </form> --}}


    {{-- Bonne pratique --}}
    <form action="{{ route('storePost') }}" method="POST">
        
        @csrf {{-- CSRF ?? --}}
        
        <!--
        Le token @csrf (Cross-Site Request Forgery) est utilisé pour protéger l'application
        contre les attaques CSRF. Ces attaques se produisent lorsqu'un utilisateur authentifié
        sur un site est amené à effectuer une requête non désirée depuis une autre source,
        exploitant sa session en cours.

        Exemple d'une attaque CSRF :
        Supposons qu'un utilisateur est connecté à son compte sur cette application (exemple : un compte bancaire).

        Si un attaquant le pousse à visiter un site malveillant contenant un formulaire caché
        qui fait une requête POST vers ton application (par exemple, pour transférer de l'argent),
        l'application exécutera cette requête en utilisant la session authentifiée de l'utilisateur.
        L'utilisateur, sans le savoir, aura effectué une transaction.

        Le token CSRF empêche ce genre d'attaque. Laravel génère automatiquement un token CSRF
        unique pour chaque session utilisateur et l'inclut dans les formulaires. Lorsqu'une requête
        POST, PUT ou DELETE est effectuée, Laravel vérifie que ce token correspond à celui stocké
        dans la session. Si le token est absent ou ne correspond pas, la requête est rejetée.

        En résumé : @csrf assure que seules les requêtes valides provenant de l'application elle-même
        peuvent être exécutées, protégeant ainsi les utilisateurs contre des requêtes non intentionnelles.

        Vulnérabilité expliqué par l'OWASP : https://owasp.org/www-community/attacks/csrf
        -->

        <div>
            <input type="text" name="title" placeholder="Titre" value="{{ old('title') }}">
            {{-- old(...) Permet de récupérer la dernière valeur saisie si la validation a échoué --}}
            @error('title') <div>{{ $message }}</div> @enderror
        </div>
        
        <div>
            <textarea name="content" placeholder="Contenu">{{ old('content') }}</textarea>
            @error('content') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <input type="text" name="author" placeholder="Auteur" value="{{ old('author') }}">
            @error('author') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <input type="number" name="value" placeholder="Valeur" value="{{ old('value') }}" min="0" max="5">
            @error('value') <div>{{ $message }}</div> @enderror
        </div>

        <input type="submit" value="Créer">
    </form>

</body>
</html>
