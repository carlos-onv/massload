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

    get_header();

    $post_id      = get_the_ID();
    $post_type    = 'case_study';
    $post_date    = get_the_date( 'F j, Y', $post_id );
    $tax_tags     = 'related_tags';
?>

<div id="pagebanner" class="pagebanner casestudies_banner">
    <div class="inner-banner" style="background-image: url(<?php the_field('banner_image'); ?>)" >
        <div class="container">

            <?php 
                // if ( mmi_opts_get( 'main-title' ) ) {
                //     echo '<h3>';
                //         mmi_opts_show( 'main-title' );
                //     echo '</h3>';
                // } 
            ?>

			<?php
                $root       = get_page_by_path( 'case-studies' );
                $root_id    = '';
                $root_link  = '';
                $root_title = '';

                if ( ! empty( $root ) ) {
                    $root_id    = core_icl_object_id( $root->ID );
                    $root_link  = get_the_permalink( $root_id );
                    $root_title = get_the_title( $root_id );

                    $breadcrumb = array(
                        'archive'     => array(
                            'title'   => $root_title,
                            'link'    => $root_link
                        ),
                    );

                    echo '<h3>';
                        echo '<a href="' . esc_url( $root_link ) . '" class="quote_btn">';
                            echo esc_html( $root_title );
                        echo '</a>';
                    echo '</h3>';
                }

                echo '<h1>';
                    the_title();
                echo '</h1>';

                if ( ! empty( $root ) ) {
                    core_breadcrumbs( $breadcrumb );
                }
            ?>

        </div>
    </div>
</div>

<main id="pagecontent" role="content">
    <section class="innerpages pt-100 ">
        
