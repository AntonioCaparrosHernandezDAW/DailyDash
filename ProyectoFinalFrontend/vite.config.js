import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
  ],
  server: {
    port: 3000 // Change this to any available port
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src') // Use path.resolve for compatibility
    }
  }
})
