<?php
/**
 * Dynamic mega menu for services
 * Generates menu from CPT service hierarchy
 * Level 1: Categories (post_parent == 0)
 * Level 2: Appliance types (has parent, has children)
 * Level 3: Final services (has parent, no children)
 */

// Get cached level 1 services (categories)
$level1_services = function_exists('get_cached_level1_services')
    ? get_cached_level1_services()
    : get_posts([
        'post_type' => 'service',
        'post_parent' => 0,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ]);

// If no services found, don't display mega menu
if (empty($level1_services)) {
    return;
}

// Counter for unique IDs
$unique_counter = 0;
?>

<div class="mega-menu" id="services-mega" hidden>
    <?php foreach ($level1_services as $level1) :
        $level1_id = $level1->ID;
        $level1_title = $level1->post_title;
        $level1_link = get_permalink($level1_id);

        // Get custom menu label if set
        $menu_label = get_field('menu_label', $level1_id);
        $display_title = $menu_label ? $menu_label : $level1_title;

        // Get level 2 children (appliance types)
        $level2_services = function_exists('get_service_children')
            ? get_service_children($level1_id)
            : get_posts([
                'post_type' => 'service',
                'post_parent' => $level1_id,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'posts_per_page' => -1,
            ]);
        ?>
        <div class="mega-menu__col">
            <div class="mega-menu__title">
                <a href="<?php echo esc_url($level1_link); ?>"><?php echo esc_html($display_title); ?></a>
            </div>

            <?php if (!empty($level2_services)) : ?>
                <ul class="mega-menu__list">
                    <?php foreach ($level2_services as $level2) :
                        $level2_id = $level2->ID;
                        $level2_title = $level2->post_title;
                        $level2_link = get_permalink($level2_id);

                        // Get level 3 children (final services)
                        $level3_services = get_posts([
                            'post_type' => 'service',
                            'post_parent' => $level2_id,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                            'posts_per_page' => -1,
                        ]);

                        $has_level3 = !empty($level3_services);
                        $unique_counter++;
                        $submenu_id = 'mega-sub-' . $level1_id . '-' . $level2_id . '-' . $unique_counter;
                        ?>
                        <li class="mega-menu__item <?php echo $has_level3 ? 'mega-menu__item--has-sub' : ''; ?>">
                            <?php if ($has_level3) : ?>
                                <button
                                    class="mega-menu__link js-nav-toggle"
                                    type="button"
                                    data-target="#<?php echo esc_attr($submenu_id); ?>"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                >
                                    <?php echo esc_html($level2_title); ?>
                                    <span class="mega-menu__arrow"></span>
                                </button>
                                <ul class="mega-menu__sub" id="<?php echo esc_attr($submenu_id); ?>" hidden>
                                    <?php foreach ($level3_services as $level3) :
                                        $level3_id = $level3->ID;
                                        $level3_title = $level3->post_title;
                                        $level3_link = get_permalink($level3_id);
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url($level3_link); ?>">
                                                <?php echo esc_html($level3_title); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <a href="<?php echo esc_url($level2_link); ?>" class="mega-menu__link">
                                    <?php echo esc_html($level2_title); ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
