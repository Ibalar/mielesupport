<?php

declare(strict_types=1);

/**
 * Service Text Block Section - Flexible Content Version
 * Template part: template-parts/service/text-block-flexible.php
 */

$section_data = get_query_var('section_data', []);

$title = (string) ($section_data['title'] ?? '');
$description = (string) ($section_data['description'] ?? '');

if ($title === '' && $description === '') {
    return;
}

?>

<section class="service-text-block">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="service-text-block__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($description) : ?>
            <div class="service-text-block__description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
