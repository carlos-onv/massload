<?php

/**
 * Google Reviews Integration
 * Integrates Google reviews with the testimonials plugin
 * 
 * THEME VERSION - Updated paths for theme integration
 */

defined('ABSPATH') or die('No script kiddies please!');

class GoogleReviewsIntegration
{

    private $plugin;

    public function __construct($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Creates a shortcode to display Google reviews in horizontal format
     */
    public function init()
    {
        add_shortcode('google-testimonials-slider', array($this, 'render_google_slider'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Loads necessary scripts for the slider
     * UPDATED: Uses theme paths instead of plugin paths
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style(
            'google-testimonials-slider',
            get_template_directory_uri() . '/google-reviews/css/google-slider.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'google-testimonials-slider',
            get_template_directory_uri() . '/google-reviews/js/google-slider.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }

    /**
     * Renders the Google reviews slider
     */
    public function render_google_slider($atts)
    {
        $atts = shortcode_atts(array(
            'widget-id' => null,
            'source' => 'plugin', // 'plugin' or 'google'
            'layout' => 'slider', // slider, grid, list
            'autoplay' => 'true',
            'interval' => '5000',
            'stars-only' => 'false'
        ), $atts);

        // If source is 'google', always render Google embed
        if ($atts['source'] === 'google') {
            return $this->render_google_embed();
        }

        // If no widget-id, render Google embed as fallback
        if (!$atts['widget-id']) {
            return $this->render_google_embed();
        }

        // Get testimonials from widget
        $widget = $this->plugin->get_widget($atts['widget-id']);
        if (!$widget) {
            return $this->render_google_embed();
        }

        $val = unserialize($widget->value);
        $style_id = isset($val['2']) ? $val['2'] : 4; // Default to slider
        $scss_set = isset($val['3']) ? $val['3'] : 'light-background';

        // Force horizontal slider styles
        if (!in_array($style_id, [4, 5, 13, 15, 19, 34, 36, 37, 39, 44, 45, 46, 47])) {
            $style_id = 4; // Default slider
        }

        ob_start();
?>
        <div class="google-testimonials-wrapper" data-autoplay="<?php echo esc_attr($atts['autoplay']); ?>" data-interval="<?php echo esc_attr($atts['interval']); ?>">
            <?php echo $this->plugin->get_noreg_list_reviews($widget->id, true, $style_id, $scss_set); ?>
        </div>
    <?php
        return ob_get_clean();
    }

    /**
     * Renders the Elfsight embed as fallback or alternative
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

    /**
     * Helper function to create testimonials from Google data
     */
    public function create_testimonial_from_google($review_data)
    {
        $testimonial = array(
            'post_title'   => $review_data['author_name'],
            'post_content' => $review_data['text'],
            'post_status'  => 'publish',
            'post_type'    => 'wpt-testimonial',
            'post_author'  => 1
        );

        $post_id = wp_insert_post($testimonial);

        if ($post_id && !is_wp_error($post_id)) {
            // Add rating
            if (isset($review_data['rating'])) {
                update_post_meta($post_id, 'rating', intval($review_data['rating']));
            }

            // Add company/location
            if (isset($review_data['company'])) {
                update_post_meta($post_id, 'company', sanitize_text_field($review_data['company']));
            }

            // Add author photo URL if exists
            if (isset($review_data['profile_photo_url'])) {
                update_post_meta($post_id, 'author_photo_url', esc_url($review_data['profile_photo_url']));
            }

            // Add review date
            if (isset($review_data['time'])) {
                update_post_meta($post_id, 'review_date', sanitize_text_field($review_data['time']));
            }

            return $post_id;
        }

        return false;
    }

    /**
     * REST API endpoint to receive Google reviews
     */
    public function register_rest_routes()
    {
        register_rest_route('google-testimonials/v1', '/import', array(
            'methods'  => 'POST',
            'callback' => array($this, 'import_google_reviews'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            }
        ));
    }

    /**
     * Imports Google reviews via REST API
     */
    public function import_google_reviews($request)
    {
        $reviews = $request->get_param('reviews');

        if (empty($reviews)) {
            return new WP_Error('no_reviews', 'No reviews provided', array('status' => 400));
        }

        $imported = 0;
        foreach ($reviews as $review) {
            if ($this->create_testimonial_from_google($review)) {
                $imported++;
            }
        }

        return rest_ensure_response(array(
            'success' => true,
            'imported' => $imported,
            'message' => sprintf('Successfully imported %d reviews', $imported)
        ));
    }
}
