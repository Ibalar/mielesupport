<?php

declare(strict_types=1);

/**
 * Service Secondary CTA Section
 * Template part: template-parts/service/cta-secondary.php
 */

$show_booking = get_field('show_booking');
$booking_link = get_field('booking_link');
$show_phone = get_field('show_phone');

// Only show if at least one option is enabled
if (!$show_booking && !$show_phone) {
    return;
}

$phone_label = '+1 347 894 7974';
$phone_link = 'tel:+13478947974';

$booking_label = 'Book Online';
$booking_label_default = '/book-online/';

?>

<section class="cta-secondary">
    <div class="container">
        <div class="cta-secondary__content">
            <?php
            $title = get_field('cta_secondary_title', 'option') ?: 'Ready to Get Your Miele Appliance Fixed?';
            $subtitle = get_field('cta_secondary_subtitle', 'option') ?: 'Fast, reliable repair service by certified Miele technicians. Same-day service available.';
            ?>
            
            <?php if ($title) : ?>
                <h2 class="cta-secondary__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if ($subtitle) : ?>
                <p class="cta-secondary__subtitle"><?php echo esc_html($subtitle); ?></p>
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