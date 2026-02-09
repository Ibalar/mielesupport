<?php

declare(strict_types=1);

/**
 * Service Areas Section
 * Template part: template-parts/service/areas.php
 */

$areas_title = '';
$areas_subtitle = '';
$areas_list = '';

$page_sections = get_field('page_sections', 'option');

if (!empty($page_sections) && is_array($page_sections)) {
    foreach ($page_sections as $section) {
        if (($section['acf_fc_layout'] ?? '') === 'service_areas') {
            $areas_title = $section['title'] ?? '';
            $areas_subtitle = $section['subtitle'] ?? '';
            $areas_list = $section['areas_list'] ?? '';
            break;
        }
    }
}

if (!$areas_title) {
    $areas_title = 'Service Areas';
}

if (!$areas_subtitle) {
    $areas_subtitle = 'We provide fast, reliable Miele appliance repair across the entire metro area.';
}

$areas = [];
if ($areas_list) {
    $areas = array_filter(array_map('trim', explode("\n", (string) $areas_list)));
    $areas = array_values(array_unique($areas));
    sort($areas, SORT_STRING | SORT_FLAG_CASE);
}

if (empty($areas)) {
    $areas = [
        'Manhattan',
        'Brooklyn',
        'Queens',
        'Bronx',
        'Staten Island',
        'Long Island',
        'Jersey City',
        'Hoboken',
    ];
}

if (empty($areas)) {
    return;
}

?>

<section class="service-areas">
    <div class="container">
        <?php if ($areas_title) : ?>
            <h2 class="service-areas__title"><?php echo esc_html($areas_title); ?></h2>
        <?php endif; ?>

        <?php if ($areas_subtitle) : ?>
            <p class="service-areas__subtitle"><?php echo esc_html($areas_subtitle); ?></p>
        <?php endif; ?>

        <?php if (!empty($areas)) : ?>
            <ul class="service-areas__list">
                <?php foreach ($areas as $area) : ?>
                    <li class="service-areas__item"><?php echo esc_html($area); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
