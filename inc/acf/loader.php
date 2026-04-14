<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {
    /**
     * Custom Post Types
     */

    // Resources Post Tyoe
    require get_template_directory() . '/inc/acf/post-types/resources.php';

    // Product Post Type
    require get_template_directory() . '/inc/acf/post-types/product.php';

    // Blog Post Type
    require get_template_directory() . '/inc/acf/post-types/blog-post.php';


    
    /**
     * Custom taxonomies
     */

    // Related Tags Taxonomy
    require get_template_directory() . '/inc/acf/taxonomies/related-tags.php';


    
    /**
     *  Page Templates
     */

    // Company & Values 
    // require get_template_directory() . '/inc/acf/page-templates/company-values.php';
}