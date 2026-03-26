<?php

/**
 * Template Name: applications
 *
 * This is the most generic template file 
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
</div>

<div id="pagecontent" class="pagecontent">
    <section class="product-section text-center product-lisiting">
        <div class="container">
            <div class="heading-block">
                <?php if (get_field('custom_title')): ?>
                    <h2><?php the_field('custom_title'); ?></h2>
                <?php endif; ?>
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
            <?php
            $output    = '';
            $post_type = 'applications';
            $taxonomy  = 'related_tags';

            $args     = array(
                'posts_per_page'   => -1,
                'post_type'        => $post_type,
                'order'            => 'DESC',
                'orderby'          => 'date',
                'suppress_filters' => false
            );

            $the_query = new WP_Query($args);

            ob_start();
            $output .= '<div class="product-block">';
            $output .= '<div class="row">';
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();
                    $object_id          = $post->ID;
                    $object_title       = get_the_title($object_id);
                    $object_link        = get_the_permalink($object_id);
                    $featured           = wp_get_attachment_image_src(get_post_thumbnail_id($object_id), "full")[0];
                    $meta_desc          = get_field('app_short_desc');
                    // $object_terms       = get_field( 'products_' . $taxonomy );
                    $products_list      = get_field('products_list');
                    $case_study_terms   = get_field('case_study_' . $taxonomy);
                    // $object_terms       = core_get_post_terms( $post->ID, $taxonomy, 'string' );
                    // $assign_products    = get_field('assign_products');
                    // $assign_casestudies = get_field('assign_casestudies');
                    $app_product_link   = get_the_permalink(1293);
                    $case_studies_link  = get_the_permalink(1382);

                    $products_id        = 'application-product-' . $object_id;
                    $casestudies_id     = 'application-casestudy-' . $object_id;

                    if (! empty($products_list) && is_array($products_list)) {
                        $products_list = implode(',', $products_list);
                    }
                    if (! empty($case_study_terms) && is_array($case_study_terms)) {
                        $case_study_terms = implode(',', $case_study_terms);
                        $case_study_terms = '?term=' . $case_study_terms;
                    }


                    $product_parent_args = array(
                        'post_type'       => 'products',
                        'post_parent'     => '',
                        'post__in'        => explode(',', $products_list),
                        'parent_post__in' => true,
                        'return_format'   => 'string',
                        // 'return'        => 'post_title',
                        // 'tax_query'     => array(
                        //     array(
                        //         'taxonomy'         => $taxonomy,
                        //         'field'            => 'id',
                        //         'terms'            => explode( ',', $object_terms ),
                        //         'operator'         => 'IN',
                        //         'include_children' => false,
                        //     )
                        // )
                    );
                    $product_parents     = core_get_post_parent($product_parent_args);


                    // if ( 
                    //     is_array( $object_terms ) &&
                    //     false !== strpos( $object_terms, ',' ) 
                    // ) {
                    //     $object_terms = explode( ',', $object_terms );
                    // }

                    // if ( ! $assign_products ) {
                    //     $assign_products = 'case-studies'; 
                    // }
                    // if ( ! $assign_casestudies ) {
                    //     $assign_casestudies = 'case-studies'; 
                    // }

                    $output .= '<div class="col-sm-6 col-md-6 col-lg-4">';
                    $output .= '<div class="productblock childProduct">';

                    $output .= '<img src="' . esc_url($featured) . '" alt="">';

                    $output .= '<div class="product-content">';

                    $output .= '<h3>';
                    $output .= '<a href="' . esc_url($object_link) . '">';
                    $output .= $object_title;
                    $output .= '</a>';
                    $output .= '</h3>';

                    if ($meta_desc) {
                        $output .= '<p>';
                        $output .= esc_html($meta_desc);
                        $output .= '</p>';
                    } else {
                        $output .= '<p>';
                        $output .= wp_trim_words(get_the_content(), 21, '...');
                        $output .= '</p>';
                    }
                    $output .= '</div>';

                    $output .= '<div class="productActions">';
                    $output .= '<a class="theme-btn" href="' . esc_url($object_link) . '">';
                    $output .= esc_html__('View Application', 'massload');
                    $output .= '</a>';

                    if (! empty($product_parents)) {
                        $output .= '<a class="theme-btn" id="' . esc_attr($products_id) . '" href="' . esc_url($app_product_link . '?parent_ids=' . $product_parents) . '">';
                        $output .= esc_html__('Products', 'massload');
                        $output .= '</a>';
                    } else {
                        $output .= '<a class="theme-btn disabled" id="' . esc_attr($products_id) . '" href="#">';
                        $output .= esc_html__('Products', 'massload');
                        $output .= '</a>';
                    }

                    if (! empty($case_study_terms)) {
                        $output .= '<a class="theme-btn" id="' . esc_attr($casestudies_id) . '" href="' . esc_url($case_studies_link) . $case_study_terms . '">';
                        $output .= esc_html__('Case studies', 'massload');
                        $output .= '</a>';
                    } else {
                        $output .= '<a class="theme-btn disabled" id="' . esc_attr($casestudies_id) . '" href="#">';
                        $output .= esc_html__('Case studies', 'massload');
                        $output .= '</a>';
                    }

                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';

                endwhile;
            endif;

            // Reset Post Data
            wp_reset_postdata();

            $output .= '</div>';
            $output .= '</div>';

            $output .= ob_get_clean();

            echo $output;
            ?>

            <div class="row">
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


    <!-- <section id="req-quote" class="quaote_blk">
        <div class="container">
            <div class="heading-block text-center">
                <h2><span>Request A</span> Solution</h2>
                <p>Submitting this form will <em>not</em> add you to any email distribution lists.</p>
                <p><br></p>
            </div>
            <div class="theme_form">
                <?php //echo do_shortcode('[contact-form-7 id="218" title="Request a Solution"]');
                ?>
            </div>
        </div>
    </section> -->

    <section id="req-quote" class="quaote_blk">
        <div class="container">
            <div class="heading-block text-center">
                <?php
                if (mmi_opts_get('csform-title')) {
                    echo '<h2>';
                    mmi_opts_show('csform-title');
                    echo '</h2>';
                } else {
                    echo sprintf(
                        esc_html__('%1$s' . '%2$s' . 'Request A' . '%3$s' . ' Case Study' . '%4$s', 'massload'),
                        '<h2>',
                        '<span>',
                        '</span>',
                        '</h2>'
                    );
                }
                /* if ( mmi_opts_get( 'csform-subtitle' ) ) {
                        echo '<p>';
                            mmi_opts_show('csform-subtitle');
                        echo '</p>';
                    } else {
                        echo sprintf( 
                            esc_html__( '%1$s' . 'Requesting a case study will ' . '%2$s' . 'not' . '%3$s' . ' add you to any email distribution lists.' . '%4$s', 'massload' ),
                            '<p>',
                            '<em>',
                            '</em>',
                            '</p>'
                        );
                    } */
                ?>

                <p><br></p>
            </div>
            <div class="theme_form">

                <!-- SharpSpring Form for Request a Quote-Solution  -->
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


                <?php //echo do_shortcode('[contact-form-7 id="1346" title="Request a Casestudy"]');
                ?>
            </div>
        </div>
    </section>

</div>



<?php get_footer(); ?>