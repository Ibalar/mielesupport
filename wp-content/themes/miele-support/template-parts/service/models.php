<?php

declare(strict_types=1);

/**
 * Models Grid for Service Page
 * Displays models of devices that we repair
 * Note: Fallback template uses default title and no toggle controls
 */

$models = get_field('models');

if (empty($models) || !is_array($models)) {
    return;
}

// Get block_title field value, use default if not set or empty
$block_title = get_field('block_title');
$title = !empty($block_title) ? $block_title : 'Модели оборудования';

// Count total models (only those with images)
$models_with_images = array_filter($models, function($model) {
    return !empty($model['image']) && is_array($model['image']);
});
$total_models = count($models_with_images);
$show_see_more = $total_models > 12;

?>

<section class="service-models">
    <div class="container">
        <h2 class="service-models__title"><?php echo esc_html($title); ?></h2>

        <div class="service-models__grid <?php echo $show_see_more ? 'service-models__grid--collapsed' : ''; ?>">
            <?php foreach ($models_with_images as $index => $model) : ?>
                <div class="service-model-item">
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
            <?php endforeach; ?>
        </div>

        <?php if ($show_see_more) : ?>
            <div class="service-models__see-more-wrapper">
                <button class="service-models__see-more" type="button">
                    <span class="service-models__see-more-text">Показать еще</span>
                    <svg class="service-models__see-more-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>
