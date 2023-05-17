<script setup lang="ts">
import PopUp from "./components/PopUp.vue";
import Banner from "./components/Banner.vue";
//准备配置数据
const data = {
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
      //简洁广告
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
      cycle: 200, //弹出周期 - 秒
      device: "all", //展示平台 all pc phone
      content: '我是广告内容', //广告内容
      debug: true, //调试模式
    },
  },
};
//逻辑，判断是否开启广告
</script>

<template>
  <!--弹窗广告-->
  <div v-if="data.popup.switch">
    <PopUp :data="data.popup"></PopUp>
  </div>
  <div v-else>没有弹窗广告</div>
  <!--横幅广告-->
  <div v-if="data.banner.switch">
    <Banner :data="data.banner"></Banner>
  </div>
  <div v-else>没有横幅广告</div>
</template>

<style scoped></style>
