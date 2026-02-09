<?php
/**
 * Dynamic offcanvas burger menu
 * Generates menu from CPT service hierarchy
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

// Counter for unique IDs
$burger_counter = 0;
?>

<!-- Выездное бургер-меню -->
<div class="offcanvas" aria-hidden="true">
    <div class="offcanvas__overlay"></div>
    <aside class="offcanvas__panel">
        <button class="offcanvas__close" type="button" aria-label="Close menu">×</button>

        <!-- Блок 1 - Основные страницы -->
        <nav class="offcanvas__block offcanvas__block--primary">
            <ul class="offcanvas__list">
                <li><a href="/about-us">About Us</a></li>
                <li><a href="/gallery">Gallery</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact-us">Contact Us</a></li>
            </ul>
        </nav>

        <?php if (!empty($level1_services)) : ?>
            <!-- Блок 2 - Услуги -->
            <nav class="offcanvas__block offcanvas__block--services">
                <?php foreach ($level1_services as $level1) :
                    $level1_id = $level1->ID;
                    $level1_title = $level1->post_title;
                    $level1_link = get_permalink($level1_id);

                    // Get level 2 children
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

                    <!-- Заголовок категории (Level 1) -->
                    <a href="<?php echo esc_url($level1_link); ?>" class="offcanvas__services-title">
                        <?php echo esc_html($level1_title); ?>
                    </a>

                    <?php if (!empty($level2_services)) : ?>
                        <ul class="offcanvas__list offcanvas__list--sub">
                            <?php foreach ($level2_services as $level2) :
                                $level2_id = $level2->ID;
                                $level2_title = $level2->post_title;
                                $level2_link = get_permalink($level2_id);

                                // Get level 3 children
                                $level3_services = get_posts([
                                    'post_type' => 'service',
                                    'post_parent' => $level2_id,
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC',
                                    'posts_per_page' => -1,
                                ]);
                                ?>
                                <li>
                                    <?php if (!empty($level3_services)) : ?>
                                        <?php $burger_counter++; ?>
                                        <button
                                            class="offcanvas__sub-toggle js-burger-toggle"
                                            type="button"
                                            data-target="#burger-sub-<?php echo esc_attr($burger_counter); ?>"
                                            aria-expanded="false"
                                        >
                                            <?php echo esc_html($level2_title); ?>
                                            <span class="offcanvas__sub-arrow"></span>
                                        </button>
                                        <ul class="offcanvas__sub-list" id="burger-sub-<?php echo esc_attr($burger_counter); ?>" hidden>
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
                                        <a href="<?php echo esc_url($level2_link); ?>">
                                            <?php echo esc_html($level2_title); ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
    </aside>
</div>
