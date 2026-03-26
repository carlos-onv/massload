<?php



function core_adv_search_widget( $filter_args = array() ) { 
    $default_filter_args = array(
        'title'               => __( 'Search', 'massload' ),
        'post_type'           => 'posts',
        'taxonomy'            => 'category',
        'ajax'                => true,
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
        FILTER_SANITIZE_NUMBER_INT
    );
    $f_term = intval( $f_term );

    if ( $ajax ) {
        echo '<div class="core-adv-search search-widget widget ajax-enabled post-object-search">';
    } else {
        echo '<div class="core-adv-search search-widget widget">';
    }
 
        echo '<h4>' . esc_html( $title ) . '</h4>';
        if ( ! empty( $redirect_slug ) ) {
            echo '<form action="' . esc_url( get_site_url() . '/' . $redirect_slug ) . '" method="get">';
        } else {
            echo '<form action="' . esc_url( get_site_url() ) . '" method="get">';
        }
            if ( ! empty( $f_search ) ) {
                echo '<input type="text" name="search" id="search-' . esc_attr( uniqid() ) . '" class="core-query-search" value="' . esc_attr( $f_search ) . '" placeholder="KEYWORDS" />';
            } else {
                echo '<input type="text" name="search" id="search-' . esc_attr( uniqid() ) . '" class="core-query-search" value="' . get_search_query() . '" placeholder="KEYWORDS" />';
            }

            echo '<button type="submit" id="searchsubmit"></button>';

            if ( ! empty( $f_post_type ) ) {
                echo '<input type="hidden" class="core-query-posttype" name="posttype" value="' . esc_attr( $f_post_type ) . '">';
            } else {
                echo '<input type="hidden" class="core-query-posttype" name="posttype" value="' . esc_attr( $post_type ) . '">';
            }
            if ( ! empty( $f_taxonomy ) ) {
                echo '<input type="hidden" class="core-query-tax" name="tax" value="' . esc_attr( $f_taxonomy ) . '">';
            } else {
                echo '<input type="hidden" class="core-query-tax" name="tax" value="' . esc_attr( $taxonomy ) . '">';
            }
            if ( ! empty( $f_term ) ) {
                echo '<input type="hidden" class="core-query-term" name="term" value="' . esc_attr( $f_term ) . '">';
            } else {
                echo '<input type="hidden" class="core-query-term" name="term" value="">';
            }
        echo '</form>';

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
            echo '<div class="core-taxonomy-dropdown">';
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

    echo '</div>';
}