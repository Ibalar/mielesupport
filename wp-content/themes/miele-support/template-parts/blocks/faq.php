<?php declare(strict_types=1);

/**
 * FAQ Block with Accordion
 * 
 * @var array $args {
 *     @type string $title       Заголовок
 *     @type string $description Описание (WYSIWYG)
 *     @type array  $faq_items   Массив вопрос-ответ
 * }
 */

$title = $args['title'] ?? '';
$description = $args['description'] ?? '';
$faq_items = $args['faq_items'] ?? [];

if (empty($faq_items)) {
    return;
}

?>

<section class="faq">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="faq__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($description) : ?>
            <div class="faq__description"><?php echo wp_kses_post($description); ?></div>
        <?php endif; ?>

        <div class="faq__list">
            <?php foreach ($faq_items as $index => $item) : ?>
                <?php if (!empty($item['question'])) : ?>
                    <div class="faq__item" data-faq-item>
                        <button class="faq__question" type="button" aria-expanded="false">
                            <span class="faq__question-text"><?php echo esc_html($item['question']); ?></span>
                            <span class="faq__icon">
                                <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <g filter="url(#filter0_d_40000122_1588)">
                                    <rect x="25.1992" y="25.2" width="36" height="36" rx="18" fill="#C5C5C5" />
                                    <path d="M42.3757 36.2H44.0227V50.2H42.3757V36.2Z" fill="black" />
                                    <path d="M50.1992 42.3765V44.0235L36.1992 44.0235L36.1992 42.3765L50.1992 42.3765Z" fill="black" />
                                  </g>
                                  <defs>
                                    <filter id="filter0_d_40000122_1588" x="-0.000782967" y="-4.76837e-06" width="86.4" height="86.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                      <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                      <feMorphology radius="8.4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_40000122_1588" />
                                      <feOffset />
                                      <feGaussianBlur stdDeviation="16.8" />
                                      <feColorMatrix type="matrix" values="0 0 0 0 0.513333 0 0 0 0 0.5412 0 0 0 0 0.55 0 0 0 0.15 0" />
                                      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_40000122_1588" />
                                      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_40000122_1588" result="shape" />
                                    </filter>
                                  </defs>
                                </svg>
                            </span>
                        </button>
                        <div class="faq__answer">
                            <div class="faq__answer-content">
                                <?php echo wp_kses_post($item['answer']); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>