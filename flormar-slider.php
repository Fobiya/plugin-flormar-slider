<?php
/**
 * Plugin Name: Flormar Slider
 * Description: A simple slider plugin for WordPress.
 * Version: 1.0
 * Author: Fobiya
 * Author URI: https://github.com/Fobiya/plugin-flormar-slider
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin directory
define('FLORMAR_SLIDER_DIR', plugin_dir_path(__FILE__));

// Include the main class
require_once FLORMAR_SLIDER_DIR . 'includes/class-flormar-slider.php';

// Initialize the plugin
function flormar_slider_init() {
    $flormar_slider = new FlormarSlider();
    $flormar_slider->init();
}
add_action('plugins_loaded', 'flormar_slider_init');

// Enqueue scripts and styles
function flormar_slider_enqueue_assets() {
    wp_enqueue_style('flormar-slider-style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script('flormar-slider-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'flormar_slider_enqueue_assets');

// Add shortcode
add_shortcode('flormar-test-slider', 'flormar_test_slider_shortcode');

function flormar_test_slider_shortcode($atts) {
    // Parse attributes
    $atts = shortcode_atts(array(
        'min-price' => '',
        'max-price' => ''
    ), $atts);

    // WooCommerce query arguments
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );

    // Add price filter if parameters are set
    if (!empty($atts['min-price']) || !empty($atts['max-price'])) {
        $args['meta_query'] = array(
            array(
                'key' => '_price',
                'type' => 'NUMERIC'
            )
        );

        if (!empty($atts['min-price'])) {
            $args['meta_query'][0]['value'] = floatval($atts['min-price']);
            $args['meta_query'][0]['compare'] = '>=';
        }

        if (!empty($atts['max-price'])) {
            if (!empty($atts['min-price'])) {
                $args['meta_query'][] = array(
                    'key' => '_price',
                    'value' => floatval($atts['max-price']),
                    'type' => 'NUMERIC',
                    'compare' => '<='
                );
            } else {
                $args['meta_query'][0]['value'] = floatval($atts['max-price']);
                $args['meta_query'][0]['compare'] = '<=';
            }
        }
    }

    $products = new WP_Query($args);
    
    ob_start();
    
    if ($products->have_posts()) : ?>
        <div class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php while ($products->have_posts()) : $products->the_post();
                        global $product; ?>
                        <li class="splide__slide">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo woocommerce_get_product_thumbnail(); ?>
                                <h3><?php the_title(); ?></h3>
                                <span class="price"><?php echo $product->get_price_html(); ?></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('.splide', {
                    perPage: 4,
                    gap: '1rem',
                    breakpoints: {
                        1024: {
                            perPage: 3,
                        },
                        768: {
                            perPage: 2,
                        },
                        480: {
                            perPage: 1,
                        },
                    }
                }).mount();
            });
        </script>
    <?php endif;

    wp_reset_postdata();
    
    return ob_get_clean();
}
?>