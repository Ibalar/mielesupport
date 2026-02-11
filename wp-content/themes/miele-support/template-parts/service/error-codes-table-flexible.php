<?php

declare(strict_types=1);

/**
 * Service Error Codes Section - Table Layout (Flexible Content Version)
 * Template part: template-parts/service/error-codes-table-flexible.php
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

<section class="error-codes-table">
    <div class="error-codes-table__container">
        <div class="error-codes-table__header">
            <h2 class="error-codes-table__title"><?php echo esc_html($section_title); ?></h2>
            <p class="error-codes-table__subtitle">
                <?php echo esc_html($section_subtitle); ?>
            </p>
        </div>

        <div class="error-codes-table__wrapper">
            <table class="error-codes-table__table">
                <thead>
                    <tr>
                        <th class="error-codes-table__code-col">Error Code</th>
                        <th class="error-codes-table__issue-col">Issue</th>
                        <th class="error-codes-table__description-col">Description & Solution</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($error_codes as $item) : ?>
                        <tr class="error-codes-table__row">
                            <td class="error-codes-table__code-cell">
                                <?php if (!empty($item['code'])) : ?>
                                    <span class="error-codes-table__code"><?php echo esc_html($item['code']); ?></span>
                                <?php else: ?>
                                    <span class="error-codes-table__code-placeholder">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="error-codes-table__issue-cell">
                                <strong><?php echo esc_html($item['label']); ?></strong>
                            </td>
                            <td class="error-codes-table__description-cell">
                                <?php echo wp_kses_post($item['description']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="error-codes-table__footer">
            <div class="error-codes-table__cta-box">
                <div class="error-codes-table__cta-content">
                    <h3 class="error-codes-table__cta-title">Need Help With an Error Code?</h3>
                    <p class="error-codes-table__cta-text">
                        Our certified technicians are ready to diagnose and fix your Miele appliance.
                    </p>
                </div>
                <div class="error-codes-table__cta-actions">
                    <a href="#contact-form" class="error-codes-table__cta-button">
                        Schedule Repair
                        <svg class="error-codes-table__cta-arrow" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="tel:+13478947974" class="error-codes-table__cta-phone">
                        <svg class="error-codes-table__phone-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        Call: +1 347 894 7974
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
