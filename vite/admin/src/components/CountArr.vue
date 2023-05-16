<script setup>
import { ref, computed, watchEffect } from "vue";
import CountType from "./CountType.vue";
//接收数据，并通过时间进行筛选
const props = defineProps({
  data: Array,
});

//{ id: "62", ad_id: "95270", ad_type: "view", ad_time: "2023-05-16 16:55:10" },

//时间筛选
//拿到当前时间戳
const today = new Date(); // 获取当前时间
today.setHours(0, 0, 0, 0); // 设置为今天的0点
const startTimestamp = today.getTime(); // 获取今天0点的时间戳
today.setHours(23, 59, 59, 999); // 设置为今天的23点59分59秒
const endTimestamp = today.getTime(); // 获取今天24点的时间戳

//设置时间默认值
const value2 = ref([startTimestamp, endTimestamp]);
const shortcuts = [
  {
    text: "过去一周",
    value: () => {
      const end = new Date();
      const start = new Date();
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
      return [start, end];
    },
  },
  {
    text: "过去一个月",
    value: () => {
      const end = new Date();
      const start = new Date();
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
      return [start, end];
    },
  },
  {
    text: "过去三个月",
    value: () => {
      const end = new Date();
      const start = new Date();
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
      return [start, end];
    },
  },
];

//定义默认筛选的开始时间和结束时间

const startTime = ref(startTimestamp);
const endTime = ref(endTimestamp);


const filteredRows = computed(() =>
  props.data.filter(
    (row) =>
      Date.parse(row.ad_time) >= startTime.value &&
      Date.parse(row.ad_time) <= endTime.value
  )
);
//监听时间变化
watchEffect(() => {
  //一天的开始
  startTime.value = value2.value[0];
  //一天的结束
  endTime.value = value2.value[1] + 86399999;
});
</script>
<template>
  <!--时间筛选-->
  <el-date-picker
    v-model="value2"
    type="daterange"
    unlink-panels
    range-separator="到"
    start-placeholder="开始日期"
    end-placeholder="结束日期"
    :shortcuts="shortcuts"
    format="YYYY/MM/DD"
    value-format="x"
  />
  <!--
     <pre>{{ filteredRows }}</pre>
  -->

  <!--筛选后的数据传出-->
  <CountType :data="filteredRows"></CountType>
</template>

<style scoped></style>
