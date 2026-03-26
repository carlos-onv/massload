<?php
/**
 * Template Name: Career Page
 *
 * This is the most generic template file 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
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
                            <?php if( get_field('career_joblist_section_title') ): ?>
                                <h2><?php the_field('career_joblist_section_title');?></h2>
                            <?php endif; ?>
                            <?php if( get_field('career_joblist_section_title') ): ?>
                                <p><?php the_field('career_joblist_section_description');?></p>
                            <?php endif; ?>
                            
                        </div>
                        <?php
                            // The Loop
                                if ( have_rows('careerpage_career_opportunities')) :
                                while( have_rows('careerpage_career_opportunities') ) : the_row();
                                    //
                                ?>
                                

                                    <div class="col-md-6 col-lg-4">
                                        <div class="productblock childProduct joblistingpage">
                                            <div class="product-content career_desc">
                                                <h3><a class="" href="/careers#career-apply"><?php _e(get_sub_field('career_job_title'),'massloadinc'); ?></a></h3>
                                                <h5><i class="fa fa-map-marker"></i><?php _e(get_sub_field('career_job_location'),'massloadinc'); ?></h5>
                                                <p><?php _e(get_sub_field('career_job_description'),'massloadinc'); ?></p>


                                            </div>
                                            <a href="/careers#career-apply" class="btn applynow com-btn"><?php _e('Apply Now','massloadinc'); ?>&emsp;<i class="fa fa-paper-plane"></i></a>
                                        </div>
                                    </div>
                                <?php endwhile;
                                endif;
                                // Reset Post Data
                                wp_reset_postdata();
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
                    <?php //echo do_shortcode('[contact-form-7 id="1890" title="Job Application"]');?>
                    <!-- SharpSpring Form for Career Inquiry  -->
                    <script type="text/javascript">
                        var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzFKMjA0ME3WNU9NS9U1MU1O1bVMNrDQNUpJTDYzT0k0MjQ3AAA'};
                        ss_form.width = '100%';
                        ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
                        // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
                        // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
                        // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
                    </script>
                    <script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>
                </div>
            </div>
         </section>   
      
    </div>
<?php
 if ( have_rows('careerpage_career_opportunities')) :
    while( have_rows('careerpage_career_opportunities') ) : the_row();
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                var newval = "<?php _e(ucwords(get_sub_field('career_job_title')),'massloadinc'); ?>";
                jQuery("#postionlist").append(jQuery("<option></option>").attr("value",newval).text(newval));
            });
        </script>
        <?php
    endwhile;
endif;
get_footer(); ?>