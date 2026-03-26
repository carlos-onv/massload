<?php 



function core_sticky_toolbar_phone() {
    $output     = '';
    $phone_num  = '18006673825';
    $contact_us = get_permalink( get_page_by_title( 'CONTACT US' ) );// get_permalink( 142 );

    $output .= '<div class="st-btn st-last core-toolbar-item phone" data-network="phone" style="display: inline-block;">';
        // $output .= '<a class="core-toolbar-link contact-us" href="tel:' . esc_html( $phone_num ) . '">';
        $output .= '<a class="core-toolbar-link contact-us" href="' . esc_url( $contact_us ) . '">';
            $output .= '<i class="core-toolbar-icon phone sharing button fa fa-phone"></i>';
            $output .= '<span class="st-label">' . __( 'Contact Us', 'massload' ) . '</span>';
        $output .= '</a>';
    $output .= '</div>';

    return $output;
}