<!DOCTYPE html>
<html lang="<?php language_attributes() ?>">
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <?php  wp_head() ?>
</head>
<body <?php  body_class()?>>

<header class="site-header">
    <nav class="container">

        <?php

        ?>
        <?php  wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class' => 'menu',
            'container' => false
        )) ?>
    </nav>
</header>

<main>
    <section class="content container">