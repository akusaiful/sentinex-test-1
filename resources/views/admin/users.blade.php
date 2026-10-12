<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pending users &mdash; {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

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
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
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
                max-width: 52rem;
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
                max-width: 52rem;
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

            .sg-status {
                margin-top: 1.5rem;
                padding: 0.75rem 1rem;
                border: 1px solid rgba(34, 211, 238, 0.35);
                border-radius: 0.75rem;
                background: rgba(34, 211, 238, 0.1);
                color: #a5f3fc;
                font-size: 0.875rem;
            }

            .sg-empty {
                margin-top: 1.5rem;
                padding: 1.5rem;
                border: 1px dashed var(--sg-border);
                border-radius: 0.75rem;
                color: var(--sg-muted);
                text-align: center;
            }

            .sg-table {
                width: 100%;
                margin-top: 1.5rem;
                border-collapse: collapse;
                font-size: 0.9375rem;
            }

            .sg-table th,
            .sg-table td {
                padding: 0.75rem 0.5rem;
                text-align: left;
                border-bottom: 1px solid var(--sg-border);
                vertical-align: middle;
            }

            .sg-table th {
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: var(--sg-muted);
            }

            .sg-table tbody tr:last-child td {
                border-bottom: none;
            }

            .sg-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
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
                transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease,
                    border-color 0.18s ease, color 0.18s ease;
            }

            .sg-btn:focus-visible {
                outline: 2px solid #67e8f9;
                outline-offset: 3px;
            }

            .sg-btn-primary {
                color: #04121a;
                background: linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2));
                box-shadow: 0 14px 30px -14px rgba(34, 211, 238, 0.9);
            }

            .sg-btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 45px -14px rgba(34, 211, 238, 1);
            }

            .sg-btn-primary:active {
                transform: translateY(0);
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

            .sg-btn-danger {
                color: #fee2e2;
                border-color: rgba(248, 113, 113, 0.45);
                background: rgba(248, 113, 113, 0.1);
            }

            .sg-btn-danger:hover {
                color: #ffffff;
                border-color: rgba(248, 113, 113, 0.75);
                background: rgba(248, 113, 113, 0.2);
            }

            .sg-link {
                color: #67e8f9;
                font-weight: 600;
                text-decoration: underline;
                text-underline-offset: 4px;
            }

            .sg-link:hover {
                color: #a5f3fc;
            }

            .sg-link:focus-visible {
                outline: 2px solid #67e8f9;
                outline-offset: 2px;
                border-radius: 2px;
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sg-btn sg-btn-ghost">Log out</button>
            </form>
        </header>

        <main class="sg-main">
            <section class="sg-card">
                <h1 class="sg-title">Pending users</h1>
                <p class="sg-lede">Review the accounts waiting for approval. Approve them to grant access, or reject them to deny it.</p>

                @if (session('status'))
                    <div class="sg-status">{{ session('status') }}</div>
                @endif

                @if ($pendingUsers->isEmpty())
                    <div class="sg-empty">There are no users awaiting approval.</div>
                @else
                    <table class="sg-table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="sg-actions">
                                            <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                                @csrf
                                                <button type="submit" class="sg-btn sg-btn-primary">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                                @csrf
                                                <button type="submit" class="sg-btn sg-btn-danger">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>
        </main>
    </body>
</html>
