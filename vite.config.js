import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/navbar.css',
                'resources/css/pages/welcome.css',
                'resources/css/normalize.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
