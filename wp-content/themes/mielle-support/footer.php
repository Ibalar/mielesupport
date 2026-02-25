<?php

declare(strict_types=1);

?>
</main><!-- #main -->

<footer class="site-footer">
    <div class="container">
        <div class="site-footer__inner">
            <!-- Footer Logo -->
            <div class="site-footer__logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-footer__logo-link">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Footer Navigation -->
            <nav class="site-footer__nav" aria-label="Footer Navigation">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>

            <!-- Copyright -->
            <div class="site-footer__copyright">
                <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
