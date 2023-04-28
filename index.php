<?php // Silence is golden

function add_hello_header()
{
    if (is_single()) {
        $content = "Test<br/>";
        echo $content;
    }
}
add_action('wp_head', 'add_hello_header');


class My_Plugin
{
    private $my_contents;

    public function __construct()
    {
        $this->my_contents = array(
            array(
                'position' => 'wp_head',
                'condition' => 'is_single',
                'content' => '我是第一段话<br/>'
            ),
            array(
                'position' => 'wp_head',
                'condition' => 'is_single',
                'content' => '我是第二段话<br/>'
            )

        );

        $this->add_ad();
    }

    public function add_ad()
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
}

// 实例化插件类
$my_plugin = new My_Plugin();
