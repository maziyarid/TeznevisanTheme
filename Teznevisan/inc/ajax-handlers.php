<?php
/**
 * AJAX Handlers - IP Based
 * @package Teznevisan
 */

if (!defined('ABSPATH')) exit;

/**
 * Like Post - IP Based
 */
function teznevisan_ajax_post_like() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if (!$post_id) {
        wp_send_json_error(array('message' => 'شناسه پست نامعتبر است'));
        return;
    }
    
    // Check if IP already liked
    $liked_ips = get_post_meta($post_id, '_liked_ips', true);
    if (!is_array($liked_ips)) {
        $liked_ips = array();
    }
    
    if (in_array($user_ip, $liked_ips)) {
        wp_send_json_error(array('message' => 'شما قبلاً این مطلب را پسندیده‌اید'));
        return;
    }
    
    // Add IP to liked list
    $liked_ips[] = $user_ip;
    update_post_meta($post_id, '_liked_ips', $liked_ips);
    
    // Increment likes count
    $likes = get_post_meta($post_id, 'post_likes', true);
    $likes = $likes ? intval($likes) : 0;
    $likes++;
    update_post_meta($post_id, 'post_likes', $likes);
    
    wp_send_json_success(array(
        'count' => $likes,
        'message' => 'پسندیده شد!'
    ));
}
add_action('wp_ajax_teznevisan_post_like', 'teznevisan_ajax_post_like');
add_action('wp_ajax_nopriv_teznevisan_post_like', 'teznevisan_ajax_post_like');

/**
 * Dislike Post - IP Based
 */
function teznevisan_ajax_post_dislike() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if (!$post_id) {
        wp_send_json_error(array('message' => 'شناسه پست نامعتبر است'));
        return;
    }
    
    // Check if IP already disliked
    $disliked_ips = get_post_meta($post_id, '_disliked_ips', true);
    if (!is_array($disliked_ips)) {
        $disliked_ips = array();
    }
    
    if (in_array($user_ip, $disliked_ips)) {
        wp_send_json_error(array('message' => 'شما قبلاً نظر خود را ثبت کرده‌اید'));
        return;
    }
    
    // Add IP to disliked list
    $disliked_ips[] = $user_ip;
    update_post_meta($post_id, '_disliked_ips', $disliked_ips);
    
    // Increment dislikes count
    $dislikes = get_post_meta($post_id, 'post_dislikes', true);
    $dislikes = $dislikes ? intval($dislikes) : 0;
    $dislikes++;
    update_post_meta($post_id, 'post_dislikes', $dislikes);
    
    wp_send_json_success(array(
        'count' => $dislikes,
        'message' => 'نظر شما ثبت شد'
    ));
}
add_action('wp_ajax_teznevisan_post_dislike', 'teznevisan_ajax_post_dislike');
add_action('wp_ajax_nopriv_teznevisan_post_dislike', 'teznevisan_ajax_post_dislike');

/**
 * Rate Post - IP Based
 */
function teznevisan_ajax_post_rating() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    $rating = isset($_POST['rating']) ? absint($_POST['rating']) : 0;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if (!$post_id || $rating < 1 || $rating > 5) {
        wp_send_json_error(array('message' => 'داده نامعتبر است'));
        return;
    }
    
    // Check if IP already rated
    $rated_ips = get_post_meta($post_id, '_rated_ips', true);
    if (!is_array($rated_ips)) {
        $rated_ips = array();
    }
    
    if (in_array($user_ip, $rated_ips)) {
        wp_send_json_error(array('message' => 'شما قبلاً امتیاز داده‌اید'));
        return;
    }
    
    // Add IP to rated list
    $rated_ips[] = $user_ip;
    update_post_meta($post_id, '_rated_ips', $rated_ips);
    
    // Calculate new average
    $ratings_sum = get_post_meta($post_id, 'ratings_sum', true);
    $ratings_count = get_post_meta($post_id, 'ratings_count', true);
    
    $ratings_sum = $ratings_sum ? intval($ratings_sum) : 0;
    $ratings_count = $ratings_count ? intval($ratings_count) : 0;
    
    $ratings_sum += $rating;
    $ratings_count++;
    $average = $ratings_sum / $ratings_count;
    
    update_post_meta($post_id, 'ratings_sum', $ratings_sum);
    update_post_meta($post_id, 'ratings_count', $ratings_count);
    update_post_meta($post_id, 'post_rating', $average);
    
    wp_send_json_success(array(
        'average' => number_format($average, 1),
        'count' => $ratings_count,
        'message' => 'امتیاز شما ثبت شد!'
    ));
}
add_action('wp_ajax_teznevisan_post_rating', 'teznevisan_ajax_post_rating');
add_action('wp_ajax_nopriv_teznevisan_post_rating', 'teznevisan_ajax_post_rating');

/**
 * Load More Posts
 */
function teznevisan_ajax_load_more_posts() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $paged = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $category = isset($_POST['category']) ? absint($_POST['category']) : 0;
    $posts_per_page = isset($_POST['posts_per_page']) ? absint($_POST['posts_per_page']) : 6;
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'post_status' => 'publish',
    );
    
    if ($category) {
        $args['cat'] = $category;
    }
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'post-card');
        }
        
        $html = ob_get_clean();
        
        wp_send_json_success(array(
            'html' => $html,
            'has_more' => $paged < $query->max_num_pages
        ));
    } else {
        wp_send_json_error(array('message' => 'مطلبی یافت نشد'));
    }
    
    wp_reset_postdata();
}
add_action('wp_ajax_teznevisan_load_more_posts', 'teznevisan_ajax_load_more_posts');
add_action('wp_ajax_nopriv_teznevisan_load_more_posts', 'teznevisan_ajax_load_more_posts');

/**
 * Contact Form Handler
 */
function teznevisan_ajax_contact_form() {
    check_ajax_referer('teznevisan_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    
    if (empty($name) || empty($phone) || empty($message)) {
        wp_send_json_error(array('message' => 'لطفاً تمام فیلدهای الزامی را پر کنید'));
        return;
    }
    
    // Send email to admin
    $to = get_option('admin_email');
    $subject = 'درخواست مشاوره جدید از ' . $name;
    $body = sprintf(
        "نام: %s\nتلفن: %s\nایمیل: %s\nخدمت: %s\n\nپیام:\n%s",
        $name, $phone, $email, $service, $message
    );
    
    $sent = wp_mail($to, $subject, $body);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'پیام شما با موفقیت ارسال شد'));
    } else {
        wp_send_json_error(array('message' => 'خطا در ارسال پیام'));
    }
}
add_action('wp_ajax_teznevisan_contact_form', 'teznevisan_ajax_contact_form');
add_action('wp_ajax_nopriv_teznevisan_contact_form', 'teznevisan_ajax_contact_form');