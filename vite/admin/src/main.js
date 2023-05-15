import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";

createApp(App).mount("#mgad_show_count");


//准备数据
const mock = [
  { id: "95266", date: "2023-05-11", count: "13" },
  { id: "9527", date: "2023-05-11", count: "55" },
  { id: "9527", date: "2023-05-12", count: "45" },
  { id: "9527", date: "2023-05-13", count: "35" },
  { id: "9527", date: "2023-05-14", count: "25" },
  { id: "9527", date: "2023-05-15", count: "15" },
];
//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_count", obj);
};
add(mock);
