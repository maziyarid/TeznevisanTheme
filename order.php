<?php
/*
Template Name: Order Page
*/
get_header(); ?>

<main id="main-content" class="order-page-main">
    
    <!-- Order Hero Section -->
    <section class="order-hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>ثبت سفارش خدمات نگارش</h1>
                    <p>با تکمیل فرم زیر، درخواست خود را ثبت کنید و کارشناسان ما در اسرع وقت با شما تماس خواهند گرفت</p>
                    
                    <div class="trust-indicators">
                        <div class="trust-item">
                            <i class="fas fa-shield-check"></i>
                            <span>تضمین کیفیت</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-clock"></i>
                            <span>تحویل سریع</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-lock"></i>
                            <span>محرمانگی کامل</span>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                        <div class="shape shape-4"></div>
                    </div>
                    
                    <div class="stats-card">
                        <div class="stat-item">
                            <span class="stat-number">۵۰۰۰+</span>
                            <span class="stat-label">پروژه موفق</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">۹۸%</span>
                            <span class="stat-label">رضایت مشتری</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">۲۴/۷</span>
                            <span class="stat-label">پشتیبانی</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Order Form Section -->
    <section class="order-form-section">
        <div class="container">
            <div class="order-layout">
                
                <!-- Order Form -->
                <div class="order-form-wrapper">
                    <div class="form-header">
                        <h2>فرم ثبت سفارش</h2>
                        <p>لطفاً تمام فیلدهای مورد نیاز را تکمیل کنید</p>
                    </div>
                    
                    <form class="order-form" id="order-form">
                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3><i class="fas fa-user"></i> اطلاعات شخصی</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="full_name">نام و نام خانوادگی <span class="required">*</span></label>
                                    <input type="text" id="full_name" name="full_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">شماره تماس <span class="required">*</span></label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">آدرس ایمیل <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="university">دانشگاه</label>
                                    <input type="text" id="university" name="university">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Service Selection -->
                        <div class="form-section">
                            <h3><i class="fas fa-tools"></i> انتخاب خدمت</h3>
                            <div class="service-selection">
                                <div class="service-option">
                                    <input type="radio" id="thesis" name="service_type" value="thesis" required>
                                    <label for="thesis" class="service-card">
                                        <div class="service-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="service-info">
                                            <h4>نگارش پایان‌نامه</h4>
                                            <p>کامل از فصل ۱ تا دفاع</p>
                                            <span class="service-price">از ۲ میلیون تومان</span>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="service-option">
                                    <input type="radio" id="proposal" name="service_type" value="proposal">
                                    <label for="proposal" class="service-card">
                                        <div class="service-icon">
                                            <i class="fas fa-file-contract"></i>
                                        </div>
                                        <div class="service-info">
                                            <h4>نگارش پروپوزال</h4>
                                            <p>با تضمین تایید</p>
                                            <span class="service-price">از ۸۰۰ هزار تومان</span>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="service-option">
                                    <input type="radio" id="article" name="service_type" value="article">
                                    <label for="article" class="service-card">
                                        <div class="service-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        <div class="service-info">
                                            <h4>نگارش مقاله علمی</h4>
                                            <p>ISI و ISC</p>
                                            <span class="service-price">از ۱.۵ میلیون تومان</span>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="service-option">
                                    <input type="radio" id="editing" name="service_type" value="editing">
                                    <label for="editing" class="service-card">
                                        <div class="service-icon">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="service-info">
                                            <h4>ویرایش و بازنویسی</h4>
                                            <p>بهبود متن موجود</p>
                                            <span class="service-price">از ۵۰۰ هزار تومان</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Details -->
                        <div class="form-section">
                            <h3><i class="fas fa-info-circle"></i> جزئیات پروژه</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="field">رشته تحصیلی</label>
                                    <select id="field" name="field">
                                        <option value="">انتخاب رشته</option>
                                        <option value="engineering">مهندسی</option>
                                        <option value="medical">پزشکی</option>
                                        <option value="humanities">علوم انسانی</option>
                                        <option value="science">علوم پایه</option>
                                        <option value="management">مدیریت</option>
                                        <option value="art">هنر</option>
                                        <option value="other">سایر</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="degree">مقطع تحصیلی</label>
                                    <select id="degree" name="degree">
                                        <option value="">انتخاب مقطع</option>
                                        <option value="bachelor">کارشناسی</option>
                                        <option value="master">کارشناسی ارشد</option>
                                        <option value="phd">دکتری</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="topic">موضوع یا عنوان</label>
                                <input type="text" id="topic" name="topic" placeholder="موضوع یا عنوان پروژه خود را وارد کنید">
                            </div>
                            
                            <div class="form-group">
                                <label for="description">توضیحات تکمیلی</label>
                                <textarea id="description" name="description" rows="5" placeholder="توضیحات بیشتر در مورد پروژه، نیازهای خاص، زمان تحویل و ..."></textarea>
                            </div>
                        </div>
                        
                        <!-- File Upload -->
                        <div class="form-section">
                            <h3><i class="fas fa-upload"></i> پیوست فایل (اختیاری)</h3>
                            <div class="file-upload-area" id="file-upload">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>فایل‌های مرجع، راهنما یا نمونه را اینجا بکشید یا کلیک کنید</p>
                                    <button type="button" class="upload-btn">انتخاب فایل</button>
                                </div>
                                <input type="file" id="file-input" name="files[]" multiple accept=".pdf,.doc,.docx,.txt" hidden>
                            </div>
                            <div class="uploaded-files" id="uploaded-files"></div>
                        </div>
                        
                        <!-- Urgency & Budget -->
                        <div class="form-section">
                            <h3><i class="fas fa-calendar-check"></i> اولویت و بودجه</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="urgency">میزان اضطراری بودن</label>
                                    <select id="urgency" name="urgency">
                                        <option value="normal">عادی (۷-۱۴ روز)</option>
                                        <option value="urgent">فوری (۳-۷ روز)</option>
                                        <option value="emergency">اضطراری (۱-۳ روز)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="budget">بودجه تقریبی</label>
                                    <select id="budget" name="budget">
                                        <option value="">انتخاب بودجه</option>
                                        <option value="500k-1m">۵۰۰ هزار تا ۱ میلیون</option>
                                        <option value="1m-2m">۱ تا ۲ میلیون</option>
                                        <option value="2m-5m">۲ تا ۵ میلیون</option>
                                        <option value="5m+">بالای ۵ میلیون</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Privacy Agreement -->
                        <div class="form-section">
                            <div class="privacy-agreement">
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" name="privacy_agreement" required>
                                    <span class="checkmark"></span>
                                    <span class="agreement-text">
                                        با <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>" target="_blank">شرایط و قوانین</a> 
                                        و <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" target="_blank">حریم خصوصی</a> موافقم
                                    </span>
                                </label>
                                
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" name="newsletter_subscribe">
                                    <span class="checkmark"></span>
                                    <span class="agreement-text">مایل به دریافت خبرنامه و اطلاعیه‌ها هستم</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-submit-section">
                            <button type="submit" class="submit-btn">
                                <span class="btn-content">
                                    <i class="fas fa-paper-plane"></i>
                                    ثبت سفارش
                                </span>
                                <span class="btn-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    در حال ارسال...
                                </span>
                            </button>
                            
                            <div class="security-notice">
                                <i class="fas fa-lock"></i>
                                <span>اطلاعات شما به صورت کاملاً محرمانه حفظ می‌شود</span>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Order Sidebar -->
                <div class="order-sidebar">
                    
                    <!-- Contact Card -->
                    <div class="sidebar-card contact-card">
                        <h3><i class="fas fa-headset"></i> تماس مستقیم</h3>
                        <div class="contact-methods">
                            <a href="tel:09162352304" class="contact-method phone-method">
                                <div class="method-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-info">
                                    <strong>تماس تلفنی</strong>
                                    <span>09162352304</span>
                                </div>
                                <div class="method-status online"></div>
                            </a>
                            
                            <a href="https://wa.me/989162352304" class="contact-method whatsapp-method" target="_blank">
                                <div class="method-icon whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="method-info">
                                    <strong>واتساپ</strong>
                                    <span>پاسخگویی فوری</span>
                                </div>
                                <div class="method-status online"></div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Guarantees Card -->
                    <div class="sidebar-card guarantees-card">
                        <h3><i class="fas fa-shield-alt"></i> تضمینات ما</h3>
                        <div class="guarantees-list">
                            <div class="guarantee-item">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین کیفیت و اصالت ۱۰۰%</span>
                            </div>
                            <div class="guarantee-item">
                                <i class="fas fa-undo"></i>
                                <span>ضمانت بازگشت وجه</span>
                            </div>
                            <div class="guarantee-item">
                                <i class="fas fa-clock"></i>
                                <span>تحویل در زمان مقرر</span>
                            </div>
                            <div class="guarantee-item">
                                <i class="fas fa-edit"></i>
                                <span>ویرایش رایگان تا رضایت</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonials Card -->
                    <div class="sidebar-card testimonials-card">
                        <h3><i class="fas fa-star"></i> نظرات مشتریان</h3>
                        <div class="testimonials-slider">
                            <div class="testimonial-item active">
                                <div class="testimonial-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p>"خدمات فوق‌العاده و کیفیت بالا. پایان‌نامه من با بهترین کیفیت و در زمان مقرر تحویل داده شد."</p>
                                <div class="testimonial-author">
                                    <strong>محمد احمدی</strong>
                                    <span>دانشجوی کارشناسی ارشد</span>
                                </div>
                            </div>
                            
                            <div class="testimonial-item">
                                <div class="testimonial-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p>"تیم حرفه‌ای و پشتیبانی عالی. بسیار راضی از همکاری با تزنویسان هستم."</p>
                                <div class="testimonial-author">
                                    <strong>فاطمه کریمی</strong>
                                    <span>دانشجوی دکتری</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="testimonial-navigation">
                            <button class="nav-dot active" data-slide="0"></button>
                            <button class="nav-dot" data-slide="1"></button>
                        </div>
                    </div>
                    
                    <!-- FAQ Card -->
                    <div class="sidebar-card faq-card">
                        <h3><i class="fas fa-question-circle"></i> سوالات متداول</h3>
                        <div class="faq-list">
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleSidebarFAQ(0)">
                                    زمان تحویل چقدر است؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer" id="sidebar-faq-0">
                                    <p>بسته به نوع خدمت و حجم کار، بین ۳ تا ۱۴ روز کاری.</p>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <button class="faq-question" onclick="toggleSidebarFAQ(1)">
                                    آیا اطلاعات محرمانه می‌ماند؟
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer" id="sidebar-faq-1">
                                    <p>بله، تمام اطلاعات شما کاملاً محرمانه و امن نگهداری می‌شود.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trust Section -->
    <section class="trust-section">
        <div class="container">
            <h2>چرا تزنویسان؟</h2>
            <div class="trust-grid">
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>۴۵۰+ پژوهشگر متخصص</h4>
                    <p>تیم بزرگ و مجرب در تمام رشته‌ها</p>
                </div>
                
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4>۵۰۰۰+ پروژه موفق</h4>
                    <p>سابقه درخشان در انجام پروژه‌ها</p>
                </div>
                
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>۹۸% رضایت مشتری</h4>
                    <p>کیفیت بالا و خدمات مطلوب</p>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Order Page Styles */
