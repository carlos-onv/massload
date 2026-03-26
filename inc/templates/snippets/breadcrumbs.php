<?php


function core_breadcrumbs( $args = array() ) {
    global $post;

    $default_args = array(
        'echo'       => true,

        'set_parent' => false,
        'parent'     => array(
            'parent_data'    => '',
            'parent_data_by' => 'id', // ID, Title or Slug
            'parent_title'   => '',
            'parent_link'    => ''
        ),
        'archive'     => array(
            'title'   => '',
            'link'    => ''
        ),

    );

    $args = array_merge( $default_args, $args );
    extract( $args );

    $lang = filter_input(
		INPUT_GET,
		'lang',
		FILTER_DEFAULT
    );
    
    $output         = '';
    $object_id      = get_the_ID();
    $post_object    = get_post( $object_id );
    if(isset($post_object->post_parent))
    {
    $object_parent  = $post_object->post_parent;
    }
    else
    {
        $object_parent = "";
    }
    $title          = get_the_title();
    $post_type      = '';
    $wp_post_types  = array( 'post', 'page' );

    $archive_link       = '';
    $archive_title      = '';
    $archive_attr_title = '';
    $archive_attr_link  = '';

    $separator     = '/';
    $separator_ui  = '<li class="separator"> ' . esc_html( $separator ) . ' </li>';


    $ancestors      = array();
    $ancestor_title = '';
    $ancestor_link  = '';

    $time_format    = '';

    /**
     * Parent Args
     */ 
    $parent_data    = '';
    $parent_data_by = '';
    $parent_title   = '';
    $parent_link    = '';

    /**
     * Taxonomy Labels
     */
    $tax_labels = array();
    $tax_name   = '';

    if (
        ! empty( 
            get_query_var( 'taxonomy' ) 
        ) 
    ) {
        $tax_labels = get_taxonomy_labels( 
            get_taxonomy( 
                get_query_var( 'taxonomy' )
            ) 
        );
        $tax_name = $tax_labels->name;
    }

    if ( 0 !== $object_parent ) {
        $parent_title = get_the_title( $object_parent );
        $parent_link  = get_permalink( $object_parent );
    }

    if ( $set_parent ) {
        $parent_data_by = core_isset_array( $parent, 'parent_data_by', '' );
        $parent_data    = core_isset_array( $parent, 'parent_data', 'id' );

        if ( ! empty( $parent_data ) ) {
            switch ( $parent_data_by ) {

                case 'id':
                    $parent_title = get_the_title( $parent_data );
                    $parent_link  = get_permalink( $parent_data );
                break;

                case 'title':
                    $parent_title = get_the_title( get_page_by_title( $parent_data ) );
                    $parent_link  = get_permalink( get_page_by_title( $parent_data ) );
                break;
                
                case 'slug':
                    $parent_title = get_the_title( get_page_by_path( $parent_data ) );
                    $parent_link  = get_permalink( get_page_by_path( $parent_data ) );
                break;

            }

        } else {
            $parent_title = core_isset_array( $parent, 'parent_title', '' );
            $parent_link  = core_isset_array( $parent, 'parent_link', '' );
        }
    }
    
    ob_start();
        $output .= '<div class="core-breadcrumbs">';

            $output .= '<ul id="breadcrumbs">';
                if ( ! is_home() ) {
                    $output .= '<li>';
                        $output .= '<a href="' . esc_url( get_option( 'home' ) ) . '">';
                            $output .= __( 'Home', 'massload' );
                        $output .= '</a>';
                    $output .= '</li>';

                    $output .= $separator_ui;

                    if ( 
                        is_category() || 
                        is_singular() || 
                        is_single()
                    ) {
                        if ( is_category() ) {
                            $output .= '<li>';
                            $output .= get_the_category_list(' </li>' . $separator_ui . '<li> ');
                        }

                        if ( 
                            is_single() ||
                            is_singular()
                        ) {
                            $post_type = get_post_type();

                            if ( ! in_array( $post_type, $wp_post_types ) ) {
                                $archive_attr_title = core_isset_array( $archive, 'title', '' );
                                $archive_attr_link  = core_isset_array( $archive, 'link', '' );

                                if ( ! empty( $archive_attr_title ) ) {
                                    $archive_title = $archive_attr_title;
                                } else {
                                    $archive_title = core_cpt_label( $post_type );
                                }

                                if ( ! empty( $archive_attr_link ) ) {
                                    $archive_link = $archive_attr_link;
                                } else {
                                    $archive_link = core_get_archive_link( $post_type );                                    
                                }
                                
                                if ( 
                                    ! empty( $archive_title ) &&
                                    ! empty( $archive_link ) 
                                ) {
                                    $output .= '<li>';
                                        $output .= '<a href="' . esc_url( $archive_link ) . '">';
                                            $output .= esc_html( $archive_title );
                                        $output .= '</a>';
                                    $output .= '</li>';

                                    $output .= $separator_ui;
                                }
                            }

                            if ( 'post' === $post_type ) {

                                $posts_page_id    = get_option( 'page_for_posts' );
                                $posts_page       = get_page( $posts_page_id );
                                $posts_page_title = $posts_page->post_title;
                                $posts_page_url   = get_the_permalink( $posts_page_id );

                                if ( ! empty( $posts_page_id ) ) {
                                    $output .= '<li>';
                                        $output .= '<a href="' . esc_url( $posts_page_url ) . '">';
                                            $output .= $posts_page_title;
                                        $output .= '</a>';
                                    $output .= '</li>';

                                    $output .= $separator_ui;
                                }
                            }
                            
                            if ( 
                                ! empty( $parent_title ) && 
                                ! empty( $parent_link )
                            ) {
                                $output .= '<li>';
                                    $output .= '<a href="' . esc_url( $parent_link ) . '">';
                                        $output .= esc_html( $parent_title );
                                    $output .= '</a>';
                                $output .= '</li>';
                                $output .= $separator_ui;
                            }

                            $output .= '<li>';
                                $output .= esc_html( $title );
                            $output .= '</li>';
                        }
                    } elseif ( is_page() ) {
                        if (
                            $post->post_parent
                        ) {
                            $ancestors = get_post_ancestors( $post->ID );
                            
                            foreach ( $ancestors as $ancestor ) {
                                $ancestor_title = get_the_title( $ancestor );
                                $ancestor_link  = get_permalink( $ancestor );

                                $output .= '<li>';
                                    $output .= '<a href="' . esc_url( $ancestor_link ) . '" title="' . esc_attr( $ancestor_title ) . '">';
                                        $output .= esc_html( $ancestor_title );
                                    $output .= '</a>';
                                $output .= '</li>';

                                $output .= $separator_ui;
                            }

                            $output .= '<strong title="' . esc_attr( $title ) . '">';
                                $output .= esc_html( $title );
                            $output .='</strong>';
                        } else {
                            $output .= '<li>';
                                $output .='<strong>';
                                    $output .= esc_html( $title );
                                $output .= '</strong>';
                            $output .= '</li>';
                        }
                    }
                } elseif ( is_home() && ! is_front_page() ) {
                    $_post = get_queried_object();
                    $title = $_post->post_title;

                    $output .= '<li>';
                        $output .= '<a href="' . esc_url( get_option( 'home' ) ) . '">';
                            $output .= __( 'Home', 'massload' );
                        $output .= '</a>';
                    $output .= '</li>';

                    $output .= $separator_ui;

                    $output .= '<li>';
                        $output .= $title;
                    $output .= '</li>';

                } elseif ( is_tag() ) {
                    if ( ! empty( $tax_name ) ) {
                        $output .= '<li>';
                            $output .= $tax_name;
                        $output .= '</li>';

                        $output .= $separator_ui;
                    }

                    $output .= '<li>';
                        $output .= single_term_title( '', false );
                    $output .= '</li>';
                } elseif ( is_author() ) {
                    $output .= '<li>';
                        $output .= __( 'Author Archive ', 'massload' );
                    $output .= '</li>';
                } elseif ( 
                    isset( $_GET[ 'paged' ] ) && 
                    !empty($_GET[ 'paged' ] )
                ) {
                    $output .= '<li>';
                        $output .= __( 'Blog Archives ', 'massload' );
                    $output .= '</li>';
                } elseif ( is_search() ) {
                    $output .= '<li>';
                        $output .= __( 'Search Results ', 'massload' );
                    $output .= '</li>';
                }

            if ( 
                is_day()   ||
                is_month() ||
                is_year()
            ) {
                if ( is_day() ) {
                    $time_format = 'F j, Y';
                }
                elseif ( is_month() ) {
                    $time_format = 'F Y';
                }
                elseif ( is_year() ) {
                    $time_format = 'Y';
                }

                $output .= '<li>';
                    $output .= __( 'Archive', 'massload' );
                $output .= '</li>';

                $output .= $separator_ui;

                $output .= '<li>';
                    $output .= esc_html( 
                        get_the_time( $time_format ) 
                    );
                $output .= '</li>';
            }

                if ( is_tax() ) {
                    if ( ! empty( $tax_name ) ) {
                        $output .= '<li>';
                            $output .= $tax_name;
                        $output .= '</li>';

                        $output .= $separator_ui;
                    }

                    $output .= '<li>';
                        $output .= single_term_title( '', false );
                    $output .= '</li>';
                }

            $output .= '</ul>';
        $output .= '</div>';
        
    $output .= ob_get_clean();
    
    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
    return;
}