<?php

declare(strict_types=1);

/**
 * 404 Not Found template
 * Supports breadcrumbs for error page
 */

get_header();
?>

<main class="error-404">
    <div class="container">
        <?php render_breadcrumbs(); ?>

        <div class="error-404__content">
            <header class="error-404__header">
                <h1 class="error-404__title"><?php _e('404 - Page Not Found', 'miele-support'); ?></h1>
                <p class="error-404__description">
                    <?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'miele-support'); ?>
                </p>
            </header>

            <div class="error-404__actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php _e('Go to Homepage', 'miele-support'); ?>
                </a>

                <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn btn-outline">
                    <?php _e('Browse Services', 'miele-support'); ?>
                </a>
            </div>

        </div>
    </div>
</main>

<?php get_footer(); ?>
