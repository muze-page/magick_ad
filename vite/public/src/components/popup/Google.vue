<script lang="ts" setup>
//Google广告
import { ref } from "vue";
interface Link {
  title?: string;
  url?: string;
  target?: string;
}

interface Item {
  title?: string;
  content?: string;
  logo?: string;
  link?: Link;
  text_open?: number;
  debug?: boolean;
  cycle?: number;
}
const props = defineProps({
  data: Object as () => Item,
});
//标题、内容和debug开关
const {
  title = "",
  content = "",
  logo = "",
  link = {},
  text_open = 0,
  debug = false,
} = props.data || {};

const item = ref({ title, content, logo, link, text_open, debug });

const CYCLE_IN_SECONDS = props.data?.cycle || 0;

//定时
const time = CYCLE_IN_SECONDS * 60 * 60 * 24;
//local名
const localData = "magick_ad_display_time_popup-google";

//准备链接
const openUrl = () => {
  //打开的链接
  location.href = item.value.link.url || "#";
};
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
  <button @click="clearLocal">展示弹窗</button>

  <div class="pop" v-show="showAd">
    <div class="box-content">
      <!--顶部-->
      <div class="top-box">
        <div class="left-box">
          <div class="text">广告</div>
        </div>
        <div class="right-box" v-show="false">
          <svg viewBox="0 0 14 24" fill="none">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M2 8C3.1 8 4 7.1 4 6C4 4.9 3.1 4 2 4C0.9 4 0 4.9 0 6C0 7.1 0.9 8 2 8ZM2 10C0.9 10 0 10.9 0 12C0 13.1 0.9 14 2 14C3.1 14 4 13.1 4 12C4 10.9 3.1 10 2 10ZM0 18C0 16.9 0.9 16 2 16C3.1 16 4 16.9 4 18C4 19.1 3.1 20 2 20C0.9 20 0 19.1 0 18Z"
              fill="#5F6368"
            ></path>
          </svg>
        </div>
      </div>
      <!--底部-->
      <div class="button-box">
        <div class="content-top">
          <!--标题和内容-->
          <div class="title" v-html="item.title"></div>
          <div class="content" v-html="item.content"></div>
        </div>
        <div class="content-button">
          <!--品牌LOGO-->
          <div class="t-logo">
            <img :src="item.logo" />
          </div>
          <div class="t-button" @click="offAd">
            <span>关闭</span>
          </div>
          <div class="t-button style-button" @click="openUrl">
            <span v-html="item.text_open"></span>
          </div>
        </div>
      </div>
      <!--反馈-->
      <div id="feedback" class="feedback" style="display: none">
        <div class="survey-bg"></div>
        <div class="feed-menu">
          <div class="feed-box">
            <a href="#">
              <div class="p-img">
                <img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAQAAAD9CzEMAAAAlElEQVR4Ae3SMQ4CMQxEUZ9myQWn50BIAQ62oA0lYArkagRNJiIS9u/nNba8mQ47HLHBO7vhjAKLDNGCC1zUFYWBA1zYiYFVCjQG7nBlDDwSUAD2LoEPJfD8ByD6FZBAvqnPAHAJzAu00UAdC6xYxgENNea/AXuYJAZ4Xg/EvB7geT0Q83qA5tUAzasB/XwAkhLo6AUCK6P+GIvGtgAAAABJRU5ErkJggg=="
                />
              </div>
              <span>有关此广告的反馈</span>
            </a>
            <a href="#">
              <div class="p-img">
                <img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAQAAAD9CzEMAAACI0lEQVR4Ae3XTUtUURjA8TOkjeBLqYTOZ1CcRW8IWiQuwjaJm6AW9QEiMP7MpIsiiqhFLVq1qRZDw8yHiAQrENpFFFSbGuZKSC+6SEOfJGQYDs95HPTMIvD+Vxee4Xe5M/fcM+5/OfYO3iBeC7hGcjRSBlHqjweMqsBIPOCSClyMB9xWgVvxgLIKlHYGTLBEibHaeQ93WVGBFe7QXZsbo8R3JrYD0nxG/vWeaXo4zxJi9I1z9HKVD1vnn0jbwDWkrjVEz5jKW0CGZWSXLZMJA0+RCD0JAUfZiAJscEQDUrxGIvVKA6YQs6/kGCC92SB5KojZJD7AKVaRYAXacXV1UDSmVzmpfQfDwesqkMJ5pYLEF46FfkV9zKk3px2n1ElVmX7OIetBa+E+4pXDBZpBvO6xb/vFzl8cBoLAkDeZNLaarnsfSweBNm/yT7OBNQMwbtFgEMh6k9XtgVYeIl75IDCLeD2gxV5N5xH8KnTglLpIlOk5+kLAKFVErag+aGVErcKwBoybr5cind7Vl81XkLJUnEXMqswwRNtmWWZJELMz2i2aRyL1AqcBhyO9cNbJ6oDjcRTgES68mv5CdtkPezXNIXX9RuyUqWmcBezn49bgWy5zkCkWEaOESbq5wrvadq3VBhynWaRQtzU/wM3Abukn1+mqzZ3gGQnjO9v8llSg0Ozt+41m/wG5EA8YUYHj8YB+FeiNBzgWEK+XuGiA3h4Qqb+5VDM8HRjcGAAAAABJRU5ErkJggg=="
                />
              </div>
              <span>查看我的 Google 广告设置</span>
            </a>

            <a href="#" onclick="closeFeed()"><span>关闭</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="less" scoped>
