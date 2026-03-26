<?php

/**
 * Template Name: Parent Product
 * Template Post Type: products
 *
 * Used for Parent Product Page
 */

get_header(); ?>



<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image'); ?>);">
        <div class="container">

            <?php
            $root       = get_page_by_path('products');
            $root_id    = '';
            $root_link  = '';
            $root_title = '';

            if (! empty($root)) {
                $root_id    = core_icl_object_id($root->ID);
                $root_link  = get_the_permalink($root_id);
                $root_title = get_the_title($root_id);

                $breadcrumb = array(
                    'archive'     => array(
                        'title'   => $root_title,
                        'link'    => $root_link
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

            if (! empty($root)) {
                core_breadcrumbs($breadcrumb);
            }
            ?>
        </div>
    </div>
    <!-- <div class="callblock">
        <a href="tel:<?php //mmi_opts_show('call-number'); 
                        ?>"><img src="<?php //mmi_opts_show('call_logo'); 
                                        ?>" alt="call"/><?php //mmi_opts_show('call-us'); 
                                                        ?></a>
    </div> -->
</div>

<?php
if (have_rows('faq_content_fields')) {
    $product_section_1 = "product-section_wf";
} else {
    $product_section_1 = "product-section_nf";
}
?>

<div id="pagecontent" class="pagecontent">
    <section class="<?php echo esc_attr($product_section_1); ?> text-center product-lisiting">
        <div class="container">
            <div class="heading-block">
                <?php if (get_field('custom_title')): ?>
                    <h2><?php the_field('custom_title'); ?></h2>
                <?php endif; ?>
                <div class="row">
                    <?php $slug = get_post_field('post_name', get_post());
                    $col_lg = "col-lg-12";
                    $top_form_id = '';
                    $show_top_form = false;
                    if ($slug == 'truck-axle-scales') {
                        $top_form_id = 'SzFNNk02MjbRtTRMMdM1STUw101MTDPVtTBIMk01NrAwMkkzBgA';
                        $show_top_form = true;
                    } elseif ($slug == 'traffic-solutions') {
                        $top_form_id = 'S0syS7FMSTbQTTVNStM1MTA10E0yNDfQTTM1MLZMNjI3M04xAAA';
                        $show_top_form = true;
                    } elseif ($slug == 'load-cells') {
                        $top_form_id = 'M7UwNzc1tLTUNTEyMNE1sUi21LVINrbQTbU0M0pLTLU0TUwxAgA';
                        $show_top_form = true;
                    } elseif ($slug == 'crane-scales-lifting-wireline') {
                        $top_form_id = 'S00zMbUwMTXTNTMyMNQ1MU8z1rU0Mk7TNbU0MUkyMjM3SrJIAQA';
                        $show_top_form = true;
                    } elseif ($slug == 'weigh-modules-vessel-weighing') {
                        $top_form_id = 's7Q0NzE2TLXQNUhJMdQ1sTRM1rVITUnRNU1KSbU0Mkk0MjE1BgA';
                        $show_top_form = true;
                    } elseif ($slug == 'process-controls-amplifiers') {
                        $top_form_id = 'S0k0TTZJMjbVtTRJtdQ1MTJP0U00Nk3TNTdNs0y1TE61NDY1BAA';
                        $show_top_form = true;
                    } elseif ($slug == 'load-cell-indicators-remote-displays-printers') {
                        $top_form_id = 'MzIxNzFLSUrWNTVKMdE1sTRI0rUwTLPUtTQ2NDO1sEgyNEhNAgA';
                        $show_top_form = true;
                    } elseif ($slug == 'wireless') {
                        $top_form_id = 's7BMMTE3sDTQTbYwNdU1SU0x1bVMMTbVNTU2NEsxSTO1NDQ3BwA';
                        $show_top_form = true;
                    } elseif ($slug == 'interconnection-hardware') {
                        $top_form_id = 'SzEyMUxNMzTQTU40M9E1MTE31rVMNDPUTUszN0kzSTFMNbAwBQA';
                        $show_top_form = true;
                    } else {
                        $show_top_form = false;
                    }



                    if ($show_top_form) {
                        $col_lg = "col-lg-7";
                    }
                    ?>
                    <div class="col-sm-12 <?php echo $col_lg; ?>">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                the_content();
                            endwhile;
                        endif;
                        ?>
                    </div>
                    <?php
                    if ($show_top_form) { ?>
                        <div class="col-sm-12 col-lg-5">
                            <div class="quaote_blk truck-axle-scales">
                                <div class="heading-block text-center">
                                    <h2><span>Request A</span> Solution</h2>
                                </div>
                                <?php echo "<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID':  '" . $top_form_id . "' };
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
	ss_form.hidden = {'_usePlaceholders': true};
</script>"; ?>
                                <script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="product-block">
                <div class="row">
                    <?php
                    $args = array(
                        'post_type'        => 'products',
                        'post_parent'      => get_the_ID(),
                        'posts_per_page'   => -1,
                        'order'            => 'ASC',
                        'orderby'          => 'menu_order',
                        'suppress_filters' => false
                    );

                    $parent_id = get_the_ID();
                    $the_query = new WP_Query($args);
                    // The Loop
                    if ($the_query->have_posts()) :
                        while ($the_query->have_posts()) : $the_query->the_post();
                            $thumb_url = get_field('product_thumb');
                            $imgid = attachment_url_to_postid($thumb_url);
                            $thumb_alt = get_post_meta($imgid, '_wp_attachment_image_alt', TRUE);
                            $child_id = get_the_ID();
                    ?>

                            <div class="col-md-6 col-lg-4">
                                <div class="productblock childProduct">
                                    <a href="<?php the_permalink(); ?>"><img src="<?php the_field('product_thumb'); ?>" alt="<?php echo $thumb_alt; ?>"></a>
                                    <div class="product-content">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <p><?php echo get_field('short_content'); ?></p>
                                    </div>
                                    <div class="productActions">
                                        <a class="theme-btn" href="<?php the_permalink(); ?>"><?php esc_html_e('VIEW PRODUCT', 'massload'); ?></a>
                                        <?php
                                        if ($parent_id == 103 && in_array($child_id, array(803, 804, 806, 809, 212))) { ?>
                                            <span class="theme-btn"><?php esc_html_e('Applications', 'massload'); ?></span>
                                        <?php } else if ($parent_id == 98 && in_array($child_id, array(324, 813, 5241, 5432, 814))) { ?>
                                            <span class="theme-btn"><?php esc_html_e('Applications', 'massload'); ?></span>
                                        <?php } else { ?>
                                            <a class="theme-btn" href="<?php echo get_the_permalink() . "#application-casestudies"; ?>"><?php esc_html_e('Applications', 'massload'); ?></a>
                                        <?php } ?>
                                        <?php
                                        if ($parent_id == 103 && in_array($child_id, array(803, 804, 805, 806, 809, 212))) { ?>
                                            <span class="theme-btn"><?php esc_html_e('Case studies', 'massload'); ?></span>
                                        <?php } else if ($parent_id == 98 && in_array($child_id, array(324, 813, 5241, 5432, 814))) { ?>
                                            <span class="theme-btn"><?php esc_html_e('Case studies', 'massload'); ?></span>
                                        <?php } else { ?>
                                            <a class="theme-btn" href="<?php echo get_the_permalink() . "#application-casestudies"; ?>"><?php esc_html_e('Case studies', 'massload'); ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                    <?php endwhile;
                    endif;
                    // Reset Post Data
                    wp_reset_postdata();
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

                        span.theme-btn::before {
                            content: none;
                        }

                        span.theme-btn::after {
                            content: none;
                        }
                    </style>
                </div>
            </div>
            <div class="col-xs-12">
                <div style="font-weight: 400; text-align: left;">
                    <?php
                    echo get_field('text_below_product_listing');
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <?php
    if(!isset($product_section)) { $product_section = ""; }
    ?>
    <section class="<?php echo $product_section; ?> text-center product-lisiting margin_bottom_80 margin_top_40">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php
                    $enable_testimonial = get_field('enable_testimonial');
                    $testimonial_shortcode = get_field('testimonial_shortcode');
                    $testimonial_area_title = get_field('testimonial_area_title');

                    if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)) {

                        echo '<h2 class="margin_top_40">' . esc_html($testimonial_area_title) . '</h2>';
                        echo '<div class="testimonial-block">';
                        echo do_shortcode($testimonial_shortcode);
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    if (have_rows('faq_content_fields')) {
        $product_section = "product-section1";
    } else {
        $product_section = "product-section2";
    }
    ?>

    <?php if (have_rows('faq_content_fields')) { ?>
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
                    <?php the_field('faq_content'); ?>
                    <?php while (have_rows('faq_content_fields')) : the_row(); ?>
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
    <?php } ?>

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
            <div class="theme_form">
                <?php
                $slug = get_post_field('post_name', get_post());
                if ($slug == 'truck-axle-scales') { ?>

                    <!-- SharpSpring Form for Product Request a Quote (Truck Scale)  -->
                    <script type="text/javascript">
                        var ss_form = {
                            'account': 'MzawMLEwMbUwBAA',
                            'formID': 'SzRPNjE1S7LQNTAyT9Y1STI21rVMSzLUNTdKNE8zSktNNjE3BwA'
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



                <?php }

                if ($slug == 'traffic-solutions') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Traffic  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzMzMTIyTLXUtTSwNNA1SUpO1E0yT7HUTTKyTDI0NTRMNEo2BAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                }


                if ($slug == 'load-cells') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Load Cells  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 's0w0ME1OTUzVTTI0TtI1MTe21E0yN0jVNUwxtDSyNLGwTLa0AAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                }

                if ($slug == 'crane-scales-lifting-wireline') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Lifting  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'S7U0SjY3TrHQNTIzNtU1SUpM1bVMSTTVTbNISrUwNTOwMDIxBAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                }

                if ($slug == 'weigh-modules-vessel-weighing') {
                    echo "<!-- SharpSpring Form for Product Request a Quote Weigh Modules  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzC3tDBOTTPSNbJMNNA1MTY01020NEzStUw1TzRPNUk0tUhNAgA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>

";
                }

                if ($slug == 'process-controls-amplifiers') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Amplifiers  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzY1Mrc0S0nWNUlLTtE1MTNM1U0ySjPWTU4xN7A0sUiyTDI0AAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                }

                if ($slug == 'load-cell-indicators-remote-displays-printers') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Indicators  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'M7I0STY1MLPQTTQ2NdU1MUhO07VINUvSNTMxSkw0MTBNMTdJAwA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>

";
                }

                if ($slug == 'wireless') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Wireless  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzExtjBMNDPUTU0zStY1MU9K1U0yMgayUlJNkozTzIwNDQ0B'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>

";
                }

                if ($slug == 'interconnection-hardware') {

                    echo "<!-- SharpSpring Form for Product Request a Quote Interconnect  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'SzY2TjJPNLPQNbcwTtI1STEy002ysLTUTTEzM0o2MbZMNEhMBQA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>

";
                }






                ?>
                <?php //echo do_shortcode('[contact-form-7 id="218" title="Request a Quote"]');
                ?>
            </div>
        </div>
    </section>

</div>



<?php get_footer(); ?>