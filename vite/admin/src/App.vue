<script setup>
import { ref } from "vue";
import CountArr from "./components/CountArr.vue";
//模拟数据
import { count } from "./mock/index.js";
//拿到数据

//读取本地浏览器数据
const readLocal = localStorage.getItem("magick_ad_count_data");
//解析JSON字符串
const dataLocal = JSON.parse(readLocal);
//待传递的数据
const dataList = ref();

//处理数据

if (import.meta.env.VITE_APP_MOCK === "true") {
  //模拟数据
  dataList.value = count;
  //console.log(count);
} else {
  //正式数据
  dataList.value = dataLocal;
}
</script>

<template>
  <div class="wrap">
    <CountArr :data="dataList"></CountArr>
  </div>
</template>

<style scoped></style>
