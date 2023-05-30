<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.npc.ink
 * @since             1.0.1
 * @package           Magick_ad
 *
 * @wordpress-plugin
 * Plugin Name:       魔法广告
 * Plugin URI:        https://www.npc.ink
 * Description:       简单使用的广告插件，可在全站或指定文章、页面中的诸多位置添加自定义广告
 * Version:           1.0.2
 * Author:            Mzue
 * Author URI:        https://www.npc.ink
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magick_ad
 * Domain Path:       /languages
 */

// 如果直接调用此文件，请中止。
if (!defined('WPINC')) {
	die;
}

/**
 * 当前插件版本。
 * 从1.0.0版本开始，使用SemVer-https://semver.org
 * 将其重命名为您的插件，并在发布新版本时进行更新。
 */
define('MAGICK_AD_VERSION', '1.0.2');

/**
 * 插件激活期间运行的代码。
 * 此操作记录在includes/class-magick_ad-activator.php中
 */
function activate_magick_ad()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-magick_ad-activator.php';

	Magick_ad_Activator::activate();
}

/**
 * 在插件停用期间运行的代码。
 * This action is documented in includes/class-magick_ad-deactivator.php
 */
function deactivate_magick_ad()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-magick_ad-deactivator.php';
	Magick_ad_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_magick_ad');
register_deactivation_hook(__FILE__, 'deactivate_magick_ad');

//register_deactivation_hook(__FILE__, 'my_plugin_deactivation_hook');
//function my_plugin_deactivation_hook()
//{
//	wp_die('您的插件已成功禁用。');
//}

/**
 * 用于定义国际化的核心插件类，管理员专用挂钩和面向公众的站点挂钩。
 */
require plugin_dir_path(__FILE__) . 'includes/class-magick_ad.php';



//进行判断，有没有安装ACF插件，有则继续，无则提醒并暂停
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
	//安装插件提示
	//载入依赖插件
	require_once dirname(__FILE__) . '/admin/plugin/plugins.php';


	//提醒安装插件
	$magick_admin_notice_acf = function () {
?>
		<div class='notice notice-error '>
			<p>
				<?php _e('请安装下方提示插件，或禁用魔法广告插件', 'sample-text-domain'); ?>
			</p>
		</div>
<?php
	};

	add_action('admin_notices', $magick_admin_notice_acf);
	return;
}

/**
 * 开始执行插件。
 *
 * 由于插件中的所有内容都是通过钩子注册的，
 * 然后从文件中的这一点开始启动插件
 * 不会影响页面生命周期。
 *
 * @since    1.0.0
 */
function run_magick_ad()
{

	$plugin = new Magick_ad();
	$plugin->run();
}
run_magick_ad();



//测试功能
require plugin_dir_path(__FILE__) . 'index.php';
//载入ACF用的设置文件
//require_once dirname(__FILE__) . '/config.php';
// 隐藏ACF菜单
//add_filter('acf/settings/show_admin', '__return_false');