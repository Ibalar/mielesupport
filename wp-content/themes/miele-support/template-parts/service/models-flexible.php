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

// Get block_title field value, use default if not set or empty
$block_title = $section_data['block_title'] ?? '';
$title = !empty($block_title) ? $block_title : 'Модели оборудования';

?>

<section class="service-models">
    <div class="container">
        <?php if (!empty($title)) : ?>
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
                            <?php if (!empty($model['model_description'])) : ?>
                                <div class="service-models__description"><?php echo esc_html($model['model_description']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($model['name'])) : ?>
                                <div class="service-models__name"><?php echo esc_html($model['name']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
