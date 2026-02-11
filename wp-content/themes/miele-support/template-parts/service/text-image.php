<?php

declare(strict_types=1);

/**
 * Text + Image section for level 1 service pages
 */

$section_data = get_query_var('section_data', []);

$title = (string) ($section_data['title'] ?? '');
$description = (string) ($section_data['description'] ?? $section_data['text'] ?? '');
$image = $section_data['image'] ?? $section_data['media'] ?? [];
$button_text = (string) ($section_data['button_text'] ?? $section_data['button_label'] ?? '');
$button_link = $section_data['button_link'] ?? $section_data['link'] ?? [];

$image_url = '';
$image_alt = '';

if (is_array($image) && !empty($image['url'])) {
    $image_url = (string) $image['url'];
    $image_alt = (string) ($image['alt'] ?? ($image['title'] ?? ''));
} elseif (is_string($image)) {
    $image_url = $image;
}

$link_url = '';
$link_target = '';

if (is_array($button_link) && !empty($button_link['url'])) {
    $link_url = (string) $button_link['url'];
    $link_target = (string) ($button_link['target'] ?? '');
} elseif (is_string($button_link)) {
    $link_url = $button_link;
}

if ($title === '' && $description === '' && $image_url === '') {
    return;
}

?>

<section class="section6">
    <div class="section6__wrapper">
        <?php if ($image_url): ?>
            <div class="section6__image">
                <img
                    src="<?php echo esc_url($image_url); ?>"
                    alt="<?php echo esc_attr($image_alt); ?>"
                    loading="lazy"
                >
            </div>
        <?php endif; ?>

        <div class="section6__content">
            <?php if ($title): ?>
                <h2 class="section6__title">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($description): ?>
                <div class="section6__description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>

            <?php if ($button_text && $link_url): ?>
                <a
                    href="<?php echo esc_url($link_url); ?>"
                    class="btn btn--primary section6__button"
                    <?php if ($link_target): ?>
                        target="<?php echo esc_attr($link_target); ?>"
                    <?php endif; ?>
                >
                    <?php echo esc_html($button_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
