import { defineConfig } from 'vite';
import path from 'node:path';

export default defineConfig({
  root: '.',
  base: './',
  build: {
    outDir: path.resolve(__dirname, 'assets/js/dist'),
    emptyOutDir: false,
    manifest: '.vite/manifest.json',
    sourcemap: false,
    rollupOptions: {
      input: path.resolve(__dirname, 'assets/js/main.ts'),
      output: {
        entryFileNames: 'main.js',
        chunkFileNames: 'chunks/[name].js',
        assetFileNames: 'assets/[name][extname]'
      }
    }
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'assets/js')
    }
  }
});