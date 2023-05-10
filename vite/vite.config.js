//vite.config.js
const path = require("path");

module.exports = {
  plugins: [],
  build: {
    outDir: "build",
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, "./index.js"),
      output: {
        // 指定 chunk 文件名（含导出的代码）
        //chunkFileNames: "js/[name].js",
        // 指定静态资源文件名（不含导出的代码）
        //assetFileNames: "assets/[name].[ext]",
        entryFileNames: "index.js",
        assetFileNames: "[name][extname]",
        chunkFileNames: "[name].js",
      },
    },
  },
};
