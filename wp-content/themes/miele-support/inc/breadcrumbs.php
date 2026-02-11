<?php

declare(strict_types=1);

/**
 * Breadcrumbs Helper Functions
 *
 * Provides functions for generating breadcrumb navigation
 * supporting all hierarchy levels for pages and services.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get breadcrumb items for the current page
 *
 * @return array Array of breadcrumb items with 'url' and 'title' keys
 */
function get_breadcrumb_items(): array
{
    $breadcrumbs = [];

    // Home link - always first
    $breadcrumbs[] = [
        'url'   => home_url('/'),
        'title' => __('Home', 'miele-support'),
    ];

    // Handle different page types
    if (is_front_page()) {
        // On home page, remove the home breadcrumb (empty result)
        return [];
    }

    if (is_singular('service')) {
        // Service single - add services root then hierarchy
        $breadcrumbs = array_merge($breadcrumbs, get_service_breadcrumbs());
    } elseif (is_post_type_archive('service')) {
        // Services archive - Services is current page
        $breadcrumbs[] = [
            'url'   => '',
            'title' => __('Services', 'miele-support'),
        ];
    } elseif (is_page()) {
        // Regular page - add page ancestors
        $breadcrumbs = array_merge($breadcrumbs, get_page_breadcrumbs());
    } elseif (is_single() && get_post_type() === 'post') {
        // Blog post - add blog page if exists, then categories
        $breadcrumbs = array_merge($breadcrumbs, get_post_breadcrumbs());
    } elseif (is_category() || is_tag() || is_tax()) {
        // Taxonomy archives
        $breadcrumbs = array_merge($breadcrumbs, get_taxonomy_breadcrumbs());
    } elseif (is_search()) {
        // Search results
        $breadcrumbs[] = [
            'url'   => '',
            'title' => __('Search Results', 'miele-support'),
        ];
    } elseif (is_404()) {
        // 404 page
        $breadcrumbs[] = [
            'url'   => '',
            'title' => __('Page Not Found', 'miele-support'),
        ];
    }

    return $breadcrumbs;
}

/**
 * Get breadcrumb items for service posts
 *
 * @return array
 */
function get_service_breadcrumbs(): array
{
    $items = [];
    global $post;

    // Add services root page
    $services_page = get_page_by_path('services');
    if ($services_page) {
        $items[] = [
            'url'   => get_permalink($services_page->ID),
            'title' => get_the_title($services_page->ID),
        ];
    } else {
        $items[] = [
            'url'   => get_post_type_archive_link('service'),
            'title' => __('Services', 'miele-support'),
        ];
    }

    // Get all ancestors (parent, grandparent, etc.)
    $ancestors = get_post_ancestors($post->ID);

    // Reverse to get them in order from oldest to current
    $ancestors = array_reverse($ancestors);

    foreach ($ancestors as $ancestor_id) {
        $items[] = [
            'url'   => get_permalink($ancestor_id),
            'title' => get_the_title($ancestor_id),
        ];
    }

    // Add current page (without link)
    $items[] = [
        'url'   => '',
        'title' => get_the_title($post->ID),
    ];

    return $items;
}

/**
 * Get breadcrumb items for regular pages
 *
 * @return array
 */
function get_page_breadcrumbs(): array
{
    $items = [];
    global $post;

    // Get all ancestors
    $ancestors = get_post_ancestors($post->ID);

    // Reverse to get them in order from oldest to current
    $ancestors = array_reverse($ancestors);

    foreach ($ancestors as $ancestor_id) {
        $items[] = [
            'url'   => get_permalink($ancestor_id),
            'title' => get_the_title($ancestor_id),
        ];
    }

    // Add current page (without link)
    $items[] = [
        'url'   => '',
        'title' => get_the_title($post->ID),
    ];

    return $items;
}

/**
 * Get breadcrumb items for blog posts
 *
 * @return array
 */
function get_post_breadcrumbs(): array
{
    $items = [];

    // Try to find blog page
    $blog_page = get_page_by_path('blog');
    if ($blog_page) {
        $items[] = [
            'url'   => get_permalink($blog_page->ID),
            'title' => get_the_title($blog_page->ID),
        ];
    }

    // Add categories if available
    $categories = get_the_category();
    if (!empty($categories)) {
        $main_category = $categories[0];
        $items[] = [
            'url'   => get_category_link($main_category->term_id),
            'title' => $main_category->name,
        ];
    }

    // Add current post (without link)
    $items[] = [
        'url'   => '',
        'title' => get_the_title(),
    ];

    return $items;
}

/**
 * Get breadcrumb items for taxonomy archives
 *
 * @return array
 */
function get_taxonomy_breadcrumbs(): array
{
    $items = [];

    // Try to find blog page for category/tag archives
    $blog_page = get_page_by_path('blog');
    if ($blog_page) {
        $items[] = [
            'url'   => get_permalink($blog_page->ID),
            'title' => get_the_title($blog_page->ID),
        ];
    }

    // Add current taxonomy (without link)
    $items[] = [
        'url'   => '',
        'title' => single_cat_title('', false) ?: single_tag_title('', false) ?: single_term_title('', false),
    ];

    return $items;
}

/**
 * Render breadcrumbs HTML
 *
 * @param array|null $breadcrumbs Optional pre-built breadcrumbs array
 * @return void
 */
function render_breadcrumbs(?array $breadcrumbs = null): void
{
    if ($breadcrumbs === null) {
        $breadcrumbs = get_breadcrumb_items();
    }

    // Don't show breadcrumbs if only Home exists or empty
    if (count($breadcrumbs) <= 1) {
        return;
    }

    get_template_part('template-parts/global/breadcrumbs', null, ['breadcrumbs' => $breadcrumbs]);
}

/**
 * Check if breadcrumbs should be shown on current page
 *
 * @return bool
 */
function should_show_breadcrumbs(): bool
{
    // Don't show on homepage
    if (is_front_page()) {
        return false;
    }

    // Check if we have enough breadcrumbs to display
    $breadcrumbs = get_breadcrumb_items();

    return count($breadcrumbs) > 1;
}
