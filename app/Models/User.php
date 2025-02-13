<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword; // A ajouter pour importer l'evenement ResetPassword

class User extends Authenticatable   {

    use HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'provider',
        'provider_id',
        'avatar',
    ];

    protected $hidden = [ // si pas existant - à ajouter dans vos modèles
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function role() {
        return $this->belongsTo(Role::class);
    }

    // Vérifier si l'utilisateur a un rôle spécifique
    public function hasRole($roleName) {
        return $this->role && $this->role->name === $roleName;
    }

    // CAS DE RELATION
    public function hasPermission($permission){
        return $this->role && $this->role->hasPermission($permission);
    }

    // VERIFIER SI ROLE ADMIN (CAS RELATION)
    public function isAdmin() {
        return $this->role && $this->role === 'admin';
   }

   // NOUVELLES VERIFICATION DE ROLES
   public function isModerator() {
        return $this->role && $this->role->name === 'moderator';
    }

    public function isEditor() {
        return $this->role && $this->role->name === 'editor';
    }

    public function isViewer() {
        return $this->role && $this->role->name === 'viewer';
    }

//    // Ne pas oublier d'associer la notification avec l'utilisateur
   public function sendPasswordResetNotification($token) {
       $this->notify(new ResetPassword($token));
   }

}
