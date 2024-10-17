<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

// ROUTE DE BASE DE LARAVEL
Route::get('/', function () {
    return view('welcome');
});

// ROUTE TEMPORAIRE D'AJOUT DE DONNEES "BRUT" - sans formulaire (Voir controlleur)
Route::get('/addPostList', [PostsController::class, 'create'])->name('addPostList');

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


