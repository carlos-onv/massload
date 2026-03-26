<?php
/**
 * Template Name: Our Services
 *
 * This is the most generic template file 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header();
?>
<div id="pagebanner" class="pagebanner service-banner">
  <div class="inner-banner" style="background-image: url(<?php the_field('banner_image'); ?>);">
    <div class="container">
      <h1>
        <?php the_title(); ?>
      </h1>

      <?php core_breadcrumbs(); ?>
      <a class="case_study_btn com-btn" href="<?php if (get_field('services_button_link')) {
                                                echo get_field('services_button_link');
                                              } else {
                                                echo "#";
                                              }  ?>" target="_self" style=""><?php if (get_field('services_button_text')): _e(get_field('services_button_text'), 'massload');
                                                                              endif; ?></a>
    </div>
  </div>
</div>

<div id="pagecontent" class="pagecontent">
  <section class="service-page">
    <div class="container">
      <div class="heading-block service-heading left-border pt-50 pb-50" id="service_tts_rma">
        <?php if (get_field('custom_title')): ?><h2><?php the_field('custom_title'); ?></h2><?php endif; ?>
        <?php
        if (have_posts()) :
          while (have_posts()) : the_post();
            the_content();
          endwhile;
        endif;
        ?>
      </div>
      <div class="row justify-content-between">
        <div class="col-md-5">
          <div class="tss">
            <div class="tss-img">
              <?php
              $services_main_left_icon = get_field('services_main_left_icon');
              if ($services_main_left_icon) { ?><img src="<?php echo $services_main_left_icon['url']; ?>" alt="<?php echo $services_main_left_icon['alt']; ?>"><?php } ?>
            </div>
            <div class="heading-block secondary-h2 left-border">
              <?php if (get_field('services_main_left_title')): ?><h2><?php the_field('services_main_left_title'); ?></h2><?php endif; ?>
            </div>
            <?php if (get_field('services_main_left_description')): the_field('services_main_left_description');
            endif; ?>
          </div>
        </div>
        <div class="col-md-5">
          <div class="tss">
            <div class="tss-img">
              <?php
              $services_main_right_icon = get_field('services_main_right_icon');
              if ($services_main_right_icon) { ?><img src="<?php echo $services_main_right_icon['url']; ?>" alt="<?php echo $services_main_right_icon['alt']; ?>"><?php } ?>
            </div>
            <div class="heading-block secondary-h2 left-border">
              <?php if (get_field('services_main_right_title')): ?><h2><?php the_field('services_main_right_title'); ?></h2><?php endif; ?>
            </div>
            <?php if (get_field('services_main_right_description')): the_field('services_main_right_description');
            endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="service_tcs" class="tcs pt-80" style="background-image: url(<?php echo home_url(); ?>/wp-content/themes/massload/assets/img/global/service-bg-pattern.png);">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <?php
          $services_testing_and_calibration_image = get_field('services_testing_and_calibration_image');
          if ($services_testing_and_calibration_image) { ?><img src="<?php echo $services_testing_and_calibration_image['url']; ?>" alt="<?php echo $services_testing_and_calibration_image['alt']; ?>"><?php } else { ?>
            <img src="<?php echo get_bloginfo("template_url"); ?>/assets/img/services/Testing-And-Calibration-Services.png">
          <?php } ?>
        </div>
        <div class="col-md-6">
          <div class="tss bottom25">
            <div class="tss-img">
              <?php
              $services_testing_and_calibration_icon = get_field('services_testing_and_calibration_icon');
              if ($services_testing_and_calibration_icon) { ?><img src="<?php echo $services_testing_and_calibration_icon['url']; ?>" alt="<?php echo $services_testing_and_calibration_icon['alt']; ?>"><?php } ?>
            </div>
          </div>
          <div class="headingsecondary-block">
            <?php if (get_field('services_testing_and_calibration_title')): ?><h2><?php the_field('services_testing_and_calibration_title'); ?></h2><?php endif; ?>
          </div>
          <?php if (get_field('services_testing_and_calibration_description')): the_field('services_testing_and_calibration_description');
          endif; ?>
        </div>
      </div>
    </div>
  </section>
  <section id="service_cgs_ss" class="servicesListings pt-80 pb-50 cgservices">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <div class="tss bottom25">
            <div class="tss-img"><?php
                                  $services_custom_gauging_services_icon = get_field('services_custom_gauging_services_icon');
                                  if ($services_custom_gauging_services_icon) { ?><img src="<?php echo $services_custom_gauging_services_icon['url']; ?>" alt="<?php echo $services_custom_gauging_services_icon['alt']; ?>"><?php } ?></div>
          </div>
          <div class="heading-block left-border">
            <?php if (get_field('services_custom_gauging_services_title')): ?><h2><?php the_field('services_custom_gauging_services_title'); ?></h2><?php endif; ?>
          </div>
          <?php if (get_field('services_custom_gauging_services_description')): the_field('services_custom_gauging_services_description');
          endif; ?>
        </div>
        <div class="col-sm-6 servicesList_inner_wrap">
          <div class="tss bottom25">
            <div class="tss-img"><?php
                                  $services_software_services_icon = get_field('services_software_services_icon');
                                  if ($services_software_services_icon) { ?><img src="<?php echo $services_software_services_icon['url']; ?>" alt="<?php echo $services_software_services_icon['alt']; ?>"><?php } ?></div>
          </div>
          <div class="heading-block left-border">
            <?php if (get_field('services_software_services_title')): ?><h2><?php the_field('services_software_services_title'); ?></h2><?php endif; ?>
          </div>
          <?php if (get_field('services_software_services_description')): the_field('services_software_services_description');
          endif; ?>
        </div>
      </div>
    </div>
  </section>
  <section id="services_sds_mfs" class="servicesListings pt-80 pb-50 solutiondevelopment">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <div class="tss bottom25">
            <div class="tss-img"><?php
                                  $services_solution_development_services_icon = get_field('services_solution_development_services_icon');
                                  if ($services_solution_development_services_icon) { ?><img src="<?php echo $services_solution_development_services_icon['url']; ?>" alt="<?php echo $services_solution_development_services_icon['alt']; ?>"><?php } ?></div>
          </div>
          <div class="heading-block left-border">
            <?php if (get_field('services_solution_development_services_title')): ?><h2><?php the_field('services_solution_development_services_title'); ?></h2><?php endif; ?>
          </div>
          <?php if (get_field('services_solution_development_services_description')): the_field('services_solution_development_services_description');
          endif; ?>
        </div>
        <div class="col-sm-6">
          <div class="servicesList_inner_wrap">
            <div class="tss bottom25">
              <div class="tss-img"><?php
                                    $services_machining_and_fabricating_services_icon = get_field('services_machining_and_fabricating_services_icon');
                                    if ($services_machining_and_fabricating_services_icon) { ?><img src="<?php echo $services_machining_and_fabricating_services_icon['url']; ?>" alt="<?php echo $services_machining_and_fabricating_services_icon['alt']; ?>"><?php } ?></div>
            </div>
            <div class="heading-block left-border">
              <?php if (get_field('services_machining_and_fabricating_services_title')): ?><h2><?php the_field('services_machining_and_fabricating_services_title'); ?></h2><?php endif; ?>
            </div>
            <?php if (get_field('services_machining_and_fabricating_services_description')): the_field('services_machining_and_fabricating_services_description');
            endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="pt-80 pb-50 termsconditions" id="service_termsconditions">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 termsoverlap">
          <div class="bottom25 alignright">
            <?php
            $services_terms_and_conditions_left_image = get_field('services_terms_and_conditions_left_image');
            if ($services_terms_and_conditions_left_image) { ?><img src="<?php echo $services_terms_and_conditions_left_image['url']; ?>" alt="<?php echo $services_terms_and_conditions_left_image['alt']; ?>"><?php } ?>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="servicesList_inner_wrap">
            <div class="tss bottom25">
              <div class="tss-img"><?php
                                    $services_terms_and_conditions_icon = get_field('services_terms_and_conditions_icon');
                                    if ($services_terms_and_conditions_icon) { ?><img src="<?php echo $services_terms_and_conditions_icon['url']; ?>" alt="<?php echo $services_terms_and_conditions_icon['alt']; ?>"><?php } ?></div>
            </div>
            <div class="heading-block left-border">
              <?php if (get_field('services_terms_and_conditions_title')): ?><h2><?php the_field('services_terms_and_conditions_title'); ?></h2><?php endif; ?>
            </div>
            <?php if (get_field('services_terms_and_conditions_description')): the_field('services_terms_and_conditions_description');
            endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
    <?php
    if(!isset($product_section)) { $product_section = ""; }
    ?>
  <section class="<?php echo $product_section; ?> text-center product-lisiting margin_bottom_80 margin_top_40">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <?php
          $enable_testimonial = get_field('enable_testimonial');
          $testimonial_shortcode = get_field('testimonial_shortcode');
          $testimonial_area_title = get_field('testimonial_area_title');

          if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)) {

            echo '<h2 class="margin_top_40">' . esc_html($testimonial_area_title) . '</h2>';
            echo '<div class="testimonial-block">';
            echo do_shortcode($testimonial_shortcode);
            echo '</div>';
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <section id="req-quote" class="quaote_blk">
    <div class="container">
      <div class="heading-block text-center">
        <?php
        echo sprintf(
          esc_html__('%1$s' . '%2$s' . 'Make a Request' . '%3$s' . ' for Service' . '%4$s', 'massload'),
          '<h2>',
          '<span>',
          '</span>',
          '</h2>'
        );
        //_e( '<p>Before sending any product to our factory, contact us to receive a Returned Material Authorisation number to ensure the product is correctly received and processed.</p>', 'massload');
        ?>
        <p><br></p>
      </div>
      <div class="theme_form"> <!-- SharpSpring Form for Service  -->
        <script type="text/javascript">
          var ss_form = {
            'account': 'MzawMLEwMbUwBAA',
            'formID': 'M7MwM7NMSzLXNbG0MNI1MUky1E2yTDLRtTQ0SrQwSjM3MDdJBgA'
          };
          ss_form.width = '100%';
          ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
          ss_form.hidden = {
            '_usePlaceholders': true
          };
          // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
          // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
          // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
        </script>
        <script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>
        <?php //echo do_shortcode('[contact-form-7 id="2807" title="Request a Service"]');
        ?>
      </div>
    </div>
  </section>
</div>

<?php /* Background Images */

