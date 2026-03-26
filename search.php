<?php
	/**
	 * The template for displaying search results pages
	 */
	global $wp_query;

	// $search_type = get_query_var( 'search_type' );
	$search_type = filter_input(
		INPUT_GET,
		'search_type',
		FILTER_DEFAULT
	);

	if ( empty( $search_type ) ) {
		$search_type = 'product_search';
	}

	get_header();
	
		echo '<main id="pagecontent" role="content">';
			echo '<div class="search-page pt-100 pb-100">';

				switch ( $search_type ) {

					case "product_search":
						echo get_template_part( 'components/search/product', 'search' );
					break;
					
					case "basic_search":
					default:
						echo get_template_part( 'components/search/basic', 'search' );
				}

			echo '</div>';

			echo '<div class="container pb-100">';
				$paginate_args = array(
					'total'       => $wp_query->max_num_pages,
					'add_classes' => 'include-advance-search',
					'ajax' 		  => false
				);
				echo core_pagination( $paginate_args );
			echo '</div>';
			
		echo '</main>'; // #main

	get_footer();