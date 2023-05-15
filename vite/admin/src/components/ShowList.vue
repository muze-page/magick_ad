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
</script>

<template>
  <!-- 如果选择了“现有 ID”，则显示一个下拉列表，供用户选择已有的 ID -->

  <label for="selected-id">请选择现有 ID：</label>
  <select id="selected-id" v-model="selectedId">
    <option value="">全部</option>
    <option v-for="id in distinctIds" :key="id" :value="id">
      {{ id }}
    </option>
  </select>

  <!-- 添加一个选择类型的下拉列表 -->
  <label for="selected-type">请选择类型：</label>
  <select id="selected-type" v-model="selectedType">
    <option value="">全部</option>
    <option v-for="item in distinctTypes" :key="item" :value="item">
      {{ item }}
    </option>
  </select>

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

  <!---->
  <ShowChart :data="filteredRows"></ShowChart>
</template>

<style scoped></style>
