<?php
/**
 * Fetch Taxonomy Object
 *
 * @param array $post_type     Post type to set the query.
 * 
 * @param array $args           An array of key => value arguments to match against the taxonomy objects. 
 *                              Default value: array()
 * 
 * @param string $output        The type of output to return in the array. 
 *                              Accepts either taxonomy 'names' or 'objects'. 
 *                              Default value: 'object'
 * 
 * @param string $operator      The logical operation to perform. 
 *                              Accepts 'and' or 'or'. 'or' means only one element from the array needs to 
 *                              match; 'and' means all elements must match. 
 *                              Default value: 'and'
 * @return void
 */


function core_get_taxonomy_obj( $post_type = array(), $args = array(), $output = 'objects', $operator = 'and' ) {
    $default_args = array(
        'object_type'     => $post_type,
        'shared_taxonomy' => true
    );

    $args        = array_merge( $default_args, $args );
    extract( $args );

    if ( empty( $args[ 'object_type' ] ) ) {
        $args[ 'object_type' ] = $post_type;
    }

    $taxonomies  = get_taxonomies( $args, $output, $operator );
    if ( $shared_taxonomy ) {
        $taxonomies  = get_object_taxonomies( $post_type, $output ); 
    }

    return $taxonomies;
}

/**
 * Fetch Taxonomy Name and Label in Array Format
 *
 * @param  array $post_type
 * @param  array $args
 * @return array $taxonomy_list
 */
function core_get_taxonomies( $post_type = array(), $args = array() ) {
    $taxonomies     = array();
    $taxonomy_list  = array();
    
    if ( ! empty( $post_type ) ) {
        $taxonomies    = core_get_taxonomy_obj( $post_type, $args );
        $taxonomy_list = wp_list_pluck( $taxonomies, 'label', 'name' );
    }
    
    return $taxonomy_list;
}

/**
 * Fetch Taxonomy Names
 *
 * @param  array $post_type
 * @param  array $args
 * @return array $taxonomy_names
 */
function core_tax_names( $post_type = array(), $args = array() ) {
    $taxonomies      = array();
    $taxonomy_names  = array();
    
    if ( ! empty( $post_type ) ) {
        $taxonomies     = core_get_taxonomy_obj( $post_type, $args );
        $taxonomy_names = wp_list_pluck( $taxonomies, 'name' );
        $taxonomy_names = array_values( $taxonomy_names );
    }
    
    return $taxonomy_names;
}

/**
 * Fetch Taxonomy Labels
 *
 * @param  array $post_type
 * @param  array $args
 * @return array $taxonomy_names
 */
function core_tax_labels( $post_type = array(), $args = array() ) {
    $taxonomies      = array();
    $taxonomy_labels = array();
    
    if ( ! empty( $post_type ) ) {
        $taxonomies      = core_get_taxonomy_obj( $post_type, $args );
        $taxonomy_labels = wp_list_pluck( $taxonomies, 'label' );
        $taxonomy_labels = array_values( $taxonomy_labels );
    }
    
    return $taxonomy_labels;
}

/**
 * Gets all the assigned Post Type for a taxonomy.
 *
 * @param string $taxonomy      Taxonomy name
 * @return array $object_type   Array list of post type assigned to the taxonomy.
 */
function core_taxonomy_object_type( $taxonomy = '' ) {
    $taxonomy_obj = array();
    $object_type  = array();
    
    if ( ! empty( $taxonomy ) ) {
        $taxonomy_obj = get_taxonomy( $taxonomy );
        $object_type  = $taxonomy_obj->object_type;
    }

    return $object_type;
}