import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      // ubah folder build dari default 'build' ke 'dist'
      buildDirectory: 'dist',
    }),
  ],
})
