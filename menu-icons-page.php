<?php
/**
 * Legacy menu-icons admin entry point.
 *
 * This generated file previously contained unresolved merge markers. The
 * feature should be rebuilt as a normal admin screen rather than writing PHP
 * files into the theme directory.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

if (is_admin() && current_user_can('manage_options')) {
    echo '<div class="notice notice-warning"><p>' . esc_html__('Menu icon management is temporarily unavailable while the admin screen is being rebuilt.', 'teznevisan') . '</p></div>';
}
