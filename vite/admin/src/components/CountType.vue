<script setup>
//ID和类型筛选
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

// 筛选数据
const filterRows = (rows, id, type) => {
  return rows
    .filter((row) => !id || row.id.toString() === id)
    .filter((row) => !type || row.type === type);
};

// 响应式变量
const selectedId = ref(""); //ID 筛选
const selectedType = ref(""); //类型筛选

// 计算属性
const rows = computed(() =>
  handleCount(props.data).map((item) => ({
    id: item.id,
    计划: "暂无",
    count: item.count,
    type: item.type,
    date: item.date,
  }))
);

// 筛选后的数据
const sortedRows = computed(() =>
  filterRows(rows.value, selectedId.value, selectedType.value).sort(
    //按时间排序
    (a, b) => new Date(b.date) - new Date(a.date)
  )
);

// 提取字段并去重
const distinctValues = (rows, field) => [
  ...new Set(rows.map((row) => row[field])),
];

// 提供 ID 列表和类型列表
const distinctIds = computed(() => distinctValues(sortedRows.value, "id"));
const distinctTypes = computed(() => distinctValues(sortedRows.value, "type"));

//提取筛选后的展示类型
const viewData = computed(() =>
  sortedRows.value.filter((row) => row.type === "view")
);

//提取筛选后的点击类型
const clickData = computed(() =>
  sortedRows.value.filter((row) => row.type === "click")
);
</script>

<template>
  <el-select
    v-model="selectedId"
    filterable
    clearable
    placeholder="请选择现有 ID"
  >
    <el-option
      v-for="item in distinctIds"
      :key="item"
      :label="item"
      :value="item"
    />
  </el-select>

  <el-select
    v-model="selectedType"
    filterable
    clearable
    placeholder="请选择类型"
  >
    <el-option
      v-for="item in distinctTypes"
      :key="item"
      :label="item"
      :value="item"
    />
  </el-select>

  <!--统计表-->
  <br />
  <ShowTable :data="sortedRows"></ShowTable>

  <!--展示图-->
  <ShowChart :data="viewData" name="展示图"></ShowChart>

  <!--点击图-->
  <ShowChart :data="clickData" name="点击图"></ShowChart>
</template>

<style scoped></style>
