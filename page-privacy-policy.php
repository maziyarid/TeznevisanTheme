<?php
/*
Template Name: Privacy Policy
*/
get_header(); ?>

<main id="main-content" class="privacy-page-main">
    
    <!-- Privacy Hero -->
    <section class="privacy-hero">
        <div class="container">
            <div class="privacy-hero-content">
                <div class="hero-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="privacy-title">حریم خصوصی و قوانین</h1>
                <p class="privacy-subtitle">
                    ما متعهد به حفظ حریم خصوصی و امنیت اطلاعات شما هستیم
                </p>
                <div class="last-updated">
                    <i class="fas fa-clock"></i>
                    <span>آخرین به‌روزرسانی: <?php echo get_the_modified_date('j F Y'); ?></span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Privacy Content -->
    <section class="privacy-content">
        <div class="container">
            <div class="privacy-layout">
                
                <!-- Main Content -->
                <div class="privacy-main">
                    <div class="privacy-sections">
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-info-circle"></i>
                                مقدمه
                            </h2>
                            <p>
                                تزنویسان متعهد به حفظ حریم خصوصی کاربران خود است. این سند شرایط 
                                جمع‌آوری، استفاده و محافظت از اطلاعات شخصی شما را توضیح می‌دهد.
                            </p>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-database"></i>
                                جمع‌آوری اطلاعات
                            </h2>
                            <div class="info-types">
                                <div class="info-type">
                                    <h4>اطلاعات شخصی</h4>
                                    <ul>
                                        <li>نام و نام خانوادگی</li>
                                        <li>آدرس ایمیل</li>
                                        <li>شماره تماس</li>
                                        <li>رشته و مقطع تحصیلی</li>
                                    </ul>
                                </div>
                                <div class="info-type">
                                    <h4>اطلاعات پروژه</h4>
                                    <ul>
                                        <li>موضوع پایان‌نامه یا مقاله</li>
                                        <li>جزئیات درخواست</li>
                                        <li>فایل‌های ارسالی</li>
                                        <li>مکاتبات پروژه</li>
                                    </ul>
                                </div>
                                <div class="info-type">
                                    <h4>اطلاعات فنی</h4>
                                    <ul>
                                        <li>آدرس IP</li>
                                        <li>نوع مرورگر</li>
                                        <li>تاریخ و زمان بازدید</li>
                                        <li>صفحات بازدید شده</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-eye"></i>
                                استفاده از اطلاعات
                            </h2>
                            <div class="usage-purposes">
                                <div class="purpose-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>ارائه خدمات درخواستی</span>
                                </div>
                                <div class="purpose-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>برقراری ارتباط و پشتیبانی</span>
                                </div>
                                <div class="purpose-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>بهبود کیفیت خدمات</span>
                                </div>
                                <div class="purpose-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>ارسال اطلاعیه‌های مهم</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-shield-check"></i>
                                حفاظت از اطلاعات
                            </h2>
                            <div class="security-measures">
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="security-content">
                                        <h4>رمزنگاری SSL</h4>
                                        <p>تمام اطلاعات با پروتکل SSL محافظت می‌شوند</p>
                                    </div>
                                </div>
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-server"></i>
                                    </div>
                                    <div class="security-content">
                                        <h4>سرورهای امن</h4>
                                        <p>اطلاعات در سرورهای مطمئن نگهداری می‌شوند</p>
                                    </div>
                                </div>
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div class="security-content">
                                        <h4>دسترسی محدود</h4>
                                        <p>تنها کارکنان مجاز دسترسی به اطلاعات دارند</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-share-alt"></i>
                                اشتراک‌گذاری اطلاعات
                            </h2>
                            <div class="sharing-policy">
                                <div class="policy-item negative">
                                    <i class="fas fa-times-circle"></i>
                                    <span>هرگز اطلاعات شما را به اشخاص ثالث نمی‌فروشیم</span>
                                </div>
                                <div class="policy-item negative">
                                    <i class="fas fa-times-circle"></i>
                                    <span>اطلاعات پروژه‌ها محرمانه باقی می‌ماند</span>
                                </div>
                                <div class="policy-item positive">
                                    <i class="fas fa-check-circle"></i>
                                    <span>تنها در موارد قانونی و با اجازه شما</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-cookie-bite"></i>
                                کوکی‌ها
                            </h2>
                            <p>
                                ما از کوکی‌ها برای بهبود تجربه کاربری استفاده می‌کنیم. 
                                شما می‌توانید تنظیمات کوکی‌ها را در مرورگر خود تغییر دهید.
                            </p>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-user-cog"></i>
                                حقوق کاربر
                            </h2>
                            <div class="user-rights">
                                <div class="right-item">
                                    <i class="fas fa-eye"></i>
                                    <span>مشاهده اطلاعات ذخیره شده</span>
                                </div>
                                <div class="right-item">
                                    <i class="fas fa-edit"></i>
                                    <span>تصحیح اطلاعات نادرست</span>
                                </div>
                                <div class="right-item">
                                    <i class="fas fa-trash"></i>
                                    <span>درخواست حذف اطلاعات</span>
                                </div>
                                <div class="right-item">
                                    <i class="fas fa-download"></i>
                                    <span>دریافت کپی از اطلاعات</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="privacy-section">
                            <h2>
                                <i class="fas fa-phone"></i>
                                تماس با ما
                            </h2>
                            <p>
                                برای هرگونه سوال در مورد حریم خصوصی، می‌توانید با ما تماس بگیرید:
                            </p>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address', 'setinco@gmail.com')); ?>">
                                        <?php echo esc_html(get_theme_mod('email_address', 'setinco@gmail.com')); ?>
                                    </a>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>">
                                        <?php echo esc_html(get_theme_mod('phone_number', '09162352304')); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Privacy Sidebar -->
                <aside class="privacy-sidebar">
                    <div class="sidebar-card quick-links">
                        <h3>
                            <i class="fas fa-link"></i>
                            دسترسی سریع
                        </h3>
                        <div class="quick-links-list">
                            <a href="#data-collection" class="quick-link">
                                <i class="fas fa-database"></i>
                                <span>جمع‌آوری اطلاعات</span>
                            </a>
                            <a href="#data-usage" class="quick-link">
                                <i class="fas fa-eye"></i>
                                <span>استفاده از اطلاعات</span>
                            </a>
                            <a href="#data-protection" class="quick-link">
                                <i class="fas fa-shield-check"></i>
                                <span>حفاظت اطلاعات</span>
                            </a>
                            <a href="#user-rights" class="quick-link">
                                <i class="fas fa-user-cog"></i>
                                <span>حقوق کاربر</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="sidebar-card security-badge">
                        <div class="badge-content">
                            <div class="badge-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h3>گواهی امنیت</h3>
                            <p>اطلاعات شما با بالاترین استانداردهای امنیتی محافظت می‌شود</p>
                            <div class="security-features">
                                <div class="feature">
                                    <i class="fas fa-check"></i>
                                    <span>SSL Certificate</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-check"></i>
                                    <span>ISO 27001</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-check"></i>
                                    <span>GDPR Compliant</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
    
