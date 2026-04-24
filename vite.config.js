// vite.config.js
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    css: {
        postcss: '@/postcss.config.js',
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './frontend/resources'),
            '@/lib': path.resolve(__dirname, './frontend/resources/lib'), // for utils
        },
    },
    server: {
        watch: {
            usePolling: true,
            interval: 1000
        },
        host: true,
        port: 5173
    },
    build: {
        outDir: path.resolve(__dirname, 'frontend/web/spa'),
        emptyOutDir: true,
        rollupOptions: {
            // This is the main entry point for our Vue application.
            input: path.resolve(__dirname, 'frontend/resources/js/app.js'),
            output: {
                // This controls how the compiled files are named.
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].[hash].js',
                assetFileNames: 'css/[name].[ext]'
            }
        }
    }
});
