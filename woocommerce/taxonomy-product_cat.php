<?php
/**
 * WooCommerce Category Template: taxonomy-product_cat.php
 */

get_header();

// WooCommerce Category Term
$current_term = get_queried_object();
$slug = $current_term->slug;

// ACF data now lives natively on the WooCommerce category term
$acf_id = 'product_cat_' . $current_term->term_id;

// 1. #pagebanner
$banner_image = get_field('banner_image', $acf_id);
?>

<style>
    .category-banner-row {
        display: flex;
        align-items: center;
        gap: 40px;
        padding: 40px 0;
    }

    .category-banner-row .category-title-col {
        flex: 0 0 40%;
        max-width: 40%;
    }

    .category-banner-row .category-desc-col {
        flex: 1;
    }

    .category-banner-row .mass-category-title {
        margin: 0;
        font-size: 36px;
        font-weight: 700;
        color: #333;
        line-height: 1.2;
    }

    .category-banner-row .category-description p {
        font-size: 16px;
        line-height: 1.7;
        color: #555;
    }

    .category-banner-row .category-description p:last-child {
        margin-bottom: 0;
    }

    .breadcrumb-nav {
        padding: 15px 20px;
        margin: 0;
        font-size: 14px;
        font-weight: 400;
        color: #777;
    }

    .breadcrumb-nav a {
        color: #e30913;
        text-decoration: none;
    }

    .breadcrumb-nav span {
        color: #333;
    }

    .product-lisiting .container {
        background-color: #f2f2f2;
    }

    #faqs-section {
        margin-bottom: 20px;

    }

    #faqs-section .container {
        background-color: #f2f2f2;
        padding-top: 20px;
    }

    .faq summary h3 {
        color: #000;
        font-weight: 400;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .category-banner-row {
            flex-direction: column;
            gap: 20px;
        }

        .category-banner-row .category-title-col {
            flex: 0 0 100%;
            max-width: 100%;
            text-align: center;
        }
    }
</style>

