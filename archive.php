<?php
/**
 * The template for displaying Archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package massload
 * @subpackage massload
 * @since massload 1.0
 */

get_header(); ?>

<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(https://www.massload.com/wp-content/themes/massload/assets/img/career-bg-pattern.jpg);">
        <div class="container">
			<?php
				$title = get_queried_object()->name;
                echo '<h1>';
                echo $title;
                echo '</h1>';
			?>				
        </div>
    </div>    
</div>
<div id="pagecontent" role="content">
	<section class="innerpages pt-100">
		<div class="container">
			<div class="row">

				<!-- #primary -->
				<div id="primary" class="content-area col-md-8">
					<main id="main" class="site-main">
						<?php
							if ( have_posts() ) :

								if ( is_home() && ! is_front_page() ) : ?>
									<header>
										<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
									</header>
								<?php
								endif;

								echo '<div class="cs-content app_case_content app_case_content_wrap ajax-loading-area">';
									echo '<div class="row post-object-filter-result">';

										/* Start the Loop */
										while ( have_posts() ) : the_post();

											/*
											* Include the Post-Format-specific template for the content.
											* If you want to override this in a child theme, then include a file
											* called content-___.php (where ___ is the Post Format name) and that will be used instead.
											*/
											get_template_part( 'components/post/content', get_post_format() );

										endwhile;

									echo '</div>';
								echo '</div>';

								the_posts_navigation();

							elseif( is_tag() ) :
								
							elseif( is_category() ) :
								
							else :

								get_template_part( 'components/post/content', 'none' );

								
							endif;

							
							
						?>
					</main>
				</div>
				
				<!-- #secondary -->
				<div id="secondary" class="col-md-4">
					<?php
						$post_type = get_post_type();

						// Advance Search Widget
						$filter_args = array(
							'title'      	=> __( 'Search', 'massload' ),
							'post_type'  	=> $post_type,
							'ajax'       	=> true,
							'set_taxonomy'  => false,
							'set_terms'     => false,
							'use_fields'	=> array( 'search' ),
						);
						core_adv_search_widget( $filter_args );
					?>
				</div>

			</div>
		</div>
	</section>
</div>
<?php
get_footer();
