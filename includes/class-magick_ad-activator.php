<?php

/**
 * 在插件激活期间激发
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 */

/**
 * 在插件激活过程中激发。
 *
 * 这个类定义了在插件激活期间运行所需的所有代码。
 *
 * @since      1.0.0
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 * @author     Mzue <1355471563@qq.com>
 */
class Magick_ad_Activator
{

	/**
	 * 简短描述。（使用期限）
	 *
	 * 详细描述。
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		create_image_view_table();
	}
	// 创建图片展示次数表
	public static function create_image_view_table()
	{
		global $wpdb;
		//表名
		$table_name = $wpdb->prefix . 'npc_ad_counts';
		$charset_collate = $wpdb->get_charset_collate();
		// 检查数据库中是否已存在该表格
		$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
		if (!$table_exists) {
			$sql = "CREATE TABLE $table_name (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				identify BIGINT(20) UNSIGNED NOT NULL,
				click_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			) $charset_collate;";
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta($sql);
		}
	}
}
