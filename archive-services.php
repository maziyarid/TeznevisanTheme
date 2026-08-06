<?php get_header(); ?>

<main id="main-content" class="services-archive-main">
    
    <!-- Services Hero -->
    <section class="services-hero">
        <div class="hero-background">
            <div class="hero-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
                <div class="shape shape-5"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-badge">
                        <i class="fas fa-award"></i>
                        بیش از ۱۰ سال تجربه
                    </span>
                    <h1 class="hero-title">
                        خدمات حرفه‌ای 
                        <span class="highlight-text">نگارش دانشگاهی</span>
                    </h1>
                    <p class="hero-description">
                        با تیم ۴۵۰+ پژوهشگر متخصص و ۵۰۰۰+ پروژه موفق، بهترین کیفیت نگارش 
                        را در تمام رشته‌ها و مقاطع تحصیلی ارائه می‌دهیم
                    </p>
                    
                    <div class="hero-features">
                        <div class="feature-item">
                            <i class="fas fa-shield-check"></i>
                            <span>تضمین کیفیت ۱۰۰%</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>تحویل به موقع</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-lock"></i>
                            <span>محرمانگی کامل</span>
                        </div>
                    </div>
                    
                    <div class="hero-actions">
                        <a href="#services-categories" class="btn-hero-primary">
                            <i class="fas fa-eye"></i>
                            مشاهده خدمات
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>" class="btn-hero-secondary">
                            <i class="fas fa-rocket"></i>
                            شروع فوری پروژه
                        </a>
                    </div>
                </div>
                
                <div class="hero-stats">
                    <div class="stats-card">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">۴۵۰+</span>
                                <span class="stat-label">پژوهشگر متخصص</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">۵۰۰۰+</span>
                                <span class="stat-label">پروژه موفق</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">۹۸%</span>
                                <span class="stat-label">رضایت مشتری</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">۲۴/۷</span>
                                <span class="stat-label">پشتیبانی</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Categories -->
    <section id="services-categories" class="services-categories">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">دسته‌بندی خدمات</h2>
                <p class="section-description">خدمات جامع نگارش در تمام مقاطع و رشته‌های تحصیلی</p>
            </div>
            
            <div class="categories-grid">
                
                <!-- Thesis Writing Category -->
                <div class="category-card thesis-category" style="--category-color: #FF6B6B; --category-light: #FFE5E5; --category-dark: #E55454;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">نگارش پایان‌نامه</h3>
                        <p class="category-description">
                            خدمات کامل نگارش پایان‌نامه از فصل اول تا دفاع نهایی 
                            با تضمین کیفیت و اصالت در تمام مقاطع تحصیلی
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>پایان‌نامه کارشناسی</h4>
                                    <span class="service-price">از ۱.۵ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>نگارش کامل ۵ فصل</span>
                                        <span>تحلیل آماری</span>
                                        <span>فرمت‌بندی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=thesis-bachelor" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>پایان‌نامه کارشناسی ارشد</h4>
                                    <span class="service-price">از ۲.۵ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>تحقیق پیشرفته</span>
                                        <span>مرور منابع</span>
                                        <span>روش‌شناسی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=thesis-master" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>رساله دکتری</h4>
                                    <span class="service-price">از ۵ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>تحقیق اصیل</span>
                                        <span>نوآوری علمی</span>
                                        <span>انتشار مقاله</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=thesis-phd" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین تایید از راهنما</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Article Writing Category -->
                <div class="category-card article-category" style="--category-color: #4ECDC4; --category-light: #E8FFFE; --category-dark: #45B7B8;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">نگارش مقاله علمی</h3>
                        <p class="category-description">
                            نگارش مقالات ISI و ISC با تضمین پذیرش در مجلات معتبر 
                            بین‌المللی و داخلی با استانداردهای علمی روز
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>مقاله ISI</h4>
                                    <span class="service-price">از ۳ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>تضمین پذیرش</span>
                                        <span>بازنگری رایگان</span>
                                        <span>انتخاب مجله</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=article-isi" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>مقاله ISC</h4>
                                    <span class="service-price">از ۱.۵ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>مجلات داخلی</span>
                                        <span>پردازش سریع</span>
                                        <span>کیفیت بالا</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=article-isc" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>مقاله کنفرانس</h4>
                                    <span class="service-price">از ۸۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>ارائه کنفرانس</span>
                                        <span>خلاصه گسترده</span>
                                        <span>اسلایدها</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=article-conference" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین پذیرش مقاله</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Proposal Writing Category -->
                <div class="category-card proposal-category" style="--category-color: #45B7D1; --category-light: #E3F2FD; --category-dark: #3A9BC1;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">پروپوزال و طرح پژوهشی</h3>
                        <p class="category-description">
                            نگارش پروپوزال و طرح‌های پژوهشی با تضمین تایید 
                            از اساتید راهنما و دانشگاه‌های مطرح کشور
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>پروپوزال پایان‌نامه</h4>
                                    <span class="service-price">از ۸۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>انتخاب موضوع</span>
                                        <span>مرور ادبیات</span>
                                        <span>روش‌شناسی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=proposal-thesis" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>طرح پژوهشی</h4>
                                    <span class="service-price">از ۱ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>طرح‌های دانشگاهی</span>
                                        <span>گرنت‌های پژوهشی</span>
                                        <span>پروژه‌های صنعتی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=research-proposal" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>طرح کسب‌وکار</h4>
                                    <span class="service-price">از ۱.۲ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>بیزینس پلن</span>
                                        <span>تحلیل بازار</span>
                                        <span>مدل کسب‌وکار</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=business-plan" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین تایید پروپوزال</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Translation Category -->
                <div class="category-card translation-category" style="--category-color: #96CEB4; --category-light: #F0FFF4; --category-dark: #7FB89B;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-language"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">ترجمه تخصصی</h3>
                        <p class="category-description">
                            ترجمه متون تخصصی، علمی و ادبی با دقت بالا 
                            توسط مترجمان مجرب در زبان‌های مختلف
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>ترجمه مقاله</h4>
                                    <span class="service-price">از ۳۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>ترجمه تخصصی</span>
                                        <span>ویرایش نهایی</span>
                                        <span>تضمین کیفیت</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=translation-article" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>ترجمه کتاب</h4>
                                    <span class="service-price">از ۲ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>کتب علمی</span>
                                        <span>ادبیات</span>
                                        <span>متون تاریخی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=translation-book" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>ترجمه فوری</h4>
                                    <span class="service-price">از ۵۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>تحویل ۲۴ ساعته</span>
                                        <span>ترجمه آنی</span>
                                        <span>پشتیبانی مداوم</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=translation-urgent" 
                                       class="service-btn urgent">
                                        <i class="fas fa-bolt"></i>
                                        سفارش فوری
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین دقت ترجمه</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Editing Category -->
                <div class="category-card editing-category" style="--category-color: #FFEAA7; --category-light: #FFFEF7; --category-dark: #E6D089;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">ویرایش و بازنویسی</h3>
                        <p class="category-description">
                            بهبود و ویرایش متون موجود، اصلاح ساختار 
                            و ارتقای کیفیت نگارش با حفظ معنا و مفهوم اصلی
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>ویرایش محتوایی</h4>
                                    <span class="service-price">از ۴۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>اصلاح متن</span>
                                        <span>بهبود ساختار</span>
                                        <span>رفع ایرادات</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=editing-content" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>ویرایش ساختاری</h4>
                                    <span class="service-price">از ۶۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>بازسازی کامل</span>
                                        <span>منطق متن</span>
                                        <span>انسجام محتوا</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=editing-structural" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>بازنویسی کامل</h4>
                                    <span class="service-price">از ۱ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>نوشتن مجدد</span>
                                        <span>بهبود کیفیت</span>
                                        <span>ارتقای استاندارد</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=rewriting" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین بهبود کیفیت</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Statistical Analysis Category -->
                <div class="category-card analysis-category" style="--category-color: #DDA0DD; --category-light: #F9F5FF; --category-dark: #C78EC7;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">تحلیل آماری</h3>
                        <p class="category-description">
                            تحلیل داده‌ها و انجام محاسبات آماری پیشرفته 
                            با نرم‌افزارهای تخصصی و تفسیر نتایج
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>تحلیل SPSS</h4>
                                    <span class="service-price">از ۵۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>آمار توصیفی</span>
                                        <span>آزمون فرضیه</span>
                                        <span>تفسیر نتایج</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=analysis-spss" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>تحلیل R و Python</h4>
                                    <span class="service-price">از ۷۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>تحلیل پیشرفته</span>
                                        <span>مدل‌سازی</span>
                                        <span>یادگیری ماشین</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=analysis-advanced" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>تحلیل کیفی</h4>
                                    <span class="service-price">از ۸۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>مصاحبه</span>
                                        <span>تحلیل محتوا</span>
                                        <span>تحلیل گفتمان</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=analysis-qualitative" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین دقت تحلیل</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Programming Category -->
                <div class="category-card programming-category" style="--category-color: #74B9FF; --category-light: #EBF4FF; --category-dark: #5A9AE5;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">پروژه‌های برنامه‌نویسی</h3>
                        <p class="category-description">
                            انجام پروژه‌های برنامه‌نویسی، طراحی وب‌سایت 
                            و توسعه اپلیکیشن‌های تحت وب و موبایل
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>پروژه وب</h4>
                                    <span class="service-price">از ۱ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>طراحی واکنش‌گرا</span>
                                        <span>پنل مدیریت</span>
                                        <span>بهینه‌سازی SEO</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=web-project" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>اپلیکیشن موبایل</h4>
                                    <span class="service-price">از ۲ میلیون تومان</span>
                                    <div class="service-features">
                                        <span>Android & iOS</span>
                                        <span>طراحی UI/UX</span>
                                        <span>انتشار در استور</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=mobile-app" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>پروژه دانشگاهی</h4>
                                    <span class="service-price">از ۸۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>الگوریتم‌ها</span>
                                        <span>پایگاه داده</span>
                                        <span>هوش مصنوعی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=programming-academic" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین عملکرد کد</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Specialized Services Category -->
                <div class="category-card specialized-category" style="--category-color: #FD79A8; --category-light: #FFF0F6; --category-dark: #E94B87;">
                    <div class="category-background">
                        <div class="category-pattern"></div>
                    </div>
                    
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <h3 class="category-title">خدمات تخصصی</h3>
                        <p class="category-description">
                            خدمات ویژه و تخصصی شامل مشاوره، آموزش 
                            و پشتیبانی در فرآیند تحصیلات تکمیلی
                        </p>
                    </div>
                    
                    <div class="category-content">
                        <div class="services-list">
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>مشاوره تحصیلی</h4>
                                    <span class="service-price">از ۲۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>انتخاب موضوع</span>
                                        <span>برنامه‌ریزی</span>
                                        <span>راهنمایی مسیر</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=consultation" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>آموزش نگارش</h4>
                                    <span class="service-price">از ۵۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>دوره‌های آنلاین</span>
                                        <span>مشاوره خصوصی</span>
                                        <span>تمرین عملی</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=training" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                            
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>دفاع از پایان‌نامه</h4>
                                    <span class="service-price">از ۳۰۰ هزار تومان</span>
                                    <div class="service-features">
                                        <span>آماده‌سازی دفاع</span>
                                        <span>اسلایدهای ارائه</span>
                                        <span>تمرین دفاع</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=defense-preparation" 
                                       class="service-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        سفارش
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-guarantee">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین آمادگی کامل</span>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                               class="consultation-btn">
                                <i class="fas fa-phone"></i>
                                مشاوره رایگان
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    <!-- Trust Section -->
    <section class="trust-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">چرا تزنویسان؟</h2>
                <p class="section-description">دلایل اعتماد هزاران دانشجو به خدمات ما</p>
            </div>
            
            <div class="trust-grid">
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>تیم متخصص</h4>
                    <p>۴۵۰+ پژوهشگر و استاد مجرب در تمام رشته‌های علمی</p>
                    <div class="trust-stats">
                        <span>میانگین تجربه: ۸+ سال</span>
                    </div>
                </div>
                
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>تضمین کیفیت</h4>
                    <p>تضمین اصالت ۱۰۰%، بازنگری رایگان و ضمانت بازگشت وجه</p>
                    <div class="trust-stats">
                        <span>نرخ تایید: ۹۹%</span>
                    </div>
                </div>
                
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>تحویل به موقع</h4>
                    <p>رعایت دقیق زمان‌بندی و تحویل پروژه‌ها در موعد مقرر</p>
                    <div class="trust-stats">
                        <span>تحویل به موقع: ۹۸%</span>
                    </div>
                </div>
                
                <div class="trust-card">
                    <div class="trust-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>پشتیبانی ۲۴/۷</h4>
                    <p>پشتیبانی مداوم و پاسخگویی فوری در تمام مراحل پروژه</p>
                    <div class="trust-stats">
                        <span>زمان پاسخ: < ۲ ساعت</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Process Section -->
    <section class="process-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">فرآیند همکاری</h2>
                <p class="section-description">مراحل ساده و شفاف انجام پروژه از ابتدا تا انتها</p>
            </div>
            
            <div class="process-timeline">
                <div class="process-step" data-step="1">
                    <div class="step-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="step-content">
                        <h4>مشاوره اولیه</h4>
                        <p>بررسی نیازها و ارائه راهکار مناسب</p>
                        <span class="step-time">۳۰ دقیقه</span>
                    </div>
                </div>
                
                <div class="process-step" data-step="2">
                    <div class="step-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="step-content">
                        <h4>عقد قرارداد</h4>
                        <p>تعیین جزئیات، زمان‌بندی و هزینه‌ها</p>
                        <span class="step-time">۱ روز</span>
                    </div>
                </div>
                
                <div class="process-step" data-step="3">
                    <div class="step-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="step-content">
                        <h4>تعیین نویسنده</h4>
                        <p>انتخاب متخصص مناسب برای پروژه شما</p>
                        <span class="step-time">۲ روز</span>
                    </div>
                </div>
                
                <div class="process-step" data-step="4">
                    <div class="step-icon">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <div class="step-content">
                        <h4>شروع نگارش</h4>
                        <p>آغاز نگارش با گزارش‌دهی مرحله‌ای</p>
                        <span class="step-time">مطابق قرارداد</span>
                    </div>
                </div>
                
                <div class="process-step" data-step="5">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="step-content">
                        <h4>بازبینی و ویرایش</h4>
                        <p>بررسی دقیق و اعمال اصلاحات نهایی</p>
                        <span class="step-time">۳ روز</span>
                    </div>
                </div>
                
                <div class="process-step" data-step="6">
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="step-content">
                        <h4>تحویل نهایی</h4>
                        <p>ارائه پروژه کامل همراه با پشتیبانی</p>
                        <span class="step-time">تحویل فوری</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">نظرات مشتریان</h2>
                <p class="section-description">تجربه دانشجویان از همکاری با تزنویسان</p>
            </div>
            
            <div class="testimonials-carousel">
                <div class="testimonial-track" id="testimonial-track">
                    
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="testimonial-info">
                                    <strong>محمد احمدی</strong>
                                    <span>دانشجوی کارشناسی ارشد - مهندسی کامپیوتر</span>
                                </div>
                                <div class="testimonial-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="testimonial-content">
                                <p>"خدمات فوق‌العاده و کیفیت بالا. پایان‌نامه من با بهترین کیفیت و در زمان مقرر تحویل داده شد. تیم تزنویسان واقعاً حرفه‌ای و قابل اعتماد هستند."</p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="project-info">
                                    <span class="project-type">پایان‌نامه کارشناسی ارشد</span>
                                    <span class="project-rating">امتیاز: ۱۹.۵/۲۰</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="testimonial-info">
                                    <strong>فاطمه کریمی</strong>
                                    <span>دانشجوی دکتری - روانشناسی</span>
                                </div>
                                <div class="testimonial-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="testimonial-content">
                                <p>"تیم حرفه‌ای و پشتیبانی عالی. مقاله ISI من در اولین ارسال پذیرفته شد. بسیار راضی از همکاری با تزنویسان هستم و به همه توصیه می‌کنم."</p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="project-info">
                                    <span class="project-type">مقاله ISI</span>
                                    <span class="project-rating">انتشار موفق</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="testimonial-info">
                                    <strong>علی رضایی</strong>
                                    <span>دانشجوی کارشناسی - مدیریت</span>
                                </div>
                                <div class="testimonial-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="testimonial-content">
                                <p>"پروپوزال من در اولین جلسه تایید شد. کیفیت کار بسیار بالا بود و راهنمایی‌های ارزشمندی دریافت کردم. پشتیبانی ۲۴ ساعته واقعاً کاربردی است."</p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="project-info">
                                    <span class="project-type">پروپوزال پایان‌نامه</span>
                                    <span class="project-rating">تایید در جلسه اول</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="testimonials-navigation">
                    <button class="nav-btn prev-btn" id="testimonial-prev">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="nav-dots" id="testimonial-dots">
                        <button class="nav-dot active" data-slide="0"></button>
                        <button class="nav-dot" data-slide="1"></button>
                        <button class="nav-dot" data-slide="2"></button>
                    </div>
                    <button class="nav-btn next-btn" id="testimonial-next">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="services-cta">
        <div class="cta-background">
            <div class="cta-particles">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="cta-content">
                <div class="cta-text">
                    <h2>آماده شروع پروژه خود هستید؟</h2>
                    <p>همین الان با کارشناسان ما تماس بگیرید و مشاوره رایگان دریافت کنید</p>
                    
                    <div class="cta-features">
                        <div class="cta-feature">
                            <i class="fas fa-phone"></i>
                            <span>مشاوره رایگان</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-calculator"></i>
                            <span>برآورد قیمت فوری</span>
                        </div>
                        <div class="cta-feature">
                            <i class="fas fa-shield-check"></i>
                            <span>تضمین کیفیت</span>
                        </div>
                    </div>
                </div>
                
                <div class="cta-actions">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>" 
                       class="cta-primary-btn">
                        <span class="btn-content">
                            <i class="fas fa-rocket"></i>
                            شروع فوری پروژه
                        </span>
                        <div class="btn-shine"></div>
                    </a>
                    
                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" 
                       class="cta-secondary-btn">
                        <span class="btn-content">
                            <i class="fas fa-phone"></i>
                            تماس مستقیم
                        </span>
                    </a>
                </div>
                
                <div class="cta-guarantee">
                    <div class="guarantee-items">
                        <div class="guarantee-item">
                            <i class="fas fa-undo"></i>
                            <span>ضمانت بازگشت وجه</span>
                        </div>
                        <div class="guarantee-item">
                            <i class="fas fa-edit"></i>
                            <span>بازنگری رایگان</span>
                        </div>
                        <div class="guarantee-item">
                            <i class="fas fa-lock"></i>
                            <span>محرمانگی کامل</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Services Archive Comprehensive Styles */