<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-color:#f1f2f1;">
        <?php
        echo '<h3 class="breadcrumb-nav">';
        echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
        echo ' / ';
        echo '<span>' . esc_html(single_term_title('', false)) . '</span>';
        echo '</h3>';
        ?>
        <div class="container">
            <div class="category-banner-row">
                <div class="category-title-col">
                    <?php
                    $custom_title = get_field('custom_title', $acf_id);
                    echo '<h1 class="mass-category-title">' . ($custom_title ? wp_kses_post($custom_title) : esc_html(single_term_title('', false))) . '</h1>';
                    ?>
                </div>
                <?php $cat_description = term_description(); ?>
                <?php if ($cat_description): ?>
                    <div class="category-desc-col">
                        <div class="category-description">
                            <?php echo wp_kses_post($cat_description); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div id="pagecontent" class="pagecontent">

    <!-- 2. Products Grid -->
    <section class="product-section_wf text-center product-lisiting">
        <div class="container">
            <div class="product-block">
                <div class="row">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            global $product;
                            // Grab native WooCommerce thumbnail
                            $thumb_url = get_the_post_thumbnail_url($product->get_id(), 'full');
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="productblock childProduct">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ($thumb_url): ?>
                                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                    </a>
                                    <div class="product-content">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                    </div>
                                    <div class="productActions">
                                        <a class="theme-btn"
                                            href="<?php the_permalink(); ?>"><?php esc_html_e('VIEW PRODUCT', 'massload'); ?></a>

                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    else:
                        echo '<p>No products found.</p>';
                    endif;
                    ?>

                    <style>
                        span.theme-btn {
                            font-size: 13px;
                            background: #4c4c4c;
                            display: inline-block;
                            width: 33.333%;
                            text-align: left;
                            margin: 0;
                            float: left;
                            color: #d2d2d2;
                            border: 1px solid #fff;
                            font-family: "Roboto Condensed", sans-serif;
                            padding: 13px 13px;
                            transition: 0.3s ease;
                        }

                        span.theme-btn:hover {
                            color: #d2d2d2;
                        }

                        /* Product grid: equal-height cards with image filling space */
                        .product-block .row {
                            display: flex;
                            flex-wrap: wrap;
                        }

                        .product-block .row>[class*="col-"] {
                            display: flex;
                            margin-bottom: 30px;
                        }

                        .productblock.childProduct {
                            display: flex;
                            flex-direction: column;
                            width: 100%;
                        }

                        .productblock.childProduct>a {
                            flex: 1;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            overflow: hidden;
                        }

                        .productblock.childProduct>a img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        }

                        .productblock.childProduct .product-content {
                            flex-shrink: 0;
                        }

                        .productblock.childProduct .productActions {
                            flex-shrink: 0;
                        }
                    </style>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions CTA Boxes -->
    <section class="solutions-cta margin_bottom_40 margin_top_40">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="/custom-solutions/" class="solutions-cta-box">
                        <span>Custom Solutions</span>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/oem-solutions/" class="solutions-cta-box">
                        <span>OEM Solutions</span>
                    </a>
                </div>
            </div>
        </div>
        <style>
            .solutions-cta-box {
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #b0b0b0;
                min-height: 180px;
                text-decoration: none;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            .solutions-cta-box:hover {
                background-color: #e30913;
                transform: translateY(-2px);
                text-decoration: none;
            }

            .solutions-cta-box span {
                color: #fff;
                font-size: 28px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            @media (max-width: 768px) {
                .solutions-cta .col-md-6 {
                    margin-bottom: 15px;
                }
            }
        </style>
    </section>

    <!-- 3. Testimonials -->
    <?php
    $enable_testimonial = get_field('enable_testimonial', $acf_id);
    $testimonial_shortcode = get_field('testimonial_shortcode', $acf_id);
    $testimonial_area_title = get_field('testimonial_area_title', $acf_id);

    if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)):
        ?>
        <section class="text-center product-lisiting margin_bottom_80 margin_top_40">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="margin_top_40"><?php echo esc_html($testimonial_area_title); ?></h2>
                        <div class="testimonial-block">
                            <?php echo do_shortcode($testimonial_shortcode); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 4. Text Below Product Listing -->
    <section class="product-lisiting">
        <div class="container">
            <div class="col-xs-12">
                <div style="font-weight: 400; text-align: left;">
                    <?php echo get_field('text_below_product_listing', $acf_id); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FAQ -->
    <?php if (have_rows('faq_content_fields', $acf_id)): ?>
        <style>
            .product-section {
                padding-bottom: 0px;
            }

            #faqs-section {
                padding-bottom: 0px;
            }
        </style>
        <section id="faqs-section" class="additional-info">
            <div class="container">
                <div class="faq">
                    <?php echo get_field('faq_content', $acf_id); ?>
                    <?php while (have_rows('faq_content_fields', $acf_id)):
                        the_row(); ?>
                        <details>
                            <summary>
                                <h3><?php the_sub_field('question'); ?></h3>
                            </summary>
                            <div><?php the_sub_field('answer'); ?></div>
                        </details>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 6. Request a Quote Formulation -->
    <section id="req-quote" class="quaote_blk">
        <div class="container">
            <div class="heading-block text-center">
                <h2><span>Request A</span> Solution</h2>
                <p><br></p>
            </div>
            <div class="theme_form">
                <?php
                if ($slug == 'truck-axle-scales') { ?>
                    <script type="text/javascript">
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'SzRPNjE1S7LQNTAyT9Y1STI21rVMSzLUNTdKNE8zSktNNjE3BwA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type="text/javascript"
                        src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>
                <?php }
                if ($slug == 'traffic-solutions') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'MzMzMTIyTLXUtTSwNNA1SUpO1E0yT7HUTTKyTDI0NTRMNEo2BAA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'load-cells') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 's0w0ME1OTUzVTTI0TtI1MTe21E0yN0jVNUwxtDSyNLGwTLa0AAA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'crane-scales-lifting-wireline') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'S7U0SjY3TrHQNTIzNtU1SUpM1bVMSTTVTbNISrUwNTOwMDIxBAA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'weigh-modules-vessel-weighing') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'MzC3tDBOTTPSNbJMNNA1MTY01020NEzStUw1TzRPNUk0tUhNAgA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'process-controls-amplifiers') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'MzY1Mrc0S0nWNUlLTtE1MTNM1U0ySjPWTU4xN7A0sUiyTDI0AAA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'load-cell-indicators-remote-displays-printers') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'M7I0STY1MLPQTTQ2NdU1MUhO07VINUvSNTMxSkw0MTBNMTdJAwA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'wireless') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'MzExtjBMNDPUTU0zStY1MU9K1U0yMgayUlJNkozTzIwNDQ0B' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php }
                if ($slug == 'interconnection-hardware') { ?>
                    <script type='text/javascript'>
                        var ss_form = { 'account': 'MzawMLEwMbUwBAA', 'formID': 'SzY2TjJPNLPQNbcwTtI1STEy002ysLTUTTEzM0o2MbZMNEhMBQA' };
                        ss_form.width = '100%'; ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services'; ss_form.hidden = { '_usePlaceholders': true };
                    </script>
                    <script type='text/javascript'
                        src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
                <?php } ?>
            </div>
        </div>
    </section>

</div>

<?php get_footer(); ?>