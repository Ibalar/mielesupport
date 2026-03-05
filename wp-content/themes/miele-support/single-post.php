<?php

declare(strict_types=1);

/**
 * Single post template for news articles
 * Detailed view for individual news posts
 */

get_header();

/**
 * Calculate human-readable time since last update
 *
 * @param int $post_id Post ID
 * @return string Human-readable time string or empty if not updated
 */
function miele_get_updated_time_ago(int $post_id): string
{
    $post_modified = get_post_field('post_modified', $post_id);
    $post_date = get_post_field('post_date', $post_id);

    // If post was never updated (modified time equals created time), return empty
    if ($post_modified === $post_date) {
        return '';
    }

    $modified_timestamp = strtotime($post_modified);
    $current_timestamp = current_time('timestamp');
    $diff_seconds = $current_timestamp - $modified_timestamp;

    // Calculate time units
    $minutes = floor($diff_seconds / 60);
    $hours = floor($minutes / 60);
    $days = floor($hours / 24);
    $weeks = floor($days / 7);
    $months = floor($days / 30);
    $years = floor($days / 365);

    // Return human-readable string
    if ($years > 0) {
        return sprintf(
            _n('Updated %d year ago', 'Updated %d years ago', $years, 'miele-support'),
            $years
        );
    } elseif ($months > 0) {
        return sprintf(
            _n('Updated %d month ago', 'Updated %d months ago', $months, 'miele-support'),
            $months
        );
    } elseif ($weeks > 0) {
        return sprintf(
            _n('Updated %d week ago', 'Updated %d weeks ago', $weeks, 'miele-support'),
            $weeks
        );
    } elseif ($days > 0) {
        return sprintf(
            _n('Updated %d day ago', 'Updated %d days ago', $days, 'miele-support'),
            $days
        );
    } elseif ($hours > 0) {
        return sprintf(
            _n('Updated %d hour ago', 'Updated %d hours ago', $hours, 'miele-support'),
            $hours
        );
    } elseif ($minutes > 0) {
        return sprintf(
            _n('Updated %d minute ago', 'Updated %d minutes ago', $minutes, 'miele-support'),
            $minutes
        );
    }

    return __('Updated just now', 'miele-support');
}
?>

