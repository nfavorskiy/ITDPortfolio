import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // 👈 Makes Vite accessible outside the container
        port: 5173,      // 👈 Must match the port you expose in Docker
        strictPort: true,
        hmr: {
            host: 'localhost', // 👈 Use your local host for HMR client connection
            port: 5173,
        },
        watch: {
            usePolling: true,
            interval: 1000, // milliseconds
        },
    },
    build: {
        sourcemap: false,
    }
});
