<script setup>
import ShowList from './components/ShowList.vue';
import ShowChart from './components/ShowChart.vue';
//拿到数据
//读取本地浏览器数据
const readLocal = localStorage.getItem("magick_ad_count");
//解析JSON字符串
const mockLocal = JSON.parse(readLocal);
</script>

<template>
  <ShowList :data="mockLocal"></ShowList>
  <ShowChart :data="mockLocal"></ShowChart>
</template>

<style scoped></style>
