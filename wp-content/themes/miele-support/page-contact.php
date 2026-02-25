<?php

declare(strict_types=1);

/**
 * Template Name: Contact
 * Contact page template with Hero section, breadcrumbs, contact form placeholder, and contact info blocks
 */

get_header();

// Get ACF fields with defaults
$hero_title = get_field('hero_title') ?: 'Contact Us';
$hero_bg_image = get_field('hero_bg_image');
$service_line = get_field('service_line') ?: '+1 (929) 351 32 30';
$hours_mon_fri = get_field('hours_mon_fri') ?: '8:00 AM - 6:00 PM';
$hours_saturday = get_field('hours_saturday') ?: '9:00 AM - 4:00 PM';

// Hero background image URL - handle different return formats
$hero_bg_url = '';
if ($hero_bg_image) {
    if (is_array($hero_bg_image) && !empty($hero_bg_image['url'])) {
        // Return format is 'array'
        $hero_bg_url = $hero_bg_image['url'];
    } elseif (is_string($hero_bg_image)) {
        // Return format is 'url' or 'id'
        $hero_bg_url = $hero_bg_image;
    }
}

// Build inline style for background image
$hero_style = '';
if ($hero_bg_url) {
    $hero_style = ' style="background-image: url(\'' . esc_url($hero_bg_url) . '\');"';
}
?>

<main class="page-content page-content--contact">
    <!-- Hero Section -->
    <section class="news-hero"<?php echo $hero_style; ?>>
        <div class="news-hero__overlay"></div>
        <div class="container">
            <div class="news-hero__content">
                <h1 class="news-hero__title"><?php echo esc_html($hero_title); ?></h1>
            </div>
        </div>
    </section>

    <!-- Breadcrumbs -->
    <div class="container">
        <?php if (function_exists('render_breadcrumbs')) : ?>
            <?php render_breadcrumbs(); ?>
        <?php endif; ?>
    </div>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-form-section__inner">
                <?php get_template_part('template-parts/contact/form'); ?>
            </div>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info-section">
        <div class="container">
            <div class="contact-info-grid">
                <!-- Block 1: Custom Service -->
                <div class="contact-info-block">
                    <h2 class="contact-info-block__label">CUSTOM SERVICE:</h2>
                    <div class="contact-info-block__content">
                        <p class="contact-info-block__line">
                            <span class="contact-info-block__prefix">SERVICE LINE:</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $service_line)); ?>" class="contact-info-block__value">
                                <?php echo esc_html($service_line); ?>
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Block 2: Hours of Work -->
                <div class="contact-info-block">
                    <h2 class="contact-info-block__label">HOURS OF WORK:</h2>
                    <div class="contact-info-block__content">
                        <p class="contact-info-block__line">
                            <span class="contact-info-block__prefix">MON TO FRI:</span>
                            <span class="contact-info-block__value"><?php echo esc_html($hours_mon_fri); ?></span>
                        </p>
                        <p class="contact-info-block__line">
                            <span class="contact-info-block__prefix">SATURDAY:</span>
                            <span class="contact-info-block__value"><?php echo esc_html($hours_saturday); ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Page Content -->
    <section class="contact-page-content">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article class="contact-page-content__article">
                    <div class="contact-page-content__body">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>