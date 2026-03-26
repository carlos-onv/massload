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
			<h2 class="sub-heading"><?php esc_html_e( 'Blogs', 'massload'); ?></h2>
			<h1><?php the_title(); ?></h1>
			<?php 
				$post_type = get_post_type( get_the_id() );
				if($post_type == "post"){
			?>
			<div class="core-breadcrumbs"><ul id="breadcrumbs"><li><a href="https://www.massload.com">Home</a></li><li class="separator"> / </li><li><a href="/blog/">Blog</a></li><li class="separator"> / </li><li><?php echo get_the_title(); ?></li></ul></div>
			<?php
				}else{
					core_breadcrumbs();
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
                    <?php
                        $post_id      = get_the_ID();
                        $post_type    = get_post_type();
                        $post_date    = get_the_date( 'F j, Y', $post_id );
                        $tax_category = 'category';
                        $tax_tag      = 'post_tag';
                        $categories   = get_the_terms( $post_id, $tax_category );
                        $tags         = get_the_terms( $post_id, $tax_tag );
                    ?>

                    <div class="cs-content app_case_content">
                        <?php if (has_post_thumbnail( $post->ID ) ): ?>
                            <div class="app_case_image">
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
								$thumbnail_id = get_post_thumbnail_id( $post->ID );
								$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
								?>              
                                <img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>" class="img-fluid">      
                                <span class="post-date"><?php echo esc_html( $post_date ); ?></span>        
                            </div>
                        <?php endif; ?>
                        <div class="sharethis"><?php echo sharethis_inline_buttons(); ?></div>
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
                    <div class="widget contact-widget">
							<h4>Contact Us</h4>
							<!-- SharpSpring Form for [TOP] Contact on blog and articles   -->
<script type="text/javascript">
    var ss_form = {'account': 'MzawMLEwMbUwBAA', 'formID': 'S0o1t0gzMjHWNUw1M9Y1MTEx1U00MbbQTU5LtTQ2szAxMDA3BwA'};
    ss_form.width = '100%';
    ss_form.domain = 'app-3QNNZZKOIE.marketingautomation.services';
	ss_form.hidden = {'_usePlaceholders': true};
    // ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values
    // ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id
    // ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.
</script>
<script type="text/javascript" src="https://koi-3QNNZZKOIE.marketingautomation.services/client/form.js?ver=2.0.1"></script>

						</div>
                    <?php
                        $filter_args = array(
                            'title'               => __( 'Search Blogs', 'massload' ),
                            'post_type'           => $post_type,
                            'taxonomy'            => $tax_category,
                            'ajax'                => false,
                            'option_default_text' => __( 'SEARCH BY CATEGORY', 'massload' ),
                            'add_classes'         => 'blogs-redirect',
                            'redirect_slug'       => 'blogs',
                            'use_fields'          => array( 'search', 'select' )
                        );
                        core_adv_search_widget( $filter_args );

						// Popular Tags Widget
						$tag_args = array(
							'post_type'           => $post_type,
							'taxonomy'            => $tax_tag,
							'ajax'                => false
						);
						//core_tags_widget( $tag_args );
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
                                $post_type     = get_post_type();
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