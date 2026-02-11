<?php

declare(strict_types=1);

/**
 * Service Hero Section - Flexible Content Version
 * Template part: template-parts/service/flexible/hero.php
 */

$section_data = get_query_var('section_data', []);

// Extract all fields from section data with defaults
$eyebrow = $section_data['eyebrow'] ?? get_field('eyebrow');
$title = $section_data['title'] ?? get_field('title');
$show_title = $section_data['show_title'] ?? get_field('show_title');
$intro_text = $section_data['intro_text'] ?? get_field('intro_text');
$hero_image = $section_data['hero_image'] ?? get_field('hero_image');
$overlay_opacity = $section_data['overlay_opacity'] ?? get_field('overlay_opacity');
$content_align = $section_data['content_align'] ?? get_field('content_align');
$show_booking = $section_data['show_booking'] ?? get_field('show_booking');
$booking_link = $section_data['booking_link'] ?? get_field('booking_link');
$show_phone = $section_data['show_phone'] ?? get_field('show_phone');
$phone_number = $section_data['phone_number'] ?? get_field('phone_number');
$min_height = $section_data['min_height'] ?? get_field('min_height');
$custom_class = $section_data['custom_class'] ?? get_field('custom_class');

// Set defaults
$show_title = $show_title ?? true;
$show_booking = $show_booking ?? true;
$show_phone = $show_phone ?? true;
$overlay_opacity = $overlay_opacity ?? 50;
$content_align = $content_align ?? 'center';
$min_height = $min_height ?? 'large';

// Determine title to display
$display_title = $title ?: get_the_title();

// Build booking URL
$booking_url = $booking_link ?: '/book-online/';

// Build phone data
$phone_label = $phone_number ?: '+1 347 894 7974';
$phone_link = 'tel:' . preg_replace('/[^\d+]/', '', $phone_label);

// Hero image handling
$hero_image_url = '';
$hero_image_alt = '';

if (is_array($hero_image) && !empty($hero_image['url'])) {
    $hero_image_url = (string) $hero_image['url'];
    $hero_image_alt = (string) ($hero_image['alt'] ?? ($hero_image['title'] ?? ''));
} elseif (is_string($hero_image)) {
    $hero_image_url = $hero_image;
}

if (!$hero_image_url) {
    $hero_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    if ($hero_image_url) {
        $hero_image_alt = get_the_title();
    }
}

// Build CSS classes
$hero_classes = ['hero', 'hero--service'];

// Add min-height class
$height_map = [
    'small' => 'hero--small',
    'medium' => 'hero--medium',
    'large' => 'hero--large',
    'full' => 'hero--full'
];
if (isset($height_map[$min_height])) {
    $hero_classes[] = $height_map[$min_height];
}

// Add alignment class
$align_map = [
    'left' => 'hero--align-left',
    'center' => 'hero--align-center',
    'right' => 'hero--align-right'
];
if (isset($align_map[$content_align])) {
    $hero_classes[] = $align_map[$content_align];
}

// Add custom classes
if (!empty($custom_class)) {
    $custom_classes = explode(' ', $custom_class);
    $hero_classes = array_merge($hero_classes, $custom_classes);
}

$hero_class_string = implode(' ', array_map('esc_attr', $hero_classes));

// Calculate overlay opacity for inline style
$overlay_style = '';
if ($overlay_opacity !== 50) {
    $opacity_value = $overlay_opacity / 100;
    $overlay_style = ' style="opacity: ' . esc_attr($opacity_value) . ';"';
}

?>

<section class="<?php echo $hero_class_string; ?>">
    <div class="hero__bg">
        <?php if ($hero_image_url) : ?>
            <img
                src="<?php echo esc_url($hero_image_url); ?>"
                alt="<?php echo esc_attr($hero_image_alt); ?>"
                loading="eager"
            >
        <?php endif; ?>
    </div>

    <div class="hero__overlay"<?php echo $overlay_style; ?>></div>

    <div class="container">
        <div class="hero__content">
            <?php if (!empty($eyebrow)) : ?>
                <span class="hero__eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>

            <?php if ($show_title) : ?>
                <h1 class="hero__title"><?php echo esc_html($display_title); ?></h1>
            <?php endif; ?>

            <?php if (!empty($intro_text)) : ?>
                <div class="hero__text">
                    <?php echo wp_kses_post($intro_text); ?>
                </div>
            <?php endif; ?>

            <?php if ($show_booking || $show_phone) : ?>
                <div class="hero__actions">
                    <?php if ($show_booking) : ?>
                        <a href="<?php echo esc_url($booking_url); ?>" class="btn btn--primary">
                            Easy Online Booking
                        </a>
                    <?php endif; ?>
                    <?php if ($show_phone) : ?>
                        <a href="<?php echo esc_url($phone_link); ?>" class="btn btn--outline">
                            SERVICE LINE: <?php echo esc_html($phone_label); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
