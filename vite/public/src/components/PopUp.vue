<script lang="ts" setup>
//弹窗功能
import Concise from "./popup/Concise.vue";
import Google from "./popup/Google.vue";
import { computed } from "vue";
//接收数据，并通过时间进行筛选
const props = defineProps({
  data: Object,
});
//判断开启的是那个广告
//计算属性，判断广告类型
const handlePopUp = computed<boolean>(() => props.data?.type === "concise");
//const handlePopUp = true;
</script>
<template>
  {{ props.data }}666
  <div v-if="handlePopUp">
    <!--简洁广告-->
    <Concise :data="props.data?.concise"></Concise>
  </div>
  <div v-else>
    <!--google广告-->
    <Google :data="props.data?.google"></Google>
  </div>
</template>
<style scoped lang="less">
.box {
  background-color: tomato;
  span {
    color: aqua;
  }
}
</style>
