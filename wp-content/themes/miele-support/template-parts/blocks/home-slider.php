<?php declare(strict_types=1);

/**
 * Home Slider Block
 * 
 * @var array $args {
 *     @type string $title    Заголовок
 *     @type string $subtitle Подзаголовок
 *     @type array  $slides   Массив слайдов
 * }
 */

$title = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$slides = $args['slides'] ?? [];

if (empty($slides)) {
    return;
}

?>

<section class="home-slider">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="home-slider__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($subtitle) : ?>
            <p class="home-slider__subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <div class="home-slider__wrapper">
            <div class="home-slider__track">
                <?php foreach ($slides as $slide) : ?>
                    <?php if (!empty($slide['image']) && is_array($slide['image'])) : ?>
                        <div class="home-slider__slide">
                            <img 
                                src="<?php echo esc_url($slide['image']['url']); ?>" 
                                alt="<?php echo esc_attr($slide['image']['alt'] ?? $slide['caption'] ?? 'Slide'); ?>"
                                loading="lazy"
                                class="home-slider__image"
                            >
                            <?php if (!empty($slide['caption'])) : ?>
                                <div class="home-slider__caption"><?php echo esc_html($slide['caption']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
