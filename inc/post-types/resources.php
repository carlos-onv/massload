<?php

add_action( 'init', 'massload_resources_cpt' );



function massload_resources_cpt() {

    $args = array(

        'labels' => array(

            'name'     => __( 'Resources' ),

            'singular' => __( 'Resource' )

        ),

        'public'      => true,

        'menu_icon'   => 'dashicons-products',

        'has_archive' => false,

        'supports'    => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )

    );
    
    register_post_type( 'resources', $args );

}

add_action( 'init', 'massload_resources_taxonomies' );

function massload_resources_taxonomies() {

    register_taxonomy(

        'resources_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).

        'resources',             // post type name

        array(

            'hierarchical' => true,

            'label' => __( 'Categories', 'massload' ), // display name

            'query_var' => true,

            'rewrite' => array(

                'slug' => 'resources-category',    // This controls the base slug that will display before each term

                'with_front' => false  // Don't display the category base before

            )

        )

    );

    register_taxonomy(

        'resources_tags',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).

        'resources',             // post type name

        array(

            'hierarchical' => true,

            'label' => __( 'Tags', 'massload' ), // display name

            'query_var' => true,

            'rewrite' => array(

                'slug' => 'resources-tag',    // This controls the base slug that will display before each term

                'with_front' => false  // Don't display the category base before

            )

        )

    );

}