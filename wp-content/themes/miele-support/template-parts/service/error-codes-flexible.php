<?php

declare(strict_types=1);

/**
 * Service Error Codes Section - Flexible Content Version
 * Template part: template-parts/service/error-codes-flexible.php
 */

$section_data = get_query_var('section_data', []);

$raw_error_codes = $section_data['error_codes'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'Common Error Codes';
$footnote = $section_data['footnote'] ?? '';

$error_codes = [];

if (!empty($raw_error_codes) && is_array($raw_error_codes)) {
    foreach ($raw_error_codes as $item) {
        $code = $item['code'] ?? '';
        $short_description = $item['short_description'] ?? '';
        $instructions = $item['instructions'] ?? '';
        $if_error_persists = $item['if_error_persists'] ?? '';

        if ($code === '' && $short_description === '' && $instructions === '' && $if_error_persists === '') {
            continue;
        }

        $error_codes[] = [
            'code' => (string) $code,
            'short_description' => (string) $short_description,
            'instructions' => (string) $instructions,
            'if_error_persists' => (string) $if_error_persists,
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
        </div>

        <div class="service-error-codes__table-wrapper">
            <table class="service-error-codes-table">
                <tbody>
                    <?php foreach ($error_codes as $item) : ?>
                        <tr class="service-error-codes-table__row">
                            <td class="service-error-codes-table__cell service-error-codes-table__cell--code">
                                <?php echo esc_html($item['code']); ?>
                            </td>
                            <td class="service-error-codes-table__cell">
                                <?php echo esc_html($item['short_description']); ?>
                            </td>
                            <td class="service-error-codes-table__cell service-error-codes-table__cell--instructions">
                                <?php echo wp_kses_post($item['instructions']); ?>
                            </td>
                            <td class="service-error-codes-table__cell service-error-codes-table__cell--if-persists">
                                <?php echo wp_kses_post($item['if_error_persists']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($footnote)) : ?>
            <div class="service-error-codes__footnote">
                <?php echo the_content($footnote); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
