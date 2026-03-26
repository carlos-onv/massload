<?php
/**
 * Template Name: Application Casestudy
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
			<?php 
				if ( function_exists( 'bcn_display' ) ) {
                    bcn_display();
				}

				echo '<h1>';
					esc_html_e( 'CASE STUDIES', 'massload');
				echo '</h1>';
			?>
            <?php core_breadcrumbs(); ?>
        </div>
    </div>
</div>

 <main id="pagecontent" role="content">
    <section class="innerpages pt-100 ">
        
		<div class="container">
			<div class="row">

				<div class="col-md-8">
					<h2 class="app_name">Application: <span>Mining</span></h2>
				
					<?php
						echo sprintf( 
							esc_html__( '%1$s' . 'Application: ' . '%2$s' . 'Mining' . '%3$s' . '%4$s', 'massload' ),
							'<h2 class="app_name">',
							'<span>',
							'</span>',
							'</h2>'
						);
					?>
					<h2 class="app_case_title"><?php esc_html_e( 'Underground Surge Bin', 'massload'); ?></h2>

					<div class="sharethis">
					</div>

					<div class="cs-content app_case_content">
						<img src="http://massloaddev.wowfactormedia.ca/wp-content/uploads/2020/05/Wireline-Lifting-Scales-and-Rope-Attachments.jpg" class="img-fluid">
						<h3><?php esc_html_e( 'What is Lorem Ipsum?', 'massload'); ?></h3>
						<p><?php esc_html_e( 'It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'massload'); ?></p>
						<h3><?php esc_html_e( 'Where does it come from?', 'massload'); ?></h3>
						<p><?php esc_html_e( 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.', 'massload'); ?></p>
						<ul>
							<li><?php esc_html_e( 'It was popularised in the 1960s with the release', 'massload'); ?></li>
							<li><?php esc_html_e( 'Galley of type and scrambled', 'massload'); ?></li>
							<li><?php esc_html_e( 'Electronic typesetting, remaining essentially', 'massload'); ?></li>
							<li><?php esc_html_e( 'Various versions have evolved over the years, sometimes', 'massload'); ?></li>
							<li><?php esc_html_e( 'There are many variations of passages of Lorem Ipsum available, but the majority', 'massload'); ?></li>
						</ul>
						<p><?php esc_html_e( 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.', 'massload'); ?></p>
					</div>

					<ul class="cs_article-footer">
						<li class="previous">
							<a class="link" href="<?php echo get_permalink( $prev_post->ID ); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php esc_html_e( ' PREVIOUS', 'massload'); ?></a>
						</li>

						<li class="next">
							<a class="link" href="<?php echo get_permalink( $next_post->ID ); ?>"><?php esc_html_e( 'NEXT ', 'massload'); ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
						</li>                
					</ul>

				</div>

				<div class="col-md-4">

					<div class="search-widget widget">
						<h4><?php esc_html_e( 'Search', 'massload'); ?></h4>
						<form>
							<input type="text" name="">
							<button type="submit" name=""> </button>
						</form>
					</div>

					<div class="tag-widget widget">
						<h4>Tag</h4>
						<ul>
							<li><a href="#"><?php esc_html_e( 'Mining', 'massload'); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Product 1', 'massload'); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Product 2', 'massload'); ?></a></li>
						</ul>
					</div>

					<div class="recently-widget widget">
						<h4>Recently Added</h4>
						<ul>
							<li><a href="#"><?php esc_html_e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'massload'); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'massload'); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'massload'); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'massload'); ?></a></li>
						</ul>
					</div>

				</div>
			</div>
		</div>
	</section>
	
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
							<?php 
								foreach( $posts as $post): 
									$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );
									//echo $thumbnail[0]."param";
									// variable must be called $post (IMPORTANT)
							?>
								<?php setup_postdata($post); ?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php 
								endforeach; 
							?>
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


</main>
<?php get_footer(); ?>