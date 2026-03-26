<?php


function core_tags_widget( $filter_args = array() ) { 
    $output              = '';
    $object_id           = get_the_ID();
    $post_type           = get_post_type();
    $active_tags         = array();
    $default_filter_args = array(
        'title'               => __( 'Search', 'massload' ),
        'set_title'           => true,
        'post_type'           => array( 'posts' ),
        'taxonomy'            => 'category',
        'hide_empty'          => false,
        'is_singular'         => false,
        'related_tags'        => false,
        'ajax'                => true,
    );
    $filter_args = array_merge( $default_filter_args, $filter_args );
    extract( $filter_args );

    $output .= '<div class="core-tag-widget tag-widget widget">';
        if ( mmi_opts_get( 'tag-title' ) ) {
            $output .= '<h4>';
                $output .= mmi_opts_get( 'tag-title' );
            $output .= '</h4>';
        } else {
            $output .= '<h4>' . __( 'Popular Tags', 'massload' ) . '</h4>';
        }

        $tag_args = array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => $hide_empty
        );

        if ( true === $related_tags ) {
            $tag_args[ 'meta_query' ] = array(
                array(  
                   'key'       => 'page_type',
                   'value'     => $post_type,
                   'compare'   => '='
                )
            );
        }

        $tags = get_terms( $tag_args );

        if ( 
            is_singular( $post_type ) && true === $is_singular ||
            true === $is_singular
        ) {
            $tags = get_the_terms( $object_id, $taxonomy );
        }

        if ( is_singular( $post_type ) ) {
            $active_tags = get_the_terms( $object_id, $taxonomy );

            if ( ! empty( $active_tags ) && is_array( $active_tags ) ) {
                $active_tags = wp_list_pluck( $active_tags, 'term_id' );
            }
        }
        
        $output .= '<ul>';
            if ( ! empty( $tags ) ) {
                foreach ( $tags as $tag ) {
                    $tag_link  = get_tag_link( $tag->term_id );
                    $tag_class = 'tag-item '; 

                    if ( is_array( $active_tags ) ) {
                        if ( in_array( $tag->term_id, $active_tags ) ) {
                            $tag_class .= 'active';
                        }
                    }

                    $output .= '<li class="' . esc_attr( $tag_class ) . '">';
                        $output .= '<a href="' . esc_attr( $tag_link ) . '" title="' . esc_attr( $tag->name ) . ' Tag" class="' . esc_attr( $tag->slug ) . '">';
                            $output .= esc_html( $tag->name );
                        $output .= '</a>';
                    $output .= '</li>';
                }
            }
        $output .= '</ul>';

    $output .= '</div>';
        
    if ( ! empty( $tags ) ) {
        echo $output; 
    }
}