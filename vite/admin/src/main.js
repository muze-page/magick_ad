import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import ElementPlus from "element-plus";
import zhCn from "element-plus/dist/locale/zh-cn.mjs";

/**
 * 测试数据
 */
//import { data, count } from "./mock/index.js";
//将数据写入本地
//const add = (data) => {
//  const obj = JSON.stringify(data);
//  localStorage.setItem("magick_ad_count_data", obj);
//};
//console.log(count);
//add(count);
/**
 * 测试结束
 */

const app = createApp(App);
//中文化
app.use(ElementPlus, {
  locale: zhCn,
});

app.mount("#mgad_show_count");
