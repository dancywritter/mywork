<?php 
/*
Plugin Name: Exchange Collective Registration
Plugin URI: http://exchangecollective.com/
Description: Plugin for displaying registration form
Author: Dynamic Online Technologies
Version: 1.0
Author URI: http://dynamiconlinetechnologies.com/
*/

function exc_registration_form_admin() {
    add_menu_page("Exchange Collective Registration", "EXC Registration", 1, "exc_registration", "exc_registration");
    //add_options_page( page_title, menu_title, capability, menu_slug, function )
}
add_action('admin_menu', 'exc_registration_form_admin');

function exc_registration() {
    include('inc/registration_form.php');
}

// Frontend Shortcode Files
include('inc/shortcode_registration_form.php');
include('inc/ajax_form.php');


// Enqueue Style files
function exc_enqueue_style() {
	wp_enqueue_style( 'bootstrap', plugins_url( 'exc_registration/assets/css/bootstrap.min.css', dirname(__FILE__) ), false ); 
	wp_enqueue_style( 'plugin_base', plugins_url( 'exc_registration/assets/css/plugin_base.css', dirname(__FILE__) ), false ); 
}

// Enqueue Scripts files
function exc_enqueue_script() {
	wp_enqueue_script( 'jquery-js', plugins_url( 'exc_registration/assets/js/jquery-3.4.1.min.js', dirname(__FILE__) ), false );
	wp_enqueue_script( 'bootstrap-js', plugins_url( 'exc_registration/assets/js/bootstrap.min.js', dirname(__FILE__) ), false );
	wp_enqueue_script( 'functions-js', plugins_url( 'exc_registration/assets/js/functions.js', dirname(__FILE__) ), false );
}

add_action( 'wp_enqueue_scripts', 'exc_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'exc_enqueue_script' );