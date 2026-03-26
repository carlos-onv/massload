<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package massload
 * @subpackage massload
 * @since massload 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		$page_id = get_the_ID(); 
		$uri 	 = get_page_uri($page_id); 
		$uri 	.= "#1"; 
		//echo $uri;  // massload_post_thumbnail(); 
	?>

	<header class="entry-header">			
						
							
		<?php
			if (
				in_array( 'category', get_object_taxonomies( get_post_type() ) )
			) {
				echo '<div class="entry-meta">';
					echo '<span class="cat-links">';
						echo get_the_category_list(
							_x(
								", ",
								"Used between list items, there is a space after the comma.",
								"massload"
							)
						);
					echo '</span>';
				echo '</div>';
			}

			if ( is_single() ) : ?> 
				<main id="pagecontent" role="content">
					<div class="innerpages">
						<div class="container">
								<div class="row">
									<div class="col-md-12">

										<?php
											$pdf_title = get_field('pdf_title');
											$pdf	   = get_field('pdf_upload');
										?>
							
										<div class="productitems">
											<?php
												
												the_title( '<h4 style="float: left;">', '</h4>' );
												
												if ($pdf) {
													echo '<div style="float: right;" class="viewpdf">';
														echo '<a target="_blank" href="' . $pdf['url'] . '">';
															echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
															echo esc_html( $pdf_title );
														echo '</a>';
													echo '</div>';
												}

												/* translators: %s: Name of current post */
												the_content( sprintf(
													__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'massload' ),
													the_title( '<span class="screen-reader-text">', '</span>', false )
												) );

												wp_link_pages( array(
													'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'massload' ) . '</span>',
													'after'       => '</div>',
													'link_before' => '<span>',
													'link_after'  => '</span>',
												) );
											?>
										</div>

										<div class="producttable">
											<div class="row">
												<div class="col-md-12">
												<?php $i = 0; if( have_rows('metal_name') ): ?>
													<?php while( have_rows('metal_name') ): the_row(); ?>
														<?php $metal_name = get_field_object('metal_name'); 
															//echo "<pre>"; print_r($metal_name);
															$size = get_sub_field('metal_size');
														?>	
													<div class="tablecontents">
														<?php if( $size ) { ?>
														<h4><i class="fa fa-arrow-right" aria-hidden="true"></i> <?php echo $size ?></h4>
														<?php } ?>
														<?php  if($i==0) { ?>
														<!--<div class="viewpdf"><a target="_blank" href="<?php echo $pdf['url']; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $pdf_title; ?></a></div>-->
														<?php  }  $i++; ?>
													</div>	
													<?php if(have_rows('metal_details')): ?>
													<div class="table-responsive tableitems">
														<table class="table table-bordered">
															<thead>
																<tr>
														<?php $val = array(); 
														foreach($metal_name['sub_fields'] as $sub_fields) {
															if( $sub_fields['sub_fields'] ) {
																foreach($sub_fields['sub_fields'] as $label) { ?>
																	<th><?php echo $label['label']; ?></th>	
																<?php 
																	$val[]= $label['name'];
																		} 
																		}

														} $count = count($val); //echo "<pre>"; print_r($val); ?>	
																</tr>
															</thead>
															<tbody>								
																<?php if(have_rows('metal_details')): ?>
															<?php while(have_rows('metal_details')):the_row(); ?>
																	<tr>
																	<?php for ($x = 0; $x < $count; $x++) { ?>
																	<?php if( $x == 0 ) { ?> 
																<?php $data = get_sub_field($val[$x]); 
																$replace_star_with_link = "<a href='$uri' style='color:red;'>*</a>";
																$star = "*"; ?>
																<td><?php echo str_replace($star, $replace_star_with_link, $data); ?></td>
																<?php } else { ?> 
																	<td><?php echo get_sub_field($val[$x]);?></td>
																<?php }	} ?>
																<tr/>
															<?php endwhile; ?>
																
															<?php endif; ?>
																											
															</tbody>
														</table>
													</div>	
													<?php endif; ?>
													<?php if( $i==1 ) { ?>
														<div class="commentsinfo">	
														<h4><?php echo get_field('inner_title'); ?></h4>
														<ul>
															<?php if(have_rows('inner_description')): ?>
															<?php while(have_rows('inner_description')):the_row(); ?>
															<li> <?php echo get_sub_field('inner_points'); ?></li>
															<?php endwhile; ?>
															<?php endif; ?>
														</ul>
														</div>	

														<?php if( have_rows('extension_name') ): ?>
													<?php while( have_rows('extension_name') ): the_row(); ?>
														<?php $extension_name = get_field_object('extension_name');
															$title = get_sub_field('extension_title');
														?>
														
														<div class="tablecontents">
															<h4><i class="fa fa-arrow-right" aria-hidden="true"></i> <?php echo $title ?></h4>
														</div>

														<div class="table-responsive tableitems">	
														<table class="table table-bordered">
															<thead>
																<tr>
														<?php $val = array(); 
														foreach($extension_name['sub_fields'] as $sub_fields) {
															if( $sub_fields['sub_fields'] ) {
																foreach($sub_fields['sub_fields'] as $label) { ?>
																	<th><?php echo $label['label']; ?></th>	
																<?php 
																	$val[]= $label['name'];
																		} 
																		}

														} $count = count($val); //echo "<pre>"; print_r($val); ?>	
																</tr>
															</thead>
															<tbody>								
																<?php if(have_rows('extension_details')): ?>
															<?php while(have_rows('extension_details')):the_row(); ?>
																	<tr>
																	<?php for ($x = 0; $x < $count; $x++) { ?>
																<td><?php echo get_sub_field($val[$x]);?></td>
																<?php	} ?>
																<tr/>
															<?php endwhile; ?>
																
															<?php endif; ?>
																											
															</tbody>
														</table>
													</div>
													<?php endwhile; endif;  ?>
													<div class="commentsinfo">
													<h4><?php echo get_field('ext_title'); ?></h4>
														<ul>
															<?php if(have_rows('ext_description')): ?>
															<?php while(have_rows('ext_description')):the_row(); ?>
															<li> <?php echo get_sub_field('ext_points'); ?></li>
															<?php endwhile; ?>
															<?php endif; ?>
														</ul>
													</div>
													<?php }	?>

													<?php endwhile; endif;  ?>									
													
													<div class="commentsinfo">
														<a name="1"></a>
														<h4><?php echo get_field('bottom_title'); ?></h4>
														<ul>
															<?php if(have_rows('bottom_description')): ?>
															<?php while(have_rows('bottom_description')):the_row(); ?>
															<li> <?php echo get_sub_field('points'); ?></li>
															<?php endwhile; ?>
															<?php endif; ?>
														</ul>
													</div>									
												</div>
											</div>
										</div> 
								</div>
							</div>
						</div>
					</div>
				</main>
			<?php else : ?> 
				<main id="pagecontent" role="content">
					<div class="container">
						<div class="productitems">
							<ul>
								<?php 
									the_title( '<li><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></li>' );
								 ?>
							</ul>
						</div>
					</div>
				</main> 
		<?php endif; ?>





		<div class="entry-meta">
			 <!-- <?php
				if ( 'post' == get_post_type() )
					massload_posted_on();

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'massload' ), __( '1 Comment', 'massload' ), __( '% Comments', 'massload' ) ); ?></span>
			<?php
				endif;

				edit_post_link( __( 'Edit', 'massload' ), '<span class="edit-link">', '</span>' );
			?> --> 	<!-- .entry-meta -->
			</div>			
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>				
			<!-- .entry-content -->
	<?php endif; ?>

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>					
</article><!-- #post-## -->
