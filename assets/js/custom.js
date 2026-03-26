jQuery(document).ready(function($) {
    
    var $core_select2 = $( '.core_select2' );
    $core_select2.select2();
    
    $core_select2.on( "select2:open", function (e) {
        if ( $core_select2.hasClass( 'select2-hidden-accessible' ) ) {
            $parent   = $core_select2.parents( '.core-taxonomy-dropdown' );
            $dropdown = $parent.find( '.toggle i' );

            $parent.addClass( 'active' );
            $dropdown.removeClass( 'fa-angle-down' ).addClass( 'fa-angle-up' );
        }
    });

    $core_select2.on( "select2:close", function (e) {
        if ( $core_select2.hasClass( 'select2-hidden-accessible' ) ) {
            $parent = $core_select2.parents( '.core-taxonomy-dropdown' );
            $dropdown = $parent.find( '.toggle i' );

            $parent.removeClass( 'active' );
            $dropdown.removeClass( 'fa-angle-up' ).addClass( 'fa-angle-down' );
        }
    });

    $core_select2.on( "select2:select", function (e) {
        if ( $core_select2.hasClass( 'select2-hidden-accessible' ) ) {
            
            if ( '' !== $core_select2.select2( 'data' ) ) {
                $( '.core-adv-search .core-query-term' ).val(
                    $core_select2.select2( 'data' )[0].id
                );
            }

            $( '.core-adv-search .core-taxonomy-dropdown .post-object-filter' ).attr(
                'data-term',
                $core_select2.select2( 'data' )[0].id
            );
            // console.log( $core_select2.select2( 'data' )[0].text );
            // console.log( $core_select2.select2( 'data' )[0] );
            // console.log( $core_select2.select2( 'data' )[0].id );
        }
    });

    /**
     * Windows on load
     */ 
    $( window ).on ( 'load', function () {

        setTimeout( function() {
            var urlHash             = window.location.href.split( '#' )[ 1 ];
            var header_menu_offset  = $( '#menubar' ).height() + $( '#topbar' ).height();
    
            if ( undefined !== urlHash ) {
                $( 'html, body' ).animate({
                    scrollTop: $( '#' + urlHash ).offset().top - header_menu_offset
                }, 500 );
            }

        }, 500 );

    });

    /**
     * Windows load
     */ 
    $( window ).load( function() {
        var $sticky_toolbar = $( '.st-sticky-share-buttons.st-left' );
        /**
         * Sticky Toolbar items
         */ 
        if ( $sticky_toolbar.length >= 1 ) {
            $sticky_toolbar.find( '.st-btn.st-last' ).removeClass( 'st-last' );
            $( core_object.templates.sticky_toolbar.contact_us ).insertBefore( $sticky_toolbar.find( '.st-toggle' ) );
        }
    });
    
    /**
     * Post Filter Search
     */
    $( document ).on( 'submit', '.post-object-search.ajax-enabled form', function(e) {
        e.preventDefault();
        
        var _this         = $( this );
        var _parent       = $( this ).parents( '.post-object-search' );
        var $search       = _parent.find( '.core-query-search' ).val();
        var $post_type    = _parent.find( '.core-query-posttype' ).val();
        var $taxonomy     = _parent.find( '.core-query-tax' ).val();
        var $term         = _parent.find( '.core-query-term' ).val();
        var _url          = document.location.href;
        var _page_count   = core_get_url_param( 'paged', _url );
        var _pagination   = $( '.core-pagination-ui.ajax-enabled' );

        if ( true === isNaN( _page_count ) ) {
            _page_count = 1;
        }

        if ( 1 < _page_count ) {
            _page_count = 1;
        }
        
        if ( _parent.hasClass( 'ajax-enabled' ) ) {
            $.ajax({
                type: 'POST',

                dataType: 'json',

                url: core_object.url.ajaxurl,

                data: {
                    'action'        : 'core_ajax', //calls core_ajax

                    'handler'       : 'post_object_filter',

                    'handler_type'  : 'search',

                    'ajaxurl'       : core_object.url.ajaxurl,

                    'site_url'      : core_object.url.site_url,

                    'page_slug'     : core_object.url.page_slug,

                    'paged'         : _page_count,

                    'search'        : $search,

                    'post_type'     : $post_type,
                    
                    'taxonomy'      : $taxonomy,
                    
                    'terms'          : $term
                },

                beforeSend: function() {
                    $( '.post-object-filter-result' ).addClass( 'disabled' );
                    _pagination.addClass( 'disabled' );
                },

                success: function( response ) {
                    if ( response.status == 202 ) {
                        $( '.post-object-filter-result' ).html( response.result );
                        _pagination.replaceWith( response.pagination );
                        _pagination.removeClass( 'core-hidden' );
                    } else {
                        $( '.post-object-filter-result' ).html( response.error );
                        _pagination.addClass( 'core-hidden' );
                    }
                    $( '.post-object-filter-result' ).removeClass( 'disabled' );
                    _pagination.removeClass( 'disabled' );
                }

            });
        }
    });

    /**
     * Post Taxonomy Term Filter
     */
    $( document ).on( 'change', '.post-object-filter.ajax-enabled', function(e) {
        e.preventDefault();
        
        var _this         = $( this );
        var $post_type    = _this.attr( 'data-post-type' );
        var _parent       = $( this ).parents( '.core-adv-search' );
        var $search       = _parent.find( '.core-query-search' ).val();
        var $taxonomy     = _this.attr( 'data-taxonomy' );
        var $term         = $core_select2.select2( 'data' )[0].id;
        var _url          = document.location.href;
        var _page_count   = core_get_url_param( 'paged', _url );
        var _pagination   = $( '.core-pagination-ui.ajax-enabled' );


        if ( true === isNaN( _page_count ) ) {
            _page_count = 1;
        }

        if ( 1 < _page_count ) {
            _page_count = 1;
        }

        if ( _this.hasClass( 'ajax-enabled' ) ) {
            $.ajax({
                type: 'POST',

                dataType: 'json',

                url: core_object.url.ajaxurl,

                data: {
                    'action'        : 'core_ajax', //calls core_ajax

                    'handler'       : 'post_object_filter',

                    'handler_type'  : 'search',

                    'ajaxurl'       : core_object.url.ajaxurl,

                    'site_url'      : core_object.url.site_url,

                    'page_slug'     : core_object.url.page_slug,
                    
                    'paged'         : _page_count,

                    'search'        : $search,

                    'post_type'     : $post_type,
                    
                    'taxonomy'      : $taxonomy,
                    
                    'terms'          : $term
                },

                beforeSend: function() {
                    $( '.post-object-filter-result' ).addClass( 'disabled' );
                    _pagination.addClass( 'disabled' );
                },

                success: function( response ) {
                    if ( response.status == 202 ) {
                        $( '.post-object-filter-result' ).html( response.result );
                        _pagination.replaceWith( response.pagination );
                        _pagination.removeClass( 'core-hidden' );
                        
                    } else {
                        $( '.post-object-filter-result' ).html( response.error );
                        _pagination.addClass( 'core-hidden' );
                        
                    }
                    $( '.post-object-filter-result' ).removeClass( 'disabled' );
                    _pagination.removeClass( 'disabled' );
                }

            });
        }

    });

    /**
     * Post Type Selection
     */
    $( document ).on( 'change', '.object-collection.ajax-enabled', function(e) {
        e.preventDefault();
        
        var _this                   = $( this );
        var _this_data              = _this.attr( 'data-current' );
        var _this_val               = _this.find( 'option:selected' ).val();
        var _parent                 = _this.parents( '.core-adv-search' );

        var _post_filter            = _parent.find( '.core_select2.post-types-collection' );
        var _post_tax_filter        = _parent.find( '.core_select2.taxonomy-collection' );
        var _post_term_filter       = _parent.find( '.core_select2.term-collection' );

        var f_post_current          = _post_filter.attr( 'data-current' );
        var f_post_tax_current      = _post_tax_filter.attr( 'data-current' );
        var f_post_term_current     = _post_term_filter.attr( 'data-current' );

        var _post_type              = _post_filter.find( 'option:selected' ).val();
        var _taxonomy               = _post_tax_filter.find( 'option:selected' ).val();
        var _terms                  = _post_term_filter.find( 'option:selected' ).val();
        
        var _url                    = document.location.href;
        var _page_count             = core_get_url_param( 'paged', _url );
        var _pagination             = $( '.core-pagination-ui.ajax-enabled' );
        var _date_query             = {};
        var _ajax_data              = {};

        var placeholder_opt         = '<option value="">Select Filter By</option>';

        if ( true === isNaN( _page_count ) ) {
            _page_count = 1;
        }

        if ( 1 < _page_count ) {
            _page_count = 1;
        }

        if ( _this.hasClass( 'ajax-enabled' ) || false === _parent.hasClass( 'disabled' ) ) {

            if ( _this_data !== _this_val ) {

                if ( _this.hasClass( 'post-types-collection' ) ) {
                    _post_tax_filter.attr( 'data-current', '' );
                    _post_term_filter.attr( 'data-current', '' );

                    _post_tax_filter.html( placeholder_opt ).trigger('select');
                    _post_term_filter.html( placeholder_opt ).trigger('select');

                    if ( '' !== _this_data  ) {
                        _taxonomy = '';
                        _terms    = '';
                    }
                }

                if ( _this.hasClass( 'taxonomy-collection' ) ) {
                    _post_tax_filter.attr( 'data-current', '' );
                    _post_tax_filter.html( placeholder_opt ).trigger('select');

                    // if ( '' !== _this_data  ) {
                    //     _taxonomy = '';
                    // }
                }

                if ( _this.hasClass( 'term-collection' ) ) {
                    _post_term_filter.attr( 'data-current', '' );
                    _post_term_filter.html( placeholder_opt ).trigger('select');

                    // if ( '' !== _this_data  ) {
                    //     _terms    = '';
                    // }
                }
            }

            _ajax_data = {
                'action'        : 'core_ajax', //calls core_ajax
    
                'handler'       : 'post_object_filter',
    
                'handler_type'  : 'post_tax_filter',
    
                'ajaxurl'       : core_object.url.ajaxurl,
    
                'site_url'      : core_object.url.site_url,
    
                'page_slug'     : core_object.url.page_slug,
                
                'url_path'      : core_object.url.url_path,
                
                'paged'         : _page_count,
    
                'post_type'     : _post_type,
    
                'taxonomy'      : _taxonomy,
    
                'terms'         : _terms
            };
    
            if ( 'date_archive' === core_object.object_info.object_type ) {
                _date_query = core_object.object_info.date_query;
    
                // Array Value
                _ajax_data.date_query = _date_query;
            }

            $.ajax({
                type: 'POST',

                dataType: 'json',

                url: core_object.url.ajaxurl,

                data: _ajax_data,

                beforeSend: function() {
                    $( '.post-object-filter-result' ).addClass( 'disabled' );
                    _parent.addClass( 'disabled' );
                    _pagination.addClass( 'disabled' );
                },

                success: function( response ) {
                    if ( response.status == 202 ) {

                        $( '.post-object-filter-result' ).html( response.result );
                        
                        _post_tax_filter.html( response.post_tax_filter ).trigger('select');
                        _post_term_filter.html( response.post_term_filter ).trigger('select');

                        _pagination.replaceWith( response.pagination );

                        _pagination.removeClass( 'core-hidden' );
                        
                    } else {
                        _post_tax_filter.html( response.post_tax_filter ).trigger('select');
                        _post_term_filter.html( response.post_term_filter ).trigger('select');

                        $( '.post-object-filter-result' ).html( response.error );
                        _pagination.addClass( 'core-hidden' );
                    }

                    _this.attr( 'data-current', _this_val );

                    $( '.post-object-filter-result' ).removeClass( 'disabled' );
                    _parent.removeClass( 'disabled' );
                    _pagination.removeClass( 'disabled' );
                    
                }

            });
        }
    });

    /**
     * Post Pagination
     */
    $( document ).on( 'click', '.core-pagination-ui.ajax-enabled .page-numbers', function(e) {
        e.preventDefault();
        
        var _this         = $( this );
        var _page_count   = '';
        var _parent       = _this.parents( '.core-pagination-ui.ajax-enabled' );
        var _url          = _this.attr( 'href' );
        var _params       = new URLSearchParams( window.location.search );
        var _search       = '';
        var _post_type    = '';
        var _post_types   = '';
        var _date_query   = '';
        var _taxonomy     = '';
        var _term         = '';
        var _paged        = '';
        var _url_param    = '';
        var _field_filter = '';

        var _post_filter  = $( '.core-posttype-filter-dropdown' );
        
        var _ajax_data    = {
            'action'        : 'core_ajax', //calls core_ajax
            'handler'       : 'post_object_filter',
            'handler_type'  : 'pagination',
            'ajaxurl'       : core_object.url.ajaxurl,
            'site_url'      : core_object.url.site_url,
            'page_slug'     : core_object.url.page_slug,
            'url_path'      : core_object.url.url_path
        };

        if ( ! _this.hasClass( 'current' ) ) {
            _page_count = core_get_url_param( 'paged', _url );
        }

        // Updates the URL Address Bar without refreshing the page
        window.history.pushState(
            { 'paged': _page_count },
            'Page ' + _page_count,
            _url
        );
        
        if ( true === isNaN( _page_count ) ) {
            _page_count = core_get_url_param( 'paged', _url );
        }

        _paged = _page_count;


        if ( '' !== core_object.url.url_param ) {
            _url_param           = core_object.url.url_param;
            _url_param           = core_remove_url_parem( '?' + _url_param, 'paged' );
            _url_param           = _url_param.replace( '?', '' );


            _ajax_data.url_param = _url_param;
        }

        if ( _parent.hasClass( 'include-advance-search' ) ) {
            _field_filter        = $( '.post-object-search.ajax-enabled' );

            _search              = _field_filter.find( '.core-query-search' ).val();
            _post_type           = _field_filter.find( '.core-query-posttype' ).val();
            _taxonomy            = _field_filter.find( '.core-query-tax' ).val();
            _term                = _field_filter.find( '.core-query-term' ).val();
            _paged               = _paged;

            if ( 'taxonomy' === core_object.object_info.object_type ) {
                _post_types = core_object.object_info.tax_post_types;
                _taxonomy   = core_object.object_info.tax_type;
                _term       = core_object.object_info.term_id;

                // Array Value
                _ajax_data.post_types = _post_types;
            }
            if ( 'wp_search' === core_object.object_info.object_type ) {
                _post_types = core_object.object_info.post_types;
                _taxonomy   = core_object.object_info.tax_type;
                _term       = core_object.object_info.term_id;
                _search     = core_object.object_info.search;
                _url_param  = core_object.url.url_param;

                _ajax_data.post_types = _post_types;
                _ajax_data.url_param  = _url_param;
            }

            if ( 'date_archive' === core_object.object_info.object_type ) {
                _post_types = core_object.object_info.post_types;
                _date_query = core_object.object_info.date_query;

                // Array Value
                _ajax_data.post_types = _post_types;
                _ajax_data.date_query = _date_query;
            }

            _ajax_data.search    = _search;
            _ajax_data.post_type = _post_type;
            _ajax_data.taxonomy  = _taxonomy;
            _ajax_data.terms     = _term;
            _ajax_data.paged     = _paged;
        } else {
            _ajax_data.paged     = _paged;
        }

        
        if ( _post_filter.length >= 1 ) {
            _post_types           = _post_filter.find( '.post-types-collection > option:selected' ).val();
            _taxonomy             = _post_filter.find( '.taxonomy-collection > option:selected' ).val();
            _term                 = _post_filter.find( '.term-collection > option:selected' ).val();
            
            if ( '' !== _post_types ) {
                _ajax_data.post_types = _post_types;
            }
        }


        if ( false === _parent.hasClass( 'disabled' ) ) {
            
            $.ajax({
                type: 'POST',

                dataType: 'json',

                url: core_object.url.ajaxurl,

                data: _ajax_data,

                beforeSend: function() {
                    $( '.post-object-filter-result' ).addClass( 'disabled' );
                    _parent.addClass( 'disabled' );
                },

                success: function( response ) {
                    if ( response.status == 202 ) {

                        $( '.post-object-filter-result' ).html( response.result );
                        _parent.replaceWith( response.pagination );
                        _parent.removeClass( 'core-hidden' );
                    } else {
                        $( '.post-object-filter-result' ).html( response.error );
                        _parent.addClass( 'core-hidden' );
                    }
                    $( '.post-object-filter-result' ).removeClass( 'disabled' );
                    _parent.removeClass( 'disabled' );
                }

            });
        }

    });


    $( document ).on( 'click', '.core-tabs-ui .core-tab-list', function( e ) {
        e.preventDefault();

        var _this           = $( this );
        var _id             = _this.find( 'a' ).attr( 'href' );
        var _root           = _this.parents( '.core-tabs-ui' );
        var _parent         = _this.parents( '.core-tab-lists' );
        var _siblings       = _parent.siblings( '.core-tab-list' );
        var _content        = _root.find( '.core-tab-contents' );
        var _active_content = _root.find( _id );

        if ( ! _this.hasClass( 'active' ) ) {
            _this.addClass( 'active' ).siblings().removeClass( 'active' );
            _active_content.addClass( 'active' ).siblings().removeClass( 'active' );
            console.log( _id );
            console.log( _active_content );
        }

    } );
    
    $('.home-banner').owlCarousel({
        loop: true,
        margin: 10,
        autoplay:true,
        autoplayTimeout:7000,
        autoplayHoverPause:true,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });


    $('#pro-gallery').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 4
            }
        }
    });

    
    $( '.core-featured-carousel .core-featured-items' ).owlCarousel({ 
        loop: true,
        margin: 15,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1,
                nav: false
            },
            1000: {
                items: 2
            }
        }
    });

    $('#additional-info-tab').responsiveTabs({
        startCollapsed: 'accordion'
    });

    $( '.other_prod_links .core-target-tab' ).bind({
        click: function( e ) {
            var _this         = $( this );
            var _target       = _this.attr( 'data-target-tab' );
            var _tabs         = $( '#additional-info-tab' );
            var _active_tab   = _tabs.find( 'a[href="' + _target + '"]' ).parent( 'li' );
            var _tab_siblings = _active_tab.siblings( 'li' );
            var _active_panel = _tabs.find( _target );
            var _panels       = _tabs.find( '.r-tabs-panel' );
    
            if ( ! _active_tab.hasClass( 'r-tabs-state-active' ) ) {
                _tab_siblings.removeClass( 'r-tabs-state-active' ).addClass( 'r-tabs-state-default' );
                _active_tab.addClass( 'r-tabs-state-active' ).removeClass( 'r-tabs-state-default' );

                _panels.removeClass( 'r-tabs-state-active' ).addClass( 'r-tabs-state-default' ).css( 'display', 'none' );
                _active_panel.addClass( 'r-tabs-state-active' ).removeClass( 'r-tabs-state-default' ).css( 'display', 'block' );
            }
        }
    });

    $( '#additional-info-tab .r-tabs-tab' ).bind({
        click: function( e ) {
            var _this     = $( this );
            var _siblings = _this.siblings( '.r-tabs-tab' );

            _siblings.removeClass( 'r-tabs-state-active' ).addClass( 'r-tabs-state-default' );
            _this.addClass( 'r-tabs-state-active' ).removeClass( 'r-tabs-state-default' );

        }
    });
      
    $( document ).on( 'click', 'a.disabled', function(e) {
        e.preventDefault();
    });

    $(".header-search, .mobile-search").click(function() {
        $(".desktop-search-form").addClass("open");
    });
    $(".icon-close").click(function(e) {
		e.preventDefault();
        $(".desktop-search-form").removeClass("open");
    });

    $(".hide_content").hide();
    $(".show_hide").on("click", function (e) {
        e.preventDefault();
        var txt = jQuery(".hide_content").is(':visible') ? 'View More' : 'View Less';        
        $(".show_hide").text(txt);
        $(".show_hide").toggleClass('direction_arrow');
        $(this).prev('.hide_content').slideToggle(200);
    });

});

