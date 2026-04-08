<?php
/**
 * The Template for displaying all single products
 *
 * This template overrides the WooCommerce default to match Massload's custom
 * ACF-driven Layout exactly.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();

// Fetch ACF Data
$specification = get_field('specification');
$specifications = get_field('specifications');
$options = get_field('options'); // Related Products
$document_content = get_field('document_content');

$highlights_content = get_field('highlights_content');
$product_print_image = get_field('hi_left_image');

$images_list = get_field('images_list');

// We are inside the Loop
while (have_posts()):
    the_post();
    ?>




    </div>
    <!-- End Pageheader (opened in global header) if applicable, but usually closed there. Let's stick to the content structure -->

    <div id="pagecontent" class="pagecontent single-product-custom-layout">
        <!-- BREADCRUMBS (Top-Left) -->
        <div class="row">
            <div class="col-md-12">
                <style>
                    .core-breadcrumbs {
                        margin-bottom: 30px;
                        text-align: left;
                        padding: 20px 0 0 20px;
                    }

                    .core-breadcrumbs ul {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                        display: flex;
                        justify-content: flex-start;
                        flex-wrap: wrap;
                    }

                    .core-breadcrumbs li {
                        font-size: 10px;
                        text-transform: capitalize;
                        font-weight: 400;
                        color: #404040;
                        letter-spacing: 0.5px;
                    }

                    .core-breadcrumbs li a {
                        color: #404040 !important;
                        text-decoration: none;
                        border-bottom: none !important;
                    }

                    .core-breadcrumbs li.separator {
                        margin: 0 2px;
                        padding: 0 !important;
                        color: #404040;
                    }
                </style>
                <?php core_breadcrumbs(); ?>
            </div>
        </div>
        <div class="container pt-3">



            <!-- SECTION 1: TITLE -->
            <div class="row mb-5">
                <div class="col-md-12 text-center single-product-title">
                    <?php
                    $custom_title = get_field('custom_title');
                    $title = $custom_title ? $custom_title : get_the_title();
                    $words = explode(' ', $title);
                    if (count($words) > 0) {
                        $words[0] = '<span style="color: #e30913;">' . $words[0] . '</span>';
                        $title = implode(' ', $words);
                    }
                    ?>
                    <h1><?php echo $title; ?></h1>
                </div>
            </div>

            <!-- SECTION 2: 2 COLUMNS (SLIDER & DESC/HIGHLIGHTS) -->
            <div class="row mb-5">

                <!-- Column 1: Product Images Slider (ACF) -->
                <div class="col-md-5 productImage-left">
                    <?php if (!empty($images_list)): ?>
                        <div class="slider-section-title">IMAGES</div>
                        <div class="thumbnail-slider">
                            <!-- Main Image Slider -->
                            <div class="slider common-content slider-content">
                                <?php
                                if (have_rows('images_list')):
                                    while (have_rows('images_list')):
                                        the_row();
                                        $image = get_sub_field('images');
                                        if (is_array($image)) { ?>
                                            <div>
                                                <a href="<?php echo esc_url($image['url']); ?>" rel="lightbox">
                                                    <img src="<?php echo esc_url($image['url']); ?>"
                                                        alt="<?php echo esc_attr($image['alt']); ?>">
                                                </a>
                                            </div>
                                        <?php }
                                    endwhile;
                                endif; ?>
                            </div>

                            <!-- Thumbnail Slider -->
                            <div class="slider common-thumb slider-thumb">
                                <?php
                                if (have_rows('images_list')):
                                    while (have_rows('images_list')):
                                        the_row();
                                        $image = get_sub_field('images');
                                        if (is_array($image)) { ?>
                                            <div>
                                                <img src="<?php echo esc_url($image['url']); ?>"
                                                    alt="<?php echo esc_attr($image['alt']); ?>">
                                            </div>
                                        <?php }
                                    endwhile;
                                endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Fallback: WooCommerce gallery images in same Slick slider -->
                        <?php
                        global $product;
                        $gallery_ids = $product->get_gallery_image_ids();
                        $featured_id = get_post_thumbnail_id();

                        // Combine featured + gallery
                        $all_ids = array();
                        if ($featured_id)
                            $all_ids[] = $featured_id;
                        if ($gallery_ids)
                            $all_ids = array_merge($all_ids, $gallery_ids);

                        if (!empty($all_ids)):
                            ?>
                            <div class="slider-section-title">IMAGES</div>
                            <div class="thumbnail-slider">
                                <div class="slider common-content slider-content">
                                    <?php foreach ($all_ids as $img_id):
                                        $img_url = wp_get_attachment_image_url($img_id, 'full');
                                        $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                                        ?>
                                        <div>
                                            <a href="<?php echo esc_url($img_url); ?>" rel="lightbox">
                                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="slider common-thumb slider-thumb">
                                    <?php foreach ($all_ids as $img_id):
                                        $img_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                                        $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                                        ?>
                                        <div>
                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- No images at all -->
                            <?php woocommerce_show_product_images(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Column 2: Description, Highlights & Add to Quote Button -->
                <div class="col-md-7 product-description">

                    <!-- Product Description -->
                    <div class="product-content-wrapper mb-4">
                        <?php
                        $content = apply_filters('the_content', get_the_content());
                        echo $content;
                        ?>
                    </div>

                    <!-- Product Details (ACF Repeater) -->
                    <?php
                    $product_details_title = get_field('product_details_title');
                    $product_details = get_field('product_details');
                    if (!empty($product_details)): ?>
                        <div class="product-details mt-4">
                            <?php if (!empty($product_details_title)): ?>
                                <div class="row product-details-title-wrap">
                                    <div class="col-md-12 inner-wrap">
                                        <h2 class="product-details-title"><?php echo esc_html($product_details_title); ?></h2>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php foreach ($product_details as $product_detail):
                                $details = isset($product_detail['details']) && is_array($product_detail['details']) ? $product_detail['details'] : [];
                                $total_details = count($details);
                                if ($total_details === 0)
                                    continue;
                                ?>
                                <div class="row row-details">
                                    <?php foreach ($details as $detail):
                                        $content_type = isset($detail['content_type']) ? $detail['content_type'] : 'Content';
                                        $content_title = isset($detail['title']) ? $detail['title'] : '';
                                        $content_text = isset($detail['content']) ? $detail['content'] : '';
                                        $content_img = isset($detail['image']) ? $detail['image'] : '';

                                        // All items full width
                                        $col_class = 'details-column col-md-12';

                                        if ($content_type === 'Content')
                                            $col_class .= ' content-column';
                                        if ($content_type === 'Image')
                                            $col_class .= ' image-column';
                                        ?>
                                        <div class="<?php echo esc_attr($col_class); ?>">
                                            <?php if ($content_type === 'Content'): ?>
                                                <?php if (!empty($content_title)): ?>
                                                    <h4 class="detail-title"><?php echo esc_html($content_title); ?></h4>
                                                <?php endif; ?>
                                                <?php if (!empty($content_text)): ?>
                                                    <?php echo wp_kses_post($content_text); ?>
                                                <?php endif; ?>
                                            <?php elseif ($content_type === 'Image' && !empty($content_img)): ?>
                                                <img src="<?php echo esc_url($content_img); ?>"
                                                    alt="<?php echo esc_attr($product_details_title); ?>" class="img-fluid">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Product Highlights -->
                    <?php if (!empty($highlights_content) || !empty($product_print_image)) { ?>
                        <div class="wwr-right red-title headingsecondary-block mt-5">
                            <div class="wwr-right-inner1">
                                <div class="product-highlights">
                                    <h2><?php esc_html_e('Highlights', 'massload'); ?></h2>
                                    <?php echo wp_kses_post($highlights_content); ?>
                                </div>
                                <?php if (!empty($product_print_image)) { ?>
                                    <div class="product-print-image text-center mt-3">
                                        <img src="<?php echo esc_url($product_print_image); ?>" class="print-image img-fluid"
                                            alt="Highlight Reference">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Request Quote Button (YITH) -->
                    <div class="mt-4 text-center yith-quote-btn-wrap">
                        <?php
                        if (function_exists('yith_ywraq_render_button')) {
                            // Use YITH's native add-to-quote button
                            echo do_shortcode('[yith_ywraq_button_quote]');
                        } else {
                            // Fallback if YITH is not active
                            ?>
                            <a href="javascript:void(0);"
                                onclick="document.getElementById('req-quote').scrollIntoView({behavior:'smooth'});"
                                class="cta-button-rfq shadow-sm">
                                ADD TO QUOTE
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>

            </div> <!-- End Section 2 Row -->

        </div> <!-- End Container -->

        <!-- SECTION 3: PRODUCT SPECIFICATIONS -->
        <?php if (!empty($specifications) || !empty($document_content)): ?>
            <section id="specifications-section" class="additional-info mb-5 bg-light pt-5 pb-5">
                <div class="container">
                    <div class="dark_blk text-center mb-4 heading-block">
                        <h2><span>PRODUCT</span> SPECIFICATIONS</h2>
                    </div>

                    <div id="additional-info-tab" class="tabPlugin">
                        <ul class="nav nav-tabs mb-4 justify-content-center" style="border-bottom: 2px solid #e30913;">
                            <?php if ($specifications): ?>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab-1"
                                        style="color:#333; font-weight:bold; font-size:18px; padding:15px 30px; border-radius:0;"><?php esc_html_e(' Specifications ', 'massload'); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ($document_content): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo !$specifications ? 'active' : ''; ?>" data-toggle="tab"
                                        href="#tab-2"
                                        style="color:#333; font-weight:bold; font-size:18px; padding:15px 30px; border-radius:0;"><?php esc_html_e(' Documents ', 'massload'); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div class="tab-content bg-white p-4 shadow-sm">
                            <?php if ($specifications) { ?>
                                <div id="tab-1" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="specifications-table">
                                            <tbody>
                                                <?php foreach ($specifications as $key => $specification) {
                                                    $spec_title = core_isset_array($specification, 'title', '');
                                                    $spec_desc = core_isset_array($specification, 'description', '');

                                                    if (!empty($spec_title) || !empty($spec_desc)) {
                                                        echo '<tr>';
                                                        echo '<th>' . esc_html($spec_title) . '</th>';
                                                        echo '<td>' . wp_kses_post($spec_desc) . '</td>';
                                                        echo '</tr>';
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($document_content): ?>
                                <div id="tab-2" class="tab-pane fade <?php echo !$specifications ? 'show active' : ''; ?>">
                                    <?php echo wp_kses_post($document_content); ?>
                                    <!-- Optional Document List -->
                                    <?php if (have_rows('document_list')): ?>
                                        <ul class="list-unstyled mt-3">
                                            <?php while (have_rows('document_list')):
                                                the_row();
                                                $link1 = get_sub_field('link');
                                                if ($link1):
                                                    ?>
                                                    <li class="mb-2">
                                                        <i class="fa fa-file-pdf-o" style="color:#e30913; margin-right:8px;"
                                                            aria-hidden="true"></i>
                                                        <strong>
                                                            <?php if (get_sub_field('document_label')) {
                                                                the_sub_field('document_label');
                                                            } else {
                                                                esc_html_e('Brochure: ', 'massload');
                                                            } ?>
                                                        </strong>
                                                        <a class="text-danger font-weight-bold" href="<?php echo esc_url($link1['url']); ?>"
                                                            target="<?php echo esc_attr($link1['target'] ? $link1['target'] : '_self'); ?>">
                                                            <?php echo esc_html($link1['title']); ?>
                                                        </a>
                                                    </li>
                                                <?php endif; endwhile; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- SECTION 4: RELATED PRODUCTS -->
        <?php
        $related_source = get_post_meta(get_the_ID(), '_related_products_source', true);
        if (empty($related_source))
            $related_source = 'custom';

        // Get WooCommerce upsell products
        $woo_upsell_ids = [];
        if ($related_source === 'woocommerce' && function_exists('wc_get_product')) {
            $wc_product = wc_get_product(get_the_ID());
            if ($wc_product) {
                $woo_upsell_ids = $wc_product->get_upsell_ids();
            }
        }

        $show_related = ($related_source === 'custom' && $options) || ($related_source === 'woocommerce' && !empty($woo_upsell_ids));
        ?>

        <?php if ($show_related): ?>
            <section class="related-products mb-5 pt-5 pb-5">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 class="massload-title" style="font-size:32px; font-weight:700; text-transform:uppercase;">RELATED
                            <span style="text-underline-offset:8px;">PRODUCTS</span>
                        </h2>
                    </div>

                    <div class="row">

                        <?php if ($related_source === 'custom'): ?>
                            <!-- Custom ACF Options -->
                            <?php if (have_rows('options')): ?>
                                <?php while (have_rows('options')):
                                    the_row();
                                    $linked_product_id = get_sub_field('option_product_link');
                                    $product_url = $linked_product_id ? get_permalink($linked_product_id) : '';
                                    $option_content = get_sub_field('option_content');
                                    $h3_title = '';
                                    if (preg_match('/<h3[^>]*>(.*?)<\/h3>/si', $option_content, $m)) {
                                        $h3_title = trim(strip_tags($m[1]));
                                    }
                                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="related-product-card">
                                            <?php if (get_sub_field('option_image')): ?>
                                                <div class="related-product-img">
                                                    <?php if ($product_url): ?>
                                                        <a href="<?php echo esc_url($product_url); ?>">
                                                        <?php endif; ?>
                                                        <img src="<?php the_sub_field('option_image'); ?>"
                                                            alt="<?php echo esc_attr(get_sub_field('alt_text') ?: $h3_title); ?>">
                                                        <?php if ($product_url): ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="related-product-title">
                                                <?php echo esc_html($h3_title ?: 'Related Product'); ?>
                                            </div>
                                            <?php if ($product_url): ?>
                                                <a href="<?php echo esc_url($product_url); ?>" class="related-product-link">
                                                    VIEW PRODUCT <span>›</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>

                        <?php else: ?>
                            <!-- WooCommerce Upsells -->
                            <?php foreach ($woo_upsell_ids as $upsell_id):
                                $upsell_product = wc_get_product($upsell_id);
                                if (!$upsell_product)
                                    continue;
                                $upsell_url = get_permalink($upsell_id);
                                $upsell_img = get_the_post_thumbnail_url($upsell_id, 'medium');
                                $upsell_title = $upsell_product->get_name();
                                ?>
                                <div class="col-md-4 mb-4">
                                    <div class="related-product-card">
                                        <div class="related-product-img">
                                            <a href="<?php echo esc_url($upsell_url); ?>">
                                                <img src="<?php echo esc_url($upsell_img ?: wc_placeholder_img_src()); ?>"
                                                    alt="<?php echo esc_attr($upsell_title); ?>">
                                            </a>
                                        </div>
                                        <div class="related-product-title">
                                            <?php echo esc_html($upsell_title); ?>
                                        </div>
                                        <a href="<?php echo esc_url($upsell_url); ?>" class="related-product-link">
                                            VIEW PRODUCT <span>›</span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

                <style>
                    .related-product-card {
                        background: #fff;
                        overflow: hidden;
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        width: 100%;
                    }

                    .related-product-img {
                        height: 250px;
                        overflow: hidden;
                    }

                    .related-product-img a {
                        display: block;
                        width: 100%;
                        height: 100%;
                    }

                    .related-product-img img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        display: block;
                        transition: transform 0.3s ease;
                    }

                    .related-product-card:hover .related-product-img img {
                        transform: scale(1.03);
                    }

                    .related-product-title {
                        background: #000;
                        color: #fff;
                        font-size: 16px;
                        font-weight: 700;
                        text-transform: uppercase;
                        padding: 12px 15px;
                    }

                    .related-product-link {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        background: #4c4c4c;
                        color: #ccc;
                        font-size: 13px;
                        font-weight: 600;
                        text-transform: uppercase;
                        padding: 10px 15px;
                        text-decoration: none;
                        transition: background 0.3s ease;
                        letter-spacing: 0.5px;
                    }

                    .related-product-link:hover {
                        background: #333;
                        color: #fff;
                        text-decoration: none;
                    }

                    .related-product-link span {
                        font-size: 18px;
                    }

                    .related-products .row {
                        display: flex;
                        flex-wrap: wrap;
                    }

                    .related-products .row>[class*="col-"] {
                        display: flex;
                    }
                </style>
            </section>
        <?php endif; ?>

        <!-- SECTION 5: TESTIMONIALS -->
        <?php
        $enable_testimonial = get_field('enable_testimonial');
        $testimonial_shortcode = get_field('testimonial_shortcode');
        $testimonial_area_title = get_field('testimonial_area_title');

        if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)):
            ?>
            <section class="container product-section1 text-center product-lisiting mt-5 mb-5 pb-5">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="heading-block mb-4">
                            <h2><?php echo esc_html($testimonial_area_title ? $testimonial_area_title : 'Testimonials'); ?></h2>
                        </div>
                        <div class="testimonial-block shadow-sm p-4 rounded">
                            <?php echo do_shortcode($testimonial_shortcode); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>



    </div> <!-- End .pagecontent -->

    <?php
    // Include Slick Slider for all product gallery types
    if (true):
        ?>
        <!-- Include Slick CSS & JS -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

        <!-- Include Slick Slider JS logic -->
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof jQuery !== 'undefined') {

                    // Ensure slick is loaded before invoking it
                    if (jQuery.fn.slick) {
                        jQuery('.slider-content').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            fade: true,
                            infinite: true,
                            speed: 500,
                            asNavFor: '.slider-thumb',
                            arrows: true,
                            prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"></button>',
                            nextArrow: '<button type="button" class="slick-next" aria-label="Next"></button>',
                        });
                        jQuery('.slider-thumb').slick({
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            asNavFor: '.slider-content',
                            arrows: false,
                            dots: false,
                            focusOnSelect: true,
                            variableWidth: true,
                        });
                    } else {
                        console.error("Slick Slider library is not loaded. Please enqueue slick.js in your theme.");
                    }
                }
            });
        </script>
    <?php endif; ?>

    <?php
endwhile; // end of the loop.

get_footer();
?>