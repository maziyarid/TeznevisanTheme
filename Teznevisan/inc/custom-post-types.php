<?php
/**
 * Custom Post Types and Taxonomies
 * 
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Services Post Type
 */
function teznevisan_register_services_post_type() {
    $labels = array(
        'name' => 'خدمات',
        'singular_name' => 'خدمت',
        'menu_name' => 'خدمات',
        'add_new' => 'افزودن خدمت',
        'add_new_item' => 'افزودن خدمت جدید',
        'edit_item' => 'ویرایش خدمت',
        'new_item' => 'خدمت جدید',
        'view_item' => 'مشاهده خدمت',
        'search_items' => 'جستجوی خدمات',
        'not_found' => 'خدمتی یافت نشد',
        'not_found_in_trash' => 'خدمتی در زباله‌دان یافت نشد',
        'all_items' => 'همه خدمات',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'services'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-hammer',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields'),
        'taxonomies' => array('service-category'),
    );
    
    register_post_type('services', $args);
}
add_action('init', 'teznevisan_register_services_post_type');

/**
 * Register Service Category Taxonomy
 */
function teznevisan_register_service_taxonomy() {
    $labels = array(
        'name' => 'دسته‌بندی خدمات',
        'singular_name' => 'دسته خدمات',
        'search_items' => 'جستجوی دسته‌ها',
        'all_items' => 'همه دسته‌ها',
        'parent_item' => 'دسته والد',
        'parent_item_colon' => 'دسته والد:',
        'edit_item' => 'ویرایش دسته',
        'update_item' => 'به‌روزرسانی دسته',
        'add_new_item' => 'افزودن دسته جدید',
        'new_item_name' => 'نام دسته جدید',
        'menu_name' => 'دسته‌بندی',
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'service-category'),
    );
    
    register_taxonomy('service-category', array('services'), $args);
}
add_action('init', 'teznevisan_register_service_taxonomy');

/**
 * Register Portfolio Post Type
 */
function teznevisan_register_portfolio_post_type() {
    $labels = array(
        'name' => 'نمونه کارها',
        'singular_name' => 'نمونه کار',
        'menu_name' => 'نمونه کارها',
        'add_new' => 'افزودن نمونه کار',
        'add_new_item' => 'افزودن نمونه کار جدید',
        'edit_item' => 'ویرایش نمونه کار',
        'new_item' => 'نمونه کار جدید',
        'view_item' => 'مشاهده نمونه کار',
        'search_items' => 'جستجوی نمونه کارها',
        'not_found' => 'نمونه کاری یافت نشد',
        'not_found_in_trash' => 'نمونه کاری در زباله‌دان یافت نشد',
        'all_items' => 'همه نمونه کارها',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );
    
    register_post_type('portfolio', $args);
}
add_action('init', 'teznevisan_register_portfolio_post_type');

/**
 * Register Testimonials Post Type
 */
function teznevisan_register_testimonials_post_type() {
    $labels = array(
        'name' => 'نظرات مشتریان',
        'singular_name' => 'نظر مشتری',
        'menu_name' => 'نظرات',
        'add_new' => 'افزودن نظر',
        'add_new_item' => 'افزودن نظر جدید',
        'edit_item' => 'ویرایش نظر',
        'new_item' => 'نظر جدید',
        'view_item' => 'مشاهده نظر',
        'search_items' => 'جستجوی نظرات',
        'not_found' => 'نظری یافت نشد',
        'not_found_in_trash' => 'نظری در زباله‌دان یافت نشد',
        'all_items' => 'همه نظرات',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonials'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    
    register_post_type('testimonials', $args);
}
add_action('init', 'teznevisan_register_testimonials_post_type');

/**
 * Add Color Field to Category and Tag
 */
function teznevisan_add_term_color_field($term) {
    $color = get_term_meta($term->term_id, is_object($term) && property_exists($term, 'taxonomy') ? ($term->taxonomy == 'post_tag' ? 'tag_color' : 'category_color') : 'category_color', true);
    ?>
    <tr class="form-field">
        <th scope="row">
            <label for="term_color">رنگ</label>
        </th>
        <td>
            <input type="color" 
                   id="term_color" 
                   name="term_color" 
                   value="<?php echo $color ? esc_attr($color) : '#1FA547'; ?>" 
                   style="width: 100px; height: 40px;">
            <p class="description">رنگ این دسته یا برچسب را انتخاب کنید</p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'teznevisan_add_term_color_field');
add_action('post_tag_edit_form_fields', 'teznevisan_add_term_color_field');

/**
 * Save Term Color
 */
function teznevisan_save_term_color($term_id) {
    if (isset($_POST['term_color'])) {
        $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : 'category';
        $meta_key = $taxonomy == 'post_tag' ? 'tag_color' : 'category_color';
        update_term_meta($term_id, $meta_key, sanitize_hex_color($_POST['term_color']));
    }
}
add_action('edited_category', 'teznevisan_save_term_color');
add_action('edited_post_tag', 'teznevisan_save_term_color');

/**
 * Flush Rewrite Rules on Theme Activation
 */
function teznevisan_flush_rewrite_rules() {
    teznevisan_register_services_post_type();
    teznevisan_register_service_taxonomy();
    teznevisan_register_portfolio_post_type();
    teznevisan_register_testimonials_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'teznevisan_flush_rewrite_rules');
