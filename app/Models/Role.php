<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    
    use HasFactory;

     /**
     * Les attributs qui peuvent être remplis en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relation avec les permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Vérifie si un rôle possède une permission spécifique.
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasPermission($permissionName) {
        return $this->permissions->contains('name', $permissionName);
    }

}
