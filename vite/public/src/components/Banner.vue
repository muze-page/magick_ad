<script lang="ts" setup>
//底部横幅功能
import BannerFooter from "./block/BannerFooter.vue";
import { computed } from "vue";
const props = defineProps({
  data: Object,
});
//判断展示广告类型
const handleBanner = computed<boolean>(() => props.data?.type === "footer");
</script>
<template>
  <div v-show="handleBanner">
    <!--底部横幅广告-->
    <BannerFooter :data="props.data?.footer"></BannerFooter>
  </div>
</template>
<style scoped lang="less"></style>
