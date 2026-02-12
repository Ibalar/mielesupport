<?php

declare(strict_types=1);

/**
 * Service Advantages Section - Flexible Content Version
 * Template part: template-parts/service/advantages-flexible.php
 */

$section_data = get_query_var('section_data', []);

$advantages = $section_data['advantages'] ?? [];

if (empty($advantages) || !is_array($advantages)) {
    return;
}

// Get visibility toggle values (default to true for backward compatibility)
$show_title = isset($section_data['show_title']) ? (bool) $section_data['show_title'] : true;
$show_subtitle = isset($section_data['show_subtitle']) ? (bool) $section_data['show_subtitle'] : true;

// Get title and subtitle from flexible content or use defaults from options
$title = !empty($section_data['title']) ? $section_data['title'] : (get_field('advantages_title', 'option') ?: 'Why Choose Our Miele Service?');
$subtitle = !empty($section_data['subtitle']) ? $section_data['subtitle'] : (get_field('advantages_subtitle', 'option') ?: 'Professional expertise, quality parts, and exceptional customer care for every repair.');

?>

<section class="service-advantages">
    <div class="service-advantages__bg">
        <?php
        // Get background image from options or use default
        $bg_image = get_field('advantages_bg_image', 'option');
        if (!empty($bg_image) && is_array($bg_image)) :
        ?>
            <img src="<?php echo esc_url($bg_image['url']); ?>" alt="<?php echo esc_attr($bg_image['alt'] ?? 'Advantages background'); ?>">
        <?php endif; ?>
        <div class="service-advantages__overlay"></div>
    </div>

    <div class="container">
        <div class="service-advantages__wrapper">
            <?php if ($show_title && !empty($title)) : ?>
                <h2 class="service-advantages__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($show_subtitle && !empty($subtitle)) : ?>
                <p class="service-advantages__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>

            <div class="service-advantages__grid">
                <?php foreach ($advantages as $advantage) : ?>
                    <?php if (!empty($advantage['icon']) && is_array($advantage['icon'])) : ?>
                        <div class="service-advantage-item">
                            <div class="service-advantage-item__icon">
                                <img
                                    src="<?php echo esc_url($advantage['icon']['url']); ?>"
                                    alt="<?php echo esc_attr($advantage['icon']['alt'] ?? $advantage['title'] ?? 'Advantage icon'); ?>"
                                    loading="lazy"
                                >
                            </div>
                            <?php if (!empty($advantage['title'])) : ?>
                                <h3 class="service-advantage-item__title"><?php echo esc_html($advantage['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($advantage['text'])) : ?>
                                <p class="service-advantage-item__text"><?php echo esc_html($advantage['text']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
