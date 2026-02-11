<?php

declare(strict_types=1);

/**
 * Service Hero Section - Flexible Content Version
 * Template part: template-parts/service/flexible/hero.php
 */

$section_data = get_query_var('section_data', []);

$intro_text = $section_data['intro_text'] ?? get_field('intro_text');
$show_booking = $section_data['show_booking'] ?? get_field('show_booking');
$booking_link = $section_data['booking_link'] ?? get_field('booking_link');
$show_phone = $section_data['show_phone'] ?? get_field('show_phone');

$show_booking = $show_booking ?? true;
$show_phone = $show_phone ?? true;

$booking_url = $booking_link ?: '/book-online/';
$phone_label = '+1 347 894 7974';
$phone_link = 'tel:+13478947974';

?>

<section class="service-hero">
    <h1><?php the_title(); ?></h1>

    <?php if (!empty($intro_text)) : ?>
        <div class="service-intro">
            <?php echo wp_kses_post($intro_text); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_booking || $show_phone) : ?>
        <div class="service-hero__actions">
            <?php if ($show_booking) : ?>
                <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-primary">Easy Online Booking</a>
            <?php endif; ?>
            <?php if ($show_phone) : ?>
                <a href="<?php echo esc_url($phone_link); ?>" class="btn btn-outline">
                    SERVICE LINE: <?php echo esc_html($phone_label); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
