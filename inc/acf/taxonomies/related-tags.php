<?php


function core_acf_related_tags_taxonomy() {

    $page_types = array(
        'applications' => 'Applications',
        'case_study'   => 'Case Study',
        // 'products'     => 'Products',
    );

    acf_add_local_field_group(array(
        'key'                   => 'core_acf_related_tags_taxonomy',
        'title'                 => 'Related Tags',
        'fields'                => array(
            array(
                'key'   => 'related_tags_page_type',
				'label' => 'Page Type',
                'name'  => 'page_type',
                'type'  => 'select',
                
                /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
                'choices' => $page_types,
                
                /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
                'allow_null' => 0,
                
                /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
                'multiple' => 0,
                
                /* (bool) Use the select2 interfacte. Defaults to 0 */
                'ui' => 1,
                
                /* (bool) Load choices via AJAX. The ui setting must also be true for this to work. Defaults to 0 */
                'ajax' => 1,
                
                /* (string) Appears within the select2 input. Defaults to '' */
                'placeholder' => 'Select Page Type',
                
            )
            // array(
            //     'key'               => 'related_tags_intro_title',
            //     'label'             => 'Tag Intro Title',
            //     'name'              => 'tag_intro_title',
            //     'type'              => 'text',
            //     'instructions'      => 'Type the Into Title for this tag',
            //     'required'          => 0,
            //     'conditional_logic' => 0,
            //     'wrapper'           => array(
            //         'width' => '',
            //         'class' => '',
            //         'id'    => '',
            //     ),
            //     'default_value'     => '',
            //     'tabs'              => 'all',
            //     'toolbar'           => 'Basic',
            //     'media_upload'      => 1,
            //     'delay'             => 0,
            // ),
            // array(
            //     'key'               => 'related_tags_intro',
            //     'label'             => 'Tag Intro',
            //     'name'              => 'tag_intro',
            //     'type'              => 'textarea',
            //     'instructions'      => 'Type the Intro Description for this tag',
            //     'required'          => 0,
            //     'conditional_logic' => 0,
            //     'wrapper'           => array(
            //         'width' => '',
            //         'class' => '',
            //         'id'    => '',
            //     ),
            //     'default_value'     => '',
            //     'tabs'              => 'all',
            //     'toolbar'           => 'Basic',
            //     'media_upload'      => 1,
            //     'delay'             => 0,
            // ),
            // array(
            //     'key'               => 'related_tags_feat_image',
            //     'label'             => 'Featured Image',
            //     'name'              => 'featured_image',
            //     'type'              => 'image',
            //     'instructions'      => 'Select the featured image for this tag',
            //     'required'          => 0,
            //     'conditional_logic' => 0,
            //     'wrapper'           => array(
            //         'width' => '',
            //         'class' => '',
            //         'id'    => '',
            //     ),
            //     'return_format'     => 'array',
            //     'preview_size'      => 'medium',
            //     'library'           => 'uploadedTo',
            //     'min_width'         => '',
            //     'min_height'        => '',
            //     'min_size'          => '',
            //     'max_width'         => '',
            //     'max_height'        => '',
            //     'max_size'          => '',
            //     'mime_types'        => '',
            // ),
            // array(
            //     'key'               => 'related_tags_banner_image',
            //     'label'             => 'Banner Image',
            //     'name'              => 'banner_image',
            //     'type'              => 'image',
            //     'instructions'      => 'Select the banner image for this tag',
            //     'required'          => 0,
            //     'conditional_logic' => 0,
            //     'wrapper'           => array(
            //         'width' => '',
            //         'class' => '',
            //         'id'    => '',
            //     ),
            //     'return_format'     => 'array',
            //     'preview_size'      => 'medium',
            //     'library'           => 'uploadedTo',
            //     'min_width'         => '',
            //     'min_height'        => '',
            //     'min_size'          => '',
            //     'max_width'         => '',
            //     'max_height'        => '',
            //     'max_size'          => '',
            //     'mime_types'        => '',
            // ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'taxonomy',
                    'operator' => '==',
                    'value'    => 'related_tags',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
    ));
}

add_action( 'acf/init', 'core_acf_related_tags_taxonomy' );

function core_get_related_tags_by_page_type( $page_type = '' ) {
    
    $post_id      = filter_input(
		INPUT_GET,
		'post',
		FILTER_DEFAULT
    );

    $post_type    = get_post_type( $post_id );

    if ( empty( $page_type ) ) {
        $page_type = $post_type;
    } 

    $taxonomy     = 'related_tags';
    $terms        = array();
    $term_args    = array(
        'taxonomy'         => $taxonomy,
        'suppress_filters' => false,
        'fields'           => 'all',
        'count'            => true,
        'hide_empty'       => false,
        'meta_query'       => array(
            array(  
               'key'       => 'page_type',
               'value'     => $page_type,
               'compare'   => '='
            )
        )
    );

    $object_terms = new WP_Term_Query( $term_args );

    if ( 
        ! empty( $object_terms->terms ) &&
        ! is_wp_error( $object_terms )
    ) {
        foreach ( $object_terms->terms as $term ) {
            $terms[ $term->term_id ] = $term->name;
            // $terms[ $term->term_id ] = array('value' => $term->term_id, 'label' => $term->name );
        }
    }

    return $terms;

}


function core_acf_posts_related_tags_taxonomy() {

    $taxonomy = 'related_tags';

    
    $page_type = 'applications';
    $label     = 'Applications';
    $terms     = core_get_related_tags_by_page_type( $page_type );
    // Applications
    acf_add_local_field_group(
        array(
            'key'                   => 'core_acf_' . $page_type . '_related_tags',
            'title'                 => $label . ' : Related Tags (' . count( $terms ) . ')',
            'fields'                => array(
                array(
                    'key'   => 'field_' . $page_type . '_' . $taxonomy,
                    'label' => '',
                    'name'  => $page_type . '_' . $taxonomy,
                    'type'  => 'select',
                    
                    /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
                    'choices' => $terms,
                    
                    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
                    'allow_null' => 0,
                    
                    /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
                    'multiple' => 1,
                    
                    /* (bool) Use the select2 interfacte. Defaults to 0 */
                    'ui' => 1,
                    
                    /* (bool) Load choices via AJAX. The ui setting must also be true for this to work. Defaults to 0 */
                    'ajax' => 0,
                    
                    /* (string) Appears within the select2 input. Defaults to '' */
                    'placeholder' => 'Select Related Tags',
                    
                )
            ),
            'location'              => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'applications',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'case_study',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'products',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal', // acf_after_title, normal or side
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
        )
    );

    $page_type = 'case_study';
    $label     = 'Case Study';
    $terms     = core_get_related_tags_by_page_type( $page_type );
    // Case Study
    acf_add_local_field_group(
        array(
            'key'                   => 'core_acf_' . $page_type . '_related_tags',
            'title'                 => $label . ' : Related Tags (' . count( $terms ) . ')',
            'fields'                => array(
                array(
                    'key'   => 'field_' . $page_type . '_' . $taxonomy,
                    'label' => '',
                    'name'  => $page_type . '_' . $taxonomy,
                    'type'  => 'select',
                    
                    /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
                    'choices' => core_get_related_tags_by_page_type( $page_type ),
                    
                    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
                    'allow_null' => 0,
                    
                    /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
                    'multiple' => 1,
                    
                    /* (bool) Use the select2 interfacte. Defaults to 0 */
                    'ui' => 1,
                    
                    /* (bool) Load choices via AJAX. The ui setting must also be true for this to work. Defaults to 0 */
                    'ajax' => 0,
                    
                    /* (string) Appears within the select2 input. Defaults to '' */
                    'placeholder' => 'Select Related Tags',
                    
                )
            ),
            'location'              => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'applications',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'case_study',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'products',
                    ),
                ),
            ),
            'menu_order'            => 1,
            'position'              => 'normal', // acf_after_title, normal or side
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
        )
    );

    $post_type = 'products';
    // Products
    acf_add_local_field_group(
        array(
            'key'                   => 'core_acf_' . $post_type . '_list',
            'title'                 => 'Product Lists',
            'fields'                => array(
                array(
                    'key'               => 'field_' . $post_type . '_list',
                    'label'             => '',
                    'name'              => $post_type . '_list',
                    'type'              => 'relationship',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => '',
                        'id'    => '',
                    ),
                    'post_type'         => array(
                        $post_type
                    ),
                    'taxonomy'          => '',
                    'filters'           => array(
                        'search',
                        'post_type',
                    ),
                    'elements'          => '',
                    'min'               => '',
                    'max'               => '',
                    'return_format'     => 'id',
                )
        
            ),
            'location'              => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'applications',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'case_study',
                    ),
                ),
            ),
            'menu_order'            => 2,
            'position'              => 'normal', // acf_after_title, normal or side
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
        )
    );

}

