(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
})(jQuery);

//url: '<?php echo admin_url('admin-ajax.php'); ?>',
//3小时算一次观看
function record_image_view(data) {
  //发出统计
  const tj = () => {
    jQuery.ajax({
      type: "POST",
      url: public.ajaxurl,
      data: {
        action: "record_image_view",
        data: JSON.stringify(data),
      },
      success: function (response) {
        console.log(response);
        console.log("数据保存成功！");
      },
      error: function (xhr, status, error) {
        console.error(xhr, status, error);
        console.log("数据保存失败！");
      },
    });
  };
  //设定local
  const local = "magick_ad_lastViewTime-" + data.id;

  let lastClickTime = parseInt(localStorage.getItem(local)) || "0";
  //拿到当前时间
  const now = Date.now();
  if (now - lastClickTime < 3 * 60 * 60 * 1000) {
    // 如果与上次点击时间相差不到3小时，则不算一次有效点击
    //console.log("等等吧");
    return;
  }

  // 更新lastClickTime并写入localStorage
  localStorage.setItem(local, now);
  //发出统计请求
  tj(data);
}
//3小时算一次点击
function record_image_click(data) {
  //发出统计
  const tj = () => {
    jQuery.ajax({
      type: "POST",
      url: public.ajaxurl,
      data: {
        action: "record_image_view",
        data: JSON.stringify(data),
      },
      success: function (response) {
        console.log(response);
        console.log("数据保存成功！");
      },
      error: function (xhr, status, error) {
        console.error(xhr, status, error);
        console.log("数据保存失败！");
      },
    });
  };

  //设定local
  const local = "magick_ad_lastClickTime-" + data.id;
  let lastClickTime = parseInt(localStorage.getItem(local)) || "0";
  //拿到当前时间
  const now = Date.now();
  if (now - lastClickTime < 3 * 60 * 60 * 1000) {
    // 如果与上次点击时间相差不到3小时，则不算一次有效点击
    //console.log("等等吧");
    return;
  }

  // 更新lastClickTime并写入localStorage
  localStorage.setItem(local, now);
  //发出统计请求
  tj(data);
}

//重复统计
function record_image_views(data) {
  //开始统计
  const tj = (data) => {
    jQuery.ajax({
      type: "POST",
      url: public.ajaxurl,
      data: {
        action: "record_image_view",
        //需要发送的数据，在此处转换为 JSON 字符串
        data: JSON.stringify(data),
      },
      success: function (response) {
        console.log(response);
        console.log("数据保存成功！");
      },
      error: function (xhr, status, error) {
        console.error(xhr, status, error);
        console.log("数据保存失败！");
      },
    });
  };
  tj(data);
}

jQuery(document).ready(function ($) {
  //图片懒加载
  var images = $("img[data-src]");
  $(window).on("load scroll resize", function () {
    images.each(function () {
      if ($(this).offset().top <= $(window).scrollTop() + $(window).height()) {
        var dataSrc = $(this).attr("data-src");
        $(this).attr("src", dataSrc).removeAttr("data-src");
      }
    });
  });
});

//PHP准备的数据
//console.log(public.ajaxurl);
//console.info(public.ad_public_data);
//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_public_data", obj);
};
//手动添加记录
add(public.ad_public_data);
