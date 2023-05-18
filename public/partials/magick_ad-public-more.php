<?php

/**
 * 更多广告数据
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/public
 */

/**
 * 更多广告数据
 *
 * 将后台的广告数据整理后放入前台本地存储
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/public
 * @author     Mzue <1355471563@qq.com>
 */

class Magick_ad_Public_More
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
     * 测试用
     */
    public function add_hello_header($version)
    {
        echo '<div style="background-color: #ccb1b1; text-align: center;">我在前台中的，当前插件版本是：';
        echo $version;
        echo '</div>';
    }
    /**
     * 接受数据并处理
     */
    
}
