# Mémento de la Syntaxe Blade pour Laravel

---

## **1. Affichage des Données**

### • Variables
```blade
{{ $variable }}
```
- Affiche la valeur d'une variable tout en échappant le contenu HTML.
- Pour afficher sans échapper :
```blade
{!! $variable !!}
```

### • Valeurs par défaut
```blade
{{ $variable ?? 'Valeur par défaut' }}
```

### • Structures complexes
```blade
{{ $array['key'] }}
{{ $object->property }}
```

---

## **2. Structures de Contrôle**

### • Conditions
```blade
@if(condition)
    Contenu
@elseif(condition)
    Contenu alternatif
@else
    Contenu par défaut
@endif
```

### • Boucles
#### • `for`
```blade
@for($i = 0; $i < 10; $i++)
    {{ $i }}
@endfor
```

#### • `foreach`
```blade
@foreach($items as $item)
    {{ $item }}
@endforeach
```

#### • `forelse`
Utilisé pour afficher un message si une collection est vide.
```blade
@forelse($items as $item)
    {{ $item }}
@empty
    Aucun élément à afficher.
@endforelse
```

#### • `while`
```blade
@while(condition)
    Contenu
@endwhile
```

### • Boucles imbriquées et gestion de la pile
```blade
@foreach($users as $user)
    @foreach($user->posts as $post)
        {{ $post->title }}
    @endforeach
@endforeach
```

---

## **3. Inclusion de Fichiers**

### • Inclure une vue
```blade
@include('nom_de_la_vue')
```

### • Inclure avec des données
```blade
@include('nom_de_la_vue', ['variable' => $valeur])
```

### • Inclusion conditionnelle
```blade
@includeWhen($condition, 'nom_de_la_vue', ['variable' => $valeur])
```

---

## **4. Sections et Mise en Page**

### • Mise en Page avec `@extends`
Dans une vue enfant :
```blade
@extends('layout.nom_du_layout')
```

### • Déclarer une Section
```blade
@section('nom_de_la_section')
    Contenu de la section
@endsection
```

### • Section Abrégée
```blade
@section('nom_de_la_section', 'Contenu rapide')
```

### • Afficher une Section
Dans le layout parent :
```blade
@yield('nom_de_la_section')
```

### • Contenu de Secours
```blade
@yield('nom_de_la_section', 'Contenu par défaut')
```

---

## **5. Composants**

### • Création d'un composant
Un composant Blade se situe dans le dossier `resources/views/components/`.

Fichier : `resources/views/components/alert.blade.php`
```blade
<div class="alert alert-{{ $type }}">
    {{ $message }}
</div>
```

### • Utilisation d'un composant
```blade
<x-alert type="success" message="Opération réussie." />
```

### • Slots (contenu personnalisé)
Composant avec slot :
```blade
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>
```
Utilisation :
```blade
<x-alert type="warning">
    Contenu du slot.
</x-alert>
```

---

## **6. Autres Fonctionnalités**

### • Stack (Pile de Contenu)
Empiler du contenu pour l’utiliser dans le layout parent.

Dans une vue enfant :
```blade
@push('scripts')
    <script src="script.js"></script>
@endpush
```

Dans le layout parent :
```blade
@stack('scripts')
```

### • Commentaires
Commentaires non visibles dans le rendu HTML :
```blade
{{-- Ceci est un commentaire Blade --}}
```

---

## **7. URL et Liens**

### • Générer une URL
```blade
<a href="{{ url('/chemin') }}">Lien</a>
```

### • Générer une Route
```blade
<a href="{{ route('nom_de_la_route') }}">Lien</a>
```

### • Asset (fichiers statiques)
```blade
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
```

---

