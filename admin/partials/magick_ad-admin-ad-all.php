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

    private $my_contents;
    /**
     * 初始化类并设置其财产。
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->load_dependencies();
        $this->my_contents = array(
            array(
                'position' => 'wp_head',
                'condition' => 'is_single',
                'content' => '我是第一段话1<br/>'
            ),
            array(
                'position' => 'wp_head',
                'condition' => 'is_single',
                'content' => '我是第二段话2<br/>'
            )

        );

        $this->add_ads();
    }

    public function add_ads()
    {

        foreach ($this->my_contents as $my_content) {
            $position = $my_content['position'];
            $condition = $my_content['condition'];
            $content = $my_content['content'];

            switch ($position) {
                case 'wp_head':
                    add_action($position, function () use ($condition, $content) {
                        if (call_user_func($condition)) {
                            echo $content;
                        }
                    });
                    break;

                case 'wp_footer':
                    add_action($position, function () use ($condition, $content) {
                        if (call_user_func($condition)) {
                            echo $content;
                        }
                    });
                    break;
            }
        }
    }


    /**
     * 加载模块类
     */
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
    public  function add_msg_handle()
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
     * @return array 处理好的广告内容，包含设置信息。
     */
    public  function handle_ad_content_arr($array)
    {
        //存储处理好的数据
        $arr = [];
        // 遍历数组
        foreach ($array as $sub_array) {

            //拿到内容数组
            $content = $sub_array['content'];
            //拿到选项数组
            $options = $sub_array['options'];

            //拿到展示效果判断条件
            $judge = $options['judge'];

            //拿到是否登录展示判断条件
            $login = $options['login'];

            //拿到展示设备判断条件
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
            //需要 - 展示内容 -展示位置 - 展示页面

            //拿到展示页面
            $show_page = $options['show_page'];

            //拿到展示位置
            $show_position = $options['show_position'];

            //展示的内容
            $show_content = "";
            foreach ($ad as $item) {
                if (isset($item['content'])) {
                    $show_content .= trim($item['content']);
                }
            }




            $aa = [];
            $aa['content'] = $show_content;
            $aa['option'] = $options;
            $arr[] = $aa;
        }
        return $arr;
    }


    /**
     * 将内容加载到顶部
     */
    public function add_ad_content()
    {
        $content = "简简单单一段话";
        echo $content;
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
            //HTMl 广告
            if ($types == 'ad_html') {
                //拿到内容
                $content = $item['h5_content'];
                //对内容进行处理后统一存入指定字段中
                $item['content'] = Magick_ad_Admin_Ad_Html::handle_html($content);
            }
            //图片广告
            if ($types == "ad_img") {
                //拿到内容
                $content = $item['img_content'];
                //对内容进行处理后统一存入指定字段中
                $item['content'] = Magick_ad_Admin_Ad_Img::handle_img($content);
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
