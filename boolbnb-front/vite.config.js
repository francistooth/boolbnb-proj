import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue({
        template: {
            transformAssetUrls: {
                base: null,
                includeAbsolute: false,
            },
            compilerOptions: {
                isCustomElement: (tag) => tag.includes('swiper'),
            },
        },
    }),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
