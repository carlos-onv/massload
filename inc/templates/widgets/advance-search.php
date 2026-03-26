<?php



function core_adv_search_widget( $filter_args = array() ) { 
    $default_filter_args = array(
        'title'               => __( 'Search', 'massload' ),
        'set_title'           => true,
        'placeholder'         => __( 'KEYWORD', 'massload' ),
        'set_post_type'       => true,
        'post_type'           => array( 'posts' ),
        'set_taxonomy'        => true,
        'taxonomy'            => 'category',
        'set_terms'           => true,
        'tax_terms'           => '',
        'search_type'         => '',
        'set_search_type'     => false,
        'wp_search'           => false,
        'ajax'                => true,
        'use_fields'          => array( 'all' ),
        'redirect_slug'       => '',
        'option_default_text' => __( 'SEARCH BY CATEGORY', 'massload' ),
    );
    $filter_args = array_merge( $default_filter_args, $filter_args );
    extract( $filter_args );
    
    $f_search      = filter_input(
        INPUT_GET,
        'search',
        FILTER_SANITIZE_STRING
    );
    $f_post_type   = filter_input(
        INPUT_GET,
        'posttype',
        FILTER_SANITIZE_STRING
    );
    $f_taxonomy    = filter_input(
        INPUT_GET,
        'tax',
        FILTER_SANITIZE_STRING
    );
    $f_term        = filter_input(
        INPUT_GET,
        'term',
        FILTER_SANITIZE_STRING
    );
    // $f_term = intval( $f_term );

    $search_name = 's';

    if ( false === $wp_search ) {
        $search_name = 'search';
    }

    // if ( false !== strpos( $post_type, ',' ) ) {
    //     $post_type = im( ',', $post_type );
    // }
    // if ( false !== strpos( $tax_terms, ',' ) ) {
    //     $tax_terms = explode( ',', $tax_terms );
    // }

    // if ( false !== strpos( $f_post_type, ',' ) ) {
    //     $f_post_type = explode( ',', $f_post_type );
    // }
    // if ( false !== strpos( $f_term, ',' ) ) {
    //     $f_term = explode( ',', $f_term );
    // }

    if ( $ajax ) {
        echo '<div class="core-adv-search search-widget widget ajax-enabled post-object-search">';
    } else {
        echo '<div class="core-adv-search search-widget widget">';
    }
 
        if ( $set_title ) {
            echo '<h4>' . esc_html( $title ) . '</h4>';
        }

        // Search Field
        if (
            in_array( 'all',    $use_fields ) ||
            in_array( 'search', $use_fields )
        ) {

            if ( ! empty( $redirect_slug ) ) {
                echo '<form action="' . esc_url( get_site_url() . '/' . $redirect_slug ) . '" method="get">';
            } else {
                echo '<form action="' . esc_url( get_site_url() ) . '" method="get">';
            }
                if ( ! empty( $f_search ) ) {
                    echo '<input type="text" name="' . esc_attr( $search_name ) . '" id="search-' . esc_attr( uniqid() ) . '" class="core-query-search" value="' . esc_attr( $f_search ) . '" placeholder="' . esc_attr( $placeholder ) . '" />';
                } else {
                    echo '<input type="text" name="' . esc_attr( $search_name ) . '" id="search-' . esc_attr( uniqid() ) . '" class="core-query-search" value="' . get_search_query() . '" placeholder="' . esc_attr( $placeholder ) . '" />';
                }

                echo '<button type="submit" id="searchsubmit" class="core-query-submit"></button>';

                if ( $set_post_type ) {
                    if ( ! empty( $f_post_type ) ) {
                        echo '<input type="hidden" class="core-query-posttype" name="posttype" value="' . esc_attr( $f_post_type ) . '">';
                    } else {
                        if ( is_array( $post_type ) ) {
                            echo '<input type="hidden" class="core-query-posttype" name="posttype" value="' . esc_attr( implode( ',', $post_type ) ) . '">';
                        } else {
                            echo '<input type="hidden" class="core-query-posttype" name="posttype" value="' . esc_attr( $post_type ) . '">';
                        }
                    }
                }

                if ( $set_taxonomy ) {
                    if ( ! empty( $f_taxonomy ) ) {
                        echo '<input type="hidden" class="core-query-tax" name="tax" value="' . esc_attr( $f_taxonomy ) . '">';
                    } else {
                        echo '<input type="hidden" class="core-query-tax" name="tax" value="' . esc_attr( $taxonomy ) . '">';
                    }
                }

                if ( $set_terms ) {
                    if ( ! empty( $f_term ) ) {
                        echo '<input type="hidden" class="core-query-term" name="term" value="' . esc_attr( $f_term ) . '">';
                    } else {
                        echo '<input type="hidden" class="core-query-term" name="term" value="' . esc_attr( $tax_terms ) . '">';
                    }
                }
                if ( $set_search_type ) {
                    echo '<input type="hidden" class="core-search-type" name="search_type" value="' . esc_attr( $search_type ) . '">';
                }

            echo '</form>';
        }

        // Taxonomy Term Dropdown
        if (
            in_array( 'all',    $use_fields ) ||
            in_array( 'select', $use_fields )
        ) {
            $terms    = get_terms(
                $taxonomy,
                array(
                    'orderby'    => 'name',
                    'hide_empty' => false
                )
            );

            $attr  = 'name="taxonomy-filter"';

            if ( $ajax ) {
                $attr .= 'class="core_select2 ajax-enabled post-object-filter"';
            } else {
                $attr .= 'class="core_select2"';
            }

            $attr .= 'data-post-type="' . $post_type . '"';
            $attr .= 'data-taxonomy="' . $taxonomy . '"';
            $attr .= 'data-term=""';

            if ( $terms && !is_wp_error( $terms ) ) {
                echo '<div class="core-taxonomy-dropdown core-widget-select">';
                    echo '<select ' . $attr . '>';
                        echo '<option>' . esc_html( $option_default_text ) . '</option>';
                        foreach ( $terms as $term ) {
                            if ( ! empty( $f_term ) ) {
                                if ( $f_term === $term->term_id ) {
                                    echo '<option selected value="' . esc_attr( $term->term_id ) . '">';
                                        echo esc_html( $term->name );
                                    echo '</option>';
                                } else {
                                    echo '<option value="' . esc_attr( $term->term_id ) . '">';
                                        echo esc_html( $term->name );
                                    echo '</option>'; 
                                }
                            } else {
                                echo '<option value="' . esc_attr( $term->term_id ) . '">';
                                    echo esc_html( $term->name );
                                echo '</option>';
                            }
                        }
                    echo '</select>';
                    echo '<span class="toggle"><i class="fa fa-angle-down"></i></span>';
                echo '</div>';
            }
        }
        
        // Post Types Select Field
        if (
            in_array( 'all',    $use_fields ) ||
            in_array( 'post_type_filter', $use_fields )
        ) {
            echo '<div class="core-posttype-filter-dropdown core-widget-select">';
                echo '<select class="core_select2 ajax-enabled object-collection post-types-collection" data-current="">';
                    echo '<option value="">' . __( 'Select Filter By', 'massload' ) . '</option>';
                    foreach ( CORE_POST_TYPES as $core_post_type ) {
                        echo '<option value="' . esc_attr( $core_post_type ) . '">';
                            echo esc_html( core_cpt_label( $core_post_type ) );
                        echo '</option>';
                    }
                echo '</select>';
                echo '<span class="toggle"><i class="fa fa-angle-down"></i></span>';
            echo '</div>';

            echo '<div class="core-posttype-filter-dropdown core-widget-select">';
                echo '<select class="core_select2 ajax-enabled object-collection taxonomy-collection" data-current="">';
                    echo '<option value="">' . __( 'Select Filter By', 'massload' ) . '</option>';
                echo '</select>';
                echo '<span class="toggle"><i class="fa fa-angle-down"></i></span>';
            echo '</div>';

            echo '<div class="core-posttype-filter-dropdown core-widget-select">';
                echo '<select class="core_select2 ajax-enabled object-collection term-collection" data-current="">';
                    echo '<option value="">' . __( 'Select Filter By', 'massload' ) . '</option>';
                echo '</select>';
                echo '<span class="toggle"><i class="fa fa-angle-down"></i></span>';
            echo '</div>';
        }

    echo '</div>';
}