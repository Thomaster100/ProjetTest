<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserSeeder extends Seeder {
    
    public function run() {

        // Vérifier si les rôles existent, sinon les créer
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Définir une date de vérification
        $verified_at = Carbon::now();

        // Créer des utilisateurs avec rôles et vérification d'email
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'email_verified_at' => $verified_at
            ],
            [
                'name' => 'Moderator User',
                'email' => 'moderator@example.com',
                'password' => Hash::make('password'),
                'role_id' => $moderatorRole->id,
                'email_verified_at' => $verified_at
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => Hash::make('password'),
                'role_id' => $editorRole->id,
                'email_verified_at' => $verified_at
            ],
            [
                'name' => 'Viewer User',
                'email' => 'viewer@example.com',
                'password' => Hash::make('password'),
                'role_id' => $viewerRole->id,
                'email_verified_at' => $verified_at
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        // Définir les permissions pour chaque rôle
        $permissions = [
            'admin' => ['manage-users', 'modify-todos', 'create-todos', 'approve-todos'],
            'moderator' => ['approve-todos', 'edit-comments', 'delete-comments'],
            'editor' => ['create-todos', 'edit-comments'],
            'viewer' => []
        ];

        foreach ($permissions as $roleName => $permissionNames) {
            $role = Role::where('name', $roleName)->first();
            foreach ($permissionNames as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        echo "Utilisateurs et permissions créés avec succès !";
    }
}
