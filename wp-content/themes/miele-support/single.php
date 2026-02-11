<?php

declare(strict_types=1);

/**
 * Single post template (blog posts)
 * Supports breadcrumbs with category hierarchy
 */

get_header();
?>

<main class="single-post">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>
            <article class="single-post__article">
                <header class="single-post__header">
                    <h1 class="single-post__title"><?php the_title(); ?></h1>

                    <?php if (has_category()) : ?>
                        <div class="single-post__meta">
                            <span class="single-post__categories">
                                <?php the_category(', '); ?>
                            </span>
                            <time class="single-post__date" datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-post__thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post__content">
                    <?php the_content(); ?>
                </div>

                <?php if (has_tag()) : ?>
                    <footer class="single-post__footer">
                        <div class="single-post__tags">
                            <?php the_tags('', ', '); ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
