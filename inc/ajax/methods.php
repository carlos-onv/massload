<?php

/**
 * Holds all the AJAX methods and data process of the theme.
 *
 * @link       https://wowfactormedia.ca/
 * @since      1.0.0
 *
 * @package    MassLoad
 * @subpackage MassLoad/Inc/AJAX
 * @category   MassLoad/Inc/AJAX/Core_Ajax_Handler
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 */

namespace Core\AJAX;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Holds all the AJAX methods and data process of the theme.
 *
 * @subpackage MassLoad/Inc/AJAX
 * @category   MassLoad/Inc/AJAX/Core_Ajax_Handler
 * @author     Wow Factor Media
 */
class Core_Ajax_Handler {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
    {
        return;
	}

    /**
	 * Handles the creation as draft of post.
	 *
	 * @since    1.0.0
	 */
    public function post_object_filter()
    {   
        $output           = '';
        $return_results   = array();

        $the_query        = '';
        $tax_query        = array();

        $status           = 403;
        $query_args       = array();
        $posts_per_page   = CORE_POST_PER_PAGE;

        $post_tax_output  = '';
        $taxonomy_list    = array();

        $get_terms        = array();
        $post_term_output = '';
        $term_list       = array();

        $handler          = filter_input(
            INPUT_POST,
            'handler',
            FILTER_DEFAULT
        );
        $handler_type     = filter_input(
            INPUT_POST,
            'handler_type',
            FILTER_DEFAULT
        );
        $ajaxurl          = filter_input(
            INPUT_POST,
            'ajaxurl',
            FILTER_DEFAULT
        );
        $site_url         = filter_input(
            INPUT_POST,
            'site_url',
            FILTER_DEFAULT
        );
        $page_slug        = filter_input(
            INPUT_POST,
            'page_slug',
            FILTER_DEFAULT
        );
        $url_path         = filter_input(
            INPUT_POST,
            'url_path',
            FILTER_DEFAULT
        );

        $search           = filter_input(
            INPUT_POST,
            'search',
            FILTER_DEFAULT
        );

        $post_id          = filter_input(
            INPUT_POST,
            'post_id',
            FILTER_SANITIZE_NUMBER_INT
        );

        $post_type        = filter_input(
            INPUT_POST,
            'post_type',
            FILTER_DEFAULT
        );

        $post_types       = filter_input(
            INPUT_POST,
            'post_types',
            FILTER_DEFAULT,
            FILTER_FORCE_ARRAY
        );

        $taxonomy         = filter_input(
            INPUT_POST,
            'taxonomy',
            FILTER_DEFAULT
        );

        $terms           = filter_input(
            INPUT_POST,
            'terms',
            FILTER_SANITIZE_NUMBER_INT
        );

        $paged           = filter_input(
            INPUT_POST,
            'paged',
            FILTER_SANITIZE_NUMBER_INT
        );

        $url_param       = filter_input(
            INPUT_POST,
            'url_param',
            FILTER_DEFAULT
        );


        $date_query      = filter_input(
            INPUT_POST,
            'date_query',
            FILTER_DEFAULT,
            FILTER_FORCE_ARRAY
        );

        if ( false !== strpos( $post_type, ',' ) ) {
            $post_type = explode( ',', $post_type );
        }
        if ( false !== strpos( $terms, ',' ) ) {
            $terms = explode( ',', $terms );
        }
        if ( false !== strpos( $post_type, ', ' ) ) {
            // $post_type = explode( ', ', $post_type );
        }

        if ( ! empty( $date_query ) ) {
            $date_query[ 'year' ]  = intval( $date_query[ 'year' ] );
            $date_query[ 'month' ] = intval( $date_query[ 'month' ] );
            $date_query[ 'day' ]   = intval( $date_query[ 'day' ] );
        }
        
        switch ( $handler_type ) {
            case "search":
                // $terms = filter_input(
                //     INPUT_POST,
                //     'terms',
                //     FILTER_SANITIZE_NUMBER_INT
                // );

                $tax_query = array(
                    array(
                        'taxonomy'         => $taxonomy,
                        'field'            => 'id',
                        'terms'            => $terms,
                        'operator'         => 'IN',
                        'include_children' => false
                    )
                );

                $query_args = array(
                    's'                => $search,
                    'posts_per_page'   => $posts_per_page,
                    'post_type'        => $post_type,
                    'order'            => 'ASC',
                    'orderby'          => 'date',
                    'suppress_filters' => false
                );

                if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
                    $query_args[ 'tax_query' ] = $tax_query;
                }

                if ( ! empty( $paged ) ) {
                    $query_args[ 'paged' ] = max( 1, $paged );
                }

            break;
            case "pagination":
                $terms = filter_input(
                    INPUT_POST,
                    'terms',
                    FILTER_SANITIZE_NUMBER_INT
                );

                $tax_query = array(
                    array(
                        'taxonomy'         => $taxonomy,
                        'field'            => 'id',
                        'terms'            => $terms,
                        'operator'         => 'IN',
                        'include_children' => false
                    )
                );

                $query_args = array(
                    's'                => $search,
                    'posts_per_page'   => $posts_per_page,
                    'post_type'        => $post_type,
                    'paged'            => max( 1, $paged ),
                    'order'            => 'ASC',
                    'orderby'          => 'date',
                    'suppress_filters' => false
                );

                // Change value for pagination config when set to 'post_tax_filter'
                if ( 'post_tax_filter' === $handler_type ) {

                }

                if ( ! empty( $post_types ) ) {
                    $query_args[ 'post_type' ] = $post_types;
                }
                if ( ! empty( $date_query ) ) {
                    
                    foreach ( $date_query as $date_index => $date ) {

                        if ( 0 === $date_query[ $date_index ][ 'month' ] ) {
                            unset( $date_query[ $date_index ][ 'month' ] );
                            unset( $date_query[ $date_index ][ 'day' ] );
                        }

                        if ( 0 === $date_query[ $date_index ][ 'day' ] ) {
                            unset( $date_query[ $date_index ][ 'day' ] );
                        }
                    }

                    $query_args[ 'date_query' ] = $date_query;
                }

                if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
                    $query_args[ 'tax_query' ] = $tax_query;
                }
                if ( ! empty( $paged ) ) {
                    $query_args[ 'paged' ] = intval( max( 1, $paged ) );
                }

