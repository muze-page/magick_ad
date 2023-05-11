<?php

/**
 * 广告统计列表
 *
 * 将数据库中的数据展示出来
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 */

/**
 * 统计列表
 *
 * 将数据库中的数据展示出来
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 * @author     Mzue <1355471563@qq.com>
 */

class Magick_ad_Admin_Count
{
    public static function run()
    {
        //处理ajax请求
        self::record_image_view();
    }

    // 处理图片展示次数ajax请求
    private static function record_image_view()
    {
        $record_ad_view = function () {
            $ad_id = $_POST['ad_id'];
            $type = $_POST['type'];


            global $wpdb;
            $table_name = $wpdb->prefix . 'npc_ad_count';
            // 插入记录到数据库中
            $wpdb->insert(
                $table_name,
                array(
                    'ad_id' => $ad_id,
                    'ad_type' => $type,
                    //'ad_id' => "666",
                    //'ad_type' => "click",
                )
            );
            // 返回响应给前端 AJAX 请求
            echo "数据保存成功！";
            //用于终止 PHP 的运行，可以避免在处理 AJAX 请求时生成多余的 HTML 代码。
            wp_die();
        };
        add_action("wp_ajax_record_image_view", $record_ad_view);
        add_action("wp_ajax_nopriv_record_image_view", $record_ad_view);
    }
}
