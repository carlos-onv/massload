<?php


function core_acf_resources_cpt() {
    $post_type   = 'resources';
    $post_status = 'publish';
    $query       = get_posts(
        array(
            'numberposts'	=> -1,
            'post_type'		=> $post_type,
            'post_status'	=> $post_status,
        )
    );
    $post_list = wp_list_pluck( $query, 'post_title', 'ID' );

	acf_add_local_field_group(array(
		'key'                   => 'resources_archive',
		'title'                 => 'Resources',
		'fields'                => array (
            array(
                'key'   => 'featured_post',
				'label' => 'Featured Resources',
                'name'  => 'featured_resources',
                'type'  => 'select',
                
                /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
                'choices' => $post_list,
                
                /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
                'allow_null' => 0,
                
                /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
                'multiple' => 1,
                
                /* (bool) Use the select2 interfacte. Defaults to 0 */
                'ui' => 1,
                
                /* (bool) Load choices via AJAX. The ui setting must also be true for this to work. Defaults to 0 */
                'ajax' => 1,
                
                /* (string) Appears within the select2 input. Defaults to '' */
                'placeholder' => 'Select Featured Resources Here',
                
            )
        ),
        
		'location'              => array (
			array (
				array (
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'resources.php',
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
        
	));
    
}

add_action( 'acf/init', 'core_acf_resources_cpt' );