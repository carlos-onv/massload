<?php
/**
 * Header functions.
 *
 * @package MM International
 * @author 
 * @link 
 */
 

/* ---------------------------------------------------------------------------
 * Title
 * --------------------------------------------------------------------------- */


function mmi_title()
{
	$title = false;
	if( mmi_opts_get('mmi-seo') && mmi_ID() ){
		if( get_post_meta( mmi_ID(), 'mmi-meta-seo-title', true ) ){
			$title = stripslashes( get_post_meta( mmi_ID(), 'mmi-meta-seo-title', true ) );
		}
	}
	
	return $title;
}


/* ---------------------------------------------------------------------------
 * Meta and Desctiption
 * --------------------------------------------------------------------------- */
function mmi_seo() 
{
	if( mmi_opts_get('mmi-seo') && mmi_ID() ){

		// description
		if( get_post_meta( mmi_ID(), 'mmi-meta-seo-description', true ) ){
			echo '<meta name="description" content="'. stripslashes( get_post_meta( mmi_ID(), 'mmi-meta-seo-description', true ) ) .'" />'."\n";
		} elseif( mmi_opts_get('meta-description') ){
			echo '<meta name="description" content="'. stripslashes( mmi_opts_get('meta-description') ) .'" />'."\n";
		}
		
		// keywords
		if( get_post_meta( mmi_ID(), 'mmi-meta-seo-keywords', true ) ){
			echo '<meta name="keywords" content="'. stripslashes( get_post_meta( mmi_ID(), 'mmi-meta-seo-keywords', true ) ) .'" />'."\n";
		} elseif( mmi_opts_get('meta-keywords') ){
			echo '<meta name="keywords" content="'. stripslashes( mmi_opts_get('meta-keywords') ) .'" />'."\n";
		}
		
	}

	// google analytics
	if( mmi_opts_get('google-analytics') ){
		mmi_opts_show('google-analytics');
	}
}
add_action('wp_seo', 'mmi_seo');


/* ---------------------------------------------------------------------------
 * Fonts | Selected in Theme Options
 * --------------------------------------------------------------------------- */
function mmi_fonts_selected(){
	$fonts = array();
	
	$fonts['content'] 		= mmi_opts_get( 'font-content', 		'Roboto' );
	$fonts['menu'] 			= mmi_opts_get( 'font-menu', 			'Roboto' );
	$fonts['headings'] 		= mmi_opts_get( 'font-headings', 		'Patua One' );
	$fonts['headingsSmall'] = mmi_opts_get( 'font-headings-small', 	'Roboto' );
	
	return $fonts;
}


/* ---------------------------------------------------------------------------
 * 960px grid
* --------------------------------------------------------------------------- */
function mmi_is_960(){
	$grid960 = false;

	if( $_GET && key_exists('mmi-960', $_GET) ){
		$grid960 = true;
	} elseif( $layoutID = get_post_meta( mmi_ID(), 'mmi-post-custom-layout', true ) ){
		if( get_post_meta( $layoutID, 'mmi-post-grid960', true ) ) $grid960 = true; // separate IF; do NOT connect
	} elseif( mmi_opts_get('grid960') ){
		$grid960 = true;
	}
	
	return $grid960;
}


/* ---------------------------------------------------------------------------
 * Styles
 * --------------------------------------------------------------------------- */
