<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies I Like</title>
    <style>
        :root {
            color: #f7f4ed;
            background: #171a1f;
            font-family: Georgia, 'Times New Roman', serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top right, #51402b, transparent 38%), #171a1f;
        }

        main {
            width: min(960px, calc(100% - 2rem));
            margin: 0 auto;
            padding: 5rem 0;
        }

        .eyebrow {
            margin: 0 0 0.75rem;
            color: #e3ae50;
            font: 600 0.8rem/1.2 Arial, sans-serif;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        h1 {
            max-width: 650px;
            margin: 0;
            font-size: clamp(2.6rem, 7vw, 5.5rem);
            font-weight: 400;
            line-height: 0.98;
        }

        .intro {
            max-width: 570px;
            margin: 1.5rem 0 3rem;
            color: #c6c1b7;
            font: 1.05rem/1.6 Arial, sans-serif;
        }

        .movie-list {
            overflow: hidden;
            border: 1px solid #514d46;
            border-radius: 8px;
            background: rgba(28, 31, 36, 0.88);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td { padding: 1.2rem 1.5rem; }

        th {
            color: #e3ae50;
            border-bottom: 1px solid #514d46;
            font: 600 0.75rem/1.2 Arial, sans-serif;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        td {
            border-bottom: 1px solid #373a3e;
            font-size: 1.1rem;
        }

        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #252a30; }
        td:last-child { color: #f0c46b; font-weight: 700; }

        footer {
            margin-top: 2rem;
            color: #8f8b83;
            font: 0.85rem Arial, sans-serif;
        }

        @media (max-width: 560px) {
            main { padding: 3rem 0; }
            th, td { padding: 1rem; }
            td { font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <main>
        <p class="eyebrow">A personal watchlist</p>
        <h1>Movies I Like</h1>
        <p class="intro">Five films that stay with me long after the credits roll.</p>

        <section class="movie-list" aria-labelledby="movie-list-title">
            <h2 id="movie-list-title" style="position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0);">Movie list</h2>
            <table>
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                        <tr>
                            <td>{{ $movie->title }}</td>
                            <td>{{ $movie->genres->pluck('name')->join(', ') }}</td>
                            <td>{{ $movie->rating }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <footer>Created by Ivann Rei M. delantar</footer>
    </main>
</body>
</html>