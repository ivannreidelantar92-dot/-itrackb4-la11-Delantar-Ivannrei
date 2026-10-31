@extends('layouts.app')

@section('title', 'Featured Movie')

@section('content')
    <section class="featured-section">
        <p class="eyebrow">EDITOR'S PICK</p>
        <article class="featured-card">
            <div class="featured-poster">
                <img src="{{ $movie->image_url }}" alt="{{ $movie->title }} poster">
            </div>
            <div class="featured-copy">
                <span class="featured-label">FEATURED MOVIE</span>
                <h2>{{ $movie->title }}</h2>
                <p class="detail-director">Directed by {{ $movie->director }}</p>
                <p class="featured-meta">{{ $movie->genres->pluck('name')->join(', ') }} <span>·</span> {{ $movie->year ?? 'Year unknown' }}</p>
                <span class="detail-rating"><span aria-hidden="true">★</span> {{ $movie->rating }}</span>
                <a href="{{ route('movies.show', ['movie' => $movie->id]) }}" class="primary-action featured-action">Movie details <span aria-hidden="true">↗</span></a>
            </div>
        </article>
        <a href="{{ route('movies.index') }}" class="back-link featured-back">← Back to collection</a>
    </section>
@endsection
