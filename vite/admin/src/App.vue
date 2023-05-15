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

//处理数据
//处理传来的值
//{id: "58", ad_id: "95266", ad_type: "view", ad_time: "2023-05-11 17:47:20"}
// { id: "95266", date: "2023-05-11", count: "13" },
const handleCount = (a) => {
  // b 数组
  let b = [];

  // 遍历 a 数组
  a.forEach((item) => {
    // 获取当前广告记录的日期和时间
    let adDate = item.ad_time.split(" ")[0];

    // 在 b 数组中查找是否已经有对应广告记录
    let index = b.findIndex(
      (bItem) =>
        bItem.id === item.ad_id &&
        bItem.date === adDate &&
        bItem.type === item.ad_type
    );

    // 如果找到了对应广告记录，则将 count 值加一
    if (index >= 0) {
      b[index].count++;
    }
    // 如果没找到对应广告记录，则新建一条记录
    else {
      let newItem = {
        id: item.ad_id,
        date: adDate,
        count: 1,
        type: item.ad_type,
      };
      b.push(newItem);
    }
  });
  b.sort((a, b) => new Date(b.date) - new Date(a.date));
  return b;
};

if (import.meta.env.VITE_APP_MOCK === "true") {
  //模拟数据
  dataList.value = handleCount(data);
  console.log(handleCount(data));
} else {
  //正式数据
  dataList.value = handleCount(dataLocal);
}
</script>

<template>
  <ShowList :data="dataList"></ShowList>
  <!--
  <ShowChart :data="mockLocal"></ShowChart>
  -->
</template>

<style scoped></style>
