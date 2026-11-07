<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $genreId = $request->query('genre_id');
        $director = $request->query('director', 'all');
        $genres = Genre::query()->orderBy('name')->get();
        $directors = Movie::query()->distinct()->orderBy('director')->pluck('director')->all();

        $query = Movie::query();

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('director', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%")
                    ->orWhereHas('genres', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($genreId !== null && $genreId !== '' && $genreId !== 'all') {
            $query->whereHas('genres', function ($query) use ($genreId) {
                $query->where('genres.id', $genreId);
            });
        }

        if ($director !== 'all') {
            $query->where('director', $director);
        }

        $movies = $query->with('genres')->get();

        return view('movies.index', [
            'movies' => $movies,
            'search' => $search,
            'genreId' => $genreId,
            'director' => $director,
            'genres' => $genres,
            'directors' => $directors,
        ]);
    }

    public function create()
    {
        return view('movies.create', [
            'genres' => Genre::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->movieRules());

        $genreIds = $validated['genre_ids'];
        unset($validated['genre_ids']);

        $movie = Movie::create($validated);
        $movie->genres()->sync($genreIds);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully.');
    }

    public function show(Movie $movie)
    {
        $movie->load('genres');

        return view('movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('movies.edit', [
            'movie' => $movie->load('genres'),
            'genres' => Genre::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate($this->movieRules());
        $genreIds = $validated['genre_ids'];
        unset($validated['genre_ids']);

        $movie->update($validated);
        $movie->genres()->sync($genreIds);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully.');
    }

    public function featured()
    {
        $movie = Movie::with('genres')->firstOrFail();

        return view('movies.featured', ['movie' => $movie]);
    }

    private function movieRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'genre_ids' => ['required', 'array', 'min:1'],
            'genre_ids.*' => ['required', 'integer', 'distinct', 'exists:genres,id'],
            'rating' => ['required', 'string', 'max:20'],
            'year' => ['required', 'integer', 'between:1888,'.date('Y')],
            'image_url' => ['required', 'url', 'starts_with:https://'],
        ];
    }
}
