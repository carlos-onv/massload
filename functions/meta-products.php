<?php
/**
 * Products custom meta fields.
 *
 * @package MM International
 * @author 
 * @link 
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */


function mmi_legacy_products_post_type() 
{
	$products_item_slug = mmi_opts_get( 'products-slug', 'legacy-products' );
	
	$labels = array(
		'name' 					=> __('Legacy Products','mmi-opts'),
		'singular_name' 		=> __('Legacy Products Item','mmi-opts'),
		'add_new' 				=> __('Add New','mmi-opts'),
		'add_new_item' 			=> __('Add New Item','mmi-opts'),
		'edit_item' 			=> __('Edit Item','mmi-opts'),
		'new_item' 				=> __('New Item','mmi-opts'),
		'view_item' 			=> __('View Item','mmi-opts'),
		'search_items' 			=> __('Search Legacy Products Items','mmi-opts'),
		'not_found' 			=> __('No items found','mmi-opts'),
		'not_found_in_trash' 	=> __('No items found in Trash','mmi-opts'), 
		'parent_item_colon' 	=> ''
	  );
		
	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true, 
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'rewrite' 				=> array( 'slug' => 'legacy-products', 'with_front'=>true ),
		'supports' 				=> array( 'editor', 'thumbnail', 'title'),
	); 
	  
	register_post_type( 'legacy-products', $args );
	
	register_taxonomy( 'legacy-products-types', 'legacy-products', array(
		'hierarchical' 			=> true,
		'label' 				=>  __('Legacy Products categories','mmi-opts'),
		'singular_label' 		=>  __('Legacy Products category','mmi-opts'),
		'rewrite'				=> true,
		'query_var' 			=> true
	));
}
add_action( 'init', 'mmi_legacy_products_post_type' );


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function mmi_products_edit_columns($columns)
{
	$newcolumns = array(
		"cb" 						=> "<input type=\"checkbox\" />",		
		"title" 					=> 'Title',
		"products_thumbnail" 		=> __('Thumbnail','mmi-opts'),
		"products_types" 			=> __('Categories','mmi-opts'),
	);
	$columns = array_merge($newcolumns, $columns);	
	
	return $columns;
}
add_filter("manage_edit-products_columns", "mmi_products_edit_columns");  


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
function mmi_products_custom_columns($column)
{
	global $post;
	switch ($column)
	{
		case "products_thumbnail":
			if ( has_post_thumbnail() ) { the_post_thumbnail('50x50'); }
			break;
		case "products_types":
			echo get_the_term_list($post->ID, 'products-types', '', ', ','');
			break;
		case "products_order":
			echo $post->menu_order;
			break;	
	}
}
add_action("manage_posts_custom_column",  "mmi_products_custom_columns"); 


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function mmi_products_save_data($post_id) {
	global $mmi_products_meta_box;
 
	// verify nonce
	if( key_exists( 'mmi_products_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['mmi_products_meta_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	} 
	
}
add_action('save_post', 'mmi_products_save_data');

?>