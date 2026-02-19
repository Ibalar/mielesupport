<?php

declare(strict_types=1);

/**
 * News archive template (blog posts index)
 * This template is used for the main blog posts page
 */

get_header();

$page_for_posts = get_option('page_for_posts');
$page_title = $page_for_posts ? get_the_title($page_for_posts) : __('Latest News', 'miele-support');
?>

<main class="news-archive">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <header class="news-archive__header">
            <h1 class="news-archive__title"><?php echo esc_html($page_title); ?></h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="news-archive__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post/news-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination([
                'prev_text' => __('Previous', 'miele-support'),
                'next_text' => __('Next', 'miele-support'),
            ]); ?>

        <?php else : ?>
            <div class="news-archive__empty">
                <p><?php _e('No news articles found.', 'miele-support'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