.services-archive-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

/* Services Hero */
.services-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6a3093 100%);
    color: white;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.hero-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: heroFloat 8s ease-in-out infinite;
}

.shape-1 {
    width: 120px;
    height: 120px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 80px;
    height: 80px;
    top: 60%;
    right: 80%;
    animation-delay: 2s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    top: 80%;
    right: 20%;
    animation-delay: 4s;
}

.shape-4 {
    width: 60px;
    height: 60px;
    top: 30%;
    right: 60%;
    animation-delay: 1s;
}

.shape-5 {
    width: 100px;
    height: 100px;
    top: 20%;
    right: 40%;
    animation-delay: 3s;
}

@keyframes heroFloat {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg) scale(1); 
        opacity: 0.3;
    }
    25% { 
        transform: translateY(-30px) rotate(90deg) scale(1.1); 
        opacity: 0.6;
    }
    50% { 
        transform: translateY(-60px) rotate(180deg) scale(0.9); 
        opacity: 0.8;
    }
    75% { 
        transform: translateY(-30px) rotate(270deg) scale(1.1); 
        opacity: 0.4;
    }
}

.hero-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: badgeGlow 3s ease-in-out infinite;
}

@keyframes badgeGlow {
    0%, 100% { box-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
    50% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.6), 0 0 30px rgba(255, 255, 255, 0.4); }
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.highlight-text {
    background: linear-gradient(45deg, #FFD700, #FFA500, #FF6347);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.hero-description {
    font-size: 1.2rem;
    line-height: 1.7;
    margin-bottom: 2rem;
    opacity: 0.95;
    font-family: inherit;
}

.hero-features {
    display: flex;
    gap: 2rem;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
}

.hero-features .feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.5rem;
    border-radius: 30px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.hero-features .feature-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
}

