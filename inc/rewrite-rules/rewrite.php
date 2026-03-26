<?php
// Allows pagination in Resources Archive


function core_rewrite_rules() {
    
    // Resources Post Type
    add_rewrite_rule(
        'resources/([0-9]{4})/?$',
        array(
            'year'      => '$matches[1]',
            'post_type' => 'resources',
        ),
        'top'
    );
}
add_action( 'init', 'core_rewrite_rules', 11, 0 );


/**
 * Date Archive Query Config
 *
 * @param [object] $wp_query
 * @return void
 */
function core_date_archive( &$wp_query ) {
    // Allows pagination in Date Archive
    if ( 
        $wp_query->is_date()  ||
        $wp_query->is_year()  ||
        $wp_query->is_month() ||
        $wp_query->is_day()
    ) {
        $wp_query->set( 'nopaging', true );
    }
}
add_action( 'pre_get_posts', 'core_date_archive' );