@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4">Add New Movie</h2>

    {{-- B3: POST method at route name sa action --}}
    <form method="POST" action="{{ route('movies.store') }}">
        
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
            <label for="genre" class="form-label">Genre</label>
            <select name="genre" id="genre" class="form-select @error('genre') is-invalid @enderror">
                <option value="">-- Select Genre --</option>
                <option value="Action" @selected(old('genre') == 'Action')>Action</option>
                <option value="Animation" @selected(old('genre') == 'Animation')>Animation</option>
                <option value="Comedy" @selected(old('genre') == 'Comedy')>Comedy</option>
                <option value="Drama" @selected(old('genre') == 'Drama')>Drama</option>
                <option value="Science Fiction" @selected(old('genre') == 'Science Fiction')>Science Fiction</option>
            </select>
            @error('genre')
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

        <button type="submit" class="btn btn-primary">Save Movie</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection