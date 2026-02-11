<?php

declare(strict_types=1);

/**
 * Service Reviews Section - Flexible Content Version
 * Template part: template-parts/service/reviews-flexible.php
 */

$section_data = get_query_var('section_data', []);

// Get reviews from flexible content
$service_reviews = $section_data['service_reviews'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'What Our Customers Say';
$section_subtitle = !empty($section_data['subtitle']) ? $section_data['subtitle'] : 'Real reviews from verified customers who trusted us with their Miele appliances';

// Only show if we have reviews
if (empty($service_reviews) || !is_array($service_reviews)) {
    return;
}

// Set up arguments for the existing reviews block template
$args = [
    'title' => $section_title,
    'subtitle' => $section_subtitle,
    'reviews' => $service_reviews,
];

// Use the existing reviews block template
get_template_part('template-parts/blocks/reviews', null, $args);