.hero-features .feature-item i {
    font-size: 1.2rem;
}

.hero-actions {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.btn-hero-primary,
.btn-hero-secondary {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 2.5rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.btn-hero-primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.4);
}

.btn-hero-secondary {
    background: linear-gradient(135deg, #FF6B6B, #FF5252);
    color: white;
    border: 2px solid transparent;
}

.btn-hero-primary:hover,
.btn-hero-secondary:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 35px rgba(255, 255, 255, 0.3);
    color: white;
}

.hero-stats {
    position: relative;
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
}

.stats-card .stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.stats-card .stat-item:last-child {
    border-bottom: none;
}

.stat-icon {
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

.stat-content {
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    font-family: inherit;
}

/* Services Categories */
.services-categories {
    padding: 5rem 0;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-family: inherit;
}

.section-description {
    font-size: 1.2rem;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 3rem;
}

.category-card {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.category-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--category-color), var(--category-dark));
}

.category-card:hover {
    transform: translateY(-10px) rotateX(5deg);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.category-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.category-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, var(--category-light) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, var(--category-light) 0%, transparent 50%);
    opacity: 0.3;
}

.category-header {
    background: linear-gradient(135deg, var(--category-color), var(--category-dark));
    color: white;
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.category-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
}

.category-icon {
    width: 90px;
    height: 90px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    backdrop-filter: blur(15px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 1;
}

.icon-pulse {
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
    border: 3px solid rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    animation: iconPulse 2.5s infinite;
}

@keyframes iconPulse {
    0% { transform: scale(1); opacity: 0.7; }
    70% { transform: scale(1.3); opacity: 0; }
    100% { transform: scale(1.3); opacity: 0; }
}

.category-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: inherit;
}

