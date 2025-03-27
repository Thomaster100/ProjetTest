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


----------------------------------------------------------------

Notifications

generer une notification de reset password 
`php artisan make:notification ResetPassword`

Generer la notification (contenu email)
`php artisan vendor:publish --tag=laravel-notifications`


----------------------------------------------------------------

Utils 

// Regenerer les fichiers et vider le cache
`composer dump-autoload `
`php artisan cache:clear `
`php artisan config:clear`

----------------------------------------------------------------

Doc Laravel 11 - tips

Pour rechercher rapidement une classe : https://laravel.com/api/11.x/(votre biliotheque).html

Exemples : 

- https://laravel.com/api/11.x/Illuminate\Support\Facades\Password.html
- https://laravel.com/api/11.x/Illuminate\Auth\Events\PasswordReset.html


----------------------------------------------------------------

Installer / Utiliser Mapbox

Doc de l'API : https://docs.mapbox.com/mapbox-gl-js/guides/

En premier lieu ajouter son token dans le fichier d'environnement : 

`MAPBOX_TOKEN={votre token}`

Installer la bibliothèque : `composer require koossaayy/laravel-mapbox`
Publier le fichier de configuration : `php artisan vendor:publish --tag=mapbox-config`
(sera placé dans le dossier config/mapbox)

Effacer le cache : `php artisan config:clear`

Pour le fichier helper (MapboxHelper) ne pas oublier de la charger dans le fichier composer (composer.json)

Pour creer le controller : `php artisan make:controller MapController`


----------------------------------------------------------------

POSTMAN

Documentation de Postman : https://learning.postman.com/docs/introduction/overview/s

----------------------------------------------------------------

GESTION DES FICHIERS

Classe : Storage (`use Illuminate\Support\Facades\Storage`)

Certaines méthodes d'exemple : 

-> `Storage::disk('')` // Exemple : Storage::disk('')
-> `MakeDirectory()`
-> `removeDirectory()`
-> `files()` Pour lister les fichiers

Pour linker le dossier laravel 'public' depuis l'extérieur (et eviter les erreur type 403)

`php artisan storage:link`

----------------------------------------------------------------

Traductions (Localization)

Doc : `https://laravel.com/docs/11.x/localization`

Creer le répertoire pour les langues : `php artisan lang:publish`

Interpréter les traductions sous cette syntaxe : `echo __('home.welcome');
`
Retrouver la locale : `$locale = App::currentLocale();`

Tester la locale : `App::isLocale('fr');`

Définir une locale : ` App::setLocale('en');`, ` App::setLocale($locale);`

Interpreter des variables

Paramètres pour les variables : `'welcome' => 'Welcome, :name'` (notez bien les deux points avant la variable name)
Interpréter des variables : `echo __('messages.welcome', ['name' => 'dayle']);`

(optionnel) Une classe `Pluralizer` existe aussi pour mettre les phrases au pluriel

Exemple pour le JSON : `'notification' => 'Vous avez une notification|Vous avez plusieurs notifications',`

` Pluralizer::useLanguage('french');`

Langages supportés : 

- french
- norwegian-bokmal
- portuguese
- spanish
- turkish

ETAPES : 

- `php artisan lang:publish (création du dossier)`
- Créer les fichiers de langues (fr, en…)
- Créer votre middleware pour gérer le multi
- Déclarer votre middleware dans `bootstrap/app.php`
  
  ```
    ->withMiddleware(function (Middleware $middleware) {
	// PREPREND pour pré-charger le middleware
        $middleware->prepend(Localization::class);
    })
  ```

Pour vider le tout : 

`php artisan cache:clear`
`php artisan config:clear`
`php artisan view:clear`
`php artisan route:clear`
`php artisan optimize:clear`


----------------------------------------------------------------

STRIPE ET ASYNCHRONE

# Intégration de Stripe avec Laravel (Paiement + Email de confirmation)

## Objectif

- Créer un bouton de paiement avec **Stripe Checkout**.
- Rediriger l'utilisateur vers un terminal de paiement Stripe.
- Détecter si le paiement a été **réussi** via un **webhook Stripe**.
- Déclencher un **événement Laravel** (`PaymentSucceeded`) et un **listener** (`SendPaymentConfirmationEmail`) pour **envoyer un email**.
- Expliquer le concept **d’asynchrone / communication en temps réel**.

## Étape 1 : Installer Stripe

```bash
composer require stripe/stripe-php
```

## Étape 2 : Configuration `.env`

```env
STRIPE_KEY=pk_test_XXXXXXXXXXXXXXXXXXXXXXXX
STRIPE_SECRET=sk_test_XXXXXXXXXXXXXXXXXXXXXXXX
```

Dans `config/services.php` :

```php
'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

##  Étape 3 : StripePaymentController

```bash
php artisan make:controller StripePaymentController
```

### Méthodes du contrôleur :

```php
public function showCheckoutForm() {
    return view('payment.checkout');
}

public function checkout() {
    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => 'eBook Laravel'],
                'unit_amount' => 1000,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('payment.cancel'),
    ]);

    return redirect($session->url);
}

public function success() {
    return view('payment.success');
}

public function cancel() {
    return view('payment.cancel');
}
```

## Étape 4 : Routes (`routes/web.php`)

```php
use App\Http\Controllers\StripePaymentController;

