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
        //拿到全局广告数组
        $arr = self::get_acf_config();
        //对数组进行处理后拿到值
        $data = self::handle_ad_content_arr($arr);
        echo "我是处理过的";
        //打印
        self::p($data);
    }

    //获取广告的内容数组，展示在页面底部
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


            $arr[] = $device_content;
        }
        return $arr;
        //return "测试下";
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
        switch ($judge) {
            case "show":
                $data = $content;
                break;
            case "random":
                $data = self::handle_random_arr($content);

                break;
            case "hide":
                $data = [];
                break;
            default:
                echo "错误：没有值";
        }
        return $data;
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
    public function device_show(array $content, string $device): array
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

    /**
     * 输入一个数组，随机输出其中一条数据
     * @since 1.0.0
     * @param array $arr 待处理的数组
     * @return array 返回包含一个值的数组
     */
    public function handle_random_arr($arr)
    {
        //随机输出数组中的一个数组
        //乱序该数组
        shuffle($arr);
        //取出其中第一个数组
        return   $arr['0'];
    }
}
