<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

     // Spécifie les champs qui peuvent être assignés en masse (mass assignable)
    protected $fillable = [
        'title',
        'content',
        'author',
        'value'
    ];

}
