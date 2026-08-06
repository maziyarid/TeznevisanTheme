<?php
/**
 * Enhanced AJAX Handlers for TezNevisan Theme
 * Complete request handling with proper validation
 */

if (!defined('ABSPATH')) {
    exit;
}

class TeznevisanAjaxHandlers {
    
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_ajax_handlers();
    }
    
    private function init_ajax_handlers() {
        // Contact form handlers
        add_action('wp_ajax_contact_form', array($this, 'handle_contact_form'));
        add_action('wp_ajax_nopriv_contact_form', array($this, 'handle_contact_form'));
        
        // Newsletter signup
        add_action('wp_ajax_newsletter_signup', array($this, 'handle_newsletter_signup'));
        add_action('wp_ajax_nopriv_newsletter_signup', array($this, 'handle_newsletter_signup'));
        
        // Mobile order
        add_action('wp_ajax_mobile_order', array($this, 'handle_mobile_order'));
        add_action('wp_ajax_nopriv_mobile_order', array($this, 'handle_mobile_order'));
        
        // Service inquiry
        add_action('wp_ajax_service_inquiry', array($this, 'handle_service_inquiry'));
        add_action('wp_ajax_nopriv_service_inquiry', array($this, 'handle_service_inquiry'));
        
        // Post reactions
        add_action('wp_ajax_post_reaction', array($this, 'handle_post_reaction'));
        add_action('wp_ajax_nopriv_post_reaction', array($this, 'handle_post_reaction'));
        
        // Live search
        add_action('wp_ajax_live_search', array($this, 'handle_live_search'));
        add_action('wp_ajax_nopriv_live_search', array($this, 'handle_live_search'));
        
        // Cookie consent
        add_action('wp_ajax_accept_cookies', array($this, 'handle_cookie_consent'));
        add_action('wp_ajax_nopriv_accept_cookies', array($this, 'handle_cookie_consent'));
        
        // Admin only handlers
        add_action('wp_ajax_get_dashboard_stats', array($this, 'get_dashboard_stats'));
        add_action('wp_ajax_check_system_status', array($this, 'check_system_status'));
        add_action('wp_ajax_dismiss_welcome_notice', array($this, 'dismiss_welcome_notice'));
        
        // Theme data handlers
        add_action('wp_ajax_get_theme_data', array($this, 'get_theme_data'));
        add_action('wp_ajax_nopriv_get_theme_data', array($this, 'get_theme_data'));
    }
    
    /**
     * Enhanced Contact Form Handler
     */
    public function handle_contact_form() {
        // Security check
        if (!$this->verify_nonce('teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی - لطفاً صفحه را تازه کرده و مجدداً تلاش کنید');
        }
        
        // Rate limiting
        if (!$this->check_rate_limit('contact_form', 3, 600)) { // 3 times per 10 minutes
            wp_send_json_error('تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً ۱۰ دقیقه صبر کنید.');
        }
        
        // Sanitize and validate input
        $data = $this->sanitize_contact_data($_POST);
        $validation_errors = $this->validate_contact_data($data);
        
        if (!empty($validation_errors)) {
            wp_send_json_error('خطاهای اعتبارسنجی: ' . implode(', ', $validation_errors));
        }
        
        // Create contact submission
        $submission_id = $this->create_contact_submission($data);
        
        if (!$submission_id) {
            wp_send_json_error('خطا در ثبت پیام. لطفاً مجدداً تلاش کنید.');
        }
        
        // Send notification email
        $email_sent = $this->send_contact_notification($data, $submission_id);
        
        // Send auto-reply if enabled
        if ($email_sent && get_theme_mod('contact_auto_reply', true)) {
            $this->send_contact_auto_reply($data);
        }
        
        // Update rate limit counter
        $this->update_rate_limit('contact_form');
        
        // Log the submission
        $this->log_form_submission('contact_form', $data, $submission_id);
        
        wp_send_json_success(array(
            'message' => 'پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.',
            'submission_id' => $submission_id
        ));
    }
    
    /**
     * Enhanced Newsletter Signup Handler
     */
    public function handle_newsletter_signup() {
        if (!$this->verify_nonce('teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        if (!$this->check_rate_limit('newsletter_signup', 5, 300)) { // 5 times per 5 minutes
            wp_send_json_error('تعداد درخواست‌های شما بیش از حد مجاز است.');
        }
        
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $name = sanitize_text_field($_POST['name'] ?? '');
        
        // Validation
        if (empty($phone) && empty($email)) {
            wp_send_json_error('شماره تماس یا ایمیل الزامی است');
        }
        
        if (!empty($phone) && !$this->validate_iranian_phone($phone)) {
            wp_send_json_error('شماره تماس معتبر نیست');
        }
        
        if (!empty($email) && !is_email($email)) {
            wp_send_json_error('آدرس ایمیل معتبر نیست');
        }
        
        // Get current subscribers
        $phone_subscribers = get_option('teznevisan_newsletter_phones', array());
        $email_subscribers = get_option('teznevisan_newsletter_emails', array());
        
        $added = false;
        $message = '';
        
        // Add phone if provided and new
        if (!empty($phone) && !in_array($phone, $phone_subscribers)) {
            $phone_subscribers[] = $phone;
            update_option('teznevisan_newsletter_phones', $phone_subscribers);
            $added = true;
            $message = 'شماره تماس در لیست اطلاع‌رسانی ثبت شد';
        }
        
        // Add email if provided and new
        if (!empty($email) && !in_array($email, $email_subscribers)) {
            $email_subscribers[] = $email;
            update_option('teznevisan_newsletter_emails', $email_subscribers);
            $added = true;
            $message = empty($message) ? 'ایمیل در لیست اطلاع‌رسانی ثبت شد' : 'اطلاعات در لیست اطلاع‌رسانی ثبت شد';
        }
        
        if ($added) {
            // Create newsletter subscriber record
            $subscriber_id = wp_insert_post(array(
                'post_title' => 'مشترک: ' . ($name ?: $phone ?: $email),
                'post_content' => wp_json_encode(array(
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'date' => current_time('mysql'),
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
                ), JSON_UNESCAPED_UNICODE),
                'post_status' => 'private',
                'post_type' => 'newsletter_subscriber'
            ));
            
            // Send welcome email if email provided
            if (!empty($email)) {
                $this->send_newsletter_welcome_email($email, $name);
            }
            
            $this->update_rate_limit('newsletter_signup');
            
            wp_send_json_success(array(
                'message' => $message,
                'total_subscribers' => count($phone_subscribers) + count($email_subscribers),
                'subscriber_id' => $subscriber_id
            ));
        } else {
            wp_send_json_error('این شماره/ایمیل قبلاً در لیست ثبت شده است');
        }
    }
    
    /**
     * Enhanced Mobile Order Handler
     */
    public function handle_mobile_order() {
        if (!$this->verify_nonce('teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        if (!$this->check_rate_limit('mobile_order', 2, 1800)) { // 2 times per 30 minutes
            wp_send_json_error('تعداد سفارش‌های شما بیش از حد مجاز است. لطفاً ۳۰ دقیقه صبر کنید.');
        }
        
        // Sanitize data
        $data = array(
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'major' => sanitize_text_field($_POST['major'] ?? ''),
            'degree' => sanitize_text_field($_POST['degree'] ?? ''),
            'university' => sanitize_text_field($_POST['university'] ?? ''),
            'urgency' => sanitize_text_field($_POST['urgency'] ?? 'normal'),
            'budget' => sanitize_text_field($_POST['budget'] ?? ''),
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'date' => current_time('mysql')
        );
        
        // Validation
        $required_fields = array('name', 'phone', 'major', 'degree');
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                wp_send_json_error('لطفاً تمام فیلدهای ضروری را تکمیل کنید: ' . $field);
            }
        }
        
        if (!$this->validate_iranian_phone($data['phone'])) {
            wp_send_json_error('شماره تماس معتبر نیست');
        }
        
        if (!empty($data['email']) && !is_email($data['email'])) {
            wp_send_json_error('آدرس ایمیل معتبر نیست');
        }
        
        // Create order record
        $order_id = wp_insert_post(array(
            'post_title' => sprintf('سفارش موبایل: %s - %s (%s)', $data['name'], $data['major'], $data['degree']),
            'post_content' => wp_json_encode($data, JSON_UNESCAPED_UNICODE),
            'post_status' => 'private',
            'post_type' => 'service_inquiry',
            'meta_input' => array(
                'inquiry_type' => 'mobile_order',
                'customer_name' => $data['name'],
                'customer_phone' => $data['phone'],
                'customer_email' => $data['email'],
                'urgency_level' => $data['urgency'],
                'submission_ip' => $data['ip'],
                'submission_date' => $data['date'],
                'inquiry_status' => 'new'
            )
        ));
        
        if ($order_id) {
            // Send notification email
            $this->send_mobile_order_notification($data, $order_id);
            
            // Send confirmation SMS/email to customer
            $this->send_mobile_order_confirmation($data, $order_id);
            
            $this->update_rate_limit('mobile_order');
            
            wp_send_json_success(array(
                'message' => 'درخواست شما با شماره پیگیری #' . $order_id . ' ثبت شد! کارشناسان ما طی ۲ ساعت آینده با شما تماس خواهند گرفت.',
                'tracking_id' => $order_id,
                'estimated_response_time' => '۲ ساعت'
            ));
        } else {
            wp_send_json_error('خطا در ثبت درخواست. لطفاً مجدداً تلاش کنید.');
        }
    }
    
    /**
     * Enhanced Service Inquiry Handler
     */
    public function handle_service_inquiry() {
        if (!$this->verify_nonce('teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        if (!$this->check_rate_limit('service_inquiry', 3, 1800)) { // 3 times per 30 minutes
            wp_send_json_error('تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً ۳۰ دقیقه صبر کنید.');
        }
        
        $service_id = absint($_POST['service_id'] ?? 0);
        
        // Validate service exists
        if (!$service_id || get_post_type($service_id) !== 'services') {
            wp_send_json_error('خدمت انتخابی معتبر نیست');
        }
        
        $data = array(
            'service_id' => $service_id,
            'service_name' => get_the_title($service_id),
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'field' => sanitize_text_field($_POST['field'] ?? ''),
            'degree' => sanitize_text_field($_POST['degree'] ?? ''),
            'university' => sanitize_text_field($_POST['university'] ?? ''),
            'urgency' => sanitize_text_field($_POST['urgency'] ?? 'normal'),
            'budget' => sanitize_text_field($_POST['budget'] ?? ''),
            'deadline' => sanitize_text_field($_POST['deadline'] ?? ''),
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'additional_info' => sanitize_textarea_field($_POST['additional_info'] ?? ''),
            'preferred_contact' => sanitize_text_field($_POST['preferred_contact'] ?? 'phone'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'date' => current_time('mysql')
        );
        
        // Validation
        $required_fields = array('name', 'phone', 'email');
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                wp_send_json_error('لطفاً فیلد ' . $field . ' را تکمیل کنید');
            }
        }
        
        if (!$this->validate_iranian_phone($data['phone'])) {
            wp_send_json_error('شماره تماس معتبر نیست');
        }
        
        if (!is_email($data['email'])) {
            wp_send_json_error('آدرس ایمیل معتبر نیست');
        }
        
        // Check for duplicate recent submissions
        $existing = get_posts(array(
            'post_type' => 'service_inquiry',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'customer_phone',
                    'value' => $data['phone'],
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
        
        if (!empty($existing)) {
            wp_send_json_error('شما قبلاً برای این خدمت درخواست ارسال کرده‌اید. کارشناسان ما به زودی با شما تماس خواهند گرفت.');
        }
        
        // Create inquiry
        $inquiry_id = wp_insert_post(array(
            'post_title' => sprintf('درخواست خدمت: %s - %s', $data['name'], $data['service_name']),
            'post_content' => wp_json_encode($data, JSON_UNESCAPED_UNICODE),
            'post_status' => 'private',
            'post_type' => 'service_inquiry',
            'meta_input' => array(
                'inquiry_type' => 'service_inquiry',
                'service_id' => $service_id,
                'customer_name' => $data['name'],
                'customer_phone' => $data['phone'],
                'customer_email' => $data['email'],
                'urgency_level' => $data['urgency'],
                'submission_ip' => $data['ip'],
                'submission_date' => $data['date'],
                'inquiry_status' => 'new'
            )
        ));
        
        if ($inquiry_id) {
            // Send notifications
            $this->send_service_inquiry_notification($data, $inquiry_id);
            $this->send_service_inquiry_confirmation($data, $inquiry_id);
            
            $this->update_rate_limit('service_inquiry');
            
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
     * Post Reaction Handler (Like/Dislike)
     */
    public function handle_post_reaction() {
        if (!$this->verify_nonce('teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        $post_id = absint($_POST['post_id'] ?? 0);
        $action = sanitize_text_field($_POST['action_type'] ?? '');
        
        if (!$post_id || !in_array($action, array('like', 'dislike'))) {
            wp_send_json_error('درخواست نامعتبر');
        }
        
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        // Get current reactions
        $likes = intval(get_post_meta($post_id, 'post_likes', true));
        $dislikes = intval(get_post_meta($post_id, 'post_dislikes', true));
        $user_reactions = get_post_meta($post_id, 'user_reactions', true) ?: array();
        
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
            // Toggle (remove) if same as previous
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
     * Live Search Handler
     */
    public function handle_live_search() {
        if (!$this->verify_nonce('teznevisan_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        $query = sanitize_text_field($_POST['query'] ?? '');
        
        if (strlen($query) < 3) {
            wp_send_json_error('حداقل ۳ کاراکتر وارد کنید');
        }
        
        $search_results = new WP_Query(array(
            's' => $query,
            'posts_per_page' => 8,
            'post_type' => array('post', 'services', 'page'),
            'post_status' => 'publish'
        ));
        
        $results_html = '';
        
        if ($search_results->have_posts()) {
            $results_html .= '<div class="live-search-results">';
            
            while ($search_results->have_posts()) {
                $search_results->the_post();
                $post_type_icon = $this->get_post_type_icon(get_post_type());
                $post_type_label = $this->get_post_type_label(get_post_type());
                
                $results_html .= '<div class="search-result-item">';
                $results_html .= '<a href="' . get_permalink() . '">';
                
                if (has_post_thumbnail()) {
                    $results_html .= '<div class="result-thumbnail">';
                    $results_html .= get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                    $results_html .= '</div>';
                }
                
                $results_html .= '<div class="result-content">';
                $results_html .= '<div class="result-type">';
                $results_html .= '<i class="' . $post_type_icon . '"></i> ' . $post_type_label;
                $results_html .= '</div>';
                $results_html .= '<div class="result-title">' . get_the_title() . '</div>';
                $results_html .= '<div class="result-excerpt">' . wp_trim_words(get_the_excerpt(), 15) . '</div>';
                $results_html .= '</div>';
                
                $results_html .= '</a>';
                $results_html .= '</div>';
            }
            
            $results_html .= '<div class="search-result-footer">';
            $results_html .= '<a href="' . home_url('/?s=' . urlencode($query)) . '">';
            $results_html .= '<i class="fa-solid fa-magnifying-glass"></i> مشاهده تمام نتایج';
            $results_html .= '</a>';
            $results_html .= '</div>';
            
            $results_html .= '</div>';
            
            wp_reset_postdata();
        } else {
            $results_html = '<div class="no-search-results">';
            $results_html .= '<i class="fa-solid fa-magnifying-glass"></i>';
            $results_html .= '<p>نتیجه‌ای یافت نشد</p>';
            $results_html .= '<small>کلمات کلیدی دیگری امتحان کنید</small>';
            $results_html .= '</div>';
        }
        
        wp_send_json_success(array('html' => $results_html));
    }
    
    /**
     * Cookie Consent Handler
     */
    public function handle_cookie_consent() {
        $accepted = sanitize_text_field($_POST['accepted'] ?? 'no');
        
        if ($accepted === 'yes') {
            setcookie('teznevisan_cookies_accepted', 'yes', time() + (365 * 24 * 60 * 60), '/');
            wp_send_json_success('کوکی‌ها پذیرفته شد');
        } else {
            setcookie('teznevisan_cookies_accepted', 'no', time() + (30 * 24 * 60 * 60), '/');
            wp_send_json_success('کوکی‌ها رد شد');
        }
    }
    
    /**
     * Get Dashboard Stats (Admin Only)
     */
    public function get_dashboard_stats() {
        if (!current_user_can('manage_options') || !$this->verify_nonce('teznevisan_admin_nonce')) {
            wp_send_json_error('دسترسی مجاز نیست');
        }
        
        // Get comprehensive stats
        $services = wp_count_posts('services');
        $inquiries = wp_count_posts('service_inquiry');
        $testimonials = wp_count_posts('testimonials');
        $posts = wp_count_posts('post');
        
        $stats = array(
            'services' => isset($services->publish) ? $services->publish : 0,
            'inquiries' => isset($inquiries->private) ? $inquiries->private : 0,
            'testimonials' => isset($testimonials->publish) ? $testimonials->publish : 0,
            'posts' => isset($posts->publish) ? $posts->publish : 0,
            'subscribers' => count(get_option('teznevisan_newsletter_phones', array())) + count(get_option('teznevisan_newsletter_emails', array()))
        );
        
        wp_send_json_success($stats);
    }
    
    /**
     * Check System Status (Admin Only)
     */
    public function check_system_status() {
        if (!current_user_can('manage_options') || !$this->verify_nonce('teznevisan_admin_nonce')) {
            wp_send_json_error('دسترسی مجاز نیست');
        }
        
        $status = array(
            'wp_version' => get_bloginfo('version'),
            'php_version' => phpversion(),
            'mysql_version' => $GLOBALS['wpdb']->db_version(),
            'theme_version' => wp_get_theme()->get('Version'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'curl_enabled' => function_exists('curl_init'),
            'gd_enabled' => extension_loaded('gd'),
            'ssl_enabled' => is_ssl()
        );
        
        wp_send_json_success($status);
    }
    
    /**
     * Dismiss Welcome Notice (Admin Only)
     */
    public function dismiss_welcome_notice() {
        if (!current_user_can('manage_options') || !$this->verify_nonce('teznevisan_admin_nonce')) {
            wp_send_json_error('دسترسی مجاز نیست');
        }
        
        update_option('teznevisan_admin_welcomed', true);
        wp_send_json_success('اعلان بسته شد');
    }
    
    /**
     * Get Theme Data
     */
    public function get_theme_data() {
        $data = array(
            'theme_name' => wp_get_theme()->get('Name'),
            'theme_version' => wp_get_theme()->get('Version'),
            'home_url' => home_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'is_rtl' => is_rtl(),
            'current_user_can_edit' => current_user_can('edit_posts')
        );
        
        wp_send_json_success($data);
    }
    
    // Helper Methods
    
    /**
     * Verify Nonce
     */
    private function verify_nonce($action) {
        return wp_verify_nonce($_POST['nonce'] ?? '', $action);
    }
    
    /**
     * Rate Limiting
     */
    private function check_rate_limit($action, $max_attempts, $time_window) {
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $rate_limit_key = $action . '_' . md5($user_ip);
        $current_count = get_transient($rate_limit_key) ?: 0;
        
        return $current_count < $max_attempts;
    }
    
    private function update_rate_limit($action) {
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $rate_limit_key = $action . '_' . md5($user_ip);
        $current_count = get_transient($rate_limit_key) ?: 0;
        $time_window = $this->get_rate_limit_window($action);
        
        set_transient($rate_limit_key, $current_count + 1, $time_window);
    }
    
    private function get_rate_limit_window($action) {
        $windows = array(
            'contact_form' => 600,      // 10 minutes
            'newsletter_signup' => 300, // 5 minutes
            'mobile_order' => 1800,     // 30 minutes
            'service_inquiry' => 1800   // 30 minutes
        );
        
        return isset($windows[$action]) ? $windows[$action] : 300;
    }
    
    /**
     * Validate Iranian Phone Number
     */
    private function validate_iranian_phone($phone) {
        return preg_match('/^(\+98|0)?9\d{9}$/', $phone);
    }
    
    /**
     * Sanitize Contact Data
     */
    private function sanitize_contact_data($data) {
        return array(
            'name' => sanitize_text_field($data['name'] ?? ''),
            'email' => sanitize_email($data['email'] ?? ''),
            'phone' => sanitize_text_field($data['phone'] ?? ''),
            'subject' => sanitize_text_field($data['subject'] ?? 'پیام از سایت'),
            'message' => sanitize_textarea_field($data['message'] ?? ''),
            'service_id' => absint($data['service_id'] ?? 0),
            'form_type' => sanitize_text_field($data['form_type'] ?? 'general')
        );
    }
    
    /**
     * Validate Contact Data
     */
    private function validate_contact_data($data) {
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
        
        if (!empty($data['phone']) && !$this->validate_iranian_phone($data['phone'])) {
            $errors[] = 'شماره تماس معتبر نیست';
        }
        
        return $errors;
    }
    
    /**
     * Create Contact Submission
     */
    private function create_contact_submission($data) {
        return wp_insert_post(array(
            'post_title' => sprintf('پیام از %s - %s', $data['name'], $data['subject']),
            'post_content' => wp_json_encode($data, JSON_UNESCAPED_UNICODE),
            'post_status' => 'private',
            'post_type' => 'contact_submissions',
            'meta_input' => array(
                'contact_name' => $data['name'],
                'contact_email' => $data['email'],
                'contact_phone' => $data['phone'],
                'contact_subject' => $data['subject'],
                'form_type' => $data['form_type'],
                'submission_ip' => $_SERVER['REMOTE_ADDR'],
                'submission_date' => current_time('mysql')
            )
        ));
    }
    
    /**
     * Send Contact Notification
     */
    private function send_contact_notification($data, $submission_id) {
        $admin_emails = array(
            'shoja.kord@yahoo.com',
            'maziyarid@gmail.com', 
            'teznevisan@gmail.com'
        );
        
        $subject = sprintf('پیام جدید از %s - %s', get_bloginfo('name'), $data['subject']);
        $message = $this->format_contact_email($data, $submission_id);
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
            'Reply-To: ' . $data['email']
        );
        
        return wp_mail($admin_emails, $subject, $message, $headers);
    }
    
    /**
     * Format Contact Email
     */
    private function format_contact_email($data, $submission_id) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Vazirmatn", Tahoma, Arial, sans-serif; direction: rtl; }
                .container { max-width: 600px; margin: 0 auto; background: #f8f9fa; }
                .header { background: #1fa547; color: white; padding: 2rem; text-align: center; }
                .content { background: white; padding: 2rem; }
                .info-row { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee; }
                .label { font-weight: bold; }
                .message-content { background: #f8f9fa; padding: 1rem; border-radius: 5px; margin: 1rem 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>پیام جدید از سایت</h2>
                    <p><?php echo get_bloginfo('name'); ?></p>
                </div>
                <div class="content">
                    <div class="info-row">
                        <span class="label">نام فرستنده:</span>
                        <span><?php echo esc_html($data['name']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">ایمیل:</span>
                        <span><?php echo esc_html($data['email']); ?></span>
                    </div>
                    <?php if (!empty($data['phone'])) : ?>
                    <div class="info-row">
                        <span class="label">تلفن:</span>
                        <span><?php echo esc_html($data['phone']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="info-row">
                        <span class="label">موضوع:</span>
                        <span><?php echo esc_html($data['subject']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">شماره پیگیری:</span>
                        <span>#<?php echo esc_html($submission_id); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">تاریخ:</span>
                        <span><?php echo jdate('Y/m/d H:i'); ?></span>
                    </div>
                    
                    <h3>متن پیام:</h3>
                    <div class="message-content">
                        <?php echo nl2br(esc_html($data['message'])); ?>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Send Auto-Reply
     */
    private function send_contact_auto_reply($data) {
        $subject = sprintf('تایید دریافت پیام - %s', get_bloginfo('name'));
        $message = sprintf(
            'سلام %s,<br><br>پیام شما با موضوع "%s" دریافت شد.<br>کارشناسان ما به زودی با شما تماس خواهند گرفت.<br><br>با تشکر<br>تیم %s',
            $data['name'],
            $data['subject'],
            get_bloginfo('name')
        );
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'
        );
        
        return wp_mail($data['email'], $subject, $message, $headers);
    }
    
    /**
     * Get Post Type Icon
     */
    private function get_post_type_icon($post_type) {
        $icons = array(
            'post' => 'fa-solid fa-newspaper',
            'services' => 'fa-solid fa-gear',
            'page' => 'fa-solid fa-file-lines'
        );
        
        return isset($icons[$post_type]) ? $icons[$post_type] : 'fa-solid fa-file';
    }
    
    /**
     * Get Post Type Label
     */
    private function get_post_type_label($post_type) {
        $labels = array(
            'post' => 'مقاله',
            'services' => 'خدمت',
            'page' => 'صفحه'
        );
        
        return isset($labels[$post_type]) ? $labels[$post_type] : 'محتوا';
    }
    
    /**
     * Send Newsletter Welcome Email
     */
    private function send_newsletter_welcome_email($email, $name) {
        $subject = sprintf('خوش آمدید به خبرنامه %s', get_bloginfo('name'));
        $message = sprintf(
            'سلام %s,<br><br>با تشکر از عضویت در خبرنامه ما.<br>از این پس از آخرین اخبار، مقالات و تخفیف‌ها مطلع خواهید شد.<br><br>با تشکر<br>تیم %s',
            $name ?: 'کاربر عزیز',
            get_bloginfo('name')
        );
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'
        );
        
        return wp_mail($email, $subject, $message, $headers);
    }
    
    /**
     * Log Form Submission
     */
    private function log_form_submission($form_type, $data, $submission_id) {
        $log_entry = array(
            'form_type' => $form_type,
            'submission_id' => $submission_id,
            'data' => $data,
            'timestamp' => current_time('mysql'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        );
        
        // Save to custom log table or option
        $logs = get_option('teznevisan_form_logs', array());
        $logs[] = $log_entry;
        
        // Keep only last 1000 entries
        if (count($logs) > 1000) {
            $logs = array_slice($logs, -1000);
        }
        
        update_option('teznevisan_form_logs', $logs);
    }
    
    /**
     * Send Mobile Order Notification
     */
    private function send_mobile_order_notification($data, $order_id) {
        $admin_emails = array(
            'shoja.kord@yahoo.com',
            'maziyarid@gmail.com',
            'teznevisan@gmail.com'
        );
        
        $subject = sprintf('سفارش موبایل جدید #%s - %s', $order_id, $data['name']);
        $message = $this->format_mobile_order_email($data, $order_id);
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'
        );
        
        return wp_mail($admin_emails, $subject, $message, $headers);
    }
    
    /**
     * Format Mobile Order Email
     */
    private function format_mobile_order_email($data, $order_id) {
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
        
        $urgency_color = $urgency_colors[$data['urgency']] ?? '#28a745';
        $urgency_label = $urgency_labels[$data['urgency']] ?? 'عادی';
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Vazirmatn", Tahoma, Arial, sans-serif; direction: rtl; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background: #1fa547; color: white; padding: 2rem; text-align: center; }
                .content { background: white; padding: 2rem; border: 1px solid #ddd; }
                .urgency-badge { 
                    background: <?php echo $urgency_color; ?>; 
                    color: white; 
                    padding: 0.5rem 1rem; 
                    border-radius: 20px; 
                    font-weight: bold;
                    display: inline-block;
                    margin-bottom: 1rem;
                }
                .info-grid { display: grid; gap: 1rem; }
                .info-item { 
                    display: flex; 
                    justify-content: space-between; 
                    padding: 0.5rem 0; 
                    border-bottom: 1px solid #eee; 
                }
                .label { font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>سفارش موبایل جدید</h2>
                    <p>شماره پیگیری: #<?php echo $order_id; ?></p>
                </div>
                <div class="content">
                    <div class="urgency-badge">
                        اولویت: <?php echo $urgency_label; ?>
                    </div>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="label">نام:</span>
                            <span><?php echo esc_html($data['name']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">تلفن:</span>
                            <span><?php echo esc_html($data['phone']); ?></span>
                        </div>
                        <?php if (!empty($data['email'])) : ?>
                        <div class="info-item">
                            <span class="label">ایمیل:</span>
                            <span><?php echo esc_html($data['email']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-item">
                            <span class="label">رشته:</span>
                            <span><?php echo esc_html($data['major']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">مقطع:</span>
                            <span><?php echo esc_html($data['degree']); ?></span>
                        </div>
                        <?php if (!empty($data['university'])) : ?>
                        <div class="info-item">
                            <span class="label">دانشگاه:</span>
                            <span><?php echo esc_html($data['university']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($data['budget'])) : ?>
                        <div class="info-item">
                            <span class="label">بودجه:</span>
                            <span><?php echo esc_html($data['budget']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-item">
                            <span class="label">تاریخ ثبت:</span>
                            <span><?php echo jdate('Y/m/d H:i', strtotime($data['date'])); ?></span>
                        </div>
                    </div>
                    
                    <?php if (!empty($data['description'])) : ?>
                    <div style="margin-top: 1rem;">
                        <strong>توضیحات:</strong>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <?php echo nl2br(esc_html($data['description'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Send Mobile Order Confirmation
     */
    private function send_mobile_order_confirmation($data, $order_id) {
        if (empty($data['email'])) return false;
        
        $subject = sprintf('تایید دریافت سفارش #%s - %s', $order_id, get_bloginfo('name'));
        $message = sprintf(
            'سلام %s,<br><br>سفارش شما با شماره پیگیری #%s دریافت شد.<br>کارشناسان ما طی ۲ ساعت آینده با شما تماس خواهند گرفت.<br><br>جزئیات سفارش:<br>- رشته: %s<br>- مقطع: %s<br>- اولویت: %s<br><br>با تشکر<br>تیم %s',
            $data['name'],
            $order_id,
            $data['major'],
            $data['degree'],
            $data['urgency'] === 'emergency' ? 'اضطراری' : ($data['urgency'] === 'urgent' ? 'فوری' : 'عادی'),
            get_bloginfo('name')
        );
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'
        );
        
        return wp_mail($data['email'], $subject, $message, $headers);
    }
    
    /**
     * Send Service Inquiry Notification
     */
    private function send_service_inquiry_notification($data, $inquiry_id) {
        $admin_emails = array(
            'shoja.kord@yahoo.com',
            'maziyarid@gmail.com',
            'teznevisan@gmail.com'
        );
        
        $subject = sprintf('درخواست خدمت جدید #%s - %s', $inquiry_id, $data['service_name']);
        $message = $this->format_service_inquiry_email($data, $inquiry_id);
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'
        );
        
        return wp_mail($admin_emails, $subject, $message, $headers);
    }
    
    /**
     * Format Service Inquiry Email
     */
    private function format_service_inquiry_email($data, $inquiry_id) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Vazirmatn", Tahoma, Arial, sans-serif; direction: rtl; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background: #1fa547; color: white; padding: 2rem; text-align: center; }
                .content { background: white; padding: 2rem; border: 1px solid #ddd; }
                .service-info { background: #e8f5e8; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
                .info-item { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee; }
                .label { font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>درخواست خدمت جدید</h2>
                    <p>شماره پیگیری: #<?php echo $inquiry_id; ?></p>
                </div>
                <div class="content">
                    <div class="service-info">
                        <strong>خدمت درخواستی: <?php echo esc_html($data['service_name']); ?></strong>
                    </div>
                    
                    <div class="info-item">
                        <span class="label">نام متقاضی:</span>
                        <span><?php echo esc_html($data['name']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">تلفن:</span>
                        <span><?php echo esc_html($data['phone']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">ایمیل:</span>
                        <span><?php echo esc_html($data['email']); ?></span>
                    </div>
                    
                    <?php if (!empty($data['field'])) : ?>
                    <div class="info-item">
                        <span class="label">رشته:</span>
                        <span><?php echo esc_html($data['field']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['degree'])) : ?>
                    <div class="info-item">
                        <span class="label">مقطع:</span>
                        <span><?php echo esc_html($data['degree']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['university'])) : ?>
                    <div class="info-item">
                        <span class="label">دانشگاه:</span>
                        <span><?php echo esc_html($data['university']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="info-item">
                        <span class="label">اولویت:</span>
                        <span><?php echo $data['urgency'] === 'emergency' ? 'اضطراری' : ($data['urgency'] === 'urgent' ? 'فوری' : 'عادی'); ?></span>
                    </div>
                    
                    <?php if (!empty($data['budget'])) : ?>
                    <div class="info-item">
                        <span class="label">بودجه:</span>
                        <span><?php echo esc_html($data['budget']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['deadline'])) : ?>
                    <div class="info-item">
                        <span class="label">مهلت تحویل:</span>
                        <span><?php echo esc_html($data['deadline']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="info-item">
                        <span class="label">روش تماس مطلوب:</span>
                        <span><?php echo $data['preferred_contact'] === 'email' ? 'ایمیل' : 'تلفن'; ?></span>
                    </div>
                    
                    <?php if (!empty($data['description'])) : ?>
                    <div style="margin-top: 1rem;">
                        <strong>توضیحات پروژه:</strong>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <?php echo nl2br(esc_html($data['description'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['additional_info'])) : ?>
                    <div style="margin-top: 1rem;">
                        <strong>اطلاعات تکمیلی:</strong>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-top: 0.5rem;">
                            <?php echo nl2br(esc_html($data['additional_info'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div style="margin-top: 1rem; font-size: 0.9rem; color: #666;">
                        <strong>اطلاعات فنی:</strong><br>
                        IP: <?php echo esc_html($data['ip']); ?><br>
                        تاریخ: <?php echo jdate('Y/m/d H:i:s', strtotime($data['date'])); ?>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Send Service Inquiry Confirmation
     */
    private function send_service_inquiry_confirmation($data, $inquiry_id) {
        $subject = sprintf('تایید دریافت درخواست #%s - %s', $inquiry_id, get_bloginfo('name'));
        $message = sprintf(
            'سلام %s,<br><br>درخواست شما برای خدمت "%s" با شماره پیگیری #%s دریافت شد.<br><br>کارشناسان ما طی ۲ ساعت آینده از طریق %s با شما تماس خواهند گرفت.<br><br>با تشکر<br>تیم %s',
            $data['name'],
            $data['service_name'],
            $inquiry_id,
            $data['preferred_contact'] === 'email' ? 'ایمیل' : 'تلفن',
            get_bloginfo('name')
        );
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'
        );
        
        return wp_mail($data['email'], $subject, $message, $headers);
    }
}

// Initialize AJAX handlers
TeznevisanAjaxHandlers::getInstance();
?>