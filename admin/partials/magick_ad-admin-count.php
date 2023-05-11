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
        $start_date = '';
        $end_date = '';
        $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : 'all';
        $date_filters = [
            'today' => '今天',
            'yesterday' => '昨天',
            'last_week' => '过去一周',
            'this_month' => '本月',
            'last_month' => '上月',
            'all' => '总计',
        ];

        $filter_options = '';
        foreach ($date_filters as $key => $label) {
            $selected = ($key === $date_filter) ? 'selected' : '';
            $filter_options .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $label);
        }

        if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
        }

        $table_name = $wpdb->prefix . 'npc_ad_count';
        $where_clause = '';

        switch ($date_filter) {
            case 'today':
                $where_clause = "WHERE DATE(ad_time) = CURDATE()";
                break;
            case 'yesterday':
                $where_clause = "WHERE DATE(ad_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                break;
            case 'last_week':
                $where_clause = "WHERE ad_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
                break;
            case 'this_month':
                $where_clause = "WHERE YEAR(ad_time) = YEAR(CURDATE()) AND MONTH(ad_time) = MONTH(CURDATE())";
                break;
            case 'last_month':
                $where_clause = "WHERE PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM ad_time)) = 1";
                break;
            default:
                $where_clause = "";
                break;
        }

        if (!empty($start_date) && !empty($end_date)) {
            $where_clause = sprintf("WHERE DATE(ad_time) BETWEEN '%s' AND '%s'", $start_date, $end_date);
        }

        //$rows = $wpdb->get_results("SELECT ad_id, DATE(ad_time) as date, COUNT(*) as count FROM $table_name $where_clause GROUP BY ad_id, DATE(ad_time)");
        $rows = $wpdb->get_results("SELECT ad_id, DATE(ad_time) as date, COUNT(*) as count
    FROM $table_name $where_clause
    GROUP BY ad_id, DATE(ad_time)
    ORDER BY MIN(ad_time) ASC, ad_id ASC");

        echo '<h1>广告统计</h1>';
        echo '<form method="post">';
        echo '<select name="date_filter">';
        echo $filter_options;
        echo '</select>';

        echo '<label for="start_date">开始日期：</label>';
        echo sprintf('<input type="date" name="start_date" id="start_date" value="%s">', $start_date);
        echo '<label for="end_date">结束日期：</label>';
        echo sprintf('<input type="date" name="end_date" id="end_date" value="%s">', $end_date);

        echo '<input type="submit" value="筛选">';
        echo '</form>';

        //echo '<table class="widefat">';
        //echo '<thead><tr><th>ID</th><th>展示日期</th><th>展示次数</th></tr></thead>';
        //echo '<tbody>';
        //foreach ($rows as $row) {
        //    echo sprintf('<tr><td>%d</td><td>%s</td><td>%d</td></tr>', $row->ad_id, $row->date, $row->count);
        //}
        //echo '</tbody>';
        //echo '</table>';

        //---------------------------------获取数据

        $data = array();
        //echo var_dump($rows);
        foreach ($rows as $row) {
            $data[] = array(

                'id' => $row->ad_id, //广告ID
                'date' => $row->date, //时间
                'count' => $row->count, //展现次数
            );
        }

        // Enqueue the script file
        wp_enqueue_script('my-image-views-vue',  plugin_dir_url( __DIR__ ) . 'js/vue.global.js', array(), '1.0', true);
        wp_enqueue_script('my-image-views-echarts',  plugin_dir_url( __DIR__ ) . 'js/echarts.js', array(), '1.0', true);
        wp_enqueue_script('my-image-views-script',  plugin_dir_url( __DIR__ ) . 'js/my-image-views.js', array(), '1.7', true);

        wp_add_inline_script('my-image-views-script', sprintf('const imageViewsData = %s;', json_encode($data)), 'before');

        // Display the menu HTML

        echo '
        <br />

        <div id="Application"></div>

    ';
    }
}
