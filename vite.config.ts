//import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    resolvere: {
    alias:{
        'ziggy-js': '/vendor/tightenco/ziggy/dist/index.esm.js',
    } 
},
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        // wayfinder({
        //     formVariants: true,
        // }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

    ],

      server: {
    host: 'localhost',   // Fuerza IPv4
    port: 5173,
    strictPort: true,
    hmr: {
      host: 'localhost', // Corrige las rutas del archivo HOT
    }},

});
