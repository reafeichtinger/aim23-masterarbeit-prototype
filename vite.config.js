import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import externalize from 'vite-plugin-externalize-dependencies';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        externalize({
            externals: ['ckeditor5', 'ckeditor5-premium-features'],
        }),
    ],
    server: {
        cors: true,
    },
});