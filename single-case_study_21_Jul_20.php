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

get_header(); ?>

<div id="pagebanner" class="pagebanner casestudies_banner">
    <div class="inner-banner">
        <div class="container">
            <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            <h1><?php echo __( 'CASE STUDIES', 'massload' ); ?></h1>
            <?php core_breadcrumbs(); ?>
        </div>
    </div>
</div>

 <main id="pagecontent" role="content">
    <section class="innerpages">
        <div class="casestudies_wrap pt100 pb100">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <h2>CASE STUDY: <?php the_title(); ?></h2>
                        <div class="cs_before_banner">
                            <div class="inline-blk cs_date">
                                <?php $post_date = get_the_date( 'F j, Y' );
                                    echo $post_date; ?>
                            </div>
                            <div class="inline-blk share">
                                <a href="#" class="share_open_btn"><i class="fa fa-share-alt"></i></a>
                                <div class="share_open_wrap">
                                    <a href="#"><i class="fa fa-facebook-f"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="cs_body_content">
                            <?php if (has_post_thumbnail( $post->ID ) ): ?>
                              <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                              <div class="cs_post_img">
                                <img src="<?php echo $image[0]; ?>" class="img-fluid">
                              </div>
                            <?php endif; ?>
                            <?php 
                                if ( have_posts() ) :
                                    while ( have_posts() ) : the_post(); 
                                    the_content();
                                    endwhile; 
                                endif; 
                            ?>
                        </div>
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        <ul class="cs_article-footer">
                        <?php  if ( ! empty( $prev_post ) ): ?>
                            <li class="previous">
                                <a class="link" href="<?php echo get_permalink( $prev_post->ID ); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php esc_html_e( 'PREVIOUS', 'massload'); ?></a>
                            </li>
                        <?php endif; ?>
                            
                            <li class="share-option">
                                <a class="outline-btn outline-btn-red" href="#"><?php esc_html_e( 'Share Post', 'massload'); ?></a>
                            </li>

                            <?php  if ( ! empty( $next_post ) ): ?>
                            <li class="next">
                                <a class="link" href="<?php echo get_permalink( $next_post->ID ); ?>"><?php esc_html_e( 'NEXT', 'massload'); ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                            </li>
                        <?php endif; ?>
                            
                        </ul>

                        <?php //if( get_field('other_pro_title') ): ?> 
                     <section id="application-casestudies" class="productapp-section pt100">
                        <div class="container">
                            <div class="row">
                                <div id="applications-section" class="col-md-6 text-center">
                                    <div class="heading-block">
                                        <h2><?php esc_html_e( 'Applications', 'massload'); ?></h2>
                                    </div>
                                    <ul>

                                    <?php $posts = get_field('assign_applications');

                                        if( $posts ): ?>                            
                                            <?php foreach( $posts as $post): 
                                            $featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );
                                    //echo $thumbnail[0]."param";
                                    // variable must be called $post (IMPORTANT) ?>
                                                <?php setup_postdata($post); ?>
                                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                            <?php endforeach; ?>
                                            <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                    <?php endif; ?>
                                    </ul>
                                </div>
                                
                                <div id="casestudies-section" class="col-md-6 text-center">
                                    <div class="heading-block">
                                        <h2><?php esc_html_e( 'Products', 'massload'); ?></h2>
                                    </div>
                                    <ul>

                                        <?php $posts = get_field('assign_products');

                                            if( $posts ): ?>                            
                                                <?php foreach( $posts as $post): 
                                                $featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );
                                        //echo $thumbnail[0]."param";
                                        // variable must be called $post (IMPORTANT) ?>
                                        <?php setup_postdata($post); ?>

                                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                               
                                        <?php endforeach; ?>
                                                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                     </section>


                    </div>

                                

                    <div class="col-sm-3 offset-lg-1">
                        <div class="cs_sidebar">
                            <div class="widget search">
                                <input type="text" readonly="readonly" placeholder="Search" class="header-search product-search-input" data-toggle="modal" data-target="#searchModal">
                            </div>
                            <div class="widget">
                                <h3 class="widget-title"><?php esc_html_e( 'Casestudies', 'massload'); ?></h3>
                                <ul class="sidebar-category-list">
                                    <?php
                                        $args = array(
                                            'post_type'        => 'case_study',
                                            'posts_per_page'   => -1,
                                            'order'            => 'DESC',
                                            'orderby'          => 'date',
                                            'suppress_filters' => false
                                        );

                                        $the_query = new WP_Query( $args );
                                        // The Loop
                                        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                        
                                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                            <?php endwhile;
                                        endif;
                                        // Reset Post Data
                                        wp_reset_postdata();
                                    ?>
                                </ul>
                            </div>
                            <!-- <div class="widget">
                                <h3 class="widget-title">Tags</h3>
                                <ul class="sidebar-category-tags">
                                    <?php
                                    //echo $post->ID; die;
                                    /*$posttags = get_the_tags($post->ID);
                                    if ($posttags) {
                                      foreach($posttags as $tag) {  ?>                     
                                        <li><a href="#"><?php echo $tag->name;  ?> </a></li>
                                    <?php }*/
                                    ?>                                    
                                   
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</main>
<?php get_footer(); ?>