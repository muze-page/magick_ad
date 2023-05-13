import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: "index.js", // 打包的文件名
        chunkFileNames: "[name].js", // 代码分割后的文件名
        assetFileNames: "[name][extname]", // 资源文件的文件名
      },
    },
  },
});
