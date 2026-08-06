<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl" lang="fa-IR">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (!class_exists('RankMath')) : ?>
        <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php endif; ?>

    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon-96x96.png" sizes="96x96">

    <!-- Chaty Fix CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/chaty-fix.css" media="all">

    <?php wp_head(); ?>
</head>

<body <?php body_class('rtl persian'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <header id="masthead" class="site-header" role="banner">
        <div class="header-main-container">
            <div class="header-main">

                <!-- Logo -->
                <div class="site-branding">
                    <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
                        <div class="logo-wrapper">
                            <?php if (has_custom_logo()) :
                                the_custom_logo();
                            else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/teznevisan.webp"
                                     alt="<?php bloginfo('name'); ?>"
                                     class="default-logo">
                            <?php endif; ?>
                        </div>
                        <div class="site-info">
                            <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                            <span class="site-description"><?php bloginfo('description'); ?></span>
                        </div>
                    </a>
                </div>

                <!-- Header Actions -->
                <div class="header-actions">

                    <!-- Mobile Menu Toggle Button -->
                    <button class="mobile-menu-toggle" aria-label="باز کردن منوی اصلی" aria-expanded="false" aria-controls="mobile-menu-overlay">
                        <span class="hamburger-lines">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </span>
                    </button>

                    <!-- Primary Navigation -->
                    <?php if (has_nav_menu('primary')) : ?>
                        <nav class="main-navigation desktop-nav" role="navigation" aria-label="منوی اصلی">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'container'      => false,
                                'menu_class'     => 'primary-menu',
                                'fallback_cb'    => 'wp_page_menu',
                                'depth'          => 2
                            ));
                            ?>
                        </nav>
                    <?php endif; ?>

                    <!-- Search Button -->
                    <button class="search-toggle"
                            id="search-toggle"
                            aria-expanded="false"
                            aria-controls="search-modal"
                            aria-label="باز کردن جستجو"
                            type="button">
                        <i class="fa-solid fa-search" aria-hidden="true"></i>
                    </button>

                    <!-- CTA -->
                    <a class="header-cta" href="<?php echo esc_url(home_url('/contact')); ?>">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span class="action-text">تماس</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="mobile-menu-overlay" aria-hidden="true">
            <div class="mobile-menu-wrapper">
                <div class="mobile-menu-header">
                    <span id="mobile-menu-title">منوی اصلی</span>
                    <button class="mobile-menu-close" id="mobile-menu-close" aria-label="بستن منو">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="mobile-menu-content">
                    <nav class="mobile-navigation" role="navigation" aria-labelledby="mobile-menu-title">
                        <?php
                        // Prefer mobile menu, otherwise fallback to primary
                        $mobile_menu_args = array(
                            'theme_location' => has_nav_menu('mobile') ? 'mobile' : 'primary',
                            'container'      => false,
                            'menu_class'     => 'mobile-menu',
                            'fallback_cb'    => '__return_false',
                            'depth'          => 2,
                            'echo'           => true
                        );

                        if (has_nav_menu('mobile') || has_nav_menu('primary')) {
                            wp_nav_menu($mobile_menu_args);
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>

    </header>

    <!-- Search Modal -->
    <div class="search-modal" id="search-modal" aria-hidden="true">
        <div class="search-modal-inner">
            <div class="search-modal-header">
                <h3>جستجو در سایت</h3>
                <button class="search-close" id="search-close" aria-label="بستن جستجو" type="button">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <form class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-group">
                    <input type="search"
                           name="s"
                           class="search-field"
                           placeholder="جستجوی مطالب..."
                           autocomplete="search">
                    <button type="submit" class="search-submit">
                        <i class="fa-solid fa-search" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="search-suggestions">
                    <h4>جستجوهای محبوب:</h4>
                    <div class="popular-searches">
                        <button type="button" class="search-tag" data-search="پایان نامه">پایان نامه</button>
                        <button type="button" class="search-tag" data-search="مقاله علمی">مقاله علمی</button>
                        <button type="button" class="search-tag" data-search="ترجمه">ترجمه</button>
                        <button type="button" class="search-tag" data-search="پروپوزال">پروپوزال</button>
                        <button type="button" class="search-tag" data-search="ویرایش">ویرایش</button>
                        <button type="button" class="search-tag" data-search="تایپ">تایپ</button>
                    </div>
                </div>
                <div class="search-results" id="search-results"></div>
            </form>
        </div>
    </div>

    <!-- Chaty Widget -->
    <div id="chaty-widget" class="chaty-widget">
        <button id="chaty-toggle"
                class="chaty-toggle"
                aria-label="ارتباط با ما"
                aria-expanded="false"
                aria-controls="chaty-channels"
                type="button">
            <i class="fa-solid fa-comments" aria-hidden="true"></i>
        </button>
        <div id="chaty-channels" class="chaty-channels" aria-hidden="true">
            <a href="<?php echo get_theme_mod('whatsapp_url', 'https://wa.me/989331663849'); ?>" class="contact-link whatsapp" target="_blank" rel="noopener" aria-label="واتساپ">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                <span class="sr-only">واتساپ</span>
            </a>
            <a href="tel:<?php echo get_theme_mod('phone_number', '09331663849'); ?>" class="contact-link phone" aria-label="تماس تلفنی">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                <span class="sr-only">تماس تلفنی</span>
            </a>
            <a href="sms:<?php echo get_theme_mod('phone_number', '09331663849'); ?>" class="chaty-channel sms" aria-label="ارسال پیامک">
                <i class="fa-solid fa-comment-sms" aria-hidden="true"></i>
                <span class="sr-only">پیامک</span>
            </a>
            <a href="<?php echo get_theme_mod('email_url', 'mailto:teznevisan@gmail.com'); ?>" class="chaty-channel email" target="_blank" rel="noopener" aria-label="ایمیل">
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                <span class="sr-only">ایمیل</span>
            </a>
            <a href="<?php echo get_theme_mod('telegram_url', 'https://t.me/teznevisan'); ?>" class="contact-link telegram" target="_blank" rel="noopener" aria-label="تلگرام">
                <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                <span class="sr-only">تلگرام</span>
            </a>
            <a href="<?php echo get_theme_mod('eitaa_url', 'https://eitaa.com/teznevisan'); ?>" class="chaty-channel eitaa" target="_blank" rel="noopener" aria-label="ایتــا">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                <span class="sr-only">ایتا</span>
            </a>
        </div>
    </div>

    <main id="main" class="site-main" role="main">
