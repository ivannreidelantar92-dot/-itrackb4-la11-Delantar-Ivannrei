<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'director',
        'genre',
        'rating',
        'year',
        'is_watched',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_watched' => 'boolean',
        ];
    }
}
