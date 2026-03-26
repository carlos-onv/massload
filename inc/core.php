<?php


function core_get_post_types_by_taxonomy( $tax = '' ) {
    global $wp_taxonomies;
    
    if ( ! empty( $tax ) ) {
        return ( isset( $wp_taxonomies[$tax] ) ) ? $wp_taxonomies[$tax]->object_type : array();
    }

    return;
}
/**
 * Gets the current URL of a page
 * 
 * @since    1.0.0
 * @link     https://www.php.net/parse_url
 * @var      int    $parse_url   Specify the component to use for the parse_url().
 */
function core_get_current_url( $parse_url = '' ) {

    $http_protocol = ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ? "https" : "http" );
    $current_url   = $http_protocol . '://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

    /**
     * Here are the allowed components
     * 
     * PHP_URL_SCHEME
     * PHP_URL_HOST
     * PHP_URL_PORT
     * PHP_URL_USER
     * PHP_URL_PASS
     * PHP_URL_PATH
     * PHP_URL_QUERY
     * PHP_URL_FRAGMENT
     */
    if ( ! empty( $parse_url ) ) {
        $current_url = parse_url( $current_url, $parse_url );
    }

    return $current_url;
}