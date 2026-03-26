<?php


function core_icl_object_id( $post_id = '', $post_type = 'page' ) {

    if ( function_exists( 'icl_object_id' ) ) {

        if (
            ! empty( $post_id ) 
        ) {
            $post_id = icl_object_id( 
                $post_id, 
                $post_type, 
                false,
                ICL_LANGUAGE_CODE
            );

        }
    }
    return $post_id;
}