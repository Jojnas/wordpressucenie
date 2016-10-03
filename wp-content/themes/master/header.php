<!DOCTYPE html>
<html lang="<?php language_attributes() ?>">
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php wp_title('/', true, 'right'); bloginfo('name');
        if (is_front_page()) echo ' / ' . get_bloginfo('description');
        ?>
    </title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri()?>">
</head>
<body <?php  body_class()?>>

<header>
    <h1><a href="<?php  echo home_url()?>"><?php bloginfo('name'); ?></a></h1>
    <h2><?php bloginfo('description'); ?></h2>
</header>