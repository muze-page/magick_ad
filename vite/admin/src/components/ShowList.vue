<script setup>
import ShowChart from "./ShowChart.vue";
import { computed, ref } from "vue";

const props = defineProps({
  data: Array,
});

// 表头常量
const COLUMNS = ["Id", "计划", "次数", "类型", "时间"];

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
const selectedId = ref("");
const selectedType = ref("");

// 计算属性
const rows = computed(() =>
  props.data
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
console.log(filteredRows.value);
console.log(viewData.value);

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

  <!--表格部分 -->
  <table class="wp-list-table widefat fixed striped">
    <thead>
      <tr>
        <th v-for="column in COLUMNS" :key="column">{{ column }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, index) in filteredRows" :key="index">
        <td v-for="(value, key) in row" :key="key">{{ value }}</td>
      </tr>
    </tbody>
  </table>

  <!--统计表-->
  <br />
  <!--展示图-->
  <ShowChart :data="viewData" name="展示图"></ShowChart>
  <!--点击图-->
  <ShowChart :data="clickData" name="点击图"></ShowChart>
</template>

<style scoped></style>
