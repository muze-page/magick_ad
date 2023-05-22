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
        $name = $listen['ad_name'];
        $id = $listen['ad_id'];
        $switch_view = $listen['view'] == 1;
        $switch_click = $listen['click'] == 1;
        $load_views = $switch_view ? "record_image_view({id:{$id},type:'view'})" : '';
        $load_click = $switch_click ? "record_image_click({id:{$id},type:'click'})" : '';

        //组装水印
        $watermark_switch = $option['watermark'] == 1;
        $watermark = $watermark_switch ? "<div class='mgad_tag'>广告</div>" : '';

        //拼接 HTML 代码
        $html = "<div class='mgad_block_img'>";
        $html .= $watermark;
        if (!empty($url_obj)) {
            $html .= "<a href='{$url_obj["link"]}' target='{$url_obj["target"]}' title='{$url_obj["title"]}' onClick='{$load_click}'>";
        }
        $html .= "<img src='{$img_obj["url"]}' alt='{$img_obj["alt"]}' title='{$img_obj["description"]}' onload='{$load_views}' style='border-radius:{$option["radian"]}px;'>";
        if (!empty($url_obj)) {
            $html .= "</a>";
        }
        $html .= "</div>";

        return $html;
    }




    /**
     * @param Array $array 待处理链接数组
     */
    private static function handle_url($url)
    {
        $obj = array();
        if (is_array($url)) {

            //拿到链接
            $obj['link'] = $url['url'];
            //拿到描述
            $obj['title'] = $url['title'];
            //拿到跳转
            $obj['target'] = $url['target'];
        }
        return $obj;
    }
    /**
     * @param Array $array 待处理图片资源数组
     */
    private static function handle_imgs($img)
    {
        $obj = array();
        //非空数组
        if (!empty($img)) {
            //拿到图片链接 - 原图
            $obj['url'] = $img['url'];
            //拿到图片描述
            $obj['alt'] = $img['alt'];
            //替代文本
            $obj['description'] = $img['description'];
        }
        return $obj;
    }
}
