<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Sentigate') }}</title>

        <!-- Apply the persisted color theme before paint to avoid a flash -->
        <script>
            (function () {
                var theme = 'dark';

                try {
                    theme = localStorage.getItem('sg-theme') === 'light' ? 'light' : 'dark';
                } catch (e) {}

                document.documentElement.setAttribute('data-theme', theme);
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Leaflet (CDN, pinned, no build step) -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""
        />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body.bg-gradient-to-br {
                    background-image: linear-gradient(to bottom right, #FDFDFC, #f4efec, #e9dfd8);
                }

                @media (prefers-color-scheme: dark) {
                    body.bg-gradient-to-br {
                        background-image: linear-gradient(to bottom right, #0a0a0a, #160f0d, #241009);
                    }
                }

                .main-nav {
                    display: flex;
                    flex-wrap: wrap;
                    align-items: center;
                    justify-content: center;
                    gap: 0.75rem;
                }

                .nav-link {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    white-space: nowrap;
                    padding: 0.375rem 1.25rem;
                    border-width: 1px;
                    border-style: solid;
                    border-radius: 0.125rem;
                    font-size: 0.875rem;
                    line-height: 1.5;
                    text-align: center;
                }
            </style>
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
                max-width: 72rem;
                margin: 0 auto 1.5rem;
                position: relative;
                z-index: 2;
            }

            body.sg-page .main-nav {
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.4rem;
                border: 1px solid var(--sg-border);
                border-radius: 9999px;
                background: rgba(255, 255, 255, 0.04);
                -webkit-backdrop-filter: blur(12px);
                backdrop-filter: blur(12px);
                box-shadow: 0 20px 45px -30px rgba(34, 211, 238, 0.7);
            }

            body.sg-page .nav-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
                padding: 0.4rem 1.15rem;
                border: 1px solid rgba(148, 163, 184, 0.2);
                border-radius: 9999px;
                font-size: 0.875rem;
                line-height: 1.5;
                text-align: center;
                color: #cbd5e1;
                text-decoration: none;
                transition: color 0.18s ease, border-color 0.18s ease, background-color 0.18s ease,
                    box-shadow 0.18s ease;
            }

            body.sg-page .nav-link:hover {
                color: #ffffff;
                border-color: rgba(34, 211, 238, 0.6);
                background: rgba(34, 211, 238, 0.08);
            }

            body.sg-page .nav-link:focus-visible {
                outline: 2px solid var(--sg-accent);
                outline-offset: 2px;
            }

            body.sg-page .nav-link[aria-current='page'] {
                color: #04121a;
                border-color: transparent;
                background: linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2));
                box-shadow: 0 10px 25px -12px rgba(34, 211, 238, 0.9);
            }

            .sg-main {
                width: 100%;
                max-width: 72rem;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                position: relative;
                z-index: 2;
            }

            .sg-hero {
                position: relative;
                overflow: hidden;
                border-radius: 1.5rem;
                padding: 2.75rem 1.5rem;
                border: 1px solid var(--sg-border);
                background-image:
                    radial-gradient(38rem 22rem at 118% -20%, rgba(129, 140, 248, 0.38), transparent 62%),
                    radial-gradient(30rem 20rem at -12% 122%, rgba(34, 211, 238, 0.3), transparent 58%),
                    linear-gradient(150deg, #0b1030 0%, #0a0a1f 58%, #14082b 100%);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06), 0 40px 90px -55px rgba(34, 211, 238, 0.75);
            }

            .sg-hero::after {
                content: '';
                position: absolute;
                left: -20%;
                right: -20%;
                bottom: -60%;
                height: 65%;
                background: radial-gradient(closest-side, rgba(34, 211, 238, 0.35), transparent 72%);
                filter: blur(28px);
                pointer-events: none;
            }

            .sg-badge {
                position: relative;
                z-index: 1;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.35rem 0.85rem;
                border-radius: 9999px;
                border: 1px solid rgba(34, 211, 238, 0.35);
                background: rgba(34, 211, 238, 0.08);
                color: #67e8f9;
                font-size: 0.72rem;
                font-weight: 500;
                letter-spacing: 0.09em;
                text-transform: uppercase;
            }

            .sg-badge-dot {
                width: 0.4rem;
                height: 0.4rem;
                border-radius: 9999px;
                background: var(--sg-accent);
                box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.2);
            }

            .sg-title {
                position: relative;
                z-index: 1;
                margin: 0.9rem 0 0;
                font-size: clamp(2.75rem, 8vw, 5rem);
                font-weight: 600;
                line-height: 1;
                letter-spacing: -0.03em;
                background: linear-gradient(100deg, #e0f2fe, #a5b4fc 55%, #f0abfc);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .sg-lede {
                position: relative;
                z-index: 1;
                margin: 1rem 0 0;
                max-width: 36rem;
                font-size: clamp(1rem, 2.2vw, 1.2rem);
                line-height: 1.6;
                color: var(--sg-muted);
            }

            .sg-actions {
                position: relative;
                z-index: 1;
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

            .sg-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .sg-card {
                position: relative;
                border-radius: 1.25rem;
                border: 1px solid var(--sg-border);
                padding: 1.75rem;
                background: linear-gradient(160deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
            }

            .sg-h2 {
                margin: 0 0 0.5rem;
                font-size: 1.5rem;
                font-weight: 600;
                color: #f1f5fd;
                letter-spacing: -0.01em;
            }

            .sg-muted {
                margin: 0 0 1rem;
                line-height: 1.65;
                color: var(--sg-muted);
            }

            .sg-list {
                list-style: none;
                margin: 0 0 1.5rem;
                padding: 0;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .sg-list-item {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                color: #c7d2e3;
            }

            .sg-dot {
                margin-top: 0.45rem;
                width: 0.5rem;
                height: 0.5rem;
                flex: none;
                border-radius: 9999px;
                background: linear-gradient(120deg, var(--sg-accent), var(--sg-accent-2));
                box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.15);
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

            .sg-card-visual {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 16rem;
                overflow: hidden;
                background-image:
                    radial-gradient(20rem 20rem at 50% 40%, rgba(129, 140, 248, 0.35), transparent 66%),
                    linear-gradient(160deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
            }

            .sg-map {
                position: relative;
                overflow: hidden;
                border-radius: 1.25rem;
                border: 1px solid var(--sg-border);
                padding: 1.75rem;
                background-image:
                    radial-gradient(30rem 20rem at 90% -12%, rgba(34, 211, 238, 0.24), transparent 62%),
                    radial-gradient(24rem 18rem at -8% 120%, rgba(129, 140, 248, 0.22), transparent 60%),
                    linear-gradient(160deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 40px 90px -60px rgba(34, 211, 238, 0.75);
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
            }

            .sg-map-layout {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1.5rem;
                align-items: center;
            }

            .sg-map-figure {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                min-height: 12rem;
            }

            .sg-map-figure::after {
                content: '';
                position: absolute;
                inset: 12% 8%;
                background: radial-gradient(closest-side, rgba(34, 211, 238, 0.28), transparent 72%);
                filter: blur(30px);
                pointer-events: none;
            }

            .sg-map-canvas {
                position: relative;
                z-index: 1;
                width: 100%;
                min-height: 18rem;
                height: 22rem;
                border-radius: 1rem;
                overflow: hidden;
                border: 1px solid var(--sg-border);
                background: rgba(5, 8, 22, 0.65);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 30px 70px -50px rgba(34, 211, 238, 0.85);
            }

            .sg-map-canvas.leaflet-container {
                font-family: inherit;
                background: rgba(5, 8, 22, 0.65);
            }

            .sg-map-canvas .leaflet-tile-pane { filter: invert(1) hue-rotate(180deg) brightness(0.95) contrast(0.9); }

            .sg-map-canvas.leaflet-container .leaflet-control-zoom,
            .sg-map-canvas.leaflet-container .leaflet-bar {
                border: 1px solid var(--sg-border);
                border-radius: 0.6rem;
                overflow: hidden;
                box-shadow: 0 18px 40px -30px rgba(34, 211, 238, 0.9);
            }

            .sg-map-canvas.leaflet-container .leaflet-bar a,
            .sg-map-canvas.leaflet-container .leaflet-bar a:hover,
            .sg-map-canvas.leaflet-container .leaflet-bar a:focus {
                background: rgba(5, 8, 22, 0.85);
                border-bottom: 1px solid var(--sg-border);
                color: #e0f2fe;
            }

            .sg-map-canvas.leaflet-container .leaflet-bar a:hover,
            .sg-map-canvas.leaflet-container .leaflet-bar a:focus {
                background: rgba(34, 211, 238, 0.16);
                color: var(--sg-accent);
            }

            .sg-map-canvas.leaflet-container .leaflet-bar a:last-child {
                border-bottom: none;
            }

            .sg-map-canvas.leaflet-container .leaflet-control-attribution {
                background: rgba(5, 8, 22, 0.72);
                border-top-left-radius: 0.5rem;
                color: rgba(226, 232, 240, 0.72);
            }

            .sg-map-canvas.leaflet-container .leaflet-control-attribution a {
                color: var(--sg-accent);
            }

            .sg-orb {
                position: absolute;
                width: 9rem;
                height: 9rem;
                border-radius: 9999px;
                background: conic-gradient(from 140deg, var(--sg-accent), var(--sg-accent-2), var(--sg-accent-3), var(--sg-accent));
                box-shadow: 0 0 70px -6px rgba(129, 140, 248, 0.85), inset 0 0 30px rgba(5, 8, 22, 0.6);
                animation: sg-float 6s ease-in-out infinite;
            }

            .sg-orb::after {
                content: '';
                position: absolute;
                inset: 14%;
                border-radius: 9999px;
                background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.55), rgba(5, 8, 22, 0.92) 70%);
            }

            .sg-mono {
                position: relative;
                z-index: 1;
                font-size: 2.75rem;
                font-weight: 600;
                color: #e0f2fe;
                text-shadow: 0 2px 24px rgba(34, 211, 238, 0.85);
            }

            @keyframes sg-float {
                0%,
                100% {
                    transform: translateY(-6px);
                }

                50% {
                    transform: translateY(6px);
                }
            }

            @media (min-width: 768px) {
                .sg-hero {
                    padding: 4rem 3rem;
                }

                .sg-grid {
                    grid-template-columns: 1.15fr 0.85fr;
                    gap: 1.5rem;
                }

                .sg-map-layout {
                    grid-template-columns: 1.05fr 0.95fr;
                    gap: 2rem;
                }
            }

            @media (min-width: 1024px) {
                body.sg-page {
                    padding: 2rem;
                }

                .sg-hero {
                    padding: 5rem 4rem;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .sg-orb {
                    animation: none;
                }
            }

            /* Light theme (opt-in via html[data-theme='light']) */
            html[data-theme='light'] {
                --sg-bg: #f4f6fb;
                --sg-text: #10152a;
                --sg-muted: #4b5568;
                --sg-border: rgba(15, 23, 42, 0.12);
            }

            html[data-theme='light'] body.sg-page {
                color: var(--sg-text);
                background-color: var(--sg-bg);
                background-image:
                    radial-gradient(60rem 40rem at 15% -10%, rgba(34, 211, 238, 0.16), transparent 60%),
                    radial-gradient(50rem 35rem at 95% 0%, rgba(129, 140, 248, 0.18), transparent 55%),
                    radial-gradient(40rem 40rem at 50% 120%, rgba(232, 121, 249, 0.12), transparent 60%),
                    linear-gradient(160deg, #f8fafc 0%, #eef2ff 55%, #fdf4ff 100%);
            }

            html[data-theme='light'] body.bg-gradient-to-br {
                background-image: linear-gradient(to bottom right, #FDFDFC, #f4efec, #e9dfd8);
            }

            html[data-theme='light'] body.sg-page .main-nav {
                background: rgba(255, 255, 255, 0.72);
                box-shadow: 0 20px 45px -30px rgba(34, 211, 238, 0.5);
            }

            html[data-theme='light'] body.sg-page .nav-link,
            html[data-theme='light'] body.sg-page .theme-toggle,
            html[data-theme='light'] body.sg-page .nav-toggle {
                color: #334155;
            }

            html[data-theme='light'] body.sg-page .nav-link:hover,
            html[data-theme='light'] body.sg-page .theme-toggle:hover,
            html[data-theme='light'] body.sg-page .nav-toggle:hover {
                color: #0f172a;
                background: rgba(34, 211, 238, 0.12);
            }

            html[data-theme='light'] .sg-hero {
                background-image:
                    radial-gradient(38rem 22rem at 118% -20%, rgba(129, 140, 248, 0.28), transparent 62%),
                    radial-gradient(30rem 20rem at -12% 122%, rgba(34, 211, 238, 0.22), transparent 58%),
                    linear-gradient(150deg, #ffffff 0%, #eef2ff 58%, #fdf4ff 100%);
            }

            html[data-theme='light'] .sg-card,
            html[data-theme='light'] .sg-map {
                background-image:
                    radial-gradient(30rem 20rem at 90% -12%, rgba(34, 211, 238, 0.14), transparent 62%),
                    radial-gradient(24rem 18rem at -8% 120%, rgba(129, 140, 248, 0.14), transparent 60%),
                    linear-gradient(160deg, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.7));
            }

            html[data-theme='light'] .sg-title {
                background: linear-gradient(100deg, #0f172a, #4338ca 55%, #a21caf);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            html[data-theme='light'] .sg-h2 {
                color: #0f172a;
            }

            html[data-theme='light'] .sg-lede,
            html[data-theme='light'] .sg-muted {
                color: #475569;
            }

            html[data-theme='light'] .sg-list-item {
                color: #334155;
            }

            html[data-theme='light'] .sg-badge {
                color: #0e7490;
            }

            html[data-theme='light'] .sg-btn-ghost {
                color: #334155;
                border-color: rgba(15, 23, 42, 0.2);
                background: rgba(255, 255, 255, 0.6);
            }

            html[data-theme='light'] .sg-map-canvas {
                background: rgba(255, 255, 255, 0.85);
            }

            html[data-theme='light'] .sg-map-canvas .leaflet-tile-pane {
                filter: none;
            }

            /* Theme toggle button */
            .theme-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.4rem;
                white-space: nowrap;
                padding: 0.4rem 1.15rem;
                border: 1px solid rgba(148, 163, 184, 0.2);
                border-radius: 9999px;
                background: rgba(255, 255, 255, 0.04);
                color: #cbd5e1;
                font-family: inherit;
                font-size: 0.875rem;
                line-height: 1.5;
                cursor: pointer;
                transition: color 0.18s ease, border-color 0.18s ease, background-color 0.18s ease,
                    box-shadow 0.18s ease;
            }

            .theme-toggle:hover {
                color: #ffffff;
                border-color: rgba(34, 211, 238, 0.6);
                background: rgba(34, 211, 238, 0.08);
            }

            .theme-toggle:focus-visible {
                outline: 2px solid var(--sg-accent);
                outline-offset: 2px;
            }

            .theme-toggle-icon {
                display: none;
                width: 1rem;
                height: 1rem;
            }

            .theme-toggle-icon-moon {
                display: inline-block;
            }

            html[data-theme='light'] .theme-toggle-icon-moon {
                display: none;
            }

            html[data-theme='light'] .theme-toggle-icon-sun {
                display: inline-block;
            }

            /* Hamburger navigation (mobile only) */
            .nav-toggle {
                display: none;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 0.28rem;
                width: 2.5rem;
                height: 2.5rem;
                padding: 0;
                border: 1px solid rgba(148, 163, 184, 0.2);
                border-radius: 9999px;
                background: rgba(255, 255, 255, 0.04);
                color: #cbd5e1;
                cursor: pointer;
                transition: color 0.18s ease, border-color 0.18s ease, background-color 0.18s ease;
            }

            .nav-toggle:hover {
                color: #ffffff;
                border-color: rgba(34, 211, 238, 0.6);
                background: rgba(34, 211, 238, 0.08);
            }

            .nav-toggle:focus-visible {
                outline: 2px solid var(--sg-accent);
                outline-offset: 2px;
            }

            .nav-toggle-bar {
                display: block;
                width: 1.1rem;
                height: 2px;
                border-radius: 9999px;
                background: currentColor;
            }

            .nav-menu {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            @media (max-width: 767px) {
                body.sg-page .main-nav {
                    justify-content: space-between;
                }

                .nav-toggle {
                    display: inline-flex;
                    order: 1;
                }

                .theme-toggle {
                    order: 2;
                }

                .nav-menu {
                    order: 3;
                    display: none;
                    flex-direction: column;
                    align-items: stretch;
                    width: 100%;
                    gap: 0.5rem;
                    padding-top: 0.5rem;
                }

                .nav-menu.is-open {
                    display: flex;
                }

                .nav-menu .nav-link {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body class="sg-page bg-gradient-to-br bg-linear-to-br from-[#FDFDFC] via-[#f4efec] to-[#e9dfd8] dark:from-[#0a0a0a] dark:via-[#160f0d] dark:to-[#241009] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
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
                </div>
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
            </nav>
        </header>
        <main class="sg-main">
            <section class="sg-hero" aria-labelledby="hero-title">
                <span class="sg-badge">
                    <span class="sg-badge-dot" aria-hidden="true"></span>
                    Sentigate Platform
                </span>
                <h1 id="hero-title" class="sg-title">Sentigate</h1>
                <p class="sg-lede">A modern Laravel foundation for your next project.</p>
                <div class="sg-actions">
                    <a href="{{ route('contact.create') }}" class="sg-btn sg-btn-primary">Contact us</a>
                    <a href="#get-started" class="sg-btn sg-btn-ghost">Learn more</a>
                </div>
            </section>

            <section id="get-started" class="sg-grid" aria-labelledby="get-started-title">
                <div class="sg-card">
                    <h2 id="get-started-title" class="sg-h2">Let's get started</h2>
                    <p class="sg-muted">Laravel has an incredibly rich ecosystem. We suggest starting with the following.</p>
                    <ul class="sg-list">
                        <li class="sg-list-item">
                            <span class="sg-dot" aria-hidden="true"></span>
                            <span>Read the <a class="sg-link" href="https://laravel.com/docs" target="_blank" rel="noopener">Documentation</a></span>
                        </li>
                        <li class="sg-list-item">
                            <span class="sg-dot" aria-hidden="true"></span>
                            <span>Watch video tutorials at <a class="sg-link" href="https://laracasts.com" target="_blank" rel="noopener">Laracasts</a></span>
                        </li>
                    </ul>
                    <div class="sg-actions">
                        <a href="https://cloud.laravel.com" target="_blank" rel="noopener" class="sg-btn sg-btn-primary">Deploy now</a>
                        <a href="{{ route('contact.create') }}" class="sg-btn sg-btn-ghost">Contact us</a>
                    </div>
                </div>

                <div class="sg-card sg-card-visual" aria-hidden="true">
                    <div class="sg-orb"></div>
                    <span class="sg-mono">S</span>
                </div>
            </section>

            <section id="malaysia" class="sg-map" aria-labelledby="malaysia-map-heading">
                <div class="sg-map-layout">
                    <div>
                        <h2 id="malaysia-map-heading" class="sg-h2">Across Malaysia</h2>
                        <p class="sg-muted">Malaysia is made up of Peninsular Malaysia and East Malaysia on the island of Borneo, separated by the South China Sea. Kuala Lumpur is the capital city.</p>
                        <ul class="sg-list">
                            <li class="sg-list-item">
                                <span class="sg-dot" aria-hidden="true"></span>
                                <span>Peninsular Malaysia</span>
                            </li>
                            <li class="sg-list-item">
                                <span class="sg-dot" aria-hidden="true"></span>
                                <span>East Malaysia (Borneo)</span>
                            </li>
                        </ul>
                    </div>
                    <figure class="sg-map-figure">
                        <div
                            id="malaysia-map"
                            class="sg-map-canvas"
                            role="region"
                            aria-label="Interactive map of Malaysia"
                            data-map-lat="4.2"
                            data-map-lng="109"
                            data-map-zoom="6"
                        ></div>
                    </figure>
                </div>
            </section>
        </main>

        <script
            src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""
        ></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('malaysia-map');

                if (!el || typeof L === 'undefined') {
                    return;
                }

                var map = L.map(el, {
                    center: [parseFloat(el.dataset.mapLat), parseFloat(el.dataset.mapLng)],
                    zoom: parseInt(el.dataset.mapZoom, 10),
                    zoomControl: true,
                    dragging: true,
                    scrollWheelZoom: true,
                    doubleClickZoom: true,
                    boxZoom: true,
                    keyboard: true,
                    touchZoom: true,
                });

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution:
                        '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors',
                }).addTo(map);
            });
        </script>
        <script>
            (function () {
                var toggle = document.getElementById('nav-toggle');
                var menu = document.getElementById('primary-menu');

                if (!toggle || !menu) {
                    return;
                }

                function setOpen(isOpen) {
                    menu.classList.toggle('is-open', isOpen);
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    toggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
                }

                toggle.addEventListener('click', function () {
                    setOpen(!menu.classList.contains('is-open'));
                });

                menu.addEventListener('click', function (event) {
                    if (event.target.closest('a')) {
                        setOpen(false);
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        setOpen(false);
                    }
                });
            })();
        </script>
        <script>
            (function () {
                var storageKey = 'sg-theme';
                var root = document.documentElement;
                var toggle = document.getElementById('theme-toggle');

                function currentTheme() {
                    return root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
                }

                function syncToggle(theme) {
                    if (!toggle) {
                        return;
                    }

                    var isLight = theme === 'light';
                    var label = isLight ? 'Switch to dark theme' : 'Switch to light theme';

                    toggle.setAttribute('aria-pressed', isLight ? 'true' : 'false');
                    toggle.setAttribute('aria-label', label);
                    toggle.setAttribute('title', label);
                }

                function apply(theme) {
                    root.setAttribute('data-theme', theme);
                    syncToggle(theme);
                }

                syncToggle(currentTheme());

                if (toggle) {
                    toggle.addEventListener('click', function () {
                        var next = currentTheme() === 'light' ? 'dark' : 'light';

                        apply(next);

                        try {
                            localStorage.setItem(storageKey, next);
                        } catch (e) {}
                    });
                }
            })();
        </script>
    </body>
</html>