function mmi_styles() 
{
	// wp_enqueue_style ------------------------------------------------------
	wp_enqueue_style( 'style', get_stylesheet_uri(), false, THEME_VERSION, 'all' );
	wp_enqueue_style( 'prettyPhoto', 	THEME_URI .'/css/prettyPhoto.css', false, THEME_VERSION, 'all' );
	
	wp_enqueue_style( 'animations',		THEME_URI .'/js/animations/animations.min.css', false, THEME_VERSION, 'all' );
	wp_enqueue_style( 'colorpicker',	THEME_URI .'/js/colorpicker/css/colorpicker.css', false, THEME_VERSION, 'all' );
	wp_enqueue_style( 'jplayer',		THEME_URI .'/css/jplayer/jplayer.blue.monday.css', false, THEME_VERSION, 'all' );
	wp_enqueue_style( 'jquery-ui', 		THEME_URI .'/css/ui/jquery.ui.all.css', false, THEME_VERSION, 'all' );
	
	// rtl | demo -----
	if( $_GET && key_exists('mmi-rtl', $_GET) ) wp_enqueue_style( 'rtl', THEME_URI .'/rtl.css', false, THEME_VERSION, 'all' );
	
	// Responsive -------------------------------------------------------------
	if( mmi_is_960() ){
		wp_enqueue_style( 'responsive-960', THEME_URI .'/css/responsive-960.css', false, THEME_VERSION, 'all' );
	} else {
		wp_enqueue_style( 'responsive-1240', THEME_URI .'/css/responsive-1240.css', false, THEME_VERSION, 'all' );
	}
	if( mmi_opts_get('responsive') ) wp_enqueue_style( 'responsive', THEME_URI .'/css/responsive.css', false, THEME_VERSION, 'all' );

	// Custom Theme Options styles --------------------------------------------
	if( $_GET && key_exists('mmi-c', $_GET) ){
		$skin = $_GET['mmi-c']; // demo
	} elseif( $layoutID = get_post_meta( mmi_ID(), 'mmi-post-custom-layout', true ) ) {
		$skin = get_post_meta( $layoutID, 'mmi-post-skin', true );
	} else {
		$skin = mmi_opts_get('skin','custom');
	}
	
	if( $skin == 'custom' ){
		
		// Custom Skin
		wp_enqueue_style( 'style-colors-php', THEME_URI .'/style-colors.php', false, THEME_VERSION, 'all' );
		
	} elseif( $skin == 'one' ){

		// One Click Skin Generator
		$color_one = ( $_GET && key_exists( 'mmi-o', $_GET )) ? $_GET['mmi-o'] : THEME_VERSION; // demo
		wp_enqueue_style( 'style-one-php', THEME_URI .'/style-one.php', false, $color_one, 'all' );
		
		
	} else {

		// Predefined Skins
		wp_enqueue_style( 'skin-'. $skin, THEME_URI .'/css/skins/'. $skin .'/style.css', false, THEME_VERSION, 'all' );
		
	}
	
	wp_enqueue_style( 'style-php', THEME_URI .'/style.php', false, THEME_VERSION, 'all' );	
	
}
add_action( 'wp_enqueue_scripts', 'mmi_styles' );


/* ---------------------------------------------------------------------------
 * Styles | HTML background
 * --------------------------------------------------------------------------- */
function mmi_styles_html_background()
{
	if( $layoutID = get_post_meta( mmi_ID(), 'mmi-post-custom-layout', true ) ){
		$bg_img = get_post_meta( $layoutID, 'mmi-post-bg', true );
		$bg_pos = get_post_meta( $layoutID, 'mmi-post-bg-pos', true );
	} else {
		$bg_img = mmi_opts_get( 'img-page-bg' );
		$bg_pos = mmi_opts_get( 'position-page-bg' );
	}

	if( $bg_img ){

		$aBg 	= array();
		$aBg[] 	= 'background-image:url('. $bg_img .')';

		if( $bg_pos ){
			$background_attr = explode( ';', $bg_pos );
			$aBg[] 	= 'background-repeat:'. $background_attr[0];
			$aBg[] 	= 'background-position:'. $background_attr[1];
			$aBg[] 	= 'background-attachment:'. $background_attr[2];
			$aBg[] 	= '-webkit-background-size:'. $background_attr[3];
			$aBg[] 	= 'background-size:'. $background_attr[3];
		}

		$background = implode('; ', $aBg );

		echo '<style>'."\n";
		echo 'html {'. $background. ';}'."\n";
		echo '</style>'."\n";
	}
}
add_action('wp_head', 'mmi_styles_html_background');


/* ---------------------------------------------------------------------------
 * Styles | Custom Styles
 * --------------------------------------------------------------------------- */
function mmi_styles_custom()
{
	// custom.css
	echo '<link rel="stylesheet" href="'. THEME_URI .'/css/custom.css?ver='.THEME_VERSION.'" media="all" />'."\n";
	
	// Thme Options > Custom CSS
	if( $custom_css = mmi_opts_get( 'custom-css' ) ){
		echo '<style>'."\n";
			echo $custom_css."\n";
		echo '</style>'."\n";
	}
	
	// Demo - Custom Google Fonts for Homepages
	if( $_GET && key_exists('mmi-f', $_GET) ){
		
		$font_slug = str_replace('+', ' ', $_GET['mmi-f']);
		$font_family = str_replace('+', ' ', $font_slug);
		
		wp_enqueue_style( $font_slug, 'http://fonts.googleapis.com/css?family='. $font_slug .':300,400' );
		
		echo '<style>';
			echo 'h1, h2, h3, h4 { font-family: '. $font_family .' !important;}';
		echo '</style>'."\n";
	}
}
add_action('wp_head', 'mmi_styles_custom');


/* ---------------------------------------------------------------------------
 * IE fix
 * --------------------------------------------------------------------------- */
function mmi_ie_fix() 
{
	if( ! is_admin() )
	{
		echo "\n".'<!--[if lt IE 9]>'."\n";
		echo '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>'."\n";
		echo '<![endif]-->'."\n";
	}	
}
add_action('wp_head', 'mmi_ie_fix');


