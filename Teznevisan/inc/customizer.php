<?php
/**
 * Theme Customizer
 * 
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer Settings
 */
function teznevisan_customize_register($wp_customize) {
    
    // ===== General Settings Panel =====
    $wp_customize->add_panel('teznevisan_general', array(
        'title' => __('تنظیمات عمومی تزنویسان', 'teznevisan'),
        'priority' => 10,
    ));
    
    // Site Identity Section
    $wp_customize->add_section('teznevisan_site_identity', array(
        'title' => __('هویت سایت', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 10,
    ));
    
    // Phone Number
    $wp_customize->add_setting('phone_number', array(
        'default' => '09162352304',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('phone_number', array(
        'label' => __('شماره تماس', 'teznevisan'),
        'section' => 'teznevisan_site_identity',
        'type' => 'text',
        'description' => __('شماره تماس سایت که در هدر و فوتر نمایش داده می‌شود', 'teznevisan'),
    ));
    
    // Email Address
    $wp_customize->add_setting('email_address', array(
        'default' => 'info@teznevisan3.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('email_address', array(
        'label' => __('ایمیل', 'teznevisan'),
        'section' => 'teznevisan_site_identity',
        'type' => 'email',
        'description' => __('آدرس ایمیل سایت', 'teznevisan'),
    ));
    
    // Address
    $wp_customize->add_setting('site_address', array(
        'default' => 'تهران، میدان ونک',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('site_address', array(
        'label' => __('آدرس', 'teznevisan'),
        'section' => 'teznevisan_site_identity',
        'type' => 'textarea',
        'description' => __('آدرس فیزیکی شرکت/سازمان', 'teznevisan'),
    ));
    
    // ===== Social Media Section =====
    $wp_customize->add_section('teznevisan_social_media', array(
        'title' => __('شبکه‌های اجتماعی', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 20,
    ));
    
    // Telegram
    $wp_customize->add_setting('telegram_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('telegram_url', array(
        'label' => __('آدرس تلگرام', 'teznevisan'),
        'section' => 'teznevisan_social_media',
        'type' => 'url',
        'description' => __('لینک کانال یا گروه تلگرام', 'teznevisan'),
    ));
    
    // Instagram
    $wp_customize->add_setting('instagram_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('instagram_url', array(
        'label' => __('آدرس اینستاگرام', 'teznevisan'),
        'section' => 'teznevisan_social_media',
        'type' => 'url',
        'description' => __('لینک پیج اینستاگرام', 'teznevisan'),
    ));
    
    // WhatsApp
    $wp_customize->add_setting('whatsapp_number', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('whatsapp_number', array(
        'label' => __('شماره واتساپ', 'teznevisan'),
        'section' => 'teznevisan_social_media',
        'type' => 'text',
        'description' => __('شماره واتساپ به همراه کد کشور (مثال: +989162352304)', 'teznevisan'),
    ));
    
    // LinkedIn
    $wp_customize->add_setting('linkedin_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('linkedin_url', array(
        'label' => __('آدرس لینکدین', 'teznevisan'),
        'section' => 'teznevisan_social_media',
        'type' => 'url',
        'description' => __('لینک پروفایل لینکدین', 'teznevisan'),
    ));
    
    // Twitter
    $wp_customize->add_setting('twitter_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('twitter_url', array(
        'label' => __('آدرس توییتر', 'teznevisan'),
        'section' => 'teznevisan_social_media',
        'type' => 'url',
        'description' => __('لینک پروفایل توییتر', 'teznevisan'),
    ));
    
    // ===== Colors Section =====
    $wp_customize->add_section('teznevisan_colors', array(
        'title' => __('رنگ‌های تم', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 30,
    ));
    
    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default' => '#1FA547',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('رنگ اصلی', 'teznevisan'),
        'section' => 'teznevisan_colors',
        'description' => __('رنگ اصلی تم که در دکمه‌ها و عناصر مهم استفاده می‌شود', 'teznevisan'),
    )));
    
    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default' => '#0f5d2a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => __('رنگ ثانویه', 'teznevisan'),
        'section' => 'teznevisan_colors',
        'description' => __('رنگ ثانویه تم', 'teznevisan'),
    )));
    
    // Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default' => '#FFD700',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('رنگ تاکیدی', 'teznevisan'),
        'section' => 'teznevisan_colors',
        'description' => __('رنگ برای بج‌ها و عناصر ویژه', 'teznevisan'),
    )));
    
    // ===== Typography Section =====
    $wp_customize->add_section('teznevisan_typography', array(
        'title' => __('تایپوگرافی', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 40,
    ));
    
    // Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default' => '16',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('base_font_size', array(
        'label' => __('اندازه فونت پایه', 'teznevisan'),
        'section' => 'teznevisan_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 20,
            'step' => 1,
        ),
        'description' => __('اندازه فونت پایه به پیکسل (پیش‌فرض: 16px)', 'teznevisan'),
    ));
    
    // Line Height
    $wp_customize->add_setting('base_line_height', array(
        'default' => '1.6',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('base_line_height', array(
        'label' => __('ارتفاع خط', 'teznevisan'),
        'section' => 'teznevisan_typography',
        'type' => 'text',
        'description' => __('ارتفاع خط متن (پیش‌فرض: 1.6)', 'teznevisan'),
    ));
    
    // ===== Header Settings =====
    $wp_customize->add_section('teznevisan_header', array(
        'title' => __('تنظیمات هدر', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 50,
    ));
    
    // Sticky Header
    $wp_customize->add_setting('sticky_header', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('sticky_header', array(
        'label' => __('هدر چسبنده', 'teznevisan'),
        'section' => 'teznevisan_header',
        'type' => 'checkbox',
        'description' => __('هدر هنگام اسکرول در بالای صفحه ثابت بماند', 'teznevisan'),
    ));
    
    // Show Search in Header
    $wp_customize->add_setting('header_search', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_search', array(
        'label' => __('نمایش جستجو در هدر', 'teznevisan'),
        'section' => 'teznevisan_header',
        'type' => 'checkbox',
        'description' => __('دکمه جستجو در هدر نمایش داده شود', 'teznevisan'),
    ));
    
    // ===== Footer Settings =====
    $wp_customize->add_section('teznevisan_footer', array(
        'title' => __('تنظیمات فوتر', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 60,
    ));
    
    // Footer Text
    $wp_customize->add_setting('footer_text', array(
        'default' => 'تمامی حقوق این سایت محفوظ است.',
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_text', array(
        'label' => __('متن کپی‌رایت', 'teznevisan'),
        'section' => 'teznevisan_footer',
        'type' => 'textarea',
        'description' => __('متنی که در پایین فوتر نمایش داده می‌شود', 'teznevisan'),
    ));
    
    // Show Footer Widgets
    $wp_customize->add_setting('footer_widgets', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_widgets', array(
        'label' => __('نمایش ویجت‌های فوتر', 'teznevisan'),
        'section' => 'teznevisan_footer',
        'type' => 'checkbox',
        'description' => __('ناحیه ویجت‌های فوتر نمایش داده شود', 'teznevisan'),
    ));
    
    // ===== Blog Settings =====
    $wp_customize->add_section('teznevisan_blog', array(
        'title' => __('تنظیمات وبلاگ', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 70,
    ));
    
    // Excerpt Length
    $wp_customize->add_setting('excerpt_length', array(
        'default' => 30,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('excerpt_length', array(
        'label' => __('طول خلاصه مطلب', 'teznevisan'),
        'section' => 'teznevisan_blog',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 5,
        ),
        'description' => __('تعداد کلمات خلاصه مطلب (پیش‌فرض: 30)', 'teznevisan'),
    ));
    
    // Show Author Box
    $wp_customize->add_setting('show_author_box', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_author_box', array(
        'label' => __('نمایش باکس نویسنده', 'teznevisan'),
        'section' => 'teznevisan_blog',
        'type' => 'checkbox',
        'description' => __('باکس اطلاعات نویسنده در پایان مطلب نمایش داده شود', 'teznevisan'),
    ));
    
    // Show Related Posts
    $wp_customize->add_setting('show_related_posts', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_related_posts', array(
        'label' => __('نمایش مطالب مرتبط', 'teznevisan'),
        'section' => 'teznevisan_blog',
        'type' => 'checkbox',
        'description' => __('مطالب مرتبط در انتهای مطلب نمایش داده شود', 'teznevisan'),
    ));
    
    // Related Posts Count
    $wp_customize->add_setting('related_posts_count', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('related_posts_count', array(
        'label' => __('تعداد مطالب مرتبط', 'teznevisan'),
        'section' => 'teznevisan_blog',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'step' => 1,
        ),
        'description' => __('تعداد مطالب مرتبط که نمایش داده شوند', 'teznevisan'),
    ));
    
    // ===== Performance Settings =====
    $wp_customize->add_section('teznevisan_performance', array(
        'title' => __('تنظیمات عملکرد', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 80,
    ));
    
    // Lazy Load Images
    $wp_customize->add_setting('lazy_load_images', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('lazy_load_images', array(
        'label' => __('بارگذاری تنبل تصاویر', 'teznevisan'),
        'section' => 'teznevisan_performance',
        'type' => 'checkbox',
        'description' => __('تصاویر به صورت تنبل (lazy) بارگذاری شوند', 'teznevisan'),
    ));
    
    // Minify CSS
    $wp_customize->add_setting('minify_css', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('minify_css', array(
        'label' => __('فشرده‌سازی CSS', 'teznevisan'),
        'section' => 'teznevisan_performance',
        'type' => 'checkbox',
        'description' => __('فایل‌های CSS به صورت خودکار فشرده شوند (نیاز به پلاگین کش)', 'teznevisan'),
    ));
    
    // ===== SEO Settings =====
    $wp_customize->add_section('teznevisan_seo', array(
        'title' => __('تنظیمات SEO', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 90,
    ));
    
    // Enable Breadcrumbs
    $wp_customize->add_setting('enable_breadcrumbs', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('enable_breadcrumbs', array(
        'label' => __('فعال‌سازی Breadcrumbs', 'teznevisan'),
        'section' => 'teznevisan_seo',
        'type' => 'checkbox',
        'description' => __('نمایش مسیر فعلی (Breadcrumbs) در صفحات', 'teznevisan'),
    ));
    
    // Enable Schema Markup
    $wp_customize->add_setting('enable_schema', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('enable_schema', array(
        'label' => __('فعال‌سازی Schema Markup', 'teznevisan'),
        'section' => 'teznevisan_seo',
        'type' => 'checkbox',
        'description' => __('افزودن خودکار Schema Markup به صفحات', 'teznevisan'),
    ));
    
    // Meta Description Length
    $wp_customize->add_setting('meta_description_length', array(
        'default' => 160,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('meta_description_length', array(
        'label' => __('طول توضیحات متا', 'teznevisan'),
        'section' => 'teznevisan_seo',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 100,
            'max' => 300,
            'step' => 10,
        ),
        'description' => __('حداکثر تعداد کاراکتر توضیحات متا', 'teznevisan'),
    ));
}
add_action('customize_register', 'teznevisan_customize_register');

/**
 * Customizer Live Preview
 */
function teznevisan_customize_preview_js() {
    wp_enqueue_script(
        'teznevisan-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('customize-preview'),
        TEZNEVISAN_VERSION,
        true
    );
}
add_action('customize_preview_init', 'teznevisan_customize_preview_js');

/**
 * Output Custom CSS from Customizer
 */
function teznevisan_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#1FA547');
    $secondary_color = get_theme_mod('secondary_color', '#0f5d2a');
    $accent_color = get_theme_mod('accent_color', '#FFD700');
    $base_font_size = get_theme_mod('base_font_size', 16);
    $line_height = get_theme_mod('base_line_height', '1.6');
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --primary-dark: <?php echo esc_attr($secondary_color); ?>;
            --accent-color: <?php echo esc_attr($accent_color); ?>;
            --base-font-size: <?php echo esc_attr($base_font_size); ?>px;
            --base-line-height: <?php echo esc_attr($line_height); ?>;
        }
        
        html {
            font-size: var(--base-font-size);
        }
        
        body {
            line-height: var(--base-line-height);
        }
        
        .btn-primary,
        .primary-btn,
        .button-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary:hover,
        .primary-btn:hover,
        .button-primary:hover {
            background-color: var(--primary-dark) !important;
        }
        
        a {
            color: var(--primary-color);
        }
        
        a:hover {
            color: var(--primary-dark);
        }
        
        .featured-badge,
        .badge-accent {
            background: var(--accent-color) !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'teznevisan_customizer_css');
