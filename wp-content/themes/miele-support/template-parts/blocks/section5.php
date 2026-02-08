<?php declare(strict_types=1);

/**
 * Section 5 - Accent Block
 * 
 * @var array $args {
 *     @type string $title       Заголовок блока
 *     @type string $subtitle    Подзаголовок
 *     @type string $button_text Текст кнопки
 *     @type array  $button_link Ссылка (array с 'url')
 * }
 */

$title = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$button_text = $args['button_text'] ?? '';
$button_link = $args['button_link'] ?? [];

if (!$title && !$subtitle) {
    return;
}

// Извлечь URL из массива ссылки (как в home-catalog)
$link_url = '';
if (!empty($button_link) && is_array($button_link) && !empty($button_link['url'])) {
    $link_url = $button_link['url'];
}

$target = '';
if (!empty($button_link['target'])) {
    $target = 'target="' . esc_attr($button_link['target']) . '"';
}

?>

<section class="section5">
    <div class="section5__bg-decoration section5__bg-decoration--top-left"></div>
    <div class="section5__bg-decoration section5__bg-decoration--bottom-right"></div>
    
    <div class="container">
        <div class="section5__wrapper">
            <!-- Левая колонка: текст -->
            <div class="section5__text-group">
                <?php if ($title) : ?>
                    <h2 class="section5__title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="section5__subtitle">
                        <?php echo wp_kses_post($subtitle); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Правая колонка: кнопка -->
            <?php if ($button_text && $link_url) : ?>
                <div class="section5__actions">
                    <a href="<?php echo esc_url($link_url); ?>" class="btn btn--primary" <?php echo $target; ?>>
                        <?php echo esc_html($button_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
