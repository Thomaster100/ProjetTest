<?php

use App\Http\Controllers\Api\PostsApiController;

// ROUTE API
Route::apiResource('posts', PostsApiController::class);

/* 

Route::apiResource genere automatiquement ces routes

GET           /posts                    index   posts.index
POST          /posts                    store   posts.store
GET           /posts/{id}               show    posts.show
PUT|PATCH     /posts/{id}               update  posts.update
DELETE        /posts/{id}               destroy posts.destroy

*/ 