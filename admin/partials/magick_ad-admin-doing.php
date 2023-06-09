<?php

/**
 * 添加位置列表
 * wp_head : 页面顶部
 * wp_footer : 页面底部
 * the_post : 文章或页面前（与循环前重复）
 * loop_start : 循环前
 * loop_end : 循环后
 * single_before : 文章顶部
 * single_three : 文章第三段
 * single_after : 文章底部
 * add_comment_text_before : 评论列表上方
 * comment_form_before : 评论框上方
 * comment_form_after : 评论框下方
 */
/**
 * 分类
 * category_description : 分类名下，分类描述广告
 */

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

class Magick_ad_Admin_Doing
{

    /**
     * 加载广告内容
     * @param array $config  包含内容的选项数组
     */
    public static function do_ad_content($config)
    {
        // 判断传来的值是否是数组
        if (!is_array($config)) {

            return "数组无值或不存在! - Magick_ad_Admin_Doing";
        }

        foreach ($config as $my_content) {
            $options = $my_content['option'];
            //拿到广告内容
            $ad_content = $my_content['content'];
            //拿到展示页面
            $condition = $options['show_page'];
            //指定广告兼容
            //拿到展示位置-若存在就拿，若不存在，就是指定广告
            if (isset($options['show_position'])) {
                $position = $options['show_position'];
            } else {
                $position = "is_404"; //给个默认值以防报错，反正下面的判断会覆盖这里的值

            }



            //指定广告兼容
            //如果展示页面是is_singular,开始检查是否存在post数组，存在则使用该数组中的值
            if ($condition === "is_singular") {
                //在ACF插件页会报错，这里再判断下
                //获取当前页的ID
                $current_page_id = get_queried_object_id();
                if ($current_page_id !== 0) {
                    //判断是否存在post数组
                    if (isset($options['post'])) {

                        //判断当前页面ID是否是指定的ID
                        global $post;

                        echo "<pre>";
                        print_r($post);
                        echo "</pre>";

                        echo "669";
                        if (in_array($post->ID, $options['post']['data'])) {
                            //改为指定文章设置的位置
                            $position = $options['post']['position'];
                        }
                    }
                }
            }
            //如果展示页面是is_Category,开始检查是否存在Category数组，存在则使用该数组中的值
            if ($condition === "is_category") {

                //判断是否存在post数组
                if (isset($options['category'])) {

                    //判断当前页面ID是否是指定的ID
                    global $cat;
                    if (in_array($cat, $options['category']['data'])) {
                        //改为指定文章设置的位置
                        $position = $options['category']['position'];
                    }
                }
            }
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

                    //文章/页面前
                case 'the_post':
                    self::add_ad_the_post($condition, $ad_content);
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
                    //分类页-分类名下-分类描述
                case 'category_description':
                    self::add_ad_category_description($condition, $ad_content);
                    break;
            }
        }
    }



    /**
     * 页面顶部。
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_wp_head($condition, $ad_content)
    {
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                echo $ad_content;
            }
        };

        add_filter('wp_head', $ad_callback);
    }

    /**
     * 页面底部。
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_wp_footer(callable $condition, $ad_content)
    {
        // 定义一个广告回调函数
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                echo $ad_content;
            }
        };

        // 在 wp_footer 钩子中添加广告回调函数
        add_filter('wp_footer', $ad_callback);
    }


    /**
     * 页面主循环前。
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $content   要显示的广告内容。
     */
    private static function add_ad_loop_start($condition, $ad_content)
    {
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //是主循环吗？
                if (is_main_query()) {
                    // do stuff
                    echo $ad_content;
                }
            }
        };
        add_filter('loop_start', $ad_callback);
    }

    /**
     * 页面主循环后。
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_loop_end($condition, $ad_content)
    {
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //是主循环吗？
                if (is_main_query()) {
                    // do stuff
                    echo $ad_content;
                }
            }
        };
        add_filter('loop_end', $ad_callback);
    }


    /**
     * 文章或页面内容前-功能重复，废弃中。
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_the_post($condition, $ad_content)
    {

        $ad_callback = function () use ($condition, $ad_content) {
            //保底输出空值
            $new_content = "";
            if (call_user_func($condition)) {
                $new_content = $ad_content;
            }
            echo $new_content;
            return $new_content;
        };
        add_filter('the_post', $ad_callback);
    }


    /**
     * 文章或页面的内容前
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_single_before($condition, $ad_content)
    {

        $ad_callback = function ($content) use ($condition, $ad_content) {
            //保底输出，有则加，无则原
            $new_content = $content;
            if (call_user_func($condition)) {
                $new_content = $ad_content . $content;
            }
            return $new_content;
        };
        add_filter('the_content', $ad_callback);
    }

    /**
     * 文章或页面的内容第三段后
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_single_three($condition, $ad_content)
    {
        $ad_callback = function ($content) use ($condition, $ad_content) {
            //保底输出，有则加，无则原
            $res = $content;
            if (call_user_func($condition)) {
                $paragraphs = explode('</p>', $content); // 按照 </p> 分割文章内容
                if (count($paragraphs) >= 3) { // 如果文章至少有 3 段
                    // 在第三段的结尾处添加自定义文本
                    $paragraphs[2] .= $ad_content;
                    // 将各段重新连接起来
                    $res = implode('</p>', $paragraphs);
                }
            }
            return $res;
        };

        add_filter('the_content', $ad_callback);
    }

    /**
     * 文章或页面的内容后
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_single_after($condition, $ad_content)
    {
        $ad_callback = function ($content) use ($condition, $ad_content) {
            //保底输出，有则加，无则原
            $res = $content;
            if (call_user_func($condition)) {
                $res =  $content . $ad_content;
            }
            return $res;
        };
        add_filter('the_content', $ad_callback);
    }


    /**
     * 评论列表开始前
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_add_comment_text_before($condition, $ad_content)
    {
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //判断开启了评论且评论数大于1
                if (comments_open() && get_comments_number() > 0) {
                    echo $ad_content;
                }
            }
        };

        add_filter('comments_template', $ad_callback);
    }


    /**
     * 评论框开始前
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_comment_form_before($condition, $ad_content)
    {
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                //是否开启了评论框
                if (comments_open()) {
                    //开启评论的
                    echo $ad_content;
                }
            }
        };
        add_filter('comment_form_before', $ad_callback);
    }


    /**
     * 评论框开始后
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_comment_form_after($condition, $ad_content)
    {
        $ad_callback = function () use ($condition, $ad_content) {
            if (call_user_func($condition)) {
                if (comments_open()) {
                    //开启评论的
                    echo $ad_content;
                }
            }
        };
        add_filter('comment_form_after', $ad_callback);
    }


    /**
     * 分类页的分类描述后
     *
     * @param callable $condition 指定要显示广告的条件回调函数。
     *                            如果该函数返回 true，则会显示广告；否则不显示。
     * @param string   $ad_content   要显示的广告内容。
     */
    private static function add_ad_category_description($condition, $ad_content)
    {

        $ad_callback = function ($content) use ($condition, $ad_content) {
            //保底输出，有则加，无则原
            $new_content = $content;
            if (call_user_func($condition)) {
                $new_content =  $content . $ad_content;
            }
            return $new_content;
        };
        add_filter('category_description', $ad_callback);
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
