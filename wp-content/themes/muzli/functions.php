<?php

define('THEME_DIRECTORY', get_template_directory());
/*
 * Theme support and Site Settings
 **/
require_once THEME_DIRECTORY . '/inc/site-settings.php';

// logika je includovanie suborov, ktore sa venuju rovnakym topicom

add_action('wp_head', 'muzli_the_head');
function muzli_the_head(){
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . PHP_EOL;
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
}

// shortcodes

add_shortcode('button', 'muzli_button_shortcode');
function muzli_button_shortcode( $atts){

   // extract sa neodporuca pouzivat
//    extract(shortcode_atts( array(
//       'color' => '',
//       'link' => '#',
//       'text' => 'enter text',
//   ), $atts));

    // set defaults
    $atts = shortcode_atts( array(
        'color' => '',
        'link' => '#',
        'text' => 'enter text',
    ), $atts);

    // create css class from color
    if ($atts['color']) $atts['color'] = 'btn-'.$atts['color'];

    $parsed = wp_parse_url($atts['link']);
    if (!isset($parsed['scheme'])) {
        $atts['link'] = home_url($atts['link']);
    }
    $html = '<a href="' . esc_attr($atts['link']) . '" class="btn ' . esc_attr($atts['color']) . ' animate">';
    $html .= esc_attr($atts['text']);
    $html .= '</a>';
    // <a href="#" class="btn btn-red animate">Get a kick right in the pooper</a>
    return $html;
}

add_shortcode('simple_blog', 'muzli_blog_shortcode');
function muzli_blog_shortcode(){
    $posts = get_posts(array(
        'posts_per_page' => get_option('posts_per_page'),
        'suppress_filters' => true,
    ));
    $html = '<div class="post-list">';
    foreach ($posts as $post) {
        $html .= '<article class="post" id="post-' . esc_attr($post->ID) . '">';
        $html .= '<h1 class="post-title">';
        $html .= apply_filters('the_title',$post->post_title);
        $html .= '</h1>';
        $html .= apply_filters('the_content',$post->post_content);
        $html .= '</article>';
    }
    $html .= do_shortcode('[button color="yellow" link="archive" text="older stuff"]');
    $html .= '</div>';

    return $html;
}

add_shortcode('simple_gallery', 'muzli_gallery_shortcode');
function muzli_gallery_shortcode($atts){

    $atts = shortcode_atts(array(
        'gallery_class' => 'image-grid group',
        'img_class' => 'gallery-img',
    ), $atts);

    $media = get_attached_media('image');

    if (! $media) {
        return '';
    }
    $html = '<div class="'.esc_attr($atts['gallery_class']).'">';
    foreach ($media as $img) {
        $html .=
            '<img src="' . esc_url( wp_get_attachment_image_url($img->ID, 'full')) . '"
            class="'. esc_attr($atts['img_class']) . '"
            alt="'. esc_attr($img->post_title) . '">';
        wp_get_attachment_image_url($img->ID, 'full');
    }
    $html .= '</div>';
    return $html;
}

add_filter('wpcf7_ajax_loader', 'muzli_wpcf7_loader');
function muzli_wpcf7_loader($hovno){
    echo $hovno;
}

/**
 * Customizer
 */

add_action('customize_register', 'muzli_customize_register');
function muzli_customize_register($wp_customize){
   $wp_customize->add_section('copyright', array(
      'title' => 'Copyright',
       'priority' => 30,
       'description' => 'copy info usually in filter',
   ));

    $wp_customize->add_setting( 'copy_by' , array(
        'default' => get_option('blogname'),
        'transport' => 'refresh',
        'sanitize_callback' => function($content) {
            return sanitize_text_field($content);
        }
    ) );

    $wp_customize->add_setting( 'copy_text' , array(
        'default' => 'Created with love',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_copy_text',
    ) );

    $wp_customize->add_control('copy_by', array(
            'label'    => 'Copyright by',
            'section'  => 'copyright',
            'type'     => 'text',
            'priority' => 10,
        )
    );

    $wp_customize->add_control('copy_text', array(
            'label'    => 'Copyright text',
            'section'  => 'copyright',
            'type'     => 'textarea',
            'priority' => 20,
        )
    );

    function sanitize_copy_text($content){
        return wp_kses($content, array(
            'strong' => array(),
            'a' => array(
                'href' => array(),
                'title' => array(),
            ),
        ));
    }
}

/**
 * Sidebar
*/
add_filter('widget_text', 'do_shortcode');
add_action('widgets_init', 'muzli_widget_init');
function muzli_widget_init(){
    register_sidebar(array(
        'name'          => __( 'Pre-footer sidebar' ),
        'id'            => 'sidebar-primary',
        'description'   => 'shows up under every page',
        'class'         => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>' )
);
}

/*
 * Add scripts & styles
 * */

add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

add_action('wp_enqueue_scripts', 'muzli_add_theme_scripts');
function muzli_add_theme_scripts()
{
    wp_enqueue_script(
        'muzli-app',
        get_template_directory_uri() . '/js/app.js',
        array('jquery'),
        '',
        true
    );

    wp_enqueue_style(
        'muzli-style', get_stylesheet_uri()
    );

    wp_enqueue_style(
        'muzli-animations', get_template_directory_uri() . '/css/animations.css'
    );

    wp_enqueue_style(
      'muzli-fonts', 'http://fonts.googleapis.com/css?family=Montserrat:400,700'
    );
}

// only load CONTACT FORM 7 on contact page

if (is_page('contact')){
    if ( function_exists('wpcf7_enqueue_scripts')){
        wpcf7_enqueue_scripts();
    }
    if ( function_exists('wpcf7_enqueue_scripts')){
        wpcf7_enqueue_styles();
    }
}

/*
 * disable garbage
 * */
add_action('init', 'muzli_disable_garbage', 9999);
function muzli_disable_garbage() {

    // disable emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');
    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
    // Remove REST API lines from the HTML header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    // clean up head
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('do_feed_rdf', 'do_feed_rdf', 10, 1);
    remove_action('do_feed_rss', 'do_feed_rss', 10, 1);
//    remove_action('do_feed_rss2', 'do_feed_rss2', 10, 1);
//    remove_action('do_feed_atom', 'do_feed_atom', 10, 1);
    remove_action('wp_head', 'feed_links_extra', 3 );
    remove_action('wp_head', 'feed_links', 2 );
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'noindex', 1);
    remove_action('wp_head', 'rel_canonical');

    // remove WordPress version from RSS feeds
    add_filter('the_generator', '__return_false');

    // disable admin toolbar
    add_filter('show_admin_bar', '__return_false');

    add_filter('style_loader_tag', 'html5_script_style_tags');
    add_filter('script_loader_tag', 'html5_script_style_tags');
    function html5_script_style_tags($tag){
        $tag = preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
        $tag = preg_replace('~\s+id=["\'][^"\']++["\']~', '', $tag);
        return $tag;
    }
}

