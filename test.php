<?php 
/**
 * Template Name: Print Test
 */


get_header(); 
$banner = get_the_post_thumbnail_url(get_the_ID(),'full');
?>
<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-image: url('<?php echo $banner;?>');">
        <div class="container">			
            <h1><?php the_title();?></h1>
            <?php core_breadcrumbs(); ?>      
        </div>
    </div>
</div>

<div id="pagecontent" class="pagecontent careerpage">
       <section class="product-section parent-product-lisiting text-center product-lisiting">
            <div class="container">
                <div class="heading-block">
                    <?php if( get_field('custom_title') ): ?>
                        <h2><?php the_field('custom_title');?></h2>
                    <?php endif; ?>
                    <?php 
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post(); 
                            the_content();
                            endwhile; 
                        endif; 
                    ?>
                    <?php if(get_field('career_join_massload_button_text')){?>
                        <a href="<?php _e(get_field('career_join_massload_button_link'),'massloadinc'); ?>" class="margin20 btn com-btn"><?php _e(get_field('career_join_massload_button_text'),'massloadinc'); ?></a> 
                    <?php } ?>

                    <br /><br /><br /><br />
                    <?php if( get_field('career_why_massload_section_title') ): ?>
                        <h2 class="smalltitles"><?php _e(the_field('career_why_massload_section_title'),'massloadinc');?></h2>
                    <?php endif; ?>

                    <div class="whymassload">
                        <?php _e(get_field('career_why_massload_section_description'),'massloadinc'); ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="fityourbestsec text-center">
            <div class="container"> 
                <div class="product-block">
                    <div class="row">
                        <div class="heading-block carrer_fullwidth">
                            <?php if( get_field('career_find_your_best_fit_section_title') ): ?>
                                <h2><?php the_field('career_find_your_best_fit_section_title');?></h2>
                            <?php endif; ?>
                        </div>
                        <div class="fityourbestdesc">
                            <?php _e(get_field('career_find_your_best_fit_section_description'),'massloadinc'); ?>

                            <a href="<?php _e(get_field('career_find_your_best_fit_section_button_link'),'massloadinc'); ?>" class="btn com-btn" target="_blank" ><?php _e(get_field('career_find_your_best_fit_section_button_text'),'massloadinc'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-section parent-product-lisiting text-center product-lisiting">
            <div class="container">   
                <div class="product-block">
                    <div class="row">
                        <div class="heading-block carrer_fullwidth">
                           <?php echo "Testing"; ?>
                            
                        </div>
                        <?php
                            // The Loop
                                
                                    //
                                ?>
                                

                                    <div class="col-md-6 col-lg-4">
                                        <div class="productblock childProduct joblistingpage">
                                            <div class="product-content career_desc">
                                                <img src="http://massload.wowfactormedia.ca/wp-content/uploads/2020/05/LCIB-High-Speed-Load-Cell-USB-Interface-Massload-Technologies-May-20211-1.jpg"/>

                                            </div>
                                            <a href="#career-apply" class="btn applynow com-btn"><?php _e('Apply Now','massloadinc'); ?>&emsp;<i class="fa fa-paper-plane"></i></a>
                                        </div>
                                    </div>
                                <?php 
                            ?>
                    </div>
                </div>
            </div>
        </section>     

        <section id="career-apply" class="quaote_blk">
            <div class="container">
                 <div class="heading-block text-center">
                    <h2><?php echo __(get_field('career_form_section_title'),'massloadinc'); ?></h2>
                    <p><?php echo __(get_field('career_form_section_description'),'massloadinc'); ?></p>
                    <p><br></p>
                </div>
                <div class="theme_form">
                    <?php echo do_shortcode('[contact-form-7 id="1890" title="Job Application"]');?>
                </div>
            </div>
         </section>   
      
    </div>
<?php
if( function_exists( 'mpdf_pdfbutton' ) ) {
mpdf_pdfbutton(true);
}
 
get_footer(); ?>