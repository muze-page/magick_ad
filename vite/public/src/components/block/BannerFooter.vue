<script lang="ts" setup>
//底部横幅功能
import { ref, onMounted, watchEffect } from "vue";
interface Item {
  display?: string;
  content?: string;
  cycle?: number;
  debug?: boolean;
}
const props = defineProps({
  data: Object as () => Item,
});
const { display = "", content = "", debug = false } = props.data || {};

const item = ref({ display, content, debug });

//定时
const time = (props.data?.cycle || 0) * 60 * 60 * 24;

//local名
const local = "magick_ad_display_time_banner-footer";

// 定义响应式数据
const show = ref(false);
//图标
const msg = ref();

// 开关广告状态
const switchButton = () => {
  show.value = !show.value;
};

// 检查指定的 localStorage 是否存在，不存在则创建并存入时间为当前时间
// 若存在，则对比当前时间与存储时间差值，大于 20 秒则继续展示广告，反之不展示广告
const checkLocalStorage = () => {
  const localStorageName = local;
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
  localStorage.removeItem(local);
  alert("页面刷新后展示广告");
  // 重新加载页面
  location.reload();
};

onMounted(() => {
  show.value = checkLocalStorage();
});
watchEffect(() => {
  //监听图标变化
  msg.value = show.value ? "︾" : "︽";
});
</script>
<template>
  <div v-if="item.display">
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
          <div v-html="item.content"></div>
        </div>
      </div>
    </transition>

    <div v-if="item.debug">
      <button @click="clearLocal()">展示底部横幅广告</button>
    </div>
  </div>
</template>
<style scoped lang="less">
.bottom-bar-box {
  width: 100%;
  height: auto;
  bottom: 0px;
  clear: none;
  float: none;
  left: 0px;
  margin: 0px;
  max-height: none;
  max-width: none;
  opacity: 1;
  overflow: visible;
  padding: 0px;
  position: fixed;
  right: auto;
  top: auto;
  visibility: visible;
  z-index: 1;
  background: #fafafa;
  /*核心内容框动画*/
  animation: BarBoxA 0.1s;
  display: flex;
  justify-content: center;
  /*align-items: center;
        */
  line-height: 38px;
}
.bottom-bar-content {
  max-height: 200px;
  margin: 0 auto;
  display: table-cell;
  vertical-align: middle;
}
.ad-bar-button {
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
.ad-bar-actives {
  animation: adBarAc 0.1s;
  bottom: 200px;
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
.ad-bar-fade-enter-from {
  height: 0px;
}
.ad-bar-fade-enter-active {
  transition: all 0.1s ease;
}
.ad-bar-fade-enter-to {
  height: 70px;
}
.ad-bar-fade-leave-from {
  height: 70px;
}
.ad-bar-fade-leave-active {
  transition: all 0.1s ease;
}
.ad-bar-fade-leave-to {
  height: 0px;
}
.bottom-bar-content img {
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
