// Список творців: авто-сабміт фільтрів; профіль: «поділитися». Без JS сторінки працюють (кнопка «Застосувати»).
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-cr-filters] [data-cr-auto]').forEach((select) => {
        select.addEventListener('change', () => select.form.submit());
    });

    document.querySelectorAll('[data-cr-share]').forEach((button) => {
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
