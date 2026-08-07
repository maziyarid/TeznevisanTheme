<?php
/**
 * Header Template - Professional & Complete
 * Version: 3.0.2 - Fixed Logo Display & Mobile Layout
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.svg" type="image/svg+xml">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Page Loader -->
<div class="page-loader">
    <div class="loader-content">
        <div class="loader-spinner"></div>
        <p>در حال بارگذاری...</p>
    </div>
</div>

<!-- Skip to Content -->
<a href="#primary" class="skip-link screen-reader-text"><?php _e('پرش به محتوای اصلی', 'teznevisan'); ?></a>

<!-- Header -->
<header id="site-header" class="site-header" role="banner">
    <div class="header-main">
        <div class="container">
            <div class="header-inner">
                
                <!-- Mobile: Hamburger Menu (Right) - Only visible on mobile -->
                <button class="menu-toggle hamburger mobile-only" id="mobile-menu-toggle" aria-controls="mobile-navigation" aria-expanded="false" aria-label="<?php esc_attr_e('منوی موبایل', 'teznevisan'); ?>">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>

                <!-- Logo (Center on Mobile, Right on Desktop) -->
<div class="site-branding">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home" aria-label="<?php bloginfo('name'); ?>">
        <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            $logo_url = get_template_directory_uri() . '/assets/images/teznevisan.svg';
            $white_logo_url = get_template_directory_uri() . '/assets/images/white.svg';
            ?>
            <img src="<?php echo esc_url($logo_url); ?>" 
                 alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                 class="logo-default" 
                 style="display: block;">
            <img src="<?php echo esc_url($white_logo_url); ?>" 
                 alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                 class="logo-white" 
                 style="display: none;">
            <?php
        }
        ?>
    </a>
</div>


                <!-- Desktop Navigation (Center) -->
                <nav id="site-navigation" class="main-navigation desktop-only" role="navigation" aria-label="<?php esc_attr_e('منوی اصلی', 'teznevisan'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false,
                        'walker' => new Teznevisan_Icon_Walker_Nav_Menu(),
                    ));
                    ?>
                </nav>

                <!-- Header Actions (Left Side) -->
                <div class="header-actions">
                    <!-- Search Toggle -->
                    <button class="action-btn search-toggle" id="search-toggle" aria-label="<?php esc_attr_e('جستجو', 'teznevisan'); ?>" title="<?php esc_attr_e('جستجو', 'teznevisan'); ?>">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <!-- User Menu / Login -->
                    <?php if (is_user_logged_in()) :
                        $user = wp_get_current_user();
                        $telegram_photo = get_user_meta($user->ID, 'telegram_photo_url', true);
                    ?>
                        <div class="user-menu-wrapper">
                            <button class="user-menu-toggle" aria-expanded="false" aria-haspopup="true">
                                <?php if ($telegram_photo) : ?>
                                    <img src="<?php echo esc_url($telegram_photo); ?>" alt="<?php echo esc_attr($user->display_name); ?>" class="user-avatar">
                                <?php else : ?>
                                    <?php echo get_avatar($user->ID, 40); ?>
                                <?php endif; ?>
                                <span class="user-name desktop-only"><?php echo esc_html($user->display_name); ?></span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="user-menu-dropdown" role="menu">
                                <div class="user-menu-header">
                                    <?php if ($telegram_photo) : ?>
                                        <img src="<?php echo esc_url($telegram_photo); ?>" alt="<?php echo esc_attr($user->display_name); ?>" class="user-dropdown-avatar">
                                    <?php endif; ?>
                                    <div class="user-info">
                                        <strong><?php echo esc_html($user->display_name); ?></strong>
                                        <span><?php echo esc_html($user->user_email); ?></span>
                                    </div>
                                </div>
                                <div class="user-menu-divider"></div>
                                <a href="<?php echo esc_url(home_url('/my-account')); ?>" class="user-menu-item" role="menuitem">
                                    <i class="fa-solid fa-user"></i>
                                    <span><?php _e('پروفایل من', 'teznevisan'); ?></span>
                                </a>
                                <?php if (current_user_can('manage_options')) : ?>
                                <a href="<?php echo esc_url(admin_url()); ?>" class="user-menu-item" role="menuitem">
                                    <i class="fa-solid fa-gauge"></i>
                                    <span><?php _e('داشبورد', 'teznevisan'); ?></span>
                                </a>
                                <?php endif; ?>
                                <div class="user-menu-divider"></div>
                                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="user-menu-item logout" role="menuitem">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span><?php _e('خروج', 'teznevisan'); ?></span>
                                </a>
                            </div>
                        </div>
                    <?php else : ?>
                        <button class="action-btn telegram-login-btn" id="open-telegram-login" aria-label="<?php esc_attr_e('ورود', 'teznevisan'); ?>">
                            <i class="fa-brands fa-telegram"></i>
                            <span class="desktop-only"><?php _e('ورود', 'teznevisan'); ?></span>
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-navigation" class="mobile-menu" aria-hidden="true">
    <div class="mobile-menu-header">
        <div class="mobile-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php
                $logo_url = get_template_directory_uri() . '/assets/images/teznevisan.svg';
                echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
                ?>
            </a>
        </div>
        <button class="mobile-menu-close" aria-label="<?php esc_attr_e('بستن منو', 'teznevisan'); ?>">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <nav class="mobile-nav" role="navigation">
        <?php
        if (has_nav_menu('primary')) {
            $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary']);
            if ($menu_items) {
                echo '<ul class="mobile-nav-menu">';
                foreach ($menu_items as $item) {
                    if ($item->menu_item_parent == 0) {
                        $icon = get_post_meta($item->ID, '_menu_icon', true);
                        $color = get_post_meta($item->ID, '_menu_color', true);
                        $style = $color ? ' style="--menu-color: ' . esc_attr($color) . ';"' : '';
                        
                        $has_children = false;
                        foreach ($menu_items as $child) {
                            if ($child->menu_item_parent == $item->ID) {
                                $has_children = true;
                                break;
                            }
                        }
                        
                        echo '<li class="mobile-menu-item' . ($has_children ? ' has-submenu' : '') . '"' . $style . '>';
                        
                        if ($has_children) {
                            echo '<button class="submenu-toggle">';
                            if ($icon) echo '<i class="' . esc_attr($icon) . ' menu-icon"></i> ';
                            echo '<span>' . esc_html($item->title) . '</span>';
                            echo '<i class="fa-solid fa-chevron-down toggle-icon"></i>';
                            echo '</button>';
                            echo '<ul class="mobile-submenu">';
                            foreach ($menu_items as $child) {
                                if ($child->menu_item_parent == $item->ID) {
                                    $child_icon = get_post_meta($child->ID, '_menu_icon', true);
                                    echo '<li><a href="' . esc_url($child->url) . '">';
                                    if ($child_icon) echo '<i class="' . esc_attr($child_icon) . '"></i> ';
                                    echo esc_html($child->title);
                                    echo '</a></li>';
                                }
                            }
                            echo '</ul>';
                        } else {
                            echo '<a href="' . esc_url($item->url) . '">';
                            if ($icon) echo '<i class="' . esc_attr($icon) . ' menu-icon"></i> ';
                            echo '<span>' . esc_html($item->title) . '</span>';
                            echo '</a>';
                        }
                        
                        echo '</li>';
                    }
                }
                echo '</ul>';
            }
        }
        ?>
    </nav>
    
    <div class="mobile-menu-footer">
        <?php if (!is_user_logged_in()) : ?>
            <button class="mobile-login-btn" id="mobile-telegram-login">
                <i class="fa-brands fa-telegram"></i>
                <span><?php _e('ورود با تلگرام', 'teznevisan'); ?></span>
            </button>
        <?php endif; ?>
        
        <div class="mobile-social">
            <?php
            $socials = array(
                'telegram' => 'fa-brands fa-telegram',
                'instagram' => 'fa-brands fa-instagram',
                'whatsapp' => 'fa-brands fa-whatsapp',
            );
            
            foreach ($socials as $network => $icon) {
                $url = get_theme_mod($network . '_url');
                if ($url) {
                    echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr($network) . '">
                        <i class="' . esc_attr($icon) . '"></i>
                    </a>';
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay"></div>

<!-- Search Modal -->
<div id="search-modal" class="search-modal" role="dialog" aria-modal="true" aria-labelledby="search-title" aria-hidden="true">
    <div class="search-modal-overlay"></div>
    <div class="search-modal-content">
        <button class="search-modal-close" aria-label="<?php esc_attr_e('بستن جستجو', 'teznevisan'); ?>">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="search-modal-inner">
            <h2 id="search-title" class="search-modal-title"><?php _e('جستجو در سایت', 'teznevisan'); ?></h2>
            <p class="search-description"><?php _e('کلمه کلیدی مورد نظر خود را وارد کنید', 'teznevisan'); ?></p>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-input-wrapper">
                    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('جستجو...', 'placeholder', 'teznevisan'); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off">
                    <button type="submit" class="search-submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
            <div class="search-suggestions">
                <h3><?php _e('جستجوهای محبوب', 'teznevisan'); ?></h3>
                <div class="popular-searches">
                    <?php
                    $popular_tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 6));
                    if ($popular_tags) {
                        foreach ($popular_tags as $tag) {
                            echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="popular-search-tag">' . esc_html($tag->name) . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="search-results"></div>
        </div>
    </div>
</div>

<!-- Telegram Login Modal -->
<div id="telegram-login-modal" class="telegram-login-modal" role="dialog" aria-modal="true" aria-labelledby="telegram-modal-title" aria-hidden="true">
    <div class="telegram-login-overlay"></div>
    <div class="telegram-login-content">
        <button class="telegram-login-close" aria-label="<?php esc_attr_e('بستن', 'teznevisan'); ?>">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="telegram-modal-inner">
            <div class="telegram-icon">
                <i class="fa-brands fa-telegram"></i>
            </div>
            <h2 id="telegram-modal-title"><?php _e('ورود با تلگرام', 'teznevisan'); ?></h2>
            <p class="telegram-description"><?php _e('برای ورود به سایت، از طریق تلگرام وارد شوید:', 'teznevisan'); ?></p>
            <div id="telegram-widget-container"></div>
            <div class="telegram-benefits">
                <div class="benefit-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <span><?php _e('ورود سریع و آسان', 'teznevisan'); ?></span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span><?php _e('امنیت بالا', 'teznevisan'); ?></span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-user-check"></i>
                    <span><?php _e('بدون نیاز به رمز عبور', 'teznevisan'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accessibility Panel -->
<div id="accessibility-panel" class="accessibility-panel" aria-hidden="true" role="region" aria-labelledby="accessibility-title">
    <div class="accessibility-header">
        <h3 id="accessibility-title">
            <i class="fa-solid fa-universal-access"></i>
            <?php _e('دسترسی‌پذیری', 'teznevisan'); ?>
        </h3>
        <button class="accessibility-close" aria-label="<?php esc_attr_e('بستن', 'teznevisan'); ?>">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <div class="accessibility-options">
        <div class="accessibility-option">
            <label>
                <input type="checkbox" id="increase-font" class="accessibility-checkbox">
                <i class="fa-solid fa-text-height"></i>
                <span><?php _e('افزایش اندازه فونت', 'teznevisan'); ?></span>
            </label>
        </div>
        
        <div class="accessibility-option">
            <label>
                <input type="checkbox" id="high-contrast" class="accessibility-checkbox">
                <i class="fa-solid fa-adjust"></i>
                <span><?php _e('تضاد بالا', 'teznevisan'); ?></span>
            </label>
        </div>
        
        <div class="accessibility-option">
            <label>
                <input type="checkbox" id="underline-links" class="accessibility-checkbox">
                <i class="fa-solid fa-underline"></i>
                <span><?php _e('زیرخط پیوندها', 'teznevisan'); ?></span>
            </label>
        </div>
        
        <div class="accessibility-option">
            <label>
                <input type="checkbox" id="reduce-motion" class="accessibility-checkbox">
                <i class="fa-solid fa-running"></i>
                <span><?php _e('کاهش حرکت', 'teznevisan'); ?></span>
            </label>
        </div>
        
        <button class="reset-accessibility">
            <i class="fa-solid fa-rotate-right"></i>
            <?php _e('بازنشانی', 'teznevisan'); ?>
        </button>
    </div>
</div>

<!-- Edge Panel (Tools) -->
<div id="edge-panel" class="edge-panel">
    <button class="edge-toggle" aria-label="<?php esc_attr_e('ابزارها', 'teznevisan'); ?>">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div class="edge-content">
        <button id="accessibility-toggle" class="edge-btn" aria-label="<?php esc_attr_e('دسترسی‌پذیری', 'teznevisan'); ?>" title="<?php esc_attr_e('دسترسی‌پذیری', 'teznevisan'); ?>">
            <i class="fa-solid fa-universal-access"></i>
        </button>
        
        <button id="dark-mode-toggle" class="edge-btn" aria-label="<?php esc_attr_e('حالت تاریک', 'teznevisan'); ?>" title="<?php esc_attr_e('حالت تاریک', 'teznevisan'); ?>">
            <i class="fa-solid fa-moon"></i>
        </button>
        
        <button id="scroll-to-top" class="edge-btn" aria-label="<?php esc_attr_e('بازگشت به بالا', 'teznevisan'); ?>" title="<?php esc_attr_e('بازگشت به بالا', 'teznevisan'); ?>" style="display: none;">
            <i class="fa-solid fa-chevron-up"></i>
        </button>
    </div>
</div>

<!-- Chaty (Floating Contact) -->
<div id="chaty-container" class="chaty-container">
    <button class="chaty-toggle" aria-label="<?php esc_attr_e('تماس با ما', 'teznevisan'); ?>">
        <i class="fa-solid fa-comments chaty-main-icon"></i>
        <i class="fa-solid fa-xmark chaty-close-icon"></i>
    </button>
    <div class="chaty-channels">
        <?php do_action('teznevisan_render_chaty_buttons'); ?>
    </div>
</div>

<div id="page" class="site">
    <div id="primary" class="site-content">