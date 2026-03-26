<?php
// Force WP to load the date.php file instead of 404.php file
// if date archive is empty


function core_date_404_template( $template = '' ){
    global $wp_query;
    
    if ( 
        isset( $wp_query->query[ 'year' ]     ) || 
        isset( $wp_query->query[ 'monthnum' ] ) || 
        isset( $wp_query->query[ 'day' ]      )
    ) {
        $template = locate_template( 'date.php', false );
    }
    return $template;
}
// add_filter( '404_template', 'core_date_404_template' );
