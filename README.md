Repos pour le labo Laravel de L'ISL.
Pour récupérer les dépendances au tout début, faire un ```composer install``` pour obtenir toutes les dépendances (stocké dans le dossier vendor)


!!! IMPORTANT !!!

Laravel arrive avec un système de clé unique, stocké dans le fiichier .env
(la variable APP_KEY) 

Si vous n'avez pas de clés, re-générez en une avec la commande ```php artisan key:generate``` qui permet d'alimenter la variable avec un nouvel ID 

- La clé est utilisée par Laravel pour le chiffrement des données (par exemple pour chiffrer les sessions et autres données sensibles...)

// GIT

- Pour récupérer un dossier (repo pour Repository) : ``` git clone ``` (https://gihub.com/(repo en .git))
- (n'oubliez de faire un ```composer install```) pour les dépendances

// En cas de changement (Ajout/ modifications)
- Pour récupérer du contenu : ``` git pull ``` (c'est une combinaison de 2 commandes : git fetch ET un git merge)

// Si je veux créer une branche
commande : ```git checkout -b``` (pour branche) (NomDeLaBrancheACreer)

Exemples : 

// Creer une branche
- ```git checkout -b laboTestNicolas``` (en local) / ```git push -u origin laboTestNicolas``` (sur GitHub)
- ```git status``` => lister les fichiers modifiés / ajouté / supprimés
- ```git add .``` (le point c'est pour tout les fichiers, sinon spécifier le chemin de votre / vos fichiers) => Fichier(s) en phase de STAGING ! 
- ```git commit``` (renvoi vers un shell interactif) / ```git commit -m``` "Mon message" (plus souvent utilisé)
=> Associer les fichiers en staging avec le message 
- ```git push``` (enregistrer les modifications - De base c'est en local)
- ```git push --upstream (ou -u) origin (nomDeLaBranche)``` => Pousser sur Github

// Pour revenir a une autre branche
```git checkout``` (nomDeLaBranche)

// Pour supprimer une branche locale
```git branch -d``` (nomDeLaBranche)

// Pour supprimer une branche distante 
```git push origin --delete nomDeLaBranche```

// Lister les branches locales
```git branch```

// Lister les branches distantes
```git ls-remote```

// Relations 

---- Pour créer une relation de type one-to-many --- 

-- COTE MIGRATION --- 

- Créer le fichier de migration avec : 

- une réference à l'entité demandé avec son id 

exemple avec les commentaires : 

 // Référence vers le post associé
 `$table->unsignedBigInteger('post_id');` 

 // Clé étrangère pour assurer la relation avec les Posts
            `$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');`

-- COTE MODEL --- 

Du coté des posts

 **Est ce que mon post A UN OU PLUSIEURS (hasMany()) commentaires ?**

exemple : 
```
    // Obtenir tout les commentaires d'un post

    public function comments() {
     return $this->hasMany(Comment::class, 'post_id');
    }
```
 **A qui APPARTIENT (belongsTo) cette entité (pour quel entité)**

    // Comment Model (association Posts)

    public function post() {
        // Appartenance a l'entité posts
        return $this->belongsTo(Posts::class, 'post_id');
    }
    
----------------------------------------------------------------

-- Ajout de librairies (liste des commandes) / configuration -- 

-- BOOTSTRAP (via NPM) --

- `npm init`
- `npm i (install) bootstrap`
- `Pour ajouter une version spécifique : npm i bootstrap@(numéro de version)`
- `Ex: npm i bootstrap 4.4.3`

-> Ensuite ajouter les imports bootstrap pour le JS (si pas automatiquement ajouté par la commande npm) => `import './bootstrap'` 
-> idem pour le CSS - a ajouter (`@import "bootstrap/dist/css/bootstrap.min.css";` )

----------------------------------------------------------------

Ajout de la debugbar

`composer require barryvdh/laravel-debugbar --dev`