<?php
/**
 * Post Meta Fields Template
 * Teznevisan Theme - Blog Post Enhancements
 */

if (!defined("ABSPATH")) {
    exit;
}
?>

<div class="teznevisan-post-meta">
    <div class="post-meta-tabs">
        <nav class="meta-nav-tabs">
            <button type="button" class="meta-tab-btn active" data-tab="basic">
                <i class="fas fa-info-circle"></i> اطلاعات پایه
            </button>
            <button type="button" class="meta-tab-btn" data-tab="content">
                <i class="fas fa-file-alt"></i> محتوای اضافی
            </button>
            <button type="button" class="meta-tab-btn" data-tab="seo">
                <i class="fas fa-search"></i> SEO و اشتراک
            </button>
            <button type="button" class="meta-tab-btn" data-tab="related">
                <i class="fas fa-link"></i> مطالب مرتبط
            </button>
        </nav>
        
        <!-- Basic Tab -->
        <div class="meta-tab-content active" data-tab="basic">
            <h3><i class="fas fa-info-circle"></i> اطلاعات پایه مطلب</h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="post_subtitle">
                            <i class="fas fa-heading"></i> زیرعنوان مطلب
                        </label>
                    </th>
                    <td>
                        <input type="text" 
                               id="post_subtitle" 
                               name="post_subtitle" 
                               value="<?php echo esc_attr($subtitle); ?>" 
                               class="large-text"
                               placeholder="زیرعنوان توضیحی برای مطلب">
                        <p class="description">این متن زیر عنوان اصلی مطلب نمایش داده می‌شود</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="reading_time">
                            <i class="fas fa-clock"></i> زمان مطالعه (دقیقه)
                        </label>
                    </th>
                    <td>
                        <input type="number" 
                               id="reading_time" 
                               name="reading_time" 
                               value="<?php echo esc_attr(get_post_meta($post->ID, "reading_time", true)); ?>" 
                               class="small-text"
                               min="1"
                               max="60"
                               placeholder="5">
                        <p class="description">اگر خالی باشد، به صورت خودکار محاسبه می‌شود</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="post_difficulty">
                            <i class="fas fa-chart-line"></i> سطح مطلب
                        </label>
                    </th>
                    <td>
                        <select id="post_difficulty" name="post_difficulty" class="regular-text">
                            <?php
                            $difficulty = get_post_meta($post->ID, "post_difficulty", true);
                            $levels = array(
                                "beginner" => "مبتدی",
                                "intermediate" => "متوسط", 
                                "advanced" => "پیشرفته",
                                "expert" => "تخصصی"
                            );
                            ?>
                            <option value="">انتخاب سطح</option>
                            <?php foreach ($levels as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php selected($difficulty, $value); ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">سطح پیچیدگی مطلب برای خوانندگان</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Content Tab -->
        <div class="meta-tab-content" data-tab="content">
            <h3><i class="fas fa-file-alt"></i> محتوای اضافی و نکات</h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label><i class="fas fa-lightbulb"></i> نکات کلیدی</label>
                    </th>
                    <td>
                        <div id="takeaways-container">
                            <?php if (!empty($key_takeaways)): ?>
                                <?php foreach ($key_takeaways as $index => $takeaway): ?>
                                    <div class="takeaway-item">
                                        <div class="takeaway-input-group">
                                            <i class="fas fa-check-circle takeaway-icon"></i>
                                            <input type="text" 
                                                   name="key_takeaways[]" 
                                                   value="<?php echo esc_attr($takeaway); ?>" 
                                                   class="takeaway-input" 
                                                   placeholder="نکته مهم از مطلب">
                                        </div>
                                        <button type="button" class="button button-secondary remove-takeaway">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" id="add-takeaway" class="button button-primary">
                            <i class="fas fa-plus"></i> افزودن نکته کلیدی
                        </button>
                        <p class="description">نکات مهم و خلاصه‌ای از مطلب که خوانندگان باید بدانند</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label><i class="fas fa-chart-bar"></i> آمار و ارقام</label>
                    </th>
                    <td>
                        <div id="statistics-container">
                            <?php if (!empty($statistics)): ?>
                                <?php foreach ($statistics as $index => $stat): ?>
                                    <div class="statistic-item">
                                        <div class="stat-fields">
                                            <input type="text" 
                                                   name="statistics[<?php echo $index; ?>][number]" 
                                                   value="<?php echo esc_attr($stat["number"] ?? ""); ?>" 
                                                   placeholder="123"
                                                   class="stat-number">
                                            <input type="text" 
                                                   name="statistics[<?php echo $index; ?>][label]" 
                                                   value="<?php echo esc_attr($stat["label"] ?? ""); ?>" 
                                                   placeholder="برچسب آمار"
                                                   class="stat-label">
                                        </div>
                                        <button type="button" class="button button-secondary remove-statistic">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" id="add-statistic" class="button button-primary">
                            <i class="fas fa-plus"></i> افزودن آمار
                        </button>
                        <p class="description">آمار و ارقام مرتبط با موضوع مطلب</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- SEO Tab -->
        <div class="meta-tab-content" data-tab="seo">
            <h3><i class="fas fa-search"></i> تنظیمات SEO و اشتراک‌گذاری</h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="custom_meta_description">
                            <i class="fas fa-align-left"></i> توضیحات متا سفارشی
                        </label>
                    </th>
                    <td>
                        <textarea id="custom_meta_description" 
                                  name="custom_meta_description" 
                                  rows="3" 
                                  class="large-text"
                                  maxlength="160"
                                  placeholder="توضیح کوتاه برای موتورهای جستجو..."><?php echo esc_textarea(get_post_meta($post->ID, "custom_meta_description", true)); ?></textarea>
                        <p class="description">حداکثر 160 کاراکتر - برای بهتر نمایش در Google استفاده می‌شود</p>
                        <div class="char-counter">
                            <span id="meta-desc-count">0</span> / 160 کاراکتر
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="focus_keyword">
                            <i class="fas fa-key"></i> کلمه کلیدی اصلی
                        </label>
                    </th>
                    <td>
                        <input type="text" 
                               id="focus_keyword" 
                               name="focus_keyword" 
                               value="<?php echo esc_attr(get_post_meta($post->ID, "focus_keyword", true)); ?>" 
                               class="regular-text"
                               placeholder="کلمه کلیدی اصلی مطلب">
                        <p class="description">کلمه کلیدی اصلی که مطلب بر اساس آن بهینه‌سازی شده</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Related Tab -->
        <div class="meta-tab-content" data-tab="related">
            <h3><i class="fas fa-link"></i> خدمات و مطالب مرتبط</h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="related_service_id">
                            <i class="fas fa-tools"></i> خدمت مرتبط
                        </label>
                    </th>
                    <td>
                        <select id="related_service_id" name="related_service_id" class="regular-text">
                            <option value="">انتخاب خدمت مرتبط</option>
                            <?php
                            $services = get_posts(array(
                                "post_type" => "services", 
                                "posts_per_page" => -1,
                                "post_status" => "publish"
                            ));
                            
                            foreach ($services as $service):
                            ?>
                                <option value="<?php echo $service->ID; ?>" 
                                        <?php selected($related_service_id, $service->ID); ?>>
                                    <?php echo esc_html($service->post_title); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">خدمتی که با این مطلب مرتبط است</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label><i class="fas fa-images"></i> تصاویر ویژه</label>
                    </th>
                    <td>
                        <div id="featured-images-container">
                            <?php if (!empty($featured_images)): ?>
                                <?php foreach ($featured_images as $index => $image_id): ?>
                                    <div class="featured-image-item">
                                        <?php echo wp_get_attachment_image($image_id, "thumbnail"); ?>
                                        <input type="hidden" name="featured_images[]" value="<?php echo $image_id; ?>">
                                        <button type="button" class="button button-secondary remove-image">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" id="add-featured-image" class="button button-primary">
                            <i class="fas fa-plus"></i> افزودن تصویر
                        </button>
                        <p class="description">تصاویر اضافی برای نمایش در مطلب</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<style>
.teznevisan-post-meta {
    font-family: "IRANSans", sans-serif;
    direction: rtl;
    margin-top: 20px;
}

.post-meta-tabs {
    background: white;
    border: 1px solid #ccd0d4;
    border-radius: 6px;
    overflow: hidden;
}

.meta-nav-tabs {
    display: flex;
    background: #f1f1f1;
    border-bottom: 1px solid #ccd0d4;
    flex-wrap: wrap;
}

.meta-tab-btn {
    background: transparent;
    border: none;
    padding: 15px 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: inherit;
    color: #555;
    transition: all 0.3s ease;
    border-left: 1px solid #ddd;
}

.meta-tab-btn.active {
    background: white;
    color: #1FA547;
    font-weight: 600;
    border-bottom: 2px solid #1FA547;
    margin-bottom: -1px;
}

.meta-tab-content {
    display: none;
    padding: 25px;
}

.meta-tab-content.active {
    display: block;
}

.meta-tab-content h3 {
    margin: 0 0 20px 0;
    color: #1FA547;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}

.takeaway-item,
.statistic-item {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
}

.takeaway-input-group {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.takeaway-icon {
    color: #1FA547;
    font-size: 1.1rem;
}

.takeaway-input {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
}

.stat-fields {
    flex: 1;
    display: flex;
    gap: 10px;
}

.stat-number {
    width: 100px;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

.stat-label {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
}

.featured-image-item {
    display: inline-block;
    position: relative;
    margin: 5px;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
}

.featured-image-item img {
    display: block;
}

.featured-image-item .remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 3px;
    padding: 5px 8px;
    font-size: 12px;
}

.char-counter {
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}

.char-counter.warning {
    color: #ffc107;
}

.char-counter.danger {
    color: #dc3545;
}

/* Responsive */
@media (max-width: 768px) {
    .meta-nav-tabs {
        flex-direction: column;
    }
    
    .meta-tab-btn {
        border-left: none;
        border-bottom: 1px solid #ddd;
    }
    
    .stat-fields {
        flex-direction: column;
    }
    
    .stat-number {
        width: 100%;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    let takeawayIndex = ' . (count($key_takeaways) ?: 0) . ';
    let statisticIndex = ' . (count($statistics) ?: 0) . ';
    
    // Tab switching
    $(".meta-tab-btn").on("click", function() {
        const targetTab = $(this).data("tab");
        
        $(".meta-tab-btn").removeClass("active");
        $(".meta-tab-content").removeClass("active");
        
        $(this).addClass("active");
        $(`.meta-tab-content[data-tab="${targetTab}"]`).addClass("active");
    });
    
    // Add takeaway
    $("#add-takeaway").on("click", function() {
        const html = `
            <div class="takeaway-item">
                <div class="takeaway-input-group">
                    <i class="fas fa-check-circle takeaway-icon"></i>
                    <input type="text" 
                           name="key_takeaways[]" 
                           class="takeaway-input" 
                           placeholder="نکته مهم از مطلب">
                </div>
                <button type="button" class="button button-secondary remove-takeaway">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        $("#takeaways-container").append(html);
        takeawayIndex++;
    });
    
    // Add statistic
    $("#add-statistic").on("click", function() {
        const html = `
            <div class="statistic-item">
                <div class="stat-fields">
                    <input type="text" 
                           name="statistics[${statisticIndex}][number]" 
                           placeholder="123"
                           class="stat-number">
                    <input type="text" 
                           name="statistics[${statisticIndex}][label]" 
                           placeholder="برچسب آمار"
                           class="stat-label">
                </div>
                <button type="button" class="button button-secondary remove-statistic">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        $("#statistics-container").append(html);
        statisticIndex++;
    });
    
    // Remove handlers
    $(document).on("click", ".remove-takeaway", function() {
        $(this).closest(".takeaway-item").remove();
    });
    
    $(document).on("click", ".remove-statistic", function() {
        $(this).closest(".statistic-item").remove();
    });
    
    $(document).on("click", ".remove-image", function() {
        $(this).closest(".featured-image-item").remove();
    });
    
    // Media uploader for featured images
    $("#add-featured-image").on("click", function(e) {
        e.preventDefault();
        
        const mediaUploader = wp.media({
            title: "انتخاب تصویر",
            button: {
                text: "انتخاب"
            },
            multiple: true
        });
        
        mediaUploader.on("select", function() {
            const attachments = mediaUploader.state().get("selection").toJSON();
            
            attachments.forEach(function(attachment) {
                const html = `
                    <div class="featured-image-item">
                        <img src="${attachment.sizes.thumbnail.url}" alt="${attachment.alt}">
                        <input type="hidden" name="featured_images[]" value="${attachment.id}">
                        <button type="button" class="button button-secondary remove-image">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                $("#featured-images-container").append(html);
            });
        });
        
        mediaUploader.open();
    });
    
    // Character counter for meta description
    $("#custom_meta_description").on("input", function() {
        const length = $(this).val().length;
        const counter = $("#meta-desc-count");
        
        counter.text(length);
        
        if (length > 150) {
            counter.parent().addClass("danger").removeClass("warning");
        } else if (length > 130) {
            counter.parent().addClass("warning").removeClass("danger");
        } else {
            counter.parent().removeClass("warning danger");
        }
    });
    
    // Initialize character counter
    $("#custom_meta_description").trigger("input");
});
</script>';
            file_put_contents($admin_dir . '/post-meta-fields.php', $post_meta_content);
        }
>>>>>>> REPLACE