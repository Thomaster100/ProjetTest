<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;

class CheckPostKeyword
{
    public function handle(Request $request, Closure $next) {

        $post = $request->route('post');
        $forbiddenKeywords = ['banni', 
                            'interdit', 
                            'censuré']; // Liste des mots-clés interdits

        if ($post && collect($forbiddenKeywords)->contains(fn($word) => 
               
               str_contains(strtolower($post->title), $word))) {
            return redirect()->route('postList')->with('error', 'Ce post contient un contenu interdit.');
        }

        return $next($request);
    }
}