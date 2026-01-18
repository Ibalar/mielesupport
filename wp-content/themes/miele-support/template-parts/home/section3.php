<?php

declare(strict_types=1);

/**
 * Section3 combo block for front page
 * Template part: template-parts/home/section3.php
 */

$title = get_field('section3_title', 'option');
$description = get_field('section3_description', 'option');
$items = get_field('section3_items', 'option');
$button_text = get_field('section3_button_text', 'option');
$button_link = get_field('section3_button_link', 'option');
$image = get_field('section3_image', 'option');
$bg = get_field('section3_bg', 'option');

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

?>

<section class="section3">
    <?php if ($bg_url): ?>
        <div class="section3__bg">
            <img
                src="<?= esc_url($bg_url); ?>"
                alt="<?= esc_attr($bg_alt); ?>"
                loading="eager"
            >
        </div>
    <?php endif; ?>

    <div class="section3__overlay"></div>

    <div class="section3__container">
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
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="10" cy="10" r="10" fill="var(--red, #cc2229)"/>
                                        <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                <a
                    href="<?= esc_url($button_url); ?>"
                    class="btn btn--primary section3__button"
                    <?= $button_target ? 'target="' . esc_attr($button_target) . '"' : ''; ?>
                    <?= $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>
                >
                    <?= esc_html((string) $button_text); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($image_url): ?>
            <div class="section3__image">
                <div class="section3__image-wrapper">
                    <img
                        src="<?= esc_url($image_url); ?>"
                        alt="<?= esc_attr($image_alt); ?>"
                        loading="eager"
                    >
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
