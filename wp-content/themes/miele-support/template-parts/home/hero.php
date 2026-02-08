<?php

declare(strict_types=1);

/**
 * Hero section for front page
 * Template part: template-parts/home/hero.php
 */

$title = get_field('hero_title', 'option');
$text = get_field('hero_subtitle', 'option');
$bg = get_field('hero_bg', 'option');

?>

<section class="hero">
    <div class="hero__bg">
        <?php if ($bg): ?>
            <img
                    src="<?= esc_url($bg['url']); ?>"
                    alt="<?= esc_attr($bg['alt']); ?>"
                    loading="eager"
            >
        <?php endif; ?>
    </div>
    
    <div class="hero__overlay"></div>
    
    <div class="container">
        <div class="hero__content">

            <?php if ($title): ?>
                <h1 class="hero__title">
                    <?= esc_html($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="hero__text">
                    <?= esc_html($text); ?>
                </p>
            <?php endif; ?>
            
            <div class="hero__actions">
                <a href="#" class="btn btn--primary">
                    Easy Online Booking
                </a>
                
                <a href="tel:+13478947974" class="btn btn--outline">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.90717 4.36067C7.00763 3.79874 5.82782 3.89183 5.06847 4.65118L3.7817 5.93795C1.82739 7.89227 3.66372 12.8972 7.88327 17.1167C12.1028 21.3363 17.1077 23.1726 19.0621 21.2183L20.3488 19.9315C21.2371 19.0432 21.2137 17.5795 20.2964 16.6622L18.3033 14.6691C17.386 13.7518 15.9222 13.7283 15.0339 14.6166L14.7575 14.893C14.2779 15.3726 13.5042 15.4196 12.9641 14.9739C12.4432 14.544 11.9244 14.0806 11.4219 13.5781C10.9194 13.0756 10.456 12.5568 10.0261 12.0359C9.58045 11.4958 9.62737 10.7221 10.107 10.2425L10.3834 9.96609C11.0837 9.26578 11.2173 8.20785 10.7931 7.34197" stroke="white" stroke-linecap="round" />
                        <path d="M17.6262 9.75071C17.3822 9.15553 17.0186 8.5979 16.5353 8.11463C16.0793 7.65865 15.5572 7.30918 14.9997 7.06622" stroke="white" stroke-linecap="round" />
                        <path d="M14.9992 3.66341C16.3338 4.14691 17.5861 4.92365 18.656 5.99364C19.7529 7.09049 20.5416 8.37883 21.0221 9.75113" stroke="white" stroke-linecap="round" />
                    </svg>
                    SERVICE LINE: +13478947974
                </a>
            </div>
        </div>
    </div>
</section>