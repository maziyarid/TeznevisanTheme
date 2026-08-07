<?php
/**
 * Theme Name: Teznevisan
 * Functions and definitions
 * Version: 3.0.0 - Production Ready
 *
 * @package Teznevisan
 */

if (!defined('TEZNEVISAN_VERSION')) {
    define('TEZNEVISAN_VERSION', '3.0.0');
}
if (!defined('TEZNEVISAN_DIR')) {
    define('TEZNEVISAN_DIR', get_template_directory());
}
if (!defined('TEZNEVISAN_URI')) {
    define('TEZNEVISAN_URI', get_template_directory_uri());
}
if (!defined('TEZNEVISAN_ASSETS_URI')) {
    define('TEZNEVISAN_ASSETS_URI', TEZNEVISAN_URI . '/assets');
}
if (!defined('TEZNEVISAN_INC_DIR')) {
    define('TEZNEVISAN_INC_DIR', TEZNEVISAN_DIR . '/inc');
}

// Admin Bar Control
add_filter('show_admin_bar', function($show) {
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        return false;
    }
    return $show;
}, 999);

add_action('init', function() {
    if (!is_admin() && (!is_user_logged_in() || !current_user_can('manage_options'))) {
        show_admin_bar(false);
    }
}, 0);

add_action('wp_head', function() {
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        echo '<style type="text/css">
            #wpadminbar { display: none !important; }
            html { margin-top: 0 !important; }
            body { margin-top: 0 !important; }
            * html body { margin-top: 0 !important; }
        </style>';
    }
}, 999);

