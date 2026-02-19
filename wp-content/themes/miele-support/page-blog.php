<?php

declare(strict_types=1);

/**
 * Template Name: Blog
 *
 * Page template for displaying blog posts/news.
 *
 * SETUP INSTRUCTIONS:
 * 1. Create a new page in WordPress admin (Pages → Add New)
 * 2. Title: "Blog"
 * 3. Slug: "blog"
 * 4. In Page Attributes, select "Blog" as the template
 * 5. Publish
 *
 * Once created, the Blog menu item in offcanvas__block--primary
 * will automatically link to /blog/
 */

get_header();

// Query posts for the blog page
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$blog_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$page_title = get_the_title();
if (empty($page_title)) {
    $page_title = __('Blog', 'miele-support');
}
?>

<main class="news-archive">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <header class="news-archive__header">
            <h1 class="news-archive__title"><?php echo esc_html($page_title); ?></h1>
        </header>

        <?php if ($blog_query->have_posts()) : ?>
            <div class="news-archive__grid">
                <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                    <?php get_template_part('template-parts/post/news-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            $big = 999999999;
            echo paginate_links([
                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'    => '?paged=%#%',
                'current'   => max(1, $paged),
                'total'     => $blog_query->max_num_pages,
                'prev_text' => __('Previous', 'miele-support'),
                'next_text' => __('Next', 'miele-support'),
            ]);
            ?>

        <?php else : ?>
            <div class="news-archive__empty">
                <p><?php _e('No news articles found.', 'miele-support'); ?></p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</main>

<?php get_footer(); ?>
