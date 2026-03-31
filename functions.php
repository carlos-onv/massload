<?php

function dom_replacements(){
    function callbackd($buffer) {
        $buffer = (str_replace('www.massload.com', "dev.mload.idlwebdev.com", $buffer));
        $buffer = (str_replace('massload.com', "dev.mload.idlwebdev.com", $buffer));
		return $buffer; 
    }
	ob_start("callbackd");
}
if ( !is_admin() ){ add_action( 'init', 'dom_replacements' ); }


define('THEME_DIR', get_template_directory());

define('THEME_URI', get_template_directory_uri());

define('THEME_DEFAULT_ASSETS', get_template_directory_uri() . '/assets/img/defaults/');

define('THEME_NAME', 'Massload');

define('THEME_VERSION', '1.0');

define('LIBS_DIR', THEME_DIR . '/functions');

define('LIBS_URI', THEME_URI . '/functions');

define('LANG_DIR', THEME_DIR . '/languages');

define('CORE_AJAX_CONSOLE_RESULT', true);

define(
    'CORE_POST_TYPES',
    array(
        // 'post',
        // 'page',
        'resources',
        'applications',
        'case_study',
        'products'
    )
);

define('CORE_POST_PER_PAGE', get_option('posts_per_page'));
// define( 'CORE_POST_PER_PAGE', 2 );

define('CORE_PLACEHOLDER_IMAGE', get_template_directory_uri() . '/assets/img/placeholder.png');
define('CORE_DEFAULT_BANNER_IMAGE', get_template_directory_uri() . '/assets/img/career-bg-pattern.jpg');

define('CORE_DEFAULT_THUMBNAIL', get_template_directory_uri() . '/assets/img/defaults/default-thumbnail.jpg');
define('CORE_DEFAULT_BANNER', get_template_directory_uri() . '/assets/img/defaults/default-banner.jpg');

add_filter('widget_text', 'do_shortcode');

require get_template_directory() . '/inc/core.php';



/* ---------------------------------------------------------------------------

 * Loads Theme Textdomain

 * --------------------------------------------------------------------------- */


function core_setup()
{
    load_theme_textdomain('betheme', LANG_DIR);
    load_theme_textdomain('to-opts', LANG_DIR);
    load_theme_textdomain('massload', LANG_DIR);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'core_setup');

/**

 * WP_nav_menu.

 */

$themename = 'Massload';

// This theme uses wp_nav_menu() in two location.

register_nav_menus(array(

    'primary' => __('Main Menu', $themename),

    'products' => __('Products Menu', $themename),

    'footer1' => __('Footer One', $themename),

    'footer2' => __('Footer Two', $themename),

    'footer3' => __('Footer Three', $themename),

));