.category-header p {
    font-size: 1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0;
    font-family: inherit;
}

.category-content {
    padding: 2rem;
    position: relative;
    z-index: 2;
}

.services-list {
    margin-bottom: 2rem;
}

.service-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.service-item::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: var(--category-color);
    transition: width 0.3s ease;
}

.service-item:hover::before {
    width: 4px;
}

.service-item:hover {
    background: var(--category-light);
    border-color: var(--category-color);
    transform: translateX(-5px);
}

.service-item:last-child {
    margin-bottom: 0;
}

.service-info {
    flex: 1;
}

.service-info h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.service-price {
    color: var(--category-color);
    font-weight: 700;
    font-size: 0.95rem;
    display: block;
    margin-bottom: 0.75rem;
    font-family: inherit;
}

.service-features {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.service-features span {
    background: var(--category-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
    font-family: inherit;
}

.service-actions {
    flex-shrink: 0;
}

.service-btn {
    background: var(--category-color);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
    white-space: nowrap;
}

.service-btn:hover {
    background: var(--category-dark);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    color: white;
}

.service-btn.urgent {
    background: linear-gradient(135deg, #FF6B6B, #FF4757);
    animation: urgentPulse 2s infinite;
}

@keyframes urgentPulse {
    0%, 100% { box-shadow: 0 0 10px rgba(255, 107, 107, 0.5); }
    50% { box-shadow: 0 0 20px rgba(255, 107, 107, 0.8), 0 0 30px rgba(255, 107, 107, 0.3); }
}

.category-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
    flex-wrap: wrap;
    gap: 1rem;
}

.category-guarantee {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #28a745;
    font-weight: 600;
    font-size: 0.9rem;
    font-family: inherit;
}

.category-guarantee i {
    font-size: 1rem;
}

.consultation-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: transparent;
    color: var(--category-color);
    text-decoration: none;
    border: 2px solid var(--category-color);
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.consultation-btn:hover {
    background: var(--category-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Trust Section */
.trust-section {
    background: var(--bg-main);
    padding: 5rem 0;
}

.trust-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2.5rem;
    margin-top: 3rem;
}

.trust-card {
    text-align: center;
    padding: 2.5rem 2rem;
    background: var(--bg-secondary);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.trust-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(31, 165, 71, 0.05), transparent);
    transition: left 0.6s ease;
}

.trust-card:hover::before {
    left: 100%;
}

.trust-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
    border-color: var(--primary-color);
}

.trust-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
    transition: all 0.3s ease;
}

