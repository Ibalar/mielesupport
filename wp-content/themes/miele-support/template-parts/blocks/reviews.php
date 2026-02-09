<?php declare(strict_types=1);

/**
 * Reviews Block with Carousel
 *
 * @var array $args {
 *     @type string $title    Заголовок
 *     @type string $subtitle Подзаголовок
 *     @type array  $reviews  Массив отзывов
 * }
 */

$title = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$reviews = $args['reviews'] ?? [];

if (empty($reviews)) {
    return;
}

?>

<section class="reviews">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="reviews__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($subtitle) : ?>
            <p class="reviews__subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <div class="reviews__wrapper">
            <div class="reviews__track">
                <?php foreach ($reviews as $review) : ?>
                    <div class="reviews__card">
                        <div class="reviews__header">
                            <?php if (!empty($review['avatar']) && is_array($review['avatar'])) : ?>
                                <div class="reviews__avatar">
                                    <img
                                        src="<?php echo esc_url($review['avatar']['url']); ?>"
                                        alt="<?php echo esc_attr($review['avatar']['alt'] ?? $review['name'] ?? 'Avatar'); ?>"
                                        loading="lazy"
                                    >
                                </div>
                            <?php else : ?>
                                <div class="reviews__avatar reviews__avatar--placeholder">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div class="reviews__author">
                                <?php if (!empty($review['name'])) : ?>
                                    <div class="reviews__name"><?php echo esc_html($review['name']); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($review['city'])) : ?>
                                    <div class="reviews__city"><?php echo esc_html($review['city']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($review['review_title'])) : ?>
                            <h4 class="reviews__card-title"><?php echo esc_html($review['review_title']); ?></h4>
                        <?php endif; ?>

                        <?php if (!empty($review['review_text'])) : ?>
                            <p class="reviews__text"><?php echo esc_html($review['review_text']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($review['rating'])) :
                            $rating = intval($review['rating']);
                            $rating = max(1, min(5, $rating));
                        ?>
                            <div class="reviews__rating">
                                <span class="reviews__rating-text"><?php echo $rating; ?>/5</span>
                                <div class="reviews__stars">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <svg class="reviews__star<?php echo $i <= $rating ? ' is-active' : ''; ?>" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
