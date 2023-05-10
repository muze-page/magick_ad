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
        //判断数组是否存在且有值
        $switch_arr = isset($array) && !empty($array);
        if (!$switch_arr) {
            return "数组无值或不存在！";
        }

        foreach ($config as $my_content) {
            //拿到广告内容
            $ad_content = $my_content['content'];
            //拿到展示页面
            $condition = $my_content['option']['show_page'];
            //拿到展示位置
            $position = $my_content['option']['show_position'];


            //通用
            switch ($position) {
                    //页面顶部
                case 'wp_head':
                    self::add_ad_wp_head($condition, $ad_content);
                    break;
                    //页面底部
                case 'wp_footer':
                    self::add_ad_wp_footer($condition, $ad_content);
                    break;

                    //页面循环前
                case 'loop_start':
                    self::add_ad_loop_start($condition, $ad_content);
                    break;

                    //页面循环后
                case 'loop_end':
                    self::add_ad_loop_end($condition, $ad_content);
                    break;

                    //文章内容前
                case 'single_before':
                    self::add_ad_single_before($condition, $ad_content);
                    break;

                    //文章内容第三段
                case 'single_three':
                    self::add_ad_single_three($condition, $ad_content);
                    break;

                    //文章内容后
                case 'single_after':
                    self::add_ad_single_after($condition, $ad_content);
                    break;

                    //评论区列表上方
                case 'add_comment_text_before':
                    self::add_ad_add_comment_text_before($condition, $ad_content);
                    break;
                    //评论框上方
                case 'comment_form_before':
                    self::add_ad_comment_form_before($condition, $ad_content);
                    break;
                    //评论框下方
                case 'comment_form_after':
                    self::add_ad_comment_form_after($condition, $ad_content);
                    break;
            }
        }
    }



    /**
     * 添加广告到页面顶部
     */
    private static function add_ad_wp_head($condition, $ad_content)
    {
        add_filter('wp_head', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                echo $ad_content;
            }
        });
    }
    /**
     * 添加广告到页面底部
     */
    private static function add_ad_wp_footer($condition, $ad_content)
    {
        add_filter('wp_footer', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                echo $ad_content;
            }
        });
    }

    /**
     * 添加广告到循环前
     */
    private static function add_ad_loop_start($condition, $ad_content)
    {
        add_filter('loop_start', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //是主循环吗？
                if (is_main_query()) {
                    // do stuff
                    echo $ad_content;
                }
            }
        });
    }
    /**
     * 添加广告到循环后
     */
    private static function add_ad_loop_end($condition, $ad_content)
    {
        add_filter('loop_end', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //是主循环吗？
                if (is_main_query()) {
                    // do stuff
                    echo $ad_content;
                }
            }
        });
    }

    /**
     * 添加广告到内容前
     */
    private static function add_ad_single_before($condition, $ad_content)
    {
        add_filter('the_content', function ($content) use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                $ad_content .=  $content;
                echo $ad_content;
            }
        });
    }
    /**
     * 添加广告到第三段
     */
    private static function add_ad_single_three($condition, $ad_content)
    {
        add_filter('the_content', function ($content) use ($condition, $ad_content) {
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
    /**
     * 添加广告到内容后
     */
    private static function add_ad_single_after($condition, $ad_content)
    {
        add_filter('the_content', function ($content) use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                $ad_content =  $content . $ad_content;
                echo $ad_content;
            }
        });
    }

    /**
     * 添加广告到评论列表开始前
     */
    private static function add_ad_add_comment_text_before($condition, $ad_content)
    {
        add_filter('comments_template', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //判断开启了评论且评论数大于1
                if (comments_open() && get_comments_number() > 0) {
                    echo $ad_content;
                }
            }
        });
    }
    /**
     * 添加广告到评论框的开始
     */
    private static function add_ad_comment_form_before($condition, $ad_content)
    {
        add_filter('comment_form_before', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //是否开启了评论框
                if (comments_open()) {
                    echo $ad_content;
                }
            }
        });
    }
    /**
     * 添加广告到评论框结束后
     */
    private static function add_ad_comment_form_after($condition, $ad_content)
    {
        add_filter('comment_form_after', function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                if (comments_open()) {
                    echo $ad_content;
                }
            }
        });
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
