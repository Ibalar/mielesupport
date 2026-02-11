<?php

declare(strict_types=1);

/**
 * Template part for displaying subcategory grid (level 2 service types)
 * Flexible content section for level 1 category pages
 */

$section_data = get_query_var('section_data', []);

$section_title = (string) ($section_data['title'] ?? '');
$section_description = (string) ($section_data['description'] ?? $section_data['text'] ?? '');
$section_subcategories = $section_data['subcategories'] ?? $section_data['subcategory_items'] ?? $section_data['items'] ?? [];

$subcategory_posts = [];

if (!empty($section_subcategories)) {
    if (!is_array($section_subcategories)) {
        $section_subcategories = [$section_subcategories];
    }

    foreach ($section_subcategories as $subcategory) {
        if ($subcategory instanceof WP_Post) {
            $subcategory_posts[] = $subcategory;
            continue;
        }

        if (is_numeric($subcategory)) {
            $post = get_post((int) $subcategory);
            if ($post instanceof WP_Post) {
                $subcategory_posts[] = $post;
            }
            continue;
        }

        if (is_array($subcategory) && !empty($subcategory['ID'])) {
            $post = get_post((int) $subcategory['ID']);
            if ($post instanceof WP_Post) {
                $subcategory_posts[] = $post;
            }
        }
    }
}

if (empty($subcategory_posts)) {
    $subcategory_posts = array_values(get_children([
        'post_type' => 'service',
        'post_parent' => get_the_ID(),
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ]));
}

if (empty($subcategory_posts)) {
    return;
}

if ($section_title === '') {
    $section_title = get_the_title() . ' Types';
}

?>

<section class="service-category-grid">
    <div class="container">
        <?php if ($section_title): ?>
            <h2 class="service-category-grid__title"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <?php if ($section_description): ?>
            <p class="service-category-grid__description"><?php echo esc_html($section_description); ?></p>
        <?php endif; ?>

        <div class="service-category-grid__grid">
            <?php foreach ($subcategory_posts as $subcategory) :
                $subcategory_id = $subcategory->ID;
                $subcategory_title = $subcategory->post_title;
                $subcategory_link = get_permalink($subcategory_id);

                $subcategory_image = get_the_post_thumbnail_url($subcategory_id, 'medium');
                if (!$subcategory_image) {
                    $subcategory_image = get_field('hero_image_level2', $subcategory_id);
                }
                if (!$subcategory_image) {
                    $subcategory_image = get_field('hero_image', $subcategory_id);
                }

                $subcategory_excerpt = get_field('short_description', $subcategory_id);
                if (!$subcategory_excerpt) {
                    $subcategory_excerpt = get_the_excerpt($subcategory_id);
                }
                if (!$subcategory_excerpt) {
                    $subcategory_excerpt = get_field('intro_text', $subcategory_id);
                }
                if ($subcategory_excerpt) {
                    $subcategory_excerpt = wp_strip_all_tags($subcategory_excerpt);
                    $subcategory_excerpt = wp_trim_words($subcategory_excerpt, 20, '...');
                }
                ?>
                <a href="<?php echo esc_url($subcategory_link); ?>" class="service-category-grid__card">
                    <div class="service-category-grid__card-image-wrapper">
                        <?php if ($subcategory_image) : ?>
                            <img
                                src="<?php echo esc_url($subcategory_image); ?>"
                                alt="<?php echo esc_attr($subcategory_title); ?>"
                                class="service-category-grid__card-image"
                                loading="lazy"
                            >
                        <?php else : ?>
                            <div class="service-category-grid__card-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="service-category-grid__card-icon">
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="service-category-grid__card-content">
                        <h3 class="service-category-grid__card-title"><?php echo esc_html($subcategory_title); ?></h3>

                        <?php if ($subcategory_excerpt) : ?>
                            <p class="service-category-grid__card-description"><?php echo esc_html($subcategory_excerpt); ?></p>
                        <?php endif; ?>

                        <span class="service-category-grid__card-link">
                            Learn More
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="service-category-grid__card-arrow">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
