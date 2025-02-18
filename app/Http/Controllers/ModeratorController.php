<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class ModeratorController extends Controller {
    
    public function index() {
        $posts = Post::all();
        $comments = Comment::all();
        return view('moderator.index', compact('posts', 'comments'));
    }

    public function deleteComment($id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('moderator.index')->with('success', 'Commentaire supprimé avec succès.');
    }

    public function approvePost($id) {
        $post = Post::findOrFail($id);
        $post->update(['approved' => true]);
        return redirect()->route('moderator.index')->with('success', 'Post approuvé.');
    }
}
