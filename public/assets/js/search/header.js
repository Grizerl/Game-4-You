/* Шторка меню в шапці: відкриття/закриття, Esc, клік по оверлею, блокування прокрутки, фокус. */
(function () {
    'use strict';

    var openBtn = document.getElementById('sh-open');
    var closeBtn = document.getElementById('sh-close');
    var drawer = document.getElementById('sh-drawer');
    var overlay = document.getElementById('sh-overlay');

    if (!openBtn || !drawer || !overlay) {
        return;
    }

    var FOCUSABLE = 'a[href], button:not([disabled])';
    var closeTimer = null;

    function isOpen() {
        return drawer.classList.contains('is-open');
    }

    function open() {
        clearTimeout(closeTimer);
        overlay.hidden = false;
        // Наступний кадр, щоб спрацював transition прозорості.
        requestAnimationFrame(function () {
            overlay.classList.add('is-open');
            drawer.classList.add('is-open');
        });
        drawer.setAttribute('aria-hidden', 'false');
        openBtn.setAttribute('aria-expanded', 'true');
        document.body.classList.add('sh-locked');
        setTimeout(function () {
            (closeBtn || drawer).focus();
        }, 60);
    }

    function close(returnFocus) {
        overlay.classList.remove('is-open');
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        openBtn.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('sh-locked');
        closeTimer = setTimeout(function () {
            overlay.hidden = true;
        }, 300);

        if (returnFocus !== false) {
            openBtn.focus();
        }
    }

    openBtn.addEventListener('click', function () {
        isOpen() ? close() : open();
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            close();
        });
    }

    overlay.addEventListener('click', function () {
        close();
    });

    // Перехід за посиланням закриває шторку (на випадок якірних посилань).
    drawer.addEventListener('click', function (event) {
        if (event.target.closest && event.target.closest('a.sh-link')) {
            close(false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!isOpen()) {
            return;
        }

        if (event.key === 'Escape') {
            close();
            return;
        }

        // Фокус не виходить зі шторки, поки вона відкрита.
        if (event.key === 'Tab') {
            var nodes = drawer.querySelectorAll(FOCUSABLE);

            if (!nodes.length) {
                return;
            }

            var first = nodes[0];
            var last = nodes[nodes.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });

    // Широкий екран → закрити, якщо шторка лишилась відкритою після повороту/зміни розміру.
    window.addEventListener('resize', function () {
        if (isOpen() && window.innerWidth < 320) {
            close(false);
        }
    });
})();

/* Пошук на мобільному: іконка в шапці показує/ховає поле під нею. */
(function () {
    'use strict';

    var toggle = document.getElementById('sh-search-toggle');
    var header = document.querySelector('.sh');
    var input = document.getElementById('hs-q-d');

    if (!toggle || !header || !input) {
        return;
    }

    function setOpen(open, focus) {
        header.classList.toggle('is-search-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', (open ? toggle.getAttribute('data-label-close') : toggle.getAttribute('data-label-open')) || '');

        if (open && focus) {
            input.focus();
        }
    }

    toggle.addEventListener('click', function () {
        setOpen(!header.classList.contains('is-search-open'), true);
    });

    input.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && window.matchMedia('(max-width: 767px)').matches) {
            setOpen(false);
            toggle.focus();
        }
    });
})();
