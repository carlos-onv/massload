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

$banner = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$banner = get_template_directory_uri() . '/assets/img/career-bg-pattern.jpg';

?>

<div id="pagebanner" class="pagebanner resources_banner">
	<div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
		<div class="container">

			<?php
                $root       = get_page_by_path( 'resources' );
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
    <section class="innerpages ">
        
        <div class="container">
            <div class="row">

                <div id="primary" class="col-md-8">
                    <h2 class="app_case_title"><?php echo get_the_title(); ?></h2>

                    <div class="sharethis"><?php echo sharethis_inline_buttons(); ?></div>
                    
                    <?php
                        $post_id      = get_the_ID();
                        $post_type    = 'resources';
                        $post_date    = get_the_date( 'F j, Y', $post_id );
                        $tax_category = 'resources_categories';
                        $tax_tag      = 'resources_tags';
                        $categories   = get_the_terms( $post_id, $tax_category );
                        $tags         = get_the_terms( $post_id, $tax_tag );
                    ?>

                    <div class="cs-content app_case_content">
                        <?php if (has_post_thumbnail( $post->ID ) ): ?>
                            <div class="app_case_image">
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>              
                                <img src="<?php echo $image[0]; ?>" class="img-fluid">      
                                <span class="post-date"><?php echo esc_html( $post_date ); ?></span>        
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( is_array( $categories ) && !empty( $categories ) ) { ?>
                            <div class="post-taxonomy-wrap post-categories">
                                <span class="title"><?php esc_html_e( 'CATEGORIES', 'massload'); ?>:</span>
                                <?php
                                    echo get_the_term_list(
                                        $post->ID,
                                        $tax_category,
                                        '<ul class="post-term-list"><li>',
                                        ', </li><li>',
                                        '</li></ul>'
                                    );
                                ?>
                            </div>
                        <?php } ?>

                        <?php if ( is_array( $tags ) && !empty( $tags ) ) { ?>
                            <div class="post-taxonomy-wrap post-tags">
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

                        <?php 
                            if ( have_posts() ) :
                                while ( have_posts() ) : the_post(); 
                                the_content();
                                endwhile; 
                            endif; 
                        ?>
                    </div>

                    <?php 
                        $prev_post = get_previous_post();
                        $next_post = get_next_post(); 
                    ?>

                    <ul class="cs_article-footer">
                        <?php  if ( ! empty( $prev_post ) ): ?>
                            <li class="previous">
                                <a class="link" href="<?php echo get_permalink( $prev_post->ID ); ?>">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i> 
                                    <?php if(mmi_opts_get('previous-text')) { ?>
                                        <?php mmi_opts_show('previous-text'); ?>
                                    <?php } else {
                                        echo __( 'PREVIOUS', 'massload' );
                                    } ?>
                                </a>
                            </li>
                        <?php endif; ?>
                       
                        <?php  if ( ! empty( $next_post ) ): ?>
                            <li class="next">
                                <a class="link" href="<?php echo get_permalink( $next_post->ID ); ?>">
                                    <?php if(mmi_opts_get('next-text')) { ?>
                                        <?php mmi_opts_show('next-text'); ?>
                                    <?php } else {
                                        echo __( 'NEXT', 'massload' );
                                    } ?>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>

                <div id="secondary" class="col-md-4">
                    
                    <?php
                        $filter_args = array(
                            'title'               => __( 'Search Resources', 'massload' ),
                            'post_type'           => $post_type,
                            'taxonomy'            => $tax_category,
                            'ajax'                => false,
                            'option_default_text' => __( 'SEARCH BY CATEGORY', 'massload' ),
                            'add_classes'         => 'resources-redirect',
                            'redirect_slug'       => 'resources',
                            'use_fields'          => array( 'search', 'select' )
                        );
                        core_adv_search_widget( $filter_args );

						// Popular Tags Widget
						$tag_args = array(
							'post_type'           => $post_type,
							'taxonomy'            => $tax_category,
							'ajax'                => false
						);
						core_tags_widget( $tag_args );
                    ?>

                    

                    <div class="core-list-widget archive-widget widget">
                        <?php if(mmi_opts_get('archive-title')) { ?>
                            <h4><?php mmi_opts_show('archive-title'); ?></h4>
                        <?php } else { ?>
                            <h4><?php esc_html_e( 'Archive', 'massload'); ?></h4>
                        <?php } ?>

                        <ul class="list-unstyled list-striped list-levels nested-archive">
                            <?php
                                global $wpdb;
                                $db            = $wpdb->prefix;
                                $post_status   = 'publish';
                                $post_type     = 'resources';
                                $post_date     = 'post_date';
                                $month_enabled = false;

                                $years = $wpdb->get_col("
                                    SELECT DISTINCT YEAR( {$post_date} ) 
                                        FROM $wpdb->posts 
                                        WHERE post_status = '{$post_status}' AND 
                                        post_type = '{$post_type}' 
                                        ORDER BY $post_date  DESC"
                                );
                                
                                foreach( $years as $year ) {
                                    $year_link = get_year_link( $year );
                                    
                                    echo '<li>';
                                        echo '<a href="' . esc_url( $year_link ) . '">' . esc_html( $year ) . '</a>';
                                        
                                        if ( $month_enabled ) {
                                            $months = $wpdb->get_col(
                                                "SELECT DISTINCT MONTH( {$post_date} ) 
                                                    FROM $wpdb->posts 
                                                    WHERE post_status = '{$post_status}' AND 
                                                    post_type = '{$post_type}' AND 
                                                    YEAR( {$post_date} ) = '". $year ."' 
                                                    ORDER BY $post_date DESC
                                                "
                                            );

                                            echo '<ul class="list-child">';
                                                foreach( $months as $month ) {
                                                    $countposts = get_posts( "year=$year&monthnum=$month" );
                                                    $month_link = get_month_link( $year, $month );
                                                    echo '<li>';
                                                        echo '<a href="' . esc_url( $month_link ) . '">';
                                                            echo strftime( '%B', mktime(0, 0, 0, $month) ); 
                                                            // echo count( $countposts );
                                                        echo '</a>';
                                                    echo '</li>';
                                                }
                                            echo '</ul>';
                                        }

                                    echo '</li>';
                                }
                            ?>
                        </ul>
                    </div>

                </div>

            </div>
        </div>

    </section>
</main>

<?php get_footer(); ?>