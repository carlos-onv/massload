<?php
add_action( 'init', 'massload_centralize_taxonomies' );



function massload_centralize_taxonomies() {

    $tax_post_types = array(
        'case_study',
        'applications',
        // 'products'
    );

    $tax_labels = array(
        'name'              => __( 'Related Tags', 'taxonomy general name', 'massload' ),
        'singular_name'     => __( 'Related Tag', 'taxonomy singular name', 'massload' ),
        'search_items'      => esc_html__( 'Search Tags', 'massload' ),
        'all_items'         => esc_html__( 'All Tags', 'massload' ),
        'parent_item'       => esc_html__( 'Parent Tag', 'massload' ),
        'parent_item_colon' => esc_html__( 'Parent Tag:', 'massload' ),
        'edit_item'         => esc_html__( 'Edit Tag', 'massload' ),
        'update_item'       => esc_html__( 'Update tag', 'massload' ),
        'add_new_item'      => esc_html__( 'Add New Tag', 'massload' ),
        'new_item_name'     => esc_html__( 'New Tag', 'massload' ),
        'menu_name'         => esc_html__( 'Related Tags', 'massload' ),
    );

    register_taxonomy(

        'related_tags',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).

        $tax_post_types,

        array(
            'hierarchical'      => true,
            'labels'            => $tax_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'meta_box_cb'       => false,
            'rewrite'           => array(
                'slug'       => 'related-tags', // This controls the base slug that will display before each term
                'with_front' => true          // Don't display the category base before
            )

        )

    );

}
