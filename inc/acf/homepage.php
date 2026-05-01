<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group( array(
        'key' => 'group_homepage_categories',
        'title' => 'Homepage Categories',
        'fields' => array(
            array(
                'key' => 'field_homepage_tab_our_product',
                'label' => 'Our Product',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_homepage_selected_categories',
                'label' => 'Select Featured Categories',
                'name' => 'selected_categories',
                'type' => 'select',
                'choices' => massload_get_product_categories_for_acf(),
                'instructions' => 'Search and select the categories you want to display on the homepage.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'ui' => 1,
                'ajax' => 1,
                'multiple' => 1,
                'allow_null' => 1,
                'placeholder' => 'Search for categories...',
                'return_format' => 'value',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-front.php',
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
    ) );

}
