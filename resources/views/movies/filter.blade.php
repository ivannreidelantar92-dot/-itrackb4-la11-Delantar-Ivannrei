@extends('layouts.app')

@section('title', 'Filter Movies')

@section('content')

    @if ($genre === null)
        <h4 class="mt-4">Genre: All</h4>
    @else
        <h4 class="mt-4">Genre: {{ $genre }}</h4>
    @endif

    <a href="{{ route('movies.filter', ['genre' => 'Action']) }}" class="btn btn-primary mb-3">View Action</a>

    <table class="table table-striped mt-4" border="1" cellpadding="8">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Director</th>
                <th>Genre</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($movies as $movie)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->director }}</td>
                    <td>{{ $movie->genres->pluck('name')->join(', ') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No movies found for this genre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <button class="btn btn-secondary">
        <a href="{{ route('movies.index') }}" class="text-decoration-none text-white">Back</a>
    </button>

@endsection