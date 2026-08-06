<?php
/*
Template Name: Complaint
*/
get_header(); ?>

<main id="main-content" class="complaint-page-main">
    
    <!-- Complaint Hero -->
    <section class="complaint-hero">
        <div class="container">
            <div class="complaint-hero-content">
                <div class="hero-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h1 class="complaint-title">شکایات و پیشنهادات</h1>
                <p class="complaint-subtitle">
                    موسسه تزنویسان در قبال تمامی شکایات، پاسخگوی دانشجویان محترم است
                </p>
                                <div class="complaint-intro">
                    <p>
                        با توجه به صحبت‌هایی که از طریق شبکه‌های اجتماعی و سایر وبسایت‌ها در مورد 
                        تز نویسان مطرح می‌شود، این صفحه بدین منظور راه‌اندازی شده است که بتوانیم 
                        به صورت شفاف و مستقل، شکایات دانشجویان محترم را بررسی و رسیدگی کنیم.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Complaint Information -->
    <section class="complaint-info">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <h3>شفافیت کامل</h3>
                    <p>تمامی پیام‌ها بررسی و پاسخ داده می‌شوند</p>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>حفظ حریم خصوصی</h3>
                    <p>اطلاعات شخصی شما محرمانه باقی می‌ماند</p>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>جبران خسارت</h3>
                    <p>در صورت اثبات، خسارات جبران خواهد شد</p>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>پاسخ سریع</h3>
                    <p>حداکثر طی ۴۸ ساعت پاسخ دریافت می‌کنید</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Complaint Form -->
    <section class="complaint-form-section">
        <div class="container">
            <div class="complaint-layout">
                <div class="form-wrapper">
                    <div class="form-header">
                        <h2>
                            <i class="fas fa-paper-plane"></i>
                            ثبت شکایت یا پیشنهاد
                        </h2>
                        <p>شما می‌توانید به صورت مستقل شکایت خود را به تصمیم‌گیرندگان ارسال کنید</p>
                    </div>
                    
                    <form class="complaint-form" id="complaint-form">
                        <div class="form-step active" data-step="1">
                            <h3 class="step-title">
                                <span class="step-number">۱</span>
                                اطلاعات تماس
                            </h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="complaint_name">
                                        <i class="fas fa-user"></i>
                                        نام و نام خانوادگی
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" id="complaint_name" name="name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="complaint_phone">
                                        <i class="fas fa-phone"></i>
                                        شماره تماس
                                        <span class="required">*</span>
                                    </label>
                                    <input type="tel" id="complaint_phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="complaint_email">
                                    <i class="fas fa-envelope"></i>
                                    آدرس ایمیل
                                    <span class="required">*</span>
                                </label>
                                <input type="email" id="complaint_email" name="email" required>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-next" onclick="nextComplaintStep()">
                                    بعدی
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-step" data-step="2">
                            <h3 class="step-title">
                                <span class="step-number">۲</span>
                                نوع شکایت
                            </h3>
                            
                            <div class="complaint-types">
                                <label class="complaint-type-option">
                                    <input type="radio" name="complaint_type" value="service_quality" required>
                                    <div class="type-card">
                                        <div class="type-icon">
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <div class="type-content">
                                            <h4>کیفیت خدمات</h4>
                                            <p>نارضایتی از کیفیت کار انجام شده</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="complaint-type-option">
                                    <input type="radio" name="complaint_type" value="delivery_delay">
                                    <div class="type-card">
                                        <div class="type-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="type-content">
                                            <h4>تأخیر در تحویل</h4>
                                            <p>عدم رعایت زمان‌بندی توافق شده</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="complaint-type-option">
                                    <input type="radio" name="complaint_type" value="communication">
                                    <div class="type-card">
                                        <div class="type-icon">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <div class="type-content">
                                            <h4>ارتباط و پشتیبانی</h4>
                                            <p>مشکل در ارتباط یا پاسخگویی</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="complaint-type-option">
                                    <input type="radio" name="complaint_type" value="billing">
                                    <div class="type-card">
                                        <div class="type-icon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <div class="type-content">
                                            <h4>مسائل مالی</h4>
                                            <p>مشکل در پرداخت یا هزینه‌ها</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="complaint-type-option">
                                    <input type="radio" name="complaint_type" value="suggestion">
                                    <div class="type-card">
                                        <div class="type-icon">
                                            <i class="fas fa-lightbulb"></i>
                                        </div>
                                        <div class="type-content">
                                            <h4>پیشنهاد</h4>
                                            <p>پیشنهاد برای بهبود خدمات</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="complaint-type-option">
                                    <input type="radio" name="complaint_type" value="other">
                                    <div class="type-card">
                                        <div class="type-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <div class="type-content">
                                            <h4>سایر موارد</h4>
                                            <p>موضوعات دیگر</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev" onclick="prevComplaintStep()">
                                    <i class="fas fa-arrow-right"></i>
                                    قبلی
                                </button>
                                <button type="button" class="btn-next" onclick="nextComplaintStep()">
                                    بعدی
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                        
                                                <div class="form-step" data-step="3">
                            <h3 class="step-title">
                                <span class="step-number">۳</span>
                                جزئیات شکایت
                            </h3>
                            
                            <div class="form-group">
                                <label for="complaint_subject">
                                    <i class="fas fa-tag"></i>
                                    موضوع شکایت
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="complaint_subject" name="subject" 
                                       placeholder="موضوع کوتاه شکایت خود را بنویسید" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="complaint_service">
                                    <i class="fas fa-cog"></i>
                                    خدمت مربوطه (در صورت وجود)
                                </label>
                                <select id="complaint_service" name="service">
                                    <option value="">انتخاب خدمت</option>
                                    <?php
                                    $services = get_posts(array('post_type' => 'services', 'posts_per_page' => -1));
                                    foreach ($services as $service) {
                                        echo '<option value="' . $service->ID . '">' . esc_html($service->post_title) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="complaint_message">
                                    <i class="fas fa-comment-alt"></i>
                                    شرح کامل شکایت
                                    <span class="required">*</span>
                                </label>
                                <textarea id="complaint_message" name="message" rows="8" 
                                          placeholder="لطفاً شکایت یا پیشنهاد خود را به طور کامل و دقیق شرح دهید..." required></textarea>
                                <div class="textarea-counter">
                                    <span class="current-chars">0</span>/<span class="max-chars">2000</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="complaint_evidence">
                                    <i class="fas fa-paperclip"></i>
                                    مدارک و مستندات (اختیاری)
                                </label>
                                <div class="file-upload-area" id="evidence-upload">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                                                                <p>فایل‌های مربوط به شکایت را بارگذاری کنید</p>
                                        <span class="upload-formats">فرمت‌های مجاز: PDF, JPG, PNG, DOC</span>
                                    </div>
                                    <input type="file" id="evidence-file" name="evidence[]" 
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple hidden>
                                </div>
                                <div class="uploaded-files" id="uploaded-evidence"></div>
                            </div>
                            
                            <div class="privacy-notice">
                                <div class="notice-header">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>نکات مهم:</strong>
                                </div>
                                <ul class="notice-list">
                                    <li>تمامی پیام‌ها به استثنای موارد سیاسی و ناشایست منتشر خواهند شد</li>
                                    <li>اطلاعات شخصی شما (نام، تلفن، ایمیل) در متن منتشر نخواهند شد</li>
                                    <li>با دانشجویانی که اطلاعات تماس ارائه دهند، جهت رفع نارضایتی تماس گرفته می‌شود</li>
                                    <li>در صورت اثبات خسارت مالی، جبران خواهد شد</li>
                                </ul>
                            </div>
                            
                            <div class="form-navigation">
                                <button type="button" class="btn-prev" onclick="prevComplaintStep()">
                                    <i class="fas fa-arrow-right"></i>
                                    قبلی
                                </button>
                                <button type="submit" class="btn-submit-complaint">
                                    <span class="btn-content">
                                        <i class="fas fa-paper-plane"></i>
                                        ارسال شکایت
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
                                <div class="progress-fill" id="complaint-progress-fill"></div>
                            </div>
                            <div class="progress-steps">
                                <div class="progress-step active" data-step="1">
                                    <span>اطلاعات</span>
                                </div>
                                <div class="progress-step" data-step="2">
                                    <span>نوع شکایت</span>
                                </div>
                                <div class="progress-step" data-step="3">
                                    <span>جزئیات</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="complaint-sidebar">
                    <!-- Contact Information -->
                    <div class="sidebar-card contact-card">
                        <h3>
                            <i class="fas fa-headset"></i>
                            تماس مستقیم
                        </h3>
                        <div class="contact-methods">
                            <div class="contact-method">
                                <div class="method-icon phone-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-info">
                                    <strong>تماس تلفنی</strong>
                                    <span>09331663849</span>
                                    <small>پاسخگویی فوری</small>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="method-icon telegram-icon">
                                    <i class="fab fa-telegram"></i>
                                </div>
                                <div class="method-info">
                                    <strong>تلگرام</strong>
                                    <span>@Thesissupport</span>
                                    <small>پشتیبانی آنلاین</small>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="method-icon eitaa-icon">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="method-info">
                                    <strong>ایتا</strong>
                                    <span>@Teznevs</span>
                                    <small>پیام در ایتا</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Response Time -->
                    <div class="sidebar-card response-card">
                        <h3>
                            <i class="fas fa-clock"></i>
                            زمان پاسخگویی
                        </h3>
                        <div class="response-timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>ارسال شکایت</strong>
                                    <span>فوری</span>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>بررسی اولیه</strong>
                                    <span>۲۴ ساعت</span>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="fas fa-reply"></i>
                                </div>
                                                                <div class="timeline-content">
                                    <strong>پاسخ نهایی</strong>
                                    <span>۴۸ ساعت</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Guidelines -->
                    <div class="sidebar-card guidelines-card">
                        <h3>
                            <i class="fas fa-list-check"></i>
                            راهنمای شکایت
                        </h3>
                        <div class="guidelines-list">
                            <div class="guideline-item">
                                <i class="fas fa-check-circle"></i>
                                <span>شکایت خود را واضح و مفصل بیان کنید</span>
                            </div>
                            <div class="guideline-item">
                                <i class="fas fa-check-circle"></i>
                                <span>مدارک مربوطه را ضمیمه کنید</span>
                            </div>
                            <div class="guideline-item">
                                <i class="fas fa-check-circle"></i>
                                <span>اطلاعات تماس صحیح ارائه دهید</span>
                            </div>
                            <div class="guideline-item">
                                <i class="fas fa-times-circle"></i>
                                <span>از الفاظ ناشایست خودداری کنید</span>
                            </div>
                            <div class="guideline-item">
                                <i class="fas fa-times-circle"></i>
                                <span>مطالب سیاسی مطرح نکنید</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Complaint Page Styles */
.complaint-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

.complaint-hero {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.complaint-hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 2rem;
    backdrop-filter: blur(10px);
}

.complaint-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    font-family: inherit;
}

