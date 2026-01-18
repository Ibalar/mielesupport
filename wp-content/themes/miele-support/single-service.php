
get_header();

global $post;

// определяем уровень
$is_child = $post->post_parent > 0;
?>

<main class="service-page">

<?php
// Хлебные крошки
get_template_part('template-parts/global/breadcrumbs');

// HERO
get_template_part('template-parts/service/hero');

// если это КОНЕЧНАЯ страница
if ($is_child) {

    get_template_part('template-parts/service/advantages');
    get_template_part('template-parts/service/models');
    get_template_part('template-parts/service/issues');
    get_template_part('template-parts/service/pricing-table');
    get_template_part('template-parts/service/cta-secondary');
    get_template_part('template-parts/service/error-codes');
    get_template_part('template-parts/service/reviews');
    get_template_part('template-parts/service/areas');
    get_template_part('template-parts/service/trust-cta');

} else {

    // 3 уровень — каталог подтипов
    get_template_part('template-parts/service/children-grid');
    get_template_part('template-parts/service/emergency-form');
}

?>

</main>

<?php get_footer(); ?>
