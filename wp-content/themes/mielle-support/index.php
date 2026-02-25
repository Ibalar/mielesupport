<?php

declare(strict_types=1);

/**
 * Main index template
 */

get_header();
?>

<div class="container">
    <h1><?php single_post_title(); ?></h1>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('No posts found.', 'mielle-support'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
