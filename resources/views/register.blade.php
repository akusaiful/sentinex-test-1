<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register &mdash; {{ config('app.name', 'Laravel') }}</title>

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

                p {
                    line-height: 1.6;
                    color: var(--muted);
                }

                .field {
                    display: flex;
                    flex-direction: column;
                    margin-top: 1.25rem;
                }

                label {
                    margin-bottom: 0.375rem;
                    font-size: 0.875rem;
                    font-weight: 500;
                }

                input {
                    padding: 0.625rem 0.75rem;
                    border: 1px solid #e3e3e0;
                    border-radius: 0.375rem;
                    font-size: 0.9375rem;
                }

                input:focus {
                    outline: none;
                    border-color: #2563eb;
                }

                .error {
                    margin-top: 0.375rem;
                    font-size: 0.8125rem;
                    color: #dc2626;
                }

                .status {
                    margin-bottom: 1.5rem;
                    padding: 0.75rem 1rem;
                    border-radius: 0.375rem;
                    background: #ecfdf5;
                    color: #065f46;
                    font-size: 0.875rem;
                }

                .button {
                    display: inline-block;
                    margin-top: 1.5rem;
                    padding: 0.75rem 1.5rem;
                    border: 0;
                    border-radius: 0.375rem;
                    background: linear-gradient(to right, #2563eb, #10b981);
                    color: #ffffff;
                    font-size: 0.9375rem;
                    font-weight: 500;
                    text-decoration: none;
                    cursor: pointer;
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
                <h1>Create your account</h1>
                <p>Register below. New accounts are reviewed by an administrator before they can log in.</p>

                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                <form id="register-form" method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="field">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="button">Create account</button>
                </form>
            </main>
        </div>
    </body>
</html>
