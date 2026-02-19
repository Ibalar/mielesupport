<?php

declare(strict_types=1);

/**
 * Single post template for news articles
 * Detailed view for individual news posts
 */

get_header();
?>

<main class="news-single">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>
            <article class="news-single__article">
                <header class="news-single__header">
                    <h1 class="news-single__title"><?php the_title(); ?></h1>
                    
                    <div class="news-single__meta">
                        <time class="news-single__date" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                        
                        <?php if (has_category()) : ?>
                            <span class="news-single__categories">
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php 
                        $author_name = get_field('author_name');
                        if ($author_name) : ?>
                            <span class="news-single__author">
                                <?php echo esc_html($author_name); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="news-single__thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                        <?php 
                        $caption = get_the_post_thumbnail_caption();
                        if (!$caption) {
                            $caption = get_field('featured_image_caption');
                        }
                        if ($caption) : ?>
                            <p class="news-single__thumbnail-caption"><?php echo esc_html($caption); ?></p>
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

<?php get_footer(); ?>
