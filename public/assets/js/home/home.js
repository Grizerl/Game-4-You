// Головна: відео-hero (повага до reduced-motion/Save-Data), вкладки, лічильники, поява секцій, підсвічування.
// Без JS сторінка повністю доступна: усе видно, відео грає як звичайний беззвучний луп.
document.addEventListener('DOMContentLoaded', () => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const saveData = Boolean(navigator.connection && navigator.connection.saveData);

    // ---- відео ----
    const video = document.querySelector('[data-hm-video]');

    if (video) {
        if (reduceMotion || saveData) {
            // Лише постер: не завантажуємо й не відтворюємо відео.
            video.removeAttribute('autoplay');
            video.preload = 'none';
            video.pause();
        } else {
            video.play().catch(() => {});
        }
    }

    // ---- підсвічування за курсором у hero ----
    const hero = document.querySelector('[data-hm-hero]');
    const glow = document.querySelector('[data-hm-glow]');

    if (hero && glow && !reduceMotion && window.matchMedia('(pointer: fine)').matches) {
        hero.addEventListener('pointermove', (event) => {
            const box = hero.getBoundingClientRect();
            glow.style.setProperty('--mx', `${event.clientX - box.left}px`);
            glow.style.setProperty('--my', `${event.clientY - box.top}px`);
        });
    }

    // ---- вкладки «Нові / Топ» ----
    const tabs = [...document.querySelectorAll('[data-hm-tab]')];
    const panels = [...document.querySelectorAll('[data-hm-panel]')];

    const selectTab = (name, focus = false) => {
        tabs.forEach((tab) => {
            const active = tab.dataset.hmTab === name;
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
            tab.tabIndex = active ? 0 : -1;

            if (active && focus) {
                tab.focus();
            }
        });

        panels.forEach((panel) => {
            const active = panel.dataset.hmPanel === name;
            panel.classList.toggle('is-active', active);

            if (active) {
                panel.classList.add('is-visible');
            }
        });
    };

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => selectTab(tab.dataset.hmTab));
        tab.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
                const next = tabs[(index + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length];
                selectTab(next.dataset.hmTab, true);
            }
        });
    });

    // ---- лічильники ----
    const animateCount = (element) => {
        const target = parseInt(element.dataset.hmCount, 10);

        if (Number.isNaN(target) || reduceMotion || target < 2) {
            return;
        }

        const duration = 1400;
        const start = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            element.textContent = Math.round(target * eased).toString();

            if (progress < 1) {
                requestAnimationFrame(tick);
            }
        };

        element.textContent = '0';
        requestAnimationFrame(tick);
    };

    // ---- поява секцій і запуск лічильників ----
    const revealItems = [...document.querySelectorAll('.hm-reveal')];
    const counters = [...document.querySelectorAll('[data-hm-count]')];

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

    revealItems.forEach((item) => revealObserver.observe(item));

    const countObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                animateCount(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.6 });

    counters.forEach((counter) => countObserver.observe(counter));
});
