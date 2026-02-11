<?php declare(strict_types=1);

/**
 * Service Flexible Content - Accent Section with Multiple Buttons (Level 3)
 *
 * @var array $section_data {
 *     @type string $title       Заголовок
 *     @type string $subtitle    Подзаголовок/описание
 *     @type array  $buttons     Список кнопок (repeater)
 * }
 */

$data = get_query_var('section_data', []);

$title = $data['title'] ?? '';
$subtitle = $data['subtitle'] ?? '';
$buttons = $data['buttons'] ?? [];

if (!$title && !$subtitle) {
    return;
}

?>

<section class="service-accent-buttons">
    <div class="service-accent-buttons__bg-decoration service-accent-buttons__bg-decoration--top-left"></div>
    <div class="service-accent-buttons__bg-decoration service-accent-buttons__bg-decoration--bottom-right"></div>
    
    <div class="container">
        <div class="service-accent-buttons__wrapper">
            <div class="service-accent-buttons__text-group">
                <?php if ($title): ?>
                    <h2 class="service-accent-buttons__title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <div class="service-accent-buttons__subtitle">
                        <?php echo wp_kses_post($subtitle); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($buttons) && is_array($buttons)): ?>
                <div class="service-accent-buttons__actions">
                    <?php foreach ($buttons as $button): 
                        $btn_text = $button['button_text'] ?? '';
                        $btn_link = $button['button_link'] ?? [];
                        $btn_style = $button['button_style'] ?? 'primary';
                        
                        if (!$btn_text) {
                            continue;
                        }
                        
                        $btn_url = '';
                        $btn_target = '';
                        
                        if (is_array($btn_link) && !empty($btn_link['url'])) {
                            $btn_url = (string) $btn_link['url'];
                            $btn_target = (string) ($btn_link['target'] ?? '');
                        }
                        
                        if (!$btn_url) {
                            continue;
                        }
                        
                        $btn_class = $btn_style === 'outline' ? 'btn btn--outline' : 'btn btn--primary';
                    ?>
                        <a
                            href="<?php echo esc_url($btn_url); ?>"
                            class="<?php echo esc_attr($btn_class); ?>"
                            <?php if ($btn_target): ?>
                                target="<?php echo esc_attr($btn_target); ?>"
                                <?php if ($btn_target === '_blank'): ?>
                                    rel="noopener noreferrer"
                                <?php endif; ?>
                            <?php endif; ?>
                        >
                            <?php echo esc_html($btn_text); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
