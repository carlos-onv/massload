<?php
/**
 * The main template file
 *
 * This is the most generic template file 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */
get_header();

$banner = CORE_DEFAULT_BANNER_IMAGE;

?>

<div id="pagebanner" class="pagebanner resources_banner">
	<div class="inner-banner"  style="background-image: url(<?php echo esc_url( $banner ); ?>);">
		<div class="container">

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			<?php else : ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
			<?php endif; ?>

			<?php core_breadcrumbs(); ?>
		</div>
	</div>
</div>

<main id="pagecontent" role="content">
	<section class="innerpages pt-100 ">
		<div class="container">

			<div class="row">
					<?php // echo do_shortcode("[pjc_slideshow slide_type='banner-slider']");	?>
					
					<div id="primary" class="content-area col-md-8">

						<div id="content" class="site-content" role="main">

							<div class="cs-content app_case_content app_case_content_wrap ajax-loading-area">
								<div class="row post-object-filter-result">
									<?php
										global $wp_query;

										if ( have_posts() ) :

											// Start the Loop.
											while ( have_posts() ) : the_post();

												// Include the page content template.`
												// get_template_part( 'content', 'page' );
												get_template_part( 'components/post/content', get_post_format() );

												// If comments are open or we have at least one comment, load up the comment template.
												if ( comments_open() || get_comments_number() ) {
													comments_template();
												}
											endwhile;

											$paginate_args = array(
												'total'       => $wp_query->max_num_pages,
												'add_classes' => 'include-advance-search'
											);
											
											echo core_pagination( $paginate_args );

										else :

											get_template_part( 'components/post/content', 'none' );

										endif;
									?>
								</div>
							</div>

						</div><!-- #content -->

					</div><!-- #primary -->

					<div id="secondary" class="col-md-4">

						<?php
							$post_type = get_post_type();

							// Advance Search Widget
							$filter_args = array(
								'title'      	=> __( 'Search Resources', 'massload' ),
								'post_type'  	=> $post_type,
								'ajax'       	=> true,
								'set_taxonomy'  => false,
								'set_terms'     => false,
								'use_fields'	=> array( 'search' ),
							);
							core_adv_search_widget( $filter_args );
						?>

					</div> <!-- #secondary -->
			
			</div>
		</div>
	</section> 

</main>
		
	
<?php get_footer(); ?>
