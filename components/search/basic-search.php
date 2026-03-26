<?php
    $post_class  = get_post_class( 'searchResults' );
    
    if ( have_posts() ) :
        echo '<div class="container">';
            echo '<h4>';
                printf( 
                    esc_html__( 'Search Results for: %s'), 
                    '<span>' . get_search_query() . '</span>' 
                );
            echo'</h4>';
        echo '</div>';

        echo '<main class="result_list">';
            echo '<div class="container">';
                while ( have_posts() ) : the_post();
                    echo '<article id="post-' . get_the_ID() . '" class="' . esc_attr( implode( ' ', $post_class ) )  . '">';
                        echo '<div class="postImage">';
                            if ( get_field( 'product_thumb' ) == true ) {
                                echo '<img src="' . get_field( 'product_thumb' ) . '">';
                            } else if ( has_post_thumbnail() ) {
                                echo '<img src="' . get_the_post_thumbnail_url() . '">';
                            } else {
                                echo '<img src="' . mmi_opts_show( 'placeholder' ) . '">';
                            }
                        echo '</div>';
                        echo '<div class="searchContent">';
                            echo get_the_title( 
                                sprintf( 
                                    '<a href="%s" rel="bookmark"><h3>', 
                                    esc_url( get_permalink() ) 
                                ), 
                                '</h3></a>'
                            );
                            
                            echo get_the_excerpt();

                            echo '<a href="' . esc_url( get_the_permalink() ) . '" class="theme-btn">Read More</a>';
                        echo '</div>';

                        echo '<div class="clearfix"></div>';
                    echo '</article>'; // #post-##
    
                endwhile;
            echo '</div>';
        echo '</main>';

    else :
        echo '<div class="container text-center">';
            echo '<h5>';
                _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'massload' );
            echo '</h5>';
        echo '</div>';
    endif;