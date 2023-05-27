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

// 响应式变量
const selectedId = ref(""); //ID 筛选
const selectedType = ref(""); //类型筛选

// 计算属性
const rows = computed(() =>
  props.data.map((item) => ({
    id: item.id,
    计划: "暂无",
    count: item.count,
    type: item.type,
    date: item.date,
  }))
);

//进行筛选
const filterRows = (rows, ids, type) => {
  //ID数组为空，仅筛选type
  if (ids.length === 0) {
    return rows.filter((row) => !type || row.type === type);
  }
  return rows
    .filter((row) => ids.includes(row.id.toString()))
    .filter((row) => !type || row.type === type);
};

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
const distinctIds = computed(() => distinctValues(props.data, "id"));
const distinctTypes = computed(() => {
  const arr = distinctValues(props.data, "type");
  const result = arr.map((item) => ({
    value: item,
    label: item == "click" ? "点击" : "展示",
  }));
  const all = { value: "", label: "全部" };
  result.unshift(all);
  return result;
});

//提取筛选后的展示类型数值，用于图标渲染
// 筛选type为"view"的数据，生成新的计算属性viewData
const viewData = computed(() =>
  sortedRows.value.filter((row) => row.type === "view")
);

//提取筛选后的点击类型数值，用于图标渲染
const clickData = computed(() =>
  sortedRows.value.filter((row) => row.type === "click")
);
</script>

<template>
  <el-select
    v-model="selectedId"
    multiple
    placeholder="请选择现有 ID"
    style="border: 0"
  >
    <el-option
      v-for="item in distinctIds"
      :key="item"
      :label="item"
      :value="item"
    />
  </el-select>

  <el-select v-model="selectedType" filterable placeholder="请选择类型">
    <el-option
      v-for="item in distinctTypes"
      :key="item.value"
      :label="item.label"
      :value="item.value"
    />
  </el-select>

  <!--统计表-->
  <br />
  <ShowTable :data="sortedRows"></ShowTable>
  <div class="echart">
    <!--展示图-->
    <ShowChart :data="viewData" name="展示图"></ShowChart>

    <!--点击图-->
    <ShowChart :data="clickData" name="点击图"></ShowChart>
  </div>
</template>

<style scoped>
.el-select {
  margin: -4px 5px 3px;
}

:deep(.el-input__inner) {
  background-color: #fff00000;
  border: 0px;
}
:deep(.el-input__inner:focus) {
  box-shadow: none;
}
</style>
