<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_scripts() {
    // Ajouter jQuery
    wp_enqueue_script('jquery');
}
function theme_enqueue_styles() {
    wp_enqueue_style('monaphoto-style', get_stylesheet_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script( 'monaphoto-scripts', get_stylesheet_directory_uri() . '/assets/js/app.js', array('jquery'), null, true );
}
function register_my_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ) );
    register_nav_menu('footer', 'Pied de page');
}
add_action( 'after_setup_theme', 'register_my_menu' );
