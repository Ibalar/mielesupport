<?php

declare(strict_types=1);

/**
 * Breadcrumbs template for service pages
 * Supports 3 levels: Home > Services > [Category] > [Type] > [Service]
 */

if (!defined('ABSPATH')) {
    exit;
}

$breadcrumbs = [];

// Home link
$breadcrumbs[] = [
    'url'   => home_url('/'),
    'title' => __('Home', 'miele-support'),
];

// Services root link
$services_page = get_page_by_path('services');
if ($services_page) {
    $breadcrumbs[] = [
        'url'   => get_permalink($services_page->ID),
        'title' => get_the_title($services_page->ID),
    ];
} else {
    // Fallback to services archive
    $breadcrumbs[] = [
        'url'   => get_post_type_archive_link('service'),
        'title' => __('Services', 'miele-support'),
    ];
}

// Build ancestor chain for hierarchical service posts
if (is_singular('service')) {
    global $post;

    // Get all ancestors (parent, grandparent, etc.)
    $ancestors = get_post_ancestors($post->ID);

    // Reverse to get them in order from oldest to current
    $ancestors = array_reverse($ancestors);

    foreach ($ancestors as $ancestor_id) {
        $breadcrumbs[] = [
            'url'   => get_permalink($ancestor_id),
            'title' => get_the_title($ancestor_id),
        ];
    }

    // Add current page (without link)
    $breadcrumbs[] = [
        'url'   => '',
        'title' => get_the_title($post->ID),
    ];
} elseif (is_post_type_archive('service')) {
    // On services archive, Services is the current page
    $last_key = array_key_last($breadcrumbs);
    $breadcrumbs[$last_key]['url'] = '';
}

// Don't show breadcrumbs if only Home exists
if (count($breadcrumbs) <= 1) {
    return;
}
?>

<div class="container">
    <nav class="breadcrumbs" aria-label="<?php echo esc_attr__('Breadcrumb', 'miele-support'); ?>">
        <ol class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
        <?php foreach ($breadcrumbs as $index => $crumb) : ?>
            <li class="breadcrumbs__item<?php echo empty($crumb['url']) ? ' breadcrumbs__item--current' : ''; ?>"
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/ListItem">

                <?php if (!empty($crumb['url'])) : ?>
                    <a href="<?php echo esc_url($crumb['url']); ?>"
                       class="breadcrumbs__link"
                       itemprop="item">
                        <span itemprop="name"><?php echo esc_html($crumb['title']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="breadcrumbs__current" itemprop="name">
                        <?php echo esc_html($crumb['title']); ?>
                    </span>
                <?php endif; ?>

                <meta itemprop="position" content="<?php echo esc_attr($index + 1); ?>" />
            </li>

            <?php if ($index < count($breadcrumbs) - 1) : ?>
                <li class="breadcrumbs__separator" aria-hidden="true">
                    <span class="breadcrumbs__separator-icon">&gt;</span>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ol>
    </nav>
</div>
