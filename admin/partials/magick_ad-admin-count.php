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
        //添加菜单
        self::ad_menu();
    }

    // 处理图片展示次数ajax请求
    private static function record_image_view()
    {
        $record_ad_view = function () {

            $data = json_decode(stripslashes($_POST['data']), true);

            $ad_id = $data['id'];
            $type = $data['type'];
            // 验证 $type 的值是否合法
            if (!in_array($type, array('click', 'view'))) {
                // 抛出异常或返回错误响应
                // throw new Exception('Invalid type value');
                $response = array('success' => false, 'data' => 'type 类型错误，不是click或是view类型');
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                wp_die();
            }



            global $wpdb;
            $table_name = $wpdb->prefix . 'npc_ad_count';
            // 插入记录到数据库中
            $result = $wpdb->insert(
                $table_name,
                array(
                    'ad_id' => $ad_id,
                    'ad_type' => $type,

                )
            );
            // 返回响应给前端 AJAX 请求
            if ($result === false) {
                $response = array('success' => false, 'data' => $wpdb->last_error);
            } else {
                $response = array('success' => true, 'data' => 'Success!');
            }

            echo json_encode($response);
            //用于终止 PHP 的运行，可以避免在处理 AJAX 请求时生成多余的 HTML 代码。
            wp_die();
        };
        add_action("wp_ajax_record_image_view", $record_ad_view);
        add_action("wp_ajax_nopriv_record_image_view", $record_ad_view);
    }

    /**
     * // 在 WordPress 后台管理界面仪表盘下添加一个菜单
     */
    private static function ad_menu()
    {

        $menu = function () {
            add_submenu_page(
                'index.php',
                '广告统计',
                '广告统计',
                'manage_options',
                'ad-count',
                array(__CLASS__, 'show_image_views'),
                200
            );
        };
        add_action('admin_menu', $menu);
    }

    /**
     *  显示图片展示次数的函数
     */
    public static function show_image_views()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'npc_ad_count';
        //查下所有时间的统计数据
        $query = "
        SELECT ad_id, ad_type, DATE(ad_time) as ad_date, COUNT(*) as ad_count 
        FROM $table_name
        GROUP BY ad_id, ad_type, ad_date
        ";
        $results = $wpdb->get_results($query);
        //待输出的值
        $adCountData = array();
        foreach ($results as $result) {
            array_push($adCountData, array(
                'id' => $result->ad_id,
                'date' => $result->ad_date,
                'count' => $result->ad_count,
                'type' => $result->ad_type,
            ));
        }
        //echo '<pre>';
        //print_r($data);
        //echo '</pre>';


        // 查询过去 6 个月的详细数据
        $past_6_months = date('Y-m-d H:i:s', strtotime('-6 months'));
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE ad_time > '$past_6_months';");
        //---------------------------------获取数据
        wp_enqueue_style('example-small-css', plugin_dir_url(__DIR__) . 'css/test.css', array(), '2.1126', true);
        wp_enqueue_script('my-image-views-test',  plugin_dir_url(__DIR__) . 'js/test.js', array(), '2.1126', true);
        wp_enqueue_script('my-image-views-script',  plugin_dir_url(__DIR__) . 'js/my-image-views.js', array(), '2.516', true);

        //将数据传给JS
        wp_add_inline_script('my-image-views-script', sprintf('const adCountData = %s;', json_encode($adCountData)), 'before');


        //展示内容
        echo '
        
        
        <div id="mgad_show_count"></div>
        

    ';
    }
}
