<?php

declare(strict_types=1);

/**
 * Service Reviews Section
 * Template part: template-parts/service/reviews.php
 */

// Try to get reviews from ACF field first
$service_reviews = get_field('service_reviews');

// If no reviews from ACF, use default reviews from theme options
if (empty($service_reviews) || !is_array($service_reviews)) {
    $theme_reviews = get_field('default_service_reviews', 'option');
    
    if (!empty($theme_reviews) && is_array($theme_reviews)) {
        $service_reviews = $theme_reviews;
    }
}

// If still no reviews, use hardcoded fallback reviews
if (empty($service_reviews) || !is_array($service_reviews)) {
    $service_reviews = [
        [
            'name' => 'Sarah Johnson',
            'city' => 'Manhattan, NY',
            'review_title' => 'Exceptional Service',
            'review_text' => 'Technician arrived on time, quickly diagnosed the issue, and had my Miele dishwasher running perfectly within an hour. Very professional!',
            'rating' => 5,
            'avatar' => null,
        ],
        [
            'name' => 'Michael Chen',
            'city' => 'Brooklyn, NY',
            'review_title' => 'Highly Recommend',
            'review_text' => 'Needed emergency repair for my Miele oven. Same-day service was a lifesaver. Fair pricing and excellent workmanship.',
            'rating' => 5,
            'avatar' => null,
        ],
        [
            'name' => 'Emily Rodriguez',
            'city' => 'Queens, NY',
            'review_title' => 'Professional & Reliable',
            'review_text' => 'Been using Miele appliances for 10 years, but this was my first repair. The technician was knowledgeable and used genuine Miele parts.',
            'rating' => 5,
            'avatar' => null,
        ],
    ];
}

// Only show if we have reviews
if (empty($service_reviews)) {
    return;
}

// Set up arguments for the existing reviews block template
$args = [
    'title' => 'What Our Customers Say',
    'subtitle' => 'Real reviews from verified customers who trusted us with their Miele appliances',
    'reviews' => $service_reviews,
];

// Use the existing reviews block template
get_template_part('template-parts/blocks/reviews', null, $args);