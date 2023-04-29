<?php // Silence is golden


function custom_title_filter($title, $id)
{
    // 判断当前页面是否为文章页
    if (is_single() && $id == get_the_ID()) {
        // 添加一句话到标题下方
        $title = '<span>你好</span><br>' . $title;
    }
    return $title;
}

add_filter('the_title', 'custom_title_filter', 10, 2);
