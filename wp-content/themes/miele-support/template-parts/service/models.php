<?php

declare(strict_types=1);

/**
 * Models Slider for Service Page
 * Displays models of devices that we repair
 */

$models = get_field('models');

if (empty($models) || !is_array($models)) {
    return;
}

?>

<section class="service-models">
    <div class="container">
        <h2 class="service-models__title">Models We Repair</h2>

        <div class="service-models__wrapper">
            <div class="service-models__track">
                <?php foreach ($models as $model) : ?>
                    <?php if (!empty($model['image']) && is_array($model['image'])) : ?>
                        <div class="service-models__slide">
                            <img
                                src="<?php echo esc_url($model['image']['url']); ?>"
                                alt="<?php echo esc_attr($model['image']['alt'] ?? $model['name'] ?? 'Model'); ?>"
                                loading="lazy"
                                class="service-models__image"
                            >
                            <?php if (!empty($model['name'])) : ?>
                                <div class="service-models__name"><?php echo esc_html($model['name']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
