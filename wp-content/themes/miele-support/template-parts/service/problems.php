<?php

declare(strict_types=1);

/**
 * Service Problems Section
 * Template part: template-parts/service/problems.php
 * 
 * Displays a grid of common problems that can be fixed
 */

// Get FAQ data from ACF - using it as a temporary solution for problems
$problems = get_field('faq');

// If no FAQ data, use hardcoded common problems for Miele appliances
if (empty($problems) || !is_array($problems)) {
    $problems = [
        [
            'question' => 'Not Cooling / Not Freezing',
            'answer' => 'Refrigerator or freezer not maintaining proper temperature or cooling at all.'
        ],
        [
            'question' => 'Leaking Water',
            'answer' => 'Water leakage from refrigerator, dishwasher, or washing machine causing puddles.'
        ],
        [
            'question' => 'Making Noise',
            'answer' => 'Unusual or loud noises coming from your appliance during operation.'
        ],
        [
            'question' => 'Not Draining',
            'answer' => 'Dishwasher or washing machine not draining water properly after cycle completion.'
        ],
        [
            'question' => 'Overheating',
            'answer' => 'Appliance getting too hot or showing signs of overheating during use.'
        ],
        [
            'question' => 'Display Error Codes',
            'answer' => 'Error codes or unusual displays appearing on your appliance control panel.'
        ],
        [
            'question' => 'Not Powering On',
            'answer' => 'Appliance not turning on or responding to power button presses.'
        ],
        [
            'question' => 'Cycle Issues',
            'answer' => 'Washing or drying cycles not completing properly or taking too long.'
        ]
    ];
}

// Only show section if we have problems to display
if (!empty($problems) && is_array($problems)):
    $problem_count = count($problems);
    ?>

    <section class="service-problems">
        <div class="service-problems__container">
            <h2 class="service-problems__title">Common Problems We Fix</h2>
            <?php if ($problem_count > 0): ?>
                <span class="service-problems__count"><?= esc_html((string) $problem_count); ?> Common Issues</span>
            <?php endif; ?>

            <div class="service-problems__grid">
                <?php
                // Define icons for common problems
                $problem_icons = [
                    'Not Cooling' => '❄️',
                    'Not Freezing' => '❄️',
                    'Leaking Water' => '💧',
                    'Making Noise' => '🔊',
                    'Not Draining' => '⚠️',
                    'Overheating' => '🌡️',
                    'Display Error' => '📱',
                    'Not Powering' => '💡',
                    'Cycle Issues' => '⏱️',
                    'Error Codes' => '📱'
                ];

                foreach ($problems as $index => $problem):
                    $question = $problem['question'] ?? '';
                    $answer = $problem['answer'] ?? '';
                    
                    if (empty($question)) continue;
                    
                    // Try to find the best matching icon
                    $icon = '🔧'; // Default wrench icon
                    foreach ($problem_icons as $keyword => $icon_char) {
                        if (stripos($question, $keyword) !== false) {
                            $icon = $icon_char;
                            break;
                        }
                    }
                    
                    // Limit description length for display
                    $description = wp_trim_words($answer, 15, '...');
                    ?>

                    <div class="service-problems__card">
                        <div class="service-problems__icon">
                            <?= esc_html($icon); ?>
                        </div>
                        <h3 class="service-problems__card-title">
                            <?= esc_html((string) $question); ?>
                        </h3>
                        <?php if (!empty($description)): ?>
                            <p class="service-problems__card-description">
                                <?= esc_html((string) $description); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php endif; ?>