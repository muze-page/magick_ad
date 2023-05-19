import { createApp } from 'vue'
import './style.css'
//import '../node_modules/_@picocss_pico@1.5.10@@picocss/pico/css/pico.min.css'
//滚动报错
import "default-passive-events";
import App from './App.vue'

const app = createApp(App);

app.mount("#mgad_public");

//const datas = {
//    "popup": {
//        "switch": "true",
//        "type": "google",
//        "concise": [],
//        "google": {
//            "cycle": "72",
//            "title": "我是简单标题",
//            "content": "<p>我是弹窗内容</p>\n",
//            "debug": "true",
//            "link": {
//                "title": "Apple 为脱碳拓展开创性的 Restore Fund",
//                "url": "http://magick.plugin/2356",
//                "target": ""
//            },
//            "text_open": "打开",
//            "logo": "http://magick.plugin/wp-content/uploads/2023/04/2023041703462180.jpg"
//        }
//    },
//    "both_sides": {
//        "switch": "true",
//        "type": "default",
//        "default": {
//            "left_content": "<p>左边的内容</p>\n",
//            "right_content": "<p>右边的内容</p>\n",
//            "page_width": "1200",
//            "sides": "100",
//            "top": "300"
//        }
//    },
//    "bottom_banner": {
//        "switch": "true",
//        "type": "footer",
//        "footer": {
//            "cycle": "1",
//            "content": "<p>我是横栏广告内容</p>\n",
//            "debug": "true",
//            "display": "true"
//        }
//    }
//};
//
//
//  //将数据写入本地
//const add = (data:any) => {
//    const obj = JSON.stringify(data);
//    localStorage.setItem("magick_ad_public_data", obj);
//  };
//  //手动添加记录
//  add(datas);