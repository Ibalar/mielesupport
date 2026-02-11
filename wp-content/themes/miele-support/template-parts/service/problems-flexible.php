<?php

declare(strict_types=1);

/**
 * Service Problems Section - Flexible Content Version
 * Template part: template-parts/service/problems-flexible.php
 *
 * Displays a grid of common problems that can be fixed
 */

$section_data = get_query_var('section_data', []);

$problems = $section_data['problems'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'Common Problems We Fix';

// Only show section if we have problems to display
if (empty($problems) || !is_array($problems)) {
    return;
}

$problem_count = count($problems);
?>

<section class="service-problems">
    <div class="service-problems__container">
        <h2 class="service-problems__title"><?php echo esc_html($section_title); ?></h2>
        <?php if ($problem_count > 0): ?>
            <span class="service-problems__count"><?php echo esc_html((string) $problem_count); ?> Common Issues</span>
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
                        <?php echo esc_html($icon); ?>
                    </div>
                    <h3 class="service-problems__card-title">
                        <?php echo esc_html((string) $question); ?>
                    </h3>
                    <?php if (!empty($description)): ?>
                        <p class="service-problems__card-description">
                            <?php echo esc_html((string) $description); ?>
                        </p>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