.pop {
  position: fixed;
  height: 100vh;
  width: 100vw;
  top: 0;
  left: 0;
  z-index: 999;
  display: flex;
  align-items: center;
  justify-content: center;

  background: rgba(52, 58, 65, 0.6);
}

.pop .box-content {
  background-color: #fff;
  border-radius: 6px;
  padding: 0 6px 1px;
  position: relative;
  box-shadow: 0px 8px 12px rgb(60 64 67 / 15%), 0px 4px 4px rgb(60 64 67 / 30%);
}

.pop .top-box {
  width: 100%;
  display: table;
  height: 24px;
  background-color: #fff;
}

.pop .top-box .left-box {
  font-size: 12px;
  font-weight: 700;
  font-family: "Roboto", arial, sans-serif;
  color: #202124;
  position: relative;
  height: 25px;
  padding: 12px 16px 0;
  float: left;

  display: table;
}

.pop .top-box .right-box {
  opacity: 0.55;
  padding: 12px 2px 0;
  float: right;
  cursor: pointer;
  visibility: visible;
}

.pop .top-box svg {
  height: 1.5em;
  width: 1.5em;
  margin-left: -0.3em;
  margin-right: -0.3em;
  vertical-align: middle;
  padding-bottom: 1px;
}

/*底部*/
.pop .button-box {
  width: 746px;
}

.pop .button-box .content-top {
  padding: 11.84px 17px;
}

/*标题*/
.pop .button-box .title {
  font-size: 50px;
  color: rgba(0, 0, 0, 0.79);
  font-weight: 500;
  line-height: 1.3;
  letter-spacing: 0.02em;
}

/*内容*/
.pop .button-box .content {
  font-size: 28px;
  padding: 11.84px 0 0;
  color: rgba(0, 0, 0, 0.6);
  letter-spacing: 0.02em;
}

/*内如底部*/
.pop .button-box .content-button {
  display: flex;
  align-items: center;
  padding: 23.68px 18px 28px;
}

/*品牌LOGO*/
.pop .button-box .t-logo {
  width: 100%;
}
.pop .button-box .t-logo img {
  max-width: 300px;
  max-height: 95px;
}

/*按钮*/
.pop .button-box .t-button {
  font-size: 15px;
  height: 40px;
  line-height: 40px;
  max-height: 40px;

  border-radius: 4px;
  box-shadow: 0 6px 12px rgb(134 140 150 / 65%);
  cursor: pointer;
  background-color: #fff;
  outline: none;

  box-sizing: border-box;
  font-weight: 400;
  text-align: center;
  width: 50%;
  display: flex;
  align-items: center;
  justify-content: center;

  margin-left: 20px;
}

.pop .button-box .style-button {
  color: white;
  background-color: #0088ff;
}

/*反馈*/
.pop .box-content .survey-bg {
  background-color: rgba(0, 0, 0, 0.8);
  bottom: 0px;
  opacity: 1;
  overflow-y: auto;
  position: absolute;
  left: 0px;
  top: 0px;
  width: 100%;
  z-index: 10000;
}

.pop .feed-menu {
  position: absolute;
  z-index: 10000;
  top: 15px;
  left: 15px;
}

.pop .feed-box {
  padding: 5px 0;
  margin: 0;
  box-shadow: 0 0 3px 3px rgb(0 0 0 / 20%);
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  background-color: #ffffff;
}

.pop .feed-box a {
  box-sizing: border-box;
  display: table;
  padding: 0 14px;
  width: 100%;
}

.pop .feed-box a div {
  display: table-cell;
  vertical-align: middle;
}

.pop .feed-box .p-img {
  width: 35px;
}

.pop .feed-box img {
  height: 21px;
  margin: 3px 14px 0 0;
}

.pop .feed-box a span {
  display: inline-block;
  color: #212121;
  font-family: "Roboto-Regular", arial, sans-serif;
  font-size: 14px;
  margin: 11px 0;
  max-width: 224px;
}

/*移动优化*/
@media only screen and (max-width: 767px) {
  .pop .button-box {
    width: 90vw;
  }

  .pop .button-box .title {
    font-size: 26px;
  }

  .pop .button-box .content {
    font-size: 14px;
  }
  .pop .button-box .t-logo img[data-v-e37e5560] {
    max-width: 120px;
    max-height: 60px;
  }
}
</style>
