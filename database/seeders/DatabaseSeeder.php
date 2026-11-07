<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! User::query()->where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $scienceFiction = Genre::firstOrCreate(['name' => 'Science Fiction']);
        $action = Genre::firstOrCreate(['name' => 'Action']);
        $animation = Genre::firstOrCreate(['name' => 'Animation']);
        $comedy = Genre::firstOrCreate(['name' => 'Comedy']);
        $drama = Genre::firstOrCreate(['name' => 'Drama']);
        Genre::firstOrCreate(['name' => 'History']);
        $historicalFiction = Genre::firstOrCreate(['name' => 'Historical Fiction']);
        $adventure = Genre::firstOrCreate(['name' => 'Adventure']);

        Movie::create([
            'title' => 'Interstellar',
            'director' => 'Christopher Nolan',
            'rating' => '9.0/10',
            'year' => 2014,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg',
        ])->genres()->sync([$scienceFiction->id, $adventure->id]);
        Movie::create([
            'title' => 'The Dark Knight',
            'director' => 'Christopher Nolan',
            'rating' => '9.0/10',
            'year' => 2008,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/1/1c/The_Dark_Knight_%282008_film%29.jpg',
        ])->genres()->sync([$action->id, $drama->id]);
        Movie::create([
            'title' => 'Spirited Away',
            'director' => 'Hayao Miyazaki',
            'rating' => '8.6/10',
            'year' => 2001,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/d/db/Spirited_Away_Japanese_poster.png',
        ])->genres()->sync([$animation->id, $adventure->id]);
        Movie::create([
            'title' => 'The Grand Budapest Hotel',
            'director' => 'Wes Anderson',
            'rating' => '8.1/10',
            'year' => 2014,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/1/1c/The_Grand_Budapest_Hotel.png',
        ])->genres()->sync([$comedy->id, $action->id, $historicalFiction->id]);
        Movie::create([
            'title' => 'The Shawshank Redemption',
            'director' => 'Frank Darabont',
            'rating' => '9.3/10',
            'year' => 1994,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg',
        ])->genres()->sync([$drama->id]);
        Movie::create([
            'title' => 'Inception',
            'director' => 'Christopher Nolan',
            'rating' => '8.8/10',
            'year' => 2010,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg',
        ])->genres()->sync([$action->id, $scienceFiction->id]);
        Movie::create([
            'title' => 'Runner',
            'director' => 'Scott Waugh',
            'rating' => '9/10',
            'year' => 2025,
            'image_url' => 'https://image.tmdb.org/t/p/w500/vJk2TW1QZAmBiD7oj9ZF9EPTYY1.jpg',
        ])->genres()->sync([$action->id, $adventure->id]);
        Movie::create([
            'title' => 'The Matrix',
            'director' => 'Lana Wachowski',
            'rating' => '8.7/10',
            'year' => 1999,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/en/d/db/The_Matrix.png',
        ])->genres()->sync([$scienceFiction->id, $action->id]);
    }
}
