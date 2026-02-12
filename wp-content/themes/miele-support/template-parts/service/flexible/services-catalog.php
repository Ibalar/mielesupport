<?php declare(strict_types=1);

/**
 * Template: Services Catalog (Flexible)
 * Renders a catalog section with categories and items from flexible content
 */

$section_data = get_query_var('section_data', []);

$catalog_title = $section_data['catalog_title'] ?? '';
$catalog_categories = $section_data['catalog_categories'] ?? [];

if (empty($catalog_categories) || !is_array($catalog_categories)) {
    return;
}
?>

<section class="home-catalog">
    <div class="container">
        <?php if ($catalog_title) : ?>
            <h2 class="home-catalog__title"><?php echo esc_html($catalog_title); ?></h2>
        <?php endif; ?>

        <div class="home-catalog__categories">
            <?php foreach ($catalog_categories as $category) : ?>
                <div class="home-catalog__category">
                    <?php if (!empty($category['category_title'])) : ?>
                        <h3 class="home-catalog__category-title">
                            <?php echo esc_html($category['category_title']); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($category['category_items']) && is_array($category['category_items'])) : ?>
                        <div class="home-catalog__grid">
                            <?php foreach ($category['category_items'] as $item) : ?>
                                <?php if (!empty($item['item_link']['url']) && !empty($item['item_title'])) : ?>
                                    <a href="<?php echo esc_url($item['item_link']['url']); ?>" class="home-catalog__item">
                                        <?php if (!empty($item['item_image']) && is_array($item['item_image'])) : ?>
                                            <img 
                                                src="<?php echo esc_url($item['item_image']['url']); ?>" 
                                                alt="<?php echo esc_attr($item['item_image']['alt'] ?? $item['item_title']); ?>" 
                                                class="home-catalog__item-image"
                                                loading="lazy"
                                            >
                                        <?php endif; ?>
                                        <h4 class="home-catalog__item-title">
                                            <?php echo esc_html($item['item_title']); ?>
                                        </h4>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