Route::get('/checkout', [StripePaymentController::class, 'showCheckoutForm'])->name('stripe.checkout');
Route::post('/checkout', [StripePaymentController::class, 'checkout'])->name('payment.process');
Route::get('/success', [StripePaymentController::class, 'success'])->name('payment.success');
Route::get('/cancel', [StripePaymentController::class, 'cancel'])->name('payment.cancel');
```

## Étape 5 : StripeWebhookController

```bash
php artisan make:controller StripeWebhookController
```

```php
public function handle(Request $request) {
    $payload = $request->getContent();
    $event = json_decode($payload);

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;
        event(new PaymentSucceeded($session->customer_email, $session->id));
    }

    return response()->json(['status' => 'received']);
}
```

Dans les routes :

```php
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
```

## Étape 6 : Événement PaymentSucceeded

```bash
php artisan make:event PaymentSucceeded
```

```php
public function __construct(public string $email, public string $stripeId) {}
```

## Étape 7 : Listener SendPaymentConfirmationEmail

```bash
php artisan make:listener SendPaymentConfirmationEmail
```

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentConfirmationNotification;

public function handle(PaymentSucceeded $event) {
    Notification::route('mail', $event->email)
        ->notify(new PaymentConfirmationNotification($event->stripeId));
}
```

## Étape 8 : Notification PaymentConfirmationNotification

```bash
php artisan make:notification PaymentConfirmationNotification
```

```php
public function __construct(public string $stripeId) {}

public function toMail($notifiable) {
    return (new MailMessage)
        ->subject('Confirmation de paiement')
        ->line("Merci pour votre achat !")
        ->line("Identifiant de transaction : {$this->stripeId}")
        ->line("Nous vous remercions pour votre confiance.");
}
```

## Étape 9 : EventServiceProvider

Fichier `app/Providers/EventServiceProvider.php` :

```php
protected $listen = [
    App\Events\PaymentSucceeded::class => [
        App\Listeners\SendPaymentConfirmationEmail::class,
    ],
];
```

## Étape 10 : Configuration Mail

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@laravelapp.test
MAIL_FROM_NAME="Laravel App"
```

## Étape 11 : Tester le flux

- Lancer `php artisan serve`
- Accéder à `/checkout`
- Payer avec une carte test `4242 4242 4242 4242`
- Stripe redirige vers `/success`
- Stripe appelle `/stripe/webhook`
- Événement déclenché
- Email envoyé

## Étape 12 : Nettoyer les caches

```bash
php artisan optimize:clear
php artisan event:cache
```

## Asynchrone & Webhook

- Stripe n’attend pas Laravel : il envoie une requête à `/stripe/webhook`
- Laravel écoute passivement puis agit
- Le traitement se fait en arrière-plan (event + listener)

## Schéma

```
[User] 
   | Cliquez paiement
   v
[Laravel] → Stripe Checkout
   ^                  |
   |                  v
[Stripe] ← Webhook ← Paiement OK
   |
   v
Événement → Listener → Notification → Mail
```


# Explications détaillées de l’intégration Stripe (Laravel 11)

Ce fichier explique pas à pas chaque étape de l'intégration Stripe dans un projet Laravel 11 avec envoi d'e-mail asynchrone après le paiement.

## 1. Installation des dépendances Stripe

```bash
composer require stripe/stripe-php
```

## 2. Configuration de l'API Stripe

Ajoute tes clés dans `.env` :

```env
STRIPE_KEY=pk_test_XXXX
STRIPE_SECRET=sk_test_XXXX
```

Et dans `config/services.php` :

```php
'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

## 3. Contrôleur principal : `StripePaymentController`

Ce contrôleur gère :
- La vue avec le bouton de paiement.
- La redirection vers Stripe.
- La gestion des retours (succès, annulation).

## 4. Création du checkout

```php
$session = Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'eBook Laravel',
            ],
            'unit_amount' => 1000,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => route('payment.cancel'),
]);
```

## 5. Routes (dans `routes/web.php`)

```php
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\StripeWebhookController;

Route::get('/checkout', [StripePaymentController::class, 'showCheckoutForm'])->name('checkout.form');
Route::post('/checkout', [StripePaymentController::class, 'checkout'])->name('stripe.checkout');
Route::get('/success', [StripePaymentController::class, 'success'])->name('payment.success');
Route::get('/cancel', [StripePaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');
```

## 6. Webhook : `StripeWebhookController`

Ce contrôleur reçoit l’événement Stripe et déclenche un événement Laravel :

```php
if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;
    event(new PaymentSucceeded($session->customer_email, $session->id));
}
```

## 7. Événement : `PaymentSucceeded`

Déclenché automatiquement depuis le webhook.

```php
class PaymentSucceeded implements ShouldBroadcast {
    public function __construct(public string $email, public string $stripeId) {}
}
```

## 8. Listener : `SendPaymentConfirmationEmail`

Ce listener écoute l’événement `PaymentSucceeded` et envoie un mail :

```php
public function handle(PaymentSucceeded $event) {
    Notification::route('mail', $event->email)
        ->notify(new PaymentConfirmationNotification($event->stripeId));
}
```

## 9. Notification : `PaymentConfirmationNotification`

```php
public function toMail($notifiable) {
    return (new MailMessage)
        ->subject('Confirmation de paiement')
        ->line('Merci pour votre achat !')
        ->line("ID de session Stripe : {$this->stripeId}");
}
```

## 10. Liaison des événements / listeners

Dans Laravel 11, on utilise `bootstrap/app.php` :

```php
use App\Events\PaymentSucceeded;
use App\Listeners\SendPaymentConfirmationEmail;

Event::listen(PaymentSucceeded::class, SendPaymentConfirmationEmail::class);
```

## 11. Tester le flux

- Lance le serveur Laravel : `php artisan serve`
- Lance le tunnel Stripe : `stripe listen --forward-to localhost:8000/stripe/webhook`
- Ouvre `/checkout` dans le navigateur
- Effectue le paiement
- Vérifie la réception de l’e-mail dans Mailtrap

## 12. Commandes utiles

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
composer dump-autoload
```

---
