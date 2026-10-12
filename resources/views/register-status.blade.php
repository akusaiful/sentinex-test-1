<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registration status &mdash; {{ config('app.name', 'Laravel') }}</title>

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
                font-size: clamp(2.75rem, 8vw, 5rem);
                font-weight: 600;
                line-height: 1;
                letter-spacing: -0.03em;
                background: linear-gradient(100deg, #e0f2fe, #a5b4fc 55%, #f0abfc);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .sg-title-sm {
                font-size: clamp(2rem, 6vw, 2.75rem);
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

            .sg-field {
                display: flex;
                flex-direction: column;
                margin-top: 1.25rem;
            }

            .sg-label {
                margin-bottom: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: #cbd5e1;
            }

            .sg-input {
                padding: 0.625rem 0.75rem;
                border: 1px solid var(--sg-border);
                border-radius: 0.75rem;
                background: rgba(255, 255, 255, 0.04);
                color: var(--sg-text);
                font-size: 0.9375rem;
                font-family: inherit;
                transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
            }

            .sg-input::placeholder {
                color: var(--sg-muted);
            }

            .sg-input:focus {
                outline: none;
                border-color: var(--sg-accent);
                background: rgba(255, 255, 255, 0.06);
                box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.2);
            }

            .sg-error {
                margin-top: 0.375rem;
                font-size: 0.8125rem;
                color: #fca5a5;
            }

            .sg-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-top: 1.75rem;
            }

            .sg-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                border: 1px solid transparent;
                border-radius: 9999px;
                font-size: 0.95rem;
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

            .sg-result {
                display: flex;
                align-items: flex-start;
                gap: 0.875rem;
                margin-top: 1.5rem;
                padding: 1rem 1.125rem;
                border: 1px solid var(--sg-border);
                border-radius: 0.875rem;
                background: rgba(255, 255, 255, 0.04);
            }

            .sg-result-icon {
                display: inline-flex;
                flex: none;
                align-items: center;
                justify-content: center;
                width: 2.25rem;
                height: 2.25rem;
                border-radius: 9999px;
            }

            .sg-result-icon svg {
                width: 1.25rem;
                height: 1.25rem;
            }

            .sg-result-title {
                margin: 0;
                font-size: 1rem;
                font-weight: 600;
                color: var(--sg-text);
            }

            .sg-result-text {
                margin: 0.25rem 0 0;
                font-size: 0.875rem;
                line-height: 1.4;
                color: var(--sg-muted);
            }

            .sg-result-badge {
                display: inline-flex;
                align-items: center;
                margin-top: 0.5rem;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .sg-result-pending {
                border-color: rgba(251, 191, 36, 0.4);
                background: rgba(251, 191, 36, 0.1);
            }

            .sg-result-pending .sg-result-icon {
                background: rgba(251, 191, 36, 0.15);
                color: #fcd34d;
            }

            .sg-result-pending .sg-result-badge {
                background: rgba(251, 191, 36, 0.18);
                color: #fcd34d;
            }

            .sg-result-approved {
                border-color: rgba(52, 211, 153, 0.4);
                background: rgba(52, 211, 153, 0.1);
            }

            .sg-result-approved .sg-result-icon {
                background: rgba(52, 211, 153, 0.15);
                color: #6ee7b7;
            }

            .sg-result-approved .sg-result-badge {
                background: rgba(52, 211, 153, 0.18);
                color: #6ee7b7;
            }

            .sg-result-rejected {
                border-color: rgba(248, 113, 113, 0.4);
                background: rgba(248, 113, 113, 0.1);
            }

            .sg-result-rejected .sg-result-icon {
                background: rgba(248, 113, 113, 0.15);
                color: #fca5a5;
            }

            .sg-result-rejected .sg-result-badge {
                background: rgba(248, 113, 113, 0.18);
                color: #fca5a5;
            }

            .sg-result-missing {
                border-color: rgba(148, 163, 184, 0.4);
                background: rgba(148, 163, 184, 0.08);
            }

            .sg-result-missing .sg-result-icon {
                background: rgba(148, 163, 184, 0.15);
                color: #cbd5e1;
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
        </header>

        <main class="sg-main">
            <section class="sg-card">
                <h1 class="sg-title sg-title-sm">Check registration status</h1>
                <p class="sg-lede">Enter the email address you registered with to see whether your account is pending, approved, or rejected.</p>

                <form id="status-form" method="POST" action="{{ route('register.status.check') }}">
                    @csrf

                    <div class="sg-field">
                        <label class="sg-label" for="email">Email</label>
                        <input class="sg-input" id="email" type="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="you@example.com" required>
                        @error('email')
                            <span class="sg-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="sg-actions">
                        <button type="submit" class="sg-btn sg-btn-primary">Check status</button>
                    </div>
                </form>

                @if (! empty($checked))
                    @if ($user === null)
                        <div class="sg-result sg-result-missing" role="status" data-status-result="not-found">
                            <span class="sg-result-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="7" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                            </span>
                            <div>
                                <p class="sg-result-title">No registration found</p>
                                <p class="sg-result-text">We could not find a registration for {{ $email }}. Please double-check the email address or register a new account.</p>
                            </div>
                        </div>
                    @else
                        @php
                            $status = $user->status;
                            $known = in_array($status, ['pending', 'approved', 'rejected'], true);
                            $modifier = $known ? $status : 'pending';
                            $labels = [
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ];
                            $messages = [
                                'pending' => 'Your registration is awaiting review by an administrator.',
                                'approved' => 'Your registration has been approved. You can log in now.',
                                'rejected' => 'Your registration was reviewed and rejected. Please contact support if you think this is a mistake.',
                            ];
                            $label = $labels[$status] ?? ucfirst($status);
                            $message = $messages[$status] ?? 'Your registration status is: '.$label.'.';
                        @endphp

                        <div class="sg-result sg-result-{{ $modifier }}" role="status" data-status-result="{{ $status }}">
                            <span class="sg-result-icon" aria-hidden="true">
                                @if ($status === 'approved')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>
                                @elseif ($status === 'rejected')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="m15 9-6 6" />
                                        <path d="m9 9 6 6" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 2" />
                                    </svg>
                                @endif
                            </span>
                            <div>
                                <p class="sg-result-title">{{ $user->name }}</p>
                                <span class="sg-result-badge">{{ $label }}</span>
                                <p class="sg-result-text">{{ $message }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </section>
        </main>
    </body>
</html>
