<?php
declare(strict_types=1);

/**
 * Archive Template for Services (Variant 1)
 * Displays all services in a hierarchical nested accordion structure
 * URL: /services/
 */

get_header();

// Get all level 1 services (categories - no parent)
$categories = get_posts([
    'post_type' => 'service',
    'post_parent' => 0,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => -1,
]);
?>

<main class="services-page services-page--archive">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <div class="services-page__header">
            <h1 class="services-page__title">
                <?php _e('All Services', 'miele-support'); ?>
            </h1>
            <p class="services-page__description">
                <?php _e('Browse our complete range of Miele appliance repair and maintenance services. Click on a category to explore available services for your specific appliance.', 'miele-support'); ?>
            </p>
        </div>

        <?php if ($categories): ?>
            <div class="services-accordion">
                <?php foreach ($categories as $category): 
                    // Get level 2 children (appliance types)
                    $appliance_types = get_posts([
                        'post_type' => 'service',
                        'post_parent' => $category->ID,
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'posts_per_page' => -1,
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
                                    $final_services = get_posts([
                                        'post_type' => 'service',
                                        'post_parent' => $appliance_type->ID,
                                        'orderby' => 'menu_order',
                                        'order' => 'ASC',
                                        'posts_per_page' => -1,
                                    ]);
                                    ?>
                                    <div class="services-accordion__sub-item">
                                        <h3 class="services-accordion__sub-title">
                                            <a href="<?php echo esc_url(get_permalink($appliance_type->ID)); ?>" class="services-accordion__sub-title-link">
                                                <?php echo esc_html($appliance_type->post_title); ?>
                                            </a>
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
                                        <?php else: ?>
                                            <p class="services-accordion__no-services">
                                                <a href="<?php echo esc_url(get_permalink($appliance_type->ID)); ?>" class="services-accordion__service-link">
                                                    <?php _e('View service details', 'miele-support'); ?>
                                                </a>
                                            </p>
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
                <p><?php _e('No services available at this time.', 'miele-support'); ?></p>
            </div>
        <?php endif; ?>

        <?php
        $service_sections = get_field('service_sections', 'option');

        if (empty($service_sections)) {
            $service_sections = get_field('service_page_sections', 'option');
        }

        if (empty($service_sections)) {
            $service_sections = get_field('services_page_sections', 'option');
        }

        if (!empty($service_sections) && is_array($service_sections)) {
            foreach ($service_sections as $section) {
                $layout = $section['acf_fc_layout'] ?? '';

                if ($layout === 'services_catalog') {
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/flexible/services-catalog');
                }

                if ($layout === 'catalog-description') {
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/flexible/catalog-description');
                }
            }
        }
        ?>

        <!-- CTA Section -->
        <div class="services-page__cta">
            <h2 class="services-page__cta-title">
                <?php _e("Can't find what you're looking for?", 'miele-support'); ?>
            </h2>
            <p class="services-page__cta-text">
                <?php _e('Contact us for custom solutions or urgent repairs. Our expert technicians are ready to help.', 'miele-support'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contacts/')); ?>" class="services-page__cta-button">
                <?php _e('Contact Us', 'miele-support'); ?>
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
