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
     * @param array $config  包含内容的选项数组
     */
    public static function do_ad_content($config)
    {


        foreach ($config as $my_content) {
            //拿到广告内容
            $ad_content = $my_content['content'];
            //拿到展示页面
            $condition = $my_content['option']['show_page'];
            //拿到展示位置
            $position = $my_content['option']['show_position'];


            //文章标题上方添加内容
            if ($position == 'title_top') {
                add_action('the_title', function ($title, $id) use ($condition, $ad_content) {
                    if (call_user_func($condition) && $id == get_the_ID()) {
                        $title =  $ad_content . $title;
                    }
                    return $title;
                }, 10, 2);
            }
            //文章标题下方添加内容
            if ($position == 'title_bottom') {
                add_action('the_title', function ($title, $id) use ($condition, $ad_content) {
                    if (call_user_func($condition) && $id == get_the_ID()) {
                        $title .=  $ad_content;
                    }
                    return $title;
                }, 10, 2);
            }

            //文章内容上方
            if ($position == 'single_top') {
                add_action('the_content', function ($cont) use ($condition, $ad_content) {
                    if (call_user_func($condition)) {
                        $ad_content .=  $cont;
                        echo $ad_content;
                    }
                }, 10, 2);
            }
            //文章内容第三段
            if ($position == 'single_three') {
                add_action('the_content', function ($content) use ($condition, $ad_content) {
                    if (call_user_func($condition)) {
                        $paragraphs = explode('</p>', $content); // 按照 </p> 分割文章内容
                        if (count($paragraphs) >= 3) { // 如果文章至少有 3 段
                            // 在第三段的结尾处添加自定义文本
                            $paragraphs[2] .= $ad_content;
                            // 将各段重新连接起来
                            $content = implode('</p>', $paragraphs);
                        }
                        echo $content;
                    }
                }, 10, 2);
            }
            //文章内容下方
            if ($position == 'single_bottom') {
                add_action('the_content', function ($cont) use ($condition, $ad_content) {
                    if (call_user_func($condition)) {
                        $ad_content = $cont . $ad_content;
                        echo $ad_content;
                    }
                }, 10, 2);
            }




            //通用
            switch ($position) {
                    //页面顶部
                case 'wp_head':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {

                            echo $ad_content;
                        }
                    });
                    break;
                    //页面底部
                case 'wp_footer':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {
                            echo $ad_content;
                        }
                    });
                    break;

                    //页面循环前
                case 'loop_start':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {
                            if (is_main_query()) {
                                // do stuff
                                echo $ad_content;
                            }
                        }
                    });
                    break;
                    //评论区上方
                case 'comment_form_before':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {
                            echo $ad_content;
                        }
                    });
                    break;
                    //评论区下方
                case 'comment_form_after':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {
                            echo $ad_content;
                        }
                    });
                    break;
            }
        }
    }

    /*
    *打印数组用
    */
    public static function p($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    /**
     * 留存
     */
    public static function do_ad_contents()
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
            $ad_content = $my_content['content'];

            switch ($position) {
                case 'wp_head':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {
                            echo $ad_content;
                        }
                    });
                    break;

                case 'wp_footer':
                    add_action($position, function () use ($condition, $ad_content) {
                        if (call_user_func($condition)) {
                            echo $ad_content;
                        }
                    });
                    break;
            }
        }
    }
}
