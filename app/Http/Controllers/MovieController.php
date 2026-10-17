<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function index(Request $request)
    {
        $allMovies = $this->readMovies();
        $search = trim((string) $request->query('search', ''));
        $genre = $request->query('genre', 'all');
        $director = $request->query('director', 'all');

        $movies = $allMovies;

        if ($search !== '') {
            $movies = array_values(array_filter($movies, function ($movie) use ($search) {
                return stripos($movie['title'], $search) !== false
                    || stripos($movie['director'], $search) !== false
                    || stripos($movie['genre'], $search) !== false
                    || stripos((string) ($movie['year'] ?? ''), $search) !== false;
            }));
        }

        if ($genre !== 'all') {
            $movies = array_values(array_filter($movies, function ($movie) use ($genre) {
                return strcasecmp($movie['genre'], $genre) === 0;
            }));
        }

        if ($director !== 'all') {
            $movies = array_values(array_filter($movies, function ($movie) use ($director) {
                return strcasecmp($movie['director'], $director) === 0;
            }));
        }

        $genres = collect($allMovies)->pluck('genre')->unique()->sort()->values()->all();
        $directors = collect($allMovies)->pluck('director')->unique()->sort()->values()->all();

        return view('movies.index', [
            'movies' => $movies,
            'search' => $search,
            'genre' => $genre,
            'director' => $director,
            'genres' => $genres,
            'directors' => $directors,
        ]);
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'in:Action,Animation,Comedy,Drama,Science Fiction'],
            'rating' => ['required', 'string', 'max:20'],
            'year' => ['required', 'integer', 'between:1888,'.date('Y')],
        ]);

        $movies = $this->readMovies();
        $nextId = empty($movies) ? 1 : max(array_column($movies, 'id')) + 1;

        $movies[] = [
            'id' => $nextId,
            'title' => $validated['title'],
            'director' => $validated['director'],
            'genre' => $validated['genre'],
            'rating' => $validated['rating'],
            'year' => (int) $validated['year'],
        ];

        $this->writeMovies($movies);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully.');
    }

    public function show(string $id)
    {
        $movies = $this->readMovies();
        $movie = collect($movies)->firstWhere('id', (int) $id);

        if (!$movie) {
            abort(404);
        }

        return view('movies.show', ['movie' => $movie]);
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }

    public function featured()
    {
        $movies = $this->readMovies();
        $movie = $movies[0] ?? null;

        if (!$movie) {
            abort(404);
        }

        return view('movies.featured', ['movie' => $movie]);
    }

    private function readMovies()
    {
        $path = storage_path('movies.json');

        if (!file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);

        if ($content === false || trim($content) === '') {
            return [];
        }

        $movies = json_decode($content, true);

        return is_array($movies) ? $movies : [];
    }

    private function writeMovies(array $movies): void
    {
        $path = storage_path('movies.json');
        file_put_contents($path, json_encode($movies, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}