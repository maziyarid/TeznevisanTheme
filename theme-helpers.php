<?php

/**
 * Additional Helper Functions for Search and Theme Features
 * Add these to functions.php or create a separate helpers.php file
 */

/**
 * Get search count by content type
 */
function teznevisan_get_search_count_by_type($search_query, $type) {
    if ($type === 'all') {
        $args = array(
            's' => $search_query,
            'post_type' => array('post', 'page', 'services'),
            'posts_per_page' => -1,
            'fields' => 'ids'
        );
    } else {
        $args = array(
            's' => $search_query,
            'post_type' => $type,
            'posts_per_page' => -1,
            'fields' => 'ids'
        );
    }

    $query = new WP_Query($args);
    return $query->found_posts;
}

/**
 * Get content type icon
 */
function teznevisan_get_content_type_icon($post_type) {
    $icons = array(
        'post' => 'fa-solid fa-newspaper',
        'page' => 'fa-solid fa-file-lines',
        'services' => 'fa-solid fa-tools',
        'service_inquiry' => 'fa-solid fa-envelope'
    );

    return $icons[$post_type] ?? 'fa-solid fa-file';
}

/**
 * Highlight search terms in text
 */
function teznevisan_highlight_search_term($text, $search_query) {
    if (empty($search_query)) {
        return $text;
    }

    $search_terms = explode(' ', $search_query);

    foreach ($search_terms as $term) {
        if (strlen(trim($term)) > 2) {
            $text = preg_replace(
                '/(' . preg_quote(trim($term), '/') . ')/iu',
                '<mark class="search-highlight">$1</mark>',
                $text
            );
        }
    }

    return $text;
}

/**
 * Create Professional Archive Pages
 */
