import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // Plugin Tailwind tetap diperlukan

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/home.css', 
                'resources/js/home.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
