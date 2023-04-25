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
class Magick_ad_Activator {

	/**
	 * 简短描述。（使用期限）
	 *
	 * 详细描述。
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		//页头添加内容
		add_action( 'wp_head', array(__CLASS__,'add_hello_header' ));

	}

	//页头添加内容
	/**
	 * 
	 */
	public static function add_hello_header() {
		echo '<div style="background-color: yellow; text-align: center;">我在页面顶部</div>';
	}

	
	

}
