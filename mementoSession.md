# Mémento sur les Sessions Laravel

---

## **1. Configuration des Sessions**

### • Fichier de configuration
Les sessions sont configurées dans le fichier `config/session.php`.

### • Drivers disponibles
Laravel supporte plusieurs drivers de session :
- `file` : Stockage des sessions dans des fichiers (par défaut).
- `cookie` : Stockage directement dans les cookies du navigateur.
- `database` : Stockage dans une table de la base de données.
- `redis` : Utilisation de Redis pour le stockage.
- `array` : Sessions volatiles (utilisées pour les tests).

### • Exemple de modification du driver
Dans `.env` :
```env
SESSION_DRIVER=database
```
Appliquez une migration pour créer la table des sessions si vous utilisez `database` :
```bash
php artisan session:table
php artisan migrate
```

---

## **2. Démarrer une Session**
Laravel démarre automatiquement les sessions pour chaque requête si le middleware `web` est appliqué.

Exemple d'application du middleware :
```php
Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
```

---

## **3. Manipulation des Données de Session**

### • Ajouter des données
```php
session(['key' => 'value']);
```
Ou via l’assistant global :
```php
Session::put('key', 'value');
```

### • Récupérer des données
```php
$value = session('key');
```
Avec une valeur par défaut :
```php
$value = session('key', 'default_value');
```
Ou avec la classe `Session` :
```php
$value = Session::get('key', 'default_value');
```

### • Ajouter temporairement des données (flash)
Les données flash sont disponibles uniquement pour la requête suivante.
```php
session()->flash('status', 'Succès!');
```
Récupérer une donnée flash :
```php
$status = session('status');
```

### • Supprimer une donnée
Supprimer une clé spécifique :
```php
session()->forget('key');
```
Supprimer toutes les données de la session :
```php
session()->flush();
```

---

## **4. Utilisation Avancée**

### • Vérifier l’existence d’une clé
```php
if (session()->has('key')) { // La clé existe
    
}
```
Pour vérifier une clé même si elle est vide :
```php
if (session()->exists('key')) { // La clé existe, même si sa valeur est null
    
}
```

### • Récupérer et Supprimer une Clé
Utilisez `pull` pour récupérer la valeur et la supprimer immédiatement :
```php
$value = session()->pull('key');
```

### • Conserver les Données Flash
Pour rendre une donnée flash disponible pour une requête supplémentaire :
```php
session()->reflash();
```
Pour conserver une clé flash spécifique :
```php
session()->keep(['key']);
```

---

## **5. Middleware Lié aux Sessions**

### • Middleware `StartSession`
Ce middleware gère automatiquement le démarrage des sessions et leur sauvegarde.

### • Exemple : Ajouter des données dans un middleware
```php
public function handle($request, Closure $next)
{
    session(['key' => 'value']);

    return $next($request);
}
```

---

## **6. Bonnes Pratiques**

1. **Limitez la taille des données stockées :** Les sessions ne doivent pas contenir de gros volumes de données.
2. **Ne stockez pas de données sensibles :** Les sessions peuvent être compromises si elles ne sont pas correctement configurées.
3. **Préférez un driver adapté :** Utilisez `redis` ou `database` pour une meilleure performance dans des applications à grande échelle.

---

