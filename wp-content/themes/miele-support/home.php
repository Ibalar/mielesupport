<?php

declare(strict_types=1);

/**
 * News archive template (blog posts index)
 * This template is used for the main blog posts page
 */

get_header();

$page_for_posts = get_option('page_for_posts');
$page_title = $page_for_posts ? get_the_title($page_for_posts) : __('Latest News', 'miele-support');

// Get all tags used in posts for the filter
$all_tags = get_tags([
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
]);

// Get current tag from URL for active state
$current_tag_slug = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';
?>

<main class="news-archive">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <header class="news-archive__header">
            <h1 class="news-archive__title"><?php echo esc_html($page_title); ?></h1>
        </header>

        <?php if (!empty($all_tags)) : ?>
            <nav class="news-tags" aria-label="<?php esc_attr_e('Filter by tag', 'miele-support'); ?>">
                <ul class="news-tags__list">
                    <li class="news-tags__item">
                        <a href="<?php echo esc_url(remove_query_arg('tag')); ?>"
                           class="news-tags__link <?php echo empty($current_tag_slug) ? 'is-active' : ''; ?>"
                           data-tag="all"
                           aria-current="<?php echo empty($current_tag_slug) ? 'true' : 'false'; ?>">
                            <?php _e('All', 'miele-support'); ?>
                        </a>
                    </li>
                    <?php foreach ($all_tags as $tag) : ?>
                        <li class="news-tags__item">
                            <a href="<?php echo esc_url(add_query_arg('tag', $tag->slug)); ?>"
                               class="news-tags__link <?php echo $current_tag_slug === $tag->slug ? 'is-active' : ''; ?>"
                               data-tag="<?php echo esc_attr($tag->slug); ?>"
                               aria-current="<?php echo $current_tag_slug === $tag->slug ? 'true' : 'false'; ?>">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <div class="news-archive__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    // Get post tags for data attribute
                    $post_tags = get_the_tags();
                    $tag_slugs = [];
                    if ($post_tags) {
                        foreach ($post_tags as $post_tag) {
                            $tag_slugs[] = $post_tag->slug;
                        }
                    }
                    $tags_data = implode(',', $tag_slugs);
                    ?>
                    <article <?php post_class('news-card'); ?> data-tags="<?php echo esc_attr($tags_data); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="news-card__image">
                                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>

                                <?php if (has_category()) : ?>
                                    <span class="news-card__category">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            echo esc_html($categories[0]->name);
                                        }
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h2 class="news-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <?php if (has_excerpt()) : ?>
                                <div class="news-archive__excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="news-card__link">
                                <a href="<?php the_permalink(); ?>" class="news-card__read-more">
                                    <?php _e('Read more', 'miele-support'); ?>
                                </a>
                            </div>
                        </div>
                    </article>
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
