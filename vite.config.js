import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //scss files
                'resources/sass/pages/page_top.scss',
                'resources/sass/pages/page_search.scss',
                'resources/sass/pages/page_job.scss',
                'resources/sass/pages/page_apply.scss',
                'resources/sass/pages/page_apply_confirm.scss',
                'resources/sass/pages/page_apply_thanks.scss',
                'resources/sass/pages/page_favorite.scss',
                // 'resources/sass/pages/page_concier.scss',
                // 'resources/sass/pages/page_concier_confirm.scss',
                // 'resources/sass/pages/page_concier_thanks.scss',
                'resources/sass/pages/page_entry.scss',
                'resources/sass/pages/page_entry_confirm.scss',
                'resources/sass/pages/page_entry_thanks.scss',
                'resources/sass/pages/page_content.scss',

                //js files
                'resources/js/app.js',
                'resources/js/page_top.js',
                'resources/js/page_search.js',
                'resources/js/page_job.js',
                'resources/js/page_apply.js',
                'resources/js/page_apply_confirm.js',
                'resources/js/page_apply_thanks.js',
                'resources/js/page_favorite.js',
                'resources/js/page_content.js',
                'resources/js/page_entry.js',
                'resources/js/page_entry_confirm.js',
                'resources/js/page_entry_thanks.js',
                'resources/js/page_content.js',
            ],
            refresh: true,
        }),
    ],
});
