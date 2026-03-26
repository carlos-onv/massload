<?php
  function core_get_archive_link( $post_type ) {
    global $wp_post_types;
    $archive_link = false;

    if ( isset( $wp_post_types[ $post_type ] ) ) {
      $wp_post_type = $wp_post_types[ $post_type ];

      if ( $wp_post_type->publicly_queryable ) {

        if ( 
            $wp_post_type->has_archive && 
            $wp_post_type->has_archive !== true 
        ) {

            $slug = $wp_post_type->has_archive;

        } elseif ( 
            isset( $wp_post_type->rewrite[ 'slug' ] ) 
        ) {

            $slug = $wp_post_type->rewrite['slug'];
            
        } else {

            $slug = $post_type;

        }

      }

      $archive_link = get_option( 'siteurl' ) . "/{$slug}/";
    }
    return apply_filters( 'core_archive_link', $archive_link, $post_type );
  }