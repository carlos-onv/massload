<?php
/**
 * The template for displaying the header
 *
 * This is the most generic template file 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

$id = get_queried_object_id();
?>

<!doctype html>

<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MVT2KJB');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- <meta name="key" content="value" /> -->

    <meta name="keywords" content="<?php the_field('meta_keywords', $id) ?>" />

    <link rel="stylesheet" type="text/css" media="print"
        href="<?php bloginfo('template_directory'); ?>/assets/css/print.css">

    <meta name="description" content="<?php the_field('meta_description', $id) ?>" />



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/owl.carousel.min.css">

    <link rel="stylesheet"
        href="<?php bloginfo('template_directory'); ?>/assets/css/style.css?v=<?php echo get_the_time('G:i') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

    <?php wp_head(); ?>

    <style type="text/css">
        li.checkbox>label {
            display: block !important;

        }
    </style>

    <style type="text/css">
        #req-quote .container .heading-block.text-center p:first-child {
            display: none !important;
        }
    </style>

    <!-- <script async src=https://www.googletagmanager.com/gtag/js?id=AW-1049106410></script>

<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}
gtag('js',new Date());gtag('config','AW-1049106410');</script>

<script>function gtag_report_conversion(url){var callback=function(){if(typeof(url)!='undefined'){window.location=url;}};gtag('event','conversion',{'send_to':'AW-1049106410/vZQCCPr1ggIQ6q-g9AM','value':1.0,'currency':'CAD','event_callback':callback});return false;}</script>

<script type="text/javascript">var _ss=_ss||[];_ss.push(['_setDomain','https://koi-3QNNZZKOIE.marketingautomation.services/net']);_ss.push(['_setAccount','KOI-4BWV2DPSPU']);_ss.push(['_trackPageView']);window._pa=window._pa||{};(function(){var ss=document.createElement('script');ss.type='text/javascript';ss.async=true;ss.src=('https:'==document.location.protocol?'https://':'http://')+'koi-3QNNZZKOIE.marketingautomation.services/client/ss.js?ver=2.4.0';var scr=document.getElementsByTagName('script')[0];scr.parentNode.insertBefore(ss,scr);})();</script> -->

    <!-- Google tag (gtag.js) -->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-3146263-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-3146263-1');
</script>-->


    <script>
        document.addEventListener('wpcf7mailsent', function (event) {
            location = 'https://www.massload.com/contact-us-success/';
        }, false);
    </script>
</head>



<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVT2KJB" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="pageheader" class="pageheader">

        <section id="topbar" class="topbar">

            <div class="container-fluid">

                <div class="left-topbar">

                    <ul>

                        <li><a target="_blank" href="<?php mmi_opts_show('linked-in'); ?>">
                                <i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </li>

                        <li><a target="_blank" href="<?php mmi_opts_show('fb-link'); ?>">
                                <i class="fa fa-facebook"></i></a>
                        </li>

                        <li><a target="_blank" href="<?php mmi_opts_show('youtube-link'); ?>">
                                <i class="fa fa-youtube-play"></i></a>
                        </li>

                        <li><span></span></li>

                        <li><i class="fa fa-envelope"></i> <a
                                href="mailto:<?php mmi_opts_show('contact-mail') ?>"><?php mmi_opts_show('contact-mail') ?></a>
                        </li>

                    </ul>

                </div>

                <div class="right-topbar">

                    <ul>

                        <li class="quote"><a class="quote_btn"
                                href="<?php mmi_opts_show('get-quote-link'); ?>"><?php mmi_opts_show('get-quote'); ?></a>
                        </li>

                        <li class="multi-lang">

                            <?php //do_action('wpml_add_language_selector');  ?>
                            <?php echo do_shortcode('[gtranslate]'); ?>

                        </li>

                    </ul>

                </div>

            </div>

        </section>

        <section id="menubar" class="menubar">

            <div class="container-fluid">

                <nav class="navbar navbar-expand-lg navbar-light justify-content-between">

                    <a class="navbar-brand" href="<?php echo get_site_url(); ?>">

                        <img class="white-logo" src="<?php mmi_opts_show('logo'); ?>" alt="logo" />
                        <?php $forty_year_logo_header = get_field('forty_years_logo_header', 82);
                        if ($forty_year_logo_header) { ?>
                            <img class="white-logo forty_year_logo_header" alt="<?php bloginfo('name'); ?>"
                                src="<?php echo $forty_year_logo_header; ?>">
                        <?php } ?>

                        <img class="print-logo" src="<?php mmi_opts_show('print-logo'); ?>"
                            alt="<?php bloginfo('name'); ?>" />

                    </a>

                    <div class="mobile-search"><i class="fa fa-search"></i></div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">

                        <span class="navbar-toggler-icon"></span>

                    </button>

                    <div class="collapse navbar-collapse" id="navbarText">

                        <ul class="navbar-nav ml-auto">

                            <?php

                            wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'items_wrap' => '%3$s',
                                    'container' => false
                                )
                            );

                            ?>

                            <div class="header-search">

                                <i class="fa fa-search"></i>

                            </div>

                        </ul>



                        <div class="side-buttons">

                            <?php if (mmi_opts_get('show-quote-cart-cta', 1)): ?>
                                <div class="callquote quote-cart-cta" style="position: relative;">
                                    <?php 
                                    $quote_count = 0;
                                    if( function_exists('YITH_Request_Quote') ) {
                                        $quote_count = YITH_Request_Quote()->get_raq_item_number();
                                    }
                                    ?>
                                    <span class="quote-cart-count" style="position: absolute; top: -5px; left: -10px; background: #e30913; color: white; border-radius: 50%; padding: 2px 6px; font-size: 11px; font-weight: bold; line-height: 1; z-index: 2; border: 2px solid #fff; min-width: 20px; text-align: center;"><?php echo esc_html($quote_count); ?></span>
                                    <i class="fa fa-shopping-cart" style="position: relative; z-index: 1;"></i> <a class="quote_btn" href="/request-quote/">Quote Cart</a>
                                    

                                </div>
                            <?php endif; ?>



                            <?php if (mmi_opts_get('show-call-cta', 1)): ?>
                                <div class="callquote">
                                    <i class="fa fa-phone"></i> <a class="quote_btn"
                                        href="tel:<?php mmi_opts_show('toll-free-number') ?>"><?php mmi_opts_show('toll-free-text') ?></a>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </nav>

            </div>

        </section>

        <div id="desktop-search" class="desktop-search-form">

            <a href="#" class="icon-close"><i class="fa fa-times" aria-hidden="true"></i></a>

            <div class="search-container">

                <form class="form-inline header-searchform" role="search" action="<?php echo get_site_url(); ?>"
                    method="get">

                    <input type="text" name="s" id="search" value="" class="form-control" placeholder="Search..."
                        required="">

                    <button type="submit" class="btn btn-red my-sm-0">Search</button>

                </form>



            </div>

        </div>

    </div>

    <?php if (is_front_page()) { ?>



        <div id="pagebanner" class="pagebanner">

            <div class="owl-carousel home-banner">

                <?php

                $curr_id = get_the_ID();

                // Check rows exists.
            
                if (have_rows('home_slider')):

                    // Loop through rows.
            
                    while (have_rows('home_slider')):
                        the_row(); ?>

                        <div class="item">

                            <div class="bannerblock">

                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="banner-text">

                                            <?php if (get_sub_field('slider_rtitle')) { ?>

                                                <p class="h1 animate__animated animate__backInDown">
                                                    <?php echo get_sub_field('slider_rtitle'); ?></p>

                                            <?php } ?>

                                            <?php if (get_sub_field('home_slider_rshort_cnt')) { ?>

                                                <p class="animate__animated animate__backInUp">
                                                    <?php echo get_sub_field('home_slider_rshort_cnt'); ?></p>

                                            <?php }

                                            if (have_rows('slider_url')):

                                                while (have_rows('slider_url')):
                                                    the_row();

                                                    $link = get_sub_field('home_rlink');

                                                    if ($link):

                                                        $link_url = $link['url'];

                                                        $link_title = $link['title'];

                                                        $link_target = $link['target'] ? $link['target'] : '_self';

                                                        ?>

                                                        <a class="btn-red theme-btn animate__animated animate__backInUp"
                                                            href="<?php echo esc_url($link_url); ?>"
                                                            target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>

                                                    <?php endif; ?>

                                                <?php endwhile;

                                            endif; ?>

                                        </div>

                                    </div>

                                    <div class="col-md-8">

                                        <div class="banner-image"
                                            style="background-image:url(<?php the_sub_field('slider_rimage'); ?>);">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endwhile;

                    wp_reset_postdata();

                endif; ?>

            </div>

        </div>

    <?php } ?>