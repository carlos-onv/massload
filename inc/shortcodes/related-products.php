<?php

/**
 * Related Products Shortcode
 *
 * @package    Massload
 * @subpackage inc/shortcodes
 */

if (!defined('ABSPATH')) {
    return;
}

/**
 * Related Products Shortcode Class.
 */
class Core_Related_Products_Shortcode
{

    protected $shortcode_name = 'related_products';

    public function __construct()
    {
        add_action('init', array($this, 'register_shortcode_tag'));
    }

    public function register_shortcode_tag()
    {
        add_shortcode('massload_related_products', array($this, 'register_shortcode'));
    }

    /**
     * Registers the shortcode attributes.
     */
    public function register_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'title' => 'RELATED PRODUCTS',
                'show_title' => 'true',
            ),
            $atts,
            'massload_related_products'
        );
        return $this->display($atts);
    }

    /**
     * Displays the shortcode.
     */
    public function display($atts, $content = null)
    {
        $post_id = get_the_ID();
        $products = get_field('associated_products', $post_id);

        if (empty($products)) {
            return '';
        }

        ob_start();
?>
        <section class="related-products-shortcode mb-5 mt-4">
            <div class="shortcode-container">
                <?php if (strtolower($atts['show_title']) === 'true'): ?>
                    <div class="text-center mb-4">
                        <h2 class="massload-title" style="font-size:32px; font-weight:700; text-transform:uppercase;">
                            <?php echo esc_html($atts['title']); ?>
                        </h2>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <?php
                    $count = 0;
                    foreach ($products as $product):
                        $count++;
                        $product_id = is_object($product) ? $product->ID : $product;
                        $product_link = get_permalink($product_id);
                        $product_name = get_the_title($product_id);
                        $product_img = get_the_post_thumbnail_url($product_id, 'medium');

                        // Handle visibility for "Show More" logic
                        $item_class = ($count > 6) ? 'product-hidden-item' : '';
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4 <?php echo esc_attr($item_class); ?>">
                            <div class="related-product-card product-card shadow-sm h-100">
                                <div class="related-product-img">
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <img src="<?php echo esc_url($product_img ?: CORE_DEFAULT_THUMBNAIL); ?>"
                                            alt="<?php echo esc_attr($product_name); ?>">
                                    </a>
                                </div>
                                <div class="related-product-title">
                                    <?php echo esc_html($product_name); ?>
                                </div>
                                <a href="<?php echo esc_url($product_link); ?>" class="related-product-link">
                                    VIEW PRODUCT <span>›</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($count > 6): ?>
                    <div class="text-center mt-3">
                        <button id="show-all-products-btn" class="theme-btn" style="min-width: 250px;">SHOW ALL
                            PRODUCTS</button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var btn = document.getElementById('show-all-products-btn');
                            if (btn) {
                                btn.addEventListener('click', function () {
                                    document.querySelectorAll('.product-hidden-item').forEach(function (el) {
                                        el.classList.remove('product-hidden-item');
                                        el.style.display = 'block';
                                    });
                                    this.parentElement.style.display = 'none';
                                });
                            }
                        });
                    </script>
                <?php endif; ?>
            </div>

            <style>
                .product-hidden-item {
                    display: none;
                }

                .related-product-card.product-card {
                    background: #fff;
                    display: flex;
                    flex-direction: column;
                    transition: transform 0.3s ease;
                }

                .related-product-card.product-card:hover {
                    transform: translateY(-5px);
                }

                .related-product-img {
                    height: 220px;
                    overflow: hidden;
                }

                .related-product-img img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .related-product-title {
                    background: #000;
                    color: #fff;
                    padding: 5px 10px;
                    text-align: center;
                    font-weight: 700;
                    text-transform: uppercase;
                    flex-grow: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: .85rem;
                    word-break: break-word;
                }

                .related-product-link {
                    display: block;
                    background: #4c4c4c;
                    color: #ccc !important;
                    text-align: center;
                    padding: 10px;
                    font-weight: 700;
                    text-decoration: none !important;
                }

                .related-product-link span {
                    margin-left: 5px;
                }

                @media (max-width: 575px) {
                    .related-product-img {
                        height: 250px;
                    }
                }
            </style>
        </section>
        <?php
        return ob_get_clean();
    }

}

new Core_Related_Products_Shortcode();
