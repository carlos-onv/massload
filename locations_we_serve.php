<?php

/**
 * Template Name: Locations We Serve 2
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
    <section class="product-section text-center product-lisiting section_bottom_cero serving_states_section2">
        <div class="container">
            <div class="heading-block">
                <?php if (get_field('page_title')): ?>
                    <h2><?php the_field('page_title'); ?></h2>
                <?php endif; ?>
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>
    <!-- Text left and image right -->
    <section class="text-left">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-7">
                    <div class="tss">
                        <div class="heading-block secondary-h2 left-border">
                            <?php if (get_field('text_image_section_title')): ?><h2 class="margin_bottom_cero h2_big_title"><?php the_field('text_image_section_title'); ?></h2><?php endif; ?>
                        </div>
                        <?php if (get_field('left_side_content')): the_field('left_side_content');
                        endif; ?>
                    </div>
                </div>
                <div class="col-md-5 align_bottom_image">
                    <div>
                        <div class="heading-block secondary-h2 left-border">
                            <?php if (get_field('right_side_image')): ?><img src="<?php the_field('right_side_image'); ?>"><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servin all the states -->
    <section class="text-left">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-12">
                    <div class="tss1">
                        <div class="heading-block secondary-h2 left-border">
                            <?php if (get_field('we_serve_title')): ?><h2 class="margin_bottom_cero h2_big_title"><?php the_field('we_serve_title'); ?></h2><?php endif; ?>
                        </div>
                        <?php if (get_field('we_serve_subtitle')): the_field('we_serve_subtitle');
                        endif; ?>
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="row">
                <?php if (have_rows('serving_states')) : ?>
                    <?php $cont = 0; ?>
                    <?php while (have_rows('serving_states')) : the_row(); ?>
                        <?php
                        $image_value = get_sub_field('state_image');
                        $text_value = get_sub_field('state_name');
                        $state_link = get_sub_field('state_link');
                        $cont++;
                        ?>
                        <div class="col-md-4 col-xs-12 <?php if ($cont % 3 == 1) {
                                                            echo 'd-flex justify-content-start';
                                                        } elseif ($cont % 3 == 2) {
                                                            echo 'd-flex justify-content-center';
                                                        } else {
                                                            echo 'd-flex justify-content-end';
                                                        } ?>">
                            <a href="<?php echo $state_link; ?>" class="state_link_area" target="_blank">
                                <div class="bg-image" style="background-image: url('<?php echo $image_value; ?>');">
                                    <div class="white_big_text_states"><?php echo $text_value; ?></div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="serving_states_section">
        <div class="container">
            <div class="row">
                <?php if (have_rows('serving_states_list')) : ?>
                    <?php
                    $states = get_field('serving_states_list');
                    $columns = 4;
                    $max_states_per_column = 12;
                    $counter = 0;

                    for ($i = 0; $i < $columns; $i++) {
                        echo '<div class="col-md-3">';
                        echo '<ul class="states_serving_ul" style="list-style-type: disc;">';
                        while ($counter < count($states) && $counter < ($i + 1) * $max_states_per_column) {
                            echo '<li>' . $states[$counter]['state_name'] . '</li>';
                            $counter++;
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Global Presence -->
    <section class="serving_states_section">
        <div class=" container">
            <div class="row">
                <div class="col-md-3">
                    <div class="vertical_align_content">
                        <div class="heading-block secondary-h2 left-border">
                            <?php if (get_field('global_presence_title')): ?><h2 class="margin_bottom_cero h2_big_title2"><?php the_field('global_presence_title'); ?></h2><?php endif; ?>
                        </div>
                        <div>
                            <?php if (get_field('global_presence_subtitle')): the_field('global_presence_subtitle');
                            endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <?php if (have_rows('global_presence_states')) : ?>
                            <?php $cont = 0; ?>
                            <?php while (have_rows('global_presence_states')) : the_row(); ?>
                                <?php
                                $state_name = get_sub_field('state_name');
                                $state_content = get_sub_field('state_content');
                                ?>
                                <div class="col-md-4">

                                    <div class="block1">
                                        <div class="original-text1"><?php echo $state_name; ?></div>
                                        <div class="hover-text1">
                                            <span class="hover_text_title"><?php echo $state_name; ?></span>
                                            <span class="hover_text_content"><?php echo $state_content; ?></span>
                                        </div>
                                    </div>

                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <section class="serving_states_section2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="heading-block">
                        <?php //if (get_field('google_map_iframe')): 
                        ?><?php //the_field('google_map_iframe'); 
                            ?><?php //endif; 
                                ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2445.329957984074!2d-106.64639102333814!3d52.20105107197934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5304f56955bd64a1%3A0xf2c03a1478b9d978!2sMassload%20Technologies%20Inc.!5e0!3m2!1sen!2sca!4v1748622263125!5m2!1sen!2sca" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="heading-block secondary-h2 left-border">
                        <?php if (get_field('google_map_title')): ?><h2 class="h2_big_title"><?php the_field('google_map_title'); ?></h2><?php endif; ?>
                        <?php if (get_field('contact_address')): ?><div class="address_field"><?php the_field('contact_address'); ?></div><?php endif; ?>
                        <?php if (get_field('contact_phone')): ?><div class="phone_field"><span class="black_text">Phone: </span><a href="tel:<?php the_field('contact_phone'); ?>" class="red_color"><?php the_field('contact_phone'); ?></a></div><?php endif; ?>
                        <?php if (get_field('contact_email')): ?><div class="email_field"><span class="black_text">Email: </<span><a href="mailto:<?php the_field('contact_email'); ?>" class="red_color"><?php the_field('contact_email'); ?></a></div><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="req-quote" class="quaote_blk">
        <div class="container">
            <div class="heading-block text-center">
                <h2><span>PUT YOUR PROJECT</span> ON THE MAP</h2>
                <div><span class="sub-title">Looking to bring our products to your country? Let’s connect.<br />
                        Talk to our engineers today to find the best weighing solution for your location.</span></div>
                <p><br></p>
            </div>
            <div class="theme_form">

                <!-- SharpSpring Form for [GENERAL LOCAL PAGES] Contact  -->

                <script type="text/javascript">
                    var ss_form = {
                        'account': 'MzawMLEwMbUwBAA',
                        'formID': 'S7QwMEhOMk_RNUhNNdc1MUg00bU0SDHRNU0yNbY0M7BMMU2yAAA'
                    };

                    ss_form.width = '100%';

                    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';

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