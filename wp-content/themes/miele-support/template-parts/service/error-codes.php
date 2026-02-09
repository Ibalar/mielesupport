<?php

declare(strict_types=1);

/**
 * Service Error Codes Section
 * Template part: template-parts/service/error-codes.php
 */

$raw_error_codes = get_field('error_codes');

if (empty($raw_error_codes) || !is_array($raw_error_codes)) {
    $raw_error_codes = get_field('faq');
}

$error_codes = [];

if (!empty($raw_error_codes) && is_array($raw_error_codes)) {
    foreach ($raw_error_codes as $item) {
        $code = $item['code'] ?? '';
        $title = $item['title'] ?? '';
        $summary = $item['question'] ?? '';
        $description = $item['description'] ?? ($item['answer'] ?? '');

        $summary_text = $summary ?: trim((string) $code . ' ' . (string) $title);
        $label_text = $title ?: $summary_text;

        if (!$summary_text || !$description) {
            continue;
        }

        $error_codes[] = [
            'code' => (string) $code,
            'label' => (string) $label_text,
            'summary' => (string) $summary_text,
            'description' => (string) $description,
        ];
    }
}

if (empty($error_codes)) {
    $error_codes = [
        [
            'code' => 'F11',
            'label' => 'Drainage fault',
            'summary' => 'Drainage fault',
            'description' => 'Water is not draining correctly. Check the filter and drain pump for blockages or schedule a professional cleaning.',
        ],
        [
            'code' => 'F02',
            'label' => 'Temperature sensor issue',
            'summary' => 'Temperature sensor issue',
            'description' => 'The appliance is detecting irregular temperature readings. We test sensors, recalibrate, and replace faulty parts.',
        ],
        [
            'code' => 'F53',
            'label' => 'Motor or drive error',
            'summary' => 'Motor or drive error',
            'description' => 'The motor is not reaching the correct speed. A technician can inspect the belt, motor brushes, and control board.',
        ],
        [
            'code' => 'F78',
            'label' => 'Circulation pump problem',
            'summary' => 'Circulation pump problem',
            'description' => 'Circulation pump performance is reduced. We diagnose circulation, clean filters, and replace the pump if needed.',
        ],
        [
            'code' => 'F66',
            'label' => 'Heating element fault',
            'summary' => 'Heating element fault',
            'description' => 'Heating element is not warming as expected. Our team tests the heater and restores proper heating performance.',
        ],
        [
            'code' => 'F12',
            'label' => 'Water intake issue',
            'summary' => 'Water intake issue',
            'description' => 'Insufficient water supply detected. We check valves, hoses, and inlet filters to restore proper flow.',
        ],
    ];
}

if (empty($error_codes)) {
    return;
}

?>

<section class="service-error-codes">
    <div class="service-error-codes__container">
        <div class="service-error-codes__header">
            <h2 class="service-error-codes__title">Common Error Codes</h2>
            <p class="service-error-codes__subtitle">
                Quick troubleshooting references for Miele appliances. If you see one of these codes, our certified team can help.
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
