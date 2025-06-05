<?php
/**
 * Theme setup functions
 *
 * @package CustomTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function custom_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Add custom image sizes
    add_image_size('hero-image', 1920, 800, true);
    add_image_size('card-image', 400, 300, true);
    add_image_size('blog-thumbnail', 400, 250, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'custom-theme'),
        'footer'  => __('Footer Menu', 'custom-theme'),
    ));

    // Switch default core markup to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for block styles
    add_theme_support('wp-block-styles');

    // Add support for wide alignment
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'custom_theme_setup');

/**
 * Theme activation hook
 */
function custom_theme_activation() {
    // Only run setup actions if we're in admin context
    if (is_admin()) {
        // Check plugin dependencies
        custom_theme_check_plugin_dependencies();
    }
    
    // Create required pages
    custom_theme_create_pages();
    
    // Setup menus
    custom_theme_setup_menus();
    
    // Set homepage
    custom_theme_set_homepage();
    
    // Import demo content for homepage only
    custom_theme_import_demo_content();
    
    // Create sample blog posts
    custom_theme_create_sample_blogs();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'custom_theme_activation');

/**
 * Check if required plugins are installed and activated
 */
function custom_theme_check_plugin_dependencies() {
    // Include the plugin.php file to access is_plugin_active function
    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    
    $required_plugins = array(
        'advanced-custom-fields-pro/acf.php' => 'Advanced Custom Fields Pro',
        'custom-utility/custom-utility.php' => 'Custom Utility Plugin'
    );
    
    $missing_plugins = array();
    
    foreach ($required_plugins as $plugin_path => $plugin_name) {
        if (!is_plugin_active($plugin_path)) {
            $missing_plugins[] = $plugin_name;
        }
    }
    
    if (!empty($missing_plugins)) {
        set_transient('custom_theme_missing_plugins', $missing_plugins, 30);
        add_action('admin_notices', 'custom_theme_plugin_dependency_notice');
    }
}

/**
 * Display admin notice for missing plugins
 */
function custom_theme_plugin_dependency_notice() {
    $missing_plugins = get_transient('custom_theme_missing_plugins');
    
    if ($missing_plugins) {
        $plugin_list = implode(', ', $missing_plugins);
        ?>
        <div class="notice notice-error is-dismissible">
            <p>
                <strong><?php _e('Custom Theme Requirements:', 'custom-theme'); ?></strong>
                <?php printf(
                    __('The following plugins are required for this theme to function correctly: %s. Please install and activate these plugins.', 'custom-theme'),
                    $plugin_list
                ); ?>
            </p>
        </div>
        <?php
        delete_transient('custom_theme_missing_plugins');
    }
}

/**
 * Create required pages (without templates)
 */
function custom_theme_create_pages() {
    $pages = array(
        'campus' => array(
            'title' => 'Campus',
            'slug' => 'campus'
        ),
        'learn' => array(
            'title' => 'Learn',
            'slug' => 'learn'
        ),
        'blog' => array(
            'title' => 'Blog',
            'slug' => 'blog'
        ),
        'about' => array(
            'title' => 'About',
            'slug' => 'about'
        ),
        'careers-and-study-opportunities' => array(
            'title' => 'Careers and Study Opportunities',
            'slug' => 'careers-and-study-opportunities'
        )
    );
    
    $created_pages = array();
    
    foreach ($pages as $page_key => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['slug']);
        
        if (!$existing_page) {
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => 1
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                $created_pages[$page_key] = $page_id;
            }
        } else {
            $created_pages[$page_key] = $existing_page->ID;
        }
    }
    
    // Store created page IDs for later use
    update_option('custom_theme_created_pages', $created_pages);
}

/**
 * Setup primary menu
 */
function custom_theme_setup_menus() {
    $created_pages = get_option('custom_theme_created_pages', array());
    
    if (empty($created_pages)) {
        return;
    }
    
    // Create menu if it doesn't exist
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
    } else {
        $menu_id = $menu_exists->term_id;
    }
    
    if ($menu_id && !is_wp_error($menu_id)) {
        // Add pages to menu in specified order
        $menu_order = array('campus', 'learn', 'blog', 'about');
        $order_counter = 1;
        
        foreach ($menu_order as $page_key) {
            if (isset($created_pages[$page_key])) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => get_the_title($created_pages[$page_key]),
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $created_pages[$page_key],
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $order_counter
                ));
                $order_counter++;
            }
        }
        
        // Assign menu to primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/**
 * Set homepage
 */
