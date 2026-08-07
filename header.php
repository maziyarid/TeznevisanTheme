<?php
/**
 * Theme header.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e('Skip to content', 'teznevisan'); ?>
</a>

<header id="site-header" class="site-header" role="banner">
    <div class="container header-container">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                </a>
            <?php endif; ?>
        </div>

        <button class="mobile-menu-toggle" id="mobile-menu-toggle" type="button"
                aria-controls="mobile-menu-overlay" aria-expanded="false"
                aria-label="<?php esc_attr_e('Open main menu', 'teznevisan'); ?>">
            <span class="hamburger-lines" aria-hidden="true">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </span>
        </button>

        <nav class="main-navigation" aria-label="<?php esc_attr_e('Primary menu', 'teznevisan'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'menu_class'     => 'primary-menu',
                )
            );
            ?>
        </nav>

        <div class="header-actions">
            <button class="search-toggle" id="search-toggle" type="button"
                    aria-controls="search-modal" aria-expanded="false"
                    aria-label="<?php esc_attr_e('Open search', 'teznevisan'); ?>">
                <span aria-hidden="true">&#128269;</span>
            </button>
        </div>
    </div>

    <div id="mobile-menu-overlay" class="mobile-menu-overlay" aria-hidden="true" hidden>
        <div class="mobile-menu-panel" role="dialog" aria-modal="true"
             aria-label="<?php esc_attr_e('Main menu', 'teznevisan'); ?>">
            <button id="mobile-menu-close" class="mobile-menu-close" type="button"
                    aria-label="<?php esc_attr_e('Close menu', 'teznevisan'); ?>">&times;</button>
            <nav class="mobile-navigation" id="mobile-navigation"
                 aria-label="<?php esc_attr_e('Mobile menu', 'teznevisan'); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'menu_class'     => 'mobile-menu-list',
                    )
                );
                ?>
            </nav>
        </div>
    </div>

    <div id="search-modal" class="search-modal" hidden aria-hidden="true">
        <div class="search-modal-inner" role="dialog" aria-modal="true"
             aria-label="<?php esc_attr_e('Site search', 'teznevisan'); ?>">
            <button class="search-modal-close" type="button"
                    aria-label="<?php esc_attr_e('Close search', 'teznevisan'); ?>">&times;</button>
            <?php get_search_form(); ?>
        </div>
    </div>
</header>

<div id="chaty-widget" class="chaty-widget" aria-label="<?php esc_attr_e('Contact options', 'teznevisan'); ?>">
    <button id="chaty-toggle" class="chaty-toggle" type="button" aria-expanded="false"
            aria-controls="chaty-channels" aria-label="<?php esc_attr_e('Open contact options', 'teznevisan'); ?>">
        <span aria-hidden="true">&#128222;</span>
    </button>
    <div id="chaty-channels" class="chaty-channels" hidden>
        <?php $phone = get_theme_mod('phone_number', ''); ?>
        <?php $telegram = get_theme_mod('telegram_url', ''); ?>
        <?php if ($phone) : ?>
            <a class="contact-link" data-platform="phone" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                <?php esc_html_e('Call', 'teznevisan'); ?>
            </a>
        <?php endif; ?>
        <?php if ($telegram) : ?>
            <a class="contact-link" data-platform="telegram" href="<?php echo esc_url($telegram); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e('Telegram', 'teznevisan'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
