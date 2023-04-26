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


		/**
		 * 测试下
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/magick_ad-admin-display.php';
	}



	public function test()
	{
		$obj = new Magick_ad_Admin_Display();
		return $obj->add_hello_header($this->version);
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
	
}
