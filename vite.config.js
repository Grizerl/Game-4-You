import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Tailwind (Breeze: логін/профіль)
                'resources/scss/app.scss',
                'resources/js/app.js',
                // Публічний сайт
                'resources/scss/public/index.scss',
                'resources/scss/public/details.scss',
                'resources/scss/public/search.scss',
                'resources/scss/public/games.scss',
                'resources/scss/public/creators.scss',
                'resources/scss/public/companies.scss',
                'resources/scss/public/home.scss',
                'resources/scss/public/news.scss',
                // Адмінка /control
                'resources/scss/admin/admin.scss',
                'resources/scss/admin/list.scss',
                'resources/scss/admin/list-news.scss',
                'resources/scss/admin/list-category.scss',
                'resources/scss/admin/list-users.scss',
                'resources/scss/admin/form-user.scss',
                'resources/scss/admin/form-company.scss',
                'resources/scss/admin/form-creator.scss',
                'resources/scss/admin/form-game.scss',
                'resources/scss/admin/form-news.scss',
                'resources/scss/admin/category-create.scss',
                'resources/scss/admin/category-edit.scss',
                'resources/scss/admin/settings.scss',
            ],
            refresh: true,
        }),
    ],
});
