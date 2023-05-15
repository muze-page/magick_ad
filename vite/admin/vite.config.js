import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
//gzip压缩
import viteCompression from "vite-plugin-compression";
// 引入rollup-plugin-visualizer模块，进行打包分析
import { visualizer } from "rollup-plugin-visualizer";

import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import { ElementPlusResolver } from "unplugin-vue-components/resolvers";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    //gzip压缩
    viteCompression({
      threshold: 500000, // 对大于 1mb 的文件进行压缩
    }),
    //体积分析
    visualizer({
      open: true, //注意这里要设置为true，否则无效
      filename: "stats.html", //分析图生成的文件名
      gzipSize: true, // 收集 gzip 大小并将其显示
      brotliSize: true, // 收集 brotli 大小并将其显示
    }),
    //自动导入
    AutoImport({
      resolvers: [ElementPlusResolver()],
    }),
    Components({
      resolvers: [ElementPlusResolver()],
    }),
  ],
  build: {
    rollupOptions: {
      //output: {
      //  entryFileNames: "index.js", // 打包的文件名
      //  chunkFileNames: "[name].js", // 代码分割后的文件名
      //  assetFileNames: "[name][extname]", // 资源文件的文件名
      //},
    },
  },
});
