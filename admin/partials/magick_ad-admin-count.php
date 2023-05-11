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
            global $wpdb;
            $table_name = $wpdb->prefix . 'npc_ad_count';

            //获取图片ID
            $image_id = $_POST['image_id'];

            echo "<script>console.log('我打印了')</script>" . $image_id;
            // 插入记录到数据库中
            $wpdb->insert(
                $table_name,
                array(
                    'identify' => $image_id,

                )
            );

            exit;
        };
        add_action("wp_ajax_record_image_view", $record_ad_view);
        add_action("wp_ajax_nopriv_record_image_view", $record_ad_view);
    }
}