// Theme Setup
function teznevisan_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('custom-logo', [
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    
    register_nav_menus([
        'primary' => __('منوی اصلی (هدر)', 'teznevisan'),
        'footer-links' => __('منوی فوتر (حریم خصوصی، قوانین، ...)', 'teznevisan'),
    ]);
    
    add_image_size('teznevisan-featured', 1200, 675, true);
    add_image_size('post-thumbnail-large', 1200, 675, true);
    add_image_size('post-thumbnail-medium', 800, 450, true);
    add_image_size('related-post-thumb', 400, 225, true);
    
    add_editor_style();
}
add_action('after_setup_theme', 'teznevisan_setup');

/**
 * Enqueue Styles - FIXED PRIORITY ORDER
 */

/**
 * Teznevisan Theme - Updated CSS Enqueue (NO PRELOAD)
 * Version: 4.0.1
 * 
 * FIXES: 
 * - Removed preload warnings
 * - Uses @import in style-4.css instead
 * - Proper loading order
 * - Conditional loading for single posts
 */

function teznevisan_enqueue_styles() {
    // Load each CSS file with WordPress (NOT @import)
    wp_enqueue_style(
        'teznevisan-variables',
        get_template_directory_uri() . '/assets/css/unified-variables.css',
        array(),
        '4.0.1'
    );
    
    wp_enqueue_style(
        'teznevisan-base',
        get_template_directory_uri() . '/assets/css/base-styles.css',
        array('teznevisan-variables'),
        '4.0.1'
    );
    
    wp_enqueue_style(
        'teznevisan-header-footer',
        get_template_directory_uri() . '/assets/css/header-footer.css',
        array('teznevisan-base'),
        '4.0.1'
    );
    
    wp_enqueue_style(
        'teznevisan-single-post',
        get_template_directory_uri() . '/assets/css/single-post-fixed-corrected.css',
        array('teznevisan-base'),
        '4.0.1'
    );
}
add_action('wp_enqueue_scripts', 'teznevisan_enqueue_styles', 10);


/**
 * Remove conflicting styles from plugins or other sources
 */
function teznevisan_dequeue_conflicting_styles() {
    // Remove old conflicting styles
    wp_dequeue_style('main-8');
    wp_dequeue_style('style-2');
    wp_dequeue_style('single-post-3');

    // Remove any other plugin styles that conflict
    // wp_dequeue_style('plugin-conflicting-style');
}
add_action('wp_enqueue_scripts', 'teznevisan_dequeue_conflicting_styles', 100);

/**
 * Add body classes for better CSS targeting
 */
function teznevisan_body_classes($classes) {
    // Add single post class
    if (is_single()) {
        $classes[] = 'single-post';
    }

    // Add page template class
    if (is_page_template()) {
        $template = get_page_template_slug();
        $classes[] = 'template-' . sanitize_html_class(str_replace('.php', '', $template));
    }

    // Add archive class
    if (is_archive()) {
        $classes[] = 'archive-page';
    }

    return $classes;
}
add_filter('body_class', 'teznevisan_body_classes');

/**
 * Remove inline styles that might conflict
 */
function teznevisan_remove_inline_styles() {
    // Remove Gutenberg block styles if conflicting
    // wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'teznevisan_remove_inline_styles', 99);

/**
 * Optional: Add custom CSS for specific features
 * Load AFTER all theme styles
 */
function teznevisan_enqueue_custom_styles() {
    // Only add if you have custom styles for specific features
    // wp_enqueue_style(
    //     'teznevisan-custom',
    //     get_template_directory_uri() . '/assets/css/custom.css',
    //     array('teznevisan-style'),
    //     '4.0.1',
    //     'all'
    // );
}
add_action('wp_enqueue_scripts', 'teznevisan_enqueue_custom_styles', 20);


/**
 * Add preload hints for critical CSS files
 */
function teznevisan_preload_critical_css() {
    ?>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/unified-variables.css" as="style">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/base-styles.css" as="style">
    <?php
}
add_action('wp_head', 'teznevisan_preload_critical_css', 1);


// AJAX Search
function teznevisan_ajax_search() {
    check_ajax_referer('teznevisan-ajax-nonce', 'nonce');
    
    $query = sanitize_text_field($_POST['search']);
    
    $args = [
        'post_type' => 'post',
        'posts_per_page' => 5,
        's' => $query,
        'post_status' => 'publish',
    ];
    
    $search_query = new WP_Query($args);
    $results = [];
    
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $results[] = [
                'title' => get_the_title(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 20),
                'url' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(null, 'thumbnail') ?: '',
            ];
        }
    }
    
    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_teznevisan_search', 'teznevisan_ajax_search');
add_action('wp_ajax_nopriv_teznevisan_search', 'teznevisan_ajax_search');

// Telegram Login Handler
function teznevisan_handle_telegram_callback() {
    if (!isset($_GET['tg_auth'])) return;
    
    $telegram_data = [];
    $fields = ['id', 'first_name', 'last_name', 'username', 'photo_url', 'auth_date', 'hash'];
    
    foreach ($fields as $field) {
        if (isset($_GET[$field])) {
            $telegram_data[$field] = $_GET[$field];
        }
    }
    
    if (empty($telegram_data) || empty($telegram_data['hash'])) {
        wp_redirect(home_url('/'));
        exit;
    }
    
    $user_login = 'tg_' . sanitize_user($telegram_data['username'] ?? 'user_' . $telegram_data['id']);
    $user_email = $user_login . '@telegram.local';
    
    $user = get_user_by('login', $user_login);
    
    if (!$user) {
        $user_id = wp_create_user(
            $user_login,
            wp_generate_password(),
            $user_email
        );
        
        if (is_wp_error($user_id)) {
            wp_redirect(home_url('/'));
            exit;
        }
        
        $user = get_user_by('id', $user_id);
        
        wp_update_user([
            'ID' => $user_id,
            'display_name' => sanitize_text_field($telegram_data['first_name'] . ' ' . ($telegram_data['last_name'] ?? '')),
            'user_nicename' => $user_login,
            'role' => 'subscriber'
        ]);
    }
    
    update_user_meta($user->ID, 'telegram_id', intval($telegram_data['id']));
    update_user_meta($user->ID, 'first_name', sanitize_text_field($telegram_data['first_name']));
    
    if (isset($telegram_data['last_name'])) {
        update_user_meta($user->ID, 'last_name', sanitize_text_field($telegram_data['last_name']));
    }
    if (isset($telegram_data['username'])) {
        update_user_meta($user->ID, 'telegram_username', sanitize_text_field($telegram_data['username']));
    }
    if (isset($telegram_data['photo_url'])) {
        update_user_meta($user->ID, 'telegram_photo_url', esc_url_raw($telegram_data['photo_url']));
    }
    
    wp_clear_auth_cookie();
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID, true);
    do_action('wp_login', $user->user_login, $user);
    
    wp_redirect(home_url('/my-account'));
    exit;
}
add_action('init', 'teznevisan_handle_telegram_callback');

// My Account Page
add_action('init', function() {
    add_rewrite_endpoint('my-account', EP_ROOT | EP_PAGES);
});

add_filter('query_vars', function($vars) {
    $vars[] = 'my-account';
    return $vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('my-account') && is_user_logged_in()) {
        return TEZNEVISAN_DIR . '/template-my-account.php';
    }
    return $template;
});

add_action('init', function() {
    if (isset($_POST['update_profile']) && wp_verify_nonce($_POST['_wpnonce'], 'update_profile')) {
        $user_id = get_current_user_id();
        wp_update_user([
            'ID' => $user_id,
            'first_name' => sanitize_text_field($_POST['first_name']),
            'last_name' => sanitize_text_field($_POST['last_name']),
            'description' => sanitize_textarea_field($_POST['description']),
        ]);
    }
});

