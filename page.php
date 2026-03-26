<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header(); 

$banner = get_the_post_thumbnail_url(get_the_ID(),'full');



?>
<?php if(is_page(1656)){ ?>
	<div id="pagebanner" class="pagebanner resources_banner">
<?php }else{ ?>
<div id="pagebanner" class="pagebanner casestudies_banner">
<?php } ?>
    <div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php core_breadcrumbs(); ?>
        </div>
    </div>
</div>


<main id="pagecontent" role="content">
    <section class="innerpages">
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