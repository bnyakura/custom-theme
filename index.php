<?php
/**
 * Main template file
 *
 * @package CustomTheme
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    else :
        echo '<p>' . __('No content found.', 'custom-theme') . '</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
