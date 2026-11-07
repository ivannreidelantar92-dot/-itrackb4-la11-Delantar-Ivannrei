@extends('layouts.app')

@section('title', 'Movies')

@section('content')
    <section class="collection-heading">
        <div>
            <p class="eyebrow">THE LIBRARY</p>
            <h2>My collection <span class="collection-count">{{ count($movies) }} films</span></h2>
            <p class="section-subtitle">A handpicked collection of stories on screen.</p>
        </div>
        <a href="{{ route('movies.create') }}" class="primary-action"><span aria-hidden="true">＋</span> Add a movie</a>
    </section>

    <section class="filter-panel">
        <form method="GET" action="{{ route('movies.index') }}" class="search-form">
            <label class="visually-hidden" for="movie-search">Search your collection</label>
            <span class="search-icon" aria-hidden="true">⌕</span>
            <input id="movie-search" type="search" name="search" placeholder="Search by title, director, genre or year..." value="{{ $search }}">
            <input type="hidden" name="genre_id" value="{{ $genreId }}">
            <input type="hidden" name="director" value="{{ $director }}">
            <button type="submit" class="search-button">Search</button>
        </form>

        <div class="filter-group">
            <span class="filter-label">Genre</span>
            <div class="filter-options">
                <a href="{{ route('movies.index', ['search' => $search, 'director' => $director]) }}" class="filter-chip {{ empty($genreId) ? 'selected' : '' }}">All</a>
                @foreach ($genres as $option)
                    <a href="{{ route('movies.index', ['search' => $search, 'genre_id' => $option->id, 'director' => $director]) }}" class="filter-chip {{ (string) $genreId === (string) $option->id ? 'selected' : '' }}">{{ $option->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-label">Director</span>
            <div class="filter-options">
                <a href="{{ route('movies.index', ['search' => $search, 'genre_id' => $genreId, 'director' => 'all']) }}" class="filter-chip {{ $director === 'all' ? 'selected' : '' }}">All</a>
                @foreach ($directors as $option)
                    <a href="{{ route('movies.index', ['search' => $search, 'genre_id' => $genreId, 'director' => $option]) }}" class="filter-chip {{ $director === $option ? 'selected' : '' }}">{{ $option }}</a>
                @endforeach
            </div>
        </div>

        @if (! empty($genreId) || $director !== 'all' || $search !== '')
            <a href="{{ route('movies.index') }}" class="clear-filters">Clear filters <span aria-hidden="true">×</span></a>
        @endif
    </section>

    <section class="movie-grid" aria-label="Movies">
        @forelse ($movies as $movie)
            <article class="movie-card">
                <a class="movie-art" href="{{ route('movies.show', ['movie' => $movie->id]) }}" aria-label="View {{ $movie->title }}">
                    <img src="{{ $movie->image_url }}" alt="{{ $movie->title }} poster" loading="lazy">
                    <span class="art-caption">FEATURE NO. {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                </a>
                <div class="movie-info">
                    <div class="movie-meta">
                        <span>{{ $movie->year ?? 'Year unknown' }}</span>
                        <span class="rating"><span aria-hidden="true">★</span> {{ $movie->rating }}</span>
                    </div>
                    <h3>{{ $movie->title }}</h3>
                    <p class="movie-director">Directed by {{ $movie->director }}</p>
                    <div class="movie-footer">
                        @foreach ($movie->genres as $genre)
                            <span class="genre-tag">{{ $genre->name }}</span>
                        @endforeach
                        <a class="details-link" href="{{ route('movies.show', ['movie' => $movie->id]) }}" aria-label="View {{ $movie->title }} details">View details <span aria-hidden="true">↗</span></a>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <a href="{{ route('movies.edit', $movie) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                        <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Delete this movie?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true">✦</span>
                <h3>No movies found</h3>
                <p>Try a different search or clear your filters to see your collection.</p>
                <a href="{{ route('movies.index') }}" class="primary-action">Show all movies</a>
            </div>
        @endforelse
    </section>

@endsection