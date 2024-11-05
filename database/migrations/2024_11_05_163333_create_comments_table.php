<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Référence vers le post associé
            $table->unsignedBigInteger('post_id'); 
            $table->string('author');
            $table->text('content');
            $table->timestamps();

            // Clé étrangère pour assurer la relation avec les Posts
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
