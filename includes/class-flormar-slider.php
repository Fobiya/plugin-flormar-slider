<?php

if (!defined('ABSPATH')) {
    exit;
}

class FlormarSlider {
    
    public function __construct() {
        // Constructor
    }

    public function init() {
        // Initialize plugin functionality
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('init', array($this, 'register_post_type'));
        add_shortcode('flormar_slider', array($this, 'render_slider'));
    }

    public function enqueue_scripts() {
        // Enqueue Splide.js
        wp_enqueue_style('splide', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css');
        wp_enqueue_script('splide', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', array(), '4.1.4', true);
    }

    public function register_post_type() {
        register_post_type('flormar_slider', array(
            'labels' => array(
                'name' => __('Flormar Sliders'),
                'singular_name' => __('Flormar Slider')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
        ));
    }

    public function render_slider($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
        ), $atts);

        $output = '<div class="flormar-slider">';
        if (!empty($atts['id'])) {
            $slider_posts = new WP_Query(array(
                'post_type' => 'flormar_slider',
                'p' => $atts['id'],
            ));

            if ($slider_posts->have_posts()) {
                while ($slider_posts->have_posts()) {
                    $slider_posts->the_post();
                    $output .= '<div class="slide">' . get_the_content() . '</div>';
                }
                wp_reset_postdata();
            }
        }
        $output .= '</div>';

        return $output;
    }
}
?>