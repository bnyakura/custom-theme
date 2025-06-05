<?php 
function register_latest_blogs_post_type() {
    $labels = array(
        'name'               => 'Latest Blogs',
        'singular_name'      => 'Latest Blog',
        'menu_name'          => 'Latest Blogs',
        'name_admin_bar'     => 'Latest Blog',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Blog',
        'new_item'           => 'New Blog',
        'edit_item'          => 'Edit Blog',
        'view_item'          => 'View Blog',
        'all_items'          => 'All Blogs',
        'search_items'       => 'Search Blogs',
        'not_found'          => 'No blogs found.',
        'not_found_in_trash' => 'No blogs found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'description'        => 'Custom post type for Latest Blogs',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'latest-blogs'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('latest_blogs', $args);
}
add_action('init', 'register_latest_blogs_post_type');


// Save ACF JSON to a specific folder
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-json';
});

// Load ACF JSON from that folder
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});