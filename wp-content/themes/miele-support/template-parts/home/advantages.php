<?php

declare(strict_types=1);

/**
 * Advantages section for front page
 * Template part: template-parts/home/advantages.php
 */

$title = get_field('advantages_title', 'option');
$subtitle = get_field('advantages_subtitle', 'option');
$bg_390px = get_field('advantages_bg_390px', 'option');
$bg_744px = get_field('advantages_bg_744px', 'option');
$bg_1440px = get_field('advantages_bg_1440px', 'option');
$cards = get_field('advantages_cards', 'option');

// SVG icons mapped to their types
$icons = [
    'warranty' => '<svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="28.5" cy="28.5" r="28.5" fill="#00A651"/><path d="M18.5 29L24.5 35L38.5 21" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'service' => '<svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="28.5" cy="28.5" r="28.5" fill="#00A651"/><path d="M27 18.5V26L32 31M29 39C34.5228 39 39 34.5228 39 29C39 23.4772 34.5228 19 29 19C23.4772 19 19 23.4772 19 29C19 34.5228 23.4772 39 29 39Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'parts' => '<svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="28.5" cy="28.5" r="28.5" fill="#00A651"/><path d="M19 29L25 35L39 21" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'experience' => '<svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="28.5" cy="28.5" r="28.5" fill="#00A651"/><path d="M18.5 29L24.5 35L38.5 21" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>'
];

?>

<section class="advantages">
    <div class="advantages__bg">
        <?php if ($bg_1440px || $bg_744px || $bg_390px): ?>
            <picture>
                <?php if ($bg_1440px): ?>
                    <source media="(min-width: 1200px)" srcset="<?= esc_url($bg_1440px['url']); ?>">
                <?php endif; ?>
                <?php if ($bg_744px): ?>
                    <source media="(min-width: 744px)" srcset="<?= esc_url($bg_744px['url']); ?>">
                <?php endif; ?>
                <?php if ($bg_390px): ?>
                    <img src="<?= esc_url($bg_390px['url']); ?>" 
                         alt="<?= esc_attr($bg_390px['alt'] ?? 'Advantages background'); ?>"
                         loading="eager">
                <?php endif; ?>
            </picture>
        <?php endif; ?>
    </div>
    
    <div class="advantages__overlay"></div>
    
    <div class="container">
        <div class="advantages__content">
            
            <?php if ($title): ?>
                <h2 class="advantages__title">
                    <?= esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($subtitle): ?>
                <p class="advantages__subtitle">
                    <?= esc_html($subtitle); ?>
                </p>
            <?php endif; ?>
            
            <?php if ($cards): ?>
                <div class="advantages__grid">
                    <?php foreach ($cards as $card): ?>
                        <div class="advantage-card">
                            <div class="advantage-card__icon">
                                <?php if (isset($icons[$card['icon']])): ?>
                                    <?= $icons[$card['icon']]; ?>
                                <?php endif; ?>
                            </div>
                            <div class="advantage-card__text">
                                <?= esc_html($card['text']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>