.complaint-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    font-family: inherit;
}

.complaint-intro p {
    font-size: 1rem;
    line-height: 1.7;
    opacity: 0.9;
    text-align: justify;
    font-family: inherit;
}

/* Complaint Info */
.complaint-info {
    background: var(--bg-main);
    padding: 4rem 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.info-card {
    background: var(--bg-secondary);
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(231, 76, 60, 0.15);
    border-color: #e74c3c;
}

.info-icon {
    width: 60px;
    height: 60px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.info-card h3 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    font-family: inherit;
}

.info-card p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.5;
    font-family: inherit;
}

/* Complaint Form */
.complaint-form-section {
    background: var(--bg-secondary);
    padding: 4rem 0;
}

.complaint-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
}

.form-wrapper {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    position: relative;
}

.form-header {
    background: #e74c3c;
    color: white;
    padding: 2rem;
    text-align: center;
}

.form-header h2 {
    margin: 0 0 0.75rem 0;
    font-size: 1.6rem;
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
    font-family: inherit;
}

.complaint-form {
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
    background: #e74c3c;
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
    color: #e74c3c;
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
    border-color: #e74c3c;
    box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
    outline: none;
    background: var(--bg-main);
}

.complaint-types {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.complaint-type-option input[type="radio"] {
    display: none;
}

.type-card {
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

.complaint-type-option input[type="radio"]:checked + .type-card {
    border-color: #e74c3c;
    background: rgba(231, 76, 60, 0.05);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(231, 76, 60, 0.15);
}

.type-card:hover {
    border-color: #e74c3c;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(231, 76, 60, 0.1);
}

.type-icon {
    width: 50px;
    height: 50px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.type-content h4 {
    margin: 0;
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 600;
    font-family: inherit;
}

.type-content p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.85rem;
    line-height: 1.4;
    font-family: inherit;
}

.textarea-counter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.current-chars {
    color: #e74c3c;
    font-weight: 600;
}

.file-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-upload-area:hover {
    border-color: #e74c3c;
    background: rgba(231, 76, 60, 0.05);
}

.upload-content i {
    font-size: 3rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.upload-content p {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    font-family: inherit;
}

.upload-formats {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-family: inherit;
}

.uploaded-files {
    margin-top: 1rem;
}

.uploaded-file-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.file-icon {
    color: #e74c3c;
    font-size: 1.2rem;
}

.file-name {
    flex: 1;
    font-weight: 500;
    color: var(--text-primary);
    font-family: inherit;
}

.remove-uploaded-file {
    background: #dc3545;
    color: white;
    border: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.privacy-notice {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.notice-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #856404;
    margin-bottom: 1rem;
    font-family: inherit;
}

.notice-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notice-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    color: #856404;
    font-size: 0.9rem;
    line-height: 1.5;
    font-family: inherit;
}

.notice-list li i {
    margin-top: 0.25rem;
    font-size: 0.8rem;
}

.form-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
}

.btn-prev,
.btn-next,
.btn-submit-complaint {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: inherit;
}

.btn-prev {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 2px solid var(--border-color);
}

.btn-next {
    background: #e74c3c;
    color: white;
    border: 2px solid #e74c3c;
}

.btn-submit-complaint {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border: none;
    position: relative;
}

.btn-prev:hover {
    background: var(--bg-main);
    border-color: #e74c3c;
    color: #e74c3c;
}

.btn-next:hover,
.btn-submit-complaint:hover {
    background: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
}

.btn-submit-complaint:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
}

.btn-submit-complaint .btn-content,
.btn-submit-complaint .btn-loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-submit-complaint .btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.btn-submit-complaint.loading .btn-content {
    opacity: 0;
}

.btn-submit-complaint.loading .btn-loading {
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
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #e74c3c, #c0392b);
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
    color: #e74c3c;
    opacity: 1;
    font-weight: 600;
}

/* Complaint Sidebar */
.complaint-sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.sidebar-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.sidebar-card h3 {
    background: #e74c3c;
    color: white;
    padding: 1.25rem 1.5rem;
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.contact-methods {
    padding: 1.5rem;
}

.contact-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.contact-method:hover {
    background: rgba(231, 76, 60, 0.05);
    border-color: #e74c3c;
    transform: translateX(-3px);
}

.contact-method:last-child {
    margin-bottom: 0;
}

.method-icon {
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
.telegram-icon { background: #0088cc; }
.eitaa-icon { background: #00C9A7; }

.method-info {
    flex: 1;
}

.method-info strong {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
    font-family: inherit;
}

.method-info span {
    display: block;
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.method-info small {
    display: block;
    color: var(--text-muted);
    font-size: 0.75rem;
    font-family: inherit;
}

/* Response Timeline */
.response-timeline {
    padding: 1.5rem;
}

.timeline-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    width: 35px;
    height: 35px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.timeline-content {
    flex: 1;
}

.timeline-content strong {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.timeline-content span {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-family: inherit;
}

/* Guidelines */
.guidelines-list {
    padding: 1.5rem;
}

.guideline-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-family: inherit;
}

.guideline-item:last-child {
    margin-bottom: 0;
}

.guideline-item i.fa-check-circle {
    color: #28a745;
}

.guideline-item i.fa-times-circle {
    color: #dc3545;
}

/* Responsive */
@media (max-width: 1024px) {
    .complaint-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .complaint-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .complaint-hero {
        padding: 3rem 0;
    }
    
    .complaint-title {
        font-size: 2.5rem;
    }
    
    .info-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .complaint-types {
        grid-template-columns: 1fr;
    }
    
    .form-navigation {
        flex-direction: column;
        gap: 1rem;
    }
    
    .complaint-form {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentComplaintStep = 1;
    const totalSteps = 3;
    
    // Step navigation
    window.nextComplaintStep = function() {
        if (currentComplaintStep < totalSteps) {
            const currentStepEl = document.querySelector(`.form-step[data-step="${currentComplaintStep}"]`);
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
                currentComplaintStep++;
                updateComplaintStep();
            } else {
                alert('لطفاً تمام فیلدهای ضروری را تکمیل کنید');
            }
        }
    };
    
    window.prevComplaintStep = function() {
        if (currentComplaintStep > 1) {
            currentComplaintStep--;
            updateComplaintStep();
        }
    };
    
    function updateComplaintStep() {
        document.querySelectorAll('.form-step').forEach(step => {
            step.classList.remove('active');
        });
        document.querySelector(`.form-step[data-step="${currentComplaintStep}"]`).classList.add('active');
        
        const progressFill = document.getElementById('complaint-progress-fill');
        const progressPercent = (currentComplaintStep / totalSteps) * 100;
        progressFill.style.width = progressPercent + '%';
        
        document.querySelectorAll('.progress-step').forEach((step, index) => {
            step.classList.toggle('active', index < currentComplaintStep);
        });
    }
    
    // Character counter
    const messageTextarea = document.getElementById('complaint_message');
    const currentChars = document.querySelector('.current-chars');
    
    if (messageTextarea && currentChars) {
        messageTextarea.addEventListener('input', function() {
            const count = this.value.length;
            currentChars.textContent = count;
            
            if (count > 1600) {
                currentChars.style.color = '#dc3545';
            } else if (count > 1200) {
                currentChars.style.color = '#ffc107';
            } else {
                currentChars.style.color = '#e74c3c';
            }
        });
    }
    
    // File upload
    const evidenceUpload = document.getElementById('evidence-upload');
    const evidenceFile = document.getElementById('evidence-file');
    const uploadedEvidence = document.getElementById('uploaded-evidence');
    
    if (evidenceUpload && evidenceFile) {
        evidenceUpload.addEventListener('click', () => evidenceFile.click());
        
        evidenceFile.addEventListener('change', function() {
            displayUploadedFiles(this.files);
        });
        
        evidenceUpload.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#e74c3c';
            this.style.background = 'rgba(231, 76, 60, 0.05)';
        });
        
        evidenceUpload.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '';
            this.style.background = '';
        });
        
        evidenceUpload.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '';
            this.style.background = '';
            displayUploadedFiles(e.dataTransfer.files);
        });
    }
    
    function displayUploadedFiles(files) {
        uploadedEvidence.innerHTML = '';
        Array.from(files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'uploaded-file-item';
            fileItem.innerHTML = `
                <i class="fas fa-file file-icon"></i>
                <span class="file-name">${file.name}</span>
                <button type="button" class="remove-uploaded-file" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            uploadedEvidence.appendChild(fileItem);
        });
    }
    
    // Form submission
    const complaintForm = document.getElementById('complaint-form');
    if (complaintForm) {
        complaintForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.btn-submit-complaint');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('شکایت شما با موفقیت ثبت شد. طی ۴۸ ساعت بررسی و پاسخ داده خواهد شد.');
                this.reset();
                currentComplaintStep = 1;
                updateComplaintStep();
                uploadedEvidence.innerHTML = '';
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }, 3000);
        });
    }
});
</script>

<?php get_footer(); ?>