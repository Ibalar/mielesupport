<?php declare(strict_types=1);

/**
 * Section 3 - Models Block
 *
 * @var array $args {
 *     @type string $title         Заголовок блока
 *     @type string $description   Описание блока
 *     @type array  $items         Список элементов
 *     @type string $button_text   Текст кнопки
 *     @type array  $button_link   Ссылка кнопки
 *     @type array  $image         Изображение
 *     @type array  $bg            Фоновое изображение
 * }
 */

$title = $args['title'] ?? '';
$description = $args['description'] ?? '';
$items = $args['items'] ?? [];
$button_text = $args['button_text'] ?? '';
$button_link = $args['button_link'] ?? [];
$image = $args['image'] ?? [];
$bg = $args['bg'] ?? [];

$button_url = '';
$button_target = '';

if (is_array($button_link)) {
    $button_url = (string) ($button_link['url'] ?? '');
    $button_target = (string) ($button_link['target'] ?? '');

    if (!$button_text && !empty($button_link['title'])) {
        $button_text = $button_link['title'];
    }
} elseif (is_string($button_link)) {
    $button_url = $button_link;
}

$image_url = '';
$image_alt = '';

if (is_array($image)) {
    $image_url = (string) ($image['url'] ?? '');
    $image_alt = (string) ($image['alt'] ?? ($image['title'] ?? ''));
}

$bg_url = '';
$bg_alt = '';

if (is_array($bg)) {
    $bg_url = (string) ($bg['url'] ?? '');
    $bg_alt = (string) ($bg['alt'] ?? ($bg['title'] ?? ''));
}

if (!$title && !$description && empty($items) && !$image_url) {
    return;
}

?>

<section class="section3">
    <?php if ($bg_url): ?>
        <div class="section3__bg">
            <img
                src="<?= esc_url($bg_url); ?>"
                alt="<?= esc_attr($bg_alt); ?>"
                loading="lazy"
            >
        </div>
    <?php endif; ?>

    <div class="section3__wrapper">
        <div class="section3__content">
            <?php if ($title): ?>
                <h2 class="section3__title"><?= esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($description): ?>
                <div class="section3__description"><?= wp_kses_post($description); ?></div>
            <?php endif; ?>

            <?php if ($items && is_array($items)): ?>
                <ul class="section3__list">
                    <?php foreach ($items as $item): ?>
                        <li class="section3__item">
                            <span class="section3__item-icon">
                                <?php
                                $icon = $item['item_icon'] ?? null;

                                if (is_array($icon) && !empty($icon['url'])): ?>
                                    <img
                                        src="<?= esc_url((string) $icon['url']); ?>"
                                        alt="<?= esc_attr((string) ($icon['alt'] ?? ($icon['title'] ?? ''))); ?>"
                                        loading="lazy"
                                    >
                                <?php elseif (is_string($icon) && $icon !== ''): ?>
                                    <?= wp_kses_post($icon); ?>
                                <?php else: ?>
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 8.656V17C19 17.5304 18.7893 18.0391 18.4142 18.4142C18.0391 18.7893 17.5304 19 17 19H3C2.46957 19 1.96086 18.7893 1.58579 18.4142C1.21071 18.0391 1 17.5304 1 17V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H15.344M7 9L10 12L20 2" stroke="#CC2229" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                <?php endif; ?>
                            </span>

                            <?php if (!empty($item['item_text'])): ?>
                                <span class="section3__item-text"><?= esc_html((string) $item['item_text']); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($button_text && $button_url): ?>
                <div class="section3__actions">
                    <a
                        href="<?= esc_url($button_url); ?>"
                        class="btn btn--primary section3__button"
                        <?= $button_target ? 'target="' . esc_attr($button_target) . '"' : ''; ?>
                        <?= $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                    >
                        <?= esc_html((string) $button_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($image_url): ?>
            <div class="section3__image">
                <img
                    src="<?= esc_url($image_url); ?>"
                    alt="<?= esc_attr($image_alt); ?>"
                    loading="lazy"
                >
            </div>
        <?php endif; ?>
    </div>
</section>