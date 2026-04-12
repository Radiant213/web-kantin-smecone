import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    // Load env file based on `mode` in the current working directory.
    const env = loadEnv(mode, process.cwd(), '');
    
    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
        server: {
            host: '0.0.0.0',
            port: 5173,
            hmr: {
                host: 'localhost',
            },
        },
        build: {
            manifest: 'manifest.json',
            outDir: 'public/build',
            rollupOptions: {
                input: {
                    app: 'resources/js/app.js',
                    css: 'resources/css/app.css',
                }
            }
        },
        // Explicitly define environment variables for the frontend
        define: {
            'import.meta.env.VITE_BROADCAST_CONNECTION': JSON.stringify(env.BROADCAST_CONNECTION || 'pusher'),
            'import.meta.env.VITE_PUSHER_APP_KEY': JSON.stringify(env.PUSHER_APP_KEY || ''),
            'import.meta.env.VITE_PUSHER_APP_CLUSTER': JSON.stringify(env.PUSHER_APP_CLUSTER || ''),
            'import.meta.env.VITE_REVERB_APP_KEY': JSON.stringify(env.REVERB_APP_KEY || ''),
            'import.meta.env.VITE_REVERB_HOST': JSON.stringify(env.REVERB_HOST || ''),
            'import.meta.env.VITE_REVERB_PORT': JSON.stringify(env.REVERB_PORT || '8080'),
            'import.meta.env.VITE_REVERB_SCHEME': JSON.stringify(env.REVERB_SCHEME || 'https'),
            'import.meta.env.VITE_ECHO_DEBUG': JSON.stringify(env.VITE_ECHO_DEBUG || 'false'),
        },
    };
});
