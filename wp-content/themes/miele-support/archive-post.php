<?php

declare(strict_types=1);

/**
 * Archive template for news posts
 * This is an alternative template that can be used for custom news archives
 * Note: WordPress uses home.php for the main posts index by default
 */

get_header();

// Get Hero fields from the blog page
$blog_page = get_page_by_path('blog');
$hero_title = __('News', 'miele-support');
$hero_bg_image = null;

if ($blog_page) {
    $hero_title_field = get_field('hero_title', $blog_page->ID);
    if ($hero_title_field) {
        $hero_title = $hero_title_field;
    }
    $hero_bg_image = get_field('hero_bg_image', $blog_page->ID);
}

// Build inline style for background image
$hero_style = '';
if ($hero_bg_image && is_array($hero_bg_image) && !empty($hero_bg_image['url'])) {
    $hero_style = ' style="background-image: url(\'' . esc_url($hero_bg_image['url']) . '\');"';
}
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

        <?php if (have_posts()) : ?>
            <div class="news-archive__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post/news-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination([
                'prev_text' => __('Previous', 'miele-support'),
                'next_text' => __('Next', 'miele-support'),
            ]); ?>

        <?php else : ?>
            <div class="news-archive__empty">
                <p><?php _e('No news articles found.', 'miele-support'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
