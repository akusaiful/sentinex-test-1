<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin approval &mdash; {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            :root {
                --sg-bg: #050816;
                --sg-text: #e8ecf8;
                --sg-muted: #9aa8bd;
                --sg-border: rgba(148, 163, 184, 0.18);
                --sg-accent: #22d3ee;
                --sg-accent-2: #818cf8;
                --sg-accent-3: #e879f9;
            }

            * {
                box-sizing: border-box;
            }

            body.sg-page {
                display: flex;
                flex-direction: column;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                padding: 1.5rem;
                font-family: 'Roboto', ui-sans-serif, system-ui, sans-serif;
                color: var(--sg-text);
                background-color: var(--sg-bg);
                background-image:
                    radial-gradient(60rem 40rem at 15% -10%, rgba(34, 211, 238, 0.18), transparent 60%),
                    radial-gradient(50rem 35rem at 95% 0%, rgba(129, 140, 248, 0.2), transparent 55%),
                    radial-gradient(40rem 40rem at 50% 120%, rgba(232, 121, 249, 0.14), transparent 60%),
                    linear-gradient(160deg, #050816 0%, #0b1030 55%, #120a2a 100%);
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
            }

            .sg-header {
                width: 100%;
                max-width: 42rem;
                margin: 0 auto 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                position: relative;
                z-index: 2;
            }

            .sg-main {
                width: 100%;
                max-width: 42rem;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                position: relative;
                z-index: 2;
            }

            .sg-card {
                position: relative;
                border-radius: 1.25rem;
                border: 1px solid var(--sg-border);
                padding: 2rem;
                background: linear-gradient(160deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 40px 90px -60px rgba(34, 211, 238, 0.7);
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
            }

            .sg-title {
                position: relative;
                z-index: 1;
                margin: 0;
                font-size: clamp(2rem, 6vw, 2.75rem);
                font-weight: 600;
                line-height: 1;
                letter-spacing: -0.03em;
                background: linear-gradient(100deg, #e0f2fe, #a5b4fc 55%, #f0abfc);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .sg-lede {
                margin: 1rem 0 0;
                font-size: 1rem;
                line-height: 1.6;
                color: var(--sg-muted);
            }

            .sg-list {
                list-style: none;
                margin: 1.5rem 0 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .sg-list-item {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
                padding: 0.875rem 1rem;
                border: 1px solid var(--sg-border);
                border-radius: 0.75rem;
                background: rgba(255, 255, 255, 0.04);
            }

            .sg-list-name {
                font-weight: 600;
            }

            .sg-list-email {
                font-size: 0.875rem;
                color: var(--sg-muted);
            }

            .sg-empty {
                margin-top: 1.5rem;
                padding: 0.75rem 1rem;
                border: 1px solid rgba(34, 211, 238, 0.35);
                border-radius: 0.75rem;
                background: rgba(34, 211, 238, 0.1);
                color: #a5f3fc;
                font-size: 0.875rem;
            }

            .sg-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.5rem 1.125rem;
                border: 1px solid transparent;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 600;
                line-height: 1;
                text-decoration: none;
                cursor: pointer;
            }

            .sg-btn-ghost {
                color: #e2e8f5;
                border-color: rgba(148, 163, 184, 0.35);
                background: rgba(255, 255, 255, 0.03);
            }

            .sg-btn-ghost:hover {
                color: #ffffff;
                border-color: rgba(34, 211, 238, 0.6);
                background: rgba(34, 211, 238, 0.08);
            }

            .sg-link {
                color: #67e8f9;
                font-weight: 600;
                text-decoration: underline;
                text-underline-offset: 4px;
            }

            @media (min-width: 768px) {
                .sg-card {
                    padding: 2.5rem;
                }
            }
        </style>
    </head>
    <body class="sg-page">
        <header class="sg-header">
            <a href="{{ url('/') }}" class="sg-link">&larr; Back home</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="sg-btn sg-btn-ghost">Log out</button>
            </form>
        </header>

        <main class="sg-main">
            <section class="sg-card">
                <h1 class="sg-title">Admin approval</h1>
                <p class="sg-lede">Review the accounts below that are awaiting approval.</p>

                @if ($pending->isEmpty())
                    <div class="sg-empty">There are no accounts awaiting approval.</div>
                @else
                    <ul class="sg-list">
                        @foreach ($pending as $user)
                            <li class="sg-list-item" data-pending-user="{{ $user->email }}">
                                <span class="sg-list-name">{{ $user->name }}</span>
                                <span class="sg-list-email">{{ $user->email }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </main>
    </body>
</html>
