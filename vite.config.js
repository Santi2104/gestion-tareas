import { fileURLToPath } from 'node:url'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            refresh: true,
        }),
        vue({
            template: { transformAssetUrls },
        }),
        quasar({
            sassVariables: fileURLToPath(new URL('./resources/js/src/css/quasar-variables.sass', import.meta.url)),
        })
    ],
});