$services_custom_gauging_services_background_image = get_field('services_custom_gauging_services_background_image');
if ($services_custom_gauging_services_background_image['url']) {
  $services_custom_gauging_services_background_image = $services_custom_gauging_services_background_image['url'];
} else {
  $services_custom_gauging_services_background_image = get_bloginfo('template_url') . '/assets/img/services/Custom-Gauging-Services-BG.jpg';
}
$services_software_services_background_image = get_field('services_software_services_background_image');
if ($services_software_services_background_image['url']) {
  $services_software_services_background_image = $services_software_services_background_image['url'];
} else {
  $services_software_services_background_image = get_bloginfo('template_url') . '/assets/img/services/Software-Services-Background.jpg';
}
$services_solution_development_services_background_image = get_field('services_solution_development_services_background_image');
if ($services_solution_development_services_background_image['url']) {
  $services_solution_development_services_background_image = $services_solution_development_services_background_image['url'];
} else {
  $services_solution_development_services_background_image = get_bloginfo('template_url') . '/assets/img/services/Solution-Development-Services-Background.jpg';
}
$services_machining_and_fabricating_services_background_image = get_field('services_machining_and_fabricating_services_background_image');
if ($services_machining_and_fabricating_services_background_image['url']) {
  $services_machining_and_fabricating_services_background_image = $services_machining_and_fabricating_services_background_image['url'];
} else {
  $services_machining_and_fabricating_services_background_image = get_bloginfo('template_url') . '/assets/img/services/Machining-and-Fabricating-Services-BG.jpg';
}

