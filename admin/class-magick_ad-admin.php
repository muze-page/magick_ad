<?php

/**
 * 插件的特定于管理员的功能。
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin
 */

/**
 * 插件的特定于管理员的功能。
 *
 * 定义插件名称、版本和两个示例挂钩，用于说明如何将特定于管理员的样式表和JavaScript放入队列
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin
 * @author     Mzue <1355471563@qq.com>
 */
class Magick_ad_Admin
{



	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * 初始化类并设置其财产。
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
	}

	private function load_dependencies()
	{

		//载入依赖插件
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/plugin/plugins.php';

		//载入全局广告
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/magick_ad-admin-ad-all.php';
		/**
		 * 测试下
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/magick_ad-admin-display.php';
	}


	/**
	 * 测试
	 */
	public function test()
	{
		$obj = new Magick_ad_Admin_Display();
		return $obj->add_hello_header($this->version);
	}
	/*
	 *将拿到的配置信息打印的网页底部
	 *
	 */
	public function get_all_ad()
	{
		$arr = [];
		$obj = new Magick_ad_Admin_Ad_All();
		$arr['config'] = $obj->add_msg_bottom(); //配置信息
		$arr['handle'] =  $obj->add_msg_handle(); //处理后的信息
		return $arr;
	}



	/**
	 * 注册管理区域的样式表。
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * 此功能仅用于演示。
		 *
		 * 应该将此类的实例传递给run（）函数
		 *在Magick_ad_Loader中定义，因为所有钩子都已定义
		 *在那个特定类别中。
		 *
		 * 然后Magick_ad_Loader将创建关系
		 *在定义的钩子和中定义的函数之间
		 *类。
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/magick_ad-admin.css', array(), $this->version, 'all');
	}

	/**
	 * 注册管理区域的JavaScript。
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * 此功能仅用于演示。
		 *
		 * 应该将此类的实例传递给run（）函数
		 *在Magick_ad_Loader中定义，因为所有钩子都已定义
		 *在那个特定类别中。
		 *
		 * 然后Magick_ad_Loader将创建关系
		 *在定义的钩子和中定义的函数之间
		 *类。
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/magick_ad-admin.js', array('jquery'), $this->version, false);
	}


	/**
	 * 未安装ACF 插件的警告信息
	 *
	 * @since    1.0.0
	 */
	public function magick_admin_notice_acf()
	{
?>
		<div class='notice notice-error '>
			<p>
				<?php _e('请安装下方提示插件，或禁用魔法广告插件', 'sample-text-domain'); ?>
			</p>
		</div>
<?php
	}


	/**
	 * 屏蔽ACF Pro 插件更新提示
	 *
	 * @type    function
	 * @date    14/06/2016
	 * 
	 * @since    1.0.0
	 */
	public function wcr_remove_update_notifications($value)
	{
		// 要屏蔽的插件位置 (在wp-content/plugins文件夹下)
		$plugins = array(
			'advanced-custom-fields-pro/acf.php',
		);
		foreach ($plugins as $key => $plugin) {
			if (empty($value->response[$plugin])) {
				continue;
			}
			unset($value->response[$plugin]);
		}
		return $value;
	}

	/**
	 * 添加提示信息
	 */
	public function my_plugin_add_meta($links, $file)
	{
		// Replace "my-plugin/my-plugin.php" with your plugin's file path
		if ($file == 'advanced-custom-fields-pro/acf.php') {
			$notice = '<br><span style="color: #8c8c8c;">提示：若需停用本插件，请先停用魔法广告插件</span>';
			$links[] = $notice;
		}
		return $links;
	}

	/*
	*添加本插件设置信息
	*/
	public function add_option_setting($links)
	{
		$links[] = '<a href="' . get_admin_url(null, 'admin.php?page=theme-general-settings') . '">' . __('设置', 'tj') . '</a>';
		return $links;
	}
	/**
	 * 添加本插件信息
	 */
	public function add_option_msg_setting($links, $file)
	{
		//增加插件信息

		//if ($file == plugin_basename(__FILE__)) {
		if ($file == 'magick_ad/magick_ad.php') {

			$links[] = '<a target="_blank" href="https://www.npc.ink/276641.html">使用帮助</a>';
			$links[] = '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1355471563">联系QQ</a>';
		}
		return $links;
	}

	/**
	 * 添加广告菜单
	 */
	public function add_option_menu_magick_ad()
	{
		//显示菜单
		//显示菜单选项
		//https://www.advancedcustomfields.com/resources/options-page/
		if (function_exists('acf_add_options_page')) {

			//acf_add_options_page();
			acf_add_options_page(array(
				'page_title' => '魔法广告插件',
				'menu_title' => '广告',
				'menu_slug' => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect' => false,
				'post_id' => 'options',
				'icon_url' => 'dashicons-filter',
				'update_button' => __('保存'),
				'updated_message' => __("保存成功"),
			));
		}
	}
}
