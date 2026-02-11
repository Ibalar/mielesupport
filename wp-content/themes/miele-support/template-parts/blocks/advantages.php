<?php declare(strict_types=1);

/**
 * Advantages Block
 *
 * @var array $args {
 *     @type string $title       Заголовок блока
 *     @type string $subtitle    Подзаголовок
 *     @type array  $items       Список преимуществ
 *     @type array  $bg          Фоновое изображение
 * }
 */

$title = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$items = $args['items'] ?? [];
$bg = $args['bg'] ?? [];

$bg_url = '';
$bg_alt = '';

if (is_array($bg) && !empty($bg['url'])) {
    $bg_url = (string) $bg['url'];
    $bg_alt = (string) ($bg['alt'] ?? ($bg['title'] ?? ''));
}

if (!$title && !$subtitle && empty($items)) {
    return;
}

?>

<section class="advantages">
    <?php if ($bg_url): ?>
        <div class="advantages__bg">
            <img
                src="<?= esc_url($bg_url); ?>"
                alt="<?= esc_attr($bg_alt); ?>"
                loading="lazy"
            >
        </div>
    <?php endif; ?>

    <div class="advantages__overlay"></div>

    <div class="container">
        <div class="advantages__wrapper">
            <?php if ($title): ?>
                <h2 class="advantages__title">
                    <?= esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($subtitle): ?>
                <p class="advantages__subtitle">
                    <?= esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($items && is_array($items)): ?>
                <div class="advantages__grid">
                    <?php foreach ($items as $item): ?>
                        <div class="advantage-item">
                            <?php if (!empty($item['icon'])): ?>
                                <div class="advantage-item__icon">
                                    <?php if (is_array($item['icon'])): ?>
                                        <img
                                            src="<?= esc_url($item['icon']['url']); ?>"
                                            alt="<?= esc_attr($item['icon']['alt']); ?>"
                                            loading="lazy"
                                        >
                                    <?php else: ?>
                                        <?= wp_kses_post($item['icon']); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($item['title'])): ?>
                                <h3 class="advantage-item__title">
                                    <?= esc_html($item['title']); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($item['text'])): ?>
                                <p class="advantage-item__text">
                                    <?= wp_kses_post($item['text']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>