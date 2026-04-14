<?php
/**
 * ACF Field Group for Blog Posts
 * Path: inc/acf/post-types/blog-post.php
 */

if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_post_linkages',
        'title' => 'Post Linkages (Industries & Products)',
        'fields' => array(
            array(
                'key' => 'field_post_shortcode_instructions',
                'label' => 'Usage Instructions',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'Use these shortcodes in your content to display the linked items:
<br><br><b>Industries:</b>
<br>• Default: <code>[massload_related_industries]</code>
<br>• Custom Title: <code>[massload_related_industries title="Your Custom Title"]</code>
<br>• Hide Title: <code>[massload_related_industries show_title="false"]</code>
<br><br><b>Products:</b>
<br>• Default: <code>[massload_related_products]</code>
<br>• Custom Title: <code>[massload_related_products title="Your Custom Title"]</code>
<br>• Hide Title: <code>[massload_related_products show_title="false"]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_post_associated_industries',
                'label' => 'Associated Industries (Applications)',
                'name' => 'associated_industries',
                'type' => 'relationship',
                'instructions' => 'Select related Applications. Display them using: <code>[massload_related_industries]</code>',
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
            array(
                'key' => 'field_post_associated_products',
                'label' => 'Associated Products',
                'name' => 'associated_products',
                'type' => 'relationship',
                'instructions' => 'Select related Products. Display them using: <code>[massload_related_products]</code>',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                    1 => 'products',
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
