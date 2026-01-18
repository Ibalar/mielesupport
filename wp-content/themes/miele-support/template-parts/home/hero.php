<?php declare(strict_types=1);

/**
 * Hero section for front page
 * Template part: template-parts/home/hero.php
 */

$hero_title = get_field('hero_title', 'option');
$hero_subtitle = get_field('hero_subtitle', 'option');
$hero_bg_id = get_field('hero_bg', 'option');
$hero_bg_url = '';

// Обработка изображения - может быть ID или URL
if ($hero_bg_id) {
    if (is_numeric($hero_bg_id)) {
        // Если это ID - получить полный URL
        $bg_image = wp_get_attachment_image_src($hero_bg_id, 'full');
        $hero_bg_url = $bg_image[0] ?? '';
    } else {
        // Если это уже URL - использовать напрямую
        $hero_bg_url = $hero_bg_id;
    }
}
?>

<section class="hero">
    <div class="hero__bg">
        <?php if ($hero_bg_url) : ?>
            <img 
                src="<?= esc_attr($hero_bg_url) ?>" 
                alt="<?= esc_attr($hero_title ?: 'Hero background') ?>" 
                loading="lazy"
            >
        <?php endif; ?>
    </div>
    <div class="hero__overlay"></div>
    
    <div class="container">
        <div class="hero__content">
            <?php if ($hero_subtitle) : ?>
                <div class="hero__eyebrow"><?= wp_kses_post($hero_subtitle) ?></div>
            <?php endif; ?>
            
            <?php if ($hero_title) : ?>
                <h1 class="hero__title"><?= wp_kses_post($hero_title) ?></h1>
            <?php endif; ?>
            
            <div class="hero__actions">
                <a href="#quick-form" class="btn btn--primary">BOOK ONLINE & GET 15% OFF</a>
                <a href="/contact-us" class="btn btn--outline">CONTACT US</a>
            </div>
        </div>
    </div>
</section>