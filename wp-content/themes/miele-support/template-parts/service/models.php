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

?>

<section class="service-models">
    <div class="container">
        <h2 class="service-models__title">Models We Repair</h2>

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
