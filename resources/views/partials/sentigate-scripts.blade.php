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
