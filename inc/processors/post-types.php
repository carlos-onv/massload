<?php

/**
 * Fetch all post types
 *
 * @param string $post_type
 * @param array $args
 * @return void
 */


function core_get_post_types( $post_type = '', $args = array() ) {
    global $wp_post_types;
    
    $post_types = '';

    $default_args = array(
        'show_in_menu' => true,
        '_builtin'     => false,
    );

    $args = array_merge( $default_args, $args );

    if ( empty( $post_types ) ) {
        $post_types = get_post_types( 
            $args,
            'objects'
        );

        return $post_types;
    }
    return;
}

/**
 * Fetch Post Type Label
 *
 * @param string $post_type
 * @param array  $args
 * @return void
 */
function core_cpt_label( $post_type = '', $args = array() ) {
    $object = array();
    $label  = '';
    
    if ( ! empty( $post_type ) ) {
        $object = core_get_post_types( $post_type, $args );
        $label  = wp_list_pluck( $object, 'label' );
        $label  = core_isset_array( $label, $post_type, '' );
    }
    
    return $label;
}

/**
 * Fetch Post Type Name
 *
 * @param string $post_type
 * @param array $args
 * @return void
 */
function core_cpt_name( $post_type = '', $args = array() ) {
    $object = array();
    $name   = '';
    
    if ( ! empty( $post_type ) ) {
        $object = core_get_post_types( $post_type, $args );
        $name  = wp_list_pluck( $object, 'name' );
        $name  = core_isset_array( $name, $post_type, '' );
    }
    
    return $name;
}

/**
 * Fetch Post Type Labels
 * 
 * @param string $post_type
 * @param string $label_name
 * @return void
 */
function core_cpt_labels( $post_type = '', $label_name = '', $args = array() ) {
    $object = array();
    $label  = '';
    
    /**
     * Acceptable $label_name keyword
     * 
     * name 
     * singular_name
     * add_new
     * add_new_item
     * edit_item
     * new_item
     * view_item
     * view_items
     * search_items
     * not_found
     * not_found_in_trash
     * parent_item_colon
     * all_items
     * archives
     * attributes
     * insert_into_item
     * uploaded_to_this_item
     * featured_image
     * set_featured_image
     * remove_featured_image
     * use_featured_image
     * filter_items_list
     * items_list_navigation
     * items_list
     * item_published
     * item_published_privately
     * item_reverted_to_draft
     * item_scheduled
     * item_updated
     * menu_name
     * name_admin_bar
     */
    if ( ! empty( $post_type ) && ! empty( $label_name ) ) {
        $object = core_get_post_types( $post_type, $args );
        $label  = wp_list_pluck( $object, 'labels' );
        $label  = wp_list_pluck( $label, $label_name );
        $label  = core_isset_array( $label, $post_type, '' );
    }
    
    return $label;
}


function core_get_related_tags_posts( $args = array() ) {
    $default_args = array(
        'post_id'          => '',
        'post_type'        => '',
        'post_parent'      => '',
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'order'            => 'ASC',
        'suppress_filters' => false,
        'echo'             => false,
        'return_count'     => false,
        'return'           => 'id' // object, id, post_title
    );
    $args = array_merge( $default_args, $args );
    extract( $args );
    
    $output       = '';
    $taxonomy     = 'related_tags';
    $terms        = array();
    $args         = array();
    $product_list = array();
    $the_query    = array();

    if ( empty( $post_id ) ) {
        $post_id = get_the_ID();
    }

    // $terms = core_get_post_terms( $post_id, $taxonomy );
    $terms = get_field( $post_type . '_' . $taxonomy );

    if ( ! empty( $post_type ) ) {
        $args  = array(
            'post_type'      => $post_type,
            'posts_per_page' => $posts_per_page,
            'order'          => 'ASC',
            'orderby'        => 'title',
            'tax_query'      => array(
                array(
                    'taxonomy'         => $taxonomy,
                    'field'            => 'id',
                    'terms'            => $terms,
                    'operator'         => 'IN',
                    'include_children' => false
                )
            )
        );

        if ( 'products' === $post_type ) {

            $product_list = get_field( 'products_list', $post_id );

            $args  = array(
                'post_type'      => $post_type,
                'posts_per_page' => $posts_per_page,
                'order'          => 'ASC',
                'orderby'        => 'post__in',
                'post__in'       => $product_list,
            );
        }

        if ( 
            ! empty( $product_list ) && 'products' === $post_type ||
            'products' !== $post_type
        ) {
            
            $the_query = new WP_Query( $args );

            if ( $return_count ) {
                return $the_query->post_count;
            }

            ob_start();

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

            $output .= ob_get_clean();
        }
    }

    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
}