<?php
/**
 * Custom Theme Functions
 *
 * @package CustomTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('CUSTOM_THEME_VERSION', '1.0.0');
define('CUSTOM_THEME_URL', get_template_directory_uri());

// Bootstrap theme functionality
require_once get_template_directory() . '/inc/latest-blogs.php';
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/theme-scripts.php';
require_once get_template_directory() . '/inc/theme-styles.php';
require_once get_template_directory() . '/inc/utils.php';
require_once get_template_directory() . '/inc/acf-blocks.php';