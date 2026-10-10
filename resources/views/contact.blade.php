<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Contact &mdash; {{ config('app.name', 'Laravel') }}</title>

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

                [data-confirmation-modal] {
                    position: fixed;
                    inset: 0;
                    z-index: 50;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 1rem;
                    background: rgba(17, 24, 39, 0.6);
                    -webkit-backdrop-filter: blur(4px);
                    backdrop-filter: blur(4px);
                    animation: modal-backdrop-in 150ms ease-out;
                }

                [data-confirmation-modal].hidden {
                    display: none;
                }

                [data-confirmation-modal] .modal-panel {
                    width: 100%;
                    max-width: 28rem;
                    background: #ffffff;
                    border-radius: 1rem;
                    padding: 1.5rem;
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                    animation: modal-panel-in 200ms cubic-bezier(0.16, 1, 0.3, 1);
                }

                [data-confirmation-modal] .modal-header {
                    display: flex;
                    align-items: flex-start;
                    gap: 1rem;
                }

                [data-confirmation-modal] .modal-icon {
                    display: flex;
                    flex: none;
                    align-items: center;
                    justify-content: center;
                    width: 2.75rem;
                    height: 2.75rem;
                    border-radius: 9999px;
                    background: #eff6ff;
                    color: #2563eb;
                }

                [data-confirmation-modal] .modal-icon svg {
                    width: 1.5rem;
                    height: 1.5rem;
                }

                [data-confirmation-modal] .modal-title {
                    margin: 0;
                    font-size: 1.125rem;
                    line-height: 1.5rem;
                    font-weight: 600;
                    color: #111827;
                }

                [data-confirmation-modal] .modal-description {
                    margin: 0.25rem 0 0;
                    font-size: 0.875rem;
                    line-height: 1.25rem;
                    color: #6b7280;
                }

                [data-confirmation-modal] .modal-summary {
                    margin: 1.25rem 0 0;
                    padding: 0;
                    list-style: none;
                    border: 1px solid #f3f4f6;
                    border-radius: 0.75rem;
                    background: #f9fafb;
                    overflow: hidden;
                }

                [data-confirmation-modal] .modal-summary-row {
                    display: flex;
                    align-items: baseline;
                    justify-content: space-between;
                    gap: 1rem;
                    padding: 0.625rem 1rem;
                    font-size: 0.875rem;
                }

                [data-confirmation-modal] .modal-summary-row + .modal-summary-row {
                    border-top: 1px solid #f3f4f6;
                }

                [data-confirmation-modal] .modal-summary dt {
                    color: #6b7280;
                    font-weight: 500;
                }

                [data-confirmation-modal] .modal-summary dd {
                    margin: 0;
                    color: #111827;
                    font-weight: 500;
                    text-align: right;
                    word-break: break-word;
                }

                [data-confirmation-modal] .modal-actions {
                    display: flex;
                    justify-content: flex-end;
                    gap: 0.75rem;
                    margin-top: 1.5rem;
                }

                [data-confirmation-modal] .modal-cancel,
                [data-confirmation-modal] .modal-confirm {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.5rem 1rem;
                    border-radius: 0.5rem;
                    font-size: 0.875rem;
                    font-weight: 500;
                    line-height: 1.25rem;
                    cursor: pointer;
                    transition: background-color 150ms ease, border-color 150ms ease, color 150ms ease;
                }

                [data-confirmation-modal] .modal-cancel {
                    border: 1px solid #d1d5db;
                    background: #ffffff;
                    color: #374151;
                }

                [data-confirmation-modal] .modal-cancel:hover {
                    background: #f9fafb;
                }

                [data-confirmation-modal] .modal-confirm {
                    border: 1px solid transparent;
                    background: #2563eb;
                    color: #ffffff;
                    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                }

                [data-confirmation-modal] .modal-confirm:hover {
                    background: #1d4ed8;
                }

                [data-confirmation-modal] .modal-cancel:focus-visible,
                [data-confirmation-modal] .modal-confirm:focus-visible {
                    outline: 2px solid #2563eb;
                    outline-offset: 2px;
                }

                @keyframes modal-backdrop-in {
                    from {
                        opacity: 0;
                    }

                    to {
                        opacity: 1;
                    }
                }

                @keyframes modal-panel-in {
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
                    [data-confirmation-modal],
                    [data-confirmation-modal] .modal-panel {
                        animation: none;
                    }
                }
            </style>
        @endif
    </head>
    <body>
        <div class="page">
            <a href="{{ url('/') }}" class="back">&larr; Back home</a>

            <main class="card">
                <h1>Contact</h1>
                <p>Send us a message and we will get back to you.</p>

                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                <form id="contact-form" method="POST" action="{{ route('contact.store') }}">
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
                        <label for="mobile">Mobile</label>
                        <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="button">Send</button>
                </form>
            </main>
        </div>

        <div
            id="confirmation-modal"
            data-confirmation-modal
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="confirmation-modal-title"
        >
            <div class="modal-panel w-full max-w-md overflow-hidden rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-black/5">
                <div class="modal-header flex items-start gap-4">
                    <span class="modal-icon flex h-11 w-11 flex-none items-center justify-center rounded-full bg-blue-50 text-blue-600" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </span>
                    <div>
                        <h2 id="confirmation-modal-title" class="modal-title text-lg font-semibold text-gray-900">
                            Confirm your details
                        </h2>
                        <p class="modal-description mt-1 text-sm text-gray-600">
                            Please review your details before sending. Is everything correct?
                        </p>
                    </div>
                </div>

                <dl class="modal-summary mt-5 text-sm">
                    <div class="modal-summary-row">
                        <dt class="font-medium text-gray-500">Name</dt>
                        <dd class="font-medium text-gray-900" data-confirmation-summary="name"></dd>
                    </div>
                    <div class="modal-summary-row">
                        <dt class="font-medium text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-900" data-confirmation-summary="email"></dd>
                    </div>
                    <div class="modal-summary-row">
                        <dt class="font-medium text-gray-500">Mobile</dt>
                        <dd class="font-medium text-gray-900" data-confirmation-summary="mobile"></dd>
                    </div>
                </dl>

                <div class="modal-actions mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        data-confirmation-cancel
                        class="modal-cancel rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        data-confirmation-confirm
                        class="modal-confirm rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
                    >
                        Yes, send
                    </button>
                </div>
            </div>
        </div>

        <script>
            (function () {
                var form = document.getElementById('contact-form');
                var modal = document.querySelector('[data-confirmation-modal]');

                if (!form || !modal) {
                    return;
                }

                var confirmButton = modal.querySelector('[data-confirmation-confirm]');
                var cancelButton = modal.querySelector('[data-confirmation-cancel]');
                var fields = ['name', 'email', 'mobile'];
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
                    modal.classList.add('flex');
                    confirmButton.focus();
                }

                function closeModal() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }

                form.addEventListener('submit', function (event) {
                    if (confirmed) {
                        return;
                    }

                    event.preventDefault();
                    openModal();
                });

                confirmButton.addEventListener('click', function (event) {
                    event.preventDefault();

                    if (confirmed) {
                        return;
                    }

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