<main class="news-single">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>
            <?php
            // Get author info with fallbacks
            $author_id = get_the_author_meta('ID');
            $custom_author_name = get_field('author_name');
            $author_name = $custom_author_name ? $custom_author_name : get_the_author();
            $author_avatar = get_avatar($author_id, 80, '', esc_attr($author_name), ['class' => 'news-single__author-avatar-img']);
            $author_description = get_the_author_meta('description', $author_id);

            // Get updated time
            $updated_time_ago = miele_get_updated_time_ago(get_the_ID());
            ?>

            <article class="news-single__article">
                <header class="news-single__header">
                    <h1 class="news-single__title"><?php the_title(); ?></h1>

                    <div class="news-single__meta">
                        <time class="news-single__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>

                        <?php if ($updated_time_ago) : ?>
                            <span class="news-single__updated"><?php echo esc_html($updated_time_ago); ?></span>
                        <?php endif; ?>

                        <?php if (has_category()) : ?>
                            <span class="news-single__categories">
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php
                // Author block - show if we have avatar or name or description
                $has_author_data = $author_avatar || $author_name || $author_description;
                if ($has_author_data) :
                ?>
                    <div class="news-single__author-block">
                        <?php if ($author_avatar) : ?>
                            <div class="news-single__author-avatar">
                                <?php echo $author_avatar; ?>
                            </div>
                        <?php endif; ?>

                        <div class="news-single__author-info">
                            <?php if ($author_name) : ?>
                                <span class="news-single__author-name"><?php echo esc_html($author_name); ?></span>
                            <?php endif; ?>

                            <?php if ($author_description) : ?>
                                <p class="news-single__author-description"><?php echo esc_html($author_description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // Online booking button with modal
                ?>
                <div class="news-single__booking">
                    <button type="button" class="news-single__booking-btn js-quick-form-trigger">
                        <?php echo esc_html__('Book Online Appointment', 'miele-support'); ?>
                    </button>
                </div>

                <?php
                // Media block: featured image + secondary image
                // Desktop (1440): 2 images side by side
                // Tablet/Mobile (744/390): only primary (featured) image visible
                $has_thumbnail = has_post_thumbnail();
                $secondary_image = get_field('secondary_image');
                $has_secondary = !empty($secondary_image);

                if ($has_thumbnail || $has_secondary) :
                    $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: get_the_title();
                ?>
                    <div class="news-single__media<?php echo $has_secondary ? ' news-single__media--dual' : ''; ?>">
                        <?php if ($has_thumbnail) : ?>
                            <div class="news-single__media-item news-single__media-item--primary">
                                <?php
                                echo wp_get_attachment_image(
                                    $thumbnail_id,
                                    'large',
                                    false,
                                    [
                                        'srcset' => wp_get_attachment_image_srcset($thumbnail_id, 'large'),
                                        'sizes' => '(max-width: 744px) 100vw, 50vw',
                                        'alt' => esc_attr($thumbnail_alt),
                                        'loading' => 'eager',
                                    ]
                                );
                                ?>
                            </div>
                        <?php elseif ($has_secondary) : ?>
                            <?php
                            // Fallback: if no featured image but secondary exists, show secondary as primary
                            $secondary_id = is_array($secondary_image) ? $secondary_image['ID'] : $secondary_image;
                            $secondary_alt = get_post_meta($secondary_id, '_wp_attachment_image_alt', true) ?: get_the_title();
                            ?>
                            <div class="news-single__media-item news-single__media-item--primary">
                                <?php
                                echo wp_get_attachment_image(
                                    $secondary_id,
                                    'large',
                                    false,
                                    [
                                        'srcset' => wp_get_attachment_image_srcset($secondary_id, 'large'),
                                        'sizes' => '100vw',
                                        'alt' => esc_attr($secondary_alt),
                                        'loading' => 'eager',
                                    ]
                                );
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($has_secondary && $has_thumbnail) : ?>
                            <div class="news-single__media-item news-single__media-item--secondary">
                                <?php
                                $secondary_id = is_array($secondary_image) ? $secondary_image['ID'] : $secondary_image;
                                $secondary_alt = get_post_meta($secondary_id, '_wp_attachment_image_alt', true) ?: get_the_title();
                                echo wp_get_attachment_image(
                                    $secondary_id,
                                    'large',
                                    false,
                                    [
                                        'srcset' => wp_get_attachment_image_srcset($secondary_id, 'large'),
                                        'sizes' => '(max-width: 744px) 100vw, 50vw',
                                        'alt' => esc_attr($secondary_alt),
                                        'loading' => 'lazy',
                                    ]
                                );
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Caption: featured image caption or secondary image caption based on context
                        $caption = '';
                        if ($has_thumbnail) {
                            $caption = get_the_post_thumbnail_caption();
                            if (!$caption) {
                                $caption = get_field('featured_image_caption');
                            }
                        }
                        if ($caption) : ?>
                            <div class="news-single__media-caption-wrapper">
                                <p class="news-single__media-caption"><?php echo esc_html($caption); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php 
                $subtitle = get_field('subtitle');
                if ($subtitle) : ?>
                    <p class="news-single__subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <div class="news-single__content">
                    <?php the_content(); ?>
                </div>

                <?php if (has_tag()) : ?>
                    <footer class="news-single__footer">
                        <div class="news-single__tags">
                            <?php the_tags('', ', '); ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </article>

            <nav class="news-single__navigation">
                <div class="news-single__nav-prev">
                    <?php previous_post_link('%link', __('&larr; Previous', 'miele-support')); ?>
                </div>
                <div class="news-single__nav-next">
                    <?php next_post_link('%link', __('Next &rarr;', 'miele-support')); ?>
                </div>
            </nav>
        <?php endwhile; ?>
    </div>
</main>

<!-- Quick Form Modal -->
<div class="quick-form-modal" aria-hidden="true">
    <div class="quick-form-modal__overlay"></div>
    <div class="quick-form-modal__panel">
        <button class="quick-form-modal__close" type="button" aria-label="<?php echo esc_attr__('Close', 'miele-support'); ?>">&times;</button>
        <h3 class="quick-form__title"><?php echo esc_html__('Book Online Appointment', 'miele-support'); ?></h3>
        <p class="quick-form__subtitle"><?php echo esc_html__('Fill out the form and we will contact you shortly', 'miele-support'); ?></p>
        <form class="quick-form" id="quick-booking-form" method="post">
            <div class="quick-form__field">
                <label for="quick_name"><?php echo esc_html__('Your Name', 'miele-support'); ?></label>
                <input type="text" id="quick_name" name="quick_name" required>
            </div>
            <div class="quick-form__field">
                <label for="quick_phone"><?php echo esc_html__('Phone Number', 'miele-support'); ?></label>
                <input type="tel" id="quick_phone" name="quick_phone" required>
            </div>
            <div class="quick-form__field">
                <label for="quick_email"><?php echo esc_html__('Email', 'miele-support'); ?></label>
                <input type="email" id="quick_email" name="quick_email" required>
            </div>
            <div class="quick-form__field">
                <label for="quick_message"><?php echo esc_html__('Message (Optional)', 'miele-support'); ?></label>
                <textarea id="quick_message" name="quick_message" rows="3"></textarea>
            </div>
            <button type="submit" class="quick-form__submit"><?php echo esc_html__('Submit Request', 'miele-support'); ?></button>
        </form>
    </div>
</div>

<?php get_footer(); ?>
