<?php
/**
 * Dynamic mega menu for services
 * Groups Level 1 categories by mega menu column (KITCHEN / LAUNDRY / VACUUM CLEANERS)
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

if (empty($level1_services)) {
    return;
}

// Define column order and labels
$columns = [
    'kitchen'          => 'KITCHEN',
    'laundry'          => 'LAUNDRY',
    'vacuum_cleaners'  => 'VACUUM CLEANERS',
];

// Group services by column_group
$grouped = [];
foreach ($level1_services as $service) {
    $group = get_field('column_group', $service->ID);
    if (!$group) {
        $group = 'kitchen'; // fallback
    }
    if (!isset($grouped[$group])) {
        $grouped[$group] = [];
    }
    $grouped[$group][] = $service;
}

$unique_counter = 0;
?>

<div class="mega-menu" id="services-mega" hidden>
    <div class="mega-menu__inner">
        <?php foreach ($columns as $group_key => $group_label) :
            $group_services = $grouped[$group_key] ?? [];
            if (empty($group_services)) continue;
        ?>
            <div class="mega-menu__col">
                <div class="mega-menu__col-header"><?php echo esc_html($group_label); ?></div>

                <ul class="mega-menu__list">
                    <?php foreach ($group_services as $level1) :
                        $level1_id = $level1->ID;
                        $level1_link = get_permalink($level1_id);
                        $menu_label = get_field('menu_label', $level1_id);
                        $display_title = $menu_label ? $menu_label : $level1->post_title;

                        $level2_services = function_exists('get_service_children')
                            ? get_service_children($level1_id)
                            : get_posts([
                                'post_type' => 'service',
                                'post_parent' => $level1_id,
                                'orderby' => 'menu_order',
                                'order' => 'ASC',
                                'posts_per_page' => -1,
                            ]);

                        $has_children = !empty($level2_services);
                        $unique_counter++;
                        $submenu_id = 'mega-sub-' . $level1_id . '-' . $unique_counter;
                        ?>
                        <li class="mega-menu__item <?php echo $has_children ? 'mega-menu__item--has-sub' : ''; ?>">
                            <?php if ($has_children) : ?>
                                <button
                                    class="mega-menu__link js-nav-toggle"
                                    type="button"
                                    data-target="#<?php echo esc_attr($submenu_id); ?>"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    aria-controls="<?php echo esc_attr($submenu_id); ?>"
                                >
                                    <?php echo esc_html($display_title); ?>
                                    <span class="mega-menu__arrow"></span>
                                </button>
                                <ul class="mega-menu__sub mega-menu__submenu--collapsed" id="<?php echo esc_attr($submenu_id); ?>" hidden>
                                    <?php foreach ($level2_services as $level2) :
                                        $level2_id = $level2->ID;
                                        $level2_title = $level2->post_title;
                                        $level2_link = get_permalink($level2_id);

                                        $level3_services = get_posts([
                                            'post_type' => 'service',
                                            'post_parent' => $level2_id,
                                            'orderby' => 'menu_order',
                                            'order' => 'ASC',
                                            'posts_per_page' => -1,
                                        ]);

                                        $has_level3 = !empty($level3_services);
                                        $unique_counter++;
                                        $submenu3_id = 'mega-sub3-' . $level2_id . '-' . $unique_counter;
                                        ?>
                                        <li class="mega-menu__subitem <?php echo $has_level3 ? 'mega-menu__subitem--has-sub' : ''; ?>">
                                            <?php if ($has_level3) : ?>
                                                <button
                                                    class="mega-menu__sublink js-nav-toggle"
                                                    type="button"
                                                    data-target="#<?php echo esc_attr($submenu3_id); ?>"
                                                    aria-expanded="false"
                                                    aria-controls="<?php echo esc_attr($submenu3_id); ?>"
                                                >
                                                    <?php echo esc_html($level2_title); ?>
                                                    <span class="mega-menu__arrow mega-menu__arrow--sub"></span>
                                                </button>
                                                <ul class="mega-menu__sub3 mega-menu__submenu--collapsed" id="<?php echo esc_attr($submenu3_id); ?>" hidden>
                                                    <?php foreach ($level3_services as $level3) : ?>
                                                        <li>
                                                            <a href="<?php echo esc_url(get_permalink($level3->ID)); ?>" class="mega-menu__sub3link">
                                                                <?php echo esc_html($level3->post_title); ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else : ?>
                                                <a href="<?php echo esc_url($level2_link); ?>" class="mega-menu__sublink">
                                                    <?php echo esc_html($level2_title); ?>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <a href="<?php echo esc_url($level1_link); ?>" class="mega-menu__link mega-menu__link--plain">
                                    <?php echo esc_html($display_title); ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>
