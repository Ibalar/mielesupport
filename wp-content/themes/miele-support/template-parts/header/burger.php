<?php
/**
 * Dynamic offcanvas burger menu
 * On large screens: only shows pages (About Us, Gallery, Blog, etc.)
 * On small screens: shows Services at the top + pages
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

// Define column order for mobile services
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
        $group = 'kitchen';
    }
    if (!isset($grouped[$group])) {
        $grouped[$group] = [];
    }
    $grouped[$group][] = $service;
}

$burger_counter = 0;
?>

<!-- Выездное бургер-меню -->
<div class="offcanvas" aria-hidden="true">
    <div class="offcanvas__overlay"></div>
    <aside class="offcanvas__panel">
        <button class="offcanvas__close" type="button" aria-label="Close menu">×</button>

        <!-- Services block - visible only on small screens -->
        <?php if (!empty($grouped)) : ?>
            <nav class="offcanvas__block offcanvas__block--services offcanvas__block--services-mobile">
                <button
                    class="offcanvas__services-toggle js-burger-toggle"
                    type="button"
                    data-target="#burger-services"
                    aria-expanded="false"
                >
                    Services
                    <span class="offcanvas__sub-arrow"></span>
                </button>

                <div class="offcanvas__services-panel" id="burger-services" hidden>
                    <?php foreach ($columns as $group_key => $group_label) :
                        $group_services = $grouped[$group_key] ?? [];
                        if (empty($group_services)) continue;
                    ?>
                        <div class="offcanvas__services-group">
                            <div class="offcanvas__services-header"><?php echo esc_html($group_label); ?></div>

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
                                $burger_counter++;
                            ?>
                                <?php if ($has_children) : ?>
                                    <button
                                        class="offcanvas__service-item offcanvas__service-item--parent js-burger-toggle"
                                        type="button"
                                        data-target="#burger-l1-<?php echo esc_attr($burger_counter); ?>"
                                        aria-expanded="false"
                                    >
                                        <?php echo esc_html($display_title); ?>
                                        <span class="offcanvas__service-dash"></span>
                                    </button>
                                    <ul class="offcanvas__service-sub" id="burger-l1-<?php echo esc_attr($burger_counter); ?>" hidden>
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
                                            $burger_counter++;
                                        ?>
                                            <li>
                                                <?php if ($has_level3) : ?>
                                                    <button
                                                        class="offcanvas__service-item offcanvas__service-item--parent js-burger-toggle"
                                                        type="button"
                                                        data-target="#burger-l2-<?php echo esc_attr($burger_counter); ?>"
                                                        aria-expanded="false"
                                                    >
                                                        <?php echo esc_html($level2_title); ?>
                                                        <span class="offcanvas__service-dash"></span>
                                                    </button>
                                                    <ul class="offcanvas__service-sub" id="burger-l2-<?php echo esc_attr($burger_counter); ?>" hidden>
                                                        <?php foreach ($level3_services as $level3) : ?>
                                                            <li>
                                                                <a href="<?php echo esc_url(get_permalink($level3->ID)); ?>" class="offcanvas__service-item offcanvas__service-item--leaf">
                                                                    <?php echo esc_html($level3->post_title); ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else : ?>
                                                    <a href="<?php echo esc_url($level2_link); ?>" class="offcanvas__service-item offcanvas__service-item--leaf">
                                                        <?php echo esc_html($level2_title); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <a href="<?php echo esc_url($level1_link); ?>" class="offcanvas__service-item offcanvas__service-item--leaf">
                                        <?php echo esc_html($display_title); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </nav>
        <?php endif; ?>

        <!-- Pages block -->
        <nav class="offcanvas__block offcanvas__block--primary">
            <ul class="offcanvas__list">
                <li><a href="/about-us">About Us</a></li>
                <li><a href="/areas">Areas</a></li>
                <li><a href="/gallery">Gallery</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact-us">Contact Us</a></li>
            </ul>
        </nav>
    </aside>
</div>
