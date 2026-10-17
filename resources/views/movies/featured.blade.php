@extends('layouts.app')

@section('title', 'Featured Movie')

@section('content')
    <div class="mt-4">
        <h2>Featured Movie</h2>

        <div class="card text-bg-light p-3 mt-3">
            <h3>{{ $movie['title'] }}</h3>
            <p><strong>Director:</strong> {{ $movie['director'] }}</p>
            <p><strong>Genre:</strong> {{ $movie['genre'] }}</p>
            <p><strong>Year:</strong> {{ $movie['year'] ?? '—' }}</p>
            <p><strong>Rating:</strong> {{ $movie['rating'] }}</p>
        </div>

        <button class="btn btn-secondary mt-3">
            <a href="{{ route('movies.index') }}" class="text-decoration-none text-white">Back</a>
        </button>
    </div>
@endsection
