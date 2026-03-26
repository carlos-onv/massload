<?php


get_header(); 

$banner = get_the_post_thumbnail_url(get_the_ID(),'full');



?>

<div id="pagebanner" class="pagebanner casestudies_banner">
    <div class="inner-banner"  style="background-image: url(<?php echo $banner; ?>);">
        <div class="container">
          <?php if ( have_posts() ) : ?>
              <?php
                //the_archive_title( '<h1 class="page-title">', '</h1>' );

                echo '<h1>' . __( 'Case Studies', 'massload' ) . '</h1>';
              ?>           
          <?php endif; ?>
          <?php core_breadcrumbs(); ?>

        </div>
    </div>
</div>

 <main id="pagecontent" role="content">
    <section class="innerpages pt-100 ">
        
      <!-- <h2>Applications : <?php single_tag_title(); ?></h2> -->

<div class="container">
      <div class="row">

       

        <div class="col-md-8">

          <div class="sharethis">
          </div>

          <div class="cs-content app_case_content app_case_content_wrap">
           <div class="row">
           <?php
          if ( have_posts() ) : ?>
            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();                                
            $featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full"  );?>

         <div class="col-sm-6">
           <div class="app_case_content_inner">
             <a href="<?php the_permalink(); ?>"><img src="<?php the_field('product_thumb');?>" class="img-fluid"></a>
             <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
             <p><?php the_excerpt(); ?></p>
             <a href="<?php the_permalink(); ?>" class="theme-btn">READ MORE</a>                                                
           </div>
         </div>

         <?php endwhile;
                                endif;
                                // Reset Post Data
                                wp_reset_postdata();
                            ?>
         
        </div>
          </div>

          

        </div>

        <div class="col-md-4">

          <div class="search-widget widget">
            <?php if(mmi_opts_get('search-title')) { ?>
                <h4><?php mmi_opts_show('search-title'); ?></h4>
            <?php } else { ?><h4>Search</h4><?php } ?>
            <form action="/" method="get">
              <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="KEYWORDS" />
              <button type="submit" id="searchsubmit"></button>  
              <input type="hidden" name="post_type" value="case_study">            
            </form>
          </div>

          <div class="tag-widget widget">
            <?php if(mmi_opts_get('tag-title')) { ?>
                <h4><?php mmi_opts_show('tag-title'); ?></h4>
            <?php } else { ?><h4>Tags</h4><?php } ?>
            <ul>
               <li><a href="<?php get_permalink(); ?>"><?php single_tag_title(); ?></a></li>
            </ul>

          </div>          

        </div>


      </div>
    </div>

    </section> 

      <section id="req-quote" class="quaote_blk">
        <div class="container">
             <div class="heading-block text-center">
                <?php if(mmi_opts_get('csform-title')) { ?>
                <h2><?php mmi_opts_show('csform-title'); ?></h2>
            <?php } else { ?><h2><span>Request A</span> Case Study</h2><?php } ?>
            <?php if(mmi_opts_get('csform-subtitle')) { ?>
                <p><?php mmi_opts_show('csform-subtitle'); ?></p>
            <?php } else { ?><p>Requesting a case study will <em>not</em> add you to any email distribution lists.</p><?php } ?>
                
                <p><br></p>
            </div>
            <div class="theme_form">
                <?php echo do_shortcode('[contact-form-7 id="1346" title="Request a Casestudy"]');?>
            </div>
        </div>
     </section>

  
</main>
<?php get_footer(); ?>