.trust-card:hover .trust-icon {
    transform: scale(1.1) rotateY(180deg);
}

.trust-card h4 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 600;
    font-family: inherit;
}

.trust-card p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.trust-stats {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
    font-family: inherit;
}

/* Process Section */
.process-section {
    background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
    padding: 5rem 0;
}

.process-timeline {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
    position: relative;
}

.process-timeline::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light), var(--primary-color));
    transform: translateY(-50%);
    z-index: 1;
}

.process-step {
    text-align: center;
    position: relative;
    z-index: 2;
    background: var(--bg-main);
    padding: 2rem 1.5rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.process-step:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(31, 165, 71, 0.15);
}

.step-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.8rem;
    box-shadow: 0 6px 20px rgba(31, 165, 71, 0.3);
    position: relative;
}

.step-icon::before {
    content: attr(data-step);
    position: absolute;
    top: -10px;
    right: -10px;
    width: 25px;
    height: 25px;
    background: #FF6B6B;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
    border: 2px solid white;
}

.process-step[data-step="1"] .step-icon::before { content: "۱"; }
.process-step[data-step="2"] .step-icon::before { content: "۲"; }
.process-step[data-step="3"] .step-icon::before { content: "۳"; }
.process-step[data-step="4"] .step-icon::before { content: "۴"; }
.process-step[data-step="5"] .step-icon::before { content: "۵"; }
.process-step[data-step="6"] .step-icon::before { content: "۶"; }

