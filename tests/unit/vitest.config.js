import { defineConfig } from 'vitest/config';

export default defineConfig({
  test: {
    globals: true,
    environment: 'jsdom',
    coverage: {
      provider: 'v8',
      reporter: ['text', 'html', 'lcov'],
      include: ['assets/js/lib/**/*.js'],
      exclude: ['**/node_modules/**', '**/tests/**']
    }
  },
  resolve: {
    alias: {
      '@': '/var/www/html/WebDev-Tools/assets/js'
    }
  }
});
