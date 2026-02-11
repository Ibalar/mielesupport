<?php

declare(strict_types=1);

/**
 * Service Trust CTA Section - Flexible Content Version
 * Template part: template-parts/service/trust-cta-flexible.php
 */

$section_data = get_query_var('section_data', []);

$cta_title = $section_data['title'] ?? 'Trusted Miele Repair Experts';
$cta_subtitle = $section_data['subtitle'] ?? 'Certified technicians, genuine parts, and transparent pricing. We fix Miele appliances right the first time.';
$button = $section_data['button_link'] ?? [];
$cta_button_text = $section_data['button_text'] ?? ($button['title'] ?? 'Book Online');
$cta_button_link = $button['url'] ?? '/book-online/';
$cta_button_target = $button['target'] ?? '';

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
