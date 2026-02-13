<?php

declare(strict_types=1);

/**
 * Service Pricing Table Section - Flexible Content Version
 * Template part: template-parts/service/pricing-flexible.php
 */

$section_data = get_query_var('section_data', []);

$price_items = $section_data['price_items'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'Service Pricing';
$section_subtitle = $section_data['subtitle'] ?? '';

$rows = [];

if (!empty($price_items) && is_array($price_items)) {
    foreach ($price_items as $item) {
        $repair_part = trim((string) ($item['repair_part'] ?? ''));
        $typical_symptoms = trim((string) ($item['typical_symptoms'] ?? ''));
        $turnaround = trim((string) ($item['turnaround'] ?? ''));
        $price_from = trim((string) ($item['price_from'] ?? ''));

        if ($repair_part === '' && $typical_symptoms === '' && $turnaround === '' && $price_from === '') {
            continue;
        }

        $rows[] = [
            'repair_part' => $repair_part,
            'typical_symptoms' => $typical_symptoms,
            'turnaround' => $turnaround,
            'price_from' => $price_from,
        ];
    }
}

if (empty($rows)) {
    return;
}

?>

<section class="service-pricing-table">
    <div class="service-pricing-table__container">
        <div class="service-pricing-table__header">
            <h2 class="service-pricing-table__title"><?php echo esc_html($section_title); ?></h2>
            <?php if (!empty($section_subtitle)) : ?>
                <p class="service-pricing-table__subtitle">
                    <?php echo esc_html($section_subtitle); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="service-pricing-table__table-wrapper">
            <table class="service-pricing-table__table">
                <thead>
                    <tr>
                        <th class="service-pricing-table__head service-pricing-table__head--repair">Repair/Part</th>
                        <th class="service-pricing-table__head service-pricing-table__head--symptoms">Typical Symptoms</th>
                        <th class="service-pricing-table__head service-pricing-table__head--turnaround">Turnaround*</th>
                        <th class="service-pricing-table__head service-pricing-table__head--price">Price (from)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr class="service-pricing-table__row">
                            <td class="service-pricing-table__cell service-pricing-table__cell--repair">
                                <?php echo $row['repair_part'] !== '' ? esc_html($row['repair_part']) : '—'; ?>
                            </td>
                            <td class="service-pricing-table__cell service-pricing-table__cell--symptoms">
                                <?php echo $row['typical_symptoms'] !== '' ? esc_html($row['typical_symptoms']) : '—'; ?>
                            </td>
                            <td class="service-pricing-table__cell service-pricing-table__cell--turnaround">
                                <?php echo $row['turnaround'] !== '' ? esc_html($row['turnaround']) : '—'; ?>
                            </td>
                            <td class="service-pricing-table__cell service-pricing-table__cell--price">
                                <?php echo $row['price_from'] !== '' ? esc_html($row['price_from']) : '—'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
