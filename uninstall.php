<?php

/**
 * 在卸载插件时激发。
 *
 *填充此文件时，请考虑以下流程
 *控制范围：
 *
 * -此方法应该是静态的
 *-检查$_REQUEST内容是否真的是插件名称
 *-运行管理员推荐人检查以确保其通过身份验证
 *-验证$_GET的输出是否合理
 *-与其他用户角色重复。最好直接使用链接/查询字符串参数。
 *-对多站点重复上述操作。一次用于网络中的单个站点，一次用于整个站点。
 *
 *这个文件可能会在未来版本的Boilerplate中更新更多；然而，这是
 *文件应该如何工作的一般框架和大纲。
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 */

// 如果没有从WordPress调用卸载，则退出。
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}


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
