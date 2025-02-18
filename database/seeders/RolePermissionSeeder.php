<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder {

    public function run() {

        // Récupérer les rôles

        // firstOrCreate() => tente de trouver un modèle correspondant aux attributs indiqués dans le premier paramètre. Si aucun modèle n'est trouvé, il crée et enregistre automatiquement un nouveau modèle après avoir appliqué les attributs passés dans le deuxième paramètre.

        // il existe aussi firstOrNew() ou encore firstOr()
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $moderator = Role::firstOrCreate(['name' => 'moderator']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        // Définir les permissions pour chaque rôle
        $permissions = [
            'admin' => ['modify-todos', 'create-todos', 'approve-todos', 'manage-users'],
            'moderator' => ['approve-todos', 'edit-comments', 'delete-comments'],
            'editor' => ['create-todos', 'edit-comments'],
            'viewer' => []
        ];

        // Attribuer chaque permissions au roles
        foreach ($permissions as $roleName => $permissionNames) {
            $role = Role::where('name', $roleName)->first();
            foreach ($permissionNames as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);

                // syncWithoutDetaching(id) ne supprimera pas toutes les relations existantes manquantes par rapport à celles fournies dans le process actuel, et les enregistrements existants ne recevront pas de nouveaux identifiants.
                $role->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }
    }
}
