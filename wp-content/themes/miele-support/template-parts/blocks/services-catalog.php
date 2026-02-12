<?php declare(strict_types=1);

/**
 * Services Catalog Block
 * Displays service categories with items in a grid layout
 */

$section_title = get_field('section_title');
$service_categories = get_field('service_categories');

if (!$service_categories || !is_array($service_categories)) {
    return;
}
?>

<section class="services-catalog">
    <div class="container">
        <?php if ($section_title) : ?>
            <h2 class="services-catalog__title"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <div class="services-catalog__categories">
            <?php foreach ($service_categories as $category) : ?>
                <div class="services-catalog__category">
                    <?php if (!empty($category['category_title'])) : ?>
                        <h3 class="services-catalog__category-title">
                            <?php echo esc_html($category['category_title']); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($category['category_items']) && is_array($category['category_items'])) : ?>
                        <div class="services-catalog__grid">
                            <?php foreach ($category['category_items'] as $item) : ?>
                                <?php if (!empty($item['item_link']['url']) && !empty($item['item_title'])) : ?>
                                    <a href="<?php echo esc_url($item['item_link']['url']); ?>" class="services-catalog__item">
                                        <?php if (!empty($item['item_image']) && is_array($item['item_image'])) : ?>
                                            <img 
                                                src="<?php echo esc_url($item['item_image']['url']); ?>" 
                                                alt="<?php echo esc_attr($item['item_image']['alt'] ?? $item['item_title']); ?>" 
                                                class="services-catalog__item-image"
                                                loading="lazy"
                                            >
                                        <?php endif; ?>
                                        <h4 class="services-catalog__item-title">
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