import { createApp } from 'vue'
import './style.css'
//import '../node_modules/_@picocss_pico@1.5.10@@picocss/pico/css/pico.min.css'
//滚动报错
import "default-passive-events";
//测试数据
//import './mock.ts'
import App from './App.vue'

const app = createApp(App);

app.mount("#mgad_public");

