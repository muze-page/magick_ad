<script setup lang="ts">
import PopUp from "./components/PopUp.vue";
import Float from "./components/Float.vue";
import Banner from "./components/Banner.vue";
import { computed } from "vue";
//准备配置数据

//读取本地浏览器数据
const readLocal = localStorage.getItem("magick_ad_public_data");

//解析JSON字符串，将字节true改为布尔值
const dataLocal = readLocal
  ? JSON.parse(readLocal, (_key, value) => {
      if (value === "true") {
        return true;
      } else if (value === "false") {
        return false;
      } else {
        return value;
      }
    })
  : "";

//待传递的数据
const data = dataLocal;
//计算下，若没有拿到值，则不显示广告


//判断有没有弹窗
const popup = computed(() => {
  const hasPopup = Object.keys(dataLocal).includes("popup");
  return hasPopup ? true : false;
});
</script>

<template>
  <!--判断是否拿到值-->
  <div v-if="popup">
    <!--弹窗广告-->
    <div v-if="data.popup.switch">
      <PopUp :data="data.popup"></PopUp>
    </div>

    <!--两侧悬浮广告-->
    <div v-if="data.both_sides.switch">
      <Float :data="data.both_sides"></Float>
    </div>

    <!--横幅广告-->
    <div v-if="data.bottom_banner.switch">
      <Banner :data="data.bottom_banner"></Banner>
    </div>
  </div>
</template>

<style scoped></style>
