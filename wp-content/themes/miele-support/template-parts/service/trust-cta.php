<?php

declare(strict_types=1);

/**
 * Service Trust CTA Section
 * Template part: template-parts/service/trust-cta.php
 */

$cta_title = '';
$cta_subtitle = '';
$cta_button_text = '';
$cta_button_link = '';
$cta_button_target = '';

$page_sections = get_field('page_sections', 'option');

if (!empty($page_sections) && is_array($page_sections)) {
    foreach ($page_sections as $section) {
        if (($section['acf_fc_layout'] ?? '') === 'section5') {
            $cta_title = $section['title'] ?? '';
            $cta_subtitle = $section['subtitle'] ?? '';
            $cta_button_text = $section['button_text'] ?? '';
            $cta_button_link = $section['button_link']['url'] ?? '';
            $cta_button_target = $section['button_link']['target'] ?? '';
            break;
        }
    }
}

if (!$cta_title) {
    $cta_title = 'Trusted Miele Repair Experts';
}

if (!$cta_subtitle) {
    $cta_subtitle = 'Certified technicians, genuine parts, and transparent pricing. We fix Miele appliances right the first time.';
}

if (!$cta_button_text) {
    $cta_button_text = 'Book Online';
}

if (!$cta_button_link) {
    $cta_button_link = '/book-online/';
}

$trust_points = [
    [
        'value' => '20+ Years',
        'label' => 'Specialized Miele service experience',
    ],
    [
        'value' => '10k+ Repairs',
        'label' => 'Successful appliance fixes completed',
    ],
    [
        'value' => 'Up to 2-Year',
        'label' => 'Warranty on parts and labor',
    ],
];

$phone_label = '+1 347 894 7974';
$phone_link = 'tel:+13478947974';

?>

<section class="service-trust-cta">
    <div class="container">
        <div class="service-trust-cta__content">
            <div class="service-trust-cta__text">
                <?php if ($cta_title) : ?>
                    <h2 class="service-trust-cta__title"><?php echo esc_html($cta_title); ?></h2>
                <?php endif; ?>
                <?php if ($cta_subtitle) : ?>
                    <p class="service-trust-cta__subtitle"><?php echo esc_html($cta_subtitle); ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($trust_points)) : ?>
                <div class="service-trust-cta__stats">
                    <?php foreach ($trust_points as $point) : ?>
                        <div class="service-trust-cta__stat">
                            <span class="service-trust-cta__stat-value"><?php echo esc_html($point['value']); ?></span>
                            <span class="service-trust-cta__stat-label"><?php echo esc_html($point['label']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="service-trust-cta__actions">
                <?php if ($cta_button_text && $cta_button_link) : ?>
                    <a href="<?php echo esc_url($cta_button_link); ?>" class="btn btn--primary" <?php echo $cta_button_target ? 'target="' . esc_attr($cta_button_target) . '"' : ''; ?>>
                        <?php echo esc_html($cta_button_text); ?>
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url($phone_link); ?>" class="btn btn--outline">
                    Call <?php echo esc_html($phone_label); ?>
                </a>
            </div>
        </div>
    </div>
</section>
