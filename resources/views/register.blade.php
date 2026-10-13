<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register &mdash; {{ config('app.name', 'Laravel') }}</title>

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

            .sg-modal {
                position: fixed;
                inset: 0;
                z-index: 50;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                background: rgba(5, 8, 22, 0.72);
                -webkit-backdrop-filter: blur(6px);
                backdrop-filter: blur(6px);
                animation: sg-modal-backdrop-in 150ms ease-out;
            }

            .sg-modal.hidden {
                display: none;
            }

            .sg-modal-panel {
                width: 100%;
                max-width: 28rem;
                padding: 1.5rem;
                border: 1px solid var(--sg-border);
                border-radius: 1.25rem;
                background: linear-gradient(160deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 40px 90px -50px rgba(34, 211, 238, 0.8);
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
                animation: sg-modal-panel-in 200ms cubic-bezier(0.16, 1, 0.3, 1);
            }

            .sg-modal-header {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
            }

            .sg-modal-icon {
                display: flex;
                flex: none;
                align-items: center;
                justify-content: center;
                width: 2.75rem;
                height: 2.75rem;
                border-radius: 9999px;
                background: rgba(34, 211, 238, 0.12);
                color: var(--sg-accent);
            }

            .sg-modal-icon svg {
                width: 1.5rem;
                height: 1.5rem;
            }

            .sg-modal-title {
                margin: 0;
                font-size: 1.125rem;
                line-height: 1.5rem;
                font-weight: 600;
                color: var(--sg-text);
            }

            .sg-modal-description {
                margin: 0.25rem 0 0;
                font-size: 0.875rem;
                line-height: 1.35rem;
                color: var(--sg-muted);
            }

            .sg-modal-summary {
                margin: 1.25rem 0 0;
                padding: 0;
                list-style: none;
                border: 1px solid var(--sg-border);
                border-radius: 0.75rem;
                background: rgba(255, 255, 255, 0.03);
                overflow: hidden;
            }

            .sg-modal-summary-row {
                display: flex;
                align-items: baseline;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.625rem 1rem;
                font-size: 0.875rem;
            }

            .sg-modal-summary-row + .sg-modal-summary-row {
                border-top: 1px solid var(--sg-border);
            }

            .sg-modal-summary dt {
                color: var(--sg-muted);
                font-weight: 500;
            }

            .sg-modal-summary dd {
                margin: 0;
                color: var(--sg-text);
                font-weight: 500;
                text-align: right;
                word-break: break-word;
            }

            .sg-modal-actions {
                display: flex;
                justify-content: flex-end;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-top: 1.5rem;
            }

            @keyframes sg-modal-backdrop-in {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes sg-modal-panel-in {
                from {
                    opacity: 0;
                    transform: translateY(0.5rem) scale(0.98);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .sg-modal,
                .sg-modal-panel {
                    animation: none;
                }
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
                <h1 class="sg-title sg-title-sm">Create your account</h1>
                <p class="sg-lede">Register below. New accounts are reviewed by an administrator before they can log in.</p>

                @if (session('status'))
                    <div class="sg-status">{{ session('status') }}</div>
                @endif

                <form id="register-form" method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="sg-field">
                        <label class="sg-label" for="name">Name</label>
                        <input class="sg-input" id="name" type="text" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="sg-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="sg-field">
                        <label class="sg-label" for="email">Email</label>
                        <input class="sg-input" id="email" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="sg-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="sg-field">
                        <label class="sg-label" for="password">Password</label>
                        <input class="sg-input" id="password" type="password" name="password" required>
                        @error('password')
                            <span class="sg-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="sg-field">
                        <label class="sg-label" for="password_confirmation">Confirm password</label>
                        <input class="sg-input" id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>

                    <div class="sg-actions">
                        <button type="submit" class="sg-btn sg-btn-primary">Create account</button>
                        <a href="{{ route('register.status') }}" class="sg-btn sg-btn-ghost">Check registration status</a>
                    </div>
                </form>
            </section>
        </main>

        <div
            id="confirmation-modal"
            data-confirmation-modal
            class="sg-modal hidden"
            role="dialog"
            aria-modal="true"
            aria-labelledby="confirmation-modal-title"
        >
            <div class="sg-modal-panel">
                <div class="sg-modal-header">
                    <span class="sg-modal-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </span>
                    <div>
                        <h2 id="confirmation-modal-title" class="sg-modal-title">Confirm your details</h2>
                        <p class="sg-modal-description">Please review your name and email before creating your account.</p>
                    </div>
                </div>

                <dl class="sg-modal-summary">
                    <div class="sg-modal-summary-row">
                        <dt>Name</dt>
                        <dd data-confirmation-summary="name"></dd>
                    </div>
                    <div class="sg-modal-summary-row">
                        <dt>Email</dt>
                        <dd data-confirmation-summary="email"></dd>
                    </div>
                </dl>

                <div class="sg-modal-actions">
                    <button type="button" data-confirmation-cancel class="sg-btn sg-btn-ghost">
                        Cancel
                    </button>
                    <button type="button" data-confirmation-confirm class="sg-btn sg-btn-primary">
                        Confirm &amp; create account
                    </button>
                </div>
            </div>
        </div>

        <script>
            (function () {
                var form = document.getElementById('register-form');
                var modal = document.querySelector('[data-confirmation-modal]');

                if (!form || !modal) {
                    return;
                }

                var confirmButton = modal.querySelector('[data-confirmation-confirm]');
                var cancelButton = modal.querySelector('[data-confirmation-cancel]');
                var fields = ['name', 'email'];
                var confirmed = false;

                function openModal() {
                    fields.forEach(function (field) {
                        var input = form.querySelector('[name="' + field + '"]');
                        var target = modal.querySelector('[data-confirmation-summary="' + field + '"]');

                        if (input && target) {
                            target.textContent = input.value;
                        }
                    });

                    modal.classList.remove('hidden');
                    confirmButton.focus();
                }

                function closeModal() {
                    modal.classList.add('hidden');
                }

                form.addEventListener('submit', function (event) {
                    if (confirmed) {
                        return;
                    }

                    event.preventDefault();
                    openModal();
                });

                confirmButton.addEventListener('click', function () {
                    confirmed = true;
                    closeModal();
                    form.submit();
                });

                cancelButton.addEventListener('click', closeModal);

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeModal();
                    }
                });
            })();
        </script>
    </body>
</html>
