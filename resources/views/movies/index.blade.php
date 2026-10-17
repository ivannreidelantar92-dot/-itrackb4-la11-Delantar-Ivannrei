@extends('layouts.app')

@section('title', 'Movies')

@section('content')
    <div class="mt-4 mb-3">
        <a href="{{ route('movies.create') }}" class="btn btn-primary mb-3">Add Movie</a>

        <form method="GET" action="{{ route('movies.index') }}" class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search movie..." value="{{ $search }}">
            <input type="hidden" name="genre" value="{{ $genre }}">
            <input type="hidden" name="director" value="{{ $director }}">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>

        <div class="mb-3">
            <strong>Active filters:</strong>
            @if ($genre !== 'all')
                <span class="badge bg-primary me-2">Genre: {{ $genre }}</span>
            @endif
            @if ($director !== 'all')
                <span class="badge bg-info text-dark me-2">Director: {{ $director }}</span>
            @endif
            @if ($search !== '')
                <span class="badge bg-secondary me-2">Search: {{ $search }}</span>
            @endif
            @if ($genre === 'all' && $director === 'all' && $search === '')
                <span class="badge bg-secondary">None</span>
            @endif
        </div>

        <div class="mb-3">
            <strong>Genre:</strong>
            <a href="{{ route('movies.index', ['search' => $search, 'genre' => 'all', 'director' => $director]) }}" class="btn btn-sm {{ $genre === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            @foreach ($genres as $option)
                <a href="{{ route('movies.index', ['search' => $search, 'genre' => $option, 'director' => $director]) }}" class="btn btn-sm {{ $genre === $option ? 'btn-primary' : 'btn-outline-primary' }}">{{ $option }}</a>
            @endforeach
        </div>

        <div class="mb-3">
            <strong>Director:</strong>
            <a href="{{ route('movies.index', ['search' => $search, 'genre' => $genre, 'director' => 'all']) }}" class="btn btn-sm {{ $director === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            @foreach ($directors as $option)
                <a href="{{ route('movies.index', ['search' => $search, 'genre' => $genre, 'director' => $option]) }}" class="btn btn-sm {{ $director === $option ? 'btn-primary' : 'btn-outline-primary' }}">{{ $option }}</a>
            @endforeach
        </div>

        <a href="{{ route('movies.index') }}" class="btn btn-secondary btn-sm">Clear all</a>
    </div>

    <table class="table table-striped mt-4" border="1" cellpadding="8">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Director</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Rating</th>
        </tr>

        @forelse ($movies as $movie)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $movie['title'] }}</td>
                <td>{{ $movie['director'] }}</td>
                <td>{{ $movie['genre'] }}</td>
                <td>{{ $movie['year'] ?? '—' }}</td>
                <td>{{ $movie['rating'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No movies found.</td>
            </tr>
        @endforelse
    </table>

@endsection