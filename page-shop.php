<?php

add_action( 'wp_enqueue_scripts', 'my_function_name' );

function my_function_name() {
    wp_enqueue_style( 'shop-style', get_stylesheet_directory_uri() . '/assets/css/shop.css' );
}

beans_remove_action( 'beans_breadcrumb' );
beans_remove_action( 'beans_post_title' );
beans_remove_action( 'beans_post_image' );


beans_load_document();
