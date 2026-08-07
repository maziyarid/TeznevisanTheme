<?php
/**
 * Single Post Meta Boxes - Simple Version
 * @package Teznevisan
 */

if (!defined('ABSPATH')) exit;

function teznevisan_single_post_meta_boxes() {
    
    add_meta_box(
        'teznevisan_eeat_settings',
        '⭐ تنظیمات E-E-A-T و اعتبار',
        'teznevisan_eeat_settings_callback',
        'post',
        'normal',
        'high'
    );
    
    add_meta_box(
        'teznevisan_content_structure',
        '📝 ساختار و محتوای مطلب',
        'teznevisan_content_structure_callback',
        'post',
        'normal',
        'high'
    );
    
    add_meta_box(
        'teznevisan_seo_settings',
        '🔍 تنظیمات سئو',
        'teznevisan_seo_settings_callback',
        'post',
        'normal',
        'default'
    );
    
    add_meta_box(
        'teznevisan_engagement_settings',
        '💬 تنظیمات تعامل',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'teznevisan_single_post_meta_boxes');

function teznevisan_eeat_settings_callback($post) {
    wp_nonce_field('teznevisan_eeat_nonce', 'teznevisan_eeat_nonce');
    
    $author_expertise = get_post_meta($post->ID, '_author_expertise', true);
    $author_credentials = get_post_meta($post->ID, '_author_credentials', true);
    $fact_checked = get_post_meta($post->ID, '_fact_checked', true);
    $last_reviewed = get_post_meta($post->ID, '_last_reviewed_date', true);
    
    // Author Social Links (Simple)
    $telegram = get_post_meta($post->ID, '_author_telegram', true);
    $instagram = get_post_meta($post->ID, '_author_instagram', true);
    $linkedin = get_post_meta($post->ID, '_author_linkedin', true);
    ?>
    
    <style>
    .meta-box-container { display: grid; gap: 1.5rem; padding: 1rem; }
    .meta-field { background: #f8fafc; padding: 1.25rem; border-radius: 8px; border: 1px solid #e2e8f0; }
    .meta-field label { display: block; font-weight: 700; margin-bottom: 0.75rem; color: #1e293b; font-size: 0.95rem; }
    .meta-field input[type="text"],
    .meta-field input[type="url"],
    .meta-field input[type="date"],
    .meta-field textarea { width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 0.95rem; transition: all 0.3s; }
    .meta-field input:focus,
    .meta-field textarea:focus { outline: none; border-color: #1FA547; box-shadow: 0 0 0 3px rgba(31,165,71,0.1); }
    .meta-field textarea { min-height: 100px; font-family: inherit; resize: vertical; }
    .meta-help { font-size: 0.85rem; color: #64748b; margin-top: 0.5rem; font-style: italic; }
    .checkbox-field { display: flex; align-items: center; gap: 0.75rem; }
    .checkbox-field input { width: 20px; height: 20px; cursor: pointer; }
    .checkbox-field label { margin: 0; cursor: pointer; }
    .meta-badge { display: inline-block; background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; margin-right: 0.5rem; }
    </style>
    
    <div class="meta-box-container">
        
        <div class="meta-field">
            <label>
                🎓 تخصص نویسنده در این موضوع
                <span class="meta-badge">Experience</span>
            </label>
            <input type="text" 
                   name="author_expertise" 
                   value="<?php echo esc_attr($author_expertise); ?>"
                   placeholder="مثال: کارشناس ارشد مدیریت با 10 سال تجربه">
            <p class="meta-help">تجربه و تخصص نویسنده در موضوع این مقاله</p>
        </div>
        
        <div class="meta-field">
            <label>
                📜 مدارک و گواهینامه‌های نویسنده
                <span class="meta-badge">Expertise</span>
            </label>
            <textarea name="author_credentials" 
                      placeholder="مثال: دکترای مدیریت - دانشگاه تهران، عضو انجمن مدیریت ایران"><?php echo esc_textarea($author_credentials); ?></textarea>
            <p class="meta-help">مدارک تحصیلی، گواهینامه‌ها و عضویت‌های حرفه‌ای</p>
        </div>
        
        <div class="meta-field">
            <label>📱 لینک تلگرام نویسنده</label>
            <input type="url" 
                   name="author_telegram" 
                   value="<?php echo esc_url($telegram); ?>"
                   placeholder="https://t.me/username">
        </div>
        
        <div class="meta-field">
            <label>📷 لینک اینستاگرام نویسنده</label>
            <input type="url" 
                   name="author_instagram" 
                   value="<?php echo esc_url($instagram); ?>"
                   placeholder="https://instagram.com/username">
        </div>
        
        <div class="meta-field">
            <label>💼 لینک لینکدین نویسنده</label>
            <input type="url" 
                   name="author_linkedin" 
                   value="<?php echo esc_url($linkedin); ?>"
                   placeholder="https://linkedin.com/in/username">
        </div>
        
        <div class="meta-field checkbox-field">
            <input type="checkbox" 
                   id="fact_checked" 
                   name="fact_checked" 
                   value="1" 
                   <?php checked($fact_checked, '1'); ?>>
            <label for="fact_checked">
                ✅ این محتوا بررسی واقعیت شده است
                <span class="meta-badge" style="background: #3b82f6;">Trust</span>
            </label>
        </div>
        
        <div class="meta-field">
            <label>📅 تاریخ آخرین بازبینی</label>
            <input type="date" 
                   name="last_reviewed_date" 
                   value="<?php echo esc_attr($last_reviewed); ?>">
            <p class="meta-help">برای نشان دادن تازگی محتوا</p>
        </div>
        
    </div>
    
    <?php
}

function teznevisan_content_structure_callback($post) {
    wp_nonce_field('teznevisan_structure_nonce', 'teznevisan_structure_nonce');
    
    $subtitle = get_post_meta($post->ID, '_post_subtitle', true);
    $reading_time = get_post_meta($post->ID, '_reading_time', true);
    $key_takeaways = get_post_meta($post->ID, '_key_takeaways', true);
    $show_author_box = get_post_meta($post->ID, '_show_author_box', true) !== '0';
    
    // Pros
    $pros = array();
    for ($i = 1; $i <= 5; $i++) {
        $pro = get_post_meta($post->ID, '_pro_' . $i, true);
        if ($pro) $pros[] = $pro;
    }
    
    // Cons
    $cons = array();
    for ($i = 1; $i <= 5; $i++) {
        $con = get_post_meta($post->ID, '_con_' . $i, true);
        if ($con) $cons[] = $con;
    }
    
    // FAQs
    $faqs = array();
    for ($i = 1; $i <= 10; $i++) {
        $q = get_post_meta($post->ID, '_faq_q_' . $i, true);
        $a = get_post_meta($post->ID, '_faq_a_' . $i, true);
        if ($q && $a) $faqs[] = array('q' => $q, 'a' => $a);
    }
    ?>
    
    <div class="meta-box-container">
        
        <div class="meta-field">
            <label>📌 زیرعنوان مطلب</label>
            <input type="text" 
                   name="post_subtitle" 
                   value="<?php echo esc_attr($subtitle); ?>"
                   placeholder="یک زیرعنوان جذاب و توصیفی...">
            <p class="meta-help">زیرعنوانی که زیر عنوان اصلی نمایش داده می‌شود</p>
        </div>
        
        <div class="meta-field">
            <label>⏱️ زمان مطالعه (دقیقه)</label>
            <input type="number" 
                   name="reading_time" 
                   value="<?php echo esc_attr($reading_time); ?>"
                   placeholder="5"
                   min="1"
                   max="60">
            <p class="meta-help">خالی بگذارید تا به صورت خودکار محاسبه شود</p>
        </div>
        
        <div class="meta-field">
            <label>💡 نکات کلیدی (هر خط یک نکته)</label>
            <textarea name="key_takeaways" 
                      rows="5"
                      placeholder="نکته اول&#10;نکته دوم&#10;نکته سوم"><?php echo esc_textarea($key_takeaways); ?></textarea>
            <p class="meta-help">نکات برجسته که در باکس ویژه نمایش داده می‌شود</p>
        </div>
        
        <div class="meta-field checkbox-field">
            <input type="checkbox" 
                   id="show_author_box" 
                   name="show_author_box" 
                   value="1" 
                   <?php checked($show_author_box, true); ?>>
            <label for="show_author_box">نمایش باکس نویسنده در انتهای مطلب</label>
        </div>
        
        <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e2e8f0;">
        
        <h4 style="margin: 0 0 1rem 0; color: #10b981;">✅ مزایا (Pros)</h4>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="meta-field">
                <label>مزیت <?php echo $i; ?></label>
                <input type="text" 
                       name="pro_<?php echo $i; ?>" 
                       value="<?php echo esc_attr($pros[$i-1] ?? ''); ?>"
                       placeholder="مزیت شماره <?php echo $i; ?>">
            </div>
        <?php endfor; ?>
        
        <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e2e8f0;">
        
        <h4 style="margin: 0 0 1rem 0; color: #ef4444;">❌ معایب (Cons)</h4>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="meta-field">
                <label>معایب <?php echo $i; ?></label>
                <input type="text" 
                       name="con_<?php echo $i; ?>" 
                       value="<?php echo esc_attr($cons[$i-1] ?? ''); ?>"
                       placeholder="معایب شماره <?php echo $i; ?>">
            </div>
        <?php endfor; ?>
        
        <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e2e8f0;">
        
        <h4 style="margin: 0 0 1rem 0; color: #3b82f6;">❓ سوالات متداول (FAQ)</h4>
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <div class="meta-field" style="background: #eff6ff;">
                <label>سوال <?php echo $i; ?></label>
                <input type="text" 
                       name="faq_q_<?php echo $i; ?>" 
                       value="<?php echo esc_attr($faqs[$i-1]['q'] ?? ''); ?>"
                       placeholder="سوال شماره <?php echo $i; ?>">
                
                <label style="margin-top: 0.75rem;">پاسخ <?php echo $i; ?></label>
                <textarea name="faq_a_<?php echo $i; ?>" 
                          rows="3"
                          placeholder="پاسخ سوال شماره <?php echo $i; ?>"><?php echo esc_textarea($faqs[$i-1]['a'] ?? ''); ?></textarea>
            </div>
        <?php endfor; ?>
        
    </div>
    
    <?php
}

function teznevisan_seo_settings_callback($post) {
    wp_nonce_field('teznevisan_seo_nonce', 'teznevisan_seo_nonce');
    
    $focus_keyword = get_post_meta($post->ID, '_focus_keyword', true);
    $meta_title = get_post_meta($post->ID, '_meta_title', true);
    $meta_description = get_post_meta($post->ID, '_meta_description', true);
    ?>
    
    <div class="meta-box-container">
        
        <div class="meta-field">
            <label>🔑 کلمه کلیدی اصلی</label>
            <input type="text" 
                   name="focus_keyword" 
                   value="<?php echo esc_attr($focus_keyword); ?>"
                   placeholder="کلمه کلیدی اصلی...">
        </div>
        
        <div class="meta-field">
            <label>📄 عنوان سئو (Meta Title) - <span id="title-counter">0</span>/60</label>
            <input type="text" 
                   id="meta-title-input"
                   name="meta_title" 
                   value="<?php echo esc_attr($meta_title); ?>"
                   maxlength="60"
                   placeholder="عنوان برای گوگل...">
        </div>
        
        <div class="meta-field">
            <label>📝 توضیحات سئو (Meta Description) - <span id="desc-counter">0</span>/160</label>
            <textarea id="meta-desc-input"
                      name="meta_description" 
                      maxlength="160"
                      rows="3"
                      placeholder="توضیح مختصر برای نتایج گوگل..."><?php echo esc_textarea($meta_description); ?></textarea>
        </div>
        
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#meta-title-input').on('input', function() {
            $('#title-counter').text($(this).val().length);
        }).trigger('input');
        
        $('#meta-desc-input').on('input', function() {
            $('#desc-counter').text($(this).val().length);
        }).trigger('input');
    });
    </script>
    
    <?php
}

function teznevisan_engagement_settings_callback($post) {
    wp_nonce_field('teznevisan_engagement_nonce', 'teznevisan_engagement_nonce');
    
    $enable_rating = get_post_meta($post->ID, '_enable_rating', true) !== '0';
    $enable_likes = get_post_meta($post->ID, '_enable_likes', true) !== '0';
    ?>
    
    <div class="meta-box-container">
        <div class="checkbox-field">
            <input type="checkbox" id="enable_rating" name="enable_rating" value="1" <?php checked($enable_rating, true); ?>>
            <label for="enable_rating">⭐ امکان امتیازدهی</label>
        </div>
        
        <div class="checkbox-field">
            <input type="checkbox" id="enable_likes" name="enable_likes" value="1" <?php checked($enable_likes, true); ?>>
            <label for="enable_likes">👍 لایک/دیسلایک</label>
        </div>
    </div>
    
    <?php
}

// Save Meta Boxes
function teznevisan_save_single_post_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    // EEAT
    if (isset($_POST['teznevisan_eeat_nonce']) && wp_verify_nonce($_POST['teznevisan_eeat_nonce'], 'teznevisan_eeat_nonce')) {
        update_post_meta($post_id, '_author_expertise', sanitize_text_field($_POST['author_expertise'] ?? ''));
        update_post_meta($post_id, '_author_credentials', sanitize_textarea_field($_POST['author_credentials'] ?? ''));
        update_post_meta($post_id, '_author_telegram', esc_url_raw($_POST['author_telegram'] ?? ''));
        update_post_meta($post_id, '_author_instagram', esc_url_raw($_POST['author_instagram'] ?? ''));
        update_post_meta($post_id, '_author_linkedin', esc_url_raw($_POST['author_linkedin'] ?? ''));
        update_post_meta($post_id, '_fact_checked', isset($_POST['fact_checked']) ? '1' : '0');
        update_post_meta($post_id, '_last_reviewed_date', sanitize_text_field($_POST['last_reviewed_date'] ?? ''));
        
        // Save social links as serialized array
        $social_links = array(
            'telegram' => esc_url_raw($_POST['author_telegram'] ?? ''),
            'instagram' => esc_url_raw($_POST['author_instagram'] ?? ''),
            'linkedin' => esc_url_raw($_POST['author_linkedin'] ?? ''),
        );
        update_post_meta($post_id, '_author_social_links', $social_links);
    }
    
    // Structure
    if (isset($_POST['teznevisan_structure_nonce']) && wp_verify_nonce($_POST['teznevisan_structure_nonce'], 'teznevisan_structure_nonce')) {
        update_post_meta($post_id, '_post_subtitle', sanitize_text_field($_POST['post_subtitle'] ?? ''));
        update_post_meta($post_id, '_reading_time', absint($_POST['reading_time'] ?? 0));
        update_post_meta($post_id, '_key_takeaways', sanitize_textarea_field($_POST['key_takeaways'] ?? ''));
        update_post_meta($post_id, '_show_author_box', isset($_POST['show_author_box']) ? '1' : '0');
        
        // Pros
        $pros = array();
        for ($i = 1; $i <= 5; $i++) {
            $pro = sanitize_text_field($_POST['pro_' . $i] ?? '');
            if ($pro) {
                $pros[] = $pro;
                update_post_meta($post_id, '_pro_' . $i, $pro);
            } else {
                delete_post_meta($post_id, '_pro_' . $i);
            }
        }
        update_post_meta($post_id, '_pros_cons', array('pros' => $pros, 'cons' => array()));
        
        // Cons
        $cons = array();
        for ($i = 1; $i <= 5; $i++) {
            $con = sanitize_text_field($_POST['con_' . $i] ?? '');
            if ($con) {
                $cons[] = $con;
                update_post_meta($post_id, '_con_' . $i, $con);
            } else {
                delete_post_meta($post_id, '_con_' . $i);
            }
        }
        
        $pros_cons_final = array('pros' => $pros, 'cons' => $cons);
        update_post_meta($post_id, '_pros_cons', $pros_cons_final);
        
        // FAQs
        $faqs = array();
        for ($i = 1; $i <= 10; $i++) {
            $q = sanitize_text_field($_POST['faq_q_' . $i] ?? '');
            $a = sanitize_textarea_field($_POST['faq_a_' . $i] ?? '');
            if ($q && $a) {
                $faqs[] = array('q' => $q, 'a' => $a);
                update_post_meta($post_id, '_faq_q_' . $i, $q);
                update_post_meta($post_id, '_faq_a_' . $i, $a);
            } else {
                delete_post_meta($post_id, '_faq_q_' . $i);
                delete_post_meta($post_id, '_faq_a_' . $i);
            }
        }
        update_post_meta($post_id, '_faq_items', $faqs);
    }
    
    // SEO
    if (isset($_POST['teznevisan_seo_nonce']) && wp_verify_nonce($_POST['teznevisan_seo_nonce'], 'teznevisan_seo_nonce')) {
        update_post_meta($post_id, '_focus_keyword', sanitize_text_field($_POST['focus_keyword'] ?? ''));
        update_post_meta($post_id, '_meta_title', sanitize_text_field($_POST['meta_title'] ?? ''));
        update_post_meta($post_id, '_meta_description', sanitize_textarea_field($_POST['meta_description'] ?? ''));
    }
    
    // Engagement
    if (isset($_POST['teznevisan_engagement_nonce']) && wp_verify_nonce($_POST['teznevisan_engagement_nonce'], 'teznevisan_engagement_nonce')) {
        update_post_meta($post_id, '_enable_rating', isset($_POST['enable_rating']) ? '1' : '0');
        update_post_meta($post_id, '_enable_likes', isset($_POST['enable_likes']) ? '1' : '0');
    }
}
add_action('save_post', 'teznevisan_save_single_post_meta');
