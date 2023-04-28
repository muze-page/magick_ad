<?php

/**
 * 处理图片模块
 *
 * 将图片类型的广告进行处理
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 */

/**
 * 处理图片广告信息
 *
 * 将图片广告进行处理
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 * @author     Mzue <1355471563@qq.com>
 */

// [img_content] => Array
//                                (
//                                    [img] => Array
//                                        (
//                                            [ID] => 2365
//                                            [id] => 2365
//                                            [title] => 2023041210122690
//                                            [filename] => 2023041210122690-scaled.jpg
//                                            [filesize] => 525902
//                                            [url] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-scaled.jpg
//                                            [link] => http://magick.plugin/2333/attachment/2023041210122690
//                                            [alt] => 
//                                            [author] => 1
//                                            [description] => 
//                                            [caption] => 
//                                            [name] => 2023041210122690
//                                            [status] => inherit
//                                            [uploaded_to] => 2333
//                                            [date] => 2023-04-12 10:12:26
//                                            [modified] => 2023-04-12 10:12:26
//                                            [menu_order] => 0
//                                            [mime_type] => image/jpeg
//                                            [type] => image
//                                            [subtype] => jpeg
//                                            [icon] => http://magick.plugin/wp-includes/images/media/default.png
//                                            [width] => 2560
//                                            [height] => 1440
//                                            [sizes] => Array
//                                                (
//                                                    [thumbnail] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-150x150.jpg
//                                                    [thumbnail-width] => 150
//                                                    [thumbnail-height] => 150
//                                                    [medium] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-300x169.jpg
//                                                    [medium-width] => 300
//                                                    [medium-height] => 169
//                                                    [medium_large] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-768x432.jpg
//                                                    [medium_large-width] => 580
//                                                    [medium_large-height] => 326
//                                                    [large] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-1024x576.jpg
//                                                    [large-width] => 580
//                                                    [large-height] => 326
//                                                    [1536x1536] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-1536x864.jpg
//                                                    [1536x1536-width] => 1536
//                                                    [1536x1536-height] => 864
//                                                    [2048x2048] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-2048x1152.jpg
//                                                    [2048x2048-width] => 2048
//                                                    [2048x2048-height] => 1152
//                                                    [post-thumbnail] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-1568x882.jpg
//                                                    [post-thumbnail-width] => 1200
//                                                    [post-thumbnail-height] => 675
//                                                    [twentytwenty-fullscreen] => http://magick.plugin/wp-content/uploads/2023/03/2023041210122690-scaled.jpg
//                                                    [twentytwenty-fullscreen-width] => 1980
//                                                    [twentytwenty-fullscreen-height] => 1114
//                                                )
//
//                                        )
//
//                                    [link] => Array
//                                        (
//                                            [title] => Apple 与全球供应商携手推广可再生电力，近 70 家中国生产合作伙伴已承诺仅使用清洁能源
//                                            [url] => http://magick.plugin/2351
//                                            [target] => 
//                                        )
//
//                                )

class Magick_ad_Admin_Ad_Img
{

    /**
     * 处理内容中的值
     * @since    1.0.0
     * @param    string $content 待处理的广告内容
     * @return string $data 处理好的广告内容
     */
    public static function handle_img($content)
    {


        $url = $content['link'];
        //拿到链接
        $url_link = $url['url'];
        //拿到描述
        $url_title = $url['title'];
        //拿到跳转
        $url_target = $url['target'];
        //进行处理
        //if ($url_link) {
        //    $url_link = 'href=' . $url_link;
        //}
        //if ($url_target) {
        //    $url_target = 'target=' . $url_target;
        //}

        //拿到图片
        $img = $content['img'];
        //拿到图片链接 - 原图
        $img_url = $img['url'];



        //拿到图片描述
        $img_alt = $img['alt'];
        //替代文本
        $img_title = $img['description'];
        //合并输出






        //准备链接
        $head = "<a href=\"{$url_link}\" target=\"{$url_target}\" title=\"{$url_title}\">";
        $tail = "</a>";

        //准备图片 - 原图
        $right_img = "<img src=\"{$img_url}\" alt=\"{$img_alt}\" title=\"{$img_title}\">";


        //拼接

        $data = $head . $right_img . $tail;

        return $data;
    }

    /**
     * 处理附加信息
     * @param string $name 待输出标签
     */
    public static function handle_meat($name, $data)
    {
        if ($data) {
            $content = $name . $data;
        }
        return $content;
    }
}
