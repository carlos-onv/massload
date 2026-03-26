<?php
/**
 * Fetch the Parent of a post.
 *
 * @param array $args   The arguments needed for the WP_Query
 *
 * @since 1.0.0
 *
 * @return string $output Contains the mark-up for the post Parent UI
 *
 */


function core_get_post_parent( $args = array() ) {
    $parent_id          = '';
    $parent_title       = '';
    $parent_collections = array();
    $default_args = array(
        'post_type'        => '',
        'post_parent'      => 0,
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'order'            => 'ASC',
        'parent_post__in'  => false,
        'return'           => 'id',   // object, id, post_title
        'return_format'    => 'array', // string or array
        'suppress_filters' => false
    );
    $args = array_merge( $default_args, $args );
    extract( $args );

    if ( false === $parent_post__in ) {
        $args[ 'post_parent' ] = 0;
    } else {
        unset( $args[ 'post_parent' ] );
    }

    if (
        ! empty( $post_type ) &&
        0 === $post_parent    ||
        true === $parent_post__in
    ) {
        $parents = get_posts( $args );

        if ( $parents ) {
            if ( 'object' === $return ) {
                $parent_collections = $parents;
            }
    
            foreach ( $parents as $parent ) {
                
                if ( $parent_post__in ) {
                    $parent_id    = $parent->post_parent;
                    $parent_title = get_the_title( $parent_id );
                }

                if ( 'id' === $return ) {

                    if ( $parent_post__in ) {
                        $parent_collections[ $parent_id ] = $parent_id;
                    } else {
                        $parent_collections[ $parent->ID ] = $parent->ID;
                    }
                }
                if ( 'post_title' === $return ) {
                    if ( $parent_post__in ) {
                        $parent_collections[ $parent_id ] = $parent_title;
                    } else {
                        $parent_collections[ $parent->ID ] = $parent->post_title;
                    }
                }
            }

            if ( 'string' === $return_format ) {
                $parent_collections = implode( ',', $parent_collections );
            }
        }
    }

    return $parent_collections;
}

/**
 * Fetch the children of a post.
 *
 * @param array $args   The arguments needed for the WP_Query
 *
 * @since 1.0.0
 *
 * @return string $output Contains the mark-up for the post children UI
 *
 */
function core_get_post_children( $args = array() ) {
    $child_collections = array();
    $default_args = array(
        'post_type'        => '',
        'post_parent'      => '',
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'order'            => 'ASC',
        'suppress_filters' => false,
        'return'           => 'id' // object, id, post_title
    );
    $args = array_merge( $default_args, $args );
    extract( $args );

    if ( 
        ! empty( $post_type ) &&
        ! empty( $post_parent )
    ) {
        $children = get_children( $args );

        if ( 'object' === $return ) {
            $child_collections = $children;
        }
        if ( 'id' === $return ) {
            if ( $children ) {
                foreach ( $children as $child ) {
                    $child_collections[ $child->ID ] = $child->ID; 
                }
            }
        }
        if ( 'post_title' === $return ) {
            if ( $children ) {
                foreach ( $children as $child ) {
                    $child_collections[ $child->ID ] = $child->post_title; 
                }
            }
        }
    }

    return $child_collections;
}

