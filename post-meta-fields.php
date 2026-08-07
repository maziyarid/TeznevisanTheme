<?php
/**
 * Legacy post-meta admin entry point.
 *
 * This generated file previously contained unresolved merge markers. Native
 * meta-box registration and saving must be implemented in a guarded module.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

if (is_admin() && current_user_can('edit_posts')) {
    echo '<div class="notice notice-warning"><p>' . esc_html__('Legacy post metadata controls are temporarily unavailable while the meta-box implementation is being rebuilt.', 'teznevisan') . '</p></div>';
}
