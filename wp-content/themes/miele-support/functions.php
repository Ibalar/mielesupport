<?php
defined('ABSPATH') || exit;

/* THEME SETUP */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
});


/* MENUS */
register_nav_menus([
    'primary'        => 'Primary Menu',
    'burger_main'    => 'Burger Main',
]);

/* CPT: SERVICE */
add_action('init', function () {
    register_post_type('service', [
        'label' => 'Services',
        'public' => true,
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'rewrite' => ['slug' => 'services'],
        'show_in_rest' => true,
    ]);
});

/* ACF OPTIONS */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'redirect'   => false,
    ]);
}

/* AJAX BLOG */
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
    $page = intval($_GET['page']);

    $q = new WP_Query([
        'post_type' => 'post',
        'paged' => $page,
    ]);

    while ($q->have_posts()) {
        $q->the_post();
        get_template_part('template-parts/blog/card');
    }

    wp_die();
}

/* SCHEMA */
add_action('wp_head', function () {
    if (is_singular('service')) {
        get_template_part('template-parts/schema/service');
        if (get_field('faq')) {
            get_template_part('template-parts/schema/faq');
        }
    }

    if (is_single() && get_post_type() === 'post') {
        get_template_part('template-parts/schema/article');
    }
});


add_filter('acf/settings/save_json', function() {
    return get_template_directory() . '/acf-json';
});
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

/* MEGA MENU CACHE */
define('MEGA_MENU_CACHE_KEY', 'miele_mega_menu_cache');
define('MEGA_MENU_CACHE_TIME', 2 * HOUR_IN_SECONDS);

/**
 * Clear mega menu cache when service posts are updated
 */
function clear_mega_menu_cache($post_id) {
    if (get_post_type($post_id) !== 'service') {
        return;
    }
    delete_transient(MEGA_MENU_CACHE_KEY);
}
add_action('save_post_service', 'clear_mega_menu_cache');
add_action('delete_post', 'clear_mega_menu_cache');

/**
 * Get cached level 1 services for mega menu
 */
function get_cached_level1_services() {
    $cached = get_transient(MEGA_MENU_CACHE_KEY);

    if ($cached !== false) {
        return $cached;
    }

    $services = get_posts([
        'post_type' => 'service',
        'post_parent' => 0,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ]);

    set_transient(MEGA_MENU_CACHE_KEY, $services, MEGA_MENU_CACHE_TIME);

    return $services;
}

/**
 * Get children services for a parent service
 */
function get_service_children($parent_id, $check_visibility = true) {
    $args = [
        'post_type' => 'service',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ];

    $children = get_posts($args);

    if ($check_visibility) {
        $children = array_filter($children, function($child) {
            $show_in_menu = get_field('show_in_mega_menu', $child->ID);
            return $show_in_menu !== false;
        });
    }

    return $children;
}

/* JS */

function theme_script($handle, $file, $deps = [], $in_footer = true) {
    wp_enqueue_script(
        $handle,
        get_template_directory_uri() . '/assets/js/' . $file,
        $deps,
        filemtime(get_template_directory() . '/assets/js/' . $file),
        $in_footer
    );
}





/* Style */

function theme_style($handle, $file, $deps = []) {
    wp_enqueue_style(
        $handle,
        get_template_directory_uri() . '/assets/css/' . $file,
        $deps,
        filemtime(get_template_directory() . '/assets/css/' . $file)
    );
}

add_action('wp_enqueue_scripts', function () {

    // CSS
    theme_style('reset', 'reset.css');
    theme_style('base', 'base.css', ['reset']);
    theme_style('breadcrumbs', 'breadcrumbs.css', ['base']);
    theme_style('header', 'header.css', ['base']);
    theme_style('hero', 'hero.css', ['base']);
    theme_style('advantages', 'advantages.css', ['base']);
    theme_style('section5', 'section5.css', ['base']);
    theme_style('section6', 'section6.css', ['base']);
    theme_style('home-catalog', 'home-catalog.css', ['base']);
    theme_style('benefits', 'benefits.css', ['base']);
    theme_style('home-slider', 'home-slider.css', ['base']);
    theme_style('faq', 'faq.css', ['base']);
    theme_style('reviews', 'reviews.css', ['base']);
    theme_style('service-areas', 'service-areas.css', ['base']);
    theme_style('service-category-grid', 'service-category-grid.css', ['base']);
    theme_style('service-models', 'service-models.css', ['base']);
    theme_style('service-problems', 'service-problems.css', ['base']);
    theme_style('service-error-codes', 'service-error-codes.css', ['base']);
    theme_style('service-pricing-table', 'service-pricing-table.css', ['base']);
    theme_style('service-trust-cta', 'service-trust-cta.css', ['base']);
    theme_style('page-services', 'page-services.css', ['base']);
    theme_style('footer', 'footer.css', ['base']);

    // JS
    theme_script('header-js', 'header.js');
    theme_script('faq-js', 'faq.js');
    theme_script('reviews-js', 'reviews.js');
    theme_script('home-catalog-js', 'home-catalog.js');
    theme_script('home-slider-js', 'home-slider.js');
    theme_script('service-models-js', 'service-models.js');
    theme_script('page-services-js', 'page-services.js');

});

