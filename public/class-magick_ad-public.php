<?php

/**
 * 插件面向公众的功能。
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/public
 */

/**
 * 插件面向公众的功能。
 *
 * 定义插件名称、版本和两个示例挂钩，用于说明如何
 *将面向公众的样式表和JavaScript排入队列。
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/public
 * @author     Mzue <1355471563@qq.com>
 */
class Magick_ad_Public
{

	/**
	 * 插件名
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * 插件版本
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * 初始化类并设置其属性。
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
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

		//载入更多广告
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/magick_ad-public-more.php';
	}
	//测试
	public function test()
	{
		$obj = new Magick_ad_Public_More();
		return $obj->add_hello_header($this->version);
	}
	//准备原始更多广告数据
	public function get_all_ad()
	{
		//准备数据
		$config = get_field('ad_more', 'options');
		echo '<h1>更多广告</h1>';
		//实例化用到的类
		$obj = new  Magick_ad_Public_More();
		//基本展示数据
		$arr['config'] = $obj->p($config);
		//说明文本
		$arr['msg'] = $obj->p("下面是处理过的更多广告");
		//处理过的数据
		$arr['handle'] = $obj->p($obj->handle_more_ad($config));
	}

	/**
	 *注册网站面向公众一侧的样式表。
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * 此功能仅用于演示。
		 *
		 *应该将此类的实例传递给run（）函数
		 *在Magick_ad_Loader中定义，因为所有钩子都已定义
		 *在那个特定类别中。
		 *
		 *然后Magick_ad_Loader将创建关系
		 *在定义的钩子和中定义的函数之间
		 *类。
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/magick_ad-public.css', array(), $this->version, 'all');
	}

	/**
	 * 为网站面向公众的一侧注册JavaScript。
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 *此功能仅用于演示。
		 *
		 *应该将此类的实例传递给run（）函数
		 *在Magick_ad_Loader中定义，因为所有钩子都已定义
		 *在那个特定类别中。
		 *
		 *然后Magick_ad_Loader将创建关系
		 *在定义的钩子和中定义的函数之间
		 *类。
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/magick_ad-public.js', array('jquery'), $this->version, false);
		//传递一些变量给JS
		wp_localize_script('frontend-ajax', 'frontend_ajax_object', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
		));
	}
}
