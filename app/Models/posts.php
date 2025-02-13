<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Posts extends Model
{
    use HasFactory;

     // Spécifie les champs qui peuvent être assignés en masse (mass assignable)
    protected $fillable = [
        'title',
        'content',
        'author',
        'value',
        'approved'
    ];

    // Cast automatique du champ "value" en float
    // En quel cas, on ne passe pas par le prepareForValidation() parce que déja défini dans le modèle...
    protected $casts = [
        'value' => 'float', 
    ];

    // Obtenir tout les commentaires d'un post
    public function comments() {
     return $this->hasMany(Comment::class, 'post_id');
    }

}
