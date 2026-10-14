@php
    $navLinkBase = 'nav-link inline-flex items-center justify-center';
    $navItems = [
        ['label' => 'Home', 'url' => route('home'), 'pattern' => 'home'],
        ['label' => 'About', 'url' => url('/about'), 'pattern' => 'about'],
        ['label' => 'Contact', 'url' => route('contact.create'), 'pattern' => 'contact.create'],
        ['label' => 'Registration', 'url' => route('register.create'), 'pattern' => 'register.create', 'class' => 'nav-link nav-link-register'],
    ];
@endphp
<header class="sg-header">
    <nav class="main-nav flex flex-wrap items-center justify-center gap-3" aria-label="Main navigation">
        <button
            type="button"
            id="nav-toggle"
            class="nav-toggle"
            aria-expanded="false"
            aria-controls="primary-menu"
            aria-label="Open navigation menu"
        >
            <span class="nav-toggle-bar" aria-hidden="true"></span>
            <span class="nav-toggle-bar" aria-hidden="true"></span>
            <span class="nav-toggle-bar" aria-hidden="true"></span>
        </button>
        <div id="primary-menu" class="nav-menu">
            @foreach ($navItems as $item)
                @php($isActive = request()->routeIs($item['pattern']))
                <a
                    href="{{ $item['url'] }}"
                    @if ($isActive) aria-current="page" @endif
                    class="{{ $item['class'] ?? $navLinkBase }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            <button
                type="button"
                id="theme-toggle"
                class="theme-toggle"
                aria-pressed="false"
                aria-label="Switch to light theme"
                title="Toggle dark or light theme"
            >
                <svg class="theme-toggle-icon theme-toggle-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z" />
                </svg>
                <svg class="theme-toggle-icon theme-toggle-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                </svg>
                <span class="theme-toggle-text">Theme</span>
            </button>
            <a
                href="{{ route('login') }}"
                @if (request()->routeIs('login')) aria-current="page" @endif
                class="nav-link nav-link-login"
            >
                Login
            </a>
        </div>
    </nav>
</header>
