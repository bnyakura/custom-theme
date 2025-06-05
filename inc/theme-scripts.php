<?php
/**
 * Theme scripts enqueue
 *
 * @package CustomTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles.
 */
function custom_theme_scripts() {
    $min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    
    // Main theme JavaScript
    wp_enqueue_script(
        'custom-theme-script',
        CUSTOM_THEME_URL . "/assets/js/theme{$min}.js",
        array('jquery'),
        CUSTOM_THEME_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script('custom-theme-script', 'customTheme', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('custom_theme_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');