.step-content h4 {
    margin: 0 0 0.75rem 0;
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    font-family: inherit;
}

.step-content p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
    line-height: 1.5;
    font-family: inherit;
}

.step-time {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    font-family: inherit;
}

/* Testimonials Section */
.testimonials-section {
    background: var(--bg-main);
    padding: 5rem 0;
}

.testimonials-carousel {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 20px;
}

.testimonial-track {
    display: flex;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.testimonial-slide {
    min-width: 100%;
    padding: 0 1rem;
}

.testimonial-card {
    background: var(--bg-secondary);
    border-radius: 15px;
    padding: 2.5rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    margin: 0 auto;
    max-width: 800px;
}

.testimonial-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.testimonial-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
}

.testimonial-info {
    flex: 1;
}

.testimonial-info strong {
    display: block;
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.testimonial-info span {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-family: inherit;
}

.testimonial-stars {
    display: flex;
    gap: 0.25rem;
}

.testimonial-stars i {
    color: #FFD700;
    font-size: 1.2rem;
    filter: drop-shadow(0 2px 4px rgba(255, 215, 0, 0.3));
}

.testimonial-content {
    margin-bottom: 2rem;
}

.testimonial-content p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-primary);
    font-style: italic;
    text-align: justify;
    margin: 0;
    font-family: inherit;
    position: relative;
}

