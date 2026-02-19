<?php

declare(strict_types=1);

/**
 * Archive template for news posts
 * This is an alternative template that can be used for custom news archives
 * Note: WordPress uses home.php for the main posts index by default
 */

get_header();

$page_title = __('News', 'miele-support');
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