.order-page-main {
    background: #f8f9fa;
    padding-top: 70px;
}

.order-hero {
    background: linear-gradient(135deg, #4ECDC4 0%, #45a29e 50%, #3d9970 100%);
    color: white;
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.order-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.05)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.08)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 3rem;
    align-items: center;
    position: relative;
    z-index: 1;
}

.hero-text h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-text p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    line-height: 1.6;
    opacity: 0.9;
}

.trust-indicators {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
}

.trust-item i {
    font-size: 1.1rem;
}

.hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 60px;
    height: 60px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 40px;
    height: 40px;
    top: 60%;
    right: 80%;
    animation-delay: 2s;
}

.shape-3 {
    width: 80px;
    height: 80px;
    top: 80%;
    right: 20%;
    animation-delay: 4s;
}

.shape-4 {
    width: 30px;
    height: 30px;
    top: 30%;
    right: 60%;
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(120deg); }
    66% { transform: translateY(-10px) rotate(240deg); }
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    z-index: 2;
}

.stat-item {
    text-align: center;
    margin-bottom: 1.5rem;
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.order-form-section {
    padding: 4rem 0;
}

.order-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
}

.order-form-wrapper {
    background: white;
    border-radius: 15px;
    padding: 0;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid #eee;
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #1FA547, #178A3A);
    color: white;
    padding: 2rem;
    text-align: center;
}

