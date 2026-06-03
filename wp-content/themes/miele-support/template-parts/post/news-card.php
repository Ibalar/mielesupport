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

// Get author info with post-level ACF fields as the primary source
$author_id = get_the_author_meta('ID');
$custom_author_name = get_field('author_name');
$author_name = $custom_author_name ? $custom_author_name : get_the_author();
$custom_author_avatar = get_field('author_avatar');
$author_description = get_field('author_description');
$author_avatar = '';

if ($custom_author_avatar) {
    if (is_array($custom_author_avatar) && !empty($custom_author_avatar['url'])) {
        $author_avatar_alt = !empty($custom_author_avatar['alt']) ? $custom_author_avatar['alt'] : $author_name;
        $author_avatar = sprintf(
            '<img src="%s" alt="%s" class="news-card__author-avatar-img">',
            esc_url($custom_author_avatar['url']),
            esc_attr($author_avatar_alt)
        );
    } elseif (is_numeric($custom_author_avatar)) {
        $author_avatar = wp_get_attachment_image(
            (int) $custom_author_avatar,
            'thumbnail',
            false,
            [
                'class' => 'news-card__author-avatar-img',
                'alt'   => esc_attr($author_name),
            ]
        );
    } elseif (is_string($custom_author_avatar)) {
        $author_avatar = sprintf(
            '<img src="%s" alt="%s" class="news-card__author-avatar-img">',
            esc_url($custom_author_avatar),
            esc_attr($author_name)
        );
    }
}

if (!$author_avatar) {
    $author_avatar = get_avatar($author_id, 40, '', $author_name, ['class' => 'news-card__author-avatar-img']);
}

// Get post tags (limit to 2)
$post_tags = get_the_tags();
$display_tags = [];
if ($post_tags && !is_wp_error($post_tags)) {
    $display_tags = array_slice($post_tags, 0, 2);
}

// Get creation date in English format, e.g. August 20, 2026
$created_date = get_post_time('F j, Y', false, get_the_ID(), false);
$modified_time = get_the_modified_time('g:i A');

// Calculate read time (rough estimate: 200 words per minute)
$content = get_the_content();
$word_count = str_word_count(strip_tags($content));
$read_time = ceil($word_count / 200);
if ($read_time < 1) {
    $read_time = 1;
}
?>

<article <?php post_class(implode(' ', $classes)); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="news-card__image">
            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('medium_large', ['class' => 'news-card__img']); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="news-card__content">
        <h2 class="news-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="news-card__author">
            <div class="news-card__author-head">
                <?php if ($author_avatar) : ?>
                    <div class="news-card__author-avatar">
                        <?php echo $author_avatar; ?>
                    </div>
                <?php endif; ?>

                <span class="news-card__author-name"><?php echo esc_html($author_name); ?></span>
            </div>

            <?php if ($author_description) : ?>
                <p class="news-card__author-description"><?php echo esc_html($author_description); ?></p>
            <?php endif; ?>
        </div>

        <?php if (has_excerpt()) : ?>
            <div class="news-card__excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($display_tags)) : ?>
            <div class="news-card__tags">
                <?php foreach ($display_tags as $tag) : ?>
                    <span class="news-card__tag"><?php echo esc_html($tag->name); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="news-card__footer">
            <div class="news-card__meta">
                <time class="news-card__date" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo esc_html($created_date); ?>
                </time>
                <span class="news-card__meta-separator">•</span>
                <span class="news-card__read-time"><?php echo $read_time; ?> <?php _e('min read', 'miele-support'); ?></span>
            </div>
            <a href="<?php the_permalink(); ?>" class="news-card__read-more">
                <?php _e('Read more', 'miele-support'); ?>
            </a>
        </div>
    </div>
</article>