function core_get_post_list_ui( $args = array() ) {
    global $wpdb, $post;

    $lang          = filter_input(
		INPUT_GET,
		'lang',
		FILTER_DEFAULT
    );

    $output        = '';
    $sql           = '';
    $db            = $wpdb->prefix;

    $levels        = array(
        'parent',
        'child',
        'grandchild',
    );
    $wrapper_class = '';

    $root_id       = '';
    $root_title    = '';
    $root_link     = '';

    $parent_id     = '';
    $parent_title  = '';
    $parent_link   = '';

    $child_id      = '';
    $child_title   = '';
    $child_link    = '';

    $default_args = array(
        'post_type'        => '',
        'post_parent'      => 0,
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'order'            => 'ASC',
        'orderby'          => 'post_title',
        'suppress_filters' => false,
        'echo'             => false,
        'root_slug'        => '',
        'root_url'         => '',
        'root_title'       => '',
        'root_slug_list'   => array(),
        'level'            => 'parent',
        'get_level'        => array(
            'parent',
            'child',
            'grandchild'
        )
    );
    $args = array_merge( $default_args, $args );
    extract( $args );

    if ( ! in_array( $level, $levels ) ) {
        $level = 'parent';
    }

    if ( empty( $lang ) ) {
        $lang = 'en';
    }
    
    if ( ! empty( $post_type ) ) {
        $wrapper_class .= $post_type . ' ';
    }

    switch( $level ) {
        case 'parent':
            $wrapper_class .= 'parents ';
        break;
        case 'child':
            $wrapper_class .= 'children ';
            unset( $args[ 'post_parent' ] );
        break;
        case 'grandchild':
            $wrapper_class .= 'grandchildren ';
            unset( $args[ 'post_parent' ] );
        break;
    }
            

    $parent_query = core_wp_query( $args );

    ob_start();

        if ( 'parent' === $level ) {
            $output .= '<div class="core-post-hierarchical">';
        }
                // $output .= '<ul class="core-post-list ' . esc_attr( $wrapper_class ) . '">';
                //     // The Loop
                //     if ( $parent_query->have_posts() ) :
                //         while ( $parent_query->have_posts() ) : $parent_query->the_post();
                //             $parent_id    = get_the_ID();
                //             $parent_title = get_the_title( $parent_id );
                //             $parent_link  = get_the_permalink( $parent_id );
                            
                //             $output .= '<li class="list-item ' . esc_attr( $level ) . ' ' . esc_attr( $level . '-' . $parent_id ) . '">';
                //                 $output .= '<a href="' . esc_url( $parent_link ) . '" class="item-link">';
                //                     $output .= esc_html( $parent_title );
                //                 $output .= '</a>';

                //                 if ( ! empty( $parent_id ) ) {
                //                     $product_args = array(
                //                         'post_type'   => $post_type,
                //                         'post_parent' => $parent_id,
                //                         'level'       => 'child'
                //                     );
                //                     $output .= core_get_post_list_ui( $product_args );
                //                 }

                //             $output .= '</li>';

                //         endwhile;
                //     endif;
                // $output .= '</ul>';
                
                if ( 
                    ! empty( $root_slug ) ||
                    ! empty( $root_url ) 
                ) {
                    if ( ! empty( $root_slug ) ) {
                        $root_id = get_page_by_path( $root_slug );

                        if ( ! empty( $root_id ) ) {
                            $object_type = get_post_type( $root_id );
                            $root_id     = $root_id->ID;

                            if ( ! empty( $root_id ) ) {
                                $object_id = core_icl_object_id( $root_id, $object_type );
                                
                                if ( empty( $object_id ) ) {
                                    $object_id = $root_id;
                                }
                                
                                $root_id = $object_id;
                            }

                            $root_link  = get_the_permalink( $root_id );

                            if ( empty( $root_title ) ) {
                                $root_title = get_the_title( $root_id );
                            }
                        }
                    }
                    
                    if ( ! empty( $root_url ) ) {
                        $root_link = $root_url;
                    }

                    if ( 
                        ! empty( $root_link ) &&
                        ! empty( $root_title ) 
                    ) {

                        $wrapper_class .= core_text_to_attr( $root_title );

                        $output .= '<div class="core-root-page">';
                            $output .= '<h4 class="core-root-title">';
                                $output .= '<a href="' . esc_url( $root_link ) . '" class="core-root-link">';
                                    $output .= esc_html( $root_title );
                                $output .= '</a>';
                            $output .= '</h4>';
                        $output .= '</div>';
                    }
                }

                if ( ! empty( $root_slug_list ) ) {
                    $output .= '<ul class="core-post-list ' . esc_attr( $wrapper_class ) . '">';
                        foreach ( $root_slug_list as $slug => $item_attr ) {

                            $item_id    = core_isset_array( $item_attr, 'id', '' );
                            $item_title = core_isset_array( $item_attr, 'title', '' );
                            $item_slug  = core_isset_array( $item_attr, 'slug', '' );
                            $item_url   = core_isset_array( $item_attr, 'url', '' );
                            $post_id    = get_page_by_path( $item_slug );
                            
                            if ( 
                                ! empty( $post_id ) &&
                                ! empty( $item_slug ) ||
                                ! empty( $item_url )
                            ) {
                                $post_id    = $post_id->ID;
                                $object_type = get_post_type( $post_id );
    
                                if ( ! empty( $post_id ) ) {
                                    $object_id = core_icl_object_id( $post_id, $object_type );
                                    
                                    if ( empty( $object_id ) ) {
                                        $object_id = $post_id;
                                    }
                                    
                                    $post_id = $object_id;
                                }

                                $post_title = $item_title;
                                $post_link  = get_the_permalink( $post_id );

                                if ( empty( $item_title ) ) {
                                    $post_title = get_the_title( $post_id );
                                }

                                if ( ! empty( $item_url ) ) {
                                    $post_link = $item_url;
                                }

                                if ( ! empty( $item_id ) ) {

                                    if (  false !== strpos( $item_id, '#' ) ) {
                                        $post_link = $post_link . $item_id;
                                    } else {
                                        $post_link = $post_link . '#' . $item_id;
                                    }
                                }

                                $output .= '<li class="list-item parent-' . esc_attr( $post_id ) . '">';
                                    $output .= '<a href="' . esc_url( $post_link ) . '" class="item-link">';
                                        $output .= esc_html( $post_title );
                                    $output .= '</a>';
                                $output .= '</li>';
                            }
                        }
                    $output .= '</ul>';
                } else {
                    $sql = "
                        SELECT p.ID 
                        FROM {$db}posts p
                        LEFT JOIN {$db}icl_translations t ON t.element_id = p.ID
                        WHERE p.post_parent='{$post_parent}'
                            AND p.post_type='{$post_type}'
                            AND p.post_status='{$post_status}'
                            AND t.language_code = '{$lang}'
                        ORDER BY `{$orderby}` ASC
                    ";
                
                    $parents = $wpdb->get_results( $sql );

                    if ( ! empty( $parents ) ) {
                        $output .= '<ul class="core-post-list ' . esc_attr( $wrapper_class ) . '">';
                            foreach ( $parents as $parent ) {
                                $parent_id    = $parent->ID;
                                $parent_title = get_the_title( $parent_id );
                                $parent_link  = get_the_permalink( $parent_id );


                                $output .= '<li class="list-item ' . esc_attr( $level ) . ' ' . esc_attr( $level . '-' . $parent_id ) . '">';
                                    $output .= '<a href="' . esc_url( $parent_link ) . '" class="item-link">';
                                        $output .= esc_html( $parent_title );
                                    $output .= '</a>';

                                    if ( 
                                        in_array( 'child', $get_level ) ||
                                        in_array( 'grandchild', $get_level )
                                    ) {
                                        $children_args = array(
                                            'post_type'   => $post_type,
                                            'post_parent' => $parent_id,
                                            'level'       => 'child'
                                        );
                                        $output .= core_get_post_list_ui( $children_args );
                                    }

                                $output .= '</li>';
                            }
                        $output .= '</ul>';
                    }
                }

        if ( 'parent' === $level ) {
            $output .= '</div>';
        }

    $output .= ob_get_clean();

    // Reset Post Data
    wp_reset_postdata();
    
    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
}