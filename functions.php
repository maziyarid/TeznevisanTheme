<?php
/**
 * Teznevisan Theme Functions - Complete Enhanced Version
 * All features maintained, all issues fixed, dynamic menus added
 * Version: 3.0.0 - Fixed Structure with RankMath Compatibility
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Constants & Configuration
 */
define('TEZNEVISAN_VERSION', '3.0.0');
define('TEZNEVISAN_THEME_DIR', get_template_directory());
define('TEZNEVISAN_THEME_URL', get_template_directory_uri());
define('TEZNEVISAN_ASSETS_URL', TEZNEVISAN_THEME_URL . '/assets');

/**
 * Include Required Files BEFORE Class Definition
 */
$required_files = [
    '/inc/navigation-manager.php',
    '/inc/classic-editor.php',
    '/admin/service-meta-fields.php'
];

foreach ($required_files as $file) {
    $file_path = get_template_directory() . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

/**
 * Enhanced Theme Setup and Initialization
 */
class TeznevisanTheme {
    private static $instance = null;
    private static $hooks_initialized = false;
    private static $additional_hooks_registered = false;
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->initHooks();
        $this->register_additional_hooks();
        // Initialize Classic Editor functionality
    }
    
private function initHooks(): void
{
    if (self::$hooks_initialized) {
        return;
    }
    self::$hooks_initialized = true;
    // Core setup
    add_action('after_setup_theme', array($this, 'init'));
    add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    add_action('wp_head', array($this, 'add_custom_styles'), 999);

    // RankMath compatibility
    add_action('init', array($this, 'rank_math_compatibility'));
    add_filter('rank_math/head', array($this, 'rank_math_customization'), 10, 0);
    add_filter('rank_math/json_ld', array($this, 'enhanceRankMathSchema'), 10, 2);

    // Admin and customization
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    add_action('init', array($this, 'register_post_types'));
    add_action('init', array($this, 'register_taxonomies'));
    add_action('widgets_init', array($this, 'register_sidebars'));
    add_action('customize_register', array($this, 'customize_register'));
    add_action('wp_head', array($this, 'add_structured_data'), 1);
    add_action('wp_head', array($this, 'add_google_analytics'), 2);
    add_action('wp_footer', array($this, 'add_accessibility_widget'));
    add_action('admin_bar_menu', array($this, 'customize_admin_bar'), 999);
    add_filter('body_class', array($this, 'add_body_classes'));
    add_filter('admin_body_class', array($this, 'add_admin_body_classes'));

    // AJAX handlers
    add_action('wp_ajax_ajax_search', array($this, 'handle_ajax_search'));
    add_action('wp_ajax_nopriv_ajax_search', array($this, 'handle_ajax_search'));
    add_action('wp_ajax_contact_form', array($this, 'handle_contact_form'));
    add_action('wp_ajax_nopriv_contact_form', array($this, 'handle_contact_form'));
    add_action('wp_ajax_newsletter_signup', array($this, 'handle_newsletter_signup'));
    add_action('wp_ajax_nopriv_newsletter_signup', array($this, 'handle_newsletter_signup'));
    add_action('wp_ajax_mobile_order', array($this, 'handle_mobile_order'));
    add_action('wp_ajax_nopriv_mobile_order', array($this, 'handle_mobile_order'));
    add_action('wp_ajax_service_inquiry', array($this, 'handle_service_inquiry'));
    add_action('wp_ajax_nopriv_service_inquiry', array($this, 'handle_service_inquiry'));
    add_action('wp_ajax_post_reaction', array($this, 'handle_post_reaction'));
    add_action('wp_ajax_nopriv_post_reaction', array($this, 'handle_post_reaction'));

    // Meta boxes and admin
    add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
    add_action('save_post', array($this, 'save_post_meta'));

    // Additional hooks
    add_action('template_redirect', array($this, 'handle_redirects'));
    add_action('wp_head', array($this, 'track_post_views'));
    add_action('wp_head', array($this, 'add_security_headers'));
    add_action('wp_footer', array($this, 'render_floating_widgets'));
    add_action('wp_footer', array($this, 'add_cookie_consent'));

    // Menu enhancements
    add_filter('wp_nav_menu_items', array($this, 'add_menu_icons'), 10, 2);
    add_action('admin_menu', array($this, 'add_admin_menu'));
    add_action('wp_ajax_save_menu_icons', array($this, 'save_menu_icons'));

    // Performance and security
    add_action('init', array($this, 'init_performance_security'));
    add_action('wp_dashboard_setup', array($this, 'custom_admin_dashboard'));

    // Theme activation/deactivation
    add_action('after_switch_theme', array($this, 'theme_activation'));
    add_action('switch_theme', array($this, 'theme_deactivation'));

    add_action('init', array($this, 'init'));
    add_action('admin_init', array($this, 'admin_init'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    add_action('admin_head', array($this, 'add_admin_fontawesome_styles'), 1);

    // Completely disable Gutenberg site-wide
    add_filter('use_block_editor_for_post_type', '__return_false', PHP_INT_MAX);
    add_filter('use_block_editor_for_post', '__return_false', PHP_INT_MAX);
    add_filter('gutenberg_can_edit_post_type', '__return_false', PHP_INT_MAX);
    add_filter('gutenberg_can_edit_post', '__return_false', PHP_INT_MAX);

    // Remove Gutenberg assets
    add_action('wp_enqueue_scripts', array($this, 'remove_gutenberg_assets'), 100);
    add_action('admin_enqueue_scripts', array($this, 'remove_gutenberg_admin_assets'), 100);

    // AJAX handlers
    add_action('wp_ajax_classic_editor_upload', array($this, 'handle_classic_editor_upload'));
    add_action('wp_ajax_nopriv_classic_editor_upload', array($this, 'handle_classic_editor_upload'));

    // Add NEW hooks for fixes
    add_action('init', array($this, 'tez_register_menus_and_editor_styles'));
    add_action('wp_enqueue_scripts', array($this, 'tez_enqueue_theme_assets'));
    add_action('admin_enqueue_scripts', array($this, 'tez_enqueue_admin_fontawesome'), 5); // PRIORITY 5
    add_action('admin_head', array($this, 'ensure_admin_fontawesome_variables'));
    add_action('admin_enqueue_scripts', array($this, 'tez_enqueue_admin_assets'), 5);

    // TinyMCE hooks
    add_filter('mce_external_plugins', array($this, 'tez_add_tinymce_plugin'));
    add_filter('mce_buttons', array($this, 'tez_add_tinymce_button'));
    add_filter('mce_external_languages', array($this, 'tez_tinymce_external_languages'));

    // React Editor Integration
    add_action('admin_menu', array($this, 'add_react_editor_menu'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_react_editor_assets'));

    // Theme activation
    register_activation_hook(__FILE__, array($this, 'theme_activation'));

    // Admin enhancements
    add_action('admin_head', array($this, 'ensure_admin_fontawesome_variables'));
}

private function register_additional_hooks(): void
{
    if (self::$additional_hooks_registered) {
        return;
    }
    self::$additional_hooks_registered = true;

    // Additional hooks for enhanced functionality
    add_action('init', function () {
        $theme = self::getInstance();
        $theme->disable_gutenberg();
        $theme->enhance_classic_editor();
    });

    // AJAX handlers for React editor
    add_action('wp_ajax_teznevisan_react_editor', function () {
        $theme = self::getInstance();
        $theme->handle_react_editor_ajax();
    });

    // Custom body classes for better styling control
    add_filter('body_class', function ($classes) {
        $classes[] = 'teznevisan-theme';

        if (get_option('teznevisan_disable_gutenberg', true)) {
            $classes[] = 'classic-editor-active';
        }

        if (get_option('teznevisan_editor_accessibility', true)) {
            $classes[] = 'accessibility-enhanced';
        }

        if (is_rtl()) {
            $classes[] = 'rtl-layout';
        }

        return $classes;
    });

    // Admin body classes for consistent styling
    add_filter('admin_body_class', function ($classes) {
        return $classes . ' teznevisan-admin fontawesome-pro-loaded';
    });

    // Remove React files decision logic
    add_action('admin_init', function () {
        $react_editor_file = get_template_directory() . '/assets/js/dist/teznevisan-editor.umd.js';
        $react_components_dir = get_template_directory() . '/assets/js/react-components';
        $typescript_files = glob(get_template_directory() . '/assets/js/*.ts');
        if (!file_exists($react_editor_file) && !is_dir($react_components_dir) && empty($typescript_files)) {
            update_option('teznevisan_react_editor_available', false);
        } else {
            update_option('teznevisan_react_editor_available', true);
        }
    });

    // Ensure HTML lang attribute is set correctly
    add_filter('language_attributes', function ($lang) {
        if (is_rtl()) {
            return 'lang="fa-IR" dir="rtl"';
        }
        return $lang;
    });

    // WordPress Customizer enhancements
    add_action('customize_register', function ($wp_customize) {
        $wp_customize->add_panel('teznevisan_accessibility', array(
            'title'       => __('دسترسی‌پذیری', 'teznevisan'),
            'description' => __('تنظیمات دسترسی‌پذیری سایت', 'teznevisan'),
            'priority'    => 30,
        ));
        $wp_customize->add_section('teznevisan_fonts', array(
            'title' => __('فونت‌ها', 'teznevisan'),
            'panel' => 'teznevisan_accessibility',
        ));
        $wp_customize->add_setting('teznevisan_base_font_size', array(
            'default'           => 16,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('teznevisan_base_font_size', array(
            'label'       => __('اندازه فونت پایه (پیکسل)', 'teznevisan'),
            'section'     => 'teznevisan_fonts',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 12,
                'max'  => 24,
                'step' => 1,
            ),
        ));
    });

    // Add CSS variables based on customizer settings
    add_action('wp_head', function () {
        $base_font_size = get_theme_mod('teznevisan_base_font_size', 16);
        echo '<style id="teznevisan-css-vars">
:root {
    --tez-base-font-size: ' . esc_attr($base_font_size) . 'px;
    --tez-primary-color: #1FA547;
    --tez-secondary-color: #178A3A;
    --tez-accent-color: #2FD65A;
    --tez-text-color: #333333;
    --tez-bg-color: #ffffff;
}

body {
    font-size: var(--tez-base-font-size);
    font-family: "IRANSans", -apple-system, BlinkMacSystemFont, sans-serif;
}
</style>';
    });

    // Clean up unused React/TS assets if not needed
    add_action('admin_notices', function () {
        if (current_user_can('manage_options') && !get_option('teznevisan_react_editor_available', false)) {
            $react_files = array('/assets/js/react/', '/assets/js/dist/', '/assets/js/*.ts', '/assets/js/react-components/');
            $has_unused_files = false;
            foreach ($react_files as $pattern) {
                $path = get_template_directory() . $pattern;
                if (glob($path)) {
                    $has_unused_files = true;
                    break;
                }
            }
            if ($has_unused_files) {
                echo '<div class="notice notice-info is-dismissible">
                        <p><strong>تزنویسان:</strong> فایل‌های React/TypeScript یافت شدند اما استفاده نمی‌شوند. 
                        برای بهینه‌سازی حجم تم، می‌توانید آنها را حذف کنید یا از ویرایشگر React استفاده نمایید.</p>
                      </div>';
            }
        }
    });

    // Performance optimization - preload critical resources
    add_action('wp_head', function () {
        $theme_uri = get_template_directory_uri();
        echo '<link rel="preload" href="' . esc_url($theme_uri . '/assets/fonts/iransans/IRANSans-Regular.woff2') . '" as="font" type="font/woff2" crossorigin>';
        echo '<link rel="preload" href="' . esc_url($theme_uri . '/assets/fonts/fontawesome/webfonts/fa-solid-900.woff2') . '" as="font" type="font/woff2" crossorigin>';
        echo '<link rel="preload" href="' . esc_url($theme_uri . '/assets/fonts/fontawesome/css/all.css') . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    }, 1);

    // Security headers for font files
    add_action('init', function () {
        if (strpos($_SERVER['REQUEST_URI'] ?? '', '.woff') !== false || strpos($_SERVER['REQUEST_URI'] ?? '', '.woff2') !== false) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET');
            header('Access-Control-Allow-Headers: *');
        }
    });

    // Add .htaccess rules for font files (programmatically)
    add_action('after_setup_theme', function () {
        $htaccess_content = get_option('teznevisan_htaccess_rules', '');
        if (empty($htaccess_content)) {
            $rules = '
<IfModule mod_headers.c>
<FilesMatch "\.(woff|woff2|eot|ttf)$">
Header set Access-Control-Allow-Origin "*"
Header set Access-Control-Allow-Methods "GET"
Header set Cache-Control "public, max-age=31536000"
</FilesMatch>
</IfModule>
<IfModule mod_mime.c>
AddType application/font-woff woff
AddType application/font-woff2 woff2
AddType application/vnd.ms-fontobject eot
AddType application/x-font-ttf ttf
</IfModule>';
            update_option('teznevisan_htaccess_rules', $rules);

            $htaccess_file = get_home_path() . '.htaccess';
            if (is_writable($htaccess_file)) {
                $current_rules = file_get_contents($htaccess_file);
                if (strpos($current_rules, '# Teznevisan Font Files') === false) {
                    file_put_contents($htaccess_file, $rules . $current_rules);
                }
            }
        }
    });

    // Cleanup on theme switch
    add_action('switch_theme', function () {
        delete_option('teznevisan_htaccess_rules');
        delete_option('teznevisan_react_editor_available');
        $htaccess_file = get_home_path() . '.htaccess';
        if (is_writable($htaccess_file)) {
            $content = file_get_contents($htaccess_file);
            $content = preg_replace('/# Teznevisan Font Files.*?# End Teznevisan Rules/s', '', $content);
            file_put_contents($htaccess_file, $content);
        }
    });

    // Development mode detection
    if (defined('WP_DEBUG') && WP_DEBUG) {
        add_filter('script_loader_src', function ($src, $handle) {
            if (strpos($handle, 'teznevisan') !== false || strpos($handle, 'tez-') !== false) {
                $dev_src = str_replace('.js', '.dev.js', $src);
                $dev_path = str_replace(get_template_directory_uri(), get_template_directory(), $dev_src);
                if (file_exists($dev_path)) {
                    return $dev_src;
                }
            }
            return $src;
        }, 10, 2);

        add_action('wp_footer', function () {
            if (current_user_can('manage_options')) {
                $missing_files = [];
                $theme_dir = get_template_directory();
                $required_files = [
                    '/assets/fonts/iransans/IRANSans-Regular.woff2',
                    '/assets/fonts/fontawesome/webfonts/fa-solid-900.woff2',
                    '/assets/fonts/fontawesome/css/all.css',
                ];
                foreach ($required_files as $file) {
                    if (!file_exists($theme_dir . $file)) {
                        $missing_files[] = $file;
                    }
                }
                if (!empty($missing_files)) {
                    echo '<script>console.warn("Missing theme files:", ' . json_encode($missing_files) . ');</script>';
                }
            }
        });
    }
}



// End of register_additional_hooks

    public function init(): void
    {
        // Theme initialization code
        load_theme_textdomain('teznevisan', get_template_directory() . '/languages');
        
        // Additional theme setup
        if (!current_theme_supports('post-thumbnails')) {
            // Core WordPress features
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array(
            'search-form', 
            'comment-form', 
            'comment-list', 
            'gallery', 
            'caption',
            'navigation-widgets'
        ));
        add_theme_support('custom-logo', array(
            'height' => 100,
            'width' => 200,
            'flex-width' => true,
            'flex-height' => true,
            'header-text' => array('site-title', 'site-description')
        ));
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('editor-styles');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('automatic-feed-links');
        
        // Persian language support
        load_theme_textdomain('teznevisan', get_template_directory() . '/languages');
        add_filter('locale', function($locale) { 
            return 'fa_IR'; 
        });
        
        // Content width
        $GLOBALS['content_width'] = 1200;
        
        // Enhanced Navigation menus - DYNAMIC SUPPORT
        register_nav_menus(array(
            'primary' => __('منوی اصلی (هدر)', 'teznevisan'),
            'mobile' => __('منوی موبایل', 'teznevisan'),
            'footer-1' => __('منوی فوتر - ستون اول', 'teznevisan'),
            'footer-2' => __('منوی فوتر - ستون دوم', 'teznevisan'), 
            'footer-3' => __('منوی فوتر - ستون سوم', 'teznevisan'),
            'footer-4' => __('منوی فوتر - ستون چهارم', 'teznevisan'),
            'footer-services' => __('منوی خدمات فوتر', 'teznevisan'),
            'footer-links' => __('منوی لینک‌های مفید فوتر', 'teznevisan'),
            'footer-legal' => __('منوی قانونی فوتر', 'teznevisan'),
            'footer-social' => __('منوی شبکه‌های اجتماعی', 'teznevisan'),
        ));
        
        // Enhanced Image sizes
        add_image_size('teznevisan-hero', 1200, 600, true);
        add_image_size('teznevisan-featured', 800, 400, true);
        add_image_size('teznevisan-thumbnail', 300, 200, true);
        add_image_size('teznevisan-service', 400, 300, true);
        add_image_size('teznevisan-blog', 600, 400, true);
        add_image_size('teznevisan-author', 100, 100, true);
        add_image_size('teznevisan-testimonial', 80, 80, true);
        add_image_size('hero-image', 1200, 600, true);
        add_image_size('service-thumbnail', 400, 300, true);
        add_image_size('blog-thumbnail', 600, 400, true);
        add_image_size('featured-large', 800, 600, true);
        add_image_size('footer-logo', 200, 80, false);
        add_image_size('author-avatar', 100, 100, true);
        add_image_size('testimonial-avatar', 80, 80, true);
        add_image_size('hero-banner', 1200, 600, true);
        add_image_size('service-thumb', 400, 300, true);
        add_image_size('blog-featured', 800, 400, true);
        
        // Editor styles
        add_editor_style('assets/css/editor-style.css');
        
        // Remove unnecessary features
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        }
    }
    /**
     * Admin initialization - ADDED TO FIX FATAL ERROR
     */
    public function admin_init(): void
    {
        // Initialize admin settings and functionality
        if (is_admin()) {
            // Remove unnecessary admin elements
            remove_action('welcome_panel', 'wp_welcome_panel');
            
            // Add custom admin capabilities
            add_action('wp_dashboard_setup', array($this, 'modify_dashboard_widgets'));
        }
    }
    
    /**
     * Modify Dashboard Widgets - ADDED
     */
    public function modify_dashboard_widgets() {
        global $wp_meta_boxes;
        // Remove default widgets
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    }

    /**
     * Enhanced Script and Style Enqueuing - FIXED
     */
    public function enqueue_scripts(): void
    {
        // Remove conflicting WordPress defaults
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_style('fontawesome');
        wp_dequeue_style('font-awesome');
        wp_dequeue_style('classic-theme-styles');
        
        // Remove jQuery conflicts
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-core');
        wp_deregister_script('jquery-migrate');
        
        // Load local jQuery first
        wp_enqueue_script(
            'jquery-local',
            TEZNEVISAN_ASSETS_URL . '/js//jquery/jquery.min.js',
            array(),
            '3.7.1',
            false
        );
        
        // FontAwesome Pro 7.0.0 - FORCE LOAD ON FRONTEND
        wp_enqueue_style(
            'fontawesome-pro',
            TEZNEVISAN_ASSETS_URL . '/fonts/fontawesome/css/all.css',
            array(),
            '7.0.0',
            'all'
        );
        
        // Add FontAwesome preload for faster loading
        add_action('wp_head', function() {
            echo '<link rel="preload" href="' . TEZNEVISAN_ASSETS_URL . '/fonts/fontawesome/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>';
            echo '<link rel="preload" href="' . TEZNEVISAN_ASSETS_URL . '/fonts/fontawesome/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>';
        }, 1);
        
        // Theme fonts
        wp_enqueue_style(
            'teznevisan-fonts',
            TEZNEVISAN_ASSETS_URL . '/css/fonts.css',
            array(),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/css/fonts.css')
        );
        
        // Critical CSS - Above fold content
        wp_enqueue_style(
            'teznevisan-critical',
            TEZNEVISAN_ASSETS_URL . '/css/critical.css',
            array('fontawesome-pro', 'teznevisan-fonts'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/css/critical.css')
        );
        
        // Main CSS
        wp_enqueue_style(
            'teznevisan-main',
            TEZNEVISAN_ASSETS_URL . '/css/main.css',
            array('teznevisan-critical'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/css/main.css')
        );
        
        // RTL CSS
        wp_enqueue_style(
            'teznevisan-rtl',
            TEZNEVISAN_ASSETS_URL . '/css/rtl.css',
            array('teznevisan-main'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/css/rtl.css')
        );
        
        // Additional CSS files
        $conditional_styles = [
            'header-enhanced' => true,
            'services' => is_singular('services') || is_post_type_archive('services'),
            'homepage' => is_front_page(),
            'admin' => is_admin(),
            'editor-style' => is_admin(),
            'frontend-editor' => !is_admin()
        ];
        
        foreach ($conditional_styles as $style_name => $condition) {
            if ($condition) {
                wp_enqueue_style(
                    "teznevisan-{$style_name}",
                    TEZNEVISAN_ASSETS_URL . "/css/{$style_name}.css",
                    array('teznevisan-main'),
                    filemtime(TEZNEVISAN_THEME_DIR . "/assets/css/{$style_name}.css")
                );
            }
        }
        
        // JavaScript files with proper dependencies

        // TinyMCE enhancements

            wp_enqueue_script(
    'teznevisan-tinymce-extensions',
    TEZNEVISAN_ASSETS_URL . '/js/tinymce-extensions.js',
    array('jquery-local'),
    TEZNEVISAN_VERSION,
    true
);

            wp_enqueue_style(
    'teznevisan-mobile-menu',
    TEZNEVISAN_ASSETS_URL . '/css/mobile-menu.css',
    array('teznevisan-main'),
    TEZNEVISAN_VERSION
);

            wp_enqueue_script(
    'teznevisan-mobile-menu',
    TEZNEVISAN_ASSETS_URL . '/js/mobile-menu.js',
    array('jquery-local'),
    TEZNEVISAN_VERSION,
    true
);


        wp_enqueue_script(
            'teznevisan-critical-js',
            TEZNEVISAN_ASSETS_URL . '/js/critical.js',
            array('jquery-local'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/js/critical.js'),
            true
        );
        
        wp_enqueue_script(
            'teznevisan-main-js',
            TEZNEVISAN_ASSETS_URL . '/js/main.js',
            array('teznevisan-critical-js'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/js/main.js'),
            true
        );
        
        wp_enqueue_script(
            'teznevisan-header-enhanced',
            TEZNEVISAN_ASSETS_URL . '/js/header-enhanced.js',
            array('teznevisan-main-js'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/js/header-enhanced.js'),
            true
        );
              
        wp_enqueue_script(
            'teznevisan-mobile-chat',
            TEZNEVISAN_ASSETS_URL . '/js/mobile-chat.js',
            array('teznevisan-main-js'),
            filemtime(TEZNEVISAN_THEME_DIR . '/assets/js/mobile-chat.js'),
            true
        );

        wp_enqueue_script(
    'teznevisan-accessibility',
    TEZNEVISAN_ASSETS_URL . '/js/accessibility.js',
    array('jquery-local'),
    filemtime(TEZNEVISAN_THEME_DIR . '/assets/js/accessibility.js'),
    true
);

        wp_enqueue_style(
    'teznevisan-accessibility',
    TEZNEVISAN_ASSETS_URL . '/css/accessibility.css',
    array('teznevisan-main'),
    filemtime(TEZNEVISAN_THEME_DIR . '/assets/css/accessibility.css')
);
        
        // Conditional scripts
        $conditional_scripts = [
            'single' => is_singular(),
            'archive' => is_archive(),
            'admin' => is_admin()
        ];
        
        foreach ($conditional_scripts as $script_name => $condition) {
            if ($condition) {
                $script_path = TEZNEVISAN_THEME_DIR . "/assets/js/{$script_name}.js";
                if (file_exists($script_path)) {
                    wp_enqueue_script(
                        "teznevisan-{$script_name}",
                        TEZNEVISAN_ASSETS_URL . "/js/{$script_name}.js",
                        array('teznevisan-main-js'),
                        filemtime($script_path),
                        true
                    );
                }
            }
        }
        
        // Enhanced localization
        wp_localize_script('teznevisan-main-js', 'teznevisanData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('teznevisan_nonce'),
            'homeUrl' => home_url(),
            'themeUrl' => TEZNEVISAN_THEME_URL,
            'assetsUrl' => TEZNEVISAN_ASSETS_URL,
            'isRTL' => true,
            'isAdmin' => is_admin(),
            'isMobile' => wp_is_mobile(),
            'currentPostId' => get_the_ID(),
            'currentUserId' => get_current_user_id(),
            'restUrl' => rest_url(),
            'restNonce' => wp_create_nonce('wp_rest'),
            'strings' => array(
                'loading' => __('در حال بارگذاری...', 'teznevisan'),
                'error' => __('خطا در بارگذاری', 'teznevisan'),
                'success' => __('عملیات با موفقیت انجام شد', 'teznevisan'),
                'close' => __('بستن', 'teznevisan'),
                'search' => __('جستجو', 'teznevisan'),
                'noResults' => __('نتیجه‌ای یافت نشد', 'teznevisan'),
                'tryAgain' => __('دوباره تلاش کنید', 'teznevisan'),
                'contactSuccess' => __('پیام شما با موفقیت ارسال شد', 'teznevisan'),
                'contactError' => __('خطا در ارسال پیام', 'teznevisan'),
                'serverError' => __('خطا در اتصال به سرور', 'teznevisan'),
                'phone' => get_theme_mod('phone_number', '+989331663849'),
                'email' => get_theme_mod('email_address', 'teznevisan@gmail.com'),
                'address' => get_theme_mod('address', 'تهران، ایران')
            ),
            'ajax' => array(
                'url' => admin_url('admin-ajax.php'),
                'timeout' => 30000,
                'retries' => 3
            ),
            'settings' => array(
                'searchMinLength' => 2,
                'searchDelay' => 300,
                'animationDuration' => 400,
                'scrollThreshold' => 100,
                'primaryColor' => get_theme_mod('primary_color', '#1FA547'),
                'enableAnimations' => get_theme_mod('enable_animations', true),
                'enableAccessibility' => get_theme_mod('enable_accessibility', true)
            )
        ));
    }

    /**
 * Add these methods to the TeznevisanTheme class
 */

// Register menus and editor styles - FIX MISSING MOBILE MENU
public function tez_register_menus_and_editor_styles(): void {
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'teznevisan'),
        'mobile'  => __('منوی موبایل', 'teznevisan'),
        'footer_main' => __('منوی اصلی فوتر', 'teznevisan'),
        'social' => __('شبکه‌های اجتماعی', 'teznevisan')
    ));
    
    // Add editor styles with absolute paths
    add_editor_style(get_template_directory_uri() . '/assets/css/editor-fontawesome.css');
}

/**
 * Enhanced asset enqueuing with dist folder support
 */
public function tez_enqueue_theme_assets(): void {
    $ver = wp_get_theme()->get('Version') ?: filemtime(get_template_directory() . '/style.css');
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    // Check if compiled assets exist in dist folder
    $use_compiled = file_exists($theme_dir . '/assets/js/dist/main.js');

    // Critical font injection first
    $font_css = "
    @font-face {
        font-family: 'IRANSans';
        src: url('{$theme_uri}/assets/fonts/iransans/IRANSans-Regular.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/iransans/IRANSans-Regular.woff') format('woff');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'Font Awesome 7 Pro';
        src: url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-solid-900.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-solid-900.woff') format('woff');
        font-weight: 900;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'Font Awesome 7 Brands';
        src: url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-brands-400.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-brands-400.woff') format('woff');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
    }";
    
    wp_add_inline_style('wp-block-library', $font_css);

    // Core styles
    wp_enqueue_style('tez-fontawesome', $theme_uri . '/assets/fonts/fontawesome/css/all.css', array(), '7.0.0');
    wp_enqueue_style('tez-main', get_stylesheet_uri(), array('tez-fontawesome'), $ver);
    
    // Theme assets
    wp_enqueue_style('tez-accessibility', $theme_uri . '/assets/css/accessibility.css', array(), $ver);
    wp_enqueue_script('tez-accessibility', $theme_uri . '/assets/js/accessibility.js', array('jquery'), $ver, true);
    
    wp_enqueue_style('tez-mobile-menu', $theme_uri . '/assets/css/mobile-menu.css', array(), $ver);
    wp_enqueue_script('tez-mobile-menu', $theme_uri . '/assets/js/mobile-menu.js', array('jquery'), $ver, true);
    
    wp_enqueue_style('tez-chaty-fix', $theme_uri . '/assets/css/chaty-fix.css', array(), $ver);
    wp_enqueue_script('tez-chaty-fix', $theme_uri . '/assets/js/chaty-fix.js', array('jquery'), $ver, true);

    // TypeScript compiled assets if they exist
        if (file_exists(get_template_directory() . '/assets/js/dist/main.js')) {
            wp_enqueue_script('tez-main-ts', $theme_uri . '/assets/js/dist/main.js', array('jquery'), $ver, true);
        }
        if ($use_compiled) {
        // Use compiled/minified assets from dist folder
        wp_enqueue_script('tez-utils', $theme_uri . '/assets/js/dist/utils.js', array(), $ver, true);
        wp_enqueue_script('tez-main-compiled', $theme_uri . '/assets/js/dist/main.js', array('jquery', 'tez-utils'), $ver, true);
        
        // Load individual feature CSS files
        wp_enqueue_style('tez-accessibility', $theme_uri . '/assets/css/accessibility.css', array('tez-main'), $ver);
        wp_enqueue_style('tez-mobile-menu', $theme_uri . '/assets/css/mobile-menu.css', array('tez-main'), $ver);
        wp_enqueue_style('tez-chaty-fix', $theme_uri . '/assets/css/chaty-fix.css', array('tez-main'), $ver);
    } else {
        // Fallback to individual files
        wp_enqueue_style('tez-accessibility', $theme_uri . '/assets/css/accessibility.css', array('tez-main'), $ver);
        wp_enqueue_script('tez-accessibility', $theme_uri . '/assets/js/accessibility.js', array('jquery'), $ver, true);
        
        wp_enqueue_style('tez-mobile-menu', $theme_uri . '/assets/css/mobile-menu.css', array('tez-main'), $ver);
        wp_enqueue_script('tez-mobile-menu', $theme_uri . '/assets/js/mobile-menu.js', array('jquery'), $ver, true);
        
        wp_enqueue_style('tez-chaty-fix', $theme_uri . '/assets/css/chaty-fix.css', array('tez-main'), $ver);
        wp_enqueue_script('tez-chaty-fix', $theme_uri . '/assets/js/chaty-fix.js', array('jquery'), $ver, true);
    }
    
    // Always load header enhanced if requested
    if (file_exists($theme_dir . '/assets/js/header-enhanced.js')) {
        wp_enqueue_script('tez-header-enhanced', $theme_uri . '/assets/js/header-enhanced.js', array('jquery'), $ver, true);
    }
    
    // Localize for all scripts
    wp_localize_script($use_compiled ? 'tez-main-compiled' : 'tez-accessibility', 'tezThemeData', array(
        'homeUrl' => home_url(),
        'themeUrl' => $theme_uri,
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tez_nonce'),
        'isCompiledVersion' => $use_compiled,
        'buildInfo' => $use_compiled ? json_decode(file_get_contents($theme_dir . '/assets/js/dist/build-info.json'), true) : null
    ));

    /**
 * Enhanced React Editor Assets
 */
public function enqueue_react_editor_assets($hook): void {
    if ($hook !== 'toplevel_page_teznevisan-react-editor') {
        return;
    }
    
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    
    // React core libraries
    wp_enqueue_script('react', $theme_uri . '/assets/js/react/react.production.min.js', array(), '18.2.0', false);
    wp_enqueue_script('react-dom', $theme_uri . '/assets/js/react/react-dom.production.min.js', array('react'), '18.2.0', false);
    
    // React components
    if (file_exists($theme_dir . '/assets/js/dist/components.js')) {
        wp_enqueue_script('tez-react-components', $theme_uri . '/assets/js/dist/components.js', array('react'), $ver, false);
    }
    
    // Main React editor
    if (file_exists($theme_dir . '/assets/js/dist/teznevisan-editor.umd.js')) {
        wp_enqueue_script(
            'teznevisan-react-editor',
            $theme_uri . '/assets/js/dist/teznevisan-editor.umd.js',
            array('react', 'react-dom', 'tez-react-components'),
            filemtime($theme_dir . '/assets/js/dist/teznevisan-editor.umd.js'),
            false
        );
    }
    
    // Editor styles
    if (file_exists($theme_dir . '/assets/css/react-editor.css')) {
        wp_enqueue_style('tez-react-editor-styles', $theme_uri . '/assets/css/react-editor.css', array('tez-main'), $ver);
    }
    
    // Localize scripts with theme data
    wp_localize_script('tez-mobile-menu', 'tezThemeData', array(
        'homeUrl' => home_url(),
        'themeUrl' => $theme_uri,
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tez_nonce')
    ));
}

public function render_editor_settings_page(): void {
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['teznevisan_settings_nonce'], 'teznevisan_settings')) {
            // Save settings
            update_option('teznevisan_disable_gutenberg', isset($_POST['disable_gutenberg']));
            update_option('teznevisan_editor_persian_numbers', isset($_POST['persian_numbers']));
            update_option('teznevisan_editor_fontawesome', isset($_POST['fontawesome']));
            update_option('teznevisan_editor_templates', isset($_POST['templates']));
            update_option('teznevisan_editor_accessibility', isset($_POST['accessibility']));
            update_option('teznevisan_autosave_interval', intval($_POST['autosave_interval']));
            
            echo '<div class="notice notice-success"><p>' . __('تنظیمات ذخیره شد.', 'teznevisan') . '</p></div>';
        }
        
        $settings = array(
            'disable_gutenberg' => get_option('teznevisan_disable_gutenberg', true),
            'persian_numbers' => get_option('teznevisan_editor_persian_numbers', true),
            'fontawesome' => get_option('teznevisan_editor_fontawesome', true),
            'templates' => get_option('teznevisan_editor_templates', true),
            'accessibility' => get_option('teznevisan_editor_accessibility', true),
            'autosave_interval' => get_option('teznevisan_autosave_interval', 30)
        );
        
        ?>
        <div class="wrap">
            <h1><?php _e('تنظیمات ویرایشگر تزنویسان', 'teznevisan'); ?></h1>
            
            <form method="post">
                <?php wp_nonce_field('teznevisan_settings', 'teznevisan_settings_nonce'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('غیرفعال کردن گوتنبرگ', 'teznevisan'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="disable_gutenberg" value="1" <?php checked($settings['disable_gutenberg']); ?>>
                                <?php _e('استفاده از ویرایشگر کلاسیک به جای گوتنبرگ', 'teznevisan'); ?>
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('اعداد فارسی', 'teznevisan'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="persian_numbers" value="1" <?php checked($settings['persian_numbers']); ?>>
                                <?php _e('تبدیل خودکار اعداد انگلیسی به فارسی', 'teznevisan'); ?>
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('آیکون‌های FontAwesome', 'teznevisan'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="fontawesome" value="1" <?php checked($settings['fontawesome']); ?>>
                                <?php _e('فعال‌سازی انتخابگر آیکون در ویرایشگر', 'teznevisan'); ?>
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('قالب‌های محتوا', 'teznevisan'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="templates" value="1" <?php checked($settings['templates']); ?>>
                                <?php _e('فعال‌سازی قالب‌های آماده محتوا', 'teznevisan'); ?>
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('دسترسی‌پذیری', 'teznevisan'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="accessibility" value="1" <?php checked($settings['accessibility']); ?>>
                                <?php _e('فعال‌سازی ابزارهای دسترسی‌پذیری', 'teznevisan'); ?>
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?php _e('فاصله ذخیره خودکار', 'teznevisan'); ?></th>
                        <td>
                            <input type="number" name="autosave_interval" value="<?php echo esc_attr($settings['autosave_interval']); ?>" min="10" max="300" step="10">
                            <p class="description"><?php _e('فاصله زمانی ذخیره خودکار به ثانیه (10 تا 300)', 'teznevisan'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(__('ذخیره تنظیمات', 'teznevisan')); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Header Enhancements (from your original function)
     */
    public function teznevisan_enqueue_header_enhancements(): void {
        $theme_uri = get_template_directory_uri();
        
        // Main CSS (if exists separately from main theme style)
        if (file_exists(get_template_directory() . '/assets/css/main.css')) {
            wp_enqueue_style(
                'teznevisan-main-css',
                $theme_uri . '/assets/css/main.css',
                array('tez-main'),
                filemtime(get_template_directory() . '/assets/css/main.css')
            );
        }
        
        // Header enhanced CSS
        if (file_exists(get_template_directory() . '/assets/css/header-enhanced.css')) {
            wp_enqueue_style(
                'teznevisan-header-enhanced',
                $theme_uri . '/assets/css/header-enhanced.css',
                array('tez-main'),
                filemtime(get_template_directory() . '/assets/css/header-enhanced.css')
            );
        }

        // Header enhanced JS
        if (file_exists(get_template_directory() . '/assets/js/header-enhanced.js')) {
            wp_enqueue_script(
                'teznevisan-header-enhanced-js',
                $theme_uri . '/assets/js/header-enhanced.js',
                array('jquery'),
                filemtime(get_template_directory() . '/assets/js/header-enhanced.js'),
                true
            );

            // Localize header script
            wp_localize_script(
                'teznevisan-header-enhanced-js',
                'teznevisanAjax',
                array(
                    'homeUrl' => esc_url(home_url('/')),
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('teznevisan_ajax_nonce'),
                    'strings' => array(
                        'phone' => get_option('phone_number', '09331663849'),
                        'search_placeholder' => __('جستجو در مطالب و خدمات...', 'teznevisan'),
                        'loading' => __('در حال بارگذاری...', 'teznevisan'),
                        'error' => __('خطا در بارگذاری', 'teznevisan')
                    )
                )
            );
        }
    }

    /**
 * React Editor Menu Integration
 */
public function add_react_editor_menu(): void {
    add_menu_page(
        __('ویرایشگر React', 'teznevisan'),
        __('ویرایشگر مدرن', 'teznevisan'),
        'edit_posts',
        'teznevisan-react-editor',
        array($this, 'render_react_editor_page'),
        'dashicons-edit',
        25
    );
    
    // Add submenu for settings if needed
    add_submenu_page(
        'teznevisan-react-editor',
        __('تنظیمات ویرایشگر', 'teznevisan'),
        __('تنظیمات', 'teznevisan'),
        'manage_options',
        'teznevisan-editor-settings',
        array($this, 'render_editor_settings_page')
    );
}

        /**
 * Render React Editor Page
 */
public function render_react_editor_page(): void {
    ?>
    <div class="wrap">
        <h1><?php _e('ویرایشگر مدرن تزنویسان', 'teznevisan'); ?></h1>
        <div id="teznevisan-react-editor-root" class="teznevisan-react-container">
            <div class="loading-spinner">
                <i class="fa-solid fa-spinner fa-spin"></i>
                <p><?php _e('در حال بارگذاری ویرایشگر...', 'teznevisan'); ?></p>
            </div>
        </div>
    </div>
    
    <style>
    .teznevisan-react-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 20px;
        min-height: 600px;
    }
    .loading-spinner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 400px;
        color: #666;
    }
    .loading-spinner i {
        font-size: 32px;
        margin-bottom: 16px;
        color: #1FA547;
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for React libraries to load
        if (typeof React !== 'undefined' && typeof ReactDOM !== 'undefined') {
            initializeReactEditor();
        } else {
            // Retry after a short delay
            setTimeout(function() {
                if (typeof React !== 'undefined' && typeof ReactDOM !== 'undefined') {
                    initializeReactEditor();
                } else {
                    console.error('React libraries not loaded');
                    showErrorMessage();
                }
            }, 1000);
        }
    });
    
    function initializeReactEditor() {
        try {
            const { createElement } = React;
            const { render } = ReactDOM;
            const rootElement = document.getElementById('teznevisan-react-editor-root');
            
            if (rootElement && typeof TeznevisanEditor !== 'undefined') {
                render(
                    createElement(TeznevisanEditor, {
                        locale: 'fa',
                        theme: 'teznevisan',
                        apiUrl: '<?php echo admin_url('admin-ajax.php'); ?>',
                        nonce: '<?php echo wp_create_nonce('teznevisan_editor_nonce'); ?>'
                    }),
                    rootElement
                );
            } else {
                console.error('TeznevisanEditor component not found');
                showErrorMessage();
            }
        } catch (error) {
            console.error('Error initializing React editor:', error);
            showErrorMessage();
        }
    }
    
    function showErrorMessage() {
        const rootElement = document.getElementById('teznevisan-react-editor-root');
        if (rootElement) {
            rootElement.innerHTML = `
                <div class="error-message" style="text-align: center; padding: 40px; color: #d63638;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px; margin-bottom: 16px;"></i>
                    <h2>خطا در بارگذاری ویرایشگر</h2>
                    <p>لطفاً صفحه را مجدداً بارگذاری کنید یا از ویرایشگر کلاسیک استفاده نمایید.</p>
                    <button onclick="location.reload()" class="button button-primary">
                        <i class="fa-solid fa-refresh"></i> بارگذاری مجدد
                    </button>
                </div>
            `;
        }
    }
    </script>
    <?php

}

/**
 * Enhanced Admin Asset Enqueuing
 */
public function tez_enqueue_admin_assets($hook): void {
    $ver = wp_get_theme()->get('Version') ?: time();
    $theme_uri = get_template_directory_uri();
    
    // PRIORITY 5 - Load FontAwesome before WP core admin styles
    wp_enqueue_style('tez-admin-fa7', $theme_uri . '/assets/fonts/fontawesome/css/all.css', array(), '7.0.0', 'all');
    wp_enqueue_style('tez-admin-fa7-override', $theme_uri . '/assets/css/admin-fontawesome.css', array('tez-admin-fa7'), $ver, 'all');
    
    // Admin font injection
    $admin_font_css = "
    @font-face {
        font-family: 'IRANSans';
        src: url('{$theme_uri}/assets/fonts/iransans/IRANSans-Regular.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/iransans/IRANSans-Regular.woff') format('woff');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'Font Awesome 7 Pro';
        src: url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-solid-900.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-solid-900.woff') format('woff');
        font-weight: 900;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'Font Awesome 7 Brands';
        src: url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-brands-400.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-brands-400.woff') format('woff');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
    }
    body, .wp-admin, #wpadminbar {
        font-family: 'IRANSans', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }";
    
    wp_add_inline_style('tez-admin-fa7', $admin_font_css);
    
    // Load editor assets on post edit screens
    if (in_array($hook, array('post.php', 'post-new.php'))) {
        wp_enqueue_style('tez-editor-fa', $theme_uri . '/assets/css/editor-fontawesome.css', array(), $ver);
    }
}

// CRITICAL: Admin FA7 enqueue with early priority
public function tez_enqueue_admin_fontawesome($hook): void {
    $ver = wp_get_theme()->get('Version') ?: time();
    $theme_uri = get_template_directory_uri();
    
    // PRIORITY 5 - Load before WP core admin styles
    wp_enqueue_style('tez-admin-fa7', $theme_uri . '/assets/fonts/fontawesome/css/all.css', array(), '7.0.0', 'all');
    
    // Admin FA override
    wp_enqueue_style('tez-admin-fa7-override', $theme_uri . '/assets/css/admin-fontawesome.css', array('tez-admin-fa7'), $ver, 'all');
    
    // Inject font-face with absolute URLs for admin
    $admin_font_css = "
    @font-face {
        font-family: 'IRANSans';
        src: url('{$theme_uri}/assets/fonts/iransans/IRANSans-Regular.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/iransans/IRANSans-Regular.woff') format('woff');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'Font Awesome 7 Pro';
        src: url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-solid-900.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-solid-900.woff') format('woff');
        font-weight: 900;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'Font Awesome 7 Brands';
        src: url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-brands-400.woff2') format('woff2'),
             url('{$theme_uri}/assets/fonts/fontawesome/webfonts/fa-brands-400.woff') format('woff');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
    }
    body, .wp-admin, #wpadminbar {
        font-family: 'IRANSans', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }
    ";
    
    wp_add_inline_style('tez-admin-fa7', $admin_font_css);
}

// TinyMCE plugin registration - ROBUST METHOD
public function tez_add_tinymce_plugin($plugin_array): array {
    if (current_user_can('edit_posts') || current_user_can('edit_pages')) {
        $plugin_array['tez_iconpicker'] = get_template_directory_uri() . '/assets/js/tinymce/tinymce-plugin-iconpicker.js';
    }
    return $plugin_array;
}

// TinyMCE button registration
public function tez_add_tinymce_button($buttons): array {
    if (current_user_can('edit_posts') || current_user_can('edit_pages')) {
        array_push($buttons, 'tez_iconpicker');
    }
    return $buttons;
}


// TinyMCE language override
public function tez_tinymce_external_languages($external_languages): array {
    $external_languages['fa'] = get_template_directory() . '/assets/js/tinymce/langs/fa.js';
    return $external_languages;
}

// Upload handler for TinyMCE
public function handle_classic_editor_upload(): void {
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'classic_editor_upload')) {
        wp_die(json_encode(['success' => false, 'data' => 'Security error']));
    }
    
    if (!current_user_can('upload_files')) {
        wp_die(json_encode(['success' => false, 'data' => 'Permission denied']));
    }
    
    if (!empty($_FILES['file'])) {
        $uploaded_file = $_FILES['file'];
        // Security validation
            $allowed_types = array(
                'image/jpeg',
                'image/png', 
                'image/gif',
                'image/webp',
                'video/mp4',
                'audio/mp3',
                'application/pdf',
                'text/plain'
            );
            
            if (!in_array($uploaded_file['type'], $allowed_types)) {
                wp_die(json_encode(['success' => false, 'data' => 'File type not allowed']));
            }
            
            // File size limit (10MB)
            if ($uploaded_file['size'] > 10 * 1024 * 1024) {
                wp_die(json_encode(['success' => false, 'data' => 'File too large']));
            }
        $upload = wp_handle_upload($uploaded_file, array('test_form' => false));
        
        if (isset($upload['error'])) {
            wp_die(json_encode(['success' => false, 'data' => $upload['error']]));
        } else {
            wp_die(json_encode(['success' => true, 'data' => ['url' => $upload['url']]]));
        }
    }
    
    wp_die(json_encode(['success' => false, 'data' => 'No file selected']));
}

// Force admin font variables
public function ensure_admin_fontawesome_variables(): void {
    if (!is_admin()) return;
    
    // Inject FA icons data for TinyMCE
        echo '<script>window.tezFaIcons = ' . json_encode([
            'solid' => [
                ['name' => 'خانه', 'class' => 'fa-solid fa-house'],
                ['name' => 'کاربر', 'class' => 'fa-solid fa-user'],
                ['name' => 'ایمیل', 'class' => 'fa-solid fa-envelope'],
                ['name' => 'تلفن', 'class' => 'fa-solid fa-phone'],
                ['name' => 'موقعیت', 'class' => 'fa-solid fa-location-dot'],
                ['name' => 'زمان', 'class' => 'fa-solid fa-clock'],
                ['name' => 'تاریخ', 'class' => 'fa-solid fa-calendar'],
                ['name' => 'جستجو', 'class' => 'fa-solid fa-magnifying-glass'],
                ['name' => 'تنظیمات', 'class' => 'fa-solid fa-gear'],
                ['name' => 'ستاره', 'class' => 'fa-solid fa-star'],
                ['name' => 'قلب', 'class' => 'fa-solid fa-heart'],
                ['name' => 'تیک', 'class' => 'fa-solid fa-check'],
                ['name' => 'ابزار', 'class' => 'fa-solid fa-tools'],
                ['name' => 'کتاب', 'class' => 'fa-solid fa-book'],
                ['name' => 'کیف', 'class' => 'fa-solid fa-briefcase'],
                ['name' => 'وبلاگ', 'class' => 'fa-solid fa-blog'],
                ['name' => 'اطلاعات', 'class' => 'fa-solid fa-circle-info']
            ],
            'brands' => [
                ['name' => 'واتساپ', 'class' => 'fa-brands fa-whatsapp'],
                ['name' => 'تلگرام', 'class' => 'fa-brands fa-telegram'],
                ['name' => 'اینستاگرام', 'class' => 'fa-brands fa-instagram'],
                ['name' => 'فیسبوک', 'class' => 'fa-brands fa-facebook'],
                ['name' => 'توییتر', 'class' => 'fa-brands fa-twitter']
            ]
        ], JSON_UNESCAPED_UNICODE) . ';</script>';
    }

     /**
     * Disable Gutenberg if option is set
     */
    public function disable_gutenberg(): void {
        if (get_option('teznevisan_disable_gutenberg', true)) {
            add_filter('use_block_editor_for_post', '__return_false', 10);
            add_filter('use_block_editor_for_post_type', '__return_false', 10);
        }
    }
    /**
     * Classic Editor Enhancements
     */
    public function enhance_classic_editor(): void {
        // Add custom TinyMCE styles
        add_filter('mce_css', function($mce_css) {
            if (!empty($mce_css)) $mce_css .= ',';
            $mce_css .= get_template_directory_uri() . '/assets/css/editor-fontawesome.css';
            return $mce_css;
        });
        
        // Persian number conversion
        if (get_option('teznevisan_editor_persian_numbers', true)) {
            add_filter('the_content', array($this, 'convert_to_persian_numbers'));
            add_filter('the_excerpt', array($this, 'convert_to_persian_numbers'));
        }
        
        // Auto-save interval
        add_filter('autosave_interval', function() {
            return get_option('teznevisan_autosave_interval', 30);
        });
    }

    /**
     * Convert English numbers to Persian
     */
    public function convert_to_persian_numbers($content): string {
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($english, $persian, $content);
    }

    /**
     * AJAX Handler for React Editor Operations
     */
    public function handle_react_editor_ajax(): void {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', 'teznevisan_editor_nonce')) {
            wp_die(json_encode(['success' => false, 'message' => 'Security error']));
        }
        
        $action = $_POST['editor_action'] ?? '';
        
        switch ($action) {
            case 'save_content':
                $this->save_editor_content();
                break;
                
            case 'load_templates':
                $this->load_content_templates();
                break;
                
            case 'save_template':
                $this->save_content_template();
                break;
                
            default:
                wp_die(json_encode(['success' => false, 'message' => 'Invalid action']));
        }
    }

    /**
     * Save Content from React Editor
     */
    private function save_editor_content(): void {
        if (!current_user_can('edit_posts')) {
            wp_die(json_encode(['success' => false, 'message' => 'Permission denied']));
        }
        
        $content = wp_kses_post($_POST['content'] ?? '');
        $post_id = intval($_POST['post_id'] ?? 0);
        
        if ($post_id > 0 && $content) {
            $result = wp_update_post(array(
                'ID' => $post_id,
                'post_content' => $content
            ));
            
            if ($result) {
                wp_die(json_encode(['success' => true, 'message' => 'Content saved successfully']));
            } else {
                wp_die(json_encode(['success' => false, 'message' => 'Failed to save content']));
            }
        } else {
            wp_die(json_encode(['success' => false, 'message' => 'Invalid data']));
        }
    }

    /**
     * Load Content Templates
     */
    private function load_content_templates(): void {
        $upload_dir = wp_upload_dir();
        $templates_dir = $upload_dir['basedir'] . '/teznevisan/templates';
        
        $templates = array();
        
        if (is_dir($templates_dir)) {
            $files = glob($templates_dir . '/*.json');
            foreach ($files as $file) {
                $template_data = json_decode(file_get_contents($file), true);
                if ($template_data) {
                    $templates[] = $template_data;
                }
            }
        }
        
        wp_die(json_encode(['success' => true, 'templates' => $templates]));
    }

    /**
     * Save Content Template
     */
    private function save_content_template(): void {
        if (!current_user_can('manage_options')) {
            wp_die(json_encode(['success' => false, 'message' => 'Permission denied']));
        }
        
        $template_name = sanitize_file_name($_POST['template_name'] ?? '');
        $template_content = wp_kses_post($_POST['template_content'] ?? '');
        
        if ($template_name && $template_content) {
            $upload_dir = wp_upload_dir();
            $templates_dir = $upload_dir['basedir'] . '/teznevisan/templates';
            
            if (!is_dir($templates_dir)) {
                wp_mkdir_p($templates_dir);
            }
            
            $template_data = array(
                'name' => $template_name,
                'content' => $template_content,
                'created' => current_time('mysql'),
                'author' => get_current_user_id()
            );
            
            $filename = $templates_dir . '/' . $template_name . '.json';
            $result = file_put_contents($filename, json_encode($template_data, JSON_UNESCAPED_UNICODE));
            
            if ($result) {
                wp_die(json_encode(['success' => true, 'message' => 'Template saved successfully']));
            } else {
                wp_die(json_encode(['success' => false, 'message' => 'Failed to save template']));
            }
        } else {
            wp_die(json_encode(['success' => false, 'message' => 'Invalid template data']));
        }
    }


    public function add_admin_fontawesome_styles(): void {
    if (!is_admin()) return;

    // Preload the most common webfonts for better performance
    echo '<link rel="preload" href="' . esc_url(TEZNEVISAN_ASSETS_URL . '/fonts/fontawesome/webfonts/fa-solid-900.woff2') . '" as="font" type="font/woff2" crossorigin>';
    echo '<link rel="preload" href="' . esc_url(TEZNEVISAN_ASSETS_URL . '/fonts/fontawesome/webfonts/fa-brands-400.woff2') . '" as="font" type="font/woff2" crossorigin>';

    echo '<style id="teznevisan-admin-fontawesome">
        /* Global FA7 forced load, targeting the admin sidebar/menu and toolbar */
        .fa, .fa-solid, .fa-regular, .fa-brands, .fa-light, .fa-thin, .fa-duotone,
        [class^="fa-"], [class*=" fa-"], .dashicons-before:before, #adminmenu .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", "Font Awesome 7 Free" !important;
            font-weight: 900 !important;
            display: inline-block !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            direction: ltr !important;
        }
        .fa-regular, .fa-regular:before { font-weight: 400 !important; font-family: "Font Awesome 7 Free" !important; }
        .fa-light, .fa-light:before  { font-weight: 300 !important; }
        .fa-thin, .fa-thin:before { font-weight: 100 !important; }
        .fa-brands, .fa-brands:before { font-family: "Font Awesome 7 Brands" !important; font-weight: 400 !important; }
        .fa-duotone, .fa-duotone:before { font-weight: 900 !important; }
        
        /* Icon size/spacing for sidebar and menu */
        #adminmenu .fa, #adminmenu [class^="fa-"] {
            margin-right: 8px;
            width: 16px;
            text-align: center;
            font-size: 16px;
        }
        .wp-menu-image .fa, #adminmenu .wp-menu-image:before {
            font-size: 18px !important;
            line-height: 1 !important;
            width: 20px !important;
            height: 20px !important;
            text-align: center !important;
        }
        #adminmenu .wp-menu-image, #adminmenu .wp-menu-image:before {
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        /* Example of how to override a specific Dashicon menu item */
        #menu-posts .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f02d"; /* example: fa-book */
            font-weight: 900;
        }
        #menu-media .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f03e"; /* example: fa-image */
            font-weight: 900;
        }
        #menu-pages .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f15c"; /* example: fa-file-lines */
            font-weight: 900;
        }
        #menu-comments .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f086"; /* example: fa-comment */
            font-weight: 900;
        }
        #menu-appearance .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f53f"; /* example: fa-palette */
            font-weight: 900;
        }
        #menu-plugins .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f1e6";
            font-weight: 900;
        }
        #menu-users .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f0c0";
            font-weight: 900;
        }
        #menu-tools .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f013";
            font-weight: 900;
        }
        #menu-settings .wp-menu-image:before {
            font-family: "Font Awesome 7 Pro" !important;
            content: "\\f013";
            font-weight: 900;
        }
        /* Add your own CPT and submenu icon rules here */
    </style>';
    }

   
   /**
     * Add Custom Styles with FIXED FontAwesome Icons
     */
    
   public function add_custom_styles(): void {
        $primary_color = get_theme_mod('primary_color', '#1FA547');
        $container_width = get_theme_mod('container_width', '1200');
        
        echo '<style id="teznevisan-custom">
                /* FontAwesome Critical Load with ALL Icons - FIXED */
    .fa, .fa-solid, .fa-regular, .fa-brands, [class^="fa-"], [class*=" fa-"] {
        font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", "Font Awesome 7 Free" !important;
        font-weight: 900 !important;
        direction: ltr !important;
        display: inline-block !important;
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
    }
    .fa-regular { 
        font-weight: 400 !important; 
    }
    .fa-brands { 
        font-family: "Font Awesome 7 Brands" !important; 
        font-weight: 400 !important; 
    }

    /* FORCE SPECIFIC ICONS - UPDATED TO FA7 PRO */
    .fa-whatsapp:before { content: "\f232" !important; }
    .fa-telegram:before { content: "\e0eb" !important; }
    .fa-paper-plane:before { content: "\f1d8" !important; }
    .fa-message-sms:before { content: "\f7cd" !important; }
    .fa-comments:before { content: "\f086" !important; }
    .fa-xmark:before { content: "\f00d" !important; }
    .fa-magnifying-glass:before { content: "\f002" !important; }
    .fa-envelope:before { content: "\f0e0" !important; }
    .fa-phone:before { content: "\f095" !important; }
    .fa-universal-access:before { content: "\f29a" !important; }
    .fa-house:before { content: "\f015" !important; }
    .fa-gear:before { content: "\f013" !important; }
    .fa-circle-info:before { content: "\f05a" !important; }
    .fa-blog:before { content: "\f781" !important; }
    .fa-sun:before { content: "\f185" !important; }
    .fa-moon:before { content: "\f186" !important; }
    .fa-book-reader:before { content: "\f5da" !important; }
    .fa-circle-half-stroke:before { content: "\f042" !important; }
    .fa-minus:before { content: "\f068" !important; }
    .fa-plus:before { content: "\f067" !important; }
    .fa-font:before { content: "\f031" !important; }
    .fa-hand-point-right:before { content: "\f0a4" !important; }
    .fa-eye:before { content: "\f06e" !important; }
    .fa-arrow-rotate-left:before { content: "\f0e2" !important; }
    .fa-bars:before { content: "\f0c9" !important; }
    .fa-chevron-down:before { content: "\f078" !important; }
    .fa-chevron-up:before { content: "\f077" !important; }
    .fa-briefcase:before { content: "\f0b1" !important; }

    /* Ensure IRANSans for all text elements */
    body, h1, h2, h3, h4, h5, h6, p, a, span, div, button, input, textarea, select, label,
    .toggle-label, .widget-text, .mobile-title, .site-title, .site-description,
    .theme-control span, .font-control span, .tool-control span, .chaty-channel span,
    .mobile-menu a, .panel-header h3, .setting-group h4, .search-modal-header h3,
    .search-suggestions h4, .search-tag, .popular-searches {
        font-family: "IRANSans", -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    /* Exception for FontAwesome icons */
    .fa, .fa-solid, .fa-regular, .fa-brands, [class^="fa-"], [class*=" fa-"] { 
        font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", "Font Awesome 7 Free" !important; 
    
            
            /* Dynamic theme colors */
            :root {
                --primary-color: ' . $primary_color . ';
                --primary-dark: #178A3A;
                --primary-light: #2FD65A;
                --container-width: ' . $container_width . 'px;
            }
            
            /* Desktop Navigation Menu Styles - ENHANCED */
            .primary-navigation {
                position: relative;
            }
            
            .primary-menu {
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
                align-items: center;
                gap: 0.5rem;
            }
            
            .primary-menu li {
                position: relative;
                margin: 0;
            }
            
            .primary-menu > li > a {
                color: #333;
                text-decoration: none;
                padding: 1rem 1.25rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 600;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 12px;
                white-space: nowrap;
                position: relative;
            }
            
            .primary-menu > li > a:hover,
            .primary-menu > li > a:focus {
                background: var(--primary-color);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            
            .menu-item-has-children > a .fa-chevron-down {
                margin-right: 0.25rem;
                transition: transform 0.3s ease;
                font-size: 0.875rem;
            }
            
            .menu-item-has-children:hover > a .fa-chevron-down {
                transform: rotate(180deg);
            }
            
            .sub-menu {
                position: absolute;
                top: calc(100% + 10px);
                right: 0;
                background: white;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                border-radius: 16px;
                padding: 1rem 0;
                min-width: 280px;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px) scale(0.95);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 999;
                border: 1px solid rgba(0, 0, 0, 0.1);
                list-style: none;
                margin: 0;
                backdrop-filter: blur(10px);
            }
            
            .menu-item-has-children:hover .sub-menu,
            .menu-item-has-children:focus-within .sub-menu {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
            }
            
            .sub-menu li {
                margin: 0;
            }
            
            .sub-menu a {
                padding: 0.875rem 1.75rem !important;
                color: #555 !important;
                font-weight: 500 !important;
                border-radius: 0 !important;
                transition: all 0.2s ease !important;
                gap: 0.75rem !important;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .sub-menu li:last-child a {
                border-bottom: none;
            }
            
            .sub-menu a:hover,
            .sub-menu a:focus {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
                color: white !important;
                transform: translateX(-5px) !important;
                padding-right: 2.25rem !important;
                box-shadow: none !important;
            }
            
            .sub-menu a i {
                color: var(--primary-color);
                transition: color 0.2s ease;
            }
            
            .sub-menu a:hover i,
            .sub-menu a:focus i {
                color: white;
            }
            
            /* Mobile Menu Styles */
            .mobile-menu {
                list-style: none;
                margin: 0;
                padding: 1rem;
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            
            .mobile-menu li {
                margin: 0;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .mobile-menu li:last-child {
                border-bottom: none;
            }
            
            .mobile-menu a {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                color: #333;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            
            .mobile-menu a:hover {
                background: var(--primary-color);
                color: white;
                padding-right: 1.5rem;
            }
            
            .mobile-menu i {
                font-size: 1.2rem;
                color: var(--primary-color);
                width: 20px;
                text-align: center;
            }
            
            .mobile-menu a:hover i {
                color: white;
            }
            
            /* Base layout fixes */
            body {
                direction: rtl !important;
                text-align: right !important;
                padding-top: 90px !important;
                background: #FFFFFF !important;
                color: #212529 !important;
            }
            
            @media (max-width: 768px) {
                body { padding-top: 70px !important; }
            }
        </style>';
    }
    

    /**
     * Remove Gutenberg Assets - ADDED TO FIX FATAL ERROR
     */
    public function remove_gutenberg_assets(): void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_style('global-styles');
    }
    
    /**
     * Remove Gutenberg Admin Assets - ADDED TO FIX FATAL ERROR
     */
    public function remove_gutenberg_admin_assets(): void
    {
        wp_dequeue_script('wp-block-editor');
        wp_dequeue_script('wp-block-library');
        wp_dequeue_script('wp-edit-post');
        wp_dequeue_style('wp-block-editor');
        wp_dequeue_style('wp-edit-post');
    }
    
    /**
     * RankMath Compatibility and Enhancement - FIXED
     */
    public function rank_math_compatibility(): void
    {
        // Add RankMath support
        add_theme_support('rank-math-breadcrumbs');
        
        // Don't remove title tag if RankMath is active - let it handle properly
        if (class_exists('RankMath')) {
            // Add custom RankMath filters
            add_filter('rank_math/frontend/title', array($this, 'enhanceRankMathTitle'));
            add_filter('rank_math/frontend/description', array($this, 'enhanceRankMathDescription'));
            add_filter('rank_math/opengraph/facebook/image', array($this, 'enhanceRankMathImage'));
            add_filter('rank_math/paper/auto_generated_description', array($this, 'generateAutoDescription'), 10, 2);
        }
    }
    
    public function rank_math_customization(): void
    {
        // RankMath customization functionality
        if (class_exists('RankMath')) {
            add_filter('rank_math/frontend/breadcrumb/args', array($this, 'customize_rankmath_breadcrumb'));
            add_filter('rank_math/frontend/title', array($this, 'customize_rankmath_title'));
        }
    }
    
    public function customize_rankmath_breadcrumb($args) {
        $args['separator'] = ' / ';
        $args['home_text'] = 'خانه';
        return $args;
    }
    
    public function customize_rankmath_title($title) {
        return $title;
        if (class_exists('RankMath')) {
            $custom_schema = '
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "ProfessionalService",
                "name": "' . get_bloginfo('name') . '",
                "description": "' . get_bloginfo('description') . '",
                "url": "' . home_url() . '",
                "logo": {
                    "@type": "ImageObject",
                    "url": "' . TEZNEVISAN_ASSETS_URL . '/images/teznevisan.webp",
                    "width": 200,
                    "height": 100
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "' . get_theme_mod('phone_number', '+989331663849') . '",
                    "contactType": "customer service",
                    "availableLanguage": ["Persian", "English"],
                    "areaServed": "IR"
                },
                "address": {
                    "@type": "PostalAddress",
                    "addressCountry": "IR",
                    "addressLocality": "تهران"
                },
                "sameAs": [
                    "https://t.me/teznevisan",
                    "https://wa.me/989331663849",
                    "mailto:teznevisan@gmail.com"
                ],
                "serviceType": [
                    "نگارش پایان نامه",
                    "نگارش مقاله علمی", 
                    "ترجمه تخصصی",
                    "ویرایش و پروف متن",
                    "نگارش پروپوزال",
                    "تایپ و صفحه‌آرایی"
                ],
                "areaServed": {
                    "@type": "Country",
                    "name": "Iran"
                }
            }
            </script>';
            
            echo $custom_schema;
        }
    }
    
    public function enhanceRankMathSchema($data, $jsonld): array
    {
        // Add accessibility schema
        $accessibility_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'accessibilityFeature' => [
                'alternativeText',
                'readingOrder', 
                'structuralNavigation',
                'tableOfContents',
                'unlocked',
                'highContrast',
                'largePrint',
                'rubyAnnotations'
            ],
            'accessibilityHazard' => 'none',
            'accessibilityControl' => [
                'fullKeyboardControl',
                'fullMouseControl',
                'fullTouchControl',
                'fullVideoControl'
            ],
            'accessibilityAPI' => 'ARIA'
        ];
        
        $data['teznevisan_accessibility'] = $accessibility_schema;
        return $data;
    }
    
    public function enhanceRankMathTitle($title): string
    {
        if (is_home() || is_front_page()) {
            return get_bloginfo('name') . ' | ' . get_bloginfo('description');
        }
        return $title;
    }
    
    public function enhanceRankMathDescription($description): string
    {
        if (empty($description) && (is_home() || is_front_page())) {
            return get_bloginfo('description');
        }
        return $description;
    }
    
    public function enhanceRankMathImage($image): string
    {
        if (empty($image)) {
            return TEZNEVISAN_ASSETS_URL . '/images/teznevisan-og.jpg';
        }
        return $image;
    }
    
    public function generateAutoDescription($description, $post): string
    {
        if (empty($description) && $post) {
            $excerpt = get_the_excerpt($post);
            if (!empty($excerpt)) {
                return wp_trim_words($excerpt, 25);
            }
            
            $content = strip_tags($post->post_content);
            return wp_trim_words($content, 25);
        }
        return $description;
    }

    
    public function handle_ajax_search(): void
    {
            // Set proper headers for AJAX
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=utf-8');
                header('Cache-Control: no-cache, must-revalidate');
            }
            
            // Security check
           if (!wp_verify_nonce($_POST['nonce'], 'teznevisan_nonce')) { wp_send_json_error(['message' => 'خطای امنیتی']); return; }
        $query = sanitize_text_field($_POST['query']);

            if (empty($query) || strlen($query) < 2) {
                wp_send_json_error([
                    'message' => 'لطفاً حداقل ۲ کاراکتر وارد کنید',
                    'error_code' => 'QUERY_TOO_SHORT'
                ]);
                return;
            }

            // Validate query for security
            if (preg_match('/[<>"\']/', $query)) {
                wp_send_json_error([
                    'message' => 'کاراکترهای غیرمجاز در جستجو',
                    'error_code' => 'INVALID_CHARACTERS'
                ]);
                return;
            }
        
        try {
            $search_query = new WP_Query(array(
                'post_type' => array('post', 'page', 'portfolio', 'services'),
                's' => sanitize_text_field($query),
                'posts_per_page' => 10,
                'post_status' => 'publish',
                'orderby' => 'relevance',
                'order' => 'DESC',
                'no_found_rows' => false,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
                'meta_query' => array(
                'relation' => 'OR',
                    array(
                        'key' => '_search_exclude',
                        'compare' => 'NOT EXISTS'
                    ),
                    array(
                        'key' => '_search_exclude',
                        'value' => '1',
                        'compare' => '!='
                    )
                ),
                'suppress_filters' => false
            ));
            
            // Check for WP_Query errors
            if (is_wp_error($search_query)) {
                throw new Exception('خطا در پردازش جستجو: ' . $search_query->get_error_message());
            }
            
            $results = [];
            
            if ($search_query->have_posts()) {
                while ($search_query->have_posts()) {
                    $search_query->the_post();
                    
                    $excerpt = get_the_excerpt();
                    if (empty($excerpt)) {
                        $excerpt = wp_trim_words(strip_tags(get_the_content()), 25);
                    }
                    
                    $results[] = [
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'excerpt' => wp_trim_words($excerpt, 20),
                        'url' => get_permalink(),
                        'type' => get_post_type_object(get_post_type())->labels->singular_name,
                        'date' => get_the_date('Y-m-d'),
                        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'teznevisan-thumbnail'),
                        'author' => get_the_author(),
                        'categories' => wp_get_post_categories(get_the_ID(), ['fields' => 'names'])
                    ];
                }
                wp_reset_postdata();
        }
        /**
     * Enhanced AJAX Search Handler - WORKING VERSION
     */
            add_action('wp_ajax_ajax_search', function() {
           $theme = TeznevisanTheme::getInstance();
           $theme->handleAjaxSearch();
          });
           add_action('wp_ajax_nopriv_ajax_search', function() {
           $theme = TeznevisanTheme::getInstance();
          $theme->handleAjaxSearch();
           });
            
            // Log search for analytics
            $this->logSearch($query, count($results));
            
            wp_send_json_success($results);
            
        } catch (Exception $e) {
            error_log('Teznevisan Search Error: ' . $e->getMessage());
            wp_send_json_error([
                'message' => 'خطا در انجام جستجو. لطفاً دوباره تلاش کنید.',
                'error_code' => 'SEARCH_EXCEPTION',
                'debug' => WP_DEBUG ? $e->getMessage() : ''
            ]);
        } catch (Error $e) {
            error_log('Teznevisan Search Fatal Error: ' . $e->getMessage());
            wp_send_json_error([
                'message' => 'خطا در اتصال به سرور. لطفاً صفحه را رفرش کنید.',
                'error_code' => 'SERVER_CONNECTION_ERROR',
                'debug' => WP_DEBUG ? $e->getMessage() : ''
            ]);
        }
    }

    
    /**
     * Log Search Function - ADDED TO FIX FATAL ERROR
     */
    private function logSearch(string $query, int $results_count): void
    {
        $search_log = get_option('teznevisan_search_log', array());
        $today = date('Y-m-d');
        
        if (!isset($search_log[$today])) {
            $search_log[$today] = array();
        }
        
        $search_log[$today][] = array(
            'query' => $query,
            'results_count' => $results_count,
            'timestamp' => current_time('mysql'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        );
        
        // Keep only last 30 days
        $search_log = array_slice($search_log, -30, null, true);
        update_option('teznevisan_search_log', $search_log);
    }
    
    /**
     * Menu Fallback Functions - WORKING
     */

    public function mobile_fallback_menu(): void
{
    echo '<ul class="mobile-menu">
        <li><a href="' . home_url() . '"><i class="fa-solid fa-house"></i><span>خانه</span></a></li>
        <li><a href="' . home_url('/services') . '"><i class="fa-solid fa-gear"></i><span>خدمات</span></a></li>
        <li><a href="' . home_url('/about') . '"><i class="fa-solid fa-circle-info"></i><span>درباره ما</span></a></li>
        <li><a href="' . home_url('/blog') . '"><i class="fa-solid fa-blog"></i><span>بلاگ</span></a></li>
        <li><a href="' . home_url('/portfolio') . '"><i class="fa-solid fa-briefcase"></i><span>نمونه کار</span></a></li>
        <li><a href="' . home_url('/contact') . '"><i class="fa-solid fa-envelope"></i><span>تماس با ما</span></a></li>
    </ul>';
}
    
    public function desktop_fallback_menu(): void
    {
        echo '<ul class="primary-menu">
            <li><a href="' . home_url() . '"><i class="fa-solid fa-house"></i>خانه</a></li>
            <li class="menu-item-has-children">
                <a href="' . home_url('/services') . '"><i class="fa-solid fa-gear"></i>خدمات <i class="fa-solid fa-chevron-down"></i></a>
                <ul class="sub-menu">
                    <li><a href="' . home_url('/services/thesis') . '">نگارش پایان نامه</a></li>
                    <li><a href="' . home_url('/services/article') . '">نگارش مقاله</a></li>
                    <li><a href="' . home_url('/services/translation') . '">ترجمه تخصصی</a></li>
                    <li><a href="' . home_url('/services/editing') . '">ویرایش و پروف</a></li>
                    <li><a href="' . home_url('/services/proposal') . '">نگارش پروپوزال</a></li>
                </ul>
            </li>
            <li><a href="' . home_url('/about') . '"><i class="fa-solid fa-circle-info"></i>درباره ما</a></li>
            <li><a href="' . home_url('/blog') . '"><i class="fa-solid fa-blog"></i>بلاگ</a></li>
            <li><a href="' . home_url('/portfolio') . '"><i class="fa-solid fa-briefcase"></i>نمونه کارها</a></li>
            <li><a href="' . home_url('/contact') . '"><i class="fa-solid fa-envelope"></i>تماس با ما</a></li>
        </ul>';
    }




/**
 * Add Accessibility Widget - FIXED PROPERLY
 */
public function add_accessibility_widget(): void
{
    if (is_admin()) {
        return;
    }
    
    ?>
    <!-- Accessibility Widget - COMPLETELY FIXED -->
    <div id="accessibility-widget" class="accessibility-widget-fixed" role="complementary" aria-label="ابزارهای دسترسی و تم">
        <button id="accessibility-toggle" class="accessibility-toggle-fixed" aria-label="باز/بسته کردن پنل دسترسی" aria-expanded="false">
            <i class="fa-solid fa-universal-access" aria-hidden="true"></i>
            <span class="toggle-text-fixed">دسترسی</span>
        </button>
        
        <div id="accessibility-panel" class="accessibility-panel-fixed" aria-hidden="true">
            <div class="accessibility-header-fixed">
                <h3>تنظیمات دسترسی و تم</h3>
                <button id="accessibility-close" class="close-btn-fixed" aria-label="بستن">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
            
            <div class="accessibility-content-fixed">
                <!-- Theme Modes -->
                <div class="control-group-fixed">
                    <h4>حالت‌های تم</h4>
                    <div class="control-buttons-fixed theme-modes-fixed">
                        <button class="theme-btn-fixed" data-theme="light" aria-label="تم روشن" role="button" tabindex="0">
                    <i class="fa-solid fa-sun" aria-hidden="true"></i>
                    <span>روشن</span>
                </button>
                
                <button class="theme-btn-fixed" data-theme="dark" aria-label="تم تیره" role="button" tabindex="0">
                    <i class="fa-solid fa-moon" aria-hidden="true"></i>
                    <span>تیره</span>
                </button>
                
                <button class="theme-btn-fixed" data-theme="sepia" aria-label="تم کاغذی" role="button" tabindex="0">
                    <i class="fa-solid fa-book-reader" aria-hidden="true"></i>
                    <span>کاغذی</span>
                </button>
                
                <button class="theme-btn-fixed" data-theme="contrast" aria-label="تم کنتراست بالا" role="button" tabindex="0">
                    <i class="fa-solid fa-circle-half-stroke" aria-hidden="true"></i>
                    <span>کنتراست</span>
                </button>
                    </div>
                </div>
                
                <!-- Font Size Controls -->
                <div class="control-group-fixed">
                    <h4>اندازه قلم</h4>
                    <div class="control-buttons-fixed font-controls-fixed">
                        <button id="font-decrease" class="font-btn-fixed" aria-label="کاهش اندازه فونت">
                    <i class="fa-solid fa-minus" aria-hidden="true"></i>
                    <span>کوچکتر</span>
                </button>
                
                <button id="font-increase" class="font-btn-fixed" aria-label="افزایش اندازه فونت">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    <span>بزرگتر</span>
                </button>
                
                <button id="font-reset" class="font-btn-fixed" aria-label="بازنشانی اندازه فونت">
                    <i class="fa-solid fa-font" aria-hidden="true"></i>
                    <span>عادی</span>
                </button>
                    </div>
                </div>
                
                <!-- Accessibility Tools -->
                <div class="control-group-fixed">
                    <h4>ابزارهای دسترسی</h4>
                    <div class="control-buttons-fixed accessibility-tools-fixed">
                        <button id="reading-guide" class="feature-btn-fixed" aria-label="راهنمای خواندن">
                    <i class="fa-solid fa-hand-point-right" aria-hidden="true"></i>
                    <span>راهنمای خواندن</span>
                </button>
                
                <button id="focus-mode" class="feature-btn-fixed" aria-label="حالت تمرکز">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                    <span>حالت تمرکز</span>
                </button>
                
                <button id="reset-all" class="reset-btn-fixed" aria-label="بازنشانی همه تنظیمات">
                    <i class="fa-solid fa-arrow-rotate-left" aria-hidden="true"></i>
                    <span>بازنشانی</span>
                </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reading Guide Line -->
    <div id="reading-guide-line" class="reading-guide-line-fixed" style="display: none;"></div>
    
    <!-- Mobile Menu Structure -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay">
        <div class="mobile-menu-wrapper">
            <div class="mobile-menu-header">
                <div class="mobile-brand">
                    <img src="<?php echo TEZNEVISAN_ASSETS_URL; ?>/images/teznevisan-icon.png" alt="تزنویسان" class="mobile-logo">
                    <span class="mobile-title"><?php bloginfo('name'); ?></span>
                </div>
                <button class="mobile-menu-close" id="mobile-menu-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <div class="mobile-menu-content">
                <nav class="mobile-navigation" role="navigation" aria-label="منوی اصلی">
                <?php
                // First try primary menu, then mobile, then fallback
                $mobile_menu = wp_nav_menu(array(
                    'theme_location' => has_nav_menu('mobile') ? 'mobile' : 'primary',
                    'container' => false,
                    'menu_class' => 'mobile-menu',
                    'depth' => 2,
                    'walker' => new TeznevisanMobileMenuWalker(),
                    'fallback_cb' => array($this, 'mobile_fallback_menu'),
                    'echo' => false
                ));
                
                if (!empty($mobile_menu)) {
                    echo $mobile_menu;
                } else {
                    $this->mobile_fallback_menu();
                }
                ?>
            </nav>
                
                <div class="mobile-menu-footer">
                    <a href="tel:<?php echo get_theme_mod('phone_number', '09331663849'); ?>" class="mobile-phone">
                        <i class="fa-solid fa-phone"></i>
                        <span>تماس مستقیم</span>
                    </a>
                    <a href="#mobile-order" class="mobile-cta">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>سفارش سریع</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Accessibility Widget - COMPLETELY FIXED WITH PROPER CONTRAST */
    .accessibility-widget-fixed {
        position: fixed !important;
        top: 50% !important;
        left: 0 !important;
        transform: translateY(-50%) !important;
        z-index: 9998 !important;
        font-family: 'IRANSans', -apple-system, BlinkMacSystemFont, sans-serif !important;
        pointer-events: auto !important;
        direction: rtl !important;
    }

    .accessibility-toggle-fixed {
        width: 60px !important;
        height: 60px !important;
        border-radius: 0 15px 15px 0 !important;
        background: #1FA547 !important;
        border: none !important;
        color: white !important;
        cursor: pointer !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 16px !important;
        transition: all 0.3s ease !important;
        box-shadow: 2px 0 15px rgba(31, 165, 71, 0.3) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .accessibility-toggle-fixed:hover {
        background: #178A3A !important;
        transform: translateX(5px) !important;
        box-shadow: 3px 0 20px rgba(31, 165, 71, 0.4) !important;
    }

    .accessibility-toggle-fixed:focus {
        outline: 3px solid #FFD700 !important;
        outline-offset: 2px !important;
    }

    .toggle-text-fixed {
        font-size: 9px !important;
        margin-top: 2px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        letter-spacing: 0.5px !important;
    }

    .accessibility-panel-fixed {
        position: absolute !important;
        left: 60px !important;
        top: 50% !important;
        transform: translateY(-50%) scale(0.8) !important;
        width: 340px !important;
        max-height: 80vh !important;
        background: #ffffff !important;
        border-radius: 15px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2) !important;
        border: 2px solid #e0e0e0 !important;
        opacity: 0 !important;
        visibility: hidden !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        z-index: 9999 !important;
        overflow: hidden !important;
    }

    .accessibility-panel-fixed.open {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(-50%) scale(1) !important;
    }

    .accessibility-header-fixed {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 20px !important;
        background: linear-gradient(135deg, #1FA547, #2FD65A) !important;
        color: white !important;
    }

    .accessibility-header-fixed h3 {
        margin: 0 !important;
        font-size: 16px !important;
        font-family: 'IRANSans', sans-serif !important;
        font-weight: 700 !important;
    }

    .accessibility-close-fixed {
        background: rgba(255, 255, 255, 0.2) !important;
        border: none !important;
        color: white !important;
        cursor: pointer !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
        font-size: 14px !important;
    }

    .accessibility-close-fixed:hover {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: scale(1.1) !important;
    }

    .accessibility-close-fixed:focus {
        outline: 2px solid #FFD700 !important;
        outline-offset: 2px !important;
    }

    .accessibility-content-fixed {
        padding: 20px !important;
        max-height: calc(80vh - 80px) !important;
        overflow-y: auto !important;
    }

    .control-group-fixed {
        margin-bottom: 25px !important;
    }

    .control-group-fixed:last-child {
        margin-bottom: 0 !important;
    }

    .control-group-fixed h4 {
        margin: 0 0 12px 0 !important;
        font-size: 14px !important;
        color: #2c3e50 !important;
        font-weight: 700 !important;
        font-family: 'IRANSans', sans-serif !important;
        padding-bottom: 8px !important;
        border-bottom: 2px solid #ecf0f1 !important;
    }

    .control-buttons-fixed {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 10px !important;
    }

    .theme-modes-fixed {
        grid-template-columns: 1fr 1fr !important;
    }

    .font-controls-fixed {
        grid-template-columns: 1fr 1fr 1fr !important;
    }

    .accessibility-tools-fixed {
        grid-template-columns: 1fr 1fr !important;
    }

    .control-btn-fixed {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 12px 10px !important;
        background: #f8f9fa !important;
        border: 2px solid #e9ecef !important;
        border-radius: 12px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        font-size: 11px !important;
        color: #495057 !important;
        font-family: 'IRANSans', sans-serif !important;
        font-weight: 600 !important;
        min-height: 70px !important;
        justify-content: center !important;
    }

    .control-btn-fixed:hover {
        background: #1FA547 !important;
        color: white !important;
        border-color: #178A3A !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(31, 165, 71, 0.3) !important;
    }

    .control-btn-fixed:focus {
        outline: 3px solid #FFD700 !important;
        outline-offset: 2px !important;
    }

    .control-btn-fixed.active-fixed,
    .control-btn-fixed[aria-pressed="true"] {
        background: #1FA547 !important;
        color: white !important;
        border-color: #178A3A !important;
        box-shadow: 0 2px 8px rgba(31, 165, 71, 0.4) !important;
    }

    .control-btn-fixed i {
        font-size: 18px !important;
        margin-bottom: 2px !important;
    }

    .control-btn-fixed span {
        font-weight: 600 !important;
        line-height: 1.2 !important;
        text-align: center !important;
    }

    /* Reading Guide Line */
    .reading-guide-line-fixed {
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        height: 4px !important;
        background: linear-gradient(90deg, transparent, #1FA547, transparent) !important;
        pointer-events: none !important;
        z-index: 9997 !important;
        box-shadow: 0 0 10px rgba(31, 165, 71, 0.7) !important;
        border-radius: 2px !important;
    }

    /* Theme Variations - PROPER CONTRAST */
    body[data-theme="dark"] {
        background-color: #1a1a1a !important;
        color: #f0f0f0 !important;
    }

    body[data-theme="dark"] .accessibility-panel-fixed {
        background: #2d2d2d !important;
        border-color: #404040 !important;
        color: #f0f0f0 !important;
    }

    body[data-theme="dark"] .control-group-fixed h4 {
        color: #e0e0e0 !important;
        border-bottom-color: #404040 !important;
    }

    body[data-theme="dark"] .control-btn-fixed {
        background: #383838 !important;
        color: #e0e0e0 !important;
        border-color: #555555 !important;
    }

    body[data-theme="sepia"] {
        background-color: #f4ecd8 !important;
        color: #3e2723 !important;
    }

    body[data-theme="sepia"] .accessibility-panel-fixed {
        background: #f9f2e7 !important;
        border-color: #d4b896 !important;
    }

    body[data-theme="sepia"] .control-btn-fixed {
        background: #ede0c8 !important;
        color: #5d4037 !important;
        border-color: #bcaaa4 !important;
    }

    body[data-theme="high-contrast"] {
        background-color: #000000 !important;
        color: #ffffff !important;
    }

    body[data-theme="high-contrast"] * {
        background-color: inherit !important;
        color: inherit !important;
        border-color: #ffffff !important;
    }

    body[data-theme="high-contrast"] .accessibility-panel-fixed {
        background: #000000 !important;
        color: #ffffff !important;
        border: 3px solid #ffffff !important;
    }

    body[data-theme="high-contrast"] .control-btn-fixed {
        background: #000000 !important;
        color: #ffffff !important;
        border: 2px solid #ffffff !important;
    }

    body[data-theme="high-contrast"] .control-btn-fixed:hover,
    body[data-theme="high-contrast"] .control-btn-fixed.active-fixed {
        background: #ffffff !important;
        color: #000000 !important;
    }

    /* Font Size Classes */
    body.font-small {
        font-size: 14px !important;
    }

    body.font-normal {
        font-size: 16px !important;
    }

    body.font-large {
        font-size: 18px !important;
    }

    body.font-xlarge {
        font-size: 20px !important;
    }

    body.font-xxlarge {
        font-size: 22px !important;
    }

    /* Focus Mode */
    body.focus-mode * {
        transition: opacity 0.3s ease !important;
    }

    body.focus-mode *:not(:hover):not(:focus):not(:focus-within) {
        opacity: 0.7 !important;
    }

    /* Mobile Adjustments */
    
    /* Mobile Menu Styles */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            transition: right 0.4s ease;
            backdrop-filter: blur(5px);
        }

        .mobile-menu-overlay.open {
            right: 0;
        }

        .mobile-menu-wrapper {
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100vh;
            background: #ffffff;
            transform: translateX(100%);
            transition: transform 0.4s ease;
            overflow-y: auto;
        }

        .mobile-menu-overlay.open .mobile-menu-wrapper {
            transform: translateX(0);
        }

        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #1FA547, #2FD65A);
            color: white;
        }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .mobile-title {
            font-weight: 700;
            font-size: 16px;
        }

        .mobile-menu-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .mobile-menu-content {
            padding: 0;
        }

        .mobile-navigation {
            padding: 0;
        }

        .mobile-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .mobile-menu .menu-item {
            border-bottom: 1px solid #f0f0f0;
        }

        .mobile-menu .menu-item {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.4s ease;
        }

        .mobile-menu .menu-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 25px;
            color: #333;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .mobile-menu .menu-item a:hover {
            background: #f8f9fa;
            color: #1FA547;
            padding-right: 30px;
        }

        .mobile-menu .menu-item a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color: #1FA547;
        }

        .mobile-menu-footer {
            padding: 20px 25px;
            border-top: 2px solid #f0f0f0;
            margin-top: 20px;
        }

        .mobile-cta, .mobile-phone {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            color: #333;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .mobile-cta:hover, .mobile-phone:hover {
            color: #1FA547;
        }

        .mobile-cta i, .mobile-phone i {
            font-size: 16px;
            color: #1FA547;
            width: 20px;
            text-align: center;
        }

        /* Mobile Navigation Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            color: #333;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        
        .mobile-menu-toggle:hover {
            color: var(--primary-color);
        }
        
        .hamburger-lines {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        
        .hamburger-line {
            width: 25px;
            height: 3px;
            background: currentColor;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .mobile-menu-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .mobile-menu-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Mobile Menu Overlay Styles */
            .mobile-menu-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.7);
                z-index: 9999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                backdrop-filter: blur(4px);
            }
            
            .mobile-menu-overlay.open {
                opacity: 1;
                visibility: visible;
            }
            
            .mobile-menu-wrapper {
                position: absolute;
                top: 0;
                right: 0;
                height: 100%;
                width: 320px;
                background: white;
                transform: translateX(100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
            }
            
            .mobile-menu-overlay.open .mobile-menu-wrapper {
                transform: translateX(0);
            }
            
            .mobile-menu-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem;
                border-bottom: 1px solid #e0e0e0;
                background: var(--primary-color);
                color: white;
            }
            
            .mobile-brand {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            
            .mobile-logo {
                width: 32px;
                height: 32px;
            }
            
            .mobile-title {
                font-size: 1.25rem;
                font-weight: 700;
            }
            
            .mobile-menu-close {
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0.5rem;
                border-radius: 50%;
                transition: background 0.2s;
            }
            
            .mobile-menu-close:hover {
                background: rgba(255, 255, 255, 0.1);
            }
            
            .mobile-menu-content {
                flex: 1;
                overflow-y: auto;
            }
            
            .mobile-navigation {
                padding: 0;
            }
            
            .mobile-menu {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            
            .mobile-menu li {
                margin: 0;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .mobile-menu li:last-child {
                border-bottom: none;
            }
            
            .mobile-menu a {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1.25rem 1.5rem;
                color: #333;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                font-size: 1rem;
            }
            
            .mobile-menu a:hover,
            .mobile-menu a:focus {
                background: var(--primary-color);
                color: white;
                padding-right: 2rem;
            }
            
            .mobile-menu i {
                font-size: 1.1rem;
                color: var(--primary-color);
                width: 20px;
                text-align: center;
                flex-shrink: 0;
            }
            
            .mobile-menu a:hover i,
            .mobile-menu a:focus i {
                color: white;
            }
            
            .mobile-menu-footer {
                padding: 1.5rem;
                border-top: 1px solid #e0e0e0;
                background: #f8f9fa;
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            
            .mobile-phone,
            .mobile-cta {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                border-radius: 12px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            
            .mobile-phone {
                background: #e8f5e8;
                color: #2d5a2d;
                border: 2px solid #a8d5a8;
            }
            
            .mobile-phone:hover {
                background: #d4edda;
                transform: translateY(-2px);
            }
            
            .mobile-cta {
                background: var(--primary-color);
                color: white;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            
            .mobile-cta:hover {
                background: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            }

            /* Mobile adjustments */
            @media (max-width: 768px) {
                .desktop-nav {
                    display: none !important;
                }
                
                .mobile-menu-toggle {
                    display: block !important;
                }
                
                .accessibility-toggle-fixed {
                    width: 50px !important;
                    height: 50px !important;
                    font-size: 14px !important;
                }
                
                .accessibility-panel-fixed {
                    width: calc(100vw - 70px) !important;
                    left: 50px !important;
                }
            }
            
            @media (min-width: 769px) {
                .mobile-menu-toggle {
                    display: none !important;
                }
                
                .mobile-menu-overlay {
                    display: none !important;
                }
            }

        @media (max-width: 480px) {
            .mobile-menu-wrapper {
                width: 100%;
            }

            .mobile-menu-overlay {
                background: rgba(0, 0, 0, 0.95);
            }
        }
        
        .control-buttons-fixed {
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
        }
        
        .font-controls-fixed {
            grid-template-columns: 1fr !important;
        }
        
        .control-btn-fixed {
            padding: 10px 8px !important;
            font-size: 10px !important;
            min-height: 60px !important;
        }
        
        .control-btn-fixed i {
            font-size: 16px !important;
        }
    
    @media (max-width: 480px) {
        .accessibility-toggle-fixed {
            width: 45px !important;
            height: 45px !important;
            font-size: 12px !important;
        }
        
        .toggle-text-fixed {
            display: none !important;
        }
        
        .accessibility-panel-fixed {
            width: calc(100vw - 60px) !important;
            left: 45px !important;
        }
    }
    
    /* Animation Performance */
    .accessibility-widget-fixed,
    .accessibility-panel-fixed,
    .control-btn-fixed {
        will-change: transform, opacity !important;
    }
    
    /* Scrollbar Styling for Panel */
    .accessibility-content-fixed::-webkit-scrollbar {
        width: 6px !important;
    }
    
    .accessibility-content-fixed::-webkit-scrollbar-track {
        background: #f1f1f1 !important;
        border-radius: 3px !important;
    }
    
    .accessibility-content-fixed::-webkit-scrollbar-thumb {
        background: #1FA547 !important;
        border-radius: 3px !important;
    }
    
    .accessibility-content-fixed::-webkit-scrollbar-thumb:hover {
        background: #178A3A !important;
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Accessibility Widget - COMPLETELY FIXED FUNCTIONALITY
        const accessibilityToggle = document.getElementById('accessibility-toggle');
        const accessibilityPanel = document.getElementById('accessibility-panel');
        const accessibilityClose = document.getElementById('accessibility-close');
        const themeButtons = document.querySelectorAll('.theme-btn-fixed');
        const fontDecrease = document.getElementById('font-decrease');
        const fontIncrease = document.getElementById('font-increase');
        const fontReset = document.getElementById('font-reset');
        const readingGuide = document.getElementById('reading-guide');
        const focusMode = document.getElementById('focus-mode');
        const resetAll = document.getElementById('reset-all');
        const readingGuideLine = document.getElementById('reading-guide-line');
        const body = document.body;
        
        console.log('Elements found:', {
            toggle: !!accessibilityToggle,
            panel: !!accessibilityPanel,
            themeButtons: themeButtons.length
        });
        const mobileOrderBtn = document.getElementById('mobile-order-btn');
        const mobileOrderModal = document.getElementById('mobile-order-modal');
        const mobileModalClose = document.getElementById('mobile-modal-close');
        const mobileOrderForm = document.getElementById('mobile-order-form');
        const nextStepBtn = document.getElementById('next-step');
        const prevStepBtn = document.getElementById('prev-step');
        const submitBtn = document.getElementById('submit-order');
        const cookieConsent = document.getElementById('cookie-consent');
        const acceptAllBtn = document.getElementById('accept-all-cookies');
        const acceptNecessaryBtn = document.getElementById('accept-necessary-cookies');
        const declineBtn = document.getElementById('decline-cookies');
        

        // Load saved preferences
        // Load saved settings - ENHANCED
        try {
            const savedTheme = localStorage.getItem('accessibility-theme');
            if (savedTheme && savedTheme !== 'null') {
                console.log('Loading saved theme:', savedTheme);
                applyTheme(savedTheme);
            } else {
                console.log('No saved theme, using default');
                applyTheme('light');
            }
            
            const savedFontSize = localStorage.getItem('accessibility-font-size');
            const savedFontSizeValue = localStorage.getItem('accessibility-font-size-value');
            
            if (savedFontSize && savedFontSize !== 'null') {
                console.log('Loading saved font size:', savedFontSize);
                if (savedFontSizeValue) {
                    currentFontSize = parseInt(savedFontSizeValue, 10);
                }
                applyFontSize(savedFontSize);
            } else {
                console.log('No saved font size, using default');
                applyFontSize('normal');
            }
        } catch (error) {
            console.error('Error loading saved accessibility settings:', error);
            // Apply defaults if error
            applyTheme('light');
            applyFontSize('normal');
        }
        const savedReadingGuide = localStorage.getItem('accessibility-reading-guide') === 'true';
        const savedFocusMode = localStorage.getItem('accessibility-focus-mode') === 'true';

        // Check if user already made a choice
            const cookieChoice = localStorage.getItem('cookieConsent');
            
            if (!cookieChoice) {
                setTimeout(() => {
                    cookieConsent.classList.add('show');
                }, 3000);
            
            let currentStep = 1;
            const totalSteps = 3;

            const newsletterPopup = document.getElementById('newsletter-popup');
            const popupClose = document.getElementById('newsletter-popup-close');
            const popupForm = document.getElementById('newsletter-popup-form');
            const popupBackdrop = document.querySelector('.popup-backdrop');
            
            // Show popup after delay
            const delay = <?php echo intval($delay); ?> * 1000;
            const popupShown = sessionStorage.getItem('newsletterPopupShown');
            const cookieChoice = localStorage.getItem('cookieConsent');
            if (!popupShown && cookieChoice) {
                setTimeout(() => {
                    if (newsletterPopup) {
                        newsletterPopup.classList.add('show');
                        sessionStorage.setItem('newsletterPopupShown', 'true');
                    }
                }, delay);
            }

        // Apply saved preferences
        applyTheme(savedTheme);
        applyFontSize(savedFontSize);
        if (savedReadingGuide) enableReadingGuide();
        if (savedFocusMode) enableFocusMode();

        function updateProgress() {
                const progressFill = document.querySelector('.progress-fill');
                const progressText = document.querySelector('.progress-text');
                const percentage = (currentStep / totalSteps) * 100;
                
                if (progressFill) progressFill.style.width = percentage + '%';
                if (progressText) progressText.textContent = `مرحله ${currentStep} از ${totalSteps}`;
            }
            function closePopup() {
                if (newsletterPopup) {
                    newsletterPopup.classList.remove('show');
                }
            }
            
            if (popupClose) popupClose.addEventListener('click', closePopup);
            if (popupBackdrop) popupBackdrop.addEventListener('click', closePopup);
            
            if (popupForm) {
                popupForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    formData.append('action', 'newsletter_signup');
                    formData.append('nonce', teznevisanAjax.nonce);
                    
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'در حال ارسال...';
                    submitBtn.disabled = true;
                    
                    fetch(teznevisanAjax.ajaxUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const successHtml = `
                                <div class="popup-success">
                                    <i class="fa-solid fa-check-circle"></i>
                                    <h4>عضویت موفق!</h4>
                                    <p>${data.data.message}</p>
                                </div>
                            `;
                            document.querySelector('.popup-body').innerHTML = successHtml;
                            
                            setTimeout(closePopup, 3000);
                        } else {
                            alert(data.data || 'خطا در ثبت شماره');
                        }
                    })
                    .catch(error => {
                        console.error('Newsletter signup error:', error);
                        alert('خطا در ارسال درخواست');
                    })
                    .finally(() => {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    });
                });
            }
        });
            
            function showStep(step) {
                document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
                document.querySelector(`[data-step="${step}"]`).classList.add('active');
                
                // Update navigation buttons
                prevStepBtn.style.display = step === 1 ? 'none' : 'flex';
                nextStepBtn.style.display = step === totalSteps ? 'none' : 'flex';
                submitBtn.style.display = step === totalSteps ? 'flex' : 'none';
                
                updateProgress();
            }
            
            function openMobileOrder() {
                if (mobileOrderModal) {
                    mobileOrderModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    currentStep = 1;
                    showStep(currentStep);
                }
            }
            
            function closeMobileOrder() {
                if (mobileOrderModal) {
                    mobileOrderModal.classList.remove('active');
                    document.body.style.overflow = '';
                    // Reset form
                    if (mobileOrderForm) mobileOrderForm.reset();
                    currentStep = 1;
                    showStep(currentStep);
                }
            }
            
            function validateStep(step) {
                const currentStepEl = document.querySelector(`[data-step="${step}"]`);
                const requiredFields = currentStepEl.querySelectorAll('[required]');
                
                for (let field of requiredFields) {
                    if (!field.value.trim()) {
                        field.focus();
                        field.style.borderColor = '#dc3545';
                        setTimeout(() => {
                            field.style.borderColor = '';
                        }, 3000);
                        return false;
                    }
                }
                return true;
            }
            
            if (mobileOrderBtn) mobileOrderBtn.addEventListener('click', openMobileOrder);
            if (mobileModalClose) mobileModalClose.addEventListener('click', closeMobileOrder);
            
            if (nextStepBtn) {
                nextStepBtn.addEventListener('click', function() {
                    if (validateStep(currentStep) && currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            }
            
            if (prevStepBtn) {
                prevStepBtn.addEventListener('click', function() {
                    if (currentStep > 1) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            }
            
            if (mobileOrderModal) {
                mobileOrderModal.addEventListener('click', function(e) {
                    if (e.target === this || e.target.classList.contains('modal-backdrop')) {
                        closeMobileOrder();
                    }
                });
            }
            
            if (mobileOrderForm) {
                mobileOrderForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (!validateStep(currentStep)) return;
                    
                    const formData = new FormData(this);
                    formData.append('action', 'mobile_order');
                    formData.append('nonce', teznevisanAjax.nonce);
                    
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                    
                    fetch(teznevisanAjax.ajaxUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const successHtml = `
                                <div class="order-success">
                                    <div class="success-icon">
                                        <i class="fa-solid fa-check-circle"></i>
                                    </div>
                                    <h3>درخواست شما ثبت شد!</h3>
                                    <p>${data.data.message}</p>
                                    <div class="tracking-info">
                                        <span>شماره پیگیری: <strong>#${data.data.tracking_id}</strong></span>
                                    </div>
                                </div>
                            `;
                            document.querySelector('.modal-body').innerHTML = successHtml;
                            
                            // Auto close after 5 seconds
                            setTimeout(closeMobileOrder, 5000);
                        } else {
                            alert(data.data || 'خطا در ارسال درخواست');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('خطا در ارسال درخواست. لطفاً مجدداً تلاش کنید.');
                    })
                    .finally(() => {
                        submitBtn.classList.remove('loading');
                        submitBtn.disabled = false;
                    });
                });
            }
            
            // Enhanced navigation active state
            const currentUrl = window.location.pathname;
            const navItems = document.querySelectorAll('.mobile-bottom-nav-enhanced .nav-item');
            
            navItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && href !== '#' && currentUrl.includes(href.replace(window.location.origin, ''))) {
                    item.classList.add('active');
                }
            });

        // Toggle panel
        function togglePanel() {
            const isOpen = accessibilityPanel.classList.contains('open');
            if (isOpen) {
                closePanel();
            } else {
                openPanel();
            }
        }

        function openPanel() {
            if (!accessibilityPanel) {
                console.error('Cannot open panel: accessibilityPanel not found');
                return;
            }
            
            console.log('Opening accessibility panel');
            accessibilityPanel.classList.add('open');
            
            if (accessibilityToggle) {
                accessibilityToggle.setAttribute('aria-expanded', 'true');
                accessibilityToggle.classList.add('active-fixed');
            }
            
            accessibilityPanel.setAttribute('aria-hidden', 'false');
            
            // Focus first interactive element
            setTimeout(() => {
                const firstButton = accessibilityPanel.querySelector('button:not([disabled])');
                if (firstButton) {
                    firstButton.focus();
                }
            }, 100);
        }
        
        function closePanel() {
            if (!accessibilityPanel) {
                console.error('Cannot close panel: accessibilityPanel not found');
                return;
            }
            
            console.log('Closing accessibility panel');
            accessibilityPanel.classList.remove('open');
            
            if (accessibilityToggle) {
                accessibilityToggle.setAttribute('aria-expanded', 'false');
                accessibilityToggle.classList.remove('active-fixed');
                accessibilityToggle.focus();
            }
            
            accessibilityPanel.setAttribute('aria-hidden', 'true');
        }

        // Initialize currentFontSize properly
        let currentFontSize = parseInt(localStorage.getItem('accessibility-font-size-value') || '16', 10);
        console.log('Initial font size:', currentFontSize);
        
        // Ensure all required elements exist
        if (!accessibilityToggle) {
            console.error('Accessibility toggle button not found');
            return;
        }
        
        if (!accessibilityPanel) {
            console.error('Accessibility panel not found');
            return;
        }
        
        // Theme functions - FIXED
        function applyTheme(theme) {
            console.log('Applying theme:', theme);
            
            if (!theme) {
                console.error('No theme specified');
                return;
            }
            
            try {
                // Remove all theme classes
                body.className = body.className.replace(/data-theme-\w+/g, '');
                body.removeAttribute('data-theme');
                
                // Apply new theme
                body.setAttribute('data-theme', theme);
                document.documentElement.setAttribute('data-theme', theme);
                
                // Update active button
                themeButtons.forEach(btn => {
                    if (btn) {
                        btn.classList.remove('active-fixed');
                        btn.setAttribute('aria-pressed', 'false');
                    }
                });
                
                const activeButton = document.querySelector(`[data-theme="${theme}"]`);
                if (activeButton) {
                    activeButton.classList.add('active-fixed');
                    activeButton.setAttribute('aria-pressed', 'true');
                }
                
                localStorage.setItem('accessibility-theme', theme);
                console.log('Theme applied successfully:', theme);
            } catch (error) {
                console.error('Error applying theme:', error);
            }
        }

        // Font size functions
        let currentFontSize = 16;

        function setCookieChoice(choice, preferences = {}) {
                localStorage.setItem('cookieConsent', choice);
                localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
                cookieConsent.classList.remove('show');
                
                // Enable/disable tracking based on choice
                if (choice === 'accepted_all') {
                    console.log('All cookies accepted');
                    // Enable analytics, marketing cookies, etc.
                } else if (choice === 'accepted_necessary') {
                    console.log('Only necessary cookies accepted');
                    // Enable only necessary cookies
                } else {
                    console.log('Cookies declined');
                    // Disable all non-essential cookies
                }
            }
            
            if (acceptAllBtn) {
                acceptAllBtn.addEventListener('click', function() {
                    setCookieChoice('accepted_all', {
                        necessary: true,
                        analytics: true,
                        marketing: true,
                        preferences: true
                    });
                });
            }
            
            if (acceptNecessaryBtn) {
                acceptNecessaryBtn.addEventListener('click', function() {
                    setCookieChoice('accepted_necessary', {
                        necessary: true,
                        analytics: false,
                        marketing: false,
                        preferences: false
                    });
                });
            }
            
            if (declineBtn) {
                declineBtn.addEventListener('click', function() {
                    setCookieChoice('declined', {
                        necessary: true,
                        analytics: false,
                        marketing: false,
                        preferences: false
                    });
                });
            }
       
        
        // Font size functions with proper initialization
        function applyFontSize(size) {
            console.log('Applying font size:', size);
            
            try {
                body.className = body.className.replace(/font-\w+/g, '');
                
                switch(size) {
                    case 'small':
                        body.classList.add('font-small');
                        currentFontSize = 14;
                        break;
                    case 'large':
                        body.classList.add('font-large');
                        currentFontSize = 18;
                        break;
                    case 'xlarge':
                        body.classList.add('font-xlarge');
                        currentFontSize = 20;
                        break;
                    case 'xxlarge':
                        body.classList.add('font-xxlarge');
                        currentFontSize = 22;
                        break;
                    default:
                        body.classList.add('font-normal');
                        currentFontSize = 16;
                }
                
                // Apply font size to root element
                document.documentElement.style.fontSize = currentFontSize + 'px';
                
                localStorage.setItem('accessibility-font-size', size);
                localStorage.setItem('accessibility-font-size-value', currentFontSize.toString());
                console.log('Font size applied successfully:', size, currentFontSize);
                
                // Update font buttons
                document.querySelectorAll('.font-btn-fixed').forEach(btn => {
                    btn.classList.remove('active-fixed');
                    if (btn.dataset.size === size) {
                        btn.classList.add('active-fixed');
                    }
                });
            } catch (error) {
                console.error('Error applying font size:', error);
            }
        }

        function increaseFontSize() {
            if (currentFontSize < 22) {
                const sizes = ['normal', 'large', 'xlarge', 'xxlarge'];
                const currentIndex = Math.floor((currentFontSize - 16) / 2);
                const nextSize = sizes[Math.min(currentIndex + 1, sizes.length - 1)];
                applyFontSize(nextSize);
            }
        }

        function decreaseFontSize() {
            if (currentFontSize > 14) {
                const sizes = ['small', 'normal', 'large', 'xlarge'];
                const currentIndex = Math.floor((currentFontSize - 14) / 2);
                const prevSize = sizes[Math.max(currentIndex - 1, 0)];
                applyFontSize(prevSize);
            }
        }

        function resetFontSize() {
            applyFontSize('normal');
        }

        // Reading guide functions
        function enableReadingGuide() {
            readingGuideLine.style.display = 'block';
            readingGuide.classList.add('active-fixed');
            readingGuide.setAttribute('aria-pressed', 'true');
            
            document.addEventListener('mousemove', updateReadingGuide);
            localStorage.setItem('accessibility-reading-guide', 'true');
        }

        function disableReadingGuide() {
            readingGuideLine.style.display = 'none';
            readingGuide.classList.remove('active-fixed');
            readingGuide.setAttribute('aria-pressed', 'false');
            
            document.removeEventListener('mousemove', updateReadingGuide);
            localStorage.setItem('accessibility-reading-guide', 'false');
        }

        function updateReadingGuide(e) {
            readingGuideLine.style.top = (e.clientY - 2) + 'px';
        }

        // Focus mode functions
        function enableFocusMode() {
            body.classList.add('focus-mode');
            focusMode.classList.add('active-fixed');
            focusMode.setAttribute('aria-pressed', 'true');
            localStorage.setItem('accessibility-focus-mode', 'true');
        }

        function disableFocusMode() {
            body.classList.remove('focus-mode');
            focusMode.classList.remove('active-fixed');
            focusMode.setAttribute('aria-pressed', 'false');
            localStorage.setItem('accessibility-focus-mode', 'false');
        }

        // Reset all function
        function resetAllSettings() {
            applyTheme('light');
            applyFontSize('normal');
            disableReadingGuide();
            disableFocusMode();
            
            // Clear localStorage
            localStorage.removeItem('accessibility-theme');
            localStorage.removeItem('accessibility-font-size');
            localStorage.removeItem('accessibility-reading-guide');
            localStorage.removeItem('accessibility-focus-mode');
        }

        // Event listeners
            // Panel toggle functionality - FIXED
        if (accessibilityToggle) {
            accessibilityToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Accessibility toggle clicked');
                if (accessibilityPanel && accessibilityPanel.classList.contains('open')) {
                    closePanel();
                } else {
                    openPanel();
                }
            });
            
            // Add keyboard support
            accessibilityToggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    if (accessibilityPanel && accessibilityPanel.classList.contains('open')) {
                        closePanel();
                    } else {
                        openPanel();
                    }
                }
            });
        }
        
               if (accessibilityClose) {
               accessibilityClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closePanel();
            });
        }

            // Theme button events - COMPLETELY FIXED
            if (themeButtons.length > 0) {
                themeButtons.forEach((button, index) => {
                    if (!button) return;
                    
                    const clickHandler = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const theme = this.getAttribute('data-theme');
                        console.log('Theme button clicked:', theme, 'by button', index);
                        if (theme) {
                            applyTheme(theme);
                        } else {
                            console.error('No theme data found on button');
                        }
                    };
                    
                    button.addEventListener('click', clickHandler);
                    button.addEventListener('touchend', clickHandler, { passive: false });
                    
                    // Add keyboard support
                    button.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            clickHandler.call(this, e);
                        }
                    });
                });
            } else {
                console.warn('No theme buttons found');
            }
            

            // Font size button events - FIXED AND ENHANCED
            if (fontDecrease) {
                fontDecrease.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Font decrease clicked, current size:', currentFontSize);
                    if (currentFontSize > 12) {
                        currentFontSize -= 2;
                        const sizeClass = getFontSizeClass(currentFontSize);
                        applyFontSize(sizeClass);
                        console.log('Font decreased to:', currentFontSize, sizeClass);
                    } else {
                        console.log('Font size at minimum');
                    }
                });
            }
            
            if (fontIncrease) {
                fontIncrease.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Font increase clicked, current size:', currentFontSize);
                    if (currentFontSize < 24) {
                        currentFontSize += 2;
                        const sizeClass = getFontSizeClass(currentFontSize);
                        applyFontSize(sizeClass);
                        console.log('Font increased to:', currentFontSize, sizeClass);
                    } else {
                        console.log('Font size at maximum');
                    }
                });
            }
            
            if (fontReset) {
                fontReset.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Font reset clicked');
                    currentFontSize = 16;
                    applyFontSize('normal');
                });
            }
            
            // Add font size class helper function
            function getFontSizeClass(size) {
                if (size <= 14) return 'small';
                if (size >= 18 && size < 20) return 'large';
                if (size >= 20 && size < 22) return 'xlarge';
                if (size >= 22) return 'xxlarge';
                return 'normal';
            }

            // Reading guide
            if (readingGuide) {
                readingGuide.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isActive = this.getAttribute('aria-pressed') === 'true';
                    this.setAttribute('aria-pressed', !isActive);
                    this.classList.toggle('active-fixed');
                    
                    if (!isActive) {
                        readingGuideLine.style.display = 'block';
                        document.addEventListener('mousemove', updateReadingGuide);
                    } else {
                        readingGuideLine.style.display = 'none';
                        document.removeEventListener('mousemove', updateReadingGuide);
                    }
                });
            }

            // Focus mode
            if (focusMode) {
                focusMode.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isActive = this.getAttribute('aria-pressed') === 'true';
                    this.setAttribute('aria-pressed', !isActive);
                    this.classList.toggle('active-fixed');
                    body.classList.toggle('focus-mode');
                });
            }

            // Reset all
            if (resetAll) {
                resetAll.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Reset all clicked');
                    
                    // Reset theme
                    applyTheme('light');
                    
                    // Reset font size
                    applyFontSize('normal');
                    
                    // Reset other features
                    if (readingGuide) {
                        readingGuide.setAttribute('aria-pressed', 'false');
                        readingGuide.classList.remove('active-fixed');
                        readingGuideLine.style.display = 'none';
                        document.removeEventListener('mousemove', updateReadingGuide);
                    }
                    
                    if (focusMode) {
                        focusMode.setAttribute('aria-pressed', 'false');
                        focusMode.classList.remove('active-fixed');
                        body.classList.remove('focus-mode');
                    }
                });
            }

            // Reading guide function
            function updateReadingGuide(e) {
                readingGuideLine.style.top = e.clientY + 'px';
            }

        // Font control events
        if (fontIncrease) {
            fontIncrease.addEventListener('click', increaseFontSize);
        }

        if (fontDecrease) {
            fontDecrease.addEventListener('click', decreaseFontSize);
        }

        if (fontReset) {
            fontReset.addEventListener('click', resetFontSize);
        }

        // Reading guide event
        if (readingGuide) {
            readingGuide.addEventListener('click', function() {
                const isActive = this.classList.contains('active-fixed');
                if (isActive) {
                    disableReadingGuide();
                } else {
                    enableReadingGuide();
                }
            });
        }

        // Focus mode event
        if (focusMode) {
            focusMode.addEventListener('click', function() {
                const isActive = this.classList.contains('active-fixed');
                if (isActive) {
                    disableFocusMode();
                } else {
                    enableFocusMode();
                }
            });
        }

        // Reset all event
        if (resetAll) {
            resetAll.addEventListener('click', function() {
                if (confirm('آیا مطمئن هستید که می‌خواهید همه تنظیمات را بازنشانی کنید؟')) {
                    resetAllSettings();
                }
            });
        }

        // Close panel when clicking outside
        // Close panel when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.accessibility-widget-fixed')) {
                closePanel();
            }
        });

        // Keyboard support
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && accessibilityPanel.classList.contains('open')) {
                closePanel();
            }
        });
        
        // Mobile Menu Functionality
        // Mobile Menu Functionality - FIXED AND ENHANCED
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileMenuClose = document.querySelector('.mobile-menu-close');
        const hamburgerLines = document.querySelector('.hamburger-lines');
        
        console.log('Mobile menu elements:', {
            toggle: !!mobileMenuToggle,
            overlay: !!mobileMenuOverlay,
            close: !!mobileMenuClose
        });
        
        function openMobileMenu() {
            console.log('Opening mobile menu...');
            if (mobileMenuOverlay) {
                mobileMenuOverlay.classList.add('open');
                document.body.style.overflow = 'hidden';
                document.body.classList.add('mobile-menu-open');
            }
            if (mobileMenuToggle) {
                mobileMenuToggle.classList.add('active');
                mobileMenuToggle.setAttribute('aria-expanded', 'true');
            }
        }
        
        function closeMobileMenu() {
            console.log('Closing mobile menu...');
            if (mobileMenuOverlay) {
                mobileMenuOverlay.classList.remove('open');
                document.body.style.overflow = '';
                document.body.classList.remove('mobile-menu-open');
            }
            if (mobileMenuToggle) {
                mobileMenuToggle.classList.remove('active');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        }
        
        function toggleMobileMenu() {
            if (mobileMenuOverlay && mobileMenuOverlay.classList.contains('open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Mobile menu toggle clicked');
                toggleMobileMenu();
            });
            
            // Add keyboard support
            mobileMenuToggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleMobileMenu();
                }
            });
        }
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
        }
        
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function(e) {
                if (e.target === this || e.target.classList.contains('mobile-menu-overlay')) {
                    closeMobileMenu();
                }
            });
        }
        
        // Close mobile menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenuOverlay && mobileMenuOverlay.classList.contains('open')) {
                closeMobileMenu();
            }
        });
    </script>
    <?php
}


/**
 * Register Enhanced Post Types - WORKING
 */
public function register_post_types(): void
{
    // Services Post Type - Enhanced
    register_post_type('services', array(
        'labels' => array(
            'name'               => __('خدمات', 'teznevisan'),
            'singular_name'      => __('خدمت', 'teznevisan'),
            'menu_name'          => __('خدمات', 'teznevisan'),
            'add_new'            => __('افزودن خدمت', 'teznevisan'),
            'add_new_item'       => __('افزودن خدمت جدید', 'teznevisan'),
            'edit_item'          => __('ویرایش خدمت', 'teznevisan'),
            'new_item'           => __('خدمت جدید', 'teznevisan'),
            'view_item'          => __('مشاهده خدمت', 'teznevisan'),
            'search_items'       => __('جستجو خدمات', 'teznevisan'),
            'not_found'          => __('خدمتی یافت نشد', 'teznevisan'),
            'not_found_in_trash' => __('خدمتی در زباله‌دان یافت نشد', 'teznevisan'),
            'all_items'          => __('همه خدمات', 'teznevisan'),
            'archives'           => __('آرشیو خدمات', 'teznevisan'),
            'featured_image'     => __('تصویر شاخص خدمت', 'teznevisan'),
            'set_featured_image' => __('انتخاب تصویر شاخص', 'teznevisan'),
            'remove_featured_image'=> __('حذف تصویر شاخص', 'teznevisan')
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'services', 'with_front' => false, 'feeds' => true, 'pages' => true],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-tools',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'],
        'show_in_rest'        => true
    ));
    
    // Service Inquiries Post Type
    register_post_type('service_inquiry', array(
        'labels' => array(
            'name' => 'درخواست‌های خدمات',
            'singular_name' => 'درخواست خدمت',
            'menu_name' => 'درخواست‌ها',
            'add_new' => 'افزودن درخواست',
            'edit_item' => 'مشاهده درخواست',
            'all_items' => 'همه درخواست‌ها',
            'search_items' => 'جستجو در درخواست‌ها'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email',
        'supports' => array('title', 'editor'),
        'capability_type' => 'post',
        'capabilities' => array(
            'create_posts' => false,
        ),
        'map_meta_cap' => true,
        'menu_position' => 25
    ));
    
    // Testimonials Post Type
    register_post_type('testimonials', array(
        'labels' => array(
            'name'          => __('نظرات مشتریان', 'teznevisan'),
            'singular_name' => __('نظر مشتری', 'teznevisan'),
            'menu_name'     => __('نظرات', 'teznevisan'),
            'add_new'       => __('افزودن نظر', 'teznevisan'),
            'edit_item'     => __('ویرایش نظر', 'teznevisan'),
            'all_items'     => __('همه نظرات', 'teznevisan')
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'menu_position' => 30
    ));
    
    // Portfolio Post Type
    register_post_type('portfolio', array(
        'labels' => array(
            'name'          => __('نمونه کارها', 'teznevisan'),
            'singular_name' => __('نمونه کار', 'teznevisan'),
            'menu_name'     => __('پرتفوی', 'teznevisan'),
            'add_new'       => __('افزودن نمونه کار', 'teznevisan'),
            'edit_item'     => __('ویرایش نمونه کار', 'teznevisan')
        ),
        'public'              => true,
        'has_archive'         => true,
        'show_ui'             => true,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'             => ['slug' => 'portfolio'],
        'show_in_rest'        => true,
        'menu_position' => 35
    ));
    
    // Contact Submissions Post Type (Private)
    register_post_type('contact_submissions', [
        'labels' => [
            'name'          => __('درخواست‌های تماس', 'teznevisan'),
            'singular_name' => __('درخواست تماس', 'teznevisan'),
            'menu_name'     => __('درخواست‌ها', 'teznevisan'),
            'edit_item'     => __('مشاهده درخواست', 'teznevisan'),
            'all_items'     => __('همه درخواست‌ها', 'teznevisan')
        ],
        'public'       => false,
        'show_ui'      => true,
        'menu_icon'    => 'dashicons-email-alt',
        'supports'     => ['title', 'editor'],
        'capabilities' => [
            'create_posts' => false,
        ],
        'map_meta_cap' => true
    ]);
}



public function enqueue_admin_scripts($hook): void
{
    // Load FA7 Pro on ALL admin pages for consistency
    wp_enqueue_style(
        'fontawesome-pro-admin-critical',
        TEZNEVISAN_ASSETS_URL . '/fonts/fontawesome/css/all.css',
        array(),
        '7.0.0',
        'all'
    );
    
    // Force FA7 Pro to load before WordPress admin styles
    wp_enqueue_style(
        'teznevisan-admin-fontawesome-override',
        TEZNEVISAN_ASSETS_URL . '/css/admin-fontawesome.css',
        array('fontawesome-pro-admin-critical'),
        TEZNEVISAN_VERSION,
        'all'
    );

    // Admin fonts
        wp_enqueue_style(
            'teznevisan-admin-fonts',
            TEZNEVISAN_ASSETS_URL . '/css/fonts.css',
            ['fontawesome-pro-admin-override'],
            TEZNEVISAN_VERSION
        );
    
    // Only on theme-related admin pages
    $theme_pages = array(
        'themes.php',
        'customize.php',
        'nav-menus.php',
        'widgets.php'
    );
    
    if (in_array($hook, $theme_pages) || strpos($hook, 'teznevisan') !== false) {
        wp_enqueue_style(
            'teznevisan-admin-custom',
            TEZNEVISAN_ASSETS_URL . '/css/admin.css',
            array('teznevisan-admin-fontawesome-override'),
            TEZNEVISAN_VERSION
        );
        
        wp_enqueue_script(
            'teznevisan-admin-custom',
            TEZNEVISAN_ASSETS_URL . '/js/admin.js',
            array('jquery'),
            TEZNEVISAN_VERSION,
            true
        );
        
        wp_localize_script('teznevisan-admin-custom', 'teznevisanAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('teznevisan_admin_nonce'),
            'strings' => array(
                'loading' => 'در حال بارگذاری...',
                'success' => 'عملیات با موفقیت انجام شد',
                'error' => 'خطا در انجام عملیات'
            )
        ));
    }
}
    
   
    
    /**
     * Register Enhanced Sidebars
     */
    public function register_sidebars() {
        register_sidebar(array(
            'name' => 'نوار کناری اصلی',
            'id' => 'main-sidebar',
            'description' => 'ویجت‌های نوار کناری اصلی',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(array(
            'name' => 'نوار کناری خدمات',
            'id' => 'services-sidebar',
            'description' => 'ویجت‌های مخصوص صفحات خدمات',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        
        for ($i = 1; $i <= 4; $i++) {
            register_sidebar(array(
                'name' => 'فوتر - ستون ' . $i,
                'id' => 'footer-' . $i,
                'description' => 'ویجت‌های ستون ' . $i . ' فوتر',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>',
            ));
        }
        
        // Homepage specific sidebars
        register_sidebar(array(
            'name' => 'بالای محتوای اصلی',
            'id' => 'above-content',
            'description' => 'ویجت‌های بالای محتوای اصلی در صفحه اول',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(array(
            'name' => 'پایین محتوای اصلی',
            'id' => 'below-content',
            'description' => 'ویجت‌های پایین محتوای اصلی در صفحه اول',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    
        
    /**
     * Register Enhanced Taxonomies
     */
    public function register_taxonomies() {
        // Service Categories
        register_taxonomy('service_category', 'services', array(
            'labels' => array(
                'name' => 'دسته‌بندی خدمات',
                'singular_name' => 'دسته‌بندی خدمت',
                'menu_name' => 'دسته‌بندی‌ها',
                'all_items' => 'همه دسته‌بندی‌ها',
                'edit_item' => 'ویرایش دسته‌بندی',
                'update_item' => 'بروزرسانی دسته‌بندی',
                'add_new_item' => 'افزودن دسته‌بندی جدید',
                'new_item_name' => 'نام دسته‌بندی جدید'
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'service-category'),
            'show_in_rest' => true
        ));
        
        // Service Tags
        register_taxonomy('service_tag', 'services', array(
            'labels' => array(
                'name' => 'برچسب‌های خدمات',
                'singular_name' => 'برچسب خدمت'
            ),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'service-tag'),
            'show_in_rest' => true
        ));
        
        // Portfolio Categories
        register_taxonomy('portfolio_category', 'portfolio', array(
            'labels' => array(
                'name' => 'دسته‌بندی نمونه کارها',
                'singular_name' => 'دسته‌بندی نمونه کار'
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'portfolio-category')
        ));
    }
    
     
    /**
     * Add Structured Data (JSON-LD)
     */
    public function add_structured_data(): void
    {
        // Skip if Rank Math is active to avoid duplication
        if (class_exists('RankMath') || 
            class_exists('WPSEO_Options') || 
            class_exists('All_in_One_SEO_Pack')) {
            return;
        }
        
        $schema_data = [];
        
        // Organization Schema
        $schema_data[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => get_bloginfo('name'),
            'url'      => home_url(),
            'logo'     => wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full'),
            'description' => get_bloginfo('description'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+98-21-12345678',
                'contactType' => 'customer service',
                'areaServed' => 'IR',
                'availableLanguage' => 'fa'
            ],
            'sameAs' => [
                'https://t.me/teznevisan',
                'https://instagram.com/teznevisan'
            ]
        ];
        
        // WebSite Schema
        $schema_data[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => get_bloginfo('name'),
            'url'      => home_url(),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => home_url('/?s={search_term_string}')
                ],
                'query-input' => 'required name=search_term_string'
            ],
            'inLanguage' => 'fa-IR'
        ];
        
        // Service Schema (for services pages)
        if (is_singular('services')) {
            global $post;
            $schema_data[] = [
                '@context' => 'https://schema.org',
                '@type'    => 'Service',
                'name'     => get_the_title($post->ID),
                'description' => get_the_excerpt($post->ID),
                'provider' => [
                    '@type' => 'Organization',
                    'name'  => get_bloginfo('name'),
                    'url'   => home_url()
                ],
                'areaServed' => 'IR',
                'availableLanguage' => 'fa'
            ];
        }
        
        // BreadcrumbList Schema
        if (!is_front_page()) {
            $breadcrumbs = [];
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => __('خانه', 'teznevisan'),
                'item' => home_url()
            ];
            
            if (is_category() || is_single()) {
                $categories = get_the_category();
                if (!empty($categories)) {
                    $breadcrumbs[] = [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $categories[0]->name,
                        'item' => get_category_link($categories[0]->term_id)
                    ];
                }
            }
            
            if (is_single()) {
                $breadcrumbs[] = [
                    '@type' => 'ListItem', 
                    'position' => count($breadcrumbs) + 1,
                    'name' => get_the_title(),
                    'item' => get_permalink()
                ];
            }
            
            if (count($breadcrumbs) > 1) {
                $schema_data[] = [
                    '@context' => 'https://schema.org',
                    '@type'    => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbs
                ];
            }
        }
        
        foreach ($schema_data as $schema) {
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
    /**
     * Add Google Analytics - G-1D4D97KBJ1
     */
    public function add_google_analytics(): void
    {
        if (is_admin() || current_user_can('manage_options')) {
            return;
        }
        
        echo <<<HTML
<!-- Google tag (gtag.js) - TezNevisan -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1D4D97KBJ1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-1D4D97KBJ1', {
    'custom_map': {'dimension1': 'theme_mode'}
  });
</script>

HTML;
    }

    /**
     * Customize Admin Bar
     */
    public function customize_admin_bar($wp_admin_bar): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Add theme mode toggle to admin bar with FA7 icon
        $wp_admin_bar->add_node([
            'id'    => 'teznevisan-admin-mode',
            'title' => '<span class="ab-icon"><i class="fa-solid fa-moon" style="font-family: \'Font Awesome 7 Pro\' !important;"></i></span> حالت مدیریت',
            'href'  => '#',
            'meta'  => [
                'class' => 'teznevisan-admin-toggle',
                'title' => __('تغییر حالت ظاهری مدیریت', 'teznevisan')
            ]
        ]);
    }

    /**
     * Add Body Classes
     */
    public function add_body_classes($classes): array
    {
        $classes[] = 'teznevisan-theme';
        $classes[] = 'theme-light'; // Default mode
        
        if (is_rtl()) {
            $classes[] = 'rtl-layout';
        }
        
        if (wp_is_mobile()) {
            $classes[] = 'mobile-device';
        }
        
        return $classes;
    }
    
    /**
     * Add Admin Body Classes
     */
    public function add_admin_body_classes($classes): string
    {
        $classes .= ' teznevisan-admin admin-dark-mode';
        
        if (is_rtl()) {
            $classes .= ' rtl-admin';
        }
        
        return $classes;
    }

    /**
     * Enhanced Menu Icons with Dynamic Support - FIXED
     */
    public function add_menu_icons($items, $args) {
        if (!isset($args->theme_location) || $args->theme_location !== 'primary') {
            return $items;
        }
        
        $menu_icons = get_option('teznevisan_menu_icons', array());
        
        if (empty($menu_icons)) {
            return $items;
        }
        
        return preg_replace_callback(
            '/<a[^>]*href="([^"]*)"[^>]*>([^<]*)<\/a>/',
            function($matches) use ($menu_icons) {
                $url = $matches[1];
                $text = $matches[2];
                
                foreach ($menu_icons as $menu_item) {
                    if (isset($menu_item['url']) && !empty($menu_item['url']) && 
                        strpos($url, $menu_item['url']) !== false && 
                        !empty($menu_item['icon'])) {
                        return str_replace(
                            '>' . $text . '<',
                            '><i class="' . esc_attr($menu_item['icon']) . '"></i> ' . $text . '<',
                            $matches[0]
                        );
                    }
                }
                
                return $matches[0];
            },
            $items
        );
    }

    /**
     * Add Meta Boxes
     */
    public function add_meta_boxes() {
        // Post meta boxes
        add_meta_box(
            'teznevisan_post_options',
            'تنظیمات پیشرفته مطلب',
            array($this, 'post_options_callback'),
            'post',
            'normal',
            'high'
        );
        
        // Service meta boxes
        add_meta_box(
            'teznevisan_service_options',
            'تنظیمات خدمت',
            array($this, 'service_options_callback'),
            'services',
            'normal',
            'high'
        );
        
        // Service SEO meta box
        add_meta_box(
            'teznevisan_service_seo',
            'تنظیمات SEO خدمت',
            array($this, 'service_seo_callback'),
            'services',
            'side',
            'high'
        );
        
        // Testimonial meta boxes
        add_meta_box(
            'teznevisan_testimonial_options',
            'تنظیمات نظر مشتری',
            array($this, 'testimonial_options_callback'),
            'testimonials',
            'normal',
            'high'
        );
        
        // Portfolio meta boxes
        add_meta_box(
            'teznevisan_portfolio_options',
            'تنظیمات نمونه کار',
            array($this, 'portfolio_options_callback'),
            'portfolio',
            'normal',
            'high'
        );
    }

    /**
     * Post Options Meta Box Callback - Enhanced
     */
    public function post_options_callback($post) {
        wp_nonce_field('teznevisan_post_options', 'post_options_nonce');
        
        $subtitle = get_post_meta($post->ID, 'post_subtitle', true);
        $featured_images = get_post_meta($post->ID, 'featured_images', true) ?: array();
        $key_takeaways = get_post_meta($post->ID, 'key_takeaways', true) ?: array();
        $statistics = get_post_meta($post->ID, 'statistics', true) ?: array();
        $faq_items = get_post_meta($post->ID, 'faq_items', true) ?: array();
        $content_recommendations = get_post_meta($post->ID, 'content_recommendations', true) ?: array();
        $citations = get_post_meta($post->ID, 'citations', true) ?: array();
        $related_service_id = get_post_meta($post->ID, 'related_service_id', true);
        $reading_time = get_post_meta($post->ID, 'reading_time', true);
        $difficulty_level = get_post_meta($post->ID, 'difficulty_level', true) ?: 'متوسط';
        $target_audience = get_post_meta($post->ID, 'target_audience', true);
        $post_type_content = get_post_meta($post->ID, 'post_type_content', true) ?: 'general';
        
        ?>
        <div class="teznevisan-post-meta-enhanced">
            <div class="meta-tabs-nav">
                <button type="button" class="meta-tab-btn active" data-tab="basic">تنظیمات پایه</button>
                <button type="button" class="meta-tab-btn" data-tab="content">محتوای اضافی</button>
                <button type="button" class="meta-tab-btn" data-tab="seo">تنظیمات SEO</button>
                <button type="button" class="meta-tab-btn" data-tab="advanced">پیشرفته</button>
            </div>
            
            <!-- Basic Settings Tab -->
            <div class="meta-tab-content active" data-tab-content="basic">
                <table class="form-table">
                    <tr>
                        <th><label for="post_subtitle">زیرعنوان مطلب</label></th>
                        <td>
                            <input type="text" id="post_subtitle" name="post_subtitle" 
                                   value="<?php echo esc_attr($subtitle); ?>" class="large-text">
                            <p class="description">زیرعنوان توضیحی برای مطلب که در هدر نمایش داده می‌شود</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="post_type_content">نوع محتوا</label></th>
                        <td>
                            <select id="post_type_content" name="post_type_content" class="regular-text">
                                <option value="general" <?php selected($post_type_content, 'general'); ?>>عمومی</option>
                                <option value="tutorial" <?php selected($post_type_content, 'tutorial'); ?>>آموزشی</option>
                                <option value="news" <?php selected($post_type_content, 'news'); ?>>خبری</option>
                                <option value="analysis" <?php selected($post_type_content, 'analysis'); ?>>تحلیلی</option>
                                <option value="guide" <?php selected($post_type_content, 'guide'); ?>>راهنما</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="difficulty_level">سطح دشواری</label></th>
                        <td>
                            <select id="difficulty_level" name="difficulty_level" class="regular-text">
                                <option value="آسان" <?php selected($difficulty_level, 'آسان'); ?>>آسان</option>
                                <option value="متوسط" <?php selected($difficulty_level, 'متوسط'); ?>>متوسط</option>
                                <option value="پیشرفته" <?php selected($difficulty_level, 'پیشرفته'); ?>>پیشرفته</option>
                                <option value="تخصصی" <?php selected($difficulty_level, 'تخصصی'); ?>>تخصصی</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="target_audience">مخاطب هدف</label></th>
                        <td>
                            <input type="text" id="target_audience" name="target_audience" 
                                   value="<?php echo esc_attr($target_audience); ?>" 
                                   class="large-text" 
                                   placeholder="مثال: دانشجویان کارشناسی ارشد">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="reading_time">زمان مطالعه (دقیقه)</label></th>
                        <td>
                            <input type="number" id="reading_time" name="reading_time" 
                                   value="<?php echo esc_attr($reading_time); ?>" 
                                   class="small-text" min="1" max="120">
                            <p class="description">اگر خالی باشد، به صورت خودکار محاسبه می‌شود</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Content Settings Tab -->
            <div class="meta-tab-content" data-tab-content="content">
                <table class="form-table">
                    <tr>
                        <th><label>نکات کلیدی</label></th>
                        <td>
                            <div id="takeaways-container">
                                <?php foreach ($key_takeaways as $index => $takeaway) : ?>
                                    <div class="takeaway-item">
                                        <input type="text" name="key_takeaways[]" 
                                               value="<?php echo esc_attr($takeaway); ?>" 
                                               class="large-text" placeholder="نکته کلیدی">
                                        <button type="button" class="button remove-takeaway">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-takeaway" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن نکته
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th><label>آمار و ارقام</label></th>
                        <td>
                            <div id="statistics-container">
                                <?php foreach ($statistics as $index => $stat) : ?>
                                    <div class="statistic-item">
                                        <input type="text" name="statistics[<?php echo $index; ?>][number]" 
                                               value="<?php echo esc_attr($stat['number'] ?? ''); ?>" 
                                               placeholder="عدد (مثال: ۱۰۰+)" class="regular-text">
                                        <input type="text" name="statistics[<?php echo $index; ?>][label]" 
                                               value="<?php echo esc_attr($stat['label'] ?? ''); ?>" 
                                               placeholder="برچسب (مثال: پروژه موفق)" class="regular-text">
                                        <button type="button" class="button remove-statistic">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-statistic" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن آمار
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th><label>سوالات متداول</label></th>
                        <td>
                            <div id="faq-container">
                                <?php foreach ($faq_items as $index => $faq) : ?>
                                    <div class="faq-item">
                                        <input type="text" name="faq_items[<?php echo $index; ?>][question]" 
                                               value="<?php echo esc_attr($faq['question'] ?? ''); ?>" 
                                               placeholder="سوال" class="large-text">
                                        <textarea name="faq_items[<?php echo $index; ?>][answer]" 
                                                  placeholder="پاسخ" rows="3" 
                                                  class="large-text"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea>
                                        <button type="button" class="button remove-faq">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-faq" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن سوال
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- SEO Settings Tab -->
            <div class="meta-tab-content" data-tab-content="seo">
                <table class="form-table">
                    <tr>
                        <th><label>پیشنهادات مطالعه</label></th>
                        <td>
                            <div id="recommendations-container">
                                <?php foreach ($content_recommendations as $index => $rec) : ?>
                                    <div class="recommendation-item">
                                        <input type="text" name="content_recommendations[<?php echo $index; ?>][title]" 
                                               value="<?php echo esc_attr($rec['title'] ?? ''); ?>" 
                                               placeholder="عنوان لینک" class="large-text">
                                        <input type="url" name="content_recommendations[<?php echo $index; ?>][link]" 
                                               value="<?php echo esc_attr($rec['link'] ?? ''); ?>" 
                                               placeholder="آدرس لینک" class="large-text">
                                        <textarea name="content_recommendations[<?php echo $index; ?>][description]" 
                                                  placeholder="توضیحات (اختیاری)" rows="2" 
                                                  class="large-text"><?php echo esc_textarea($rec['description'] ?? ''); ?></textarea>
                                        <button type="button" class="button remove-recommendation">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-recommendation" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن پیشنهاد
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th><label>منابع و مراجع</label></th>
                        <td>
                            <div id="citations-container">
                                <?php foreach ($citations as $index => $citation) : ?>
                                    <div class="citation-item">
                                        <input type="text" name="citations[<?php echo $index; ?>][author]" 
                                               value="<?php echo esc_attr($citation['author'] ?? ''); ?>" 
                                               placeholder="نویسنده" class="regular-text">
                                        <input type="text" name="citations[<?php echo $index; ?>][title]" 
                                               value="<?php echo esc_attr($citation['title'] ?? ''); ?>" 
                                               placeholder="عنوان" class="large-text">
                                        <input type="text" name="citations[<?php echo $index; ?>][source]" 
                                               value="<?php echo esc_attr($citation['source'] ?? ''); ?>" 
                                               placeholder="منبع" class="regular-text">
                                        <input type="number" name="citations[<?php echo $index; ?>][year]" 
                                               value="<?php echo esc_attr($citation['year'] ?? ''); ?>" 
                                               placeholder="سال" class="small-text" min="1900" max="2030">
                                        <input type="url" name="citations[<?php echo $index; ?>][url]" 
                                               value="<?php echo esc_attr($citation['url'] ?? ''); ?>" 
                                               placeholder="لینک (اختیاری)" class="large-text">
                                        <button type="button" class="button remove-citation">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-citation" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن منبع
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Advanced Settings Tab -->
            <div class="meta-tab-content" data-tab-content="advanced">
                <table class="form-table">
                    <tr>
                        <th><label for="related_service_id">خدمت مرتبط</label></th>
                        <td>
                            <select id="related_service_id" name="related_service_id" class="regular-text">
                                <option value="">انتخاب خدمت مرتبط</option>
                                <?php
                                $services = get_posts(array(
                                    'post_type' => 'services',
                                    'posts_per_page' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC'
                                ));
                                foreach ($services as $service) {
                                    echo '<option value="' . $service->ID . '"' . selected($related_service_id, $service->ID, false) . '>';
                                    echo esc_html($service->post_title);
                                    echo '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label>تصاویر شاخص اضافی</label></th>
                        <td>
                            <div id="featured-images-container">
                                <?php foreach ($featured_images as $index => $image_id) : ?>
                                    <div class="featured-image-item">
                                        <input type="hidden" name="featured_images[]" value="<?php echo esc_attr($image_id); ?>">
                                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                                        <button type="button" class="button remove-featured-image">حذف</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-featured-image" class="button button-secondary">
                                <i class="fa-solid fa-image"></i> افزودن تصویر
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Tab switching
            $('.meta-tab-btn').on('click', function() {
                const tab = $(this).data('tab');
                $('.meta-tab-btn').removeClass('active');
                $('.meta-tab-content').removeClass('active');
                $(this).addClass('active');
                $('[data-tab-content="' + tab + '"]').addClass('active');
            });
            
            // Dynamic field additions
            $('#add-takeaway').on('click', function() {
                const html = `<div class="takeaway-item">
                    <input type="text" name="key_takeaways[]" class="large-text" placeholder="نکته کلیدی">
                    <button type="button" class="button remove-takeaway"><i class="fa-solid fa-trash"></i> حذف</button>
                </div>`;
                $('#takeaways-container').append(html);
            });
            
            $(document).on('click', '.remove-takeaway', function() {
                $(this).closest('.takeaway-item').remove();
            });
            
            $('#add-statistic').on('click', function() {
                const index = $('#statistics-container .statistic-item').length;
                const html = `<div class="statistic-item">
                    <input type="text" name="statistics[${index}][number]" placeholder="عدد" class="regular-text">
                    <input type="text" name="statistics[${index}][label]" placeholder="برچسب" class="regular-text">
                    <button type="button" class="button remove-statistic"><i class="fa-solid fa-trash"></i></button>
                </div>`;
                $('#statistics-container').append(html);
            });
            
            $(document).on('click', '.remove-statistic', function() {
                $(this).closest('.statistic-item').remove();
            });
            
            $('#add-faq').on('click', function() {
                const index = $('#faq-container .faq-item').length;
                const html = `<div class="faq-item">
                    <input type="text" name="faq_items[${index}][question]" placeholder="سوال" class="large-text">
                    <textarea name="faq_items[${index}][answer]" placeholder="پاسخ" rows="3" class="large-text"></textarea>
                    <button type="button" class="button remove-faq"><i class="fa-solid fa-trash"></i> حذف</button>
                </div>`;
                $('#faq-container').append(html);
            });
            
            $(document).on('click', '.remove-faq', function() {
                $(this).closest('.faq-item').remove();
            });
            
            $('#add-recommendation').on('click', function() {
                const index = $('#recommendations-container .recommendation-item').length;
                const html = `<div class="recommendation-item">
                    <input type="text" name="content_recommendations[${index}][title]" placeholder="عنوان لینک" class="large-text">
                    <input type="url" name="content_recommendations[${index}][link]" placeholder="آدرس لینک" class="large-text">
                    <textarea name="content_recommendations[${index}][description]" placeholder="توضیحات" rows="2" class="large-text"></textarea>
                    <button type="button" class="button remove-recommendation"><i class="fa-solid fa-trash"></i> حذف</button>
                </div>`;
                $('#recommendations-container').append(html);
            });
            
            $(document).on('click', '.remove-recommendation', function() {
                $(this).closest('.recommendation-item').remove();
            });
            
            $('#add-citation').on('click', function() {
                const index = $('#citations-container .citation-item').length;
                const html = `<div class="citation-item">
                    <input type="text" name="citations[${index}][author]" placeholder="نویسنده" class="regular-text">
                    <input type="text" name="citations[${index}][title]" placeholder="عنوان" class="large-text">
                    <input type="text" name="citations[${index}][source]" placeholder="منبع" class="regular-text">
                    <input type="number" name="citations[${index}][year]" placeholder="سال" class="small-text" min="1900" max="2030">
                    <input type="url" name="citations[${index}][url]" placeholder="لینک" class="large-text">
                    <button type="button" class="button remove-citation"><i class="fa-solid fa-trash"></i> حذف</button>
                </div>`;
                $('#citations-container').append(html);
            });
            
            $(document).on('click', '.remove-citation', function() {
                $(this).closest('.citation-item').remove();
            });
        });
        </script>
        
        <style>
        .teznevisan-post-meta-enhanced {
            margin-top: 20px;
        }
        
        .meta-tabs-nav {
            display: flex;
            gap: 5px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }
        
        .meta-tab-btn {
            padding: 12px 20px;
            background: #f1f1f1;
            border: 1px solid #ccc;
            border-bottom: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px 8px 0 0;
        }
        
        .meta-tab-btn.active {
            background: white;
            color: #1FA547;
            border-bottom: 1px solid white;
            margin-bottom: -1px;
            position: relative;
            z-index: 1;
        }
        
        .meta-tab-content {
            display: none;
            background: white;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 0 8px 8px 8px;
        }
        
        .meta-tab-content.active {
            display: block;
        }
        
        .takeaway-item,
        .statistic-item,
        .faq-item,
        .recommendation-item,
        .citation-item {
            border: 2px solid #e1e1e1;
            padding: 15px;
            margin-bottom: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            position: relative;
        }
        
        .takeaway-item:hover,
        .statistic-item:hover,
        .faq-item:hover,
        .recommendation-item:hover,
        .citation-item:hover {
            border-color: #1FA547;
            background: #f0fff4;
        }
        
        .takeaway-item input,
        .takeaway-item textarea,
        .statistic-item input,
        .faq-item input,
        .faq-item textarea,
        .recommendation-item input,
        .recommendation-item textarea,
        .citation-item input {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .statistic-item {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            align-items: start;
        }
        
        .citation-item {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr auto auto auto;
            gap: 10px;
            align-items: start;
        }
        
        .remove-takeaway,
        .remove-statistic,
        .remove-faq,
        .remove-recommendation,
        .remove-citation {
            background: #dc3545 !important;
            color: white !important;
            border-color: #dc3545 !important;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .featured-image-item {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            background: #f9f9f9;
        }
        </style>
        <?php
    }

    /**
     * Service Options Meta Box Callback - Complete Enhanced Version
     */
    public function service_options_callback($post) {
        wp_nonce_field('teznevisan_service_options', 'service_options_nonce');
        
        $service_subtitle = get_post_meta($post->ID, 'service_subtitle', true);
        $service_excerpt = get_post_meta($post->ID, 'service_excerpt', true);
        $hero_headline = get_post_meta($post->ID, 'hero_headline', true);
        $hero_description = get_post_meta($post->ID, 'hero_description', true);
        $content_title_1 = get_post_meta($post->ID, 'content_title_1', true) ?: 'توضیحات خدمت';
        $content_title_2 = get_post_meta($post->ID, 'content_title_2', true) ?: 'ویژگی‌های خدمت';
        $lottie_animation_url = get_post_meta($post->ID, 'lottie_animation_url', true);
        $price_range_min = get_post_meta($post->ID, 'price_range_min', true);
        $price_range_max = get_post_meta($post->ID, 'price_range_max', true);
        $delivery_time = get_post_meta($post->ID, 'delivery_time', true);
        $completed_projects = get_post_meta($post->ID, 'completed_projects', true);
        $satisfaction_rate = get_post_meta($post->ID, 'satisfaction_rate', true);
        $service_features = get_post_meta($post->ID, 'service_features', true) ?: array();
        $process_steps = get_post_meta($post->ID, 'process_steps', true) ?: array();
        $service_faq = get_post_meta($post->ID, 'service_faq', true) ?: array();
        $related_services = get_post_meta($post->ID, 'related_services', true) ?: array();
        $service_benefits = get_post_meta($post->ID, 'service_benefits', true) ?: array();
        $service_requirements = get_post_meta($post->ID, 'service_requirements', true) ?: array();
        $service_guarantee = get_post_meta($post->ID, 'service_guarantee', true);
        $service_category_type = get_post_meta($post->ID, 'service_category_type', true) ?: 'academic';
        
        ?>
        <div class="service-meta-tabs-enhanced">
            <nav class="service-meta-nav">
                <button type="button" class="service-tab-btn active" data-tab="basic">اطلاعات پایه</button>
                <button type="button" class="service-tab-btn" data-tab="hero">هیرو و نمایش</button>
                <button type="button" class="service-tab-btn" data-tab="content">محتوا و توضیحات</button>
                <button type="button" class="service-tab-btn" data-tab="pricing">قیمت‌گذاری</button>
                <button type="button" class="service-tab-btn" data-tab="features">ویژگی‌ها</button>
                <button type="button" class="service-tab-btn" data-tab="process">فرآیند کار</button>
                <button type="button" class="service-tab-btn" data-tab="benefits">مزایا و ضمانت</button>
                <button type="button" class="service-tab-btn" data-tab="faq">سوالات متداول</button>
                <button type="button" class="service-tab-btn" data-tab="related">خدمات مرتبط</button>
            </nav>
            
            <!-- Basic Settings -->
            <div class="service-tab-content active" data-tab-content="basic">
                <table class="form-table">
                    <tr>
                        <th><label for="service_subtitle">زیرعنوان خدمت</label></th>
                        <td>
                            <input type="text" id="service_subtitle" name="service_subtitle" 
                                   value="<?php echo esc_attr($service_subtitle); ?>" class="large-text">
                            <p class="description">زیرعنوان کوتاه برای توضیح خدمت</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="service_excerpt">خلاصه خدمت</label></th>
                        <td>
                            <textarea id="service_excerpt" name="service_excerpt" rows="4" 
                                      class="large-text"><?php echo esc_textarea($service_excerpt); ?></textarea>
                            <p class="description">متن کوتاه برای نمایش در کارت خدمت و هیرو</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="service_category_type">نوع دسته‌بندی</label></th>
                        <td>
                            <select id="service_category_type" name="service_category_type" class="regular-text">
                                <option value="academic" <?php selected($service_category_type, 'academic'); ?>>دانشگاهی</option>
                                <option value="professional" <?php selected($service_category_type, 'professional'); ?>>حرفه‌ای</option>
                                <option value="creative" <?php selected($service_category_type, 'creative'); ?>>خلاقانه</option>
                                <option value="technical" <?php selected($service_category_type, 'technical'); ?>>فنی</option>
                                <option value="consultation" <?php selected($service_category_type, 'consultation'); ?>>مشاوره‌ای</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Hero Settings -->
            <div class="service-tab-content" data-tab-content="hero">
                <table class="form-table">
                    <tr>
                        <th><label for="hero_headline">عنوان اصلی هیرو</label></th>
                        <td>
                            <input type="text" id="hero_headline" name="hero_headline" 
                                   value="<?php echo esc_attr($hero_headline); ?>" class="large-text"
                                   placeholder="مثال: خدمات نگارش پایان‌نامه برای دانشجویان ایرانی">
                            <p class="description">عنوان اصلی که در بخش هیرو نمایش داده می‌شود</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="hero_description">توضیحات هیرو</label></th>
                        <td>
                            <textarea id="hero_description" name="hero_description" rows="4" 
                                      class="large-text"><?php echo esc_textarea($hero_description); ?></textarea>
                            <p class="description">توضیحات تکمیلی برای نمایش در هیرو</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="lottie_animation_url">لینک انیمیشن Lottie</label></th>
                        <td>
                            <input type="url" id="lottie_animation_url" name="lottie_animation_url" 
                                   value="<?php echo esc_attr($lottie_animation_url); ?>" class="large-text">
                            <p class="description">لینک فایل JSON انیمیشن Lottie برای نمایش در هیرو</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Content Settings -->
            <div class="service-tab-content" data-tab-content="content">
                <table class="form-table">
                    <tr>
                        <th><label for="content_title_1">عنوان بخش اول محتوا</label></th>
                        <td>
                            <input type="text" id="content_title_1" name="content_title_1" 
                                   value="<?php echo esc_attr($content_title_1); ?>" class="large-text">
                            <p class="description">عنوان بخش توضیحات خدمت</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="content_title_2">عنوان بخش دوم محتوا</label></th>
                        <td>
                            <input type="text" id="content_title_2" name="content_title_2" 
                                   value="<?php echo esc_attr($content_title_2); ?>" class="large-text">
                            <p class="description">عنوان بخش ویژگی‌های خدمت</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="service_guarantee">ضمانت خدمت</label></th>
                        <td>
                            <textarea id="service_guarantee" name="service_guarantee" rows="3" 
                                      class="large-text"><?php echo esc_textarea($service_guarantee); ?></textarea>
                            <p class="description">توضیحات ضمانت و تعهدات خدمت</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Pricing Settings -->
            <div class="service-tab-content" data-tab-content="pricing">
                <table class="form-table">
                    <tr>
                        <th><label for="price_range_min">حداقل قیمت (تومان)</label></th>
                        <td>
                            <input type="number" id="price_range_min" name="price_range_min" 
                                   value="<?php echo esc_attr($price_range_min); ?>" 
                                   step="10000" min="0" class="regular-text">
                            <p class="description">حداقل قیمت محدوده این خدمت</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="price_range_max">حداکثر قیمت (تومان)</label></th>
                        <td>
                            <input type="number" id="price_range_max" name="price_range_max" 
                                   value="<?php echo esc_attr($price_range_max); ?>" 
                                   step="10000" min="0" class="regular-text">
                            <p class="description">حداکثر قیمت محدوده این خدمت</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="delivery_time">زمان تحویل</label></th>
                        <td>
                            <input type="text" id="delivery_time" name="delivery_time" 
                                   value="<?php echo esc_attr($delivery_time); ?>" 
                                   class="regular-text" placeholder="مثال: ۳ تا ۷ روز کاری">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="completed_projects">پروژه‌های تکمیل شده</label></th>
                        <td>
                            <input type="text" id="completed_projects" name="completed_projects" 
                                   value="<?php echo esc_attr($completed_projects); ?>" 
                                   class="regular-text" placeholder="مثال: ۵۰۰+">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="satisfaction_rate">درصد رضایت</label></th>
                        <td>
                            <input type="text" id="satisfaction_rate" name="satisfaction_rate" 
                                   value="<?php echo esc_attr($satisfaction_rate); ?>" 
                                   class="regular-text" placeholder="مثال: ۹۸%">
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Features Settings -->
            <div class="service-tab-content" data-tab-content="features">
                <table class="form-table">
                    <tr>
                        <th><label>ویژگی‌های خدمت</label></th>
                        <td>
                            <div id="service-features-container">
                                <?php foreach ($service_features as $index => $feature) : ?>
                                    <div class="feature-item-admin">
                                        <h4>ویژگی <?php echo $index + 1; ?></h4>
                                        <input type="text" name="service_features[<?php echo $index; ?>][title]" 
                                               placeholder="عنوان ویژگی" 
                                               value="<?php echo esc_attr($feature['title'] ?? ''); ?>" 
                                               class="large-text">
                                        <textarea name="service_features[<?php echo $index; ?>][description]" 
                                                  placeholder="توضیحات ویژگی" 
                                                  rows="2" 
                                                  class="large-text"><?php echo esc_textarea($feature['description'] ?? ''); ?></textarea>
                                        <button type="button" class="button remove-feature">
                                            <i class="fa-solid fa-trash"></i> حذف ویژگی
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-service-feature" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن ویژگی جدید
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Process Settings -->
            <div class="service-tab-content" data-tab-content="process">
                <table class="form-table">
                    <tr>
                        <th><label>مراحل انجام کار</label></th>
                        <td>
                            <div id="process-steps-container">
                                <?php foreach ($process_steps as $index => $step) : ?>
                                    <div class="process-step-admin">
                                        <h4>مرحله <?php echo $index + 1; ?></h4>
                                        <input type="text" name="process_steps[<?php echo $index; ?>][title]" 
                                               placeholder="عنوان مرحله" 
                                               value="<?php echo esc_attr($step['title'] ?? ''); ?>" 
                                               class="large-text">
                                        <textarea name="process_steps[<?php echo $index; ?>][description]" 
                                                  placeholder="توضیحات مرحله" 
                                                  rows="3" 
                                                  class="large-text"><?php echo esc_textarea($step['description'] ?? ''); ?></textarea>
                                        <input type="text" name="process_steps[<?php echo $index; ?>][duration]" 
                                               placeholder="مدت زمان (اختیاری)" 
                                               value="<?php echo esc_attr($step['duration'] ?? ''); ?>"
                                               class="regular-text">
                                        <button type="button" class="button remove-process-step">
                                            <i class="fa-solid fa-trash"></i> حذف مرحله
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-process-step" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن مرحله جدید
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Benefits Settings -->
            <div class="service-tab-content" data-tab-content="benefits">
                <table class="form-table">
                    <tr>
                        <th><label>مزایای خدمت</label></th>
                        <td>
                            <div id="service-benefits-container">
                                <?php foreach ($service_benefits as $index => $benefit) : ?>
                                    <div class="benefit-item-admin">
                                        <input type="text" name="service_benefits[<?php echo $index; ?>][title]" 
                                               placeholder="عنوان مزیت" 
                                               value="<?php echo esc_attr($benefit['title'] ?? ''); ?>" 
                                               class="large-text">
                                        <textarea name="service_benefits[<?php echo $index; ?>][description]" 
                                                  placeholder="توضیحات مزیت" 
                                                  rows="2" 
                                                  class="large-text"><?php echo esc_textarea($benefit['description'] ?? ''); ?></textarea>
                                        <button type="button" class="button remove-benefit">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-service-benefit" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن مزیت
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th><label>الزامات و پیش‌نیازها</label></th>
                        <td>
                            <div id="service-requirements-container">
                                <?php foreach ($service_requirements as $index => $requirement) : ?>
                                    <div class="requirement-item-admin">
                                        <input type="text" name="service_requirements[]" 
                                               value="<?php echo esc_attr($requirement); ?>" 
                                               class="large-text" placeholder="پیش‌نیاز یا الزام">
                                        <button type="button" class="button remove-requirement">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-service-requirement" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن الزام
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- FAQ Settings -->
            <div class="service-tab-content" data-tab-content="faq">
                <table class="form-table">
                    <tr>
                        <th><label>سوالات متداول</label></th>
                        <td>
                            <div id="service-faq-container">
                                <?php foreach ($service_faq as $index => $faq) : ?>
                                    <div class="service-faq-item-admin">
                                        <h4>سوال <?php echo $index + 1; ?></h4>
                                        <input type="text" name="service_faq[<?php echo $index; ?>][question]" 
                                               placeholder="سوال" 
                                               value="<?php echo esc_attr($faq['question'] ?? ''); ?>" 
                                               class="large-text">
                                        <textarea name="service_faq[<?php echo $index; ?>][answer]" 
                                                  placeholder="پاسخ" 
                                                  rows="3" 
                                                  class="large-text"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea>
                                        <button type="button" class="button remove-service-faq">
                                            <i class="fa-solid fa-trash"></i> حذف سوال
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-service-faq" class="button button-primary">
                                <i class="fa-solid fa-plus"></i> افزودن سوال جدید
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Related Services -->
            <div class="service-tab-content" data-tab-content="related">
                <table class="form-table">
                    <tr>
                        <th><label>خدمات مرتبط (حداکثر ۳ عدد)</label></th>
                        <td>
                            <?php
                            $all_services = get_posts(array(
                                'post_type' => 'services',
                                'posts_per_page' => -1,
                                'post__not_in' => array($post->ID),
                                'orderby' => 'title',
                                'order' => 'ASC'
                            ));
                            
                            for ($i = 0; $i < 3; $i++) :
                                $selected_service = isset($related_services[$i]) ? $related_services[$i] : '';
                            ?>
                                <div class="related-service-item">
                                    <label>خدمت مرتبط <?php echo $i + 1; ?>:</label>
                                    <select name="related_services[]" class="large-text">
                                        <option value="">انتخاب خدمت</option>
                                        <?php foreach ($all_services as $service) : ?>
                                            <option value="<?php echo $service->ID; ?>" <?php selected($selected_service, $service->ID); ?>>
                                                <?php echo esc_html($service->post_title); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endfor; ?>
                            <p class="description">انتخاب ۳ خدمت مرتبط برای نمایش در انتهای صفحه</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Service tab switching
            $('.service-tab-btn').on('click', function() {
                const tab = $(this).data('tab');
                $('.service-tab-btn').removeClass('active');
                $('.service-tab-content').removeClass('active');
                $(this).addClass('active');
                $('[data-tab-content="' + tab + '"]').addClass('active');
            });
            
            // Service feature management
            $('#add-service-feature').on('click', function() {
                const index = $('#service-features-container .feature-item-admin').length;
                const html = `<div class="feature-item-admin">
                    <h4>ویژگی ${index + 1}</h4>
                    <input type="text" name="service_features[${index}][title]" placeholder="عنوان ویژگی" class="large-text">
                    <textarea name="service_features[${index}][description]" placeholder="توضیحات ویژگی" rows="2" class="large-text"></textarea>
                    <button type="button" class="button remove-feature"><i class="fa-solid fa-trash"></i> حذف ویژگی</button>
                </div>`;
                $('#service-features-container').append(html);
            });
            
            $(document).on('click', '.remove-feature', function() {
                $(this).closest('.feature-item-admin').remove();
                $('#service-features-container .feature-item-admin').each(function(index) {
                    $(this).find('h4').text('ویژگی ' + (index + 1));
                });
            });
            
            // Process step management
            $('#add-process-step').on('click', function() {
                const index = $('#process-steps-container .process-step-admin').length;
                const html = `<div class="process-step-admin">
                    <h4>مرحله ${index + 1}</h4>
                    <input type="text" name="process_steps[${index}][title]" placeholder="عنوان مرحله" class="large-text">
                    <textarea name="process_steps[${index}][description]" placeholder="توضیحات مرحله" rows="3" class="large-text"></textarea>
                    <input type="text" name="process_steps[${index}][duration]" placeholder="مدت زمان" class="regular-text">
                    <button type="button" class="button remove-process-step"><i class="fa-solid fa-trash"></i> حذف مرحله</button>
                </div>`;
                $('#process-steps-container').append(html);
            });
            
            $(document).on('click', '.remove-process-step', function() {
                $(this).closest('.process-step-admin').remove();
                $('#process-steps-container .process-step-admin').each(function(index) {
                    $(this).find('h4').text('مرحله ' + (index + 1));
                });
            });
            
            // Service FAQ management
            $('#add-service-faq').on('click', function() {
                const index = $('#service-faq-container .service-faq-item-admin').length;
                const html = `<div class="service-faq-item-admin">
                    <h4>سوال ${index + 1}</h4>
                    <input type="text" name="service_faq[${index}][question]" placeholder="سوال" class="large-text">
                    <textarea name="service_faq[${index}][answer]" placeholder="پاسخ" rows="3" class="large-text"></textarea>
                    <button type="button" class="button remove-service-faq"><i class="fa-solid fa-trash"></i> حذف سوال</button>
                </div>`;
                $('#service-faq-container').append(html);
            });
            
            $(document).on('click', '.remove-service-faq', function() {
                $(this).closest('.service-faq-item-admin').remove();
                $('#service-faq-container .service-faq-item-admin').each(function(index) {
                    $(this).find('h4').text('سوال ' + (index + 1));
                });
            });
            
            // Benefit management
            $('#add-service-benefit').on('click', function() {
                const index = $('#service-benefits-container .benefit-item-admin').length;
                const html = `<div class="benefit-item-admin">
                    <input type="text" name="service_benefits[${index}][title]" placeholder="عنوان مزیت" class="large-text">
                    <textarea name="service_benefits[${index}][description]" placeholder="توضیحات مزیت" rows="2" class="large-text"></textarea>
                    <button type="button" class="button remove-benefit"><i class="fa-solid fa-trash"></i> حذف</button>
                </div>`;
                $('#service-benefits-container').append(html);
            });
            
            $(document).on('click', '.remove-benefit', function() {
                $(this).closest('.benefit-item-admin').remove();
            });
            
            // Requirement management
            $('#add-service-requirement').on('click', function() {
                const html = `<div class="requirement-item-admin">
                    <input type="text" name="service_requirements[]" class="large-text" placeholder="پیش‌نیاز یا الزام">
                    <button type="button" class="button remove-requirement"><i class="fa-solid fa-trash"></i> حذف</button>
                </div>`;
                $('#service-requirements-container').append(html);
            });
            
            $(document).on('click', '.remove-requirement', function() {
                $(this).closest('.requirement-item-admin').remove();
            });
        });
        </script>
        
        <style>
        .service-meta-tabs-enhanced {
            margin-top: 20px;
        }
        
        .service-meta-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }
        
        .service-tab-btn {
            padding: 12px 16px;
            background: #f1f1f1;
            border: 1px solid #ccc;
            border-bottom: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px 8px 0 0;
            font-size: 13px;
        }
        
        .service-tab-btn.active {
            background: white;
            color: #1FA547;
            border-bottom: 1px solid white;
            margin-bottom: -1px;
            position: relative;
            z-index: 2;
            font-weight: 600;
        }
        
        .service-tab-content {
            display: none;
            background: white;
            border: 1px solid #ccc;
            padding: 25px;
            border-radius: 0 8px 8px 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .service-tab-content.active {
            display: block;
        }
        
        .feature-item-admin,
        .process-step-admin,
        .service-faq-item-admin,
        .benefit-item-admin,
        .requirement-item-admin {
            border: 2px solid #e1e1e1;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            position: relative;
        }
        
        .feature-item-admin:hover,
        .process-step-admin:hover,
        .service-faq-item-admin:hover {
            border-color: #1FA547;
            background: #f0fff4;
        }
        
        .feature-item-admin h4,
        .process-step-admin h4,
        .service-faq-item-admin h4 {
            margin: 0 0 15px 0;
            color: white;
            font-size: 14px;
            font-weight: 700;
            padding: 8px 12px;
            background: #1FA547;
            border-radius: 4px;
            display: inline-block;
        }
        
        .related-service-item {
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        
        .related-service-item label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        </style>
        <?php
    }

    /**
     * Service SEO Meta Box
     */
    public function service_seo_callback($post) {
        wp_nonce_field('teznevisan_service_seo', 'service_seo_nonce');
        
        $meta_title = get_post_meta($post->ID, 'meta_title', true);
        $meta_description = get_post_meta($post->ID, 'meta_description', true);
        $focus_keyword = get_post_meta($post->ID, 'focus_keyword', true);
        $canonical_url = get_post_meta($post->ID, 'canonical_url', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="meta_title">عنوان SEO</label></th>
                <td>
                    <input type="text" id="meta_title" name="meta_title" 
                           value="<?php echo esc_attr($meta_title); ?>" class="large-text">
                    <p class="description">حداکثر ۶۰ کاراکتر</p>
                </td>
            </tr>
            <tr>
                <th><label for="meta_description">توضیحات SEO</label></th>
                <td>
                    <textarea id="meta_description" name="meta_description" rows="3" 
                              class="large-text"><?php echo esc_textarea($meta_description); ?></textarea>
                    <p class="description">حداکثر ۱۶۰ کاراکتر</p>
                </td>
            </tr>
            <tr>
                <th><label for="focus_keyword">کلمه کلیدی اصلی</label></th>
                <td>
                    <input type="text" id="focus_keyword" name="focus_keyword" 
                           value="<?php echo esc_attr($focus_keyword); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="canonical_url">URL کانونیکال</label></th>
                <td>
                    <input type="url" id="canonical_url" name="canonical_url" 
                           value="<?php echo esc_attr($canonical_url); ?>" class="large-text">
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Testimonial Options Meta Box
     */
    public function testimonial_options_callback($post) {
        wp_nonce_field('teznevisan_testimonial_options', 'testimonial_options_nonce');
        
        $client_name = get_post_meta($post->ID, 'client_name', true);
        $client_position = get_post_meta($post->ID, 'client_position', true);
        $client_company = get_post_meta($post->ID, 'client_company', true);
        $rating = get_post_meta($post->ID, 'rating', true) ?: 5;
        $project_type = get_post_meta($post->ID, 'project_type', true);
        $testimonial_date = get_post_meta($post->ID, 'testimonial_date', true);
        $is_featured = get_post_meta($post->ID, 'is_featured', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="client_name">نام مشتری</label></th>
                <td>
                    <input type="text" id="client_name" name="client_name" 
                           value="<?php echo esc_attr($client_name); ?>" class="regular-text" required>
                </td>
            </tr>
            <tr>
                <th><label for="client_position">سمت مشتری</label></th>
                <td>
                    <input type="text" id="client_position" name="client_position" 
                           value="<?php echo esc_attr($client_position); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="client_company">شرکت/دانشگاه</label></th>
                <td>
                    <input type="text" id="client_company" name="client_company" 
                           value="<?php echo esc_attr($client_company); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="rating">امتیاز (۱ تا ۵)</label></th>
                <td>
                    <select id="rating" name="rating" class="regular-text">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>>
                                <?php echo $i; ?> ستاره
                            </option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="project_type">نوع پروژه</label></th>
                <td>
                    <select id="project_type" name="project_type" class="regular-text">
                        <option value="">انتخاب نوع پروژه</option>
                        <option value="thesis" <?php selected($project_type, 'thesis'); ?>>پایان‌نامه</option>
                        <option value="article" <?php selected($project_type, 'article'); ?>>مقاله علمی</option>
                        <option value="proposal" <?php selected($project_type, 'proposal'); ?>>پروپوزال</option>
                        <option value="translation" <?php selected($project_type, 'translation'); ?>>ترجمه</option>
                        <option value="editing" <?php selected($project_type, 'editing'); ?>>ویرایش</option>
                        <option value="other" <?php selected($project_type, 'other'); ?>>سایر</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="testimonial_date">تاریخ نظر</label></th>
                <td>
                    <input type="date" id="testimonial_date" name="testimonial_date" 
                           value="<?php echo esc_attr($testimonial_date); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="is_featured">نظر شاخص</label></th>
                <td>
                    <label>
                        <input type="checkbox" id="is_featured" name="is_featured" 
                               value="1" <?php checked($is_featured, '1'); ?>>
                        نمایش در صفحه اصلی
                    </label>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Portfolio Options Meta Box
     */
    public function portfolio_options_callback($post) {
        wp_nonce_field('teznevisan_portfolio_options', 'portfolio_options_nonce');
        
        $project_client = get_post_meta($post->ID, 'project_client', true);
        $project_year = get_post_meta($post->ID, 'project_year', true);
        $project_duration = get_post_meta($post->ID, 'project_duration', true);
        $project_tools = get_post_meta($post->ID, 'project_tools', true) ?: array();
        $project_url = get_post_meta($post->ID, 'project_url', true);
        $project_status = get_post_meta($post->ID, 'project_status', true) ?: 'completed';
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="project_client">نام مشتری/سازمان</label></th>
                <td>
                    <input type="text" id="project_client" name="project_client" 
                           value="<?php echo esc_attr($project_client); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="project_year">سال انجام</label></th>
                <td>
                    <input type="number" id="project_year" name="project_year" 
                           value="<?php echo esc_attr($project_year); ?>" 
                           class="regular-text" min="2000" max="2030">
                </td>
            </tr>
            <tr>
                <th><label for="project_duration">مدت زمان پروژه</label></th>
                <td>
                    <input type="text" id="project_duration" name="project_duration" 
                           value="<?php echo esc_attr($project_duration); ?>" 
                           class="regular-text" placeholder="مثال: ۲ ماه">
                </td>
            </tr>
            <tr>
                <th><label for="project_status">وضعیت پروژه</label></th>
                <td>
                    <select id="project_status" name="project_status" class="regular-text">
                        <option value="completed" <?php selected($project_status, 'completed'); ?>>تکمیل شده</option>
                        <option value="in_progress" <?php selected($project_status, 'in_progress'); ?>>در حال انجام</option>
                        <option value="planned" <?php selected($project_status, 'planned'); ?>>برنامه‌ریزی شده</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="project_url">لینک پروژه</label></th>
                <td>
                    <input type="url" id="project_url" name="project_url" 
                           value="<?php echo esc_attr($project_url); ?>" class="large-text">
                </td>
            </tr>
            <tr>
                <th><label>ابزارها و تکنولوژی‌ها</label></th>
                <td>
                    <div id="project-tools-container">
                        <?php foreach ($project_tools as $index => $tool) : ?>
                            <div class="tool-item">
                                <input type="text" name="project_tools[]" 
                                       value="<?php echo esc_attr($tool); ?>" 
                                       class="regular-text" placeholder="نام ابزار">
                                <button type="button" class="button remove-tool">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="add-project-tool" class="button button-secondary">
                        <i class="fa-solid fa-plus"></i> افزودن ابزار
                    </button>
                </td>
            </tr>
        </table>
        
        <script>
        jQuery(document).ready(function($) {
            $('#add-project-tool').on('click', function() {
                const html = `<div class="tool-item">
                    <input type="text" name="project_tools[]" class="regular-text" placeholder="نام ابزار">
                    <button type="button" class="button remove-tool"><i class="fa-solid fa-trash"></i></button>
                </div>`;
                $('#project-tools-container').append(html);
            });
            
            $(document).on('click', '.remove-tool', function() {
                $(this).closest('.tool-item').remove();
            });
        });
        </script>
        
        <style>
        .tool-item {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .tool-item input {
            flex: 1;
        }
        </style>
        <?php
    }
    
    /**
     * Save Post Meta - Enhanced
     */
    public function save_post_meta($post_id) {
        // Verify nonce and permissions
        if (!$this->verify_save_permissions($post_id)) {
            return;
        }
        
        $post_type = get_post_type($post_id);
        
        switch ($post_type) {
            case 'post':
                $this->save_post_fields($post_id);
                break;
            case 'services':
                $this->save_service_fields($post_id);
                break;
            case 'testimonials':
                $this->save_testimonial_fields($post_id);
                break;
            case 'portfolio':
                $this->save_portfolio_fields($post_id);
                break;
        }
    }
    
    /**
     * Verify Save Permissions - Enhanced
     */
    private function verify_save_permissions($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return false;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }
        
        $post_type = get_post_type($post_id);
        $nonce_fields = array(
            'post' => 'post_options_nonce',
            'services' => 'service_options_nonce',
            'testimonials' => 'testimonial_options_nonce',
            'portfolio' => 'portfolio_options_nonce'
        );
        
        $nonce_actions = array(
            'post' => 'teznevisan_post_options',
            'services' => 'teznevisan_service_options',
            'testimonials' => 'teznevisan_testimonial_options',
            'portfolio' => 'teznevisan_portfolio_options'
        );
        
        if (isset($nonce_fields[$post_type]) && isset($nonce_actions[$post_type])) {
            return isset($_POST[$nonce_fields[$post_type]]) && 
                   wp_verify_nonce($_POST[$nonce_fields[$post_type]], $nonce_actions[$post_type]);
        }
        
        return false;
    }
    
    /**
     * Save Post Fields - Enhanced
     */
    private function save_post_fields($post_id) {
        $text_fields = array(
            'post_subtitle', 'related_service_id', 'reading_time', 
            'difficulty_level', 'target_audience', 'post_type_content'
        );
        
        foreach ($text_fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        // Array fields
        $array_fields = array(
            'featured_images' => 'absint',
            'key_takeaways' => 'sanitize_text_field',
            'statistics' => array($this, 'sanitize_statistics'),
            'faq_items' => array($this, 'sanitize_faq_items'),
            'content_recommendations' => array($this, 'sanitize_recommendations'),
            'citations' => array($this, 'sanitize_citations')
        );
        
        foreach ($array_fields as $field => $sanitizer) {
            if (isset($_POST[$field]) && is_array($_POST[$field])) {
                if (is_callable($sanitizer)) {
                    $value = call_user_func($sanitizer, $_POST[$field]);
                } else {
                    $value = array_map($sanitizer, array_filter($_POST[$field]));
                }
                update_post_meta($post_id, $field, $value);
            }
        }
    }
    
    /**
     * Save Service Fields - Enhanced
     */
    private function save_service_fields($post_id) {
        $text_fields = array(
            'service_subtitle' => 'sanitize_text_field',
            'service_excerpt' => 'sanitize_textarea_field',
            'hero_headline' => 'sanitize_text_field',
            'hero_description' => 'sanitize_textarea_field',
            'content_title_1' => 'sanitize_text_field',
            'content_title_2' => 'sanitize_text_field',
            'lottie_animation_url' => 'esc_url_raw',
            'price_range_min' => 'absint',
            'price_range_max' => 'absint',
            'delivery_time' => 'sanitize_text_field',
            'completed_projects' => 'sanitize_text_field',
            'satisfaction_rate' => 'sanitize_text_field',
            'service_guarantee' => 'sanitize_textarea_field',
            'service_category_type' => 'sanitize_text_field',
            'meta_title' => 'sanitize_text_field',
            'meta_description' => 'sanitize_textarea_field',
            'focus_keyword' => 'sanitize_text_field',
            'canonical_url' => 'esc_url_raw'
        );
        
        foreach ($text_fields as $field => $sanitizer) {
            if (isset($_POST[$field])) {
                $value = call_user_func($sanitizer, $_POST[$field]);
                update_post_meta($post_id, $field, $value);
            }
        }
        
        // Array fields for services
        if (isset($_POST['service_features']) && is_array($_POST['service_features'])) {
            $features = $this->sanitize_service_features($_POST['service_features']);
            update_post_meta($post_id, 'service_features', $features);
        }
        
        if (isset($_POST['process_steps']) && is_array($_POST['process_steps'])) {
            $steps = $this->sanitize_process_steps($_POST['process_steps']);
            update_post_meta($post_id, 'process_steps', $steps);
        }
        
        if (isset($_POST['service_faq']) && is_array($_POST['service_faq'])) {
            $faq = $this->sanitize_service_faq($_POST['service_faq']);
            update_post_meta($post_id, 'service_faq', $faq);
        }
        
        if (isset($_POST['service_benefits']) && is_array($_POST['service_benefits'])) {
            $benefits = $this->sanitize_service_benefits($_POST['service_benefits']);
            update_post_meta($post_id, 'service_benefits', $benefits);
        }
        
        if (isset($_POST['service_requirements']) && is_array($_POST['service_requirements'])) {
            $requirements = array_map('sanitize_text_field', array_filter($_POST['service_requirements']));
            update_post_meta($post_id, 'service_requirements', $requirements);
        }
        
        if (isset($_POST['related_services']) && is_array($_POST['related_services'])) {
            $related = array_map('absint', array_filter($_POST['related_services']));
            update_post_meta($post_id, 'related_services', array_slice($related, 0, 3));
        }
    }

    /**
     * Save Testimonial Fields
     */
    private function save_testimonial_fields($post_id) {
        $fields = array(
            'client_name' => 'sanitize_text_field',
            'client_position' => 'sanitize_text_field',
            'client_company' => 'sanitize_text_field',
            'rating' => 'absint',
            'project_type' => 'sanitize_text_field',
            'testimonial_date' => 'sanitize_text_field'
        );
        
        foreach ($fields as $field => $sanitizer) {
            if (isset($_POST[$field])) {
                $value = call_user_func($sanitizer, $_POST[$field]);
                update_post_meta($post_id, $field, $value);
            }
        }
        
        $is_featured = isset($_POST['is_featured']) ? '1' : '0';
        update_post_meta($post_id, 'is_featured', $is_featured);
    }

    /**
     * Save Portfolio Fields
     */
    private function save_portfolio_fields($post_id) {
        $fields = array(
            'project_client' => 'sanitize_text_field',
            'project_year' => 'absint',
            'project_duration' => 'sanitize_text_field',
            'project_url' => 'esc_url_raw',
            'project_status' => 'sanitize_text_field'
        );
        
        foreach ($fields as $field => $sanitizer) {
            if (isset($_POST[$field])) {
                $value = call_user_func($sanitizer, $_POST[$field]);
                update_post_meta($post_id, $field, $value);
            }
        }
        
        if (isset($_POST['project_tools']) && is_array($_POST['project_tools'])) {
            $tools = array_map('sanitize_text_field', array_filter($_POST['project_tools']));
            update_post_meta($post_id, 'project_tools', $tools);
        }
    }
    
    /**
     * Enhanced Sanitization Methods
     */
    public function sanitize_statistics($data) {
        $clean_data = array();
        foreach ($data as $stat) {
            if (!empty($stat['number']) && !empty($stat['label'])) {
                $clean_data[] = array(
                    'number' => sanitize_text_field($stat['number']),
                    'label' => sanitize_text_field($stat['label'])
                );
            }
        }
        return $clean_data;
    }
    
    public function sanitize_faq_items($data) {
        $clean_data = array();
        foreach ($data as $faq) {
            if (!empty($faq['question']) && !empty($faq['answer'])) {
                $clean_data[] = array(
                    'question' => sanitize_text_field($faq['question']),
                    'answer' => sanitize_textarea_field($faq['answer'])
                );
            }
        }
        return $clean_data;
    }
    
    public function sanitize_recommendations($data) {
        $clean_data = array();
        foreach ($data as $rec) {
            if (!empty($rec['title']) && !empty($rec['link'])) {
                $clean_data[] = array(
                    'title' => sanitize_text_field($rec['title']),
                    'link' => esc_url_raw($rec['link']),
                    'description' => sanitize_textarea_field($rec['description'] ?? '')
                );
            }
        }
        return $clean_data;
    }
    
    public function sanitize_citations($data) {
        $clean_data = array();
        foreach ($data as $citation) {
            if (!empty($citation['title'])) {
                $clean_data[] = array(
                    'author' => sanitize_text_field($citation['author'] ?? ''),
                    'title' => sanitize_text_field($citation['title']),
                    'source' => sanitize_text_field($citation['source'] ?? ''),
                    'year' => sanitize_text_field($citation['year'] ?? ''),
                    'url' => esc_url_raw($citation['url'] ?? '')
                );
            }
        }
        return $clean_data;
    }
    
    public function sanitize_service_features($data) {
        $clean_data = array();
        foreach ($data as $feature) {
            if (!empty($feature['title'])) {
                $clean_data[] = array(
                    'title' => sanitize_text_field($feature['title']),
                    'description' => sanitize_textarea_field($feature['description'] ?? '')
                );
            }
        }
        return $clean_data;
    }
    
    public function sanitize_process_steps($data) {
        $clean_data = array();
        foreach ($data as $step) {
            if (!empty($step['title'])) {
                $clean_data[] = array(
                    'title' => sanitize_text_field($step['title']),
                    'description' => sanitize_textarea_field($step['description'] ?? ''),
                    'duration' => sanitize_text_field($step['duration'] ?? '')
                );
            }
        }
        return $clean_data;
    }
    
    public function sanitize_service_faq($data) {
        $clean_data = array();
        foreach ($data as $faq) {
            if (!empty($faq['question']) && !empty($faq['answer'])) {
                $clean_data[] = array(
                    'question' => sanitize_text_field($faq['question']),
                    'answer' => sanitize_textarea_field($faq['answer'])
                );
            }
        }
        return $clean_data;
    }

    public function sanitize_service_benefits($data) {
        $clean_data = array();
        foreach ($data as $benefit) {
            if (!empty($benefit['title'])) {
                $clean_data[] = array(
                    'title' => sanitize_text_field($benefit['title']),
                    'description' => sanitize_textarea_field($benefit['description'] ?? '')
                );
            }
        }
        return $clean_data;
    }
    
    /**
     * Enhanced Customizer Register - COMPLETE DYNAMIC MENUS
     */
    public function customize_register($wp_customize) {
        // Header Settings
        $wp_customize->add_section('header_settings', array(
            'title' => 'تنظیمات هدر',
            'priority' => 110,
        ));
        
        $wp_customize->add_setting('header_style', array(
            'default' => 'modern',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control('header_style', array(
            'label' => 'استایل هدر',
            'section' => 'header_settings',
            'type' => 'select',
            'choices' => array(
                'modern' => 'مدرن',
                'classic' => 'کلاسیک',
                'minimal' => 'مینیمال'
            )
        ));
        
        $wp_customize->add_setting('enable_header_search', array(
            'default' => true,
            'sanitize_callback' => 'wp_validate_boolean'
        ));
        
        $wp_customize->add_control('enable_header_search', array(
            'label' => 'نمایش دکمه جستجو در هدر',
            'section' => 'header_settings',
            'type' => 'checkbox'
        ));
        
        $wp_customize->add_setting('enable_sticky_header', array(
            'default' => true,
            'sanitize_callback' => 'wp_validate_boolean'
        ));
        
        $wp_customize->add_control('enable_sticky_header', array(
            'label' => 'هدر چسبان',
            'section' => 'header_settings',
            'type' => 'checkbox'
        ));
        
        // Menu Settings Section - Enhanced
        $wp_customize->add_section('menu_settings', array(
            'title' => 'تنظیمات منو و ناوبری',
            'priority' => 115,
        ));
        
        $wp_customize->add_setting('enable_mega_menu', array(
            'default' => false,
            'sanitize_callback' => 'wp_validate_boolean'
        ));
        
        $wp_customize->add_control('enable_mega_menu', array(
            'label' => 'فعال‌سازی مگامنو',
            'section' => 'menu_settings',
            'type' => 'checkbox'
        ));
        
        $wp_customize->add_setting('menu_animation_style', array(
            'default' => 'fade',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control('menu_animation_style', array(
            'label' => 'نوع انیمیشن منو',
            'section' => 'menu_settings',
            'type' => 'select',
            'choices' => array(
                'fade' => 'محو شدن',
                'slide' => 'کشیدن',
                'bounce' => 'پرش',
                'none' => 'بدون انیمیشن'
            )
        ));
        
        $wp_customize->add_setting('enable_menu_icons', array(
            'default' => true,
            'sanitize_callback' => 'wp_validate_boolean'
        ));
        
        $wp_customize->add_control('enable_menu_icons', array(
            'label' => 'نمایش آیکون‌ها در منو',
            'section' => 'menu_settings',
            'type' => 'checkbox'
        ));
        
        // Contact Information - Enhanced
        $wp_customize->add_section('contact_info', array(
            'title' => 'اطلاعات تماس و ارتباطات',
            'priority' => 120,
        ));
        
        $contact_fields = array(
            'phone_number' => array('label' => 'شماره تلفن اصلی', 'default' => '09331663849', 'type' => 'text'),
            'phone_number_2' => array('label' => 'شماره تلفن دوم (اختیاری)', 'default' => '', 'type' => 'text'),
            'email_address' => array('label' => 'آدرس ایمیل اصلی', 'default' => 'setinco@gmail.com', 'type' => 'email'),
            'support_email' => array('label' => 'ایمیل پشتیبانی', 'default' => '', 'type' => 'email'),
            'address' => array('label' => 'آدرس کامل', 'default' => 'ایران، یزد، خیابان مطهری', 'type' => 'textarea'),
            'postal_code' => array('label' => 'کد پستی', 'default' => '', 'type' => 'text'),
            'working_hours' => array('label' => 'ساعات کاری', 'default' => 'شنبه تا پنج‌شنبه: ۸ تا ۲۰', 'type' => 'text'),
            'emergency_phone' => array('label' => 'شماره اضطراری', 'default' => '', 'type' => 'text')
        );
        
        foreach ($contact_fields as $field => $config) {
            $wp_customize->add_setting($field, array(
                'default' => $config['default'],
                'sanitize_callback' => $config['type'] === 'email' ? 'sanitize_email' : 
                                     ($config['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field')
            ));
            
            $wp_customize->add_control($field, array(
                'label' => $config['label'],
                'section' => 'contact_info',
                'type' => $config['type']
            ));
        }
        
        // Social Media - Enhanced
        $wp_customize->add_section('social_media', array(
            'title' => 'شبکه‌های اجتماعی و پیام‌رسان‌ها',
            'priority' => 125,
        ));
        
        $social_networks = array(
    'telegram_url' => array('label' => 'تلگرام', 'icon' => 'fa-brands fa-telegram'),
    'whatsapp_url' => array('label' => 'واتساپ', 'icon' => 'fa-brands fa-whatsapp'),
    'eitaa_url' => array('label' => 'ایتا', 'icon' => 'fa-solid fa-comment'),
    'instagram_url' => array('label' => 'اینستاگرام', 'icon' => 'fa-brands fa-instagram'),
    'linkedin_url' => array('label' => 'لینکدین', 'icon' => 'fa-brands fa-linkedin'),
    'twitter_url' => array('label' => 'توییتر/X', 'icon' => 'fa-brands fa-twitter'),
    'youtube_url' => array('label' => 'یوتیوب', 'icon' => 'fa-brands fa-youtube'),
    'aparat_url' => array('label' => 'آپارات', 'icon' => 'fa-solid fa-play-circle'),
    'rubika_url' => array('label' => 'روبیکا', 'icon' => 'fa-solid fa-comment-dots'),
    'bale_url' => array('label' => 'بله', 'icon' => 'fa-solid fa-comment-alt')
);

        
        foreach ($social_networks as $network => $config) {
            $wp_customize->add_setting($network, array(
                'default' => '',
                'sanitize_callback' => 'esc_url_raw'
            ));
            
            $wp_customize->add_control($network, array(
                'label' => 'لینک ' . $config['label'],
                'section' => 'social_media',
                'type' => 'url'
            ));
        }
        
        // Footer Settings - ENHANCED FOR COMPLETE DYNAMIC MENUS
        $wp_customize->add_section('footer_settings', array(
            'title' => 'تنظیمات فوتر و منوها',
            'priority' => 130,
        ));
        
        $footer_fields = array(
            'footer_layout' => array(
                'label' => 'چیدمان فوتر',
                'default' => '4-columns',
                'type' => 'select',
                'choices' => array(
                    '4-columns' => '۴ ستونه',
                    '3-columns' => '۳ ستونه',
                    '2-columns' => '۲ ستونه',
                    'single-column' => 'تک ستونه'
                )
            ),
            'footer_about_title' => array(
                'label' => 'عنوان بخش درباره ما',
                'default' => 'درباره تزنویسان',
                'type' => 'text'
            ),
            'footer_about_text' => array(
                'label' => 'متن درباره ما',
                'default' => 'تیم متخصص تزنویسان با بیش از ۴۵۰ پژوهشگر و استاد مجرب، آماده ارائه بهترین خدمات در تمامی رشته‌ها و مقاطع تحصیلی با تضمین کیفیت و اصالت است.',
                'type' => 'textarea'
            ),
            'footer_services_title' => array(
                'label' => 'عنوان بخش خدمات فوتر',
                'default' => 'خدمات ما',
                'type' => 'text'
            ),
            'footer_links_title' => array(
                'label' => 'عنوان بخش لینک‌ها',
                'default' => 'لینک‌های مفید',
                'type' => 'text'
            ),
            'footer_contact_title' => array(
                'label' => 'عنوان بخش تماس',
                'default' => 'اطلاع‌رسانی',
                'type' => 'text'
            ),
            'footer_contact_desc' => array(
                'label' => 'توضیحات بخش تماس',
                'default' => 'شماره خود را وارد کنید تا از تخفیف‌ها و اخبار مطلع شوید',
                'type' => 'textarea'
            ),
            'footer_copyright_text' => array(
                'label' => 'متن کپی‌رایت',
                'default' => 'طراحی و توسعه با 💚 توسط تیم تزنویسان',
                'type' => 'text'
            ),
            'footer_show_logo' => array(
                'label' => 'نمایش لوگو در فوتر',
                'default' => true,
                'type' => 'checkbox'
            ),
            'footer_show_social' => array(
                'label' => 'نمایش شبکه‌های اجتماعی',
                'default' => true,
                'type' => 'checkbox'
            ),
            'footer_show_trust_badges' => array(
                'label' => 'نمایش نشان‌های اعتماد',
                'default' => true,
                'type' => 'checkbox'
            )
        );
        
        foreach ($footer_fields as $field => $config) {
            $sanitizer = 'sanitize_text_field';
            if ($config['type'] === 'textarea') $sanitizer = 'sanitize_textarea_field';
            if ($config['type'] === 'checkbox') $sanitizer = 'wp_validate_boolean';
            
            $wp_customize->add_setting($field, array(
                'default' => $config['default'],
                'sanitize_callback' => $sanitizer
            ));
            
            if ($config['type'] === 'select') {
                $wp_customize->add_control($field, array(
                    'label' => $config['label'],
                    'section' => 'footer_settings',
                    'type' => 'select',
                    'choices' => $config['choices']
                ));
            } else {
                $wp_customize->add_control($field, array(
                    'label' => $config['label'],
                    'section' => 'footer_settings',
                    'type' => $config['type']
                ));
            }
        }
        
        // Trust badges - Enhanced
        for ($i = 1; $i <= 6; $i++) {
            $defaults = array(
                1 => array('title' => 'پرداخت امن', 'desc' => 'SSL Certificate', 'icon' => 'fa-solid fa-shield-alt'),
                2 => array('title' => 'مجوز رسمی', 'desc' => 'Licensed Business', 'icon' => 'fa-solid fa-certificate'),
                3 => array('title' => 'تضمین امنیت', 'desc' => 'Security Guaranteed', 'icon' => 'fa-solid fa-shield-check'),
                4 => array('title' => 'جایزه کیفیت', 'desc' => 'Quality Award', 'icon' => 'fa-solid fa-trophy'),
                5 => array('title' => 'پشتیبانی ۲۴/۷', 'desc' => 'Always Available', 'icon' => 'fa-solid fa-headset'),
                6 => array('title' => 'تحویل به موقع', 'desc' => 'On Time Delivery', 'icon' => 'fa-solid fa-clock')
            );
            
            $wp_customize->add_setting('trust_badge_' . $i . '_title', array(
                'default' => $defaults[$i]['title'],
                'sanitize_callback' => 'sanitize_text_field'
            ));
            
            $wp_customize->add_control('trust_badge_' . $i . '_title', array(
                'label' => 'عنوان نشان اعتماد ' . $i,
                'section' => 'footer_settings',
                'type' => 'text'
            ));
            
            $wp_customize->add_setting('trust_badge_' . $i . '_desc', array(
                'default' => $defaults[$i]['desc'],
                'sanitize_callback' => 'sanitize_text_field'
            ));
            
            $wp_customize->add_control('trust_badge_' . $i . '_desc', array(
                'label' => 'توضیح نشان اعتماد ' . $i,
                'section' => 'footer_settings',
                'type' => 'text'
            ));
            
            $wp_customize->add_setting('trust_badge_' . $i . '_icon', array(
                'default' => $defaults[$i]['icon'],
                'sanitize_callback' => 'sanitize_text_field'
            ));
            
            $wp_customize->add_control('trust_badge_' . $i . '_icon', array(
                'label' => 'آیکون نشان اعتماد ' . $i,
                'section' => 'footer_settings',
                'type' => 'text',
                'description' => 'کلاس FontAwesome مثال: fa-solid fa-shield-alt'
            ));
        }
        
        // Newsletter Settings - Enhanced
        $wp_customize->add_section('newsletter_settings', array(
            'title' => 'تنظیمات خبرنامه و اطلاع‌رسانی',
            'priority' => 135,
        ));
        
        $newsletter_fields = array(
            'newsletter_title' => array('label' => 'عنوان خبرنامه', 'default' => 'از آخرین اخبار و تخفیف‌ها باخبر شوید'),
            'newsletter_subtitle' => array('label' => 'زیرنویس خبرنامه', 'default' => 'شماره تماس خود را وارد کنید'),
            'newsletter_subscribers' => array('label' => 'تعداد مشترکین', 'default' => '۱۰,۰۰۰+'),
            'newsletter_satisfaction' => array('label' => 'درصد رضایت', 'default' => '۹۸%'),
            'newsletter_privacy_text' => array('label' => 'متن حریم خصوصی', 'default' => 'اطلاعات شما محفوظ است و به اشتراک گذاشته نمی‌شود'),
            'newsletter_benefits' => array('label' => 'مزایای عضویت', 'default' => 'تخفیف‌های ویژه، اطلاع از آخرین مقالات، مشاوره رایگان'),
            'enable_newsletter_popup' => array('label' => 'فعال‌سازی پاپ‌آپ خبرنامه', 'default' => false, 'type' => 'checkbox'),
            'newsletter_popup_delay' => array('label' => 'تأخیر پاپ‌آپ (ثانیه)', 'default' => '30', 'type' => 'number')
        );
        
        foreach ($newsletter_fields as $field => $config) {
            $sanitizer = 'sanitize_text_field';
            if (isset($config['type']) && $config['type'] === 'checkbox') $sanitizer = 'wp_validate_boolean';
            
            $wp_customize->add_setting($field, array(
                'default' => $config['default'],
                'sanitize_callback' => $sanitizer
            ));
            
            $wp_customize->add_control($field, array(
                'label' => $config['label'],
                'section' => 'newsletter_settings',
                'type' => $config['type'] ?? 'text'
            ));
        }
        
        // Performance Settings
        $wp_customize->add_section('performance_settings', array(
            'title' => 'تنظیمات عملکرد',
            'priority' => 140,
        ));
        
        $performance_fields = array(
            'enable_lazy_loading' => array('label' => 'بارگذاری تنبل تصاویر', 'default' => true, 'type' => 'checkbox'),
            'enable_image_optimization' => array('label' => 'بهینه‌سازی تصاویر', 'default' => true, 'type' => 'checkbox'),
            'enable_css_minification' => array('label' => 'فشرده‌سازی CSS', 'default' => false, 'type' => 'checkbox'),
            'enable_js_minification' => array('label' => 'فشرده‌سازی JavaScript', 'default' => false, 'type' => 'checkbox'),
            'enable_caching' => array('label' => 'فعال‌سازی کش', 'default' => true, 'type' => 'checkbox'),
            'cache_duration' => array('label' => 'مدت کش (ساعت)', 'default' => '24', 'type' => 'number')
        );
        
        foreach ($performance_fields as $field => $config) {
            $sanitizer = $config['type'] === 'checkbox' ? 'wp_validate_boolean' : 'sanitize_text_field';
            
            $wp_customize->add_setting($field, array(
                'default' => $config['default'],
                'sanitize_callback' => $sanitizer
            ));
            
            $wp_customize->add_control($field, array(
                'label' => $config['label'],
                'section' => 'performance_settings',
                'type' => $config['type']
            ));
        }
        
        // Security Settings
        $wp_customize->add_section('security_settings', array(
            'title' => 'تنظیمات امنیتی',
            'priority' => 145,
        ));
        
        $security_fields = array(
            'enable_security_headers' => array('label' => 'فعال‌سازی هدرهای امنیتی', 'default' => true, 'type' => 'checkbox'),
            'enable_brute_force_protection' => array('label' => 'محافظت در برابر حمله Brute Force', 'default' => true, 'type' => 'checkbox'),
            'enable_ip_blocking' => array('label' => 'فعال‌سازی مسدودسازی IP', 'default' => false, 'type' => 'checkbox'),
            'security_email' => array('label' => 'ایمیل هشدارهای امنیتی', 'default' => '', 'type' => 'email'),
            'enable_login_alerts' => array('label' => 'هشدار ورود مشکوک', 'default' => true, 'type' => 'checkbox')
        );
        
        foreach ($security_fields as $field => $config) {
            $sanitizer = $config['type'] === 'checkbox' ? 'wp_validate_boolean' : 
                        ($config['type'] === 'email' ? 'sanitize_email' : 'sanitize_text_field');
            
            $wp_customize->add_setting($field, array(
                'default' => $config['default'],
                'sanitize_callback' => $sanitizer
            ));
            
            if ($config['type'] === 'select') {
                $wp_customize->add_control($field, array(
                    'label' => $config['label'],
                    'section' => 'security_settings',
                    'type' => 'select',
                    'choices' => $config['choices']
                ));
            } else {
                $wp_customize->add_control($field, array(
                    'label' => $config['label'],
                    'section' => 'security_settings',
                    'type' => $config['type']
                ));
            }
        }
    }
    
    /**
     * Enhanced Security Headers
     */
    public function add_security_headers() {
        if (!headers_sent() && !is_admin()) {
            ?>
            <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
            <meta name="googlebot" content="index, follow">
            <meta name="format-detection" content="telephone=no">
            <meta name="theme-color" content="#1FA547">
            <meta name="msapplication-TileColor" content="#1FA547">
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
            <?php
        }
    }
    
    /**
     * Handle Contact Form - Enhanced
     */
    public function handle_contact_form() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی - نشست منقضی شده است');
        }
        
        // Rate limiting
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $rate_limit_key = 'contact_form_' . md5($user_ip);
        $rate_limit = get_transient($rate_limit_key);
        
        if ($rate_limit && $rate_limit >= 3) {
            wp_send_json_error('تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً ۱۰ دقیقه صبر کنید.');
        }
        
        // Sanitize and validate data
        $data = array(
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'subject' => sanitize_text_field($_POST['subject'] ?? 'پیام از سایت'),
            'message' => sanitize_textarea_field($_POST['message'] ?? ''),
            'service_id' => absint($_POST['service_id'] ?? 0),
            'form_type' => sanitize_text_field($_POST['form_type'] ?? 'general')
        );
        
        // Validation
        $errors = array();
        
        if (empty($data['name'])) {
            $errors[] = 'نام الزامی است';
        }
        
        if (empty($data['email']) || !is_email($data['email'])) {
            $errors[] = 'آدرس ایمیل معتبر الزامی است';
        }
        
        if (empty($data['message'])) {
            $errors[] = 'متن پیام الزامی است';
        }
        
        if (!empty($data['phone']) && !preg_match('/^(\+98|0)?9\d{9}$/', $data['phone'])) {
            $errors[] = 'شماره تماس معتبر نیست';
        }
        
        if (!empty($errors)) {
            wp_send_json_error(implode(', ', $errors));
        }
        
        // Create email content
        $admin_email = get_option('admin_email');
        $subject = 'پیام جدید از سایت ' . get_bloginfo('name') . ' - ' . $data['subject'];
        
        $email_content = $this->create_email_template($data);
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>',
            'Reply-To: ' . $data['email']
        );
        
        // Send email
        $sent = wp_mail($admin_email, $subject, $email_content, $headers);
        
        // Send auto-reply if enabled
        if ($sent && get_theme_mod('form_auto_reply', true)) {
            $auto_reply_subject = 'تایید دریافت پیام - ' . get_bloginfo('name');
            $auto_reply_message = get_theme_mod('auto_reply_message', 
                'با تشکر از تماس شما. پیام شما دریافت شد و به زودی کارشناسان ما با شما تماس خواهند گرفت.');
            
            wp_mail($data['email'], $auto_reply_subject, $auto_reply_message, $headers);
        }
        
        if ($sent) {
            // Update rate limiting
            $current_count = $rate_limit ?: 0;
            set_transient($rate_limit_key, $current_count + 1, 600); // 10 minutes
            
            // Log successful submission
            $this->log_form_submission($data, 'contact_form');
            
            wp_send_json_success('پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.');
        } else {
            wp_send_json_error('خطا در ارسال پیام. لطفاً مجدداً تلاش کنید یا با شماره تلفن تماس بگیرید.');
        }
    }
    
    /**
     * Handle Newsletter Signup - Enhanced
     */
    public function handle_newsletter_signup() {
        if (!wp_verify_nonce($_POST['nonce'], 'teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        // Rate limiting
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $rate_limit_key = 'newsletter_' . md5($user_ip);
        $rate_limit = get_transient($rate_limit_key);
        
        if ($rate_limit && $rate_limit >= 5) {
            wp_send_json_error('تعداد درخواست‌های شما بیش از حد مجاز است.');
        }
        
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $name = sanitize_text_field($_POST['name'] ?? '');
        
        if (empty($phone) && empty($email)) {
            wp_send_json_error('شماره تماس یا ایمیل الزامی است');
        }
        
        if (!empty($phone) && !preg_match('/^(\+98|0)?9\d{9}$/', $phone)) {
            wp_send_json_error('شماره تماس معتبر نیست');
        }
        
        if (!empty($email) && !is_email($email)) {
            wp_send_json_error('آدرس ایمیل معتبر نیست');
        }
        
        // Get current subscribers
        $phone_subscribers = get_option('teznevisan_newsletter_phones', array());
        $email_subscribers = get_option('teznevisan_newsletter_emails', array());
        
        $added = false;
        
        if (!empty($phone) && !in_array($phone, $phone_subscribers)) {
            $phone_subscribers[] = $phone;
            update_option('teznevisan_newsletter_phones', $phone_subscribers);
            $added = true;
        }
        
        if (!empty($email) && !in_array($email, $email_subscribers)) {
            $email_subscribers[] = $email;
            update_option('teznevisan_newsletter_emails', $email_subscribers);
            $added = true;
        }
        
        if ($added) {
            // Update rate limiting
            $current_count = $rate_limit ?: 0;
            set_transient($rate_limit_key, $current_count + 1, 300); // 5 minutes
            
            // Log successful subscription
            $this->log_form_submission(array(
                'phone' => $phone,
                'email' => $email,
                'name' => $name
            ), 'newsletter_signup');
            
            wp_send_json_success(array(
                'message' => 'شماره/ایمیل شما در لیست اطلاع‌رسانی ثبت شد',
                'total_subscribers' => count($phone_subscribers) + count($email_subscribers)
            ));
        } else {
            wp_send_json_error('این شماره/ایمیل قبلاً در لیست ثبت شده است');
        }
    }
    
    /**
     * Handle Mobile Order - Enhanced
     */
    public function handle_mobile_order() {
        if (!wp_verify_nonce($_POST['nonce'], 'teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        // Rate limiting
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $rate_limit_key = 'mobile_order_' . md5($user_ip);
        $rate_limit = get_transient($rate_limit_key);
        
        if ($rate_limit && $rate_limit >= 2) {
            wp_send_json_error('تعداد سفارش‌های شما بیش از حد مجاز است. لطفاً ۳۰ دقیقه صبر کنید.');
        }
        
        $data = array(
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'major' => sanitize_text_field($_POST['major'] ?? ''),
            'degree' => sanitize_text_field($_POST['degree'] ?? ''),
            'urgency' => sanitize_text_field($_POST['urgency'] ?? 'normal'),
            'description' => sanitize_textarea_field($_POST['description'] ?? '')
        );
        
        // Validation
        if (empty($data['name']) || empty($data['phone']) || empty($data['major'])) {
            wp_send_json_error('لطفاً تمام فیلدهای ضروری را تکمیل کنید');
        }
        
        if (!preg_match('/^(\+98|0)?9\d{9}$/', $data['phone'])) {
            wp_send_json_error('شماره تماس معتبر نیست');
        }
        
        // Add metadata
        $data['type'] = 'mobile_order';
        $data['date'] = current_time('mysql');
        $data['ip'] = $user_ip;
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $data['referer'] = $_SERVER['HTTP_REFERER'] ?? '';
        
        // Create inquiry post
        $inquiry_id = wp_insert_post(array(
            'post_title' => sprintf('سفارش موبایل: %s - %s', $data['name'], $data['major']),
            'post_content' => wp_json_encode($data, JSON_UNESCAPED_UNICODE),
            'post_status' => 'private',
            'post_type' => 'service_inquiry',
            'meta_input' => array(
                'inquiry_type' => 'mobile_order',
                'customer_name' => $data['name'],
                'customer_phone' => $data['phone'],
                'urgency_level' => $data['urgency'],
                'submission_ip' => $user_ip,
                'submission_date' => current_time('mysql')
            )
        ));
        
        if ($inquiry_id) {
            // Update rate limiting
            $current_count = $rate_limit ?: 0;
            set_transient($rate_limit_key, $current_count + 1, 1800); // 30 minutes
            
            // Send notification email to admin
            $this->send_admin_notification($data, 'mobile_order', $inquiry_id);
            
            wp_send_json_success(array(
                'message' => 'درخواست شما با شماره پیگیری #' . $inquiry_id . ' ثبت شد! به زودی کارشناسان ما با شما تماس خواهند گرفت.',
                'tracking_id' => $inquiry_id
            ));
        } else {
            wp_send_json_error('خطا در ثبت درخواست. لطفاً مجدداً تلاش کنید.');
        }
    }
    
    /**
     * Handle Service Inquiry - Enhanced
     */
    public function handle_service_inquiry() {
        if (!wp_verify_nonce($_POST['nonce'], 'teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        $required_fields = array('service_id', 'name', 'phone', 'email');
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                wp_send_json_error('لطفاً تمام فیلدهای ضروری را تکمیل کنید: ' . $field);
            }
        }
        
        $service_id = absint($_POST['service_id']);
        $service_post = get_post($service_id);
        
        if (!$service_post || $service_post->post_type !== 'services') {
            wp_send_json_error('خدمت انتخابی معتبر نیست');
        }
        
        $inquiry_data = array(
            'service_id' => $service_id,
            'service_name' => get_the_title($service_id),
            'name' => sanitize_text_field($_POST['name']),
            'phone' => sanitize_text_field($_POST['phone']),
            'email' => sanitize_email($_POST['email']),
            'field' => sanitize_text_field($_POST['field'] ?? ''),
            'degree' => sanitize_text_field($_POST['degree'] ?? ''),
            'university' => sanitize_text_field($_POST['university'] ?? ''),
            'urgency' => sanitize_text_field($_POST['urgency'] ?? 'normal'),
            'budget' => sanitize_text_field($_POST['budget'] ?? ''),
            'deadline' => sanitize_text_field($_POST['deadline'] ?? ''),
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'additional_info' => sanitize_textarea_field($_POST['additional_info'] ?? ''),
            'preferred_contact' => sanitize_text_field($_POST['preferred_contact'] ?? 'phone'),
            'date' => current_time('mysql'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        );
        
        // Advanced validation
        if (!preg_match('/^(\+98|0)?9\d{9}$/', $inquiry_data['phone'])) {
            wp_send_json_error('شماره تماس معتبر نیست');
        }
        
        if (!is_email($inquiry_data['email'])) {
            wp_send_json_error('آدرس ایمیل معتبر نیست');
        }
        
        // Check for duplicate submissions
        $existing_inquiry = get_posts(array(
            'post_type' => 'service_inquiry',
            'meta_query' => array(
                array(
                    'key' => 'customer_phone',
                    'value' => $inquiry_data['phone'],
                    'compare' => '='
                ),
                array(
                    'key' => 'service_id',
                    'value' => $service_id,
                    'compare' => '='
                )
            ),
            'date_query' => array(
                array(
                    'after' => '24 hours ago'
                )
            ),
            'posts_per_page' => 1
        ));
        
        if (!empty($existing_inquiry)) {
            wp_send_json_error('شما قبلاً برای این خدمت درخواست ارسال کرده‌اید. کارشناسان ما به زودی با شما تماس خواهند گرفت.');
        }
        
        // Create inquiry post
        $inquiry_id = wp_insert_post(array(
            'post_title' => sprintf('درخواست خدمت: %s - %s', $inquiry_data['name'], $inquiry_data['service_name']),
            'post_content' => wp_json_encode($inquiry_data, JSON_UNESCAPED_UNICODE),
            'post_status' => 'private',
            'post_type' => 'service_inquiry',
            'meta_input' => array(
                'inquiry_type' => 'service_inquiry',
                'service_id' => $service_id,
                'customer_name' => $inquiry_data['name'],
                'customer_phone' => $inquiry_data['phone'],
                'customer_email' => $inquiry_data['email'],
                'urgency_level' => $inquiry_data['urgency'],
                'submission_ip' => $inquiry_data['ip'],
                'submission_date' => $inquiry_data['date'],
                'inquiry_status' => 'new'
            )
        ));
        
        if ($inquiry_id) {
            // Send notification to admin
            $this->send_admin_notification($inquiry_data, 'service_inquiry', $inquiry_id);
            
            // Send confirmation to customer
            $this->send_customer_confirmation($inquiry_data, $inquiry_id);
            
            wp_send_json_success(array(
                'message' => 'درخواست شما با شماره پیگیری #' . $inquiry_id . ' ثبت شد! کارشناسان ما طی ۲ ساعت آینده با شما تماس خواهند گرفت.',
                'tracking_id' => $inquiry_id,
                'estimated_response_time' => '۲ ساعت'
            ));
        } else {
            wp_send_json_error('خطا در ثبت درخواست. لطفاً مجدداً تلاش کنید.');
        }
    }

    /**
     * Handle Post Reaction (Like/Dislike) - Enhanced
     */
    public function handle_post_reaction() {
        if (!wp_verify_nonce($_POST['nonce'], 'teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        $post_id = absint($_POST['post_id']);
        $action = sanitize_text_field($_POST['action_type']);
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        if (!$post_id || !in_array($action, array('like', 'dislike'))) {
            wp_send_json_error('درخواست نامعتبر');
        }
        
        // Get current reactions
        $likes = get_post_meta($post_id, 'post_likes', true) ?: 0;
        $dislikes = get_post_meta($post_id, 'post_dislikes', true) ?: 0;
        $user_reactions = get_post_meta($post_id, 'user_reactions', true) ?: array();
        
        // Check if user already reacted
        $user_previous_action = isset($user_reactions[$user_ip]) ? $user_reactions[$user_ip] : null;
        
        // Remove previous reaction if exists
        if ($user_previous_action) {
            if ($user_previous_action === 'like') {
                $likes = max(0, $likes - 1);
            } else {
                $dislikes = max(0, $dislikes - 1);
            }
        }
        
        // Add new reaction if different from previous
        if ($user_previous_action !== $action) {
            if ($action === 'like') {
                $likes++;
            } else {
                $dislikes++;
            }
            $user_reactions[$user_ip] = $action;
        } else {
            // Remove reaction if same as previous (toggle)
            unset($user_reactions[$user_ip]);
        }
        
        // Update database
        update_post_meta($post_id, 'post_likes', $likes);
        update_post_meta($post_id, 'post_dislikes', $dislikes);
        update_post_meta($post_id, 'user_reactions', $user_reactions);
        
        // Update aggregate rating for schema
        $total_reactions = $likes + $dislikes;
        if ($total_reactions > 0) {
            $rating = ($likes / $total_reactions) * 5;
            update_post_meta($post_id, 'post_rating_average', $rating);
            update_post_meta($post_id, 'post_rating_count', $total_reactions);
        }
        
        wp_send_json_success(array(
            'likes' => $likes,
            'dislikes' => $dislikes,
            'user_action' => isset($user_reactions[$user_ip]) ? $user_reactions[$user_ip] : null,
            'total_reactions' => $total_reactions
        ));
    }
    
    /**
     * Handle Redirects - Enhanced
     */
    public function handle_redirects() {
        // Redirect author pages to about page
        if (is_author()) {
            wp_safe_redirect(home_url('/about'), 301);
            exit;
        }
        
        // Handle old permalink structure
        $request_uri = $_SERVER['REQUEST_URI'];
        if (strpos($request_uri, '/بایگانی/') !== false) {
            $new_url = str_replace('/بایگانی/', '/', $request_uri);
            wp_safe_redirect(home_url($new_url), 301);
            exit;
        }
        
        // Redirect empty search results to search page
        if (is_search() && !have_posts()) {
            $search_term = get_search_query();
            if (empty($search_term)) {
                wp_safe_redirect(home_url('/'), 302);
                exit;
            }
        }
        
        // Handle 404 intelligent redirects
        if (is_404()) {
            $request_uri = trim($_SERVER['REQUEST_URI'], '/');
            
            // Try to find similar pages
            $similar_pages = get_posts(array(
                'post_type' => array('page', 'services'),
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => '_wp_old_slug',
                        'value' => $request_uri,
                        'compare' => '='
                    )
                )
            ));
            
            if ($similar_pages) {
                wp_safe_redirect(get_permalink($similar_pages[0]), 301);
                exit;
            }
        }
    }
    

    /**
     * Generate Service Schema
     */
    private function generate_service_schema() {
        global $post;
        if (!$post || $post->post_type !== 'services') return null;
        
        $price_min = get_post_meta($post->ID, 'price_range_min', true);
        $price_max = get_post_meta($post->ID, 'price_range_max', true);
        $service_excerpt = get_post_meta($post->ID, 'service_excerpt', true);
        $delivery_time = get_post_meta($post->ID, 'delivery_time', true);
        $satisfaction_rate = get_post_meta($post->ID, 'satisfaction_rate', true);
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => get_the_title(),
            'description' => $service_excerpt ?: wp_trim_words(get_the_content(), 30),
            'provider' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url(),
                'telephone' => get_theme_mod('phone_number', '09331663849'),
                'email' => get_theme_mod('email_address', 'setinco@gmail.com'),
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => get_theme_mod('address', 'ایران، یزد، خیابان مطهری'),
                    'addressCountry' => 'IR'
                )
            ),
            'serviceType' => get_the_title(),
            'areaServed' => array(
                '@type' => 'Country',
                'name' => 'ایران'
            ),
            'availableChannel' => array(
                array(
                    '@type' => 'ServiceChannel',
                    'servicePhone' => get_theme_mod('phone_number', '09331663849'),
                    'serviceUrl' => get_permalink()
                )
            ),
            'category' => 'Academic Writing Services',
            'audience' => array(
                '@type' => 'Audience',
                'audienceType' => 'University Students'
            )
        );
        
        if ($price_min && $price_max) {
            $schema['offers'] = array(
                '@type' => 'Offer',
                'priceRange' => number_format((int)$price_min) . '-' . number_format((int)$price_max) . ' تومان',
                'priceCurrency' => 'IRR',
                'availability' => 'InStock',
                'validFrom' => date('c'),
                'category' => 'Academic Services'
            );
        }
        
        if ($delivery_time) {
            $schema['serviceOutput'] = array(
                '@type' => 'Thing',
                'name' => 'Academic Document',
                'description' => 'زمان تحویل: ' . $delivery_time
            );
        }
        
        // Add reviews if available
        $reviews = $this->get_service_reviews($post->ID);
        if ($reviews) {
            $schema['review'] = $reviews;
        }
        
        return $schema;
    }

    /**
     * Generate Breadcrumb Schema
     */
    private function generate_breadcrumb_schema() {
        $items = array(
            array(
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'خانه',
                'item' => home_url()
            )
        );
        
        $position = 2;
        
        if (is_category()) {
            $category = get_queried_object();
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $category->name,
                'item' => get_category_link($category->term_id)
            );
        } elseif (is_single()) {
            $post_type = get_post_type();
            
            if ($post_type === 'services') {
                $items[] = array(
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => 'خدمات',
                    'item' => get_post_type_archive_link('services')
                );
            } elseif ($post_type === 'post') {
                $categories = get_the_category();
                if ($categories) {
                    $category = $categories[0];
                    $items[] = array(
                        '@type' => 'ListItem',
                        'position' => $position++,
                        'name' => $category->name,
                        'item' => get_category_link($category->term_id)
                    );
                }
            }
            
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => get_the_title(),
                'item' => get_permalink()
            );
        } elseif (is_page()) {
            $ancestors = get_post_ancestors(get_the_ID());
            $ancestors = array_reverse($ancestors);
            
            foreach ($ancestors as $ancestor) {
                $items[] = array(
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => get_the_title($ancestor),
                    'item' => get_permalink($ancestor)
                );
            }
            
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => get_the_title(),
                'item' => get_permalink()
            );
        }
        
        return array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        );
    }

    /**
     * Track Post Views - Enhanced
     */
    public function track_post_views() {
        if (is_single() && !is_admin() && !wp_is_mobile()) {
            $post_id = get_the_ID();
            if ($post_id) {
                $views = get_post_meta($post_id, 'post_views', true) ?: 0;
                $mobile_views = get_post_meta($post_id, 'post_mobile_views', true) ?: 0;
                $unique_views = get_post_meta($post_id, 'post_unique_views', true) ?: array();
                
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $view_key = md5($user_ip . date('Y-m-d'));
                
                // Track total views
                update_post_meta($post_id, 'post_views', intval($views) + 1);
                
                // Track mobile views
                if (wp_is_mobile()) {
                    update_post_meta($post_id, 'post_mobile_views', intval($mobile_views) + 1);
                }
                
                // Track unique views (per IP per day)
                if (!in_array($view_key, $unique_views)) {
                    $unique_views[] = $view_key;
                    // Keep only last 30 days
                    $unique_views = array_slice($unique_views, -30);
                    update_post_meta($post_id, 'post_unique_views', $unique_views);
                }
                
                // Track reading behavior
                $this->track_reading_behavior($post_id);
            }
        }
    }

    /**
     * Track Reading Behavior
     */
    private function track_reading_behavior($post_id) {
        $behavior_data = get_post_meta($post_id, 'reading_behavior', true) ?: array(
            'average_time' => 0,
            'bounce_rate' => 0,
            'completion_rate' => 0,
            'total_sessions' => 0
        );
        
        // This would be enhanced with JavaScript tracking
        $behavior_data['total_sessions']++;
        update_post_meta($post_id, 'reading_behavior', $behavior_data);
    }
    
    /**
     * Render Floating Widgets - DESKTOP ONLY CHATY
     */

    public function render_floating_contact_widget(): void
{
    $contacts = array(
        'whatsapp' => array(
            'url' => 'https://wa.me/' . get_theme_mod('whatsapp_number', '989331663849'),
            'icon' => 'fa-brands fa-whatsapp',
            'label' => 'واتساپ',
            'color' => '#25D366'
        ),
        'telegram' => array(
            'url' => 'https://t.me/' . get_theme_mod('telegram_username', 'teznevisan'),
            'icon' => 'fa-brands fa-telegram',
            'label' => 'تلگرام',
            'color' => '#0088cc'
        ),
        'phone' => array(
            'url' => 'tel:' . get_theme_mod('phone_number', '+989331663849'),
            'icon' => 'fa-solid fa-phone',
            'label' => 'تماس تلفنی',
            'color' => '#4CAF50'
        ),
        'email' => array(
            'url' => 'mailto:' . get_theme_mod('email_address', 'teznevisan@gmail.com'),
            'icon' => 'fa-solid fa-envelope',
            'label' => 'ایمیل',
            'color' => '#ff5722'
        )
    );
    
    ?>
    <div id="floating-contact-widget" class="floating-contact-widget" role="complementary" aria-label="راه‌های تماس">
        <div class="contact-toggle" id="contact-toggle" role="button" aria-label="نمایش راه‌های تماس" aria-expanded="false" tabindex="0">
            <i class="fa-solid fa-comments contact-main-icon" aria-hidden="true"></i>
            <span class="contact-toggle-text">تماس با ما</span>
        </div>
        
        <div class="contact-channels" id="contact-channels" aria-hidden="true">
            <?php foreach ($contacts as $key => $contact) : ?>
                <a href="<?php echo esc_url($contact['url']); ?>" 
                   class="contact-channel" 
                   data-channel="<?php echo esc_attr($key); ?>"
                   style="background-color: <?php echo esc_attr($contact['color']); ?>"
                   target="<?php echo $key === 'email' ? '_self' : '_blank'; ?>"
                   rel="<?php echo $key !== 'email' ? 'noopener' : ''; ?>"
                   aria-label="<?php echo esc_attr($contact['label']); ?>">
                    <div class="channel-icon">
                        <i class="<?php echo esc_attr($contact['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <div class="channel-label">
                        <span class="channel-name"><?php echo esc_html($contact['label']); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="contact-backdrop" id="contact-backdrop"></div>
    </div>
    
    <style>
    /* Floating Contact Widget - Complete with Labels */
    .floating-contact-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9990;
        font-family: 'IRANSans', -apple-system, BlinkMacSystemFont, sans-serif;
        direction: rtl;
    }
    
    .contact-toggle {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #1FA547, #2FD65A);
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(31, 165, 71, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        outline: none;
        position: relative;
        overflow: hidden;
    }
    
    .contact-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(31, 165, 71, 0.5);
    }
    
    .contact-toggle:focus {
        outline: 3px solid #FFD700;
        outline-offset: 3px;
    }
    
    .contact-main-icon {
        font-size: 24px;
        color: white;
        transition: transform 0.3s ease;
        font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", "Font Awesome 7 Free" !important;
    }
    
    .contact-toggle.active .contact-main-icon {
        transform: rotate(180deg);
    }
    
    .contact-toggle-text {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 10px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
    }
    
    .contact-toggle:hover .contact-toggle-text {
        opacity: 1;
        visibility: visible;
        bottom: -30px;
    }
    
    .contact-channels {
        position: absolute;
        bottom: 70px;
        right: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px) scale(0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }
    
    .contact-channels.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
        pointer-events: all;
    }
    
    .contact-channel {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: #25D366;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 150px;
        transform: translateX(20px);
        opacity: 0;
        animation: slideInRight 0.4s ease forwards;
    }
    
    .contact-channel:hover {
        transform: translateX(-5px) translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .contact-channel:focus {
        outline: 2px solid #FFD700;
        outline-offset: 2px;
    }
    
    /* Staggered animation delays */
    .contact-channel:nth-child(1) { animation-delay: 0.1s; }
    .contact-channel:nth-child(2) { animation-delay: 0.2s; }
    .contact-channel:nth-child(3) { animation-delay: 0.3s; }
    .contact-channel:nth-child(4) { animation-delay: 0.4s; }
    
    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .channel-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .channel-icon i {
        font-size: 18px;
        font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", "Font Awesome 7 Free" !important;
    }
    
    .channel-label {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    
    .channel-name {
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
        font-family: 'IRANSans', sans-serif;
    }
    
    .contact-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: -1;
    }
    
    .contact-backdrop.active {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }
    
    /* Channel-specific colors */
    .contact-channel[data-channel="whatsapp"] { background-color: #25D366; }
    .contact-channel[data-channel="telegram"] { background-color: #0088cc; }
    .contact-channel[data-channel="phone"] { background-color: #4CAF50; }
    .contact-channel[data-channel="email"] { background-color: #ff5722; }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .floating-contact-widget {
            bottom: 15px;
            right: 15px;
        }
        
        .contact-toggle {
            width: 55px;
            height: 55px;
        }
        
        .contact-main-icon {
            font-size: 22px;
        }
        
        .contact-channel {
            min-width: 130px;
            padding: 10px 14px;
        }
        
        .channel-name {
            font-size: 13px;
        }
    }
    
    /* RTL support */
    [dir="rtl"] .floating-contact-widget {
        right: auto;
        left: 20px;
    }
    
    [dir="rtl"] .contact-channels {
        right: auto;
        left: 0;
    }
    
    [dir="rtl"] .contact-channel {
        transform: translateX(-20px);
    }
    
    [dir="rtl"] .contact-channel:hover {
        transform: translateX(5px) translateY(-2px);
    }
    
    @media (max-width: 768px) and (orientation: landscape) {
        .floating-contact-widget {
            bottom: 10px;
            right: 10px;
        }
    }
    
    /* Accessibility improvements */
    @media (prefers-reduced-motion: reduce) {
        .contact-toggle,
        .contact-channel,
        .contact-channels,
        .contact-backdrop {
            transition: none;
            animation: none;
        }
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const widget = document.getElementById('floating-contact-widget');
        const toggle = document.getElementById('contact-toggle');
        const channels = document.getElementById('contact-channels');
        const backdrop = document.getElementById('contact-backdrop');
        
        let isOpen = false;
        
        function openWidget() {
            isOpen = true;
            toggle.classList.add('active');
            toggle.setAttribute('aria-expanded', 'true');
            channels.classList.add('active');
            channels.setAttribute('aria-hidden', 'false');
            backdrop.classList.add('active');
            
            // Focus first channel
            const firstChannel = channels.querySelector('.contact-channel');
            if (firstChannel) firstChannel.focus();
        }
        
        function closeWidget() {
            isOpen = false;
            toggle.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
            channels.classList.remove('active');
            channels.setAttribute('aria-hidden', 'true');
            backdrop.classList.remove('active');
            
            toggle.focus();
        }
        
        function toggleWidget() {
            if (isOpen) {
                closeWidget();
            } else {
                openWidget();
            }
        }
        
        // Toggle on click
        toggle.addEventListener('click', toggleWidget);
        
        // Toggle on Enter/Space
        toggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleWidget();
            }
        });
        
        // Close on backdrop click
        backdrop.addEventListener('click', closeWidget);
        
        // Close on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                closeWidget();
            }
        });
        
        // Keyboard navigation within channels
        channels.addEventListener('keydown', function(e) {
            const channelLinks = channels.querySelectorAll('.contact-channel');
            const currentIndex = Array.from(channelLinks).indexOf(document.activeElement);
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = (currentIndex + 1) % channelLinks.length;
                channelLinks[nextIndex].focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevIndex = currentIndex - 1 < 0 ? channelLinks.length - 1 : currentIndex - 1;
                channelLinks[prevIndex].focus();
            }
        });
        
        // Track clicks for analytics
        channels.addEventListener('click', function(e) {
            const channel = e.target.closest('.contact-channel');
            if (channel) {
                const channelType = channel.getAttribute('data-channel');
                console.log('Contact channel clicked:', channelType);
                
                // Optional: Send to Google Analytics
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'contact_click', {
                        'contact_method': channelType,
                        'event_category': 'engagement'
                    });
                }
            }
        });
    });
    </script>
    <?php
}

public function render_floating_widgets(): void
{
    if (is_admin()) {
        return;
    }
    
    // Render the floating contact widget
    $this->render_floating_contact_widget();
}


    /**
     * Check if device is tablet
     */
    private function is_tablet() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $user_agent);
    }

     /**
     * Render Mobile Bottom Navigation - Enhanced
     */
    private function render_mobile_bottom_nav() {
        $nav_items = array(
            'home' => array(
                'icon' => 'fa-solid fa-home',
                'label' => 'خانه',
                'url' => home_url('/'),
                'active' => is_front_page()
            ),
            'services' => array(
                'icon' => 'fa-solid fa-tools',
                'label' => 'خدمات', 
                'url' => get_post_type_archive_link('services'),
                'active' => is_post_type_archive('services') || is_singular('services')
            ),
            'call' => array(
                'icon' => 'fa-solid fa-phone',
                'label' => 'تماس',
                'url' => 'tel:' . get_theme_mod('phone_number', '09331663849'),
                'active' => false,
                'special' => true
            ),
            'order' => array(
                'icon' => 'fa-solid fa-shopping-cart',
                'label' => 'سفارش',
                'url' => '#',
                'active' => false,
                'action' => 'mobile-order',
                'special' => true
            ),
            'whatsapp' => array(
                'icon' => 'fa-brands fa-whatsappp',
                'label' => 'واتساپ',
                'url' => 'https://wa.me/' . str_replace(['+', ' ', '-'], '', get_theme_mod('phone_number', '09331663849')),
                'active' => false
            )
        );
        
        ?>
        <div class="mobile-bottom-nav-enhanced" id="mobile-bottom-nav">
            <div class="bottom-nav-container">
                <div class="bottom-nav-items">
                    <?php foreach ($nav_items as $item_key => $item) : ?>
                        <<?php echo !empty($item['action']) ? 'button' : 'a'; ?> 
                            <?php if (empty($item['action'])) : ?>
                                href="<?php echo esc_url($item['url']); ?>"
                                <?php if (strpos($item['url'], 'wa.me') !== false) echo 'target="_blank" rel="noopener"'; ?>
                            <?php else : ?>
                                id="<?php echo esc_attr($item['action']); ?>-btn"
                            <?php endif; ?>
                            class="nav-item <?php echo esc_attr($item_key); ?>-item <?php echo !empty($item['active']) ? 'active' : ''; ?> <?php echo !empty($item['special']) ? 'special-item' : ''; ?>">
                            
                            <div class="nav-icon">
                                <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                                <?php if ($item_key === 'order') : ?>
                                    <div class="order-pulse"></div>
                                <?php endif; ?>
                                <?php if (!empty($item['active'])) : ?>
                                    <div class="active-indicator"></div>
                                <?php endif; ?>
                            </div>
                            <span class="nav-label"><?php echo esc_html($item['label']); ?></span>
                            
                        </<?php echo !empty($item['action']) ? 'button' : 'a'; ?>>
                    <?php endforeach; ?>
                </div>
                
                <div class="nav-background-blur"></div>
            </div>
        </div>

        <!-- Enhanced Mobile Order Modal -->
        <div class="mobile-order-modal-enhanced" id="mobile-order-modal">
            <div class="modal-backdrop"></div>
            <div class="modal-container">
                <div class="modal-header">
                    <div class="modal-title">
                        <i class="fa-solid fa-rocket"></i>
                        <h3>ثبت سفارش سریع</h3>
                    </div>
                    <button class="modal-close" id="mobile-modal-close">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form class="mobile-order-form-enhanced" id="mobile-order-form">
                        <div class="form-progress">
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <span class="progress-text">مرحله ۱ از ۳</span>
                        </div>
                        
                        <!-- Step 1: Basic Info -->
                        <div class="form-step active" data-step="1">
                            <h4>اطلاعات پایه</h4>
                            <div class="form-group">
                                <label for="mobile_name">
                                    <i class="fa-solid fa-user"></i>
                                    نام و نام خانوادگی
                                </label>
                                <input type="text" id="mobile_name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile_phone">
                                    <i class="fa-solid fa-phone"></i>
                                    شماره تماس
                                </label>
                                <input type="tel" id="mobile_phone" name="phone" 
                                       pattern="^(\+98|0)?9\d{9}$" required>
                                <small>مثال: ۰۹۱۲۳۴۵۶۷۸۹</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile_email">
                                    <i class="fa-solid fa-envelope"></i>
                                    آدرس ایمیل
                                </label>
                                <input type="email" id="mobile_email" name="email" required>
                            </div>
                        </div>
                        
                        <!-- Step 2: Academic Info -->
                        <div class="form-step" data-step="2">
                            <h4>اطلاعات تحصیلی</h4>
                            <div class="form-group">
                                <label for="mobile_major">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    رشته تحصیلی
                                </label>
                                <select id="mobile_major" name="major" required>
                                    <option value="">انتخاب رشته</option>
                                    <optgroup label="مهندسی">
                                        <option value="computer">مهندسی کامپیوتر</option>
                                        <option value="electrical">مهندسی برق</option>
                                        <option value="mechanical">مهندسی مکانیک</option>
                                        <option value="civil">مهندسی عمران</option>
                                        <option value="industrial">مهندسی صنایع</option>
                                        <option value="chemical">مهندسی شیمی</option>
                                    </optgroup>
                                    <optgroup label="علوم پایه">
                                        <option value="mathematics">ریاضی</option>
                                        <option value="physics">فیزیک</option>
                                        <option value="chemistry">شیمی</option>
                                        <option value="biology">زیست‌شناسی</option>
                                    </optgroup>
                                    <optgroup label="علوم انسانی">
                                        <option value="psychology">روان‌شناسی</option>
                                        <option value="sociology">جامعه‌شناسی</option>
                                        <option value="history">تاریخ</option>
                                        <option value="literature">ادبیات</option>
                                    </optgroup>
                                    <optgroup label="پزشکی">
                                        <option value="medicine">پزشکی عمومی</option>
                                        <option value="dentistry">دندان‌پزشکی</option>
                                        <option value="pharmacy">داروسازی</option>
                                        <option value="nursing">پرستاری</option>
                                    </optgroup>
                                    <optgroup label="سایر">
                                        <option value="management">مدیریت</option>
                                        <option value="economics">اقتصاد</option>
                                        <option value="law">حقوق</option>
                                        <option value="art">هنر</option>
                                        <option value="agriculture">کشاورزی</option>
                                        <option value="other">سایر رشته‌ها</option>
                                    </optgroup>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile_degree">
                                    <i class="fa-solid fa-medal"></i>
                                    مقطع تحصیلی
                                </label>
                                <select id="mobile_degree" name="degree" required>
                                    <option value="">انتخاب مقطع</option>
                                    <option value="bachelor">کارشناسی</option>
                                    <option value="master">کارشناسی ارشد</option>
                                    <option value="phd">دکتری</option>
                                    <option value="diploma">دیپلم</option>
                                    <option value="associate">کاردانی</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile_university">
                                    <i class="fa-solid fa-university"></i>
                                    نام دانشگاه (اختیاری)
                                </label>
                                <input type="text" id="mobile_university" name="university" 
                                       placeholder="مثال: دانشگاه تهران">
                            </div>
                        </div>
                        
                        <!-- Step 3: Project Details -->
                        <div class="form-step" data-step="3">
                            <h4>جزئیات پروژه</h4>
                            <div class="form-group">
                                <label for="mobile_urgency">
                                    <i class="fa-solid fa-clock"></i>
                                    اولویت
                                </label>
                                <select id="mobile_urgency" name="urgency">
                                    <option value="normal">عادی (۷-۱۰ روز)</option>
                                    <option value="urgent">فوری (۳-۵ روز)</option>
                                    <option value="emergency">اضطراری (۱-۲ روز)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile_budget">
                                    <i class="fa-solid fa-money-bill"></i>
                                    بودجه تقریبی (اختیاری)
                                </label>
                                <select id="mobile_budget" name="budget">
                                    <option value="">انتخاب محدوده بودجه</option>
                                    <option value="under-500k">زیر ۵۰۰ هزار تومان</option>
                                    <option value="500k-1m">۵۰۰ هزار تا ۱ میلیون</option>
                                    <option value="1m-2m">۱ تا ۲ میلیون</option>
                                    <option value="2m-5m">۲ تا ۵ میلیون</option>
                                    <option value="above-5m">بالای ۵ میلیون</option>
                                    <option value="negotiate">قابل مذاکره</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile_description">
                                    <i class="fa-solid fa-edit"></i>
                                    توضیحات تکمیلی (اختیاری)
                                </label>
                                <textarea id="mobile_description" name="description" rows="4" 
                                          placeholder="توضیحات بیشتر در مورد پروژه، الزامات خاص، یا سوالات..."></textarea>
                            </div>
                        </div>
                        
                        <div class="form-navigation">
                            <button type="button" class="nav-btn prev-btn" id="prev-step" style="display: none;">
                                <i class="fa-solid fa-arrow-right"></i>
                                قبلی
                            </button>
                            <button type="button" class="nav-btn next-btn" id="next-step">
                                بعدی
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                            <button type="submit" class="nav-btn submit-btn" id="submit-order" style="display: none;">
                                <span class="btn-content">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    ارسال درخواست
                                </span>
                                <span class="btn-loading">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                    در حال ارسال...
                                </span>
                            </button>
                        </div>
                        
                        <div class="form-footer">
                            <div class="security-note">
                                <i class="fa-solid fa-shield-alt"></i>
                                <span>اطلاعات شما کاملاً محفوظ است</span>
                            </div>
                            <div class="response-time">
                                <i class="fa-solid fa-clock"></i>
                                <span>پاسخ طی ۲ ساعت</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
        .mobile-bottom-nav-enhanced {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: none;
            font-family: inherit;
        }
        
        /* ONLY SHOW ON MOBILE/TABLET */
        @media (max-width: 1024px) {
            .mobile-bottom-nav-enhanced {
                display: block;
            }
            
            body {
                padding-bottom: calc(90px + env(safe-area-inset-bottom));
            }
        }
        
        .bottom-nav-container {
            position: relative;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--border-color);
            padding: 0.75rem 0 calc(0.75rem + env(safe-area-inset-bottom));
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .nav-background-blur {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            backdrop-filter: inherit;
            z-index: -1;
        }
        
        .bottom-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 500px;
            margin: 0 auto;
            padding: 0 1rem;
            gap: 0.5rem;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 60px;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .nav-item:hover::before,
        .nav-item.active::before {
            opacity: 0.1;
        }
        
        .nav-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }
        
        .nav-item i {
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }
        
        .nav-label {
            font-size: 0.7rem;
            font-weight: 500;
            opacity: 0.8;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover,
        .nav-item.active {
            color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .nav-item:hover .nav-label,
        .nav-item.active .nav-label {
            opacity: 1;
            font-weight: 600;
        }
        
        .nav-item:hover i,
        .nav-item.active i {
            transform: scale(1.1);
        }
        
        .special-item {
            background: var(--primary-color);
            color: white;
            border-radius: 15px;
            padding: 0.75rem 1rem;
            box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
        }
        
        .special-item:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(31, 165, 71, 0.4);
        }
        
        .order-pulse {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 12px;
            height: 12px;
            background: #ff6b6b;
            border-radius: 50%;
            animation: orderPulse 2s infinite;
        }
        
        @keyframes orderPulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        
        .active-indicator {
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: activeIndicator 2s infinite;
        }
        
        @keyframes activeIndicator {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        
        /* Enhanced Mobile Order Modal */
        .mobile-order-modal-enhanced {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10001;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .mobile-order-modal-enhanced.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .modal-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--bg-main);
            border-radius: 25px 25px 0 0;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .mobile-order-modal-enhanced.active .modal-container {
            transform: translateY(0);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .modal-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .modal-title i {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .modal-title h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
            font-family: inherit;
        }
        
        .modal-close {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .modal-close:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: rotate(90deg);
        }
        
        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }
        
        .form-progress {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }
        
        .progress-bar {
            flex: 1;
            height: 6px;
            background: var(--border-color);
            border-radius: 3px;
            overflow: hidden;
            margin-left: 1rem;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            width: 33%;
            transition: width 0.4s ease;
            border-radius: 3px;
        }
        
        .progress-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-color);
            font-family: inherit;
        }
        
        .form-step {
            display: none;
        }
        
        .form-step.active {
            display: block;
            animation: stepSlideIn 0.4s ease;
        }
        
        @keyframes stepSlideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .form-step h4 {
            color: var(--text-primary);
            margin: 0 0 1.5rem 0;
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            font-family: inherit;
        }
        
        .mobile-order-form-enhanced .form-group {
            margin-bottom: 1.5rem;
        }
        
        .mobile-order-form-enhanced label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-family: inherit;
        }
        
        .mobile-order-form-enhanced label i {
            color: var(--primary-color);
            width: 18px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .mobile-order-form-enhanced input,
        .mobile-order-form-enhanced select,
        .mobile-order-form-enhanced textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-family: inherit;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .mobile-order-form-enhanced input:focus,
        .mobile-order-form-enhanced select:focus,
        .mobile-order-form-enhanced textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(31, 165, 71, 0.1);
            outline: none;
            background: var(--bg-main);
        }
        
        .mobile-order-form-enhanced input:valid,
        .mobile-order-form-enhanced select:valid {
            border-color: var(--primary-color);
        }
        
        .mobile-order-form-enhanced small {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: block;
            font-family: inherit;
        }
        
        .form-navigation {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        .nav-btn {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .prev-btn {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        
        .next-btn,
        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }
        
        .nav-btn:hover {
            transform: translateY(-2px);
        }
        
        .prev-btn:hover {
            background: var(--border-color);
        }
        
        .next-btn:hover,
        .submit-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), #0f5d2a);
            box-shadow: 0 6px 20px rgba(31, 165, 71, 0.4);
        }
        
        .submit-btn .btn-content,
        .submit-btn .btn-loading {
            transition: all 0.3s ease;
        }
        
        .submit-btn .btn-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
        }
        
        .submit-btn.loading .btn-content {
            opacity: 0;
        }
        
        .submit-btn.loading .btn-loading {
            opacity: 1;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .security-note,
        .response-time {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: inherit;
        }
        
        .security-note i {
            color: #28a745;
        }
        
        .response-time i {
            color: var(--primary-color);
        }
        
        [data-theme="dark"] .bottom-nav-container {
            background: rgba(13, 17, 23, 0.95);
        }
        
        [data-theme="sepia"] .bottom-nav-container {
            background: rgba(244, 236, 216, 0.95);
        }
        
        @media (max-width: 480px) {
            .modal-container {
                border-radius: 20px 20px 0 0;
            }
            
            .modal-header {
                padding: 1.5rem;
            }
            
            .modal-body {
                padding: 1.5rem;
            }
            
            .bottom-nav-items {
                gap: 0.25rem;
                padding: 0 0.5rem;
            }
            
            .nav-item {
                min-width: 50px;
                padding: 0.4rem;
            }
            
            .nav-item i {
                font-size: 1.2rem;
            }
            
            .nav-label {
                font-size: 0.65rem;
            }
        }
        </style>
        
        
        <?php
    }
 
    
    /**
     * Dashboard Widget Function - ADDED TO FIX FATAL ERROR
     */
    public function dashboard_widget_function() {
        echo '<p>خوش آمدید به پنل مدیریت تزنویسان</p>';
    }

    /**
     * Admin Page Callback - ADDED TO FIX FATAL ERROR
     */
    public function admin_page_callback() {
        echo '<div class="wrap"><h1>تنظیمات تزنویسان</h1><p>صفحه تنظیمات اصلی تم</p></div>';
    }
    

    /**
     * Add Cookie Consent - Enhanced
     */
    public function add_cookie_consent() {
        ?>
        <div class="cookie-consent-enhanced" id="cookie-consent">
            <div class="cookie-content">
                <div class="cookie-icon-animation">
                    <i class="fa-solid fa-cookie-bite"></i>
                    <div class="cookie-crumbs">
                        <span class="crumb"></span>
                        <span class="crumb"></span>
                        <span class="crumb"></span>
                    </div>
                </div>
                <div class="cookie-text">
                    <h4>استفاده از کوکی‌ها</h4>
                    <p>
                        ما از کوکی‌ها برای بهبود تجربه کاربری، تجزیه و تحلیل ترافیک و شخصی‌سازی محتوا استفاده می‌کنیم. 
                        با ادامه استفاده از سایت، استفاده از کوکی‌ها را می‌پذیرید.
                    </p>
                </div>
                <div class="cookie-actions">
                    <button class="cookie-btn accept-all" id="accept-all-cookies">
                        <i class="fa-solid fa-check"></i>
                        پذیرش همه
                    </button>
                    <button class="cookie-btn accept-necessary" id="accept-necessary-cookies">
                        <i class="fa-solid fa-cog"></i>
                        فقط ضروری
                    </button>
                    <button class="cookie-btn decline" id="decline-cookies">
                        <i class="fa-solid fa-times"></i>
                        رد
                    </button>
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" 
                       class="cookie-link" target="_blank">
                        <i class="fa-solid fa-info-circle"></i>
                        اطلاعات بیشتر
                    </a>
                </div>
            </div>
        </div>
        
        <style>
        .cookie-consent-enhanced {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.95), rgba(26, 26, 26, 0.95));
            color: white;
            padding: 2rem 0;
            z-index: 10002;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(15px);
            border-top: 3px solid var(--primary-color);
        }
        
        .cookie-consent-enhanced.show {
            transform: translateY(0);
        }
        
        .cookie-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .cookie-icon-animation {
            position: relative;
            font-size: 2.5rem;
            color: #ffa500;
            flex-shrink: 0;
            animation: cookieRotate 3s infinite linear;
        }
        
        @keyframes cookieRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .cookie-crumbs {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }
        
        .crumb {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #d4af37;
            border-radius: 50%;
            animation: crumbFloat 2s infinite ease-in-out;
        }
        
        .crumb:nth-child(1) {
            top: 20%;
            left: 30%;
            animation-delay: 0s;
        }
        
        .crumb:nth-child(2) {
            top: 60%;
            right: 25%;
            animation-delay: 0.7s;
        }
        
        .crumb:nth-child(3) {
            bottom: 25%;
            left: 50%;
            animation-delay: 1.4s;
        }
        
        @keyframes crumbFloat {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.8; }
            50% { transform: translateY(-5px) scale(1.2); opacity: 1; }
        }
        
        .cookie-text {
            flex: 1;
            min-width: 300px;
        }
        
        .cookie-text h4 {
            margin: 0 0 0.75rem 0;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: inherit;
            color: white;
        }
        
        .cookie-text p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
            line-height: 1.6;
            font-family: inherit;
        }
        
        .cookie-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .cookie-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }
        
        .cookie-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .cookie-btn:hover::before {
            left: 100%;
        }
        
        .cookie-btn.accept-all {
            background: var(--primary-color);
            color: white;
        }
        
        .cookie-btn.accept-necessary {
            background: #6c757d;
            color: white;
        }
        
        .cookie-btn.decline {
            background: transparent;
            color: #ff6b6b;
            border: 1px solid #ff6b6b;
        }
        
        .cookie-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        
        .cookie-btn.accept-all:hover {
            background: var(--primary-dark);
        }
        
        .cookie-btn.accept-necessary:hover {
            background: #5a6268;
        }
        
        .cookie-btn.decline:hover {
            background: #ff6b6b;
            color: white;
        }
        
        .cookie-link {
            color: #ffa500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-family: inherit;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .cookie-link:hover {
            color: #ffb84d;
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .cookie-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }
            
            .cookie-actions {
                justify-content: center;
                flex-direction: column;
                width: 100%;
            }
            
            .cookie-btn {
                width: 100%;
                justify-content: center;
            }
            
            .cookie-text {
                min-width: auto;
            }
        }
        </style>
        
        <?php
    }

    /**
     * Newsletter Popup
     */
    private function render_newsletter_popup() {
        $delay = get_theme_mod('newsletter_popup_delay', 30);
        ?>
        <div class="newsletter-popup-enhanced" id="newsletter-popup">
            <div class="popup-backdrop"></div>
            <div class="popup-container">
                <div class="popup-header">
                    <div class="popup-icon">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <h3><?php echo esc_html(get_theme_mod('newsletter_title', 'از آخرین اخبار و تخفیف‌ها باخبر شوید')); ?></h3>
                    <p><?php echo esc_html(get_theme_mod('newsletter_subtitle', 'شماره تماس خود را وارد کنید')); ?></p>
                    <button class="popup-close" id="newsletter-popup-close">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                
                <div class="popup-body">
                    <form class="newsletter-popup-form" id="newsletter-popup-form">
                        <div class="input-group">
                            <i class="fa-solid fa-mobile-alt"></i>
                            <input type="tel" name="phone" placeholder="شماره تماس..." required>
                            <button type="submit">عضویت</button>
                        </div>
                        
                        <div class="popup-benefits">
                            <div class="benefit">
                                <i class="fa-solid fa-percentage"></i>
                                <span>تخفیف‌های ویژه</span>
                            </div>
                            <div class="benefit">
                                <i class="fa-solid fa-bell"></i>
                                <span>اطلاع از آخرین مقالات</span>
                            </div>
                            <div class="benefit">
                                <i class="fa-solid fa-headset"></i>
                                <span>مشاوره رایگان</span>
                            </div>
                        </div>
                    </form>
                    
                    <div class="popup-stats">
                        <div class="stat">
                            <span class="number"><?php echo esc_html(get_theme_mod('newsletter_subscribers', '۱۰,۰۰۰+')); ?></span>
                            <span class="label">مشترک فعال</span>
                        </div>
                        <div class="stat">
                            <span class="number"><?php echo esc_html(get_theme_mod('newsletter_satisfaction', '۹۸%')); ?></span>
                            <span class="label">رضایت</span>
                        </div>
                    </div>
                </div>
                
                <div class="popup-footer">
                    <small><?php echo esc_html(get_theme_mod('newsletter_privacy_text', 'اطلاعات شما محفوظ است و به اشتراک گذاشته نمی‌شود')); ?></small>
                </div>
            </div>
        </div>
        
        <style>
        .newsletter-popup-enhanced {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10003;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }
        
        .newsletter-popup-enhanced.show {
            opacity: 1;
            visibility: visible;
        }
        
        .popup-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }
        
        .popup-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background: var(--bg-main);
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.4s ease;
        }
        
        .newsletter-popup-enhanced.show .popup-container {
            transform: translate(-50%, -50%) scale(1);
        }
        
        .popup-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .popup-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            animation: popupIconBounce 2s infinite;
        }
        
        @keyframes popupIconBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .popup-header h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.3rem;
            font-weight: 700;
            font-family: inherit;
        }
        
        .popup-header p {
            margin: 0;
            opacity: 0.9;
            font-family: inherit;
        }
        
        .popup-close {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .popup-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        
        .popup-body {
            padding: 2rem;
        }
        
                .input-group {
            display: flex;
            align-items: center;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            transition: border-color 0.3s ease;
        }
        
        .input-group:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(31, 165, 71, 0.1);
        }
        
        .input-group i {
            padding: 1rem;
            color: var(--text-muted);
            background: var(--bg-main);
        }
        
        .input-group input {
            flex: 1;
            padding: 1rem;
            border: none;
            background: transparent;
            font-family: inherit;
            color: var(--text-primary);
            font-size: 1rem;
        }
        
        .input-group input:focus {
            outline: none;
        }
        
        .input-group button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            font-family: inherit;
            transition: background 0.3s ease;
        }
        
        .input-group button:hover {
            background: var(--primary-dark);
        }
        
        .popup-benefits {
            display: flex;
            justify-content: space-around;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .benefit {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
            text-align: center;
        }
        
        .benefit i {
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        .benefit span {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-family: inherit;
        }
        
        .popup-stats {
            display: flex;
            justify-content: space-around;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 12px;
            margin-bottom: 1rem;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat .number {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            font-family: inherit;
        }
        
        .stat .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-family: inherit;
        }
        
        .popup-footer {
            padding: 1rem 2rem;
            background: var(--bg-secondary);
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        .popup-footer small {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-family: inherit;
        }
        
        @media (max-width: 480px) {
            .popup-container {
                width: 95%;
                max-width: 95vw;
            }
            
            .popup-header {
                padding: 1.5rem;
            }
            
            .popup-body {
                padding: 1.5rem;
            }
            
            .popup-benefits {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .benefit {
                flex-direction: row;
                justify-content: flex-start;
                text-align: right;
            }
        }
        </style>
        
                
        <style>
        .newsletter-popup-enhanced {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10004;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }
        
        .newsletter-popup-enhanced.show {
            opacity: 1;
            visibility: visible;
        }
        
        .popup-success {
            text-align: center;
            padding: 2rem;
        }
        
        .popup-success i {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1rem;
            animation: successBounce 0.6s ease;
        }
        
        @keyframes successBounce {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .popup-success h4 {
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
            font-family: inherit;
        }
        
        .popup-success p {
            color: var(--text-secondary);
            margin: 0;
            font-family: inherit;
        }
        </style>
        <?php
    }

    /**
     * Log Form Submission - ADDED TO FIX MISSING METHOD
     */
    private function log_form_submission($data, $form_type) {
        $log_entry = array(
            'type' => $form_type,
            'data' => $data,
            'timestamp' => current_time('mysql'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'referer' => $_SERVER['HTTP_REFERER'] ?? ''
        );
        
        $logs = get_option('teznevisan_form_logs', array());
        $logs[] = $log_entry;
        
        // Keep only last 1000 entries
        $logs = array_slice($logs, -1000);
        update_option('teznevisan_form_logs', $logs);
    }
    

        
    /**
     * Get Service Reviews - ADDED TO FIX MISSING METHOD
     */
    private function get_service_reviews($service_id) {
        $reviews = get_posts(array(
            'post_type' => 'testimonials',
            'meta_query' => array(
                array(
                    'key' => 'related_service',
                    'value' => $service_id,
                    'compare' => '='
                )
            ),
            'posts_per_page' => 5
        ));
        
        $review_data = array();
        foreach ($reviews as $review) {
            $rating = get_post_meta($review->ID, 'rating', true) ?: 5;
            $review_data[] = array(
                '@type' => 'Review',
                'reviewRating' => array(
                    '@type' => 'Rating',
                    'ratingValue' => $rating,
                    'bestRating' => 5
                ),
                'author' => array(
                    '@type' => 'Person',
                    'name' => get_post_meta($review->ID, 'client_name', true) ?: 'مشتری تزنویسان'
                ),
                'reviewBody' => wp_trim_words(get_post_field('post_content', $review), 50)
            );
        }
        
        return $review_data;
    }
    
    /**
     * Create Email Template - Enhanced
     */
    private function create_email_template($data) {
        $urgency_colors = array(
            'normal' => '#28a745',
            'urgent' => '#ffc107',
            'emergency' => '#dc3545'
        );
        
        $urgency_labels = array(
            'normal' => 'عادی',
            'urgent' => 'فوری', 
            'emergency' => 'اضطراری'
        );
        
        $urgency = $data['urgency'] ?? 'normal';
        $urgency_color = $urgency_colors[$urgency];
        $urgency_label = $urgency_labels[$urgency];
        $template = '
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>پیام جدید از ' . get_bloginfo('name') . '</title>
            <style>
                * {
                    box-sizing: border-box;
                    font-family: "Vazirmatn", Tahoma, Arial, sans-serif;
                }
                
                body {
                    margin: 0;
                    padding: 0;
                    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                    direction: rtl;
                    text-align: right;
                    line-height: 1.6;
                }
                
                .email-container {
                    max-width: 600px;
                    margin: 2rem auto;
                    background: white;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                }
                
                .email-header {
                    background: linear-gradient(135deg, #1FA547, #178A3A);
                    color: white;
                    padding: 3rem 2rem;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                }
                
                .email-header::before {
                    content: "";
                    position: absolute;
                    top: -50%;
                    left: -50%;
                    width: 200%;
                    height: 200%;
                    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                    animation: emailHeaderShine 3s ease-in-out infinite;
                }
                
                @keyframes emailHeaderShine {
                    0%, 100% { transform: rotate(0deg); }
                    50% { transform: rotate(180deg); }
                }
                
                .email-logo {
                    width: 80px;
                    height: 80px;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 1.5rem;
                    font-size: 2rem;
                    position: relative;
                    z-index: 1;
                }
                
                .email-header h1 {
                    margin: 0;
                    font-size: 1.8rem;
                    font-weight: 700;
                    position: relative;
                    z-index: 1;
                }
                
                .email-subtitle {
                    margin: 0.5rem 0 0 0;
                    opacity: 0.9;
                    font-size: 1rem;
                    position: relative;
                    z-index: 1;
                }
                
                .email-body {
                    padding: 2.5rem;
                }
                
                .info-section {
                    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                    border-radius: 15px;
                    padding: 2rem;
                    margin-bottom: 2rem;
                    border-right: 5px solid #1FA547;
                    position: relative;
                }
                
                .info-section::before {
                    content: "";
                    position: absolute;
                    top: 10px;
                    left: 10px;
                    right: 10px;
                    bottom: 10px;
                    border: 1px dashed rgba(31, 165, 71, 0.3);
                    border-radius: 10px;
                    pointer-events: none;
                }
                
                .info-section h3 {
                    margin: 0 0 1.5rem 0;
                    color: #1FA547;
                    font-size: 1.3rem;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                
                .info-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.75rem 0;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                }
                
                .info-row:last-child {
                    border-bottom: none;
                }
                
                .info-label {
                    font-weight: 600;
                    color: #333;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                
                .info-label i {
                    color: #1FA547;
                    width: 16px;
                    text-align: center;
                }
                
                .info-value {
                    color: #666;
                    font-weight: 500;
                    background: white;
                    padding: 0.5rem 1rem;
                    border-radius: 20px;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                }
                
                .message-section {
                    background: white;
                    border: 1px solid #e9ecef;
                    border-radius: 15px;
                    padding: 2rem;
                    margin-bottom: 2rem;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                }
                
                .message-section h3 {
                    margin: 0 0 1rem 0;
                    color: #1FA547;
                    font-size: 1.2rem;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                
                .message-content {
                    background: #f8f9fa;
                    padding: 1.5rem;
                    border-radius: 10px;
                    border-right: 3px solid #1FA547;
                    line-height: 1.7;
                    color: #495057;
                }
                
                .urgency-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    padding: 0.5rem 1rem;
                    border-radius: 20px;
                    font-size: 0.85rem;
                    font-weight: 600;
                    margin-bottom: 1rem;
                }
                
                .urgency-normal {
                    background: rgba(40, 167, 69, 0.1);
                    color: #28a745;
                    border: 1px solid rgba(40, 167, 69, 0.2);
                }
                
                .urgency-urgent {
                    background: rgba(255, 193, 7, 0.1);
                    color: #ffc107;
                    border: 1px solid rgba(255, 193, 7, 0.2);
                }
                
                .urgency-emergency {
                    background: rgba(220, 53, 69, 0.1);
                    color: #dc3545;
                    border: 1px solid rgba(220, 53, 69, 0.2);
                }
                
                .email-footer {
                    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                    padding: 2.5rem 2rem;
                    text-align: center;
                    border-top: 1px solid #dee2e6;
                }
                
                .contact-info {
                    display: flex;
                    justify-content: center;
                    gap: 2rem;
                    margin-bottom: 1.5rem;
                    flex-wrap: wrap;
                }
                
                .contact-item {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    color: #666;
                    font-size: 0.9rem;
                    background: white;
                    padding: 0.75rem 1rem;
                    border-radius: 25px;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease;
                }
                
                .contact-item:hover {
                    background: #1FA547;
                    color: white;
                    transform: translateY(-2px);
                }
                
                .contact-item i {
                    color: #1FA547;
                    transition: color 0.3s ease;
                }
                
                .contact-item:hover i {
                    color: white;
                }
                
                .email-footer-note {
                    margin: 1rem 0 0 0;
                    color: #999;
                    font-size: 0.8rem;
                    opacity: 0.8;
                }
                
                .action-buttons {
                    display: flex;
                    gap: 1rem;
                    justify-content: center;
                    margin: 2rem 0;
                }
                
                .action-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    padding: 1rem 2rem;
                    text-decoration: none;
                    border-radius: 25px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                }
                
                .action-btn.primary {
                    background: #1FA547;
                    color: white;
                }
                
                .action-btn.secondary {
                    background: transparent;
                    color: #1FA547;
                    border: 2px solid #1FA547;
                }
                
                .action-btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(31, 165, 71, 0.3);
                }
                
                @media (max-width: 600px) {
                    .email-container {
                        margin: 0;
                        border-radius: 0;
                    }
                    
                    .email-header,
                    .email-body,
                    .email-footer {
                        padding: 2rem 1.5rem;
                    }
                    
                    .contact-info {
                        flex-direction: column;
                        gap: 1rem;
                    }
                    
                    .action-buttons {
                        flex-direction: column;
                    }
                    
                    .info-row {
                        flex-direction: column;
                        gap: 0.5rem;
                        align-items: flex-start;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <div class="email-logo">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h1>' . get_bloginfo('name') . '</h1>
                    <p class="email-subtitle">پیام جدید از سایت</p>
                </div>
                
                <div class="email-body">
                    <div class="info-section">
                        <h3><i class="fa-solid fa-user"></i> اطلاعات فرستنده</h3>
                        <div class="info-row">
                            <span class="info-label"><i class="fa-solid fa-user"></i> نام:</span>
                            <span class="info-value">' . esc_html($data['name']) . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fa-solid fa-phone"></i> تلفن:</span>
                            <span class="info-value">' . esc_html($data['phone']) . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fa-solid fa-envelope"></i> ایمیل:</span>
                            <span class="info-value">' . esc_html($data['email']) . '</span>
                        </div>
                        ' . (!empty($data['service_name']) ? '<div class="info-row"><span class="info-label"><i class="fa-solid fa-tools"></i> خدمت:</span><span class="info-value">' . esc_html($data['service_name']) . '</span></div>' : '') . '
                        ' . (!empty($data['urgency']) ? '<div class="info-row"><span class="info-label"><i class="fa-solid fa-clock"></i> اولویت:</span><span class="urgency-badge urgency-' . esc_attr($data['urgency']) . '"><i class="fa-solid fa-exclamation-triangle"></i>' . esc_html($data['urgency']) . '</span></div>' : '') . '
                        <div class="info-row">
                            <span class="info-label"><i class="fa-solid fa-calendar"></i> تاریخ:</span>
                            <span class="info-value">' . jdate('j F Y - H:i') . '</span>
                        </div>
                    </div>
                    
                    ' . (!empty($data['message']) ? '
                    <div class="message-section">
                        <h3><i class="fa-solid fa-comment"></i> پیام:</h3>
                        <div class="message-content">' . nl2br(esc_html($data['message'])) . '</div>
                    </div>
                    ' : '') . '
                    
                    <div class="action-buttons">
                        <a href="tel:' . esc_attr($data['phone']) . '" class="action-btn primary">
                            <i class="fa-solid fa-phone"></i>
                            تماس با مشتری
                        </a>
                        <a href="mailto:' . esc_attr($data['email']) . '" class="action-btn secondary">
                            <i class="fa-solid fa-reply"></i>
                            پاسخ ایمیل
                        </a>
                    </div>
                </div>
                
                <div class="email-footer">
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <span>' . get_theme_mod('phone_number', '09331663849') . '</span>
                        </div>
                        <div class="contact-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span>' . get_theme_mod('email_address', 'setinco@gmail.com') . '</span>
                        </div>
                        <div class="contact-item">
                            <i class="fa-solid fa-globe"></i>
                            <span>' . home_url() . '</span>
                        </div>
                    </div>
                    <p class="email-footer-note">این ایمیل از طریق سایت ' . get_bloginfo('name') . ' ارسال شده است.</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $template;
        ob_start();
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>اطلاعیه جدید از <?php echo get_bloginfo('name'); ?></title>
            <style>
                * {
                    box-sizing: border-box;
                    font-family: "Vazirmatn", "IRANSans", Tahoma, Arial, sans-serif;
                }
                
                body {
                    margin: 0;
                    padding: 0;
                    background: linear-gradient(135deg, #f1f8e9, #e8f5e8);
                    direction: rtl;
                    text-align: right;
                    line-height: 1.7;
                    color: #333;
                }
                
                .email-wrapper {
                    max-width: 650px;
                    margin: 3rem auto;
                    background: white;
                    border-radius: 25px;
                    overflow: hidden;
                    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
                    border: 1px solid #e9ecef;
                }
                
                .email-header {
                    background: linear-gradient(135deg, #1FA547, #178A3A);
                    color: white;
                    padding: 3.5rem 2.5rem;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                }
                
                .email-header::before {
                    content: "";
                    position: absolute;
                    top: -100px;
                    left: -100px;
                    width: 200px;
                    height: 200px;
                    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                    border-radius: 50%;
                    animation: headerFloat 6s ease-in-out infinite;
                }
                
                .email-header::after {
                    content: "";
                    position: absolute;
                    bottom: -80px;
                    right: -80px;
                    width: 150px;
                    height: 150px;
                    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
                    border-radius: 50%;
                    animation: headerFloat 4s ease-in-out infinite reverse;
                }
                
                @keyframes headerFloat {
                    0%, 100% { transform: translate(0, 0) rotate(0deg); }
                    33% { transform: translate(30px, -30px) rotate(120deg); }
                    66% { transform: translate(-20px, 20px) rotate(240deg); }
                }
                
                .email-logo {
                    width: 90px;
                    height: 90px;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 2rem;
                    font-size: 2.5rem;
                    position: relative;
                    z-index: 2;
                    border: 3px solid rgba(255, 255, 255, 0.3);
                }
                
                .email-header h1 {
                    margin: 0 0 0.5rem 0;
                    font-size: 2rem;
                    font-weight: 800;
                    position: relative;
                    z-index: 2;
                    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }
                
                .email-subtitle {
                    margin: 0;
                    opacity: 0.95;
                    font-size: 1.1rem;
                    position: relative;
                    z-index: 2;
                    font-weight: 400;
                }
                
                .email-body {
                    padding: 3rem 2.5rem;
                }
                
                .urgency-alert {
                    background: <?php echo $urgency_color; ?>;
                    color: <?php echo $urgency === 'urgent' ? '#000' : '#fff'; ?>;
                    padding: 1rem 1.5rem;
                    border-radius: 15px;
                    text-align: center;
                    font-weight: 700;
                    margin-bottom: 2rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.5rem;
                    font-size: 1.1rem;
                }
                
                .info-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 2rem;
                    margin-bottom: 2.5rem;
                }
                
                .info-section {
                    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                    border-radius: 18px;
                    padding: 2rem;
                    border-right: 6px solid #1FA547;
                    position: relative;
                    overflow: hidden;
                }
                
                .info-section::before {
                    content: "";
                    position: absolute;
                    top: 15px;
                    left: 15px;
                    right: 15px;
                    bottom: 15px;
                    border: 2px dashed rgba(31, 165, 71, 0.2);
                    border-radius: 12px;
                    pointer-events: none;
                }
                
                .info-section h3 {
                    margin: 0 0 1.5rem 0;
                    color: #1FA547;
                    font-size: 1.3rem;
                    font-weight: 700;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    position: relative;
                    z-index: 1;
                }
                
                .info-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem 0;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
                    position: relative;
                    z-index: 1;
                }
                
                .info-row:last-child {
                    border-bottom: none;
                    padding-bottom: 0;
                }
                
                .info-label {
                    font-weight: 600;
                    color: #495057;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    font-size: 0.95rem;
                }
                
                .info-label i {
                    color: #1FA547;
                    width: 18px;
                    text-align: center;
                    font-size: 1rem;
                }
                
                .info-value {
                    color: #212529;
                    font-weight: 600;
                    background: white;
                    padding: 0.75rem 1.25rem;
                    border-radius: 25px;
                    border: 1px solid rgba(0, 0, 0, 0.08);
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    font-size: 0.9rem;
                }
                
                .message-section {
                    background: white;
                    border: 2px solid #e9ecef;
                    border-radius: 18px;
                    padding: 2.5rem;
                    margin-bottom: 2.5rem;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                    position: relative;
                }
                
                .message-section::before {
                    content: "💬";
                    position: absolute;
                    top: -15px;
                    right: 30px;
                    background: white;
                    font-size: 1.5rem;
                    padding: 0 0.5rem;
                }
                
                .message-section h3 {
                    margin: 0 0 1.5rem 0;
                    color: #1FA547;
                    font-size: 1.3rem;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    font-weight: 700;
                }
                
                .message-content {
                    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                    padding: 2rem;
                    border-radius: 15px;
                    border-right: 4px solid #1FA547;
                    line-height: 1.8;
                    color: #495057;
                    font-size: 1rem;
                    position: relative;
                    margin: 1.5rem 0;
                }
                
                .message-content::before {
                    content: """;
                    position: absolute;
                    top: -10px;
                    right: 20px;
                    font-size: 3rem;
                    color: #1FA547;
                    opacity: 0.3;
                }
                
                .action-buttons {
                    display: flex;
                    gap: 1.5rem;
                    justify-content: center;
                    margin: 3rem 0;
                    flex-wrap: wrap;
                }
                
                .action-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.75rem;
                    padding: 1.25rem 2.5rem;
                    text-decoration: none;
                    border-radius: 30px;
                    font-weight: 700;
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    overflow: hidden;
                    font-size: 1rem;
                    border: 2px solid transparent;
                }
                
                .action-btn::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                    transition: left 0.5s ease;
                }
                
                .action-btn:hover::before {
                    left: 100%;
                }
                
                .action-btn.primary {
                    background: linear-gradient(135deg, #1FA547, #178A3A);
                    color: white;
                    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
                }
                
                .action-btn.secondary {
                    background: transparent;
                    color: #1FA547;
                    border-color: #1FA547;
                }
                
                .action-btn.tertiary {
                    background: linear-gradient(135deg, #007bff, #0056b3);
                    color: white;
                    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
                }
                
                .action-btn:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
                }
                
                .action-btn.secondary:hover {
                    background: #1FA547;
                    color: white;
                }
                
                .email-footer {
                    background: linear-gradient(135deg, #343a40, #212529);
                    color: white;
                    padding: 3rem 2.5rem;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                }
                
                .email-footer::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 1px;
                    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                }
                
                .contact-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 1.5rem;
                    margin-bottom: 2rem;
                }
                
                .contact-card {
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 15px;
                    padding: 1.5rem;
                    text-align: center;
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    backdrop-filter: blur(10px);
                    transition: all 0.3s ease;
                }
                
                .contact-card:hover {
                    background: rgba(255, 255, 255, 0.15);
                    transform: translateY(-3px);
                }
                
                .contact-card i {
                    font-size: 1.8rem;
                    color: #1FA547;
                    margin-bottom: 1rem;
                    display: block;
                }
                
                .contact-card strong {
                    display: block;
                    margin-bottom: 0.5rem;
                    font-size: 0.9rem;
                    color: rgba(255, 255, 255, 0.9);
                }
                
                .contact-card span {
                    color: rgba(255, 255, 255, 0.8);
                    font-size: 0.85rem;
                }
                
                .social-links {
                    display: flex;
                    justify-content: center;
                    gap: 1rem;
                    margin: 2rem 0;
                }
                
                .social-link {
                    width: 45px;
                    height: 45px;
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    text-decoration: none;
                    transition: all 0.3s ease;
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }
                
                .social-link:hover {
                    background: #1FA547;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(31, 165, 71, 0.4);
                }
                
                .email-footer-note {
                    margin: 2rem 0 0 0;
                    padding-top: 2rem;
                    border-top: 1px solid rgba(255, 255, 255, 0.1);
                    color: rgba(255, 255, 255, 0.7);
                    font-size: 0.85rem;
                    line-height: 1.6;
                }
                
                .tracking-info {
                    background: rgba(31, 165, 71, 0.1);
                    border: 1px solid rgba(31, 165, 71, 0.2);
                    border-radius: 12px;
                    padding: 1.5rem;
                    margin: 2rem 0;
                    text-align: center;
                }
                
                .tracking-number {
                    font-size: 1.1rem;
                    font-weight: 700;
                    color: #1FA547;
                    margin-bottom: 0.5rem;
                }
                
                .tracking-note {
                    font-size: 0.9rem;
                    color: #666;
                }
                
                @media (max-width: 600px) {
                    .email-wrapper {
                        margin: 1rem;
                        border-radius: 15px;
                    }
                    
                    .email-header,
                    .email-body,
                    .email-footer {
                        padding: 2rem 1.5rem;
                    }
                    
                    .info-grid {
                        grid-template-columns: 1fr;
                        gap: 1.5rem;
                    }
                    
                    .action-buttons {
                        flex-direction: column;
                        gap: 1rem;
                    }
                    
                    .contact-grid {
                        grid-template-columns: 1fr;
                        gap: 1rem;
                    }
                    
                    .info-row {
                        flex-direction: column;
                        gap: 0.75rem;
                        align-items: flex-start;
                        text-align: right;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <div class="email-header">
                    <div class="email-logo">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h1><?php echo get_bloginfo('name'); ?></h1>
                    <p class="email-subtitle">
                        <?php echo isset($data['service_name']) ? 'درخواست خدمت جدید' : 'پیام جدید از سایت'; ?>
                    </p>
                </div>
                
                <div class="email-body">
                    <?php if (isset($data['urgency']) && $data['urgency'] !== 'normal') : ?>
                    <div class="urgency-alert">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        درخواست <?php echo $urgency_label; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="info-grid">
                        <div class="info-section">
                            <h3><i class="fa-solid fa-user-circle"></i> اطلاعات مشتری</h3>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-signature"></i> نام:</span>
                                <span class="info-value"><?php echo esc_html($data['name']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-mobile-alt"></i> تلفن:</span>
                                <span class="info-value"><?php echo esc_html($data['phone']); ?></span>
                            </div>
                            <?php if (!empty($data['email'])) : ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-at"></i> ایمیل:</span>
                                <span class="info-value"><?php echo esc_html($data['email']); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($data['university'])) : ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-university"></i> دانشگاه:</span>
                                <span class="info-value"><?php echo esc_html($data['university']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="info-section">
                            <h3><i class="fa-solid fa-info-circle"></i> جزئیات درخواست</h3>
                            <?php if (!empty($data['service_name'])) : ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-tools"></i> خدمت:</span>
                                <span class="info-value"><?php echo esc_html($data['service_name']); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($data['major'])) : ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-graduation-cap"></i> رشته:</span>
                                <span class="info-value"><?php echo esc_html($data['major']); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($data['degree'])) : ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-medal"></i> مقطع:</span>
                                <span class="info-value"><?php echo esc_html($data['degree']); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($data['budget'])) : ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-money-bill"></i> بودجه:</span>
                                <span class="info-value"><?php echo esc_html($data['budget']); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="info-row">
                                <span class="info-label"><i class="fa-solid fa-calendar"></i> تاریخ:</span>
                                <span class="info-value"><?php echo jdate('j F Y - H:i'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!empty($data['message']) || !empty($data['description'])) : ?>
                    <div class="message-section">
                        <h3><i class="fa-solid fa-comment-dots"></i> پیام مشتری</h3>
                        <div class="message-content">
                            <?php echo nl2br(esc_html($data['message'] ?? $data['description'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="tracking-info">
                        <div class="tracking-number">
                            شماره پیگیری: #<?php echo isset($GLOBALS['current_inquiry_id']) ? $GLOBALS['current_inquiry_id'] : rand(1000, 9999); ?>
                        </div>
                        <div class="tracking-note">
                            این شماره را برای پیگیری درخواست نزد مشتری ذخیره کنید
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="tel:<?php echo esc_attr($data['phone']); ?>" class="action-btn primary">
                            <i class="fa-solid fa-phone-alt"></i>
                            تماس فوری با مشتری
                        </a>
                        <?php if (!empty($data['email'])) : ?>
                        <a href="mailto:<?php echo esc_attr($data['email']); ?>" class="action-btn secondary">
                            <i class="fa-solid fa-reply"></i>
                            پاسخ ایمیل
                        </a>
                        <?php endif; ?>
                        <a href="https://wa.me/<?php echo str_replace(['+', ' ', '-'], '', $data['phone']); ?>" 
                           class="action-btn tertiary" target="_blank">
                            <i class="fa-brands fa-whatsapp"></i>
                            واتساپ
                        </a>
                    </div>
                </div>
                
                <div class="email-footer">
                    <div class="contact-grid">
                        <div class="contact-card">
                            <i class="fa-solid fa-phone-volume"></i>
                            <strong>تماس مستقیم</strong>
                            <span><?php echo get_theme_mod('phone_number', '09331663849'); ?></span>
                        </div>
                        
                        <div class="contact-card">
                            <i class="fa-solid fa-envelope-open"></i>
                            <strong>ایمیل رسمی</strong>
                            <span><?php echo get_theme_mod('email_address', 'setinco@gmail.com'); ?></span>
                        </div>
                        
                        <div class="contact-card">
                            <i class="fa-solid fa-globe-americas"></i>
                            <strong>وب‌سایت</strong>
                            <span><?php echo str_replace(['http://', 'https://'], '', home_url()); ?></span>
                        </div>
                        
                        <div class="contact-card">
                            <i class="fa-solid fa-clock"></i>
                            <strong>ساعات کاری</strong>
                            <span><?php echo get_theme_mod('working_hours', 'شنبه تا پنج‌شنبه: ۸ تا ۲۰'); ?></span>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <?php
                        $social_links = array(
                            'telegram_url' => 'fa-brands fa-telegram',
                            'whatsapp_url' => 'fa-brands fa-whatsapp', 
                            'instagram_url' => 'fa-brands fa-instagram',
                            'linkedin_url' => 'fa-brands fa-linkedin',
                            'eitaa_url' => 'fa-solid fa-comment'
                        );
                        
                        foreach ($social_links as $option => $icon) {
                            $url = get_theme_mod($option);
                            if ($url) {
                                echo '<a href="' . esc_url($url) . '" class="social-link" target="_blank">';
                                echo '<i class="' . esc_attr($icon) . '"></i>';
                                echo '</a>';
                            }
                        }
                        ?>
                    </div>
                    
                    <div class="email-footer-note">
                        <p>
                            <strong>این ایمیل به صورت خودکار از سیستم <?php echo get_bloginfo('name'); ?> ارسال شده است.</strong><br>
                            لطفاً در اسرع وقت با مشتری تماس بگیرید و وضعیت درخواست را در پنل مدیریت بروزرسانی کنید.<br>
                            <small>IP مشتری: <?php echo $_SERVER['REMOTE_ADDR'] ?? 'نامشخص'; ?> | 
                            زمان ارسال: <?php echo current_time('Y-m-d H:i:s'); ?></small>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
        }

    /**
     * Send Admin Notification
     */
    private function send_admin_notification($data, $type, $inquiry_id) {
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        
        $subjects = array(
            'contact_form' => 'پیام جدید از فرم تماس',
            'service_inquiry' => 'درخواست خدمت جدید',
            'mobile_order' => 'سفارش موبایل جدید'
        );
        
        $subject = ($subjects[$type] ?? 'اعلان جدید') . ' - ' . $site_name;

        $message = sprintf(
            'درخواست جدیدی از نوع %s با شناسه %d دریافت شد.<br><br>نام: %s<br>تلفن: %s<br>تاریخ: %s',
            $type,
            $id,
            $data['name'] ?? '',
            $data['phone'] ?? '',
            current_time('Y-m-d H:i')
        );
        
        $email_content = $this->create_email_template($data);
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>',
            'Reply-To: ' . ($data['email'] ?? $admin_email)
        );
        
        return wp_mail($admin_email, $subject, $email_content, $headers);
    }

     
    /**
     * Performance and Security Initialization
     */
    public function init_performance_security() {
        // Remove unnecessary WordPress features
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_shortlink_header', 10, 0);
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        
        // Security enhancements
        add_filter('xmlrpc_enabled', '__return_false');
        
        // Performance optimizations
        add_filter('pre_get_posts', function($query) {
            if (!is_admin() && $query->is_main_query()) {
                if (is_home()) {
                    $query->set('posts_per_page', 12);
                }
                if (is_archive()) {
                    $query->set('posts_per_page', 15);
                }
                if (is_search()) {
                    $query->set('posts_per_page', 10);
                }
            }
            return $query;
        });
        
        // Clean up head
        remove_action('wp_head', 'wp_resource_hints', 2);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        
        // Disable file editing
        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }
    }

    /**
     * Custom Admin Dashboard - Enhanced
     */
    public function custom_admin_dashboard() {
        // Remove default dashboard widgets
        $default_widgets = array(
            'dashboard_incoming_links', 'dashboard_plugins', 'dashboard_primary',
            'dashboard_secondary', 'dashboard_quick_press', 'dashboard_recent_drafts',
            'dashboard_recent_comments', 'dashboard_right_now', 'dashboard_activity'
        );
        
        foreach ($default_widgets as $widget) {
            // Remove unnecessary dashboard widgets
            remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
            remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
            remove_meta_box('dashboard_primary', 'dashboard', 'side');
            remove_meta_box('dashboard_secondary', 'dashboard', 'side');
            remove_meta_box($widget, 'dashboard', 'normal');
            remove_meta_box($widget, 'dashboard', 'side');
            
        }
        
        // Add custom dashboard widgets
        // Add custom widgets with FontAwesome icons
        wp_add_dashboard_widget(
            'teznevisan_overview',
            '<i class="fa-solid fa-chart-line" style="margin-left: 8px; color: #1fa547;"></i>آمار کلی سایت',
            array($this, 'dashboard_overview_widget')
        );
        
        wp_add_dashboard_widget(
            'teznevisan_recent_inquiries',
            'آخرین درخواست‌های مشتریان',
            array($this, 'dashboard_inquiries_widget')
        );
        
        wp_add_dashboard_widget(
            'teznevisan_quick_stats',
            'آمار سریع',
            array($this, 'dashboard_quick_stats_widget')
        );
        
        wp_add_dashboard_widget(
            'teznevisan_quick_actions',
            'عملیات سریع',
            array($this, 'dashboard_quick_actions_widget')
        );
    }

    /**
     * Dashboard Overview Widget
     */
    public function dashboard_overview_widget() {
        $services_count = wp_count_posts('services')->publish ?? 0;
        $posts_count = wp_count_posts()->publish ?? 0;
        $inquiries_count = wp_count_posts('service_inquiry')->private ?? 0;
        $phone_subscribers = count(get_option('teznevisan_newsletter_phones', array()));
        $email_subscribers = count(get_option('teznevisan_newsletter_emails', array()));
        $total_subscribers = $phone_subscribers + $email_subscribers;
        
        // Get recent activity
        $recent_inquiries = get_posts(array(
            'post_type' => 'service_inquiry',
            'posts_per_page' => 3,
            'post_status' => 'private',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        ?>
        <div class="teznevisan-dashboard-overview">
            <div class="overview-stats-grid">
                <div class="stat-card services">
                    <div class="stat-icon">
                        <i class="fa-solid fa-tools"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number"><?php echo $services_count; ?></span>
                        <span class="stat-label">خدمات فعال</span>
                        <span class="stat-change">+۲ این ماه</span>
                    </div>
                </div>
                
                <div class="stat-card posts">
                    <div class="stat-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number"><?php echo $posts_count; ?></span>
                        <span class="stat-label">مقالات منتشر شده</span>
                        <span class="stat-change">+۵ این هفته</span>
                    </div>
                </div>
                
                <div class="stat-card inquiries">
                    <div class="stat-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number"><?php echo $inquiries_count; ?></span>
                        <span class="stat-label">درخواست‌های جدید</span>
                        <span class="stat-change">امروز</span>
                    </div>
                </div>
                
                <div class="stat-card subscribers">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number"><?php echo $total_subscribers; ?></span>
                        <span class="stat-label">مشترکین خبرنامه</span>
                        <span class="stat-change">+۱۵ امروز</span>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($recent_inquiries)) : ?>
            <div class="recent-activity">
                <h4><i class="fa-solid fa-clock"></i> آخرین فعالیت‌ها</h4>
                <div class="activity-list">
                    <?php foreach ($recent_inquiries as $inquiry) : 
                        $inquiry_data = json_decode($inquiry->post_content, true);
                        if ($inquiry_data) :
                    ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fa-solid fa-<?php echo $inquiry_data['type'] === 'mobile_order' ? 'mobile-alt' : 'tools'; ?>"></i>
                            </div>
                            <div class="activity-content">
                                <strong><?php echo esc_html($inquiry_data['name']); ?></strong>
                                <span><?php echo esc_html($inquiry_data['service_name'] ?? 'درخواست عمومی'); ?></span>
                                <small><?php echo human_time_diff(strtotime($inquiry->post_date), current_time('timestamp')) . ' پیش'; ?></small>
                            </div>
                            <div class="activity-actions">
                                <a href="<?php echo admin_url('post.php?post=' . $inquiry->ID . '&action=edit'); ?>" class="activity-btn">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="overview-actions">
                <a href="<?php echo admin_url('post-new.php?post_type=services'); ?>" class="overview-btn primary">
                    <i class="fa-solid fa-plus"></i>
                    افزودن خدمت جدید
                </a>
                <a href="<?php echo admin_url('edit.php?post_type=service_inquiry'); ?>" class="overview-btn secondary">
                    <i class="fa-solid fa-envelope-open"></i>
                    مشاهده درخواست‌ها
                </a>
                <a href="<?php echo admin_url('customize.php'); ?>" class="overview-btn tertiary">
                    <i class="fa-solid fa-palette"></i>
                    تنظیمات تم
                </a>
            </div>
        </div>
        
        <style>
        .teznevisan-dashboard-overview {
            font-family: "Vazirmatn", sans-serif;
        }
        
        .overview-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(31, 165, 71, 0.15);
            border-color: #1FA547;
        }
        
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        
        .stat-card {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .stat-card.services .stat-icon { background: linear-gradient(135deg, #1FA547, #178A3A); }
        .stat-card.posts .stat-icon { background: linear-gradient(135deg, #007bff, #0056b3); }
        .stat-card.inquiries .stat-icon { background: linear-gradient(135deg, #ffc107, #e0a800); color: #1a1a1a; }
        .stat-card.subscribers .stat-icon { background: linear-gradient(135deg, #28a745, #1e7e34); }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-number {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.25rem;
            line-height: 1;
        }
        
        .stat-label {
            display: block;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }
        
        .stat-change {
            font-size: 0.75rem;
            color: #28a745;
            font-weight: 600;
        }
        
        .recent-activity {
            margin-bottom: 2rem;
        }
        
        .recent-activity h4 {
            margin: 0 0 1rem 0;
            color: #333;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .activity-list {
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            overflow: hidden;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            transition: background 0.3s ease;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-item:hover {
            background: rgba(31, 165, 71, 0.05);
        }
        
        .activity-icon {
            width: 35px;
            height: 35px;
            background: #1FA547;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-content strong {
            display: block;
            color: #333;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .activity-content span {
            display: block;
            color: #1FA547;
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }
        
        .activity-content small {
            color: #666;
            font-size: 0.75rem;
        }
        
        .activity-actions {
            flex-shrink: 0;
        }
        
        .activity-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: #1FA547;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .activity-btn:hover {
            background: #178A3A;
            transform: scale(1.1);
        }
        
        .overview-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .overview-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .overview-btn.primary {
            background: linear-gradient(135deg, #1FA547, #178A3A);
            color: white;
        }
        
        .overview-btn.secondary {
            background: transparent;
            color: #1FA547;
            border: 1px solid #1FA547;
        }
        
        .overview-btn.tertiary {
            background: linear-gradient(135deg, #6f42c1, #5a2d91);
            color: white;
        }
        
        .overview-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .overview-btn.secondary:hover {
            background: #1FA547;
            color: white;
        }
        </style>
        <?php
    }

    /**
     * Dashboard Inquiries Widget
     */
    public function dashboard_inquiries_widget() {
        $recent_inquiries = get_posts(array(
            'post_type' => 'service_inquiry',
            'posts_per_page' => 8,
            'post_status' => 'private',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if (empty($recent_inquiries)) {
            echo '<div class="no-inquiries">';
            echo '<i class="fa-solid fa-inbox"></i>';
            echo '<p>درخواست جدیدی وجود ندارد.</p>';
            echo '<a href="' . admin_url('post-new.php?post_type=service_inquiry') . '" class="button button-primary">افزودن درخواست دستی</a>';
            echo '</div>';
            return;
        }
        
        echo '<div class="inquiries-dashboard" style="font-family: Vazirmatn, sans-serif;">';
        
        foreach ($recent_inquiries as $inquiry) {
            $data = json_decode($inquiry->post_content, true);
            if ($data) {
                $urgency_colors = array(
                    'normal' => '#28a745',
                    'urgent' => '#ffc107', 
                    'emergency' => '#dc3545'
                );
                $urgency_labels = array(
                    'normal' => 'عادی',
                    'urgent' => 'فوری',
                    'emergency' => 'اضطراری'
                );
                
                $urgency = $data['urgency'] ?? 'normal';
                $color = $urgency_colors[$urgency];
                $label = $urgency_labels[$urgency];
                $type_icon = $data['type'] === 'mobile_order' ? 'mobile-alt' : 'tools';
                
                echo '<div class="inquiry-dashboard-item">';
                echo '<div class="inquiry-icon">';
                echo '<i class="fa-solid fa-' . $type_icon . '"></i>';
                echo '</div>';
                echo '<div class="inquiry-details">';
                echo '<div class="inquiry-header">';
                echo '<strong>' . esc_html($data['name']) . '</strong>';
                echo '<span class="urgency-badge" style="background: ' . $color . '; color: ' . ($urgency === 'urgent' ? '#000' : '#fff') . ';">' . $label . '</span>';
                echo '</div>';
                echo '<div class="inquiry-meta">';
                echo '<span class="service-name">' . esc_html($data['service_name'] ?? 'عمومی') . '</span>';
                echo '<span class="contact-info">';
                echo '<i class="fa-solid fa-phone"></i> ' . esc_html($data['phone']);
                if (!empty($data['email'])) {
                    echo ' | <i class="fa-solid fa-envelope"></i> ' . esc_html($data['email']);
                }
                echo '</span>';
                echo '</div>';
                echo '<div class="inquiry-time">';
                echo '<i class="fa-solid fa-clock"></i> ' . human_time_diff(strtotime($inquiry->post_date), current_time('timestamp')) . ' پیش';
                echo '</div>';
                echo '</div>';
                echo '<div class="inquiry-actions">';
                echo '<a href="' . admin_url('post.php?post=' . $inquiry->ID . '&action=edit') . '" class="inquiry-btn view" title="مشاهده جزئیات">';
                echo '<i class="fa-solid fa-eye"></i>';
                echo '</a>';
                echo '<a href="tel:' . esc_attr($data['phone']) . '" class="inquiry-btn call" title="تماس">';
                echo '<i class="fa-solid fa-phone"></i>';
                echo '</a>';
                if (!empty($data['email'])) {
                    echo '<a href="mailto:' . esc_attr($data['email']) . '" class="inquiry-btn email" title="ایمیل">';
                    echo '<i class="fa-solid fa-envelope"></i>';
                    echo '</a>';
                }
                echo '</div>';
                echo '</div>';
            }
        }
        
        echo '</div>';
        
        echo '<div class="inquiries-footer">';
        echo '<a href="' . admin_url('edit.php?post_type=service_inquiry') . '" class="button button-primary view-all-inquiries">';
        echo '<i class="fa-solid fa-list"></i> مشاهده همه درخواست‌ها (' . wp_count_posts('service_inquiry')->private . ')';
        echo '</a>';
        echo '</div>';
        
        ?>
        <style>
        .no-inquiries {
            text-align: center;
            padding: 2rem;
            color: #666;
        }
        
        .no-inquiries i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }
        
        .inquiries-dashboard {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .inquiry-dashboard-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        
        .inquiry-dashboard-item:hover {
            background: rgba(31, 165, 71, 0.05);
            border-color: #1FA547;
        }
        
        .inquiry-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1FA547, #178A3A);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .inquiry-details {
            flex: 1;
            min-width: 0;
        }
        
        .inquiry-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .inquiry-header strong {
            color: #333;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .urgency-badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .inquiry-meta {
            margin-bottom: 0.5rem;
        }
        
        .service-name {
            display: block;
            color: #1FA547;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .contact-info {
            display: block;
            color: #666;
            font-size: 0.75rem;
        }
        
        .contact-info i {
            color: #1FA547;
            margin-left: 0.25rem;
        }
        
        .inquiry-time {
            color: #999;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .inquiry-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        
        .inquiry-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .inquiry-btn.view {
            background: #17a2b8;
            color: white;
        }
        
        .inquiry-btn.call {
            background: #007bff;
            color: white;
        }
        
        .inquiry-btn.email {
            background: #dc3545;
            color: white;
        }
        
        .inquiry-btn:hover {
            transform: scale(1.1);
        }
        
        .inquiries-footer {
            text-align: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        
        .view-all-inquiries {
            background: #1FA547 !important;
            border-color: #1FA547 !important;
        }
        </style>
        <?php
    }

    /**
     * Dashboard Quick Stats Widget
     */
    public function dashboard_quick_stats_widget() {
        // Calculate various statistics
        $total_views = 0;
        $posts = get_posts(array('posts_per_page' => -1, 'fields' => 'ids'));
        foreach ($posts as $post_id) {
            $views = get_post_meta($post_id, 'post_views', true) ?: 0;
            $total_views += intval($views);
        }
        
        $popular_services = get_posts(array(
            'post_type' => 'services',
            'posts_per_page' => 3,
            'meta_key' => 'post_views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        ));
        
        $recent_subscribers = count(get_option('teznevisan_newsletter_phones', array()));
        $conversion_rate = $recent_subscribers > 0 ? round(($recent_subscribers / max(1, $total_views)) * 100, 2) : 0;
        
        ?>
        <div class="quick-stats-widget">
            <div class="stats-summary">
                <div class="summary-item">
                    <div class="summary-icon views">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <div class="summary-data">
                        <span class="summary-number"><?php echo number_format($total_views); ?></span>
                        <span class="summary-label">بازدید کل</span>
                    </div>
                </div>
                
                <div class="summary-item">
                    <div class="summary-icon conversion">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="summary-data">
                        <span class="summary-number"><?php echo $conversion_rate; ?>%</span>
                        <span class="summary-label">نرخ تبدیل</span>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($popular_services)) : ?>
            <div class="popular-services">
                <h5><i class="fa-solid fa-fire"></i> محبوب‌ترین خدمات</h5>
                <div class="services-list">
                    <?php foreach ($popular_services as $index => $service) : 
                        $views = get_post_meta($service->ID, 'post_views', true) ?: 0;
                    ?>
                        <div class="service-item">
                            <span class="service-rank"><?php echo $index + 1; ?></span>
                            <div class="service-info">
                                <a href="<?php echo admin_url('post.php?post=' . $service->ID . '&action=edit'); ?>">
                                    <?php echo esc_html(get_the_title($service)); ?>
                                </a>
                                <small><?php echo number_format($views); ?> بازدید</small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <style>
        .quick-stats-widget {
            font-family: "Vazirmatn", sans-serif;
        }
        
        .stats-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .summary-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }
        
        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }
        
        .summary-icon.views {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        
        .summary-icon.conversion {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        
        .summary-data {
            flex: 1;
        }
        
        .summary-number {
            display: block;
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            line-height: 1;
        }
        
        .summary-label {
            font-size: 0.8rem;
            color: #666;
        }
        
        .popular-services h5 {
            margin: 0 0 1rem 0;
            color: #333;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .popular-services h5 i {
            color: #ff6b6b;
        }
        
        .services-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .service-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .service-item:hover {
            background: rgba(31, 165, 71, 0.05);
            border-color: #1FA547;
        }
        
        .service-rank {
            width: 24px;
            height: 24px;
            background: #1FA547;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        
        .service-info {
            flex: 1;
        }
        
        .service-info a {
            display: block;
            color: #333;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .service-info a:hover {
            color: #1FA547;
        }
        
        .service-info small {
            color: #666;
            font-size: 0.7rem;
        }
        </style>
        <?php
    }

    /**
     * Dashboard Quick Actions Widget
     */
    public function dashboard_quick_actions_widget() {
        $quick_actions = array(
            array(
                'title' => 'ایجاد خدمت جدید',
                'url' => admin_url('post-new.php?post_type=services'),
                'icon' => 'fa-solid fa-plus-circle',
                'color' => '#1FA547',
                'description' => 'افزودن خدمت جدید به سایت'
            ),
            array(
                'title' => 'نوشتن مقاله',
                'url' => admin_url('post-new.php'),
                'icon' => 'fa-solid fa-edit',
                'color' => '#007bff',
                'description' => 'انتشار مقاله جدید در وبلاگ'
            ),
            array(
                'title' => 'تنظیمات تم',
                'url' => admin_url('customize.php'),
                'icon' => 'fa-solid fa-palette',
                'color' => '#6f42c1',
                'description' => 'شخصی‌سازی ظاهر سایت'
            ),
            array(
                'title' => 'مدیریت منوها',
                'url' => admin_url('nav-menus.php'),
                'icon' => 'fa-solid fa-bars',
                'color' => '#fd7e14',
                'description' => 'ویرایش منوهای سایت'
            ),
            array(
                'title' => 'آمار و گزارشات',
                'url' => admin_url('edit.php?post_type=service_inquiry'),
                'icon' => 'fa-solid fa-chart-bar',
                'color' => '#20c997',
                'description' => 'مشاهده آمار عملکرد'
            ),
            array(
                'title' => 'مشاهده سایت',
                'url' => home_url(),
                'icon' => 'fa-solid fa-external-link-alt',
                'color' => '#17a2b8',
                'description' => 'بازدید از سایت'
            )
        );
        
        echo '<div class="quick-actions-dashboard">';
        foreach ($quick_actions as $action) {
            echo '<a href="' . esc_url($action['url']) . '" class="quick-action-card" target="' . (strpos($action['url'], home_url()) !== false ? '_blank' : '_self') . '">';
            echo '<div class="action-icon" style="background: ' . esc_attr($action['color']) . ';">';
            echo '<i class="' . esc_attr($action['icon']) . '"></i>';
            echo '</div>';
            echo '<div class="action-content">';
            echo '<h6>' . esc_html($action['title']) . '</h6>';
            echo '<p>' . esc_html($action['description']) . '</p>';
            echo '</div>';
            echo '<div class="action-arrow">';
            echo '<i class="fa-solid fa-chevron-left"></i>';
            echo '</div>';
            echo '</a>';
        }
        echo '</div>';
        
        ?>
        <style>
        .quick-actions-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            font-family: "Vazirmatn", sans-serif;
        }
        
        .quick-action-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: 1px solid #e9ecef;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .quick-action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(31, 165, 71, 0.05), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #1FA547;
        }
        
        .quick-action-card:hover::before {
            opacity: 1;
        }
        
        .action-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }
        
        .action-content {
            flex: 1;
            position: relative;
            z-index: 1;
        }
        
        .action-content h6 {
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
        }
        
        .action-content p {
            margin: 0;
            font-size: 0.75rem;
            color: #666;
            line-height: 1.4;
        }
        
        .action-arrow {
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s ease;
            color: #1FA547;
            position: relative;
            z-index: 1;
        }
        
        .quick-action-card:hover .action-arrow {
            opacity: 1;
            transform: translateX(0);
        }
        </style>
        <?php
    }

    /**
     * Admin Menu Management
     */
    public function add_admin_menu() {
        add_theme_page(
            'تنظیمات آیکون‌های منو',
            'آیکون‌های منو',
            'manage_options',
            'teznevisan-menu-icons',
            array($this, 'menu_icons_admin_page')
        );
        
        add_theme_page(
            'گزارشات و آمار',
            'گزارشات',
            'manage_options',
            'teznevisan-reports',
            array($this, 'reports_admin_page')
        );
        
        add_theme_page(
            'تنظیمات پیشرفته',
            'تنظیمات پیشرفته',
            'manage_options',
            'teznevisan-advanced',
            array($this, 'advanced_settings_page')
        );
        add_menu_page(
            'تنظیمات تزنویسان',
            'تزنویسان',
            'manage_options',
            'teznevisan-settings',
            array($this, 'admin_page_callback'),
            'dashicons-admin-generic',
            30
        );
    }

    /**
     * Menu Icons Admin Page
     */
    public function menu_icons_admin_page() {
        $menu_icons = get_option('teznevisan_menu_icons', array());
        $available_icons = $this->get_fontawesome_icons();
        
        ?>
        <div class="wrap teznevisan-admin-page">
            <h1><i class="fa-solid fa-icons"></i> تنظیمات آیکون‌های منو</h1>
            <p>آیکون‌های منوی اصلی سایت را تنظیم کنید.</p>
            
            <form method="post" action="" id="menu-icons-form">
                <?php wp_nonce_field('teznevisan_menu_icons', 'menu_icons_nonce'); ?>
                
                <div class="menu-icons-container">
                    <h3>آیکون‌های منوی اصلی</h3>
                    
                    <div class="icons-grid">
                        <?php 
                        $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary'] ?? '');
                        if ($menu_items) :
                            foreach ($menu_items as $item) :
                        ?>
                            <div class="icon-item">
                                <label><?php echo esc_html($item->title); ?></label>
                                <select name="menu_icons[<?php echo $item->ID; ?>]" class="icon-select">
                                    <option value="">انتخاب آیکون</option>
                                    <?php foreach ($available_icons as $class => $name) : ?>
                                        <option value="<?php echo esc_attr($class); ?>" 
                                                <?php selected(isset($menu_icons[$item->ID]) ? $menu_icons[$item->ID] : '', $class); ?>>
                                            <?php echo esc_html($name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="icon-preview">
                                    <i class="<?php echo esc_attr($menu_icons[$item->ID] ?? 'fa-solid fa-link'); ?>"></i>
                                </div>
                            </div>
                        <?php 
                            endforeach;
                        else :
                        ?>
                            <p>لطفاً ابتدا منوی اصلی را ایجاد کنید.</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="button button-primary">
                            <i class="fa-solid fa-save"></i>
                            ذخیره تنظیمات
                        </button>
                        <button type="button" class="button button-secondary" id="reset-icons">
                            <i class="fa-solid fa-undo"></i>
                            بازنشانی
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <style>
        .teznevisan-admin-page {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .teznevisan-admin-page h1 {
            color: #1FA547;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .menu-icons-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .icons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .icon-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .icon-item label {
            flex: 1;
            font-weight: 600;
            color: #333;
        }
        
        .icon-select {
            flex: 2;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .icon-preview {
            width: 40px;
            height: 40px;
            background: #1FA547;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            $('.icon-select').on('change', function() {
                const iconClass = $(this).val();
                const preview = $(this).siblings('.icon-preview').find('i');
                preview.attr('class', iconClass || 'fa-solid fa-link');
            });
            
            $('#reset-icons').on('click', function() {
                if (confirm('آیا از بازنشانی همه آیکون‌ها اطمینان دارید؟')) {
                    $('.icon-select').val('');
                    $('.icon-preview i').attr('class', 'fa-solid fa-link');
                }
            });
        });
        </script>
        <?php
    }

    /**
     * Reports Admin Page
     */
    public function reports_admin_page() {
        $total_inquiries = wp_count_posts('service_inquiry')->private ?? 0;
        $phone_subscribers = count(get_option('teznevisan_newsletter_phones', array()));
        $email_subscribers = count(get_option('teznevisan_newsletter_emails', array()));
        $form_logs = get_option('teznevisan_form_logs', array());
        
        // Calculate statistics
        $today_inquiries = get_posts(array(
            'post_type' => 'service_inquiry',
            'posts_per_page' => -1,
            'date_query' => array(
                array(
                    'after' => '24 hours ago'
                )
            ),
            'fields' => 'ids'
        ));
        
        $this_week_inquiries = get_posts(array(
            'post_type' => 'service_inquiry',
            'posts_per_page' => -1,
            'date_query' => array(
                array(
                    'after' => '1 week ago'
                )
            ),
            'fields' => 'ids'
        ));
        
        ?>
        <div class="wrap teznevisan-reports-page">
            <h1><i class="fa-solid fa-chart-line"></i> گزارشات و آمار سایت</h1>
            
            <div class="reports-grid">
                <!-- Statistics Overview -->
                <div class="report-card">
                    <div class="card-header">
                        <h3><i class="fa-solid fa-tachometer-alt"></i> آمار کلی</h3>
                    </div>
                    <div class="card-body">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $total_inquiries; ?></div>
                                <div class="stat-label">کل درخواست‌ها</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo count($today_inquiries); ?></div>
                                <div class="stat-label">درخواست‌های امروز</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo count($this_week_inquiries); ?></div>
                                <div class="stat-label">این هفته</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $phone_subscribers + $email_subscribers; ?></div>
                                <div class="stat-label">مشترکین</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Services -->
                <div class="report-card">
                    <div class="card-header">
                        <h3><i class="fa-solid fa-fire"></i> محبوب‌ترین خدمات</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        $popular_services = get_posts(array(
                            'post_type' => 'services',
                            'posts_per_page' => 5,
                            'meta_key' => 'post_views',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        ));
                        
                        if ($popular_services) :
                        ?>
                            <div class="services-ranking">
                                <?php foreach ($popular_services as $index => $service) : 
                                    $views = get_post_meta($service->ID, 'post_views', true) ?: 0;
                                ?>
                                    <div class="ranking-item">
                                        <span class="rank"><?php echo $index + 1; ?></span>
                                        <div class="service-details">
                                            <strong><?php echo esc_html(get_the_title($service)); ?></strong>
                                            <small><?php echo number_format($views); ?> بازدید</small>
                                        </div>
                                        <div class="popularity-bar">
                                            <div class="popularity-fill" style="width: <?php echo $index === 0 ? 100 : max(20, 100 - ($index * 15)); ?>%;"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p>آمار کافی برای نمایش وجود ندارد.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Form Submissions Chart -->
                <div class="report-card full-width">
                    <div class="card-header">
                        <h3><i class="fa-solid fa-chart-area"></i> روند ارسال فرم‌ها</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="submissions-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .teznevisan-reports-page {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin: 20px 0;
            font-family: "Vazirmatn", sans-serif;
        }
        
        .teznevisan-reports-page h1 {
            color: #1FA547;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .report-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .report-card.full-width {
            grid-column: 1 / -1;
        }
        
        .card-header {
            background: linear-gradient(135deg, #1FA547, #178A3A);
            color: white;
            padding: 1.5rem;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .stat-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1FA547;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #666;
        }
        
        .services-ranking {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .ranking-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .rank {
            width: 30px;
            height: 30px;
            background: #1FA547;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        
        .service-details {
            flex: 1;
        }
        
        .service-details strong {
            display: block;
            color: #333;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .service-details small {
            color: #666;
            font-size: 0.75rem;
        }
        
        .popularity-bar {
            width: 60px;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .popularity-fill {
            height: 100%;
            background: linear-gradient(90deg, #1FA547, #178A3A);
            transition: width 0.3s ease;
        }
        
        .chart-container {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            $('.icon-select').on('change', function() {
                const iconClass = $(this).val();
                const preview = $(this).siblings('.icon-preview').find('i');
                preview.attr('class', iconClass || 'fa-solid fa-link');
            });
            
            $('#menu-icons-form').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                formData.append('action', 'save_menu_icons');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('تنظیمات با موفقیت ذخیره شد!');
                        } else {
                            alert('خطا در ذخیره‌سازی: ' + response.data);
                        }
                    },
                    error: function() {
                        alert('خطا در ارسال درخواست');
                    }
                });
            });
        });
        </script>
        <?php
    }

    /**
     * Advanced Settings Page
     */
    public function advanced_settings_page() {
        ?>
        <div class="wrap teznevisan-advanced-page">
            <h1><i class="fa-solid fa-cogs"></i> تنظیمات پیشرفته</h1>
            
            <div class="advanced-settings-grid">
                <div class="settings-card">
                    <h3><i class="fa-solid fa-database"></i> مدیریت داده‌ها</h3>
                    <div class="settings-actions">
                        <button class="action-btn" id="export-data">
                            <i class="fa-solid fa-download"></i>
                            صادرات داده‌ها
                        </button>
                        <button class="action-btn" id="import-data">
                            <i class="fa-solid fa-upload"></i>
                            وارد کردن داده‌ها
                        </button>
                        <button class="action-btn danger" id="reset-theme">
                            <i class="fa-solid fa-refresh"></i>
                            بازنشانی تم
                        </button>
                    </div>
                </div>
                
                <div class="settings-card">
                    <h3><i class="fa-solid fa-shield-alt"></i> امنیت</h3>
                    <div class="security-status">
                        <div class="security-item">
                            <span>هدرهای امنیتی</span>
                            <span class="status active">فعال</span>
                        </div>
                        <div class="security-item">
                            <span>محافظت Brute Force</span>
                            <span class="status active">فعال</span>
                        </div>
                        <div class="security-item">
                            <span>فایروال</span>
                            <span class="status inactive">غیرفعال</span>
                        </div>
                    </div>
                </div>
                
                                <div class="settings-card">
                    <h3><i class="fa-solid fa-rocket"></i> عملکرد</h3>
                    <div class="performance-metrics">
                        <div class="metric">
                            <span class="metric-label">سرعت بارگذاری</span>
                            <div class="metric-bar">
                                <div class="metric-fill" style="width: 85%;"></div>
                            </div>
                            <span class="metric-value">85%</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">بهینه‌سازی تصاویر</span>
                            <div class="metric-bar">
                                <div class="metric-fill" style="width: 92%;"></div>
                            </div>
                            <span class="metric-value">92%</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">فشرده‌سازی</span>
                            <div class="metric-bar">
                                <div class="metric-fill" style="width: 78%;"></div>
                            </div>
                            <span class="metric-value">78%</span>
                        </div>
                    </div>
                </div>
                
                <div class="settings-card">
                    <h3><i class="fa-solid fa-tools"></i> ابزارهای توسعه</h3>
                    <div class="dev-tools">
                        <button class="tool-btn" id="clear-cache">
                            <i class="fa-solid fa-broom"></i>
                            پاک کردن کش
                        </button>
                        <button class="tool-btn" id="regenerate-thumbnails">
                            <i class="fa-solid fa-image"></i>
                            بازسازی تصاویر بندانگشتی
                        </button>
                        <button class="tool-btn" id="check-seo">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            بررسی SEO
                        </button>
                        <button class="tool-btn" id="optimize-database">
                            <i class="fa-solid fa-database"></i>
                            بهینه‌سازی دیتابیس
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .teznevisan-advanced-page {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin: 20px 0;
            font-family: "Vazirmatn", sans-serif;
        }
        
        .teznevisan-advanced-page h1 {
            color: #1FA547;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .advanced-settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .settings-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .settings-card h3 {
            background: linear-gradient(135deg, #1FA547, #178A3A);
            color: white;
            margin: 0;
            padding: 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .settings-actions {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-family: inherit;
        }
        
        .action-btn:hover {
            background: linear-gradient(135deg, #1FA547, #178A3A);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
        }
        
        .action-btn.danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }
        
        .action-btn.danger:hover {
            background: linear-gradient(135deg, #c82333, #a71e2a);
        }
        
        .security-status {
            padding: 1.5rem;
        }
        
        .security-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .security-item:last-child {
            border-bottom: none;
        }
        
        .status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status.active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status.inactive {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .performance-metrics {
            padding: 1.5rem;
        }
        
        .metric {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .metric:last-child {
            margin-bottom: 0;
        }
        
        .metric-label {
            flex: 1;
            font-size: 0.9rem;
            color: #333;
            font-weight: 500;
        }
        
        .metric-bar {
            flex: 2;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .metric-fill {
            height: 100%;
            background: linear-gradient(90deg, #1FA547, #178A3A);
            transition: width 0.3s ease;
        }
        
        .metric-value {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1FA547;
            min-width: 40px;
            text-align: center;
        }
        
        .dev-tools {
            padding: 1.5rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .tool-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            padding: 1.5rem 1rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        
        .tool-btn:hover {
            background: linear-gradient(135deg, #1FA547, #178A3A);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(31, 165, 71, 0.3);
        }
        
        .tool-btn i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .ranking-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 0.75rem;
        }
        
        .ranking-item:hover {
            background: rgba(31, 165, 71, 0.05);
            border-color: #1FA547;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            $('#export-data').on('click', function() {
                if (confirm('آیا می‌خواهید تمام داده‌های تم را صادر کنید؟')) {
                    // Implement export functionality
                    alert('قابلیت صادرات در نسخه آینده اضافه خواهد شد.');
                }
            });
            
            $('#clear-cache').on('click', function() {
                $(this).html('<i class="fa-solid fa-spinner fa-spin"></i> در حال پاک‌سازی...');
                
                // Simulate cache clearing
                setTimeout(() => {
                    $(this).html('<i class="fa-solid fa-check"></i> کش پاک شد!');
                    setTimeout(() => {
                        $(this).html('<i class="fa-solid fa-broom"></i> پاک کردن کش');
                    }, 2000);
                }, 1500);
            });
            
            $('#reset-theme').on('click', function() {
                if (confirm('هشدار: این عملیات تمام تنظیمات تم را بازنشانی خواهد کرد. آیا اطمینان دارید؟')) {
                    if (confirm('آیا از بازنشانی کامل تم اطمینان دارید؟ این عملیات قابل بازگشت نیست!')) {
                        // Implement reset functionality
                        alert('قابلیت بازنشانی در نسخه آینده اضافه خواهد شد.');
                    }
                }
            });
        });
        </script>
        <?php
    }

    /**
     * Get FontAwesome Icons List
     */
    private function get_fontawesome_icons() {
        return array(
            'fa-solid fa-home' => 'خانه',
            'fa-solid fa-tools' => 'خدمات',
            'fa-solid fa-blog' => 'وبلاگ',
            'fa-solid fa-info-circle' => 'درباره ما',
            'fa-solid fa-phone' => 'تماس',
            'fa-solid fa-envelope' => 'ایمیل',
            'fa-solid fa-user' => 'کاربر',
            'fa-solid fa-magnifying-glass' => 'جستجو',
            'fa-solid fa-shopping-cart' => 'سفارش',
            'fa-solid fa-graduation-cap' => 'تحصیلات',
            'fa-solid fa-book' => 'کتاب',
            'fa-solid fa-file-alt' => 'مقاله',
            'fa-solid fa-edit' => 'ویرایش',
            'fa-solid fa-translate' => 'ترجمه',
            'fa-solid fa-star' => 'ستاره',
            'fa-solid fa-heart' => 'قلب',
            'fa-solid fa-thumbs-up' => 'لایک',
            'fa-solid fa-share' => 'اشتراک',
            'fa-solid fa-download' => 'دانلود',
            'fa-solid fa-upload' => 'آپلود',
            'fa-solid fa-print' => 'چاپ',
            'fa-solid fa-save' => 'ذخیره',
            'fa-solid fa-cog' => 'تنظیمات',
            'fa-solid fa-lock' => 'قفل',
            'fa-solid fa-unlock' => 'باز کردن',
            'fa-solid fa-eye' => 'مشاهده',
            'fa-solid fa-eye-slash' => 'مخفی',
            'fa-solid fa-calendar' => 'تقویم',
            'fa-solid fa-clock' => 'ساعت',
            'fa-solid fa-map-marker-alt' => 'مکان',
            'fa-solid fa-globe' => 'وب‌سایت',
            'fa-brands fa-telegram' => 'تلگرام',
            'fa-brands fa-whatsapp' => 'واتساپ',
            'fa-brands fa-instagram' => 'اینستاگرام',
            'fa-brands fa-linkedin' => 'لینکدین',
            'fa-brands fa-twitter' => 'توییتر',
            'fa-brands fa-youtube' => 'یوتیوب'
        );
    }

    /**
     * Save Menu Icons
     */
    public function save_menu_icons() {
        if (!wp_verify_nonce($_POST['menu_icons_nonce'], 'teznevisan_menu_icons')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('دسترسی غیرمجاز');
        }
        
        $menu_icons = array();
        
        if (isset($_POST['menu_icons']) && is_array($_POST['menu_icons'])) {
            foreach ($_POST['menu_icons'] as $item_id => $icon_class) {
                if (!empty($icon_class)) {
                    $menu_item = wp_setup_nav_menu_item(get_post($item_id));
                    if ($menu_item && isset($menu_item->url)) {
                        $menu_icons[] = array(
                            'item_id' => absint($item_id),
                            'title' => sanitize_text_field($menu_item->title),
                            'url' => esc_url($menu_item->url),
                            'icon' => sanitize_text_field($icon_class)
                        );
                    }
                }
            }
        }
        
        update_option('teznevisan_menu_icons', $menu_icons);
        
        wp_send_json_success('آیکون‌های منو با موفقیت ذخیره شد');
    }


    /**
     * Send Customer Confirmation Email - Enhanced
     */
    private function send_customer_confirmation($data, $inquiry_id) {
        if (empty($data['email'])) return false;
        
        $subject = 'تایید دریافت درخواست شماره #' . $inquiry_id . ' - ' . get_bloginfo('name');

        $message = sprintf(
            'سلام %s،<br><br>درخواست شما با شناسه #%d با موفقیت دریافت شد.<br>کارشناسان ما به زودی با شما تماس خواهند گرفت.<br><br>با تشکر<br>تیم %s',
            $data['name'] ?? 'کاربر گرامی',
            $inquiry_id,
            get_bloginfo('name')
        );
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($data['email'], $subject, $message, $headers);
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <style>
                * { box-sizing: border-box; font-family: Tahoma, Arial; direction: rtl; }
                body { margin: 0; padding: 20px; background: #f8f9fa; line-height: 1.7; }
                .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #1FA547, #178A3A); color: white; padding: 3rem 2rem; text-align: center; position: relative; }
                .header::before { content: '✅'; position: absolute; top: 20px; right: 20px; font-size: 2rem; opacity: 0.3; }
                .header h2 { margin: 0 0 1rem 0; font-size: 1.8rem; font-weight: 700; }
                .header p { margin: 0; opacity: 0.9; font-size: 1.1rem; }
                .content { padding: 3rem 2rem; }
                .success-message { background: linear-gradient(135deg, #d4edda, #c3e6cb); border: 1px solid #c3e6cb; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; text-align: center; }
                .success-icon { font-size: 3rem; color: #28a745; margin-bottom: 1rem; }
                .tracking-box { background: #f8f9fa; border: 2px dashed #1FA547; border-radius: 12px; padding: 2rem; margin: 2rem 0; text-align: center; }
                .tracking-number { font-size: 1.5rem; font-weight: 700; color: #1FA547; margin-bottom: 0.5rem; }
                .summary-table { width: 100%; border-collapse: collapse; margin: 2rem 0; }
                .summary-table th, .summary-table td { padding: 1rem; border-bottom: 1px solid #e9ecef; text-align: right; }
                .summary-table th { background: #f8f9fa; font-weight: 600; color: #333; }
                .footer { background: #343a40; color: white; padding: 2rem; text-align: center; }
                .contact-info { display: flex; justify-content: center; gap: 2rem; margin-bottom: 1rem; flex-wrap: wrap; }
                .contact-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; }
                .contact-item i { color: #1FA547; }
                @media (max-width: 600px) { .contact-info { flex-direction: column; gap: 1rem; } }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>تایید دریافت درخواست</h2>
                    <p>درخواست شما با موفقیت ثبت شد</p>
                </div>
                
                <div class="content">
                    <div class="success-message">
                        <div class="success-icon">🎉</div>
                        <h3>جناب آقای/خانم <?php echo esc_html($data['name']); ?></h3>
                        <p>درخواست شما دریافت شد و در دست بررسی کارشناسان ما قرار گرفت.</p>
                    </div>
                    
                    <div class="tracking-box">
                        <h4>شماره پیگیری درخواست</h4>
                        <div class="tracking-number">#<?php echo $inquiry_id; ?></div>
                        <p>این شماره را برای پیگیری نزد خود نگه دارید</p>
                    </div>
                    
                    <h4>خلاصه درخواست شما:</h4>
                    <table class="summary-table">
                        <?php if (!empty($data['service_name'])) : ?>
                        <tr>
                            <th>خدمت درخواستی:</th>
                            <td><?php echo esc_html($data['service_name']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>شماره تماس:</th>
                            <td><?php echo esc_html($data['phone']); ?></td>
                        </tr>
                        <?php if (!empty($data['major'])) : ?>
                        <tr>
                            <th>رشته تحصیلی:</th>
                            <td><?php echo esc_html($data['major']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($data['degree'])) : ?>
                        <tr>
                            <th>مقطع:</th>
                            <td><?php echo esc_html($data['degree']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($data['urgency'])) : ?>
                        <tr>
                            <th>اولویت:</th>
                            <td style="color: <?php echo $urgency_color; ?>; font-weight: 600;">
                                <?php echo esc_html($urgency_label); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>تاریخ ثبت:</th>
                            <td><?php echo jdate('j F Y - H:i'); ?></td>
                        </tr>
                    </table>
                    
                    <div style="background: linear-gradient(135deg, rgba(31, 165, 71, 0.1), rgba(23, 138, 58, 0.05)); border-radius: 12px; padding: 2rem; margin: 2rem 0; border-right: 4px solid #1FA547;">
                        <h4 style="color: #1FA547; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-clock"></i>
                            مراحل بعدی:
                        </h4>
                        <ul style="margin: 0; padding-right: 1.5rem; color: #495057;">
                            <li>بررسی درخواست توسط کارشناسان (۱-۲ ساعت)</li>
                            <li>تماس تلفنی برای بررسی جزئیات</li>
                            <li>ارائه پیشنهاد قیمت و زمان‌بندی</li>
                            <li>شروع کار پس از تأیید شما</li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer">
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <span><?php echo get_theme_mod('phone_number', '09331663849'); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span><?php echo get_theme_mod('email_address', 'setinco@gmail.com'); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fa-solid fa-globe"></i>
                            <span><?php echo str_replace(['http://', 'https://'], '', home_url()); ?></span>
                        </div>
                    </div>
                    <p style="margin: 1rem 0 0 0; font-size: 0.85rem; opacity: 0.8;">
                        با تشکر از اعتماد شما به <?php echo get_bloginfo('name'); ?><br>
                        <small>این ایمیل به صورت خودکار ارسال شده است.</small>
                    </p>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    /**
     * Theme Activation
     */
    public function theme_activation() {
        // Set default theme options
        $defaults = array(
            'phone_number' => '09331663849',
            'email_address' => 'setinco@gmail.com',
            'telegram_url' => 'https://t.me/Thesissupport',
            'eitaa_url' => 'https://eitaa.com/Teznevs',
            'address' => 'ایران، یزد، خیابان مطهری',
            'working_hours' => 'شنبه تا پنج‌شنبه: ۸ تا ۲۰',
            'footer_about_text' => 'تیم متخصص تزنویسان با بیش از ۴۵۰ پژوهشگر و استاد مجرب، آماده ارائه بهترین خدمات در تمامی رشته‌ها و مقاطع تحصیلی با تضمین کیفیت و اصالت است.',
            'enable_sticky_header' => true,
            'enable_header_search' => true,
            'enable_menu_icons' => true,
            'footer_show_logo' => true,
            'footer_show_social' => true,
            'footer_show_trust_badges' => true
        );
        
        foreach ($defaults as $option => $value) {
            if (!get_theme_mod($option)) {
                set_theme_mod($option, $value);
            }
        }
        foreach ($default_pages as $title => $slug) {
            if (!get_page_by_path($slug)) {
                wp_insert_post(array(
                    'post_title' => $title,
                    'post_name' => $slug,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'page'
                ));
            }
        }
        
        // Create required directories
        $this->create_required_directories();
        
        // Create required files
        $this->create_required_files();
        
        // Flush rewrite rules
        flush_rewrite_rules(true);
        update_option('teznevisan_rewrite_flushed', true);
        
        // Set up default menus if they don't exist
        $this->setup_default_menus();
        
        // Import sample data if requested
        $this->import_sample_data();
    }

    /**
     * Theme Deactivation Cleanup
     */
    public function theme_deactivation() {
        // Clean up transients
        delete_transient('teznevisan_performance_cache');
        
        // Log deactivation
        update_option('teznevisan_last_deactivated', current_time('mysql'));
        
        // Cleanup operations
        flush_rewrite_rules();
    }

    /**
     * Create Required Directories
     */
    private function create_required_directories() {
        $theme_dir = get_template_directory();
        
        $directories = array(
            '/admin',
            '/assets',
            '/assets/css',
            '/assets/js',
            '/assets/images',
            '/assets/fonts',
            '/includes',
            '/templates',
            '/languages'
        );
        
        foreach ($directories as $dir) {
            $full_path = $theme_dir . $dir;
            if (!file_exists($full_path)) {
                wp_mkdir_p($full_path);
            }
        }
        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Create Required Files
     */
    private function create_required_files() {
        $theme_dir = get_template_directory();
        
        // Create main.css if it doesn't exist
        $main_css_path = $theme_dir . '/main.css';
        if (!file_exists($main_css_path)) {
            $main_css_content = $this->get_main_css_content();
            file_put_contents($main_css_path, $main_css_content);
        }
        
        // Create main.js if it doesn't exist
        $main_js_path = $theme_dir . '/assets/js/main.js';
        if (!file_exists($main_js_path)) {
            $main_js_content = $this->get_main_js_content();
            file_put_contents($main_js_path, $main_js_content);
        }
        
        // Create admin templates
        $this->create_admin_templates();
    }

    /**
     * Create Admin Templates
     */
    private function create_admin_templates() {
        $admin_dir = get_template_directory() . '/admin';
        
        // Create post meta fields template
        $post_meta_content = '<?php if (!defined("ABSPATH")) exit; ?>
        <div class="teznevisan-meta-fields">
            <p>فیلدهای متا برای مطالب در فایل functions.php تعریف شده‌اند.</p>
        </div>';
        
        if (!file_exists($admin_dir . '/post-meta-fields.php')) {
            file_put_contents($admin_dir . '/post-meta-fields.php', $post_meta_content);
        }
        
        // Create service meta fields template  
        $service_meta_content = '<?php if (!defined("ABSPATH")) exit; ?>
        <div class="service-meta-fields">
            <p>فیلدهای متا برای خدمات در فایل functions.php تعریف شده‌اند.</p>
        </div>';
        
        if (!file_exists($admin_dir . '/service-meta-fields.php')) {
            file_put_contents($admin_dir . '/service-meta-fields.php', $service_meta_content);
        }
    }

    /**
     * Setup Default Menus
     */
    private function setup_default_menus() {
        // Create default primary menu if it doesn't exist
        $menu_name = 'منوی اصلی';
        $menu_exists = wp_get_nav_menu_object($menu_name);
        
        if (!$menu_exists) {
            $menu_id = wp_create_nav_menu($menu_name);
            
            if (!is_wp_error($menu_id)) {
                // Add default menu items
                $menu_items = array(
                    array('title' => 'صفحه اصلی', 'url' => home_url('/'), 'menu-item-parent-id' => 0),
                    array('title' => 'خدمات', 'url' => get_post_type_archive_link('services'), 'menu-item-parent-id' => 0),
                    array('title' => 'وبلاگ', 'url' => get_permalink(get_option('page_for_posts')), 'menu-item-parent-id' => 0),
                    array('title' => 'درباره ما', 'url' => home_url('/about'), 'menu-item-parent-id' => 0),
                    array('title' => 'تماس با ما', 'url' => home_url('/contact'), 'menu-item-parent-id' => 0)
                );
                
                foreach ($menu_items as $item) {
                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' => $item['title'],
                        'menu-item-url' => $item['url'],
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => $item['menu-item-parent-id']
                    ));
                }
                
                // Assign menu to location
                $locations = get_theme_mod('nav_menu_locations');
                $locations['primary'] = $menu_id;
                set_theme_mod('nav_menu_locations', $locations);
            }
        }
    }

    /**
     * Import Sample Data
     */
    private function import_sample_data() {
        // Only import if no services exist
        $existing_services = get_posts(array('post_type' => 'services', 'posts_per_page' => 1));
        
        if (empty($existing_services)) {
            $sample_services = array(
                array(
                    'title' => 'نگارش پایان‌نامه',
                    'content' => 'خدمات کامل نگارش پایان‌نامه برای تمامی رشته‌ها و مقاطع تحصیلی',
                    'excerpt' => 'نگارش تخصصی پایان‌نامه با ضمانت کیفیت',
                    'meta' => array(
                        'service_subtitle' => 'تخصصی و با کیفیت',
                        'price_range_min' => 500000,
                        'price_range_max' => 2000000,
                        'delivery_time' => '۱۰ تا ۳۰ روز کاری'
                    )
                ),
                array(
                    'title' => 'نگارش مقاله علمی',
                    'content' => 'نگارش مقالات علمی برای انتشار در مجلات معتبر',
                    'excerpt' => 'مقاله‌نویسی حرفه‌ای با استانداردهای بین‌المللی',
                    'meta' => array(
                        'service_subtitle' => 'آماده انتشار در مجلات',
                        'price_range_min' => 300000,
                        'price_range_max' => 1500000,
                        'delivery_time' => '۷ تا ۲۱ روز کاری'
                    )
                ),
                array(
                    'title' => 'ترجمه تخصصی',
                    'content' => 'ترجمه تخصصی متون علمی و دانشگاهی',
                    'excerpt' => 'ترجمه دقیق و تخصصی با حفظ معنا',
                    'meta' => array(
                        'service_subtitle' => 'دقیق و روان',
                        'price_range_min' => 100000,
                        'price_range_max' => 800000,
                        'delivery_time' => '۳ تا ۱۰ روز کاری'
                    )
                )
            );
            
            foreach ($sample_services as $service) {
                $post_id = wp_insert_post(array(
                    'post_title' => $service['title'],
                    'post_content' => $service['content'],
                    'post_excerpt' => $service['excerpt'],
                    'post_status' => 'publish',
                    'post_type' => 'services'
                ));
                
                if ($post_id && !is_wp_error($post_id)) {
                    foreach ($service['meta'] as $key => $value) {
                        update_post_meta($post_id, $key, $value);
                    }
                }
            }
        }
    }

    /**
     * Get Main CSS Content
     */
    private function get_main_css_content() {
        return '/* Teznevisan Main CSS - Generated automatically */
:root {
    --primary-color: #1FA547;
    --primary-dark: #178A3A;
    --primary-light: #2FD65A;
    --bg-main: #FFFFFF;
    --bg-secondary: #F8F9FA;
    --text-primary: #212529;
    --text-secondary: #495057;
    --text-muted: #6C757D;
    --border-color: #DEE2E6;
    --success-color: #28A745;
    --warning-color: #FFC107;
    --error-color: #DC3545;
    --info-color: #17A2B8;
}

[data-theme="dark"] {
    --bg-main: #0D1117;
    --bg-secondary: #161B22;
    --text-primary: #F0F6FC;
    --text-secondary: #C9D1D9;
    --text-muted: #8B949E;
    --border-color: #30363D;
}

[data-theme="sepia"] {
    --bg-main: #F4ECD8;
    --bg-secondary: #EBE3D0;
    --text-primary: #3E2723;
    --text-secondary: #4E342E;
    --text-muted: #5D4037;
    --border-color: #BCAAA4;
}

* {
    box-sizing: border-box;
}

body {
    font-family: "Vazirmatn", "IRANSans", Tahoma, Arial, sans-serif;
    line-height: 1.6;
    color: var(--text-primary);
    background: var(--bg-main);
    margin: 0;
    padding: 0;
    direction: rtl;
    text-align: right;
}

/* Base Typography */
h1, h2, h3, h4, h5, h6 {
    font-family: inherit;
    font-weight: 700;
    line-height: 1.2;
    color: var(--text-primary);
    margin: 0 0 1rem 0;
}

p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
}

a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: var(--primary-dark);
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Button Styles */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    font-family: inherit;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
}

.btn-secondary {
    background: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Utility Classes */
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-left { text-align: left; }
.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: 1rem; }
.mb-2 { margin-bottom: 2rem; }
.mt-0 { margin-top: 0; }
.mt-1 { margin-top: 1rem; }
.mt-2 { margin-top: 2rem; }

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 0.5rem;
    }
}

/* Loading Animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 2s infinite linear;
}

/* Enhanced Form Styles */
input, select, textarea {
    font-family: inherit;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    padding: 0.75rem;
    transition: all 0.3s ease;
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

/* Admin Bar Compatibility */
@media screen and (min-width: 783px) {
    body.admin-bar .site-header {
        top: 32px;
    }
    
    body.admin-bar .main-content {
        margin-top: calc(100px + 32px);
    }
}

@media screen and (max-width: 782px) {
    body.admin-bar .site-header {
        top: 46px;
    }
    
    body.admin-bar .main-content {
        margin-top: calc(80px + 46px);
    }
}';
    }

    /**
     * Get Main JS Content
     */
    private function get_main_js_content() {
        return '/* Teznevisan Main JavaScript - Generated automatically */

document.addEventListener("DOMContentLoaded", function() {
    console.log("تزنویسان UI بارگذاری شد ✓");
    
    // Initialize all components
    initializeTheme();
    initializeModals();
    initializeForms();
    initializeAnimations();
    initializePerformance();
});

function initializeTheme() {
    // Theme mode functionality
    const modeButtons = document.querySelectorAll(".mode-btn");
    const savedTheme = localStorage.getItem("theme") || "light";
    
    document.documentElement.setAttribute("data-theme", savedTheme);
    modeButtons.forEach(btn => {
        btn.classList.toggle("active", btn.dataset.theme === savedTheme);
    });
    
    modeButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const theme = this.dataset.theme;
            document.documentElement.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
            
            modeButtons.forEach(b => b.classList.remove("active"));
            this.classList.add("active");
        });
    });
}

function initializeModals() {
    // Search modal
    const searchBtn = document.querySelector("[data-search-toggle]");
    const searchModal = document.getElementById("search-modal");
    const searchClose = document.querySelector(".search-modal-close");
    
    if (searchBtn && searchModal) {
        searchBtn.addEventListener("click", () => {
            searchModal.classList.add("active");
            document.body.style.overflow = "hidden";
        });
    }
    
    if (searchClose && searchModal) {
        searchClose.addEventListener("click", () => {
            searchModal.classList.remove("active");
            document.body.style.overflow = "";
        });
    }
    
    // Mobile menu
    const mobileToggle = document.querySelector(".mobile-menu-toggle-enhanced");
    const mobileMenu = document.querySelector(".mobile-menu-enhanced");
    const mobileClose = document.querySelector(".mobile-menu-close");
    
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener("click", () => {
            mobileToggle.classList.add("active");
            mobileMenu.classList.add("active");
            document.body.style.overflow = "hidden";
        });
    }
    
    if (mobileClose && mobileMenu) {
        mobileClose.addEventListener("click", () => {
            document.querySelector(".mobile-menu-toggle-enhanced").classList.remove("active");
            mobileMenu.classList.remove("active");
            document.body.style.overflow = "";
        });
    }
}

function initializeForms() {
    // Newsletter forms
    const newsletterForms = document.querySelectorAll(".footer-newsletter-form, .newsletter-popup-form");
    
    newsletterForms.forEach(form => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            handleNewsletterSubmission(this);
        });
    });
    
    // Contact forms
    const contactForms = document.querySelectorAll(".contact-form");
    
    contactForms.forEach(form => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            handleContactSubmission(this);
        });
    });
}

function handleNewsletterSubmission(form) {
    const phoneInput = form.querySelector("input[name=\"phone\"]");
    const submitBtn = form.querySelector("button[type=\"submit\"]");
    const phone = phoneInput.value.trim();
    
    if (!phone || !/^(\\+98|0)?9\\d{9}$/.test(phone)) {
        showNotification("لطفاً شماره تماس معتبر وارد کنید", "error");
        phoneInput.focus();
        return;
    }
    
    const originalText = submitBtn.textContent;
    submitBtn.textContent = "در حال ارسال...";
    submitBtn.disabled = true;
    
    const formData = new FormData();
    formData.append("action", "newsletter_signup");
    formData.append("phone", phone);
    formData.append("nonce", teznevisanAjax.nonce);
    
    fetch(teznevisanAjax.ajaxUrl, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.data.message, "success");
            phoneInput.value = "";
        } else {
            showNotification(data.data || "خطا در ثبت شماره", "error");
        }
    })
    .catch(error => {
        console.error("Newsletter error:", error);
        showNotification("خطا در ارسال درخواست", "error");
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

function handleContactSubmission(form) {
    const submitBtn = form.querySelector("button[type=\"submit\"]");
    const formData = new FormData(form);
    formData.append("action", "contact_form");
    formData.append("nonce", teznevisanAjax.nonce);
    
    const originalText = submitBtn.textContent;
    submitBtn.textContent = "در حال ارسال...";
    submitBtn.disabled = true;
    
    fetch(teznevisanAjax.ajaxUrl, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.data, "success");
            form.reset();
        } else {
            showNotification(data.data || "خطا در ارسال پیام", "error");
        }
    })
    .catch(error => {
        console.error("Contact error:", error);
        showNotification("خطا در ارسال پیام", "error");
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

function showNotification(message, type = "info") {
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fa-solid fa-${type === "success" ? "check-circle" : (type === "error" ? "exclamation-triangle" : "info-circle")}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i class="fa-solid fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto show
    setTimeout(() => notification.classList.add("show"), 100);
    
    // Auto hide
    setTimeout(() => {
        notification.classList.remove("show");
        setTimeout(() => notification.remove(), 300);
    }, 5000);
    
    // Manual close
    notification.querySelector(".notification-close").addEventListener("click", () => {
        notification.classList.remove("show");
        setTimeout(() => notification.remove(), 300);
    });
}

function initializeAnimations() {
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-in");
            }
        });
    }, observerOptions);
    
    // Observe elements
    document.querySelectorAll(".animate-on-scroll").forEach(el => {
        observer.observe(el);
    });
}

function initializePerformance() {
    // Lazy loading for images
    if ("IntersectionObserver" in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove("lazy");
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll("img[data-src]").forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Preload critical resources
    const criticalResources = [
        "/assets/css/critical.css",
        "/assets/js/critical.js"
    ];
    
    criticalResources.forEach(resource => {
        const link = document.createElement("link");
        link.rel = "preload";
        link.href = teznevisanAjax.themeUrl + resource;
        link.as = resource.endsWith(".css") ? "style" : "script";
        document.head.appendChild(link);
    });
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Export for use in other scripts
window.TeznevisanTheme = {
    showNotification,
    debounce,
    throttle
};';
    }
} // END OF TeznevisanTheme CLASS
// Initialize theme
$teznevisan_theme_instance = TeznevisanTheme::getInstance();


/**
 * AJAX Handlers
 */
class TezNevisanAjax
{
    public function __construct()
    {
        add_action('wp_ajax_contact_form', [$this, 'handleContactForm']);
        add_action('wp_ajax_nopriv_contact_form', [$this, 'handleContactForm']);
        add_action('wp_ajax_newsletter_signup', [$this, 'handleNewsletterSignup']);
        add_action('wp_ajax_nopriv_newsletter_signup', [$this, 'handleNewsletterSignup']);
        add_action('wp_ajax_service_inquiry', [$this, 'handleServiceInquiry']);
        add_action('wp_ajax_nopriv_service_inquiry', [$this, 'handleServiceInquiry']);
    }
    
    public function handleContactForm(): void
    {
        check_ajax_referer('teznevisan_nonce', 'nonce');
        
        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $subject = sanitize_text_field($_POST['subject'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');
        
        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(__('لطفاً تمام فیلدهای ضروری را تکمیل کنید', 'teznevisan'));
        }
        
        // Create contact submission
        $post_id = wp_insert_post([
            'post_title'   => sprintf(__('تماس از %s', 'teznevisan'), $name),
            'post_content' => $message,
            'post_type'    => 'contact_submissions',
            'post_status'  => 'private',
            'meta_input'   => [
                'contact_name'    => $name,
                'contact_email'   => $email,
                'contact_phone'   => $phone,
                'contact_subject' => $subject,
                'contact_ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
                'contact_date'    => current_time('mysql')
            ]
        ]);
        
        if ($post_id) {
            // Send notification email
            $to = get_option('admin_email');
            $email_subject = sprintf(__('تماس جدید از %s', 'teznevisan'), get_bloginfo('name'));
            $email_message = sprintf(
                __("تماس جدید دریافت شد:\n\nنام: %s\nایمیل: %s\nتلفن: %s\nموضوع: %s\n\nپیام:\n%s", 'teznevisan'),
                $name, $email, $phone, $subject, $message
            );
            
            wp_mail($to, $email_subject, $email_message);
            
            wp_send_json_success(__('پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.', 'teznevisan'));
        } else {
            wp_send_json_error(__('خطا در ارسال پیام. لطفاً دوباره تلاش کنید.', 'teznevisan'));
        }
    }
    
    public function handleNewsletterSignup(): void
    {
        check_ajax_referer('teznevisan_nonce', 'nonce');
        
        $email = sanitize_email($_POST['email'] ?? '');
        
        if (!is_email($email)) {
            wp_send_json_error(__('آدرس ایمیل معتبر نیست', 'teznevisan'));
        }
        
        // Check if already subscribed
        $existing = get_posts([
            'post_type'  => 'contact_submissions',
            'meta_key'   => 'newsletter_email',
            'meta_value' => $email,
            'numberposts' => 1
        ]);
        
        if (!empty($existing)) {
            wp_send_json_error(__('این ایمیل قبلاً ثبت شده است', 'teznevisan'));
        }
        
        $post_id = wp_insert_post([
            'post_title'  => sprintf(__('عضویت خبرنامه: %s', 'teznevisan'), $email),
            'post_type'   => 'contact_submissions', 
            'post_status' => 'private',
            'meta_input'  => [
                'newsletter_email' => $email,
                'signup_date'      => current_time('mysql'),
                'signup_ip'        => $_SERVER['REMOTE_ADDR'] ?? ''
            ]
        ]);
        
        if ($post_id) {
            wp_send_json_success(__('شما با موفقیت در خبرنامه عضو شدید', 'teznevisan'));
        } else {
            wp_send_json_error(__('خطا در ثبت عضویت', 'teznevisan'));
        }
    }
    
    public function handleServiceInquiry(): void
    {
        check_ajax_referer('teznevisan_nonce', 'nonce');
        
        $service_id = intval($_POST['service_id'] ?? 0);
        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');
        
        if (!$service_id || empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(__('لطفاً تمام فیلدها را تکمیل کنید', 'teznevisan'));
        }
        
        $service_title = get_the_title($service_id);
        
        $post_id = wp_insert_post([
            'post_title'   => sprintf(__('درخواست خدمت %s از %s', 'teznevisan'), $service_title, $name),
            'post_content' => $message,
            'post_type'    => 'contact_submissions',
            'post_status'  => 'private',
            'meta_input'   => [
                'inquiry_type'     => 'service',
                'service_id'       => $service_id,
                'service_title'    => $service_title,
                'client_name'      => $name,
                'client_email'     => $email,
                'client_phone'     => $phone,
                'inquiry_message'  => $message,
                'inquiry_date'     => current_time('mysql'),
                'inquiry_ip'       => $_SERVER['REMOTE_ADDR'] ?? ''
            ]
        ]);
        
        if ($post_id) {
            wp_send_json_success(__('درخواست شما ثبت شد. متخصصان ما به زودی با شما تماس خواهند گرفت.', 'teznevisan'));
        } else {
            wp_send_json_error(__('خطا در ثبت درخواست', 'teznevisan'));
        }
    }
}


/**
 * ENHANCED DYNAMIC MENU WALKER CLASS WITH COMPLETE SUBMENU SUPPORT
 */
class Teznevisan_Enhanced_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $css_class = $depth === 0 ? 'sub-menu dropdown-menu' : 'sub-menu nested-menu';
        $output .= "\n$indent<ul class=\"$css_class depth-$depth\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add dropdown class if item has children
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
            $classes[] = 'dropdown-parent';
        }
        
        // Add depth class
        $classes[] = 'menu-depth-' . $depth;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        // Enhanced auto icon detection
        $icon = $this->get_menu_item_icon($item);
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . ' class="nav-link depth-' . $depth . '">';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . $icon . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        
        // Add dropdown arrow for parent items
        if (in_array('menu-item-has-children', $classes)) {
            $arrow_class = $depth === 0 ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-left';
            $item_output .= ' <i class="' . $arrow_class . ' dropdown-arrow"></i>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= $item_output;
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
    

}

/**
 * Enhanced Widget Classes
 */
class Teznevisan_Enhanced_Newsletter_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'teznevisan_enhanced_newsletter',
            'خبرنامه پیشرفته تزنویسان',
            array('description' => 'ویجت خبرنامه با قابلیت‌های پیشرفته')
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'عضویت در خبرنامه';
        $description = !empty($instance['description']) ? $instance['description'] : 'شماره خود را وارد کنید';
        $show_stats = !empty($instance['show_stats']);
        $show_benefits = !empty($instance['show_benefits']);
        
        echo $args['before_widget'];
        ?>
        <div class="newsletter-widget-enhanced">
            <div class="widget-header">
                <div class="widget-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="widget-title-section">
                    <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
                    <p class="widget-description"><?php echo esc_html($description); ?></p>
                </div>
            </div>
            
            <?php if ($show_benefits) : ?>
            <div class="newsletter-benefits">
                <div class="benefit-item">
                    <i class="fa-solid fa-percentage"></i>
                    <span>تخفیف‌های ویژه</span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-bell"></i>
                    <span>اطلاع از مقالات جدید</span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-gift"></i>
                    <span>محتوای اختصاصی</span>
                </div>
            </div>
            <?php endif; ?>
            
            <form class="enhanced-newsletter-form" method="post" data-widget-newsletter>
                <div class="form-input-group">
                    <div class="input-icon">
                        <i class="fa-solid fa-mobile-alt"></i>
                    </div>
                    <input type="tel" name="phone" placeholder="۰۹۱۲۳۴۵۶۷۸۹" required>
                    <button type="submit" class="submit-btn">
                        <span class="btn-text">عضویت</span>
                        <span class="btn-loading"><i class="fa-solid fa-spinner fa-spin"></i></span>
                    </button>
                </div>
                <div class="form-note">
                    <i class="fa-solid fa-shield-alt"></i>
                    <span>اطلاعات شما محفوظ است</span>
                </div>
            </form>
            
            <?php if ($show_stats) : ?>
            <div class="newsletter-stats">
                <div class="stat">
                    <span class="stat-number"><?php echo get_theme_mod('newsletter_subscribers', '۱۰,۰۰۰+'); ?></span>
                    <span class="stat-label">مشترک</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?php echo get_theme_mod('newsletter_satisfaction', '۹۸%'); ?></span>
                    <span class="stat-label">رضایت</span>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <style>
        .newsletter-widget-enhanced {
            background: linear-gradient(135deg, var(--bg-main), var(--bg-secondary));
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .newsletter-widget-enhanced:hover {
            box-shadow: 0 8px 25px rgba(31, 165, 71, 0.15);
            border-color: var(--primary-color);
        }
        
        .widget-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .widget-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
        }
        
        .widget-title-section {
            flex: 1;
        }
        
        .widget-title {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .widget-description {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .newsletter-benefits {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }
        
        .benefit-item i {
            color: var(--primary-color);
            width: 16px;
            text-align: center;
        }
        
        .form-input-group {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--bg-main);
            border: 2px solid var(--border-color);
            border-radius: 25px;
            overflow: hidden;
            transition: border-color 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .form-input-group:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
        }
        
        .input-icon {
            padding: 0 1rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        
        .enhanced-newsletter-form input {
            flex: 1;
            padding: 1rem 0;
            border: none;
            background: transparent;
            font-family: inherit;
            color: var(--text-primary);
            font-size: 0.95rem;
            direction: rtl;
        }
        
        .enhanced-newsletter-form input:focus {
            outline: none;
        }
        
        .submit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .submit-btn:hover {
            background: var(--primary-dark);
        }
        
        .btn-text,
        .btn-loading {
            transition: all 0.3s ease;
        }
        
        .btn-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
        }
        
        .submit-btn.loading .btn-text {
            opacity: 0;
        }
        
        .submit-btn.loading .btn-loading {
            opacity: 1;
        }
        
        .form-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        .form-note i {
            color: #28a745;
        }
        
        .newsletter-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        </style>
        <?php
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'عضویت در خبرنامه';
        $description = !empty($instance['description']) ? $instance['description'] : 'شماره خود را وارد کنید';
        $show_stats = !empty($instance['show_stats']);
        $show_benefits = !empty($instance['show_benefits']);
        
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">عنوان:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>">توضیحات:</label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" 
                      name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_stats); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_stats')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_stats')); ?>" value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_stats')); ?>">نمایش آمار</label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_benefits); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_benefits')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_benefits')); ?>" value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_benefits')); ?>">نمایش مزایا</label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_textarea_field($new_instance['description']) : '';
        $instance['show_stats'] = (!empty($new_instance['show_stats'])) ? 1 : 0;
        $instance['show_benefits'] = (!empty($new_instance['show_benefits'])) ? 1 : 0;
        return $instance;
    }
}

/**
 * Popular Posts Widget
 */
class Teznevisan_Popular_Posts_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'teznevisan_popular_posts',
            'مطالب محبوب تزنویسان',
            array('description' => 'نمایش محبوب‌ترین مطالب بر اساس بازدید')
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'مطالب محبوب';
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;
        $show_views = !empty($instance['show_views']);
        $show_date = !empty($instance['show_date']);
        
        $popular_posts = get_posts(array(
            'posts_per_page' => $count,
            'meta_key' => 'post_views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'post_status' => 'publish'
        ));
        
        if (empty($popular_posts)) return;
        
        echo $args['before_widget'];
        ?>
        <div class="popular-posts-widget-enhanced">
            <h3 class="widget-title">
                <i class="fa-solid fa-fire"></i>
                <?php echo esc_html($title); ?>
            </h3>
            
            <div class="popular-posts-list">
                <?php foreach ($popular_posts as $index => $post) : 
                    $views = get_post_meta($post->ID, 'post_views', true) ?: 0;
                    $reading_time = teznevisan_reading_time_persian($post->ID);
                ?>
                    <article class="popular-post-item">
                        <div class="post-rank">
                            <span class="rank-number"><?php echo $index + 1; ?></span>
                        </div>
                        
                        <?php if (has_post_thumbnail($post)) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php echo get_permalink($post); ?>">
                                <?php echo get_the_post_thumbnail($post, 'thumbnail'); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <h4 class="post-title">
                                <a href="<?php echo get_permalink($post); ?>">
                                    <?php echo esc_html(get_the_title($post)); ?>
                                </a>
                            </h4>
                            
                            <div class="post-meta">
                                <?php if ($show_date) : ?>
                                <span class="post-date">
                                    <i class="fa-solid fa-calendar"></i>
                                    <?php echo get_the_date('j F Y', $post); ?>
                                </span>
                                <?php endif; ?>
                                
                                <?php if ($show_views) : ?>
                                <span class="post-views">
                                    <i class="fa-solid fa-eye"></i>
                                    <?php echo number_format($views); ?>
                                </span>
                                <?php endif; ?>
                                
                                <span class="reading-time">
                                    <i class="fa-solid fa-clock"></i>
                                    <?php echo $reading_time; ?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="widget-footer">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="view-all-posts">
                    مشاهده همه مطالب
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
        
        <style>
        .popular-posts-widget-enhanced {
            background: var(--bg-main);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .popular-posts-widget-enhanced .widget-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0 1.5rem 0;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .popular-posts-widget-enhanced .widget-title i {
            color: #ff6b6b;
        }
        
        .popular-posts-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .popular-post-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .popular-post-item:hover {
            background: rgba(31, 165, 71, 0.05);
            border-color: var(--primary-color);
            transform: translateX(-3px);
        }
        
        .post-rank {
            flex-shrink: 0;
        }
        
        .rank-number {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .post-thumbnail {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .post-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .popular-post-item:hover .post-thumbnail img {
            transform: scale(1.1);
        }
        
        .post-content {
            flex: 1;
            min-width: 0;
        }
        
        .post-title {
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.3;
        }
        
        .post-title a {
            color: var(--text-primary);
            text-decoration: none;
        }
        
        .post-title a:hover {
            color: var(--primary-color);
        }
        
        .post-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        
        .post-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .post-meta i {
            color: var(--primary-color);
            opacity: 0.8;
        }
        
        .widget-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }
        
        .view-all-posts {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .view-all-posts:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        </style>
        <?php
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'مطالب محبوب';
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;
        $show_views = !empty($instance['show_views']);
        $show_date = !empty($instance['show_date']);
        
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">عنوان:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">تعداد مطالب:</label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" 
                   type="number" min="1" max="20" value="<?php echo esc_attr($count); ?>">
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_views); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_views')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_views')); ?>" value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_views')); ?>">نمایش تعداد بازدید</label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_date); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>">نمایش تاریخ</label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 5;
        $instance['show_views'] = (!empty($new_instance['show_views'])) ? 1 : 0;
        $instance['show_date'] = (!empty($new_instance['show_date'])) ? 1 : 0;
        return $instance;
    }
}

/**
 * Fixed Asset Loading - NO CONFLICTS
 */
function teznevisan_fix_asset_loading() {
    // Remove problematic default scripts
    wp_dequeue_script('wp-embed');
    
    // Fix jQuery loading
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', TEZNEVISAN_ASSETS_URL . '/js//jquery/jquery.min.js', array(), '3.7.1', false);
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'teznevisan_fix_asset_loading', 1);

/**
 * Fix Font MIME Types
 */
function teznevisan_fix_font_mime_types() {
    add_action('wp_loaded', function() {
        if (strpos($_SERVER['REQUEST_URI'], '/assets/fonts/') !== false) {
            $file_path = TEZNEVISAN_THEME_DIR . $_SERVER['REQUEST_URI'];
            
            if (file_exists($file_path)) {
                $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                
                $font_mime_types = [
                    'woff2' => 'font/woff2',
                    'woff' => 'font/woff',
                    'ttf' => 'font/ttf',
                    'eot' => 'application/vnd.ms-fontobject',
                    'otf' => 'font/otf'
                ];
                
                if (isset($font_mime_types[$ext])) {
                    header('Content-Type: ' . $font_mime_types[$ext]);
                    header('Access-Control-Allow-Origin: *');
                    header('Cache-Control: public, max-age=31536000');
                    
                    readfile($file_path);
                    exit;
                }
            }
        }
    });
}
add_action('init', 'teznevisan_fix_font_mime_types');

/**
 * Enhanced Helper Functions
 */

// Safe post getter with enhanced error handling
function teznevisan_get_safe_post($post_id = null) {
    if ($post_id) {
        $post = get_post($post_id);
        if ($post && !is_wp_error($post)) {
            return $post;
        }
    }
    
    global $post;
    if ($post && is_object($post) && isset($post->ID)) {
        return $post;
    }
    
    $current_id = get_the_ID();
    if ($current_id) {
        $current_post = get_post($current_id);
        if ($current_post && !is_wp_error($current_post)) {
            return $current_post;
        }
    }
    
    return null;
}

// Enhanced theme option getter with type validation
function teznevisan_get_option($option_name, $default = '', $type = 'string') {
    $value = get_theme_mod($option_name, $default);
    
    switch ($type) {
        case 'boolean':
            return (bool) $value;
        case 'integer':
            return (int) $value;
        case 'float':
            return (float) $value;
        case 'array':
            return is_array($value) ? $value : array();
        default:
            return (string) $value;
    }
}

// Enhanced Persian reading time with word count accuracy
function teznevisan_reading_time_persian($post_id = null) {
    $post = teznevisan_get_safe_post($post_id);
    if (!$post) return '۰ دقیقه خواندن';
    
    // Check for manual reading time first
    $manual_time = get_post_meta($post->ID, 'reading_time', true);
    if ($manual_time && is_numeric($manual_time)) {
        $reading_time = intval($manual_time);
    } else {
        // Calculate automatically
        $content = $post->post_content;
        $word_count = str_word_count(strip_tags($content));
        $reading_time = max(1, ceil($word_count / 150)); // Minimum 1 minute
    }
    
    // Convert to Persian numbers
    $persian_numbers = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english_numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    
    $persian_time = str_replace($english_numbers, $persian_numbers, (string)$reading_time);
    
    return $persian_time . ' دقیقه خواندن';
}


// Enhanced post view functions with analytics
function teznevisan_get_post_views($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    if (!$post_id) return 0;
    
    $views = get_post_meta($post_id, 'post_views', true);
    return $views ? intval($views) : 0;
}

function teznevisan_get_post_mobile_views($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    if (!$post_id) return 0;
    
    $mobile_views = get_post_meta($post_id, 'post_mobile_views', true);
    return $mobile_views ? intval($mobile_views) : 0;
}

function teznevisan_get_unique_views($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    if (!$post_id) return 0;
    
    $unique_views = get_post_meta($post_id, 'post_unique_views', true);
    return is_array($unique_views) ? count($unique_views) : 0;
}

// Enhanced service functions
function teznevisan_get_service_price_range($service_id) {
    $price_min = get_post_meta($service_id, 'price_range_min', true);
    $price_max = get_post_meta($service_id, 'price_range_max', true);
    
    if (!$price_min || !$price_max) {
        return 'قیمت: تماس بگیرید';
    }
    
    $persian_numbers = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english_numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    
    $formatted_min = str_replace($english_numbers, $persian_numbers, number_format($price_min));
    $formatted_max = str_replace($english_numbers, $persian_numbers, number_format($price_max));
    
    return $formatted_min . ' تا ' . $formatted_max . ' تومان';
}

function teznevisan_get_service_features($service_id) {
    $features = get_post_meta($service_id, 'service_features', true);
    return is_array($features) ? $features : array();
}

function teznevisan_get_process_steps($service_id) {
    $steps = get_post_meta($service_id, 'process_steps', true);
    return is_array($steps) ? $steps : array();
}

function teznevisan_get_service_faq($service_id) {
    $faq = get_post_meta($service_id, 'service_faq', true);
    return is_array($faq) ? $faq : array();
}



// Enhanced notification system
function teznevisan_add_admin_notice($message, $type = 'info', $dismissible = true) {
    $class = 'notice notice-' . $type . ($dismissible ? ' is-dismissible' : '');
    
    add_action('admin_notices', function() use ($message, $class) {
        echo '<div class="' . esc_attr($class) . '">';
        echo '<p><strong>تزنویسان:</strong> ' . esc_html($message) . '</p>';
        echo '</div>';
    });
}

// Performance monitoring
function teznevisan_log_performance($event, $data = array()) {
    if (!WP_DEBUG) return;
    
    $log_entry = array(
        'event' => $event,
        'data' => $data,
        'timestamp' => microtime(true),
        'memory' => memory_get_usage(true),
        'peak_memory' => memory_get_peak_usage(true)
    );
    
    $logs = get_transient('teznevisan_performance_logs') ?: array();
    $logs[] = $log_entry;
    
    // Keep only last 50 entries
    $logs = array_slice($logs, -50);
    
    set_transient('teznevisan_performance_logs', $logs, HOUR_IN_SECONDS);
}

// Enhanced pagination
function teznevisan_pagination($args = array()) {
    global $wp_query;
    
    $defaults = array(
        'prev_text' => '<i class="fa-solid fa-chevron-right"></i> قبلی',
        'next_text' => 'بعدی <i class="fa-solid fa-chevron-left"></i>',
        'show_all' => false,
        'end_size' => 1,
        'mid_size' => 2,
        'type' => 'array'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $pages = paginate_links($args);
    
    if (is_array($pages)) {
        echo '<nav class="pagination-enhanced" role="navigation" aria-label="صفحه‌بندی">';
        echo '<ul class="pagination-list">';
        
        foreach ($pages as $page) {
            $class = strpos($page, 'current') !== false ? 'pagination-item active' : 'pagination-item';
            echo '<li class="' . $class . '">' . $page . '</li>';
        }
        
        echo '</ul>';
        echo '</nav>';
    }
}

/**
 * Theme Optimization Functions
 */

// Optimize images on upload
function teznevisan_optimize_uploaded_image($metadata, $attachment_id) {
    if (!get_theme_mod('enable_image_optimization', true)) {
        return $metadata;
    }
    
    $file_path = get_attached_file($attachment_id);
    $file_type = wp_check_filetype($file_path);
    
    if (in_array($file_type['type'], array('image/jpeg', 'image/png'))) {
        // Add WebP conversion logic here
        teznevisan_log_performance('image_optimization', array(
            'attachment_id' => $attachment_id,
            'file_type' => $file_type['type'],
            'file_size' => filesize($file_path)
        ));
    }
    
    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'teznevisan_optimize_uploaded_image', 10, 2);

// Enhanced cache management
function teznevisan_clear_theme_cache() {
    // Clear all theme-related transients
    $transients = array(
        'teznevisan_performance_logs',
        'teznevisan_menu_cache',
        'teznevisan_widget_cache',
        'teznevisan_customizer_cache'
    );
    
    foreach ($transients as $transient) {
        delete_transient($transient);
    }
    
    // Clear object cache if available
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
    
    teznevisan_add_admin_notice('کش تم با موفقیت پاک شد.', 'success');
}

// Database optimization
function teznevisan_optimize_database() {
    global $wpdb;
    
    // Clean up old revisions (keep only 3 per post)
    $wpdb->query("
        DELETE FROM {$wpdb->posts} 
        WHERE post_type = 'revision' 
        AND post_date < DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    
    // Clean up spam comments
    $wpdb->query("
        DELETE FROM {$wpdb->comments} 
        WHERE comment_approved = 'spam' 
        AND comment_date < DATE_SUB(NOW(), INTERVAL 7 DAY)
    ");
    
    // Clean up old transients
    $wpdb->query("
        DELETE FROM {$wpdb->options} 
        WHERE option_name LIKE '_transient_%' 
        AND option_value < UNIX_TIMESTAMP()
    ");
    
    // Optimize tables
    $wpdb->query("OPTIMIZE TABLE {$wpdb->posts}");
    $wpdb->query("OPTIMIZE TABLE {$wpdb->postmeta}");
    $wpdb->query("OPTIMIZE TABLE {$wpdb->options}");
    
    teznevisan_log_performance('database_optimization', array(
        'timestamp' => current_time('mysql'),
        'tables_optimized' => 3
    ));
    
    return true;
}

/**
 * Final Setup and Security
 */
function teznevisan_final_enhanced_setup() {
    // Security headers
    if (!is_admin() && !headers_sent()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        if (is_ssl()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }
    
    // Remove version information
    remove_action('wp_head', 'wp_generator');
    add_filter('the_generator', '__return_empty_string');
    
    // Hide login errors
    add_filter('login_errors', function() {
        return 'اطلاعات ورود اشتباه است.';
    });
    
    // Enhance search functionality
    add_filter('pre_get_posts', function($query) {
        if (!is_admin() && $query->is_main_query() && $query->is_search()) {
            $query->set('post_type', array('post', 'services', 'page'));
        }
        return $query;
    });
}
add_action('init', 'teznevisan_final_enhanced_setup');


// Enqueue styles and scripts
function teznevisan_scripts() {
    // Load jQuery properly
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', '/wp-content/themes/WPTeznevisan/assets/js/jquery/jquery.min.js', array(), '3.7.1', false);
    
    // Load fonts first (IRANSans + Roboto Slab)
    wp_enqueue_style('teznevisan-fonts', 
        get_template_directory_uri() . '/assets/css/fonts.css', 
        array(), TEZNEVISAN_VERSION
    );
    
    // Font Awesome 7 (Pro version for more icons, loading locally)
    wp_enqueue_style('font-awesome', 
        '/assets/fonts/fontawesome/css/all.css', 
        array(), '7.0.0'
    );
    
    // Main theme styles (depends on fonts)
    wp_enqueue_style('teznevisan-main', 
        get_template_directory_uri() . '/assets/css/main.css', 
        array('teznevisan-fonts'), TEZNEVISAN_VERSION
    );
    
    // Main JavaScript with Persian localization
    wp_enqueue_script('teznevisan-main', 
        get_template_directory_uri() . '/assets/js/main.js', 
        array('jquery'), TEZNEVISAN_VERSION, true
    );
    
    // Localize with Persian strings
    wp_localize_script('teznevisan-main', 'teznevisanAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('teznevisan_nonce'),
        'strings' => array(
            'loading' => __('در حال بارگذاری...', 'teznevisan'),
            'error' => __('خطایی رخ داد', 'teznevisan'),
            'success' => __('عملیات موفقیت‌آمیز بود', 'teznevisan'),
        )
    ));
}
add_action('wp_enqueue_scripts', 'teznevisan_scripts');


// Admin styles and scripts
    function teznevisan_admin_scripts($hook) {
    // Font Awesome for admin
    wp_enqueue_style('font-awesome-admin', 
        '/assets/fonts/fontawesome/css/all.css', 
        array(), '7.0.0'
    );
    
    // Persian fonts for admin
    wp_enqueue_style('teznevisan-admin-fonts', 
        get_template_directory_uri() . '/assets/css/fonts.css', 
        array(), TEZNEVISAN_VERSION
    );
    
    // Admin styles
    wp_enqueue_style('teznevisan-admin', 
        get_template_directory_uri() . '/assets/css/admin.css', 
        array('teznevisan-admin-fonts'), TEZNEVISAN_VERSION
    );
    
    // Admin JavaScript
    wp_enqueue_script('teznevisan-admin', 
        get_template_directory_uri() . '/assets/js/admin.js', 
        array('jquery'), TEZNEVISAN_VERSION, true
    );
    
    // Localize admin script
    wp_localize_script('teznevisan-admin', 'teznevisanAdmin', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('teznevisan_admin_nonce'),
        'strings' => array(
            'loading' => __('در حال بارگذاری...', 'teznevisan'),
            'saved' => __('ذخیره شد', 'teznevisan'),
            'error' => __('خطایی رخ داد', 'teznevisan'),
        )
    ));
}
add_action('admin_enqueue_scripts', 'teznevisan_admin_scripts');


// Force WordPress Admin Bar styles on frontend
function teznevisan_admin_bar_styles() {
    if (is_admin_bar_showing()) {
        ?>
        <style type="text/css">
            /* Persian font for admin bar texts */
            #wpadminbar, #wpadminbar * {
                font-family: "IRANSans", "Roboto Slab", sans-serif !important;
            }

            /* RTL direction for admin bar */
            #wpadminbar {
                direction: rtl !important;
            }

            /* Font Awesome 7 Pro for admin bar icons */
            #wpadminbar .dashicons,
            #adminmenu .dashicons {
                font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", "Font Awesome 7 Free" !important;
                font-weight: 900 !important;
                font-style: normal !important;
                font-variant: normal !important;
                text-rendering: auto !important;
                -webkit-font-smoothing: antialiased !important;
                -moz-osx-font-smoothing: grayscale !important;
            }

            /* Specific icon replacements with FA7 Pro Unicode */
            .dashicons-wordpress:before { content: "\f19a" !important; }  /* WordPress logo */
            .dashicons-admin-site:before { content: "\f0ac" !important; }  /* Site icon */
            .dashicons-dashboard:before { content: "\f3fd" !important; }   /* Dashboard icon */
            .dashicons-edit:before { content: "\f044" !important; }        /* Edit icon */
            .dashicons-admin-comments:before { content: "\f086" !important; } /* Comments icon */
        </style>
        <?php
    }
}
add_action('wp_head', 'teznevisan_admin_bar_styles');
add_action('admin_head', 'teznevisan_admin_bar_styles');



// Widget areas
function teznevisan_widgets_init() {
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'teznevisan'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'teznevisan'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 1', 'teznevisan'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here.', 'teznevisan'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 2', 'teznevisan'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here.', 'teznevisan'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 3', 'teznevisan'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here.', 'teznevisan'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'teznevisan_widgets_init');

// Custom post types
function teznevisan_custom_post_types() {
    // Services post type
    register_post_type('services', array(
        'labels' => array(
            'name'               => __('Services', 'teznevisan'),
            'singular_name'      => __('Service', 'teznevisan'),
            'menu_name'          => __('Services', 'teznevisan'),
            'add_new'            => __('Add New Service', 'teznevisan'),
            'add_new_item'       => __('Add New Service', 'teznevisan'),
            'edit_item'          => __('Edit Service', 'teznevisan'),
            'new_item'           => __('New Service', 'teznevisan'),
            'view_item'          => __('View Service', 'teznevisan'),
            'search_items'       => __('Search Services', 'teznevisan'),
            'not_found'          => __('No services found', 'teznevisan'),
            'not_found_in_trash' => __('No services found in trash', 'teznevisan'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'fa-hammer',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'       => array('slug' => 'services'),
        'show_in_rest'  => true,
    ));
    
    // Testimonials post type
    register_post_type('testimonials', array(
        'labels' => array(
            'name'               => __('Testimonials', 'teznevisan'),
            'singular_name'      => __('Testimonial', 'teznevisan'),
            'menu_name'          => __('Testimonials', 'teznevisan'),
            'add_new'            => __('Add New Testimonial', 'teznevisan'),
            'add_new_item'       => __('Add New Testimonial', 'teznevisan'),
            'edit_item'          => __('Edit Testimonial', 'teznevisan'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'fa-quote-right',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'show_in_rest'  => true,
    ));
}
add_action('init', 'teznevisan_custom_post_types');

// Custom taxonomies
function teznevisan_custom_taxonomies() {
    // Service categories
    register_taxonomy('service_category', 'services', array(
        'labels' => array(
            'name'              => __('Service Categories', 'teznevisan'),
            'singular_name'     => __('Service Category', 'teznevisan'),
            'search_items'      => __('Search Categories', 'teznevisan'),
            'all_items'         => __('All Categories', 'teznevisan'),
            'parent_item'       => __('Parent Category', 'teznevisan'),
            'parent_item_colon' => __('Parent Category:', 'teznevisan'),
            'edit_item'         => __('Edit Category', 'teznevisan'),
            'update_item'       => __('Update Category', 'teznevisan'),
            'add_new_item'      => __('Add New Category', 'teznevisan'),
            'new_item_name'     => __('New Category Name', 'teznevisan'),
            'menu_name'         => __('Categories', 'teznevisan'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'service-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'teznevisan_custom_taxonomies');



// Add rating to post
function teznevisan_add_post_rating($post_id, $rating) {
    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        return false;
    }
    
    $ratings = get_post_meta($post_id, '_post_ratings', true);
    if (!$ratings || !is_array($ratings)) {
        $ratings = array();
    }
    
    $ratings[] = (int) $rating;
    update_post_meta($post_id, '_post_ratings', $ratings);
    
    return true;
}

// AJAX handler for post rating
function teznevisan_ajax_rate_post() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $post_id = intval($_POST['post_id']);
    $rating = intval($_POST['rating']);
    
    if (!$post_id || !$rating) {
        wp_die('Invalid data');
    }
    
    $success = teznevisan_add_post_rating($post_id, $rating);
    
    if ($success) {
        $rating_data = teznevisan_get_post_rating($post_id);
        wp_send_json_success($rating_data);
    } else {
        wp_send_json_error('Failed to save rating');
    }
}
add_action('wp_ajax_rate_post', 'teznevisan_ajax_rate_post');
add_action('wp_ajax_nopriv_rate_post', 'teznevisan_ajax_rate_post');

// Persian date function
function teznevisan_persian_date($format = 'Y/m/d', $timestamp = null) {
    if ($timestamp === null) {
        $timestamp = time();
    }
    
    $persian_months = array(
        1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
        4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
        7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
        10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
    );
    
    $persian_days = array(
        'Sunday' => 'یکشنبه', 'Monday' => 'دوشنبه', 'Tuesday' => 'سه‌شنبه',
        'Wednesday' => 'چهارشنبه', 'Thursday' => 'پنج‌شنبه', 'Friday' => 'جمعه', 'Saturday' => 'شنبه'
    );
    
    // This is a simplified version - you may want to use a proper Persian calendar library
    $english_date = date($format, $timestamp);
    return $english_date; // Return English date for now - replace with proper Persian calendar conversion
}



// Add async and defer attributes to scripts
function teznevisan_script_loader_tag($tag, $handle, $src) {
    if ('teznevisan-main' === $handle) {
        return str_replace('<script ', '<script defer ', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'teznevisan_script_loader_tag', 10, 3);

// Optimize images
function teznevisan_image_quality($quality) {
    return 85;
}
add_filter('jpeg_quality', 'teznevisan_image_quality');
add_filter('wp_editor_set_quality', 'teznevisan_image_quality');

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary meta tags
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// Add security headers
function teznevisan_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
}
add_action('init', 'teznevisan_security_headers');

// Include additional files
$theme_includes = array(
    '/inc/customizer.php',
    '/inc/widgets.php',
    '/inc/ajax-handlers.php',
    '/inc/admin-functions.php',
);

foreach ($theme_includes as $file) {
    if (file_exists(get_template_directory() . $file)) {
        require_once get_template_directory() . $file;
    }
}

// Theme activation hook
function teznevisan_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'teznevisan_activation');

// Contact form handler (basic implementation)
function teznevisan_handle_contact_form() {
    if (isset($_POST['teznevisan_contact_form'])) {
        // Verify nonce
        if (!wp_verify_nonce($_POST['contact_nonce'], 'teznevisan_contact')) {
            wp_die('Security check failed');
        }
        
        // Sanitize input
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = sanitize_textarea_field($_POST['message']);
        
        // Basic validation
        if (empty($name) || empty($email) || empty($message)) {
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
            exit;
        }
        
        // Send email (basic implementation)
        $to = get_option('admin_email');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        $email_content = "نام: $name\n";
        $email_content .= "ایمیل: $email\n";
        $email_content .= "موضوع: $subject\n\n";
        $email_content .= "پیام:\n$message";
        
        $sent = wp_mail($to, 'تماس جدید از سایت', $email_content, $headers);
        
        if ($sent) {
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
        } else {
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        }
        exit;
    }
}
add_action('init', 'teznevisan_handle_contact_form');

// Add custom body classes
function teznevisan_body_classes($classes) {
    // Add Persian language class
    $classes[] = 'rtl';
    $classes[] = 'persian';
    
    // Add page-specific classes
    if (is_page_template()) {
        $template = str_replace('.php', '', basename(get_page_template()));
        $classes[] = 'page-template-' . $template;
    }
    
    // Add service-specific classes
    if (is_singular('services')) {
        $classes[] = 'single-service';
    }
    
    return $classes;
}
add_filter('body_class', 'teznevisan_body_classes');

// Custom admin footer text
function teznevisan_admin_footer_text() {
    echo 'Created by <a href="#" target="_blank">TezNevisan Team</a> | Powered by WordPress';
}
add_filter('admin_footer_text', 'teznevisan_admin_footer_text');

// Performance optimizations
function teznevisan_performance_optimizations() {
    // Remove unnecessary scripts and styles
    wp_deregister_script('wp-embed');
    
    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove jQuery migrate
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', includes_url('/wp-content/themes/WPTeznevisan/assets/js/jquery/jquery.min.js'), false, NULL, true);
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'teznevisan_performance_optimizations');

// Error handling for missing functions
if (!function_exists('wp_body_open')) {
    function wp_body_open() {
        do_action('wp_body_open');
    }
}

// Breadcrumbs function

function teznevisan_breadcrumb() {
    // اگر در صفحه اصلی هستیم، چیزی نمایش نده.
    if (is_front_page()) {
        return;
    }

    $delimiter = ' <span class="delimiter">›</span> ';
    
    echo '<nav class="breadcrumb-enhanced" aria-label="مسیر صفحه">';
    echo '<ol class="breadcrumb-list">';

    // آیتم صفحه اصلی
    echo '<li class="breadcrumb-item">';
    echo '<a href="' . esc_url(home_url('/')) . '">';
    echo '<i class="fa-solid fa-home"></i>';
    echo '<span>خانه</span>';
    echo '</a>';
    echo '</li>';

    // نان‌کوب برای انواع مختلف صفحات
    if (is_category()) {
        $thisCat = get_category(get_query_var('cat'));
        if ($thisCat->parent != 0) {
            $parent_cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
            echo str_replace('<a href', '<li class="breadcrumb-item"><a href', str_replace('</a>', '</a></li>', $parent_cats));
        }
        echo '<li class="breadcrumb-item active">';
        echo '<i class="fa-solid fa-folder"></i>';
        echo '<span>' . single_cat_title('', false) . '</span>';
        echo '</li>';

    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active">';
        echo '<i class="fa-solid fa-magnifying-glass"></i>';
        echo '<span>نتایج جستجو برای: «' . esc_html(get_search_query()) . '»</span>';
        echo '</li>';

    } elseif (is_day()) {
        echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
        echo $delimiter;
        echo '<li class="breadcrumb-item"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
        echo $delimiter;
        echo '<li class="breadcrumb-item active"><span>' . get_the_time('d') . '</span></li>';

    } elseif (is_month()) {
        echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
        echo $delimiter;
        echo '<li class="breadcrumb-item active"><span>' . get_the_time('F') . '</span></li>';

    } elseif (is_year()) {
        echo '<li class="breadcrumb-item active"><span>' . get_the_time('Y') . '</span></li>';

    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() === 'services') {
            echo '<li class="breadcrumb-item">';
            echo '<a href="' . esc_url(get_post_type_archive_link('services')) . '">';
            echo '<i class="fa-solid fa-tools"></i>';
            echo '<span>خدمات</span>';
            echo '</a>';
            echo '</li>';
            echo $delimiter;
        } elseif (get_post_type() === 'post') {
            $categories = get_the_category();
            if ($categories) {
                $category = $categories[0];
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">';
                echo '<i class="fa-solid fa-folder"></i>';
                echo '<span>' . esc_html($category->name) . '</span>';
                echo '</a>';
                echo '</li>';
                echo $delimiter;
            }
        } else {
            $post_type = get_post_type_object(get_post_type());
            if ($post_type) {
                echo '<li class="breadcrumb-item"><a href="' . get_post_type_archive_link($post_type->name) . '">' . $post_type->labels->singular_name . '</a></li>';
                echo $delimiter;
            }
        }
        echo '<li class="breadcrumb-item active">';
        echo '<i class="fa-solid fa-file-alt"></i>';
        echo '<span>' . esc_html(get_the_title()) . '</span>';
        echo '</li>';

    } elseif (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . esc_url(get_permalink($ancestor)) . '">';
                echo '<span>' . esc_html(get_the_title($ancestor)) . '</span>';
                echo '</a>';
                echo '</li>';
                echo $delimiter;
            }
        }
        echo '<li class="breadcrumb-item active">';
        echo '<i class="fa-solid fa-file"></i>';
        echo '<span>' . esc_html(get_the_title()) . '</span>';
        echo '</li>';

    } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        echo '<li class="breadcrumb-item"><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
        echo $delimiter;
        echo '<li class="breadcrumb-item active"><span>' . get_the_title() . '</span></li>';

    } elseif (is_tag()) {
        echo '<li class="breadcrumb-item active"><span>' . single_tag_title('', false) . '</span></li>';

    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo '<li class="breadcrumb-item active"><span>' . 'مقالات نویسنده: ' . $userdata->display_name . '</span></li>';

    } elseif (is_404()) {
        echo '<li class="breadcrumb-item active">';
        echo '<i class="fa-solid fa-exclamation-triangle"></i>';
        echo '<span>صفحه یافت نشد</span>';
        echo '</li>';
    }
    
    // نمایش شماره صفحه برای صفحات بایگانی چند صفحه‌ای
    if (get_query_var('paged')) {
        echo '<li class="breadcrumb-item">';
        echo '<span> (صفحه ' . get_query_var('paged') . ')</span>';
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

// Post rating functions
function teznevisan_get_post_rating($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $rating = get_post_meta($post_id, '_teznevisan_rating', true);
    return $rating ? floatval($rating) : 0;
}

function teznevisan_display_post_rating($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $rating = teznevisan_get_post_rating($post_id);
    $stars = '';
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<i class="fa-solid fa-star"></i>';
        } elseif ($i - 0.5 <= $rating) {
            $stars .= '<i class="fa-solid fa-star-half-alt"></i>';
        } else {
            $stars .= '<i class="fa-regular fa-star"></i>';
        }
    }
    
    return '<div class="post-rating" data-rating="' . $rating . '">' . $stars . '</div>';
}

// AJAX handler for post rating
function teznevisan_rate_post() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $post_id = intval($_POST['post_id']);
    $rating = floatval($_POST['rating']);
    
    if ($post_id && $rating >= 1 && $rating <= 5) {
        update_post_meta($post_id, '_teznevisan_rating', $rating);
        wp_send_json_success(array('message' => __('Rating saved successfully', 'teznevisan')));
    } else {
        wp_send_json_error(array('message' => __('Invalid rating data', 'teznevisan')));
    }
}
add_action('wp_ajax_rate_post', 'teznevisan_rate_post');
add_action('wp_ajax_nopriv_rate_post', 'teznevisan_rate_post');



// Custom post types and meta boxes
function teznevisan_create_post_types() {
    // Services post type
    register_post_type('service', array(
        'labels' => array(
            'name' => __('Services', 'teznevisan'),
            'singular_name' => __('Service', 'teznevisan'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'fa-gear',
    ));
}
add_action('init', 'teznevisan_create_post_types');

// Fix content width
function teznevisan_content_width() {
    $GLOBALS['content_width'] = apply_filters('teznevisan_content_width', 800);
}
add_action('after_setup_theme', 'teznevisan_content_width', 0);

// Remove WordPress emoji scripts
function teznevisan_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'teznevisan_disable_emojis');

// Custom excerpt length
function teznevisan_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'teznevisan_excerpt_length', 999);

// Custom excerpt more
function teznevisan_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'teznevisan_excerpt_more');

// Add meta boxes
function teznevisan_add_meta_boxes() {
    add_meta_box(
        'post-rating',
        __('Post Rating', 'teznevisan'),
        'teznevisan_post_rating_callback',
        'post'
    );
}
add_action('add_meta_boxes', 'teznevisan_add_meta_boxes');

function teznevisan_post_rating_callback($post) {
    wp_nonce_field('teznevisan_save_post_rating', 'teznevisan_post_rating_nonce');
    $rating = get_post_meta($post->ID, '_teznevisan_rating', true);
    echo '<label for="teznevisan_rating">' . __('Rating (1-5):', 'teznevisan') . '</label>';
    echo '<input type="number" id="teznevisan_rating" name="teznevisan_rating" value="' . esc_attr($rating) . '" min="1" max="5" step="0.5" />';
}

function teznevisan_save_post_rating($post_id) {
    if (!isset($_POST['teznevisan_post_rating_nonce']) || !wp_verify_nonce($_POST['teznevisan_post_rating_nonce'], 'teznevisan_save_post_rating')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['teznevisan_rating'])) {
        update_post_meta($post_id, '_teznevisan_rating', sanitize_text_field($_POST['teznevisan_rating']));
    }
}
add_action('save_post', 'teznevisan_save_post_rating');

// Force admin font to inherit theme font
function teznevisan_force_admin_font() {
    echo '<style>
    .wp-admin, .wp-admin * {
        font-family: "IRANSans", sans-serif !important;
    }
    .wp-admin .english-text, .wp-admin [lang="en"] {
        font-family: "Roboto Slab", serif !important;
    }
    </style>';
}
add_action('admin_head', 'teznevisan_force_admin_font');

// Security enhancements
function teznevisan_remove_version() {
    return '';
}
add_filter('the_generator', 'teznevisan_remove_version');

// Clean up head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
/**
 * Cron Job Setup
 */
function teznevisan_setup_cron_jobs() {
    // Weekly database optimization
    if (!wp_next_scheduled('teznevisan_weekly_optimization')) {
        wp_schedule_event(time(), 'weekly', 'teznevisan_weekly_optimization');
    }
    
    // Daily cleanup
    if (!wp_next_scheduled('teznevisan_daily_cleanup')) {
        wp_schedule_event(time(), 'daily', 'teznevisan_daily_cleanup');
    }
}
add_action('wp', 'teznevisan_setup_cron_jobs');

// Cron job callbacks
add_action('teznevisan_weekly_optimization', 'teznevisan_optimize_database');
add_action('teznevisan_daily_cleanup', function() {
    // Clean old logs
    $logs = get_option('teznevisan_form_logs', array());
    if (count($logs) > 100) {
        $logs = array_slice($logs, -50);
        update_option('teznevisan_form_logs', $logs);
    }
    
    // Clean old transients
    teznevisan_clear_theme_cache();
});

/**
 * Emergency Mode and Debug Functions
 */
function teznevisan_enable_emergency_mode() {
    update_option('teznevisan_emergency_mode', true);
    
    // Disable all non-essential features
    remove_all_actions('wp_footer');
    remove_all_actions('wp_head');
    
    // Keep only essential WordPress hooks
    add_action('wp_head', 'wp_enqueue_scripts');
    add_action('wp_head', 'wp_print_styles');
    add_action('wp_footer', 'wp_print_footer_scripts');
    
    teznevisan_add_admin_notice('حالت اضطراری فعال شد. تنها قابلیت‌های ضروری در دسترس هستند.', 'warning');
}

function teznevisan_disable_emergency_mode() {
    delete_option('teznevisan_emergency_mode');
    teznevisan_add_admin_notice('حالت اضطراری غیرفعال شد.', 'success');
}

// Debug information
function teznevisan_get_debug_info() {
    return array(
        'theme_version' => wp_get_theme()->get('Version'),
        'wordpress_version' => get_bloginfo('version'),
        'php_version' => PHP_VERSION,
        'mysql_version' => $GLOBALS['wpdb']->db_version(),
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'services_count' => wp_count_posts('services')->publish,
        'inquiries_count' => wp_count_posts('service_inquiry')->private,
        'active_plugins' => count(get_option('active_plugins', array())),
        'theme_options' => count(get_theme_mods()),
        'is_multisite' => is_multisite(),
        'is_ssl' => is_ssl(),
        'emergency_mode' => get_option('teznevisan_emergency_mode', false)
    );
}

/**
 * AJAX Endpoints for Admin
 */
add_action('wp_ajax_teznevisan_get_debug_info', function() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز');
    }
    
    wp_send_json_success(teznevisan_get_debug_info());
});

add_action('wp_ajax_teznevisan_clear_cache', function() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز');
    }
    
    teznevisan_clear_theme_cache();
    wp_send_json_success('کش با موفقیت پاک شد');
});

add_action('wp_ajax_teznevisan_optimize_db', function() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز');
    }
    
    $result = teznevisan_optimize_database();
    if ($result) {
        wp_send_json_success('دیتابیس بهینه‌سازی شد');
    } else {
        wp_send_json_error('خطا در بهینه‌سازی');
    }
});

/**
 * Notification System CSS - Global
 */
add_action('wp_head', function() {
    ?>
    <style>
    .notification {
        position: fixed;
        top: 20px;
        right: -400px;
        max-width: 400px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 10005;
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-right: 5px solid var(--primary-color);
        overflow: hidden;
        font-family: inherit;
    }
    
    .notification.show {
        right: 20px;
    }
    
    .notification-success {
        border-right-color: #28a745;
    }
    
    .notification-error {
        border-right-color: #dc3545;
    }
    
    .notification-warning {
        border-right-color: #ffc107;
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        color: var(--text-primary);
    }
    
    .notification-content i {
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .notification-success .notification-content i {
        color: #28a745;
    }
    
    .notification-error .notification-content i {
        color: #dc3545;
    }
    
    .notification-warning .notification-content i {
        color: #ffc107;
    }
    
    .notification-close {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.1);
        border: none;
        color: var(--text-muted);
        width: 25px;
        height: 25px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .notification-close:hover {
        background: rgba(0, 0, 0, 0.2);
        color: var(--text-primary);
    }
    
    @media (max-width: 480px) {
        .notification {
            right: -100%;
            left: 10px;
            right: 10px;
            max-width: none;
        }
        
        .notification.show {
            right: 10px;
        }
    }
    </style>
    <?php
});

/**
 * Enhanced Admin Bar Customization
 */
add_action('admin_bar_menu', function($wp_admin_bar) {
    if (!is_admin()) {
        // Add theme-specific menu
        $wp_admin_bar->add_menu(array(
            'id' => 'teznevisan-theme',
            'title' => '<i class="fa-solid fa-paint-brush"></i> تزنویسان',
            'href' => admin_url('customize.php'),
            'meta' => array(
                'class' => 'teznevisan-admin-bar-menu'
            )
        ));
        
        // Add quick actions
        $wp_admin_bar->add_menu(array(
            'parent' => 'teznevisan-theme',
            'id' => 'teznevisan-new-service',
            'title' => 'خدمت جدید',
            'href' => admin_url('post-new.php?post_type=services')
        ));
        
        $wp_admin_bar->add_menu(array(
            'parent' => 'teznevisan-theme',
            'id' => 'teznevisan-inquiries',
            'title' => 'درخواست‌ها',
            'href' => admin_url('edit.php?post_type=service_inquiry')
        ));
        
        $wp_admin_bar->add_menu(array(
            'parent' => 'teznevisan-theme',
            'id' => 'teznevisan-clear-cache',
            'title' => 'پاک کردن کش',
            'href' => '#',
            'meta' => array(
                'onclick' => 'teznevisanClearCache(); return false;'
            )
        ));
    }
}, 100);

/**
 * Enhanced CSS and JS minification
 */
if (get_theme_mod('enable_css_minification', false)) {
    add_filter('style_loader_tag', function($html, $handle) {
        if (strpos($handle, 'teznevisan') !== false) {
            return str_replace('rel=\'stylesheet\'', 'rel=\'stylesheet\' data-minified=\'true\'', $html);
        }
        return $html;
    }, 10, 2);
}

if (get_theme_mod('enable_js_minification', false)) {
    add_filter('script_loader_tag', function($tag, $handle) {
        if (strpos($handle, 'teznevisan') !== false) {
            return str_replace('<script', '<script data-minified="true"', $tag);
        }
        return $tag;
    }, 10, 2);
}

/**
 * Enhanced Error Handling and Logging
 */
function teznevisan_handle_error($error_message, $error_type = 'general', $context = array()) {
    $error_log = get_option('teznevisan_error_log', array());
    
    $error_entry = array(
        'message' => $error_message,
        'type' => $error_type,
        'context' => $context,
        'timestamp' => current_time('mysql'),
        'url' => $_SERVER['REQUEST_URI'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'ip' => $_SERVER['REMOTE_ADDR'] ?? ''
    );
    
    $error_log[] = $error_entry;
    
    // Keep only last 50 errors
    $error_log = array_slice($error_log, -50);
    
    update_option('teznevisan_error_log', $error_log);
    
    // Log to WordPress error log if debug is enabled
    if (WP_DEBUG_LOG) {
        error_log('Teznevisan Theme Error: ' . $error_message . ' | Context: ' . wp_json_encode($context));
    }
    
    // Send critical errors to admin email
    if ($error_type === 'critical') {
        $admin_email = get_option('admin_email');
        $subject = 'خطای بحرانی در سایت ' . get_bloginfo('name');
        $message = "خطای بحرانی در تم تزنویسان:\n\n";
        $message .= "پیام خطا: " . $error_message . "\n";
        $message .= "زمان: " . current_time('Y-m-d H:i:s') . "\n";
        $message .= "URL: " . ($_SERVER['REQUEST_URI'] ?? 'نامشخص') . "\n";
        $message .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'نامشخص') . "\n";
        
        wp_mail($admin_email, $subject, $message);
    }
}

/**
 * Backup and Restore Functions
 */
function teznevisan_create_settings_backup() {
    $backup_data = array(
        'theme_mods' => get_theme_mods(),
        'menus' => wp_get_nav_menus(),
        'widgets' => get_option('sidebars_widgets'),
        'custom_options' => array(
            'newsletter_phones' => get_option('teznevisan_newsletter_phones', array()),
            'newsletter_emails' => get_option('teznevisan_newsletter_emails', array()),
            'menu_icons' => get_option('teznevisan_menu_icons', array()),
            'form_logs' => get_option('teznevisan_form_logs', array())
        ),
        'timestamp' => current_time('mysql'),
        'version' => wp_get_theme()->get('Version')
    );
    
    $backup_file = 'teznevisan-backup-' . date('Y-m-d-H-i-s') . '.json';
    $backup_content = wp_json_encode($backup_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
    return array(
        'filename' => $backup_file,
        'content' => $backup_content,
        'size' => strlen($backup_content)
    );
}

function teznevisan_restore_settings_backup($backup_data) {
    try {
        if (isset($backup_data['theme_mods'])) {
            foreach ($backup_data['theme_mods'] as $mod_name => $mod_value) {
                set_theme_mod($mod_name, $mod_value);
            }
        }
        
        if (isset($backup_data['custom_options'])) {
            foreach ($backup_data['custom_options'] as $option_name => $option_value) {
                update_option('teznevisan_' . $option_name, $option_value);
            }
        }
        
        if (isset($backup_data['widgets'])) {
            update_option('sidebars_widgets', $backup_data['widgets']);
        }
        
        return true;
    } catch (Exception $e) {
        teznevisan_handle_error('خطا در بازگردانی تنظیمات: ' . $e->getMessage(), 'critical');
        return false;
    }
}

/**
 * Persian/Jalali Date Function (Enhanced)
 */
function jdate($format, $timestamp = null) {
    if ($timestamp === null) {
        $timestamp = time();
    }
    
    $persian_months = array(
        1 => 'ژانویه', 2 => 'فوریه', 3 => 'مارس', 4 => 'آوریل',
        5 => 'مه', 6 => 'ژوئن', 7 => 'ژوئیه', 8 => 'اوت', 
        9 => 'سپتامبر', 10 => 'اکتبر', 11 => 'نوامبر', 12 => 'دسامبر'
    );
    
    $persian_days = array(
        'Saturday' => 'شنبه',
        'Sunday' => 'یکشنبه', 
        'Monday' => 'دوشنبه',
        'Tuesday' => 'سه‌شنبه',
        'Wednesday' => 'چهارشنبه',
        'Thursday' => 'پنج‌شنبه',
        'Friday' => 'جمعه'
    );
    
    $english_numbers = array('0','1','2','3','4','5','6','7','8','9');
    $persian_numbers = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
    
    $formatted_date = date($format, $timestamp);
    
    // Replace month names
    foreach ($persian_months as $month_num => $persian_month) {
        $english_month = date('F', mktime(0, 0, 0, $month_num, 1));
        $formatted_date = str_replace($english_month, $persian_month, $formatted_date);
    }
    
    // Replace day names
    foreach ($persian_days as $english_day => $persian_day) {
        $formatted_date = str_replace($english_day, $persian_day, $formatted_date);
    }
    
    // Replace numbers
    $formatted_date = str_replace($english_numbers, $persian_numbers, $formatted_date);
    
    return $formatted_date;
}

// Ensure no closing PHP tag for best practices
new TezNevisanAjax();

/**
 * Register Navigation Menus
 */
function teznevisan_register_nav_menus() {
    register_nav_menus(array(
        'primary' => esc_html__('منوی اصلی', 'teznevisan'),
        'footer' => esc_html__('منوی فوتر', 'teznevisan'),
        'mobile' => esc_html__('منوی موبایل', 'teznevisan'),
        'sidebar' => esc_html__('منوی کناری', 'teznevisan'),
        'top' => esc_html__('منوی بالا', 'teznevisan'),
    ));
}
add_action('after_setup_theme', 'teznevisan_register_nav_menus');

/**
 * Enhanced Walker for Navigation Menu
 */
class TeznevisanMobileMenuWalker extends Walker_Nav_Menu {
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'mobile-menu-item-' . $item->ID;
        
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-submenu';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'mobile-menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        // Get menu item icon
        $icon = $this->get_mobile_menu_icon($item->title);
        
        $item_output = '<a class="mobile-nav-link"' . $attributes . '>';
        $item_output .= $icon;
        $item_output .= '<span>' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
        
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<i class="fa-solid fa-chevron-left submenu-arrow"></i>';
        }
        
        $item_output .= '</a>';
        
        $output .= $item_output;
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
    
    private function get_mobile_menu_icon($title) {
        $title_lower = strtolower($title);
        
        $icon_mapping = array(
            'خانه' => 'fa-solid fa-house',
            'home' => 'fa-solid fa-house',
            'خدمات' => 'fa-solid fa-gear',
            'services' => 'fa-solid fa-gear',
            'درباره' => 'fa-solid fa-circle-info',
            'about' => 'fa-solid fa-circle-info',
            'تماس' => 'fa-solid fa-envelope',
            'contact' => 'fa-solid fa-envelope',
            'وبلاگ' => 'fa-solid fa-blog',
            'blog' => 'fa-solid fa-blog',
            'نمونه' => 'fa-solid fa-briefcase',
            'portfolio' => 'fa-solid fa-briefcase'
        );
        
        foreach ($icon_mapping as $keyword => $icon) {
            if (strpos($title_lower, $keyword) !== false) {
                return '<i class="' . esc_attr($icon) . '"></i>';
            }
        }
        
        return '<i class="fa-solid fa-circle"></i>';
    }
}

/**
 * AJAX Search Handler
 */
function teznevisan_ajax_search() {
    check_ajax_referer('teznevisan_header_nonce', 'nonce');
    
    $search_query = sanitize_text_field($_POST['query']);
    
    if (empty($search_query)) {
        wp_die();
    }
    
    $args = array(
        's' => $search_query,
        'posts_per_page' => 5,
        'post_status' => 'publish'
    );
    
    $search_results = new WP_Query($args);
    $results = array();
    
    if ($search_results->have_posts()) {
        while ($search_results->have_posts()) {
            $search_results->the_post();
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 15)
            );
        }
    }
    
    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_teznevisan_search', 'teznevisan_ajax_search');
add_action('wp_ajax_nopriv_teznevisan_search', 'teznevisan_ajax_search');


/**
 * Display post meta information
 */
function teznevisan_post_meta(): void
{
    echo '<div class="post-meta">';
    echo '<span class="post-date"><i class="fa-regular fa-calendar" aria-hidden="true"></i> ' . get_the_date() . '</span>';
    echo '<span class="post-author"><i class="fa-regular fa-user" aria-hidden="true"></i> ' . get_the_author() . '</span>';
    
    $categories = get_the_category();
    if (!empty($categories)) {
        echo '<span class="post-category"><i class="fa-regular fa-folder" aria-hidden="true"></i> ';
        echo '<a href="' . get_category_link($categories[0]->term_id) . '">' . $categories[0]->name . '</a>';
        echo '</span>';
    }
    
    if (comments_open() || get_comments_number()) {
        echo '<span class="post-comments"><i class="fa-regular fa-comments" aria-hidden="true"></i> ';
        comments_popup_link('بدون نظر', '۱ نظر', '% نظر');
        echo '</span>';
    }
    
    echo '</div>';
}

/**
 * Display social sharing buttons
 */
function teznevisan_social_share(): void
{
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    $site_name = urlencode(get_bloginfo('name'));
    
    echo '<div class="social-share">';
    echo '<h4>اشتراک‌گذاری:</h4>';
    echo '<div class="share-buttons">';
    
    $share_links = [
        'telegram' => [
            'url' => "https://t.me/share/url?url={$url}&text={$title}",
            'title' => 'اشتراک در تلگرام',
            'icon' => 'fa-brands fa-telegram-plane'
        ],
        'whatsapp' => [
            'url' => "https://wa.me/?text={$title} {$url}",
            'title' => 'اشتراک در واتساپ', 
            'icon' => 'fa-brands fa-whatsapp'
        ],
        'twitter' => [
            'url' => "https://twitter.com/intent/tweet?url={$url}&text={$title}&via={$site_name}",
            'title' => 'اشتراک در توییتر',
            'icon' => 'fa-brands fa-twitter'
        ],
        'linkedin' => [
            'url' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
            'title' => 'اشتراک در لینکدین',
            'icon' => 'fa-brands fa-linkedin'
        ],
        'email' => [
            'url' => "mailto:?subject={$title}&body={$url}",
            'title' => 'ارسال با ایمیل',
            'icon' => 'fa-regular fa-envelope'
        ]
    ];
    
    foreach ($share_links as $platform => $data) {
        echo sprintf(
            '<a href="%s" class="share-btn share-%s" target="_blank" rel="noopener noreferrer" title="%s" aria-label="%s">
                <i class="%s" aria-hidden="true"></i>
            </a>',
            $data['url'],
            $platform,
            $data['title'], 
            $data['title'],
            $data['icon']
        );
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Custom excerpt with Persian support
 */
function teznevisan_excerpt(int $length = 25): string
{
    global $post;
    
    if (has_excerpt($post->ID)) {
        return get_the_excerpt($post->ID);
    }
    
    $content = strip_tags($post->post_content);
    $words = preg_split('/\s+/', $content, $length + 1, PREG_SPLIT_NO_EMPTY);
    
    if (count($words) > $length) {
        array_pop($words);
        return implode(' ', $words) . '...';
    }
    
    return implode(' ', $words);
}

/**
 * Estimate reading time in Persian
 */
function teznevisan_reading_time(): string
{
    global $post;
    
    $content = strip_tags($post->post_content);
    $word_count = str_word_count($content, 0, 'اآأإبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیي');
    $reading_time = ceil($word_count / 200); // 200 words per minute in Persian
    
    if ($reading_time < 1) {
        return 'کمتر از یک دقیقه';
    } elseif ($reading_time == 1) {
        return 'یک دقیقه';
    } else {
        return $reading_time . ' دقیقه';
    }
}

/**
 * Get related posts
 */
function teznevisan_related_posts(int $limit = 4): array
{
    global $post;
    
    $categories = wp_get_post_categories($post->ID);
    if (empty($categories)) {
        return [];
    }
    
    $related_posts = get_posts([
        'category__in' => $categories,
        'post__not_in' => [$post->ID],
        'posts_per_page' => $limit,
        'orderby' => 'rand'
    ]);
    
    return $related_posts;
}

/**
 * Performance & Security Enhancements
 */
add_action('init', function() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    
    // Disable REST API for non-authenticated users
    if (!is_user_logged_in()) {
        add_filter('rest_authentication_errors', function() {
            return new WP_Error('rest_disabled', 'REST API disabled for non-authenticated users', ['status' => 401]);
        });
    }
    
    // Remove query strings from static resources
    add_filter('script_loader_src', 'teznevisan_remove_query_strings');
    add_filter('style_loader_src', 'teznevisan_remove_query_strings');
});
/**
 * Fix MIME Type Issues for Fonts and CSS
 */
function teznevisan_fix_mime_types() {
    // Add proper MIME types for fonts
    add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
        $filetype = wp_check_filetype($filename, $mimes);
        return [
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        ];
    }, 10, 4);
}
add_action('init', 'teznevisan_fix_mime_types');

/**
 * Block External Font Loading Completely
 */
function teznevisan_block_external_fonts() {
    // Remove any external font preloads
    remove_action('wp_head', 'wp_resource_hints', 2);
    
    // Block specific external font requests
    add_filter('style_loader_src', function($src, $handle) {
        // Block any external font CDNs
        $blocked_domains = [
            'fonts.googleapis.com',
            'fonts.gstatic.com', 
            'r2cdn.perplexity.ai',
            'cdnjs.cloudflare.com/ajax/libs/font-awesome'
        ];
        
        foreach ($blocked_domains as $domain) {
            if (strpos($src, $domain) !== false) {
                return false; // Block the request
            }
        }
        
        return $src;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'teznevisan_block_external_fonts', 1);

/**
 * Fix MIME Types and Headers
 */
function teznevisan_fix_mime_and_headers() {
    // Add proper headers for assets
    add_action('send_headers', function() {
        if (strpos($_SERVER['REQUEST_URI'], '/assets/css/') !== false) {
            header('Content-Type: text/css; charset=utf-8');
        }
        if (strpos($_SERVER['REQUEST_URI'], '/assets/js/') !== false) {
            header('Content-Type: application/javascript; charset=utf-8');
        }
        if (strpos($_SERVER['REQUEST_URI'], '/assets/fonts/') !== false) {
            $ext = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION);
            switch($ext) {
                case 'woff2':
                    header('Content-Type: font/woff2');
                    break;
                case 'woff':
                    header('Content-Type: font/woff');
                    break;
                case 'ttf':
                    header('Content-Type: font/ttf');
                    break;
                case 'eot':
                    header('Content-Type: application/vnd.ms-fontobject');
                    break;
            }
            header('Access-Control-Allow-Origin: *');
        }
    });
}
add_action('init', 'teznevisan_fix_mime_and_headers');

/**
 * Block External Font Requests Completely
 */
function teznevisan_block_external_requests() {
    add_filter('pre_http_request', function($preempt, $args, $url) {
        $blocked_domains = [
            'fonts.googleapis.com',
            'fonts.gstatic.com', 
            'r2cdn.perplexity.ai',
            'cdnjs.cloudflare.com'
        ];
        
        foreach ($blocked_domains as $domain) {
            if (strpos($url, $domain) !== false) {
                return new WP_Error('blocked_request', 'External font request blocked');
            }
        }
        
        return $preempt;
    }, 10, 3);
}
add_action('init', 'teznevisan_block_external_requests');
/**
 * Complete Asset Loading Fix - No More Console Errors
 */
function teznevisan_fix_all_console_errors() {
    // Remove default jQuery that's causing issues
    wp_deregister_script('jquery');
    
    // Enqueue WordPress's jQuery properly
    wp_register_script('jquery', includes_url('/wp-content/themes/WPTeznevisan/assets/js/jquery/jquery.min.js'), array(), '3.7.1', false);
    wp_enqueue_script('jquery');
    
    // Fix Font Awesome MIME type by serving from correct path
    wp_enqueue_style(
        'font-awesome-fixed', 
        get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css',
        array(), 
        '7.0.0'
    );
    
    // Enqueue all CSS files with proper headers
    $css_files = [
        'critical' => '/assets/css/critical.css',
        'fonts' => '/assets/css/fonts.css',
        'main' => '/assets/css/main.css',
        'rtl' => '/assets/css/rtl.css',
        'header-enhanced' => '/assets/css/header-enhanced.css',
        'services' => '/assets/css/services.css',
        'homepage' => '/assets/css/homepage.css',
        'frontend-editor' => '/assets/css/frontend-editor.css',
        'admin' => '/assets/css/admin.css',
        'editor-style' => '/assets/css/editor-style.css'
    ];
    
    foreach ($css_files as $handle => $path) {
        wp_enqueue_style(
            "teznevisan-{$handle}",
            get_template_directory_uri() . $path,
            array(),
            filemtime(get_template_directory() . $path)
        );
    }
    
    // Enhanced Header JavaScript
    wp_enqueue_script(
        'teznevisan-header-enhanced',
        get_template_directory_uri() . '/assets/js/header-enhanced.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/header-enhanced.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'teznevisan_fix_all_console_errors', 5);
/**
 * Fix MIME Types for All Assets
 */
function teznevisan_fix_all_mime_types() {
    add_action('wp_loaded', function() {
        $request_uri = $_SERVER['REQUEST_URI'];
        
        // Handle Font Files
        if (strpos($request_uri, '/assets/fonts/') !== false) {
            $file_path = get_template_directory() . $request_uri;
            
            if (file_exists($file_path)) {
                $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                
                $font_mime_types = [
                    'woff2' => 'font/woff2',
                    'woff' => 'font/woff',
                    'ttf' => 'font/ttf',
                    'eot' => 'application/vnd.ms-fontobject',
                    'otf' => 'font/otf'
                ];
                
                if (isset($font_mime_types[$ext])) {
                    header('Content-Type: ' . $font_mime_types[$ext]);
                    header('Access-Control-Allow-Origin: *');
                    header('Cache-Control: public, max-age=31536000');
                    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
                    
                    readfile($file_path);
                    exit;
                }
            }
        }
        
        // Handle CSS Files
        if (strpos($request_uri, '/assets/css/') !== false && 
            pathinfo($request_uri, PATHINFO_EXTENSION) === 'css') {
            
            $file_path = get_template_directory() . $request_uri;
            
            if (file_exists($file_path)) {
                header('Content-Type: text/css; charset=utf-8');
                header('Cache-Control: public, max-age=86400');
                
                readfile($file_path);
                exit;
            }
        }
        
        // Handle JavaScript Files  
        if (strpos($request_uri, '/assets/js/') !== false && 
            pathinfo($request_uri, PATHINFO_EXTENSION) === 'js') {
            
            $file_path = get_template_directory() . $request_uri;
            
            if (file_exists($file_path)) {
                header('Content-Type: application/javascript; charset=utf-8');
                header('Cache-Control: public, max-age=86400');
                
                readfile($file_path);
                exit;
            }
        }
    });
}
add_action('init', 'teznevisan_fix_all_mime_types');


// Enqueue services CSS
function teznevisan_enqueue_services_styles() {
    if (is_singular('services')) {
        wp_enqueue_style(
            'teznevisan-services',
            get_template_directory_uri() . '/services.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'teznevisan_enqueue_services_styles');

/**
 * Fix CSS MIME Types Specifically for FontAwesome and JQUERY
 */
// Handle FontAwesome CSS MIME Type  
function teznevisan_fix_css_mime_types() {
    add_action('wp_loaded', function() {
        if (strpos($_SERVER['REQUEST_URI'], '/assets/fonts/fontawesome/css/') !== false && 
            strpos($_SERVER['REQUEST_URI'], '.css') !== false) {
            
            header('Content-Type: text/css; charset=utf-8');
            
            $file_path = get_template_directory() . $_SERVER['REQUEST_URI'];
            if (file_exists($file_path)) {
                readfile($file_path);
                exit;
            }
        }
    });
    // Handle JavaScript Files  
        if (strpos($_SERVER['REQUEST_URI'], '/assets/js/jquery') !== false && 
            strpos($_SERVER['REQUEST_URI'], '.js') !== false) {
            
            $file_path = get_template_directory() . $request_uri;
            
            if (file_exists($file_path)) {
                header('Content-Type: application/javascript; charset=utf-8');
                header('Cache-Control: public, max-age=86400');
                
                readfile($file_path);
                exit;
            }
        }
    }
add_action('init', 'teznevisan_fix_css_mime_types');

/**
 * Enqueue Font Awesome and other styles
 */
function teznevisan_enqueue_assets() {
    // Font Awesome 7 Pro - Local version
    wp_enqueue_style(
        'font-awesome-pro', 
        get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css', 
        array(), 
        '7.0.0'
    );
    
    // Main theme stylesheet
    wp_enqueue_style(
        'teznevisan-main-style', 
        get_stylesheet_uri(), 
        array('font-awesome-pro'), 
        wp_get_theme()->get('Version')
    );
    
    // Services page specific styles
    if (is_singular('services')) {
        wp_enqueue_style(
            'teznevisan-services',
            get_template_directory_uri() . '/services.css',
            array('font-awesome-pro'),
            '1.0.0'
        );
    }
    
    // Single post specific styles are inline in post.php
    
    // Main JavaScript
    wp_enqueue_script(
        'teznevisan-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'teznevisan_enqueue_assets');

/**
 * Enqueue admin assets with Font Awesome
 */
function teznevisan_admin_enqueue_assets($hook) {
    global $post_type;
    
    // Load Font Awesome in admin for all pages
    wp_enqueue_style(
        'font-awesome-pro-admin', 
        get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css', 
        array(), 
        '7.0.0'
    );
    
    // Load additional admin styles for services
    if (($hook == 'post.php' || $hook == 'post-new.php') && $post_type == 'services') {
        wp_enqueue_style(
            'teznevisan-admin-services',
            get_template_directory_uri() . '/admin/services-admin.css',
            array('font-awesome-pro-admin'),
            '1.0.0'
        );
    }
}
add_action('admin_enqueue_scripts', 'teznevisan_admin_enqueue_assets');

/**
 * Add .htaccess Rules for Font MIME Types (if needed)
 */
function teznevisan_add_font_htaccess_rules() {
    $htaccess_file = ABSPATH . '.htaccess';
    $font_rules = "
# Font MIME Types
<IfModule mod_mime.c>
    AddType application/vnd.ms-fontobject .eot
    AddType font/truetype .ttf
    AddType font/opentype .otf
    AddType font/woff .woff
    AddType font/woff2 .woff2
</IfModule>

# Enable CORS for fonts
<IfModule mod_headers.c>
    <FilesMatch \"\\.(ttf|otf|eot|woff|woff2)$\">
        Header set Access-Control-Allow-Origin \"*\"
    </FilesMatch>
</IfModule>
";
    
    if (is_writable($htaccess_file)) {
        $current_rules = file_get_contents($htaccess_file);
        if (strpos($current_rules, '# Font MIME Types') === false) {
            file_put_contents($htaccess_file, $font_rules . $current_rules);
        }
    }
}
add_action('admin_init', 'teznevisan_add_font_htaccess_rules');

function theme_enqueue_chaty_fix() {
    wp_enqueue_script('chaty-fix', get_template_directory_uri() . '/assets/js/chaty-fix.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_chaty_fix');


function teznevisan_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

// Optimize database queries
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_home()) {
            $query->set('posts_per_page', 10);
        }
        if (is_archive()) {
            $query->set('posts_per_page', 12);
        }
    }
});

// Add security headers
add_action('wp_head', function() {
    if (!is_admin()) {
        echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />' . "\n";
        echo '<meta name="referrer" content="no-referrer-when-downgrade" />' . "\n";
        echo '<meta name="format-detection" content="telephone=no" />' . "\n";
    }
}, 1);

/**
 * Cleanup and Optimization
 */
add_action('wp_enqueue_scripts', function() {
    // Remove unnecessary scripts/styles
    wp_deregister_script('wp-embed');
    wp_dequeue_style('wp-block-library-theme');
    
    // Conditionally load scripts
    if (!is_singular()) {
        wp_dequeue_script('comment-reply');
    }
    
    // Optimize jQuery
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', '/wp-content/themes/WPTeznevisan/assets/js/jquery/jquery.min.js', false, '3.7.1', true);
        wp_enqueue_script('jquery');
    }
}, 100);

// Cache optimization
add_action('init', function() {
    if (!is_admin()) {
        // Set appropriate cache headers
        header('Cache-Control: public, max-age=3600');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    }
});

// Final initialization
add_action('wp_loaded', function() {
    // Theme is fully loaded - fire any final hooks
    do_action('teznevisan_theme_loaded');
});
