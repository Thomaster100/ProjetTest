<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration {

    public function up() {
        $roles = ['moderator', 'editor', 'viewer'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }

    public function down() {
        // SELECT * from (table) WHERE (colonne) IN ('moderator', 'editor', 'viewer')
        Role::whereIn('name', ['moderator', 'editor', 'viewer'])->delete();
    }
};