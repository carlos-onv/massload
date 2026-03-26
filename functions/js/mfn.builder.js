/* ---------------------------------------------------------------------------
 * UI Sortable init for items
 * --------------------------------------------------------------------------- */
function mmiSortableInit(item){
	item.find('.mmi-sortable').sortable({ 
		connectWith				: '.mmi-sortable',
		cursor					: 'move',
		forcePlaceholderSize	: true, 
		placeholder				: 'mmi-placeholder',
		items					: '.mmi-item',
		opacity					: 0.9,
		receive					: mmiSortableReceive
	});
	return item;
}


/* ---------------------------------------------------------------------------
 * UI Sortable receive callback
 * --------------------------------------------------------------------------- */
function mmiSortableReceive(event, ui){
	var targetSectionID = jQuery(this).siblings('.mmi-row-id').val(); 
	ui.item.find('.mmi-item-parent').val(targetSectionID);
}


/* ---------------------------------------------------------------------------
 * Muffin Builder 2.0
 * --------------------------------------------------------------------------- */
function mmiBuilder(){
		
	var desktop = jQuery('#mmi-desk');
	var sectionID = jQuery('#mmi-row-id');
	
	
	// sizes & classes ========================================
	
	
	// available items ----------------------------------------
	var items = {
		'accordion'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'article_box'		: [ '1/3', '1/2' ],
		'blockquote'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'blog'				: [ '1/1' ],
		'blog_slider'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'call_to_action'	: [ '1/1' ],
		'chart'				: [ '1/4', '1/3', '1/2' ],
		'clients'			: [ '1/1' ],
		'code'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'column'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'contact_box'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'content'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'counter'			: [ '1/4', '1/3', '1/2' ],
		'divider'			: [ '1/1' ],
		'fancy_heading'		: [ '1/1' ],
		'feature_list'		: [ '1/1' ],
		'faq'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'how_it_works'		: [ '1/4', '1/3' ],
		'icon_box'			: [ '1/4', '1/3', '1/2' ],
		'image'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'info_box'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'list'				: [ '1/4', '1/3', '1/2' ],
		'map'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'offer_slider'		: [ '1/1' ],
		'opening_hours'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'our_team'			: [ '1/4', '1/3', '1/2' ],
		'our_team_list'		: [ '1/1' ],
		'portfolio'			: [ '1/1' ],
		'portfolio_grid'	: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'portfolio_slider'	: [ '1/1' ],
		'photo_box'			: [ '1/4', '1/3', '1/2' ],
		'pricing_item'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'progress_bars'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'promo_box'			: [ '1/2' ],
		'quick_fact'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'shop_slider'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'sidebar_widget'	: [ '1/4', '1/3' ],
		'slider'			: [ '1/1' ],
		'sliding_box'		: [ '1/4', '1/3', '1/2' ],
		'tabs'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'testimonials'		: [ '1/1' ],
		'trailer_box'		: [ '1/4', '1/3', '1/2' ],
		'timeline'			: [ '1/1' ],
		'video'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'visual'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ]
	};	
	
	
	// available classes ------------------------------------------
	var classes = {
		'1/4' : 'mmi-item-1-4',
		'1/3' : 'mmi-item-1-3',
		'1/2' : 'mmi-item-1-2',
		'2/3' : 'mmi-item-2-3',
		'3/4' : 'mmi-item-3-4',
		'1/1' : 'mmi-item-1-1'
	};

	
	// jquery.ui =================================================

	
	desktop.sortable({ 
		cursor					: 'move',
		forcePlaceholderSize	: true, 
		placeholder				: 'mmi-placeholder',
		items					: '.mmi-row',
		opacity					: 0.9		
	});
	
	desktop.find('.mmi-sortable').sortable({ 
		connectWith				: '.mmi-sortable',
		cursor					: 'move',
		forcePlaceholderSize	: true, 
		placeholder				: 'mmi-placeholder',
		items					: '.mmi-item',
		opacity					: 0.9,
		receive					: mmiSortableReceive
	});

	
	// section ===================================================
	
	
	// add section -----------------------------------------------
	jQuery('.mmi-row-add-btn').click(function(){
		var clone = jQuery('#mmi-rows .mmi-row').clone(true);

		clone.find('.mmi-sortable').sortable({ 
			connectWith				: '.mmi-sortable',
			cursor					: 'move',
			forcePlaceholderSize	: true, 
			placeholder				: 'mmi-placeholder',
			items					: '.mmi-item',
			opacity					: 0.9,
			receive					: mmiSortableReceive
		});
		
		clone.hide()
			.find('.mmi-element-content > input').each(function() {
				jQuery(this).attr('name',jQuery(this).attr('class')+'[]');
			});
		
		sectionID.val(sectionID.val()*1+1);
		clone
			.find('.mmi-row-id').val(sectionID.val());
		
		desktop.append(clone).find(".mmi-row").fadeIn(500);
	});
	
	
	// clone section ---------------------------------------------
	jQuery('.mmi-row .mmi-row-clone').click(function(){
		var element = jQuery(this).closest('.mmi-element');

		// sortable destroy, clone & init for cloned element
		element.find('.mmi-sortable').sortable('destroy');
		var clone = element.clone(true);
		
		mmiSortableInit(element);
		mmiSortableInit(clone);
		
		sectionID.val(sectionID.val()*1+1);
		clone
			.find('.mmi-row-id, .mmi-item-parent').val(sectionID.val());
		
		element.after(clone);
	});
	
	
	// add item list toggle ---------------------------------------
	jQuery('.mmi-item-add-btn').click(function(){
		var parent = jQuery(this).parent();
		
		if( parent.hasClass('focus') ){
			parent.removeClass('focus');
		} else {
			jQuery('.mmi-item-add').removeClass('focus');
			parent.addClass('focus');
		}
	});
	
	
	// add item ---------------------------------------------------
	jQuery('.mmi-item-add-list a').click(function(){
		
		jQuery(this).closest('.mmi-item-add').removeClass('focus');
		
		var parentDesktop = jQuery(this).parents('.mmi-row').find('.mmi-droppable');
		var targetSectionID = jQuery(this).parents('.mmi-row').find('.mmi-row-id').val(); 
		
		var item = jQuery(this).attr('class');
		var clone = jQuery('#mmi-items').find('div.mmi-item-'+ item ).clone(true);

		clone
			.hide()
			.find('.mmi-element-content input').each(function() {
				jQuery(this).attr('name',jQuery(this).attr('class')+'[]');
			});
		
		clone.find('.mmi-item-parent').val(targetSectionID);
	
		parentDesktop.append(clone).find(".mmi-item").fadeIn(500);
	});
	
	
	// item =======================================================
	
	
	// increase item size --------------------------------------
	jQuery('.mmi-item-size-inc').click(function(){
		var item = jQuery(this).closest('.mmi-item');
		var item_type = item.find('.mmi-item-type').val();
		var item_sizes = items[item_type];
		
		for( var i = 0; i < item_sizes.length-1; i++ ){
		
			if( ! item.hasClass( classes[item_sizes[i]] ) ) continue;
			
			item
				.removeClass( classes[item_sizes[i]] )
				.addClass( classes[item_sizes[i+1]] )
				.find('.mmi-item-size').val( item_sizes[i+1] );
			
			item.find('.mmi-item-desc').text( item_sizes[i+1] );
	
			break;
		}	
	});
	
	
	// decrease size ----------------------------------------------
	jQuery('.mmi-item-size-dec').click(function(){
		var item = jQuery(this).closest('.mmi-item');
		var item_type = item.find('.mmi-item-type').val();
		var item_sizes = items[item_type];
		
		for( var i = 1; i < item_sizes.length; i++ ){
			
			if( ! item.hasClass( classes[item_sizes[i]] ) ) continue;
			
			item
				.removeClass( classes[item_sizes[i]] )
				.addClass( classes[item_sizes[i-1]] )
				.find('.mmi-item-size').val( item_sizes[i-1]);
			
			item.find('.mmi-item-desc').text( item_sizes[i-1] );
			
			break;
		}		
	});
	
	
	// clone item ---------------------------------------------
	jQuery('.mmi-item .mmi-item-clone').click(function(){
		var element = jQuery(this).closest('.mmi-element');
		var clone = element.clone(true);
		element.after(clone);
	});
	
	
	// element ===================================================

	
	// delete element --------------------------------------------
	jQuery('.mmi-element-delete').click(function(){
		var item = jQuery(this).closest('.mmi-element');
		
		if( confirm( "You are about to delete this element.\nIt can not be restored at a later time! Continue?" ) ){
			item.fadeOut(500,function(){jQuery(this).remove();});
	    } else {
	    	return false;
	    }
	});
	
	
	// helper - switch editor  ------------------------------------
	jQuery('#mmi-popup').on('click', '.mmi-switch-editor', function(e) {
		e.preventDefault();
		if( tinymce.get('mmi-editor') ) {
//			var tinyHTML = tinymce.get('mmi-editor').getContent();
			tinymce.execCommand('mceRemoveEditor', false, 'mmi-editor');
//			jQuery('#mmi-editor').val( tinyHTML );
		} else {
        	tinymce.execCommand('mceAddEditor', false, 'mmi-editor');
        }
	});

	
	var source_item = '';

	// popup - edit -----------------------------------------------
	jQuery('.mmi-element-edit').click(function(){
		
		jQuery('#publish').fadeOut(500); // hide Publish/Update button
		
		jQuery('#mmi-content, .form-table').fadeOut(50);
		source_item = jQuery(this).closest('.mmi-element');
		var clone_meta = source_item.children('.mmi-element-meta').clone(true);
	
		jQuery('#mmi-popup')
			.append(clone_meta)
			.fadeIn(500);

		if (jQuery('#mmi-wrapper').length > 0){
			jQuery('html, body').animate({
				scrollTop: jQuery('#mmi-wrapper').offset().top
			}, 500);
		}
		
		source_item.children('.mmi-element-meta').remove();
	
		
		// mce - editor ---------------

		jQuery('#mmi-popup textarea.editor').attr('id','mmi-editor');            

		try {
			jQuery('.wp-switch-editor.switch-html').click();
			jQuery('.wp-switch-editor.switch-tmce').click();
			tinymce.execCommand('mceAddEditor', true, 'mmi-editor');
		} catch (err) {
//			console.log(err);
		}
		
		jQuery('#mmi-popup .mce-tinymce .mce-i-wp_more, #mmi-popup .mce-tinymce .mce_woocommerce_shortcodes_button, #mmi-popup .mce-tinymce .mce_revslider')
			.closest('.mce-btn').remove();

		jQuery('#mmi-popup .mce-tinymce').closest('td').prepend('<a href="#" class="mmi-switch-editor"">Visual / HTML</a>');

		// end: mce - editor ----------
		        
	});

	
	// popup - close ----------------------------------------------
	jQuery('#mmi-popup .mmi-popup-close, #mmi-popup .mmi-popup-save').click(function(){

		// mce - editor ---------------

		try {
			if( tinymce.get('mmi-editor') ){
				jQuery('#mmi-editor').html( tinymce.get('mmi-editor').getContent() );
				tinymce.execCommand('mceRemoveEditor', false, 'mmi-editor');
			} else {
				jQuery('#mmi-editor').html( jQuery('#mmi-editor').val() );
			}
	    } catch (err) {
//	    	console.log(err);
	    }
	    
	    jQuery('.mmi-switch-editor').remove();
	    jQuery('#mmi-editor').removeAttr('id');	    
  
	    // end: mce - editor ----------
		
		
		// destroy sortable for fields 'tabs'
		jQuery('.tabs-ul.ui-sortable').sortable('destroy');
		
		jQuery('#publish').fadeIn(500); // show Publish/Update button
		
		jQuery('#mmi-content, .form-table').fadeIn(500);
		var popup = jQuery('#mmi-popup');
		var clone = popup.find('.mmi-element-meta').clone(true);

		source_item.append(clone);
		
		popup.fadeOut(50);
	
		setTimeout(function(){
			popup.find('.mmi-element-meta').remove();
		},50);
	});	
	
	
	// go to top ===================================================
	
	jQuery('#mmi-go-to-top').click(function(){
		jQuery('html, body').animate({ 
			scrollTop: 0
		}, 500);
	});
	
	
	// post formats ================================================
	
	jQuery("#post-formats-select label.post-format-standard").text('Standard, Horizontal Image');
	jQuery("#post-formats-select label.post-format-image").text('Vertical Image');
	
	
	// seo =========================================================
	jQuery('#wp-content-wrap .wp-editor-tabs').prepend('<a class="wp-switch-editor switch-seo" id="content-seo">Builder &raquo; SEO</a>');

	jQuery('#content-seo').click(function(){
		
		if( confirm( "This option is useful for plugins like Yoast SEO to analize post content when you use Muffin Builder.\nIt will collect content from Muffin Builder Elements and copy it into the WordPress Editor.\n\nCurrent Editor Content will be replaced.\nYou can hide the content if you turn \"Hide the content\" option ON.\n\nPlease remember to Publish/Update your post before & after use of this option.\nContinue?" ) ){
			
			var items_decoded = jQuery('#mmi-items-seo-data').val();
			console.log(items_decoded);
			jQuery('#content-html').click();
			jQuery('#content').val( items_decoded ).text( items_decoded );
			
	    } else {
	    	return false;
	    }

	});
		
}


/* ---------------------------------------------------------------------------
 * Clone fix (textarea, select)
 * --------------------------------------------------------------------------- */
(function (original) {
	jQuery.fn.clone = function () {
	    var result = original.apply (this, arguments),
		my_textareas = this.find('textarea:not(.editor), select'),
	    result_textareas = result.find('textarea:not(.editor), select');
	
	    for (var i = 0, l = my_textareas.length; i < l; ++i)
	    	jQuery(result_textareas[i]).val( jQuery(my_textareas[i]).val() );
	
	    return result;
	};
}) (jQuery.fn.clone);


/* ---------------------------------------------------------------------------
 * jQuery(document).ready
 * --------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	mmiBuilder();
});


/* ---------------------------------------------------------------------------
 * jQuery(document).mouseup
 * --------------------------------------------------------------------------- */
jQuery(document).mouseup(function(e)
{
	if (jQuery(".mmi-item-add").has(e.target).length === 0){
		jQuery(".mmi-item-add").removeClass('focus');
	}
});
