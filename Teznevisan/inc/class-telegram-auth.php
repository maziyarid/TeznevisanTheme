<?php
/**
 * Telegram Authentication Module
 * Secure Telegram Login Integration for WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class Teznevisan_Telegram_Auth {
    
    private $bot_token = '8546300826:AAGN3uhp-NSZMU41yFq9R_HWdCqLXSangHo';
    private $bot_username = 'TeznevisanBot';
    
    public function __construct() {
        add_action('init', array($this, 'handle_telegram_callback'));
        add_action('wp_ajax_telegram_auth', array($this, 'ajax_telegram_auth'));
        add_action('wp_ajax_nopriv_telegram_auth', array($this, 'ajax_telegram_auth'));
    }
    
    /**
     * Verify Telegram Authorization Data
     */
    public function verify_authorization($auth_data) {
        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        
        $secret_key = hash('sha256', $this->bot_token, true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        
        // Verify hash
        if (!hash_equals($hash, $check_hash)) {
            return false;
        }
        
        // Check if data is not outdated (max 24 hours)
        if ((time() - intval($auth_data['auth_date'])) > 86400) {
            return false;
        }
        
        return $auth_data;
    }
    
    /**
     * Get or Create WordPress User from Telegram Data
     */
    public function get_or_create_user($telegram_data) {
        $telegram_id = intval($telegram_data['id']);
        $first_name = sanitize_text_field($telegram_data['first_name']);
        $last_name = isset($telegram_data['last_name']) ? sanitize_text_field($telegram_data['last_name']) : '';
        $username = isset($telegram_data['username']) ? sanitize_text_field($telegram_data['username']) : '';
        $photo_url = isset($telegram_data['photo_url']) ? esc_url_raw($telegram_data['photo_url']) : '';
        
        // Check if user exists by Telegram ID
        $user = get_user_by('meta', 'telegram_id', $telegram_id);
        
        if (!$user) {
            // Create new user
            $user_login = 'telegram_' . $telegram_id;
            $user_email = $username ? $username . '@telegram.local' : 'user_' . $telegram_id . '@telegram.local';
            $user_nicename = $username ? $username : 'user_' . $telegram_id;
            
            // Check if email already exists
            if (email_exists($user_email)) {
                $user_email = 'user_' . $telegram_id . '_' . time() . '@telegram.local';
            }
            
            $user_id = wp_create_user(
                $user_login,
                wp_generate_password(32, true),
                $user_email
            );
            
            if (is_wp_error($user_id)) {
                return false;
            }
            
            $user = get_user_by('id', $user_id);
        }
        
        // Update user meta
        update_user_meta($user->ID, 'telegram_id', $telegram_id);
        update_user_meta($user->ID, 'first_name', $first_name);
        update_user_meta($user->ID, 'last_name', $last_name);
        update_user_meta($user->ID, 'telegram_username', $username);
        update_user_meta($user->ID, 'telegram_photo_url', $photo_url);
        update_user_meta($user->ID, 'telegram_auth_date', intval($telegram_data['auth_date']));
        
        // Update display name
        $display_name = trim($first_name . ' ' . $last_name);
        wp_update_user(array(
            'ID' => $user->ID,
            'display_name' => $display_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ));
        
        return $user;
    }
    
    /**
     * AJAX Handler for Telegram Authentication
     */
    public function ajax_telegram_auth() {
        check_ajax_referer('teznevisan_nonce', 'nonce');
        
        if (!isset($_POST['telegram_data'])) {
            wp_send_json_error(array('message' => __('بیانات تلگرام دریافت نشد', 'teznevisan')));
        }
        
        $telegram_data = json_decode(stripslashes($_POST['telegram_data']), true);
        
        if (!is_array($telegram_data)) {
            wp_send_json_error(array('message' => __('بیانات نامعتبر', 'teznevisan')));
        }
        
        // Verify Telegram data
        $verified_data = $this->verify_authorization($telegram_data);
        
        if (!$verified_data) {
            wp_send_json_error(array('message' => __('اعتبارسنجی تلگرام ناموفق بود', 'teznevisan')));
        }
        
        // Get or create user
        $user = $this->get_or_create_user($verified_data);
        
        if (!$user) {
            wp_send_json_error(array('message' => __('خطا در ایجاد حساب کاربری', 'teznevisan')));
        }
        
        // Log in user
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);
        do_action('wp_login', $user->user_login, $user);
        
        wp_send_json_success(array(
            'message' => sprintf(__('خوش آمدید %s!', 'teznevisan'), $user->display_name),
            'redirect' => home_url('/'),
        ));
    }
    
    /**
     * Handle Telegram Callback (Redirect Method)
     */
    public function handle_telegram_callback() {
        if (!isset($_GET['tg_callback'])) {
            return;
        }
        
        if ($_GET['tg_callback'] !== 'telegram_auth') {
            return;
        }
        
        // Collect Telegram auth data
        $telegram_data = array();
        $fields = array('id', 'first_name', 'last_name', 'username', 'photo_url', 'auth_date', 'hash');
        
        foreach ($fields as $field) {
            if (isset($_GET[$field])) {
                $telegram_data[$field] = $_GET[$field];
            }
        }
        
        if (empty($telegram_data)) {
            wp_die(__('بیانات تلگرام خالی است', 'teznevisan'));
        }
        
        // Verify Telegram data
        $verified_data = $this->verify_authorization($telegram_data);
        
        if (!$verified_data) {
            wp_die(__('اعتبارسنجی تلگرام ناموفق بود', 'teznevisan'));
        }
        
        // Get or create user
        $user = $this->get_or_create_user($verified_data);
        
        if (!$user) {
            wp_die(__('خطا در ایجاد حساب کاربری', 'teznevisan'));
        }
        
        // Log in user
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);
        do_action('wp_login', $user->user_login, $user);
        
        wp_safe_remote_post(home_url('/'), array('blocking' => false));
        wp_redirect(home_url('/'));
        exit;
    }
    
    /**
     * Get Telegram Widget HTML
     */
    public function get_telegram_widget() {
        $callback_url = add_query_arg(array('tg_callback' => 'telegram_auth'), home_url('/'));
        
        $html = sprintf(
            '<script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="%s" data-size="large" data-auth-url="%s" data-request-access="write"></script>',
            esc_attr($this->bot_username),
            esc_url($callback_url)
        );
        
        return $html;
    }
    
    /**
     * Logout User
     */
    public static function logout_user() {
        wp_logout();
        wp_redirect(home_url('/'));
        exit;
    }
}

// Initialize Telegram Auth
new Teznevisan_Telegram_Auth();
