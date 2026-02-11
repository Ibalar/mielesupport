<?php

declare(strict_types=1);

/**
 * Default page template
 * Supports all page hierarchy levels with breadcrumbs
 */

get_header();
?>

<main class="page-content">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>
            <article class="page-content__article">
                <header class="page-content__header">
                    <h1 class="page-content__title"><?php the_title(); ?></h1>
                </header>

                <div class="page-content__body">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
