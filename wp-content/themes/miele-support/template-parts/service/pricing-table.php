<?php

declare(strict_types=1);

/**
 * Service Pricing Table Section
 * Template part: template-parts/service/pricing-table.php
 * 
 * Displays pricing tiers for Miele appliance repair services
 */

// Get pricing data from ACF if available
$pricing_plans = get_field('pricing_plans');

// If no ACF data, use hardcoded pricing structure
if (empty($pricing_plans) || !is_array($pricing_plans)) {
    $pricing_plans = [
        [
            'title' => 'Diagnostic',
            'price' => '89',
            'description' => 'Professional inspection and diagnosis',
            'features' => [
                'Comprehensive system check',
                'Problem identification',
                'Repair estimate',
                'No-fix, no-fee guarantee'
            ],
            'icon' => '🔍'
        ],
        [
            'title' => 'Basic Repair',
            'price' => '199',
            'description' => 'Standard repair service',
            'features' => [
                'Includes diagnostic fee',
                'Common parts replacement',
                'Basic troubleshooting',
                '30-day warranty',
                'Same-day service available'
            ],
            'icon' => '🔧',
            'featured' => true
        ],
        [
            'title' => 'Full Service',
            'price' => '349',
            'description' => 'Complete maintenance and repair',
            'features' => [
                'Everything in Basic Repair',
                'Deep cleaning & maintenance',
                'Multiple issues fixed',
                '90-day warranty',
                'Priority scheduling'
            ],
            'icon' => '⭐'
        ]
    ];
}

// Only show section if we have pricing data
if (!empty($pricing_plans) && is_array($pricing_plans)):
    ?>

    <section class="pricing-table">
        <div class="pricing-table__container">
            <div class="pricing-table__header">
                <h2 class="pricing-table__title">Service Pricing</h2>
                <p class="pricing-table__subtitle">
                    Transparent pricing for quality Miele appliance repair
                </p>
            </div>

            <div class="pricing-table__grid">
                <?php foreach ($pricing_plans as $plan): 
                    $title = $plan['title'] ?? '';
                    $price = $plan['price'] ?? '';
                    $description = $plan['description'] ?? '';
                    $features = $plan['features'] ?? [];
                    $icon = $plan['icon'] ?? '📋';
                    $featured = $plan['featured'] ?? false;
                    
                    if (empty($title) || empty($price)) continue;
                    
                    $card_class = 'pricing-table__card';
                    if ($featured) {
                        $card_class .= ' pricing-table__card--featured';
                    }
                    ?>

                    <div class="<?= esc_attr($card_class); ?>">
                        <?php if ($featured): ?>
                            <div class="pricing-table__badge">Most Popular</div>
                        <?php endif; ?>
                        
                        <div class="pricing-table__card-header">
                            <?php if (!empty($icon)): ?>
                                <div class="pricing-table__icon">
                                    <?= esc_html($icon); ?>
                                </div>
                            <?php endif; ?>
                            
                            <h3 class="pricing-table__card-title">
                                <?= esc_html($title); ?>
                            </h3>
                            
                            <?php if (!empty($description)): ?>
                                <p class="pricing-table__card-description">
                                    <?= esc_html($description); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="pricing-table__price-wrapper">
                            <span class="pricing-table__price-prefix">Starting from</span>
                            <div class="pricing-table__price">
                                <span class="pricing-table__currency">$</span>
                                <span class="pricing-table__amount"><?= esc_html($price); ?></span>
                            </div>
                        </div>

                        <?php if (!empty($features) && is_array($features)): ?>
                            <ul class="pricing-table__features">
                                <?php foreach ($features as $feature): ?>
                                    <li class="pricing-table__feature">
                                        <svg class="pricing-table__feature-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span><?= esc_html($feature); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <a href="#contact-form" class="pricing-table__cta">
                            Book Service
                            <svg class="pricing-table__cta-arrow" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>

            <div class="pricing-table__footer">
                <p class="pricing-table__disclaimer">
                    <svg class="pricing-table__disclaimer-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>
                        Prices vary based on appliance model, issue complexity, and parts required. 
                        Contact us for an accurate quote. Diagnostic fee may be waived with repair.
                    </span>
                </p>
            </div>
        </div>
    </section>

<?php endif; ?>
