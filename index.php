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


//将指定的评论修改为指定的文章
function transfer_comments_to_article($post_id, $comment_ids)
{
    // Get the target article.
    $target_post = get_post(2533);

    // Transfer comments to the target article.
    foreach ($comment_ids as $comment_id) {
        wp_update_comment(array(
            'comment_ID' => $comment_id,
            'comment_post_ID' => $target_post->ID,
        ));
    }

    // Redirect to the target article after saving.
    add_filter('redirect_post_location', function ($location) use ($target_post) {
        return get_permalink($target_post->ID);
    });
}
//add_action('save_post', function ($post_id, $post, $update) {
//    if ($post_id === 2533) {
//        return; // Don't transfer comments from article 222 to itself.
//    }
//
//    // Get the comment IDs to transfer.
//    $comment_ids = array(64, 63, 60); // Replace with your own IDs.
//
//    // Transfer comments to target article.
//    transfer_comments_to_article($post_id, $comment_ids);
//}, 10, 3);




function add_hello_footers()
{

    echo '<div id="mgad_public"></div>';
}
//add_action('wp_head', 'add_hello_footers');
