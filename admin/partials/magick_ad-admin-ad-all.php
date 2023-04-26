<?php

/**
 * 处理全局广告信息
 *
 * 将全局广告进行处理
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 */

/**
 * 处理全局广告信息
 *
 * 将全局广告进行处理
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 * @author     Mzue <1355471563@qq.com>
 */

class Magick_ad_Admin_Ad_All
{
    /*
    *打印数组用
    */
    public function p($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    /**
     * 获取ACF的配置信息
     */
    public function get_acf_config()
    {
        $arr = array();

        $arr = get_field('add_ad_all', 'options');

        return $arr;
    }

    /**
     * 添加配置信息在网页底部
     */
    public function add_msg_bottom()
    {

        self::p(self::get_acf_config());
    }
}
