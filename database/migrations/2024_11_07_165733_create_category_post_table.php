<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPostTable extends Migration
{
    public function up() {
        
        Schema::create('category_post', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('post_id'); // Clé étrangère pour Posts
            $table->unsignedBigInteger('category_id'); // Clé étrangère pour Category
            $table->timestamps();

            // Référence pour les clé étrangères
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('category_post');
    }
}
