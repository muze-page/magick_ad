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

//3小时算一次
function record_image_view(image_id) {
  console.log("我执行了");
  console.log(image_id);
  //发出统计
  const tj = () => {
    jQuery.ajax({
      type: "POST",
      url: "/wp-admin/admin-ajax.php",
      data: {
        action: "record_image_view",
        image_id: image_id,
      },
      success: function (response) {
        alert(response);
      },
    });
  };

  let lastClickTime = parseInt(localStorage.getItem("lastClickTime")) || "0";
  //拿到当前时间
  const now = Date.now();
  if (now - lastClickTime < 3 * 60 * 60 * 1000) {
    // 如果与上次点击时间相差不到3小时，则不算一次有效点击
    console.log("等等吧");
    return;
  }

  // 更新lastClickTime并写入localStorage
  localStorage.setItem("lastClickTime", now);
  //发出统计请求
  tj();
}

//重复统计
function record_image_views(image_id, name) {
  console.log("我执行了");
  console.log(image_id);
  //开始统计
  const tj = () => {
    jQuery.ajax({
      type: "POST",
      url: "/wp-admin/admin-ajax.php",
      data: {
        action: "record_image_view",
        image_id: image_id,
      },
      success: function (response) {
        //alert(response)
      },
    });
  };
  tj();
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
