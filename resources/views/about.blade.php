<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About &mdash; {{ config('app.name', 'Laravel') }}</title>

        @include('partials.sentigate-theme-head')

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                :root {
                    --font-sans: 'Roboto', ui-sans-serif, system-ui, sans-serif;
                    --foreground: #1b1b18;
                    --muted: #706f6c;
                    --accent: #f53003;
                }

                body {
                    margin: 0;
                    min-height: 100vh;
                    font-family: var(--font-sans);
                    color: var(--foreground);
                    background: linear-gradient(to bottom right, #2563eb, #10b981);
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
            </style>
        @endif

        <style>
            /* Keep the shared buttons visually consistent with the Home theme. */
            body.sg-page .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                margin: 0;
                padding: 0.75rem 1.5rem;
                border: 1px solid transparent;
                border-radius: 9999px;
                background: linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2));
                color: #04121a;
                font-size: 0.95rem;
                font-weight: 600;
                line-height: 1;
                text-decoration: none;
                box-shadow: 0 14px 30px -14px rgba(34, 211, 238, 0.9);
                transition: transform 0.18s ease, box-shadow 0.18s ease;
            }

            body.sg-page .button:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 45px -14px rgba(34, 211, 238, 1);
            }
        </style>
    </head>
    <body class="sg-page bg-gradient-to-br bg-linear-to-br from-[#FDFDFC] via-[#f4efec] to-[#e9dfd8] dark:from-[#0a0a0a] dark:via-[#160f0d] dark:to-[#241009] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        @include('partials.sentigate-header')

        <main class="sg-main">
            <section class="sg-card">
                <h1 class="sg-title sg-title-sm">About</h1>
                <p class="sg-lede">
                    This application is built on Laravel and serves as a small,
                    focused starting point for your next project.
                </p>

                <h2 class="sg-h2">Our mission</h2>
                <p class="sg-muted">
                    We build tools that are simple to use, reliable to operate and
                    pleasant to maintain. Every feature starts with a clear user story
                    and ships with tests.
                </p>

                <h2 class="sg-h2">Get in touch</h2>
                <p class="sg-muted">
                    Have a question or an idea? Open an issue on
                    <a class="sg-link" href="https://github.com/laravel/laravel" target="_blank" rel="noopener">GitHub</a>
                    or use our contact form.
                </p>

                <div class="sg-actions">
                    <a href="{{ route('contact.create') }}" class="button">Contact us</a>
                    <a href="{{ url('/') }}" class="button">Get started</a>
                </div>
            </section>
        </main>

        @include('partials.sentigate-scripts')
    </body>
</html>
