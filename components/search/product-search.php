<?php
    $post_class   = get_post_class( 'searchResults' );
    $search_val   = filter_input(
		INPUT_GET,
		's',
		FILTER_DEFAULT
	);
    $s_post_type = filter_input(
        INPUT_GET,
        'posttype',
        FILTER_DEFAULT
    );
	$search_type = filter_input(
		INPUT_GET,
		'search_type',
		FILTER_DEFAULT
    );
    
    $product_link = '';

     $filter_args = array(
                            'placeholder'     => __( 'PRODUCT SEARCH', 'massload' ),
                            'post_type'       => 'products',
                            'taxonomy'        => 'related_tags',
                            'search_type'     => 'product_search',
                            'set_taxonomy'    => false,
                            'set_terms'       => false,
                            'set_search_type' => true,
                            'wp_search'       => true,
                            'set_title'       => false,
                            'ajax'            => false,
                            'use_fields'      => array( 'search' ),
                        );
                        echo '<div class="core-product-archive-search pb-50">';
                            core_adv_search_widget( $filter_args );
                        echo '</div>';
    
    if ( have_posts() ) :
        echo '<div class="container">';
            echo '<h4>';
                printf( 
                    esc_html__( 'Product Results for: %s', 'massload' ), 
                    '<span>' . get_search_query() . '</span>' 
                );
            echo'</h4>';
        echo '</div>';

        echo '<main class="result_list">';
            echo '<div class="container">';

                // .product-block
                echo '<div class="product-block">';
                    echo '<div class="row">';
                       $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                        $args = array(
                            // 'post_parent' => get_the_ID(),
                            's'                => $search_val,
                            'post_type'        => $s_post_type,
                            'posts_per_page'   => 12,
                            'order'            => 'ASC',
                            'orderby'          => 'date',
                            'post_status'      => 'publish',
                            'suppress_filters' => false,
                            'paged'          => $paged,
                        );

                        $the_query = new WP_Query( $args );

                        // The Loop
                        if ( $the_query->have_posts() ) :
                            while ( 
                                $the_query->have_posts() ) : $the_query->the_post();
                                $post_id       = get_the_ID();
                                $product_link  = get_the_permalink();
                                $img_class     = '';
                                $post_image    = get_field( 'product_thumb' );
                                $post_parent   = wp_get_post_parent_id( $post_id );

                                if ( empty( $post_image ) ) {
                                    $post_image = CORE_PLACEHOLDER_IMAGE;
                                    $img_class  = 'placeholder-image';
                                }

                                echo '<div class="col-md-6 col-lg-4">';

                                    echo '<div class="productblock childProduct ' . esc_attr( $img_class ) . '">';

                                        echo '<div class="image-wrap">';
                                            echo '<a href="' . esc_url( $product_link ) . '">';
                                                echo '<img src="' . esc_url( $post_image ) . '" alt="">';
                                            echo '</a>';
                                        echo '</div>';

                                        echo '<div class="product-content">';
                                            echo '<h3>';
                                                echo '<a href="' . esc_url( $product_link ) . '">';
                                                    echo get_the_title();
                                                echo '</a>';
                                            echo '</h3>';
                                            echo '<p>';
                                                echo get_field('short_content'); 
                                            echo '</p>';
                                        echo '</div>';
                                        echo '<div class="productActions">';

                                            echo '<a href="' . esc_url( $product_link ) . '" class="theme-btn">';
                                                echo __( 'VIEW PRODUCT', 'massload' );
                                            echo '</a>';

                                            if (
                                                0     === $post_parent ||
                                                false === $post_parent
                                            ) {
                                                echo '<a href="' . esc_url( '#' ) . '" class="theme-btn disabled">';
                                                    echo __( 'Applications', 'massload' );
                                                echo '</a>';

                                                echo '<a href="' . esc_url( '#' ) . '" class="theme-btn disabled">';
                                                    echo __( 'Case studies', 'massload' );
                                                echo '</a>';
                                            } else {
                                                echo '<a href="' . esc_url( $product_link . '#application-casestudies' ) . '" class="theme-btn">';
                                                    echo __( 'Applications', 'massload' );
                                                echo '</a>';

                                                echo '<a href="' . esc_url( $product_link . '#application-casestudies' ) . '" class="theme-btn">';
                                                    echo __( 'Case studies', 'massload' );
                                                echo '</a>';
                                            }
                                        
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            endwhile;
                        endif;

                        // Reset Post Data
                        wp_reset_postdata();

                    echo '</div>';
                echo '</div>';
                // .product-block

            echo '</div>';
        echo '</main>';

    else :
        echo '<div class="container text-center">';
            echo '<h5>';
                _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'massload' );
            echo '</h5>';
        echo '</div>';
    endif;