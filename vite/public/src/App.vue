<script setup lang="ts">
import PopUp from "./components/PopUp.vue";
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
    },
  },
};
//逻辑，判断是否开启广告
</script>

<template>
  <div v-if="data.popup.switch">
    <PopUp :data="data.popup"></PopUp>
  </div>
  <div v-else>没有广告</div>

  {{ data }}
</template>

<style scoped></style>
