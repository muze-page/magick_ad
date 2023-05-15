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

// 响应式变量
const filterType = ref(0);
const selectedId = ref("");
const inputId = ref("");

// 计算属性
const rows = computed(() =>
  props.data
    .map((item) => ({
      id: item.id,
      计划: "暂无",
      count: item.count,
      类型: "点击",
      date: item.date.slice(8),
    }))
    .sort((a, b) => b.date - a.date)
);

const filteredRows = computed(() => {
  const rowsToFilter = filterType.value === 0 ? rows.value : [...rows.value];
  return filterRowsById(
    rowsToFilter,
    filterType.value === 0 ? selectedId.value : inputId.value
  );
});
const distinctIds = computed(() => distinct(rows.value.map((row) => row.id)));

// 点击事件处理程序
const handleFilterTypeChange = (type) => {
  filterType.value = type;
  if (type === 0) {
    selectedId.value = "";
  } else {
    inputId.value = "";
  }
};
</script>

<template>
  <div class="content">
    <!-- 添加选项卡，用于选择筛选方式 -->
    <div class="filter-type">
      <button
        :class="{ active: filterType === 0 }"
        @click="handleFilterTypeChange(0)"
      >
        现有 ID
      </button>
      <button
        :class="{ active: filterType === 1 }"
        @click="handleFilterTypeChange(1)"
      >
        输入 ID
      </button>
    </div>

    <!-- 如果选择了“现有 ID”，则显示一个下拉列表，供用户选择已有的 ID -->
    <div v-if="filterType === 0" class="filter-dropdown">
      <label for="selected-id">请选择现有 ID：</label>
      <select id="selected-id" v-model="selectedId">
        <option value="">全部</option>
        <option v-for="id in distinctIds" :key="id" :value="id">
          {{ id }}
        </option>
      </select>
    </div>

    <!-- 如果选择了“输入 ID”，则显示一个输入框，供用户输入要查询的 ID -->
    <div v-else class="filter-input">
      <label for="input-id">请输入要查询的 ID：</label>
      <input type="text" id="input-id" v-model="inputId" />
    </div>

    <!-- 表格部分 -->
    <table class="widefat" width="300px">
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
  </div>
<!---->
  <ShowChart :data="filteredRows"></ShowChart>
  
</template>

<style scoped>
.active {
  background-color: #2b6cb0;
  color: #fff;
}

.filter-type,
.filter-dropdown,
.filter-input {
  margin-bottom: 20px;
}

label {
  display: inline-block;
  width: 120px;
}

input[type="text"],
select {
  width: 200px;
  padding: 5px;
  border-radius: 5px;
  outline: none;
  border: 1px solid #ccc;
}
</style>
