<?php declare(strict_types=1);

/**
 * Section 6 - Online Consultation Block
 *
 * @var array $args {
 *     @type array  $image        Изображение (array с 'url', 'alt')
 *     @type string $title        Заголовок блока
 *     @type string $description  Описание блока
 *     @type string $button_text  Текст кнопки
 *     @type array  $button_link  Ссылка (array с 'url')
 * }
 */

$image = $args['image'] ?? [];
$title = $args['title'] ?? '';
$description = $args['description'] ?? '';
$button_text = $args['button_text'] ?? '';
$button_link = $args['button_link'] ?? [];

$image_url = '';
$image_alt = '';

if (is_array($image) && !empty($image['url'])) {
    $image_url = (string) $image['url'];
    $image_alt = (string) ($image['alt'] ?? ($image['title'] ?? ''));
}

$link_url = '';
$link_target = '';

if (is_array($button_link) && !empty($button_link['url'])) {
    $link_url = (string) $button_link['url'];
    $link_target = (string) ($button_link['target'] ?? '');
}

if (!$title && !$description && !$image_url) {
    return;
}

?>

<section class="section6">

        <div class="section6__wrapper">
            <?php if ($image_url): ?>
                <div class="section6__image">
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr($image_alt); ?>"
                        loading="lazy"
                    >
                </div>
            <?php endif; ?>

            <div class="section6__content">
                <?php if ($title): ?>
                    <h2 class="section6__title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="section6__description">
                        <?php echo wp_kses_post($description); ?>
                    </p>
                <?php endif; ?>

                <?php if ($button_text && $link_url): ?>
                    <a
                        href="<?php echo esc_url($link_url); ?>"
                        class="btn btn--primary section6__button"
                        <?php if ($link_target): ?>
                            target="<?php echo esc_attr($link_target); ?>"
                        <?php endif; ?>
                    >
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
</section>
