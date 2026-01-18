<?php $theme_uri = get_template_directory_uri(); ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>

    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/css/section3.css">
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <?php get_template_part('template-parts/header/top'); ?>



    <div class="header-inner">
        <!-- CTA слева, скрывается на мобилке -->
        <a href="#quick-form" class="header-cta">
            <span class="header-cta__icon"><img src="<?= $theme_uri ?>/assets/images/icon/icon-calendar.svg" alt="Calendar icon"></span>
            <span class="header-cta__text">BOOK ONLINE &amp; GET 15% OFF</span>
        </a>

        <!-- Логотип по центру -->
        <div class="header-logo-wrap">
            <a href="/" class="header-logo" aria-label="Go to homepage">
                <img src="<?= $theme_uri ?>/assets/images/logo.svg" alt="M repair">
            </a>
            <!-- Основное меню (десктоп / tablet) -->
            <nav class="main-nav">
                <ul class="main-nav__list">
                    <li class="main-nav__item main-nav__item--has-mega">
                        <button
                                class="main-nav__link js-nav-toggle"
                                type="button"
                                data-target="#services-mega"
                                aria-expanded="false"
                                aria-haspopup="true"
                        >
                            Services
                            <span class="main-nav__arrow"></span>
                        </button>


                    </li>

                    <li class="main-nav__item"><a href="/contact-us" class="main-nav__link">Contact Us</a></li>
                    <li class="main-nav__item"><a href="/areas" class="main-nav__link">Areas</a></li>
                </ul>
            </nav>


        </div>

        <!-- Телефон + бургер справа -->
        <div class="header-right">
            <a href="tel:+13478947974" class="header-phone">
                <span class="header-phone__icon"><img src="<?= $theme_uri ?>/assets/images/icon/icon-calling.svg" alt=""></span>
                <span class="header-phone__label">SERVICE LINE:</span>
                <span class="header-phone__number">+13478947974</span>
            </a>

            <button class="burger" type="button" aria-label="Open menu">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="28" height="28" fill="#191919" />
                    <path d="M23.5898 7.1792L5.12831 7.1792" stroke="white" stroke-width="2.05128" stroke-linecap="round" />
                    <path d="M23.5898 14.1025L5.12831 14.1025" stroke="white" stroke-width="2.05128" stroke-linecap="round" />
                    <path d="M23.5898 21.0254H5.12831" stroke="white" stroke-width="2.05128" stroke-linecap="round" />
                </svg>
            </button>
        </div>
    </div>

</header>

<?php get_template_part('template-parts/header/main-nav'); ?>

<?php get_template_part('template-parts/header/burger'); ?>
