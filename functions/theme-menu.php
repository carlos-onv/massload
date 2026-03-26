<?php
/**
 * Menu functions.
 *
 * @package MM International
 * @author 
 * @link 
 */


/* ---------------------------------------------------------------------------
 * Registers a menu location to use with navigation menus.
 * --------------------------------------------------------------------------- */
register_nav_menu( 'main-menu',			__( 'Main Menu', 'mmi-opts' ) );
register_nav_menu( 'quick-menu',		__( 'Quick Menu', 'mmi-opts' ) );
//register_nav_menu( 'product-menu',		__( 'Product Menu', 'mmi-opts' ) );


/* ---------------------------------------------------------------------------
 * Main Menu
 * --------------------------------------------------------------------------- */


function mmi_wp_nav_menu() 
{
	$args = array( 
		'container' 		=> 'nav',
		'container_id'		=> 'menu', 
		'menu_class'		=> 'menu', 
		'fallback_cb'		=> 'mmi_wp_page_menu', 
// 		'theme_location'	=> $location,
		'depth' 			=> 3,
		'link_before'     	=> '<span>',
		'link_after'      	=> '</span>',
		'walker' 			=> new Walker_Nav_Menu_mmi,
	);
	
	// custom menu for pages
	if( $custom_menu = get_post_meta( get_the_ID(), 'mmi-post-menu', true ) ){
		$args['menu']			= $custom_menu;
	} else {
		$args['theme_location'] = 'main-menu';
	}
	
	wp_nav_menu( $args ); 
}

function mmi_wp_page_menu() 
{
	$args = array(
		'title_li' => '0',
		'sort_column' => 'menu_order',
		'depth' => 3
	);

	echo '<nav id="menu">'."\n";
		echo '<ul class="menu page-menu">'."\n";
			wp_list_pages($args); 
		echo '</ul>'."\n";
	echo '</nav>'."\n";
}


/* ---------------------------------------------------------------------------
 * Secondary menu
 * --------------------------------------------------------------------------- */
function mmi_wp_secondary_menu()
{
	$args = array(
		'container' 		=> 'nav',
		'container_id'		=> 'secondary-menu', 
		'menu_class'		=> 'secondary-menu', 
		'fallback_cb'		=> false,
		'theme_location' 	=> 'secondary-menu',
		'depth'				=> 2,
	);
	wp_nav_menu( $args );
}

?>