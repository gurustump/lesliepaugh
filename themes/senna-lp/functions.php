<?php function load_senna_lp_styles() {
	wp_enqueue_style( 'senna-lp-styles', get_stylesheet_directory_uri() . '/style.css');	wp_enqueue_script( 'senna-lp-actions', get_stylesheet_directory_uri() . '/actions.js');}add_action('wp_enqueue_scripts', 'load_senna_lp_styles'); 
?>