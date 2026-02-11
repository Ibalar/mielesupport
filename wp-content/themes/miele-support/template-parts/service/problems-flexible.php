<?php

declare(strict_types=1);

/**
 * Service Problems Section - Flexible Content Version
 * Template part: template-parts/service/problems-flexible.php
 *
 * Displays common problems with alternating image/text layout (left/right)
 */

$section_data = get_query_var('section_data', []);

$problems = $section_data['problems'] ?? [];
$section_title = !empty($section_data['title']) ? $section_data['title'] : 'Common Problems We Fix';

if (empty($problems) || !is_array($problems)) {
    return;
}

$problem_count = count($problems);
?>

<section class="service-problems service-problems--alternating">
    <div class="service-problems__container">
        <div class="service-problems__header">
            <h2 class="service-problems__title"><?php echo esc_html($section_title); ?></h2>
            <?php if ($problem_count > 0): ?>
                <span class="service-problems__count"><?php echo esc_html((string) $problem_count); ?> Common Issues</span>
            <?php endif; ?>
        </div>

        <div class="service-problems__list">
            <?php
            foreach ($problems as $index => $problem):
                $question = $problem['question'] ?? '';
                $answer = $problem['answer'] ?? '';
                $image = $problem['image'] ?? [];

                if (empty($question)) continue;

                $is_even = ($index % 2 === 0);
                $position_class = $is_even ? 'service-problems__item--left' : 'service-problems__item--right';
                
                $image_url = '';
                $image_alt = '';
                
                if (is_array($image) && !empty($image)) {
                    $image_url = $image['url'] ?? '';
                    $image_alt = $image['alt'] ?? ($image['title'] ?? '');
                }
                ?>

                <div class="service-problems__item <?php echo esc_attr($position_class); ?>">
                    <?php if ($image_url): ?>
                        <div class="service-problems__image">
                            <img
                                src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr($image_alt); ?>"
                                loading="lazy"
                            >
                        </div>
                    <?php endif; ?>

                    <div class="service-problems__content">
                        <h3 class="service-problems__question">
                            <?php echo esc_html($question); ?>
                        </h3>
                        <?php if (!empty($answer)): ?>
                            <div class="service-problems__answer">
                                <?php echo wp_kses_post(wpautop($answer)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
