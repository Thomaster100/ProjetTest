<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'content'
    ];

    public function post() {
        // Appartenance a l'entité posts
        return $this->belongsTo(Posts::class, 'post_id');
    }

}
