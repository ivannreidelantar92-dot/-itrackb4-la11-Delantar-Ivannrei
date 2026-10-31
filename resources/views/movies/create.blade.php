@extends('layouts.app')

@section('content')
<section class="form-page">
    <a href="{{ route('movies.index') }}" class="back-link">← Back to collection</a>
    <div class="form-card">
        <p class="eyebrow">GROW YOUR LIBRARY</p>
        <h2>Add a movie</h2>
        <p class="section-subtitle">Save another story worth remembering.</p>

        <form method="POST" action="{{ route('movies.store') }}" class="movie-form">
        
        {{-- B4: @csrf security token --}}
        @csrf

        {{-- B2, B5, D1, D3: Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Movie Title</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   class="form-control @error('title') is-invalid @enderror" 
                   value="{{ old('title') }}">
            @error('title')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- B2, B5, D1, D3: Director --}}
        <div class="mb-3">
            <label for="director" class="form-label">Director</label>
            <input type="text" 
                   name="director" 
                   id="director" 
                   class="form-control @error('director') is-invalid @enderror" 
                   value="{{ old('director') }}">
            @error('director')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- B2, B5, C3, D1, D4: Genre Dropdown --}}
        <div class="mb-3">
            <label for="genre_ids" class="form-label">Genres</label>
            <select name="genre_ids[]" id="genre_ids" multiple
                    class="form-select @error('genre_ids') is-invalid @enderror @error('genre_ids.*') is-invalid @enderror">
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" @selected(in_array($genre->id, (array) old('genre_ids', [])))>{{ $genre->name }}</option>
                @endforeach
            </select>
            <div class="form-text">Select one or more genres. Hold Ctrl (Windows) or Command (Mac) to choose multiple.</div>
            @error('genre_ids')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @error('genre_ids.*')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- B2, B5, D1, D3: Rating --}}
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="text" 
                   name="rating" 
                   id="rating" 
                   placeholder="e.g. 9.0/10"
                   class="form-control @error('rating') is-invalid @enderror" 
                   value="{{ old('rating') }}">
            @error('rating')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number"
                   name="year"
                   id="year"
                   min="1888"
                   max="{{ date('Y') }}"
                   class="form-control @error('year') is-invalid @enderror"
                   value="{{ old('year') }}">
            @error('year')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Poster image URL</label>
            <input type="url"
                   name="image_url"
                   id="image_url"
                   placeholder="https://example.com/movie-poster.jpg"
                   class="form-control @error('image_url') is-invalid @enderror"
                   value="{{ old('image_url') }}">
            <div class="form-text">Use a direct HTTPS link to an image you have permission to use.</div>
            @error('image_url')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="primary-action">Save movie</button>
            <a href="{{ route('movies.index') }}" class="cancel-action">Cancel</a>
        </div>
        </form>
    </div>
</section>
@endsection