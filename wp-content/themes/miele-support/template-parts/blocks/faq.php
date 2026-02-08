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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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