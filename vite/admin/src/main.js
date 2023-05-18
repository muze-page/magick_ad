import { createApp } from "vue";
//import "./style.css";
import App from "./App.vue";
import ElementPlus from "element-plus";
import zhCn from "element-plus/dist/locale/zh-cn.mjs";

const app = createApp(App);
//中文化
app.use(ElementPlus, {
  locale: zhCn,
});

app.mount("#mgad_show_count");

//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_count_data", obj);
};
const modulePath = "./mock/index.js";
if (import.meta.env.VITE_APP_MOCK === "true") {
  //模拟数据
  const { count } = await import(modulePath);
  //模拟数据写入本地
  add(count);
  console.log(count);
}


