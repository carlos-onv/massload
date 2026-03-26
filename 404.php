<?php
/**
 * The template for displaying single page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header(); ?>
		
 <main id="pagecontent" role="content">
    <section class="page_not_found">
        <div class="container text-center">
             <h3><?php esc_html_e( 'Oops!', 'massload'); ?></h3>
                <p><?php esc_html_e( 'That page can’t be found.', 'massload'); ?> <br><br></p>
                <p><a class="theme-btn" href="<?php echo home_url();?>"><?php esc_html_e( 'Back Home', 'massload'); ?></a></p>
        </div>
    </section>
</main>
<?php get_footer(); ?>