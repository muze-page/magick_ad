<script lang="ts" setup>
//展示表格
const props = defineProps({
  data: Array,
});
</script>
<template>
  <el-table :data="props.data" stripe style="width: 100%" max-height="300">
    <el-table-column fixed prop="id" label="ID" />
    <el-table-column prop="计划" label="计划" />
    <el-table-column prop="count" label="次数" />
    <el-table-column prop="type" label="类型" />
    <el-table-column prop="date" label="时间" />
  </el-table>
</template>