window.onscroll = function() { myFunction() };

var header = document.getElementById("menubar");
var sticky = header.offsetTop;

function myFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}

// jQuery('a[href^="#"]').on('click', function(e) {
// 	//alert("test");
// 	e.preventDefault();
//     var hash  = this.hash;
//     	$hash = jQuery(hash);
//         addHash = function() {
//             window.location.hash = hash;
//         };

        
//         var offset = jQuery('.sticky').offset();
// 		var scrollto = offset.top - 167; // minus fixed header height
// 		jQuery('html, body').animate({scrollTop:scrollto}, 500);

//         //var header = jQuery('#pageheader').offset().top;
//       //  jQuery('html,body').animate({ 'scrollTop': $hash.offset().top -167 }, 500, addHash);
//        // jQuery('html,body').animate({ 'scrollTop': jQuery('#req-quote').offset().top - 167 }, 500);
//         //var heightval = $hash.offset().top - 167;
//         //alert();
//         //jQuery('html,body').animate({ 'scrollTop': heightval }, 500);
//         //jQuery('html,body').animate({ 'scrollTop': jQuery(hash).offset().top-200 }, 500);
// });


function core_get_url_param( parameter, url ) {
    var url_parameter = url;
    
    if ( window.location.href.indexOf( parameter ) > -1 ) {

        if ( '' === url ) {
            url_parameter = core_get_url_vars()[ parameter ];
        } else {
            url_parameter = core_get_url_vars( url )[ parameter ];
        }
    }
    return url_parameter;
}

