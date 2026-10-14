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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet" />

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

    .sg-title-sm {
        font-size: clamp(2rem, 6vw, 2.75rem);
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
        padding: 2rem;
        background: linear-gradient(160deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 40px 90px -60px rgba(34, 211, 238, 0.7);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
    }

    .sg-h2 {
        margin: 2rem 0 0.5rem;
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

    .sg-status {
        margin: 1.5rem 0 0;
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

    @media (min-width: 768px) {
        .sg-hero {
            padding: 4rem 3rem;
        }

        .sg-grid {
            grid-template-columns: 1.15fr 0.85fr;
            gap: 1.5rem;
        }

        .sg-card {
            padding: 2.5rem;
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

    html[data-theme='light'] .sg-card {
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

    html[data-theme='light'] .sg-label {
        color: #334155;
    }

    html[data-theme='light'] .sg-input {
        background: rgba(255, 255, 255, 0.85);
        color: #10152a;
    }

    html[data-theme='light'] .sg-status {
        color: #0e7490;
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
        transition: transform 0.25s ease, opacity 0.2s ease;
    }

    .nav-toggle[aria-expanded='true'] .nav-toggle-bar:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }

    .nav-toggle[aria-expanded='true'] .nav-toggle-bar:nth-child(2) {
        opacity: 0;
    }

    .nav-toggle[aria-expanded='true'] .nav-toggle-bar:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }

    .nav-menu {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    @media (max-width: 767px) {
        .sg-header {
            /* Keep the off-canvas panel above the page content. */
            z-index: 80;
        }

        body.sg-page .main-nav {
            justify-content: space-between;
            /* Drop the ancestor backdrop-filter so the off-canvas panel
               can be positioned relative to the viewport. */
            -webkit-backdrop-filter: none;
            backdrop-filter: none;
        }

        .nav-toggle {
            display: inline-flex;
            order: 1;
            position: relative;
            z-index: 70;
        }

        .theme-toggle {
            /* The toggle now lives inside the off-canvas drawer. */
            z-index: 70;
        }

        /* Off-canvas panel: hidden off-screen to the left by default. */
        .nav-menu {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 60;
            display: none;
            flex-direction: column;
            flex-wrap: nowrap;
            align-items: stretch;
            justify-content: flex-start;
            width: min(82vw, 20rem);
            height: 100dvh;
            gap: 0.75rem;
            margin: 0;
            padding: 5rem 1.25rem 1.5rem;
            overflow-y: auto;
            border: none;
            border-right: 1px solid var(--sg-border);
            border-radius: 0;
            background: rgba(5, 8, 22, 0.94);
            -webkit-backdrop-filter: blur(16px);
            backdrop-filter: blur(16px);
            box-shadow: 0 30px 80px -40px rgba(0, 0, 0, 0.9);
            transform: translateX(-100%);
            transition: transform 0.3s ease, display 0.3s ease allow-discrete;
        }

        /* Open state: rendered, then slid into place with a smooth transition. */
        .nav-menu.is-open {
            display: flex;
            transform: translateX(0);
        }

        @starting-style {
            .nav-menu.is-open {
                transform: translateX(-100%);
            }
        }

        /* Plain stacked vertical nav: drop all box/border/button chrome. */
        body.sg-page .nav-menu .nav-link {
            width: 100%;
            justify-content: flex-start;
            padding: 0.7rem 0.25rem;
            border: none;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            text-align: left;
            font-size: 1rem;
            color: #e2e8f5;
        }

        body.sg-page .nav-menu .nav-link:hover,
        body.sg-page .nav-menu .nav-link:focus-visible {
            color: #ffffff;
            border-color: transparent;
            background: transparent;
            box-shadow: none;
        }

        body.sg-page .nav-menu .nav-link[aria-current='page'] {
            color: #67e8f9;
            border: none;
            background: none;
            box-shadow: none;
        }

        /* The theme toggle lives inside the drawer and reads as a plain item. */
        body.sg-page .theme-toggle {
            width: 100%;
            justify-content: flex-start;
            text-align: left;
            padding: 0.7rem 0.25rem;
            border: none;
            border-radius: 0;
            background: transparent;
            color: #e2e8f5;
            font-size: 1rem;
        }

        body.sg-page .theme-toggle:hover,
        body.sg-page .theme-toggle:focus-visible {
            border-color: transparent;
            background: transparent;
            color: #ffffff;
        }

        html[data-theme='light'] body.sg-page .nav-menu {
            background: rgba(255, 255, 255, 0.96);
            border-right-color: rgba(15, 23, 42, 0.12);
            box-shadow: 0 30px 80px -40px rgba(15, 23, 42, 0.35);
        }

        html[data-theme='light'] body.sg-page .nav-menu .nav-link {
            color: #1e293b;
        }

        html[data-theme='light'] body.sg-page .nav-menu .nav-link:hover,
        html[data-theme='light'] body.sg-page .nav-menu .nav-link:focus-visible {
            color: #0f172a;
            background: transparent;
        }

        html[data-theme='light'] body.sg-page .nav-menu .nav-link[aria-current='page'] {
            color: #0e7490;
            background: none;
        }

        html[data-theme='light'] body.sg-page .theme-toggle {
            color: #1e293b;
        }

        html[data-theme='light'] body.sg-page .theme-toggle:hover,
        html[data-theme='light'] body.sg-page .theme-toggle:focus-visible {
            color: #0f172a;
            background: transparent;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .nav-menu {
            transition: none;
        }
    }
</style>