add_action( 'acf/init', 'core_acf_posts_related_tags_taxonomy' );


function core_related_tags_save_by_post_type( $post_id ) {
    $taxonomy  = '';
    $post_type = '';
    $terms     = array();

    if ( 
        in_array( 
            $post_type,
            array(
                'applications',
                'case_study',
            )
        ) 
    ) {

        $taxonomy  = 'related_tags';
        $post_type = get_post_type( $post_id );
        $terms     = get_field( $post_type . '_' . $taxonomy, $post_id );
        
        if ( ! empty( $terms ) ) {
            wp_set_post_terms( 
                $post_id, 
                implode( ',', $terms ), 
                $taxonomy 
            );
        }
    }
}

add_action( 'acf/save_post', 'core_related_tags_save_by_post_type', 15 );

/**
 * Hide tags from quick edit if user does not have admin priviledges
 */
function core_hide_related_tags_from_quick_edit( $show_in_quick_edit, $taxonomy_name, $post_type ) {
    if ( 'related_tags' === $taxonomy_name ) {
        return false;
    } else {
        return $show_in_quick_edit;
    }
}
add_filter( 'quick_edit_show_taxonomy', 'core_hide_related_tags_from_quick_edit', 10, 3 );


/* Related Tags Quick Edit */

/**
 * New columns
 */
