<?php


function acf_load_color_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('my_select_values', 'option') ) {
        
        // while has rows
        while( have_rows('my_select_values', 'option') ) {
            
            // instantiate row
            the_row();
            
            
            // vars
            $value = get_sub_field('value');
            $label = get_sub_field('label');

            
            // append to choices
            $field['choices'][ $value ] = $label;
            
        }
        
    }


    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=color', 'acf_load_color_field_choices');