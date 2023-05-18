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
     * 接收数据并处理
     */
    public function handle_more_ad($arr)
    {
        // 判断数组是否存在且有值
        if (empty($arr)) {
            return "数组无值或不存在！";
        }

        // 定义输出对象
        $obj = array();

        // 处理弹窗广告数组
        if (isset($arr['popup'])) {
            $popupArr = self::handle_popup($arr['popup']);
            $obj['popup'] = $popupArr;
        }

        // 返回处理后的对象
        return $obj;
    }


    /**
     * 传入弹窗广告数据
     */
    public function handle_popup($arr)
    {
        // 初始化弹窗广告数组
        $popupArr = array(
            'switch' => 'false', // 默认广告未开启
            'type' => '',
            'concise' => array(),
            'google' => array()
        );

        // 判断广告是否开启
        if ($arr['switch'] !== 'off') {

            // 简洁形式广告
            $popupArr['switch'] = 'true';
            if ($arr['switch'] == 'concise') {
                $popupArr['type'] = 'concise';
                $popupArr['concise'] = array(
                    'cycle' => $arr['cycle'],
                    'title' => $arr['title'],
                    'content' => $arr['content'],
                    'debug' => $arr['debug']
                );
            }

            // Google 广告
            if ($arr['switch'] == 'google') {
                $popupArr['type'] = 'google';
                $popupArr['google'] = array(
                    'cycle' => $arr['cycle'],
                    'title' => $arr['title'],
                    'content' => $arr['content'],
                    'debug' => $arr['debug'],
                    'link' => $arr['google_button-link'],
                    'text_open' => $arr['google_button-text'],
                    'logo' => $arr['google_logo']
                );
            }
        }

        return $popupArr;
    }
}
