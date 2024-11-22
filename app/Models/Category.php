<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relation Many-to-Many avec le modèle Posts
    public function posts() {
        return $this->belongsToMany(Posts::class, 'post_id');
    }
}
