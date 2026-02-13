<?php

declare(strict_types=1);

/**
 * Service Secondary CTA Section - Flexible Content Version
 * Template part: template-parts/service/cta-secondary-flexible.php
 */

$section_data = get_query_var('section_data', []);

$show_booking = $section_data['show_booking'] ?? true;
$booking_link = $section_data['booking_link'] ?? '';
$show_phone = $section_data['show_phone'] ?? true;

// Only show if at least one option is enabled
if (!$show_booking && !$show_phone) {
    return;
}

$phone_label = '+1 347 894 7974';
$phone_link = 'tel:+13478947974';

$booking_label = 'Book Online';
$booking_label_default = '/book-online/';

// Get title and subtitle from flexible content or use defaults from options
$title = !empty($section_data['cta_secondary_title']) ? $section_data['cta_secondary_title'] : (get_field('cta_secondary_title', 'option') ?: 'Ready to Get Your Miele Appliance Fixed?');
$subtitle = !empty($section_data['cta_secondary_subtitle']) ? $section_data['cta_secondary_subtitle'] : (get_field('cta_secondary_subtitle', 'option') ?: 'Fast, reliable repair service by certified Miele technicians. Same-day service available.');

// Get background image
$bg_image = $section_data['bg_image'] ?? '';
$bg_image_url = '';
$bg_style = '';

if (!empty($bg_image) && is_array($bg_image)) {
    $bg_image_url = $bg_image['url'] ?? '';
    if (!empty($bg_image_url)) {
        $bg_style = 'background-image: url(' . esc_url($bg_image_url) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
    }
}

?>

<section class="cta-secondary" <?php echo !empty($bg_style) ? 'style="' . esc_attr($bg_style) . '"' : ''; ?>>
    <div class="container">
        <div class="cta-secondary__content">
            <?php if ($title) : ?>
                <h2 class="cta-secondary__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($subtitle) : ?>
                <div class="cta-secondary__subtitle">
                    <?php 
                    // Output WYSIWYG content
                    if (is_string($subtitle)) {
                        echo wp_kses_post(wpautop($subtitle));
                    } else {
                        echo wp_kses_post($subtitle);
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="cta-secondary__actions">
                <?php if ($show_booking) : ?>
                    <a href="<?php echo esc_url($booking_link ?: $booking_label_default); ?>" class="btn btn--primary">
                        <?php echo esc_html($booking_label); ?>
                    </a>
                <?php endif; ?>

                <?php if ($show_phone) : ?>
                    <a href="<?php echo esc_url($phone_link); ?>" class="btn btn--outline">
                        Call <?php echo esc_html($phone_label); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>