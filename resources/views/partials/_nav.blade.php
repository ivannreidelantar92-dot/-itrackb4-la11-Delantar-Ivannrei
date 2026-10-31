@php
    $isFeatured = request()->routeIs('movies.featured');
    $isMovies = request()->is('movies*') && !$isFeatured;
@endphp

<nav class="site-nav" aria-label="Main navigation">
    <a class="site-nav-link {{ $isMovies ? 'active' : '' }}" href="{{ route('movies.index') }}">My collection</a>
    <a class="site-nav-link {{ $isFeatured ? 'active' : '' }}" href="{{ route('movies.featured') }}">Featured</a>
</nav>