<?php
/**
 * The template for displaying the footer
 *
 * This is the most generic template file 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */
?>

    <div id="pagefooter" class="pagefooter">

        <div class="container footer-widget-area">
            <div class="row">
                <div class="col-md-4">
                    <div class="ft-menu">
					<?php
						ob_start();
						mmi_opts_show('foot-logo');
						$foot_logo_url = ob_get_contents();
						ob_end_clean();
						$foot_logo_id = attachment_url_to_postid($foot_logo_url);
						$foot_logo_alt = get_post_meta($foot_logo_id, '_wp_attachment_image_alt', TRUE);
					?>
                    <a href="<?php echo get_site_url(); ?>"><img src="<?php mmi_opts_show('foot-logo'); ?>" alt="<?php echo $foot_logo_alt; ?>">
                        <?php $forty_year_logo_header = get_field('forty_years_logo_header',82);
                        if($forty_year_logo_header){ 
							$forty_year_logo_id = attachment_url_to_postid($forty_year_logo_header);
							$forty_year_logo_alt = get_post_meta($forty_year_logo_id, '_wp_attachment_image_alt', TRUE);
						?>
                            <img class="white-logo forty_year_logo_header footer_year_logo" src="<?php echo $forty_year_logo_header; ?>" alt="<?php echo $forty_year_logo_alt; ?>" width="60" height="60">
                        <?php } ?>
                    </a>

                    <p><?php mmi_opts_show('footer-desc'); ?></p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="ft-menu">
                    <h4><?php mmi_opts_show('footer-title1'); ?></h4>
                    <ul>
                        <?php 
                        wp_nav_menu( array(
                        'theme_location' => 'footer1',
                        'items_wrap'=>'%3$s', 
                        'container' => false
                        ) ); 
                    ?>
                    </ul>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="ft-menu">
                    <!-- <h4><?php //mmi_opts_show('footer-title2'); ?></h4> -->
                    <?php //echo do_shortcode('[mc4wp_form id="191"]') ?>
                    <h4><?php mmi_opts_show('footer-title3'); ?></h4>
                    <ul class="social-links">
                        <li><a target="_blank" href="<?php mmi_opts_show('linked-in')?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="<?php mmi_opts_show('fb-link')?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="<?php mmi_opts_show('youtube-link')?>"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                    </ul>
                    </div>
                </div>

                <div class="col-md-3 ftlogcnt">
                    <div class="ft-menu ftlogos">
                    <?php if(mmi_opts_show('footer-title4')){?>
                        <h4><?php mmi_opts_show('footer-title4'); ?></h4>
                    <?php } ?>
					<?php
						ob_start();
						mmi_opts_show('certification-logo');
						$certification_logo_url = ob_get_contents();
						ob_end_clean();
						$certification_logo_id = attachment_url_to_postid($certification_logo_url);
						$certification_logo_alt = get_post_meta($certification_logo_id, '_wp_attachment_image_alt', TRUE);
					?>
                    <img class="certilogo" src="<?php mmi_opts_show('certification-logo'); ?>" alt="<?php echo $certification_logo_alt; ?>" width="150" height="150">
                    <?php $forty_year_logo = get_field('forty_year_logo_footer', 82);
                    if($forty_year_logo){ $forty_year_logo_id1 = attachment_url_to_postid($forty_year_logo);
							$forty_year_logo_alt1 = get_post_meta($forty_year_logo_id1, '_wp_attachment_image_alt', TRUE);?><img class="certilogo forty_year_logo" src="<?php echo $forty_year_logo; ?>" alt="<?php echo $forty_year_logo_alt1; ?>" width="135" height="155"><?php } ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <?php mmi_opts_show('copyrights'); ?>
                    </div>

                    <div class="col-md-4">
                        <ul class="footernav ml-auto">
                            <?php 
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'footer2',
                                        'items_wrap'     => '%3$s', 
                                        'container'      => false
                                    )
                                ); 
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
    
<script src="//code.tidio.co/mggovizu7tn4xv17pr5jenzehrof2bgv.js"></script>
<?php if(is_page(82) || is_page(1054)){ ?>
<script type="text/javascript">

jQuery(document).ready(function(){
 //Product dropdown open in home page
  jQuery('div.productActions').each(function() {
    var $dropdown = jQuery(this);

    jQuery("a.theme-btn", $dropdown).click(function(e) {
      e.preventDefault();
      $div = jQuery("ul.product-children-list", $dropdown);
      $div.toggle();
      jQuery("ul.product-children-list").not($div).hide();
      return false;
    });

});
  jQuery('html').click(function(){
    jQuery("ul.product-children-list").hide();
  });
     
});


</script>
<?php } ?>
<script type="text/javascript">
    var __ss_noform = __ss_noform || [];
    __ss_noform.push(['baseURI', 'https://app-3QNNZZKOIE.marketingautomation.services/webforms/receivePostback/MzawMLEwMbUwBAA/']);
    __ss_noform.push(['endpoint', '2f9be45f-741c-4521-bcb4-12a60b1ee302']);
</script>
<script type="text/javascript" src=https://koi-3QNNZZKOIE.marketingautomation.services/client/noform.js?ver=1.24 ></script>

<script type="text/javascript" language="javascript">__pid=33259;</script>
<script type="text/javascript" language="javascript" src="//live.activeconversion.com/ac.js"></script>

</body>

</html>

<?php wp_footer(); ?>

