<?php


function core_search_by_taxonomy( $query ) {
    if ( !$query->is_search ) {
        return $query;
    }

    $post_type = filter_input(
        INPUT_GET,
        'posttype',
        FILTER_DEFAULT
    );

    if ( empty( $post_type ) ) {
        $post_type = get_post_type();
    }

    if ( ( $query->is_main_query() ) && ( is_search() ) ) {
        if ( 'post' === $post_type ) {
            $search      = filter_input(
                INPUT_GET,
                'search',
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
            
            $tax_query = array(
                array(
                    'taxonomy'         => $taxonomy,
                    'field'            => 'id',
                    'terms'            => $terms,
                    'operator'         => 'IN',
                    'include_children' => false
                )
            );

            if ( ! empty( $post_type ) ) {
                $query->set( 's', $search );
                $query->set( 'post_type', $post_type );
                $query->set( 'orderby', 'publish_date' );
                $query->set( 'order', 'DESC' );
            }

            if ( ! empty( $terms ) ) {
                $query->set( 's', $search );
                $query->set( 'post_type', $post_type );
                $query->set( 'tax_query', $tax_query );

                $query->set( 'orderby', 'publish_date' );
                $query->set( 'order', 'DESC' );
            }

        }
        
        if ( 'post' !== $post_type ) {
            $search = filter_input(
                INPUT_GET,
                's',
                FILTER_DEFAULT
            );
            $tax = filter_input(
                INPUT_GET,
                'tax',
                FILTER_DEFAULT
            );
            $term = filter_input(
                INPUT_GET,
                'term',
                FILTER_DEFAULT
            );

            $search_type = filter_input(
                INPUT_GET,
                'search_type',
                FILTER_DEFAULT
            );

            $taxquery = array(
                array(
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => array( $term ),
                'operator' => 'IN',
                )
            );
            
            $query->set( 'search_type', $search_type );
            
            if ( ! empty( $post_type ) ) {
                $query->set( 's', $search );
                $query->set( 'post_type', $post_type );
                $query->set( 'orderby', 'publish_date' );
                $query->set( 'order', 'DESC' );
            }

            if ( ! empty( $term ) ) {
                $query->set( 's', $search );
                $query->set( 'post_type', $post_type );
                $query->set( 'tax_query', $taxquery );

                if ( in_array( $post_type, array( 'resources' ) ) ) {
                    $query->set( 'orderby', 'publish_date' );
                    $query->set( 'order', 'DESC' );
                } else {
                    $query->set( 'orderby', 'title' );
                    $query->set( 'order', 'ASC' );
                }
            }

        }

    }

}
add_action( 'pre_get_posts', 'core_search_by_taxonomy' );

function core_post_search_by_taxonomy( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {

        if ( 'post' === get_post_type() ) {
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
            
            $tax_query = array(
                array(
                    'taxonomy'         => $taxonomy,
                    'field'            => 'id',
                    'terms'            => $terms,
                    'operator'         => 'IN',
                    'include_children' => false
                )
            );

            if ( ! empty( $post_type ) ) {
                $query->set( 's', $search );
                $query->set( 'post_type', $post_type );
                $query->set( 'orderby', 'publish_date' );
                $query->set( 'order', 'DESC' );
            }

            if ( ! empty( $terms ) ) {
                $query->set( 's', $search );
                $query->set( 'post_type', $post_type );
                $query->set( 'tax_query', $tax_query );

                $query->set( 'orderby', 'publish_date' );
                $query->set( 'order', 'DESC' );
            }

        }
    }
}
// add_action( 'pre_get_posts', 'core_post_search_by_taxonomy' );