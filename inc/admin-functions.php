<?php
/**
 * Admin Functions for TezNevisan Theme - Updated Fixed Version
 * Maintains WordPress core admin integrity
 */

if (!defined('ABSPATH')) {
    exit;
}

class TeznevisanAdmin {

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
        // Enqueue admin scripts and styles on admin pages only
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        // Enqueue frontend scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        
        // Setup admin menus and dashboard widgets
        add_action('admin_menu', array($this, 'add_admin_menus'));
        add_action('wp_dashboard_setup', array($this, 'setup_dashboard_widgets'));

        // AJAX actions
        add_action('wp_ajax_get_dashboard_stats', array($this, 'get_dashboard_stats'));
        add_action('wp_ajax_check_system_status', array($this, 'check_system_status'));

        // Customize admin footer text
        add_filter('admin_footer_text', array($this, 'custom_admin_footer'));

        // Load custom admin styles only on theme related admin pages
        add_action('admin_head', array($this, 'admin_custom_styles'), 999);

        // Require meta fields configuration
        require_once get_template_directory() . '/admin/service-meta-fields.php';
    }

    public function enqueue_admin_assets($hook) {
        // Restrict to theme admin pages and dashboard by hook name
        if (strpos($hook, 'teznevisan') === false && $hook !== 'index.php') {
            return;
        }

        // Font Awesome 7 Pro CSS for admin
        wp_enqueue_style(
            'fontawesome-pro-admin',
            get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css',
            array(),
            '7.0.0'
        );

        // Custom admin CSS dependent on FA
        wp_enqueue_style(
            'teznevisan-admin-custom',
            get_template_directory_uri() . '/assets/css/admin.css',
            array('fontawesome-pro-admin'),
            defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0'
        );

        // Admin JS with jQuery dependency
        wp_enqueue_script(
            'teznevisan-admin-custom',
            get_template_directory_uri() . '/assets/js/admin.js',
            array('jquery'),
            defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0',
            true
        );

        // Localization for AJAX and strings
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

    public function enqueue_frontend_assets() {
        if (!is_admin()) {
            // Deregister default jQuery and register local optimized version
            wp_dequeue_script('jquery');
            wp_deregister_script('jquery');
            wp_enqueue_script(
                'jquery-local',
                get_template_directory_uri() . '/assets/js/jquery/jquery.min.js',
                array(),
                '3.7.1',
                false
            );
        }

        // Font Awesome 7 Pro CSS for frontend
        wp_enqueue_style(
            'fontawesome-pro-frontend',
            get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.min.css',
            array(),
            '7.0.0'
        );

        // Critical CSS
        wp_enqueue_style(
            'teznevisan-critical',
            get_template_directory_uri() . '/assets/css/critical.css',
            array(),
            defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0'
        );

        // Main theme CSS dependent on FA and critical CSS
        wp_enqueue_style(
            'teznevisan-main',
            get_template_directory_uri() . '/assets/css/main.css',
            array('fontawesome-pro-frontend', 'teznevisan-critical'),
            defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0'
        );

        // Page and CPT specific CSS
        if (is_home() || is_front_page()) {
            wp_enqueue_style(
                'teznevisan-homepage',
                get_template_directory_uri() . '/assets/css/homepage.css',
                array('teznevisan-main'),
                defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0'
            );
        }

        if (is_post_type_archive('services') || is_singular('services')) {
            wp_enqueue_style(
                'teznevisan-services',
                get_template_directory_uri() . '/assets/css/services.css',
                array('teznevisan-main'),
                defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0'
            );
        }

        // Critical JS
        wp_enqueue_script(
            'teznevisan-critical-js',
            get_template_directory_uri() . '/assets/js/critical.js',
            array(),
            defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0',
            false
        );

        // Main theme JS with localized data
        wp_enqueue_script(
            'teznevisan-main-js',
            get_template_directory_uri() . '/assets/js/main.js',
            array('jquery-local'),
            defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0',
            true
        );

        if (is_archive() || is_search() || is_home()) {
            wp_enqueue_script(
                'teznevisan-archive-js',
                get_template_directory_uri() . '/assets/js/archive.js',
                array('teznevisan-main-js'),
                defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0',
                true
            );
        }

        wp_localize_script('teznevisan-main-js', 'teznevisanTheme', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('teznevisan_nonce'),
            'homeUrl' => home_url(),
            'themeUrl' => get_template_directory_uri(),
            'isRTL' => is_rtl(),
            'strings' => array(
                'loading' => 'در حال بارگذاری...',
                'error' => 'خطا در انجام عملیات',
                'success' => 'عملیات موفق',
                'confirm' => 'آیا مطمئن هستید؟'
            )
        ));
    }

    public function add_admin_menus() {
        add_theme_page(
            'تنظیمات تزنویسان',
            'تنظیمات تم',
            'manage_options',
            'teznevisan-settings',
            array($this, 'theme_settings_page')
        );

        add_dashboard_page(
            'داشبورد تزنویسان',
            'آمار کلی',
            'manage_options',
            'teznevisan-overview',
            array($this, 'dashboard_overview_page')
        );

        add_management_page(
            'وضعیت سیستم',
            'وضعیت سیستم',
            'manage_options',
            'system-status',
            array($this, 'system_status_page')
        );
    }

    public function setup_dashboard_widgets() {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');

        wp_add_dashboard_widget(
            'teznevisan_overview',
            '<i class="fa-solid fa-chart-line"></i> آمار کلی سایت',
            array($this, 'dashboard_overview_widget')
        );

        wp_add_dashboard_widget(
            'teznevisan_recent_activity',
            '<i class="fa-solid fa-bell"></i> فعالیت‌های اخیر',
            array($this, 'recent_activity_widget')
        );
    }

    public function dashboard_overview_widget() {
        $services_count = wp_count_posts('services');
        $services_total = isset($services_count->publish) ? intval($services_count->publish) : 0;

        $inquiries_count = wp_count_posts('service_inquiry');
        $inquiries_total = isset($inquiries_count->private) ? intval($inquiries_count->private) : 0;

        $posts_count = wp_count_posts('post');
        $posts_total = isset($posts_count->publish) ? intval($posts_count->publish) : 0;

        $newsletter_phones = get_option('teznevisan_newsletter_phones', array());
        $newsletter_emails = get_option('teznevisan_newsletter_emails', array());
        $newsletter_total = count($newsletter_phones) + count($newsletter_emails);
        ?>
        <div class="teznevisan-overview-widget">
            <style>
                /* Your widget styles here */
            </style>

            <div class="overview-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <div class="stat-number"><?php echo esc_html($services_total); ?></div>
                    <div class="stat-label">خدمات فعال</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-envelope-open"></i>
                    </div>
                    <div class="stat-number"><?php echo esc_html($inquiries_total); ?></div>
                    <div class="stat-label">درخواست‌ها</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-number"><?php echo esc_html($newsletter_total); ?></div>
                    <div class="stat-label">مشترکین</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div class="stat-number"><?php echo esc_html($posts_total); ?></div>
                    <div class="stat-label">مقالات</div>
                </div>
            </div>

            <div class="overview-actions">
                <a href="<?php echo admin_url('post-new.php?post_type=services'); ?>" class="action-btn">
                    <i class="fa-solid fa-plus"></i> خدمت جدید
                </a>
                <a href="<?php echo admin_url('edit.php?post_type=service_inquiry'); ?>" class="action-btn secondary">
                    <i class="fa-solid fa-eye"></i> درخواست‌ها
                </a>
            </div>
        </div>
        <?php
    }

    public function recent_activity_widget() {
        $recent_inquiries = get_posts(array(
            'post_type' => 'service_inquiry',
            'posts_per_page' => 5,
            'post_status' => 'private',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        ?>
        <div class="recent-activity-widget">
            <style>
                /* Your recent widget styles here */
            </style>

            <?php if (!empty($recent_inquiries)) : ?>
                <h4><i class="fa-solid fa-envelope"></i> آخرین درخواست‌ها</h4>
                <?php foreach ($recent_inquiries as $inquiry) : ?>
                    <div class="activity-item">
                        <div class="activity-content">
                            <a href="<?php echo get_edit_post_link($inquiry->ID); ?>">
                                <?php echo esc_html($inquiry->post_title); ?>
                            </a>
                        </div>
                        <div class="activity-time">
                            <?php echo human_time_diff(get_the_time('U', $inquiry->ID), current_time('timestamp')); ?> پیش
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p>هنوز درخواستی ثبت نشده است</p>
            <?php endif; ?>
        </div>
        <?php
    }

    public function theme_settings_page() {
        ?>
        <div class="wrap">
            <h1><i class="fa-solid fa-gear"></i> تنظیمات تم تزنویسان</h1>

            <div class="card">
                <h2>تنظیمات کلی</h2>
                <p>برای تنظیمات ظاهری به <a href="<?php echo admin_url('customize.php'); ?>">شخصی‌ساز</a> مراجعه کنید.</p>

                <h3>پیوندهای مفید</h3>
                <ul>
                    <li><a href="<?php echo admin_url('edit.php?post_type=services'); ?>">مدیریت خدمات</a></li>
                    <li><a href="<?php echo admin_url('edit.php?post_type=service_inquiry'); ?>">مشاهده درخواست‌ها</a></li>
                    <li><a href="<?php echo admin_url('edit.php?post_type=testimonials'); ?>">نظرات مشتریان</a></li>
                    <li><a href="<?php echo admin_url('nav-menus.php'); ?>">مدیریت منوها</a></li>
                </ul>
            </div>
        </div>
        <?php
    }

    public function dashboard_overview_page() {
        ?>
        <div class="wrap">
            <h1><i class="fa-solid fa-chart-line"></i> آمار و گزارشات تزنویسان</h1>

            <div class="card">
                <h2>آمار کلی</h2>
                <div id="dashboard-stats-container">
                    <p>در حال بارگذاری آمار...</p>
                </div>
            </div>
        </div>
        <?php
    }

    public function system_status_page() {
        $theme = wp_get_theme();
        ?>
        <div class="wrap">
            <h1><i class="fa-solid fa-server"></i> وضعیت سیستم</h1>

            <div class="card">
                <h2>اطلاعات سیستم</h2>
                <table class="widefat">
                    <tbody>
                        <tr>
                            <td>نسخه وردپرس:</td>
                            <td><?php echo get_bloginfo('version'); ?></td>
                        </tr>
                        <tr>
                            <td>نسخه PHP:</td>
                            <td><?php echo phpversion(); ?></td>
                        </tr>
                        <tr>
                            <td>نسخه تم:</td>
                            <td><?php echo $theme->get('Version'); ?></td>
                        </tr>
                        <tr>
                            <td>حد حافظه:</td>
                            <td><?php echo ini_get('memory_limit'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    public function get_dashboard_stats() {
        if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['nonce'], 'teznevisan_admin_nonce')) {
            wp_die('Access denied');
        }

        $services = wp_count_posts('services');
        $inquiries = wp_count_posts('service_inquiry');
        $posts = wp_count_posts('post');

        $stats = array(
            'services' => isset($services->publish) ? intval($services->publish) : 0,
            'inquiries' => isset($inquiries->private) ? intval($inquiries->private) : 0,
            'posts' => isset($posts->publish) ? intval($posts->publish) : 0
        );

        wp_send_json_success($stats);
    }

    public function check_system_status() {
        if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['nonce'], 'teznevisan_admin_nonce')) {
            wp_die('Access denied');
        }

        $status = array(
            'wp_version' => get_bloginfo('version'),
            'php_version' => phpversion(),
            'theme_version' => wp_get_theme()->get('Version')
        );

        wp_send_json_success($status);
    }

    public function custom_admin_footer() {
        return 'ساخته شده برای تزنویسان | نسخه ' . (defined('TEZNEVISAN_VERSION') ? TEZNEVISAN_VERSION : '1.0.0');
    }

    public function admin_custom_styles() {
        $screen = get_current_screen();
        if (!$screen || strpos($screen->id, 'teznevisan') === false) {
            return;
        }

        ?>
        <style>
            .wrap h1 i {
                color: #1fa547;
                margin-left: 0.5rem;
            }
            .card {
                background: white;
                border: 1px solid #ccd0d4;
                border-radius: 4px;
                padding: 1rem;
                margin: 1rem 0;
            }
        </style>
        <?php
    }
}

// Initialize admin functions
TeznevisanAdmin::getInstance();
?>
