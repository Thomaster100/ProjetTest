<?php

namespace App\Services;
use App\Models\Posts;

class PostsService {

    public function createPost($data) {
        return Posts::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author'],
            'value' => $data['value'],
        ]);
    }

    public function updatePost(Posts $post, $data) {
        $post->update($data);
        return $post;
    }
}