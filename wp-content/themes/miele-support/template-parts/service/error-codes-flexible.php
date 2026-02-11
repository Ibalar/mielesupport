<?php

declare(strict_types=1);

/**
 * Service Error Codes Section - Flexible Content Version
 * Template part: template-parts/service/error-codes-flexible.php
 */

$section_data = get_query_var('section_data', []);

$raw_error_codes = $section_data['error_codes'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'Common Error Codes';
$section_subtitle = !empty($section_data['subtitle']) ? $section_data['subtitle'] : 'Quick troubleshooting references for Miele appliances. If you see one of these codes, our certified team can help.';

$error_codes = [];

if (!empty($raw_error_codes) && is_array($raw_error_codes)) {
    foreach ($raw_error_codes as $item) {
        $code = $item['code'] ?? '';
        $title = $item['title'] ?? '';
        $description = $item['description'] ?? '';

        $label_text = $title ?: $code;

        if (empty($description)) {
            continue;
        }

        $error_codes[] = [
            'code' => (string) $code,
            'label' => (string) $label_text,
            'description' => (string) $description,
        ];
    }
}

if (empty($error_codes)) {
    return;
}

?>

<section class="service-error-codes">
    <div class="service-error-codes__container">
        <div class="service-error-codes__header">
            <h2 class="service-error-codes__title"><?php echo esc_html($section_title); ?></h2>
            <p class="service-error-codes__subtitle">
                <?php echo esc_html($section_subtitle); ?>
            </p>
        </div>

        <div class="service-error-codes__list">
            <?php foreach ($error_codes as $item) : ?>
                <details class="service-error-codes__item">
                    <summary class="service-error-codes__summary">
                        <?php if (!empty($item['code'])) : ?>
                            <span class="service-error-codes__code"><?php echo esc_html($item['code']); ?></span>
                        <?php endif; ?>
                        <span class="service-error-codes__label"><?php echo esc_html($item['label']); ?></span>
                        <span class="service-error-codes__toggle" aria-hidden="true">+</span>
                    </summary>
                    <div class="service-error-codes__content">
                        <?php echo wp_kses_post($item['description']); ?>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
