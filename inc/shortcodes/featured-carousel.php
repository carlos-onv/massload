<?php

/**
 * Featured Carousel Shortcode
 *
 * @link       https://wowfactormedia.ca/
 * @since      1.0.0
 *
 * @package    Massload
 * @subpackage inc/shortcodes
 */


if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Events and Promotions Shortcode.
 *
 * This class defines all code necessary initialize for Events and Promotions shortcode.
 *
 * @since      1.0.0
 * @package    Massload
 * @subpackage inc/shortcodes
 * @author     Wow Factor Media <info@wowfactormedia.ca>
 */



class Core_Featured_Carousel_Shortcode {


	protected $shortcode_name = 'core_featured_carousel';

	/**
	 * Define the core functionality of the shortcode.
	 *
     * Registers the shortcode and hooks the Class methods for this shortcode.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        add_shortcode( 'core_featured_carousel', array( $this, 'register_shortcode' ) );
        add_action( 'init', array( $this, 'register_shortcode' ) );
	}

    /**
	 * Registers the shortcode.
	 *
	 * @since    1.0.0
	 */
    public function register_shortcode( $atts ) {
        $atts = shortcode_atts(
			array(
				'main_title' => 'Featured Resources',
				'display'    => 'all',
				'ids'   	 => ''
			),
            $atts,
            'core_featured_carousel'
		);
		return $this->display( $atts );
    }

    /**
	 * Displays the shortcode.
	 *
	 * @since    1.0.0
	 */
    public function display( $atts, $content = null ) {
		extract( $atts );

		$output 		 = '';
		$id      		 = get_queried_object_id();
		$results 		 = array();
		$query_args      = array();
		$post_types      = array();
		$set_list        = array();

		$allowed_display = array(
			'resources'
		);

		if ( ! in_array( $display, $allowed_display ) ) {
			$display = 'all';
		}

		if ( ! empty( $ids ) ) {
			$ids = explode( ', ', $ids );
		} else {
			$ids = array();
		}

		if ( ! empty ( $display ) ) {
			switch ( $display ) {
				case 'resources':
					$post_types = 'resources';
				break;
			}
		}

		$query_args = array(
			'post_type'        => $post_types,
			'status'           => 'publish',
			'posts_per_page'   => -1,
			'order'            => 'ASC',
			// 'orderby' => 'date',
			'suppress_filters' => false,
			'orderby'          => array(
				'type'  => 'DESC',
				'title' => 'ASC'
			),
		);

		if ( ! empty( $ids ) ) {
			$query_args['post__in'] = $ids;
			$query_args['orderby']  = 'post__in';
		} else {

			if ( function_exists( 'get_field' ) ) {
				$set_list = get_field( "featured_post", $id );

				$query_args['post__in'] = $set_list;
				$query_args['orderby']  = 'post__in';
			}
		}

		$count   = 0;
		$results = core_wp_query( $query_args );

		if ( $results->have_posts() ) :
			ob_start();
				$output .= '<div class="core-featured-carousel">';
                    $output .= '<h3 class="core-featured-title">' . $main_title . '</h3>';
                    
                    $output .= '<div class="core-featured-items core-carousel owl-carousel owl-theme">';
                        while ( $results->have_posts() ) : $results->the_post();

                            $post_id      = get_the_ID();
                            $post_title   = get_the_title( $post_id );
							$post_link    = get_the_permalink( $post_id );
							$post_content = get_the_content( $post_id );
                            $post_image   = get_the_post_thumbnail_url( $post_id, 'full' );
                            $post_date    = get_the_date( 'F j, Y', $post_id );

                            $output .= '<div class="row core-featured-item item item-' . esc_attr( $post_id ) . '">';
                                $output .= '<div class="col-md-6 app_case_image image ">';
                                    $output .= '<a href="' . esc_url( $post_link ). '" class="image-link">';
                                        $output .= '<img src="' . esc_url( $post_image ) . '">';
                                        $output .= '<span class="post-date">' . esc_html( $post_date ) . '</span>';
                                    $output .= '</a>';
                                $output .= '</div>';

                                $output .= '<div class="col-md-6 info">';

                                    $output .= '<h4 class="item-title">';
                                        $output .= '<a href="' . esc_url( $post_link ). '">';
                                            $output .= esc_html( $post_title );
                                        $output .= '</a>';
                                    $output .= '</h4>';

                                    $output .= core_get_excerpt(
                                        $post_id,       // Post ID
                                        $post_content,  // Post Content
                                        true,           // Enable Read More Link
                                        true,           // Enable Ellipsis
                                        22,             // Number of Words to display
                                        '... '          // Ellipsis text
                                    );

                                $output .= '</div>';
                            
                            $output .= '</div>';

                        endwhile;
                    $output .= '</div>';
                    
				$output .= '</div>';
				wp_reset_postdata();
			$output .= ob_get_clean();
		endif;

    	return $output;
    }

}

new Core_Featured_Carousel_Shortcode();
