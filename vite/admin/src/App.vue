<script setup>
import { ref } from "vue";
import ShowList from "./components/ShowList.vue";
import ShowChart from "./components/ShowChart.vue";
//模拟数据
import { data } from "./mock/index.js";
//拿到数据
//读取本地浏览器数据
const readLocal = localStorage.getItem("magick_ad_count");
//解析JSON字符串
const dataLocal = JSON.parse(readLocal);
const dataList = ref();

if (import.meta.env.VITE_APP_MOCK === "true") {
  //模拟数据
  dataList.value = data;
} else {
  //正式数据
  dataList.value = dataLocal;
}
</script>

<template>
  <ShowList :data="dataList"></ShowList>
  <!--
  <ShowChart :data="mockLocal"></ShowChart>
  -->
</template>

<style scoped></style>
