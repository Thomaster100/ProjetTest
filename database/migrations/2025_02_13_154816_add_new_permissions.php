<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;

return new class extends Migration {

    public function up() {
        $permissions = [
            'create-todos', 
            'approve-todos', 
            'edit-comments', 
            'delete-comments', 
            'manage-users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    public function down() {

        // WhereIn() => Equivaut a IN en SQL classique (select * from ... where ... IN ('create-todos', 'approve-todos'...))
        Permission::whereIn('name', [
            'create-todos', 'approve-todos', 'edit-comments', 'delete-comments', 'manage-users'
        ])->delete();
    }
};