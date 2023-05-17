import { createApp } from 'vue'
import './style.css'
//import '../node_modules/_@picocss_pico@1.5.10@@picocss/pico/css/pico.min.css'
import App from './App.vue'

const app = createApp(App);

app.mount("#mgad_public");

const datas = {
    popup: {
      //弹窗广告
      switch: true, //广告开关
      type: "concise", //广告类型
      concise: {
        //简洁广告
        cycle: 200, //弹出周期 - 秒
        title: "你好呀", //广告标题
        content: "大大方方", //广告内容
        debug: true, //调试模式
      },
      google: {
        //谷歌广告
        cycle: 200, //弹出周期 - 秒
        title: "你好呀", //广告标题
        content: "大大方方", //广告内容
        link: "https://www.dongbd.com", //打开链接
        text_open: "打开", //打开按钮文本
        logo: "https://www.dongbd.com", //品牌LOGO
      },
    },
    //横幅广告
    banner: {
      switch: true, //广告开关
      type: "footer", //广告类型
      footer: {
        //广告最高200像素
        cycle: 200, //弹出周期 - 秒
        device: "all", //展示平台 all pc phone
        content:
          "<h2>我是广告内容</h2><h2>我是广告内容</h2><h2>我是广告内容</h2>", //广告内容
        debug: true, //调试模式
      },
    },
  };

  //将数据写入本地
const add = (data:any) => {
    const obj = JSON.stringify(data);
    localStorage.setItem("magick_ad_public_data", obj);
  };
  add(datas);