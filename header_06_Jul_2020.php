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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="key" content="value" /> -->

	<meta name="keywords" content="<?php the_field('meta_keywords', $id) ?>" />

	<meta name="description" content="<?php the_field('meta_description', $id) ?>" />

    <title>Mass Load</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/style.css">
    <?php wp_head();  ?>
</head>

<body <?php body_class(); ?> >
    <div id="pageheader" class="pageheader">
        <section id="topbar" class="topbar">
            <div class="container-fluid">
                <div class="left-topbar">
                    <ul>
                        <li><a target="_blank" href="<?php mmi_opts_show('fb-link')?>"><i class="fa fa-facebook"></i></li>
                        <li><a target="_blank" href="<?php mmi_opts_show('youtube-link')?>"><i class="fa fa-youtube-play"></i></li>
                        <li><a target="_blank" href="<?php mmi_opts_show('twitter-link')?>"><i class="fa fa-twitter" aria-hidden="true"></i></li>
                        <li><span></span></li>
                        <li><i class="fa fa-envelope"></i> <a href="mailto:<?php mmi_opts_show('contact-mail')?>"><?php mmi_opts_show('contact-mail')?></a></li>
                    </ul>
                </div>
                <div class="right-topbar">
                    <ul>
                        <!-- <li><i class="fa fa-phone"></i> <a href="tel:<?php //mmi_opts_show('toll-free-number')?>"> <?php //mmi_opts_show('toll-free-text')?></a></li>
                        <li><i class="fa fa-phone"></i> <a href="tel:<?php//mmi_opts_show('international-number')?>"><?php// mmi_opts_show('international-text')?></a></li>
                        <li><i class="fa fa-fax"></i> <a href="tel:<?php //mmi_opts_show('fax-number')?>"><?php //mmi_opts_show('fax-text')?></a></li>
                        <li><i class="fa fa-envelope"></i> <a href="mailto:<?php //mmi_opts_show('contact-mail')?>"><?php //mmi_opts_show('contact-mail')?></a></li> -->

                        <li class="quote"><a class="quote_btn" href="<?php mmi_opts_show('get-quote-link'); ?>"><?php mmi_opts_show('get-quote'); ?></a></li>
                        <li><a href="#"><img src="<?php mmi_opts_show('en_logo')?>" alt="location"></a></li>
                    </ul>
                    <!-- <div class="quote">
                        <a class="quote_btn" href="<?php //mmi_opts_show('get-quote-link'); ?>"><?php //mmi_opts_show('get-quote'); ?></a>
                    </div> -->
                </div>
            </div>
        </section>
        <section id="menubar" class="menubar">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
                    <a class="navbar-brand" href="<?php echo get_site_url(); ?>">
                        <img src="<?php mmi_opts_show('logo'); ?>" alt="logo" />
                    </a>
                    <div class="mobile-search"><i class="fa fa-search"></i></div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mx-auto">
                            <?php 
                                wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'items_wrap'=>'%3$s', 
                                'container' => false
                                ) ); 
                            ?>
                            <div class="header-search">
                                <i class="fa fa-search"></i>
                            </div>
                        </ul>

                        <div class="side-buttons">
                            
                            <div class="callquote">
                            <i class="fa fa-phone"></i> <a class="quote_btn" href="tel:<?php mmi_opts_show('toll-free-number')?>"><?php mmi_opts_show('toll-free-text')?></a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
        <div id="desktop-search" class="desktop-search-form">
            <a href="#" class="icon-close"><i class="fa fa-times" aria-hidden="true"></i></a>
            <div class="search-container">
                <form class="form-inline header-searchform" role="search" action="<?php echo get_site_url(); ?>" method="get">
                    <input type="text" name="s" id="search" value="" class="form-control" placeholder="Search..." required="">                    
                    <button type="submit" class="btn btn-red my-sm-0">Search</button>
                </form>
                
            </div>
        </div>
    </div>
    <?php if ( is_front_page()){ ?>

    <div id="pagebanner" class="pagebanner">
        <div class="owl-carousel home-banner">
            <?php
            $args = array( 'posts_per_page' => 4, 'order' => 'ASC', 'post_type' => 'products' );

            $myposts = get_posts( $args );

            foreach ( $myposts as $post ) : setup_postdata( $post ); 

            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
            ?>

            <div class="item">
                <div class="bannerblock">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="banner-text">
                                <!-- <img src="<?php echo $featured_img_url; ?>" /> -->
                                <!-- <img src="<?php the_field('product_thumb'); ?>" /> -->
                                <h1><?php the_title(); ?></h1>
                                <p><?php echo get_field('short_content'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn-red theme-btn">Process Controls & Amplifiers</a>
                                <a href="<?php the_permalink(); ?>" class="btn-red theme-btn">Indicators, Remote Display & Printers</a>
                                <a href="<?php the_permalink(); ?>" class="btn-red theme-btn">Wireless</a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="banner-image" style="background-image:url(<?php the_field('banner_image'); ?>); background-size: cover; height:100%; width:100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; 
            wp_reset_postdata();         
            ?>
            
        </div>
        <!-- <div class="callblock">
            <a href="tel:<?php mmi_opts_show('call-number'); ?>"><img src="<?php mmi_opts_show('call_logo'); ?>" alt="call"/><?php mmi_opts_show('call-us'); ?></a>
        </div> -->
    </div>
    <?php } ?>