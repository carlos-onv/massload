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
    <section class="innerpages Child">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="interiorpage">
		
                            <?php 
                                if ( have_posts() ) :
                                    while ( have_posts() ) : the_post(); 
                                	the_content();
                                    endwhile; 
                                endif; 
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>