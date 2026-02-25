<?php

declare(strict_types=1);

/**
 * Breadcrumbs functionality
 */

if (!function_exists('render_breadcrumbs')) {
    /**
     * Render breadcrumbs navigation
     *
     * @param array $args Optional arguments
     * @return void
     */
    function render_breadcrumbs(array $args = []): void {
        $defaults = [
            'separator'     => '/',
            'show_home'     => true,
            'home_text'     => 'Home',
            'home_link'     => home_url('/'),
            'before'        => '<nav class="breadcrumbs" aria-label="Breadcrumb">',
            'after'         => '</nav>',
            'before_item'   => '<ol class="breadcrumbs__list">',
            'after_item'    => '</ol>',
            'item_before'   => '<li class="breadcrumbs__item">',
            'item_after'    => '</li>',
            'current_class' => 'breadcrumbs__item--current',
            'link_class'    => 'breadcrumbs__link',
            'current_class_name' => 'breadcrumbs__current',
        ];

        $args = wp_parse_args($args, $defaults);

        // Don't show breadcrumbs on homepage
        if (is_front_page()) {
            return;
        }

        $items = [];

        // Home link
        if ($args['show_home']) {
            $items[] = sprintf(
                '%s<a href="%s" class="%s">%s</a>%s',
                $args['item_before'],
                esc_url($args['home_link']),
                esc_attr($args['link_class']),
                esc_html($args['home_text']),
                $args['item_after']
            );
        }

        // Build breadcrumb trail based on current page
        if (is_page()) {
            $page = get_queried_object();
            $ancestors = get_post_ancestors($page);

            // Add ancestors in correct order (oldest first)
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor_id) {
                $items[] = sprintf(
                    '%s<a href="%s" class="%s">%s</a>%s',
                    $args['item_before'],
                    esc_url(get_permalink($ancestor_id)),
                    esc_attr($args['link_class']),
                    esc_html(get_the_title($ancestor_id)),
                    $args['item_after']
                );
            }

            // Add current page
            $items[] = sprintf(
                '%s<span class="%s" aria-current="page">%s</span>%s',
                str_replace('class="', 'class="' . $args['current_class'] . ' ', $args['item_before']),
                esc_attr($args['current_class_name']),
                esc_html(get_the_title($page)),
                $args['item_after']
            );
        } elseif (is_single()) {
            // Get post type
            $post_type = get_post_type();
            $post_type_object = get_post_type_object($post_type);

            if ($post_type_object && $post_type !== 'post') {
                // Add post type archive link
                $archive_link = get_post_type_archive_link($post_type);
                if ($archive_link) {
                    $items[] = sprintf(
                        '%s<a href="%s" class="%s">%s</a>%s',
                        $args['item_before'],
                        esc_url($archive_link),
                        esc_attr($args['link_class']),
                        esc_html($post_type_object->label),
                        $args['item_after']
                    );
                }
            }

            // Add current post
            $items[] = sprintf(
                '%s<span class="%s" aria-current="page">%s</span>%s',
                str_replace('class="', 'class="' . $args['current_class'] . ' ', $args['item_before']),
                esc_attr($args['current_class_name']),
                esc_html(get_the_title()),
                $args['item_after']
            );
        } elseif (is_archive()) {
            $title = get_the_archive_title();
            $items[] = sprintf(
                '%s<span class="%s" aria-current="page">%s</span>%s',
                str_replace('class="', 'class="' . $args['current_class'] . ' ', $args['item_before']),
                esc_attr($args['current_class_name']),
                esc_html(wp_strip_all_tags($title)),
                $args['item_after']
            );
        } elseif (is_search()) {
            $items[] = sprintf(
                '%s<span class="%s" aria-current="page">%s "%s"</span>%s',
                str_replace('class="', 'class="' . $args['current_class'] . ' ', $args['item_before']),
                esc_attr($args['current_class_name']),
                esc_html__('Search results for', 'mielle-support'),
                esc_html(get_search_query()),
                $args['item_after']
            );
        } elseif (is_404()) {
            $items[] = sprintf(
                '%s<span class="%s" aria-current="page">%s</span>%s',
                str_replace('class="', 'class="' . $args['current_class'] . ' ', $args['item_before']),
                esc_attr($args['current_class_name']),
                esc_html__('Page not found', 'mielle-support'),
                $args['item_after']
            );
        }

        // Output breadcrumbs
        if (!empty($items)) {
            echo $args['before'];
            echo $args['before_item'];
            echo implode('', $items);
            echo $args['after_item'];
            echo $args['after'];
        }
    }
}
