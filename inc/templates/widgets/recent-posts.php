<?php


function core_recent_posts_widget( $filter_args = array() ) { 
    $output              = '';
    $post_title          = '';
    $post_link           = '';
    $default_filter_args = array(
        'title'               => __( 'Search', 'massload' ),
        'set_title'           => true,
        'ajax'                => true,
        'post_type'           => array( 'posts' ),
        'posts_per_page'      => 4,
        'order' 		      => 'DESC',
        'orderby'   	      => 'date'
    );
    $filter_args = array_merge( $default_filter_args, $filter_args );
    extract( $filter_args );

    $output .= '<div class="core-recent-post-widget recently-widget widget">';
        if ( mmi_opts_get( 'recent-title' ) ) {
            $output .= '<h4>';
                $output .= mmi_opts_get( 'recent-title' );
            $output .= '</h4>';
        } else {
            $output .= '<h4>' . __( 'Recently Added', 'massload' ) . '</h4>';
        }

        $args = array(
            'posts_per_page'   => $posts_per_page,
            'post_type'        => $post_type,
            'order' 		   => $order,
            'orderby'   	   => $orderby,
            'suppress_filters' => false
        );
        $the_query = new WP_Query( $args );

        $output .= '<ul>';

            if ( $the_query->have_posts() ) : 
                while ( $the_query->have_posts() ) : $the_query->the_post();
                    $post_title = get_the_title();
                    $post_link  = get_the_permalink();

                    $output .= '<li>';
                        $output .= '<a href="' . esc_url( $post_link ) . '">';
                            $output .= esc_html( $post_title );
                        $output .= '</a>';
                    $output .= '</li>';
                endwhile;
            endif;

            // Reset Post Data
            wp_reset_postdata();

        $output .= '</ul>';

    $output .= '</div>';
    
    echo $output; 
}