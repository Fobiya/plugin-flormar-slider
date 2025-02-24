<?php
/**
 * Plugin Name: Flormar Slider
 * Description: A simple slider plugin for WordPress.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin directory
define( 'FLORMAR_SLIDER_DIR', plugin_dir_path( __FILE__ ) );

// Include the main class
require_once FLORMAR_SLIDER_DIR . 'includes/class-flormar-slider.php';

// Initialize the plugin
function flormar_slider_init() {
    $flormar_slider = new FlormarSlider();
    $flormar_slider->init();
}
add_action( 'plugins_loaded', 'flormar_slider_init' );

// Enqueue scripts and styles
function flormar_slider_enqueue_assets() {
    wp_enqueue_style( 'flormar-slider-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
    wp_enqueue_script( 'flormar-slider-script', plugins_url( 'assets/js/script.js', __FILE__ ), array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'flormar_slider_enqueue_assets' );
?>