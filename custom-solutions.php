<?php
/**
 * Template Name: Custom Solution
 *
 * This template file is use for Company & Values Page
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header();

    $output     = '';
    $page_title = get_the_title();

    $banner = get_field( 'banner_section' );
        $bnr_image    = core_isset_array( $banner, 'banner_image', '' );
        $bnr_btn_text = core_isset_array( $banner, 'button_label', '' );
        $bnr_btn_link = core_isset_array( $banner, 'button_link', '' );

    $company_values = get_field( 'company_values_section' );
        $cv_title       = core_isset_array( $company_values, 'title', '' );
        $cv_desc        = core_isset_array( $company_values, 'description', '' );
        $cv_tabs_title  = core_isset_array( $company_values, 'tabs_title', '' );
        $cv_tabs        = get_field( 'company_values_tabs' );
            $cv_tab_label     = '';
            $active_tab       = '';
            $cv_tab_id        = '';
            $cv_tab_ids       = array();
            $cv_tab_lists     = array();
            $cv_tab_list_id   = '';
            $cv_tab_list_logo = '';
            $cv_tab_list_desc = '';

    $our_history = get_field( 'our_history' );
        $oh_title    = core_isset_array( $our_history, 'title', '' );
        $oh_desc     = core_isset_array( $our_history, 'description', '' );
        $oh_bg_color = core_isset_array( $our_history, 'background_color', '' );
        $oh_bg_img   = core_isset_array( $our_history, 'background_image', '' );

    $environmental_sustainability_journey = get_field( 'environmental_sustainability_journey' );
        $esj_title     = core_isset_array( $environmental_sustainability_journey, 'title', '' );
        $esj_desc      = core_isset_array( $environmental_sustainability_journey, 'description', '' );
        $esj_btn_label = core_isset_array( $environmental_sustainability_journey, 'button_label', '' );
        $esj_btn_link  = core_isset_array( $environmental_sustainability_journey, 'button_link', '' );

    $economic_sustainability = get_field( 'economic_sustainability' );
        $es_title    = core_isset_array( $economic_sustainability, 'title', '' );
        $es_desc     = core_isset_array( $economic_sustainability, 'description', '' );
        $es_bg_color = core_isset_array( $economic_sustainability, 'background_color', '' );
        $es_bg_img   = core_isset_array( $economic_sustainability, 'background_image', '' );

    
    $cvs_main_desc   = get_field( 'core_values_main_content');
    $core_values    = get_field( 'core_values' );
        $cvs_title       = core_isset_array( $core_values, 'title', '' );
        $cvs_bg_color    = core_isset_array( $core_values, 'background_color', '' );
        $cvs_bg_image    = core_isset_array( $core_values, 'background_image', '' );
        $cvs_grid_items  = core_isset_array( $core_values, 'grid_items', '' );
            $cvs_grid_icon   = '';
            $cvs_grid_title  = '';
            $cvs_grid_desc   = '';
        if(is_array($cvs_grid_items))
        {
        $cvs_count_items = count( $cvs_grid_items );
        }
        else
        {
            $cvs_count_items = 0;
        }
            $cvs_col_class = 'grid-item ';
            if ( 1 === $cvs_count_items ) {
                $cvs_col_class .= 'col-md-12';
            } elseif ( 2 === $cvs_count_items ) {
                $cvs_col_class .= 'col-md-6';
            } else {
                $cvs_col_class .= 'col-md-4';
            }

    $unashamedly_ethical = get_field( 'unashamedly_ethical' );
        $ue_title    = core_isset_array( $unashamedly_ethical, 'title', '' );
        $ue_desc     = core_isset_array( $unashamedly_ethical, 'description', '' );
        $ue_bg_image = core_isset_array( $unashamedly_ethical, 'background_image', '' );
    $code_of_conduct_for_individuals = get_field( 'code_of_conduct_for_individuals' );
        $cocfi_title = core_isset_array( $code_of_conduct_for_individuals, 'title', '' );
        $cocfi_list  = core_isset_array( $code_of_conduct_for_individuals, 'list', '' );
            $cocfi_list_item = '';

            
    $output .= '<div id="pagebanner" class="pagebanner casestudies_banner">';
        $output .= '<div class="inner-banner"  style="background-image: url(' . esc_url( $bnr_image ) . ');">';
            $output .= '<div class="container">';
                $output .= '<h1>' . esc_html( $page_title ) . '</h1>';
                
                $output .= core_breadcrumbs( 
                    array( 
                        'echo' => false
                    )
                );
                
                $output .= '<a class="banner-btn com-btn" href="' . esc_url( $bnr_btn_link ) . '">';
                    $output .= esc_html( $bnr_btn_text );
                $output .= '</a>';

            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';

    $output .= '<main id="pagecontent" role="content">';
        $output .= '<section class="innerpages content-wrap">';

            $output .= '<div class="container-wrap container-fliud">';
                $output .= '<div class="container-inner-wrap row">';

                    $output .= '<section class="page-section company-values container">';
                        $output .= '<div class="section-wrap">';
                            $output .= '<div class="inner-section col-md-12">';

                             $output .= '<div class="heading-block">';
                            
                                $output .= '<h2 class="section-heading1">';
                                    $output .= core_encapsulate_text(
                                            array(
                                                'text'          => esc_html( $cv_title ),
                                                'word_position' => 0,
                                                'before'        => '<span class="highlight">',
                                                'after'         => '</span>',
                                            )
                                        );
                                $output .=  '</h2>';
                            $output .= '</div>';

                                $output .= '<div class="section-contents">';

                                    $output .= '<div class="section-desc">';
                                        $output .= wp_kses_post( $cv_desc );
                                    $output .= '</div>';

                                    $output .= '<h3 class="section-title" id="QualityCertifications">';
                                        $output .= core_encapsulate_text(
                                            array(
                                                'text'          => esc_html( $cv_tabs_title ),
                                                'word_position' => 0,
                                                'before'        => '<span class="highlight">',
                                                'after'         => '</span>',
                                            )
                                        );
                                    $output .=  '</h3>';
                                    
                                    if ( ! empty( $cv_tabs ) ) {
                                        $output .= '<div class="row core-tabs-ui core-tabs-vertical">';
                                            $output .= '<div class="col-md-4 core-tab">';

                                                $output .= '<ul class="core-tab-lists">';
                                                    foreach ( $cv_tabs as $key => $cv_tab ) {
                                                        $cv_tab_label = core_isset_array( $cv_tab, 'tab_label', '');
                                                        $cv_tab_id    = core_text_to_attr( $cv_tab_label );
                                                        $cv_tab_ids[] = $cv_tab_id;

                                                        if (
                                                            ! empty ( $cv_tab[ 'list' ] ) &&
                                                            isset( $cv_tab[ 'list' ] ) 
                                                        ) {
                                                            $cv_tab_lists[ $cv_tab_id ] = core_isset_array( $cv_tab, 'list', '' );
                                                        } else {
                                                            $cv_tab_lists[ $cv_tab_id ] = array();
                                                        }

                                                        if ( 0 === $key ) {
                                                            $active_tab = $cv_tab_id;
                                                            $output .= '<li class="core-tab-list active">';
                                                        } else {
                                                            $output .= '<li class="core-tab-list">';
                                                        }
                                                            $output .= '<a href="#' . esc_attr( $cv_tab_id ) . '" class="core-tab-link" >';
                                                                $output .= esc_html( $cv_tab_label );
                                                            $output .= '</a>';
                                                        $output .= '</li>';
                                                    }

                                                $output .= '</ul>';

                                            $output .= '</div>';

                                            $output .= '<div class="col-md-8 core-tab-contents">';

                                                if ( ! empty( $cv_tab_lists ) ) {

                                                    foreach ( $cv_tab_lists as $tab_id => $cv_tab_list ) {
                                                        $cv_tab_list_id = $tab_id;

                                                        if ( ! empty( $cv_tab_list ) ) {
                                                            if ( $active_tab === $cv_tab_list_id ) {
                                                                $output .= '<div class="core-tab-details-wrap active" id="' . esc_attr( $cv_tab_list_id ) . '">';
                                                            } else {
                                                                $output .= '<div class="core-tab-details-wrap" id="' . esc_attr( $cv_tab_list_id ) . '">';
                                                            }

                                                                foreach ( $cv_tab_list as $cv_tab_details ) {

                                                                    $cv_tab_list_logo = core_isset_array( $cv_tab_details, 'logo', '');
                                                                    $cv_tab_list_desc = core_isset_array( $cv_tab_details, 'description', '');

                                                                    $output .= '<div class="row core-tab-details">';
                                                                        
                                                                        $output .= '<div class="col-md-2 core-tab-logo">';
                                                                            $output .= '<img src="' . esc_url( $cv_tab_list_logo ) . '">';
                                                                        $output .= '</div>';
                        
                                                                        $output .= '<div class="col-md-10 core-tab-desc">';
                                                                            $output .= wp_kses_post( $cv_tab_list_desc );
                                                                        $output .= '</div>';
                        
                                                                    $output .= '</div>';
                                                                }
                                                            $output .= '</div>';
                                                        }
                                                    }

                                                }
                                                
                                            $output .= '</div>';

                                        $output .= '</div>';
                                    }

                                $output .= '</div>';
                            
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</section>';

                    $output .= '<section class="page-section full-scaled-column right our-history container-fluid" style="background-color: ' . esc_attr( $oh_bg_color ) . ';">';
                        $output .= '<div class="section-wrap container">';
                            $output .= '<div class="inner-section col-md-12">';
                                
                                $output .= '<div class="details-col col-md-7">';

                                    $output .= '<h3 class="section-title" id="OurHistory">';
                                        $output .= core_encapsulate_text(
                                                array(
                                                    'text'          => esc_html( $oh_title ),
                                                    'word_position' => 0,
                                                    'before'        => '<span class="highlight">',
                                                    'after'         => '</span>',
                                                )
                                            );
                                    $output .=  '</h3>';
                                    
                                    $output .= '<div class="section-contents">';
                                        $output .= '<div class="section-desc">';
                                            $output .= wp_kses_post( $oh_desc );
                                        $output .= '</div>';
                                    $output .= '</div>';
                                    
                                $output .= '</div>';

                                $output .= '<div class="image-col col-md-5" style="background-image: url(' . esc_url( $oh_bg_img ) . '   );">';
                                $output .= '</div>';

                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</section>';
                

                    $output .= '<section class="page-section full-scaled-column left design-adaptations economic-sustainability container-fluid" style="background-color: ' . esc_attr( $es_bg_color ) . ';">';
                        $output .= '<div class="section-wrap container">';
                            $output .= '<div class="inner-section row">';

                                $output .= '<div class="image-col col-md-5" style="background-image: url(' . esc_url( $es_bg_img ) . '   );">';
                                $output .= '</div>';

                                $output .= '<div class="details-col col-md-7 offset-md-5">';

                                    $output .= '<h3 class="section-title" id="EconomicSustainability">';
                                        $output .= core_encapsulate_text(
                                                array(
                                                    'text'          => esc_html( $es_title ),
                                                    'word_position' => 0,
                                                    'before'        => '<span class="highlight">',
                                                    'after'         => '</span>',
                                                )
                                            );
                                    $output .=  '</h3>';
                                    
                                    $output .= '<div class="section-contents">';
                                        $output .= '<div class="section-desc">';
                                            $output .= wp_kses_post( $es_desc );
                                        $output .= '</div>';
                                    $output .= '</div>';
                                    
                                $output .= '</div>';

                            $output .= '</div>';
                        $output .= '</div><div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><!-- 16:9 aspect ratio -->
<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe></div></div></div></div></div>';
                    $output .= '</section>';

                    $output .= '<section class="page-section image-background core-grid-items custom-designs core-values container-fluid" style="background-image: url(' . esc_attr( $cvs_bg_image ) . '   ); --data-color: ' . esc_attr( esc_attr( $cvs_bg_color ) ) . '">';
                        $output .= '<div class="section-wrap container">';
                            $output .= '<div class="inner-section col-md-12">';
                            
                                $output .= '<h3 class="section-title" id="OurCoreValues">';
                                    $output .= core_encapsulate_text(
                                            array(
                                                'text'          => esc_html( $cvs_title ),
                                                'word_position' => 0,
                                                'before'        => '<span class="highlight">',
                                                'after'         => '</span>',
                                            )
                                        );
                                $output .=  '</h3>';
                                // Core Values Main content
                               
                                $output .= '<div class="section-contents">';
                                        $output .= '<div class="section-desc">';
                                            $output .= wp_kses_post( $cvs_main_desc );
                                        $output .= '</div>';
                                    $output .= '</div>';    

                                if ( ! empty( $cvs_grid_items ) ) {
                                    $output .= '<div class="section-contents">';
                                        $output .= '<div class="grid-items">';
                                            $output .= '<div class="row">';

                                                foreach ( $cvs_grid_items as $key => $cvs_grid_item ) {
                                                    $cvs_grid_icon   = core_isset_array( $cvs_grid_item, 'icon', '' );
                                                    $cvs_grid_title  = core_isset_array( $cvs_grid_item, 'title', '' );
                                                    $cvs_grid_desc   = core_isset_array( $cvs_grid_item, 'description', '' );

                                                    $output .=  '<div class="' . esc_attr( $cvs_col_class ) . '">';

                                                        $output .= '<div class="grid-image-wrap">';
                                                            $output .= '<img src="' . esc_url( $cvs_grid_icon ) . '">';
                                                        $output .= '</div>';

                                                        $output .= '<div class="grid-title-wrap">';
                                                            $output .= '<h4 class="item-title">';
                                                                $output .= esc_html( $cvs_grid_title );
                                                            $output .= '</h4>';
                                                        $output .= '</div>';

                                                        $output .= '<div class="grid-desc-wrap">';
                                                            $output .= wp_kses_post( $cvs_grid_desc );
                                                        $output .= '</div>';

                                                    $output .=  '</div>';
                                                }

                                            $output .=  '</div>';
                                        $output .=  '</div>';
                                    $output .=  '</div>';
                                }

                            $output .=  '</div>';
                        $output .=  '</div>';
                    $output .= '</section>';

                $output .= '</div>';
            $output .= '</div>';


        $output .= '</section>';
    $output .= '</main>';


    echo $output;

get_footer();