<?php
/**
 * Template Name: OLD Parent Products
 *
 * This is the most generic template file 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header(); ?>



<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image');?>);">
        <div class="container">			
            <h1><?php the_title();?></h1>
            <?php core_breadcrumbs(); ?>     
        </div>
    </div>
    <!-- <div class="callblock">
        <a href="tel:<?php //mmi_opts_show('call-number'); ?>"><img src="<?php //mmi_opts_show('call_logo'); ?>" alt="call"/><?php //mmi_opts_show('call-us'); ?></a>
    </div> -->
</div>

<div id="pagecontent" class="pagecontent">
       <section class="product-section parent-product-lisiting text-center product-lisiting">
            <div class="container">
                <div class="heading-block">
                    <?php if( get_field('custom_title') ): ?>
                        <h2><?php the_field('custom_title');?></h2>
                    <?php endif; ?>
                    <div class="search-box">
						<form method="get" action="">
							<input type="text" class="form-control-plaintext" placeholder="Product Search" name="s">
                            <input type="hidden" name="post_type" value="products">
							<button type="submit" class="fa fa-search green-button"></button>
						</form>
					</div>
                    <?php 
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post(); 
                            the_content();
                            endwhile; 
                        endif; 
                    ?>
                </div>
                <div class="product-block">
                    <div class="row">
                        <?php
                            $args = array(
                                'post_parent'      => 0,
                                'posts_per_page'   => -1,
                                'post_type'        => 'products',
                                'order'            => 'ASC',
                                'orderby'          => 'menu_order',
                                'suppress_filters' => false
                            );

                                $the_query = new WP_Query( $args );
                                // The Loop
                                if ( $the_query->have_posts() ) :
                                while ( $the_query->have_posts() ) : $the_query->the_post(); 
                                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );?>

                                    <div class="col-md-6 col-lg-4">
                                        <div class="productblock childProduct">
                                            <a class="" href="<?php the_permalink(); ?>">                                               
                                                <img src="<?php echo $thumbnail[0]; ?>" alt="">                                               
                                            </a>
                                            <div class="product-content">
                                                <h3><a class="" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                <p><?php echo get_field('short_content'); ?></p>
                                            </div>
											<div class="productActions">												
												<ul>
													<li><a class="theme-btn" href="<?php the_permalink(); ?>">PRODUCTS <i class="fa fa-angle-down"></i></a>

													<?php //$parents = get_children(get_the_ID());	

                                                    $parents = get_posts(
                                                        array(
                                                            'post_type'      => 'products',
                                                            'post_parent'    => get_the_ID(),
                                                            'posts_per_page' => -1,
                                                            'orderby'        => 'menu_order',
                                                            'order'          => 'ASC',
                                                        )
                                                    );


													echo "<ul>";
													foreach ($parents as $parent) {
														if( $parent->post_type != 'attachment')
													 		echo "<li><a href='".get_the_permalink($parent->ID)."'>". $parent->post_title ."</a></li>";
													} 
													echo "</ul>"; ?>
													</li>	
													<!-- <li><a class="theme-btn" id="<?php $case = get_field('assign_applications');
                                                if(!$case){ echo 'case-studies'; } ?>" href="<?php echo get_the_permalink()."#casestudies-section"; ?>">Applications</a></li>
													<li><a class="theme-btn" id="<?php $case = get_field('assign_casestudies');
                                                if(!$case){ echo 'case-studies'; } ?>" href="<?php echo get_the_permalink()."#casestudies-section"; ?>">Case studies</a></li> -->
												</ul>
											</div>
                                        </div>
                                    </div>
                                <?php endwhile;
                                endif;
                                // Reset Post Data
                                wp_reset_postdata();
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
							echo '<span>' . __( 'Request A', 'massload' ) . '</span> ' . __( 'Solution', 'massload' );
						?>
					</h2>
                    <?php
                        echo sprintf( 
                            esc_html__( '%1$s' . 'Submitting this form will ' . '%2$s' . 'not' . '%3$s' . ' add you to any email distribution lists.' . '%4$s', 'massload' ),
                            '<p>',
                            '<em>',
                            '</em>',
                            '</p>'
                        );
                    ?>
                    <p><br></p>
                </div>
                <div class="theme_form">
                    <?php echo do_shortcode('[contact-form-7 id="218" title="Request a Solution"]');?>
                </div>
            </div>
         </section>   
      
    </div>
		
		
                            
<?php get_footer(); ?>