</main>

<style>
.privacy-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

.privacy-hero {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 4rem 0;
    text-align: center;
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
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.privacy-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    font-family: inherit;
}

.privacy-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    font-family: inherit;
}

.last-updated {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-family: inherit;
}

.privacy-content {
    padding: 4rem 0;
}

.privacy-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
}

.privacy-main {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.privacy-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.privacy-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.privacy-section h2 {
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.privacy-section h2 i {
    color: var(--primary-color);
}

.privacy-section p {
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 1.5rem;
    text-align: justify;
    font-family: inherit;
}

.info-types {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.info-type {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 10px;
    border: 1px solid var(--border-color);
}

.info-type h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-family: inherit;
}

.info-type ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-type li {
    padding: 0.5rem 0;
    color: var(--text-secondary);
    border-bottom: 1px solid var(--border-color);
    font-family: inherit;
}

.info-type li:last-child {
    border-bottom: none;
}

.usage-purposes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.purpose-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.purpose-item i {
    color: #28a745;
    font-size: 1.1rem;
}

.security-measures {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.security-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.security-item:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.1);
}

.security-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.security-content h4 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
    font-family: inherit;
}

.security-content p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    font-family: inherit;
}

.sharing-policy {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.policy-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 10px;
    font-weight: 500;
    font-family: inherit;
}

.policy-item.positive {
    background: rgba(40, 167, 69, 0.1);
    border: 1px solid rgba(40, 167, 69, 0.3);
    color: #155724;
}

.policy-item.negative {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #721c24;
}

.policy-item.positive i {
    color: #28a745;
}

.policy-item.negative i {
    color: #dc3545;
}

.user-rights {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.right-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.right-item:hover {
    border-color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
}

.right-item i {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.contact-info {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.contact-item i {
    color: var(--primary-color);
}

.contact-item a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

/* Privacy Sidebar */
.privacy-sidebar {
    position: sticky;
    top: calc(70px + 2rem);
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sidebar-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.sidebar-card h3 {
    background: var(--primary-color);
    color: white;
    padding: 1rem 1.5rem;
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.quick-links-list {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    font-family: inherit;
}

.quick-link:hover {
    border-color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
    transform: translateX(-3px);
    color: var(--text-primary);
}

.quick-link i {
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

.security-badge .badge-content {
    padding: 2rem 1.5rem;
    text-align: center;
}

.badge-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.security-badge h3 {
    background: transparent;
    color: var(--text-primary);
    padding: 0;
    margin-bottom: 1rem;
    font-family: inherit;
}

.security-badge p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.5;
    font-family: inherit;
}

.security-features {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.security-features .feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-family: inherit;
}

.security-features .feature i {
    color: #28a745;
}

@media (max-width: 1024px) {
    .privacy-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .privacy-sidebar {
        position: static;
        order: -1;
    }
}

@media (max-width: 768px) {
    .privacy-hero {
        padding: 3rem 0;
    }
    
    .privacy-title {
        font-size: 2.5rem;
    }
    
    .privacy-main {
        padding: 2rem;
    }
    
    .info-types {
        grid-template-columns: 1fr;
    }
    
    .usage-purposes {
        grid-template-columns: 1fr;
    }
    
    .security-measures {
        grid-template-columns: 1fr;
    }
    
    .user-rights {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>