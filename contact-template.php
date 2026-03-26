<?php
/**
 * Template Name: Contact Page
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
    <div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php core_breadcrumbs(); ?>
        </div>
    </div>
</div>
<section class="pb-50 contactsection">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 pt-80">
          
          <div class="heading-block left-border">
            <h2><?php _e(get_field('contact_left_section_title'),'massloadinc'); ?></h2>
          </div>
          <?php 
          if( have_rows('contact_departments') ):
          ?>
          <div class="cnt_left_details">

          	<?php 
          	while( have_rows('contact_departments') ) : the_row();
          	?>
          	<h4><?php _e(get_sub_field('contact_department_title'),'massloadinc'); ?></h4>
          	<ul>
          		<li>
          			<label><?php _e('Phone:','massloadinc'); ?></label><a href="tel:<?php _e(get_sub_field('contact_department_phone'),'massloadinc'); ?>"><?php _e(get_sub_field('contact_department_phone'),'massloadinc'); ?></a>
          		</li>
          		<?php if(get_sub_field('contact_department_email')){ ?>
          		<li>
          			<label><?php _e('E-Mail:','massloadinc'); ?></label><a href="mailto:<?php _e(get_sub_field('contact_department_email'),'massloadinc'); ?>"><?php _e(get_sub_field('contact_department_email'),'massloadinc'); ?></a>
          		</li>
          		<?php } ?>
          	</ul>
          <?php endwhile; ?>
          </div>
      <?php endif; ?>
          
        </div>
        <div class="col-sm-6  pt-80 cnt_rightbox">
          <div class="heading-block left-border">
            <h2><?php _e(get_field('contact_right_section_title'),'massloadinc'); ?></h2>          
          </div>
          <?php the_content(); ?>
          <div class="theme_form"><!-- SharpSpring Form for Contact Us  -->
<script type="text/javascript">
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'S0ozT00xSTHRNTY1MdY1STM0000yTDbRtTRJSjZPNjQ3SjU0AAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>

            <?php //echo do_shortcode('[contact-form-7 id="1840" title="Contact Us Final"]');?>
          </div>
        </div>
      </div>
    </div>
  </section>


    <div id="pagecontent" class="pagecontent contatpagecnt">
         <section class="quaote_blk">
            <div class="container">
                <?php if(get_field('contact_cant_find_section')){ ?>
                 <div class="heading-block text-center">
                    <h2 class="simple_title"><?php _e(get_field('contact_cant_find_section'),'massloadinc'); ?></h2>
                </div>
                <?php } ?>
            <?php  if( have_rows('cant_find_section_buttons') ): ?>
                <div class="theme_form">
                <?php 
		        while( have_rows('cant_find_section_buttons') ) : the_row();
		          	?>
                	<a href="<?php _e(get_sub_field('contact_button_link'),'massloadinc'); ?>" class="btn com-btn"><?php _e(get_sub_field('contact_button_title'),'massloadinc'); ?>  </a>
                <?php endwhile; ?>
                    
                </div>
            <?php endif; ?>
            </div>
         </section> 


         <!-- start -->
         <section class="pb-50 mapsection">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 pt-80">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2445.329957984074!2d-106.64639102333814!3d52.20105107197934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5304f56955bd64a1%3A0xf2c03a1478b9d978!2sMassload%20Technologies%20Inc.!5e0!3m2!1sen!2sca!4v1748622263125!5m2!1sen!2sca" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          
        </div>
        <div class="col-sm-6  pt-80 cnt_rightbox">
          <div class="heading-block left-border">
            <h2><?php _e(get_field('head_quarters_title'),'massloadinc'); ?></h2>          
          </div>
          <div class="theme_form">
            <?php _e(get_field('head_quarters_details'),'massloadinc'); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
         <!-- end -->
         
    </div>

<?php
$contact_right_section_background_image = get_field('contact_right_section_background_image');
  if($contact_right_section_background_image['url']){
      $contact_right_section_background_image = $contact_right_section_background_image['url'];
  }else{
      $contact_right_section_background_image = get_bloginfo('url').'/wp-content/uploads/2020/11/contact-form-background.jpg';
  }

$contact_map_image = get_field('contact_map_image');
  if(is_array($contact_map_image) && $contact_map_image['url']){
      $contact_map_image = $contact_map_image['url'];
  }else{
      $contact_map_image = get_bloginfo('url').'/wp-content/uploads/2020/11/map.jpg';
  }

   ?>
<style type="text/css">
	/*.col-sm-6.cnt_rightbox{ background-image: url('<?php echo $contact_right_section_background_image; ?>'); }*/
	.pagecontent.contatpagecnt .mapsection::before {
		background-image: url('<?php echo $contact_map_image; ?>');
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery("#wpcf7-f1840-o1 .form-group select option:first").text('Please contact me by');
	});
	
</script>
<?php get_footer(); ?>