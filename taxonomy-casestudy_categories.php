<?php
    get_header(); 

    $post_type         = 'case_study';

    // The ID of a term in the terms table
    $term_id           = $wp_query->queried_object_id;
    
    // Fetch the Taxonomy Name
    $taxonomy          = get_query_var( 'taxonomy' );
    $taxonomy_obj      = get_taxonomy( $taxonomy );
    
    // Get WP_Term Object
    $term              = get_term_by(
        'id', 
        $term_id, 
        $taxonomy 
    );

    // Fetch Term Name
    $term_name         = $term->name;
    
    // Fetch Term Slug
    $term_slug         = $term->slug;
    
    // Fetch Term Group
    $term_group        = $term->term_group;
    
    // Fetch a unique ID for the term + taxonomy pair
    $term_taxonomy_id  = $term->term_taxonomy_id;
    
    // Fetch the Taxonomy Name
    $term_taxonomy     = $term->taxonomy;
    
    // Fetch the Description
    $term_description  = $term->description;
    
    // Fetch the Term Parent
    $term_parent       = $term->parent;
    
    // Fetch the Post related to Term
    $term_count        = $term->count;
    
    // Fetch the Term Filter
    $term_filter       = $term->filter;
    
    // Fetch the Term Order
    $term_order        = $term->term_order;

    $banner            = CORE_DEFAULT_BANNER_IMAGE;

?>

<div id="pagebanner" class="pagebanner casestudies_banner">
    <div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
        <div class="container">
		
			<?php
		  		if ( have_posts() ) :
					//the_archive_title( '<h1 class="page-title">', '</h1>' );

					echo '<h1>' . esc_html( $term_name ) . '</h1>';
				endif;
			?>

			<?php core_breadcrumbs(); ?>
        </div>
    </div>
</div>

 <main id="pagecontent" role="content">
    <section class="innerpages pt-100 pb-100">
        
        <div class="container">
            <div class="row">

       

                <div id="primary" class="col-md-8">

                    <div class="sharethis"></div>

                    <div class="cs-content app_case_content app_case_content_wrap ajax-loading-area">

                        <?php
                            $tax_query = array(
                                array(
                                    'taxonomy'         => $taxonomy,
                                    'field'            => 'id',
                                    'terms'            => $term_id,
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

                            $query_args[ 'tax_query' ] = $tax_query;

                            $the_query = new WP_Query( $query_args );
                        ?>

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

                </div> <!-- #primary -->

                <div id="secondary" class="col-md-4">       
                    <?php
                        $filter_args = array(
                            'title'      => __( 'Search ' . core_cpt_label( $post_type ), 'massload' ),
                            'post_type'  => $post_type,
                            'taxonomy'   => $taxonomy,
                            'tax_terms'  => $term_id,
                            'ajax'       => true,
                            'option_default_text' => __( 'SEARCH BY CATEGORY', 'massload' ),
                            'use_fields' => array( 'search' )
                        );
                        core_adv_search_widget( $filter_args );
                    ?>
                </div> <!-- #secondary -->

            </div>
        </div>

    </section> 
</main>
<?php get_footer(); ?>