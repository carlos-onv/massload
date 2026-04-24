<?php

/**
 * Related Industries Shortcode
 *
 * @package    Massload
 * @subpackage inc/shortcodes
 */

if (!defined('ABSPATH')) {
    return;
}

/**
 * Related Industries Shortcode Class.
 */
class Core_Related_Industries_Shortcode
{

    protected $shortcode_name = 'related_industries';

    public function __construct()
    {
        add_action('init', array($this, 'register_shortcode_tag'));
    }

    public function register_shortcode_tag()
    {
        add_shortcode('massload_related_industries', array($this, 'register_shortcode'));
    }

    /**
     * Registers the shortcode attributes.
     */
    public function register_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'title' => 'RELATED INDUSTRIES',
                'show_title' => 'true',
            ),
            $atts,
            'massload_related_industries'
        );
        return $this->display($atts);
    }

    /**
     * Displays the shortcode.
     */
    public function display($atts, $content = null)
    {
        $industries = get_field('associated_industries');

        if (empty($industries)) {
            return '';
        }

        ob_start();
        ?>
        <section class="related-industries-shortcode mb-5 mt-4">
            <div class="shortcode-container">
                <?php if (strtolower($atts['show_title']) === 'true'): ?>
                    <div class="text-center mb-4">
                        <h2 class="massload-title" style="font-size:32px; font-weight:700; text-transform:uppercase;">
                            <?php 
                                $title_words = explode(' ', $atts['title']);
                                if (count($title_words) >= 2) {
                                    $title_words[1] = '<span style="color:#e30913;">' . esc_html($title_words[1]) . '</span>';
                                    echo esc_html($title_words[0]) . ' ' . $title_words[1];
                                    if (count($title_words) > 2) {
                                        echo ' ' . esc_html(implode(' ', array_slice($title_words, 2)));
                                    }
                                } else {
                                    echo esc_html($atts['title']);
                                } 
                            ?>
                        </h2>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <?php
                    $count = 0;
                    foreach ($industries as $industry):
                        $count++;
                        $industry_id = $industry->ID;
                        $industry_link = get_permalink($industry_id);
                        $industry_name = get_the_title($industry_id);
                        $industry_img = get_the_post_thumbnail_url($industry_id, 'medium');

                        // Handle visibility for "Show More" logic
                        $item_class = ($count > 6) ? 'industry-hidden-item' : '';
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4 <?php echo esc_attr($item_class); ?>">
                            <div class="related-product-card industry-card shadow-sm h-100">
                                <div class="related-product-img">
                                    <a href="<?php echo esc_url($industry_link); ?>">
                                        <img src="<?php echo esc_url($industry_img ?: CORE_DEFAULT_THUMBNAIL); ?>"
                                            alt="<?php echo esc_attr($industry_name); ?>">
                                    </a>
                                </div>
                                <div class="related-product-title">
                                    <?php echo esc_html($industry_name); ?>
                                </div>
                                <a href="<?php echo esc_url($industry_link); ?>" class="related-product-link">
                                    VIEW INDUSTRY <span>›</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($count > 6): ?>
                    <div class="text-center mt-3">
                        <button id="show-all-industries-btn" class="theme-btn" style="min-width: 250px;">SHOW ALL
                            INDUSTRIES</button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var btn = document.getElementById('show-all-industries-btn');
                            if (btn) {
                                btn.addEventListener('click', function () {
                                    document.querySelectorAll('.industry-hidden-item').forEach(function (el) {
                                        el.classList.remove('industry-hidden-item');
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
                .industry-hidden-item {
                    display: none;
                }

                .related-product-card.industry-card {
                    background: #fff;
                    display: flex;
                    flex-direction: column;
                    transition: transform 0.3s ease;
                }

                .related-product-card.industry-card:hover {
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

new Core_Related_Industries_Shortcode();
