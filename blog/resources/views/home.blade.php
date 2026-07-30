<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Blog') }}</title>
        <style>
            :root {
                color-scheme: light;
            }

            body {
                margin: 0;
                min-height: 100vh;
                display: grid;
                place-items: center;
                font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
                background: #f6f7f9;
                color: #111827;
            }

            main {
                width: min(100% - 2rem, 32rem);
            }

            h1 {
                margin: 0 0 0.5rem;
                font-size: 1.75rem;
                font-weight: 650;
            }

            p {
                margin: 0 0 1.5rem;
                color: #4b5563;
                line-height: 1.5;
            }

            ul {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 0.75rem;
            }

            a {
                display: block;
                padding: 0.9rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.75rem;
                background: #fff;
                color: #111827;
                text-decoration: none;
            }

            a:hover {
                border-color: #9ca3af;
            }

            span {
                display: block;
                margin-top: 0.25rem;
                color: #6b7280;
                font-size: 0.875rem;
            }
        </style>
    </head>
    <body>
        <main>
            <h1>{{ config('app.name', 'Blog') }}</h1>
            <p>API and admin panel for the Blog mobile app.</p>
            <ul>
                <li>
                    <a href="{{ url('/admin') }}">
                        Admin panel
                        <span>/admin</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/docs/api') }}">
                        API documentation
                        <span>/docs/api</span>
                    </a>
                </li>
            </ul>
        </main>
    </body>
</html>