/* ---------------------------------------------------------------------------
 * Scripts
 * --------------------------------------------------------------------------- */
function mmi_scripts() 
{
	if( ! is_admin() ) 
	{
		wp_enqueue_script( 'jquery-ui-core', 		THEME_URI .'/js/ui/jquery.ui.core.js', false, THEME_VERSION, true );
		wp_enqueue_script( 'jquery-ui-widget', 		THEME_URI .'/js/ui/jquery.ui.widget.js', false, THEME_VERSION, true );
		wp_enqueue_script( 'jquery-ui-tabs', 		THEME_URI .'/js/ui/jquery.ui.tabs.js', false, THEME_VERSION, true );
		wp_enqueue_script( 'jquery-ui-accordion',	THEME_URI .'/js/ui/jquery.ui.accordion.js', false, THEME_VERSION, true );

		wp_enqueue_script( 'jquery-animations',		THEME_URI. '/js/animations/animations.min.js', false, THEME_VERSION, true );
		wp_enqueue_script( 'jquery-jplayer', 		THEME_URI. '/js/jquery.jplayer.min.js', false, THEME_VERSION, true );
		wp_enqueue_script( 'jquery-colorpicker', 	THEME_URI. '/js/colorpicker/js/colorpicker.js', false, THEME_VERSION, true );

		wp_enqueue_script( 'jquery-plugins', 		THEME_URI. '/js/jquery.plugins.js', false, THEME_VERSION, true );
		wp_enqueue_script( 'jquery-mmi-menu', 		THEME_URI. '/js/mmi.menu.js', false, THEME_VERSION, true );
		
		// sliders config -----------------------------
		mmi_scripts_ajax();
		mmi_slider_config();
		wp_enqueue_script( 'jquery-scripts', 		THEME_URI. '/js/scripts.js', false, THEME_VERSION, true );

		if ( is_singular() && get_option( 'thread_comments' ) ){ 
			wp_enqueue_script( 'comment-reply' ); 
		}
	}
}
add_action('wp_enqueue_scripts', 'mmi_scripts');


/* ---------------------------------------------------------------------------
 * Retina logo
* --------------------------------------------------------------------------- */
function mmi_retina_logo()
{
	// logo - source
	if( $_GET && key_exists('mmi-l', $_GET) ){
		$retina_logo = THEME_URI .'/images/logo/retina-'. $_GET['mmi-l'] .'.png'; // demo
	} elseif( $layoutID = get_post_meta( mmi_ID(), 'mmi-post-custom-layout', true ) ){
		$retina_logo = get_post_meta( $layoutID, 'mmi-post-retina-logo-img', true );
	} else {
		$retina_logo = mmi_opts_get( 'retina-logo-img' );
	}
	
	if( $retina_logo ){
		echo '<script>'."\n";
		echo '//<![CDATA['."\n";
			echo 'jQuery(window).load(function(){'."\n";
				echo 'var retina = window.devicePixelRatio > 1 ? true : false;';
				echo 'if(retina){';
					echo 'var retinaEl = jQuery("#logo img");';
					echo 'var retinaLogoW = retinaEl.width();';
					echo 'var retinaLogoH = retinaEl.height();';
					echo 'retinaEl';
						echo '.attr("src","'. $retina_logo .'")';
						echo '.width(retinaLogoW)';
						echo '.height(retinaLogoH)';
				echo '}';
				echo '});'."\n";
			echo '//]]>'."\n";
		echo '</script>'."\n";
	}
}
add_action('wp_head', 'mmi_retina_logo');


/* ---------------------------------------------------------------------------
 * Ajax
* --------------------------------------------------------------------------- */
function mmi_scripts_ajax()
{
	echo '<script>'."\n";
		echo '//<![CDATA['."\n";
			echo 'window.mmi_ajax = "' . admin_url( 'admin-ajax.php' ) . '"'."\n";
		echo '//]]>'."\n";
	echo '</script>'."\n";
}


/* ---------------------------------------------------------------------------
 * Slider configuration
* --------------------------------------------------------------------------- */
function mmi_slider_config()
{	
	// Vertical
	$args_vertical = array(
		'autoplay'	=> intval( mmi_opts_get( 'slider-vertical-auto' ) ),
	);
	
	// Portfolio
	$args_portfolio = array(
		'autoPlay'	=> intval( mmi_opts_get( 'slider-portfolio-auto' ) ),
	);

	echo '<script>'."\n";
		echo '//<![CDATA['."\n";
		
			echo 'window.mmi_slider_vertical	= { autoplay:'. (int)$args_vertical['autoplay'] .' 	};'."\n";
			echo 'window.mmi_slider_portfolio 	= { autoPlay:'. (int)$args_portfolio['autoPlay'] .' };'."\n";
		
		echo '//]]>'."\n";
	echo '</script>'."\n";
}


