<script setup>
import CountArr from "./components/CountArr.vue";

//读取本地浏览器数据
const readLocal = localStorage.getItem("magick_ad_count_data");
//解析JSON字符串
const dataLocal = JSON.parse(readLocal);
//对数据进行处理，去除不符合类型的数
// 过滤数组，仅保留type为click或view的元素
const filteredArr = dataLocal.filter(item => ['click', 'view'].includes(item.type));
//待传递的数据
const dataList = filteredArr;



</script>

<template>
  <div class="wrap">
    <CountArr :data="dataList"></CountArr>
  </div>
</template>

<style scoped></style>
