<?php
/**
 * ACF Field Group for Blog Posts
 * Path: inc/acf/post-types/blog-post.php
 */

if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_post_industries',
        'title' => 'Post Application Linkage',
        'fields' => array(
            array(
                'key' => 'field_post_associated_industries',
                'label' => 'Associated Industries (Applications)',
                'name' => 'associated_industries',
                'type' => 'relationship',
                'instructions' => 'Select one or more Applications/Industries related to this blog post.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'applications',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                ),
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'object',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

}
