<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::table('posts', function (Blueprint $table) {
            // Ajoute la colonne après 'value'
            $table->boolean('approved')->default(false)->after('value'); 
        });
    }

    public function down() {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
};