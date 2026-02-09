<?php declare(strict_types=1);

/**
 * Service Areas Block with Map
 * 
 * @var array $args {
 *     @type string $title       Заголовок
 *     @type string $subtitle    Подзаголовок
 *     @type string $areas_list  Список районов (построчно)
 *     @type string $map_embed   iframe код карты
 * }
 */

$title = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$areas_list = $args['areas_list'] ?? '';
$map_embed = $args['map_embed'] ?? '';

// Разрешенные теги и атрибуты для iframe (Google Maps)
$allowed_iframe = [
    'iframe' => [
        'src'             => [],
        'width'           => [],
        'height'          => [],
        'frameborder'     => [],
        'style'           => [],
        'allowfullscreen' => [],
        'loading'         => [],
        'referrerpolicy'  => [],
        'title'           => [],
    ],
];

// Преобразовать список в массив и отсортировать
$areas = [];
if ($areas_list) {
    $areas = array_filter(array_map('trim', explode("\n", $areas_list)));
    sort($areas, SORT_STRING | SORT_FLAG_CASE); // Алфавитная сортировка
}

?>

<section class="service-areas">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="service-areas__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($subtitle) : ?>
            <p class="service-areas__subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <?php if (!empty($areas)) : ?>
            <ul class="service-areas__list">
                <?php foreach ($areas as $area) : ?>
                    <li class="service-areas__item"><?php echo esc_html($area); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($map_embed) : ?>
            <div class="service-areas__map">
                <div class="service-areas__map-container">
                    <?php echo wp_kses($map_embed, $allowed_iframe); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>