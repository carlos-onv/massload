<?php

/**
 * The template for displaying single page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header();

$get_the_ID = get_the_ID();

?>

<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image'); ?>);">
        <div class="container">

            <?php
            $root = get_page_by_path('applications');
            $root_id = '';
            $root_link = '';
            $root_title = '';

            if (!empty($root)) {
                $root_id = core_icl_object_id($root->ID);
                $root_link = get_the_permalink($root_id);
                $root_title = get_the_title($root_id);

                $breadcrumb = array(
                    'archive' => array(
                        'title' => $root_title,
                        'link' => $root_link
                    ),
                );

                echo '<h3>';
                echo '<a href="' . esc_url($root_link) . '" class="quote_btn">';
                echo esc_html($root_title);
                echo '</a>';
                echo '</h3>';
            }

            echo '<h1>';
            the_title();
            echo '</h1>';

            if (!empty($root)) {
                core_breadcrumbs($breadcrumb);
            }
            ?>

        </div>
    </div>
</div>

<main id="pagecontent" role="content">
    <section class="innerpages pb-0">

        <div class="container pb100">
            <div class="heading-block pt-100 text-center">
                <?php if (get_field('custom_title')) {
                    ?>
                    <h2><?php the_field('custom_title'); ?></h2> <?php
                } else {
                    ?>
                    <h2><span><?php the_title(); ?></span> <?php echo esc_html($root_title); ?></h2>
                    <?php
                } ?>
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <?php if (get_field('app_short_desc')) { ?>
                            <p><?php echo get_field('app_short_desc'); ?></p>
                        <?php } ?>
                    </div>
                </div>

                <?php
                $application_products_link = get_the_permalink('1293');
                $products_list = get_field('products_list', $get_the_ID);
                $product_parent_args = array();
                $product_parents = '';

                if (!empty($products_list) && is_array($products_list)) {
                    $products_list = implode(',', $products_list);
                }

                $product_parent_args = array(
                    'post_type' => 'products',
                    'post_parent' => '',
                    'post__in' => explode(',', $products_list),
                    'parent_post__in' => true,
                    'return_format' => 'string',
                    // 'return'          => 'post_title',
                );
                $product_parents = core_get_post_parent($product_parent_args);

                if (!empty($product_parents)) {
                    $application_products_link = $application_products_link . '?parent_ids=' . $product_parents;
                }

                echo '<a class="case_study_btn com-btn" href="' . get_permalink() . '#related-products" target="_self">';
                echo __('View Related Products', 'massload');
                echo '</a>';
                ?>
            </div>

            <?php if (get_field('text_above_case_studies')) { ?>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="text"><?php echo get_field('text_above_case_studies'); ?></div>
                    </div>
                </div>
            <?php } ?>
            <!-- </div> -->
            <?php

            // Check rows exists.
            if (have_rows('app_case_studies')):
                $cs_i = 1; ?>
                <div id="accordion" class="aapp">
                    <?php // Loop through rows.
                        while (have_rows('app_case_studies')):
                            the_row(); ?>
                        <div class="card">
                            <div class="card-header" id="heading<?php echo $cs_i; ?>">
                                <h5 class="mb-0">
                                    <?php if ($cs_i == 1) { ?>
                                        <button class="btn btn-link" data-toggle="collapse"
                                            data-target="#collapse<?php echo $cs_i; ?>" aria-expanded="true"
                                            aria-controls="collapse<?php echo $cs_i; ?>">
                                            <?php if (get_sub_field('small_image')) { ?> <img class="acc_small_img1"
                                                    src="<?php echo get_sub_field('small_image'); ?>"><?php } ?>
                                        <?php } else { ?>
                                            <button class="btn btn-link collapsed" data-toggle="collapse"
                                                data-target="#collapse<?php echo $cs_i; ?>" aria-expanded="false"
                                                aria-controls="collapse<?php echo $cs_i; ?>">
                                                <?php if (get_sub_field('small_image')) { ?> <img class="acc_small_img1"
                                                        src="<?php echo get_sub_field('small_image'); ?>"><?php } ?>
                                            <?php } ?>
                                            <?php echo get_sub_field('cs_rtitle'); ?>
                                        </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo $cs_i; ?>" class="collapse <?php if ($cs_i == 1) {
                                   echo "show";
                               } ?>" aria-labelledby="heading<?php echo $cs_i; ?>" data-parent="#accordion">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="cd-inner">
                                                <?php if (get_sub_field('cs_rimage')) {
                                                    $image = get_sub_field('cs_rimage'); ?>
                                                    <div class="con-img app_case_image">
                                                        <img src="<?php echo $image; ?>" alt="<?php echo get_the_title(); ?>">
                                                    </div>
                                                <?php } ?>
                                                <?php the_sub_field('cs_rcontent'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="cd-sidebar app-cd-sidebar">
                                                <?php if (get_field('app_case_study_title', $get_the_ID)) { ?>
                                                    <h3><?php echo get_field('app_case_study_title', $get_the_ID); ?></h3>
                                                <?php } ?>
                                                <?php if (get_sub_field('cs_rlinkcs')) { ?>
                                                    <?php $cs_post = get_sub_field('cs_rlinkcs');
                                                    if ($cs_post) { ?>
                                                        <?php $cs_img = get_the_post_thumbnail_url($cs_post); ?>
                                                        <?php if ($cs_img) { ?>
                                                            <img src="<?php echo $cs_img; ?>">
                                                        <?php } ?>
                                                        <h3><?php echo get_the_title($cs_post); ?></h3>
                                                        <p><?php echo get_the_excerpt($cs_post); ?></p>
                                                        <a href="<?php echo get_the_permalink($cs_post); ?>"><?php if (get_field('app_cs_rmore')) {
                                                               echo get_field('app_cs_rmore');
                                                           } else {
                                                               echo "Read More";
                                                           } ?> &#62;
                                                        </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div class="box-sidebar">
                                                        <?php if (get_field('app_defaultcs_title')) { ?>
                                                            <h4><?php echo get_field('app_defaultcs_title'); ?></h4>
                                                        <?php } ?>
                                                        <?php if (get_field('app_defaultcs_content')) { ?>
                                                            <p><?php echo get_field('app_defaultcs_content'); ?></p>
                                                        <?php } ?>
                                                        <?php
                                                        $link = get_field('app_defaultcs_button');
                                                        if ($link) {
                                                            $link_url = $link['url'];
                                                            $link_title = $link['title'];
                                                            $link_target = $link['target'] ? $link['target'] : '_blank';
                                                            ?>
                                                            <a href="<?php echo esc_url($link_url); ?>"
                                                                target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php // End loop.
                                $cs_i++;
                        endwhile; ?>
                </div>
            <?php endif; ?>

        </div>


        <!-- SECTION: RELATED PRODUCTS -->
        <?php
        $current_app_id = get_the_ID();
        $related_products_query = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'associated_industries',
                    'value' => '"' . $current_app_id . '"',
                    'compare' => 'LIKE',
                )
            )
        ));

        if ($related_products_query->have_posts()): ?>
            <section id="related-products" class="related-products mb-5 pt-5 pb-5 bg-light">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 class="massload-title" style="font-size:32px; font-weight:700; text-transform:uppercase;">
                            RELATED
                            <span style="text-underline-offset:8px;">PRODUCTS</span>
                        </h2>
                    </div>

                    <div class="row">
                        <?php while ($related_products_query->have_posts()):
                            $related_products_query->the_post();
                            $product_url = get_permalink();
                            $product_title = get_the_title();
                            $product_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            ?>
                            <div class="col-md-3 mb-4">
                                <div class="related-product-card">
                                    <div class="related-product-img">
                                        <a href="<?php echo esc_url($product_url); ?>">
                                            <img src="<?php echo esc_url($product_img ?: wc_placeholder_img_src()); ?>"
                                                alt="<?php echo esc_attr($product_title); ?>">
                                        </a>
                                    </div>
                                    <div class="related-product-title">
                                        <?php echo esc_html($product_title); ?>
                                    </div>
                                    <a href="<?php echo esc_url($product_url); ?>" class="related-product-link">
                                        VIEW PRODUCT <span>›</span>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>

                <style>
                    /* Reuse core styles for consistency */
                    .related-product-card {
                        background: #fff;
                        overflow: hidden;
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        width: 100%;
                        border: 1px solid #eee;
                    }

                    .related-product-img {
                        height: 250px;
                        overflow: hidden;
                    }

                    .related-product-img img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        /* Better for product detail visibility */
                        padding: 0px;
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
                        min-height: 50px;
                        display: flex;
                        align-items: center;
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
                </style>
            </section>
        <?php endif; ?>
        <section class="<?php echo $product_section; ?> text-center product-lisiting margin_bottom_40 margin_top_80">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <!-- Testimonials -->
                        <?php
                        $enable_testimonial = get_field('enable_testimonial');
                        $testimonial_shortcode = get_field('testimonial_shortcode');
                        $testimonial_area_title = get_field('testimonial_area_title');

                        if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)) {

                            echo '<div class="heading-block"><h2>' . esc_html($testimonial_area_title) . '</h2></div>';
                            echo '<div class="testimonial-block margin_bottom_76">';
                            echo do_shortcode($testimonial_shortcode);
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="req-quote" class="quaote_blk">
            <div class="container">
                <div class="heading-block text-center">
                    <?php
                    echo sprintf(
                        esc_html__('%1$s' . '%2$s' . 'Request A' . '%3$s' . ' Solution' . '%4$s', 'massload'),
                        '<h2>',
                        '<span>',
                        '</span>',
                        '</h2>'
                    );
                    /*echo sprintf( 
                                esc_html__( '%1$s' . 'Submitting this form will ' . '%2$s' . 'not' . '%3$s' . ' add you to any email distribution lists.' . '%4$s', 'massload' ),
                                '<p>',
                                '<em>',
                                '</em>',
                                '</p>'
                            );*/
                    ?>
                    <p><br></p>
                </div>
                <div class="theme_form"><!-- SharpSpring Form for Request a Quote-Solution  -->
                    <script type="text/javascript">
                        if (!bCheck()) {
                            var ss_form = {
                                'account': 'MzawMLEwMbUwBAA',
                                'formID': 'M042SjZKSknWNU41S9E1MTRP0rU0TzbWNTOxMDQ2SbKwNDRLBQA'
                            };
                            ss_form.width = '100%';
                            ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
                            ss_form.hidden = {
                                '_usePlaceholders': true
                            };
                            // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
                            // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
                            // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
                        }
                    </script>
                    <script type="text/javascript"
                        src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>


                    <?php //echo do_shortcode('[contact-form-7 id="218" title="Request a Solution"]');
                    ?>
                </div>
            </div>
        </section>

    </section>
</main>
<?php get_footer(); ?>