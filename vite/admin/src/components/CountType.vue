<script setup>
import ShowChart from "./ShowChart.vue";
import ShowTable from "./ShowTable.vue";
import { computed, ref } from "vue";

const props = defineProps({
  data: Array,
});

//对传来的数据进行处理
//处理传来的值
//{id: "58", ad_id: "95266", ad_type: "view", ad_time: "2023-05-11 17:47:20"}
// { id: "95266", date: "2023-05-11", count: "13" },
const handleCount = (a) => {
  // b 数组
  let b = [];

  // 遍历 a 数组
  a.forEach((item) => {
    // 获取当前广告记录的日期和时间
    let timeStr = item.ad_time;
    const date = new Date(timeStr);
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const result = `${month}-${day}`;
    //处理后赋值
    let adDate = result;

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
  //排序
  b.sort((a, b) => new Date(b.date) - new Date(a.date));
  return b;
};



// 定义一个去重处理函数
const distinct = (arr) => [...new Set(arr)];

// 根据ID过滤数据
const filterRowsById = (rows, id) => {
  if (!id) {
    // 如果没有选择ID
    return rows;
  }
  return rows.filter((row) => row.id.toString() === id);
};

// 根据类型过滤数据
const filterRowsByType = (rows, selectedType) => {
  if (!selectedType) {
    // 如果没有选择类型
    return rows;
  }
  return rows.filter((row) => row.type === selectedType);
};

// 响应式变量
const selectedId = ref(""); //ID 筛选
const selectedType = ref(""); //类型筛选

// 计算属性
const rows = computed(() =>
  handleCount(props.data)
    .map((item) => ({
      id: item.id,
      计划: "暂无",
      count: item.count,
      type: item.type === "click" ? "点击" : "展示",
      date: item.date,
    }))
    //按时间排序
    .sort((a, b) => new Date(b.date) - new Date(a.date))
);

//筛选后的数据
const filteredRows = computed(() => {
  let tempRows = filterRowsById(rows.value, selectedId.value);
  return filterRowsByType(tempRows, selectedType.value);
});

// 提供ID列表和类型列表
const distinctIds = computed(() => distinct(rows.value.map((row) => row.id)));
const distinctTypes = computed(() =>
  distinct(rows.value.map((row) => row.type))
);
//提取

//提取筛选后的展示类型
const viewData = computed(() => {
  return filteredRows.value.filter((row) => row.type === "展示");
});

//提取筛选后的点击类型
const clickData = computed(() => {
  return filteredRows.value.filter((row) => row.type === "点击");
});
</script>

<template>
  <!-- 如果选择了“现有 ID”，则显示一个下拉列表，供用户选择已有的 ID -->
  <el-select v-model="selectedId" filterable placeholder="请选择现有 ID">
    <el-option
      v-for="item in distinctIds"
      :key="item"
      :label="item"
      :value="item"
    />
  </el-select>
  <!-- 添加一个选择类型的下拉列表 -->
  <el-select v-model="selectedType" filterable placeholder="请选择类型">
    <el-option
      v-for="item in distinctTypes"
      :key="item"
      :label="item"
      :value="item"
    />
  </el-select>


  <!--统计表-->
  <br />
  <ShowTable :data="filteredRows"></ShowTable>
  <!--展示图-->
  <ShowChart :data="viewData" name="展示图"></ShowChart>
  <!--点击图-->
  <ShowChart :data="clickData" name="点击图"></ShowChart>
</template>

<style scoped></style>
