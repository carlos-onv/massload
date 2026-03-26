<?php
	/**
	 * Template Name: Application Products
	 */


	get_header(); 

	$rp_link   = get_permalink();

	$app_id    = filter_input(
		INPUT_GET,
		'appid',
		FILTER_DEFAULT
	);
	
	$parent_id_param  = 'parent_ids';
	$parent_id_string = filter_input(
		INPUT_GET,
		$parent_id_param,
		FILTER_DEFAULT
	);
	$parent_ids		  = array();

	if ( ! empty( $parent_id_string ) ) {
		$parent_ids = explode( ',', $parent_id_string );
	}

?>

<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image');?>);">
        <div class="container">
			<h3>
				<?php if(mmi_opts_get('product-banner-link')) { 
					$prod_main_link = mmi_opts_get('product-banner-link');
				} else { 
					$prod_main_link = get_home_url().'/?page_id=1054';
				} ?>
				<a href="<?php echo $prod_main_link; ?>" class="quote_btn"> 
					<?php if(mmi_opts_get('product-banner-title')) { ?>
						<?php mmi_opts_show('product-banner-title'); ?>
					<?php } else { ?>
						Products 
					<?php } ?>
				</a>
			</h3>

			<h1><?php the_title();?></h1>

			<?php
				core_breadcrumbs(
					array(
						'set_parent' => true,
						'parent'     => array(
							'parent_data'    => 'applications',
							'parent_data_by' => 'slug', // ID, Title or Slug
							'parent_title'   => '',
							'parent_link'    => ''
						)
					)
				);
			?>
        </div>
    </div>
</div>

