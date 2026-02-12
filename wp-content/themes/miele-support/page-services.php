<?php

declare(strict_types=1);

/**
 * Template Name: Services Page
 * Displays service page sections from ACF options (Service Settings)
 */

get_header();

$service_sections = get_field('service_sections', 'option');

if (empty($service_sections)) {
    $service_sections = get_field('service_page_sections', 'option');
}

if (empty($service_sections)) {
    $service_sections = get_field('services_page_sections', 'option');
}

$hero_section = null;

if (!empty($service_sections) && is_array($service_sections)) {
    foreach ($service_sections as $section) {
        if (($section['acf_fc_layout'] ?? '') === 'service_hero') {
            $hero_section = $section;
            break;
        }
    }
}
?>

<main class="services-page">
    <?php
    if ($hero_section) {
        set_query_var('section_data', $hero_section);
        get_template_part('template-parts/service/flexible/hero');
    }

    render_breadcrumbs();
    ?>

    <?php if (!empty($service_sections) && is_array($service_sections)) : ?>
        <?php foreach ($service_sections as $section) :
            $layout = $section['acf_fc_layout'] ?? '';

            switch ($layout) {
                case 'service_hero':
                    break;

                case 'service_advantages':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/advantages-flexible');
                    break;

                case 'service_models':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/models-flexible');
                    break;

                case 'service_problems':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/problems-flexible');
                    break;

                case 'service_pricing_table':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/pricing-table-flexible');
                    break;

                case 'service_cta_secondary':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/cta-secondary-flexible');
                    break;

                case 'service_error_codes':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/error-codes-flexible');
                    break;

                case 'service_reviews':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/reviews-flexible');
                    break;

                case 'service_areas':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/areas-flexible');
                    break;

                case 'service_trust_cta':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/trust-cta-flexible');
                    break;

                case 'service_accent':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/flexible/accent');
                    break;

                case 'service_accent_with_buttons':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/flexible/accent_with_buttons');
                    break;

                case 'services_catalog':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/flexible/services-catalog');
                    break;

                case 'service_section3':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/flexible/section3');
                    break;
            }
        endforeach; ?>
    <?php else : ?>
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article class="page-content__article">
                    <header class="page-content__header">
                        <h1 class="page-content__title"><?php the_title(); ?></h1>
                    </header>

                    <div class="page-content__body">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
