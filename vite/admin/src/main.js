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

//准备数据
const mock = [
  { id: "2666", date: "2023-05-15", count: "3", type: "click" },
  { id: "2666", date: "2023-05-16", count: "6", type: "click" },
  { id: "2666", date: "2023-05-17", count: "2", type: "click" },
  { id: "2666", date: "2023-05-18", count: "3", type: "click" },
  { id: "2666", date: "2023-05-19", count: "9", type: "view" },
];
//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_count_data", obj);
};
//add(mock);
