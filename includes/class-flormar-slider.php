<?php
class FlormarSlider {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_shortcode('flormar_slider', array($this, 'render_slider'));
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