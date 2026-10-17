<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieCrudTest extends TestCase
{
    public function test_create_page_loads(): void
    {
        $response = $this->get('/movies/create');

        $response->assertOk();
    }

    public function test_store_redirects_and_saves_movie(): void
    {
        $response = $this->post('/movies', [
            'title' => 'The Matrix',
            'director' => 'Lana Wachowski',
            'genre' => 'Science Fiction',
            'rating' => '8.7/10',
            'year' => 1999,
        ]);

        $response->assertRedirect(route('movies.index'));
    }
}