function custom_menu_classes($classes, $item, $args)
{

    if ($args->theme_location == 'primary') {

        $classes[] = 'nav-item';
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'custom_menu_classes', 1, 3);



//remove_filter( 'the_content', 'wpautop' );

//remove_filter( 'the_excerpt', 'wpautop' );



/**

 * Enqueue scripts and styles.

 */



add_action('wp_enqueue_scripts', 'massload_scripts');

function massload_scripts()
{
    global $wp_query;

    $ajax_console_result = 'false';

    if (CORE_AJAX_CONSOLE_RESULT) {
        $ajax_console_result = 'true';
    }

    $object_info         = array();
    $taxonomy            = '';
    $taxonomy_obj        = '';
    $term_obj            = '';
    $ajax_data           = array(
        'url'                 => array(
            'site_url'            => get_site_url(),
            'ajaxurl'             => admin_url('admin-ajax.php'),
            'theme_url'           => get_template_directory_uri(),
            'page_slug'           => '',
            'current_url'         => core_get_current_url(),
            'url_path'            => strtok(core_get_current_url(), '?'),
            'url_param'           => parse_url(core_get_current_url(), PHP_URL_QUERY),
        ),
        'templates' => array(
            'sticky_toolbar' => array(
                'contact_us' => core_sticky_toolbar_phone()
            ),
        ),
        'ajax_console_result' => $ajax_console_result,
        'loading'             => '<div class="core-loading-overlay"><div class="loading-table"><div class="loading-wrapper"><span class="loading"></span></div></div></div>',
        // This is available only if CORE_AJAX_CONSOLE_RESULT is true
        'query'               => array(
            'wp_query'            => $wp_query
        ),
    );

    if ('true' !== $ajax_console_result) {
        unset($ajax_data['query']);
    }

    if (is_tax()) {
        $term_id       = $wp_query->queried_object_id;
        $taxonomy      = get_query_var('taxonomy');
        $taxonomy_obj  = get_taxonomy($taxonomy);
        $term_obj      = get_term_by(
            'id',
            $term_id,
            $taxonomy
        );

        $object_info['object_type']    = 'taxonomy';
        $object_info['tax_type']       = $taxonomy;
        $object_info['term_id']        = $term_id;
        $object_info['term_obj']       = $term_obj;
        $object_info['tax_post_types'] = core_get_post_types_by_taxonomy($taxonomy);

        if (isset(get_queried_object()->slug)) {

            $object_info['taxonomy_obj'] = $taxonomy_obj;

            $ajax_data['url']['page_slug'] = $taxonomy_obj->rewrite['slug'] . '/' . get_queried_object()->slug;
        }
        $ajax_data['object_info'] = $object_info;
    } elseif (is_search()) {
        $object_info['object_type'] = 'wp_search';
        $object_info['post_types']  = array('any');
        $object_info['post_type']   = array('any');
        $object_info['tax_type']    = '';
        $object_info['term_id']     = array();
        $object_info['search']      = '';

        if (! empty(get_query_var('post_type'))) {
            $object_info['post_types']  = get_query_var('post_type');
            $object_info['post_type']   = get_query_var('post_type');
        }
        if (! empty(get_query_var('tax'))) {
            $object_info['tax_type']  = get_query_var('tax');
        }
        if (! empty(get_query_var('term'))) {
            $object_info['term_id']  = get_query_var('term');
        }
        if (! empty(get_query_var('s'))) {
            $object_info['search']  = get_query_var('s');
        }

        $ajax_data['object_info'] = $object_info;
    } elseif (is_date()) {
        $object_info['object_type'] = 'date_archive';
        $object_info['post_types']  = CORE_POST_TYPES;
        $object_info['date_query'] = array(
            array(
                'year'  => intval(get_query_var('year')),
                'month' => intval(get_query_var('monthnum')),
                'day'   => intval(get_query_var('day'))
            )
        );

        if (isset(get_queried_object()->post_name)) {
            $ajax_data['url']['page_slug'] = get_queried_object()->post_name;
        }

        $ajax_data['object_info'] = $object_info;
    } else {
        $object_info['object_type'] = 'post';
        $object_info['post_type']   = get_post_type();

        if (isset(get_queried_object()->post_name)) {
            $ajax_data['url']['page_slug'] = get_queried_object()->post_name;
        }
        $ajax_data['object_info'] = $object_info;
    }

    if (is_front_page() && is_home()) {

        wp_enqueue_script('massload-jquery-3.2.1', get_template_directory_uri() . '/assets/js/jquery-3.2.1.slim.min.js', array('jquery'), '1.0', true);
    }

    wp_enqueue_style('massload-select2-style', get_template_directory_uri() . '/assets/css/select2.min.css', '1.1');

    wp_enqueue_script('massload-512de21213', get_template_directory_uri() . '/assets/js/512de21213.js', array('jquery'), '1.1', true);

    wp_enqueue_script('massload-owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '1.2', true);

    wp_enqueue_script('massload-popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), '1.3', true);

    wp_enqueue_script('massload_bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '4.0', true);

    wp_enqueue_script('massload_tab', get_template_directory_uri() . '/assets/js/jquery.responsiveTabs.min.js', array('jquery'), '4.0', true);

    wp_enqueue_script('massload_select2', get_template_directory_uri() . '/assets/js/select2.min.js', array('jquery'), '4.0', true);

    wp_enqueue_script('massload_custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.5', true);



    wp_localize_script(
        'massload_custom',
        'core_object',
        $ajax_data
    );
}





/**

 * Add excerpt

 */



add_post_type_support('page', 'excerpt');

add_post_type_support('case_study', 'excerpt');

add_post_type_support('products', 'page-attributes');





// add tag support to pages

/*function tags_support_all() {

    register_taxonomy_for_object_type('post_tag', 'page');

}



// ensure all tags are included in queries

function tags_support_query($wp_query) {

    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');

}



// tag hooks

add_action('init', 'tags_support_all');

add_action('pre_get_posts', 'tags_support_query');*/





add_filter('body_class', 'massload_body_class');

/**

 * Add "innersection" class to 'body' element for inner pages

 */

function massload_body_class($classes)
{

    if (! is_front_page()) {

        $classes[] = 'innersection';
    }



    return $classes;
}



/**

 * Add Custom Post type

 */



add_action('init', 'create_post_type');

add_post_type_support('products', 'thumbnail');

function create_post_type()
{

    register_post_type(
        'products',

        array(

            'labels' => array(

                'name' => __('Products', 'massload'),

                'singular_name' => __('Product', 'massload')

            ),

            'public' => true,

            'menu_icon' => 'dashicons-products',

            'has_archive' => false,

            'hierarchical' => true,

        )

    );
}





/**

 * Add Custom Taxonomy

 */



function products_taxonomy()
{

    register_taxonomy(

        'producttype',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 

        'products',        //post type name

        array(

            'hierarchical' => true,

            'label' => __('Products Categories', 'massload'),  //Display name

            'query_var' => true,

            'rewrite' => array(

                'slug' => 'producttype', // This controls the base slug that will display before each term

                'with_front' => false // Don't display the category base before 

            )

        )

    );
}

add_action('init', 'products_taxonomy');



function products_parent_taxonomy()
{

    register_taxonomy(

        'parenttaxonomy',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 

        'products',        //post type name

        array(

            'hierarchical' => true,

            'label' => __('Parent Categories', 'massload'),  //Display name

            'query_var' => true,

            'rewrite' => array(

                'slug' => 'parenttaxonomy', // This controls the base slug that will display before each term

                'with_front' => false // Don't display the category base before 

            )

        )

    );
}

add_action('init', 'products_parent_taxonomy');



function taxonomy_post_order($qry)
{

    if ($qry->is_main_query() && $qry->is_tax()) {

        $qry->set('order', 'ASC');
    }
}

add_action('pre_get_posts', 'taxonomy_post_order');



/**

 * Taxonomy Link

 */



function filter_post_type_link($link, $post)

{

    if ($post->post_type != 'products')

        return $link;



    if ($cats = get_the_terms($post->ID, 'category'))

        $link = str_replace('%category%', array_pop($cats)->slug, $link);

    return $link;
}

add_filter('post_type_link', 'filter_post_type_link', 10, 2);





/**

 * avoid migrate problem

 */

add_action('wp_default_scripts', function ($scripts) {

    if (! empty($scripts->registered['jquery'])) {

        $jquery_dependencies = $scripts->registered['jquery']->deps;

        $scripts->registered['jquery']->deps = array_diff($jquery_dependencies, array('jquery-migrate'));
    }
});



/**

 * Enable Page Featured image.

 */

add_theme_support('post-thumbnails');



//Add this code in your theme functions.php file






/* ---------------------------------------------------------------------------

 * Loads the Options Panel

 * --------------------------------------------------------------------------- */

function to_admin_scripts()
{

    // 	wp_enqueue_script( 'jquery-ui-droppable' );

    wp_enqueue_script('jquery-ui-sortable');
}

add_action('wp_enqueue_scripts', 'to_admin_scripts');

add_action('admin_enqueue_scripts', 'to_admin_scripts');



require(THEME_DIR . '/theme-options/theme-options.php');







/**

 * Add Custom Post Type for Case study

 */



add_action('init', 'custom_post_type');

add_post_type_support('case_study', 'thumbnail');

function custom_post_type()
{

    register_post_type(
        'case_study',

        array(

            'labels' => array(

                'name' => __('Case Studies'),

                'singular' => __('Case Studies')

            ),

            'public'      => true,

            'menu_icon'   => 'dashicons-products',

            'has_archive' => false,

            'rewrite'     => array(
                'slug' => 'case-studies'
            ),

        )

    );
}





function casestudies_taxonomy()
{

    register_taxonomy(

        'casestudy_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).

        'case_study',             // post type name

        array(

            'hierarchical' => true,

            'label' => __('Tags', 'massload'), // display name

            'query_var' => true,

            'rewrite' => array(

                'slug' => 'casestudy-category',    // This controls the base slug that will display before each term

                'with_front' => true  // Don't display the category base before

            )

        )

    );
}

add_action('init', 'casestudies_taxonomy');



/**

 * Add Custom Post Type for Applications

 */



add_action('init', 'custom_post_type_application');

add_post_type_support('applications', 'thumbnail');

function custom_post_type_application()
{

    register_post_type(
        'applications',

        array(

            'labels' => array(

                'name' => __('Applications'),

                'singular' => __('Application')

            ),

            'public' => true,

            'menu_icon' => 'dashicons-products',

            'has_archive' => false,

        )

    );
}





/** ============================= Shortcodes =========================================== */

/** 

 * Products Section

 */

function products_function()
{

    ob_start();

?>

    <div class="product-block">

        <div class="row">

            <?php

            $args = array(

                'post_type' => 'products',

                'orderby' => 'date',

                'order'   => 'ASC',

                'posts_per_page' => 4,

            );

            $the_query = new WP_Query($args);

            global $wp_query;

            ?>

            <?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();

                    /* grab the url for the full size featured image */

                    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");

                    //echo $thumbnail[0]."param";

            ?>

                    <div class="col-sm-6 col-md-6 col-lg-3">

                        <div class="productblock">

                            <img src="<?php echo $thumbnail[0]; ?>" />

                            <div class="product-content">

                                <h3><?php the_title(); ?></h3>

                                <?php the_content(); ?>

                                <a class="product-btn" href="<?php the_permalink(); ?>"><?php esc_html_e('learnmore', 'massload'); ?></a>

                            </div>

                        </div>

                    </div>

                <?php endwhile;
            else: ?>
                <p><?php esc_html_e('Sorry, there are no news to display', 'massload'); ?></p>
            <?php endif; ?>

        </div>

    </div>

<?php

    $result = ob_get_contents();

    ob_end_clean();

    return $result;
}

add_shortcode('products', 'products_function');





function custom_excerpt_length($length)
{

    return 55;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);



/*

function stc_register_sidebars() {

    register_sidebar( array(

        'name' => 'Home menu sidebar',

        'id' => 'language_switcher',

        'before_widget' => '<div>',

        'after_widget' => '</div>',

        'before_title' => '<h2 class="rounded">',

        'after_title' => '</h2>',

    ) );

}

add_action( 'widgets_init', 'stc_register_sidebars' );



function register_my_menus() {

  register_nav_menus(

    array(

      'header-menu' => __( 'Header Menu' ),

      'extra-menu' => __( 'Extra Menu' )

     )

   );

 }

 add_action( 'init', 'register_my_menus' );





function custom_menu_classes($classes, $item, $args) {

  if($args->theme_location == 'header-menu') {

    $classes[] = 'nav-item';

  }

  return $classes;

}

add_filter('nav_menu_css_class', 'custom_menu_classes', 1, 3);



function add_class_to_all_menu_anchors( $atts ) {

    $atts['class'] = 'nav-link';

 

    return $atts;

}



add_filter( 'nav_menu_link_attributes', 'add_class_to_all_menu_anchors', 10 );



function wpdocs_custom_dropdown_class( $classes ) {

    $classes[] = 'dropdown-menu';

 

    return $classes;

}

 

add_filter( 'nav_menu_submenu_css_class', 'wpdocs_custom_dropdown_class' );

 */



add_theme_support('title-tag');


add_filter('wpcf7_additional_mail', 'wpcf7_send_mail_to_self', 10, 2);

function wpcf7_send_mail_to_self($additional_mail, $cf)
{
    $cf = WPCF7_Submission::get_instance();
    $posted_data = $cf->get_posted_data();
    if ("Receive a copy of the form request" != $posted_data['send_c'][0])
        $additional_mail = array();

    return $additional_mail;
}


function check_mail_send_contactform($cf7)
{

    if (190 == $cf7->id()) {
        //get CF7's mail and posted_data objects
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $posted_data = $submission->get_posted_data();
        }
        $mail = $cf7->prop('mail');

        if ($posted_data['send_c'][0]) { //if Checkbox checked
            $mail2 = $cf7->prop('mail_2'); //get CF7's mail_2 object
            //now set sender's address to mail2's recipient
            $mail2['recipient'] = $posted_data['email'];
            //wp_mail("nilay.patel@wowfactormedia.ca","testss",@serialize($posted_data));
            // wp_mail("nilay.patel@wowfactormedia.ca","testss122",serialize($mail2));
            $cf7->set_properties(array('mail_2' => $mail2));
        }
    }

    if (1346 == $cf7->id()) {
        //get CF7's mail and posted_data objects
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $posted_data = $submission->get_posted_data();
        }
        $mail = $cf7->prop('mail');

        if ($posted_data['send_c'][0]) { //if Checkbox checked
            $mail2 = $cf7->prop('mail_2'); //get CF7's mail_2 object
            //now set sender's address to mail2's recipient
            $mail2['recipient'] = $posted_data['emailaddr'];
            wp_mail("nilay.patel@wowfactormedia.ca", "testss", @serialize($posted_data));
            // wp_mail("nilay.patel@wowfactormedia.ca","testss122",serialize($mail2));
            $cf7->set_properties(array('mail_2' => $mail2));
        }
    }

    if (218 == $cf7->id()) {
        //get CF7's mail and posted_data objects
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $posted_data = $submission->get_posted_data();
        }
        $mail = $cf7->prop('mail');

        if ($posted_data['send_c'][0]) { //if Checkbox checked
            $mail2 = $cf7->prop('mail_2'); //get CF7's mail_2 object
            //now set sender's address to mail2's recipient
            $mail2['recipient'] = $posted_data['emailaddr'];
            //wp_mail("nilay.patel@wowfactormedia.ca","testss",@serialize($posted_data));
            // wp_mail("nilay.patel@wowfactormedia.ca","testss122",serialize($mail2));
            $cf7->set_properties(array('mail_2' => $mail2));
        }
    }

    if (1840 == $cf7->id()) {
        //get CF7's mail and posted_data objects
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $posted_data = $submission->get_posted_data();
        }
        $mail = $cf7->prop('mail');

        if ($posted_data['send_c'][0]) { //if Checkbox checked
            $mail2 = $cf7->prop('mail_2'); //get CF7's mail_2 object
            //now set sender's address to mail2's recipient
            $mail2['recipient'] = $posted_data['emailaddr'];
            //wp_mail("nilay.patel@wowfactormedia.ca","testss",@serialize($posted_data));
            // wp_mail("nilay.patel@wowfactormedia.ca","testss122",serialize($mail2));
            $cf7->set_properties(array('mail_2' => $mail2));
        }
    }

    return $cf7;
}
add_action('wpcf7_before_send_mail', 'check_mail_send_contactform');