.form-header h2 {
    margin: 0 0 0.5rem 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.form-header p {
    margin: 0;
    opacity: 0.9;
}

.order-form {
    padding: 2rem;
}

.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.form-section h3 {
    color: #333;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-section h3 i {
    color: #1FA547;
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
    display: block;
    color: #333;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.required {
    color: #dc3545;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 1rem;
    border: 2px solid #eee;
    border-radius: 8px;
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #1FA547;
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
    outline: none;
    background: white;
}

.service-selection {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.service-option input[type="radio"] {
    display: none;
}

.service-card {
    display: block;
    padding: 1.5rem;
    background: #fafafa;
    border: 2px solid #eee;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.service-option input[type="radio"]:checked + .service-card {
    border-color: #1FA547;
    background: rgba(31, 165, 71, 0.05);
}

.service-card:hover {
    border-color: #1FA547;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.15);
}

.service-icon {
    width: 60px;
    height: 60px;
    background: #1FA547;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.service-info h4 {
    margin: 0 0 0.5rem 0;
    color: #333;
    font-size: 1.1rem;
    font-weight: 600;
}

.service-info p {
    margin: 0 0 0.75rem 0;
    color: #666;
    font-size: 0.9rem;
}

.service-price {
    color: #1FA547;
    font-weight: 600;
    font-size: 0.9rem;
}

.file-upload-area {
    border: 2px dashed #ddd;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    background: #fafafa;
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-upload-area:hover {
    border-color: #1FA547;
    background: rgba(31, 165, 71, 0.05);
}

.upload-content i {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.upload-content p {
    color: #666;
    margin-bottom: 1rem;
}

.upload-btn {
    background: #1FA547;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.privacy-agreement {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    border: 1px solid #eee;
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    cursor: pointer;
}

.checkbox-wrapper:last-child {
    margin-bottom: 0;
}

.checkbox-wrapper input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid #ddd;
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
}

.checkbox-wrapper input[type="checkbox"]:checked + .checkmark {
    background: #1FA547;
    border-color: #1FA547;
}

.checkbox-wrapper input[type="checkbox"]:checked + .checkmark::after {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 0.8rem;
}

.agreement-text {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.5;
}

.agreement-text a {
    color: #1FA547;
    text-decoration: none;
    font-weight: 600;
}

.form-submit-section {
    text-align: center;
}

.submit-btn {
    background: linear-gradient(135deg, #1FA547, #178A3A);
    color: white;
    border: none;
    padding: 1.25rem 3rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    margin-bottom: 1rem;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(31, 165, 71, 0.4);
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

.submit-btn.loading .btn-content {
    opacity: 0;
}

.submit-btn.loading .btn-loading {
    opacity: 1;
}

.security-notice {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.85rem;
}

.security-notice i {
    color: #28a745;
}

/* Order Sidebar */
.order-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sidebar-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    border: 1px solid #eee;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.sidebar-card h3 {
    margin: 0 0 1.5rem 0;
    color: #333;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sidebar-card h3 i {
    color: #1FA547;
}

.contact-methods {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    border: 1px solid #eee;
    transition: all 0.3s ease;
}

.contact-method:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: #1FA547;
    transform: translateX(-3px);
}

.method-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.phone-method .method-icon { background: #007bff; }
.whatsapp-method .method-icon { background: #25d366; }

.method-info strong {
    display: block;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.method-info span {
    font-size: 0.85rem;
    color: #666;
}

.method-status {
    margin-right: auto;
}

.method-status.online::after {
    content: 'آنلاین';
    background: #28a745;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 600;
}

.guarantees-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.guarantee-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 0.9rem;
}

.guarantee-item i {
    color: #28a745;
    font-size: 1rem;
}

.testimonials-slider {
    position: relative;
    min-height: 200px;
}

.testimonial-item {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    opacity: 0;
    transform: translateX(30px);
    transition: all 0.5s ease;
}

.testimonial-item.active {
    opacity: 1;
    transform: translateX(0);
}

.testimonial-stars {
    margin-bottom: 1rem;
    text-align: center;
}

.testimonial-stars i {
    color: #ffc107;
    font-size: 0.9rem;
    margin: 0 0.1rem;
}

.testimonial-item p {
    font-style: italic;
    line-height: 1.6;
    margin-bottom: 1rem;
    color: #666;
    text-align: center;
}

.testimonial-author {
    text-align: center;
}

.testimonial-author strong {
    display: block;
    color: #333;
    margin-bottom: 0.25rem;
}

.testimonial-author span {
    color: #666;
    font-size: 0.85rem;
}

.testimonial-navigation {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

.nav-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: none;
    background: #ddd;
    cursor: pointer;
    transition: all 0.3s ease;
}

.nav-dot.active {
    background: #1FA547;
    transform: scale(1.2);
}

.faq-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.faq-item {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
}

.faq-question {
    width: 100%;
    padding: 1rem;
    background: #f8f9fa;
    border: none;
    text-align: right;
    font-family: inherit;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.faq-question:hover {
    background: rgba(31, 165, 71, 0.05);
    color: #1FA547;
}

.faq-question i {
    transition: transform 0.3s ease;
}

.faq-answer {
    padding: 0;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
}

.faq-answer.active {
    padding: 1rem;
    max-height: 200px;
}

.faq-answer p {
    margin: 0;
    color: #666;
    line-height: 1.6;
}

.trust-section {
    background: white;
    padding: 4rem 0;
}

.trust-section h2 {
    text-align: center;
    color: #333;
    font-size: 2rem;
    margin-bottom: 3rem;
    font-weight: 700;
}

.trust-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.trust-card {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 15px;
    border: 1px solid #eee;
    transition: all 0.3s ease;
}

.trust-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(31, 165, 71, 0.15);
}

.trust-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1FA547, #178A3A);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
}

.trust-card h4 {
    margin: 0 0 1rem 0;
    color: #333;
    font-size: 1.2rem;
    font-weight: 600;
}

.trust-card p {
    margin: 0;
    color: #666;
    line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
    
    .order-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
    }
    
    .trust-indicators {
        justify-content: center;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .service-selection {
        grid-template-columns: 1fr;
    }
    
    .order-form {
        padding: 1.5rem;
    }
    
    .sidebar-card {
        padding: 1rem;
    }
    
    .trust-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .order-hero {
        padding: 2rem 0;
    }
    
    .hero-text h1 {
        font-size: 1.7rem;
    }
    
    .form-header {
        padding: 1.5rem;
    }
    
    .order-form {
        padding: 1rem;
    }
    
    .submit-btn {
        padding: 1rem 2rem;
        font-size: 1rem;
    }
    
    .trust-indicators {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload functionality
    const fileUploadArea = document.getElementById('file-upload');
    const fileInput = document.getElementById('file-input');
    const uploadedFiles = document.getElementById('uploaded-files');
    
    if (fileUploadArea && fileInput) {
        fileUploadArea.addEventListener('click', () => fileInput.click());
        
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#1FA547';
            this.style.background = 'rgba(31, 165, 71, 0.05)';
        });
        
        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ddd';
            this.style.background = '#fafafa';
        });
        
        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ddd';
            this.style.background = '#fafafa';
            
            const files = e.dataTransfer.files;
            displayUploadedFiles(files);
        });
        
        fileInput.addEventListener('change', function() {
            displayUploadedFiles(this.files);
        });
    }
    
    function displayUploadedFiles(files) {
        uploadedFiles.innerHTML = '';
        Array.from(files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'uploaded-file';
            fileItem.innerHTML = `
                <i class="fas fa-file"></i>
                <span>${file.name}</span>
                <button type="button" class="remove-file" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            uploadedFiles.appendChild(fileItem);
        });
    }
    
    // Testimonials slider
    const testimonials = document.querySelectorAll('.testimonial-item');
    const navDots = document.querySelectorAll('.nav-dot');
    let currentTestimonial = 0;
    
    function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.classList.toggle('active', i === index);
        });
        
        navDots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }
    
    navDots.forEach((dot, index) => {
        dot.addEventListener('click', () => showTestimonial(index));
    });
    
    // Auto-rotate testimonials
    setInterval(() => {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        showTestimonial(currentTestimonial);
    }, 5000);
    
    // Order form submission
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.submit-btn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Simulate form submission
            setTimeout(() => {
                alert('سفارش شما با موفقیت ثبت شد! کارشناسان ما به زودی با شما تماس خواهند گرفت.');
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                this.reset();
            }, 3000);
        });
    }
});

// FAQ toggle function
function toggleSidebarFAQ(index) {
    const answer = document.getElementById('sidebar-faq-' + index);
    const question = answer.previousElementSibling;
    const icon = question.querySelector('i');
    
    if (answer.classList.contains('active')) {
        answer.classList.remove('active');
        icon.style.transform = 'rotate(0deg)';
    } else {
        // Close all other FAQs
        document.querySelectorAll('.faq-answer').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.faq-question i').forEach(el => el.style.transform = 'rotate(0deg)');
        
        answer.classList.add('active');
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>

<?php get_footer(); ?>