            break;
            case "post_tax_filter":
                $terms = filter_input(
                    INPUT_POST,
                    'terms',
                    FILTER_SANITIZE_NUMBER_INT
                );

                if ( is_string( $terms ) ) {
                    if ( empty( $terms ) ) {
                        $terms = array();
                    } else {
                        $terms = array( $terms );
                    }
                }

                if ( '' !== $post_type && is_string( $post_type ) ) {
                    if ( empty( $post_type ) ) {
                        $post_types = CORE_POST_TYPES;
                    } else {
                        $post_types = $post_type;
                    }
                }

                if ( empty( $post_type ) ) {
                    $post_types = CORE_POST_TYPES;
                }

                $query_args = array(
                    'posts_per_page'   => $posts_per_page,
                    'post_type'        => $post_types,
                    'paged'            => max( 1, $paged ),
                    'order'            => 'ASC',
                    'orderby'          => 'date',
                    'suppress_filters' => false
                );
                
                if ( is_string( $post_types ) ) {
                    $taxonomy_list = core_get_taxonomies( array( $post_types ) );
                } else {
                    $taxonomy_list = core_get_taxonomies( $post_types );
                }
                
                $return_results[ 'post_types' ]  = $post_types;

                if ( ! empty( $taxonomy ) ) {
                    $term_list = core_get_terms( array( $taxonomy ) );
                }
                

                // Taxonomy Options
                $post_tax_output .= '<option value="">' . __( 'Select Filter By', 'massload' ) . '</option>';
                foreach ( $taxonomy_list as $tax_name => $tax_label ) {
                    if ( $tax_name === $taxonomy ) {
                        $post_tax_output .= '<option value="' . esc_attr( $tax_name ) . '" selected>';
                            $post_tax_output .= esc_html( $tax_label );
                        $post_tax_output .= '</option>';
                    } else {
                        $post_tax_output .= '<option value="' . esc_attr( $tax_name ) . '">';
                            $post_tax_output .= esc_html( $tax_label );
                        $post_tax_output .= '</option>';
                    }
                }


                // Term Options
                $post_term_output .= '<option value="">' . __( 'Select Filter By', 'massload' ) . '</option>';
                foreach ( $term_list as $term_id => $term_name ) {
                    if ( 
                        is_array( $terms ) && in_array( $term_id, $terms ) &&
                        ! empty( $post_type ) && ! empty( $taxonomy ) ||
                        false === is_array( $terms ) && $term_id === $terms &&
                        ! empty( $post_type ) && ! empty( $taxonomy )

                    ) {
                        $post_term_output .= '<option value="' . esc_attr( $term_id ) . '" selected>';
                            $post_term_output .= esc_html( $term_name );
                        $post_term_output .= '</option>';
                    } else {
                        $post_term_output .= '<option value="' . esc_attr( $term_id ) . '">';
                            $post_term_output .= esc_html( $term_name );
                        $post_term_output .= '</option>';
                    }
                }
                
                if ( 
                    ! empty( $taxonomy ) && empty( $terms )
                ) {
                    $get_terms = get_terms( $taxonomy ); 

                    $get_terms = wp_list_pluck( $get_terms, 'term_id' );

                    $tax_query = array(
                        array(
                            'taxonomy'         => $taxonomy,
                            'field'            => 'id',
                            'terms'            => $get_terms,
                            'operator'         => 'IN',
                            'include_children' => false
                        )
                    );
                    $query_args[ 'tax_query' ] = $tax_query;
                }
                
                if ( 
                    ! empty( $taxonomy ) && ! empty( $terms ) 
                ) {

                    $tax_query = array(
                        array(
                            'taxonomy'         => $taxonomy,
                            'field'            => 'id',
                            'terms'            => $terms,
                            'operator'         => 'IN',
                            'include_children' => false
                        )
                    );
                    $query_args[ 'tax_query' ] = $tax_query;
                }

