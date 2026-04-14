<?php

/**
 * Template Name: Parent Products
 *
 * Used to for Product Directory Page 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header(); ?>



<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image'); ?>);">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php core_breadcrumbs(); ?>
        </div>
    </div>
    <!-- <div class="callblock">
        <a href="tel:<?php //mmi_opts_show('call-number'); 
                        ?>"><img src="<?php //mmi_opts_show('call_logo'); 
                                        ?>" alt="call"/><?php //mmi_opts_show('call-us'); 
                                                        ?></a>
    </div> -->
</div>

<div id="pagecontent" class="pagecontent">
    <section class="product-section parent-product-lisiting text-center product-lisiting">
        <div class="container">
            <div class="heading-block">
                <?php if (get_field('custom_title')): ?>
                    <h2><?php the_field('custom_title'); ?></h2>
                <?php endif; ?>

                <?php
                $filter_args = array(
                    'placeholder'     => __('PRODUCT SEARCH', 'massload'),
                    'post_type'       => 'products',
                    'taxonomy'        => 'related_tags',
                    'search_type'     => 'product_search',
                    'set_taxonomy'    => false,
                    'set_terms'       => false,
                    'set_search_type' => true,
                    'wp_search'       => true,
                    'set_title'       => false,
                    'ajax'            => false,
                    'use_fields'      => array('search'),
                );
                echo '<div class="core-product-archive-search pb-50">';
                core_adv_search_widget($filter_args);
                echo '</div>';
                ?>

                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
            <div class="product-block">
                <div class="row">
                    <?php
                    $taxonomy = 'product_cat';
                    $default_cat_id = get_option('default_product_cat'); // Usually 'Uncategorized'

                    $cat_args = array(
                        'taxonomy'   => $taxonomy,
                        'parent'     => 0,
                        'hide_empty' => true, // User request: Hide empty
                        'orderby'    => 'name', // User request: Alphabetical
                        'order'      => 'ASC',
                        'exclude'    => array($default_cat_id), // User request: Hide default uncategorized
                    );

                    $top_categories = get_terms($cat_args);

                    if (!is_wp_error($top_categories) && !empty($top_categories)):
                        foreach ($top_categories as $cat):
                            $cat_id = $cat->term_id;
                            $acf_id = 'product_cat_' . $cat_id;

                            $custom_title = get_field('custom_title', $acf_id);
                            $cat_title = $custom_title ? $custom_title : $cat->name;
                            $cat_link = get_term_link($cat);
                            $cat_desc = $cat->description;

                            // Get WooCommerce Category Image
                            $thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
                            $cat_img = wp_get_attachment_image_url($thumbnail_id, 'full');
                            if (!$cat_img) {
                                $cat_img = CORE_DEFAULT_THUMBNAIL;
                            }

                            // Sub-categories (instead of child posts)
                            $sub_cats = get_terms(array(
                                'taxonomy'   => $taxonomy,
                                'parent'     => $cat_id,
                                'hide_empty' => true,
                                'orderby'    => 'name',
                                'order'      => 'ASC',
                            ));
                            ?>
                            <div class="col-md-6 col-lg-4 product-parent product-cat-<?php echo esc_attr($cat_id); ?>">
                                <div class="productblock childProduct">
                                    <a href="<?php echo esc_url($cat_link); ?>">
                                        <img src="<?php echo esc_url($cat_img); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                                    </a>
                                    <div class="product-content">
                                        <h3>
                                            <a href="<?php echo esc_url($cat_link); ?>">
                                                <?php echo wp_kses_post($cat_title); ?>
                                            </a>
                                        </h3>
                                        <?php if ($cat_desc): ?>
                                            <p class="short-desc">
                                                <?php echo wp_trim_words($cat_desc, 20); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="productActions">
                                        <ul class="product-child-list">
                                            <li class="product-parent-link">
                                                <a class="theme-btn" href="<?php echo esc_url($cat_link); ?>">
                                                    <?php esc_html_e('EXPLORE MODELS', 'massload'); ?>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>

                                                <?php if (!is_wp_error($sub_cats) && !empty($sub_cats)): ?>
                                                    <ul class="product-children-list">
                                                        <?php foreach ($sub_cats as $sub): ?>
                                                            <li class="product-child-link">
                                                                <a href="<?php echo esc_url(get_term_link($sub)); ?>">
                                                                    <?php echo esc_html($sub->name); ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12">
                            <p><?php esc_html_e('No product categories found.', 'massload'); ?></p>
                        </div>
                    <?php endif; ?>

                    ?>

                </div>
            </div>
        </div>
    </section>



    <section class="casestudies-section pb100 our_partners">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="heading-block">
                        <?php $partner_title = get_field('partner_title');
                        $sub_title = get_field('sub_title'); ?>
                        <h2><?php if ($partner_title) {
                                echo $partner_title;
                            } ?></h2>
                        <?php if ($sub_title) { ?>
                            <p> <?php echo $sub_title; ?></p>
                        <?php } ?>
                    </div>
                    <?php echo do_shortcode('[logocarousel id="2816"]'); ?>
                </div>

                <div class="col-md-12 text-center">
                    <!-- Testimonials -->
                    <?php
                    $enable_testimonial = get_field('enable_testimonial');
                    $testimonial_shortcode = get_field('testimonial_shortcode');
                    $testimonial_area_title = get_field('testimonial_area_title');

                    if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)) {

                        echo '<div class="heading-block margin_top_40"><h2>' . esc_html($testimonial_area_title) . '</h2></div>';
                        echo '<div class="testimonial-block">';
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
                <h2>
                    <?php
                    echo '<span>' . __('Request A', 'massload') . '</span> ' . __('Solution', 'massload');
                    ?>
                </h2>
                <?php
                /* echo sprintf( 
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
                </script>
                <script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>

                <?php //echo do_shortcode('[contact-form-7 id="218" title="Request a Solution"]');
                ?>
            </div>
        </div>
    </section>

</div>



<?php get_footer(); ?>