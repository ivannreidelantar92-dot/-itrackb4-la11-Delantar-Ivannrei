<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Genre::create(['name' => 'Action']);
        Genre::create(['name' => 'Comedy']);
        Genre::create(['name' => 'Drama']);
        Genre::create(['name' => 'Historical Fiction']);
    }

    public function test_create_page_loads(): void
    {
        $response = $this->get('/movies/create');

        $response->assertStatus(200);
        $response->assertSee('Add a movie');
    }

    public function test_store_saves_movie_and_redirects(): void
    {
        $genre = Genre::where('name', 'Action')->firstOrFail();

        $response = $this->post('/movies', [
            'title' => 'Sicario',
            'director' => 'Denis Villeneuve',
            'genre_ids' => [$genre->id],
            'rating' => '7.6/10',
            'year' => 2015,
            'image_url' => 'https://example.com/sicario.jpg',
        ]);

        $response->assertRedirect('/movies');
        $this->assertDatabaseHas('movies', [
            'title' => 'Sicario',
            'year' => 2015,
            'image_url' => 'https://example.com/sicario.jpg',
        ]);
        $movieId = Movie::where('title', 'Sicario')->value('id');
        $this->assertDatabaseHas('genre_movie', [
            'movie_id' => $movieId,
            'genre_id' => $genre->id,
        ]);
    }

    public function test_store_saves_multiple_genres_for_a_movie(): void
    {
        $genres = Genre::whereIn('name', ['Comedy', 'Action', 'Historical Fiction'])
            ->orderBy('name')
            ->pluck('id')
            ->all();

        $response = $this->post('/movies', [
            'title' => 'Comedy Action Historical Fiction Movie',
            'director' => 'Director C',
            'genre_ids' => $genres,
            'rating' => '8/10',
            'year' => 2020,
            'image_url' => 'https://example.com/multi.jpg',
        ]);

        $response->assertRedirect('/movies');
        $movieId = Movie::where('title', 'Comedy Action Historical Fiction Movie')->value('id');
        $this->assertDatabaseCount('genre_movie', 3);
        foreach ($genres as $genreId) {
            $this->assertDatabaseHas('genre_movie', [
                'movie_id' => $movieId,
                'genre_id' => $genreId,
            ]);
        }
    }

    public function test_index_displays_related_genre_names_and_filters_by_genre_id(): void
    {
        $action = Genre::where('name', 'Action')->firstOrFail();
        $drama = Genre::where('name', 'Drama')->firstOrFail();

        Movie::create([
            'title' => 'Action Movie',
            'director' => 'Director A',
            'rating' => '8/10',
            'year' => 2020,
            'image_url' => 'https://example.com/action.jpg',
        ])->genres()->attach([$action->id, $drama->id]);
        Movie::create([
            'title' => 'Drama Movie',
            'director' => 'Director B',
            'rating' => '7/10',
            'year' => 2021,
            'image_url' => 'https://example.com/drama.jpg',
        ])->genres()->attach($drama->id);

        $response = $this->get('/movies?genre_id='.$action->id);

        $response->assertOk()
            ->assertSee('Action Movie')
            ->assertSee('Action')
        ->assertSee('Drama')
            ->assertDontSee('Drama Movie')
            ->assertSee('genre_id='.$action->id, false);
    }
}
