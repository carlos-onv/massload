<?php
/**
 * Template Name: Resources
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

$banner = get_the_post_thumbnail_url( get_the_ID(), 'full' );

?>
  
<div id="pagebanner" class="pagebanner resources_banner">
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

      <?php echo do_shortcode( '[core_featured_carousel display=resources]' ); ?>

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
                $post_type = 'resources';
            }

            if ( empty( $taxonomy ) ) {
                $taxonomy = 'resources_categories';
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
            // The Loop
        ?>

        <div id="primary" class="col-md-8">

            <div class="sharethis"></div>

            <div class="cs-content app_case_content app_case_content_wrap ajax-loading-area">
                <div class="row post-object-filter-result">
                    <?php  

                        if ( $the_query->have_posts() ) {
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                $post_id       = $post->ID;
                                $post_content  = $post->post_content;
                                $post_image    = get_the_post_thumbnail_url( $post_id, 'full' );
                                $post_date     = get_the_date( 'F j, Y', $post_id );
                    ?>

                                <div class="col-sm-6">
                                    <div class="app_case_content_wrap">
                                        <div class="app_case_content_inner">
                                            <div class="app_case_image">
                                                <a href="<?php the_permalink(); ?>" class="image-link">
                                                    <img src="<?php echo esc_url( $post_image ) ?>" class="img-fluid">
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
                    'title'      => __( 'Search Resources', 'massload' ),
                    'post_type'  => $post_type,
                    'taxonomy'   => $taxonomy,
                    'ajax'       => true,
                    'use_fields' => array( 'search', 'select' ),
                    'option_default_text' => __( 'SEARCH BY CATEGORY', 'massload' ),
                );
                core_adv_search_widget( $filter_args );

                // Popular Tags Widget
                $tag_args = array(
                    'post_type'           => $post_type,
                    'taxonomy'            => $taxonomy,
                    'ajax'                => false
                );

                core_tags_widget( $tag_args );
            ?>

        </div>
      </div>
    </div>
  </section> 

</main>
<?php get_footer(); ?>