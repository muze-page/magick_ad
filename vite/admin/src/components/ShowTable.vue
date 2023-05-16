<script setup>
//展示表格
import { computed } from "vue";
const props = defineProps({
  data: Array,
});
const rows = computed(() =>
  props.data.map((item) => {
    //调整时间
    const [year, month, day] = item.date.split("-");
    return {
      id: item.id,
      计划: "暂无",
      count: item.count,
      type: item.type,
      date: `${month}-${day}`, // 将时间字符串改为 02-14 格式
    };
  })
);
</script>
<template>
  <el-table :data="rows" stripe style="width: 100%" max-height="300">
    <el-table-column fixed prop="id" label="ID" />
    <el-table-column prop="计划" label="计划" />
    <el-table-column prop="count" label="次数" />
    <el-table-column prop="type" label="类型" />
    <el-table-column prop="date" label="时间" />
  </el-table>
</template>
