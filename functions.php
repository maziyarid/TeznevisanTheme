<?php
/**
 * TeznevisanTheme bootstrap.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('TEZNEVISAN_VERSION')) define('TEZNEVISAN_VERSION', '2.0.1');
if (!defined('TEZNEVISAN_DIR')) define('TEZNEVISAN_DIR', get_template_directory());
if (!defined('TEZNEVISAN_URI')) define('TEZNEVISAN_URI', get_template_directory_uri());

if (!function_exists('teznevisan_asset_version')) {
    function teznevisan_asset_version($relative_path) {
        $file = TEZNEVISAN_DIR . '/' . ltrim($relative_path, '/');
        return file_exists($file) ? (string) filemtime($file) : TEZNEVISAN_VERSION;
    }
}

if (!function_exists('teznevisan_reading_time_persian')) {
    function teznevisan_reading_time_persian($post_id = 0) {
        $post_id = $post_id ? (int) $post_id : get_the_ID();
        $content = $post_id ? get_post_field('post_content', $post_id) : '';
        $content = trim(wp_strip_all_tags(strip_shortcodes((string) $content)));
        $words = $content === '' ? 0 : preg_split('/\s+/u', $content, -1, PREG_SPLIT_NO_EMPTY);
        $count = is_array($words) ? count($words) : 0;
        $minutes = max(1, (int) ceil($count / 200));
        return sprintf('%d دقیقه مطالعه', $minutes);
    }
}

if (!function_exists('teznevisan_setup')) {
    function teznevisan_setup() {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo', array('height' => 120, 'width' => 360, 'flex-height' => true, 'flex-width' => true));
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
        add_theme_support('responsive-embeds');
        add_theme_support('align-wide');
        add_editor_style('assets/css/editor-style.css');
        register_nav_menus(array('primary' => __('Primary menu', 'teznevisan'), 'footer' => __('Footer menu', 'teznevisan')));
    }
}
add_action('after_setup_theme', 'teznevisan_setup');

if (!function_exists('teznevisan_widgets_init')) {
    function teznevisan_widgets_init() {
        $areas = array(
            array('primary-sidebar', __('Primary sidebar', 'teznevisan'), __('Main sidebar widget area.', 'teznevisan')),
            array('footer-1', __('Footer column 1', 'teznevisan'), __('First footer widget area.', 'teznevisan')),
            array('footer-2', __('Footer column 2', 'teznevisan'), __('Second footer widget area.', 'teznevisan')),
            array('footer-3', __('Footer column 3', 'teznevisan'), __('Third footer widget area.', 'teznevisan')),
            array('footer-4', __('Footer column 4', 'teznevisan'), __('Fourth footer widget area.', 'teznevisan')),
        );
        foreach ($areas as $area) {
            register_sidebar(array(
                'name' => $area[1], 'id' => $area[0], 'description' => $area[2],
                'before_widget' => '<section id="%1$s" class="widget %2$s">', 'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">', 'after_title' => '</h2>',
            ));
        }
    }
}
add_action('widgets_init', 'teznevisan_widgets_init');

if (!function_exists('teznevisan_enqueue_assets')) {
    function teznevisan_enqueue_assets() {
        $styles = array(
            'teznevisan-fonts' => 'assets/css/fonts.css',
            'teznevisan-fontawesome' => 'assets/fonts/fontawesome/css/all.css',
            'teznevisan-main' => 'assets/css/main.css',
            'teznevisan-mobile-menu' => 'assets/css/mobile-menu.css',
            'teznevisan-chaty' => 'assets/css/chaty-fix.css',
            'teznevisan-accessibility' => 'assets/css/accessibility.css',
        );
        foreach ($styles as $handle => $relative_path) {
            if (file_exists(TEZNEVISAN_DIR . '/' . $relative_path)) {
                wp_enqueue_style($handle, TEZNEVISAN_URI . '/' . $relative_path, array(), teznevisan_asset_version($relative_path));
            }
        }
        if (is_rtl() && file_exists(TEZNEVISAN_DIR . '/assets/css/rtl.css')) {
            wp_enqueue_style('teznevisan-rtl', TEZNEVISAN_URI . '/assets/css/rtl.css', array('teznevisan-main'), teznevisan_asset_version('assets/css/rtl.css'));
        }
        if (is_singular('services') && file_exists(TEZNEVISAN_DIR . '/assets/css/services.css')) {
            wp_enqueue_style('teznevisan-services', TEZNEVISAN_URI . '/assets/css/services.css', array('teznevisan-main'), teznevisan_asset_version('assets/css/services.css'));
        }

        wp_enqueue_script('jquery');
        $scripts = array(
            'mobile-menu' => array(),
            'main' => array('jquery'),
            'accessibility' => array('jquery'),
            'chaty-fix' => array('jquery'),
        );
        foreach ($scripts as $script => $dependencies) {
            $path = 'assets/js/' . $script . '.js';
            if (file_exists(TEZNEVISAN_DIR . '/' . $path)) {
                wp_enqueue_script('teznevisan-' . sanitize_key($script), TEZNEVISAN_URI . '/' . $path, $dependencies, teznevisan_asset_version($path), true);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'teznevisan_enqueue_assets', 20);

if (!function_exists('teznevisan_print_footer_styles_fallback')) {
    function teznevisan_print_footer_styles_fallback() {
        if (did_action('wp_head')) return;
        wp_print_styles();
    }
}
add_action('wp_footer', 'teznevisan_print_footer_styles_fallback', 1);

if (!function_exists('teznevisan_register_content_types')) {
    function teznevisan_register_content_types() {
        if (!post_type_exists('services')) {
            register_post_type('services', array(
                'labels' => array('name' => __('Services', 'teznevisan'), 'singular_name' => __('Service', 'teznevisan')),
                'public' => true, 'show_in_rest' => true, 'has_archive' => true,
                'rewrite' => array('slug' => 'services'),
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments'),
                'menu_icon' => 'dashicons-list-view',
            ));
        }
        if (!taxonomy_exists('service_category')) {
            register_taxonomy('service_category', array('services'), array(
                'labels' => array('name' => __('Service categories', 'teznevisan'), 'singular_name' => __('Service category', 'teznevisan')),
                'public' => true, 'show_in_rest' => true, 'hierarchical' => true,
                'rewrite' => array('slug' => 'service-category'),
            ));
        }
    }
}
add_action('init', 'teznevisan_register_content_types', 5);

if (!function_exists('teznevisan_breadcrumbs')) {
    function teznevisan_breadcrumbs() {
        if (is_front_page()) return;
        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumbs', 'teznevisan') . '">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'teznevisan') . '</a><span aria-hidden="true"> / </span>';
        if (is_singular()) echo '<span aria-current="page">' . esc_html(get_the_title()) . '</span>';
        elseif (is_archive()) echo '<span aria-current="page">' . esc_html(wp_strip_all_tags(get_the_archive_title())) . '</span>';
        else echo '<span aria-current="page">' . esc_html(wp_get_document_title()) . '</span>';
        echo '</nav>';
    }
}

foreach (array('inc/classic-editor.php', 'inc/customizer.php', 'inc/navigation-manager.php') as $module) {
    $module_path = TEZNEVISAN_DIR . '/' . $module;
    if (file_exists($module_path)) require_once $module_path;
}
