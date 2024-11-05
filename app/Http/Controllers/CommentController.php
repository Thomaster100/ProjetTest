<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Posts;

class CommentController extends Controller
{

    public function index($postId) {
        $post = Posts::findOrFail($postId);
        $comments = $post->comments;
        return view('comments.index', compact('post', 'comments'));
    }

    public function create($postId) {
        $post = Posts::findOrFail($postId);
        return view('comments.create', compact('post'));
    }

    public function store(Request $request, $postId) {

        // Validations
        $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
    
        $post = Posts::findOrFail($postId);
        $post->comments()->create($request->all());
    
        return redirect()->route('comments.index', $postId)->with('success', 'Commentaire ajouté !');
    }

    public function show($postId, $id) {
        $comment = Comment::where('post_id', $postId)->findOrFail($id);
        return view('comments.show', compact('comment'));
    }

    public function edit($postId, $id) {
        $comment = Comment::where('post_id', $postId)->findOrFail($id);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, $postId, $id) {
        $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
    
        $comment = Comment::where('post_id', $postId)->findOrFail($id);
        $comment->update($request->all());
    
        return redirect()->route('comments.index', $postId)->with('success', 'Commentaire mis à jour !');
    }

    public function destroy($postId, $id)
    {
        $comment = Comment::where('post_id', $postId)->findOrFail($id);
        $comment->delete();
    
        return redirect()->route('comments.index', $postId)->with('success', 'Commentaire supprimé !');
    }
    
}
