<?php

declare(strict_types=1);

/**
 * News card template part
 * Reusable component for displaying a news item in list/grid view
 */

$classes = ['news-card'];
if (!has_post_thumbnail()) {
    $classes[] = 'news-card--no-image';
}
?>

<article <?php post_class(implode(' ', $classes)); ?>>
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
            <div class="news-card__excerpt">
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
