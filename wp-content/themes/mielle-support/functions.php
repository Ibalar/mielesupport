<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

/* INCLUDES */
require_once get_template_directory() . '/inc/breadcrumbs.php';

/* THEME SETUP */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
});

/* MENUS */
register_nav_menus([
    'primary' => 'Primary Menu',
    'footer'  => 'Footer Menu',
]);

/* ACF OPTIONS */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'redirect'   => false,
    ]);
}

/* ACF JSON SYNC */
add_filter('acf/settings/save_json', function () {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

/* STYLE & SCRIPT HELPERS */
function theme_style($handle, $file, $deps = []) {
    wp_enqueue_style(
        $handle,
        get_template_directory_uri() . '/assets/css/' . $file,
        $deps,
        filemtime(get_template_directory() . '/assets/css/' . $file)
    );
}

function theme_script($handle, $file, $deps = [], $in_footer = true) {
    wp_enqueue_script(
        $handle,
        get_template_directory_uri() . '/assets/js/' . $file,
        $deps,
        filemtime(get_template_directory() . '/assets/js/' . $file),
        $in_footer
    );
}

/* ENQUEUE SCRIPTS & STYLES */
add_action('wp_enqueue_scripts', function () {
    // Base CSS
    theme_style('contact-page', 'contact.css', []);
});
