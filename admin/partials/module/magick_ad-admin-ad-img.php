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

        //图片链接
        $url = $content['link'];
        //进行处理
        $url_obj = self::handle_url($url);




        //拿到图片
        $img = $content['img'];
        //进行处理
        $img_obj = self::handle_imgs($img);



        //拿水印开关
        $watermark_switch = $option['watermark'];
        $watermark = $watermark_switch == 1 ? "<div class='mgad_tag'>广告</div>" : '';
        //圆角弧度
        $radian = $option['radian'] . 'px';


        //统计选项
        //获取计划名
        $name = $listen['ad_name'];
        //获取唯一ID
        $id = $listen['ad_id'];
        //展示开关
        $switch_view = $listen['view'];
        //点击开关
        $switch_click = $listen['click'];

        //组合数据
        $load_views = $switch_view == 1 ? "record_image_view({id:" . $id . ",type:'view'})" : '';
        $load_click = $switch_click == 1 ? "record_image_click({id:" . $id . ",type:'click'})" : '';










        //准备图片 - 原图
        $right_img = "<img 
        src=\"{$img_obj['url']}\" 
        alt=\"{$img_obj['alt']}\" 
        title=\"{$img_obj['description']}\"
        onload=\"{$load_views}\"
        style='border-radius:" . $radian . ";'
        >";

        if (!empty($url_obj)) {
            //链接中有值
            $head = "<a 
        href=\"{$url_obj['link']}\" 
        target=\"{$url_obj['target']}\" 
        title=\"{$url_obj['title']}\"
        onClick=\"{$load_click}\"
        
        >";
            $tail = "</a>";

            //拼接

            $data = "<div class='mgad_block_img'>" . $watermark . $head . $right_img . $tail  . "</div>";
        } else {
            //拼接

            $data = "<div class='mgad_block_img'>" . $watermark  . $right_img   . "</div>";
        }



        return $data;
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
