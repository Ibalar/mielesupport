<?php declare(strict_types=1);

/**
 * Service Flexible Content - Accent Section (Level 3)
 *
 * @var array $section_data {
 *     @type string $title       Заголовок
 *     @type string $subtitle    Подзаголовок/описание
 *     @type string $button_text Текст кнопки
 *     @type array  $button_link Ссылка кнопки (array с 'url', 'target')
 * }
 */

$data = get_query_var('section_data', []);

$title = $data['title'] ?? '';
$subtitle = $data['subtitle'] ?? '';
$button_text = $data['button_text'] ?? '';
$button_link = $data['button_link'] ?? [];

if (!$title && !$subtitle) {
    return;
}

$link_url = '';
$link_target = '';

if (is_array($button_link) && !empty($button_link['url'])) {
    $link_url = (string) $button_link['url'];
    $link_target = (string) ($button_link['target'] ?? '');
}

?>

<section class="service-accent">
    <div class="service-accent__bg-decoration service-accent__bg-decoration--top-left"></div>
    <div class="service-accent__bg-decoration service-accent__bg-decoration--bottom-right"></div>
    
    <div class="container">
        <div class="service-accent__wrapper">
            <div class="service-accent__text-group">
                <?php if ($title): ?>
                    <h2 class="service-accent__title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <div class="service-accent__subtitle">
                        <?php echo wp_kses_post($subtitle); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($button_text && $link_url): ?>
                <div class="service-accent__actions">
                    <a
                        href="<?php echo esc_url($link_url); ?>"
                        class="btn btn--primary"
                        <?php if ($link_target): ?>
                            target="<?php echo esc_attr($link_target); ?>"
                            <?php if ($link_target === '_blank'): ?>
                                rel="noopener noreferrer"
                            <?php endif; ?>
                        <?php endif; ?>
                    >
                        <?php echo esc_html($button_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