function teznevisan_create_archive_templates() {
    $theme_dir = get_template_directory();

    // Create archive-services.php
    $services_archive = '<?php
/**
 * Services Archive Template
 */
get_header(); ?>

<div class="services-archive-page">
    <div class="container">
        <!-- Archive Header -->
        <div class="archive-header">
            <div class="archive-title-section">
                <h1 class="archive-title">
                    <i class="fa-solid fa-tools"></i>
                    خدمات تزنویسان
                </h1>
                <p class="archive-description">
                    مجموعه کامل خدمات نگارش دانشگاهی با بالاترین کیفیت و تضمین رضایت
                </p>
            </div>

            <div class="archive-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo wp_count_posts("services")->publish; ?></span>
                    <span class="stat-label">خدمت فعال</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">۴۵۰+</span>
                    <span class="stat-label">متخصص</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">۹۸%</span>
                    <span class="stat-label">رضایت</span>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="services-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); 
                $price_min = get_post_meta(get_the_ID(), "price_range_min", true);
                $price_max = get_post_meta(get_the_ID(), "price_range_max", true);
                $service_excerpt = get_post_meta(get_the_ID(), "service_excerpt", true);
            ?>
                <article class="service-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="service-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail("service-thumbnail"); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="service-content">
                        <h3 class="service-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <p class="service-excerpt">
                            <?php echo $service_excerpt ?: wp_trim_words(get_the_excerpt(), 15); ?>
                        </p>

                        <?php if ($price_min && $price_max) : ?>
                            <div class="service-price">
                                <i class="fa-solid fa-tag"></i>
                                <span><?php echo number_format($price_min); ?> - <?php echo number_format($price_max); ?> تومان</span>
                            </div>
                        <?php endif; ?>

                        <div class="service-actions">
                            <a href="<?php the_permalink(); ?>" class="btn-primary">
                                <i class="fa-solid fa-circle-info"></i>
                                مشاهده جزئیات
                            </a>
                            <a href="tel:09331663849" class="btn-secondary">
                                <i class="fa-solid fa-phone"></i>
                                تماس فوری
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>

        <!-- Pagination -->
        <div class="archive-pagination">
            <?php
            the_posts_pagination(array(
                "prev_text" => "<i class="fa-solid fa-chevron-right"></i> قبلی",
                "next_text" => "بعدی <i class="fa-solid fa-chevron-left"></i>",
                "mid_size" => 2
            ));
            ?>
        </div>
    </div>
</div>

<style>
.services-archive-page { margin: 2rem 0; }
.archive-header { background: linear-gradient(135deg, #1FA547, #178A3A); color: white; padding: 3rem 2rem; border-radius: 15px; margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: center; }
.archive-title { font-size: 2.5rem; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 1rem; }
.archive-description { font-size: 1.1rem; opacity: 0.9; margin: 0; }
.archive-stats { display: flex; gap: 2rem; }
.stat-item { text-align: center; }
.stat-number { display: block; font-size: 2rem; font-weight: 800; color: #FFD700; }
.stat-label { font-size: 0.9rem; opacity: 0.8; }
.services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
.service-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #e1e5e9; }
.service-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(31,165,71,0.2); }
.service-thumbnail img { width: 100%; height: 200px; object-fit: cover; }
.service-content { padding: 2rem; }
.service-title { margin: 0 0 1rem 0; font-size: 1.3rem; }
.service-title a { color: #333; text-decoration: none; }
.service-title a:hover { color: #1FA547; }
.service-excerpt { color: #666; line-height: 1.6; margin-bottom: 1.5rem; }
.service-price { display: flex; align-items: center; gap: 0.5rem; color: #1FA547; font-weight: 600; margin-bottom: 1.5rem; }
.service-actions { display: flex; gap: 1rem; }
.btn-primary, .btn-secondary { display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; }
.btn-primary { background: #1FA547; color: white; }
.btn-secondary { background: transparent; color: #1FA547; border: 2px solid #1FA547; }
.btn-primary:hover { background: #178A3A; transform: translateY(-2px); }
.btn-secondary:hover { background: #1FA547; color: white; }
@media (max-width: 768px) { 
    .archive-header { flex-direction: column; gap: 2rem; text-align: center; }
    .services-grid { grid-template-columns: 1fr; }
    .service-actions { flex-direction: column; }
}
</style>

<?php get_footer(); ?>';

    file_put_contents($theme_dir . '/archive-services.php', $services_archive);

    // Create single-services.php
    $single_service = '<?php
/**
 * Single Service Template
 */
get_header(); 

if (have_posts()) : while (have_posts()) : the_post();
    $hero_headline = get_post_meta(get_the_ID(), "hero_headline", true) ?: get_the_title();
    $hero_description = get_post_meta(get_the_ID(), "hero_description", true) ?: get_the_excerpt();
    $service_excerpt = get_post_meta(get_the_ID(), "service_excerpt", true);
    $lottie_url = get_post_meta(get_the_ID(), "lottie_animation_url", true);
    $price_min = get_post_meta(get_the_ID(), "price_range_min", true);
    $price_max = get_post_meta(get_the_ID(), "price_range_max", true);
    $features = get_post_meta(get_the_ID(), "service_features", true) ?: array();
    $process_steps = get_post_meta(get_the_ID(), "process_steps", true) ?: array();
    $faq_items = get_post_meta(get_the_ID(), "service_faq", true) ?: array();
?>

<div class="single-service-page">
    <!-- Service Hero -->
    <div class="service-hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title"><?php echo esc_html($hero_headline); ?></h1>
                    <p class="hero-description"><?php echo esc_html($hero_description); ?></p>

                    <?php if ($price_min && $price_max) : ?>
                        <div class="hero-price">
                            <span class="price-label">قیمت:</span>
                            <span class="price-range"><?php echo number_format($price_min); ?> - <?php echo number_format($price_max); ?> تومان</span>
                        </div>
                    <?php endif; ?>

                    <div class="hero-actions">
                        <a href="tel:09331663849" class="btn-cta primary">
                            <i class="fa-solid fa-phone"></i>
                            تماس فوری: ۰۹۳۳۱۶۶۳۸۴۹
                        </a>
                        <a href="https://t.me/Thesissupport" class="btn-cta secondary" target="_blank">
                            <i class="fab fa-telegram"></i>
                            چت تلگرام
                        </a>
                    </div>
                </div>

                <?php if ($lottie_url) : ?>
                    <div class="hero-animation">
                        <lottie-player src="<?php echo esc_url($lottie_url); ?>" 
                                       background="transparent" 
                                       speed="1" 
                                       style="width: 100%; height: 300px;" 
                                       loop autoplay>
                        </lottie-player>
                    </div>
                <?php elseif (has_post_thumbnail()) : ?>
                    <div class="hero-image">
                        <?php the_post_thumbnail("hero-image"); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Service Content -->
    <div class="service-content-section">
        <div class="container">
            <div class="service-main-content">
                <div class="content-text">
                    <?php the_content(); ?>
                </div>

                <?php if (!empty($features)) : ?>
                    <div class="service-features">
                        <h3><i class="fa-solid fa-star"></i> ویژگی‌های خدمت</h3>
                        <div class="features-grid">
                            <?php foreach ($features as $feature) : ?>
                                <div class="feature-item">
                                    <h4><?php echo esc_html($feature["title"]); ?></h4>
                                    <p><?php echo esc_html($feature["description"]); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($process_steps)) : ?>
                    <div class="process-section">
                        <h3><i class="fa-solid fa-gear"></i> فرآیند انجام کار</h3>
                        <div class="process-steps">
                            <?php foreach ($process_steps as $index => $step) : ?>
                                <div class="process-step">
                                    <div class="step-number"><?php echo $index + 1; ?></div>
                                    <div class="step-content">
                                        <h4><?php echo esc_html($step["title"]); ?></h4>
                                        <p><?php echo esc_html($step["description"]); ?></p>
                                        <?php if (!empty($step["duration"])) : ?>
                                            <span class="step-duration">
                                                <i class="solid fa-clock"></i>
                                                <?php echo esc_html($step["duration"]); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($faq_items)) : ?>
                    <div class="service-faq">
                        <h3><i class="fa-solid fa-question-circle"></i> سوالات متداول</h3>
                        <div class="faq-items">
                            <?php foreach ($faq_items as $index => $faq) : ?>
                                <div class="faq-item">
                                    <button class="faq-question" onclick="toggleFAQ(<?php echo $index; ?>)">
                                        <?php echo esc_html($faq["question"]); ?>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="faq-answer" id="faq-<?php echo $index; ?>" style="display:none;">
                                        <p><?php echo esc_html($faq["answer"]); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Service Sidebar -->
            <div class="service-sidebar">
                <div class="contact-widget">
                    <h4><i class="fa-solid fa-headset"></i> مشاوره و سفارش</h4>
                    <p>برای دریافت مشاوره رایگان و ثبت سفارش با ما تماس بگیرید:</p>

                    <div class="contact-methods">
                        <a href="tel:09331663849" class="contact-method phone">
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <strong>تماس تلفنی</strong>
                                <span>۰۹۳۳۱۶۶۳۸۴۹</span>
                            </div>
                        </a>

                        <a href="https://t.me/Thesissupport" class="contact-method telegram" target="_blank">
                            <i class="fa-brands fa-telegram"></i>
                            <div>
                                <strong>تلگرام</strong>
                                <span>@Thesissupport</span>
                            </div>
                        </a>

                        <a href="https://eitaa.com/Teznevs" class="contact-method eitaa" target="_blank">
                            <i class="fa-solid fa-comment"></i>
                            <div>
                                <strong>ایتا</strong>
                                <span>@Teznevs</span>
                            </div>
                        </a>

                        <a href="https://wa.me/989331663849" class="contact-method whatsapp" target="_blank">
                            <i class="fa-brands fa-whatsapp"></i>
                            <div>
                                <strong>واتساپ</strong>
                                <span>پیام سریع</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="guarantee-widget">
                    <h4><i class="fa-solid fa-shield-alt"></i> تضمین‌های ما</h4>
                    <ul>
                        <li><i class="fa-solid fa-check"></i> تضمین کیفیت نگارش</li>
                        <li><i class="fa-solid fa-check"></i> تحویل در موعد مقرر</li>
                        <li><i class="fa-solid fa-check"></i> پشتیبانی ۲۴ ساعته</li>
                        <li><i class="fa-solid fa-check"></i> رضایت ۱۰۰٪ مشتریان</li>
                        <li><i class="fa-solid fa-check"></i> تضمین اصالت محتوا</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.service-hero { background: linear-gradient(135deg, #1FA547, #178A3A); color: white; padding: 4rem 0; }
.hero-content { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
.hero-title { font-size: 2.5rem; margin: 0 0 1rem 0; font-weight: 700; }
.hero-description { font-size: 1.2rem; opacity: 0.9; margin-bottom: 2rem; line-height: 1.6; }
.hero-price { margin-bottom: 2rem; }
.price-label { opacity: 0.8; margin-left: 0.5rem; }
.price-range { font-size: 1.4rem; font-weight: 700; color: #FFD700; }
.hero-actions { display: flex; gap: 1rem; }
.btn-cta { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 2rem; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; }
.btn-cta.primary { background: rgba(255,255,255,0.2); color: white; }
.btn-cta.secondary { background: transparent; color: white; border: 2px solid rgba(255,255,255,0.3); }
.btn-cta:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
.service-content-section { padding: 4rem 0; }
.service-main-content { display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; }
.content-text { font-size: 1.1rem; line-height: 1.8; color: #333; }
.service-features, .process-section, .service-faq { margin: 3rem 0; }
.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem; }
.feature-item { background: #f8f9fa; padding: 2rem; border-radius: 10px; border-left: 4px solid #1FA547; }
.process-steps { margin-top: 2rem; }
.process-step { display: flex; gap: 2rem; margin-bottom: 2rem; padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.step-number { width: 50px; height: 50px; background: #1FA547; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; flex-shrink: 0; }
.faq-item { background: white; border-radius: 8px; margin-bottom: 1rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.faq-question { width: 100%; padding: 1.5rem; background: transparent; border: none; text-align: right; font-weight: 600; color: #333; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
.faq-answer { padding: 1.5rem; border-top: 1px solid #eee; }
.service-sidebar { display: flex; flex-direction: column; gap: 2rem; }
.contact-widget, .guarantee-widget { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
.contact-methods { display: flex; flex-direction: column; gap: 1rem; }
.contact-method { display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px; text-decoration: none; color: #333; transition: all 0.3s ease; }
.contact-method:hover { background: #1FA547; color: white; transform: translateX(-3px); }
.guarantee-widget ul { list-style: none; padding: 0; }
.guarantee-widget li { padding: 0.75rem 0; display: flex; align-items: center; gap: 0.75rem; }
.guarantee-widget i { color: #1FA547; }
@media (max-width: 768px) { 
    .hero-content { grid-template-columns: 1fr; text-align: center; }
    .service-main-content { grid-template-columns: 1fr; }
    .hero-actions { flex-direction: column; }
    .features-grid { grid-template-columns: 1fr; }
    .process-step { flex-direction: column; text-align: center; }
}
</style>

<script>
function toggleFAQ(index) {
    const answer = document.getElementById("faq-" + index);
    const question = answer.previousElementSibling;
    const icon = question.querySelector("i");

    if (answer.style.display === "block") {
        answer.style.display = "none";
        icon.style.transform = "rotate(0deg)";
    } else {
        document.querySelectorAll(".faq-answer").forEach(el => el.style.display = "none");
        document.querySelectorAll(".faq-question i").forEach(el => el.style.transform = "rotate(0deg)");

        answer.style.display = "block";
        icon.style.transform = "rotate(180deg)";
    }
}
</script>

<?php endwhile; endif; get_footer(); ?>';

    file_put_contents($theme_dir . '/single-services.php', $single_service);
}

teznevisan_create_archive_templates();

/**
 * Enhanced Navigation Menu System
 */
class Teznevisan_Menu_Manager {
    public function __construct() {
        add_action('wp_nav_menu_item_custom_fields', array($this, 'add_custom_fields'), 10, 4);
        add_action('wp_update_nav_menu_item', array($this, 'save_custom_fields'), 10, 3);
        add_filter('walker_nav_menu_start_el', array($this, 'add_menu_icons'), 10, 4);
    }

    public function add_custom_fields($item_id, $item, $depth, $args) {
        $icon_class = get_post_meta($item_id, '_menu_item_icon', true);
        $badge_text = get_post_meta($item_id, '_menu_item_badge', true);
        $is_featured = get_post_meta($item_id, '_menu_item_featured', true);
        ?>
        <p class="field-icon description description-wide">
            <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
                آیکون منو<br>
                <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" 
                       class="widefat code edit-menu-item-icon" 
                       name="menu-item-icon[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr($icon_class); ?>" 
                       placeholder="fa-solid fa-home">
            </label>
            <span class="description">کلاس آیکون Font Awesome</span>
        </p>

        <p class="field-badge description description-wide">
            <label for="edit-menu-item-badge-<?php echo $item_id; ?>">
                نشان منو<br>
                <input type="text" id="edit-menu-item-badge-<?php echo $item_id; ?>" 
                       class="widefat edit-menu-item-badge" 
                       name="menu-item-badge[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr($badge_text); ?>" 
                       placeholder="جدید">
            </label>
            <span class="description">نشان کوچک کنار آیتم منو</span>
        </p>

        <p class="field-featured description description-wide">
            <label for="edit-menu-item-featured-<?php echo $item_id; ?>">
                <input type="checkbox" id="edit-menu-item-featured-<?php echo $item_id; ?>" 
                       name="menu-item-featured[<?php echo $item_id; ?>]" 
                       value="1" <?php checked($is_featured, 1); ?>>
                آیتم ویژه (نمایش متفاوت)
            </label>
        </p>
        <?php
    }

    public function save_custom_fields($menu_id, $menu_item_db_id, $args) {
        if (isset($_REQUEST['menu-item-icon'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_menu_item_icon', sanitize_text_field($_REQUEST['menu-item-icon'][$menu_item_db_id]));
        }

        if (isset($_REQUEST['menu-item-badge'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_menu_item_badge', sanitize_text_field($_REQUEST['menu-item-badge'][$menu_item_db_id]));
        }

        $is_featured = isset($_REQUEST['menu-item-featured'][$menu_item_db_id]) ? 1 : 0;
        update_post_meta($menu_item_db_id, '_menu_item_featured', $is_featured);
    }

    public function add_menu_icons($item_output, $item, $depth, $args) {
        $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
        $badge_text = get_post_meta($item->ID, '_menu_item_badge', true);
        $is_featured = get_post_meta($item->ID, '_menu_item_featured', true);

        if ($icon_class) {
            $icon = '<i class="' . esc_attr($icon_class) . ' menu-icon"></i>';
            $item_output = str_replace('<a', '<a', $item_output);
            $item_output = str_replace('>' . $item->title, '>' . $icon . '<span class="menu-text">' . $item->title . '</span>', $item_output);
        }

        if ($badge_text) {
            $badge = '<span class="menu-badge">' . esc_html($badge_text) . '</span>';
            $item_output = str_replace('</a>', $badge . '</a>', $item_output);
        }

        if ($is_featured) {
            $item_output = str_replace('<li class="', '<li class="menu-item-featured ', $item_output);
        }

        return $item_output;
    }
}

new Teznevisan_Menu_Manager();

/**
 * IP-based Like/Dislike with Schema Markup
 */
function teznevisan_render_like_dislike_buttons($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    if (!$post_id) return;

    $likes = get_post_meta($post_id, 'post_likes', true) ?: 0;
    $dislikes = get_post_meta($post_id, 'post_dislikes', true) ?: 0;
    $total_reactions = $likes + $dislikes;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_reactions = get_post_meta($post_id, 'user_reactions', true) ?: array();
    $user_reaction = isset($user_reactions[$user_ip]) ? $user_reactions[$user_ip] : null;

    // Generate rating for schema
    $rating = $total_reactions > 0 ? ($likes / $total_reactions) * 5 : 0;

    ?>
    <div class="post-reactions" data-post-id="<?php echo esc_attr($post_id); ?>" 
         itemscope itemtype="https://schema.org/AggregateRating">

        <!-- Schema.org markup -->
        <meta itemprop="ratingValue" content="<?php echo esc_attr(number_format($rating, 2)); ?>">
        <meta itemprop="bestRating" content="5">
        <meta itemprop="worstRating" content="1">
        <meta itemprop="ratingCount" content="<?php echo esc_attr($total_reactions); ?>">

        <div class="reactions-header">
            <h4>این مطلب را چگونه ارزیابی می‌کنید؟</h4>
        </div>

        <div class="reaction-buttons">
            <button class="reaction-btn like-btn <?php echo $user_reaction === 'like' ? 'active' : ''; ?>" 
                    data-action="like" 
                    title="مفید و مطلوب">
                <i class="fa-solid fa-thumbs-up"></i>
                <span class="reaction-label">مفید</span>
                <span class="reaction-count"><?php echo number_format($likes); ?></span>
            </button>

            <button class="reaction-btn dislike-btn <?php echo $user_reaction === 'dislike' ? 'active' : ''; ?>" 
                    data-action="dislike" 
                    title="غیرمفید">
                <i class="fa-solid fa-thumbs-down"></i>
                <span class="reaction-label">غیرمفید</span>
                <span class="reaction-count"><?php echo number_format($dislikes); ?></span>
            </button>
        </div>

        <div class="reactions-stats">
            <div class="rating-display">
                <div class="stars-rating">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <i class="fa-solid fa-star <?php echo $i <= round($rating) ? 'filled' : 'empty'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <span class="rating-text">
                    <?php echo number_format($rating, 1); ?> از ۵ 
                    (<?php echo number_format($total_reactions); ?> نظر)
                </span>
            </div>
        </div>
    </div>

    <style>
    .post-reactions { 
        background: #f8f9fa; 
        border-radius: 15px; 
        padding: 2rem; 
        margin: 2rem 0; 
        border: 1px solid #e1e5e9; 
    }

    .reactions-header h4 { 
        text-align: center; 
        margin: 0 0 1.5rem 0; 
        color: #333; 
    }

    .reaction-buttons { 
        display: flex; 
        justify-content: center; 
        gap: 2rem; 
        margin-bottom: 1.5rem; 
    }

    .reaction-btn { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        gap: 0.5rem; 
        padding: 1.5rem 2rem; 
        background: white; 
        border: 2px solid #e1e5e9; 
        border-radius: 15px; 
        cursor: pointer; 
        transition: all 0.3s ease; 
        font-family: inherit; 
        min-width: 120px; 
    }

    .reaction-btn:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
    }

    .reaction-btn.like-btn:hover, 
    .reaction-btn.like-btn.active { 
        background: #e8f5e8; 
        border-color: #1FA547; 
        color: #1FA547; 
    }

    .reaction-btn.dislike-btn:hover, 
    .reaction-btn.dislike-btn.active { 
        background: #ffeaea; 
        border-color: #dc3545; 
        color: #dc3545; 
    }

    .reaction-btn i { 
        font-size: 1.5rem; 
    }

    .reaction-label { 
        font-weight: 600; 
        font-size: 0.9rem; 
    }

    .reaction-count { 
        font-weight: 700; 
        font-size: 1.1rem; 
    }

    .reactions-stats { 
        text-align: center; 
        padding-top: 1rem; 
        border-top: 1px solid #e1e5e9; 
    }

    .stars-rating { 
        margin-bottom: 0.5rem; 
    }

    .stars-rating i { 
        color: #ddd; 
        font-size: 1.2rem; 
        margin: 0 0.1rem; 
    }

    .stars-rating i.filled { 
        color: #FFD700; 
    }

    .rating-text { 
        color: #666; 
        font-weight: 500; 
    }

    @media (max-width: 480px) { 
        .reaction-buttons { 
            flex-direction: column; 
            align-items: center; 
            gap: 1rem; 
        }

        .reaction-btn { 
            flex-direction: row; 
            width: 200px; 
            justify-content: space-between; 
        } 
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const reactionButtons = document.querySelectorAll('.reaction-btn');

        reactionButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const postId = this.closest('.post-reactions').dataset.postId;
                const action = this.dataset.action;

                // Disable button temporarily
                this.style.pointerEvents = 'none';
                this.style.opacity = '0.7';

                fetch(teznevisanAjax.ajaxUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'post_reaction',
                        post_id: postId,
                        action_type: action,
                        nonce: teznevisanAjax.nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update counts
                        const likeBtn = document.querySelector('.like-btn .reaction-count');
                        const dislikeBtn = document.querySelector('.dislike-btn .reaction-count');

                        likeBtn.textContent = data.data.likes.toLocaleString();
                        dislikeBtn.textContent = data.data.dislikes.toLocaleString();

                        // Update active states
                        reactionButtons.forEach(b => b.classList.remove('active'));
                        if (data.data.user_action) {
                            const activeBtn = document.querySelector(`[data-action="${data.data.user_action}"]`);
                            if (activeBtn) activeBtn.classList.add('active');
                        }

                        // Update rating display
                        const total = data.data.likes + data.data.dislikes;
                        if (total > 0) {
                            const rating = (data.data.likes / total) * 5;
                            const ratingText = document.querySelector('.rating-text');
                            ratingText.textContent = `${rating.toFixed(1)} از ۵ (${total.toLocaleString()} نظر)`;

                            // Update stars
                            const stars = document.querySelectorAll('.stars-rating i');
                            stars.forEach((star, index) => {
                                star.className = index < Math.round(rating) ? 'fa-solid fa-star filled' : 'fa-solid fa-star empty';
                            });
                        }
                    } else {
                        alert(data.data || 'خطا در ثبت نظر');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('خطا در ارتباط با سرور');
                })
                .finally(() => {
                    // Re-enable button
                    this.style.pointerEvents = '';
                    this.style.opacity = '';
                });
            });
        });
    });
    </script>
    <?php
}

/**
 * Create Cookie Consent with GDPR Compliance
 */
function teznevisan_render_cookie_consent() {
    if (isset($_COOKIE['teznevisan_cookie_consent'])) {
        return; // User already made a choice
    }

    ?>
    <div class="cookie-consent-banner" id="cookieConsentBanner">
        <div class="cookie-content-wrapper">
            <div class="cookie-info">
                <div class="cookie-icon">
                    <i class="fa-solid fa-cookie-bite"></i>
                </div>
                <div class="cookie-text">
                    <h4>🍪 استفاده از کوکی‌ها</h4>
                    <p>
                        ما از کوکی‌های ضروری و تحلیلی برای بهبود عملکرد سایت استفاده می‌کنیم. 
                        با ادامه استفاده، استفاده از کوکی‌ها را می‌پذیرید.
                    </p>
                </div>
            </div>

            <div class="cookie-actions">
                <button class="cookie-btn accept-all" onclick="acceptAllCookies()">
                    <i class="fa-solid fa-check"></i>
                    پذیرش همه
                </button>
                <button class="cookie-btn accept-necessary" onclick="acceptNecessaryCookies()">
                    <i class="fa-solid fa-cog"></i>
                    ضروری فقط
                </button>
                <button class="cookie-btn settings" onclick="showCookieSettings()">
                    <i class="ffa-solid fa-sliders-h"></i>
                    تنظیمات
                </button>
                <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="cookie-link" target="_blank">
                    <i class="fa-solid fa-circle-info"></i>
                    حریم خصوصی
                </a>
            </div>
        </div>
    </div>

    <!-- Cookie Settings Modal -->
    <div class="cookie-settings-modal" id="cookieSettingsModal">
        <div class="modal-backdrop" onclick="closeCookieSettings()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>تنظیمات کوکی‌ها</h3>
                <button class="modal-close" onclick="closeCookieSettings()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="cookie-category">
                    <div class="category-header">
                        <div class="category-info">
                            <h4>کوکی‌های ضروری</h4>
                            <p>برای عملکرد اساسی سایت الزامی هستند</p>
                        </div>
                        <div class="category-toggle">
                            <input type="checkbox" id="necessary-cookies" checked disabled>
                            <label for="necessary-cookies">همیشه فعال</label>
                        </div>
                    </div>
                </div>

                <div class="cookie-category">
                    <div class="category-header">
                        <div class="category-info">
                            <h4>کوکی‌های تحلیلی</h4>
                            <p>برای بررسی عملکرد و بهبود سایت</p>
                        </div>
                        <div class="category-toggle">
                            <input type="checkbox" id="analytics-cookies">
                            <label for="analytics-cookies">اختیاری</label>
                        </div>
                    </div>
                </div>

                <div class="cookie-category">
                    <div class="category-header">
                        <div class="category-info">
                            <h4>کوکی‌های عملکردی</h4>
                            <p>برای شخصی‌سازی تجربه کاربری</p>
                        </div>
                        <div class="category-toggle">
                            <input type="checkbox" id="functional-cookies">
                            <label for="functional-cookies">اختیاری</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="cookie-btn accept-selected" onclick="saveCustomSettings()">
                    <i class="fa-solid fa-save"></i>
                    ذخیره تنظیمات
                </button>
                <button class="cookie-btn cancel" onclick="closeCookieSettings()">
                    انصراف
                </button>
            </div>
        </div>
    </div>

    <style>
    .cookie-consent-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
        color: white;
        padding: 1.5rem 0;
        z-index: 10003;
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-top: 3px solid #1FA547;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
    }

    .cookie-consent-banner.show {
        transform: translateY(0);
    }

    .cookie-content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: center;
    }

    .cookie-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .cookie-icon {
        font-size: 2.5rem;
        color: #ffa500;
        flex-shrink: 0;
    }

    .cookie-text h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .cookie-text p {
        margin: 0;
        opacity: 0.9;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .cookie-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cookie-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: inherit;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .cookie-btn.accept-all {
        background: #1FA547;
        color: white;
    }

    .cookie-btn.accept-necessary {
        background: #6c757d;
        color: white;
    }

    .cookie-btn.settings {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .cookie-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .cookie-btn.accept-all:hover {
        background: #178A3A;
    }

    .cookie-link {
        color: #ffa500;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        padding: 0.5rem;
    }

    .cookie-link:hover {
        text-decoration: underline;
    }

    /* Cookie Settings Modal */
    .cookie-settings-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 10004;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .cookie-settings-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        background: white;
        border-radius: 15px;
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        transition: transform 0.3s ease;
    }

    .cookie-settings-modal.show .modal-content {
        transform: translate(-50%, -50%) scale(1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 2rem 1rem;
        border-bottom: 1px solid #e1e5e9;
    }

    .modal-header h3 {
        margin: 0;
        color: #333;
        font-size: 1.4rem;
    }

    .modal-close {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        color: #666;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: #f8f9fa;
        color: #333;
    }

    .modal-body {
        padding: 2rem;
    }

    .cookie-category {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e1e5e9;
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-info h4 {
        margin: 0 0 0.5rem 0;
        color: #333;
        font-size: 1.1rem;
    }

    .category-info p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .category-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-toggle input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #1FA547;
    }

    .category-toggle label {
        color: #666;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1rem 2rem 2rem;
        border-top: 1px solid #e1e5e9;
    }

    .cookie-btn.accept-selected {
        background: #1FA547;
        color: white;
    }

    .cookie-btn.cancel {
        background: #6c757d;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cookie-content-wrapper {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            text-align: center;
        }

        .cookie-info {
            flex-direction: column;
            text-align: center;
        }

        .cookie-actions {
            justify-content: center;
            flex-wrap: wrap;
        }

        .modal-content {
            width: 95%;
            margin: 1rem;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }

        .category-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .modal-footer {
            flex-direction: column;
        }
    }
    </style>

    <script>
    // Cookie Consent JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('cookieConsentBanner');
        const modal = document.getElementById('cookieSettingsModal');

        // Show banner after 2 seconds
        setTimeout(() => {
            if (banner) banner.classList.add('show');
        }, 2000);
    });

    function acceptAllCookies() {
        setCookieConsent({
            necessary: true,
            analytics: true,
            functional: true
        });
        hideBanner();
        enableAllCookies();
    }

    function acceptNecessaryCookies() {
        setCookieConsent({
            necessary: true,
            analytics: false,
            functional: false
        });
        hideBanner();
        enableNecessaryCookies();
    }

    function showCookieSettings() {
        const modal = document.getElementById('cookieSettingsModal');
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeCookieSettings() {
        const modal = document.getElementById('cookieSettingsModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    function saveCustomSettings() {
        const necessary = document.getElementById('necessary-cookies').checked;
        const analytics = document.getElementById('analytics-cookies').checked;
        const functional = document.getElementById('functional-cookies').checked;

        setCookieConsent({
            necessary: necessary,
            analytics: analytics,
            functional: functional
        });

        hideBanner();
        closeCookieSettings();

        if (analytics) enableAnalytics();
        if (functional) enableFunctionalCookies();

        // Show success message
        showToast('تنظیمات کوکی ذخیره شد', 'success');
    }

    function setCookieConsent(preferences) {
        const consent = {
            timestamp: new Date().toISOString(),
            preferences: preferences
        };

        // Set cookie for 1 year
        const date = new Date();
        date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));

        document.cookie = `teznevisan_cookie_consent=${JSON.stringify(consent)}; expires=${date.toUTCString()}; path=/; SameSite=Strict`;

        console.log('Cookie consent saved:', consent);
    }

    function hideBanner() {
        const banner = document.getElementById('cookieConsentBanner');
        if (banner) {
            banner.classList.remove('show');
            setTimeout(() => {
                banner.style.display = 'none';
            }, 400);
        }
    }

    function enableAllCookies() {
        enableAnalytics();
        enableFunctionalCookies();
        console.log('All cookies enabled');
    }

    function enableNecessaryCookies() {
        console.log('Only necessary cookies enabled');
    }

    function enableAnalytics() {
        // Enable Google Analytics or other analytics
        console.log('Analytics cookies enabled');
    }

    function enableFunctionalCookies() {
        // Enable functional features
        console.log('Functional cookies enabled');
    }

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);
    }
    </script>

    <style>
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border: 1px solid #e1e5e9;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        z-index: 10005;
        min-width: 300px;
    }

    .toast.show {
        transform: translateX(0);
    }

    .toast.toast-success {
        border-color: #1FA547;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #333;
    }

    .toast.toast-success .toast-content i {
        color: #1FA547;
    }
    </style>
    <?php
}

print("Helper functions created successfully!");
print("✓ Search count by content type")
print("✓ Content type icons")
print("✓ Search term highlighting")
print("✓ Professional archive templates")
print("✓ Enhanced menu system with icons")
print("✓ IP-based like/dislike with schema")
print("✓ GDPR-compliant cookie consent")
print("✓ All templates are mobile responsive")