function core_get_url_vars( url ) {
    var vars = {};
    var parts = window.location.href.replace(
        /[?&]+([^=&]+)=([^&]*)/gi, 
        function( m, key, value ) {
            vars[ key ] = value;
        }
    );

    if ( '' !== url ) {
        parts = url.replace(
            /[?&]+([^=&]+)=([^&]*)/gi, 
            function( m, key, value ) {
                vars[ key ] = value;
            }
        );
    }

    return vars;
}

function core_remove_url_parem( url, parameter ) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}




/* NP 1-6-2021 */
jQuery(document).ready(function($) {
    
    //console.log("NPTESTING "+ core_object.url.site_url); 
    if ($(".wpcf7")[0]){
        // Do something if class exists
    } else {
        // Do something if class does not exist
        // $(".right-topbar ul li a.quote_btn").attr("href",core_object.url.site_url+"#req-quote");
    }



    var $videoSrc;  
    $('.video-btn').click(function() {
        $videoSrc = $(this).data( "src" );
    });
    console.log($videoSrc);

    $('#myModal').on('shown.bs.modal', function (e) {
        
    // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
    $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
    })
      


    // stop playing the youtube video when I close the modal
    $('#myModal').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        $("#video").attr('src',$videoSrc); 
    }) 


    // adjust height on career page



    var career_descmaxHeight = 0;

    $("div.product-content.career_desc").each(function(){
       if ($(this).height() > career_descmaxHeight) { career_descmaxHeight = $(this).height(); }
       console.log($(this).height());
    });

    $("div.product-content.career_desc").height(career_descmaxHeight);




});