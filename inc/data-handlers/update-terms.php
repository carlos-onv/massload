<?php



function core_update_post_terms( $args = array() ) {
    $children     = array(); 
    $default_args = array(
        'post_type'        => '',
        'post_parent'      => '',
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'order'            => 'ASC',
        'set_taxonomy'     => '',
        'set_terms'        => array(),
        'suppress_filters' => false
    );

    $args = array_merge( $default_args, $args );

    extract( $args );

    if ( 
        ! empty( $post_type )    &&
        ! empty( $post_parent )  &&
        ! empty( $set_taxonomy ) &&
        ! empty( $set_terms )
    ) {
        $children = core_get_post_children( $args );

        if ( $children ) {
            foreach ( $children as $child_id ) {
                wp_set_post_terms(
                    $child_id,
                    $set_terms,
                    $set_taxonomy
                );
            }
        }
    }

    return;
}

