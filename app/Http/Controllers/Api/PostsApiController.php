<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Validator;

class PostsApiController extends Controller {

    public function index() {

        $posts = Posts::all();
        return response()->json($posts);
    }

    public function show($id) {

        $post = Posts::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post non trouvé'], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'author'  => 'nullable|string|max:255',
            'value'   => 'nullable|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $post = Posts::create($validator->validated());

        return response()->json([
            'message' => 'Post créé avec succès',
            'post' => $post
        ], 201);
    }

    public function update(Request $request, $id) {
        
        $post = Posts::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'   => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'author'  => 'nullable|string|max:255',
            'value'   => 'nullable|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $post->update($validator->validated());

        return response()->json([
            'message' => 'Post mis à jour avec succès',
            'post' => $post
        ]);
    }

    public function destroy($id) {
        
        $post = Posts::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post non trouvé'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post supprimé avec succès']);
    }
}
