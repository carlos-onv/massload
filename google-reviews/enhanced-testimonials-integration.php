<?php

/**
 * Google Reviews Integration - Enhanced Version
 * Adds 'source' parameter to existing [wp-testimonials] shortcode
 * 
 * THEME VERSION - Works with existing shortcode
 */

defined('ABSPATH') or die('No script kiddies please!');

/**
 * Enhanced Testimonials Integration
 * Extends the existing wp-testimonials shortcode with source parameter
 */
class EnhancedTestimonialsIntegration
{
    private $plugin;

    public function __construct($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Initialize the enhancement
     */
    public function init()
    {
        // Hook into wp_testimonials shortcode to add source parameter
        add_filter('pre_do_shortcode_tag', array($this, 'intercept_shortcode'), 10, 4);

        // Load custom styles and scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Intercept wp-testimonials shortcode to add source functionality
     */
    public function intercept_shortcode($return, $tag, $attr, $m)
    {
        // Only intercept wp-testimonials shortcode
        if ($tag !== 'wp-testimonials') {
            return $return;
        }

        // Parse attributes
        $atts = shortcode_parse_atts($attr);

        // Check if source parameter is set
        if (isset($atts['source']) && $atts['source'] === 'google') {
            // Return Google embed instead
            return $this->render_google_embed();
        }

        // Let the original shortcode handle it (plugin testimonials)
        return $return;
    }

    /**
     * Load custom CSS and JS for enhanced slider
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style(
            'enhanced-testimonials-slider',
            get_stylesheet_directory_uri() . '/google-reviews/css/google-slider.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'enhanced-testimonials-slider',
            get_stylesheet_directory_uri() . '/google-reviews/js/google-slider.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }

    /**
     * Render Google reviews embed (Elfsight)
     */
    private function render_google_embed()
    {
        ob_start();
?>
        <div class="elfsight-app-9d3f4d84-9767-4ffe-9516-bfe35333b1dd" data-elfsight-app-lazy=""></div>
        <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
<?php
        return ob_get_clean();
    }
}