.testimonial-content p::before {
    content: '"';
    font-size: 4rem;
    color: var(--primary-color);
    position: absolute;
    top: -1rem;
    right: -0.5rem;
    line-height: 1;
    opacity: 0.3;
    font-family: serif;
}

.testimonial-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.project-info {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.project-type,
.project-rating {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

.project-rating {
    background: #28a745;
}

.testimonials-navigation {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-top: 2rem;
}

.nav-btn {
    width: 50px;
    height: 50px;
    background: var(--bg-main);
    color: var(--text-primary);
    border: 2px solid var(--border-color);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.nav-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.1);
}

.nav-dots {
    display: flex;
    gap: 0.75rem;
}

.nav-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: var(--border-color);
    cursor: pointer;
    transition: all 0.3s ease;
}

.nav-dot.active {
    background: var(--primary-color);
    transform: scale(1.3);
    box-shadow: 0 0 15px rgba(31, 165, 71, 0.5);
}

/* Services CTA */
.services-cta {
    background: linear-gradient(135deg, #1FA547 0%, #178A3A 50%, #0f5d2a 100%);
    color: white;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.cta-particles {
    position: absolute;
    width: 100%;
    height: 100%;
}

.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: particleFloat 8s ease-in-out infinite;
}

.particle:nth-child(1) {
    width: 20px;
    height: 20px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.particle:nth-child(2) {
    width: 15px;
    height: 15px;
    top: 60%;
    left: 80%;
    animation-delay: 2s;
}

.particle:nth-child(3) {
    width: 25px;
    height: 25px;
    top: 80%;
    left: 20%;
    animation-delay: 4s;
}

.particle:nth-child(4) {
    width: 18px;
    height: 18px;
    top: 30%;
    left: 70%;
    animation-delay: 1s;
}

.particle:nth-child(5) {
    width: 22px;
    height: 22px;
    top: 50%;
    left: 40%;
    animation-delay: 3s;
}

@keyframes particleFloat {
    0%, 100% { 
        transform: translateY(0px) translateX(0px) rotate(0deg); 
        opacity: 0.3;
    }
    25% { 
        transform: translateY(-30px) translateX(20px) rotate(90deg); 
        opacity: 0.7;
    }
    50% { 
        transform: translateY(-60px) translateX(-20px) rotate(180deg); 
        opacity: 1;
    }
    75% { 
        transform: translateY(-30px) translateX(10px) rotate(270deg); 
        opacity: 0.5;
    }
}

.cta-content {
    text-align: center;
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.cta-text h2 {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    font-family: inherit;
}

.cta-text p {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.95;
    line-height: 1.6;
    font-family: inherit;
}

.cta-features {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
}

.cta-feature {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-family: inherit;
}

.cta-feature i {
    font-size: 1.2rem;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
}

.cta-primary-btn,
.cta-secondary-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem 3rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.cta-primary-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.4);
}

.cta-secondary-btn {
    background: transparent;
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.6);
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s ease;
}

