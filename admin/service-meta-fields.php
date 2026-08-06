<?php
/**
 * Service Meta Fields for Teznevisan Theme
 * Complete rewrite with proper functionality
 */

if (!defined("ABSPATH")) exit;

class Teznevisan_Service_Meta {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'register_meta_boxes'));
        add_action('save_post', array($this, 'save_service_meta'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_head', array($this, 'admin_inline_styles'));
        add_action('admin_footer', array($this, 'admin_inline_scripts'));
    }
    
    /**
     * Enqueue admin assets with proper conditionals
     */
    public function enqueue_admin_assets($hook) {
        global $post_type, $post;
        
        // Only load on services edit pages
        if (($hook == 'single.php' || $hook == 'post.php') && $post_type == 'services') {
            // Enqueue WordPress media uploader
            wp_enqueue_media();
            
            // Enqueue jQuery UI for better functionality
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-accordion');
            
            // Load FontAwesome for icons
            wp_enqueue_style(
            'font-awesome-pro-local',
            get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css',
            array(),
            '7.0.0'
);
        }
    }
    
    /**
     * Add inline styles for admin interface
     */
    public function admin_inline_styles() {
        global $post_type;
        if ($post_type !== 'services') return;
        ?>
        <style>
            /* Import Design System Fonts */
@import url('./fonts.css');
/* Font Awesome for editor */
@import url('../fonts/fontawesome/css/all.css');
        .teznevisan-service-meta {
            font-family: "IRANSans", -apple-system, BlinkMacSystemFont, sans-serif !important; 
            direction: rtl;
            margin: 10px 0;
        }
        
        .meta-tabs-container {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
        }
        
        .meta-nav-tabs {
            display: flex;
            background: #f6f7f7;
            border-bottom: 1px solid #c3c4c7;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }
        
        .meta-tab-btn {
            background: transparent;
            border: none;
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #646970;
            transition: all 0.2s ease;
            border-left: 1px solid #dcdcde;
            white-space: nowrap;
            min-height: 44px;
        }
        
        .meta-tab-btn:hover {
            background: #f0f0f1;
            color: #2271b1;
        }
        
        .meta-tab-btn.active {
            background: #fff;
            color: #2271b1;
            border-bottom: 2px solid #2271b1;
            margin-bottom: -1px;
        }
        
        .meta-tab-btn i {
            font-size: 14px;
        }
        
        .meta-tab-content {
            display: none;
            padding: 20px;
        }
        
        .meta-tab-content.active {
            display: block;
        }
        
        .meta-tab-content h3 {
            margin: 0 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #dcdcde;
            color: #1d2327;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .meta-tab-content .form-table th {
            width: 200px;
            padding: 15px 10px 15px 0;
            vertical-align: top;
        }
        
        .meta-tab-content .form-table td {
            padding: 15px 0;
        }
        
        .meta-field-group {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #dcdcde;
            border-radius: 4px;
            background: #f9f9f9;
        }
        
        .dynamic-field-container {
            border: 1px solid #dcdcde;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .dynamic-field-header {
            background: #f6f7f7;
            padding: 10px 15px;
            border-bottom: 1px solid #dcdcde;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dynamic-field-content {
            padding: 15px;
        }
        
        .dynamic-field-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: flex-start;
        }
        
        .field-input-group {
            flex: 1;
        }
        
        .field-input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .field-input-group input,
        .field-input-group textarea,
        .field-input-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            font-size: 13px;
        }
        
        .field-input-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        
        .add-field-btn {
            background: #2271b1;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .add-field-btn:hover {
            background: #135e96;
        }
        
        .remove-field-btn {
            background: #d63638;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            flex-shrink: 0;
        }
        
        .remove-field-btn:hover {
            background: #b32d2e;
        }
        
        .price-range-inputs {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .price-input-group {
            flex: 1;
        }
        
        .price-input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .related-services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }
        
        .related-service-checkbox {
            margin-left: 8px;
        }
        
        .related-service-label {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border: 1px solid #dcdcde;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .related-service-label:hover {
            background: #f6f7f7;
            border-color: #2271b1;
        }
        
        .related-service-label.selected {
            background: #e7f3ff;
            border-color: #2271b1;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            background: #2271b1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            flex-shrink: 0;
        }
        
        @media (max-width: 782px) {
            .meta-nav-tabs {
                flex-direction: column;
            }
            
            .meta-tab-btn {
                border-left: none;
                border-bottom: 1px solid #dcdcde;
            }
            
            .price-range-inputs {
                flex-direction: column;
                gap: 10px;
            }
            
            .dynamic-field-row {
                flex-direction: column;
                gap: 15px;
            }
        }
        </style>
        <?php
    }
    
    /**
     * Add inline JavaScript for admin functionality
     */
    public function admin_inline_scripts() {
        global $post_type;
        if ($post_type !== 'services') return;
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Tab switching
            $('.meta-tab-btn').on('click', function(e) {
                e.preventDefault();
                
                const targetTab = $(this).data('tab');
                
                // Remove active classes
                $('.meta-tab-btn').removeClass('active');
                $('.meta-tab-content').removeClass('active');
                
                // Add active classes
                $(this).addClass('active');
                $('.meta-tab-content[data-tab="' + targetTab + '"]').addClass('active');
            });
            
            // Initialize field counters
            let featureIndex = $('.feature-field').length;
            let stepIndex = $('.step-field').length;
            let faqIndex = $('.faq-field').length;
            
            // Add feature
            $('#add-feature').on('click', function() {
                const html = `
                    <div class="dynamic-field-container feature-field">
                        <div class="dynamic-field-header">
                            <strong>ویژگی ${featureIndex + 1}</strong>
                            <button type="button" class="remove-field-btn remove-feature">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </div>
                        <div class="dynamic-field-content">
                            <div class="field-input-group">
                                <label>عنوان ویژگی:</label>
                                <input type="text" name="service_features[${featureIndex}][title]" placeholder="عنوان ویژگی">
                            </div>
                            <div class="field-input-group">
                                <label>توضیحات ویژگی:</label>
                                <textarea name="service_features[${featureIndex}][description]" placeholder="توضیحات کامل ویژگی"></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#features-container').append(html);
                featureIndex++;
            });
            
            // Remove feature
            $(document).on('click', '.remove-feature', function() {
                if (confirm('آیا از حذف این ویژگی اطمینان دارید؟')) {
                    $(this).closest('.feature-field').fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });
            
            // Add process step
            $('#add-step').on('click', function() {
                const html = `
                    <div class="dynamic-field-container step-field">
                        <div class="dynamic-field-header">
                            <strong>مرحله ${stepIndex + 1}</strong>
                            <button type="button" class="remove-field-btn remove-step">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </div>
                        <div class="dynamic-field-content">
                            <div class="dynamic-field-row">
                                <div class="step-number">${stepIndex + 1}</div>
                                <div class="field-input-group">
                                    <label>عنوان مرحله:</label>
                                    <input type="text" name="process_steps[${stepIndex}][title]" placeholder="عنوان مرحله">
                                </div>
                            </div>
                            <div class="field-input-group">
                                <label>توضیحات مرحله:</label>
                                <textarea name="process_steps[${stepIndex}][description]" placeholder="توضیحات کامل مرحله"></textarea>
                            </div>
                            <div class="field-input-group">
                                <label>مدت زمان:</label>
                                <input type="text" name="process_steps[${stepIndex}][duration]" placeholder="مثال: 2-3 روز">
                            </div>
                        </div>
                    </div>
                `;
                $('#steps-container').append(html);
                stepIndex++;
                updateStepNumbers();
            });
            
            // Remove step
            $(document).on('click', '.remove-step', function() {
                if (confirm('آیا از حذف این مرحله اطمینان دارید؟')) {
                    $(this).closest('.step-field').fadeOut(300, function() {
                        $(this).remove();
                        updateStepNumbers();
                    });
                }
            });
            
            // Update step numbers
            function updateStepNumbers() {
                $('.step-field').each(function(index) {
                    $(this).find('.dynamic-field-header strong').text('مرحله ' + (index + 1));
                    $(this).find('.step-number').text(index + 1);
                });
            }
            
            // Add FAQ
            $('#add-faq').on('click', function() {
                const html = `
                    <div class="dynamic-field-container faq-field">
                        <div class="dynamic-field-header">
                            <strong>سوال ${faqIndex + 1}</strong>
                            <button type="button" class="remove-field-btn remove-faq">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </div>
                        <div class="dynamic-field-content">
                            <div class="field-input-group">
                                <label>سوال:</label>
                                <input type="text" name="service_faq[${faqIndex}][question]" placeholder="سوال متداول">
                            </div>
                            <div class="field-input-group">
                                <label>پاسخ:</label>
                                <textarea name="service_faq[${faqIndex}][answer]" placeholder="پاسخ کامل و مفصل"></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#faq-container').append(html);
                faqIndex++;
            });
            
            // Remove FAQ
            $(document).on('click', '.remove-faq', function() {
                if (confirm('آیا از حذف این سوال اطمینان دارید؟')) {
                    $(this).closest('.faq-field').fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });
            
            // Related services selection
            $('.related-service-checkbox').on('change', function() {
                const label = $(this).closest('.related-service-label');
                if ($(this).is(':checked')) {
                    label.addClass('selected');
                } else {
                    label.removeClass('selected');
                }
                
                // Limit to 3 selections
                const selectedCount = $('.related-service-checkbox:checked').length;
                if (selectedCount >= 3) {
                    $('.related-service-checkbox:not(:checked)').prop('disabled', true);
                } else {
                    $('.related-service-checkbox').prop('disabled', false);
                }
            });
            
            // Initialize existing selections
            $('.related-service-checkbox:checked').each(function() {
                $(this).closest('.related-service-label').addClass('selected');
            });
            
            // Check initial limit
            if ($('.related-service-checkbox:checked').length >= 3) {
                $('.related-service-checkbox:not(:checked)').prop('disabled', true);
            }
        });
        </script>
        <?php
    }
    
    /**
     * Register meta boxes
     */
    public function register_meta_boxes() {
        add_meta_box(
            'teznevisan_service_meta',
            'تنظیمات تکمیلی خدمت',
            array($this, 'render_meta_box'),
            'services',
            'normal',
            'high'
        );
    }
    
    /**
     * Render the main meta box
     */
    public function render_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('teznevisan_save_service', 'teznevisan_service_nonce');
        
        // Get meta values
        $meta = $this->get_service_meta($post->ID);
        
        ?>
        <div class="teznevisan-service-meta">
            <div class="meta-tabs-container">
                <!-- Tab Navigation -->
                <nav class="meta-nav-tabs">
                    <button type="button" class="meta-tab-btn active" data-tab="basic">
                        <i class="fas fa-info-circle"></i> تنظیمات پایه
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="hero">
                        <i class="fas fa-star"></i> بخش هیرو
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="content">
                        <i class="fas fa-file-alt"></i> محتوا
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="pricing">
                        <i class="fas fa-dollar-sign"></i> قیمت‌گذاری
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="features">
                        <i class="fas fa-list"></i> ویژگی‌ها
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="process">
                        <i class="fas fa-cogs"></i> فرآیند کار
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="faq">
                        <i class="fas fa-question-circle"></i> سوالات متداول
                    </button>
                    <button type="button" class="meta-tab-btn" data-tab="related">
                        <i class="fas fa-link"></i> خدمات مرتبط
                    </button>
                </nav>
                
                <!-- Basic Settings Tab -->
                <div class="meta-tab-content active" data-tab="basic">
                    <h3><i class="fas fa-info-circle"></i> تنظیمات پایه خدمت</h3>
                    <table class="form-table">
                        <tr>
                            <th><label for="service_subtitle">زیرعنوان خدمت:</label></th>
                            <td>
                                <input type="text" 
                                       id="service_subtitle" 
                                       name="service_subtitle" 
                                       value="<?php echo esc_attr($meta['service_subtitle']); ?>" 
                                       class="large-text"
                                       placeholder="زیرعنوان کوتاه و جذاب">
                                <p class="description">زیرعنوان که در کارت خدمت نمایش داده می‌شود</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="service_excerpt">خلاصه خدمت:</label></th>
                            <td>
                                <textarea id="service_excerpt" 
                                          name="service_excerpt" 
                                          rows="4" 
                                          class="large-text"
                                          placeholder="خلاصه‌ای از خدمت برای نمایش در لیست خدمات"><?php echo esc_textarea($meta['service_excerpt']); ?></textarea>
                                <p class="description">این متن در صفحه اصلی و فهرست خدمات نمایش داده می‌شود</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Hero Section Tab -->
                <div class="meta-tab-content" data-tab="hero">
                    <h3><i class="fas fa-star"></i> تنظیمات بخش هیرو</h3>
                    <table class="form-table">
                        <tr>
                            <th><label for="hero_headline">عنوان اصلی هیرو:</label></th>
                            <td>
                                <input type="text" 
                                       id="hero_headline" 
                                       name="hero_headline" 
                                       value="<?php echo esc_attr($meta['hero_headline']); ?>" 
                                       class="large-text"
                                       placeholder="عنوان اصلی و جذاب">
                                <p class="description">عنوان اصلی که در بالای صفحه نمایش داده می‌شود</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="hero_description">توضیحات هیرو:</label></th>
                            <td>
                                <textarea id="hero_description" 
                                          name="hero_description" 
                                          rows="4" 
                                          class="large-text"
                                          placeholder="توضیحات تکمیلی و انگیزه‌بخش"><?php echo esc_textarea($meta['hero_description']); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="service_hero_image">تصویر پس‌زمینه:</label></th>
                            <td>
                                <input type="url" 
                                       id="service_hero_image" 
                                       name="service_hero_image" 
                                       value="<?php echo esc_attr($meta['service_hero_image']); ?>" 
                                       class="large-text"
                                       placeholder="https://example.com/image.jpg">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="lottie_animation_url">انیمیشن Lottie:</label></th>
                            <td>
                                <input type="url" 
                                       id="lottie_animation_url" 
                                       name="lottie_animation_url" 
                                       value="<?php echo esc_attr($meta['lottie_animation_url']); ?>" 
                                       class="large-text"
                                       placeholder="https://assets.example.com/animation.json">
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Content Settings Tab -->
                <div class="meta-tab-content" data-tab="content">
                    <h3><i class="fas fa-file-alt"></i> تنظیمات محتوای صفحه</h3>
                    <table class="form-table">
                        <tr>
                            <th><label for="content_title_1">عنوان بخش اول:</label></th>
                            <td>
                                <input type="text" 
                                       id="content_title_1" 
                                       name="content_title_1" 
                                       value="<?php echo esc_attr($meta['content_title_1']); ?>" 
                                       class="large-text"
                                       placeholder="توضیحات خدمت">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="content_title_2">عنوان بخش دوم:</label></th>
                            <td>
                                <input type="text" 
                                       id="content_title_2" 
                                       name="content_title_2" 
                                       value="<?php echo esc_attr($meta['content_title_2']); ?>" 
                                       class="large-text"
                                       placeholder="ویژگی‌های خدمت">
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Pricing Tab -->
                <div class="meta-tab-content" data-tab="pricing">
                    <h3><i class="fas fa-dollar-sign"></i> تنظیمات قیمت و آمار</h3>
                    <table class="form-table">
                        <tr>
                            <th><label>محدوده قیمت:</label></th>
                            <td>
                                <div class="price-range-inputs">
                                    <div class="price-input-group">
                                        <label for="price_range_min">حداقل قیمت (تومان):</label>
                                        <input type="number" 
                                               id="price_range_min" 
                                               name="price_range_min" 
                                               value="<?php echo esc_attr($meta['price_range_min']); ?>" 
                                               placeholder="100000">
                                    </div>
                                    <span>تا</span>
                                    <div class="price-input-group">
                                        <label for="price_range_max">حداکثر قیمت (تومان):</label>
                                        <input type="number" 
                                               id="price_range_max" 
                                               name="price_range_max" 
                                               value="<?php echo esc_attr($meta['price_range_max']); ?>" 
                                               placeholder="500000">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="delivery_time">زمان تحویل:</label></th>
                            <td>
                                <input type="text" 
                                       id="delivery_time" 
                                       name="delivery_time" 
                                       value="<?php echo esc_attr($meta['delivery_time']); ?>" 
                                       class="regular-text"
                                       placeholder="3 تا 7 روز کاری">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="completed_projects">پروژه‌های انجام شده:</label></th>
                            <td>
                                <input type="text" 
                                       id="completed_projects" 
                                       name="completed_projects" 
                                       value="<?php echo esc_attr($meta['completed_projects']); ?>" 
                                       class="regular-text"
                                       placeholder="150+ پروژه">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="satisfaction_rate">درصد رضایت:</label></th>
                            <td>
                                <input type="text" 
                                       id="satisfaction_rate" 
                                       name="satisfaction_rate" 
                                       value="<?php echo esc_attr($meta['satisfaction_rate']); ?>" 
                                       class="regular-text"
                                       placeholder="98%">
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Features Tab -->
                <div class="meta-tab-content" data-tab="features">
                    <h3><i class="fas fa-list"></i> ویژگی‌های خدمت</h3>
                    <div id="features-container">
                        <?php if (!empty($meta['service_features']) && is_array($meta['service_features'])): ?>
                            <?php foreach ($meta['service_features'] as $index => $feature): ?>
                                <div class="dynamic-field-container feature-field">
                                    <div class="dynamic-field-header">
                                        <strong>ویژگی <?php echo $index + 1; ?></strong>
                                        <button type="button" class="remove-field-btn remove-feature">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </div>
                                    <div class="dynamic-field-content">
                                        <div class="field-input-group">
                                            <label>عنوان ویژگی:</label>
                                            <input type="text" 
                                                   name="service_features[<?php echo $index; ?>][title]" 
                                                   value="<?php echo esc_attr($feature['title'] ?? ''); ?>"
                                                   placeholder="عنوان ویژگی">
                                        </div>
                                        <div class="field-input-group">
                                            <label>توضیحات ویژگی:</label>
                                            <textarea name="service_features[<?php echo $index; ?>][description]" 
                                                      placeholder="توضیحات کامل ویژگی"><?php echo esc_textarea($feature['description'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="add-feature" class="add-field-btn">
                        <i class="fas fa-plus"></i> افزودن ویژگی جدید
                    </button>
                </div>
                
                <!-- Process Steps Tab -->
                <div class="meta-tab-content" data-tab="process">
                    <h3><i class="fas fa-cogs"></i> فرآیند انجام کار</h3>
                    <div id="steps-container">
                        <?php if (!empty($meta['process_steps']) && is_array($meta['process_steps'])): ?>
                            <?php foreach ($meta['process_steps'] as $index => $step): ?>
                                <div class="dynamic-field-container step-field">
                                    <div class="dynamic-field-header">
                                        <strong>مرحله <?php echo $index + 1; ?></strong>
                                        <button type="button" class="remove-field-btn remove-step">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </div>
                                    <div class="dynamic-field-content">
                                        <div class="dynamic-field-row">
                                            <div class="step-number"><?php echo $index + 1; ?></div>
                                            <div class="field-input-group">
                                                <label>عنوان مرحله:</label>
                                                <input type="text" 
                                                       name="process_steps[<?php echo $index; ?>][title]" 
                                                       value="<?php echo esc_attr($step['title'] ?? ''); ?>"
                                                       placeholder="عنوان مرحله">
                                            </div>
                                        </div>
                                        <div class="field-input-group">
                                            <label>توضیحات مرحله:</label>
                                            <textarea name="process_steps[<?php echo $index; ?>][description]" 
                                                      placeholder="توضیحات کامل مرحله"><?php echo esc_textarea($step['description'] ?? ''); ?></textarea>
                                        </div>
                                        <div class="field-input-group">
                                            <label>مدت زمان:</label>
                                            <input type="text" 
                                                   name="process_steps[<?php echo $index; ?>][duration]" 
                                                   value="<?php echo esc_attr($step['duration'] ?? ''); ?>"
                                                   placeholder="مثال: 2-3 روز">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="add-step" class="add-field-btn">
                        <i class="fas fa-plus"></i> افزودن مرحله جدید
                    </button>
                </div>
                
                <!-- FAQ Tab -->
                <div class="meta-tab-content" data-tab="faq">
                    <h3><i class="fas fa-question-circle"></i> سوالات متداول</h3>
                    <div id="faq-container">
                        <?php if (!empty($meta['service_faq']) && is_array($meta['service_faq'])): ?>
                            <?php foreach ($meta['service_faq'] as $index => $faq): ?>
                                <div class="dynamic-field-container faq-field">
                                    <div class="dynamic-field-header">
                                        <strong>سوال <?php echo $index + 1; ?></strong>
                                        <button type="button" class="remove-field-btn remove-faq">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </div>
                                    <div class="dynamic-field-content">
                                        <div class="field-input-group">
                                            <label>سوال:</label>
                                            <input type="text" 
                                                   name="service_faq[<?php echo $index; ?>][question]" 
                                                   value="<?php echo esc_attr($faq['question'] ?? $faq['q'] ?? ''); ?>"
                                                   placeholder="سوال متداول">
                                        </div>
                                        <div class="field-input-group">
                                            <label>پاسخ:</label>
                                            <textarea name="service_faq[<?php echo $index; ?>][answer]" 
                                                      placeholder="پاسخ کامل و مفصل"><?php echo esc_textarea($faq['answer'] ?? $faq['a'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="add-faq" class="add-field-btn">
                        <i class="fas fa-plus"></i> افزودن سوال جدید
                    </button>
                </div>
                
                <!-- Related Services Tab -->
                <div class="meta-tab-content" data-tab="related">
                    <h3><i class="fas fa-link"></i> خدمات مرتبط</h3>
                    <p><strong>حداکثر 3 خدمت مرتبط را انتخاب کنید:</strong></p>
                    <?php
                    $all_services = get_posts(array(
                        'post_type' => 'services',
                        'posts_per_page' => -1,
                        'post__not_in' => array($post->ID),
                        'post_status' => 'publish'
                    ));
                    
                    if ($all_services): ?>
                        <div class="related-services-grid">
                            <?php foreach ($all_services as $service): 
                                $is_selected = in_array($service->ID, $meta['related_services']);
                            ?>
                                <label class="related-service-label <?php echo $is_selected ? 'selected' : ''; ?>">
                                    <input type="checkbox" 
                                           name="related_services[]" 
                                           value="<?php echo $service->ID; ?>"
                                           class="related-service-checkbox"
                                           <?php checked($is_selected); ?>>
                                    <?php echo esc_html($service->post_title); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>هیچ خدمت دیگری برای انتخاب وجود ندارد.</p>
                    <?php endif; ?>
                    
                    <table class="form-table" style="margin-top: 20px;">
                        <tr>
                            <th><label for="service_cta_text">متن دکمه سفارش:</label></th>
                            <td>
                                <input type="text" 
                                       id="service_cta_text" 
                                       name="service_cta_text" 
                                       value="<?php echo esc_attr($meta['service_cta_text']); ?>" 
                                       class="regular-text"
                                       placeholder="سفارش این خدمت">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="service_cta_url">لینک دکمه سفارش:</label></th>
                            <td>
                                <input type="url" 
                                       id="service_cta_url" 
                                       name="service_cta_url" 
                                       value="<?php echo esc_attr($meta['service_cta_url']); ?>" 
                                       class="large-text"
                                       placeholder="https://example.com/order">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Get service meta with proper defaults
     */
    private function get_service_meta($post_id) {
        return array(
            // Basic Info
            'service_subtitle' => get_post_meta($post_id, 'service_subtitle', true) ?: '',
            'service_excerpt' => get_post_meta($post_id, 'service_excerpt', true) ?: '',
            
            // Hero Section
            'hero_headline' => get_post_meta($post_id, 'hero_headline', true) ?: '',
            'hero_description' => get_post_meta($post_id, 'hero_description', true) ?: '',
            'service_hero_image' => get_post_meta($post_id, 'service_hero_image', true) ?: '',
            'lottie_animation_url' => get_post_meta($post_id, 'lottie_animation_url', true) ?: '',
            
            // Content Settings
            'content_title_1' => get_post_meta($post_id, 'content_title_1', true) ?: 'توضیحات خدمت',
            'content_title_2' => get_post_meta($post_id, 'content_title_2', true) ?: 'ویژگی‌های خدمت',
            
            // Pricing
            'price_range_min' => get_post_meta($post_id, 'price_range_min', true) ?: '',
            'price_range_max' => get_post_meta($post_id, 'price_range_max', true) ?: '',
            'delivery_time' => get_post_meta($post_id, 'delivery_time', true) ?: '',
            'completed_projects' => get_post_meta($post_id, 'completed_projects', true) ?: '',
            'satisfaction_rate' => get_post_meta($post_id, 'satisfaction_rate', true) ?: '',
            
            // Dynamic Fields
            'service_features' => get_post_meta($post_id, 'service_features', true) ?: array(),
            'process_steps' => get_post_meta($post_id, 'process_steps', true) ?: array(),
            'service_faq' => get_post_meta($post_id, 'service_faq', true) ?: array(),
            'related_services' => get_post_meta($post_id, 'related_services', true) ?: array(),
            
            // CTA
            'service_cta_text' => get_post_meta($post_id, 'service_cta_text', true) ?: 'سفارش این خدمت',
            'service_cta_url' => get_post_meta($post_id, 'service_cta_url', true) ?: '',
        );
    }
    
    /**
     * Save service meta data with proper validation
     */
    public function save_service_meta($post_id) {
        // Security checks
        if (!isset($_POST['teznevisan_service_nonce']) || 
            !wp_verify_nonce($_POST['teznevisan_service_nonce'], 'teznevisan_save_service')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        if (get_post_type($post_id) !== 'services') {
            return;
        }
        
        // Save simple fields
        $simple_fields = array(
            'service_subtitle',
            'service_excerpt',
            'hero_headline',
            'hero_description',
            'service_hero_image',
            'lottie_animation_url',
            'content_title_1',
            'content_title_2',
            'price_range_min',
            'price_range_max',
            'delivery_time',
            'completed_projects',
            'satisfaction_rate',
            'service_cta_text',
            'service_cta_url'
        );
        
        foreach ($simple_fields as $field) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                if (in_array($field, ['service_hero_image', 'lottie_animation_url', 'service_cta_url'])) {
                    $value = esc_url_raw($value);
                } elseif (in_array($field, ['service_excerpt', 'hero_description'])) {
                    $value = sanitize_textarea_field($_POST[$field]);
                } elseif (in_array($field, ['price_range_min', 'price_range_max'])) {
                    $value = intval($_POST[$field]);
                }
                update_post_meta($post_id, $field, $value);
            }
        }
        
        // Save service features
        $service_features = array();
        if (isset($_POST['service_features']) && is_array($_POST['service_features'])) {
            foreach ($_POST['service_features'] as $feature) {
                if (!empty($feature['title'])) {
                    $service_features[] = array(
                        'title' => sanitize_text_field($feature['title']),
                        'description' => sanitize_textarea_field($feature['description'])
                    );
                }
            }
        }
        update_post_meta($post_id, 'service_features', $service_features);
        
        // Save process steps
        $process_steps = array();
        if (isset($_POST['process_steps']) && is_array($_POST['process_steps'])) {
            foreach ($_POST['process_steps'] as $step) {
                if (!empty($step['title'])) {
                    $process_steps[] = array(
                        'title' => sanitize_text_field($step['title']),
                        'description' => sanitize_textarea_field($step['description']),
                        'duration' => sanitize_text_field($step['duration'])
                    );
                }
            }
        }
        update_post_meta($post_id, 'process_steps', $process_steps);
        
        // Save FAQ
        $service_faq = array();
        if (isset($_POST['service_faq']) && is_array($_POST['service_faq'])) {
            foreach ($_POST['service_faq'] as $faq) {
                if (!empty($faq['question'])) {
                    $service_faq[] = array(
                        'question' => sanitize_text_field($faq['question']),
                        'answer' => sanitize_textarea_field($faq['answer']),
                        // Legacy support
                        'q' => sanitize_text_field($faq['question']),
                        'a' => sanitize_textarea_field($faq['answer'])
                    );
                }
            }
        }
        update_post_meta($post_id, 'service_faq', $service_faq);
        
        // Save related services
        $related_services = array();
        if (isset($_POST['related_services']) && is_array($_POST['related_services'])) {
            $related_services = array_map('intval', $_POST['related_services']);
            $related_services = array_slice($related_services, 0, 3); // Limit to 3
        }
        update_post_meta($post_id, 'related_services', $related_services);
        
        // Also save to legacy field for backward compatibility
        update_post_meta($post_id, 'service_related', $related_services);
    }
}

// Initialize the service meta class
new Teznevisan_Service_Meta();
?>
