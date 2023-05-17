import { createApp } from "vue";
import "./style.css";
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
  { id: "57", ad_id: "95266", ad_type: "view", ad_time: "2023-05-10 17:47:20" },
  { id: "57", ad_id: "95267", ad_type: "view", ad_time: "2023-05-11 17:47:20" },
  { id: "57", ad_id: "95266", ad_type: "view", ad_time: "2023-05-13 17:47:20" },
  {
    id: "57",
    ad_id: "95267",
    ad_type: "click",
    ad_time: "2023-05-12 17:47:20",
  },
  { id: "57", ad_id: "95266", ad_type: "view", ad_time: "2023-05-11 17:47:20" },
  { id: "57", ad_id: "95266", ad_type: "view", ad_time: "2023-05-11 17:47:20" },
];
//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_count_data", obj);
};
//add(mock);