function custom_theme_set_homepage() {
    $created_pages = get_option('custom_theme_created_pages', array());
    
    if (isset($created_pages['careers-and-study-opportunities'])) {
        // Set front page to static page
        update_option('show_on_front', 'page');
        update_option('page_on_front', $created_pages['careers-and-study-opportunities']);
        
        // Set blog page if blog page exists
        if (isset($created_pages['blog'])) {
            update_option('page_for_posts', $created_pages['blog']);
        }
    }
}

/**
 * Import demo content for homepage
 */
function custom_theme_import_demo_content() {
    $created_pages = get_option('custom_theme_created_pages', array());
    
    if (isset($created_pages['careers-and-study-opportunities'])) {
        // Import content from JSON file
        $demo_content_file = get_template_directory() . '/demo-content/homepage-content.json';
        
        if (file_exists($demo_content_file)) {
            $demo_content = file_get_contents($demo_content_file);
            $content_data = json_decode($demo_content, true);
            
            if ($content_data && isset($content_data['content']) && !empty($content_data['content'])) {
                // Import images first
                if (isset($content_data['images']) && !empty($content_data['images'])) {
                    custom_theme_import_demo_images($content_data['images']);
                }
                
                // Replace image IDs in content
                $updated_content = custom_theme_replace_image_ids($content_data['content']);
                
                // Update page content
                wp_update_post(array(
                    'ID' => $created_pages['careers-and-study-opportunities'],
                    'post_content' => $updated_content
                ));
                
                // Import ACF fields if they exist
                if (isset($content_data['acf_fields']) && function_exists('update_field')) {
                    foreach ($content_data['acf_fields'] as $field_name => $field_value) {
                        // Handle image fields in ACF
                        if (is_array($field_value) && isset($field_value['ID'])) {
                            $new_image_id = get_option('custom_theme_image_mapping_' . $field_value['ID']);
                            if ($new_image_id) {
                                $field_value['ID'] = $new_image_id;
                                $field_value = wp_get_attachment_metadata($new_image_id);
                            }
                        }
                        update_field($field_name, $field_value, $created_pages['careers-and-study-opportunities']);
                    }
                }
            }
        }
    }
}

/**
 * Replace image IDs in content with new imported image IDs
 */
function custom_theme_replace_image_ids($content) {
    // Get all image mappings
    global $wpdb;
    $mappings = $wpdb->get_results(
        "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'custom_theme_image_mapping_%'",
        ARRAY_A
    );
    
    foreach ($mappings as $mapping) {
        $old_id = str_replace('custom_theme_image_mapping_', '', $mapping['option_name']);
        $new_id = $mapping['option_value'];
        
        // Replace wp-image-{old_id} with wp-image-{new_id}
        $content = str_replace('wp-image-' . $old_id, 'wp-image-' . $new_id, $content);
        
        // Replace attachment URLs
        $old_url = wp_get_attachment_url($old_id);
        $new_url = wp_get_attachment_url($new_id);
        if ($old_url && $new_url) {
            $content = str_replace($old_url, $new_url, $content);
        }
    }
    
    return $content;
}

/**
 * Create sample blog posts for latest_blogs custom post type
 */
