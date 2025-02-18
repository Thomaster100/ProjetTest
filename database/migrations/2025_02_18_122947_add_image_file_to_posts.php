<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {

        Schema::table('posts', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content'); // Nouvelle colonne pour l’image
            $table->string('file')->nullable()->after('image');  // Nouvelle colonne pour le fichier
            $table->string('user_folder')->nullable()->after('file')->index(); // Dossier utilisateur spécifique
        });
    }

    public function down() {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['image', 'file', 'user_folder']);
        });
    }
};
