<?php
/**
 * Utility functions
 *
 * @package CustomTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Safe ACF field getter to avoid hard dependencies
 */
function custom_safe_get_field($selector, $post_id = false, $format_value = true) {
    if (function_exists('get_field')) {
        return get_field($selector, $post_id, $format_value);
    }
    return false;
}

/**
 * Safe ACF sub field getter
 */
function custom_safe_get_sub_field($selector, $format_value = true) {
    if (function_exists('get_sub_field')) {
        return get_sub_field($selector, $format_value);
    }
    return false;
}

/**
 * Safe ACF have rows checker
 */
function custom_safe_have_rows($selector, $post_id = false) {
    if (function_exists('have_rows')) {
        return have_rows($selector, $post_id);
    }
    return false;
}

/**
 * Safe ACF the row function
 */
function custom_safe_the_row() {
    if (function_exists('the_row')) {
        return the_row();
    }
    return false;
}



