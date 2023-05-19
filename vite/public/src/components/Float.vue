<script lang="ts" setup>
//悬浮广告功能
import BothSidesDefault from "./block/BothSidesDefault.vue";
import { computed } from "vue";
const props = defineProps({
  data: Object,
});
//判断展示广告类型
const handleFloat = computed<boolean>(() => props.data?.type === "default");
</script>
<template>
  <div v-show="handleFloat">
    <!--底部横幅广告-->
    <BothSidesDefault :data="props.data?.default"></BothSidesDefault>
  </div>
  <div class="test" v-show="true"></div>
</template>
<style scoped lang="less">
.test {
  height: 5000px;
}
</style>
