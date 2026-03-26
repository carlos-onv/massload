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
<?php
	$post_id       = $post->ID;
	$post_content  = $post->post_content;
	$post_image    = get_the_post_thumbnail_url( $post_id, 'full' );
	$thumbnail_id  = get_post_thumbnail_id( $post_id );
	$alt           = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
	$post_date     = get_the_date( 'F j, Y', $post_id );
?>

<div class="col-sm-6">
	<div class="app_case_content_wrap">
		<div class="app_case_content_inner">
			<div class="app_case_image">
				<a href="<?php the_permalink(); ?>" class="image-link">
					<img src="<?php echo esc_url( $post_image ) ?>" alt="<?php echo $alt; ?>"  class="img-fluid">
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