/* ---------------------------------------------------------------------------
 * Adds classes to the array of body classes.
 * --------------------------------------------------------------------------- */
// header style ---------------------------------
function mmi_header_style(){
	$header = '';

	if( $_GET && key_exists('mmi-h', $_GET) ){
		$header_layout = $_GET['mmi-h']; // demo
	} elseif( $layoutID = get_post_meta( mmi_ID(), 'mmi-post-custom-layout', true ) ){
		$header_layout = get_post_meta( $layoutID, 'mmi-post-header-style', true );
	} elseif( mmi_opts_get('header-style') ){
		$header_layout =  mmi_opts_get('header-style');
	}

	if( strpos( $header_layout, ',' ) ){
		$a_header_layout = explode( ',', $header_layout );
		foreach( (array)$a_header_layout as $key => $val ){
			$a_header_layout[$key] = 'header-'. $val;
		}
		$header = implode(' ', $a_header_layout);
	} else {
		$header = 'header-'. $header_layout;
	}
	
	return $header;
}

// sidebar classes ------------------------------
function mmi_sidebar_classes()
{
	$classes = false;
	
	if( mmi_ID() ){
		
		if( get_post_type()=='post' && is_single() && mmi_opts_get('single-layout') ){
			// theme options - force layout for posts
			$layout = mmi_opts_get('single-layout');						
		} else {
			// post meta
			$layout = get_post_meta( mmi_ID(), 'mmi-post-layout', true);	
		}

		switch ( $layout ) {
			case 'left-sidebar':
				$classes = ' with_aside aside_left';
				break;
			case 'right-sidebar':
				$classes = ' with_aside aside_right';
				break;
		}
		
		// demo
		if( $_GET && key_exists('mmi-s', $_GET) ){
			if( $_GET['mmi-s'] ){
				$classes = ' with_aside aside_right';
			} else {
				$classes = false;
			}
		}
	}

	return $classes;
}

// body classes ---------------------------------
function mmi_body_classes( $classes )
{
	// custom layout ------------------
	$layoutID = get_post_meta( mmi_ID(), 'mmi-post-custom-layout', true );
	
	// template-slider ----------------
	if( ! is_404() && get_post_type()=='page' && $slider = get_post_meta( get_the_ID(), 'mmi-post-slider', true ) ){
		$classes[] = 'template-slider';
	}
	
	// sidebar classes ----------------
	$classes[] = mmi_sidebar_classes();

	// skin ---------------------------
	if( $_GET && key_exists('mmi-c', $_GET) ){
		$classes[] = 'color-'. $_GET['mmi-c']; // demo
	} elseif( $layoutID ){
		$classes[] = 'color-'. get_post_meta( $layoutID, 'mmi-post-skin', true );
	} else {
		$classes[] = 'color-'. mmi_opts_get('skin','custom');
	}
	
	// theme layout -------------------
	if( $_GET && key_exists('mmi-box', $_GET) ){
		$classes[] = 'layout-boxed'; // demo
	} elseif( $layoutID ){
		$classes[] = 'layout-'. get_post_meta( $layoutID, 'mmi-post-layout', true );
	} else {
		$classes[] = 'layout-'. mmi_opts_get('layout','full-width');
	}
	
	// header layout ------------------
	$classes[] = mmi_header_style();
	
	// minimalist header --------------
	if( $_GET && key_exists('mmi-min', $_GET) ){
		$classes[] = 'minimalist-header'; // demo
	} elseif( $layoutID ){
		if( get_post_meta( $layoutID, 'mmi-post-minimalist-header', true ) ) $classes[] = 'minimalist-header';
	} elseif( mmi_opts_get('minimalist-header') ) {
		$classes[] = 'minimalist-header';
	}
	
	// grid 960px ---------------------
	if( mmi_is_960() ) $classes[] = 'grid960';

	// sticky header ------------------
	if( mmi_opts_get('sticky-header') ) $classes[] = 'sticky-header';
	
	// page title ---------------------
	if( get_post_meta( mmi_ID(), 'mmi-post-hide-title', true ) ) $classes[] = 'hide-title-area';
	
	// rtl | demo ---------------------
	if( $_GET && key_exists('mmi-rtl', $_GET) ) $classes[] = 'rtl';

	return $classes;
}
add_filter( 'body_class', 'mmi_body_classes' );


/* ---------------------------------------------------------------------------
 * Annoying styles remover
 * --------------------------------------------------------------------------- */
function mmi_remove_recent_comments_style() {  
    global $wp_widget_factory;  
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );  
}  
add_action( 'widgets_init', 'mmi_remove_recent_comments_style' ); 

?>