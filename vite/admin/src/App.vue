<script setup>
import { ref } from "vue";
import CountArr from "./components/CountArr.vue";


//读取本地浏览器数据
const readLocal = localStorage.getItem("magick_ad_count_data");
//解析JSON字符串
const dataLocal = JSON.parse(readLocal);
//待传递的数据
const dataList = ref();
dataList.value = dataLocal;



</script>

<template>
  <div class="wrap">
    <CountArr :data="dataList"></CountArr>
  </div>
</template>

<style scoped></style>