function core_posts_related_tags_columns( $column_array ) {
    
    $column_array['posts_related_tags'] = 'Related Tags';
    
	return $column_array;
}

// add_filter( 'manage_post_posts_columns', 'core_posts_related_tags_columns' );

/**
 * Populate our new columns with data
 */
function core_populate_related_tags_columns( $column_name, $id ) {
 
    // if you have to populate more that one columns, use switch()
	switch( $column_name ) :
		case 'posts_related_tags': {
            $taxonomy     = 'related_tags';
            $post_type    = get_post_type( $id );
        
            $taxonomy     = 'related_tags';
            $terms        = array();
            $term_args    = array(
                'taxonomy'         => $taxonomy,
                'suppress_filters' => false,
                'fields'           => 'all',
                'count'            => true,
                'hide_empty'       => false,
                'meta_query'       => array(
                    array(  
                       'key'       => 'page_type',
                       'value'     => $post_type,
                       'compare'   => '='
                    )
                )
            );
        
            $object_terms = new WP_Term_Query( $term_args );


            echo '<fieldset class="inline-edit-col-center inline-edit-' . $taxonomy . '">';
                echo '<div class="inline-edit-col">';
        
            
                    echo '<span class="title inline-edit-' . $taxonomy . '-label">';
                        echo esc_html( 'Related Tags' );
                    echo '</span>';
                    echo '<input type="hidden" name="tax_input[' . $taxonomy . '][]" value="0">';

                    echo '<ul class="cat-checklist ' . $taxonomy . '-checklist">';
                           wp_terms_checklist( null, array( 'taxonomy' => $taxonomy ) );
                    echo '</ul>';

                echo '</div>';
            echo '</fieldset>';
			
		}
	endswitch;
 
}

// add_action('manage_posts_custom_column', 'core_populate_related_tags_columns', 10, 2);