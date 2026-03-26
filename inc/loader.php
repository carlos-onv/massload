<?php
// Post Type Loader
require get_template_directory() . '/inc/post-types/loader.php';

// Taxonomy Loader
require get_template_directory() . '/inc/taxonomies/loader.php';

// WP Table Loader
require get_template_directory() . '/inc/wp-table/loader.php';

// Custom Query Loader
require get_template_directory() . '/inc/query/loader.php';

// Utility Functions
require get_template_directory() . '/inc/util/loader.php';

// Rewrite Rules Loader
require get_template_directory() . '/inc/rewrite-rules/loader.php';

// Data Processing Functions
require get_template_directory() . '/inc/processors/loader.php';

// Data Handlers for Read, Add, Update and Delete Functions
require get_template_directory() . '/inc/data-handlers/loader.php';

// Format Modifying Functions
require get_template_directory() . '/inc/formats/loader.php';

// AJAX Loader
require get_template_directory() . '/inc/ajax/loader.php';

// Templates Loader
require get_template_directory() . '/inc/templates/loader.php';

// Shortcode Loader
require get_template_directory() . '/inc/shortcodes/loader.php';

// Advance Custom Fields Code Config Loader
require get_template_directory() . '/inc/acf/loader.php';