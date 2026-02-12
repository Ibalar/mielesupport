<?php

declare(strict_types=1);

/**
 * Service Advantages Section
 * Template part: template-parts/service/advantages.php
 */

$advantages = get_field('advantages');

if (empty($advantages) || !is_array($advantages)) {
    return;
}

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
            <?php
            // Get title and subtitle from options or use defaults
            // Note: Fallback template always shows title/subtitle (no toggle fields available)
            $title = get_field('advantages_title', 'option') ?: 'Why Choose Our Miele Service?';
            $subtitle = get_field('advantages_subtitle', 'option') ?: 'Professional expertise, quality parts, and exceptional customer care for every repair.';
            ?>

            <h2 class="service-advantages__title"><?php echo esc_html($title); ?></h2>
            <p class="service-advantages__subtitle"><?php echo esc_html($subtitle); ?></p>

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