<?php
    get_header(); 
    global $wp_query;

    $post_types = CORE_POST_TYPES;
    $date_query = array();
    $q_year     = get_query_var( 'year' );
    $q_month    = get_query_var( 'monthnum' );
    $q_day      = get_query_var( 'day' );

    $banner     = CORE_DEFAULT_BANNER_IMAGE;

?>

<div id="pagebanner" class="pagebanner casestudies_banner">
    <div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
        <div class="container">
            <?php if ( have_posts() ) : ?>
                <?php
                    //the_archive_title( '<h1 class="page-title">', '</h1>' );

                    echo '<h1>' . get_the_archive_title() . '</h1>';
                ?>           
            <?php endif; ?>

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
                            if ( ! empty( $q_year ) ) {
                                $date_query['year']  = $q_year;
                            }

                            if ( ! empty( $q_month ) ) {
                                $date_query['month'] = $q_month;
                            }

                            if ( ! empty( $q_day ) ) {
                                $date_query['day']   = $q_day;
                            }

                            $query_args = array(
                                'post_type'        => $post_types,
                                'posts_per_page'   => CORE_POST_PER_PAGE,
                                'paged'            => max( 1, get_query_var( 'paged' ) ),
                                'order'            => 'ASC',
                                'orderby'          => 'date',
                                'date_query'       => $date_query,
                                'suppress_filters' => false
                            );
                            $the_query = new WP_Query( $query_args );
                        ?>

                        <div class="row post-object-filter-result">
                            <?php  

                                if ( $the_query->have_posts() ) {
                                    while ( $the_query->have_posts() ) : $the_query->the_post();
                                        $post_id       = $post->ID;
                                        $post_content  = $post->post_content;
                                        $post_type     = $post->post_type;
                                        $img_class     = '';
                                        $post_image    = get_the_post_thumbnail_url( $post_id, 'full' );
                                        $post_date     = get_the_date( 'F j, Y', $post_id );

                                        if ( empty( $post_image ) ) {
                                            $post_image = CORE_PLACEHOLDER_IMAGE;
                                            $img_class  = 'placeholder-image';
                                        }

                                       echo '<div class="col-sm-6 ' . esc_attr( $post_type ) . '">';
                            ?>
                                            <div class="app_case_content_wrap">
                                                <div class="app_case_content_inner">
                                                    <div class="app_case_image <?php echo esc_attr( $img_class ); ?>">
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
                            'title'     => __( 'Filter Archive', 'massload' ),
                            'post_type' => 'resources',
                            'taxonomy'  => 'resources_categories',
                            'tax_terms' => '',
                            'ajax'      => true,
                            'option_default_text' => __( 'SEARCH BY CATEGORY', 'massload' ),
                            'use_fields' => array( 'post_type_filter' )
                        );
                        core_adv_search_widget( $filter_args );
                    ?>
                    <?php // the_widget( 'WP_Widget_Archives' ); ?>
                </div> <!-- #secondary -->

            </div>
        </div>

    </section> 
</main>
<?php get_footer(); ?>