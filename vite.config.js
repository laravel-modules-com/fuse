import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import collectModuleAssetsPaths from './vite-module-loader.js';

const paths = [
    'resources/css/app.css',
    'resources/js/app.js',
];
const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

export default defineConfig({
    plugins: [
        laravel({
            input: allPaths,
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
