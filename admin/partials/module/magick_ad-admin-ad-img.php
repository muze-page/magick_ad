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



class Magick_ad_Admin_Ad_Img
{

    /**
     * 处理内容中的值
     * @since    1.0.0
     * @param    string $content 待处理的广告内容
     * @param    array $option 广告选项
     *  @param    array $option 监听选项
     * @return string $data 处理好的广告内容
     */
    public static function handle_img($content, $option, $listen)
    {
        //进行处理
        $url_obj = self::handle_url($content['link']);
        $img_obj = self::handle_imgs($content['img']);

        //组装广告统计选项
        $listen_obj = self::handle_listen($listen);

        $load_views = $listen_obj['view'] ? "record_image_view({id:{$listen_obj['id']},type:\"view\"})" : '';
        $load_click = $listen_obj['click'] ? "record_image_click({id:{$listen_obj['id']},type:\"click\"})" : '';

        //组装水印
        $watermark_switch = $option['watermark'] == 1;
        $watermark = $watermark_switch ? "<div class='mgad_tag'>广告</div>" : '';

        //拼接 HTML 代码
        $html = "<div class='mgad_block_img'
        style='
    max-width: {$option["max-width"]}px;
    margin: 0 auto;
'
        >";
        $html .= $watermark;
        if (!empty($url_obj)) {
            $html .= "<a href='{$url_obj["link"]}' target='{$url_obj["target"]}' title='{$url_obj["title"]}' onClick='{$load_click}'>";
        }
        $html .= "<img src='{$img_obj["url"]}' alt='{$img_obj["alt"]}' title='{$img_obj["description"]}' onload='{$load_views}'
         style='
         border-radius:{$option["radian"]}px;
         margin:{$option["top"]}px {$option["right"]}px {$option["bottom"]}px {$option["left"]}px;
        
         '>";
        if (!empty($url_obj)) {
            $html .= "</a>";
        }
        $html .= "</div>";

        return $html;
    }




    /**
     * @param Array $array 待处理链接数组
     */
    private static function handle_url($array)
    {
        $obj = array();
        if (is_array($array) && !empty($array)) {

            //拿到链接
            $obj['link'] = $array['url'];
            //拿到描述
            $obj['title'] = $array['title'];
            //拿到跳转
            $obj['target'] = $array['target'];
        }
        return $obj;
    }
    /**
     * @param Array $array 待处理图片资源数组
     */
    private static function handle_imgs($array)
    {
        $obj = array();
        //非空数组
        if (is_array($array) && !empty($array)) {
            //拿到图片链接 - 原图
            $obj['url'] = $array['url'];
            //拿到图片描述
            $obj['alt'] = $array['alt'];
            //替代文本
            $obj['description'] = $array['description'];
        }
        return $obj;
    }
    /**
     * @param Array $listen 待处理设置数组
     */
    private static function handle_listen($array)
    {
        $obj = array();
        //非空数组
        if (is_array($array) && !empty($array)) {
            //拿到监听名
            $obj['name'] = $array['ad_name'];
            //拿到监听ID
            $obj['id'] = $array['ad_id'];
            //拿到监听 - 查阅开关
            $obj['view'] = $array['view'] == 1;
            //拿到监听 - 点击开关
            $obj['click'] = $array['click'] == 1;
        }
        return $obj;
    }
}
