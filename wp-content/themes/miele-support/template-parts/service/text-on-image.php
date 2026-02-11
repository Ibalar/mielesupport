<?php

declare(strict_types=1);

/**
 * Text on image section for level 1 service pages
 */

$section_data = get_query_var('section_data', []);

$title = (string) ($section_data['title'] ?? '');
$description = (string) ($section_data['description'] ?? $section_data['text'] ?? '');
$background = $section_data['background_image'] ?? $section_data['image'] ?? [];
$button_text = (string) ($section_data['button_text'] ?? $section_data['button_label'] ?? '');
$button_link = $section_data['button_link'] ?? $section_data['link'] ?? [];

$background_url = '';
$background_alt = '';

if (is_array($background) && !empty($background['url'])) {
    $background_url = (string) $background['url'];
    $background_alt = (string) ($background['alt'] ?? ($background['title'] ?? ''));
} elseif (is_string($background)) {
    $background_url = $background;
}

$link_url = '';
$link_target = '';

if (is_array($button_link) && !empty($button_link['url'])) {
    $link_url = (string) $button_link['url'];
    $link_target = (string) ($button_link['target'] ?? '');
} elseif (is_string($button_link)) {
    $link_url = $button_link;
}

if ($title === '' && $description === '') {
    return;
}

?>

<section class="service-text-on-image">
    <?php if ($background_url): ?>
        <div class="service-text-on-image__background">
            <img
                src="<?php echo esc_url($background_url); ?>"
                alt="<?php echo esc_attr($background_alt); ?>"
                loading="lazy"
            >
            <div class="service-text-on-image__overlay"></div>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="service-text-on-image__content">
            <?php if ($title): ?>
                <h2 class="service-text-on-image__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($description): ?>
                <div class="service-text-on-image__description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>

            <?php if ($button_text && $link_url): ?>
                <a
                    href="<?php echo esc_url($link_url); ?>"
                    class="btn btn--primary service-text-on-image__button"
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
