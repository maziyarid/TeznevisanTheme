<?php get_header(); ?>

<main id="main-content" class="contact-page-main">
    
    <!-- Contact Hero -->
    <section class="contact-hero">
        <div class="hero-animation-bg">
            <div class="animated-circles">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
                <div class="circle circle-4"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="contact-hero-content">
                <div class="hero-text">
                    <h1 class="contact-title">
                        <i class="fas fa-comments"></i>
                        تماس با ما
                    </h1>
                    <p class="contact-subtitle">
                        ما همیشه آماده پاسخگویی به سوالات شما هستیم
                    </p>
                    <p class="contact-description">
                        تیم پشتیبانی ۲۴ ساعته ما آماده ارائه مشاوره رایگان و پاسخگویی 
                        به تمام سوالات شما در زمینه خدمات نگارش دانشگاهی است.
                    </p>
                    
                    <div class="response-guarantee">
                        <div class="guarantee-item">
                            <i class="fas fa-clock"></i>
                            <span>پاسخ طی ۲ ساعت</span>
                        </div>
                        <div class="guarantee-item">
                            <i class="fas fa-phone"></i>
                            <span>پشتیبانی ۲۴/۷</span>
                        </div>
                        <div class="guarantee-item">
                            <i class="fas fa-gift"></i>
                            <span>مشاوره کاملاً رایگان</span>
                        </div>
                    </div>
                </div>
                
                <div class="hero-contact-preview">
                    <div class="contact-preview-card">
                        <div class="preview-header">
                            <h3>راه‌های ارتباطی</h3>
                            <div class="online-status">
                                <span class="status-dot"></span>
                                <span>آنلاین</span>
                            </div>
                        </div>
                        
                        <div class="preview-methods">
                            <div class="preview-method">
                                <div class="method-icon phone-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-details">
                                    <strong>تماس مستقیم</strong>
                                    <span><?php echo esc_html(get_theme_mod('phone_number', '09162352304')); ?></span>
                                </div>
                                <div class="method-status online"></div>
                            </div>
                            
                            <div class="preview-method">
                                <div class="method-icon whatsapp-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="method-details">
                                    <strong>واتساپ</strong>
                                    <span>پیام فوری</span>
                                </div>
                                <div class="method-status online"></div>
                            </div>
                            
                            <div class="preview-method">
                                <div class="method-icon email-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="method-details">
                                    <strong>ایمیل</strong>
                                    <span><?php echo esc_html(get_theme_mod('email_address', 'setinco@gmail.com')); ?></span>
                                </div>
                                <div class="method-status online"></div>
                            </div>
                        </div>
                        
                        <div class="preview-footer">
                            <div class="working-hours">
                                <i class="fas fa-clock"></i>
                                <span><?php echo esc_html(get_theme_mod('working_hours', 'شنبه تا پنج‌شنبه: ۸ تا ۲۰')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Contact Section -->
    <section class="main-contact-section">
        <div class="container">
            <div class="contact-layout">
                
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <h2>
                            <i class="fas fa-paper-plane"></i>
                            ارسال پیام
                        </h2>
                        <p>فرم زیر را تکمیل کنید تا در اسرع وقت با شما تماس بگیریم</p>
                    </div>
                    
                    <form class="contact-form" id="main-contact-form">
                        <div class="form-step active" data-step="1">
                            <h3 class="step-title">
                                <span class="step-number">۱</span>
                                اطلاعات تماس
                            </h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_name">
                                        <i class="fas fa-user"></i>
                                        نام و نام خانوادگی
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" id="contact_name" name="name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact_phone">
                                        <i class="fas fa-phone"></i>
                                        شماره تماس
                                        <span class="required">*</span>
                                    </label>
                                    <input type="tel" id="contact_phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_email">
                                    <i class="fas fa-envelope"></i>
                                    آدرس ایمیل
                                    <span class="required">*</span>
                                </label>
                                <input type="email" id="contact_email" name="email" required>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-next" onclick="nextStep()">
                                    بعدی
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-step" data-step="2">
                            <h3 class="step-title">
                                <span class="step-number">۲</span>
                                نوع درخواست
                            </h3>
                            
                            <div class="service-types">
                                <label class="service-type-option">
                                    <input type="radio" name="service_type" value="thesis" required>
                                    <div class="option-card">
                                        <div class="option-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="option-content">
                                            <h4>نگارش پایان‌نامه</h4>
                                            <p>کارشناسی، ارشد، دکتری</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="service-type-option">
                                    <input type="radio" name="service_type" value="article">
                                    <div class="option-card">
                                        <div class="option-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        <div class="option-content">
                                            <h4>نگارش مقاله</h4>
                                            <p>ISI، ISC، کنفرانس</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="service-type-option">
                                    <input type="radio" name="service_type" value="translation">
                                    <div class="option-card">
                                        <div class="option-icon">
                                            <i class="fas fa-language"></i>
                                        </div>
                                        <div class="option-content">
                                            <h4>ترجمه تخصصی</h4>
                                            <p>متون علمی و تخصصی</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="service-type-option">
                                    <input type="radio" name="service_type" value="editing">
                                    <div class="option-card">
                                        <div class="option-icon">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="option-content">
                                            <h4>ویرایش</h4>
                                            <p>بهبود متون موجود</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="service-type-option">
                                    <input type="radio" name="service_type" value="consultation">
                                    <div class="option-card">
                                        <div class="option-icon">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <div class="option-content">
                                            <h4>مشاوره</h4>
                                            <p>راهنمایی و مشاوره</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="service-type-option">
                                    <input type="radio" name="service_type" value="other">
                                    <div class="option-card">
                                        <div class="option-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <div class="option-content">
                                            <h4>سایر موارد</h4>
                                            <p>خدمات دیگر</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev" onclick="prevStep()">
                                    <i class="fas fa-arrow-right"></i>
                                    قبلی
                                </button>
                                <button type="button" class="btn-next" onclick="nextStep()">
                                    بعدی
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-step" data-step="3">
                            <h3 class="step-title">
                                <span class="step-number">۳</span>
                                جزئیات درخواست
                            </h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_subject">
                                        <i class="fas fa-tag"></i>
                                        موضوع پیام
                                    </label>
                                    <input type="text" id="contact_subject" name="subject" placeholder="موضوع درخواست خود را وارد کنید">
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact_urgency">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        میزان اضطراری
                                    </label>
                                    <select id="contact_urgency" name="urgency">
                                        <option value="normal">عادی</option>
                                        <option value="urgent">فوری</option>
                                        <option value="emergency">اضطراری</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_message">
                                    <i class="fas fa-comment-alt"></i>
                                    پیام شما
                                    <span class="required">*</span>
                                </label>
                                <textarea id="contact_message" name="message" rows="6" placeholder="توضیح کاملی از نیاز خود ارائه دهید..." required></textarea>
                                <div class="textarea-footer">
                                    <div class="char-counter">
                                        <span class="current-chars">0</span>/<span class="max-chars">1000</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="privacy_agreement" required>
                                    <span class="checkmark"></span>
                                    <span class="label-text">
                                        با <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>" target="_blank">شرایط و قوانین</a> موافقم
                                    </span>
                                </label>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev" onclick="prevStep()">
                                    <i class="fas fa-arrow-right"></i>
                                    قبلی
                                </button>
                                <button type="submit" class="btn-submit">
                                    <span class="btn-content">
                                        <i class="fas fa-paper-plane"></i>
                                        ارسال پیام
                                    </span>
                                    <span class="btn-loading">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        در حال ارسال...
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Progress Indicator -->
                        <div class="form-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" id="form-progress-fill"></div>
                            </div>
                            <div class="progress-steps">
                                <div class="progress-step active" data-step="1">
                                    <span>اطلاعات تماس</span>
                                </div>
                                <div class="progress-step" data-step="2">
                                    <span>نوع درخواست</span>
                                </div>
                                <div class="progress-step" data-step="3">
                                    <span>جزئیات</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Contact Information -->
                <div class="contact-info-wrapper">
                    
                    <!-- Direct Contact Methods -->
                    <div class="contact-info-card">
                        <div class="info-header">
                            <h3>
                                <i class="fas fa-address-book"></i>
                                اطلاعات تماس
                            </h3>
                        </div>
                        
                        <div class="contact-methods-list">
                            <div class="contact-method-detailed">
                                <div class="method-icon-large phone-large">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-content">
                                    <h4>تماس تلفنی</h4>
                                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" class="contact-link">
                                        <?php echo esc_html(get_theme_mod('phone_number', '09162352304')); ?>
                                    </a>
                                    <p>پاسخگویی ۲۴ ساعته</p>
                                    <div class="contact-action">
                                        <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" class="action-btn call-now">
                                            <i class="fas fa-phone-alt"></i>
                                            تماس الان
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-method-detailed">
                                <div class="method-icon-large email-large">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="method-content">
                                    <h4>پست الکترونیک</h4>
                                    <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address', 'setinco@gmail.com')); ?>" class="contact-link">
                                        <?php echo esc_html(get_theme_mod('email_address', 'setinco@gmail.com')); ?>
                                    </a>
                                    <p>پاسخ طی ۲ ساعت</p>
                                    <div class="contact-action">
                                        <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address', 'setinco@gmail.com')); ?>?subject=درخواست مشاوره" class="action-btn email-now">
                                            <i class="fas fa-paper-plane"></i>
                                            ارسال ایمیل
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-method-detailed">
                                <div class="method-icon-large address-large">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="method-content">
                                    <h4>آدرس دفتر</h4>
                                    <span class="contact-address">
                                        <?php echo esc_html(get_theme_mod('address', 'ایران، یزد، خیابان مطهری')); ?>
                                    </span>
                                    <p>ملاقات با هماهنگی قبلی</p>
                                    <div class="contact-action">
                                        <a href="https://maps.google.com/?q=<?php echo urlencode(get_theme_mod('address', 'ایران، یزد، خیابان مطهری')); ?>" 
                                           target="_blank" class="action-btn view-map">
                                            <i class="fas fa-map"></i>
                                            مشاهده نقشه
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-method-detailed">
                                <div class="method-icon-large hours-large">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="method-content">
                                    <h4>ساعات کاری</h4>
                                    <span class="working-hours-text">
                                        <?php echo esc_html(get_theme_mod('working_hours', 'شنبه تا پنج‌شنبه: ۸ تا ۲۰')); ?>
                                    </span>
                                    <p id="current-status">در حال بررسی وضعیت...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Contact -->
                    <div class="social-contact-card">
                        <div class="info-header">
                            <h3>
                                <i class="fas fa-share-alt"></i>
                                شبکه‌های اجتماعی
                            </h3>
                        </div>
                        
                        <div class="social-methods">
                            <?php if (get_theme_mod('whatsapp_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('whatsapp_url')); ?>" 
                                   class="social-method whatsapp-social" target="_blank">
                                    <div class="social-icon">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div class="social-info">
                                        <strong>واتساپ</strong>
                                        <span>پیام فوری</span>
                                    </div>
                                    <div class="social-arrow">
                                        <i class="fas fa-external-link-alt"></i>
                                    </div>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('telegram_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('telegram_url')); ?>" 
                                   class="social-method telegram-social" target="_blank">
                                    <div class="social-icon">
                                        <i class="fab fa-telegram"></i>
                                    </div>
                                    <div class="social-info">
                                        <strong>تلگرام</strong>
                                        <span>کانال تلگرام</span>
                                    </div>
                                    <div class="social-arrow">
                                        <i class="fas fa-external-link-alt"></i>
                                    </div>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('instagram_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>" 
                                   class="social-method instagram-social" target="_blank">
                                    <div class="social-icon">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                    <div class="social-info">
                                        <strong>اینستاگرام</strong>
                                        <span>صفحه اینستاگرام</span>
                                    </div>
                                    <div class="social-arrow">
                                        <i class="fas fa-external-link-alt"></i>
                                    </div>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('linkedin_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>" 
                                   class="social-method linkedin-social" target="_blank">
                                    <div class="social-icon">
                                        <i class="fab fa-linkedin"></i>
                                    </div>
                                    <div class="social-info">
                                        <strong>لینکدین</strong>
                                        <span>پروفایل حرفه‌ای</span>
                                    </div>
                                    <div class="social-arrow">
                                        <i class="fas fa-external-link-alt"></i>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Emergency Contact -->
                    <div class="emergency-contact-card">
                        <div class="emergency-header">
                            <h3>
                                <i class="fas fa-exclamation-circle"></i>
                                تماس اضطراری
                            </h3>
                            <p>برای موارد فوری و ضروری</p>
                        </div>
                        
                        <div class="emergency-methods">
                            <a href="https://wa.me/<?php echo esc_attr(str_replace(['+', ' ', '-'], '', get_theme_mod('phone_number', '09162352304'))); ?>?text=<?php echo urlencode('اضطراری: نیاز فوری به مشاوره دارم'); ?>" 
                               class="emergency-btn whatsapp-emergency" target="_blank">
                                <div class="emergency-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="emergency-text">
                                    <strong>واتساپ فوری</strong>
                                    <span>پاسخ در کمتر از ۱۰ دقیقه</span>
                                </div>
                            </a>
                            
                            <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" 
                               class="emergency-btn call-emergency">
                                <div class="emergency-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="emergency-text">
                                    <strong>تماس اضطراری</strong>
                                    <span>پاسخگویی فوری</span>
                                </div>
                            </a>
                        </div>
                        
                        <div class="emergency-note">
                            <i class="fas fa-info-circle"></i>
                            <span>برای موارد اضطراری از این راه‌ها استفاده کنید</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="contact-faq-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">سوالات متداول</h2>
                <p class="section-description">پاسخ سوالات رایج در مورد خدمات و نحوه همکاری</p>
            </div>
            
            <div class="faq-container">
                <div class="faq-categories">
                    <button class="faq-category-btn active" data-category="general">عمومی</button>
                    <button class="faq-category-btn" data-category="services">خدمات</button>
                    <button class="faq-category-btn" data-category="pricing">قیمت‌ها</button>
                    <button class="faq-category-btn" data-category="process">فرآیند کار</button>
                </div>
                
                <div class="faq-content">
                    <div class="faq-category-content active" data-category="general">
                        <div class="faq-accordion">
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    چگونه می‌توانم با شما تماس بگیرم؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                                                <div class="faq-answer">
                                    <p>شما می‌توانید از طریق تلفن، واتساپ، ایمیل، تلگرام و یا فرم تماس سایت با ما در ارتباط باشید. تیم پشتیبانی ما ۲۴ ساعته آماده پاسخگویی است.</p>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    زمان پاسخگویی شما چقدر است؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>ما متعهد هستیم که طی حداکثر ۲ ساعت به تمام پیام‌ها و درخواست‌های شما پاسخ دهیم. برای موارد اضطراری، پاسخگویی در کمتر از ۳۰ دقیقه انجام می‌شود.</p>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    آیا مشاوره اولیه رایگان است؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>بله، مشاوره اولیه کاملاً رایگان است. در این جلسه، نیازهای شما بررسی شده و بهترین راهکارها ارائه می‌شود.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-category-content" data-category="services">
                        <div class="faq-accordion">
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    چه خدماتی ارائه می‌دهید؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>خدمات ما شامل نگارش پایان‌نامه، مقاله علمی، پروپوزال، ترجمه تخصصی، ویرایش، تحلیل آماری و مشاوره تحصیلی است.</p>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    در چه رشته‌هایی فعالیت دارید؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>ما در تمام رشته‌های علمی شامل مهندسی، پزشکی، علوم انسانی، علوم پایه، مدیریت، هنر و کشاورزی خدمات ارائه می‌دهیم.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-category-content" data-category="pricing">
                        <div class="faq-accordion">
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    نحوه محاسبه قیمت چگونه است؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>قیمت بر اساس نوع خدمت، حجم کار، مقطع تحصیلی، پیچیدگی موضوع و زمان تحویل محاسبه می‌شود. برآورد اولیه رایگان ارائه می‌شود.</p>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    آیا امکان پرداخت اقساطی وجود دارد؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>بله، برای پروژه‌های بزرگ امکان پرداخت به صورت اقساط و در مراحل مختلف کار فراهم است.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-category-content" data-category="process">
                        <div class="faq-accordion">
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    فرآیند همکاری چگونه است؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>فرآیند شامل مشاوره اولیه، تعیین جزئیات پروژه، انتخاب نویسنده متخصص، شروع کار، بازنگری و تحویل نهایی است.</p>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleContactFAQ(this)">
                                    زمان تحویل چقدر است؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>زمان تحویل بسته به نوع و حجم پروژه متفاوت است. برای پایان‌نامه ۱۰-۳۰ روز، مقاله ۵-۱۵ روز و ترجمه ۳-۱۰ روز کاری.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Contact Page Comprehensive Styles */
.contact-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

/* Contact Hero */
.contact-hero {
    background: linear-gradient(135deg, #4ECDC4 0%, #45a29e 50%, #3d9970 100%);
    color: white;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.hero-animation-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.1;
}

.animated-circles {
    position: absolute;
    width: 100%;
    height: 100%;
}

.circle {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    animation: circleFloat 10s ease-in-out infinite;
}

.circle-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.circle-2 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 70%;
    animation-delay: 2.5s;
}

.circle-3 {
    width: 100px;
    height: 100px;
    top: 80%;
    right: 20%;
    animation-delay: 5s;
}

.circle-4 {
    width: 120px;
    height: 120px;
    top: 30%;
    right: 50%;
    animation-delay: 7.5s;
}

@keyframes circleFloat {
    0%, 100% { transform: translateY(0px) scale(1); opacity: 0.3; }
    25% { transform: translateY(-40px) scale(1.1); opacity: 0.5; }
    50% { transform: translateY(-80px) scale(0.9); opacity: 0.7; }
    75% { transform: translateY(-40px) scale(1.05); opacity: 0.4; }
}

.contact-hero-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.contact-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-family: inherit;
}

.contact-title i {
    font-size: 0.8em;
    opacity: 0.9;
}

.contact-subtitle {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    opacity: 0.95;
    font-family: inherit;
}

.contact-description {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 2rem;
    opacity: 0.9;
    text-align: justify;
    font-family: inherit;
}

.response-guarantee {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.response-guarantee .guarantee-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.response-guarantee .guarantee-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
}

.response-guarantee .guarantee-item i {
    font-size: 1.2rem;
}

.hero-contact-preview {
    position: relative;
}

.contact-preview-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.preview-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 700;
    font-family: inherit;
}

.online-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.status-dot {
    width: 10px;
    height: 10px;
    background: #28a745;
    border-radius: 50%;
    animation: statusPulse 2s infinite;
}

@keyframes statusPulse {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.2); }
    100% { opacity: 1; transform: scale(1); }
}

.preview-methods {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.preview-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.preview-method:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-3px);
}

.preview-method .method-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.phone-icon { background: #007bff; }
.whatsapp-icon { background: #25d366; }
.email-icon { background: #dc3545; }

.method-details {
    flex: 1;
}

.method-details strong {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.method-details span {
    font-size: 0.85rem;
    opacity: 0.8;
    font-family: inherit;
}

.preview-method .method-status {
    width: 20px;
    height: 20px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-method .method-status::after {
    content: '✓';
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
}

.preview-footer {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.working-hours {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    opacity: 0.9;
    font-family: inherit;
}

/* Main Contact Section */
.main-contact-section {
    padding: 5rem 0;
}

.contact-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Contact Form */
.contact-form-wrapper {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.form-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 2.5rem 2rem;
    text-align: center;
}

.form-header h2 {
    margin: 0 0 0.75rem 0;
    font-size: 1.8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-family: inherit;
}

.form-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 1rem;
    line-height: 1.5;
    font-family: inherit;
}

.contact-form {
    padding: 2rem;
    position: relative;
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
    animation: stepSlideIn 0.4s ease;
}

@keyframes stepSlideIn {
    0% { opacity: 0; transform: translateX(30px); }
    100% { opacity: 1; transform: translateX(0); }
}

.step-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-family: inherit;
}

.step-number {
    width: 35px;
    height: 35px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    font-family: inherit;
}

.form-group label i {
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

.required {
    color: #dc3545;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(31, 165, 71, 0.1);
    outline: none;
    background: var(--bg-main);
    transform: translateY(-1px);
}

.service-types {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.service-type-option input[type="radio"] {
    display: none;
}

.option-card {
    background: var(--bg-secondary);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.service-type-option input[type="radio"]:checked + .option-card {
    border-color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.15);
}

.option-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.1);
}

.option-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.service-type-option input[type="radio"]:checked + .option-card .option-icon {
    background: var(--primary-dark);
    transform: scale(1.1);
}

.option-content h4 {
    margin: 0;
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 600;
    font-family: inherit;
}

.option-content p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-family: inherit;
}

.textarea-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
}

.char-counter {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: inherit;
}

.current-chars {
    color: var(--primary-color);
    font-weight: 600;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-family: inherit;
}

.checkbox-label input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.checkbox-label input[type="checkbox"]:checked + .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.checkbox-label input[type="checkbox"]:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 0.8rem;
    font-weight: 700;
}

.label-text {
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.4;
    font-family: inherit;
}

.label-text a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.form-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
}

.btn-prev,
.btn-next,
.btn-submit {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.btn-prev {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 2px solid var(--border-color);
}

.btn-next {
    background: var(--primary-color);
    color: white;
    border: 2px solid var(--primary-color);
}

.btn-submit {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 1.25rem 2.5rem;
}

.btn-prev:hover {
    background: var(--bg-main);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-next:hover,
.btn-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
}

.btn-submit:hover {
    background: linear-gradient(135deg, var(--primary-dark), #0f5d2a);
}

.btn-content,
.btn-loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.btn-submit.loading .btn-content {
    opacity: 0;
}

.btn-submit.loading .btn-loading {
    opacity: 1;
}

.form-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
}

.progress-bar {
    height: 4px;
    background: var(--bg-secondary);
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    width: 33.33%;
    transition: width 0.3s ease;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    padding: 1rem 2rem;
    background: var(--bg-secondary);
}

.progress-step {
    text-align: center;
    font-size: 0.8rem;
    color: var(--text-muted);
    opacity: 0.5;
    transition: all 0.3s ease;
    font-family: inherit;
}

.progress-step.active {
    color: var(--primary-color);
    opacity: 1;
    font-weight: 600;
}

/* Contact Information */
.contact-info-wrapper {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.contact-info-card,
.social-contact-card,
.emergency-contact-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
}

.info-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.5rem 2rem;
    text-align: center;
}

.info-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-family: inherit;
}

