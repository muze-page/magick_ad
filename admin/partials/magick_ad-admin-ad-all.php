<?php

/**
 * 处理全局广告信息
 *
 * 将全局广告进行处理
 *
 * @link       https://www.npc.ink
 * @since      1.0.0
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 */

/**
 * 处理全局广告信息
 *
 * 将全局广告进行处理
 *
 * @package    Magick_ad
 * @subpackage Magick_ad/admin/partials
 * @author     Mzue <1355471563@qq.com>
 */

class Magick_ad_Admin_Ad_All
{

    /**
     * 初始化类并设置其财产。
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->load_dependencies();
    }

    private function load_dependencies()
    {

        //载入图片广告模块
        require_once plugin_dir_path(dirname(__FILE__)) . 'partials/module/magick_ad-admin-ad-img.php';
        //载入 HTML 广告模块
        require_once plugin_dir_path(dirname(__FILE__)) . 'partials/module/magick_ad-admin-ad-html.php';
    }

    /*
    *打印数组用
    */
    public function p($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    /**
     * 获取ACF的配置信息
     */
    public function get_acf_config()
    {
        $arr = array();

        $arr = get_field('ad_all', 'options');

        return $arr;
    }

    /**
     * 添加原始配置信息在网页底部
     */
    public function add_msg_bottom()
    {

        self::p(self::get_acf_config());
    }

    /**
     * 添加处理后的配置信息在网页底部
     */
    public function add_msg_handle()
    {
        echo "我是处理过的";
        //拿到全局广告数组
        $arr = self::get_acf_config();
        //对数组进行处理后拿到值
        $data = self::handle_ad_content_arr($arr);

        //打印
        self::p($data);
    }


    /**
     * @since    1.0.0
     * @param    array $array 待处理的广告内容
     */
    public function handle_ad_content_arr($array)
    {
        //存储处理好的数据
        $arr = [];
        // 遍历数组
        foreach ($array as $sub_array) {

            //拿到内容数组
            $content = $sub_array['content'];
            //拿到选项数组
            $options = $sub_array['options'];

            //拿到展示效果判断
            $judge = $options['judge'];

            //拿到是否登录展示判断
            $login = $options['login'];

            //拿到展示设备判断
            $device = $options['device'];

            //判断展示效果
            $judge_content = self::judge_show($content, $judge);


            //进行登录条件判断
            $login_content = self::login_show($judge_content, $login);

            //进行设备条件判断
            $device_content = self::device_show($login_content, $device);

            //对广告内容进行处理
            $ad = self::handle_type_data($device_content);

            //展示广告






            $arr[] = $ad;
            //$arr[] = "666";
        }
        return $arr;
        //return "测试下";
    }

    /**
     * 根据广告类型进行对应处理
     * @param array $data 待处理的广告内容数组
     * @return strin 处理完毕的广告内容
     */
    public function handle_type_data($data)
    {
        //在 foreach 循环中，使用引用（&）可以让当前遍历的元素的变化直接作用于原数组。
        //如果不使用引用，则只是将当前遍历的元素值复制到一个临时变量中，
        //而对临时变量的修改并不会影响原数组。
        foreach ($data as &$item) {
            //拿到广告类型
            $types = $item['acf_fc_layout'];
            //根据广告类型分给对应的模块进行内容处理
            if ($types == 'ad_html') {
                //拿到内容
                $content = $item['h5_content'];
                $item['h5_content'] = Magick_ad_Admin_Ad_Html::handle_html($content);
               
            }
            if ($types == "ad_img") {
            }
           
        }
        return $data;
    }


    /**
     * 判断展示效果
     * 输入展示数组值
     * @since    1.0.0
     * @param    array $content 待处理的广告内容
     * @param    string $judge 判断条件
     * @return array 处理好的广告内容
     */
    public function judge_show($content, $judge)
    {
        //若展示效果为展示，则继续
        //若展示效果为随机，则从数组中抽一条
        //若展示效果为隐藏，则返回空

        if ($judge === "show") {
            return $content;
        }
        if ($judge === "random") {
            shuffle($content);

            return reset($content);
        }

        if ($judge === "hide") {
            return [];
        }
        return [];
    }

    /**
     * 判断登录展示效果
     * 
     * @since    1.0.0
     * @param    array $content 待处理的广告内容
     * @param    string $login 判断条件
     * @return array 处理好的广告内容
     */
    public function login_show($content, $login)
    {
        //若展示效果为均展示，登录，未登录，
        if ($login === "displas") {
            return $content;
        }
        if ($login === "login" && is_user_logged_in()) {
            return $content;
        }
        if ($login === "no_login" && !is_user_logged_in()) {
            return $content;
        }
        return [];
    }

    /**
     * 判断当前使用设备展示效果
     * @since    1.0.0
     * @param    array $content 待处理的广告内容
     * @param    string $device 判断条件
     * @return array 处理好的广告内容
     */
    public function device_show($content, $device)
    {
        //若展示效果为：全平台、仅手机、仅电脑
        if ($device === 'all') {
            return $content;
        }
        if ($device === 'phone' && wp_is_mobile()) {
            return $content;
        }

        if ($device === 'computer' && !wp_is_mobile()) {
            return $content;
        }

        //throw new InvalidArgumentException('错误：无效的设备类型名');
        //throw new Exception("错误：没有值");


        return [];
    }
}
