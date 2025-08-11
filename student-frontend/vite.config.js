import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';
//import tailwindcss from 'tailwindcss';
var __filename = fileURLToPath(import.meta.url);
var __dirname = dirname(__filename);
export default defineConfig({
    base: '/student/',
    plugins: [react()],
    build: {
        outDir: resolve(__dirname, '../public/student'),
        emptyOutDir: true,
    },
});
