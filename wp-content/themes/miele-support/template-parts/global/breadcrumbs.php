<?php

declare(strict_types=1);

/**
 * Breadcrumbs Template
 *
 * Supports all hierarchy levels:
 * - Home > Services (archive)
 * - Home > Services > [Category] (Level 1)
 * - Home > Services > [Category] > [Appliance Type] (Level 2)
 * - Home > Services > [Category] > [Appliance Type] > [Service] (Level 3)
 * - Home > [Page] (regular pages)
 * - Home > [Page] > [Child Page] (page hierarchy)
 *
 * @param array $args Template arguments
 *   - breadcrumbs: Pre-built breadcrumbs array (optional)
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get breadcrumbs from args or generate them
$breadcrumbs = $args['breadcrumbs'] ?? get_breadcrumb_items();

// Don't show breadcrumbs if only Home exists or empty
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
                    <span class="breadcrumbs__current" itemprop="name" aria-current="page">
                        <?php echo esc_html($crumb['title']); ?>
                    </span>
                <?php endif; ?>

                <meta itemprop="position" content="<?php echo esc_attr($index + 1); ?>" />
            </li>

            <?php if ($index < count($breadcrumbs) - 1) : ?>
                <li class="breadcrumbs__separator" aria-hidden="true">
                    <svg class="breadcrumbs__separator-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ol>
    </nav>
</div>
