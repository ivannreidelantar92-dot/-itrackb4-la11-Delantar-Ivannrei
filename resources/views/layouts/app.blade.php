<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Movies')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet">
</head>
<body class="app-shell">
    <header class="site-header">
        <div class="container app-container">
            <div class="header-copy">
                <p class="eyebrow">MY PERSONAL COLLECTION</p>
                <h1 class="hero-title">
                    <span>Here's a movie</span>
                    <span>you might not know</span>
                    <span class="hero-title-accent">exists.</span>
                </h1>
                <p class="header-credit">A movie journal by Idward Jones</p>
            </div>
            @include('partials._nav')
        </div>
    </header>

    <main class="container app-container page-content">
        @if (session('success'))
            <div class="alert app-alert mb-4" role="status">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
