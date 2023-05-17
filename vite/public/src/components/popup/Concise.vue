<script lang="ts" setup>
//简洁弹窗功能
const props = defineProps({
  data: Object,
});
</script>
<template>
  我是简洁弹窗
  <pre>{{ props.data }}</pre>
</template>
<style scoped lang="less"></style>
