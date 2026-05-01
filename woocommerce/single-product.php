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

// We are inside the Loop
while (have_posts()):
    the_post();

    global $product;
    $product = wc_get_product(get_the_ID());

    // Fetch ACF Data
    $specification = get_field('specification');
    $specifications = get_field('specifications');
    $document_content = get_field('document_content');
    $show_related = get_field('show_related');

    $highlights_content = get_field('highlights_content');
    $product_print_image = get_field('hi_left_image');

    $images_list = get_field('images_list');
    ?>




    </div>
    <!-- End Pageheader (opened in global header) if applicable, but usually closed there. Let's stick to the content structure -->

    <div id="pagecontent" class="pagecontent single-product-custom-layout">

        <div class="container pt-3">
            <!-- BREADCRUMBS (Top-Left) -->
            <div class="row">
                <div class="col-md-12">
                    <style>
                        .core-breadcrumbs {
                            margin-bottom: 30px;
                            text-align: left;
                            padding: 20px 0 0 0;
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
                            font-size: 12px;
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

                        /* Product Variations Styling */
                        .variations_form {
                            background: transparent;
                            padding: 0;
                            border: none;
                        }

                        .variations_form table,
                        .variations_form tbody,
                        .variations_form tr,
                        .variations_form td {
                            border: none !important;
                            padding: 0 !important;
                            background: transparent !important;
                            color: #333;
                        }

                        .variations_form table {
                            margin-bottom: 20px;
                            width: 100%;
                            border-spacing: 0 15px;
                            border-collapse: separate;
                        }

                        .variations_form .label {
                            text-align: left;
                            width: 120px;
                            font-size: 13px;
                            color: #333;
                            font-weight: 700 !important;
                            text-transform: uppercase;
                            background: transparent !important;
                            padding: 15px 0 !important;
                            vertical-align: middle;
                        }

                        .variations_form td.value {
                            background: transparent !important;
                            padding: 5px 0 !important;
                            vertical-align: middle;
                            position: relative;
                        }

                        .variations_form select {
                            width: 100%;
                            height: 50px;
                            border: 1px solid #ddd;
                            border-radius: 0;
                            padding: 0 15px;
                            font-size: 15px;
                            color: #333;
                            appearance: none;
                            background-color: #fff !important;
                            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M10.293%203.293L6%207.586%201.707%203.293A1%201%200%2000.293%204.707l5%205a1%201%200%20001.414%200l5-5a1%201%200%2010-1.414-1.414z%22%2F%3E%3C%2Fsvg%3E");
                            background-repeat: no-repeat;
                            background-position: right 15px center;
                            background-size: 12px;
                            cursor: pointer;
                        }

                        .variations_form select:focus {
                            border-color: #e30913;
                            outline: none;
                        }

                        .reset_variations {
                            display: inline-block;
                            margin-top: 5px !important;
                            color: #e30913 !important;
                            text-decoration: none !important;
                            font-size: 12px;
                            font-weight: 600;
                            float: right;
                        }

                        /* Hide Quantity for Quotes */
                        .variations_form .quantity,
                        .variations_form .group_table .quantity {
                            display: none !important;
                        }

                        .single_variation_wrap {
                            margin-top: 30px;
                            text-align: center;
                        }

                        .woocommerce-variation-price,
                        .variations_form .single_variation_wrap .woocommerce-variation-add-to-cart,
                        .variations_form .variations_button {
                            display: none !important;
                        }

                        /* Button Styling to match cta-button-rfq */
                        button.single_add_to_cart_button,
                        .variations_button .button,
                        .add-to-quote-button {
                            background-color: #e30913 !important;
                            color: #fff !important;
                            border: none !important;
                            padding: 15px 40px !important;
                            font-size: 16px !important;
                            font-weight: 700 !important;
                            letter-spacing: 1px !important;
                            border-radius: 0 !important;
                            transition: all 0.3s ease !important;
                            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
                            cursor: pointer;
                            display: inline-block !important;
                            width: auto;
                            min-width: 200px;
                            text-decoration: none !important;
                        }

                        button.single_add_to_cart_button:hover,
                        .variations_button .button:hover,
                        .add-to-quote-button:hover {
                            background-color: #333 !important;
                            transform: translateY(-2px);
                            color: #fff !important;
                        }

                        .woocommerce-variation-price {
                            display: none !important;
                            /* Hide price for quotes */
                        }

                        /* Responsive Tables for Highlights/Specs */
                        .table-responsive-wrapper {
                            width: 100%;
                            overflow-x: auto;
                            -webkit-overflow-scrolling: touch;
                            margin-top: 20px;
                            margin-bottom: 30px;

                        }

                        .specifications-table {
                            width: 100% !important;
                            border-collapse: collapse !important;
                            min-width: 600px;
                            /* Force scroll on mobile */
                        }

                        .specifications-table th {
                            background: #eee;
                            color: #333;
                            font-weight: 700;
                            text-align: center;
                            padding: 12px 10px !important;
                            font-size: 13px;
                            border: 1px solid #ddd !important;
                            text-transform: uppercase;
                        }

                        .specifications-table td {
                            padding: 10px !important;
                            text-align: center;
                            border: 1px solid #ddd !important;
                            font-size: 14px;
                        }

                        .specifications-table tr:nth-child(even) {
                            background-color: #f9f9f9;
                        }
                    </style>
                    <?php core_breadcrumbs(); ?>
                </div>
            </div>


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
                    <?php
                    // Product Certifications
                    $certifications = get_the_terms(get_the_ID(), 'certification');
                    if (!empty($certifications) && !is_wp_error($certifications)): ?>
                        <div class="product-certifications mb-3">

                            <div class="certifications-logos">
                                <?php foreach ($certifications as $cert):
                                    $logo = get_field('certification_logo', 'certification_' . $cert->term_id);
                                    if ($logo): ?>
                                        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($cert->name); ?>"
                                            title="<?php echo esc_attr($cert->name); ?>">
                                    <?php else: ?>
                                        <span class="cert-text-badge"><?php echo esc_html($cert->name); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Column 2: Description, Highlights & Add to Quote Button -->
                <div class="col-md-7 product-description">



                    <!-- Short Description -->
                    <?php if (has_excerpt()): ?>
                        <div class="product-short-description-wrapper mb-4">

                            <div class="short-description-content">
                                <?php echo apply_filters('woocommerce_short_description', get_the_excerpt()); ?>
                            </div>
                        </div>
                    <?php endif; ?>


                    <!-- Product Highlights -->
                    <?php if (!empty($highlights_content) || !empty($product_print_image)) { ?>
                        <div class="wwr-right red-title headingsecondary-block mt-5">
                            <div class="wwr-right-inner1">
                                <div class="product-highlights">
                                    <h2><?php esc_html_e('Highlights', 'massload'); ?></h2>
                                    <div class="table-responsive-wrapper">
                                        <?php echo wp_kses_post($highlights_content); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>


                    <!-- Product Variations / Add to Quote -->
                    <div class="mt-4 product-purchase-actions">
                        <div class="variations-qty-row">
                            <?php
                            if ($product->is_type('variable')) {
                                woocommerce_variable_add_to_cart();
                            }
                            ?>
                            <div class="quote-quantity-wrapper">
                                <button type="button" class="qty-btn qty-minus" onclick="var input=document.getElementById('quote-quantity');var val=parseInt(input.value)||1;if(val>1)input.value=val-1;">−</button>
                                <input type="number" id="quote-quantity" class="quote-quantity-input" name="quantity" value="1" min="1" step="1">
                                <button type="button" class="qty-btn qty-plus" onclick="var input=document.getElementById('quote-quantity');input.value=parseInt(input.value||1)+1;">+</button>
                            </div>
                        </div>
                        <?php
                        if ($product->is_type('variable')) {
                            if (class_exists('YITH_YWRAQ_Frontend')) {
                                YITH_YWRAQ_Frontend::get_instance()->print_button($product);
                            }
                        } else {
                            echo do_shortcode('[yith_ywraq_button_quote]');
                        }
                        ?>
                    </div>
                </div>

            </div> <!-- End Section 2 Row -->

        </div> <!-- End Container -->
        <!-- Product long Description -->
        <section class="product-long-desc pt-5 pb-5">
            <div class="container">
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
                            <!-- <div class="row product-details-title-wrap">
                                <div class="col-md-12 inner-wrap">
                                    <h2 class="product-details-title">
                                        <?php //echo esc_html($product_details_title); ?>
                                    </h2>
                                </div>
                            </div> -->
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

                                            <?php endif; ?>
                                            <?php if (!empty($content_text)): ?>
                                                <?php echo wp_kses_post($content_text); ?>
                                            <?php endif; ?>
                                        <?php elseif ($content_type === 'Image' && !empty($content_img)): ?>
                                            <!-- <img src="<?php //echo esc_url($content_img); ?>"
                                                alt="<?php //echo esc_attr($product_details_title); ?>" class="img-fluid"> -->
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </section>
        <!-- SECTION 3: PRODUCT SPECIFICATIONS -->
        <?php if (!empty($specifications) || !empty($specification) || !empty($document_content) || have_rows('document_list')): ?>
            <section id="specifications-section" class="additional-info mb-5 bg-light pt-5 pb-5">
                <div class="container">


                    <?php
                    $has_specs = (!empty($specifications) || !empty($specification));
                    $has_docs = (!empty($document_content) || have_rows('document_list'));
                    $active_tab = $has_specs ? 'spec' : ($has_docs ? 'doc' : '');
                    ?>
                    <div id="additional-info-tab" class="tabPlugin">
                        <ul class="nav nav-tabs mb-4 justify-content-center" style="border-bottom: 2px solid #e30913;">
                            <?php if ($has_specs): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($active_tab === 'spec') ? 'active' : ''; ?>" data-toggle="tab"
                                        href="#tab-1"
                                        style="color:#333; font-weight:bold; font-size:18px; padding:15px 30px; border-radius:0;"><?php esc_html_e(' Specifications ', 'massload'); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ($has_docs): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($active_tab === 'doc') ? 'active' : ''; ?>" data-toggle="tab"
                                        href="#tab-2"
                                        style="color:#333; font-weight:bold; font-size:18px; padding:15px 30px; border-radius:0;"><?php esc_html_e(' Documents & Drawings ', 'massload'); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div class="tab-content dynamic-tab-content is-visible">
                            <style>
                                .dynamic-tab-content {
                                    display: none;
                                    background: #fff;
                                    padding: 25px;
                                    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                                    border: 1px solid #eee;
                                    border-top: none;
                                }

                                .dynamic-tab-content.is-visible {
                                    display: block;
                                }
                            </style>
                            <script>
                                jQuery(document).ready(function ($) {
                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                        $('.dynamic-tab-content').addClass('is-visible');
                                    });
                                });
                            </script>
                            <?php if ($has_specs) { ?>
                                <div id="tab-1" class="tab-pane fade <?php echo ($active_tab === 'spec') ? 'show active' : ''; ?>">
                                    <div class="table-responsive">
                                        <?php if (!empty($specifications)): ?>
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
                                        <?php elseif (get_field('specification')): ?>
                                            <?php the_field('specification'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($has_docs): ?>
                                <div id="tab-2" class="tab-pane fade <?php echo ($active_tab === 'doc') ? 'show active' : ''; ?>">
                                    <?php if ($document_content)
                                        echo wp_kses_post($document_content); ?>
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
        global $product;
        if (!$product) {
            $product = wc_get_product(get_the_ID());
        }

        // 1. Prioritize Upsells (manually linked) fallback to Category-based
        $display_ids = [];
        if ($product) {
            $display_ids = $product->get_upsell_ids();
            if (empty($display_ids)) {
                $display_ids = wc_get_related_products($product->get_id(), 3);
            } else {
                $display_ids = array_slice($display_ids, 0, 3);
            }
        }
        ?>

        <?php if (!empty($display_ids)): ?>
            <section class="related-products product-lisiting mb-5 pt-5 pb-5">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 class="massload-title" style="font-size:32px; font-weight:700; text-transform:uppercase;">RELATED
                            <span style="text-underline-offset:8px;">PRODUCTS</span>
                        </h2>
                    </div>

                    <div class="product-block">
                        <div class="row">

                            <?php
                            foreach ($display_ids as $p_id):
                                $p_obj = wc_get_product($p_id);
                                if (!$p_obj)
                                    continue;
                                $p_url = get_permalink($p_id);
                                $p_img = get_the_post_thumbnail_url($p_id, 'full');
                                $p_title = $p_obj->get_name();
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="productblock childProduct">
                                        <div class="product-content">
                                            <h3><a href="<?php echo esc_url($p_url); ?>"><?php echo esc_html($p_title); ?></a></h3>
                                        </div>

                                        <a href="<?php echo esc_url($p_url); ?>">
                                            <?php if ($p_img): ?>
                                                <img src="<?php echo esc_url($p_img); ?>" alt="<?php echo esc_attr($p_title); ?>">
                                            <?php else: ?>
                                                <?php echo wc_placeholder_img('full'); ?>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- SECTION 4.5: RELATED INDUSTRIES / APPLICATIONS -->
        <?php if ($associated_industries): ?>
            <section class="related-industries product-lisiting mb-5 pt-5 pb-5 bg-light">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 class="massload-title" style="font-size:32px; font-weight:700; text-transform:uppercase;">RELATED
                            <span style="text-underline-offset:8px;">INDUSTRIES</span>
                        </h2>
                    </div>

                    <div class="product-block">
                        <div class="row justify-content-center">
                            <?php foreach ($associated_industries as $industry):
                                $industry_id = $industry->ID;
                                $industry_link = get_permalink($industry_id);
                                $industry_name = get_the_title($industry_id);
                                $industry_img = get_the_post_thumbnail_url($industry_id, 'medium');
                                ?>
                                <div class="col-md-6 col-lg-3">
                                    <div class="productblock childProduct">
                                        <div class="product-content">
                                            <h3><a href="<?php echo esc_url($industry_link); ?>"><?php echo esc_html($industry_name); ?></a></h3>
                                        </div>

                                        <a href="<?php echo esc_url($industry_link); ?>">
                                            <?php if ($industry_img): ?>
                                                <img src="<?php echo esc_url($industry_img); ?>" alt="<?php echo esc_attr($industry_name); ?>">
                                            <?php else: ?>
                                                <img src="<?php echo esc_url(CORE_DEFAULT_THUMBNAIL); ?>" alt="<?php echo esc_attr($industry_name); ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
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