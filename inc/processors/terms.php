<?php



function core_get_terms( $taxonomy = '', $specific = '' ) {

    $terms = get_terms( $taxonomy );

    if ( ! empty( $specific ) ) {
        $terms = wp_list_pluck( $terms, $specific );
    } else {
        $terms = wp_list_pluck( $terms, 'name', 'term_id' );
    }

    return $terms;
}

function core_get_post_terms( $post_id = '', $taxonomy = '', $return = 'array', $field = '' ) {
    $terms      = array();
    $collection = '';

    if (
        ! empty( $post_id ) &&
        ! empty( $taxonomy ) 
    ) {
        $terms = get_the_terms( $post_id, $taxonomy );
    
        if ( $terms && ! is_wp_error( $terms ) ) {
            if ( 'array' === $return ) {
                if ( ! empty( $field ) ) {
                    $collection = wp_list_pluck( $terms, $field, 'term_id' );
                } else {
                    $collection = wp_list_pluck( $terms, 'term_id' );
                }
            }
            if ( 'string' === $return ) {
                if ( ! empty( $field ) ) {
                    $collection = wp_list_pluck( $terms, $field, 'term_id' );
                } else {
                    $collection = wp_list_pluck( $terms, 'term_id' );
                }
                $collection = implode( ',', $collection );
            }
        }
    }

    return $collection;
}