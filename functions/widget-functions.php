<?php
/**
 * Theme widgets and sidebars.
 *
 * @package MM International
 * @author 
 * @link 
 */


/* ---------------------------------------------------------------------------
 * Add custom sidebars
 * --------------------------------------------------------------------------- */


function mmi_register_sidebars() {
	
	
	// page top ----------------------------------------------------------

	{
		register_sidebar(array(
			'name' 			=> __('Page area','mmi-opts'),
			'id' 			=> 'page-area',
			'description'	=> __('Appears in the Page section of the site.','mminternational'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</aside>',
			'before_title' 	=> '<h4>',
			'after_title' 	=> '</h4>',
		));
	}
	
	// footer areas ----------------------------------------------------------
	
	/*{
		register_sidebar(array(
			'name' 			=> __('Footer area 1','mmi-opts'),
			'id' 			=> 'footer-area-1',
			'description'	=> __('Appears in the Footer section of the site.','mminternational'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</aside>',
			'before_title' 	=> '<h4>',
			'after_title' 	=> '</h4>',
		));
	}
	
	{
		register_sidebar(array(
			'name' 			=> __('Footer area 2','mmi-opts'),
			'id' 			=> 'footer-area-2',
			'description'	=> __('Appears in the Footer section of the site.','mminternational'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</aside>',
			'before_title' 	=> '<h4>',
			'after_title' 	=> '</h4>',
		));
	}*/

}
add_action( 'widgets_init', 'mmi_register_sidebars' );

?>