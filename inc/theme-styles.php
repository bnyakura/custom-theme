<?php
/**
 * Theme styles enqueue
 *
 * @package CustomTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue styles.
 */
function custom_theme_styles() {
    $min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    
    // Main theme stylesheet
    wp_enqueue_style(
        'custom-theme-style',
        CUSTOM_THEME_URL . "/assets/css/style{$min}.css",
        array(),
        CUSTOM_THEME_VERSION
    );

    // Block styles
    wp_enqueue_style(
        'custom-theme-blocks',
        CUSTOM_THEME_URL . "/assets/css/blocks{$min}.css",
        array('custom-theme-style'),
        CUSTOM_THEME_VERSION
    );

    // Font Awesome CDN
    wp_enqueue_style(
        'fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );
    // Google Fonts - Open Sans
    wp_enqueue_style(
        'custom-theme-google-fonts',
        'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&display=swap',
        array(),
        CUSTOM_THEME_VERSION
    );
}
add_action('wp_enqueue_scripts', 'custom_theme_styles');

/**
 * Enqueue block editor styles
 */
function custom_theme_block_editor_styles() {
        wp_enqueue_style(
        'custom-theme-block-editor',
        CUSTOM_THEME_URL . '/assets/css/editor-style.css',
        array(),
        CUSTOM_THEME_VERSION
    );
    // Google Fonts for editor
    wp_enqueue_style(
        'custom-theme-google-fonts',
        'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&display=swap',
        array(),
        CUSTOM_THEME_VERSION
    );
}
add_action('enqueue_block_editor_assets', 'custom_theme_block_editor_styles');

/**
 * Add custom CSS variables to the frontend
 */
function custom_theme_css_variables() {
    $custom_css = ':root {
        --color-primary: #1a3c7b;
        --color-secondary: #64748b;
        --color-accent: #f59e0b;
        --color-background: #ffffff;
        --color-foreground: #1e293b;
        --color-muted: #f8fafc;
        --font-family-base: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        --container-max-width: 1200px;
        --container-padding: 1rem;
        --border-radius: 0.5rem;
        --box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        
        /* Typography - Base */
        --font-size-base: 16px;
        --line-height-base-d: 160%;
        --line-height-base-m: 140%;
        --line-height-base: 3rem;
        
        /* Typography - Headings */
        --font-size-h1-d: 48px;
        --font-size-h1-m: 40px;
        --line-height-h1: 3rem;
        
        --font-size-h2-d: 34px;
        --font-size-h2-m: 30px;
        --line-height-h2: 140%;
        
        --font-size-h3-d: 32px;
        --font-size-h3-m: 28px;
        --line-height-h3: 140%;
        
        --font-size-h4-d: 26px;
        --font-size-h4-m: 22px;
        --line-height-h4-d: auto;
        --line-height-h4-m: 150%;
        
        --font-size-h5: 15px;
        --line-height-h5-d: 160%;
        --line-height-h5-m: 180%;
        
        --font-size-h6-d: 14px;
        --font-size-h6-m: 12px;
        --line-height-h6: 140%;
        
        /* Typography - Nav */
        --font-size-nav: 16px;
        --line-height-nav: auto;
        
        /* Typography - Button */
        --font-size-button: 18px;
        --line-height-button: auto;
    }';
    
    wp_add_inline_style('custom-theme-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'custom_theme_css_variables');
