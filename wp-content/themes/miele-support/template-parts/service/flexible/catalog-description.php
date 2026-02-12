<?php declare(strict_types=1);

/**
 * Service Flexible Content - Catalog Description
 */

$section_data = get_query_var('section_data', []);

$title = (string) ($section_data['title'] ?? '');
$description = (string) ($section_data['description'] ?? '');
$background = $section_data['background_image'] ?? [];

$background_url = '';
$background_alt = '';

if (is_array($background) && !empty($background['url'])) {
    $background_url = (string) $background['url'];
    $background_alt = (string) ($background['alt'] ?? ($background['title'] ?? ''));
} elseif (is_string($background)) {
    $background_url = $background;
}

if ($title === '' && $description === '' && $background_url === '') {
    return;
}
?>

<section class="catalog-description">
    <?php if ($background_url) : ?>
        <div class="catalog-description__background">
            <img
                src="<?php echo esc_url($background_url); ?>"
                alt="<?php echo esc_attr($background_alt); ?>"
                loading="lazy"
            >
        </div>
        <div class="catalog-description__overlay"></div>
    <?php endif; ?>

    <div class="container">
        <div class="catalog-description__content">
            <?php if ($title) : ?>
                <h2 class="catalog-description__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <div class="catalog-description__description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