.contact-methods-list {
    padding: 2rem;
}

.contact-method-detailed {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.contact-method-detailed::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: var(--primary-color);
    transition: width 0.3s ease;
}

.contact-method-detailed:hover::before {
    width: 4px;
}

.contact-method-detailed:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateX(-5px);
}

.contact-method-detailed:last-child {
    margin-bottom: 0;
}

.method-icon-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.phone-large { background: linear-gradient(135deg, #007bff, #0056b3); }
.email-large { background: linear-gradient(135deg, #dc3545, #c82333); }
.address-large { background: linear-gradient(135deg, #28a745, #1e7e34); }
.hours-large { background: linear-gradient(135deg, #ffc107, #e0a800); color: #1a1a1a; }

.method-content {
    flex: 1;
}

.method-content h4 {
    margin: 0 0 0.75rem 0;
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 700;
    font-family: inherit;
}

.contact-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.3s ease;
    font-family: inherit;
}

.contact-link:hover {
    color: var(--primary-dark);
}

.contact-address,
.working-hours-text {
    color: var(--text-primary);
    font-weight: 500;
    display: block;
    margin-bottom: 0.5rem;
    font-family: inherit;
}

.method-content p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-family: inherit;
}

.contact-action {
    margin-top: 1rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.call-now {
    background: #007bff;
    color: white;
}

.email-now {
    background: #dc3545;
    color: white;
}

.view-map {
    background: #28a745;
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    color: white;
}

/* Social Contact */
.social-methods {
    padding: 1.5rem;
}

.social-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.social-method:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateX(-3px);
    color: var(--text-primary);
}

.social-method:last-child {
    margin-bottom: 0;
}

.social-method .social-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.whatsapp-social .social-icon { background: #25d366; }
.telegram-social .social-icon { background: #0088cc; }
.instagram-social .social-icon { background: #e4405f; }
.linkedin-social .social-icon { background: #0077b5; }

.social-info {
    flex: 1;
}

.social-info strong {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.social-info span {
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.social-arrow {
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    color: var(--primary-color);
}

.social-method:hover .social-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Emergency Contact */
.emergency-contact-card {
    border: 2px solid #FF6B6B;
    box-shadow: 0 6px 25px rgba(255, 107, 107, 0.2);
    animation: emergencyPulse 3s infinite;
}

@keyframes emergencyPulse {
    0%, 100% { 
        box-shadow: 0 6px 25px rgba(255, 107, 107, 0.2); 
        transform: scale(1);
    }
    50% { 
        box-shadow: 0 10px 35px rgba(255, 107, 107, 0.4); 
        transform: scale(1.02);
    }
}

.emergency-header {
    background: linear-gradient(135deg, #FF6B6B, #FF4757);
    color: white;
    padding: 1.5rem 2rem;
    text-align: center;
}

.emergency-header h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-family: inherit;
}

.emergency-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
    font-family: inherit;
}

.emergency-methods {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.emergency-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.whatsapp-emergency {
    background: linear-gradient(135deg, #25d366, #20b358);
    color: white;
}

.call-emergency {
    background: linear-gradient(135deg, #FF6B6B, #FF4757);
    color: white;
}

.emergency-btn:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    color: white;
}

.emergency-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.emergency-text {
    flex: 1;
}

.emergency-text strong {
    display: block;
    font-weight: 700;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.emergency-text span {
    font-size: 0.85rem;
    opacity: 0.9;
    font-family: inherit;
}

.emergency-note {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #FFF3CD;
    border: 1px solid #FFEAA7;
    border-radius: 8px;
    padding: 1rem;
    margin: 1rem 1.5rem;
    color: #856404;
    font-size: 0.85rem;
    font-family: inherit;
}

/* Contact FAQ */
.contact-faq-section {
    background: var(--bg-main);
    padding: 5rem 0;
}

.faq-container {
    max-width: 1000px;
    margin: 3rem auto 0;
}

.faq-categories {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.faq-category-btn {
    padding: 0.75rem 1.5rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.faq-category-btn:hover,
.faq-category-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.faq-category-content {
    display: none;
}

.faq-category-content.active {
    display: block;
    animation: faqSlideIn 0.4s ease;
}

@keyframes faqSlideIn {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.faq-accordion {
    max-width: 800px;
    margin: 0 auto;
}

.faq-item {
    background: var(--bg-secondary);
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.1);
}

.faq-item:last-child {
    margin-bottom: 0;
}

.faq-question {
    width: 100%;
    padding: 1.5rem 2rem;
    background: transparent;
    border: none;
    text-align: right;
    font-family: inherit;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.faq-question:hover {
    color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
}

.faq-question i {
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.faq-question.active i {
    transform: rotate(180deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: all 0.4s ease;
    background: var(--bg-main);
}

.faq-answer.active {
    max-height: 200px;
    padding: 1.5rem 2rem;
}

.faq-answer p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.7;
    font-family: inherit;
}

/* Responsive Contact */
@media (max-width: 1200px) {
    .contact-hero-content,
    .contact-layout {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
    }
    
    .contact-hero-content .hero-text {
        text-align: center;
    }
    
    .contact-description {
        text-align: center;
    }
}

@media (max-width: 1024px) {
    .response-guarantee {
        justify-content: center;
    }
    
    .service-types {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    }
    
    .faq-categories {
        gap: 0.5rem;
    }
}

@media (max-width: 768px) {
    .contact-hero {
        padding: 3rem 0;
    }
    
    .contact-title {
        font-size: 2.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .contact-subtitle {
        font-size: 1.2rem;
    }
    
    .contact-description {
        font-size: 1rem;
    }
    
    .response-guarantee {
        flex-direction: column;
        align-items: center;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .service-types {
        grid-template-columns: 1fr;
    }
    
    .form-navigation {
        flex-direction: column;
        gap: 1rem;
    }
    
    .contact-method-detailed {
        flex-direction: column;
        text-align: center;
    }
    
    .emergency-methods {
        gap: 0.75rem;
    }
    
    .faq-categories {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .contact-hero {
        padding: 2rem 0;
    }
    
    .contact-title {
        font-size: 2rem;
    }
    
    .contact-form {
        padding: 1.5rem;
    }
    
    .form-header {
        padding: 2rem 1.5rem;
    }
    
    .contact-methods-list {
        padding: 1.5rem;
    }
    
    .contact-method-detailed {
        padding: 1rem;
    }
    
    .method-icon-large {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .progress-steps {
        padding: 0.75rem 1rem;
    }
    
    .progress-step {
        font-size: 0.7rem;
    }
    
    .btn-prev,
    .btn-next,
    .btn-submit {
        padding: 1rem 1.5rem;
        font-size: 0.9rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    
    // Form step navigation
    window.nextStep = function() {
        if (currentStep < totalSteps) {
            // Validate current step
            const currentStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
            const requiredInputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            
            let isValid = true;
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#dc3545';
                    input.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
                } else {
                    input.style.borderColor = '#28a745';
                    input.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.1)';
                }
            });
            
            if (isValid) {
                currentStep++;
                updateFormStep();
            } else {
                alert('لطفاً تمام فیلدهای ضروری را تکمیل کنید.');
            }
        }
    };
    
    window.prevStep = function() {
        if (currentStep > 1) {
            currentStep--;
            updateFormStep();
        }
    };
    
    function updateFormStep() {
        // Update step visibility
        document.querySelectorAll('.form-step').forEach(step => {
            step.classList.remove('active');
        });
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
        
        // Update progress
        const progressFill = document.getElementById('form-progress-fill');
        const progressPercent = (currentStep / totalSteps) * 100;
        progressFill.style.width = progressPercent + '%';
        
        // Update progress steps
        document.querySelectorAll('.progress-step').forEach((step, index) => {
            step.classList.toggle('active', index < currentStep);
        });
    }
    
    // Form submission
    const contactForm = document.getElementById('main-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.btn-submit');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Collect form data
            const formData = new FormData(this);
            const contactData = {
                name: formData.get('name'),
                phone: formData.get('phone'),
                email: formData.get('email'),
                service_type: formData.get('service_type'),
                subject: formData.get('subject'),
                urgency: formData.get('urgency'),
                message: formData.get('message')
            };
            
            // Simulate form submission
            setTimeout(() => {
                alert('پیام شما با موفقیت ارسال شد! به زودی با شما تماس خواهیم گرفت.');
                this.reset();
                currentStep = 1;
                updateFormStep();
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                
                console.log('Contact form submitted:', contactData);
            }, 2500);
        });
    }
    
    // Character counter for message textarea
    const messageTextarea = document.getElementById('contact_message');
    const currentChars = document.querySelector('.current-chars');
    
    if (messageTextarea && currentChars) {
        messageTextarea.addEventListener('input', function() {
            const count = this.value.length;
            currentChars.textContent = count;
            
            if (count > 800) {
                currentChars.style.color = '#dc3545';
            } else if (count > 600) {
                currentChars.style.color = '#ffc107';
            } else {
                currentChars.style.color = 'var(--primary-color)';
            }
        });
    }
    
    // FAQ functionality
    window.toggleContactFAQ = function(button) {
        const faqItem = button.closest('.faq-item');
        const answer = faqItem.querySelector('.faq-answer');
        const isActive = answer.classList.contains('active');
        
        // Close all other FAQs in the same category
        const currentCategory = button.closest('.faq-category-content');
        currentCategory.querySelectorAll('.faq-answer').forEach(el => el.classList.remove('active'));
        currentCategory.querySelectorAll('.faq-question').forEach(el => el.classList.remove('active'));
        
        if (!isActive) {
            answer.classList.add('active');
            button.classList.add('active');
        }
    };
    
    // FAQ categories switching
    const faqCategoryBtns = document.querySelectorAll('.faq-category-btn');
    const faqCategoryContents = document.querySelectorAll('.faq-category-content');
    
    faqCategoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update buttons
            faqCategoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update content
            faqCategoryContents.forEach(content => {
                content.classList.remove('active');
                if (content.getAttribute('data-category') === category) {
                    content.classList.add('active');
                }
            });
        });
    });
    
    // Business hours status checker
    function updateBusinessStatus() {
        const statusElement = document.getElementById('current-status');
        if (!statusElement) return;
        
        const now = new Date();
        const hour = now.getHours();
        const day = now.getDay();
        
        // Saturday(6) to Thursday(4), 8 AM to 8 PM
        const isBusinessHours = (day >= 6 || day <= 4) && hour >= 8 && hour <= 20;
        
        if (isBusinessHours) {
            statusElement.textContent = 'اکنون باز هستیم';
            statusElement.style.color = '#28a745';
            statusElement.style.fontWeight = '600';
        } else {
            const nextOpen = new Date();
            if (day === 5) { // Friday
                nextOpen.setDate(nextOpen.getDate() + 1); // Saturday
                nextOpen.setHours(8, 0, 0, 0);
            } else if (hour < 8) {
                nextOpen.setHours(8, 0, 0, 0);
            } else {
                nextOpen.setDate(nextOpen.getDate() + 1);
                nextOpen.setHours(8, 0, 0, 0);
            }
            
            statusElement.textContent = 'اکنون بسته - فردا ساعت ۸ باز می‌شویم';
            statusElement.style.color = '#dc3545';
            statusElement.style.fontWeight = '600';
        }
    }
    
    updateBusinessStatus();
    setInterval(updateBusinessStatus, 60000); // Update every minute
    
    // Animation observer
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Animate contact methods
    document.querySelectorAll('.contact-method-detailed, .social-method, .emergency-btn').forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(el);
    });
    
    // Copy contact info to clipboard
    document.querySelectorAll('.contact-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (e.ctrlKey || e.metaKey) {
                e.preventDefault();
                const text = this.textContent.trim();
                navigator.clipboard.writeText(text).then(() => {
                    const originalText = this.textContent;
                    this.textContent = 'کپی شد!';
                    this.style.color = '#28a745';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                });
            }
        });
    });
    
    // Form field enhancements
    const formInputs = document.querySelectorAll('.contact-form input, .contact-form select, .contact-form textarea');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#28a745';
                this.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.1)';
            }
        });
        
        input.addEventListener('input', function() {
            // Reset error styling on input
            if (this.style.borderColor === 'rgb(220, 53, 69)') {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            }
        });
    });
    
    // Service type selection animation
    const serviceOptions = document.querySelectorAll('.service-type-option');
    serviceOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.querySelector('input').checked) {
                this.querySelector('.option-card').style.animation = 'optionSelect 0.4s ease';
            }
        });
    });
    
    // Emergency contact attention animation
    const emergencyCard = document.querySelector('.emergency-contact-card');
    if (emergencyCard) {
        setInterval(() => {
            emergencyCard.style.animation = 'none';
            setTimeout(() => {
                emergencyCard.style.animation = 'emergencyPulse 3s infinite';
            }, 10);
        }, 10000); // Every 10 seconds
    }
});

// Additional CSS animations
const contactStyles = document.createElement('style');
contactStyles.textContent = `
@keyframes optionSelect {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.contact-preview-card {
    animation: previewCardFloat 4s ease-in-out infinite;
}

@keyframes previewCardFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.method-icon-large {
    animation: methodIconPulse 3s ease-in-out infinite;
}

@keyframes methodIconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3); }
}

.emergency-btn {
    animation: emergencyBtnGlow 2s ease-in-out infinite;
}

@keyframes emergencyBtnGlow {
    0%, 100% { box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); }
    50% { box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4), 0 0 20px rgba(255, 255, 255, 0.3); }
}
`;
document.head.appendChild(contactStyles);
</script>

<?php get_footer(); ?>