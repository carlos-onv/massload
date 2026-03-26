<?php

/**
 * Template Name: Child Product
 * Template Post Type: products
 * 
 * Use for Child Product Page
 */

get_header(); ?>


<!--<link rel='stylesheet' href='https://kenwheeler.github.io/slick/slick/slick.css'>
<link rel='stylesheet' href='https://kenwheeler.github.io/slick/slick/slick-theme.css'>-->
<style>
    /* Slider */
    .slick-slider {
        position: relative;
        display: block;
        box-sizing: border-box;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
        -khtml-user-select: none;
        -ms-touch-action: pan-y;
        touch-action: pan-y;
        -webkit-tap-highlight-color: transparent;
    }

    .slick-list {
        position: relative;
        display: block;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .slick-list:focus {
        outline: none;
    }

    .slick-list.dragging {
        cursor: pointer;
        cursor: hand;
    }

    .slick-slider .slick-track,
    .slick-slider .slick-list {
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        -o-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }

    .slick-track {
        position: relative;
        top: 0;
        left: 0;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .slick-track:before,
    .slick-track:after {
        display: table;
        content: '';
    }

    .slick-track:after {
        clear: both;
    }

    .slick-loading .slick-track {
        visibility: hidden;
    }

    .slick-slide {
        display: none;
        float: left;
        height: 100%;
        min-height: 1px;
    }

    .slick-slide img {
        display: block;
    }

    .slick-slide.slick-loading img {
        display: none;
    }

    .slick-slide.dragging img {
        pointer-events: none;
    }

    .slick-initialized .slick-slide {
        display: block;
    }

    .slick-loading .slick-slide {
        visibility: hidden;
    }

    .slick-vertical .slick-slide {
        display: block;
        height: auto;
        border: 1px solid transparent;
    }

    .slick-arrow.slick-hidden {
        display: none;
    }

    /* Arrows */
    .slick-prev,
    .slick-next {
        font-size: 0;
        line-height: 0;
        position: absolute;
        padding: 0;
        transform: translate(0, -50%);
        cursor: pointer;
        color: transparent;
        border: none;
        outline: none;
        background: transparent;
    }

    .slick-prev:hover,
    .slick-prev:focus,
    .slick-next:hover,
    .slick-next:focus {
        color: transparent;
        outline: none;
        background: transparent;
    }

    .slick-prev:hover:before,
    .slick-prev:focus:before,
    .slick-next:hover:before,
    .slick-next:focus:before {
        opacity: 1;
    }

    .slick-prev.slick-disabled:before,
    .slick-next.slick-disabled:before {
        opacity: .25;
    }

    .slick-prev:before,
    .slick-next:before {
        font-family: 'slick';
        font-size: 20px;
        line-height: 1;
        opacity: .75;
        color: white;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .slick-prev {
        left: -25px;
    }

    .slick-next {
        right: -25px;
    }

    * {
        margin: 0;
        padding: 0;
    }

    .thumbnail-slider {
        width: 100%;
        margin: 0;
    }

    .slider.common-content img {
        width: 100%;
        max-width: 100%;
    }

    .slider .slick-prev,
    .slider .slick-next {
        width: 28px;
        height: 28px;
        border-style: solid;
        margin: 10px;
        display: inline-block;
        margin: auto;
        top: 0;
        bottom: 0;
        z-index: 10;
        cursor: pointer;
    }

    .slider .slick-arrow {
        border-color: transparent #e30913;
    }

    .slider .slick-prev {
        border-width: 14px 14px 14px 0px;
        left: 0px;
        right: auto;
    }

    .slider .slick-next {
        border-width: 14px 0px 14px 14px;
        right: 0px;
        left: auto;
    }

    .slider .slick-prev:hover,
    .slider .slick-next:hover {
        border-color: transparent #000;
    }

    .slider .slick-prev.slick-disabled,
    .slider .slick-next.slick-disabled,
    .slider .slick-prev.slick-disabled:hover,
    .slider .slick-next.slick-disabled:hover {
        opacity: 0.1;
        cursor: default;
    }

    .slider.common-content .slick-slide {
        height: 340px;
        text-align: center;
        font-size: 75px;
        color: #ffffff;
    }

    .slider.common-thumb {
        margin-top: 5px;
    }

    .common-thumb .slick-slide {
        height: 80px;
        line-height: 50px;
        font-size: 25px;
        width: auto !important;
        cursor: pointer;
        margin-right: 5px;
    }

    .common-thumb .slick-slide:last-of-type {
        margin-right: 0;
    }

    .common-thumb img {
        width: 100px;
        height: 80px;
        object-fit: cover;
    }

    .common-thumb .slick-slide.slick-current {
        border: 0;
    }

    .common-thumb .slick-slide:focus {
        outline: none;
    }
</style>

<?php
$specification        = get_field('specification');
$specifications        = get_field('specifications');
$options               = get_field('options');
$document_content      = get_field('document_content');

$product_details_title = get_field('product_details_title');
$product_details       = get_field('product_details');

$images_list           = get_field('images_list');

$count_left = core_get_related_tags_posts(
    array(
        'post_type'    => 'applications',
        'return_count' => true
    )
);

$count_right = core_get_related_tags_posts(
    array(
        'post_type'    => 'case_study',
        'return_count' => true
    )
);
?>

<div id="pagebanner" class="pagebanner">
    <?php if (get_field('banner_image') == true) { ?>
        <div class="inner-banner" style="background-image: url(<?php the_field('banner_image'); ?>);">
        <?php } else { ?>
            <div class="inner-banner" style="background-image: url(https://via.placeholder.com/1920x345.png);">
            <?php } ?>

            <div class="container">

                <?php
                $root         = get_page_by_path('products');
                $root_id      = '';
                $root_link    = '';
                $root_title   = '';

                $post_parent  = $post->post_parent;
                $parent_title = '';
                $parent_link  = '';

                if ($post_parent) {
                    $parent_title = get_the_title($post_parent);
                    $parent_link  = get_the_permalink($post_parent);
                }

                if (! empty($root)) {
                    $root_id    = core_icl_object_id($root->ID);
                    $root_link  = get_the_permalink($root_id);
                    $root_title = get_the_title($root_id);

                    $breadcrumb = array(
                        'archive'     => array(
                            'title'   => $root_title,
                            'link'    => $root_link
                        ),
                    );

                    echo '<h3>';
                    echo '<a href="' . esc_url($root_link) . '" class="quote_btn">';
                    echo esc_html($root_title);
                    echo '</a>';

                    echo esc_html(' | ');

                    echo '<a href="' . esc_url($parent_link) . '" class="quote_btn parent">';
                    echo esc_html($parent_title);
                    echo '</a>';
                    echo '</h3>';
                }

                echo '<h1>';
                the_title();
                echo '</h1>';

                if (! empty($root)) {
                    core_breadcrumbs($breadcrumb);
                }
                ?>
            </div>
            </div>

            <!-- <div class="callblock">
        <a href="tel:<?php //mmi_opts_show('call-number'); 
                        ?>"><img src="<?php //mmi_opts_show('call_logo'); 
                                        ?>" alt="call"/><?php //mmi_opts_show('call-us'); 
                                                        ?></a>
    </div> -->
        </div>

        <div id="pagecontent" class="pagecontent">

            <div class="product-intro pt-100">
                <div class="container product-intro-wrap">
                    <div class="row product-intro-inner">
                        <!-- div class="<?php //if( get_field('right_side_image') ) { echo 'col-md-4 productImage-right'; } else { echo'col-sm-12 text-center'; } 
                                        ?>" --->

                        <div class="col-md-4 product-filter productImage-right">
                            <div class="productMenu-sidebar hide-mobile">
                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <form class="form-inline header-searchform" role="search" action="<?php echo get_site_url(); ?>" method="get">
                                        <input class="form-control my-0 py-1" type="text" name="s" id="search" value="" placeholder="Search" aria-label="Search">
                                        <button type="submit" class="btn btn-red my-sm-0"><span class="input-group-text" id="basic-text1"><i class="fa fa-search"
                                                    aria-hidden="true"></i></span></button>
                                        <input type="hidden" name="post_type" value="products">
                                    </form>
                                </div>
                                <?php bellows('main', array('theme_location' => 'products')); ?>
                            </div>
                        </div>

                        <?php //if( get_field('right_side_image') ):
                        $content     = apply_filters('the_content', get_the_content());
                        $this_url    = get_permalink(get_the_ID());

                        if (! empty($count_left) || ! empty($content) || ! empty($specification) || ! empty($count_right) || ! empty($product_details) || ! empty($images_list)) {  ?>

                            <div class="col-md-8 product-description">

                                <div class="heading-block">
                                    <?php
                                    if (get_field('product_title_h2')) {
                                    ?> <h2 class="product-title"><?php the_field('product_title_h2'); ?></h2> <?php
                                                                                                            } else {
                                                                                                                ?> <h2 class="product-title"><?php the_title(); ?></h2> <?php
                                                                                                                                                                    }
                                                                                                                                                                        ?>
                                    <?php if (! empty($count_left) || ! empty($specifications) || ! empty($count_right)  || ! empty($images_list)) { ?>
                                        <ul class="other_prod_links">
                                            <?php if (! empty($images_list)) { ?>
                                                <li><a href="<?php echo $this_url; ?>#media-gallery" class="cta-button"><?php esc_html_e('Media Gallery', 'massload'); ?></a></li>
                                            <?php } ?>

                                            <?php if (! empty($specifications)) { ?>
                                                <li><a href="<?php echo $this_url; ?>#specifications-section" class="core-target-tab cta-button" data-target-tab="#tab-1"><?php esc_html_e('Specifications', 'massload'); ?></a></li>
                                            <?php } elseif (! empty($options)) { ?>
                                                <li><a href="<?php echo $this_url; ?>#specifications-section" class="core-target-tab cta-button" data-target-tab="#tab-2"><?php esc_html_e('Specifications', 'massload'); ?></a></li>
                                            <?php  } ?>

                                            <?php if (! empty($count_left)) { ?>
                                                <li><a href="<?php echo $this_url; ?>#application-casestudies" class="cta-button"><?php esc_html_e('Applications', 'massload'); ?></a></li>
                                            <?php } ?>
                                            <?php if (! empty($count_right)) { ?>
                                                <li><a href="<?php echo $this_url; ?>#application-casestudies" class="cta-button"><?php esc_html_e('Case Studies', 'massload'); ?></a></li>
                                            <?php } ?>
                                            <li><a href="<?php echo $this_url; ?>#req-quote" class="cta-button-rfq"><?php esc_html_e('Request a quote', 'massload'); ?></a></li>
                                        </ul>
                                    <?php }
                                    $content = apply_filters('the_content', get_the_content());
                                    echo $content;

                                    $highlights_content           = get_field('highlights_content');
                                    $product_print_image = get_field('hi_left_image');
                                    if (! empty($highlights_content) || ! empty($product_print_image)) { ?>
                                        <div class="wwr-right red-title headingsecondary-block">
                                            <div class="wwr-right-inner1">
                                                <div class="product-highlights">
                                                    <h2><?php esc_html_e('Highlights', 'massload'); ?></h2>
                                                    <?php the_field('highlights_content'); ?>
                                                </div>
                                                <div class="product-print-image">
                                                    <?php
                                                    echo '<img src="' . esc_url($product_print_image) . '" class="print-image">';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php if (! empty($product_details)) { ?>
                                <div class="product-details">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 product-details-collection">

                                                <?php
                                                $details_output = '';
                                                $format_output  = '';

                                                ob_start();


                                                if (! empty($product_details_title)) {
                                                    $details_output .= '<div class="row product-details-title-wrap">';
                                                    $details_output .= '<div class="col-md-12 inner-wrap">';
                                                    $details_output .= '<h2 class="product-details-title">' . esc_html($product_details_title) . '</h2>';
                                                    $details_output .= '</div>';
                                                    $details_output .= '</div>';
                                                }

                                                foreach ($product_details as $product_detail) {
                                                    $details               = core_isset_array($product_detail, 'details', array());
                                                    if(is_array($details))
                                                    {
                                                    $total_details = count($details);
                                                    }
                                                    else
                                                    {
                                                        $total_details = 0;
                                                    }
                                                    $details_count         = 1;

                                                    $details_output .= '<div class="row row-details">';

                                                    if($total_details>0)
                                                    {
                                                        foreach ($details as $detail) {
                                                            $column_class  = 'details-column';
                                                            $content_type  = core_isset_array($detail, 'content_type', 'Content');
                                                            $content_title = core_isset_array($detail, 'title', '');
                                                            $content_text  = core_isset_array($detail, 'content', '');
                                                            $content_img   = core_isset_array($detail, 'image', '');
    
                                                            if (1 === $total_details) {
                                                                $column_class .= ' col-md-12';
                                                            }
                                                            if (2 === $total_details) {
                                                                $column_class .= ' col-md-6';
                                                            }
                                                            if (3 === $total_details) {
                                                                $column_class .= ' col-md-4';
                                                            }
    
                                                            if ('Content' === $content_type) {
                                                                $content_img = '';
                                                                $column_class .= ' content-column';
    
                                                                if (empty($content_title)) {
                                                                    $column_class .= ' no-title';
                                                                }
                                                            }
                                                            if ('Image' === $content_type) {
                                                                $content_title = '';
                                                                $content_text  = '';
                                                                $column_class .= ' image-column';
                                                            }
    
                                                            $details_output .= '<div class="' . esc_attr($column_class) . '">';
    
                                                            switch ($content_type) {
    
                                                                case 'Content':
                                                                    if (! empty($content_title)) {
                                                                        $details_output .= '<h4 class="detail-title">' . esc_html($content_title) . '</h4>';
                                                                    }
                                                                    if (! empty($content_text)) {
                                                                        $details_output .= wp_kses_post($content_text);
                                                                    }
                                                                    break;
    
                                                                case 'Image':
                                                                    if (! empty($content_img)) {
                                                                        $details_output .= '<img alt="'.esc_attr( $product_details_title ).'" src="' . esc_url($content_img) . '" />';
                                                                    }
                                                                    break;
                                                            }
    
                                                            $details_output .= '</div>';
                                                        }
                                                    }

                                                    $details_output .= '</div>';
                                                }

                                                $details_output .= ob_get_clean();

                                                echo $details_output;
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        <?php } //endif; 
                        ?>

                    </div>
                </div>
            </div>

            <?php if (! empty($images_list)) { ?>
                <section id="media-gallery" class="images-videos pt100">
                    <div class=container>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="headingsecondary-block">
                                    <h2><?php esc_html_e('Images', 'massload'); ?></h2>
                                </div>
                                <?php if (get_field('images_list')): ?>
                                    <section class="casestudies-section">
                                        <div class="thumbnail-slider">
                                            <div class="slider common-content slider-content">
                                                <?php if (have_rows('images_list')):
                                                    while (have_rows('images_list')) : the_row(); ?>
                                                        <?php $image = get_sub_field('images'); if(is_array($image)) { ?>
                                                        <div><a href="<?php echo $image['url']; ?>" rel="lightbox"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></a></div>
                                                <?php } endwhile;
                                                endif; ?>
                                            </div>
                                            <div class="slider common-thumb slider-thumb">
                                                <?php if (have_rows('images_list')):
                                                    while (have_rows('images_list')) : the_row(); ?>
                                                        <?php $image = get_sub_field('images'); if(is_array($image)) { ?>
                                                        <div><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></div>
                                                <?php } endwhile;
                                                endif; ?>
                                            </div>
                                        </div>
                                    </section>
                                <?php endif; ?>
                            </div>

                            <?php if (get_field('video_list')): ?>
                                <div class="col-md-6">
                                    <div class="headingsecondary-block">
                                        <h2><?php esc_html_e('Videos', 'massload'); ?></h2>
                                    </div>

                                    <?php
                                    $i = 1;

                                    ?>

                                    <div class="thumbnail-slider">
                                        <div class="slider common-content video-content">
                                            <?php
                                            if (have_rows('video_list')):
                                                while (have_rows('video_list')) : the_row();
                                            ?>
                                                    <div>
                                                        <div class="video_blk dark_blk pt-50 pb-50 text-center" style="background-image: url(<?php the_sub_field('video_banner_image'); ?>);">
                                                            <h2><?php the_sub_field('video_banner_title'); ?></h2>
                                                            <a href="#" data-toggle="modal" class="videoIcon" data-target="#videoModal<?php echo $i; ?>"><img src="<?php the_field('play_icon'); ?>"></a>
                                                        </div>
                                                    </div>
                                            <?php $i = $i + 1;
                                                endwhile;
                                            endif; ?>
                                        </div>

                                        <?php
                                        $j = 1;
                                        if (have_rows('video_list')):
                                            while (have_rows('video_list')) : the_row();
                                        ?>
                                                <div class="modal fade" id="videoModal<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <div class="modal-body">
                                                                <iframe width="100%" height="430" src="<?php the_sub_field('video_link'); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                                $j = $j + 1;
                                            endwhile;
                                        endif;
                                        ?>


                                        <div class="slider common-thumb video-thumb">
                                            <?php
                                            if (have_rows('video_list')):
                                                while (have_rows('video_list')) : the_row();
                                            ?>
                                                    <div><img src="<?php the_field('video_banner_image'); ?>"></div>
                                            <?php
                                                endwhile;
                                            endif;
                                            ?>
                                        </div>
                                    </div>



                                </div>
                            <?php
                            endif;
                            ?>

                        </div>
                    </div>
                </section>
            <?php } ?>


            <?php
            if (
                (get_field('specification')) ||
                (get_field('options'))       ||
                (get_field('document_content'))
            ):
            ?>
                <section id="specifications-section" class="additional-info <?php if (get_field('video_banner_image')): ?> pt-100  <?php endif; ?> ">
                    <div class="container">
                        <div class="dark_blk">
                            <?php
                            echo sprintf(
                                esc_html__('%1$s' . '%2$s' . 'PRODUCT' . '%3$s' . ' SPECIFICATIONS' . '%4$s', 'massload'),
                                '<h2>',
                                '<span>',
                                '</span>',
                                '</h2>'
                            );
                            ?>
                        </div>
                        <div id="additional-info-tab" class="tabPlugin">
                            <ul>
                                <?php
                                $spec_title = '';
                                $spec_desc  = '';


                                if ($specifications):
                                    echo '<li>';
                                    echo '<a href="#tab-1">';
                                    echo esc_html__(' Specifications ', 'massload');
                                    echo '</a>';
                                    echo '</li>';
                                endif;

                                if ($document_content):
                                    echo '<li>';
                                    echo '<a href="#tab-3">';
                                    echo esc_html__(' Documents ', 'massload');
                                    echo '</a>';
                                    echo '</li>';
                                endif;

                                if ($options):
                                    echo '<li>';
                                    echo '<a href="#tab-2">';
                                    echo esc_html__(' Related Products ', 'massload');
                                    echo '</a>';
                                    echo '</li>';
                                endif;

                                ?>
                            </ul>

                            <?php
                            if ($specifications) {
                                echo '<div id="tab-1">';

                                echo '<table class="specifications-table" border="1" width="100%" cellspacing="1" cellpadding="10" align="center">';
                                echo '<tbody>';
                                foreach ($specifications as $key => $specification) {
                                    $spec_title = core_isset_array($specification, 'title', '');
                                    $spec_desc  = core_isset_array($specification, 'description', '');

                                    if (! empty($spec_title) || ! empty($spec_desc)) {
                                        echo '<tr>';
                                        echo '<th align="center">';
                                        echo esc_html($spec_title);
                                        echo '</th>';
                                        echo '<td>';
                                        echo wp_kses_post($spec_desc);
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                                echo '</tbody>';
                                echo '</table>';

                                echo '</div>';
                            }
                            ?>

                            <?php if ($options): ?>
                                <div id="tab-2">

                                    <?php if (have_rows('options')): ?>
                                        <?php while (have_rows('options')) : the_row(); ?>

                                            <div class="optionsBlk">
                                                <div class="row">
                                                    <?php if (get_sub_field('option_image')): ?>
                                                        <div class="col-sm-3">
                                                            <img  alt="<?php the_title();?>" src="<?php the_sub_field('option_image'); ?>" class="img-fluid">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="<?php if (get_sub_field('option_image')) {
                                                                    echo 'col-sm-9';
                                                                } else {
                                                                    echo 'col-sm-12';
                                                                } ?>">
                                                        <?php the_sub_field('option_content'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($document_content): ?>

                                <div id="tab-3">

                                    <?php the_field('document_content'); ?>

                                    <ul>
                                        <?php if (have_rows('document_list')): ?>
                                            <?php while (have_rows('document_list')) : the_row(); ?>
                                                <li>
                                                    <i class="fa fa-download" aria-hidden="true"></i>

                                                    <?php if (get_sub_field('document_label')) { ?>
                                                        <?php the_sub_field('document_label'); ?>
                                                    <?php } else { ?>
                                                        <?php esc_html_e(' Brochure: ', 'massload'); ?>
                                                    <?php } ?>

                                                    <?php
                                                    $link1 = get_sub_field('link');

                                                    if ($link1):
                                                        $link_url    = $link1['url'];
                                                        $link_title  = $link1['title'];
                                                        $link_target = $link1['target'] ? $link1['target'] : '_self';
                                                    ?>
                                                        <a class="button" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                                                            <?php echo esc_html($link_title); ?>
                                                        </a>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </li>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php
            endif;
            ?>

            <section class="container product-section1 text-center product-lisiting margin_top_40 margin_bottom_40">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <!-- Testimonials -->
                        <?php
                        $enable_testimonial = get_field('enable_testimonial');
                        $testimonial_shortcode = get_field('testimonial_shortcode');
                        $testimonial_area_title = get_field('testimonial_area_title');

                        if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)) {

                            echo '<div class="heading-block"><h2>' . esc_html($testimonial_area_title) . '</h2></div>';
                            echo '<div class="testimonial-block">';
                            echo do_shortcode($testimonial_shortcode);
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </section>
            
            
            <?php
            if($_SERVER['REMOTE_ADDR'] == "99.234.36.164" && 1==2)
            {
            ?>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
<style>
.es-header-component-top {
    display:none;
}
.slick-prev::before, .slick-next::before {
  color: #000;
}
.slick-slide .es-text-shortener {
    height: 81px !important;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 4;
  line-height: 20px;
}
</style>

            <section class="container product-section1 text-center product-lisiting margin_top_40 margin_bottom_40">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <!-- Testimonials -->
                        <?php
                        $enable_testimonial = get_field('enable_testimonial');
                        $testimonial_shortcode = get_field('testimonial_shortcode');
                        $testimonial_area_title = get_field('testimonial_area_title');

                        if ($enable_testimonial == "Yes" && !empty($testimonial_shortcode)) {

                            echo '<div class="heading-block"><h2>' . esc_html($testimonial_area_title) . '</h2></div>';
                            echo '<div class="testimonial-block-slider">';
                            echo '<div class="elfsight-app-9d3f4d84-9767-4ffe-9516-bfe35333b1dd" ></div><script src="https://static.elfsight.com/platform/platform.js" data-use-service-core></script>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </section>
            <script>
            jQuery( document ).ready(function() {
                setTimeout(
                  function() 
                  {
                    jQuery(".es-list-layout > div").each(function(){
                        jQuery(this).addClass("item");
                    });
                    
                    jQuery('.es-list-layout').slick({
                      infinite: false,
                      slidesToShow: 3,
                      slidesToScroll: 1
                    });


                    jQuery(".es-load-more-button").on("click", function(e) {
                        setTimeout(
                          function() 
                          {
                            jQuery('.es-list-layout').slick('refresh');
                          }, 1000);
                    });

                  }, 500);


//$('#slick-slider').slick('refresh');


                /*
                jQuery('.es-list-layout').owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:3
                        },
                        1000:{
                            items:5
                        }
                    }
                });
                */
            });
            </script>

            <?php
            }
            ?>
            
            
            

            <?php if (have_rows('faq_content_fields')) { ?>
                <section id="faqs-section" class="additional-info margin_bottom_76">
                    <div class="container">
                        <div class="faq">
                            <?php the_field('faq_content'); ?>
                            <?php while (have_rows('faq_content_fields')) : the_row(); ?>
                                <details>
                                    <summary>
                                        <h4><?php the_sub_field('question'); ?></h4>
                                    </summary>
                                    <div><?php the_sub_field('answer'); ?></div>
                                </details>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </section>
            <?php } ?>

            <?php if (! get_field('other_pro_title')): ?>
                <section class="other-products">
                    <div class="container">
                        <div class="heading-block">
                            <h2><span><?php the_field('other_pro_title'); ?></h2>
                        </div>

                        <?php
                        $posts = get_field('other_sub_products');

                        if ($posts):
                        ?>
                            <ul>
                                <?php foreach ($posts as $post): // variable must be called $post (IMPORTANT) 
                                ?>
                                    <?php setup_postdata($post); ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly 
                            ?>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (1 == 0 && (!empty($count_left) || !empty($count_right))) { ?>
                <section id="application-casestudies" class="productapp-section pt100" style="background-image: url(<?php the_field('app_products_backround'); ?>)">
                    <div class="container">
                        <div class="row">
                            <div id="applications-section" class="col-md-6 text-center">
                                <div class="heading-block">
                                    <h2><?php esc_html_e('Applications', 'massload'); ?></h2>
                                </div>
                                <?php
                                echo core_get_related_tags_posts(
                                    array(
                                        'post_type' => 'applications'
                                    )
                                );
                                ?>
                            </div>

                            <div id="casestudies-section" class="col-md-6 text-center">
                                <div class="casestudies">
                                    <div class="heading-block">

                                        <?php
                                        echo sprintf(
                                            esc_html__('%1$s' . 'Case ' . '%2$s' . 'Studies' . '%3$s' . '%4$s', 'massload'),
                                            '<h2>',
                                            '<span>',
                                            '</span>',
                                            '</h2>'
                                        );
                                        ?>

                                    </div>

                                    <?php
                                    echo core_get_related_tags_posts(
                                        array(
                                            'post_type' => 'case_study'
                                        )
                                    );
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            <?php } ?>

            <section id="req-quote" class="quaote_blk">
                <div class="container">
                    <div class="heading-block text-center">
                        <?php
                        echo sprintf(
                            esc_html__('%1$s' . '%2$s' . 'Request A' . '%3$s' . ' Quote' . '%4$s', 'massload'),
                            '<h2>',
                            '<span>',
                            '</span>',
                            '</h2>'
                        );

                        /*echo sprintf( 
                        esc_html__( '%1$s' . 'Submitting this form will ' . '%2$s' . 'not' . '%3$s' . ' add you to any email distribution lists.' . '%4$s', 'massload' ),
                        '<p>',
                        '<em>',
                        '</em>',
                        '</p>'
                    );*/
                        ?>
                        <p><br></p>
                    </div>
                    <div class="theme_form">
                        <?php
                        $post_data = get_post($post->post_parent);
                        $parent_slug = $post_data->post_name;
                        // echo $parent_slug.'___';

                        if ($parent_slug == 'applications' || $post->post_name == 'applications') { ?>

                            <!-- SharpSpring Form for Request a Quote-Solution  -->
                            <script type="text/javascript">
                                var ss_form = {
                                    'account': 'MzawMLEwMbUwBAA',
                                    'formID': 'M042SjZKSknWNU41S9E1MTRP0rU0TzbWNTOxMDQ2SbKwNDRLBQA'
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


                        <?php }

                        if ($parent_slug == 'truck-axle-scales' || $post->post_name == 'truck-axle-scales') { ?>

                        <?php if ($post->post_name == 'farm-truck-scales') {

                                echo "<!-- SharpSpring Form for Request a Quote - Farm Scale (New 2022)  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'M0wyT0lMTTbSTTY3s9Q1MTc01bVINE_STUw2STNJSkmxSDZLBAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                            } elseif ($post->post_name == 'ultraslim-wheel-load-scales') {

                                echo "<!-- SharpSpring Form for Request a Quote - ULTRASLIM (New 2022)  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'BcHBEQBABAPAivJxYqQcDP2XcLsTTL5dDJVwp6MURJl46ivr-w'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                            } else {

                                echo "<!-- SharpSpring Form for Product Request a Quote (Truck Scale)  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'SzRPNjE1S7LQNTAyT9Y1STI21rVMSzLUNTdKNE8zSktNNjE3BwA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>";
                            }
                        }  // main truck axel cale cod 


                        if ($parent_slug == 'traffic-solutions') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Traffic  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzMzMTIyTLXUtTSwNNA1SUpO1E0yT7HUTTKyTDI0NTRMNEo2BAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }


                        if ($parent_slug == 'load-cells') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Load Cells  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 's0w0ME1OTUzVTTI0TtI1MTe21E0yN0jVNUwxtDSyNLGwTLa0AAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }

                        if ($parent_slug == 'weigh-modules-vessel-weighing') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Weigh Modules  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzC3tDBOTTPSNbJMNNA1MTY01020NEzStUw1TzRPNUk0tUhNAgA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }

                        if ($parent_slug == 'crane-scales-lifting-wireline') {
                            echo "<!-- SharpSpring Form for Product Request a Quote Lifting  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'S7U0SjY3TrHQNTIzNtU1SUpM1bVMSTTVTbNISrUwNTOwMDIxBAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }

                        if ($parent_slug == 'process-controls-amplifiers') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Amplifiers  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzY1Mrc0S0nWNUlLTtE1MTNM1U0ySjPWTU4xN7A0sUiyTDI0AAA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }

                        if ($parent_slug == 'indicators-remote-displays-printers' || $parent_slug == 'load-cell-indicators-remote-displays-printers') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Indicators  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'M7I0STY1MLPQTTQ2NdU1MUhO07VINUvSNTMxSkw0MTBNMTdJAwA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }

                        if ($parent_slug == 'wireless') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Wireless  -->
<script type='text/javascript'>
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'MzExtjBMNDPUTU0zStY1MU9K1U0yMgayUlJNkozTzIwNDQ0B'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript' src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }

                        if ($parent_slug == 'interconnection-hardware') {

                            echo "<!-- SharpSpring Form for Product Request a Quote Interconnect  -->
<script type='text/javascript' >
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'SzY2TjJPNLPQNbcwTtI1STEy002ysLTUTTEzM0o2MbZMNEhMBQA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type='text/javascript'  src='https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1'></script>
";
                        }






                        // echo do_shortcode('[contact-form-7 id="218" title="Request a Quote"]');
                        ?>
                    </div>
                </div>
            </section>

            <div class="product-intro pt-100 hide-desktop">
                <div class="container product-intro-wrap">
                    <div class="row product-intro-inner">
                        <div class="col-md-4 product-filter productImage-right">
                            <div class="productMenu-sidebar">
                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <form class="form-inline header-searchform" role="search" action="<?php echo get_site_url(); ?>" method="get">
                                        <input class="form-control my-0 py-1" type="text" name="s" id="search" value="" placeholder="Search" aria-label="Search">
                                        <button type="submit" class="btn btn-red my-sm-0"><span class="input-group-text" id="basic-text1"><i class="fa fa-search"
                                                    aria-hidden="true"></i></span></button>
                                        <input type="hidden" name="post_type" value="products">
                                    </form>
                                </div>
                                <?php bellows('main', array('theme_location' => 'products')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php get_footer(); ?>

        <script src='https://kenwheeler.github.io/slick/slick/slick.js'></script>
        <script type="text/javascript">
            jQuery('.slider-content').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                infinite: false,
                speed: 1000,
                asNavFor: '.slider-thumb',
                arrows: true,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',
            });
            jQuery('.slider-thumb').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.slider-content',
                arrows: true,
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                variableWidth: true,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>'
            });


            jQuery('.video-content').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                infinite: false,
                speed: 1000,
                asNavFor: '.video-thumb',
                arrows: true,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',
            });
            jQuery('.video-thumb').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.video-content',
                arrows: true,
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                variableWidth: true,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>'
            });
        </script>

        <script type="text/javascript">
            /*$('.slider-content').each(function(key, item) {

      var sliderIdName = 'slider' + key;
      var sliderNavIdName = 'sliderNav' + key;

      this.id = sliderIdName;
      $('.slider-thumb')[key].id = sliderNavIdName;

      var sliderId = '#' + sliderIdName;
      var sliderNavId = '#' + sliderNavIdName;

      $(sliderId).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: sliderNavId
      });

      $(sliderNavId).slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: sliderId,
        dots: false,
        arrows: true,
        centerMode: true,
        focusOnSelect: true,
        variableWidth: true
      });

    });*/
        </script>