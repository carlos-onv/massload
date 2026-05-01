<?php
/**
 * Template Name: Front Page
 *
 * This is the most generic template file 
 *
 *  @package Massload
 *  @subpackage Massload
 * @since Massload 1.0
 */
get_header(); ?>
   <div id="pagecontent" class="pagecontent">

        <section class="product-section text-center">

            <div class="container">

                <div class="heading-block">
                    <h1><?php echo get_field('our_products') ?: 'OUR PRODUCTS'; ?></h1>
                    <p><?php echo get_field('our_products_description') ?: 'Select from our wide range of high-quality weighing solutions.'; ?></p>
                </div>

                <div class="product-block">
                    <div class="row">
                        <?php
                        $taxonomy = 'product_cat';
                        $selected_product_ids = get_field('selected_categories');

                        if (!empty($selected_product_ids)) {
                            $category_ids = array();
                            foreach ($selected_product_ids as $p_id) {
                                $terms = get_the_terms($p_id, $taxonomy);
                                if ($terms && !is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                        // Only include top-level categories if desired, or all selected
                                        $category_ids[] = $term->term_id;
                                    }
                                }
                            }
                            $category_ids = array_unique($category_ids);
                            
                            $top_categories = array();
                            foreach ($category_ids as $cat_id) {
                                $term = get_term($cat_id, $taxonomy);
                                if ($term && !is_wp_error($term)) {
                                    $top_categories[] = $term;
                                }
                            }
                        } else {
                            $cat_args = array(
                                'taxonomy'   => $taxonomy,
                                'parent'     => 0,
                                'hide_empty' => true,
                                'orderby'    => 'name',
                                'order'      => 'ASC',
                                'exclude'    => array(get_option('default_product_cat')),
                            );
                            $top_categories = get_terms($cat_args);
                        }

                        if (!is_wp_error($top_categories) && !empty($top_categories)):
                            foreach ($top_categories as $cat):
                                $cat_id = $cat->term_id;
                                $acf_id = 'product_cat_' . $cat_id;
                                $cat_link = get_term_link($cat);
                                $cat_desc = get_field('short_content', $acf_id) ?: $cat->description;
                                
                                // Get WooCommerce Category Image
                                $thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
                                $cat_img = wp_get_attachment_image_url($thumbnail_id, 'full');
                                if (!$cat_img) {
                                    $cat_img = CORE_DEFAULT_THUMBNAIL;
                                }

                                // Category name logic (without red span)
                                $display_name = $cat->name;
                                ?>
                                <div class="col-md-6 col-lg-4 product-parent">
                                    <div class="productblock childProduct">
                                        <div class="product-content">
                                            <h3>
                                                <a href="<?php echo esc_url($cat_link); ?>">
                                                    <?php echo esc_html($display_name); ?>
                                                </a>
                                            </h3>
                                        </div>

                                        <a href="<?php echo esc_url($cat_link); ?>">
                                            <img src="<?php echo esc_url($cat_img); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </section>

        <section class="video_blk dark_blk pt-200 pb-200" style="background-image: url(<?php the_field('video_background'); ?>);">

            <div class="container text-center">

                <h2><?php the_field('video_title'); ?></h2>

                <?php the_field('video_description'); ?>

                <a href="#" data-toggle="modal" data-target="#videoModal" class="playicon"><img alt="play video" src="<?php the_field('play_icon'); ?> " height="98" width="98"></a>

                <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

                        <div class="modal-content">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">&times;</span>

                            </button>

                            <div class="modal-body">

                            <iframe width="100%" height="430" src="<?php the_field('video_url'); ?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <section class="productapp-section pt100 pb100">

            <div class=container>

                <div class="row">

                    <div class="col-md-12 text-center">

                        <div class="heading-block">

                            <?php
                                echo sprintf( 
                                    esc_html__( '%1$s' . '%2$s' . 'Industrial' . '%3$s' . ' Applications' . '%4$s', 'massload' ),
                                    '<h2>',
                                    '<span>',
                                    '</span>',
                                    '</h2>'
                                );
                            ?>
                        </div>

                    </div>

                </div>



                    <?php 

                    $args = array( 

                        'post_type' => 'applications',

                        'orderby' => 'date',

                        'order'   => 'DESC',

                        'posts_per_page' => -1, 

                        'suppress_filters' => false

                    );

                    $the_query = new WP_Query( $args );

                    global $wp_query;

                    ?>

                    <?php $application_i = 1;  ?>

                    <div class="row">

                    <?php                   

                    if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); 

                        /* grab the url for the full size featured image */

                        $featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );
                        $product_thumbnail_alt =  get_post_thumbnail_id($post->ID);
                        $img_alt = get_post_meta($product_thumbnail_alt , '_wp_attachment_image_alt', true);
						
                        //echo $thumbnail[0]."param";


                        if( $application_i == 9 ) { ?>

                        </div>

                            <div class="row hide_content">

                        <?php } ?>

                        <div class="col-lg-3 col-md-3 col-sm-6">

                            <div class="papp-item">

                                <a href="<?php the_permalink(); ?>" title=""><img src="<?php echo $featured[0]; ?>" alt="<?php if($img_alt){echo $img_alt; }else{ the_title(); } ?>"></a>

                                <h3><?php the_title(); ?></h3>

                            </div>

                        </div>                      

                        <?php $application_i++; endwhile; ?>

                        <?php if( $application_i > 9 ) { ?>                        

                            </div>

                            <a href="#" class="show_hide" data-content="toggle-text"><?php esc_html_e( 'View More', 'massload'); ?></a>

                        <?php } ?>

                <?php
                    wp_reset_postdata();

                    else:
                        echo '<p>';
                        esc_html_e( 'Sorry, there are no application to display', 'massload');    
                        echo '</p>';
                    endif;
                    
                ?>

                  

                

            </div>

        </section>

        <!-- <section class="jot-section pt100" style="background-image: url(<?php //the_field('join_our_team_background'); ?>);" >

            <div class="container">                

                <div class="row">                 

                    <div class="col-lg-5 col-md-5 col-sm-12">

                        <img src="<?php //the_field('team_image'); ?>">    

                    </div>

                    <div class="col-lg-7 col-md-7 col-sm-12 jot-text">

                        <div class="jot-inner headingsecondary-block">

                            <h2><?php //the_field('join_our_team_title'); ?></h2>

                            <p><?php //the_field('join_description'); ?></p>

                            <a class="theme-btn" href="<?php //the_field('viewmore_link'); ?>"><?php //the_field('viewmore_button'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

        </section> -->

        <section class="casestudies-section pb100">

            <div class=container>

                <div class="row">

                    <div class="col-md-12 text-center">

                        <div class="heading-block">

                            <h2><?php the_field('case_study_title'); ?></h2>                            

                            <p><?php the_field('case_study_description'); ?></p>

                            <?php $link = get_field('casestudy_button');

                            if( $link ): 

                                $link_url = $link['url'];

                                $link_title = $link['title'];

                                $link_target = $link['target'] ? $link['target'] : '_self';

                                ?>

                            <a class="case_study_btn com-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>

                            <?php endif; ?>

                        </div>

                    </div>

                    <?php 

                    $args = array( 

                        'post_type' => 'case_study',

                        'orderby' => 'date',

                        'order'   => 'ASC',

                        'posts_per_page' => 3, 

                        'suppress_filters' => false
                    );

                    $the_query = new WP_Query( $args );

                    global $wp_query;

                    ?>

                    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); 

                    /* grab the url for the full size featured image */

                    $featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );
                    $product_thumbnail_alt =  get_post_thumbnail_id($post->ID);
                    $img_alt = get_post_meta($product_thumbnail_alt , '_wp_attachment_image_alt', true);
                    //echo $thumbnail[0]."param";

                    ?>

                    <div class="col-md-4">

                        <div class="cs-item">

                            <img src="<?php echo $featured[0]; ?>" alt="<?php if($img_alt){echo $img_alt; }else{ the_title(); } ?>">

                            <h3><?php the_title(); ?></h3>

                            <?php the_excerpt(); ?>

                            <a class="theme-btn" href="<?php the_permalink(); ?>" title=""><?php esc_html_e( 'Read More', 'massload'); ?></a>

                        </div>

                    </div>

                <?php 
                        endwhile;

                        wp_reset_postdata();

                    else:
                        echo '<p>';
                            esc_html_e( 'Sorry, there are no application to display', 'massload');    
                        echo '</p>';
                    endif;
                ?>
                
                </div>

            </div>

        </section>

        <section class="wwr-section">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-12 wwa-bg" style="background-image: url(<?php the_field('who_we_are_background'); ?>);">

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 wwr-right headingsecondary-block">

                        <div class="wwr-right-inner">

                            <h2><?php the_field('who_we_are_title'); ?></h2>

                            <?php the_field('who_we_are_description'); ?>

                            <a class="theme-btn" href="<?php the_field('learnmore_link'); ?>"><?php the_field('learmore_button'); ?></a>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <section class="contact-section">

        <div class="container">

          <div class="row">

            <div class="contact-bg" style="background-image: url(<?php the_field('contact_background'); ?>);"></div>

            <div class="col-md-6">

              <div class="contact-wrap">

                <div class="headingsecondary-block">

                  <h2><?php the_field('contact_title'); ?></h2>                  

                </div>

                <?php the_field('contact_content'); ?>

              </div>

            </div>

            <div class="form-bg" style="background-image: url(<?php the_field('quote_background'); ?>);"></div>

            <div class="col-md-6">

              <div id="req-quote" class="contact-form">

                <div class="headingsecondary-block dark_blk">

                  <h2><?php the_field('get_quote_title'); ?></h2>

                    <?php if(get_field('get_quote_stitle')) { ?>

                        <p><?php //the_field('get_quote_stitle'); ?></p>

                    <?php } ?>

                </div>

                <?php //echo do_shortcode('[contact-form-7 id="190" title="Get Quote"]'); ?>
                <!-- SharpSpring Form for Home Page  --> 
                    <script type="text/javascript">
                        var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'SzJIsUw2NEvVtTQzSNE1SUo00bVMSjXWNUi0NDYxSTW2tEw1BwA'};
                        ss_form.width = '100%';
                        ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
                        ss_form.hidden = {'_usePlaceholders': true};
                        // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
                        // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
                        // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
                    </script>
                    <script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>


              </div>

            </div>

          </div>

        </div>  

      </section>

    </div>

	

<?php get_footer(); ?>

