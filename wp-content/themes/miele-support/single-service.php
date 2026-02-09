
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
// Хлебные крошки
get_template_part('template-parts/global/breadcrumbs');

// HERO
get_template_part('template-parts/service/hero');

// Вывод шаблонов в зависимости от уровня иерархии
if ($level === 1) {
    // Уровень 1: Категория - показать подкатегории (типы приборов)
    // category-grid будет создан в задаче 3
    // get_template_part('template-parts/service/category-grid');
    get_template_part('template-parts/service/children-grid');

} elseif ($level === 2) {
    // Уровень 2: Тип прибора - показать конечные услуги
    get_template_part('template-parts/service/children-grid');

} else {
    // Уровень 3: Конечная услуга - показать все секции
    get_template_part('template-parts/service/advantages');
    get_template_part('template-parts/service/models');
    get_template_part('template-parts/service/issues');
    get_template_part('template-parts/service/pricing-table');
    get_template_part('template-parts/service/cta-secondary');
    get_template_part('template-parts/service/error-codes');
    get_template_part('template-parts/service/reviews');
    get_template_part('template-parts/service/areas');
    get_template_part('template-parts/service/trust-cta');
}

?>

</main>

<?php get_footer(); ?>
