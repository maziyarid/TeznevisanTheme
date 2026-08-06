<?php
/**
 * Navigation and Menu Management for TezNevisan Theme
 * Handles all dynamic menu functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * TeznevisanNavigationManager Class - FIXED
 */
class TeznevisanNavigationManager {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // Register menus
        add_action('after_setup_theme', array($this, 'register_menus'));
        
        // Admin menu management
        add_action('admin_menu', array($this, 'add_menu_management_page'));
        
        // Custom walker for menus
        add_filter('wp_nav_menu_args', array($this, 'custom_menu_args'));
        
        // AJAX handlers for menu management
        add_action('wp_ajax_update_menu_settings', array($this, 'update_menu_settings'));
        
        // Enqueue admin scripts for menu management
        add_action('admin_enqueue_scripts', array($this, 'enqueue_menu_admin_scripts'));
    }
    
    /**
     * Register Navigation Menus
     */
    public function register_menus() {
        register_nav_menus(array(
            'primary' => 'منوی اصلی (هدر)',
            'secondary' => 'منوی ثانویه (هدر)',
            'mobile' => 'منوی موبایل',
            'footer_main' => 'منوی اصلی فوتر',
            'footer_services' => 'منوی خدمات فوتر',
            'footer_about' => 'منوی درباره ما فوتر',
            'footer_links' => 'پیوندهای مفید فوتر',
            'social' => 'شبکه‌های اجتماعی'
        ));
    }
    
    /**
     * Add Menu Management Page
     */
    public function add_menu_management_page() {
        add_submenu_page(
            'themes.php',
            'مدیریت منوها - تزنویسان',
            'مدیریت منوهای تم',
            'manage_options',
            'teznevisan-menus',
            array($this, 'menu_management_page')
        );
    }
    
    /**
     * Menu Management Admin Page
     */
    public function menu_management_page() {
        ?>
        <div class="wrap">
            <h1><i class="fa-solid fa-bars"></i> مدیریت منوهای تم تزنویسان</h1>
            
            <div class="nav-tab-wrapper">
                <a href="#menu-locations" class="nav-tab nav-tab-active">موقعیت منوها</a>
                <a href="#menu-settings" class="nav-tab">تنظیمات منو</a>
                <a href="#mobile-menu" class="nav-tab">منوی موبایل</a>
                <a href="#social-menu" class="nav-tab">شبکه‌های اجتماعی</a>
            </div>
            
            <div id="menu-locations" class="nav-tab-content">
                <h2>تعیین منوها برای موقعیت‌های مختلف</h2>
                <?php $this->render_menu_locations(); ?>
            </div>
            
            <div id="menu-settings" class="nav-tab-content" style="display: none;">
                <h2>تنظیمات نمایش منو</h2>
                <?php $this->render_menu_settings(); ?>
            </div>
            
            <div id="mobile-menu" class="nav-tab-content" style="display: none;">
                <h2>تنظیمات منوی موبایل</h2>
                <?php $this->render_mobile_menu_settings(); ?>
            </div>
            
            <div id="social-menu" class="nav-tab-content" style="display: none;">
                <h2>شبکه‌های اجتماعی</h2>
                <?php $this->render_social_menu_settings(); ?>
            </div>
        </div>
        
        <style>
        .nav-tab-content {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            border-top: none;
            margin-bottom: 20px;
        }
        .menu-location-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 4px;
            background: #f9f9f9;
        }
        .location-info h3 {
            margin: 0 0 5px 0;
            color: #1fa547;
        }
        .location-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .location-select select {
            min-width: 200px;
        }
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .setting-card {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .setting-card h3 {
            margin-top: 0;
            color: #1fa547;
        }
        .social-links-manager {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .social-link-item {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .social-link-item input {
            flex: 1;
        }
        .add-social-link {
            background: #1fa547;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-social-link {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            // Tab switching
            $('.nav-tab').click(function(e) {
                e.preventDefault();
                
                $('.nav-tab').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');
                
                $('.nav-tab-content').hide();
                $($(this).attr('href')).show();
            });
            
            // Add social link
            $('#add-social-link').click(function() {
                const timestamp = new Date().getTime();
                const template = `
                    <div class="social-link-item">
                        <select name="social_links[${timestamp}][platform]">
                            <option value="">انتخاب شبکه</option>
                            <option value="instagram">اینستاگرام</option>
                            <option value="telegram">تلگرام</option>
                            <option value="whatsapp">واتساپ</option>
                            <option value="twitter">توییتر</option>
                            <option value="facebook">فیسبوک</option>
                            <option value="linkedin">لینکدین</option>
                            <option value="youtube">یوتیوب</option>
                        </select>
                        <input type="url" name="social_links[${timestamp}][url]" placeholder="آدرس لینک" />
                        <button type="button" class="remove-social-link">حذف</button>
                    </div>
                `;
                $('#social-links-container').append(template);
            });
            
            // Remove social link
            $(document).on('click', '.remove-social-link', function() {
                $(this).closest('.social-link-item').remove();
            });
            
            // Save settings
            $('#save-menu-settings').click(function() {
                const formData = $('#menu-settings-form').serialize();
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: formData + '&action=update_menu_settings&nonce=' + (window.teznevisanAdmin ? teznevisanAdmin.nonce : ''),
                    success: function(response) {
                        if (response.success) {
                            alert('تنظیمات با موفقیت ذخیره شد');
                        } else {
                            alert('خطا در ذخیره تنظیمات');
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
     * Render Menu Locations
     */
    private function render_menu_locations() {
        $locations = get_registered_nav_menus();
        $menu_locations = get_nav_menu_locations();
        $menus = wp_get_nav_menus();
        
        ?>
        <form method="post" action="<?php echo admin_url('nav-menus.php?action=locations'); ?>">
            <?php wp_nonce_field('save-menu-locations'); ?>
            
            <?php foreach ($locations as $location => $description) : ?>
                <div class="menu-location-item">
                    <div class="location-info">
                        <h3><?php echo esc_html($description); ?></h3>
                        <p>موقعیت: <code><?php echo esc_html($location); ?></code></p>
                    </div>
                    <div class="location-select">
                        <select name="menu-locations[<?php echo esc_attr($location); ?>]">
                            <option value="0"><?php _e('— انتخاب منو —'); ?></option>
                            <?php foreach ($menus as $menu) : ?>
                                <option value="<?php echo esc_attr($menu->term_id); ?>" 
                                        <?php selected(isset($menu_locations[$location]) ? $menu_locations[$location] : 0, $menu->term_id); ?>>
                                    <?php echo esc_html($menu->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <p class="submit">
                <input type="submit" name="nav-menu-locations" value="ذخیره تغییرات" class="button-primary" />
            </p>
        </form>
        
        <div class="card">
            <h3>راهنمای سریع</h3>
            <p>برای ایجاد منوی جدید، به <a href="<?php echo admin_url('nav-menus.php'); ?>">مدیریت منوها</a> مراجعه کنید.</p>
            <ul>
                <li><strong>منوی اصلی:</strong> نمایش در هدر سایت</li>
                <li><strong>منوی ثانویه:</strong> منوی اضافی در هدر</li>
                <li><strong>منوی موبایل:</strong> منوی همبرگری در نسخه موبایل</li>
                <li><strong>منوهای فوتر:</strong> نمایش در قسمت‌های مختلف فوتر</li>
            </ul>
        </div>
        <?php
    }
    
    /**
     * Render Menu Settings
     */
    private function render_menu_settings() {
        $settings = get_option('teznevisan_menu_settings', array(
            'show_icons' => true,
            'show_descriptions' => false,
            'dropdown_animation' => 'slide',
            'mobile_breakpoint' => 768,
            'sticky_header' => true,
            'search_in_menu' => true
        ));
        
        ?>
        <form id="menu-settings-form">
            <div class="settings-grid">
                <div class="setting-card">
                    <h3>نمایش عناصر</h3>
                    <p>
                        <label>
                            <input type="checkbox" name="settings[show_icons]" value="1" <?php checked($settings['show_icons']); ?> />
                            نمایش آیکن‌ها در منو
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="settings[show_descriptions]" value="1" <?php checked($settings['show_descriptions']); ?> />
                            نمایش توضیحات آیتم‌ها
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="settings[search_in_menu]" value="1" <?php checked($settings['search_in_menu']); ?> />
                            نمایش جستجو در منو
                        </label>
                    </p>
                </div>
                
                <div class="setting-card">
                    <h3>انیمیشن‌ها</h3>
                    <p>
                        <label>نوع انیمیشن زیرمنو:</label>
                        <select name="settings[dropdown_animation]">
                            <option value="slide" <?php selected($settings['dropdown_animation'], 'slide'); ?>>کشیدن</option>
                            <option value="fade" <?php selected($settings['dropdown_animation'], 'fade'); ?>>محو شدن</option>
                            <option value="none" <?php selected($settings['dropdown_animation'], 'none'); ?>>بدون انیمیشن</option>
                        </select>
                    </p>
                </div>
                
                <div class="setting-card">
                    <h3>تنظیمات موبایل</h3>
                    <p>
                        <label>نقطه شکست موبایل (پیکسل):</label>
                        <input type="number" name="settings[mobile_breakpoint]" value="<?php echo esc_attr($settings['mobile_breakpoint']); ?>" min="480" max="1200" />
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="settings[sticky_header]" value="1" <?php checked($settings['sticky_header']); ?> />
                            هدر چسبناک در موبایل
                        </label>
                    </p>
                </div>
            </div>
            
            <p class="submit">
                <button type="button" id="save-menu-settings" class="button-primary">ذخیره تنظیمات</button>
            </p>
        </form>
        <?php
    }
    
    /**
     * Render Mobile Menu Settings
     */
    private function render_mobile_menu_settings() {
        $mobile_settings = get_option('teznevisan_mobile_menu_settings', array(
            'style' => 'slide',
            'position' => 'right',
            'show_search' => true,
            'show_social' => true,
            'overlay_color' => '#000000',
            'overlay_opacity' => 0.5
        ));
        
        ?>
        <form id="mobile-menu-settings-form">
            <div class="settings-grid">
                <div class="setting-card">
                    <h3>نمایش منوی موبایل</h3>
                    <p>
                        <label>نوع نمایش:</label>
                        <select name="mobile_settings[style]">
                            <option value="slide" <?php selected($mobile_settings['style'], 'slide'); ?>>کشیدن از کنار</option>
                            <option value="overlay" <?php selected($mobile_settings['style'], 'overlay'); ?>>پوشش کامل</option>
                            <option value="accordion" <?php selected($mobile_settings['style'], 'accordion'); ?>>آکاردئونی</option>
                        </select>
                    </p>
                    <p>
                        <label>موقعیت نمایش:</label>
                        <select name="mobile_settings[position]">
                            <option value="right" <?php selected($mobile_settings['position'], 'right'); ?>>راست</option>
                            <option value="left" <?php selected($mobile_settings['position'], 'left'); ?>>چپ</option>
                            <option value="top" <?php selected($mobile_settings['position'], 'top'); ?>>بالا</option>
                        </select>
                    </p>
                </div>
                
                <div class="setting-card">
                    <h3>عناصر اضافی</h3>
                    <p>
                        <label>
                            <input type="checkbox" name="mobile_settings[show_search]" value="1" <?php checked($mobile_settings['show_search']); ?> />
                            نمایش جستجو
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="mobile_settings[show_social]" value="1" <?php checked($mobile_settings['show_social']); ?> />
                            نمایش شبکه‌های اجتماعی
                        </label>
                    </p>
                </div>
                
                <div class="setting-card">
                    <h3>ظاهر</h3>
                    <p>
                        <label>رنگ پس‌زمینه:</label>
                        <input type="color" name="mobile_settings[overlay_color]" value="<?php echo esc_attr($mobile_settings['overlay_color']); ?>" />
                    </p>
                    <p>
                        <label>شفافیت پس‌زمینه:</label>
                        <input type="range" name="mobile_settings[overlay_opacity]" min="0" max="1" step="0.1" value="<?php echo esc_attr($mobile_settings['overlay_opacity']); ?>" />
                    </p>
                </div>
            </div>
        </form>
        <?php
    }
    
    /**
     * Render Social Menu Settings
     */
    private function render_social_menu_settings() {
        $social_links = get_option('teznevisan_social_links', array());
        
        ?>
        <div class="social-links-manager">
            <h3>پیوندهای شبکه‌های اجتماعی</h3>
            <p>این لینک‌ها در منوی اجتماعی و فوتر نمایش داده می‌شوند.</p>
            
            <div id="social-links-container">
                <?php foreach ($social_links as $key => $link) : ?>
                    <div class="social-link-item">
                        <select name="social_links[<?php echo esc_attr($key); ?>][platform]">
                            <option value="">انتخاب شبکه</option>
                            <option value="instagram" <?php selected($link['platform'], 'instagram'); ?>>اینستاگرام</option>
                            <option value="telegram" <?php selected($link['platform'], 'telegram'); ?>>تلگرام</option>
                            <option value="whatsapp" <?php selected($link['platform'], 'whatsapp'); ?>>واتساپ</option>
                            <option value="twitter" <?php selected($link['platform'], 'twitter'); ?>>توییتر</option>
                            <option value="facebook" <?php selected($link['platform'], 'facebook'); ?>>فیسبوک</option>
                            <option value="linkedin" <?php selected($link['platform'], 'linkedin'); ?>>لینکدین</option>
                            <option value="youtube" <?php selected($link['platform'], 'youtube'); ?>>یوتیوب</option>
                        </select>
                        <input type="url" name="social_links[<?php echo esc_attr($key); ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="آدرس لینک" />
                        <button type="button" class="remove-social-link">حذف</button>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="button" id="add-social-link" class="add-social-link">
                <i class="fa-solid fa-plus"></i> افزودن شبکه اجتماعی
            </button>
        </div>
        <?php
    }
    
    /**
     * Custom Menu Args
     */
    public function custom_menu_args($args) {
        // Add custom walker for better control
        if (empty($args['walker'])) {
            $args['walker'] = new TeznevisanMenuWalker();
        }
        
        return $args;
    }
    
    /**
     * Update Menu Settings via AJAX
     */
    public function update_menu_settings() {
        if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['nonce'], 'teznevisan_admin_nonce')) {
            wp_die('Access denied');
        }
        
        $settings = $_POST['settings'] ?? array();
        $mobile_settings = $_POST['mobile_settings'] ?? array();
        $social_links = $_POST['social_links'] ?? array();
        
        update_option('teznevisan_menu_settings', $settings);
        update_option('teznevisan_mobile_menu_settings', $mobile_settings);
        update_option('teznevisan_social_links', $social_links);
        
        wp_send_json_success('تنظیمات با موفقیت ذخیره شد');
    }
    
    /**
     * Enqueue Menu Admin Scripts
     */
    public function enqueue_menu_admin_scripts($hook) {
        if ($hook !== 'appearance_page_teznevisan-menus') {
            return;
        }
        
        wp_enqueue_script('jquery');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
    
    /**
     * Get Navigation Menu
     */
    public static function get_nav_menu($location, $args = array()) {
        $defaults = array(
            'theme_location' => $location,
            'container' => 'nav',
            'container_class' => 'navigation-' . $location,
            'menu_class' => 'menu menu-' . $location,
            'echo' => false,
            'walker' => new TeznevisanMenuWalker(),
            'fallback_cb' => array(__CLASS__, 'fallback_menu')
        );
        
        $args = wp_parse_args($args, $defaults);
        
        return wp_nav_menu($args);
    }
    
    /**
     * Fallback Menu
     */
    public static function fallback_menu($args = array()) {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $output = '<div class="no-menu-assigned">';
        $output .= '<p>هیچ منویی تعریف نشده است.</p>';
        $output .= '<a href="' . admin_url('nav-menus.php') . '" class="button">ایجاد منو</a>';
        $output .= '</div>';
        
        if (!empty($args['echo'])) {
            echo $output;
        } else {
            return $output;
        }
    }
    
    /**
     * Get Social Links
     */
    public static function get_social_links() {
        return get_option('teznevisan_social_links', array());
    }
    
} // END TeznevisanNavigationManager CLASS

/**
 * TeznevisanMenuWalker Class - FIXED
 */
class TeznevisanMenuWalker extends Walker_Nav_Menu {
    
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
    
    /**
     * Get Menu Item Icon
     */
    private function get_menu_item_icon($item) {
        $saved_icons = get_option('teznevisan_menu_icons', array());
        
        // Check for saved icon first
        foreach ($saved_icons as $saved_icon) {
            if (isset($saved_icon['item_id']) && $saved_icon['item_id'] == $item->ID && !empty($saved_icon['icon'])) {
                return '<i class="' . esc_attr($saved_icon['icon']) . ' menu-icon"></i> ';
            }
        }
        
        // Fallback to auto detection
        $title_lower = strtolower($item->title);
        
        $icon_mapping = array(
            'خانه' => 'fa-solid fa-house',
            'صفحه اصلی' => 'fa-solid fa-house',
            'خدمات' => 'fa-solid fa-tools',
            'درباره' => 'fa-solid fa-circle-info',
            'تماس' => 'fa-solid fa-phone',
            'وبلاگ' => 'fa-solid fa-blog',
            'مقالات' => 'fa-solid fa-newspaper',
            'نمونه کار' => 'fa-solid fa-briefcase',
            'نظرات' => 'fa-solid fa-star'
        );
        
        foreach ($icon_mapping as $keyword => $icon) {
            if (strpos($title_lower, $keyword) !== false) {
                return '<i class="' . esc_attr($icon) . ' menu-icon auto-icon"></i> ';
            }
        }
        
        return '';
    }
    
} // END TeznevisanMenuWalker CLASS

// Initialize Navigation Manager
TeznevisanNavigationManager::getInstance();
?>