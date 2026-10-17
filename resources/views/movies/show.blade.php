@extends('layouts.app')
@section ('title', 'Movies')
@section('content')
    <h1>{{ $movie['title'] }}</h1>
    <p><strong>Director:</strong> {{ $movie['director'] }}</p>
    <p><strong>Genre:</strong> {{ $movie['genre'] }}</p>
    <p><strong>Year:</strong> {{ $movie['year'] ?? '—' }}</p>
    <p><strong>Rating:</strong> {{ $movie['rating'] }}</p>

    <p><a href="{{ route('movies.index') }}">Back to Movie List</a></p>
<button class="btn btn-secondary"><a href="{{ route('movies.index') }}" class="text-decoration-none text-white">Back</a></button>

@endsection