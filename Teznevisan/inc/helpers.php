<?php
/**
 * Helper Functions for Teznevisan Theme
 * 
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// ============================================
// READING TIME HELPER
// ============================================

if (!function_exists('teznevisan_get_reading_time')) {
    /**
     * Get post reading time
     * 
     * @param int $post_id Post ID
     * @param int $words_per_minute Average words per minute (default: 200)
     * @return int Reading time in minutes
     */
    function teznevisan_get_reading_time($post_id = 0, $words_per_minute = 200) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $post = get_post($post_id);
        if (!$post) {
            return 0;
        }
        
        $content = wp_strip_all_tags($post->post_content);
        $word_count = str_word_count($content);
        $reading_time = ceil($word_count / $words_per_minute);
        
        return max(1, $reading_time);
    }
}

if (!function_exists('estimate_reading_time')) {
    /**
     * Estimate reading time for current post
     * (Backwards compatible alias)
     * 
     * @param string $content Post content
     * @return int Reading time in minutes
     */
    function estimate_reading_time($content = '') {
        if (empty($content)) {
            return teznevisan_get_reading_time();
        }
        
        $content = wp_strip_all_tags($content);
        $word_count = str_word_count($content);
        $reading_time = ceil($word_count / 200);
        
        return max(1, $reading_time);
    }
}

// ============================================
// DISPLAY HELPERS
// ============================================

if (!function_exists('teznevisan_display_reading_time')) {
    /**
     * Display reading time HTML
     * 
     * @param int $post_id Post ID
     * @return string HTML output
     */
    function teznevisan_display_reading_time($post_id = 0) {
        $time = teznevisan_get_reading_time($post_id);
        
        if ($time <= 0) {
            return '';
        }
        
        return sprintf(
            '<span class="reading-time" title="%s"><i class="fa-solid fa-clock"></i> %d %s</span>',
            esc_attr(__('وقت تخمینی برای خواندن', 'teznevisan')),
            $time,
            _n(__('دقیقه', 'teznevisan'), __('دقیقه', 'teznevisan'), $time, 'teznevisan')
        );
    }
}

// ============================================
// SAFE FUNCTION CHECKS
// ============================================

if (!function_exists('teznevisan_theme_function_exists')) {
    /**
     * Safely check if theme function exists before calling
     * 
     * @param string $function Function name
     * @return bool
     */
    function teznevisan_theme_function_exists($function) {
        return function_exists($function);
    }
}
