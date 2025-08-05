import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: '../public/student', // Output directory for Laravel to serve
    emptyOutDir: true,           // Clean the folder before each build
  },
  base: '/student/',             // Base path for routing and assets
  server: {
    // Optional: Enable SPA routing during development
    fs: {
      allow: ['..'],             // Allow access to parent directory (public)
    },
  },
});