<?php
/**
 /**
	 * Template Name: Environmental Sustainability
	 

 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header(); 

$get_the_ID = get_the_ID();

$bnr_btn_text = get_field( 'button_label');
$bnr_btn_link = get_field( 'button_link');
?>

<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image');?>);">
        <div class="container">

			<?php
             /*   $root       = get_page_by_path( 'applications' );
                $root_id    = '';
                $root_link  = '';
                $root_title = '';

                if ( ! empty( $root ) ) {
                    $root_id    = core_icl_object_id( $root->ID );
                    $root_link  = get_the_permalink( $root_id );
                    $root_title = get_the_title( $root_id );

                    $breadcrumb = array(
                        'archive'     => array(
                            'title'   => $root_title,
                            'link'    => $root_link
                        ),
                    );

                    echo '<h3>';
                        echo '<a href="' . esc_url( $root_link ) . '" class="quote_btn">';
                            echo esc_html( $root_title );
                        echo '</a>';
                    echo '</h3>';
                } */

                echo '<h1>';
                    the_title();
                echo '</h1>';

                echo core_breadcrumbs( 
                    array( 
                        'echo' => false
                    )
                );
                
                echo '<a class="banner-btn com-btn" href="' . esc_url( $bnr_btn_link ) . '">';
                    echo esc_html( $bnr_btn_text );
                echo '</a>';
			?>
			
        </div>
    </div>    
</div>

 <main id="pagecontent" role="content">
    <section class="innerpages pb-0">

        <div class="container pb100">
            <div class="heading-block pt-100 text-center">
            	<?php $custom_title = get_field('custom_title');
            	if($custom_title){  ?>
					<h2><?php echo $custom_title ?></h2>
				<?php }else{ ?>
					<h2><span><?php the_title();?></span> <?php //echo esc_html( $root_title ); ?></h2>
				<?php } ?>

				<div class="row justify-content-center">
                	<div class="col-md-12">
		            	<?php if( get_field('app_short_desc')) { ?>
		                	<p><?php echo get_field('app_short_desc'); ?></p>
		                <?php } ?>
                    </div>
                </div>

				<?php
					/*$application_products_link = get_the_permalink( '1293' );
					$products_list       	   = get_field( 'products_list', $get_the_ID );
					$product_parent_args 	   = array();
					$product_parents     	   = '';
					
					if ( ! empty( $products_list ) && is_array( $products_list ) ) {
						$products_list = implode( ',', $products_list );
					}

					$product_parent_args = array(
						'post_type'       => 'products',
						'post_parent'     => '',
						'post__in'        => explode( ',', $products_list ),
						'parent_post__in' => true,
						'return_format'   => 'string',
						// 'return'          => 'post_title',
					);
					$product_parents     = core_get_post_parent( $product_parent_args );

					if ( ! empty( $product_parents ) ) {
						$application_products_link = $application_products_link . '?parent_ids=' . $product_parents;
					}

					echo '<a class="case_study_btn com-btn" href="' . esc_url( $application_products_link  ) . '" target="_self">';
						echo __( 'View Related Products', 'massload' );
					echo '</a>';
				*/ ?>
				
            </div>
            <?php

			// Check rows exists.
			if( have_rows('app_case_studies') ): 
			$cs_i = 1; ?>
            <div id="accordion" class="aapp">
            	<?php // Loop through rows.
    			while( have_rows('app_case_studies') ) : the_row(); ?>
              <div class="card">
                <div class="card-header" id="heading<?php echo $cs_i; ?>">
                  <h5 class="mb-0">
                  <?php if($cs_i == 1) { ?>
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $cs_i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $cs_i; ?>">
                  <?php }else { ?>
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $cs_i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $cs_i; ?>">
                  <?php } ?>
                      <?php echo get_sub_field('cs_rtitle'); ?>
                    </button>
                  </h5>
                </div>

                <div id="collapse<?php echo $cs_i; ?>" class="collapse <?php if($cs_i == 1 ) { echo "show"; } ?>" aria-labelledby="heading<?php echo $cs_i; ?>" data-parent="#accordion">
                  <div class="card-body">
                    
                      <div class="row">
                        <div class="col-md-12">
                          <div class="cd-inner">  
                            <?php if(get_sub_field('cs_rimage')) { ?>
                            <div class="con-img app_case_image">
                              		<img src="<?php echo get_sub_field('cs_rimage'); ?>">
                            </div>
                            <?php } ?>
                            <?php the_sub_field('cs_rcontent'); ?>
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

            <section id="req-quote" class="quaote_blk">
                <div class="container">
                    <div class="heading-block text-center">
						<?php
							echo sprintf( 
								esc_html__( '%1$s' . '%2$s' . 'Request A' . '%3$s' . ' Solution' . '%4$s', 'massload' ),
								'<h2>',
								'<span>',
								'</span>',
								'</h2>'
							);
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

    </section>
</main>
<?php get_footer(); ?>