require get_template_directory() . '/inc/loader.php';
require get_template_directory() . '/inc/extras.php';
add_post_type_support('products', 'revisions');



add_action('wp_footer', 'method');

function method()
{
    echo "<style> li.checkbox > label {
    display: block !important;
}</style>
";
}

function allow_iframes_in_acf($allowed_tags)
{
    $allowed_tags['iframe'] = [
        'src' => true,
        'width' => true,
        'height' => true,
        'frameborder' => true,
        'allow' => true,
        'allowfullscreen' => true,
    ];
    return $allowed_tags;
}
add_filter('wp_kses_allowed_html', 'allow_iframes_in_acf', 10, 2);

/* Turn off the WordPress Admin Bar for all users */
//add_filter('show_admin_bar', '__return_false');

/**
 * Related Products Source Toggle — sidebar meta box
 */
function massload_related_products_metabox() {
    add_meta_box(
        'massload_related_source',
        'Related Products Source',
        'massload_related_source_callback',
        'product',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'massload_related_products_metabox');

function massload_related_source_callback($post) {
    wp_nonce_field('massload_related_source_nonce', 'massload_related_source_nonce_field');
    $source = get_post_meta($post->ID, '_related_products_source', true);
    if (empty($source)) $source = 'custom'; // default to ACF options
    ?>
    <style>
        .massload-toggle { display:flex; gap:10px; margin:10px 0; }
        .massload-toggle label {
            flex:1; text-align:center; padding:8px 12px;
            border:2px solid #ddd; border-radius:4px; cursor:pointer;
            font-weight:600; font-size:12px; transition:all 0.2s;
        }
        .massload-toggle input { display:none; }
        .massload-toggle input:checked + label {
            border-color:#e30913; background:#e30913; color:#fff;
        }
        .massload-toggle label:hover { border-color:#e30913; }
    </style>
    <div class="massload-toggle">
        <span>
            <input type="radio" name="_related_products_source" id="rps_custom" value="custom" <?php checked($source, 'custom'); ?>>
            <label for="rps_custom">Custom (ACF)</label>
        </span>
        <span>
            <input type="radio" name="_related_products_source" id="rps_woo" value="woocommerce" <?php checked($source, 'woocommerce'); ?>>
            <label for="rps_woo">WooCommerce</label>
        </span>
    </div>
    <p class="description" style="margin-top:8px;">
        <strong>Custom:</strong> Uses the ACF Options repeater.<br>
        <strong>WooCommerce:</strong> Uses Linked Products → Upsells.
    </p>
    <?php
}

function massload_save_related_source($post_id) {
    if (!isset($_POST['massload_related_source_nonce_field'])) return;
    if (!wp_verify_nonce($_POST['massload_related_source_nonce_field'], 'massload_related_source_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['_related_products_source'])) {
        update_post_meta($post_id, '_related_products_source', sanitize_text_field($_POST['_related_products_source']));
    }
}
add_action('save_post_product', 'massload_save_related_source');

/**
 * YITH Request a Quote — Save extra form fields and include in email
 */
function massload_ywraq_save_extra_fields($args) {
    $extra_fields = ['rqa_last_name', 'rqa_phone', 'rqa_company', 'rqa_country', 'rqa_priority', 'rqa_source', 'rqa_send_copy', 'rqa_newsletter'];
    foreach ($extra_fields as $field) {
        if (isset($_POST[$field])) {
            $args[$field] = sanitize_text_field($_POST[$field]);
        }
    }
    return $args;
}
add_filter('ywraq_request_quote_args', 'massload_ywraq_save_extra_fields');

function massload_ywraq_email_body($body, $args) {
    $extra = '';
    if (!empty($args['rqa_last_name']))  $extra .= '<br><strong>Last Name:</strong> ' . esc_html($args['rqa_last_name']);
    if (!empty($args['rqa_phone']))      $extra .= '<br><strong>Phone:</strong> ' . esc_html($args['rqa_phone']);
    if (!empty($args['rqa_company']))    $extra .= '<br><strong>Company:</strong> ' . esc_html($args['rqa_company']);
    if (!empty($args['rqa_country']))    $extra .= '<br><strong>Country:</strong> ' . esc_html($args['rqa_country']);
    if (!empty($args['rqa_priority']))   $extra .= '<br><strong>Priority:</strong> ' . esc_html($args['rqa_priority']);
    if (!empty($args['rqa_source']))     $extra .= '<br><strong>How they heard about us:</strong> ' . esc_html($args['rqa_source']);
    if (!empty($args['rqa_newsletter'])) $extra .= '<br><strong>Newsletter opt-in:</strong> Yes';

    if (!empty($extra)) {
        $body .= '<br><hr><h3>Additional Information</h3>' . $extra;
    }
    return $body;
}
add_filter('ywraq_request_quote_email_body', 'massload_ywraq_email_body', 10, 2);

/**
 * Send copy to customer if they checked the box
 */
function massload_ywraq_send_copy($args) {
    if (!empty($args['rqa_send_copy']) && $args['rqa_send_copy'] === 'yes' && !empty($args['rqa_email'])) {
        add_filter('ywraq_request_quote_email_headers', function($headers) use ($args) {
            $headers[] = 'Cc: ' . sanitize_email($args['rqa_email']);
            return $headers;
        });
    }
}
add_action('ywraq_process_request_quote', 'massload_ywraq_send_copy');
?>