function custom_theme_create_sample_blogs() {
    // Check if posts already exist
    $existing_posts = get_posts(array(
        'post_type' => 'latest_blogs',
        'posts_per_page' => 1,
        'post_status' => 'publish'
    ));
    
    if (!empty($existing_posts)) {
        return; // Posts already exist, don't create duplicates
    }
    
    $blog_posts = array(
        array(
            'title' => 'Quam id molestie sit leo vulputate. Nisi aliquet in quis aenean nisi. Blandit nunc quis pulvinar morbi parturient vitae porttitor in risus. Massa a faucibus porttitor est maecenas aliquet.',
            'custom_field' => 'Quam id molestie sit leo vulputate. Nisi aliquet in quis aenean nisi. Blandit nunc quis pulvinar morbi parturient vitae porttitor in risus. Massa a faucibus porttitor est maecenas aliquet.'
        ),
        array(
            'title' => 'Sapien aliquam morbi suspendisse velit commodo. Lacus amet semper aliquet id neque nunc.',
            'custom_field' => 'Sapien aliquam morbi suspendisse velit commodo. Lacus amet semper aliquet id neque nunc.'
        ),
        array(
            'title' => 'Quam id molestie sit leo vulputate. Nisi aliquet in quis aenean nisi. Blandit nunc quis pulvinar morbi parturient vitae porttitor in risus. Massa a faucibus porttitor est maecenas aliquet.',
            'custom_field' => 'Quam id molestie sit leo vulputate. Nisi aliquet in quis aenean nisi. Blandit nunc quis pulvinar morbi parturient vitae porttitor in risus. Massa a faucibus porttitor est maecenas aliquet.'
        )
    );
    
    // Import the blog thumbnail image first
    $thumbnail_id = custom_theme_import_blog_thumbnail();
    
    foreach ($blog_posts as $index => $blog_data) {
        $post_id = wp_insert_post(array(
            'post_title' => $blog_data['title'],
            'post_content' => '<p>' . $blog_data['custom_field'] . '</p>',
            'post_status' => 'publish',
            'post_type' => 'latest_blogs',
            'post_author' => 1,
            'post_date' => date('Y-m-d H:i:s', strtotime('-' . ($index + 1) . ' days'))
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // Set featured image if thumbnail was imported
            if ($thumbnail_id) {
                set_post_thumbnail($post_id, $thumbnail_id);
            }
            
            // Set ACF custom field if ACF is active
            if (function_exists('update_field')) {
                error_log("update function is there");
                update_field('latest_custom_filed', $blog_data['custom_field'], $post_id);
            }
        }
    }
}

/**
 * Import blog thumbnail image
 */
function custom_theme_import_blog_thumbnail() {
    $thumbnail_path = get_template_directory() . '/assets/images/blog-thumbnail.png';
    
    if (!file_exists($thumbnail_path)) {
        return false;
    }
    
    // Check if image already exists
    $existing_attachment = get_posts(array(
        'post_type' => 'attachment',
        'meta_query' => array(
            array(
                'key' => '_wp_attached_file',
                'value' => 'blog-thumbnail.png',
                'compare' => 'LIKE'
            )
        ),
        'posts_per_page' => 1
    ));
    
    if (!empty($existing_attachment)) {
        return $existing_attachment[0]->ID;
    }
    
    // Include required WordPress functions
    if (!function_exists('media_handle_sideload')) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    
    // Copy file to temp location for sideloading
    $temp_file = wp_tempnam('blog-thumbnail.png');
    copy($thumbnail_path, $temp_file);
    
    $file_array = array(
        'name' => 'blog-thumbnail.png',
        'tmp_name' => $temp_file
    );
    
    $attachment_id = media_handle_sideload($file_array, 0, 'Blog Thumbnail');
    
    if (!is_wp_error($attachment_id)) {
        update_post_meta($attachment_id, '_wp_attachment_image_alt', 'Blog thumbnail image');
        return $attachment_id;
    }
    
    return false;
}

/**
 * Import demo images
 */
function custom_theme_import_demo_images($images) {
    if (!function_exists('media_handle_sideload')) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    
    foreach ($images as $image_data) {
        $image_path = get_template_directory() . '/demo-content/images/' . $image_data['filename'];
        
        if (file_exists($image_path)) {
            // Copy to temp file for sideloading
            $temp_file = wp_tempnam($image_data['filename']);
            copy($image_path, $temp_file);
            
            $file_array = array(
                'name' => $image_data['filename'],
                'tmp_name' => $temp_file
            );
            
            $attachment_id = media_handle_sideload($file_array, 0, $image_data['title']);
            
            if (!is_wp_error($attachment_id)) {
                // Update alt text
                if (isset($image_data['alt'])) {
                    update_post_meta($attachment_id, '_wp_attachment_image_alt', $image_data['alt']);
                }
                
                // Store mapping for content replacement
                update_option('custom_theme_image_mapping_' . $image_data['original_id'], $attachment_id);
            }
        }
    }
}

/**
 * Register widget areas.
 */
function custom_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'custom-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 1', 'custom-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here.', 'custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 2', 'custom-theme'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here.', 'custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 3', 'custom-theme'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here.', 'custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets_init');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function custom_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('custom_theme_content_width', 1200);
}
add_action('after_setup_theme', 'custom_theme_content_width', 0);

/**
 * Clean up on theme deactivation
 */
function custom_theme_deactivation() {
    // Clean up transients
    delete_transient('custom_theme_missing_plugins');
    delete_option('custom_theme_created_pages');
    
    // Clean up image mappings
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'custom_theme_image_mapping_%'");
}
add_action('switch_theme', 'custom_theme_deactivation');
