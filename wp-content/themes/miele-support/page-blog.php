<?php

declare(strict_types=1);

/**
 * Template Name: Blog
 *
 * Page template for displaying blog posts/news.
 *
 * SETUP INSTRUCTIONS:
 * 1. Create a new page in WordPress admin (Pages → Add New)
 * 2. Title: "Blog"
 * 3. Slug: "blog"
 * 4. In Page Attributes, select "Blog" as the template
 * 5. Publish
 *
 * Once created, the Blog menu item in offcanvas__block--primary
 * will automatically link to /blog/
 */

get_header();

// Get Hero fields from current page
$hero_title = get_field('hero_title');
if (empty($hero_title)) {
    $hero_title = get_the_title();
}
if (empty($hero_title)) {
    $hero_title = __('Blog', 'miele-support');
}

$hero_bg_image = get_field('hero_bg_image');
$hero_bg_image_url = null;

// Handle different return formats (array vs URL)
if ($hero_bg_image) {
    if (is_array($hero_bg_image) && !empty($hero_bg_image['url'])) {
        // Return format is 'array'
        $hero_bg_image_url = $hero_bg_image['url'];
    } elseif (is_string($hero_bg_image)) {
        // Return format is 'url' or 'id'
        $hero_bg_image_url = $hero_bg_image;
    }
}

// Build inline style for background image
$hero_style = '';
if ($hero_bg_image_url) {
    $hero_style = ' style="background-image: url(\'' . esc_url($hero_bg_image_url) . '\');"';
}

// Get current tag from URL for filtering
$current_tag_slug = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

// Query posts for the blog page
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$query_args = [
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

// Add tag filter if specified
if ($current_tag_slug) {
    $tag = get_term_by('slug', $current_tag_slug, 'post_tag');
    if ($tag) {
        $query_args['tag_id'] = $tag->term_id;
    }
}

$blog_query = new WP_Query($query_args);

// Get all tags used in posts for the filter
$all_tags = get_tags([
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
]);
?>

<section class="news-hero"<?php echo $hero_style; ?>>
    <div class="news-hero__overlay"></div>
    <div class="container">
        <div class="news-hero__content">
            <h1 class="news-hero__title"><?php echo esc_html($hero_title); ?></h1>
        </div>
    </div>
</section>

<main class="news-archive">
    <div class="container">
        <?php render_breadcrumbs(); ?>

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

        <?php if ($blog_query->have_posts()) : ?>
            <div class="news-archive__grid">
                <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
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

            <?php
            // Pagination
            $big = '999999999';
            echo paginate_links([
                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'    => '?paged=%#%',
                'current'   => max(1, $paged),
                'total'     => $blog_query->max_num_pages,
                'prev_text' => __('Previous', 'miele-support'),
                'next_text' => __('Next', 'miele-support'),
                'add_args'  => $current_tag_slug ? ['tag' => $current_tag_slug] : [],
            ]);
            ?>

        <?php else : ?>
            <div class="news-archive__empty">
                <p><?php _e('No news articles found.', 'miele-support'); ?></p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</main>

<?php get_footer(); ?>
