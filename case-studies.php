<?php
/**
 * Template Name: Casestudies
 * 
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

get_header(); 

$post_type = 'case_study';
$taxonomy  = 'casestudy_categories';
$banner    = get_the_post_thumbnail_url(get_the_ID(),'full');
?>

<div id="pagebanner" class="pagebanner casestudies_banner">
    <div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
        <div class="container">
            <h1><?php the_title(); ?></h1>
			<?php core_breadcrumbs(); ?>
        </div>
    </div>
</div>

 <main id="pagecontent" role="content">
    <section class="innerpages pt-100 ">
        
		<div class="container">
			<div class="row">

				<?php 
					$search      = filter_input(
						INPUT_GET,
						'search',
						FILTER_DEFAULT
					);
					$post_type   = filter_input(
						INPUT_GET,
						'posttype',
						FILTER_DEFAULT
					);
					$taxonomy    = filter_input(
						INPUT_GET,
						'tax',
						FILTER_DEFAULT
					);
					$terms        = filter_input(
						INPUT_GET,
						'term',
						FILTER_DEFAULT
					);

					if ( false !== strpos( $terms, ',' ) ) {
						$terms = explode( ',', $terms );
					}
					
					if ( empty( $post_type ) ) {
						$post_type = 'case_study';
					}

					if ( empty( $taxonomy ) ) {
						$taxonomy = 'related_tags';
					}
					
					$tax_query = array(
						array(
							'taxonomy'         => $taxonomy,
							'field'            => 'id',
							'terms'            => $terms,
							'operator'         => 'IN',
							'include_children' => false
						)
					);
					
					$query_args = array(
						'post_type'        => $post_type,
						'posts_per_page'   => CORE_POST_PER_PAGE,
						'paged'            => max( 1, get_query_var( 'paged' ) ),
						'order'            => 'ASC',
						'orderby'          => 'date',
						'suppress_filters' => false
					);

					if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
						$query_args[ 'tax_query' ] = $tax_query;
					}
					if ( ! empty( $search ) ) {
						$query_args[ 's' ] = $search;
					}

					$the_query = new WP_Query( $query_args );
				?>

				<div id="primary" class="col-md-8">

					<div class="sharethis">
					</div>

					<div class="cs-content app_case_content app_case_content_wrap ajax-loading-area core-post-boxes pb-100">
						<div class="row post-object-filter-result">
							<?php  

								if ( $the_query->have_posts() ) {
									while ( $the_query->have_posts() ) : $the_query->the_post();
										$post_id       = $post->ID;
										$post_content  = $post->post_content;
										$post_image    = get_the_post_thumbnail_url( $post_id, 'full' );
										$post_date     = get_the_date( 'F j, Y', $post_id );
									    $thumbnail_id  = get_post_thumbnail_id( $post_id );
										$alt           = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
							?>

										<div class="col-sm-6">
											<div class="app_case_content_wrap">
												<div class="app_case_content_inner">
													<div class="app_case_image">
														<a href="<?php the_permalink(); ?>" class="image-link">
															<img src="<?php echo esc_url( $post_image ) ?>" alt="<?php echo $alt; ?>" class="img-fluid">
															<span class="post-date"><?php echo esc_html( $post_date ); ?></span>
														</a>
													</div>
													<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
													<p>
														<?php
															echo core_get_excerpt(
																$post_id,       // Post ID
																$post_content,  // Post Content
																true,          // Enable Read More Link
																true,           // Enable Ellipsis
																22,             // Number of Words to display
																'... '          // Ellipsis text
															);
														?>
													</p>
												</div>
											</div>
										</div>

									<?php 
									endwhile;
								} else {
									echo '<p>' . __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'massload' ) . '</p>';
								}

								// Reset Post Data
								wp_reset_postdata();
							?>
						</div>

						<?php
							$paginate_args = array(
								'total'       => $the_query->max_num_pages,
								'add_classes' => 'include-advance-search'
							);
							echo core_pagination( $paginate_args );
						?>
					</div>

				</div>

				<div id="secondary" class="col-md-4">
					<?php
						// Advance Search Widget
						$filter_args = array(
							'title'      => __( 'Search Case Studies', 'massload' ),
							'post_type'  => $post_type,
							'taxonomy'   => $taxonomy,
							'ajax'       => true,
							'set_terms'  => false,
							'use_fields' => array( 'search' ),
						);
						core_adv_search_widget( $filter_args );

				
						// Popular Tags Widget
						$tag_args = array(
							'post_type'           => $post_type,
							'taxonomy'            => $taxonomy,
							'related_tags'        => true,
							'ajax'                => false
						);
						core_tags_widget( $tag_args );


						// Recent Posts Widget
						$recent_posts_args = array(
							'post_type'           => $post_type,
							'posts_per_page'      => 4,
							'ajax'                => false,
						);
						core_recent_posts_widget( $recent_posts_args );
					?>

				</div>


			</div>
		</div>

    </section> 

      <section id="req-quote" class="quaote_blk">
        <div class="container">
             <div class="heading-block text-center">
				<?php 
					if ( mmi_opts_get( 'csform-title' ) ) {
						echo '<h2>';
							mmi_opts_show( 'csform-title' );
						echo '</h2>';
            		} else {
						echo sprintf( 
							esc_html__( '%1$s' . '%2$s' . 'Request A' . '%3$s' . ' Solution' . '%4$s', 'massload' ),
							'<h2>',
							'<span>',
							'</span>',
							'</h2>'
						);
					}
            		/*if ( mmi_opts_get( 'csform-subtitle' ) ) {
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
					}*/
				?>
                
                <p><br></p>
            </div>
            <div class="theme_form"><!-- SharpSpring Form for Case Study  -->
<script type="text/javascript">
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'M7VIMzY1NE_TtUg0SdQ1STQz0U1MTTXWTTYwtkhNSUkxNkk1AQA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>

                <?php //echo do_shortcode('[contact-form-7 id="1346" title="Request a Casestudy"]');?>
            </div>
        </div>
     </section>

  
</main>
<?php get_footer(); ?>