<div id="pagecontent" class="pagecontent">
 
  	<!-- <h2>Application: <?php //echo get_the_title($app_id); ?></h2> -->

	<div class="product-intro pt-100 pb-100">
		<div class="container">
			<div class="row">

				<div class="col-md-4 productImage-right">
					<div class="productMenu-sidebar applicationMenu-sidebar">
						<div class="headingsecondary-block">
							<h3>
								<?php 
									if ( mmi_opts_get( 'filter-prod-title' ) ) {
										mmi_opts_show( 'filter-prod-title' );
									} else {
										echo esc_html__( 'FILTER PRODUCTS', 'massload' );
									}
								?>
							</h3>
						</div>

						<?php 
							$args = array(
								'post_parent'      => 0,
								'posts_per_page'   => -1,
								'post_type'   	   => 'products',
								'order' 		   => 'ASC',
								'orderby'		   => 'menu_order',
								'suppress_filters' => false
							);

							$the_query = new WP_Query( $args );
							
							$list_output     = '';
							$current_link    = get_the_permalink();

							$products_cpt    = 'products';
							$products_order  = 'menu_order';
							$products_status = 'publish';
							$product_parents = array();
							$args 			 = array(
								'post_parent'    => 0,
								'posts_per_page' => -1,
								'post_type'   	 => $products_cpt,
								'order' 		 => 'ASC',
								'post_status'    => $products_status,
								'orderby'		 => $products_order,
								'return'		 => 'object'
							);
							
							$product_parents = core_get_post_parent( $args );

							if ( ! empty( $product_parents ) ) {

								$list_output .= '<ul class="core-product-filter">';
									foreach ( $product_parents as $product_parent ) {
										$parent_id    = $product_parent->ID;
										$parent_title = $product_parent->post_title;
										$item_class   = 'product-filter';
										$filter_link  = $current_link;
										$current_ids  = $parent_ids;
										
										$children_args = array(
											'post_type'        => $products_cpt,
											'post_parent'      => $parent_id,
											'post_status'      => $products_status,
											'posts_per_page'   => -1,
											'order'            => 'ASC',
											'suppress_filters' => false
										);
										
										$product_children = get_children( $children_args ); 
										$count_children   = count( $product_children );
										
										if ( ! empty( $parent_id_string ) ) {
											$filter_link  = $current_link . '?' . $parent_id_param . '=' . $parent_id_string;
										}

										if ( 0 !== $count_children ) { 
											if ( in_array( $parent_id, $parent_ids ) ) {
												
												$current_ids  = array_diff( 
													$current_ids, 
													array( strval( $parent_id ) ) 
												);
												
												if ( ! empty( $current_ids ) ) {
													$filter_link  = $current_link . '?' . $parent_id_param . '=' . implode( ',', $current_ids );
												} else {
													$filter_link  = $current_link;
												}

												$item_class   = 'app_active ';
											} else {
												if ( ! empty( $parent_id_string ) ) {
													$current_ids[] = strval( $parent_id );
													$filter_link  = $current_link . '?' . $parent_id_param . '=' . implode( ',', $current_ids );
												} else {
													$filter_link  = $current_link . '?' . $parent_id_param . '=' . $parent_id;
												}
											}


											$list_output .= '<li class="' . esc_attr( $item_class ) . '">';
												$list_output .= '<a href="' . esc_url( $filter_link ) . '">';
													$list_output .= esc_html( $parent_title . ' (' . $count_children . ')' );
												$list_output .= '</a>';
											$list_output .= '</li>';
										}

									}
								$list_output .= '</ul>';
							}

							echo $list_output;

						?>
					</div>
				</div>
			
				<?php
					$product_children_args = array(
						'post_type'      	  => $products_cpt,
						'post_parent'    	  => $parent_ids,
						'post_parent__in'     => $parent_ids,
						'posts_per_page' 	  => -1,
						'order'          	  => 'DESC',
						'suppress_filters'    => false
					);

					$product_children = get_children( $product_children_args );
					
					if ( $product_children ) {
						echo '<div class="col-md-8">';
							echo '<div class="product-block app-product-block">';
								echo '<div class="row">';
									foreach ( $product_children as $product_child ) { 
										if ( 
											$product_child->post_type != 'attachment' &&
											$product_child->post_parent != 0 
										) {

											$product_thumb = get_field( 'product_thumb', $product_child->ID );
											$product_class = 'productblock ';
											
											if ( empty( $product_thumb ) ) {
												$product_thumb = CORE_PLACEHOLDER_IMAGE;
												$product_class .= 'default-img';
											}

											echo '<div class="col-md-6 col-lg-6">';
												echo '<div class="' . esc_attr( $product_class ) . '">';

													if ( $product_thumb ) {
														echo '<img src="' . esc_url( $product_thumb ) . '">';
													}

													echo '<div class="product-content">';
														echo '<h3>';
															echo '<a href="' . esc_url( get_permalink( $product_child->ID ) ). '">';
																echo esc_html( $product_child->post_title );
															echo '</a>';
														echo '</h3>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
										}
									}
								echo '</div>';

							echo '</div>';
						echo '</div>';
					}
				?>

			</div>
		</div>
	</div>
</div>


<section id="req-quote" class="quaote_blk">
	<div class="container">
		<div class="heading-block text-center">
			<h2>
				<?php 
					echo '<span>' . esc_html_e( 'Request A', 'massload' ) . '</span> ' . esc_html_e( 'Solution', 'massload' );

					// if ( mmi_opts_get( 'quoteform-title' ) ) {
					// 	mmi_opts_show('quoteform-title');
					// } else {
					// 	echo '<span>' . __( 'Request A', 'massload' ) . '</span> ' . __( 'Solution', 'massload' );
					// }
				?>
			</h2>
			<?php 
				if ( mmi_opts_get( 'quoteform-subtitle' ) ) {
					echo '<p>';
						mmi_opts_show('quoteform-subtitle');
					echo '</p>';
				} else {
					echo sprintf( 
						esc_html__( '%1$s' . 'Submitting this form will ' . '%2$s' . 'not' . '%3$s' . ' add you to any email distribution lists.' . '%4$s', 'massload' ),
						'<p>',
						'<em>',
						'</em>',
						'</p>'
					);
				}
			?>
			<p><br></p>
		</div>
		<div class="theme_form">
			<?php echo do_shortcode('[contact-form-7 id="218" title="Request a Solution"]');?>
		</div>
	</div>
</section>
		
<?php get_footer(); ?>