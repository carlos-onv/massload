<?php
/**
 * Template Name: Sitemap
 *
 * Used to for Sitemap Page 
 *
 * @package Massload
 * @subpackage Massload
 * @since Massload 1.0
 */

get_header();

$banner = CORE_DEFAULT_BANNER_IMAGE;

?>

<div id="pagebanner" class="pagebanner sitemap_banner">
	<div class="inner-banner"  style="background-image: url(<?php echo esc_url( $banner ); ?>);">
		<div class="container">

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			<?php else : ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
			<?php endif; ?>

			<?php core_breadcrumbs(); ?>
		</div>
	</div>
</div>

<main id="pagecontent" role="content">
    <section class="innerpages pt-100 pb-100">
        
        <div class="container">
            <div class="row">

                <section id="primary" class="col-md-12">

                    <div class="cs-content app_case_content sitemap-ui">
                        <div class="cs-content-inner row">
                            <div class="inner-column col-md-4">
                                <?php
                                    // Homepage
                                    $company_values_args = array(
                                        /**
                                         * Accepted fields
                                         * 
                                         * root_title       The title for the link. If empty gets the "post_id" 
                                         *                  from the "root_slug" field to use as title.
                                         * 
                                         * root_slug        Uses the slug of a post as a keyword
                                         *                  to get the "post_id" and "permalink" of a post
                                         * 
                                         * root_url         If not empty overwrites the permalink to use for the link
                                         * 
                                         * root_slug_list   Holds list of items to display
                                         * 
                                         */ 
                                        'root_title'     => get_the_title( url_to_postid( get_site_url() ) ),
                                        'root_url'       => get_site_url(),
                                        'root_slug_list' => array(
                                            array(
                                                'title' => get_the_title( url_to_postid( get_site_url() ) ),
                                                'url'   => get_site_url()
                                            ),
                                        ),
                                        'echo'           => true
                                    );
                                    core_get_post_list_ui( $company_values_args );

                                    // Company & Values
                                    $company_values_args = array(
                                        'root_slug'      => 'company-values',
                                        'root_slug_list' => array(
                                            array(
                                                'slug' => 'company-values'
                                            ),
                                            array(
                                                'slug' => 'contact-us'
                                            ),
                                            array(
                                                'slug' => 'careers'
                                            )
                                        ),
                                        'echo'           => true
                                    );
                                    core_get_post_list_ui( $company_values_args );

                                    // Services
                                    $company_values_args = array(
                                        'root_slug'      => 'services',
                                        'root_slug_list' => array(
                                            /**
                                             * Accepted fields
                                             * 
                                             * id       The attr id of the target element to append in a link 
                                             * 
                                             * slug     Uses the slug of a post as a keyword
                                             *          to get the "post_id" and "permalink" of a post
                                             * 
                                             * title    The title for the link. If empty gets the "post_id" 
                                             *          from the "slug" field to use as title.
                                             * 
                                             * url      If not empty overwrites the permalink to use for the link
                                             */ 
                                            array(
                                                'id'    => '#service_tts_rma',
                                                'title' => 'Troubleshooting & Technical Support',
                                                'slug'  => 'services',
                                            ),
                                            array(
                                                'id'    => '#service_tts_rma',
                                                'title' => 'RMA Return and Repair',
                                                'slug'  => 'services',
                                            ),
                                            array(
                                                'id'    => '#service_tcs',
                                                'title' => 'Testing and Calibration Services',
                                                'slug'  => 'services',
                                            ),
                                            array(
                                                'id'    => '#service_cgs_ss',
                                                'title' => 'Custom Gauging Services',
                                                'slug'  => 'services',
                                            ),
                                            array(
                                                'id'    => '#service_cgs_ss',
                                                'title' => 'Software Services',
                                                'slug'  => 'services',
                                            ),
                                            array(
                                                'id'    => '#services_sds_mfs',
                                                'title' => 'Solution Development Services',
                                                'slug'  => 'services',
                                            ),
                                            array(
                                                'id'    => '#services_sds_mfs',
                                                'title' => 'Machining and Fabricating Services',
                                                'slug'  => 'services',
                                            ),
                                        ),
                                        'echo'           => true
                                    );
                                    core_get_post_list_ui( $company_values_args );

                                    // Applications
                                    $application_args = array(
                                        'root_slug' => 'applications',
                                        'post_type' => 'applications',
                                        'echo'      => true
                                    );
                                    core_get_post_list_ui( $application_args );

                                    // Case Study
                                    $case_study_args = array(
                                        'root_slug' => 'case-studies',
                                        'post_type' => 'case_study',
                                        'echo'      => true
                                    );
                                    core_get_post_list_ui( $case_study_args );

                                    // Resources
                                    $case_study_args = array(
                                        'root_slug' => 'resources',
                                        'post_type' => 'resources',
                                        'echo'      => true
                                    );
                                    //core_get_post_list_ui( $case_study_args );
                                    ?>
                                    <div class="core-post-hierarchical">
                                        <ul class="core-post-list resources parents resources">
                                            <li class="list-item parent parent-1912"><a href="https://www.massload.com/case-studies/natural-gas-desander/" class="item-link">NATURAL GAS DESANDER</a></li>
                                            <li class="list-item parent parent-1916"><a href="https://www.massload.com/case-studies/natural-gas-desander/" class="item-link">NATURAL GAS DESANDER 2</a></li>
                                            <li class="list-item parent parent-1913"><a href="https://www.massload.com/case-studies/underground-surge-bin/" class="item-link">UNDERGROUND SURGE BIN</a></li>
                                            <li class="list-item parent parent-1917"><a href="https://www.massload.com/case-studies/underground-surge-bin/" class="item-link">UNDERGROUND SURGE BIN 2</a></li>
                                        </ul>
                                    </div>
                            </div>
                            <div class="inner-column col-md-8">
                                <?php
                                    // Products
                                    $product_args = array(
                                        'root_slug' => 'products',
                                        'post_type' => 'products',
                                        'echo'      => true
                                    );
                                    core_get_post_list_ui( $product_args );
                                ?>
                            </div>
                        </div>
                    </div>

                </section>

            </div>
        </div>
    </section>
</main>


<?php get_footer(); ?>