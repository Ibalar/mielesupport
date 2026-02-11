<?php

declare(strict_types=1);

/**
 * Service Pricing Table Section - Table Layout (Flexible Content Version)
 * Template part: template-parts/service/pricing-table-comparison-flexible.php
 *
 * Displays pricing tiers in a comparison table format
 */

$section_data = get_query_var('section_data', []);

$pricing_plans = $section_data['pricing_plans'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'Service Pricing Comparison';
$section_subtitle = !empty($section_data['subtitle']) ? $section_data['subtitle'] : 'Compare our service packages to find the best option for your needs';

// Only show section if we have pricing data
if (empty($pricing_plans) || !is_array($pricing_plans)) {
    return;
}

// Collect all unique features across all plans
$all_features = [];
foreach ($pricing_plans as $plan) {
    $features = $plan['features'] ?? [];
    if (is_array($features)) {
        foreach ($features as $feature) {
            $feature_text = is_string($feature) ? $feature : ($feature['feature'] ?? '');
            if (!empty($feature_text) && !in_array($feature_text, $all_features)) {
                $all_features[] = $feature_text;
            }
        }
    }
}

?>

<section class="pricing-comparison">
    <div class="pricing-comparison__container">
        <div class="pricing-comparison__header">
            <h2 class="pricing-comparison__title"><?php echo esc_html($section_title); ?></h2>
            <p class="pricing-comparison__subtitle">
                <?php echo esc_html($section_subtitle); ?>
            </p>
        </div>

        <div class="pricing-comparison__table-wrapper">
            <table class="pricing-comparison__table">
                <thead>
                    <tr>
                        <th class="pricing-comparison__feature-col">Features</th>
                        <?php foreach ($pricing_plans as $plan): 
                            $title = $plan['title'] ?? '';
                            $featured = $plan['featured'] ?? false;
                            $th_class = 'pricing-comparison__plan-col';
                            if ($featured) {
                                $th_class .= ' pricing-comparison__plan-col--featured';
                            }
                            ?>
                            <th class="<?php echo esc_attr($th_class); ?>">
                                <?php if ($featured): ?>
                                    <span class="pricing-comparison__badge">Most Popular</span>
                                <?php endif; ?>
                                <span class="pricing-comparison__plan-name">
                                    <?php echo esc_html($title); ?>
                                </span>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="pricing-comparison__price-row">
                        <td class="pricing-comparison__feature-col">Price</td>
                        <?php foreach ($pricing_plans as $plan): 
                            $price = $plan['price'] ?? '';
                            $featured = $plan['featured'] ?? false;
                            $td_class = 'pricing-comparison__plan-col';
                            if ($featured) {
                                $td_class .= ' pricing-comparison__plan-col--featured';
                            }
                            ?>
                            <td class="<?php echo esc_attr($td_class); ?>">
                                <div class="pricing-comparison__price">
                                    <span class="pricing-comparison__currency">$</span>
                                    <span class="pricing-comparison__amount"><?php echo esc_html($price); ?></span>
                                </div>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_features as $feature): ?>
                        <tr>
                            <td class="pricing-comparison__feature-cell">
                                <?php echo esc_html($feature); ?>
                            </td>
                            <?php foreach ($pricing_plans as $plan): 
                                $plan_features = $plan['features'] ?? [];
                                $has_feature = false;
                                
                                if (is_array($plan_features)) {
                                    foreach ($plan_features as $pf) {
                                        $pf_text = is_string($pf) ? $pf : ($pf['feature'] ?? '');
                                        if ($pf_text === $feature) {
                                            $has_feature = true;
                                            break;
                                        }
                                    }
                                }
                                
                                $featured = $plan['featured'] ?? false;
                                $td_class = 'pricing-comparison__plan-col pricing-comparison__check-cell';
                                if ($featured) {
                                    $td_class .= ' pricing-comparison__plan-col--featured';
                                }
                                ?>
                                <td class="<?php echo esc_attr($td_class); ?>">
                                    <?php if ($has_feature): ?>
                                        <svg class="pricing-comparison__check-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="pricing-comparison__cross-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="pricing-comparison__feature-col"></td>
                        <?php foreach ($pricing_plans as $plan): 
                            $featured = $plan['featured'] ?? false;
                            $td_class = 'pricing-comparison__plan-col';
                            if ($featured) {
                                $td_class .= ' pricing-comparison__plan-col--featured';
                            }
                            ?>
                            <td class="<?php echo esc_attr($td_class); ?>">
                                <a href="#contact-form" class="pricing-comparison__cta">
                                    Book Now
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="pricing-comparison__footer">
            <p class="pricing-comparison__disclaimer">
                <svg class="pricing-comparison__disclaimer-icon" viewBox="0 0 20 20" fill="currentColor">
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