<div class="container">
      <div class="row">

        <div id="primary" class="col-md-8">
            <?php
            $cs_application_posts = get_field('assign_applications');

            if ( ! $cs_application_posts ): ?>                
                <?php foreach( $cs_application_posts as $cs_application_post ): 
                    $cs_app_permalink = get_permalink( $cs_application_post->ID );
                    $ca_app_title     = get_the_title( $cs_application_post->ID ); ?>
                    <h2 class="app_name"><?php esc_html_e( 'Application:', 'massload'); ?> <span><?php echo $ca_app_title; ?></span></h2>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- <h2 class="app_case_title"> -->
              <?php // echo get_the_title(); ?>
            <!-- </h2> -->

          <!-- <div class="sharethis"><?php echo sharethis_inline_buttons(); ?></div> -->

            <div class="cs-content app_case_content">
                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                    <div class="app_case_image">
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>              					<?php $image_alt =  get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE); ?> 
                        <img src="<?php echo $image[0]; ?>" class="img-fluid" alt="<?php echo $image_alt; ?>">
                    </div>
                <?php endif; ?>
                <?php
                    $post_id      = get_the_ID();
                    $tax_tag      = 'related_tags';
                    $tags         = get_the_terms( $post_id, $tax_tag );
                ?>

                <?php if ( is_array( $tags ) && !empty( $tags ) ) { ?>
                    <div class="post-taxonomy-wrap related-tags">
                        <span class="title"><?php esc_html_e( 'TAGS', 'massload'); ?>:</span>
                        <?php
                            echo get_the_term_list(
                                $post->ID,
                                $tax_tag,
                                '<ul class="post-term-list"><li>',
                                ', </li><li>',
                                '</li></ul>'
                            );
                        ?>
                    </div>
                <?php } ?>
                <div class="cs-content app_case_content">
                    <?php 
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post(); 
                            the_content();
                            endwhile; 
                        endif; 
                    ?>
                </div>
            </div>

            <?php 
                $prev_post = get_previous_post();
                $next_post = get_next_post(); 
            ?>
            
            <ul class="cs_article-footer">

                <?php if ( ! empty( $prev_post ) ): ?>
                    <li class="previous">
                        <a class="link" href="<?php echo get_permalink( $prev_post->ID ); ?>">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            <?php 
                                if ( mmi_opts_get( 'previous-text' ) ) {
                                    mmi_opts_show('previous-text');
                                } else { 
                                    esc_html_e( 'PREVIOUS', 'massload');
                                }
                            ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( ! empty( $next_post ) ): ?>
                    <li class="next">
                        <a class="link" href="<?php echo get_permalink( $next_post->ID ); ?>">
                            <?php if ( mmi_opts_get( 'next-text' ) ) { ?>
                                <?php mmi_opts_show( 'next-text' ); ?>
                            <?php } else { ?>
                                <?php esc_html_e( 'NEXT', 'massload'); ?>
                            <?php } ?> 
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>

        <div id="secondary" class="col-md-4">

            <?php
                // Advance Search Widget
                $filter_args = array(
                    'title'               => __( 'Search Case Studies', 'massload' ),
                    'post_type'           => $post_type,
                    'taxonomy'            => $tax_tags,
                    'ajax'                => false,
                    'set_taxonomy'        => false,
                    'set_terms'           => false,
                    'set_search_type'     => false,
                    'add_classes'         => 'case-studies-redirect',
                    'redirect_slug'       => 'case-studies',
                    'use_fields'          => array( 'search' )
                );
                core_adv_search_widget( $filter_args );

                // Popular Tags Widget
                $tag_args = array(
                    'post_type'           => $post_type,
                    'taxonomy'            => $tax_tags,
                    'related_tags'        => true,
                    'ajax'                => false
                );
                core_tags_widget( $tag_args );

                // Recent Posts Widget
                $recent_posts_args = array(
                    'post_type'           => $post_type,
                    'posts_per_page'      => 4,
                    'ajax'                => false,
                );
                core_recent_posts_widget( $recent_posts_args );
            ?>

      </div>
    </div>

    </section>

    <?php 
        $count_left = core_get_related_tags_posts( 
            array(
                'post_type'    => 'applications',
                'return_count' => true
            )
        );

        $count_right = core_get_related_tags_posts( 
            array(
                'post_type'    => 'products',
                'return_count' => true
            )
        );
    ?>

    <?php if ( ! empty( $count_left ) || ! empty( $count_right ) ) { ?>

        <section id="application-casestudies" class="productapp-section pt100" style="background-image: url(<?php the_field('app_products_backround'); ?>)" >
            <div class="container">
                <div class="row">
                    <div id="applications-section" class="col-md-6 text-center">
                        <div class="heading-block left-border">
                            <?php if(mmi_opts_get('application-title')) { ?>
                                <h2><?php mmi_opts_show('application-title'); ?></h2>
                            <?php } else { ?>
                                <h2><?php esc_html_e( 'Applications', 'massload'); ?></h2>
                            <?php } ?>
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
                            <div class="heading-block left-border">
                                <?php if(mmi_opts_get('product-title')) { ?>
                                    <h2><?php mmi_opts_show('product-title'); ?></h2>
                                <?php } else { ?>
                                    <h2><?php esc_html_e( 'Products', 'massload'); ?></h2>
                                <?php } ?>
                            </div>
                            <?php 
                                echo core_get_related_tags_posts( 
                                    array(
                                        'post_type' => 'products'
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
                <?php if(mmi_opts_get('csform-title')) { ?>
                <h2><?php mmi_opts_show('csform-title'); ?></h2>
            <?php } else { ?>
                <?php
                    echo sprintf( 
                        esc_html__( '%1$s' . '%2$s' . 'Request A' . '%3$s' . ' Case Study' . '%4$s', 'massload' ),
                        '<h2>',
                        '<span>',
                        '</span>',
                        '</h2>'
                    );
                ?>
            <?php } ?>
            <?php if(mmi_opts_get('csform-subtitle')) { ?>
                <!-- <p><?php //mmi_opts_show('csform-subtitle'); ?></p> -->
            <?php } else { ?>
                <?php
                    /*echo sprintf( 
                        esc_html__( '%1$s' . 'Requesting a case study will ' . '%2$s' . 'not' . '%3$s' . ' add you to any email distribution lists.' . '%4$s', 'massload' ),
                        '<p>',
                        '<em>',
                        '</em>',
                        '</p>'
                    );*/
                ?>
            <?php } ?>
                
                <p><br></p>
            </div>
            <div class="theme_form"><!-- SharpSpring Form for Case Study  -->
<script type="text/javascript">
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'M7VIMzY1NE_TtUg0SdQ1STQz0U1MTTXWTTYwtkhNSUkxNkk1AQA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
    ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>

                <?php //echo do_shortcode('[contact-form-7 id="1346" title="Request a Casestudy"]');?>
            </div>
        </div>
     </section>
</main>

<?php get_footer(); ?>