<?php

/**
 * 注册插件的所有操作和筛选器
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 */

/**
 * 注册插件的所有操作和筛选器
 *
 * 维护整个过程中注册的所有钩子的列表
 * 插件，并使用WordPress API注册它们。致电
 * run函数来执行操作和筛选器的列表。
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/includes
 * @author     Mzue <1355471563@qq.com>
 */
class Magick_ad_Loader {

	/**
	 * 在WordPress中注册的操作数组。
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    在WordPress中注册的操作在加载插件时启动。
	 */
	protected $actions;

	/**
	 * 在WordPress中注册的筛选器数组。
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    在WordPress注册的过滤器在加载插件时启动。
	 */
	protected $filters;

	/**
	 * 初始化用于维护操作和筛选器的集合。
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * 将新操作添加到要在WordPress中注册的集合中。
	 * 这里对原有add_action进行了改造，
	 * add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	 * 
	 *
	 * @since    1.0.0
	 * @param    string               $hook             正在注册的WordPress操作的名称。 -  'wp_enqueue_scripts'
	 * @param    object               $component        对在其上定义操作的对象的实例的引用。- $plugin_public 实例化的类
	 * @param    string               $callback         $组件上的函数定义的名称。 - enqueue_styles 实例化类中的函数
	 * @param    int                  $priority         可选择的应激发函数的优先级。默认值为10。
	 * @param    int                  $accepted_args    可选择的应传递给$callback的参数数。默认值为1。
	 */

	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * 将新过滤器添加到要向WordPress注册的集合中。
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * 一个实用函数，用于将操作和挂钩注册到单个收集。
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * 使用WordPress注册过滤器和操作。
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}
