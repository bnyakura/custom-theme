<?php
/**
 * ACF Blocks Registration
 *
 * @package CustomTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF blocks
 */
function custom_register_acf_blocks() {
    // Check if ACF is active
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Breadcrumb Block
    acf_register_block_type(array(
        'name'              => 'breadcrumb',
        'title'             => __('Breadcrumb', 'custom-theme'),
        'description'       => __('A breadcrumb navigation block.', 'custom-theme'),
        'render_template'   => 'template-parts/blocks/breadcrumb/breadcrumb.php',
        'category'          => 'custom-blocks',
        'icon'              => 'menu',
        'keywords'          => array('breadcrumb', 'navigation', 'trail'),
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true,
        ),
        'example'           => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'breadcrumb_items' => array(
                        array('label' => 'Home', 'url' => '/'),
                        array('label' => 'Sample Page', 'url' => '/sample-page/'),
                    ),
                ),
            ),
        ),
    ));

    // Latest Blogs Block
    acf_register_block_type(array(
        'name'              => 'latest-blogs',
        'title'             => __('Latest Blogs', 'custom-theme'),
        'description'       => __('Displays a list of the most recent blog posts.', 'custom-theme'),
        'render_template'   => 'template-parts/blocks/latest-blogs/latest-blogs.php',
        'category'          => 'custom-blocks',
        'icon'              => 'admin-post',
        'keywords'          => array('blog', 'posts', 'latest', 'news'),
        'supports'          => array(
            'align' => array('wide', 'full'),
            'mode' => false,
            'jsx' => true,
        ),
        'example'           => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'number_of_posts' => 3,
                    'show_excerpt' => true,
                ),
            ),
        ),
    ));

}
add_action('acf/init', 'custom_register_acf_blocks');

/**
 * Add custom block category
 */
function custom_block_categories($categories) {
    return array_merge(
        array(
            array(
                'slug'  => 'custom-blocks',
                'title' => __('Custom Blocks', 'custom-theme'),
                'icon'  => 'admin-customizer',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'custom_block_categories');
