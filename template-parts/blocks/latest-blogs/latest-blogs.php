<?php
// Get block settings or set defaults
$number_of_posts = get_field('number_of_posts') ?: 3;
$show_excerpt = get_field('show_excerpt') !== false;

// Query latest posts
$args = array(
    'post_type'      => 'latest_blogs',
    'posts_per_page' => $number_of_posts,
    'post_status'    => 'publish',
);
$latest_posts = new WP_Query($args);

if ($latest_posts->have_posts()) : ?>
    <div class="latest-blogs-block">
        <div class="latest-blogs-grid">
            <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                <article class="latest-blog-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="latest-blog-thumb">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    <?php endif; ?>
                        <?php
                        $custom_field_key = 'latest_custom_filed';
                        $custom_field_value = get_post_meta(get_the_ID(), $custom_field_key, true);
                        ?>
                        <p><?php the_title(); ?></p>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>

<?php endif; ?>