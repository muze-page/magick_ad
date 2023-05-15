<script setup>
import ShowChart from "./ShowChart.vue";
import { ref, computed } from "vue";

const props = defineProps({
  data: Array,
});

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

// 数据部分
const data = computed(() => {
  const rows = props.data
    .map((item) => ({
      id: item.id,
      计划: "暂无",
      count: item.count,
      type: item.type,
      date: item.date.slice(5),
    }))
    .sort((a, b) => a.date - b.date);
  const distinctIds = distinct(rows.map((row) => row.id));
  return { rows, distinctIds };
});

// 模板部分
const selectedId = ref("");
const templateData = computed(() => {
  const { rows, distinctIds } = data.value;
  const filteredRows = filterRowsById(rows, selectedId.value);
  return {
    COLUMNS: ["Id", "计划", "次数", "类型", "时间"],
    rows: filteredRows,
    distinctIds: [""].concat(distinctIds),
  };
});
</script>

<template>
  <div class="content">
    <!-- 下拉列表选择ID -->
    <div class="filter-dropdown">
      <label for="selected-id">请选择ID：</label>
      <select id="selected-id" v-model="selectedId">
        <option v-for="id in templateData.distinctIds" :key="id" :value="id">
          {{ id }}
        </option>
      </select>
    </div>

    <!-- 表格部分 -->
    <table class="widefat" width="300px">
      <thead>
        <tr>
          <th v-for="column in templateData.COLUMNS" :key="column">
            {{ column }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in templateData.rows" :key="index">
          <td v-for="(value, key) in row" :key="key">{{ value }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <!---->
  <ShowChart :data="templateData.rows"></ShowChart>
</template>

<style scoped>
label {
  display: inline-block;
  width: 120px;
}

select {
  width: 200px;
  padding: 5px;
  border-radius: 5px;
  outline: none;
  border: 1px solid #ccc;
}

table {
  margin-top: 20px;
}

th,
td {
  padding: 5px;
  text-align: center;
}
</style>
