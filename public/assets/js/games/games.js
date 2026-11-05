// Сторінки ігор: автосабміт фільтрів, трейлер за кліком, лайтбокс скріншотів, підсвічування розділу.
// Без JS каталог працює (кнопка «Шукати»), навігація-якорі теж; JS лише покращує досвід.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-gm-filters] [data-gm-auto]').forEach((select) => {
        select.addEventListener('change', () => select.form.submit());
    });

    // Ряд жанрів: затемнення країв, кнопки, перетягування мишею, активний чіп — у видимій області.
    document.querySelectorAll('[data-gm-chips]').forEach((wrap) => {
        const rail = wrap.querySelector('[data-gm-rail]');
        const step = () => Math.max(160, rail.clientWidth * 0.7);

        const update = () => {
            wrap.classList.toggle('can-prev', rail.scrollLeft > 4);
            wrap.classList.toggle('can-next', rail.scrollLeft + rail.clientWidth < rail.scrollWidth - 4);
        };

        wrap.querySelector('[data-gm-chips-prev]')?.addEventListener('click', () => rail.scrollBy({ left: -step(), behavior: 'smooth' }));
        wrap.querySelector('[data-gm-chips-next]')?.addEventListener('click', () => rail.scrollBy({ left: step(), behavior: 'smooth' }));
        rail.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);

        const active = rail.querySelector('.is-active');

        if (active) {
            rail.scrollLeft = Math.max(0, active.offsetLeft - (rail.clientWidth - active.offsetWidth) / 2);
        }

        let startX = 0;
        let startLeft = 0;
        let dragging = false;
        let moved = false;

        rail.addEventListener('pointerdown', (event) => {
            if (event.pointerType !== 'mouse' || event.button !== 0) {
                return;
            }

            dragging = true;
            moved = false;
            startX = event.clientX;
            startLeft = rail.scrollLeft;
        });

        window.addEventListener('pointermove', (event) => {
            if (!dragging) {
                return;
            }

            const delta = event.clientX - startX;

            if (!moved && Math.abs(delta) > 5) {
                moved = true;
                rail.classList.add('is-dragging');
            }

            if (moved) {
                rail.scrollLeft = startLeft - delta;
            }
        });

        const stop = () => {
            dragging = false;
            // Знімаємо клас із затримкою, щоб клік після перетягування не відкрив жанр.
            setTimeout(() => rail.classList.remove('is-dragging'), 0);
        };

        window.addEventListener('pointerup', stop);
        window.addEventListener('pointercancel', stop);

        update();
    });

    document.querySelectorAll('[data-gm-trailer]').forEach((box) => {
        const id = box.dataset.gmTrailer;

        box.querySelector('button')?.addEventListener('click', () => {
            const frame = document.createElement('iframe');
            frame.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(id)}?autoplay=1&rel=0`;
            frame.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen';
            frame.allowFullscreen = true;
            frame.title = 'Trailer';
            box.replaceChildren(frame);
        });
    });

    const box = document.querySelector('[data-gm-lightbox]');

    if (box) {
        const image = box.querySelector('img');
        const shots = [...document.querySelectorAll('[data-gm-shot]')];
        let index = 0;
        let opener = null;

        const show = (next) => {
            index = (next + shots.length) % shots.length;
            image.src = shots[index].dataset.gmShot;
        };

        const close = () => {
            box.hidden = true;
            image.src = '';
            document.body.style.overflow = '';
            opener?.focus();
        };

        shots.forEach((button, i) => {
            button.addEventListener('click', () => {
                opener = button;
                show(i);
                box.hidden = false;
                document.body.style.overflow = 'hidden';
                box.querySelector('[data-gm-close]').focus();
            });
        });

        box.querySelector('[data-gm-close]').addEventListener('click', close);
        box.querySelector('[data-gm-prev]').addEventListener('click', () => show(index - 1));
        box.querySelector('[data-gm-next]').addEventListener('click', () => show(index + 1));
        box.addEventListener('click', (event) => {
            if (event.target === box) {
                close();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (box.hidden) {
                return;
            }

            if (event.key === 'Escape') {
                close();
            } else if (event.key === 'ArrowLeft') {
                show(index - 1);
            } else if (event.key === 'ArrowRight') {
                show(index + 1);
            }
        });
    }

    const tabs = [...document.querySelectorAll('[data-gm-tab]')];

    if (tabs.length && 'IntersectionObserver' in window) {
        const sections = tabs.map((tab) => document.getElementById(tab.dataset.gmTab)).filter(Boolean);

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    tabs.forEach((tab) => tab.classList.toggle('is-active', tab.dataset.gmTab === entry.target.id));
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

        sections.forEach((section) => observer.observe(section));
    }
});
