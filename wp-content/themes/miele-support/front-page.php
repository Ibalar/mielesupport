<?php get_header(); ?>

<main>
    <?php
    // Получить Flexible Content блоки для section5
    $page_sections = get_field('page_sections', 'option');

    get_template_part('template-parts/home/hero');
    get_template_part('template-parts/home/advantages');
    get_template_part('template-parts/home/section3');
    get_template_part('template-parts/home/home-catalog');
    
    // Вывести section5 и section6 блоки если есть
    if ($page_sections && is_array($page_sections)) {
        foreach ($page_sections as $section) {
            if ($section['acf_fc_layout'] === 'section5') {
                get_template_part(
                    'template-parts/blocks/section5',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'subtitle' => $section['subtitle'] ?? '',
                        'button_text' => $section['button_text'] ?? '',
                        'button_link' => $section['button_link'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'section6') {
                get_template_part(
                    'template-parts/blocks/section6',
                    null,
                    [
                        'image' => $section['image'] ?? [],
                        'title' => $section['title'] ?? '',
                        'description' => $section['description'] ?? '',
                        'button_text' => $section['button_text'] ?? '',
                        'button_link' => $section['button_link'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'home_slider') {
                get_template_part(
                    'template-parts/blocks/home-slider',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'subtitle' => $section['subtitle'] ?? '',
                        'slides' => $section['slides'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'faq') {
                get_template_part(
                    'template-parts/blocks/faq',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'description' => $section['description'] ?? '',
                        'faq_items' => $section['faq_items'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'reviews') {
                get_template_part(
                    'template-parts/blocks/reviews',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'subtitle' => $section['subtitle'] ?? '',
                        'reviews' => $section['reviews'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'advantages') {
                get_template_part(
                    'template-parts/blocks/advantages',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'subtitle' => $section['subtitle'] ?? '',
                        'items' => $section['items'] ?? [],
                        'bg' => $section['bg'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'section3') {
                get_template_part(
                    'template-parts/blocks/section3',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'description' => $section['description'] ?? '',
                        'items' => $section['items'] ?? [],
                        'button_text' => $section['button_text'] ?? '',
                        'button_link' => $section['button_link'] ?? [],
                        'image' => $section['image'] ?? [],
                        'bg' => $section['bg'] ?? []
                    ]
                );
            } elseif ($section['acf_fc_layout'] === 'service_areas') {
                get_template_part(
                    'template-parts/blocks/service-areas',
                    null,
                    [
                        'title' => $section['title'] ?? '',
                        'subtitle' => $section['subtitle'] ?? '',
                        'areas_list' => $section['areas_list'] ?? '',
                        'map_embed' => $section['map_embed'] ?? ''
                    ]
                );
            }
        }
    }
    ?>
</main>

<?php get_footer(); ?>
