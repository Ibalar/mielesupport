<?php
declare(strict_types=1);

/**
 * Template Name: All Services
 * Displays all services in a nested accordion structure
 * Level 1: Categories -> Level 2: Appliance Types -> Level 3: Final Services
 */

get_header();

// Get all level 1 services (categories - no parent)
$categories = get_posts([
    'post_type' => 'service',
    'post_parent' => 0,
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1,
]);
?>

<main class="services-page">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <div class="services-page__header">
            <h1 class="services-page__title">All Services</h1>
            <p class="services-page__description">
                Browse our complete range of Miele appliance repair and maintenance services. 
                Click on a category to explore available services for your specific appliance.
            </p>
        </div>

        <?php if ($categories): ?>
            <div class="services-accordion">
                <?php foreach ($categories as $category): 
                    // Get level 2 children (appliance types)
                    $appliance_types = get_children([
                        'post_type' => 'service',
                        'post_parent' => $category->ID,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ]);

                    if (empty($appliance_types)) {
                        continue;
                    }
                    ?>
                    <div class="services-accordion__item" data-services-accordion-item>
                        <button class="services-accordion__header" type="button" aria-expanded="false">
                            <span class="services-accordion__title"><?php echo esc_html($category->post_title); ?></span>
                            <span class="services-accordion__icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </button>
                        <div class="services-accordion__content">
                            <div class="services-accordion__inner">
                                <?php foreach ($appliance_types as $appliance_type): 
                                    // Get level 3 children (final services)
                                    $final_services = get_children([
                                        'post_type' => 'service',
                                        'post_parent' => $appliance_type->ID,
                                        'orderby' => 'title',
                                        'order' => 'ASC',
                                    ]);
                                    ?>
                                    <div class="services-accordion__sub-item">
                                        <h3 class="services-accordion__sub-title">
                                            <?php echo esc_html($appliance_type->post_title); ?>
                                        </h3>
                                        <?php if ($final_services): ?>
                                            <ul class="services-accordion__services-list">
                                                <?php foreach ($final_services as $service): ?>
                                                    <li class="services-accordion__service-item">
                                                        <a href="<?php echo esc_url(get_permalink($service->ID)); ?>" class="services-accordion__service-link">
                                                            <?php echo esc_html($service->post_title); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="services-page__empty">
                <p>No services available at this time.</p>
            </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <div class="services-page__cta">
            <h2 class="services-page__cta-title">Can't find what you're looking for?</h2>
            <p class="services-page__cta-text">
                Contact us for custom solutions or urgent repairs. Our expert technicians are ready to help.
            </p>
            <a href="/contacts/" class="services-page__cta-button">
                Contact Us
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
