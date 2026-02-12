<?php

declare(strict_types=1);

/**
 * Models Grid for Service Page - Flexible Content Version
 * Displays models of devices that we repair
 */

$section_data = get_query_var('section_data', []);

$models = $section_data['models'] ?? [];

if (empty($models) || !is_array($models)) {
    return;
}

// Get visibility toggle value (default to true for backward compatibility)
$show_title = isset($section_data['show_title']) ? (bool) $section_data['show_title'] : true;

// Get title from flexible content or use default
$title = !empty($section_data['title']) ? $section_data['title'] : 'Models We Repair';

?>

<section class="service-models">
    <div class="container">
        <?php if ($show_title && !empty($title)) : ?>
            <h2 class="service-models__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="service-models__grid">
            <?php foreach ($models as $model) : ?>
                <?php if (!empty($model['image']) && is_array($model['image'])) : ?>
                    <div class="service-models__item">
                        <img
                            src="<?php echo esc_url($model['image']['url']); ?>"
                            alt="<?php echo esc_attr($model['image']['alt'] ?? $model['name'] ?? 'Model'); ?>"
                            loading="lazy"
                            class="service-models__image"
                        >
                        <div class="service-models__content">
                            <?php if (!empty($model['name'])) : ?>
                                <div class="service-models__name"><?php echo esc_html($model['name']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($model['description'])) : ?>
                                <div class="service-models__description"><?php echo esc_html($model['description']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
