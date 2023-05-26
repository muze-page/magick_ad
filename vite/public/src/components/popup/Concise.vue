<script lang="ts" setup>
//简洁广告
import { ref } from "vue";
interface Item {
  title?: string;
  content?: string;
  cycle?: number;
  debug?: boolean;
}

const props = defineProps({
  data: Object as () => Item,
});

const { title = "", content = "", debug = false } = props.data || {};

const item = ref({ title, content, debug });

//定时
const time = (props.data?.cycle || 0) * 60 * 60 * 24;
//local名
const localData = "magick_ad_display_time_popup-concise";

// 默认显示广告
const showAd = ref(true);

// 关闭广告方法
const offAd = () => {
  showAd.value = false;
};

// 清除 localStorage
const clearLocal = () => {
  // TODO: 实现清除 localStorage 的逻辑
  localStorage.removeItem(localData);
  alert("页面刷新后展示广告");
  location.reload();
};

// 检查指定的 localStorage 是否存在，不存在则创建并存入时间为当前时间
// 若存在，则对比当前时间差值，大于 2 秒则继续展示广告，反之不展示广告
const checkLocalStorage = () => {
  //定时器
  const localStorageName = localData;
  //拿到现在的时间
  const currentTime = new Date().getTime();
  //拿到本地存储的时间
  const storedTime = localStorage.getItem(localStorageName);

  //现在的时间减去本地存储的时间的差值
  // 毫秒转换成秒
  if (!storedTime || (currentTime - Number(storedTime)) / 1000 >= time) {
    localStorage.setItem(localStorageName, String(currentTime));
    return true;
  } else {
    return false;
  }
};

// 初始检查 localStorage 并决定是否展示广告
showAd.value = checkLocalStorage();
</script>
<template>
  <div class="magick_main" v-show="showAd">
    <div class="sec">
      <div class="ad_box">
        <div class="ad_main">
          <h2>{{ item.title }}</h2>
          <span v-html="item.content"></span>
        </div>
      </div>

      <div class="set">
        <button class="offAd" @click="offAd()">X</button>
      </div>
    </div>
  </div>
  <div v-if="item.debug">
    <button @click="clearLocal()">展示弹窗广告</button>
  </div>
</template>
<style scoped lang="less">
.magick_main {
  display: flex;
  position: fixed;
  width: 100vw;
  height: 70vh;
  top: 0;
  left: 0;
  z-index: 9999;
  justify-content: center;
  transition: 0.3s ease-out;
  flex-direction: column;
  align-items: center;
  background: var(--heo-maskbgdeep);
  backdrop-filter: saturate(180%) blur(20px);
  -webkit-backdrop-filter: blur(20px);
  .sec {
    max-width: 600px;
    margin: 0.9rem auto;
    .set {
      overflow: hidden;
      width: 60%;
      display: block;
      margin: 0 auto;
      padding: 20px;
      display: flex;
      justify-content: center;
      .offAd {
        width: 48px;
        height: 48px;
        right: 50px;
        top: auto;
        font-size: 35px;
        color: var(--heo-fontcolor);
        cursor: pointer;
        transition: 0.3s;

        padding: 1px 8px;
        float: right;
        border-radius: 100px;
        border: 0px;
      }
      .offAd:hover {
        color: #fff;
        background: #58595b;
        border-radius: 32px;
        text-decoration: none;
      }
    }
    .ad_box {
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      justify-content: center;
      /*height: 100%;*/
      overflow: hidden;
    }
    .ad_main {
      background: var(--card-bg);
      border-radius: 12px;
      overflow: hidden;
      border: var(--style-border);
      box-shadow: var(--heo-shadow-border);
      padding: 40px;
    }
  }
}

.magick_main {
  --card-bg: #fff;
  --style-border: 1px solid var(--heo-card-border);
  --heo-card-border: #e3e8f7;
  --heo-shadow-border: 0 8px 16px -4px #2c2d300c;
  --heo-fontcolor: #363636;
  --heo-maskbgdeep: rgba(255, 255, 255, 0.85);
}

@media screen and (max-width: 768px) {
  .magick_main .sec {
    width: 90%;
    .set {
      width: 100%;
    }
    .ad_box {
      width: 100%;
    }
    .ad_main {
      padding: 20px;
    }
  }
}

/*临时修改*/
//.magick_main {
//background: none !important;
//backdrop-filter: none !important;
//}
</style>
