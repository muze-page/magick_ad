<?php

/**
 * 定义核心插件类的文件
 *
 * 一个类定义，包括在面向公众的一侧的网站和管理区域。
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 */

/**
 * 核心插件类。
 *
 * 这用于定义国际化、特定于管理的挂钩，以及面向公众的站点挂钩
 *
 * 还维护此插件的唯一标识符以及当前插件的版本。
 *
 * @since      1.0.0
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 * @author     Mzue <1355471563@qq.com>
 */
class Magick_ad
{

	/**
	 * 负责维护和注册所有供电挂钩的加载器插件
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Magick_ad_Loader    $loader    维护并注册插件的所有挂钩。
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name   用于唯一标识此插件的字符串。
	 */
	protected $plugin_name;

	/**
	 * 插件的当前版本。
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    插件的当前版本。
	 */
	protected $version;

	/**
	 * 定义插件的核心功能。
	 *
	 * 设置插件名称和可在整个插件中使用的插件版本。
	 * 加载依赖项，定义区域设置，并为管理区域和场地面向公众的一侧。
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('MAGICK_AD_VERSION')) {
			$this->version = MAGICK_AD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'magick_ad';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * 加载此插件所需的依赖项。
	 *
	 * 包括以下组成插件的文件：
	 *
	 * - Magick_ad_Loader. 编排插件的挂钩。
	 * - Magick_ad_i18n. 定义国际化功能。
	 * - Magick_ad_Admin. 定义管理区域的所有挂钩。
	 * - Magick_ad_Public. 定义站点公共端的所有挂钩。
	 *
	 * 创建一个用于注册钩子的加载器实例使用WordPress。
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * 负责编排的操作和筛选器的类核心插件。
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-magick_ad-loader.php';

		/**
		 * 负责定义国际化功能的类
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-magick_ad-i18n.php';

		/**
		 * 负责定义在管理区域中发生的所有操作的类。
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-magick_ad-admin.php';

		/**
		 * 负责定义在公众面前发生的所有行动的类别现场一侧。
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-magick_ad-public.php';

		$this->loader = new Magick_ad_Loader();
	}

	/**
	 * 为国际化定义此插件的区域设置。
	 *
	 * 使用Magick_ad_i18n类来设置域和注册钩子
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Magick_ad_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * 注册与管理区域功能相关的所有挂钩
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Magick_ad_Admin($this->get_plugin_name(), $this->get_version());

		//加载后台的css文件和JS文件
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		//顶部打印测试内容
		$this->loader->add_action('wp_head', $plugin_admin, 'test');
		//打印广告数组到前台底部
		//$this->loader->add_action('wp_footer', $plugin_admin, 'get_all_ad');

		//加载广告内容
		$plugin_admin->show_ad();



		//是在后台中
		if (is_admin()) {
			//进行判断，有没有安装ACF插件，有则继续，无则提醒并暂停
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
				//提醒安装插件
				$this->loader->add_action('admin_notices', $plugin_admin, 'magick_admin_notice_acf');
				return;
			}

			//屏蔽ACF 的更新提示
			$this->loader->add_filter('site_transient_update_plugins', $plugin_admin, 'wcr_remove_update_notifications');

			//添加ACF自定义提示
			$this->loader->add_filter('plugin_row_meta', $plugin_admin, 'my_plugin_add_meta', '', 2);

			//添加广告插件设置信息
			$this->loader->add_filter('plugin_action_links_magick_ad/magick_ad.php', $plugin_admin, 'add_option_setting', '', 2);

			//添加广告插件附加信息
			$this->loader->add_filter('plugin_row_meta', $plugin_admin, 'add_option_msg_setting', '', 2);

			//添加菜单
			$plugin_admin->add_option_menu_magick_ad();
		}
	}

	/**
	 * 注册与面向公众的功能相关的所有挂钩
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Magick_ad_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * 运行加载程序以使用WordPress执行所有挂钩。
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * 用于在的上下文中唯一标识它的插件的名称WordPress和定义国际化功能。
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * 对使用插件编排钩子的类的引用。
	 *
	 * @since     1.0.0
	 * @return    Magick_ad_Loader    编排插件的挂钩。
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * 检索插件的版本号。
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
