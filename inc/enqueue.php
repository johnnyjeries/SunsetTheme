<?php
/*
@package sunsetTheme
    ==================
    ADMIN ENQUEUE FUNCTIONS 
    ==================
*/

function sunset_load_admin_scripts( $hook ){
    if( 'toplevel_page_webproz_sunset' != $hook ){
        return;
    }
    wp_register_style( 'sunset_admin', get_template_directory_uri() . '/css/sunset.admin.css', array(), '1.0.0', 'all');
    wp_enqueue_style('sunset_admin');

    //to use the wp media uploader
    wp_enqueue_media();
    
    wp_register_script( 'sunset-admin-script', get_template_directory_uri() . '/js/sunset.admin.js', array('jquery'), '1.0.0',  true);
    wp_enqueue_script('sunset-admin-script');
}

add_action('admin_enqueue_scripts', 'sunset_load_admin_scripts');
//admin_enqueue_scripts only calls the function when on admin page

/*

    ==================
    FRONTEND ENQUEUE FUNCTIONS 
    ==================

*/

function sunset_load_scripts(){
    //if the style is used for all the website then there is no need to register it, we can directly use the enqueue function
    // wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.0-alpha1', 'all' );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/3.3.6-css/bootstrap.min.css', array(), '3.3.6', 'all' );
    wp_enqueue_style( 'raleway', 'https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;500&display=swap' );
    //important to load bootstrap css before our custom css
    wp_enqueue_style( 'sunset', get_template_directory_uri() . '/css/sunset.css', array(), '1.0.0', 'all' );
    wp_deregister_script('jquery'); //prevent the browser to load jquery in header
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.11.3.min.js', false, '1.11.3', true );
    wp_enqueue_script('jquery');
    // wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '5.3.0-alpha1', true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/3.3.6-js/bootstrap.min.js', array('jquery'), '3.3.6', true );
    wp_enqueue_script( 'sunset', get_template_directory_uri() . '/js/sunset.js', array('jquery'), '1.0.0', true ) ;

}

add_action( 'wp_enqueue_scripts', 'sunset_load_scripts' );

