<?php
/**
 * Template part for displaying category grid (level 2 service types)
 * Used on level 1 category pages to display child service types as cards
 */

// Get children of current page (level 2 service types)
$children = get_children([
    'post_type' => 'service',
    'post_parent' => get_the_ID(),
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => -1,
]);

// If no children, don't display anything
if (empty($children)) {
    return;
}

// Get current page title for the section heading
$current_title = get_the_title();
$section_title = $current_title . ' Types';
?>

<section class="service-category-grid">
    <div class="container">
        <h2 class="service-category-grid__title"><?php echo esc_html($section_title); ?></h2>

        <div class="service-category-grid__grid">
            <?php foreach ($children as $child) : 
                $child_id = $child->ID;
                $child_title = $child->post_title;
                $child_link = get_permalink($child_id);
                
                // Try to get featured image
                $child_image = get_the_post_thumbnail_url($child_id, 'medium');
                
                // If no featured image, try ACF hero_image field
                if (!$child_image) {
                    $child_image = get_field('hero_image', $child_id);
                }
                
                // Get excerpt or intro_text for description
                $child_excerpt = get_the_excerpt($child_id);
                if (!$child_excerpt) {
                    $child_excerpt = get_field('intro_text', $child_id);
                    // Strip HTML and truncate if needed
                    if ($child_excerpt) {
                        $child_excerpt = wp_strip_all_tags($child_excerpt);
                        $child_excerpt = wp_trim_words($child_excerpt, 20, '...');
                    }
                }
            ?>
                <a href="<?php echo esc_url($child_link); ?>" class="service-category-grid__card">
                    <div class="service-category-grid__card-image-wrapper">
                        <?php if ($child_image) : ?>
                            <img 
                                src="<?php echo esc_url($child_image); ?>" 
                                alt="<?php echo esc_attr($child_title); ?>" 
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
                        <h3 class="service-category-grid__card-title"><?php echo esc_html($child_title); ?></h3>
                        
                        <?php if ($child_excerpt) : ?>
                            <p class="service-category-grid__card-description"><?php echo esc_html($child_excerpt); ?></p>
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