// Menu Icon Walker
class Teznevisan_Icon_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $icon = get_post_meta($item->ID, '_menu_icon', true);
        $color = get_post_meta($item->ID, '_menu_color', true);
        
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        if ($item->current) {
            $classes[] = 'current-menu-item';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $style = $color ? ' style="--menu-color: ' . esc_attr($color) . ';"' : '';
        
        $output .= '<li' . $class_names . $style . '>';
        
        $atts = [];
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        
        if ($icon) {
            $item_output .= '<i class="' . esc_attr($icon) . ' menu-icon"></i> ';
        }
        
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Menu Icon Fields
add_action('wp_nav_menu_item_custom_fields', function($item_id, $item, $depth, $args) {
    $menu_icon = get_post_meta($item_id, '_menu_icon', true);
    $menu_color = get_post_meta($item_id, '_menu_color', true);
    ?>
    <p class="field-menu-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php _e('آیکون منو (Font Awesome 7 Pro)'); ?><br>
            <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr($menu_icon); ?>">
            <span class="description">مثال: fa-solid fa-home</span>
        </label>
    </p>
    <p class="field-menu-color description description-wide">
        <label for="edit-menu-item-color-<?php echo $item_id; ?>">
                        <?php _e('رنگ منو'); ?><br>
            <input type="color" id="edit-menu-item-color-<?php echo $item_id; ?>" name="menu-item-color[<?php echo $item_id; ?>]" value="<?php echo esc_attr($menu_color); ?>">
        </label>
    </p>
    <?php
}, 10, 4);

add_action('wp_update_nav_menu_item', function($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_icon', sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]));
    }
    if (isset($_POST['menu-item-color'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_color', sanitize_hex_color($_POST['menu-item-color'][$menu_item_db_id]));
    }
}, 10, 3);

// Customizer
function teznevisan_customize_register($wp_customize) {
    // General Panel
    $wp_customize->add_panel('teznevisan_general', array(
        'title' => __('تنظیمات عمومی تزنویسان', 'teznevisan'),
        'priority' => 10,
    ));
    
    // Site Identity
    $wp_customize->add_section('teznevisan_site_identity', array(
        'title' => __('هویت سایت', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 10,
    ));
    
    $wp_customize->add_setting('phone_number', array(
        'default' => '09162352304',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('phone_number', array(
        'label' => __('شماره تماس', 'teznevisan'),
        'section' => 'teznevisan_site_identity',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('email_address', array(
        'default' => 'info@teznevisan3.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('email_address', array(
        'label' => __('ایمیل', 'teznevisan'),
        'section' => 'teznevisan_site_identity',
        'type' => 'email',
    ));
    
    // Social Media
    $wp_customize->add_section('teznevisan_social_media', array(
        'title' => __('شبکه‌های اجتماعی', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 20,
    ));
    
    $socials = ['telegram', 'instagram', 'whatsapp', 'linkedin', 'twitter', 'youtube'];
    
    foreach ($socials as $social) {
        $wp_customize->add_setting($social . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control($social . '_url', array(
            'label' => sprintf(__('آدرس %s', 'teznevisan'), ucfirst($social)),
            'section' => 'teznevisan_social_media',
            'type' => 'url',
        ));
    }
    
    // Colors
    $wp_customize->add_section('teznevisan_colors', array(
        'title' => __('رنگ‌های تم', 'teznevisan'),
        'panel' => 'teznevisan_general',
        'priority' => 30,
    ));
    
    $colors = [
        'primary_color' => ['label' => 'رنگ اصلی', 'default' => '#2563eb'],
        'secondary_color' => ['label' => 'رنگ ثانویه', 'default' => '#1FA640'],
        'accent_color' => ['label' => 'رنگ تاکیدی', 'default' => '#f59e0b'],
    ];
    
    foreach ($colors as $key => $color) {
        $wp_customize->add_setting($key, array(
            'default' => $color['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, array(
            'label' => __($color['label'], 'teznevisan'),
            'section' => 'teznevisan_colors',
        )));
    }
    
    // Footer Settings
    $wp_customize->add_section('teznevisan_footer_settings', array(
        'title' => __('تنظیمات فوتر', 'teznevisan'),
        'priority' => 60,
    ));
    
    $wp_customize->add_setting('footer_company_description', array(
        'default' => __('درباره شرکت ما...', 'teznevisan'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_company_description', array(
        'label' => __('توضیحات شرکت', 'teznevisan'),
        'section' => 'teznevisan_footer_settings',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('footer_copyright', array(
        'default' => sprintf(__('© %d تمامی حقوق محفوظ است.', 'teznevisan'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_copyright', array(
        'label' => __('متن کپی‌رایت', 'teznevisan'),
        'section' => 'teznevisan_footer_settings',
        'type' => 'textarea',
    ));
    
    // Chaty Settings
    $wp_customize->add_section('teznevisan_chaty_settings', array(
        'title' => __('دکمه‌های Chaty', 'teznevisan'),
        'priority' => 100,
    ));
    
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("chaty_name_$i", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("chaty_name_$i", array(
            'label' => sprintf(__('دکمه %d - نام', 'teznevisan'), $i),
            'section' => 'teznevisan_chaty_settings',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("chaty_icon_$i", array(
            'default' => 'fa-solid fa-message',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("chaty_icon_$i", array(
            'label' => sprintf(__('دکمه %d - آیکون', 'teznevisan'), $i),
            'section' => 'teznevisan_chaty_settings',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("chaty_link_$i", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control("chaty_link_$i", array(
            'label' => sprintf(__('دکمه %d - لینک', 'teznevisan'), $i),
            'section' => 'teznevisan_chaty_settings',
            'type' => 'url',
        ));
        
        $wp_customize->add_setting("chaty_color_$i", array(
            'default' => '#3b82f6',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "chaty_color_$i", array(
            'label' => sprintf(__('دکمه %d - رنگ', 'teznevisan'), $i),
            'section' => 'teznevisan_chaty_settings',
        )));
    }
}
add_action('customize_register', 'teznevisan_customize_register');

// Customizer CSS
function teznevisan_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#2563eb');
    $secondary_color = get_theme_mod('secondary_color', '#1FA640');
    $accent_color = get_theme_mod('accent_color', '#f59e0b');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --accent-color: <?php echo esc_attr($accent_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'teznevisan_customizer_css');

// Register Footer Widgets
function teznevisan_register_footer_widgets() {
    register_sidebar([
        'name' => __('فوتر - ستون 2', 'teznevisan'),
        'id' => 'footer-1',
        'description' => __('ناحیه ویجت فوتر - ستون دوم', 'teznevisan'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);
    
    register_sidebar([
        'name' => __('فوتر - ستون 3', 'teznevisan'),
        'id' => 'footer-2',
        'description' => __('ناحیه ویجت فوتر - ستون سوم', 'teznevisan'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);
}
add_action('widgets_init', 'teznevisan_register_footer_widgets');

// Render Chaty Buttons
add_action('teznevisan_render_chaty_buttons', 'teznevisan_render_chaty_buttons_func');
function teznevisan_render_chaty_buttons_func() {
    for ($i = 1; $i <= 5; $i++) {
        $name = get_theme_mod("chaty_name_$i");
        $icon = get_theme_mod("chaty_icon_$i", 'fa-solid fa-message');
        $link = get_theme_mod("chaty_link_$i");
        $color = get_theme_mod("chaty_color_$i", '#3b82f6');
        
        if ($link && $name) {
            echo '<a href="' . esc_url($link) . '" class="chaty-channel" style="background-color: ' . esc_attr($color) . ';" aria-label="' . esc_attr($name) . '" target="_blank" rel="noopener noreferrer">
                <i class="' . esc_attr($icon) . '"></i>
                <span class="chaty-tooltip">' . esc_html($name) . '</span>
            </a>';
        }
    }
}

/**
 * Custom Post Meta Boxes for Single Posts
 * Version: 1.0.0
 */

// Add Custom Meta Boxes
function teznevisan_add_post_meta_boxes() {
    add_meta_box(
        'teznevisan_post_settings',
        __('تنظیمات پست', 'teznevisan'),
        'teznevisan_post_settings_callback',
        'post',
        'normal',
        'high'
    );
    
    add_meta_box(
        'teznevisan_post_seo',
        __('تنظیمات SEO', 'teznevisan'),
        'teznevisan_post_seo_callback',
        'post',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'teznevisan_add_post_meta_boxes');

// Post Settings Meta Box Callback
function teznevisan_post_settings_callback($post) {
    wp_nonce_field('teznevisan_post_settings_nonce', 'teznevisan_post_settings_nonce');
    
    $subtitle = get_post_meta($post->ID, '_post_subtitle', true);
    $reading_time = get_post_meta($post->ID, '_reading_time', true);
    $difficulty = get_post_meta($post->ID, '_difficulty_level', true);
    $featured_video = get_post_meta($post->ID, '_featured_video', true);
    $table_of_contents = get_post_meta($post->ID, '_enable_toc', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="post_subtitle"><?php _e('زیرعنوان', 'teznevisan'); ?></label></th>
            <td>
                <input type="text" id="post_subtitle" name="post_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="large-text">
                <p class="description"><?php _e('یک زیرعنوان کوتاه برای پست', 'teznevisan'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="reading_time"><?php _e('زمان مطالعه (دقیقه)', 'teznevisan'); ?></label></th>
            <td>
                <input type="number" id="reading_time" name="reading_time" value="<?php echo esc_attr($reading_time); ?>" min="1" max="120">
                <p class="description"><?php _e('زمان تقریبی مطالعه این پست', 'teznevisan'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="difficulty_level"><?php _e('سطح دشواری', 'teznevisan'); ?></label></th>
            <td>
                <select id="difficulty_level" name="difficulty_level">
                    <option value=""><?php _e('انتخاب کنید', 'teznevisan'); ?></option>
                    <option value="beginner" <?php selected($difficulty, 'beginner'); ?>><?php _e('مبتدی', 'teznevisan'); ?></option>
                    <option value="intermediate" <?php selected($difficulty, 'intermediate'); ?>><?php _e('متوسط', 'teznevisan'); ?></option>
                    <option value="advanced" <?php selected($difficulty, 'advanced'); ?>><?php _e('پیشرفته', 'teznevisan'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="featured_video"><?php _e('ویدیو شاخص', 'teznevisan'); ?></label></th>
            <td>
                <input type="url" id="featured_video" name="featured_video" value="<?php echo esc_url($featured_video); ?>" class="large-text">
                <p class="description"><?php _e('لینک ویدیو از آپارات یا یوتیوب', 'teznevisan'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="enable_toc"><?php _e('فهرست مطالب', 'teznevisan'); ?></label></th>
            <td>
                <label>
                    <input type="checkbox" id="enable_toc" name="enable_toc" value="1" <?php checked($table_of_contents, '1'); ?>>
                    <?php _e('نمایش فهرست مطالب خودکار', 'teznevisan'); ?>
                </label>
            </td>
        </tr>
    </table>
    <?php
}

// SEO Meta Box Callback
function teznevisan_post_seo_callback($post) {
    wp_nonce_field('teznevisan_post_seo_nonce', 'teznevisan_post_seo_nonce');
    
    $meta_description = get_post_meta($post->ID, '_meta_description', true);
    $meta_keywords = get_post_meta($post->ID, '_meta_keywords', true);
    $canonical_url = get_post_meta($post->ID, '_canonical_url', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="meta_description"><?php _e('توضیحات متا', 'teznevisan'); ?></label></th>
            <td>
                <textarea id="meta_description" name="meta_description" rows="3" class="large-text"><?php echo esc_textarea($meta_description); ?></textarea>
                <p class="description"><?php _e('توضیحات برای موتورهای جستجو (حداکثر 160 کاراکتر)', 'teznevisan'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="meta_keywords"><?php _e('کلمات کلیدی', 'teznevisan'); ?></label></th>
            <td>
                <input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo esc_attr($meta_keywords); ?>" class="large-text">
                <p class="description"><?php _e('کلمات کلیدی را با کاما جدا کنید', 'teznevisan'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="canonical_url"><?php _e('URL کانونیکال', 'teznevisan'); ?></label></th>
            <td>
                <input type="url" id="canonical_url" name="canonical_url" value="<?php echo esc_url($canonical_url); ?>" class="large-text">
                <p class="description"><?php _e('URL کانونیکال برای جلوگیری از محتوای تکراری', 'teznevisan'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Save Post Meta Data
function teznevisan_save_post_meta($post_id) {
    // Check nonces
    if (!isset($_POST['teznevisan_post_settings_nonce']) || 
        !wp_verify_nonce($_POST['teznevisan_post_settings_nonce'], 'teznevisan_post_settings_nonce')) {
        return;
    }
    
    if (!isset($_POST['teznevisan_post_seo_nonce']) || 
        !wp_verify_nonce($_POST['teznevisan_post_seo_nonce'], 'teznevisan_post_seo_nonce')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save post settings
    if (isset($_POST['post_subtitle'])) {
        update_post_meta($post_id, '_post_subtitle', sanitize_text_field($_POST['post_subtitle']));
    }
    
    if (isset($_POST['reading_time'])) {
        update_post_meta($post_id, '_reading_time', absint($_POST['reading_time']));
    }
    
    if (isset($_POST['difficulty_level'])) {
        update_post_meta($post_id, '_difficulty_level', sanitize_text_field($_POST['difficulty_level']));
    }
    
    if (isset($_POST['featured_video'])) {
        update_post_meta($post_id, '_featured_video', esc_url_raw($_POST['featured_video']));
    }
    
    update_post_meta($post_id, '_enable_toc', isset($_POST['enable_toc']) ? '1' : '0');
    
    // Save SEO settings
    if (isset($_POST['meta_description'])) {
        update_post_meta($post_id, '_meta_description', sanitize_textarea_field($_POST['meta_description']));
    }
    
    if (isset($_POST['meta_keywords'])) {
        update_post_meta($post_id, '_meta_keywords', sanitize_text_field($_POST['meta_keywords']));
    }
    
    if (isset($_POST['canonical_url'])) {
        update_post_meta($post_id, '_canonical_url', esc_url_raw($_POST['canonical_url']));
    }
}
add_action('save_post', 'teznevisan_save_post_meta');


/**
 * Auto-generate Table of Contents
 */
function teznevisan_generate_toc($content) {
    if (!is_single()) {
        return $content;
    }
    
    global $post;
    $enable_toc = get_post_meta($post->ID, '_enable_toc', true);
    
    if ($enable_toc != '1') {
        return $content;
    }
    
    // Extract headings
    preg_match_all('/<h([2-3])([^>]*)>(.*?)<\/h[2-3]>/i', $content, $matches, PREG_SET_ORDER);
    
    if (count($matches) < 3) {
        return $content;
    }
    
    $toc = '<div class="table-of-contents">';
    $toc .= '<h3 class="toc-title"><i class="fa-solid fa-list"></i> ' . __('فهرست مطالب', 'teznevisan') . '</h3>';
    $toc .= '<ul class="toc-list">';
    
    foreach ($matches as $index => $heading) {
        $level = $heading[1];
        $title = strip_tags($heading[3]);
        $id = 'heading-' . ($index + 1);
        
        // Add ID to heading in content
        $content = str_replace(
            $heading[0],
            '<h' . $level . ' id="' . $id . '"' . $heading[2] . '>' . $heading[3] . '</h' . $level . '>',
            $content
        );
        
        $toc .= '<li class="toc-level-' . $level . '">';
        $toc .= '<a href="#' . $id . '">' . esc_html($title) . '</a>';
        $toc .= '</li>';
    }
    
    $toc .= '</ul></div>';
    
    // Insert TOC after first paragraph
    $content = preg_replace('/<\/p>/', '</p>' . $toc, $content, 1);
    
    return $content;
}
add_filter('the_content', 'teznevisan_generate_toc');

/**
 * Reading Progress Bar
 */
function teznevisan_reading_progress() {
    if (is_single()) {
        echo '<div class="reading-progress-bar"><div class="reading-progress-fill"></div></div>';
    }
}
add_action('wp_body_open', 'teznevisan_reading_progress');


// Create Ratings Table on Theme Activation
function teznevisan_create_ratings_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'post_ratings';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        user_ip varchar(100) NOT NULL,
        rating_type varchar(20) NOT NULL,
        rating_value int(11) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY post_id (post_id),
        KEY user_ip (user_ip),
        KEY rating_type (rating_type)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Run on theme switch
add_action('after_switch_theme', 'teznevisan_create_ratings_table');

// Also create table if it doesn't exist (safety check)
function teznevisan_check_ratings_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'post_ratings';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        teznevisan_create_ratings_table();
    }
}
add_action('init', 'teznevisan_check_ratings_table');

/**
 * Get User IP Address
 */
function teznevisan_get_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return sanitize_text_field($ip);
}

/**
 * Get Rating Statistics (Safe Version)
 */
function teznevisan_get_rating_stats($post_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'post_ratings';
    
    // Default return value
    $default_stats = array(
        'likes' => 0,
        'dislikes' => 0,
        'star_average' => 0,
        'star_count' => 0
    );
    
    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return $default_stats;
    }
    
    // Get likes
    $likes = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE post_id = %d AND rating_type = 'like'",
        $post_id
    ));
    
    // Get dislikes
    $dislikes = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE post_id = %d AND rating_type = 'dislike'",
        $post_id
    ));
    
    // Get star average
    $star_avg = $wpdb->get_var($wpdb->prepare(
        "SELECT AVG(rating_value) FROM $table_name WHERE post_id = %d AND rating_type = 'star'",
        $post_id
    ));
    
    // Get star count
    $star_count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE post_id = %d AND rating_type = 'star'",
        $post_id
    ));
    
    return array(
        'likes' => intval($likes),
        'dislikes' => intval($dislikes),
        'star_average' => $star_avg ? round(floatval($star_avg), 1) : 0,
        'star_count' => intval($star_count)
    );
}

/**
 * Check if User Has Rated
 */
function teznevisan_user_has_rated($post_id, $rating_type) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'post_ratings';
    
    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return false;
    }
    
    $user_ip = teznevisan_get_user_ip();
    
    $rating = $wpdb->get_row($wpdb->prepare(
        "SELECT rating_value FROM $table_name WHERE post_id = %d AND user_ip = %s AND rating_type = %s",
        $post_id, $user_ip, $rating_type
    ));
    
    return $rating ? $rating->rating_value : false;
}

/**
 * AJAX: Submit Rating
 */
function teznevisan_submit_rating() {
    check_ajax_referer('teznevisan_rating_nonce', 'nonce');
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'post_ratings';
    
    // Check if table exists, create if not
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        teznevisan_create_ratings_table();
    }
    
    $post_id = absint($_POST['post_id']);
    $rating_type = sanitize_text_field($_POST['rating_type']); // 'like', 'dislike', 'star'
    $rating_value = absint($_POST['rating_value']); // 1-5 for stars, 1 for like, -1 for dislike
    $user_ip = teznevisan_get_user_ip();
    
    // Check if user already rated
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE post_id = %d AND user_ip = %s AND rating_type = %s",
        $post_id, $user_ip, $rating_type
    ));
    
    if ($existing) {
        // Update existing rating
        $wpdb->update(
            $table_name,
            array('rating_value' => $rating_value),
            array('id' => $existing->id),
            array('%d'),
            array('%d')
        );
    } else {
        // Insert new rating
        $wpdb->insert(
            $table_name,
            array(
                'post_id' => $post_id,
                'user_ip' => $user_ip,
                'rating_type' => $rating_type,
                'rating_value' => $rating_value
            ),
            array('%d', '%s', '%s', '%d')
        );
    }
    
    // Get updated counts
    $stats = teznevisan_get_rating_stats($post_id);
    
    wp_send_json_success($stats);
}
add_action('wp_ajax_submit_rating', 'teznevisan_submit_rating');
add_action('wp_ajax_nopriv_submit_rating', 'teznevisan_submit_rating');

/**
 * Post Views Counter
 */
function teznevisan_set_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function teznevisan_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return 0;
    }
    
    return $count;
}

// Prevent counting views for bots
function teznevisan_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) return;
    
    // Don't count if it's a bot
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $bot_agents = array('bot', 'crawl', 'spider', 'slurp');
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        
        foreach ($bot_agents as $bot) {
            if (strpos($user_agent, $bot) !== false) {
                return;
            }
        }
    }
    
    // Don't count admin views
    if (current_user_can('manage_options')) {
        return;
    }
    
    teznevisan_set_post_views($post_id);
}
add_action('wp_head', function() {
    if (is_single()) {
        teznevisan_track_post_views(get_the_ID());
    }
});

/**
 * Extract Headings for TOC
 */
function extract_headings_for_toc($content) {
    preg_match_all('/<h([2-3])([^>]*)>(.*?)<\/h[2-3]>/i', $content, $matches, PREG_SET_ORDER);
    
    $toc_items = array();
    foreach ($matches as $match) {
        $toc_items[] = array(
            'level' => $match[1],
            'text' => strip_tags($match[3])
        );
    }
    
    return $toc_items;
}

/**
 * Add IDs to Headings
 */
function add_heading_ids($content, $toc_items) {
    if (empty($toc_items)) {
        return $content;
    }
    
    preg_match_all('/<h([2-3])([^>]*)>(.*?)<\/h[2-3]>/i', $content, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $index => $match) {
        $id = 'heading-' . $index;
        $replacement = '<h' . $match[1] . ' id="' . $id . '"' . $match[2] . '>' . $match[3] . '</h' . $match[1] . '>';
        $content = str_replace($match[0], $replacement, $content);
    }
    
    return $content;
}

/**
 * Get Related Posts
 */
function teznevisan_get_related_posts($post_id, $limit = 3) {
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return array();
    }
    
    $args = array(
        'category__in' => $categories,
        'post__not_in' => array($post_id),
        'posts_per_page' => $limit,
        'orderby' => 'rand',
        'ignore_sticky_posts' => 1
    );
    
    return get_posts($args);
}


/**
 * Social Share Buttons (Updated for X)
 */
function teznevisan_social_share_buttons($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_url = urlencode(get_permalink($post_id));
    $post_title = urlencode(get_the_title($post_id));
    
    $shares = array(
        'telegram' => array(
            'url' => 'https://t.me/share/url?url=' . $post_url . '&text=' . $post_title,
            'icon' => 'fa-brands fa-telegram',
            'color' => '#0088cc',
            'label' => 'تلگرام'
        ),
        'whatsapp' => array(
            'url' => 'https://wa.me/?text=' . $post_title . ' ' . $post_url,
            'icon' => 'fa-brands fa-whatsapp',
            'color' => '#25D366',
            'label' => 'واتساپ'
        ),
        'twitter' => array( // Keep as 'twitter' in array key for compatibility
            'url' => 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title,
            'icon' => 'fa-brands fa-x-twitter', // Updated icon
            'color' => '#000000', // X's black color
            'label' => 'X (توییتر)' // Updated label
        ),
        'linkedin' => array(
            'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_url . '&title=' . $post_title,
            'icon' => 'fa-brands fa-linkedin',
            'color' => '#0077b5',
            'label' => 'لینکدین'
        ),
        'copy' => array(
            'url' => get_permalink($post_id),
            'icon' => 'fa-solid fa-link',
            'color' => '#6b7280',
            'label' => 'کپی لینک'
        )
    );
    
    return $shares;
}


/**
 * Custom Comment Callback
 */
function teznevisan_custom_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar($comment, 64); ?>
            </div>
            <div class="comment-content-wrapper">
                <div class="comment-meta">
                    <span class="comment-author-name"><?php comment_author(); ?></span>
                    <time class="comment-date" datetime="<?php comment_date('c'); ?>">
                        <?php comment_date('j F Y'); ?>
                    </time>
                </div>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                <?php
                comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'reply_text' => '<i class="fa-solid fa-reply"></i> پاسخ'
                )));
                ?>
            </div>
        </div>
    <?php
}

/**
 * Enqueue Single Post Styles and Scripts
 */
function teznevisan_single_post_assets() {
    if (is_single()) {
        // Enqueue single post CSS
        wp_enqueue_style(
            'teznevisan-single-post',
            get_template_directory_uri() . '/assets/css/single-post.css',
            array(), // Dependencies
            filemtime(get_template_directory() . '/assets/css/single-post.css'), // Version based on file modification time
            'all'
        );
        
        // Enqueue single post JS
        wp_enqueue_script(
            'teznevisan-single-post',
            get_template_directory_uri() . '/assets/js/single-post.js',
            array('jquery'), // Dependencies
            filemtime(get_template_directory() . '/assets/js/single-post.js'), // Version
            true // Load in footer
        );
        
        // Localize script
        wp_localize_script('teznevisan-single-post', 'teznevisanSingle', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('teznevisan_rating_nonce'),
            'post_id' => get_the_ID(),
            'strings' => array(
                'copied' => __('لینک کپی شد!', 'teznevisan'),
                'error' => __('خطا در ارسال', 'teznevisan'),
                'login_required' => __('لطفاً ابتدا وارد شوید', 'teznevisan'),
                'rating_success' => __('امتیاز شما ثبت شد!', 'teznevisan'),
                'rating_updated' => __('امتیاز شما به‌روزرسانی شد', 'teznevisan')
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'teznevisan_single_post_assets', 20);


/**
 * Modify Comment Form for Telegram Login
 */
function teznevisan_comment_form_defaults($defaults) {
    if (!is_user_logged_in()) {
        $defaults['must_log_in'] = '<p class="must-log-in">' .
            sprintf(
                __('برای ارسال دیدگاه باید <a href="#" id="comment-login-trigger">با تلگرام وارد شوید</a>.', 'teznevisan')
            ) . '</p>';
        $defaults['comment_field'] = '';
        $defaults['fields'] = array();
    }
    return $defaults;
}
add_filter('comment_form_defaults', 'teznevisan_comment_form_defaults');

/**
 * Add Telegram Photo to Comments
 */
function teznevisan_get_avatar($avatar, $id_or_email, $size, $default, $alt) {
    $user = false;
    
    if (is_numeric($id_or_email)) {
        $id = (int) $id_or_email;
        $user = get_user_by('id', $id);
    } elseif (is_object($id_or_email)) {
        if (!empty($id_or_email->user_id)) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by('id', $id);
        }
    } else {
        $user = get_user_by('email', $id_or_email);
    }
    
    if ($user && is_object($user)) {
        $telegram_photo = get_user_meta($user->ID, 'telegram_photo_url', true);
        if ($telegram_photo) {
            $avatar = "<img alt='{$alt}' src='{$telegram_photo}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
    }
    
    return $avatar;
}
add_filter('get_avatar', 'teznevisan_get_avatar', 10, 5);

/**
 * Reading Time Calculation
 */
function estimate_reading_time() {
    $content = get_the_content();
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 words per minute
    return max(1, $reading_time);
}

/**
 * Display Reading Time
 */
function teznevisan_display_reading_time() {
    $reading_time = get_post_meta(get_the_ID(), '_reading_time', true);
    if (!$reading_time) {
        $reading_time = estimate_reading_time();
    }
    return $reading_time;
}

