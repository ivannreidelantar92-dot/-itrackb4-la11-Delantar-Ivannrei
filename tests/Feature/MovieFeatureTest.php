<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->movieFile = base_path('storage/movies.json');
        $this->originalMovies = file_get_contents($this->movieFile);
    }

    protected function tearDown(): void
    {
        file_put_contents($this->movieFile, $this->originalMovies);

        parent::tearDown();
    }

    public function test_create_page_loads(): void
    {
        $response = $this->get('/movies/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Movie');
    }

    public function test_store_saves_movie_and_redirects(): void
    {
        $response = $this->post('/movies', [
            'title' => 'Sicario',
            'director' => 'Denis Villeneuve',
            'genre' => 'Action',
            'rating' => '7.6/10',
            'year' => 2015,
        ]);

        $response->assertRedirect('/movies');

        $movies = json_decode(file_get_contents($this->movieFile), true);
        $this->assertNotNull($movies);
        $this->assertTrue(in_array('Sicario', array_column($movies, 'title')));
        $this->assertSame(2015, $movies[array_key_last($movies)]['year']);
    }
}
