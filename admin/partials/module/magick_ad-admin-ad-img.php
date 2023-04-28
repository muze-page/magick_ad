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

// Array
//                        (
//                            [img] => Array
//                                (
//                                    [ID] => 2324
//                                    [id] => 2324
//                                    [title] => 2023030909475294
//                                    [filename] => 2023030909475294.jpg
//                                    [filesize] => 53857
//                                    [url] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                    [link] => http://magick.plugin/2261/attachment/2023030909475294
//                                    [alt] => 简单的替代文本
//                                    [author] => 1
//                                    [description] => 简简单单的描述
//                                    [caption] => 有趣的说明文字
//                                    [name] => 2023030909475294
//                                    [status] => inherit
//                                    [uploaded_to] => 2261
//                                    [date] => 2023-03-09 09:47:52
//                                    [modified] => 2023-03-15 08:03:48
//                                    [menu_order] => 0
//                                    [mime_type] => image/jpeg
//                                    [type] => image
//                                    [subtype] => jpeg
//                                    [icon] => http://magick.plugin/wp-includes/images/media/default.png
//                                    [width] => 736
//                                    [height] => 414
//                                    [sizes] => Array
//                                        (
//                                            [thumbnail] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [thumbnail-width] => 150
//                                            [thumbnail-height] => 84
//                                            [medium] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [medium-width] => 300
//                                            [medium-height] => 169
//                                            [medium_large] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [medium_large-width] => 580
//                                            [medium_large-height] => 326
//                                            [large] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [large-width] => 580
//                                            [large-height] => 326
//                                            [1536x1536] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [1536x1536-width] => 736
//                                            [1536x1536-height] => 414
//                                            [2048x2048] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [2048x2048-width] => 736
//                                            [2048x2048-height] => 414
//                                            [post-thumbnail] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [post-thumbnail-width] => 736
//                                            [post-thumbnail-height] => 414
//                                            [twentytwenty-fullscreen] => http://magick.plugin/wp-content/uploads/2023/02/2023030909475294.jpg
//                                            [twentytwenty-fullscreen-width] => 736
//                                            [twentytwenty-fullscreen-height] => 414
//                                        )
//
//                                )
//
//                            [link] => Array
//                                (
//                                    [title] => Apple 与全球供应商携手推广可再生电力，近 70 家中国生产合作伙伴已承诺仅使用清洁能源
//                                    [url] => http://magick.plugin/2351
//                                    [target] => 
//                                )
//
//                        )

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
        $data = "asdf" . $content . "asdf";
        return $data;
        //return '666';
    }
}
