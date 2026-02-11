<?php

declare(strict_types=1);

/**
 * Search results template
 * Supports breadcrumbs for search results page
 */

get_header();
?>

<main class="search-results">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <div class="search-results__header">
            <h1 class="search-results__title">
                <?php
                printf(
                    /* translators: %s: search query */
                    __('Search Results for: "%s"', 'miele-support'),
                    get_search_query()
                );
                ?>
            </h1>
        </div>

        <?php if (have_posts()) : ?>
            <div class="search-results__content">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="search-results__item">
                        <h2 class="search-results__item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <div class="search-results__item-type">
                            <?php
                            $post_type = get_post_type();
                            $post_type_obj = get_post_type_object($post_type);
                            echo $post_type_obj ? esc_html($post_type_obj->label) : esc_html($post_type);
                            ?>
                        </div>

                        <?php if (has_excerpt()) : ?>
                            <div class="search-results__item-excerpt">
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
            <div class="search-results__empty">
                <p><?php _e('No results found. Please try a different search term.', 'miele-support'); ?></p>

                <div class="search-results__search-form">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
