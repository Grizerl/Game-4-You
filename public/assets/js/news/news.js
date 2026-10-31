// Стаття: індикатор прогресу читання та «поділитися». Без JS стаття повністю доступна.
document.addEventListener('DOMContentLoaded', () => {
    const progress = document.querySelector('[data-nw-progress]');
    const body = document.querySelector('[data-nw-body]');

    if (progress && body) {
        const update = () => {
            const box = body.getBoundingClientRect();
            const total = box.height - window.innerHeight * 0.5;
            const value = total > 0 ? Math.min(Math.max(-box.top / total, 0), 1) : 1;

            progress.style.setProperty('--p', value.toFixed(3));
        };

        update();
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
    }

    document.querySelectorAll('[data-nw-share]').forEach((button) => {
        const label = button.textContent;

        button.addEventListener('click', async () => {
            const { url, title, copied } = button.dataset;

            if (navigator.share) {
                try {
                    await navigator.share({ title, url });
                    return;
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }
                }
            }

            try {
                await navigator.clipboard.writeText(url);
            } catch (error) {
                window.prompt(title, url);
                return;
            }

            button.textContent = `✓ ${copied}`;
            setTimeout(() => { button.textContent = label; }, 2000);
        });
    });
});
