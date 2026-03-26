<?php
/**
 * General custom meta fields.
 *
 * @package MM International
 * @author 
 * @link 
 */


/*-----------------------------------------------------------------------------------*/
/*	LIST of Categories for posts or specified taxonomy
/*-----------------------------------------------------------------------------------*/


function mmi_get_categories( $category ) {
	$categories = get_categories( array( 'taxonomy' => $category ));
	
	$array = array( '' => __( 'All', 'mmi-opts' ) );	
	foreach( $categories as $cat ){
		$array[$cat->slug] = $cat->name;
	}
		
	return $array;
}


/*-----------------------------------------------------------------------------------*/
/*	LIST of Sliders (Revolution Sliders)
/*-----------------------------------------------------------------------------------*/
function mmi_get_sliders( $all = false ) {
	global $wpdb;

	$sliders = array( 0 => __('-- Select --', 'mmi-opts') );
	
	// Muffin Slider for some themes
	if( $all ) $sliders['mmi-slider'] = __('- Muffin Slider -', 'mmi-opts');

	// Revolution Slider database table name
	$table_name = $wpdb->base_prefix . "revslider_sliders";
	
	$array = false;
	
	// check if Revolution Slider is activated
	if ( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$array = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title");
	}
	
	if( is_array( $array ) ){
		foreach( $array as $v ){
			$sliders[$v->alias] = $v->title;
		}
	}
	
	return $sliders;
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Single Muffin Options FIELD
/*-----------------------------------------------------------------------------------*/
function mmi_meta_field_input( $field, $meta ){
	global $mmi_Options;

	if( isset( $field['type'] ) ){		
		echo '<tr valign="top">';
		
			// Field Title & SubDescription
			echo '<th scope="row">';
				if( key_exists('title', $field) ) echo $field['title'];
				if( key_exists('sub_desc', $field) ) echo '<span class="description">'. $field['sub_desc'] .'</span>';
			echo '</th>';
			
			// Muffin Options Field & Description 
			echo '<td>';
				$field_class = 'mmi_Options_'.$field['type'];
				require_once( $mmi_Options->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php' );
				
				if( class_exists( $field_class ) ){
					$field_object = new $field_class( $field, $meta );
					$field_object->render(1);
				}
				
			echo '</td>';
			
		echo '</tr>';
	}
	
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Single Muffin Builder ITEM
/*-----------------------------------------------------------------------------------*/
function mmi_builder_item( $item_std, $item = false, $section_id = false ) {
	
	// input's 'name' only for existing items, not for items to clone
	$name_type 		= $item ? 'name="mmi-item-type[]"' : '';
	$name_size 		= $item ? 'name="mmi-item-size[]"' : '';
	$name_parent	= $item ? 'name="mmi-item-parent[]"' : '';
	
	$item_std['size'] = $item['size'] ? $item['size'] : $item_std['size'];
	$label = ( $item && key_exists('fields', $item) && key_exists('title', $item['fields']) ) ? $item['fields']['title'] : '';

	$classes = array(
		'1/4' => 'mmi-item-1-4',
		'1/3' => 'mmi-item-1-3',
		'1/2' => 'mmi-item-1-2',
		'2/3' => 'mmi-item-2-3',
		'3/4' => 'mmi-item-3-4',
		'1/1' => 'mmi-item-1-1'
	);
	
	echo '<div class="mmi-element mmi-item mmi-item-'. $item_std['type'] .' '. $classes[$item_std['size']] .'">';
							
		echo '<div class="mmi-element-content">';
			echo '<input type="hidden" class="mmi-item-type" '. $name_type .' value="'. $item_std['type'] .'">';
			echo '<input type="hidden" class="mmi-item-size" '. $name_size .' value="'. $item_std['size'] .'">';
			echo '<input type="hidden" class="mmi-item-parent" '. $name_parent .' value="'. $section_id .'" />';
			
			echo '<div class="mmi-element-header">';
				echo '<div class="mmi-item-size">';
					echo '<a class="mmi-element-btn mmi-item-size-dec" href="javascript:void(0);">-</a>';
					echo '<a class="mmi-element-btn mmi-item-size-inc" href="javascript:void(0);">+</a>';
					echo '<span class="mmi-item-desc">'. $item_std['size'] .'</span>';
				echo '</div>';
				echo '<div class="mmi-element-tools">';
					echo '<a class="mmi-element-btn mmi-fr mmi-element-edit" title="Edit" href="javascript:void(0);">E</a>';
					echo '<a class="mmi-element-btn mmi-fr mmi-element-clone mmi-item-clone" title="Clone" href="javascript:void(0);">C</a>';
					echo '<a class="mmi-element-btn mmi-fr mmi-element-delete" title="Delete" href="javascript:void(0);">D</a>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mmi-item-content">';
				echo '<div class="mmi-item-icon"></div>';
				echo '<span class="mmi-item-title">'. $item_std['title'] .'</span>';
				echo '<span class="mmi-item-label">'. $label .'</span>';
			echo '</div>';
	
		echo '</div>';
		
		echo '<div class="mmi-element-meta">';
			echo '<table class="form-table">';
				echo '<tbody>';		
		 
					// Fields for Item
					foreach( $item_std['fields'] as $field ){
							
						// values for existing items
						if( $item && key_exists( 'fields', $item ) && key_exists( $field['id'], $item['fields'] ) ){
							$meta = $item['fields'][$field['id']];
						} else {
							$meta = false;
						}
						
						if( ! key_exists('std', $field) ) $field['std'] = false;
						$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
						
						// field ID
						$field['id'] = 'mmi-items['. $item_std['type'] .']['. $field['id'] .']';	
						
						// field ID except accordion, faq & tabs
						if( $field['type'] != 'tabs' ){
							$field['id'] .= '[]';					
						}
						
						// PRINT Single Muffin Options FIELD
						mmi_meta_field_input( $field, $meta );
						
					}
		 
				echo '</tbody>';
			echo '</table>';
		echo '</div>';
	
	echo '</div>';						
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Single Muffin Builder SECTION
/*-----------------------------------------------------------------------------------*/
function mmi_builder_section( $item_std, $section_std, $section = false, $section_id = false ) {

	// input's 'name' only for existing sections, not for section to clone
	$name_row_id = $section ? 'name="mmi-row-id[]"' : '';
		
	echo '<div class="mmi-element mmi-row">';

		echo '<div class="mmi-element-content">';
		
			// Section ID
			echo '<input type="hidden" class="mmi-row-id" '. $name_row_id .' value="'. $section_id .'" />';

			echo '<div class="mmi-element-header">';
			echo '<div class="mmi-item-add">';
				echo '<a class="mmi-item-add-btn" href="javascript:void(0);">Add Item</a>';
					echo '<ul class="mmi-item-add-list">';
					
						// List of available Items
						foreach( $item_std as $item ){
							echo '<li><a class="'. $item['type'] .'" href="javascript:void(0);">'. $item['title'] .'</a></li>';
						}
					
					echo '</ul>';
				echo '</div>';
				echo '<div class="mmi-element-tools">';			
					echo '<a class="mmi-element-btn mmi-element-edit" title="Edit" href="javascript:void(0);">E</a>';
					echo '<a class="mmi-element-btn mmi-element-clone mmi-row-clone" title="Clone" href="javascript:void(0);">C</a>';
					echo '<a class="mmi-element-btn mmi-element-delete" title="Delete" href="javascript:void(0);">D</a>';
				echo '</div>';
			echo '</div>';
			
			// .mmi-element-droppable
			echo '<div class="mmi-droppable mmi-sortable clearfix">';

				// Existing Items for Section
				if( $section && key_exists('items', $section) && is_array($section['items']) ){
					foreach( $section['items'] as $item )
					{
						mmi_builder_item( $item_std[$item['type']], $item, $section_id );
					}
				}
		
			echo '</div>';

		echo '</div>';
		
		echo '<div class="mmi-element-meta">';
			echo '<table class="form-table" style="display: table;">';
				echo '<tbody>';
					
					// Fields for Section
					foreach( $section_std as $field ){

						// values for existing sections
						if( $section ){
							$meta = $section['attr'][$field['id']];
						} else {
							$meta = false;
						}
					
						if( ! key_exists('std', $field) ) $field['std'] = false;
						$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
					
						// field ID
						$field['id'] = 'mmi-rows['. $field['id'] .']';
					
						// field ID except accordion, faq & tabs
						if( $field['type'] != 'tabs' ){
							$field['id'] .= '[]';
						}
					
						// PRINT Single Muffin Options FIELD
						mmi_meta_field_input( $field, $meta );
						
					}
					
				echo '</tbody>';
			echo '</table>';
		echo '</div>';
		
	echo '</div>';

}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Muffin Builder
/*-----------------------------------------------------------------------------------*/
function mmi_builder_show() {
	global $post;


	// Entrance Animations -----------------------------------------------------------------------------
	$mmi_animate = array(
		'' 					=> '- Not Animated -',
		'fadeIn' 			=> 'Fade In',
		'fadeInUp' 			=> 'Fade In Up',
		'fadeInDown' 		=> 'Fade In Down ',
		'fadeInLeft' 		=> 'Fade In Left',
		'fadeInRight' 		=> 'Fade In Right ',
		'fadeInUpLarge' 	=> 'Fade In Up Large',
		'fadeInDownLarge' 	=> 'Fade In Down Large',
		'fadeInLeftLarge' 	=> 'Fade In Left Large',
		'fadeInRightLarge' 	=> 'Fade In Right Large',
		'zoomIn' 			=> 'Zoom In',
		'zoomInUp' 			=> 'Zoom In Up',
		'zoomInDown' 		=> 'Zoom In Down',
		'zoomInLeft' 		=> 'Zoom In Left',
		'zoomInRight' 		=> 'Zoom In Right',
		'zoomInUpLarge' 	=> 'Zoom In Up Large',
		'zoomInDownLarge' 	=> 'Zoom In Down Large',
		'zoomInLeftLarge' 	=> 'Zoom In Left Large',
		'bounceIn' 			=> 'Bounce In',
		'bounceInUp' 		=> 'Bounce In Up',
		'bounceInDown' 		=> 'Bounce In Down',
		'bounceInLeft' 		=> 'Bounce In Left',
		'bounceInRight' 	=> 'Bounce In Right',
	);
	
	// Default Fields for Section -----------------------------------------------------------------------------
	$mmi_std_section = array(
	
		array(
			'id'		=> 'bg_image',
			'type'		=> 'upload',
			'title'		=> __('Background Image', 'mmi-opts'),
		),
			
		array(
			'id' 		=> 'bg_position',
			'type' 		=> 'select',
			'title' 	=> __('Background Image position', 'mmi-opts'),
			'desc' 		=> __('This option can be used only with your custom image selected above.', 'mmi-opts'),
			'options' 	=> array(
				'no-repeat;center top;;'			=> 'Center Top No-Repeat',
				'repeat;center top;;'				=> 'Center Top Repeat',
				'no-repeat;center bottom;;'			=> 'Center Bottom No-Repeat',
				'no-repeat;center;;'				=> 'Center No-Repeat',
				'no-repeat;center;;cover'			=> 'Center No-Repeat Cover',
				'repeat;center;;'					=> 'Center Repeat',
				'no-repeat;center top;fixed;cover'	=> 'Parallax',				
			),
			'std' 		=> 'center top no-repeat',
		),
			
		array(
			'id' 		=> 'bg_color',
			'type' 		=> 'text',
			'title' 	=> __('Background Color', 'mmi-opts'),
			'desc' 		=> __('Use color name (eg. "gray") or hex (eg. "#808080").<br /><br />Leave this field blank if you want to use transparent background.', 'mmi-opts'),
			'class' 	=> 'small-text',
			'std' 		=> '',
		),
		
		array(
			'id' 		=> 'layout',
			'type' 		=> 'select',
			'title' 	=> __('Layout', 'mmi-opts'),
			'sub_desc'	=> __('Select layout for this section', 'mmi-opts'),
			'desc' 		=> __('<strong>Notice:</strong> Sidebar for section will show <strong>only</strong> if you set Full Width Page Layout in Page Options below Content Builder.', 'mmi-opts'),
			'options' 	=> array(
				'no-sidebar'	=> 'Full width. No sidebar',
				'left-sidebar'	=> 'Left Sidebar',
				'right-sidebar'	=> 'Right Sidebar'
			),
			'std' 		=> 'no-sidebar',
		),
		
		array(
			'id'		=> 'sidebar',
			'type' 		=> 'select',
			'title' 	=> __('Sidebar', 'mmi-opts'),
			'sub_desc' 	=> __('Select sidebar for this section', 'mmi-opts'),
			'options' 	=> mmi_opts_get( 'sidebars' ),
		),
		
		array(
			'id' 		=> 'padding_top',
			'type'		=> 'text',
			'title' 	=> __('Padding Top', 'mmi-opts'),
			'sub_desc'	=> __('Section Padding Top', 'mmi-opts'),
			'desc' 		=> __('px', 'mmi-opts'),
			'class' 	=> 'small-text',
			'std' 		=> '0',
		),
		
		array(
			'id' 		=> 'padding_bottom',
			'type'		=> 'text',
			'title' 	=> __('Padding Bottom', 'mmi-opts'),
			'sub_desc'	=> __('Section Padding Bottom', 'mmi-opts'),
			'desc' 		=> __('px', 'mmi-opts'),
			'class' 	=> 'small-text',
			'std' 		=> '0',
		),
		
		array(
			'id' 		=> 'style',
			'type' 		=> 'select',
			'title' 	=> __('Style', 'mmi-opts'),
			'sub_desc'	=> __('Predefined styles for section', 'mmi-opts'),
			'desc' 		=> __('For more advanced styles please use Custom CSS field below.', 'mmi-opts'),
			'options' 	=> array(
				'' 					=> 'Default',
				'dark' 				=> 'Dark',
				'highlight-left' 	=> 'Highlight Left',
				'highlight-right' 	=> 'Highlight Right',
				'full-width'	 	=> 'Full Width',
			),
			'std' 		=> 'no-sidebar',
		),
		
		array(
			'id' 		=> 'class',
			'type' 		=> 'text',
			'title' 	=> __('Custom CSS classes', 'mmi-opts'),
			'desc'		=> __('Multiple classes should be separated with SPACE.<br />For sections with centered text you can use class: <strong>center</strong>', 'mmi-opts'),
		),
		
		array(
			'id' 		=> 'section_id',
			'type' 		=> 'text',
			'title' 	=> __('Custom ID', 'mmi-opts'),
			'desc'		=> __('Use this option to create One Page sites.<br /><br />For example: Your Custom ID is <strong>offer</strong> and you want to open this section, please use link: <strong>your-url/#offer-2</strong>', 'mmi-opts'),
			'class' 	=> 'small-text',
		),
				
	);
	
	// Default Items with Fields -----------------------------------------------------------------------------
	$mmi_std_items = array(
	
		// Accordion  --------------------------------------------
		'accordion' => array(
			'type' => 'accordion',
			'title' => __('Accordion', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mmi-opts'),
				),
					
				array(
					'id' => 'tabs',
					'type' => 'tabs',
					'title' => __('Accordion', 'mmi-opts'),
					'sub_desc' => __('Manage accordion tabs.', 'mmi-opts'),
					'desc' => __('You can use Drag & Drop to set the order.', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'open1st',
					'type' 		=> 'select',
					'title' 	=> __('Open First', 'mmi-opts'),
					'desc' 		=> __('Open first tab at start.', 'mmi-opts'),
					'options'	=> array( 0 => 'No', 1 => 'Yes' ),
				),
					
				array(
					'id' 		=> 'style',
					'type' 		=> 'select',
					'title' 	=> __('Style', 'mmi-opts'),
					'options'	=> array( 
						'accordion'	=> 'Accordion',
						'toggle'	=> 'Toggle'
					),
				),
				
			),															
		),
			
		// Article box  --------------------------------------------
		'article_box' => array(
			'type' => 'article_box',
			'title' => __('Article box', 'mmi-opts'),
			'size' => '1/3',
			'fields' => array(
	
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Image', 'mmi-opts'),
					'sub_desc' 	=> __('Featured Image', 'mmi-opts'),
				),
			
				array(
					'id' 		=> 'slogan',
					'type' 		=> 'text',
					'title' 	=> __('Slogan', 'mmi-opts'),
				),
			
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
		
				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
				),
		
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title'		=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Blockquote --------------------------------------------
		'blockquote' => array(
			'type' => 'blockquote',
			'title' => __('Blockquote', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mmi-opts'),
					'sub_desc' => __('Blockquote content.', 'mmi-opts'),
					'desc' => __('HTML tags allowed.', 'mmi-opts')
				),
				
				array(
					'id' => 'author',
					'type' => 'text',
					'title' => __('Author', 'mmi-opts'),
				),
				
				array(
					'id' => 'link',
					'type' => 'text',
					'title' => __('Link', 'mmi-opts'),
					'sub_desc' => __('Link to company page.', 'mmi-opts'),
				),
				
				array(
					'id' => 'target',
					'type' => 'select',
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'title' => __('Open in new window', 'mmi-opts'),
					'sub_desc' => __('Open link in a new window.', 'mmi-opts'),
					'desc' => __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'style',
					'type'		=> 'select',
					'title'		=> 'Style',
					'options'	=> array(
						'classic'	=> 'Classic',
						'modern'	=> 'Modern',
					),
					'desc'		=> __('Classic - transparent background<br />Modern - with background color set in Theme Options', 'mmi-opts'),
				),
				
			),															
		),
		
		// Blog --------------------------------------------
		'blog' => array(
			'type' => 'blog',
			'title' => __('Blog', 'mmi-opts'), 
			'size' => '1/1', 
			'fields' => array(
		
				array(
					'id' 		=> 'count',
					'type' 		=> 'text',
					'title' 	=> __('Count', 'mmi-opts'),
					'sub_desc' 	=> __('Number of posts to show', 'mmi-opts'),
					'std' 		=> '2',
					'class' 	=> 'small-text',
				),

				array(
					'id' 		=> 'category',
					'type' 		=> 'select',
					'title' 	=> __('Category', 'mmi-opts'),
					'options' 	=> mmi_get_categories( 'category' ),
					'sub_desc' 	=> __('Select posts category', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'style',
					'type'		=> 'select',
					'title'		=> 'Style',
					'options'	=> array(
						'classic'	=> 'Classic',
						'masonry'	=> 'Masonry',
						'timeline'	=> 'Timeline',
					),
					'std'		=> 'classic',
				),
				
				array(
					'id' 		=> 'more',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Show Read More link', 'mmi-opts'),
					'std'		=> 1,
				),
				
				array(
					'id' 		=> 'pagination',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Show Pagination', 'mmi-opts'),
					'desc' 		=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'mmi-opts'),
				),
				
			),															
		),
		
		// Blog Slider --------------------------------------------
		'blog_slider' => array(
			'type' => 'blog_slider',
			'title' => __('Blog Slider', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
			
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
		
				array(
					'id' 		=> 'count',
					'type' 		=> 'text',
					'title' 	=> __('Count', 'mmi-opts'),
					'sub_desc' 	=> __('Number of posts to show', 'mmi-opts'),
					'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mmi-opts'),
					'std' 		=> '5',
					'class' 	=> 'small-text',
				),

				array(
					'id' 		=> 'category',
					'type' 		=> 'select',
					'title' 	=> __('Category', 'mmi-opts'),
					'options' 	=> mmi_get_categories( 'category' ),
					'sub_desc' 	=> __('Select posts category', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'more',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Show Read More button', 'mmi-opts'),
					'std'		=> 1,
				),
				
			),															
		),
		
		// Call to Action --------------------------------------------------
		'call_to_action' => array(
			'type' => 'call_to_action',
			'title' => __('Call to Action', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
			
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'icon',
					'type' 		=> 'text',
					'title' 	=> __('Icon', 'mmi-opts'),
					'desc' 		=> __('Font Icon, eg. <strong>icon-lamp</strong>', 'mmi-opts'),
					'class'		=> 'small-text',
					'std'		=> 'icon-lamp',
				),
				
				array(
					'id'		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
				),

				array(
					'id'		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'class',
					'type' 		=> 'text',
					'title' 	=> __('Class', 'mmi-opts'),
					'desc' 		=> __('This option is useful when you want to use PrettyPhoto (prettyphoto).', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'title' 	=> __('Open in new window', 'mmi-opts'),
					'desc'		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
				
			),
		),
		
		// Chart  --------------------------------------------------
		'chart' => array(
			'type' => 'chart',
			'title' => __('Chart', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
			
				array(
					'id' 		=> 'percent',
					'type' 		=> 'text',
					'title' 	=> __('Percent', 'mmi-opts'),
					'desc' 		=> __('Number between 0-100', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'label',
					'type' 		=> 'text',
					'title' 	=> __('Chart Label', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'icon',
					'type' 		=> 'text',
					'title' 	=> __('Chart Icon', 'mmi-opts'),
					'desc' 		=> __('Font Icon, eg. <strong> icon-lamp</strong>', 'mmi-opts'),
					'class'		=> 'small-text',
				),
				
				array(
					'id'		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Chart Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
		
			),
		),
		
		// Clients  --------------------------------------------
		'clients' => array(
			'type' => 'clients',
			'title' => __('Clients', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
	
				array(
					'id' 		=> 'in_row',
					'type' 		=> 'text',
					'title' 	=> __('Items in Row', 'mmi-opts'),
					'sub_desc' 	=> __('Number of items in row', 'mmi-opts'),
					'desc' 		=> __('Recommended number: 3-6', 'mmi-opts'),
					'std' 		=> 6,
					'class' 	=> 'small-text',
				),
				
				array(
					'id'		=> 'category',
					'type'		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'client-types' ),
					'sub_desc'	=> __('Select the client post category.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'style',
					'type' 		=> 'select',
					'options' 	=> array(
						''			=> 'Default',
						'tiles' 	=> 'Tiles',
					),
					'title' 	=> __('Style', 'mmi-opts'),
				),
	
			),
		),
		
		// Code  --------------------------------------------
		'code' => array(
			'type' => 'code',
			'title' => __('Code', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mmi-opts'),
					'class' => 'full-width',
					'validate' => 'html',
				),
				
			),															
		),
		
		// Column  --------------------------------------------
		'column' => array(
			'type' => 'column',
			'title' => __('Column', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
					'desc' 		=> __('This field is used as an Item Label in admin panel only and shows after page update.', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Column content', 'mmi-opts'),
					'desc' 		=> __('Shortcodes and HTML tags allowed.', 'mmi-opts'),
					'class' 	=> 'full-width',
					'validate' 	=> 'html',
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),

			),															
		),
		
		// Contact box --------------------------------------------
		'contact_box' => array(
			'type' => 'contact_box',
			'title' => __('Contact Box', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'address',
					'type' 		=> 'textarea',
					'title' 	=> __('Address', 'mmi-opts'),
					'desc' 		=> __('HTML tags allowed.', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'telephone',
					'type' 		=> 'text',
					'title' 	=> __('Telephone', 'mmi-opts'),
				),			
				
				array(
					'id' 		=> 'email',
					'type' 		=> 'text',
					'title' 	=> __('Email', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'www',
					'type' 		=> 'text',
					'title' 	=> __('WWW', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Background Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
				
			),															
		),
		
		// Content  --------------------------------------------
		'content' => array(
			'type' => 'content',
			'title' => __('Content WP', 'mmi-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' 		=> 'info',
					'type' 		=> 'info',
					'desc' 		=> __('Adding this Item will show Content from WordPress Editor above Page Options. You can use it only once per page. Please also remember to turn on "Hide The Content" option.', 'nhp-opts'),
				),

			),														
		),
		
		// Counter  --------------------------------------------------
		'counter' => array(
			'type' => 'counter',
			'title' => __('Counter', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' => 'icon',
					'type' => 'text',
					'title' => __('Icon', 'mmi-opts'),
					'desc' => __('Font Icon, eg. <strong> icon-lamp</strong>', 'mmi-opts'),
					'std' => ' icon-lamp',
					'class' => 'small-text',
				),
				
				array(
					'id' 		=> 'color',
					'type' 		=> 'text',
					'title' 	=> __('Icon Color', 'mmi-opts'),
					'desc' 		=> __('Use color name (eg. "blue") or hex (eg. "#2991D6").', 'mmi-opts'),
					'class' 	=> 'small-text',
				),

				array(
					'id' => 'image',
					'type' => 'upload',
					'title' => __('Image', 'mmi-opts'),
					'desc' => __('If you upload an image, icon will not show.', 'mmi-opts'),
				),
				
				array(
					'id' => 'number',
					'type' => 'text',
					'title' => __('Number', 'mmi-opts'),
				),
				
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'type',
					'type' 		=> 'select',
					'options' 	=> array(
						'horizontal'	=> 'Horizontal',
						'vertical' 		=> 'Vertical',
					),
					'title' 	=> __('Style', 'mmi-opts'),
					'std'		=> 'vertical',
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
		
			),
		),
	
		// Divider  --------------------------------------------
		'divider' => array(
			'type' => 'divider',
			'title' => __('Divider', 'mmi-opts'), 
			'size' => '1/1',
			'fields' => array(
		
				array(
					'id' 		=> 'height',
					'type' 		=> 'text',
					'title' 	=> __('Divider height', 'mmi-opts'),
					'desc' 		=> __('px', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'style',
					'type' 		=> 'select',
					'options' 	=> array( 
						'default'	=> 'Default',
						'dots'		=> 'Dots',
						'zigzag'	=> 'ZigZag',
					),
					'title' 	=> __('Style', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'line',
					'type' 		=> 'select',
					'options' 	=> array( 
						'default'	=> 'Default',
						'narrow'	=> 'Narrow',
						'wide'		=> 'Wide',
						''			=> 'No Line',
					),
					'title' 	=> __('Line', 'mmi-opts'),
					'desc' 		=> __('This option can be used <strong>only</strong> with Style: Default.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'themecolor',
					'type' 		=> 'select',
					'options' 	=> array( 
						0			=> 'No',
						1			=> 'Yes',
					),
					'title' 	=> __('Theme Color', 'mmi-opts'),
					'desc' 		=> __('This option can be used <strong>only</strong> with Style: Default.', 'mmi-opts'),
				),
				
			),														
		),	
		
		// Fancy Heading --------------------------------------------
		'fancy_heading' => array(
			'type' 		=> 'fancy_heading',
			'title' 	=> __('Fancy Heading', 'mmi-opts'),
			'size' 		=> '1/1',
			'fields' 	=> array(
			
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'h1',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Use H1 tag', 'mmi-opts'),
					'desc' 		=> __('Wrap title into H1 instead of H2', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'icon',
					'type' 		=> 'text',
					'title' 	=> __('Icon', 'mmi-opts'),
					'desc' 		=> __('Font Icon, eg. <strong> icon-lamp</strong>', 'mmi-opts'),
					'sub_desc' 	=> __('Icon Style only', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'slogan',
					'type' 		=> 'text',
					'title' 	=> __('Slogan', 'mmi-opts'),
					'sub_desc' 	=> __('Line Style only', 'mmi-opts'),
				),

				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
					'validate' 	=> 'html',
				),

				array(
					'id' 		=> 'style',
					'type' 		=> 'select',
					'options' 	=> array( 
						'icon'		=> 'Icon',
						'line'		=> 'Line',
						'arrows' 	=> 'Arrows',
					),
					'title' 	=> __('Style', 'mmi-opts'),
					'desc' 		=> __('Some fields above work on selected styles.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
		
			),
		),

		// FAQ  --------------------------------------------
		'faq' => array(
			'type' 		=> 'faq',
			'title' 	=> __('FAQ', 'mmi-opts'), 
			'size' 		=> '1/4', 
			'fields' 	=> array(
				
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'tabs',
					'type' 		=> 'tabs',
					'title' 	=> __('FAQ', 'mmi-opts'),
					'sub_desc' 	=> __('Manage FAQ tabs.', 'mmi-opts'),
					'desc' 		=> __('You can use Drag & Drop to set the order.', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'open1st',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Open First', 'mmi-opts'),
					'desc' 		=> __('Open first tab at start.', 'mmi-opts'),
				),
				
			),															
		),
		
		// Feature List --------------------------------------------
		'feature_list' => array(
			'type' => 'feature_list',
			'title' => __('Feature List', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
	
				array(
					'id' 	=> 'title',
					'type' 	=> 'text',
					'title' => __('Title', 'mmi-opts'),
					'desc' 	=> __('This field is used as an Item Label in admin panel only and shows after page update.', 'mmi-opts'),
				),
					
				array(
					'id' 	=> 'content',
					'type' 	=> 'textarea',
					'title' => __('Content', 'mmi-opts'),
					'desc' 	=> __('Please use <strong>[item icon="" title="" link=""]</strong> shortcodes here.', 'mmi-opts'),
					'std' 	=> '[item icon="icon-picture" title="Item title" link=""]',
				),
	
			),
		),
		
		// How It Works --------------------------------------------
		'how_it_works' => array(
			'type' => 'how_it_works',
			'title' => __('How It Works', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 	=> 'image',
					'type' 	=> 'upload',
					'title' => __('Background Image', 'mmi-opts'),
					'desc' => __('Recommended: Square Image with transparent background.', 'mmi-opts'),
				),
						
				array(
					'id' 	=> 'number',
					'type' 	=> 'text',
					'title' => __('Number', 'mmi-opts'),
					'class' => 'small-text',
				),

				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mmi-opts'),
				),

				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mmi-opts'),
					'validate' => 'html',
				),
				
				array(
					'id' 		=> 'border',
					'type' 		=> 'select',
					'title' 	=> __('Line', 'mmi-opts'),
					'sub_desc' 	=> __('Show right connecting line', 'mmi-opts'),
					'options' 	=> array(
						0 => 'No',
						1 => 'Yes'
					),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Icon Box  --------------------------------------------------
		'icon_box' => array(
			'type' => 'icon_box',
			'title' => __('Icon Box', 'mmi-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
				),
		
				array(
					'id' 		=> 'icon',
					'type' 		=> 'text',
					'title' 	=> __('Icon', 'mmi-opts'),
					'desc' 		=> __('Font Icon, eg. <strong> icon-lamp</strong>', 'mmi-opts'),
					'std' 		=> ' icon-lamp',
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'icon_position',
					'type' 		=> 'select',
					'options'	=> array(
						'left'	=> 'Left',
						'top'	=> 'Top',
					),
					'title' 	=> __('Icon Position', 'mmi-opts'),
					'std'		=> 'top',
				),
				
				array(
					'id' 		=> 'border',
					'type' 		=> 'select',
					'title' 	=> __('Border', 'mmi-opts'),
					'sub_desc' 	=> __('Show right border', 'mmi-opts'),
					'options' 	=> array(
						0 	=> 'No',
						1 	=> 'Yes'
					),
				),
				
				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
				
				array(
					'id' 		=> 'class',
					'type' 		=> 'text',
					'title' 	=> __('Custom CSS classes for link', 'mmi-opts'),
					'desc' 		=> __('This option is useful when you want to use PrettyPhoto (prettyphoto) or Scroll (scroll).', 'mmi-opts'),
				),

			),														
		),
			
		// Image  --------------------------------------------------
		'image' => array(
			'type' => 'image',
			'title' => __('Image', 'mmi-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' 		=> 'src',
					'type' 		=> 'upload',
					'title' 	=> __('Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'border',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Border', 'mmi-opts'),
					'sub_desc' 	=> __('Show Image Border', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'align',
					'type' 		=> 'select',
					'title' 	=> __('Align', 'mmi-opts'),
					'options' 	=> array( 
						'' 			=> 'None', 
						'left' 		=> 'Left', 
						'right' 	=> 'Right', 
						'center' 	=> 'Center', 
					),
				),
				
				array(
					'id' 		=> 'margin',
					'type' 		=> 'text',
					'title' 	=> __('Margin Top', 'mmi-opts'),
					'desc' 		=> __('px', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'alt',
					'type' 		=> 'text',
					'title' 	=> __('Alternate Text', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'caption',
					'type' 		=> 'text',
					'title' 	=> __('Caption', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'link_image',
					'type' 		=> 'upload',
					'title' 	=> __('Zoomed image', 'mmi-opts'),
					'desc' 		=> __('This image will be opened in lightbox.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
					'desc' 		=> __('This link will work only if you leave the above "Zoomed image" field empty.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),

			),														
		),
		
		// Info box --------------------------------------------
		'info_box' => array(
			'type' => 'info_box',
			'title' => __('Info Box', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title'		=> __('Title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
					'desc' 		=> __('HTML tags allowed.', 'mmi-opts'),
					'std' 		=> '<ul><li>list item 1</li><li>list item 2</li></ul>',
				),

				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Background Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// List --------------------------------------------
		'list' => array(
			'type' 		=> 'list',
			'title'		=> __('List', 'mmi-opts'),
			'size'		=> '1/4',
			'fields'	=> array(
	
				array(
					'id' 		=> 'icon',
					'type' 		=> 'text',
					'title' 	=> __('Icon', 'mmi-opts'),
					'desc' 		=> __('Font Icon, eg. <strong> icon-lamp</strong>', 'mmi-opts'),
					'std' 		=> ' icon-lamp',
					'class'		=> 'small-text',
				),
				
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
				),

				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
					'desc' 		=> __('This link will work only if you leave the above "Zoomed image" field empty.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',	
					'title' 	=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
				),
				
				array(
					'id' 		=> 'style',
					'type' 		=> 'select',	
					'title' 	=> __('Style', 'mmi-opts'),
					'options' 	=> array( 
						1 => 'With background',
						2 => 'Transparent',
						3 => 'Vertical',
						4 => 'Ordered list',
					),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
				
			),
		),
		
		// Map ---------------------------------------------
		'map' => array(
			'type' => 'map',
			'title' => __('Map', 'mmi-opts'), 
			'size' => '1/4',
			'fields' => array(

				array(
					'id' => 'lat',
					'type' => 'text',
					'title' => __('Google Maps Lat', 'mmi-opts'),
					'class' => 'small-text',
					'desc' => __('The map will appear only if this field is filled correctly.', 'mmi-opts'), 
				),
				
				array(
					'id' => 'lng',
					'type' => 'text',
					'title' => __('Google Maps Lng', 'mmi-opts'),
					'class' => 'small-text',
					'desc' => __('The map will appear only if this field is filled correctly.', 'mmi-opts'), 
				),
	
				array(
					'id' 		=> 'zoom',
					'type' 		=> 'text',
					'title' 	=> __('Zoom', 'mmi-opts'),
					'class' 	=> 'small-text',
					'std' 		=> 13,
				),
				
				array(
					'id' 		=> 'height',
					'type' 		=> 'text',
					'title' 	=> __('Height', 'mmi-opts'),
					'class' 	=> 'small-text',
					'std' 		=> 200,
				),
	
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Address Box Title', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Address Box Content', 'mmi-opts'),
					'desc' 		=> __('HTML tags allowed.', 'mmi-opts'),
				),
				
			),														
		),
		
		// Offer --------------------------------------------
		'offer' => array(
			'type' => 'offer',
			'title' => __('Offer', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
	
				array(
					'id' 		=> 'info',
					'type' 		=> 'info',
					'desc' 		=> __('This item can only be used on pages <strong>Without Sidebar</strong>.<br />Please also set Section Style to <strong>Full Width</strong> and use one Item in one Section.', 'nhp-opts'),
				),
				
				array(
					'id'		=> 'category',
					'type'		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'offer-types' ),
					'sub_desc'	=> __('Select the offer post category.', 'mmi-opts'),
				),
	
			),
		),
		
		// Opening Hours --------------------------------------------
		'opening_hours' => array(
			'type' => 'opening_hours',
			'title' => __('Opening Hours', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
					'desc' 		=> __('HTML tags allowed.', 'mmi-opts'),
					'std' 		=> '<ul><li><label>Monday - Saturday</label><span>8am - 4pm</span></li></ul>',
				),

				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Background Image', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Our team --------------------------------------------
		'our_team' => array(
			'type' => 'our_team',
			'title' => __('Our Team', 'mmi-opts'), 
			'size' => '1/4',
			'fields' => array(
				
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title' 	=> __('Photo', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
					'sub_desc' 	=> __('Will also be used as the image alternative text', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'subtitle',
					'type' 		=> 'text',
					'title' 	=> __('Subtitle', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'phone',
					'type' 		=> 'text',
					'title' 	=> __('Phone', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'content',
					'type'		=> 'textarea',
					'title'		=> __('Content', 'mmi-opts'),
				),

				array(
					'id' 		=> 'email',
					'type' 		=> 'text',
					'title' 	=> __('E-mail', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'facebook',
					'type' 		=> 'text',
					'title' 	=> __('Facebook', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'twitter',
					'type' 		=> 'text',
					'title' 	=> __('Twitter', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'linkedin',
					'type' 		=> 'text',
					'title' 	=> __('LinkedIn', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'style',
					'type' 		=> 'select',
					'options'	=> array(
						'circle'		=> 'Circle',
						'vertical'		=> 'Vertical',
						'horizontal'	=> 'Horizontal 	[only: 1/2]',
					),
					'title' 	=> __('Style', 'mmi-opts'),
					'std'		=> 'vertical',
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
				
			),														
		),
		
		// Our team list --------------------------------------------
		'our_team_list' => array(
			'type' => 'our_team_list',
			'title' => __('Our Team List', 'mmi-opts'), 
			'size' => '1/1',
			'fields' => array(
				
				array(
					'id' => 'image',
					'type' => 'upload',
					'title' => __('Photo', 'mmi-opts'),
				),
				
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mmi-opts'),
					'sub_desc' => __('Will also be used as the image alternative text', 'mmi-opts'),
				),
				
				array(
					'id' => 'subtitle',
					'type' => 'text',
					'title' => __('Subtitle', 'mmi-opts'),
				),
				
				array(
					'id' => 'phone',
					'type' => 'text',
					'title' => __('Phone', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'content',
					'type'		=> 'textarea',
					'title'		=> __('Content', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'blockquote',
					'type'		=> 'textarea',
					'title'		=> __('Blockquote', 'mmi-opts'),
				),
				
				array(
					'id' => 'email',
					'type' => 'text',
					'title' => __('E-mail', 'mmi-opts'),
				),
				
				array(
					'id' => 'facebook',
					'type' => 'text',
					'title' => __('Facebook', 'mmi-opts'),
				),
				
				array(
					'id' => 'twitter',
					'type' => 'text',
					'title' => __('Twitter', 'mmi-opts'),
				),
				
				array(
					'id' => 'linkedin',
					'type' => 'text',
					'title' => __('LinkedIn', 'mmi-opts'),
				),
				
			),														
		),
		
		// Photo Box --------------------------------------------
		'photo_box' => array(
			'type' => 'photo_box',
			'title' => __('Photo Box', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id'		=> 'title',
					'type'		=> 'text',
					'title'		=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'image',
					'type'		=> 'upload',
					'title'		=> __('Image', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'content',
					'type'		=> 'textarea',
					'title'		=> __('Content', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'link',
					'type'		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'title' 	=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
					'options'	=> array( 0 => 'No', 1 => 'Yes' ),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Portfolio --------------------------------------------
		'portfolio' => array(
			'type' => 'portfolio',
			'title' => __('Portfolio', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
	
				array(
					'id'		=> 'count',
					'type'		=> 'text',
					'title'		=> __('Count', 'mmi-opts'),
					'std'		=> '2',
					'class'		=> 'small-text',
				),

				array(
					'id'		=> 'category',
					'type'		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'portfolio-types' ),
					'sub_desc'	=> __('Select the portfolio post category.', 'mmi-opts'),
				),

				array(
					'id'		=> 'style',
					'type'		=> 'select',
					'title'		=> 'Style',
					'options' 	=> array(
						'list'		=> 'List',
						'flat'		=> 'Flat',
						'grid'		=> 'Grid',
						'masonry'	=> 'Masonry',
					),
					'std' 		=> 'grid'	
				),
				
				array(
					'id'		=> 'orderby',
					'type'		=> 'select',
					'title'		=> __('Order by', 'mmi-opts'),
					'sub_desc'	=> __('Portfolio items order by column.', 'mmi-opts'),
					'options' 	=> array(
						'date'			=> 'Date', 
						'menu_order' 	=> 'Menu order',			
						'title'			=> 'Title',
						'rand'			=> 'Random',
					),
					'std'		=> 'date'
				),
				
				array(
					'id'		=> 'order',
					'type'		=> 'select',
					'title'		=> __('Order', 'mmi-opts'),
					'sub_desc'	=> __('Portfolio items order.', 'mmi-opts'),
					'options'	=> array(
						'ASC' 	=> 'Ascending',
						'DESC' 	=> 'Descending',
					),
					'std'		=> 'DESC'
				),

				array(
					'id' 		=> 'pagination',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title' 	=> __('Show pagination', 'mmi-opts'),
					'desc'		=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'mmi-opts'),
				),
	
			),
		),
		
		// Portfolio Grid --------------------------------------------
		'portfolio_grid' => array(
			'type' => 'portfolio_grid',
			'title' => __('Portfolio Grid', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
			
				array(
					'id'		=> 'count',
					'type'		=> 'text',
					'title'		=> __('Count', 'mmi-opts'),
					'std'		=> '4',
					'class'		=> 'small-text',
				),
		
				array(
					'id'		=> 'category',
					'type'		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'portfolio-types' ),
					'sub_desc'	=> __('Select the portfolio post category.', 'mmi-opts'),
				),
		
				array(
					'id'		=> 'orderby',
					'type'		=> 'select',
					'title'		=> __('Order by', 'mmi-opts'),
					'sub_desc'	=> __('Portfolio items order by column.', 'mmi-opts'),
					'options' 	=> array(
						'date'			=> 'Date', 
						'menu_order' 	=> 'Menu order',			
						'title'			=> 'Title',
						'rand'			=> 'Random',
					),
					'std'		=> 'date'
				),
				
				array(
					'id'		=> 'order',
					'type'		=> 'select',
					'title'		=> __('Order', 'mmi-opts'),
					'sub_desc'	=> __('Portfolio items order.', 'mmi-opts'),
					'options'	=> array(
						'ASC' 	=> 'Ascending',
						'DESC' 	=> 'Descending',
					),
					'std'		=> 'DESC'
				),

			),
		),
		
		// Portfolio Slider --------------------------------------------
		'portfolio_slider' => array(
			'type' => 'portfolio_slider',
			'title' => __('Portfolio Slider', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
			
				array(
					'id'		=> 'count',
					'type'		=> 'text',
					'title'		=> __('Count', 'mmi-opts'),
					'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mmi-opts'),
					'std'		=> '6',
					'class'		=> 'small-text',
				),
		
				array(
					'id'		=> 'category',
					'type'		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'portfolio-types' ),
					'sub_desc'	=> __('Select the portfolio post category.', 'mmi-opts'),
				),
		
				array(
					'id'		=> 'orderby',
					'type'		=> 'select',
					'title'		=> __('Order by', 'mmi-opts'),
					'sub_desc'	=> __('Portfolio items order by column.', 'mmi-opts'),
					'options'	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std'		=> 'date'
				),

				array(
					'id'		=> 'order',
					'type'		=> 'select',
					'title'		=> __('Order', 'mmi-opts'),
					'sub_desc'	=> __('Portfolio items order.', 'mmi-opts'),
					'options'	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std'		=> 'DESC'
				),

			),
		),
		
		// Pricing item --------------------------------------------
		'pricing_item' => array(
			'type' => 'pricing_item',
			'title' => __('Pricing Item', 'mmi-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
					'sub_desc' 	=> __('Pricing item title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'price',
					'type' 		=> 'text',
					'title' 	=> __('Price', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'currency',
					'type'		=> 'text',
					'title' 	=> __('Currency', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
					
				array(
					'id' 		=> 'period',
					'type' 		=> 'text',
					'title' 	=> __('Period', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id'		=> 'subtitle',
					'type'		=> 'text',
					'title'		=> __('Subtitle', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
					'desc' 		=> __('HTML tags allowed.', 'mmi-opts'),
					'std' 		=> '<ul><li><strong>List</strong> item</li></ul>',
				),
				
				array(
					'id' 		=> 'link_title',
					'type' 		=> 'text',
					'title' 	=> __('Link title', 'mmi-opts'),
					'desc' 		=> __('Link will appear only if this field will be filled.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
					'desc' 		=> __('Link will appear only if this field will be filled.', 'mmi-opts'),
				),

				array(
					'id' 		=> 'featured',
					'type' 		=> 'select',
					'title' 	=> __('Featured', 'mmi-opts'),
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
				),
				
				array(
					'id' 		=> 'style',
					'type' 		=> 'select',
					'title' 	=> __('Style', 'mmi-opts'),
					'options' 	=> array( 
						'box'	=> 'Box',
						'label'	=> 'Table Label',
						'table'	=> 'Table',	
					),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
				
			),														
		),
		
		// Progress Bars  --------------------------------------------
		'progress_bars' => array(
			'type' => 'progress_bars',
			'title' => __('Progress Bars', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mmi-opts'),
				),
					
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mmi-opts'),
					'desc' => __('Please use <strong>[bar title="Title" value="50"]</strong> shortcodes here.', 'mmi-opts'),
					'std' => '[bar title="Bar1" value="50"]'."\n".'[bar title="Bar2" value="60"]',
				),
	
			),
		),
		
		// Promo Box --------------------------------------------
		'promo_box' => array(
			'type'		=> 'promo_box',
			'title'		=> __('Promo Box', 'mmi-opts'),
			'size'		=> '1/2',
			'fields'	=> array(

				array(
					'id'		=> 'image',
					'type'		=> 'upload',
					'title'		=> __('Image', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'title',
					'type'		=> 'text',
					'title'		=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'content',
					'type'		=> 'textarea',
					'title'		=> __('Content', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'btn_text',
					'type' 		=> 'text',
					'title' 	=> __('Button Text', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				array(
					'id' 		=> 'btn_link',
					'type' 		=> 'text',
					'title' 	=> __('Button Link', 'mmi-opts'),
					'class' 	=> 'small-text',
				),
				
				array(
					'id' 		=> 'position',
					'type' 		=> 'select',
					'title' 	=> __('Image position', 'mmi-opts'),
					'options' 	=> array(
						'left' 	=> 'Left',
						'right' => 'Right'
					),
					'std'		=> 'left',
				),
				
				array(
					'id' 		=> 'border',
					'type' 		=> 'select',
					'title' 	=> __('Border', 'mmi-opts'),
					'sub_desc' 	=> __('Show right border', 'mmi-opts'),
					'options' 	=> array(
						'no_border'		=> 'No',
						'has_border'	=> 'Yes'
					),
					'std'		=> 'no_border',
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'title' 	=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),

			),
		),
		
		// Quick Fact --------------------------------------------
		'quick_fact' => array(
			'type' => 'quick_fact',
			'title' => __('Quick Fact', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 		=> 'number',
					'type' 		=> 'text',
					'title'		=> __('Number', 'mmi-opts'),
					'class'		=> 'small-text',
				),

				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Content', 'mmi-opts'),
					'validate' 	=> 'html',
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Shop Slider --------------------------------------------
		'shop_slider' => array(
			'type' 		=> 'shop_slider',
			'title' 	=> __('Shop Slider', 'mmi-opts'),
			'size' 		=> '1/4',
			'fields' 	=> array(
					
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'count',
					'type' 		=> 'text',
					'title' 	=> __('Count', 'mmi-opts'),
					'sub_desc' 	=> __('Number of posts to show', 'mmi-opts'),
					'desc'		=> __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mmi-opts'),
					'std' 		=> '5',
					'class' 	=> 'small-text',
				),
			
				array(
					'id' 		=> 'category',
					'type' 		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'product_cat' ),
					'sub_desc'	=> __('Select the products category', 'mmi-opts'),
				),

				array(
					'id' 		=> 'orderby',
					'type' 		=> 'select',
					'title' 	=> __('Order by', 'mmi-opts'),
					'sub_desc' 	=> __('Slides order by column', 'mmi-opts'),
					'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std' 		=> 'date'
				),

				array(
					'id' 		=> 'order',
					'type' 		=> 'select',
					'title' 	=> __('Order', 'mmi-opts'),
					'sub_desc' 	=> __('Slides order', 'mmi-opts'),
					'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std' 		=> 'DESC'
				),
	
			),
		),
		
		// Sidebar Widget --------------------------------------------
		'sidebar_widget' => array(
			'type' 		=> 'sidebar_widget',
			'title' 	=> __('Sidebar Widget', 'mmi-opts'),
			'size' 		=> '1/4',
			'fields' 	=> array(
				
				array(
					'id'		=> 'sidebar',
					'type' 		=> 'select',
					'title' 	=> __('Select Sidebar', 'mmi-opts'),
					'desc' 		=> __('1. Create Sidebar in Theme Options > Getting Started > Sidebars.<br />2. Add Widget.<br />3. Select your sidebar.', 'mmi-opts'),
					'options' 	=> mmi_opts_get( 'sidebars' ),
				),
	
			),
		),
		
		// Slider --------------------------------------------
		'slider' => array(
			'type' 		=> 'slider',
			'title' 	=> __('Slider', 'mmi-opts'),
			'size' 		=> '1/1',
			'fields' 	=> array(
				
				array(
					'id' 		=> 'category',
					'type' 		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'slide-types' ),
					'sub_desc'	=> __('Select the slides category', 'mmi-opts'),
				),

				array(
					'id' 		=> 'orderby',
					'type' 		=> 'select',
					'title' 	=> __('Order by', 'mmi-opts'),
					'sub_desc' 	=> __('Slides order by column', 'mmi-opts'),
					'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std' 		=> 'date'
				),

				array(
					'id' 		=> 'order',
					'type' 		=> 'select',
					'title' 	=> __('Order', 'mmi-opts'),
					'sub_desc' 	=> __('Slides order', 'mmi-opts'),
					'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std' 		=> 'DESC'
				),
	
			),
		),
		
		// Sliding Box --------------------------------------------
		'sliding_box' => array(
			'type' => 'sliding_box',
			'title' => __('Sliding Box', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title'		=> __('Image', 'mmi-opts'),
				),

				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title'		=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Tabs --------------------------------------------
		'tabs' => array(
			'type' => 'tabs',
			'title' => __('Tabs', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),
			
				array(
					'id' 		=> 'tabs',
					'type' 		=> 'tabs',
					'title' 	=> __('Tabs', 'mmi-opts'),
					'sub_desc' 	=> __('To add an <strong>icon</strong> in Title field, please use the following code:<br/><br/>&lt;i class=" icon-lamp"&gt;&lt;/i&gt; Tab Title', 'mmi-opts'),
					'desc' 		=> __('You can use Drag & Drop to set the order.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'type',
					'type' 		=> 'select',
					'options' 	=> array(
						'horizontal'	=> 'Horizontal',
						'vertical' 		=> 'Vertical', 
					),
					'title' 	=> __('Style', 'mmi-opts'),
					'desc' 		=> __('Vertical tabs works only for column widths: 1/2, 3/4 & 1/1', 'mmi-opts'),
				),
				
				array(
					'id'		=> 'uid',
					'type'		=> 'text',
					'title'		=> __('Unique ID [optional]', 'mmi-opts'),
					'sub_desc'	=> __('Allowed characters: "a-z" "-" "_"', 'mmi-opts'),
					'desc'		=> __('Use this option if you want to open specified tab from link.<br />For example: Your Unique ID is <strong>offer</strong> and you want to open 2nd tab, please use link: <strong>your-url/#offer-2</strong>', 'mmi-opts'),
				),
				
			),															
		),
			
		// Testimonials --------------------------------------------
		'testimonials' => array(
			'type' => 'testimonials',
			'title' => __('Testimonials', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
				
				array(
					'id' 		=> 'category',
					'type' 		=> 'select',
					'title'		=> __('Category', 'mmi-opts'),
					'options'	=> mmi_get_categories( 'testimonial-types' ),
					'sub_desc'	=> __('Select the testimonial post category.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'orderby',
					'type' 		=> 'select',
					'title' 	=> __('Order by', 'mmi-opts'),
					'sub_desc' 	=> __('Testimonials order by column.', 'mmi-opts'),
					'options' 	=> array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std' 		=> 'date'
				),
				
				array(
					'id' 		=> 'order',
					'type' 		=> 'select',
					'title' 	=> __('Order', 'mmi-opts'),
					'sub_desc' 	=> __('Testimonials order.', 'mmi-opts'),
					'options' 	=> array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std' 		=> 'DESC'
				),
	
			),
		),
		
		// Timeline --------------------------------------------
		'timeline' => array(
			'type' => 'timeline',
			'title' => __('Timeline', 'mmi-opts'),
			'size' => '1/1',
			'fields' => array(
		
				array(
					'id' => 'tabs',
					'type' => 'tabs',
					'title' => __('Timeline', 'mmi-opts'),
					'sub_desc' => __('Please add <strong>date</strong> wrapped into <strong>span</strong> tag in Title field.<br/><br/>&lt;span&gt;2013&lt;/span&gt;Event Title', 'mmi-opts'),
					'desc' => __('You can use Drag & Drop to set the order.', 'mmi-opts'),
				),
		
			),
		),
		
		// Trailer Box --------------------------------------------
		'trailer_box' => array(
			'type' => 'trailer_box',
			'title' => __('Trailer Box', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 		=> 'image',
					'type' 		=> 'upload',
					'title'		=> __('Image', 'mmi-opts'),
				),

				array(
					'id' 		=> 'slogan',
					'type' 		=> 'text',
					'title' 	=> __('Slogan', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
				),

				array(
					'id' 		=> 'link',
					'type' 		=> 'text',
					'title' 	=> __('Link', 'mmi-opts'),
				),

				array(
					'id' 		=> 'target',
					'type' 		=> 'select',
					'options' 	=> array( 0 => 'No', 1 => 'Yes' ),
					'title'		=> __('Open in new window', 'mmi-opts'),
					'desc' 		=> __('Adds a target="_blank" attribute to the link.', 'mmi-opts'),
				),
				
				array(
					'id' 		=> 'animate',
					'type' 		=> 'select',
					'title' 	=> __('Animation', 'mmi-opts'),
					'sub_desc' 	=> __('Entrance animation', 'mmi-opts'),
					'options' 	=> $mmi_animate,
				),
	
			),
		),
		
		// Video  --------------------------------------------
		'video' => array(
			'type' => 'video',
			'title' => __('Video', 'mmi-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' 		=> 'video',
					'type' 		=> 'text',
					'title' 	=> __('Video ID', 'mmi-opts'),
					'sub_desc' 	=> __('YouTube or Vimeo', 'mmi-opts'),
					'desc' 		=> __('It`s placed in every YouTube & Vimeo video, for example:<br /><br /><b>YouTube:</b> http://www.youtube.com/watch?v=<u>WoJhnRczeNg</u><br /><b>Vimeo:</b> http://vimeo.com/<u>62954028</u>', 'mmi-opts'),
					'class' 	=> 'small-text'
				),
				
				array(
					'id' => 'width',
					'type' => 'text',
					'title' => __('Width', 'mmi-opts'),
					'desc' => __('px', 'mmi-opts'),
					'class' => 'small-text',
					'std' => 700,
				),
				
				array(
					'id' => 'height',
					'type' => 'text',
					'title' => __('Height', 'mmi-opts'),
					'desc' => __('px', 'mmi-opts'),
					'class' => 'small-text',
					'std' => 400,
				),
				
			),	
		),
		
		// Visual Editor  --------------------------------------------
		'visual' => array(
			'type' => 'visual',
			'title' => __('Visual Editor', 'mmi-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' 		=> 'title',
					'type' 		=> 'text',
					'title' 	=> __('Title', 'mmi-opts'),
					'desc' 		=> __('This field is used as an Item Label in admin panel only and shows after page update.', 'mmi-opts'),
				),
					
				array(
					'id' 		=> 'content',
					'type' 		=> 'textarea',
					'title' 	=> __('Visual Editor', 'mmi-opts'),
					'class' 	=> 'editor',
					'validate' 	=> 'html',
				),
	
			),
		),
		
	);
	
	// GET Sections & Items
	$mmi_items = get_post_meta($post->ID, 'mmi-page-items', true);
	$mmi_tmp_fn = 'base'.'64_decode';
	$mmi_items = unserialize(call_user_func($mmi_tmp_fn, $mmi_items));

	// OLD Content Builder 1.0 Compatibility
	if( is_array( $mmi_items ) && ! key_exists( 'attr', $mmi_items[0] ) ){
		$mmi_items_builder2 = array(
			'attr'	=> $mmi_std_section,
			'items'	=> $mmi_items
		);
		$mmi_items = array( $mmi_items_builder2 );
	}

// 	print_r($mmi_items);
	$mmi_sections_count = is_array( $mmi_items ) ? count( $mmi_items ) : 0;	
	
	?>
	<div id="mmi-builder">
		<input type="hidden" id="mmi-row-id" value="<?php echo $mmi_sections_count; ?>" />
		<a id="mmi-go-to-top" href="javascript:void(0);">Go to top</a>
	
		<div id="mmi-content">
		
		
			<!-- .mmi-row-add ================================================ -->			
			<div class="mmi-row-add">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<td>
								<a class="btn-blue mmi-row-add-btn" href="javascript:void(0);"><em></em>Add Section</a>
								<div class="logo">Muffin Group | Muffin Builder</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			
			<!-- #mmi-desk ================================================== -->
			<div id="mmi-desk" class="clearfix">
			
				<?php
					for( $i = 0; $i < $mmi_sections_count; $i++ ) {
						mmi_builder_section( $mmi_std_items, $mmi_std_section, $mmi_items[$i], $i+1 );
					}
				?>
			
			</div>
			
			
			<!-- #mmi-rows ================================================= -->
			<div id="mmi-rows" class="clearfix">
				<?php mmi_builder_section( $mmi_std_items, $mmi_std_section ); ?>
			</div>
						
			
			<!-- #mmi-items =============================================== -->
			<div id="mmi-items" class="clearfix">
				<?php
					foreach( $mmi_std_items as $item ){
						mmi_builder_item( $item );
					}
				?>				
			</div>
	
		</div>
		
		<!-- #mmi-popup -->
		<div id="mmi-popup">
			<a href="javascript:void(0);" class="mmi-btn-close mmi-popup-close">Close</a>	
			<a href="javascript:void(0);" class="mmi-popup-save">Save changes</a>	
		</div>
		
		<!-- #mmi-items-seo -->
		<div id="mmi-items-seo">
			<?php 
				$mmi_items_seo = get_post_meta($post->ID, 'mmi-page-items-seo', true);
				echo '<textarea id="mmi-items-seo-data">'. $mmi_items_seo .'</textarea>'; 
			?>
		</div>
		
	</div>
	<?php 

}


/*-----------------------------------------------------------------------------------*/
/*	SAVE Muffin Builder
/*-----------------------------------------------------------------------------------*/
function mmi_builder_save($post_id) {

	$mmi_items = array();
// 	print_r($_POST);

	
	// sections loop -------------------------------------------------------------
	if( key_exists('mmi-row-id', $_POST) && is_array($_POST['mmi-row-id']))
	{
		// foreach $_POST['mmi-row-id']
		foreach( $_POST['mmi-row-id'] as $sectionID_k => $sectionID )
		{
			$section = array();
				
			// $section['attr'] - section attributes
			if( key_exists('mmi-rows', $_POST) && is_array($_POST['mmi-rows'])){
				foreach ( $_POST['mmi-rows'] as $section_attr_k => $section_attr ){
					$section['attr'][$section_attr_k] = $section_attr[$sectionID_k];
				}
			}
				
			// $section['items'] - section items will be added in the next foreach
			$section['items'] = '';
				
			$mmi_items[] = $section;
		}
	
		$newParentSectionIDs = array_flip( $_POST['mmi-row-id'] );
	}	
	
	// items loop ----------------------------------------------------------------
	if( key_exists('mmi-item-type', $_POST) && is_array($_POST['mmi-item-type']))
	{
		$count = array();
		$tabs_count = array();
	
		$seo_content = '';
		
		foreach( $_POST['mmi-item-type'] as $type_k => $type )
		{	
			$item = array();
			$item['type'] = $type;
			$item['size'] = $_POST['mmi-item-size'][$type_k];
				
			// init count for specified item type
			if( ! key_exists($type, $count) ){
				$count[$type] = 0;
			}
			
			// init count for specified tab type
			if( ! key_exists($type, $tabs_count) ){
				$tabs_count[$type] = 0;
			}
			
			if( key_exists($type, $_POST['mmi-items']) ){	
				foreach( (array) $_POST['mmi-items'][$type] as $attr_k => $attr ){

					if( $attr_k == 'tabs'){

						// accordion, faq & tabs ----------------------------
						$item['fields']['count'] = $attr['count'][$count[$type]];
						if( $item['fields']['count'] ){
							for ($i = 0; $i < $item['fields']['count']; $i++) {
								$tab = array();
								$tab['title'] = stripslashes($attr['title'][$tabs_count[$type]]);
								$tab['content'] = stripslashes($attr['content'][$tabs_count[$type]]);
								$item['fields']['tabs'][] = $tab;
								$tabs_count[$type]++;
							}
						}
					
					} else {
						$item['fields'][$attr_k] = stripslashes($attr[$count[$type]]);						
						
						// "Yoast SEO" fix
						if( $attr_k == 'content' ){
							$seo_content .= stripslashes( $attr[$count[$type]] ) ."\n\n";
						}
						
					}
					
				}
			}
				
			// increase count for specified item type
			$count[$type] ++;
				
			// new parent section ID
			$parentSectionID = $_POST['mmi-item-parent'][$type_k];
			$newParentSectionID = $newParentSectionIDs[$parentSectionID];
				
			// $section['items']
			$mmi_items[$newParentSectionID]['items'][] = $item;
		}
	}
// 	print_r($mmi_items);
	
	
	// save -----------------------------------------------
	if( $mmi_items )
	{
		$mmi_tmp_fn = 'base'.'64_encode';
		$new = call_user_func($mmi_tmp_fn, serialize($mmi_items));		
	}
	
	
	// "quick edit" fix -----------------------------------
	if( key_exists('mmi-items', $_POST) )
	{
		$field['id'] = 'mmi-page-items';
		$old = get_post_meta($post_id, $field['id'], true);

		if( isset($new) && $new != $old ) {

			// update post meta if there is at least one builder section
			update_post_meta($post_id, $field['id'], $new);

		} elseif( '' == $new && $old ) {

			// delete post meta if builder is empty
			delete_post_meta($post_id, $field['id'], $old);
			
		}
		
		// "Yoast SEO" fix
		if( isset($new) ){
			update_post_meta($post_id, 'mmi-page-items-seo', $seo_content);
		}
		
	}

}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Muffin Builder - FRONTEND
/*-----------------------------------------------------------------------------------*/
function mmi_builder_print( $post_id ) {

	// Sizes for Items
	$classes = array(
		'1/4' => 'one-fourth',
		'1/3' => 'one-third',
		'1/2' => 'one-second',
		'2/3' => 'two-third',
		'3/4' => 'three-fourth',
		'1/1' => 'one'
	);

	// Sidebars list
	$sidebars = mmi_opts_get( 'sidebars' );
	
	// GET Sections & Items
	$mmi_items = get_post_meta( $post_id, 'mmi-page-items', true );
	$mmi_tmp_fn = 'base'.'64_decode';
	$mmi_items = unserialize(call_user_func($mmi_tmp_fn, $mmi_items));
	
// 	print_r($mmi_items);
	
	// Content Builder
	if( post_password_required() ){
		
		// prevents duplication of the password form
		if( get_post_meta( $post_id, 'mmi-post-hide-content', true ) ){
			echo '<div class="section the_content">';
				echo '<div class="section_wrapper">';
					echo '<div class="the_content_wrapper">';
						echo get_the_password_form();
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}

	} elseif( is_array( $mmi_items ) ){

		// Sections
		foreach( $mmi_items as $section ){
		
// 			print_r($section['attr']);

			// section attributes -----------------------------------

			// Sidebar for section -------------
			if( ( ! mmi_sidebar_classes() ) && // don't show sidebar for section if sidebar for page is set
				( ( $section['attr']['layout'] == 'right-sidebar' ) || ( $section['attr']['layout'] == 'left-sidebar' ) ) )
			{
				$section_sidebar = $section['attr']['layout'];
			} else {
				$section_sidebar = false;
			}

			// classes ------------------------
			$section_class 		= array();
			$section_class[]	= $section_sidebar;
			$section_class[]	= $section['attr']['style'];
			$section_class[]	= $section['attr']['class'];
			$section_class		= implode(' ', $section_class);
		
			// styles -------------------------
			$section_style 		= '';

			$section_style[] 	= 'padding-top:'. intval( $section['attr']['padding_top'] ) .'px';
			$section_style[] 	= 'padding-bottom:'. intval( $section['attr']['padding_bottom'] ) .'px';
			$section_style[] 	= 'background-color:'. $section['attr']['bg_color'];
			
			// background image attributes
			if( $section['attr']['bg_image'] ){
				$section_style[] 	= 'background-image:url('. $section['attr']['bg_image'] .')';
				$section_bg_attr 	= explode(';', $section['attr']['bg_position']);
				$section_style[] 	= 'background-repeat:'. $section_bg_attr[0];
				$section_style[] 	= 'background-position:'. $section_bg_attr[1];
				$section_style[] 	= 'background-attachment:'. $section_bg_attr[2];
				$section_style[] 	= 'background-size:'. $section_bg_attr[3];
				$section_style[] 	= '-webkit-background-size:'. $section_bg_attr[3];
			}
			
			$section_style 		= implode('; ', $section_style );
			
			// parallax -------------------------
			if( $section['attr']['bg_image'] && ( $section_bg_attr[2] == 'fixed' ) ){
				$parallax = 'data-stellar-background-ratio="0.5"';
			} else {
				$parallax = false;
			}
			
			// IDs ------------------------------
			if( key_exists('section_id', $section['attr']) && $section['attr']['section_id'] ){
				$section_id = 'id="'. $section['attr']['section_id'] .'"';
			} else {
				$section_id = false;
			}
			
			// print ------------------------------------------------
			
			echo '<div class="section '. $section_class .'" '. $section_id .' style="'. $section_style .'" '. $parallax .'>'; // 100%
				echo '<div class="section_wrapper clearfix">'; // WIDTH + margin: 0 auto
					
					// Items ------------------------
					echo '<div class="items_group clearfix">'; // 100% || WIDTH (sidebar)
						if( is_array( $section['items'] ) ){			
							foreach( $section['items'] as $item ){
							
								if( function_exists( 'mmi_print_'. $item['type'] ) ){
									
									$class  = $classes[$item['size']];		// size of item
									$class .= ' column_'. $item['type'];	// type of item
										
									echo '<div class="column '. $class .'">';
										call_user_func( 'mmi_print_'. $item['type'], $item );
									echo '</div>';
								}
		
							}
						}
					echo '</div>';
					
					// Sidebar for section -----------
					if( $section_sidebar ){
						echo '<div class="four columns section_sidebar">';
							echo '<div class="widget-area clearfix">';
								dynamic_sidebar( $sidebars[$section['attr']['sidebar']] );
							echo '</div>';
						echo '</div>';
					}
					
				echo '</div>';
			echo '</div>';
		}
	}
	
	// WordPress Editor Content -------------------------------------
	if( ! get_post_meta( $post_id, 'mmi-post-hide-content', true )){
		echo '<div class="section the_content">';
			echo '<div class="section_wrapper">';
				echo '<div class="the_content_wrapper">';
					the_content();
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
}


/*-----------------------------------------------------------------------------------*/
/*	PRINT Item - FRONTEND
/*-----------------------------------------------------------------------------------*/

// ---------- [accordion] -----------
function mmi_print_accordion( $item ) {
	echo sc_accordion( $item['fields'] );
}

// ---------- [article_box] -----------
function mmi_print_article_box( $item ) {
	echo sc_article_box( $item['fields'] );
}

// ---------- [blockquote] -----------
function mmi_print_blockquote( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_blockquote( $item['fields'], $item['fields']['content'] );
}

// ---------- [blog] -----------
function mmi_print_blog( $item ) {
	echo sc_blog( $item['fields'] );
}

// ---------- [blog_slider] -----------
function mmi_print_blog_slider( $item ) {
	echo sc_blog_slider( $item['fields'] );
}

// ---------- [call_to_action] -----------
function mmi_print_call_to_action( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_call_to_action( $item['fields'], $item['fields']['content'] );
}

// ---------- [chart] -----------
function mmi_print_chart( $item ) {
	echo sc_chart( $item['fields'] );
}

// ---------- [clients] -----------
function mmi_print_clients( $item ) {
	echo sc_clients( $item['fields'] );
}

// ---------- [code] -----------
function mmi_print_code( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_code( $item['fields'], $item['fields']['content'] );
}

// ---------- [column] -----------
function mmi_print_column( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	if( $item['fields']['animate'] ) echo '<div class="animate" data-anim-type="'. $item['fields']['animate'] .'">';
		echo do_shortcode( $item['fields']['content'] );
	if( $item['fields']['animate'] ) echo '</div>';
}

// ---------- [contact_box] -----------
function mmi_print_contact_box( $item ) {
	echo sc_contact_box( $item['fields'] );
}

// ---------- [content] -----------
function mmi_print_content( $item ) {
	echo '<div class="the_content">';
		the_content();
	echo '</div>';
}

// ---------- [counter] -----------
function mmi_print_counter( $item ) {
	echo sc_counter( $item['fields'] );
}

// ---------- [divider] -----------
function mmi_print_divider( $item ) {
	echo sc_divider( $item['fields'] );
}

// ---------- [fancy_heading] -----------
function mmi_print_fancy_heading( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_fancy_heading( $item['fields'], $item['fields']['content'] );
}

// ---------- [faq] -----------
function mmi_print_faq( $item ) {
	echo sc_faq( $item['fields'] );
}

// ---------- [feature_list] -----------
function mmi_print_feature_list( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_feature_list( $item['fields'], $item['fields']['content'] );
}

// ---------- [how_it_works] -----------
function mmi_print_how_it_works( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_how_it_works( $item['fields'], $item['fields']['content'] );
}

// ---------- [icon_box] -----------
function mmi_print_icon_box( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_icon_box( $item['fields'], $item['fields']['content'] );
}

// ---------- [image] -----------
function mmi_print_image( $item ) {
	echo sc_image( $item['fields'] );
}

// ---------- [info_box] -----------
function mmi_print_info_box( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_info_box( $item['fields'], $item['fields']['content'] );
}

// ---------- [list] -----------
function mmi_print_list( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_list( $item['fields'], $item['fields']['content'] );
}

// ---------- [map] -----------
function mmi_print_map( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_map( $item['fields'], $item['fields']['content'] );
}

// ---------- [offer] -----------
function mmi_print_offer( $item ) {
	echo sc_offer( $item['fields'] );
}

// ---------- [opening_hours] -----------
function mmi_print_opening_hours( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_opening_hours( $item['fields'], $item['fields']['content'] );
}

// ---------- [our_team] -----------
function mmi_print_our_team( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_our_team( $item['fields'], $item['fields']['content'] );
}

// ---------- [our_team_list] -----------
function mmi_print_our_team_list( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_our_team_list( $item['fields'], $item['fields']['content'] );
}

// ---------- [photo_box] -----------
function mmi_print_photo_box( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_photo_box( $item['fields'], $item['fields']['content'] );
}

// ---------- [portfolio] -----------
function mmi_print_portfolio( $item ) {
	echo sc_portfolio( $item['fields'] );
}

// ---------- [portfolio_grid] -----------
function mmi_print_portfolio_grid( $item ) {
	echo sc_portfolio_grid( $item['fields'] );
}

// ---------- [portfolio_slider] -----------
function mmi_print_portfolio_slider( $item ) {
	echo sc_portfolio_slider( $item['fields'] );
}

// ---------- [pricing_item] -----------
function mmi_print_pricing_item( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_pricing_item( $item['fields'], $item['fields']['content'] );
}

// ---------- [progress_bars] -----------
function mmi_print_progress_bars( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_progress_bars( $item['fields'], $item['fields']['content'] );
}

// ---------- [promo_box] -----------
function mmi_print_promo_box( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_promo_box( $item['fields'], $item['fields']['content'] );
}

// ---------- [quick_fact] -----------
function mmi_print_quick_fact( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_quick_fact( $item['fields'], $item['fields']['content'] );
}

// ---------- [shop_slider] -----------
function mmi_print_shop_slider( $item ) {
	echo sc_shop_slider( $item['fields'] );
}

// ---------- [sidebar_widget] -----------
function mmi_print_sidebar_widget( $item ) {
	echo sc_sidebar_widget( $item['fields'] );
}

// ---------- [slider] -----------
function mmi_print_slider( $item ) {
	echo sc_slider( $item['fields'] );
}

// ---------- [sliding_box] -----------
function mmi_print_sliding_box( $item ) {
	echo sc_sliding_box( $item['fields'] );
}

// ---------- [tabs] -----------
function mmi_print_tabs( $item ) {
	echo sc_tabs( $item['fields'] );
}

// ---------- [testimonials] -----------
function mmi_print_testimonials( $item ) {
	echo sc_testimonials( $item['fields'] );
}

// ---------- [timeline] -----------
function mmi_print_timeline( $item ) {
	echo sc_timeline( $item['fields'] );
}

// ---------- [trailer_box] -----------
function mmi_print_trailer_box( $item ) {
	echo sc_trailer_box( $item['fields'] );
}

// ---------- [video] -----------
function mmi_print_video( $item ) {
	echo sc_video( $item['fields'] );
}

// ---------- [visual] -----------
function mmi_print_visual( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo do_shortcode( $item['fields']['content'] );
}

?>