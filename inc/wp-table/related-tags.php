<?php
/**
 * Adds a column for the page_type display column to the Related Tags manage edit screen
 **/


function core_related_tags_columns( $columns ) {
    $posts_count = $columns[ 'posts' ];

    unset( $columns[ 'posts' ] );

    $columns[ 'page_type' ] = __( 'Page Type', 'massload' );
    $columns[ 'posts' ]     = __( 'Count', 'massload' );

	return $columns;
}
add_filter( 'manage_edit-related_tags_columns' , 'core_related_tags_columns' );

/**
 * Adds the value for Page Type display column for each page_type
 * to the Related Tags manage edit screen
 **/
function core_add_related_tags_column( $content, $column_name, $term_id ) {
    
    $taxonomy  = 'related_tags';
    $term      = get_term( $term_id, $taxonomy );
    $page_type = get_term_meta( $term_id, 'page_type', true );

    switch ( $column_name ) {
        case 'page_type':
            //do your stuff here with $term or $term_id
            $content = $page_type;
            break;
        default:
            break;
    }
    return $content;
}
add_filter( 'manage_related_tags_custom_column', 'core_add_related_tags_column', 10, 3 );

function core_register_related_tags_sortable( $columns ) {
    $columns[ 'page_type' ] = 'page_type';
    return $columns;
}
add_filter( 'manage_edit-related_tags_sortable_columns', 'core_register_related_tags_sortable' );
  
function core_sort_related_tags_by_page_type( $pieces, $taxonomies, $args ) {
    global $pagenow;

    if ( !is_admin() ) {
      return $pieces;
    }
  
    if( 
        is_admin() && 
        $pagenow       == 'edit-tags.php' && 
        $taxonomies[0] == 'issue' && 
        ( 
            ! isset( $_GET[ 'orderby' ] ) || 
            $_GET[ 'orderby' ] == 'issue_date'
        )
    ) {
      $pieces['join']   .= " INNER JOIN wp_options AS opt ON opt.option_name = concat('issue_',t.term_id,'_issue_date')";
      $pieces['orderby'] = "ORDER BY opt.option_value";
      $pieces['order']   = isset($_GET['order']) ? $_GET['order'] : "DESC";
    }
  
    return $pieces;
  }
//   add_filter( 'terms_clauses', 'core_sort_related_tags_by_page_type', 10, 3);
  