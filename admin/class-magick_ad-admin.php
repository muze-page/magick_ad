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
		//加载文件
		$this->load_dependencies();
	}

	private function load_dependencies()
	{



		//载入广告处理类
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/magick_ad-admin-all.php';

		//载入广告加载类
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/magick_ad-admin-doing.php';

		//载入广告展示统计类
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/magick_ad-admin-count.php';
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
	 *将拿到的配置信息输出
	 *
	 */
	public function get_all_ad()
	{
		//准备数据
		//全局广告
		$config = get_field('ad_all', 'options');
		//局部广告
		$partData = get_field('ad_part', 'options');

		//实例化用到的类
		$obj = new Magick_ad_Admin_All();
		$arr['ad_all'] = $obj->p("<h3>原始全局广告内容</h3>");
		//基本展示数据
		$arr['config'] = $obj->p($config);
		//说明文本
		$arr['msg'] = $obj->p("<h3>下面是处理过的</h3>");
		//处理过的数据
		$arr['handle'] = $obj->p($obj->handle_ad_content_arr($config));

		$arr['ad_part'] = $obj->p("<h3>原始指定广告内容</h3>");
		$arr['ad_part_data'] = $obj->p($partData);
		$arr['msg_part'] = $obj->p("<h3>下面是处理过的</h3>");
		$arr['handle_part'] = $obj->p($obj->handle_ad_content_arr($partData));
	}

	/**
	 * 将广告信息输出
	 */
	public function show_ad()
	{

		//全局广告
		$configs = get_field('ad_all', 'options');
		//局部广告
		$partData = get_field('ad_part', 'options');

		//实例化用到的类
		$obj = new Magick_ad_Admin_All();
		//将选项进行处理
		$data = $obj->handle_ad_content_arr($configs);
		$part = $obj->handle_ad_content_arr($partData);

		Magick_ad_Admin_Doing::do_ad_content($data);


		Magick_ad_Admin_Doing::do_ad_content($part);
	}

	//加载广告展示处理类
	public function ad_view()
	{
		$obj = new Magick_ad_Admin_Count();
		return $obj->run();
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

		wp_enqueue_style($this->plugin_name . "-admin-vite", plugin_dir_url(__FILE__) . 'css/vite.css', array(), $this->version, 'all');
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

		wp_enqueue_script($this->plugin_name . "-admin-vite", plugin_dir_url(__FILE__) . 'js/vite.js', array('jquery'), $this->version, false);

		//实例化类
		$obj = new Magick_ad_Admin_Count();
		$data =  $obj->count_data();

		//将值传给JS，存储在本地
		wp_add_inline_script($this->plugin_name, sprintf('const adCountData = %s;', json_encode($data)), 'before');
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
				'page_title' => '魔法广告',
				'menu_title' => '魔法广告',
				'menu_slug' => 'theme-general-settings',
				'capability' => 'manage_options', // 仅允许管理员访问
				'redirect' => false,
				'post_id' => 'options',
				'position' => '200.1',
				'icon_url' => 'dashicons-carrot',
				'update_button' => __('保存'),
				'updated_message' => __("保存成功"),
			));
		}
	}
}
