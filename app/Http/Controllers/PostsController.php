<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PostsController extends Controller {

    // LISTER TOUT LES POSTS
    public function index() {

        //vérifier si user authentifié avant d'afficher postList sinon redirection vers login
        if(auth()->check()) {
            // Récuperer tout les posts
            $postList = Posts::all();
            return view('posts.index', compact('postList'));
        }else{
            return view('auth.login');
        }
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

    public function addCommentsToPosts() {

    $posts = Posts::all();
    foreach ($posts as $post) {
        $post->comments()->create([
            'author' => 'Auteur Anonyme',
            'content' => 'Ceci est un commentaire pour ' . $post->title,
        ]);
    }

    return redirect()->route('postList')->with('success', 'Commentaires ajoutés aux posts existants !');
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

    // Ne pas oublier d'ajouter dans les déclarations tout en haut du fichier : use Illuminate\Support\Facades\Validator;
    $validator = Validator::make($request->all(), [
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


  // ---------------- COMPARAISON ELOQUENT / QUERY BUILDER ----------------//


  /*  POUR DECLARER LE QUERY BUILDER => use Illuminate\Support\Facades\DB; en haut de votre fichier */

  /* REQUETES AVANCES (ELOQUENT) */


   // ---- AGGREGATIONS (computer sur un ensemble de valeurs) ---- //
   // EXEMPLES : SELECT COUNT(*) FROM..., SELECT MIN(*) FROM..., MAX(*) en SQL
   public function makeAggregation() {

    $postsByAuthor = Posts::select('author', DB::raw('COUNT(*) as total_posts')) // L'aggrégat se fait avec la fonction COUNT(*)
    ->groupBy('author')
    ->get();

    return $postsByAuthor;
  }

   // ---- EXEMPLE DE SOUS-REQUETE ---- //
  // Obtenir le nombre de records liés à l'objet principal (donc les commentaires associés au post)
  public function getPostWithComments() {

    $posts = Posts::withCount('comments')->get();

    foreach ($posts as $post) {
        echo $post->title . ' a ' . $post->comments_count . ' commentaires.';
    }

    // withCount('comments') ajoute un attribut 'comments_count' à chaque posts... qui représente le nombre de commentaires associés au post.
    // Equivaut à une sous-requête pour compter les commentaires.

    return $posts;
}

  // REQUETE AVEC FILTRES
  public function makeFilteredRequest() {

    $posts = Posts::with('categories')
                    ->where('value', '>', 4.0)
                    ->get();
    return $posts;
  }

    // EXEMPLE DE EXISTS (APPROCHE ELOQUENT)
    public function littleRequestWithClause() {

        $posts = Posts::whereHas('comments')->get(); // Récupérer les posts qui ont des commentaires
        return $posts;
    }

  /* REQUETES AVANCES (QUERY BUILDER) */

  // SOUS-REQUETE
  public function makePostsSubRequest() {

    $posts = DB::table('posts')
    ->select('posts.*', DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count'))
    // DB::raw permet de créer sa requete EN BRUT (raw...) sous forme de string.
    ->get();

    return $posts;
  }

  // REQUETE AVEC PLUSIEURS JOINTURES
  public function makeComplexRequestWithPosts() {

    $posts = DB::table('posts')
                ->select('posts.title', 'categories.name as category_name', 'posts.value')
                ->join('category_post', 'posts.id', '=', 'category_post.post_id') // 1ere jointure
                ->join('categories', 'categories.id', '=', 'category_post.category_id') // 2eme
                ->groupBy('category.')
                ->where('posts.value', '>', 4.0)
                ->get();

    return $posts;
  }

  // REQUETE AVEC PLUSIEURS CONDITIONS
  public function makeConditionnalRequest() {

    $author = 'John Doe';
    $minValue = 4.0;

        $posts = DB::table('posts')
            ->when($author, function ($query, $author) {
                // utilisation des fonctions anonymes (closure) en guise de callback... qui peux se combiner avec une autre condition
                return $query->where('author', $author);
            })
            ->when($minValue, function ($query, $minValue) {
                return $query->where('value', '>=', 3);
            })
            ->get();

    return $posts;
  }

  // REQUETE AVEC GROUPE DE CONDITIONS
  public function makeMoreConditionnalRequest() {

    $posts = DB::table('posts')->where(function ($query) {

        $query->where('author', 'John Doe')
              ->orWhere('author', 'Jane Doe'); // Dans ce cas, soit la 1ere condition ou la 2eme.
    })
    ->where('value', '>', 3.5)
    ->get();

    return $posts;
  }

  // REQUETE AVEC TRI ET LIMITE
  public function makeRequestWithSortAndLimit() {

    $posts = DB::table('posts')
    ->orderBy('value', 'desc') // les orderBy sont chainables..
    ->orderBy('created_at', 'desc')
    ->limit(5) // pour limiter ou faire une pagination DB par exemple
    ->get();

    return $posts;
  }

  // REQUETES AVEC EXCLUSIONS
  public function makeRequestWithExclusions() {

    $excludedAuthors = ['John Doe', 'Jane Doe'];
    $posts = DB::table('posts')
        ->whereNotIn('author', $excludedAuthors)
        ->get();

    return $posts;
  }

  // REQUETES AVEC CLAUSE D'EXISTENCE
  public function requestWithClause() {

    $posts = DB::table('posts')->whereExists(function ($query) { // WhereExists marche aussi avec des closures...
    $query->select(DB::raw(1))
              ->from('comments')
              ->whereColumn('comments.post_id', 'posts.id'); // whereColumn() pour comparer les colonnes...
    })->get();

    return $posts;
  }

}
