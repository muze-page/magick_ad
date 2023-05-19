<?php

/**
 * 在插件停用期间激发
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 */

/**
 * 在插件停用期间激发
 *
 * 这个类定义了在插件停用期间运行所需的所有代码。
 *
 * @since      1.0.0
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 * @author     Mzue <1355471563@qq.com>
 */
class Magick_ad_Deactivator
{

	/**
	 * 简短描述。（使用期限）
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{

		//self::my_plugin_deactivation_hook();


	}

	public static function my_plugin_deactivation_hook()
	{
		wp_die('您的插件已成功禁用!!!666。');
	}
	/**
	 * 删除数据库表
	 */
	public static function remove_sql_table()
	{
		// 获取 $wpdb 全局对象
		global $wpdb;

		// 定义要删除的数据表名
		$table_name = $wpdb->prefix . 'npc_ad_count';

		// 判断数据表是否存在
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			return "数据表不存在！";
		} else {
			// 执行删除数据表操作
			$wpdb->query("DROP TABLE IF EXISTS $table_name");

			//return "数据表删除成功！";
		}
	}
}