add_action( 'init', 'muzli_disable_wp_emojicons' );
function muzli_disable_wp_emojicons( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}
/**
 * Simple error logging
 * @param $message
 * @return bool
 */
function log_me($message)
{
    if (true !== WP_DEBUG) return false;
    if (is_array($message) || is_object($message)) {
        return error_log(json_encode($message));
    }
    return error_log($message);
}


/*
 * Theme settings
 */

add_action( 'admin_menu', 'muzli_add_admin_menu' );
add_action( 'admin_init', 'muzli_settings_init' );

function muzli_add_admin_menu(  ) {
    add_options_page( 'Theme Settings', 'Theme Settings', 'manage_options', 'theme_settings', 'muzli_options_page' );
}

function muzli_settings_init(  ) {
    register_setting( 'muzli_theme', 'muzli_settings', 'save_muzli_theme_settings' );

    add_settings_section(
        'muzli_copyright_section',
        __( 'Copyright info', 'muzli' ),
        false,
        'muzli_theme'
    );

    add_settings_field(
        'copyright_by',
        __( 'Copyright by ', 'muzli' ),
        'copyright_by_render',
        'muzli_theme',
        'muzli_copyright_section'
    );

    add_settings_field(
        'copyright_text',
        __( 'Text in footer ', 'muzli' ),
        'copyright_by_text',
        'muzli_theme',
        'muzli_copyright_section'
    );
/*
 * Logo section
 */
    add_settings_section(
        'muzli_logo_section',
        __( 'Upload logo', 'muzli' ),
        false,
        'muzli_theme'
    );

    add_settings_field(
        'logo',
        __( 'Choose an image ', 'muzli' ),
        'muzli_logo_render',
        'muzli_theme',
        'muzli_logo_section'
    );
}

function save_muzli_theme_settings($data){
    $data = array_map('sanitize_text_field', $data);
    $options = extend_array(get_option('muzli_settings'), $data);

    if ( !empty($_FILES['logo']['tmp_name']) && file_is_displayable_image($_FILES['logo']['tmp_name'])){
        $upload = wp_handle_upload($_FILES['logo'], array('test_form' => false));
       $options['logo'] = $upload['url'];
    }
    return $options;
}

function copyright_by_render(  ) {
    $options = get_option( 'muzli_settings' );
    $value = isset($options['copyright_by']) ? $options['copyright_by'] : 0;
    ?>
    <input type="text" class="regular-text" name='muzli_settings[copyright_by]' value='<?php echo $value ?>'>
    <?php
}

function copyright_by_text(  ) {
    $options = get_option( 'muzli_settings' );
    $value = isset($options['copyright_text']) ? $options['copyright_text'] : 0;
    ?>
    <textarea name='muzli_settings[copyright_text]' cols="46" rows="3"><?php echo $value ?></textarea>
    <?php
}

function muzli_logo_render(  ) {
    $options = get_option( 'muzli_settings' );
    $logo = isset($options['logo']) ? $options['logo'] : 0;
    ?>
    <p><input type="file" name="logo"></p>
    <?php if ($logo) : ?>
        <p><img src="<?php echo esc_url($logo)?>" alt="muzli-logo" class="muzli-logo"></p>
    <?php endif;
}

function muzli_options_page(  ) {
    ?>
    <div class="wrap">
        <h1>Theme Settings</h1>
        <form action="options.php" method="post" enctype="multipart/form-data">
            <?php
            settings_fields( 'muzli_theme' );
            do_settings_sections( 'muzli_theme' );
            submit_button();
            ?>
        </form>
    </div>

    <style>
        .muzli-logo {
            padding: 10px;
            margin: 10px 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
    </style>

    <?php
}

/**
* jQuery style array extend
    *
 * @return array
 */
function extend_array()
{
    $args     = func_get_args();
    $extended = array();

    if ( is_array( $args ) && count( $args ) )
    {
        foreach ( $args as $array )
        {
            if ( ! is_array( $array ) ) continue;
            $extended = array_merge( $extended, $array );
        }
    }

    return $extended;
}

add_action('admin_menu', 'muzli_edit_admin_menus', 999);
function muzli_edit_admin_menus(){
    remove_menu_page('edit-comments.php');

    if (! current_user_can('administrator')) {
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_submenu_page('plugins.php', 'plugin-editor.php');
    }
}

add_filter('tiny_mce_before_init', 'muzli_unhide_kitchensink');
function muzli_unhide_kitchensink ($args) {
    $args['wordpress_adv_hidden'] = false;
    return $args;
}




