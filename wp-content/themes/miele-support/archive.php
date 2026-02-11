<?php

declare(strict_types=1);

/**
 * Archive template for services and other post types
 */

get_header();

$post_type = get_post_type();
$post_type_obj = get_post_type_object($post_type);
$post_type_name = $post_type_obj ? $post_type_obj->label : __('Archive', 'miele-support');
?>

<main class="archive-page archive-page--<?php echo esc_attr($post_type); ?>">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <div class="archive-page__header">
            <h1 class="archive-page__title">
                <?php
                if (is_post_type_archive('service')) {
                    _e('All Services', 'miele-support');
                } else {
                    post_type_archive_title();
                }
                ?>
            </h1>
        </div>

        <?php if (have_posts()) : ?>
            <div class="archive-page__content">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="archive-page__item">
                        <h2 class="archive-page__item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <?php if (has_excerpt()) : ?>
                            <div class="archive-page__item-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination([
                'prev_text' => __('Previous', 'miele-support'),
                'next_text' => __('Next', 'miele-support'),
            ]); ?>

        <?php else : ?>
            <div class="archive-page__empty">
                <p><?php _e('No items found.', 'miele-support'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
