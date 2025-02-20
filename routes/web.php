<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest; // A ajouter
use App\Http\Controllers\MapController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\EditorController;

// ROUTE DE BASE DE LARAVEL
Route::get('/', function () {
    return redirect()->route('login');
});

// ROUTE DASHBOARD ADMIN
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ROUTES INSCRIPTION UTILISATEUR
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// ROUTES LOGIN UTILISATEUR
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 

Route::post('/login', [AuthController::class, 'login']); 

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// AUTHENTIFICATION EXTERNE
Route::get('/auth/redirect/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialAuthController::class, 'callback'])->name('social.callback');


// ROUTE TEMPORAIRE D'AJOUT DE DONNEES "BRUT" - sans formulaire (Voir controlleur)
Route::get('/addPostList', [PostsController::class, 'create'])->name('addPostList');

// ROUTE TEMPORAIRE D'AJOUT D'UTILISATEURS, ROLES ET PERMISSIONS
Route::get('/addUsers', [UserController::class, 'run'])->name('addUsers');

// LISTER LES POSTES
Route::get('/postList', [PostsController::class, 'index'])->name('postList');

// CREATE
Route::get('/createPost', [PostsController::class, 'createNewPost'])->name('createPost');

// STORE 
Route::post('/storePost' , [PostsController::class, 'store'])->name('storePost'); 

// EDIT

// Afficher le formulaire d'édition

Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');

Route::get('/posts/{id}/edit', [PostsController::class, 'editById'])->name('posts.edit.byId');


// UPDATE - METHODES APPELES APRES LES FORMULAIRES DU EDIT

// ROUTE MODEL BINDING -  Fait correspondre l'ID fourni dans l'URL à une instance du modèle Post

Route::put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');

// Route avec le "getPostsByID"
Route::put('/posts/{id}', [PostsController::class, 'update'])->name('posts.update.byId');


// DELETE

// Par posts
Route::delete('/posts/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');

// Par ID
Route::delete('/posts/{id}', [PostsController::class, 'destroyById'])->name('posts.destroy.byId');

// -------- COMMENTS --------- // 

// route express pour remplir/charge la base de données de commentaires et les associer
Route::get('/addCommentsToPosts', [PostsController::class, 'addCommentsToPosts'])->name('addCommentsToPosts');

// Liste des commentaires d'un post
Route::get('/posts/{postId}/comments', [CommentController::class, 'index'])->name('comments.index');

// Création de commentaire
Route::get('/posts/{postId}/comments/create', [CommentController::class, 'create'])->name('comments.create');

// Nouveau commentaire (store database)
Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');

// Afficher un commentaire spécifique
Route::get('/posts/{postId}/comments/{id}', [CommentController::class, 'show'])->name('comments.show');

// Formulaire 
Route::get('/posts/{postId}/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');

// Mise à jour 
Route::put('/posts/{postId}/comments/{id}', [CommentController::class, 'update'])->name('comments.update');

// Suppression 
Route::delete('/posts/{postId}/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

// ------ Version groupée (avec prefix) ----- // 

Route::prefix('posts/{postId}/comments')->as('comments.')->group(function () {

    Route::get('/', [CommentController::class, 'index'])->name('index');  
    
    Route::get('/create', [CommentController::class, 'create'])->name('create'); 
    
    Route::post('/', [CommentController::class, 'store'])->name('store');  
    
    Route::get('/{id}', [CommentController::class, 'show'])->name('show');  
    
    Route::get('/{id}/edit', [CommentController::class, 'edit'])->name('edit'); 

    Route::put('/{id}', [CommentController::class, 'update'])->name('update'); 

    Route::delete('/{id}', [CommentController::class, 'destroy'])->name('destroy'); 
});

// Version avec ressources (crée toutes les routes CRUD automatiquement)
Route::resource('posts.comments', CommentController::class);

// ROUTE AVEC MIDDLEWARE POUR LES PERMISSIONS
Route::middleware(['permission:modify-todos'])->group(function () {
    Route::put('/todos/{todo}', [PostsController::class, 'update']);
    Route::delete('/todos/{todo}', [PostsController::class, 'destroy']);
});

// ROUTE DE RECHERCHE DE POSTS
Route::get('/search', [PostsController::class, 'search'])->name('posts.search');

// Mot de passe oublié
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}/{email}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ROUTES DE VERIFICATION EMAIL
Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verified/{id}', [EmailVerificationController::class, 'verified'])->name('email.verified');

// ROUTES DE FINALISATION UTILISATEUR
Route::get('/finish-register/{id}', [UserController::class, 'finishRegistrationView'])->name('finish-register');
Route::post('/complete-user/{id}', [UserController::class, 'completeUser'])->name('user.complete');

// MAPBOX

// AFFICHAGE
Route::get('/map', [MapController::class, 'index'])->name('map.index');

// RECHERCHE
Route::get('/map/search', [MapController::class, 'search'])->name('map.search');

// HELPER 
Route::get('/get-coordinates', [MapController::class, 'getCoordinates'])->name('map.coordinates');

// LES MARKERS
Route::get('/map/multiple-markers', [MapController::class, 'showMultipleMarkers'])->name('map.multiple_markers');

Route::get('/map/get-markers', [MapController::class, 'getMarkers'])->name('map.get_markers');

// Route postman de test
Route::get('/postman-test', [MapController::class, 'printPostmanDatas'])->name('/postman-test');

// Routes accessibles uniquement aux administrateurs
Route::middleware(['auth', PermissionMiddleware::class . ':manage-users'])->group(function () {
    Route::get('/admin', 'AdminController@index')->name('admin.dashboard');
});
Route::middleware(['auth', PermissionMiddleware::class . ':approve-todos'])->group(function () {
    Route::get('/moderate', 'ModeratorController@index')->name('moderator.dashboard');
});
Route::middleware(['auth', PermissionMiddleware::class . ':create-todos'])->group(function () {
    Route::get('/editor', 'EditorController@index')->name('editor.dashboard');
});

// Routes pour les modérateurs
Route::middleware(['auth', 'moderator'])->group(function () {
    Route::get('/moderator', [ModeratorController::class, 'index'])->name('moderator.index');
    Route::delete('/moderator/comment/{id}', [ModeratorController::class, 'deleteComment'])->name('moderator.delete_comment');
    Route::post('/moderator/approve/{id}', [ModeratorController::class, 'approvePost'])->name('moderator.approve_post');
});

// Routes pour les éditeurs
Route::middleware(['auth', 'editor'])->group(function () {
    Route::get('/editor', [EditorController::class, 'index'])->name('editor.index');
    Route::get('/editor/create', [EditorController::class, 'createPost'])->name('editor.create_post');
    Route::post('/editor/store', [EditorController::class, 'storePost'])->name('editor.store_post');
    Route::get('/editor/edit/{post}', [EditorController::class, 'editPost'])->name('editor.edit_post');
    Route::put('/editor/update/{post}', [EditorController::class, 'updatePost'])->name('editor.update_post');
});

// Routes pour la gestion d'image (édition)
Route::post('/edit-image/{id}', [PostController::class, 'editImage'])->name('edit.image');
