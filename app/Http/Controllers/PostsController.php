<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;


class PostsController extends Controller {
    
    // LISTER TOUT LES POSTS 
    public function index() {

        // Récuperer tout les posts
        $postList = Posts::all();
        return view('posts.index', compact('postList'));    
    }

    // CREER DES POSTS (SANS FORMULAIRE, JUSTE POUR REMPLIR LA BASE DE DONNEE)
    public function create() {

        // On modifiera plus tard mais on aura le formulaire de création ici (la vue...)
        Posts::create([
          'title' => 'Les Ombres du Crepuscule',
          'content' => 'Dans une ville où le soleil ne se couche jamais, un enquêteur découvre que certaines ombres renferment un secret vieux de plusieurs siècles.', 
          'author' => 'Camille Bertrand', 
          'value' => '4.5'   
        ]);

        Posts::create([
        'title' => 'Horloge des Rêves',
        'content' => 'Un horloger découvre une montre ancienne qui permet de contrôler le monde des rêves, mais chaque manipulation a un prix.', 
        'author' => 'Nathan Lemoine', 
        'value' => '3.7'   
        ]);

        Posts::create([
        'title' => 'Au-delà des Étoiles Brisées',
        'content' => 'Après la destruction de leur planète, un groupe de survivants doit naviguer dans l\'univers et affronter des créatures mystérieuses pour trouver un nouveau foyer.', 
        'author' => 'Elisa Durand', 
        'value' => '4.2'   
        ]);

        Posts::create([
        'title' => 'Les Murmures de la Forêt',
        'content' => 'Dans un petit village, les habitants entendent des voix mystérieuses venant de la forêt environnante, et un jeune garçon décide de découvrir leur origine.', 
        'author' => 'Hugo Marchal', 
        'value' => '3.9'   
        ]);

        
    }

    // STORE -> mauvaise pratique

//     public function store(PostsRequest $request) {

//         $currentPost = new Posts();

//         $currentPost->title = $request['title'];
//         $currentPost->content = $request['content'];
//         $currentPost->author = $request['author'];
//         $currentPost->value = $request['value'];

//         $currentPost->save();
//         return redirect()->route('postList');

//  }

public function createNewPost() {
    return view('posts.create');
}

// Bonne pratique avec validation
// 1ere méthode - classique : Instanciation manuelle et assignation des attributs

// public function store(PostsRequest $request) {

//     // Les données sont validées grâce à PostsRequest - voir le commentaire dans le PostsRequests
//     $validatedData = $request->validated();

//     $post = new Posts();
//     $post->title = $validatedData['title'];
//     $post->content = $validatedData['content'];
//     $post->author = $validatedData['author'];
//     $post->value = $validatedData['value'];
//     $post->save();

//     return redirect()->route('postList')->with('success', 'Post créé avec succès!');
// }

    // 2eme manière en utilisant l'assignation en masse, d'ou le fait d'avoir complété les attributs dans le model de Posts...

    public function store(PostsRequest $request)
    {
        $validatedData = $request->validated();
    
        // Création du post avec la méthode create() et Mass Assignment
        Posts::create($validatedData);
    
        // Redirection après création avec un message de succès
        return redirect()->route('postList')->with('success', 'Post créé avec succès!');
    }



    // -------------- EDITION -------------------------- // 

    public function edit(Posts $post) {
        return view('posts.edit', compact('post'));
    }

    public function editById($id) {
        $post = Posts::findOrFail($id);
        return view('posts.edit', compact('post'));
   }

 
    // UPDATE - 1ere méthode avec le post récupéré
    
    // public function update(PostsRequest $request, Posts $post)  {
        
    //     $validatedData = $request->validated();

    //     $post->title = $validatedData['title'];
    //     $post->content = $validatedData['content'];
    //     $post->author = $validatedData['author'];
    //     $post->value = $validatedData['value'];
    //     $post->save();

    // // $post->update($validatedData);

    //     return redirect()->route('postList')->with('success', 'Post mis à jour avec succès!');
    
    // }

    public function update(PostsRequest $request, $id) {

        $validatedData = $request->validated();
        $post = Posts::findOrFail($id);

        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->author = $validatedData['author'];
        $post->value = $validatedData['value'];

        // OU $post->update($validatedData);

        $post->save();
        return redirect()->route('postList')->with('success', 'Post mis à jour avec succès!');
    }

    // DESTROY

    // Par post
    public function destroy(Posts $post) {

    // Suppression physique
    $post->delete();

    return redirect()->route('postList')->with('success', 'Post supprimé avec succès!');
}

    // Par ID
    public function destroyById($id) {

    $post = Posts::findOrFail($id);
    $post->delete();

    return redirect()->route('postList')->with('success', 'Post supprimé avec succès!');
}


// GERER LE TRATEMENT SANS LES FORMS REQUESTS
public function storeWithoutFormRequests(Request $request) {


    $validator = Validator::make($request->all(), [ // Ne pas oublier d'ajouter dans les déclarations tout en haut du fichier : use Illuminate\Support\Facades\Validator;

        'title' => 'required|string|max:255',
        'value' => 'required|numeric|min:0|max:5',
    ]);

    // Le hook before pour manipuler les données avant validation
    $validator->after(function ($validator) use ($request) {
        $request->merge([
            'title' => ucfirst($request->title),  // Exemple : Mettre la première lettre du titre en majuscule 
        ]);
    });

    if ($validator->fails()) {

        return redirect()->back()  // Redirige vers la page précédente
        ->withErrors($validator)  // Ajoute les erreurs à la session
        ->withInput();  // Conserve les anciennes données du formulaire
    }
}
}
