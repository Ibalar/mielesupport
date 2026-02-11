<?php

get_header();

global $post;

// Определяем уровень иерархии
$has_parent = $post->post_parent > 0;
$children = get_children([
    'post_type' => 'service',
    'post_parent' => get_the_ID(),
]);
$has_children = !empty($children);

// Уровень 1: Категория (нет родителя, есть дети)
// Уровень 2: Тип прибора (есть родитель, есть дети)
// Уровень 3: Конечная услуга (есть родитель, нет детей)
if (!$has_parent && $has_children) {
    $level = 1;
} elseif ($has_parent && $has_children) {
    $level = 2;
} else {
    $level = 3;
}
?>

<main class="service-page">

<?php
// Breadcrumbs - supports all hierarchy levels
render_breadcrumbs();

// HERO
get_template_part('template-parts/service/hero');

// Вывод шаблонов в зависимости от уровня иерархии
if ($level === 1) {
    // Уровень 1: Категория - показываем flexible sections или сетку подкатегорий
    $level1_sections = get_field('level1_sections');

    if (empty($level1_sections)) {
        $level1_sections = get_field('service_level1_sections');
    }

    if (empty($level1_sections)) {
        $level1_sections = get_field('service_sections_level1');
    }

    if (!empty($level1_sections) && is_array($level1_sections)) {
        foreach ($level1_sections as $section) {
            $layout = $section['acf_fc_layout'] ?? '';

            switch ($layout) {
                case 'subcategory_grid':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/subcategory-grid');
                    break;

                case 'text_image':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/text-image');
                    break;

                case 'text_on_image':
                    set_query_var('section_data', $section);
                    get_template_part('template-parts/service/text-on-image');
                    break;
            }
        }
    } else {
        get_template_part('template-parts/service/category-grid');
    }

} elseif ($level === 2) {
    // Уровень 2: Тип прибора - показать конечные услуги
    get_template_part('template-parts/service/children-grid');

} else {
    // Уровень 3: Конечная услуга - выводим flexible content секции
    $service_sections = get_field('service_sections');

    if (!empty($service_sections) && is_array($service_sections)) {
        // Выводим секции из flexible content
        foreach ($service_sections as $section) {
            $layout = $section['acf_fc_layout'] ?? '';

            switch ($layout) {
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

                case 'service_hero':
                    // Hero уже выведен выше, пропускаем
                    break;
            }
        }
    } else {
        // Fallback: выводим все секции по умолчанию
        get_template_part('template-parts/service/advantages');
        get_template_part('template-parts/service/models');
        get_template_part('template-parts/service/problems');
        get_template_part('template-parts/service/pricing-table');
        get_template_part('template-parts/service/cta-secondary');
        get_template_part('template-parts/service/error-codes');
        get_template_part('template-parts/service/reviews');
        get_template_part('template-parts/service/areas');
        get_template_part('template-parts/service/trust-cta');
    }
}

?>

</main>

<?php get_footer(); ?>
