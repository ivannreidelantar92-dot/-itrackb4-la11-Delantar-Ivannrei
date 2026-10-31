<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_loads(): void
    {
        Genre::create(['name' => 'Science Fiction']);

        $response = $this->get('/movies/create');

        $response->assertOk()
            ->assertSee('Science Fiction')
            ->assertSee('name="genre_ids[]"', false)
            ->assertSee('multiple', false);
    }

    public function test_store_redirects_and_saves_movie(): void
    {
        $genre = Genre::create(['name' => 'Science Fiction']);

        $response = $this->post('/movies', [
            'title' => 'The Matrix',
            'director' => 'Lana Wachowski',
            'genre_ids' => [$genre->id],
            'rating' => '8.7/10',
            'year' => 1999,
            'image_url' => 'https://example.com/matrix.jpg',
        ]);

        $response->assertRedirect(route('movies.index'));
        $this->assertDatabaseHas('movies', [
            'title' => 'The Matrix',
        ]);
        $this->assertDatabaseHas('genre_movie', [
            'movie_id' => Movie::where('title', 'The Matrix')->value('id'),
            'genre_id' => $genre->id,
        ]);
    }
}
