<?php
/**
 * Wrapper function for paginate_links.
 *
 * @param array  $paginate_args  The array configuration.
 *
 * @link   https://developer.wordpress.org/reference/functions/paginate_links/
 * @since  1.0.0
 *
 * @return void
 */


function core_pagination( $paginate_args = array() ) { 
    global $wp_query, $wp_rewrite;

    $output   = '';
    $paginate = 999999999; // need an unlikely integer
     

    $default_paginate_args = array(
        // Use This Format on Archive Pages
        // 'base'      => str_replace( $paginate, '%#%', esc_url( get_pagenum_link( $paginate ) ) ),

        // Use this Format when using on a custom pagination
        'base'        => add_query_arg( 'paged', '%#%' ),
        'format'      => '?paged=%#%',
        'current'     => max( 1, get_query_var( 'paged' ) ),
        'prev_text'   => '<i class="fa fa-angle-left core-icon" aria-hidden="true"></i>' . __( 'Prev', 'massload' ),
        'next_text'   => __( 'Next ', 'massload' ) . '<i class="fa fa-angle-right core-icon" aria-hidden="true"></i>',
        'total'       => $wp_query->max_num_pages,
        'ajax'        => true,
        'add_classes' => ''
    );

    $paginate_args = array_merge( $default_paginate_args, $paginate_args );
    extract( $paginate_args );

    // if ( $total <= CORE_POST_PER_PAGE ) {
    //     $paginate_args[ 'total' ] = 0;
    // }

    if ( $ajax ) {
        $output .= '<div class="core-pagination-ui ajax-enabled ' . esc_attr( $add_classes ) . '">';
    } else {
        $output .= '<div class="core-pagination-ui ' . esc_attr( $add_classes ) . '">';
    }
        $output .= '<nav class="core-pagination">';
            $output .= paginate_links( $paginate_args );
        $output .= '</nav>'; // .core-pagination
    $output .= '</div>'; // .core-pagination-container

    return $output;
}