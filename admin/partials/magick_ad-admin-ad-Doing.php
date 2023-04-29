<?php

/**
 * 将广告数组加载到页面
 *
 * 将传来的广告数组加载到页面
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 */

/**
 * 将广告数组加载到页面
 *
 * 将传来的广告数组加载到页面
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 * @author     Mzue <1355471563@qq.com>
 */

class Magick_ad_Admin_Ad_Doing
{

    /**
     * 加载广告内容
     */
    public function do_ad_content()
    {


        $my_contents = array(
            array(
                'position' => 'wp_head',
                'condition' => 'is_single',
                'content' => '我是第一段话1<br/>'
            ),
            array(
                'position' => 'wp_head',
                'condition' => 'is_single',
                'content' => '我是第二段话2<br/>'
            )

        );

        foreach ($my_contents as $my_content) {
            $position = $my_content['position'];
            $condition = $my_content['condition'];
            $content = $my_content['content'];

            switch ($position) {
                case 'wp_head':
                    add_action($position, function () use ($condition, $content) {
                        if (call_user_func($condition)) {
                            echo $content;
                        }
                    });
                    break;

                case 'wp_footer':
                    add_action($position, function () use ($condition, $content) {
                        if (call_user_func($condition)) {
                            echo $content;
                        }
                    });
                    break;
            }
        }
    }
}