.cta-primary-btn:hover .btn-shine {
    left: 100%;
}

.cta-primary-btn:hover,
.cta-secondary-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    color: white;
}

.cta-guarantee {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.guarantee-items {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.guarantee-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-family: inherit;
}

.guarantee-item i {
    color: #FFD700;
    font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }
}

@media (max-width: 1024px) {
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }
    
    .process-timeline::before {
        display: none;
    }
    
    .process-timeline {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .services-hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-features {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
    
    .service-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .category-footer {
        flex-direction: column;
        text-align: center;
    }
    
    .trust-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
    
    .process-timeline {
        grid-template-columns: 1fr;
    }
    
    .cta-features {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .guarantee-items {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .services-hero {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .category-header {
        padding: 2rem 1.5rem;
    }
    
    .category-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
    
    .category-content {
        padding: 1.5rem;
    }
    
    .testimonial-card {
        padding: 2rem 1.5rem;
    }
    
    .testimonial-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .cta-content {
        padding: 0 1rem;
    }
    
    .cta-primary-btn,
    .cta-secondary-btn {
        padding: 1.25rem 2rem;
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Testimonials carousel
    const testimonialTrack = document.getElementById('testimonial-track');
    const testimonialDots = document.querySelectorAll('.nav-dot');
    const prevBtn = document.getElementById('testimonial-prev');
    const nextBtn = document.getElementById('testimonial-next');
    
    let currentSlide = 0;
    const totalSlides = testimonialDots.length;
    
    function updateCarousel() {
        if (testimonialTrack) {
            testimonialTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        testimonialDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }
    
    // Navigation buttons
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    
    // Dots navigation
    testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });
    
    // Auto-play testimonials
    setInterval(nextSlide, 6000);
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Category cards hover effects
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.zIndex = '';
        });
    });
    
    // Process steps animation on scroll
    const processSteps = document.querySelectorAll('.process-step');
    
    const observerOptions = {
        threshold: 0.3,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const processObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }, 100);
            }
        });
    }, observerOptions);
    
    processSteps.forEach((step, index) => {
        step.style.opacity = '0';
        step.style.transform = 'translateY(50px) scale(0.9)';
        step.style.transition = 'all 0.6s ease';
        step.style.transitionDelay = (index * 0.1) + 's';
        processObserver.observe(step);
    });
    
    // Trust cards animation
    const trustCards = document.querySelectorAll('.trust-card');
    trustCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        card.style.transitionDelay = (index * 0.15) + 's';
        
        const trustObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        trustObserver.observe(card);
    });
});
</script>

<?php get_footer(); ?>