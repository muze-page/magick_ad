<script lang="ts" setup>
import { ref, onMounted, computed } from "vue";

interface Item {
  left_content?: string;
  right_content?: string;
  page_width?: number;
  sides?: number;
  top?: number;
}

const props = defineProps({
  data: Object as () => Item,
});

const item = ref<Item>(props.data || {});

// 获取节点并添加样式
const myDiv = ref<HTMLDivElement>();
const scrollFunction = () => {
  if (window.scrollY > 300) {
    myDiv.value?.classList.add("magick_ad_isashow");
    myDiv.value?.classList.remove("magick_ad_noshow");
  } else {
    myDiv.value?.classList.add("magick_ad_noshow");
    myDiv.value?.classList.remove("magick_ad_isashow");
  }
};
const scoll = () => {
  window.addEventListener("scroll", scrollFunction);
};

onMounted(() => {
  setTimeout(scoll, 1500);
});

const pageWidth = computed(
  () => window.innerWidth >= (item.value?.page_width || 0)
);

const sidesCss = computed(() => item.value?.sides + "px" || "");
const topCss = computed(() => item.value?.top + "px" || "");
</script>

<template>
  <div ref="myDiv" class="magick_ad_both_sides" v-show="pageWidth">
    <div class="magick_ad_go-top magick_ad_left-s">
      <span v-html="item.left_content"></span>
    </div>

    <div class="magick_ad_go-top magick_ad_right-s">
      <span v-html="item.right_content"></span>
    </div>
  </div>
</template>
<style lang="less" scoped>
.magick_ad_both_sides {
  opacity: 0;
}

.magick_ad_both_sides > .magick_ad_left-s {
  left: v-bind("sidesCss");
}

.magick_ad_both_sides > .magick_ad_right-s {
  right: v-bind("sidesCss");
}

.magick_ad_both_sides > .magick_ad_go-top {
  position: fixed;
  /* 设置fixed固定定位 */

  top: v-bind("topCss");
  /* 距离浏览器窗口下边框20px */
  word-break: break-all;
  max-width: 300px;
}

.magick_ad_both_sides > .magick_ad_go-top span {
  display: block;
  /* 将<a>标签设为块元素，用于美化样式 */
  text-decoration: none;
  /* 取消超链接下画线 */
  color: #333;
  /* 设置文本颜色 */
  background-color: #f2f2f2;
  /* 设置背景颜色 */
  border: 1px solid #ccc;
  /* 设置边框样式 */
  padding: 6px 10px;
  /* 设置内边距 */
  border-radius: 5px;
  /* 设置圆角矩形 */
  letter-spacing: 2px;
  /* 设置文字间距 */

  max-width: 180px;
  max-height: 500px;
}

.magick_ad_isashow {
  opacity: 1;
  animation: magick_ad_fadeIn 1s;
}

.magick_ad_noshow {
  opacity: 0;
  animation: magick_ad_fadeOut 1s;
}

@keyframes magick_ad_fadeOut {
  from {
    opacity: 1;
  }

  to {
    opacity: 0;
  }
}

@keyframes magick_ad_fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}
//@media only screen and (max-width: 1400px) {
//  .magick_ad_both_sides {
//    display: none;
//  }
//}
</style>
