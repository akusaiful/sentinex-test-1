<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About &mdash; {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                :root {
                    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                    --foreground: #1b1b18;
                    --muted: #706f6c;
                    --accent: #f53003;
                }

                * {
                    box-sizing: border-box;
                }

                body {
                    margin: 0;
                    min-height: 100vh;
                    font-family: var(--font-sans);
                    color: var(--foreground);
                    background: linear-gradient(to bottom right, #2563eb, #10b981);
                }

                .page {
                    max-width: 42rem;
                    margin: 0 auto;
                    padding: 3rem 1.5rem;
                }

                .back {
                    display: inline-block;
                    margin-bottom: 2rem;
                    font-size: 0.875rem;
                    color: #ffffff;
                    text-decoration: none;
                }

                .back:hover {
                    color: #ffffff;
                    text-decoration: underline;
                }

                .card {
                    background: #ffffff;
                    border-radius: 0.5rem;
                    padding: 2rem;
                    box-shadow: inset 0 0 0 1px rgba(26, 26, 0, 0.16);
                }

                h1 {
                    margin: 0 0 0.5rem;
                    font-size: 1.75rem;
                    font-weight: 600;
                }

                h2 {
                    margin: 2rem 0 0.5rem;
                    font-size: 1.125rem;
                    font-weight: 600;
                }

                p {
                    line-height: 1.6;
                    color: var(--muted);
                }

                a.inline {
                    color: var(--accent);
                    font-weight: 500;
                }

                .button {
                    display: inline-block;
                    margin-top: 1.5rem;
                    padding: 0.75rem 1.5rem;
                    border-radius: 0.375rem;
                    background: linear-gradient(to right, #2563eb, #10b981);
                    color: #ffffff;
                    font-weight: 500;
                    text-decoration: none;
                }

                .button:hover {
                    opacity: 0.9;
                }
            </style>
        @endif
    </head>
    <body>
        <div class="page">
            <a href="{{ url('/') }}" class="back">&larr; Back home</a>

            <main class="card">
                <h1>About</h1>
                <p>
                    This application is built on Laravel and serves as a small,
                    focused starting point for your next project.
                </p>

                <h2>Our mission</h2>
                <p>
                    We build tools that are simple to use, reliable to operate and
                    pleasant to maintain. Every feature starts with a clear user story
                    and ships with tests.
                </p>

                <h2>Get in touch</h2>
                <p>
                    Have a question or an idea? Open an issue on
                    <a class="inline" href="https://github.com/laravel/laravel" target="_blank" rel="noopener">GitHub</a>
                    or use our contact form.
                </p>

                <a href="{{ route('contact.create') }}" class="button">Contact us</a>
                <a href="{{ url('/') }}" class="button">Get started</a>
            </main>
        </div>
    </body>
</html>
