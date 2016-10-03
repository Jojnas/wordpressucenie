<?php
// theme support
add_action('after_setup_theme', 'muzli_setup');
function muzli_setup() {
    add_theme_support('menus');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'secondary' => 'Secondary menu'
    ));

    add_editor_style('css/editor-style.css');
}

// get body class name - cize ked sa page vola gallery, tak classa bude gallery
add_filter('body_class', 'muzli_body_classes');
function muzli_body_classes($classes){
    $slug = get_post_field('post_name', get_post());
    $classes = array ($slug);
    return $classes;
}