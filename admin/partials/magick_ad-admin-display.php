<?php

/**
 * 为插件提供管理区域视图
 *
 * 该文件用于标记插件的面向管理的方面。
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 */

/**
 * 插件的管理员的功能。
 *
 * 执行一些动作
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 * @author     Mzue <1355471563@qq.com>
 */

class Magick_ad_Admin_Display
{

  public function add_hello_header($version)
  {
    echo '<div style="background-color: #ccb1b1; text-align: center;">我在类中的，当前插件版本是：';
    echo $version;
    echo '</div>';
  }
}

?>