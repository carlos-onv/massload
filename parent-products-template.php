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
                    $output            = '';
                    $post_type         = 'products';
                    $taxonomy          = 'related_tags';
                    $related_tags      = core_get_terms($taxonomy, 'term_id');
                    $product_thumbnail = '';

                    $parent_args       = array(
                        'post_parent'    => 0,
                        'posts_per_page' => -1,
                        'post_type'      => $post_type,
                        'post_status'    => 'publish',
                        'order'          => 'ASC',
                        'orderby'        => 'menu_order',
                        'suppress_filters' => false,
                        // 'tax_query'      => array(
                        //     array(
                        //         'taxonomy' => $taxonomy,
                        //         'field'    => 'term_id',
                        //         'terms'    => $related_tags,
                        //     )
                        // ),
                    );

                    $parents           = get_posts($parent_args);
                    $parent_id         = '';
                    $parent_title      = '';
                    $parent_link       = '';
                    $parent_desc       = '';

                    $children_args     = array();
                    $children          = array();
                    $child_id          = '';
                    $child_title       = '';
                    $child_link        = '';

                    ob_start();
                    foreach ($parents as $parent) {

                        $parent_id         = $parent->ID;
                        $parent_title      = $parent->post_title;
                        $parent_link       = get_the_permalink($parent_id);
                        $parent_desc       = get_field('short_content', $parent_id);
                        if(is_array(wp_get_attachment_image_src(get_post_thumbnail_id($parent_id), "full")))
                        {
                        $product_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($parent_id), "full")[0];
                        }
                        $product_thumbnail_alt = get_post_meta(get_post_thumbnail_id($parent_id), '_wp_attachment_image_alt', TRUE);
                        $parent_class      = 'product-parent product-' . $parent_id . ' ';

                        if (empty($product_thumbnail)) {
                            $product_thumbnail = CORE_DEFAULT_THUMBNAIL;
                            $parent_class      = 'default-thumbnail';
                        }

                        $output .= '<div class="col-md-6 col-lg-4 ' . esc_attr($parent_class) . '">';
                        $output .= '<div class="productblock childProduct">';
                        $output .= '<a class="" href="' . esc_url($parent_link) . '">';
                        $output .= '<img src="' . esc_url($product_thumbnail) . '" alt="' . $product_thumbnail_alt . ' ">';
                        $output .= '</a>';
                        $output .= '<div class="product-content">';
                        $output .= '<h3>';
                        $output .= '<a class="" href="' . esc_url($parent_link) . '">';
                        $output .= esc_html($parent_title);
                        $output .= '</a>';
                        $output .= '</h3>';
                        $output .= '<p class="short-desc">';
                        $output .= esc_html($parent_desc);
                        $output .= '</p>';
                        $output .= '</div>';
                        $output .= '<div class="productActions">';
                        $output .= '<ul class="product-child-list">';

                        $output .= '<li class="product-parent-link">';
                        $output .= '<a class="theme-btn" href="' . esc_url($parent_link) . '">';
                        $output .= __('PRODUCTS', 'massload');
                        $output .= '<i class="fa fa-angle-down"></i>';
                        $output .= '</a>';

                        $children_args     = array(
                            'post_type'        => $post_type,
                            'post_parent'      => $parent_id,
                            'posts_per_page'   => -1,
                            'orderby'          => 'menu_order',
                            'order'            => 'ASC',
                            'suppress_filters' => false,
                            // 'tax_query'        => array(
                            //     array(
                            //         'taxonomy' => $taxonomy,
                            //         'field'    => 'term_id',
                            //         'terms'    => $related_tags,
                            //     )
                            // ),
                        );

                        $children = get_posts($children_args);

                        $output .= '<ul class="product-children-list">';
                        foreach ($children as $child) {
                            $child_id         = $child->ID;
                            $child_title      = $child->post_title;
                            $child_link       = get_the_permalink($child_id);

                            if ($child->post_type != 'attachment') {
                                $output .= '<li class="product-child-link">';
                                $output .= '<a href="' . esc_url($child_link) . '">';
                                $output .= esc_html($child_title);
                                $output .= '</a>';
                                $output .= '</li>';
                            }
                        }
                        $output .=  '</ul>';
                        $output .= '</li>';

                        $output .= '</ul>';
                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                    $output .= ob_get_clean();

                    echo $output;

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