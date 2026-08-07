<?php
/**
 * Complete Meta Boxes for E-E-A-T and Helpful Content
 * All backend fields for single post optimization
 */

// Add all meta boxes
function teznevisan_register_post_meta_boxes() {
    
    // E-E-A-T & Author Credentials
    add_meta_box(
        'teznevisan_eeat_meta',
        '🎓 E-E-A-T & Author Credentials',
        'teznevisan_eeat_meta_callback',
        'post',
        'normal',
        'high'
    );
    
    // Content Structure & Key Takeaways
    add_meta_box(
        'teznevisan_structure_meta',
        '📝 Content Structure & Key Points',
        'teznevisan_structure_meta_callback',
        'post',
        'normal',
        'high'
    );
    
    // Pros & Cons
    add_meta_box(
        'teznevisan_pros_cons_meta',
        '✅❌ Pros & Cons',
        'teznevisan_pros_cons_meta_callback',
        'post',
        'normal',
        'default'
    );
    
    // FAQs Schema
    add_meta_box(
        'teznevisan_faq_meta',
        '❓ FAQ Schema',
        'teznevisan_faq_meta_callback',
        'post',
        'normal',
        'default'
    );
    
    // Sources & Citations
    add_meta_box(
        'teznevisan_sources_meta',
        '📚 Sources & Citations',
        'teznevisan_sources_meta_callback',
        'post',
        'normal',
        'default'
    );
    
    // Engagement Features
    add_meta_box(
        'teznevisan_engagement_meta',
        '💬 Engagement Features',
        'teznevisan_engagement_meta_callback',
        'post',
        'side',
        'default'
    );
    
    // Content Updates & History
    add_meta_box(
        'teznevisan_updates_meta',
        '🔄 Content Updates & History',
        'teznevisan_updates_meta_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'teznevisan_register_post_meta_boxes');

/**
 * E-E-A-T Meta Box Callback
 */
function teznevisan_eeat_meta_callback($post) {
    wp_nonce_field('teznevisan_eeat_meta', 'teznevisan_eeat_nonce');
    
    $author_expertise = get_post_meta($post->ID, '_author_expertise', true);
    $author_credentials = get_post_meta($post->ID, '_author_credentials', true);
    $author_bio_override = get_post_meta($post->ID, '_author_bio_override', true);
    $fact_checked = get_post_meta($post->ID, '_fact_checked', true);
    $fact_checker_name = get_post_meta($post->ID, '_fact_checker_name', true);
    $medical_review = get_post_meta($post->ID, '_medical_review', true);
    $reviewer_name = get_post_meta($post->ID, '_reviewer_name', true);
    $reviewer_credentials = get_post_meta($post->ID, '_reviewer_credentials', true);
    $last_reviewed_date = get_post_meta($post->ID, '_last_reviewed_date', true);
    $content_disclaimer = get_post_meta($post->ID, '_content_disclaimer', true);
    ?>
    <style>
        .teznevisan-meta-field { margin-bottom: 20px; }
        .teznevisan-meta-field label { display: block; margin-bottom: 5px; font-weight: 600; }
        .teznevisan-meta-field input[type="text"],
        .teznevisan-meta-field textarea { width: 100%; padding: 8px; }
        .teznevisan-meta-field textarea { min-height: 80px; }
        .teznevisan-meta-description { font-size: 12px; color: #666; margin-top: 5px; font-style: italic; }
        .teznevisan-meta-checkbox { margin-left: 8px; }
    </style>
    
    <div class="teznevisan-meta-field">
        <label for="author_expertise">تخصص نویسنده (Expertise)</label>
        <input type="text" id="author_expertise" name="author_expertise" value="<?php echo esc_attr($author_expertise); ?>" placeholder="مثال: متخصص تغذیه، مشاور سئو، وکیل دادگستری">
        <p class="teznevisan-meta-description">تخصص اصلی نویسنده در این زمینه</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="author_credentials">مدارک و گواهینامه‌ها (Credentials)</label>
        <textarea id="author_credentials" name="author_credentials" placeholder="مثال: کارشناسی ارشد تغذیه از دانشگاه تهران، 10 سال تجربه مشاوره"><?php echo esc_textarea($author_credentials); ?></textarea>
        <p class="teznevisan-meta-description">مدارک تحصیلی، گواهینامه‌ها، و سوابق حرفه‌ای</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="author_bio_override">توضیح کوتاه نویسنده برای این مقاله (اختیاری)</label>
        <textarea id="author_bio_override" name="author_bio_override"><?php echo esc_textarea($author_bio_override); ?></textarea>
        <p class="teznevisan-meta-description">اگر می‌خواهید برای این مقاله توضیح متفاوتی نمایش دهید</p>
    </div>
    
    <hr style="margin: 20px 0;">
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="fact_checked" class="teznevisan-meta-checkbox" value="1" <?php checked($fact_checked, '1'); ?>>
            این محتوا توسط کارشناس بررسی شده است (Fact-Checked)
        </label>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="fact_checker_name">نام بررسی‌کننده حقایق</label>
        <input type="text" id="fact_checker_name" name="fact_checker_name" value="<?php echo esc_attr($fact_checker_name); ?>" placeholder="نام و نام خانوادگی">
    </div>
    
    <hr style="margin: 20px 0;">
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="medical_review" class="teznevisan-meta-checkbox" value="1" <?php checked($medical_review, '1'); ?>>
            این محتوا دارای بازبینی پزشکی است (Medical Review)
        </label>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="reviewer_name">نام بازبین پزشکی</label>
        <input type="text" id="reviewer_name" name="reviewer_name" value="<?php echo esc_attr($reviewer_name); ?>" placeholder="دکتر احمد محمدی">
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="reviewer_credentials">مدارک بازبین</label>
        <input type="text" id="reviewer_credentials" name="reviewer_credentials" value="<?php echo esc_attr($reviewer_credentials); ?>" placeholder="متخصص قلب و عروق، عضو نظام پزشکی">
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="last_reviewed_date">تاریخ آخرین بازبینی</label>
        <input type="date" id="last_reviewed_date" name="last_reviewed_date" value="<?php echo esc_attr($last_reviewed_date); ?>">
    </div>
    
    <hr style="margin: 20px 0;">
    
    <div class="teznevisan-meta-field">
        <label for="content_disclaimer">اخطار یا سلب مسئولیت محتوا (Disclaimer)</label>
        <textarea id="content_disclaimer" name="content_disclaimer"><?php echo esc_textarea($content_disclaimer); ?></textarea>
        <p class="teznevisan-meta-description">برای مقالات پزشکی، حقوقی، یا مالی</p>
    </div>
    <?php
}

/**
 * Content Structure Meta Box
 */
function teznevisan_structure_meta_callback($post) {
    wp_nonce_field('teznevisan_structure_meta', 'teznevisan_structure_nonce');
    
    $subtitle = get_post_meta($post->ID, '_post_subtitle', true);
    $reading_time = get_post_meta($post->ID, '_reading_time', true);
    $key_takeaways = get_post_meta($post->ID, '_key_takeaways', true);
    $editor_notes = get_post_meta($post->ID, '_editor_notes', true);
    $content_summary = get_post_meta($post->ID, '_content_summary', true);
    $target_audience = get_post_meta($post->ID, '_target_audience', true);
    ?>
    
    <div class="teznevisan-meta-field">
        <label for="post_subtitle">زیرعنوان مقاله (Subtitle)</label>
        <input type="text" id="post_subtitle" name="post_subtitle" value="<?php echo esc_attr($subtitle); ?>" placeholder="توضیح کوتاه در زیر عنوان">
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="reading_time">زمان مطالعه (دقیقه)</label>
        <input type="number" id="reading_time" name="reading_time" value="<?php echo esc_attr($reading_time); ?>" min="1" max="60" placeholder="5">
        <p class="teznevisan-meta-description">خالی بگذارید تا خودکار محاسبه شود</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="key_takeaways">نکات کلیدی (Key Takeaways)</label>
        <textarea id="key_takeaways" name="key_takeaways" rows="5"><?php echo esc_textarea($key_takeaways); ?></textarea>
        <p class="teznevisan-meta-description">هر نکته در یک خط (برای نمایش در ابتدای مقاله)</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="editor_notes">یادداشت سردبیر</label>
        <textarea id="editor_notes" name="editor_notes" rows="4"><?php echo esc_textarea($editor_notes); ?></textarea>
        <p class="teznevisan-meta-description">توضیحات اضافی سردبیر درباره این مقاله</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="content_summary">خلاصه محتوا (برای Rich Snippets)</label>
        <textarea id="content_summary" name="content_summary" rows="3"><?php echo esc_textarea($content_summary); ?></textarea>
        <p class="teznevisan-meta-description">خلاصه 150-160 کاراکتری از محتوا</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="target_audience">مخاطب هدف</label>
        <input type="text" id="target_audience" name="target_audience" value="<?php echo esc_attr($target_audience); ?>" placeholder="مثال: افراد مبتدی، صاحبان کسب‌وکار">
    </div>
    <?php
}

/**
 * Pros & Cons Meta Box
 */
function teznevisan_pros_cons_meta_callback($post) {
    wp_nonce_field('teznevisan_pros_cons_meta', 'teznevisan_pros_cons_nonce');
    
    $show_pros_cons = get_post_meta($post->ID, '_show_pros_cons', true);
    ?>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="show_pros_cons" class="teznevisan-meta-checkbox" value="1" <?php checked($show_pros_cons, '1'); ?>>
            نمایش بخش مزایا و معایب
        </label>
    </div>
    
    <h4>✅ مزایا (Pros)</h4>
    <?php for ($i = 1; $i <= 5; $i++) : 
        $pro = get_post_meta($post->ID, '_pro_' . $i, true);
    ?>
        <div class="teznevisan-meta-field">
            <label for="pro_<?php echo $i; ?>">مزیت <?php echo $i; ?></label>
            <input type="text" id="pro_<?php echo $i; ?>" name="pro_<?php echo $i; ?>" value="<?php echo esc_attr($pro); ?>">
        </div>
    <?php endfor; ?>
    
    <h4 style="margin-top: 20px;">❌ معایب (Cons)</h4>
    <?php for ($i = 1; $i <= 5; $i++) : 
        $con = get_post_meta($post->ID, '_con_' . $i, true);
    ?>
        <div class="teznevisan-meta-field">
            <label for="con_<?php echo $i; ?>">معایب <?php echo $i; ?></label>
            <input type="text" id="con_<?php echo $i; ?>" name="con_<?php echo $i; ?>" value="<?php echo esc_attr($con); ?>">
        </div>
    <?php endfor; ?>
    <?php
}

/**
 * FAQ Meta Box
 */
function teznevisan_faq_meta_callback($post) {
    wp_nonce_field('teznevisan_faq_meta', 'teznevisan_faq_nonce');
    
    $enable_faq = get_post_meta($post->ID, '_enable_faq_schema', true);
    ?>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_faq_schema" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_faq, '1'); ?>>
            فعال‌سازی FAQ Schema
        </label>
    </div>
    
    <p style="background: #e7f3ff; padding: 10px; border-radius: 4px; font-size: 13px;">
        💡 <strong>نکته:</strong> FAQ Schema به گوگل کمک می‌کند سوالات شما را در نتایج جستجو نمایش دهد.
    </p>
    
    <?php for ($i = 1; $i <= 10; $i++) : 
        $question = get_post_meta($post->ID, '_faq_q_' . $i, true);
        $answer = get_post_meta($post->ID, '_faq_a_' . $i, true);
    ?>
        <div class="teznevisan-meta-field" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
            <h4 style="margin-top: 0;">سوال <?php echo $i; ?></h4>
            <label for="faq_q_<?php echo $i; ?>">سوال</label>
            <input type="text" id="faq_q_<?php echo $i; ?>" name="faq_q_<?php echo $i; ?>" value="<?php echo esc_attr($question); ?>" placeholder="سوال خود را بنویسید...">
            
            <label for="faq_a_<?php echo $i; ?>" style="margin-top: 10px;">پاسخ</label>
            <textarea id="faq_a_<?php echo $i; ?>" name="faq_a_<?php echo $i; ?>" rows="3" placeholder="پاسخ کامل را بنویسید..."><?php echo esc_textarea($answer); ?></textarea>
        </div>
    <?php endfor; ?>
    <?php
}

/**
 * Sources & Citations Meta Box
 */
function teznevisan_sources_meta_callback($post) {
    wp_nonce_field('teznevisan_sources_meta', 'teznevisan_sources_nonce');
    
    $enable_sources = get_post_meta($post->ID, '_enable_sources', true);
    ?>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_sources" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_sources, '1'); ?>>
            نمایش بخش منابع و مراجع
        </label>
    </div>
    
    <p style="background: #fff3cd; padding: 10px; border-radius: 4px; font-size: 13px;">
        📚 منابع معتبر به اعتبار محتوای شما کمک می‌کند و E-E-A-T را بهبود می‌بخشد.
    </p>
    
    <?php for ($i = 1; $i <= 10; $i++) : 
        $source_title = get_post_meta($post->ID, '_source_title_' . $i, true);
        $source_url = get_post_meta($post->ID, '_source_url_' . $i, true);
        $source_author = get_post_meta($post->ID, '_source_author_' . $i, true);
    ?>
        <div class="teznevisan-meta-field" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
            <h4 style="margin-top: 0;">منبع <?php echo $i; ?></h4>
            
            <label for="source_title_<?php echo $i; ?>">عنوان منبع</label>
            <input type="text" id="source_title_<?php echo $i; ?>" name="source_title_<?php echo $i; ?>" value="<?php echo esc_attr($source_title); ?>" placeholder="عنوان مقاله یا کتاب">
            
            <label for="source_url_<?php echo $i; ?>" style="margin-top: 10px;">لینک منبع</label>
            <input type="url" id="source_url_<?php echo $i; ?>" name="source_url_<?php echo $i; ?>" value="<?php echo esc_url($source_url); ?>" placeholder="https://...">
            
            <label for="source_author_<?php echo $i; ?>" style="margin-top: 10px;">نویسنده/سازمان</label>
            <input type="text" id="source_author_<?php echo $i; ?>" name="source_author_<?php echo $i; ?>" value="<?php echo esc_attr($source_author); ?>" placeholder="نام نویسنده یا سازمان">
        </div>
    <?php endfor; ?>
    <?php
}

/**
 * Engagement Features Meta Box
 */
function teznevisan_engagement_meta_callback($post) {
    wp_nonce_field('teznevisan_engagement_meta', 'teznevisan_engagement_nonce');
    
    $enable_rating = get_post_meta($post->ID, '_enable_rating', true);
    $enable_likes = get_post_meta($post->ID, '_enable_likes', true);
    $enable_comments = get_post_meta($post->ID, '_enable_post_comments', true);
    $enable_share = get_post_meta($post->ID, '_enable_social_share', true);
    $enable_print = get_post_meta($post->ID, '_enable_print', true);
    ?>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_rating" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_rating, '1'); ?>>
            امتیازدهی (Rating)
        </label>
    </div>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_likes" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_likes, '1'); ?>>
            پسندیدن/نپسندیدن (Likes)
        </label>
    </div>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_post_comments" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_comments, '1'); ?>>
            نظرات (Comments)
        </label>
    </div>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_social_share" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_share, '1'); ?>>
            اشتراک‌گذاری (Social Share)
        </label>
    </div>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="enable_print" class="teznevisan-meta-checkbox" value="1" <?php checked($enable_print, '1'); ?>>
            دکمه چاپ (Print)
        </label>
    </div>
    <?php
}

/**
 * Content Updates Meta Box
 */
function teznevisan_updates_meta_callback($post) {
    wp_nonce_field('teznevisan_updates_meta', 'teznevisan_updates_nonce');
    
    $major_update = get_post_meta($post->ID, '_major_update', true);
    $update_notes = get_post_meta($post->ID, '_update_notes', true);
    $content_freshness = get_post_meta($post->ID, '_content_freshness', true);
    
    $post_views = get_post_meta($post->ID, 'post_views_count', true);
    ?>
    
    <div class="teznevisan-meta-field">
        <label>
            <input type="checkbox" name="major_update" class="teznevisan-meta-checkbox" value="1" <?php checked($major_update, '1'); ?>>
            این به‌روزرسانی عمده است
        </label>
        <p class="teznevisan-meta-description">برای به‌روزرسانی‌های مهم فعال کنید</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="update_notes">یادداشت به‌روزرسانی</label>
        <textarea id="update_notes" name="update_notes" rows="3"><?php echo esc_textarea($update_notes); ?></textarea>
        <p class="teznevisan-meta-description">توضیح تغییرات انجام شده</p>
    </div>
    
    <div class="teznevisan-meta-field">
        <label for="content_freshness">تازگی محتوا</label>
        <select id="content_freshness" name="content_freshness">
            <option value="evergreen" <?php selected($content_freshness, 'evergreen'); ?>>همیشه جاری (Evergreen)</option>
            <option value="recent" <?php selected($content_freshness, 'recent'); ?>>اخیر (Recent)</option>
            <option value="timesensitive" <?php selected($content_freshness, 'timesensitive'); ?>>وابسته به زمان (Time-sensitive)</option>
            <option value="historical" <?php selected($content_freshness, 'historical'); ?>>تاریخی (Historical)</option>
        </select>
    </div>
    
    <hr style="margin: 15px 0;">
    
    <div class="teznevisan-meta-field">
        <strong>آمار مقاله:</strong>
        <p style="margin: 5px 0;">بازدید: <?php echo $post_views ? number_format($post_views) : '0'; ?></p>
        <p style="margin: 5px 0;">تاریخ انتشار: <?php echo get_the_date('Y/m/d', $post->ID); ?></p>
        <p style="margin: 5px 0;">آخرین ویرایش: <?php echo get_the_modified_date('Y/m/d', $post->ID); ?></p>
    </div>
    <?php
}

/**
 * Save All Meta Boxes
 */
function teznevisan_save_all_meta_boxes($post_id) {
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) return;
    
    // E-E-A-T Meta
    if (isset($_POST['teznevisan_eeat_nonce']) && wp_verify_nonce($_POST['teznevisan_eeat_nonce'], 'teznevisan_eeat_meta')) {
        update_post_meta($post_id, '_author_expertise', sanitize_text_field($_POST['author_expertise'] ?? ''));
        update_post_meta($post_id, '_author_credentials', sanitize_textarea_field($_POST['author_credentials'] ?? ''));
        update_post_meta($post_id, '_author_bio_override', sanitize_textarea_field($_POST['author_bio_override'] ?? ''));
        update_post_meta($post_id, '_fact_checked', isset($_POST['fact_checked']) ? '1' : '0');
        update_post_meta($post_id, '_fact_checker_name', sanitize_text_field($_POST['fact_checker_name'] ?? ''));
        update_post_meta($post_id, '_medical_review', isset($_POST['medical_review']) ? '1' : '0');
        update_post_meta($post_id, '_reviewer_name', sanitize_text_field($_POST['reviewer_name'] ?? ''));
        update_post_meta($post_id, '_reviewer_credentials', sanitize_text_field($_POST['reviewer_credentials'] ?? ''));
        update_post_meta($post_id, '_last_reviewed_date', sanitize_text_field($_POST['last_reviewed_date'] ?? ''));
        update_post_meta($post_id, '_content_disclaimer', sanitize_textarea_field($_POST['content_disclaimer'] ?? ''));
    }
    
    // Structure Meta
    if (isset($_POST['teznevisan_structure_nonce']) && wp_verify_nonce($_POST['teznevisan_structure_nonce'], 'teznevisan_structure_meta')) {
        update_post_meta($post_id, '_post_subtitle', sanitize_text_field($_POST['post_subtitle'] ?? ''));
        update_post_meta($post_id, '_reading_time', absint($_POST['reading_time'] ?? 0));
        update_post_meta($post_id, '_key_takeaways', sanitize_textarea_field($_POST['key_takeaways'] ?? ''));
        update_post_meta($post_id, '_editor_notes', sanitize_textarea_field($_POST['editor_notes'] ?? ''));
        update_post_meta($post_id, '_content_summary', sanitize_textarea_field($_POST['content_summary'] ?? ''));
        update_post_meta($post_id, '_target_audience', sanitize_text_field($_POST['target_audience'] ?? ''));
    }
    
    // Pros & Cons
    if (isset($_POST['teznevisan_pros_cons_nonce']) && wp_verify_nonce($_POST['teznevisan_pros_cons_nonce'], 'teznevisan_pros_cons_meta')) {
        update_post_meta($post_id, '_show_pros_cons', isset($_POST['show_pros_cons']) ? '1' : '0');
        
        for ($i = 1; $i <= 5; $i++) {
            update_post_meta($post_id, '_pro_' . $i, sanitize_text_field($_POST['pro_' . $i] ?? ''));
            update_post_meta($post_id, '_con_' . $i, sanitize_text_field($_POST['con_' . $i] ?? ''));
        }
    }
    
    // FAQ Meta
    if (isset($_POST['teznevisan_faq_nonce']) && wp_verify_nonce($_POST['teznevisan_faq_nonce'], 'teznevisan_faq_meta')) {
        update_post_meta($post_id, '_enable_faq_schema', isset($_POST['enable_faq_schema']) ? '1' : '0');
        
        for ($i = 1; $i <= 10; $i++) {
            update_post_meta($post_id, '_faq_q_' . $i, sanitize_text_field($_POST['faq_q_' . $i] ?? ''));
            update_post_meta($post_id, '_faq_a_' . $i, sanitize_textarea_field($_POST['faq_a_' . $i] ?? ''));
        }
    }
    
    // Sources Meta
    if (isset($_POST['teznevisan_sources_nonce']) && wp_verify_nonce($_POST['teznevisan_sources_nonce'], 'teznevisan_sources_meta')) {
        update_post_meta($post_id, '_enable_sources', isset($_POST['enable_sources']) ? '1' : '0');
        
        for ($i = 1; $i <= 10; $i++) {
            update_post_meta($post_id, '_source_title_' . $i, sanitize_text_field($_POST['source_title_' . $i] ?? ''));
            update_post_meta($post_id, '_source_url_' . $i, esc_url_raw($_POST['source_url_' . $i] ?? ''));
            update_post_meta($post_id, '_source_author_' . $i, sanitize_text_field($_POST['source_author_' . $i] ?? ''));
        }
    }
    
    // Engagement Meta
    if (isset($_POST['teznevisan_engagement_nonce']) && wp_verify_nonce($_POST['teznevisan_engagement_nonce'], 'teznevisan_engagement_meta')) {
        update_post_meta($post_id, '_enable_rating', isset($_POST['enable_rating']) ? '1' : '0');
        update_post_meta($post_id, '_enable_likes', isset($_POST['enable_likes']) ? '1' : '0');
        update_post_meta($post_id, '_enable_post_comments', isset($_POST['enable_post_comments']) ? '1' : '0');
        update_post_meta($post_id, '_enable_social_share', isset($_POST['enable_social_share']) ? '1' : '0');
        update_post_meta($post_id, '_enable_print', isset($_POST['enable_print']) ? '1' : '0');
    }
    
    // Updates Meta
    if (isset($_POST['teznevisan_updates_nonce']) && wp_verify_nonce($_POST['teznevisan_updates_nonce'], 'teznevisan_updates_meta')) {
        update_post_meta($post_id, '_major_update', isset($_POST['major_update']) ? '1' : '0');
        update_post_meta($post_id, '_update_notes', sanitize_textarea_field($_POST['update_notes'] ?? ''));
        update_post_meta($post_id, '_content_freshness', sanitize_text_field($_POST['content_freshness'] ?? 'evergreen'));
    }
}
add_action('save_post', 'teznevisan_save_all_meta_boxes');
