<?php // Silence is golden




function add_type_attribute_to_script($tag, $handle)
{
    // 在这里判断需要添加 type 属性的 JS 文件，比如文件名包含 xxx.js
    if (strpos($tag, 'test.js') !== false) {
        // 在 script 标签中添加 type 属性
        $tag = str_replace('<script', '<script type="module"', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute_to_script', 10, 2);
