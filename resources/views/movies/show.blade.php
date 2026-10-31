@extends('layouts.app')
@section('title', $movie->title)
@section('content')
    <a href="{{ route('movies.index') }}" class="back-link">← Back to collection</a>
    <article class="movie-detail">
        <div class="detail-poster">
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }} poster">
        </div>
        <div class="detail-copy">
            <p class="eyebrow">{{ $movie->genres->pluck('name')->join(', ') }} · {{ $movie->year ?? 'Year unknown' }}</p>
            <h2>{{ $movie->title }}</h2>
            <p class="detail-director">Directed by {{ $movie->director }}</p>
            <span class="detail-rating"><span aria-hidden="true">★</span> {{ $movie->rating }}</span>
        </div>
    </article>
@endsection