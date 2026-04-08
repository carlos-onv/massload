<?php
/**
 * Theme Options - fields and args
 *
 * @package MM International
 * @author
 * @link
 */

require_once( dirname( __FILE__ ) . '/options.php' );

/**
 * Options Page | Helper Functions
 */


// Background Position


function mmia_bg_position(){
	return array(
		'no-repeat;center top;;' 		=> 'Center Top No-Repeat',
		'repeat;center top;;' 			=> 'Center Top Repeat',
		'no-repeat;center;;' 			=> 'Center No-Repeat',
		'repeat;center;;' 				=> 'Center Repeat',
		'no-repeat;left top;;' 			=> 'Left Top No-Repeat',
		'repeat;left top;;' 			=> 'Left Top Repeat',
		'no-repeat;center top;fixed;' 	=> 'Center No-Repeat Fixed',
		'no-repeat;center;fixed;cover' 	=> 'Center No-Repeat Fixed Cover',
	);
}


/**
 * Options Page | Fields & Args
 */
function mmi_opts_setup(){

	// Navigation elements
	$menu = array(

		// General --------------------------------------------
		'general' => array(
			'title' 	=> __('Getting started', 'mmi-opts'),
			'sections' 	=> array( 'layout-general', 'layout-header', 'social', 'casestudy', 'product', 'layout-footer' ),
		),

		// Layout --------------------------------------------
		//'elements' => array(
			//'title' 	=> __('Layout', 'mmi-opts'),
			//'sections' 	=> array( 'layout-general', 'layout-header', 'social', 'custom-css', 'layout-footer'),
		//),

	);

	$sections = array();

	
	// Header --------------------------------------------
	$sections['layout-header'] = array(
		'title' => __('Header', 'mmi-opts'),
		'fields' => array(

			array(
				'id'		=> 'logo',
				'type'		=> 'upload',
				'title'		=> __('Main Logo', 'mmi-opts'),
			),

			array(
				'id'		=> 'print-logo',
				'type'		=> 'upload',
				'title'		=> __('Print Logo', 'mmi-opts'),
			),
	
			array(
				'id'		=> 'toll-free-text',
				'type'		=> 'text',
				'title'		=> __('Toll Free', 'mmi-opts'),
				'desc'		=> __('Toll Free Label', 'mmi-opts'),
			),

			array(
				'id'		=> 'toll-free-number',
				'type'		=> 'text',
				'title'		=> __('Toll Free Number', 'mmi-opts'),
				'desc'		=> __('Toll Free Number', 'mmi-opts'),
			),

			array(
				'id'		=> 'international-text',
				'type'		=> 'text',
				'title'		=> __('International Label', 'mmi-opts'),
				'desc'		=> __('International Label Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'international-number',
				'type'		=> 'text',
				'title'		=> __('International Number', 'mmi-opts'),
				'desc'		=> __('International Number', 'mmi-opts'),
			),

			array(
				'id'		=> 'fax-text',
				'type'		=> 'text',
				'title'		=> __('Fax Label', 'mmi-opts'),
				'desc'		=> __('Fax Label Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'fax-number',
				'type'		=> 'text',
				'title'		=> __('Fax Number', 'mmi-opts'),
			),

			array(
				'id'		=> 'contact-mail',
				'type'		=> 'text',
				'title'		=> __('Contact Mail', 'mmi-opts'),
				'desc'		=> __('Enter You Mail ID', 'mmi-opts'),
			),

			array(
				'id'		=> 'call_logo',
				'type'		=> 'upload',
				'title'		=> __('Call Icon', 'mmi-opts'),
			),

			array(
				'id'		=> 'call-us',
				'type'		=> 'text',
				'title'		=> __('Call Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'call-number',
				'type'		=> 'text',
				'title'		=> __('Call Number', 'mmi-opts'),
			),

			array(
				'id'		=> 'get-quote',
				'type'		=> 'text',
				'title'		=> __('Get Quote Button Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'get-quote-link',
				'type'		=> 'text',
				'title'		=> __('Get Quote Button Link', 'mmi-opts'),
			),
			
			array(
				'id'		=> 'en_logo',
				'type'		=> 'upload',
				'title'		=> __('English Icon', 'mmi-opts'),
			),

			array(
				'id'		=> 'ca_logo',
				'type'		=> 'upload',
				'title'		=> __('Canada Icon', 'mmi-opts'),
			),

			array(
				'id'		=> 'show-call-cta',
				'type'		=> 'select',
				'title'		=> __('Show Call CTA', 'mmi-opts'),
				'desc'		=> __('Enable or disable the Call button in the header.', 'mmi-opts'),
				'options'	=> array( '1' => 'Yes', '0' => 'No' ),
				'std'		=> '1',
			),

			array(
				'id'		=> 'show-quote-cart-cta',
				'type'		=> 'select',
				'title'		=> __('Show Quote Cart CTA', 'mmi-opts'),
				'desc'		=> __('Enable or disable the Quote Cart button in the header.', 'mmi-opts'),
				'options'	=> array( '1' => 'Yes', '0' => 'No' ),
				'std'		=> '0',
			),
		),
	);

	// Product --------------------------------------------
	$sections['product'] = array(
		'title' => __('Product', 'mmi-opts'),
		'fields' => array(

			array(
				'id'		=> 'product-banner-title',
				'type'		=> 'text',
				'title'		=> __('Banner Main Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'product-banner-link',
				'type'		=> 'text',
				'title'		=> __('Banner Main Link', 'mmi-opts'),
			),

			array(
				'id'		=> 'filter-prod-title',
				'type'		=> 'text',
				'title'		=> __('Filter Products Title', 'mmi-opts'),				
			),			

			array(
				'id'		=> 'quoteform-title',
				'type'		=> 'text',
				'title'		=> __('Request a Quote Form Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'quoteform-subtitle',
				'type'		=> 'text',
				'title'		=> __('Request a Quote Form Sub Title', 'mmi-opts'),
			),
			
		),
	);

	// CaseStudy --------------------------------------------
	$sections['casestudy'] = array(
		'title' => __('Case Study', 'mmi-opts'),
		'fields' => array(

			array(
				'id'		=> 'main-title',
				'type'		=> 'text',
				'title'		=> __('Main Case Study Title', 'mmi-opts'),				
			),

			array(
				'id'		=> 'previous-text',
				'type'		=> 'text',
				'title'		=> __('Previous Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'next-text',
				'type'		=> 'text',
				'title'		=> __('Next Text', 'mmi-opts'),
			),

			array(
				'id'		=> 'search-title',
				'type'		=> 'text',
				'title'		=> __('Search Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'tag-title',
				'type'		=> 'text',
				'title'		=> __('Tag Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'recent-title',
				'type'		=> 'text',
				'title'		=> __('Recent Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'application-title',
				'type'		=> 'text',
				'title'		=> __('Application Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'product-title',
				'type'		=> 'text',
				'title'		=> __('Product Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'csform-title',
				'type'		=> 'text',
				'title'		=> __('Case Study Form Title', 'mmi-opts'),
			),

			array(
				'id'		=> 'csform-subtitle',
				'type'		=> 'text',
				'title'		=> __('Case Study Form Sub Title', 'mmi-opts'),
			),

		),
	);

	// Footer --------------------------------------------
	$sections['layout-footer'] = array(
		'title' => __('Footer', 'mmi-opts'),
		'fields' => array(

			array(
				'id'		=> 'placeholder',
				'type'		=> 'upload',
				'title'		=> __('Placeholder', 'mmi-opts'),
			),

			array(
				'id'		=> 'foot-logo',
				'type'		=> 'upload',
				'title'		=> __('Footer Logo', 'mmi-opts'),
			),

			array(
				'id'		=> 'footer-desc',
				'type'		=> 'textarea',
				'title'		=> __('Footer Description', 'mmi-opts'),
			),

			array(
				'id'		=> 'certification-logo',
				'type'		=> 'upload',
				'title'		=> __('Certification Image', 'mmi-opts'),
			),

			array(
				'id'		=> 'footer-title1',
				'type'		=> 'text',
				'title'		=> __('Footer Title1', 'mmi-opts'),
			),

			array(
				'id'		=> 'footer-title2',
				'type'		=> 'text',
				'title'		=> __('Footer Title2', 'mmi-opts'),
			),

			array(
				'id'		=> 'footer-title3',
				'type'		=> 'text',
				'title'		=> __('Footer Title3', 'mmi-opts'),
			),

			array(
				'id'		=> 'footer-title4',
				'type'		=> 'text',
				'title'		=> __('Footer Title4', 'mmi-opts'),
			),

			array(
				'id'		=> 'fb-link',
				'type'		=> 'text',
				'title'		=> __('Facebook Link', 'mmi-opts'),
				'desc'		=> __('Enter your Facebook Link', 'mmi-opts'),
			),

			array(
				'id'		=> 'youtube-link',
				'type'		=> 'text',
				'title'		=> __('Youtube Link', 'mmi-opts'),
				'desc'		=> __('Enter your Youtube Link', 'mmi-opts'),
			),

			array(
				'id'		=> 'linked-in',
				'type'		=> 'text',
				'title'		=> __('LinkedIn Link', 'mmi-opts'),
				'desc'		=> __('Enter your LinkedIn link', 'mmi-opts'),
			),

			array(
				'id'		=> 'copyrights',
				'type'		=> 'text',
				'title'		=> __('Footer Copyright', 'mmi-opts'),
				'desc'		=> __('please enter your copyrights.', 'mmi-opts'),
			)			

		),
	);

	
	global $mmi_Options;
	$mmi_Options = new mmi_Options( $menu, $sections );
}
//add_action('init', 'mmi_opts_setup', 0);
mmi_opts_setup();


/**
 * This is used to return option value from the options array
 */
function mmi_opts_get( $opt_name, $default = null ){
	global $mmi_Options;
	return $mmi_Options->get( $opt_name, $default );
}


/**
 * This is used to echo option value from the options array
*/
function mmi_opts_show( $opt_name, $default = null ){
	global $mmi_Options;
	$option = $mmi_Options->get( $opt_name, $default );
	if( ! is_array( $option ) ){
		echo $option;
	}
}


/**
 * Add new mimes for custom font upload
 */
add_filter('upload_mimes', 'mmi_upload_mimes');
function mmi_upload_mimes( $existing_mimes=array() ){
	$existing_mimes['woff'] = 'font/woff';
	$existing_mimes['ttf'] 	= 'font/ttf';
	$existing_mimes['svg'] 	= 'font/svg';
	$existing_mimes['eot'] 	= 'font/eot';
	return $existing_mimes;
}
?>
