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
        <div class="box__background">
            <div class="box__flormar__container">
                <div class="box__flormar">
                    <div class="splide full-width-slider">
                        <div class="splide__track">
                            <div class="splide__list"> <!-- Changed from ul to div -->
                                <?php while ($products->have_posts()) : $products->the_post();
                                    global $product; ?>
                                    <div class="splide__slide"> <!-- Changed from li to div -->
                                        <div class="slide-inner">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php echo woocommerce_get_product_thumbnail(); ?>
                                                <h3><?php the_title(); ?></h3>
                                                <span class="price"><?php echo $product->get_price_html(); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('.full-width-slider', {
                    perPage: 4,
                    perMove: 1,
                    gap: 42,
                    type: 'loop',
                    pagination: false,
                    arrows: true,
                    drag: true,
                    snap: true,
                    cloneStatus: true,
                    focus: 0,
                    trimSpace: false,
                    breakpoints: {
                        1124: {
                            perPage: 3,
                            gap: 42,
                            arrows: false,
                        },
                        768: {
                            perPage: 2,
                            gap: 32,
                            arrows: false,
                        },
                        480: {
                            perPage: 2,
                            gap: 20,
                            arrows: false,
                        }
                    }
                }).mount();
            });
        </script>
    <?php endif;

    wp_reset_postdata();
    
    return ob_get_clean();
}
?>