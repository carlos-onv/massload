<?php
/**
 * News custom meta fields.
 *
 * @package MM International
 * @author 
 * @link 
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */


function mmi_news_post_type() 
{
	$news_item_slug = mmi_opts_get( 'news-slug', 'news' );
	
	$labels = array(
		'name' 					=> __('News','mmi-opts'),
		'singular_name' 		=> __('News','mmi-opts'),
		'add_new' 				=> __('Add New','mmi-opts'),
		'add_new_item' 			=> __('Add New News','mmi-opts'),
		'edit_item' 			=> __('Edit News','mmi-opts'),
		'new_item' 				=> __('New News','mmi-opts'),
		'view_item' 			=> __('View News','mmi-opts'),
		'search_items' 			=> __('Search News','mmi-opts'),
		'not_found' 			=> __('No News found','mmi-opts'),
		'not_found_in_trash' 	=> __('No News found in Trash','mmi-opts'), 
		'parent_item_colon' 	=> ''
	  );
		
	$args = array(
		'labels' 				=> $labels,
		'menu_icon'				=> 'dashicons-businessman',
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true, 
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'rewrite' 				=> array( 'slug' => $news_item_slug, 'with_front'=>true ),
		'supports' 				=> array( 'title', 'thumbnail', 'editor' ),
	); 
	  
	register_post_type( 'news', $args );
	
	register_taxonomy( 'news-types', 'news', array(
		'hierarchical' 			=> true,
		'label' 				=>  __('News Categories','mmi-opts'),
		'singular_label' 		=>  __('News Category','mmi-opts'),
		'rewrite'				=> true,
		'query_var' 			=> true
	));
}
add_action( 'init', 'mmi_news_post_type' );


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function mmi_news_edit_columns($columns)
{
	$newcolumns = array(
		"cb" 					=> "<input type=\"checkbox\" />",
		"title" 				=> 'Title',
		"news_thumbnail" 		=> __('Thumbnail','mmi-opts'),		
		"news_types" 			=> __('Categories','mmi-opts'),		
	);
	$columns = array_merge($newcolumns, $columns);	
	
	return $columns;
}
add_filter("manage_edit-news_columns", "mmi_news_edit_columns");  


?>