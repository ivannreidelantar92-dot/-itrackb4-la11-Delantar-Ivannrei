<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'director',
        'rating',
        'year',
        'is_watched',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_watched' => 'boolean',
        ];
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