                if ( ! empty( $date_query ) ) {
                    foreach ( $date_query as $date_index => $date ) {

                        if ( 0 === $date_query[ $date_index ][ 'month' ] ) {
                            unset( $date_query[ $date_index ][ 'month' ] );
                            unset( $date_query[ $date_index ][ 'day' ] );
                        }

                        if ( 0 === $date_query[ $date_index ][ 'day' ] ) {
                            unset( $date_query[ $date_index ][ 'day' ] );
                        }
                    }

                    // if ( 0 === $date_query[ 'month' ] ) {
                    //     unset( $date_query[ 'month' ] );
                    //     unset( $date_query[ 'day' ] );
                    // }

                    // if ( 0 === $date_query[ 'day' ] ) {
                    //     unset( $date_query[ 'day' ] );
                    // }
                    
                    $query_args[ 'date_query' ] = $date_query;
                }

                $return_results[ 'post_tax_filter' ]  = $post_tax_output;
                $return_results[ 'post_term_filter' ] = $post_term_output;
                $return_results[ 'taxonomy_list' ]    = $taxonomy_list;

            break;
            case "single_term":
                $terms = filter_input(
                    INPUT_POST,
                    'terms',
                    FILTER_SANITIZE_NUMBER_INT
                );

                $tax_query = array(
                    array(
                        'taxonomy'         => $taxonomy,
                        'field'            => 'id',
                        'terms'            => $terms,
                        'operator'         => 'IN',
                        'include_children' => false
                    )
                );

                $query_args = array(
                    'posts_per_page' => $posts_per_page,
                    'post_type'      => $post_type,
                    'order'          => 'ASC',
                    'orderby'        => 'date'
                );

                if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
                    $query_args[ 'tax_query' ] = $tax_query;
                }
              break;
            case "multi_term":
              break;
            default:
        }

        if ( ! empty( $query_args ) ) {

            $the_query = new \WP_Query( $query_args );

            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) : $the_query->the_post();
                    $post_id       = $post->ID;
                    $get_posttype  = get_post_type( $post_id );
                    $post_content  = $post->post_content;
                    $img_class     = '';
                    $post_image    = get_the_post_thumbnail_url( $post_id, 'full' );
                    $post_date     = get_the_date( 'F j, Y', $post_id );

                    if ( empty( $post_image ) ) {
                        $post_image = CORE_PLACEHOLDER_IMAGE;
                        $img_class  = 'placeholder-image';
                    }

                    $output .= '<div class="col-sm-6 ' . esc_attr( $get_posttype ) . '">';
                        $output .= '<div class="app_case_content_wrap">';
                            $output .= '<div class="app_case_content_inner">';
                                $output .= '<div class="app_case_image ' . esc_attr( $img_class ) . '">';
                                $output .= '<a href="' . get_the_permalink() . '" class="image-link">';
                                $output .= '<img src="' . esc_url( $post_image ) . '" class="img-fluid">';
                                    $output .= '<span class="post-date">' . esc_html( $post_date ) . '</span>';
                                    $output .= '</a>';
                                $output .= '</div>';
                                $output .= '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
                                $output .= '<p>';
                                    $output .=  core_get_excerpt(
                                            $post_id,       // Post ID
                                            $post_content,  // Post Content
                                            true,          // Enable Read More Link
                                            true,           // Enable Ellipsis
                                            22,             // Number of Words to display
                                            '... '          // Ellipsis text
                                        );
                                $output .= '</p>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';

                endwhile;
                    
                // Reset Post Data
                wp_reset_postdata();


                $return_results['status']     = 202;
                $return_results['result']     = $output;

                /**
                 * Pagination
                 */
                $paginate      = 999999999;
                $pagenum_link  = get_pagenum_link( $paginate );
                // $pagenum_link  = str_replace( $ajaxurl, $site_url . '/' . $page_slug, $pagenum_link );
                $pagenum_link  = str_replace( $ajaxurl, $url_path, $pagenum_link );

                $paginate_args = array(
                    'base'        => str_replace( $paginate, '%#%', $pagenum_link ),
                    'total'       => $the_query->max_num_pages,
                    'current'     => $paged,
                    'add_classes' => 'include-advance-search'
                );

                if ( ! empty( $url_param ) ) {
                    $paginate_args[ 'base' ]  = $paginate_args[ 'base' ] . '&' . $url_param;
                }

                $return_results[ 'pagination' ] = core_pagination( $paginate_args );
                
            } else {
                $return_results[ 'status' ]     = 404;
                $return_results[ 'result' ]     = $output;
                $return_results[ 'error' ]      = '<p>' . __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'massload' ) . '</p>';
           }
        }

        $return_results[ 'handler' ]      = $handler;
        $return_results[ 'handler_type' ] = $handler_type;
        $return_results[ 'post_type' ]    = $post_type;
        $return_results[ 'wp_query' ]     = $the_query;
        $return_results[ 'query_args' ]   = $query_args;

        echo wp_json_encode( $return_results );
    }
}