$services_terms_and_conditions_left_image2 = get_field('services_terms_and_conditions_left_image2');
if ($services_terms_and_conditions_left_image2['url']) {
  $services_terms_and_conditions_left_image2 = $services_terms_and_conditions_left_image2['url'];
} else {
  $services_terms_and_conditions_left_image2 = get_bloginfo('template_url') . '/assets/img/services/terms-left.png';
}


?>
<style type="text/css">
  .tss.bottom25,
  .tss.bottom25 .tss-img {
    margin-bottom: 25px;
  }

  .col-lg-6.col-md-6.col-sm-12.wwr-right.headingsecondary-block .wwr-right-inner.padding60 {
    padding: 60px;
  }

  .servicesListings::before {
    background: url(<?php echo get_bloginfo('template_url') . '/assets/img/services/Software-Services-Background.jpg'; ?>) !important;
    opacity: 0.1;
    background-repeat: no-repeat;
    background-size: cover !important;
  }

  .servicesListings::after {
    background: url(<?php echo get_bloginfo('template_url') . '/assets/img/services/Solution-Development-Services-Background.jpg'; ?>);
    opacity: 0.1;
    background-repeat: no-repeat;
    background-size: cover !important;
  }

  .servicesListings.cgservices::before {
    background: url('<?php echo $services_custom_gauging_services_background_image; ?>') !important;
    opacity: 0.1;
    background-repeat: no-repeat;
    background-size: cover !important;
  }

  .servicesListings.cgservices::after {
    background: url('<?php echo $services_software_services_background_image; ?>') !important;
    opacity: 0.1;
    background-repeat: no-repeat;
    background-size: cover !important;
  }

  .servicesListings.solutiondevelopment::before {
    background: url('<?php echo $services_solution_development_services_background_image; ?>') !important;
    opacity: 0.1;
    background-repeat: no-repeat;
    background-size: cover !important;
  }

  .servicesListings.solutiondevelopment::after {
    background: url('<?php echo $services_machining_and_fabricating_services_background_image; ?>') !important;
    opacity: 0.1;
    background-repeat: no-repeat;
    background-size: cover !important;
  }

  .bottom25.alignright {
    text-align: right;
  }

  .bottom25.alignright img {
    width: 300px;
  }

  .col-sm-6.termsoverlap {
    position: relative;
  }

  .col-sm-6.termsoverlap::before {
    position: absolute;
    content: '';
    background: url('<?php echo $services_terms_and_conditions_left_image2; ?>');
    background-size: cover;
    background-position: left;
    height: 170%;
    width: 90%;
    display: block;
    left: -67%;
    top: -125px;
    z-index: 1;
    background-repeat: no-repeat;
  }

  .termsconditions h2 {
    font-size: 26px;
  }

  .termsconditions .heading-block {
    margin-bottom: auto;
  }

  body.page-template-services #pagecontent a {
    color: #e30913 !important;
  }

  body.page-template-services #pagecontent .servicesListings p {
    font-weight: 400;
  }

  body.page-template-services #pagecontent .servicesListings h2 {
    font-size: 28px;
  }
</style>
<?php get_footer(); ?>