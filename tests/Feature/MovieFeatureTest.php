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

    public function test_edit_page_prefills_movie_fields_and_selects_its_genres(): void
    {
        $action = Genre::where('name', 'Action')->firstOrFail();
        $drama = Genre::where('name', 'Drama')->firstOrFail();
        $movie = Movie::create([
            'title' => 'The Pirates',
            'director' => 'A Director',
            'rating' => '8/10',
            'year' => 2020,
            'image_url' => 'https://example.com/pirates.jpg',
        ]);
        $movie->genres()->attach([$action->id, $drama->id]);

        $response = $this->get(route('movies.edit', $movie));

        $response->assertOk()
            ->assertSee('value="The Pirates"', false)
            ->assertSee('value="A Director"', false)
            ->assertSee('value="8/10"', false)
            ->assertSee('value="2020"', false)
            ->assertSee('value="https://example.com/pirates.jpg"', false)
            ->assertSee('value="'.$action->id.'" selected', false)
            ->assertSee('value="'.$drama->id.'" selected', false);
    }

    public function test_update_saves_movie_fields_and_syncs_genres(): void
    {
        $action = Genre::where('name', 'Action')->firstOrFail();
        $comedy = Genre::where('name', 'Comedy')->firstOrFail();
        $movie = Movie::create([
            'title' => 'Old title',
            'director' => 'Old director',
            'rating' => '6/10',
            'year' => 2010,
            'image_url' => 'https://example.com/old.jpg',
        ]);
        $movie->genres()->attach($action);

        $response = $this->put(route('movies.update', $movie), [
            'title' => 'Updated title',
            'director' => 'Updated director',
            'genre_ids' => [$comedy->id],
            'rating' => '9/10',
            'year' => 2022,
            'image_url' => 'https://example.com/updated.jpg',
        ]);

        $response->assertRedirect(route('movies.index'));
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Updated title',
            'director' => 'Updated director',
            'rating' => '9/10',
            'year' => 2022,
            'image_url' => 'https://example.com/updated.jpg',
        ]);
        $this->assertDatabaseHas('genre_movie', [
            'movie_id' => $movie->id,
            'genre_id' => $comedy->id,
        ]);
        $this->assertDatabaseMissing('genre_movie', [
            'movie_id' => $movie->id,
            'genre_id' => $action->id,
        ]);
    }

    public function test_invalid_update_redirects_back_with_typed_values(): void
    {
        $action = Genre::where('name', 'Action')->firstOrFail();
        $movie = Movie::create([
            'title' => 'Original title',
            'director' => 'Original director',
            'rating' => '6/10',
            'year' => 2010,
            'image_url' => 'https://example.com/original.jpg',
        ]);
        $movie->genres()->attach($action);
        $editUrl = route('movies.edit', $movie);

        $response = $this->from($editUrl)->put(route('movies.update', $movie), [
            'title' => '',
            'director' => 'Typed director',
            'genre_ids' => [$action->id],
            'rating' => 'Typed rating',
            'year' => 2022,
            'image_url' => 'https://example.com/typed.jpg',
        ]);

        $response->assertRedirect($editUrl)
            ->assertSessionHasErrors('title')
            ->assertSessionHasInput('director', 'Typed director')
            ->assertSessionHasInput('rating', 'Typed rating');
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Original title',
        ]);
    }

    public function test_destroy_deletes_movie_and_redirects(): void
    {
        $action = Genre::where('name', 'Action')->firstOrFail();
        $movie = Movie::create([
            'title' => 'Movie to delete',
            'director' => 'Director',
            'rating' => '7/10',
            'year' => 2020,
            'image_url' => 'https://example.com/delete.jpg',
        ]);
        $movie->genres()->attach($action);

        $response = $this->delete(route('movies.destroy', $movie));

        $response->assertRedirect(route('movies.index'));
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
        $this->assertDatabaseMissing('genre_movie', ['movie_id' => $movie->id]);
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
