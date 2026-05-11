<?php
/**
 * Template Name: Products Template
 */

get_header();

$banner = get_the_post_thumbnail_url(get_the_ID(),'full');
?>

<div id="pagebanner" class="pagebanner">
    <div class="inner-banner" style="background-color:#f1f2f1; <?php if($banner) echo 'background-image: url('.esc_url($banner).'); background-size: cover;'; ?>">
        <div class="container">
            <?php
            echo '<h3 class="breadcrumb-nav">';
            echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
            echo ' / ';
            echo '<span>' . esc_html(get_the_title()) . '</span>';
            echo '</h3>';
            ?>
            <div class="category-banner-row">
                <div class="category-title-col">
                    <?php
                    $title = get_the_title();
                    // Apply red span to the first word
                    $words = explode(' ', $title);
                    if (count($words) > 0) {
                        $words[0] = '<span style="color: #e30913;">' . $words[0] . '</span>';
                        $title = implode(' ', $words);
                    }
                    echo '<h1 class="mass-category-title">' . $title . '</h1>';
                    ?>
                </div>
                <?php
                if (function_exists('get_field')) {
                    $page_description = get_field('page_description');
                    if ($page_description) {
                        echo '<div class="category-desc-col">';
                        echo '<div class="category-description">';
                        echo wp_kses_post($page_description);
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<main id="pagecontent" role="content">
    <section class="innerpages mt-4 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="interiorpage">
                            <?php 
                                if ( have_posts() ) :
                                    while ( have_posts() ) : the_post(); 
                                	    the_content();
                                    endwhile; 
                                endif; 
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
