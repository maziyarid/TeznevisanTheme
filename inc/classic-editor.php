<?php
/**
 * Safe classic-editor compatibility wrapper.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ClassicEditor')) {
    class ClassicEditor {
        private $editor_id;
        private $content;
        private $settings;

        public function __construct($editor_id = 'classic-editor', $content = '', $settings = array()) {
            $this->editor_id = sanitize_key($editor_id);
            $this->content = (string) $content;
            $this->settings = wp_parse_args(
                $settings,
                array(
                    'textarea_name' => $this->editor_id,
                    'media_buttons' => current_user_can('upload_files'),
                    'teeny' => false,
                    'quicktags' => true,
                    'tinymce' => true,
                )
            );
        }

        public function render($name = '', $value = '', $attrs = array()) {
            $name = $name !== '' ? sanitize_key($name) : $this->editor_id;
            $value = $value !== '' ? (string) $value : $this->content;
            $settings = $this->settings;
            $settings['textarea_name'] = $name;
            $settings['textarea_rows'] = isset($settings['textarea_rows']) ? absint($settings['textarea_rows']) : 12;
            $settings['editor_class'] = isset($settings['editor_class']) ? sanitize_html_class($settings['editor_class']) : 'teznevisan-editor';
            if (!empty($attrs['class'])) {
                $settings['editor_class'] .= ' ' . sanitize_html_class($attrs['class']);
            }
            wp_editor($value, $this->editor_id, $settings);
        }

        public function enqueue_scripts() {
            if (!is_admin() || !current_user_can('edit_posts')) {
                return;
            }
            wp_enqueue_editor();
        }
    }
}

if (!function_exists('create_classic_editor')) {
    function create_classic_editor($id = 'classic-editor', $content = '', $settings = array()) {
        return new ClassicEditor($id, $content, $settings);
    }
}

if (!function_exists('render_classic_editor')) {
    function render_classic_editor($id = 'classic-editor', $name = '', $value = '', $settings = array(), $attrs = array()) {
        $editor = new ClassicEditor($id, $value, $settings);
        return $editor->render($name, $value, $attrs);
    }
}

add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, array('post.php', 'post-new.php'), true)) {
        return;
    }
    if (current_user_can('edit_posts')) {
        wp_enqueue_editor();
    }
});
