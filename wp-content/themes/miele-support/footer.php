<?php declare(strict_types=1);

/**
 * Footer template
 */

?>

<footer class="footer">
    <div class="container">
        <!-- Логотип -->
        <div class="footer__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.svg" alt="Miele Support" class="footer__logo-img">
            </a>
        </div>

        <!-- Меню в 5 колонок -->
        <div class="footer__columns">
            <!-- Navigation -->
            <div class="footer__column">
                <h4 class="footer__column-title">Navigation</h4>
                <ul class="footer__menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/services">Services</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="footer__column">
                <h4 class="footer__column-title">Services</h4>
                <ul class="footer__menu">
                    <li><a href="/repair">Repair</a></li>
                    <li><a href="/maintenance">Maintenance</a></li>
                    <li><a href="/installation">Installation</a></li>
                    <li><a href="/diagnostics">Diagnostics</a></li>
                </ul>
            </div>

            <!-- KITCHEN -->
            <div class="footer__column">
                <h4 class="footer__column-title">KITCHEN</h4>
                <ul class="footer__menu">
                    <li><a href="/kitchen/ovens">Ovens</a></li>
                    <li><a href="/kitchen/cooktops">Cooktops</a></li>
                    <li><a href="/kitchen/dishwashers">Dishwashers</a></li>
                    <li><a href="/kitchen/refrigerators">Refrigerators</a></li>
                </ul>
            </div>

            <!-- LAUNDRY -->
            <div class="footer__column">
                <h4 class="footer__column-title">LAUNDRY</h4>
                <ul class="footer__menu">
                    <li><a href="/laundry/washing-machines">Washing Machines</a></li>
                    <li><a href="/laundry/dryers">Dryers</a></li>
                    <li><a href="/laundry/irons">Irons</a></li>
                </ul>
            </div>

            <!-- VACUUM CLEANERS -->
            <div class="footer__column">
                <h4 class="footer__column-title">VACUUM CLEANERS</h4>
                <ul class="footer__menu">
                    <li><a href="/vacuum/cordless">Cordless</a></li>
                    <li><a href="/vacuum/bagless">Bagless</a></li>
                    <li><a href="/vacuum/bagged">Bagged</a></li>
                    <li><a href="/vacuum/robot">Robot</a></li>
                </ul>
            </div>
        </div>

        <!-- Нижняя часть футера -->
        <div class="footer__bottom">
            <div class="footer__legal">
                <a href="/privacy-policy" class="footer__privacy">Privacy Policy</a>
            </div>

            <div class="footer__social">
                <a href="https://wa.me/1234567890" target="_blank" rel="noopener" class="footer__social-link" aria-label="WhatsApp">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.6 6.32A7.85 7.85 0 0 0 12 4a7.94 7.94 0 0 0-6.88 12.1L4 20l4.05-1.06A7.93 7.93 0 0 0 20 12a7.85 7.85 0 0 0-2.4-5.68zM12 18.5a6.46 6.46 0 0 1-3.3-.91l-.24-.14-2.47.65.66-2.4-.16-.25a6.46 6.46 0 0 1 5.51-9.88 6.46 6.46 0 0 1 6.5 6.5 6.47 6.47 0 0 1-6.5 6.43zm3.55-4.85l-.88-.44c-.24-.12-.4-.2-.57.2-.16.4-.56.48-.8.6-.24.12-.4.12-.64-.12-.24-.24-.92-.68-1.36-1.12-.36-.36-.6-.8-.68-1.04-.08-.24 0-.4.12-.52.12-.12.24-.32.36-.48.12-.16.16-.28.24-.44.08-.16.04-.32-.02-.44-.06-.12-.56-1.36-.76-1.84-.2-.48-.4-.4-.56-.4-.14 0-.3-.02-.46-.02-.16 0-.4.06-.6.32-.2.24-.76.76-.76 1.84 0 1.08.8 2.12.92 2.28.12.16 1.52 2.32 3.68 3.24.52.22.92.36 1.24.46.52.16 1 .14 1.36.08.42-.06 1.28-.52 1.46-1.02.18-.5.18-.92.12-1.02-.04-.08-.2-.16-.44-.28z" fill="currentColor"/>
                    </svg>
                </a>
                <a href="https://t.me/mielesupport" target="_blank" rel="noopener" class="footer__social-link" aria-label="Telegram">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z" fill="currentColor"/>
                    </svg>
                </a>
            </div>

            <div class="footer__copyright">
                COPYRIGHT © 2025 MIELE SUPPORT — ALL RIGHTS RESERVED. POWERED BY MIELE SUPPORT.
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
