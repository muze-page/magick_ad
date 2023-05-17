<script lang="ts" setup>
//底部横幅功能
import { ref, onMounted } from "vue";
const props = defineProps({
  data: Object,
});

//标题、内容和debug开关
const item = ref({
  device: props.data?.device,
  content: props.data?.content,
  debug: props.data?.debug,
});

//定时
const time = props.data?.cycle;

// 定义响应式数据
const msg = ref("↓");
const show = ref(false);

// 开关广告状态
const switchButton = () => {
  show.value = !show.value;
  if (show.value) {
    msg.value = "↓";
  } else {
    msg.value = "↑";
  }
};

// 检查指定的 localStorage 是否存在，不存在则创建并存入时间为当前时间
// 若存在，则对比当前时间与存储时间差值，大于 20 秒则继续展示广告，反之不展示广告
const checkLocalStorage = () => {
  const localStorageName = "mad_display_banner_footer";
  const currentTime = new Date().getTime();
  const storedTime = localStorage.getItem(localStorageName);

  if (!storedTime || (currentTime - Number(storedTime)) / 1000 >= time) {
    localStorage.setItem(localStorageName, String(currentTime));
    return true;
  } else {
    return false;
  }
};

// 清除本地记录并刷新页面
const clearLocal = () => {
  localStorage.removeItem("mad_display_banner_footer");
  alert("页面刷新后展示广告");
  // 重新加载页面
  location.reload();
};

onMounted(() => {
  show.value = checkLocalStorage();
});
</script>
<template>
  <div id="magcik_ad_bottom_bar">
    <button
      class="ad-bar-button"
      :class="{ 'ad-bar-actives': show }"
      @click="switchButton"
    >
      {{ msg }}
    </button>
    <transition name="ad-bar-fade">
      <div class="bottom-bar-box" v-if="show">
        <div class="bottom-bar-content">
          {{ item.content }}
        </div>
      </div>
    </transition>
  </div>
  <div v-if="item.debug">
    <button @click="clearLocal()">展示广告</button>
  </div>
</template>
<style scoped lang="less">
#magcik_ad_bottom_bar .bottom-bar-box {
  display: block;
  width: 100% !important;
  height: auto;
  bottom: 0px;
  clear: none !important;
  float: none !important;
  left: 0px;
  margin: 0px !important;
  max-height: none !important;
  max-width: none !important;
  opacity: 1;
  overflow: visible !important;
  padding: 0px !important;
  position: fixed;
  right: auto !important;
  top: auto !important;
  visibility: visible !important;
  z-index: 2147483647;
  background: #fafafa !important;
  /*核心内容框动画*/
  animation: BarBoxA 0.1s;
  display: flex;
  justify-content: center;
  /*align-items: center;
        */
  line-height: 38px;
}
#magcik_ad_bottom_bar .bottom-bar-content {
  max-width: 720px;
  max-height: 90px;
  margin: 0 auto;
  display: table-cell;
  vertical-align: middle;
}
#magcik_ad_bottom_bar .ad-bar-button {
  bottom: 10px;
  position: fixed;
  animation: BottomBarButton 0.1s;
  padding: 5px 15px;
  cursor: pointer;
  left: 0px;
  border: 0px;
}
@keyframes BottomBarButton {
  from {
    bottom: 70px;
    padding: 10px 20px;
  }
  to {
    bottom: 10px;
    padding: 5px 15px;
  }
}
#magcik_ad_bottom_bar .ad-bar-actives {
  animation: adBarAc 0.1s;
  bottom: 80px;
  position: fixed;
  padding: 10px 20px;
  cursor: pointer;
  left: 0px;
  border: 0px;
}
@keyframes adBarAc {
  from {
    bottom: 10px;
    padding: 5px 15px;
  }
  to {
    bottom: 70px;
    padding: 10px 20px;
  }
}
@keyframes BarBoxA {
  from {
    height: 0px;
  }
  to {
    height: 70px;
  }
}
#magcik_ad_bottom_bar .ad-bar-fade-enter-from {
  height: 0px;
}
#magcik_ad_bottom_bar .ad-bar-fade-enter-active {
  transition: all 0.1s ease;
}
#magcik_ad_bottom_bar .ad-bar-fade-enter-to {
  height: 70px;
}
#magcik_ad_bottom_bar .ad-bar-fade-leave-from {
  height: 70px;
}
#magcik_ad_bottom_bar .ad-bar-fade-leave-active {
  transition: all 0.1s ease;
}
#magcik_ad_bottom_bar .ad-bar-fade-leave-to {
  height: 0px;
}
#magcik_ad_bottom_bar .bottom-bar-content img {
  max-width: 100%;
  height: auto;
  object-fit: cover;
  image-rendering: -webkit-optimize-contrast;
  border: 0;
  /*vertical-align: baseline;
        */
}
/*移动端优化样式*/
@media screen and (min-width: 768px) {
  .ad-bar-actives {
    bottom: 90px;
  }
  @keyframes BottomBarButton {
    from {
      bottom: 90px;
    }
    to {
      bottom: 10px;
    }
  }
  @keyframes adBarAc {
    from {
      bottom: 10px;
    }
    to {
      bottom: 90px;
    }
  }
  @keyframes BarBoxA {
    from {
      height: 0px;
    }
    to {
      height: 90px;
    }
  }
  .ad-bar-fade-enter-to {
    height: 90px;
  }
  .ad-bar-fade-leave-from {
    height: 90px;
  }
}


</style>
