<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class EditorController extends Controller {

    public function index() {
        $posts = Post::all();
        return view('editor.index', compact('posts'));
    }

    public function createPost() {
        return view('editor.create');
    }

    public function storePost(Request $request) {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => auth()->user()->name,
        ]);

        return redirect()->route('editor.index')->with('success', 'Post ajouté avec succès.');
    }

    public function editPost(Post $post) {
        return view('editor.edit', compact('post'));
    }

    public function updatePost(Request $request, Post $post) {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('editor.index')->with('success', 'Post mis à jour.');
    }
}
