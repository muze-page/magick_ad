<?php // Silence is golden


add_filter('the_title', 'my_custom_title', 10, 2);
function my_custom_title($title, $id)
{
    if (is_single() && in_the_loop() && $id === get_the_ID()) { // 判断是否在文章循环中
        $new_title = '添加的文本 ' . $title; // 在标题前添加文本
        return $new_title;
    } else {
        return $title; // 非单篇文章页面或其他特定页面，返回原标题
    }
}

add_action('loop_start', 'my_new_elem_after_title');
add_action('loop_end', 'my_new_elem_after_title');
function my_new_elem_after_title()
{
    $value = '<h2>简单内容</h2>';
    //是文章页则输出内容
    if (is_single()) {
        if (is_main_query()) {
            // do stuff
            echo $value;
        }
    }
}
