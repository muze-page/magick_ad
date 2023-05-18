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
            $data = self::handle_popup($arr['popup']);
            $obj['popup'] = $data;
        }

        // 处理两侧广告数组
        if (isset($arr['both_sides'])) {
            $data = self::handle_both_sides($arr['both_sides']);
            $obj['both_sides'] = $data;
        }

        // 处理底部横栏广告数组
        if (isset($arr['bottom_banner'])) {
            $data = self::handle_bottom_banner($arr['bottom_banner']);
            $obj['bottom_banner'] = $data;
        }

        // 返回处理后的对象
        return $obj;
    }


    /**
     * 传入弹窗广告数据
     * 传出处理后的数组
     */
    public function handle_popup($arr)
    {
        // 初始化弹窗广告数组
        $data = array(
            'switch' => 'false', // 默认广告未开启
            'type' => '',
            'concise' => array(),
            'google' => array()
        );

        // 判断广告是否开启
        if ($arr['switch'] == '1') {

            // 简洁形式广告
            $data['switch'] = 'true';
            if ($arr['type'] == 'concise') {
                $data['type'] = 'concise';
                $data['concise'] = array(
                    'cycle' => $arr['cycle'],
                    'title' => $arr['title'],
                    'content' => $arr['content'],
                    'debug' => isset($arr['debug']) && $arr['debug'] == 1 ? 'true' : 'false',
                );
            }

            // Google 广告
            if ($arr['type'] == 'google') {
                $data['type'] = 'google';
                $data['google'] = array(
                    'cycle' => $arr['cycle'],
                    'title' => $arr['title'],
                    'content' => $arr['content'],
                    'debug' => isset($arr['debug']) && $arr['debug'] == 1 ? 'true' : 'false',
                    'link' => $arr['google_button-link'],
                    'text_open' => $arr['google_button-text'],
                    'logo' => $arr['google_logo']
                );
            }
        }

        return $data;
    }
    /**
     * 处理两侧广告
     */
    public function handle_both_sides($arr)
    {
        // 初始化弹窗广告数组
        $data = array(
            'switch' => 'false', // 默认广告未开启
            'type' => '',
            'default' => array(),
        );
        // 判断广告是否开启
        if (isset($arr['switch']) && $arr['switch'] == '1') {
            // 设置广告详情
            $data = array(
                'switch' => 'true',
                'type' => 'default',
                'default' => array(
                    'left_content' => $arr['left_content'],
                    'right_content' => $arr['right_content'],
                    'sides' => $arr['sides'],
                    'top' => $arr['top'],
                ),
            );
        }

        return $data;
    }

    /**
     * 传入横幅广告数组
     * 传出横幅广告数组
     */
    public function handle_bottom_banner($arr)
    {
        // 初始化弹窗广告数组
        $data = array(
            'switch' => 'false', // 默认广告未开启
            'type' => '',
            'footer' => array(),
        );

        // 判断设备类型
        $device = wp_is_mobile() ? 'phone' : 'computer';

        // 判断广告是否开启
        if (isset($arr['switch']) && $arr['switch'] == '1') {

            // 设置 display 值
            if ($arr['display'] == 'all') {
                $display = 'true';
            } elseif ($arr['display'] == 'computer' && $device == 'computer') {
                $display = 'true';
            } elseif ($arr['display'] == 'phone' && $device == 'phone') {
                $display = 'true';
            } else {
                $display = 'false';
            }

            // 设置广告详情
            $data = array(
                'switch' => 'true',
                'type' => 'footer',
                'footer' => array(
                    'cycle' => $arr['cycle'],
                    'content' => $arr['content'],
                    'debug' => isset($arr['debug']) && $arr['debug'] == 1 ? 'true' : 'false',
                    'display' => $display,
                ),
            );
        }

        return $data;
    }
}

//请继续改进上述代码，
