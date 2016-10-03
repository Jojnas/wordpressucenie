<?php
/*
Template Name: Archives
*/
get_header(); ?>

<?php
    $posts = get_posts();

$html = '';
foreach ($posts as $post) {
    $html .= '<article class="post" id="post-' . esc_attr($post->ID) . '">';
    $html .= '<h1 class="post-title">';
    $html .= apply_filters('the_title',$post->post_title);
    $html .= '</h1>';
    $html .= apply_filters('the_content',$post->post_content);
    $html .= '</article>';
}
echo $html;

?>

<?php get_footer(); ?>