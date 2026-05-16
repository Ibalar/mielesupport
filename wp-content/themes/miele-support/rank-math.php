<?php
/**
 * Rank Math SEO Integration
 * Provides ACF Theme Settings data to RankMath for front page SEO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Auto-save RankMath meta from ACF Theme Settings on front page
 * This populates RankMath's meta box in admin AND frontend output
 */
add_action('wp', function () {
    if (!is_front_page()) return;

    $front_page_id = get_option('page_on_front');
    if (!$front_page_id) return;

    $hero_title = get_field('hero_title', 'option');
    $hero_subtitle = get_field('hero_subtitle', 'option');
    $hero_bg = get_field('hero_bg', 'option');

    // Only update if RankMath meta is empty (avoid overwriting manual edits)
    $existing_title = get_post_meta($front_page_id, 'rank_math_title', true);
    $existing_desc = get_post_meta($front_page_id, 'rank_math_description', true);

    if (empty($existing_title) && $hero_title) {
        update_post_meta($front_page_id, 'rank_math_title', $hero_title);
    }

    if (empty($existing_desc) && $hero_subtitle) {
        update_post_meta($front_page_id, 'rank_math_description', wp_strip_all_tags($hero_subtitle));
    }

    // Open Graph image
    if ($hero_bg && is_array($hero_bg) && !empty($hero_bg['url'])) {
        $existing_image = get_post_meta($front_page_id, 'rank_math_opengraph-image', true);
        if (empty($existing_image)) {
            update_post_meta($front_page_id, 'rank_math_opengraph-image', $hero_bg['url']);
        }
    }
});

/**
 * Frontend title filter (fallback if meta is not set)
 */
add_filter('rank_math/frontend/title', function ($title) {
    if (!is_front_page()) return $title;

    $hero_title = get_field('hero_title', 'option');
    if ($hero_title) {
        return $hero_title . ' | ' . get_bloginfo('name');
    }

    return $title;
});

/**
 * Frontend description filter (fallback if meta is not set)
 */
add_filter('rank_math/frontend/description', function ($description) {
    if (!is_front_page()) return $description;

    $hero_subtitle = get_field('hero_subtitle', 'option');
    if ($hero_subtitle) {
        return wp_strip_all_tags($hero_subtitle);
    }

    return $description;
});

/**
 * Open Graph image (frontend fallback)
 */
add_filter('rank_math/frontend/open_graph/image', function ($image) {
    if (!is_front_page()) return $image;

    $hero_bg = get_field('hero_bg', 'option');
    if ($hero_bg && is_array($hero_bg) && !empty($hero_bg['url'])) {
        return $hero_bg['url'];
    }

    return $image;
});

/**
 * Front page LocalBusiness schema
 */
add_filter('rank_math/frontend/schema/output', function ($schema) {
    if (!is_front_page()) return $schema;

    $local_business = [
        '@type'       => 'LocalBusiness',
        '@id'         => home_url('/#localbusiness'),
        'name'        => get_bloginfo('name'),
        'url'         => home_url('/'),
        'telephone'   => get_field('service_line', 'option') ?: '+1 (929) 351 32 30',
        'description' => wp_strip_all_tags(get_field('hero_subtitle', 'option') ?: get_bloginfo('description')),
    ];

    $hero_bg = get_field('hero_bg', 'option');
    if ($hero_bg && is_array($hero_bg) && !empty($hero_bg['url'])) {
        $local_business['image'] = $hero_bg['url'];
    }

    $schema[] = $local_business;

    return $schema;
});

/**
 * Service page schema
 */
add_filter('rank_math/frontend/schema/output', function ($schema) {
    if (!is_singular('service')) return $schema;

    $service_schema = [
        '@type'       => 'Service',
        '@id'         => get_permalink() . '#service',
        'name'        => get_the_title(),
        'url'         => get_permalink(),
        'description' => wp_strip_all_tags(get_the_excerpt() ?: get_the_title()),
    ];

    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
    if ($thumbnail) {
        $service_schema['image'] = $thumbnail;
    }

    $service_schema['provider'] = [
        '@type' => 'LocalBusiness',
        'name'  => get_bloginfo('name'),
        'url'   => home_url('/'),
    ];

    $schema[] = $service_schema;

    // FAQ schema from ACF
    $faq_items = get_field('faq');
    if ($faq_items && is_array($faq_items)) {
        $faq_schema = [
            '@type'      => 'FAQPage',
            '@id'        => get_permalink() . '#faq',
            'mainEntity' => [],
        ];

        foreach ($faq_items as $item) {
            if (!empty($item['question']) && !empty($item['answer'])) {
                $faq_schema['mainEntity'][] = [
                    '@type' => 'Question',
                    'name'  => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => wp_strip_all_tags($item['answer']),
                    ],
                ];
            }
        }

        if (!empty($faq_schema['mainEntity'])) {
            $schema[] = $faq_schema;
        }
    }

    return $schema;
});

/**
 * Article/news post schema
 */
add_filter('rank_math/frontend/schema/output', function ($schema) {
    if (!is_single() || get_post_type() !== 'post') return $schema;

    $article_schema = [
        '@type'         => 'Article',
        '@id'           => get_permalink() . '#article',
        'headline'      => get_the_title(),
        'url'           => get_permalink(),
        'datePublished' => get_the_date('c'),
        'dateModified'  => get_the_modified_date('c'),
        'description'   => wp_strip_all_tags(get_the_excerpt() ?: get_the_title()),
        'author'        => [
            '@type' => 'Person',
            'name'  => get_the_author(),
        ],
        'publisher'     => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
        ],
    ];

    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
    if ($thumbnail) {
        $article_schema['image'] = $thumbnail;
    }

    $schema[] = $article_schema;

    return $schema;
});
