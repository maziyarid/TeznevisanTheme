<?php
/**
 * Front Page Template (Home Page)
 * Based on index.html with full functionality
 * 
 * @package Teznevisan
 */

get_header();
?>

<main id="main-content" class="site-main">
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-pattern"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="hero-title-main">
                            <?php echo get_theme_mod('hero_title_main', 'خدمات انجام پروژه دانشجویی'); ?>
                        </span>
                        <span class="hero-title-sub">
                            <?php echo get_theme_mod('hero_title_sub', 'با ضمانت کیفیت و قیمت منصفانه'); ?>
                        </span>
                    </h1>
                    <p class="hero-description">
                        <?php 
                        echo get_theme_mod('hero_description', 'موسسه تز نویسان با بیش از <strong>۴۵۰ محقق و پژوهشگر متخصص</strong> در تمامی رشته‌ها، آماده انجام پایان‌نامه، پروپوزال، مقاله و تمامی پروژه‌های دانشجویی شما با بالاترین کیفیت است.');
                        ?>
                    </p>
                    
                    <div class="hero-features">
                        <div class="hero-feature">
                            <i class="fa-solid fa-check-circle"></i>
                            <span>تضمین کیفیت</span>
                        </div>
                        <div class="hero-feature">
                            <i class="fa-solid fa-clock"></i>
                            <span>تحویل به موقع</span>
                        </div>
                        <div class="hero-feature">
                            <i class="fa-solid fa-shield-alt"></i>
                            <span>محرمانگی کامل</span>
                        </div>
                    </div>
                    
                    <div class="hero-actions">
                        <a href="#order-form" class="btn btn-primary btn-lg hero-cta-primary" onclick="scrollToForm()">
                            <i class="fa-solid fa-arrow-down"></i>
                            همین حالا سفارش دهید
                        </a>
                        <a href="<?php echo get_permalink(get_page_by_path('services')); ?>" class="btn btn-outline btn-lg hero-cta-secondary">
                            <i class="fa-solid fa-list"></i>
                            مشاهده خدمات
                        </a>
                    </div>
                </div>
                
                <div class="hero-visual desktop-only">
                    <div class="hero-stats-card">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo get_theme_mod('stat_researchers', '۴۵۰+'); ?></div>
                            <div class="stat-label">محقق متخصص</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo get_theme_mod('stat_projects', '۵۰۰۰+'); ?></div>
                            <div class="stat-label">پروژه موفق</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo get_theme_mod('stat_satisfaction', '۱۰۰%'); ?></div>
                            <div class="stat-label">رضایت مشتری</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trust Bar -->
    <section class="trust-bar">
        <div class="container">
            <div class="trust-items">
                <?php
                $trust_items = array(
                    array('icon' => 'users', 'number' => '۴۵۰+', 'label' => 'محقق متخصص'),
                    array('icon' => 'project-diagram', 'number' => '۵۰۰۰+', 'label' => 'پروژه انجام شده'),
                    array('icon' => 'star', 'number' => '۱۰۰%', 'label' => 'ضمانت رضایت'),
                    array('icon' => 'shield-alt', 'number' => '۱۰+', 'label' => 'سال تجربه'),
                    array('icon' => 'user-secret', 'number' => '۱۰۰%', 'label' => 'محرمانگی'),
                    array('icon' => 'comments', 'number' => '۲۴/۷', 'label' => 'ارتباط با محقق'),
                );
                
                foreach ($trust_items as $item):
                ?>
                    <div class="trust-item scroll-animate">
                        <div class="trust-icon">
                            <i class="fa-solid fa-<?php echo $item['icon']; ?>"></i>
                        </div>
                        <div class="trust-content">
                            <span class="trust-number"><?php echo $item['number']; ?></span>
                            <span class="trust-label"><?php echo $item['label']; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <h2>در چه زمینه‌هایی می‌توانیم به شما کمک کنیم؟</h2>
                <p>موسسه تز نویسان در تمامی رشته‌ها و مقاطع تحصیلی خدمات ارائه می‌دهد</p>
            </div>
            
            <div class="services-grid">
                <?php
                $services = array(
                    array(
                        'icon' => 'graduation-cap',
                        'title' => 'انجام پایان‌نامه ارشد و دکتری',
                        'description' => 'انجام کامل پایان‌نامه‌های کارشناسی ارشد و دکتری در تمامی رشته‌ها با کیفیت بالا و رعایت استانداردهای علمی',
                        'features' => array('انتخاب موضوع مناسب', 'نگارش کامل متن', 'ویرایش و بازبینی'),
                        'link' => 'thesis-writing'
                    ),
                    array(
                        'icon' => 'file-contract',
                        'title' => 'نوشتن پروپوزال تحقیق',
                        'description' => 'تدوین پروپوزال تحقیق حرفه‌ای برای ارائه به استاد راهنما با رعایت چارچوب‌های علمی و پژوهشی',
                        'features' => array('تعیین اهداف و سوالات', 'بررسی پیشینه تحقیق', 'تدوین روش‌شناسی'),
                        'link' => 'proposal-writing'
                    ),
                    array(
                        'icon' => 'newspaper',
                        'title' => 'نگارش مقاله علمی و ISI',
                        'description' => 'نوشتن مقالات علمی-پژوهشی برای چاپ در مجلات معتبر داخلی و بین‌المللی با رعایت استانداردهای نگارش',
                        'features' => array('مقالات ISI و Scopus', 'مقالات کنفرانس', 'مقالات مروری'),
                        'link' => 'article-writing'
                    ),
                    array(
                        'icon' => 'chart-bar',
                        'title' => 'تحلیل آماری داده‌ها',
                        'description' => 'تحلیل آماری داده‌های پژوهشی با استفاده از نرم‌افزارهای SPSS، AMOS، LISREL، R و Python',
                        'features' => array('تحلیل توصیفی و استنباطی', 'مدل‌سازی معادلات ساختاری', 'رگرسیون و آزمون فرضیات'),
                        'link' => 'statistical-analysis'
                    ),
                    array(
                        'icon' => 'language',
                        'title' => 'ترجمه تخصصی متون',
                        'description' => 'ترجمه تخصصی متون علمی، مقالات، کتب و اسناد تحقیقاتی از فارسی به انگلیسی و بالعکس',
                        'features' => array('ترجمه مقالات علمی', 'ترجمه پایان‌نامه', 'ویراستاری متون انگلیسی'),
                        'link' => 'translation'
                    ),
                    array(
                        'icon' => 'code',
                        'title' => 'پروژه‌های برنامه‌نویسی',
                        'description' => 'انجام پروژه‌های برنامه‌نویسی دانشجویی در زمینه‌های وب، موبایل، دسکتاپ و هوش مصنوعی',
                        'features' => array('پروژه‌های وب و موبایل', 'پروژه‌های دیتابیس', 'پروژه‌های یادگیری ماشین'),
                        'link' => 'programming'
                    ),
                );
                
                foreach ($services as $service):
                ?>
                    <article class="service-card scroll-animate">
                        <div class="service-icon">
                            <i class="fa-solid fa-<?php echo $service['icon']; ?>"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><?php echo $service['title']; ?></h3>
                            <p class="service-description"><?php echo $service['description']; ?></p>
                            
                            <ul class="service-features">
                                <?php foreach ($service['features'] as $feature): ?>
                                    <li><i class="fa-solid fa-check"></i><?php echo $feature; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <div class="service-footer">
                                <span class="price-range">
                                    <i class="fa-solid fa-tag"></i>
                                    قیمت: توافقی
                                </span>
                                <a href="<?php echo get_permalink(get_page_by_path($service['link'])); ?>" class="service-btn">
                                    جزئیات بیشتر <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="section-footer">
                <a href="<?php echo get_permalink(get_page_by_path('services')); ?>" class="btn btn-primary btn-lg">
                    مشاهده تمام خدمات <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Us Section -->
    <section class="why-choose-section">
        <div class="container">
            <div class="section-header">
                <h2>چرا باید تز نویسان را انتخاب کنید؟</h2>
                <p>دلایل اعتماد هزاران دانشجو به موسسه تز نویسان</p>
            </div>
            
            <div class="value-grid">
                <?php
                $values = array(
                    array(
                        'icon' => 'user-graduate',
                        'title' => 'تجربه و تخصص بی‌نظیر',
                        'description' => 'با تیمی متشکل از بیش از ۴۵۰ محقق و پژوهشگر متخصص در تمامی رشته‌ها، ما توانسته‌ایم بیش از ۵۰۰۰ پروژه تحقیقاتی و پایان‌نامه را با موفقیت به پایان برسانیم.'
                    ),
                    array(
                        'icon' => 'certificate',
                        'title' => 'تضمین کیفیت و اصالت',
                        'description' => 'تمامی پروژه‌ها با بالاترین استانداردهای علمی و تحقیقاتی انجام می‌شوند و از نظر Plagiarism کاملاً بررسی و تأیید می‌گردند.'
                    ),
                    array(
                        'icon' => 'clock',
                        'title' => 'تحویل به موقع و سریع',
                        'description' => 'ما متعهد به زمان‌بندی مشخص شده هستیم و پروژه‌ها را در موعد مقرر با کیفیت عالی تحویل می‌دهیم.'
                    ),
                    array(
                        'icon' => 'dollar-sign',
                        'title' => 'قیمت منصفانه و رقابتی',
                        'description' => 'برخلاف بسیاری از موسسات، ما با قیمت‌گذاری منصفانه و متناسب با کیفیت، خدمات خود را ارائه می‌دهیم.'
                    ),
                    array(
                        'icon' => 'shield-alt',
                        'title' => 'محرمانگی و امنیت کامل',
                        'description' => 'اطلاعات شخصی و پروژه‌های شما کاملاً محرمانه بوده و با امنیت بالا محافظت می‌شوند.'
                    ),
                    array(
                        'icon' => 'headset',
                        'title' => 'پشتیبانی ۲۴/۷',
                        'description' => 'تیم پشتیبانی ما به صورت شبانه‌روزی آماده پاسخگویی به سوالات شما است.'
                    ),
                    array(
                        'icon' => 'sync-alt',
                        'title' => 'اصلاح و بازنگری رایگان',
                        'description' => 'در صورت درخواست هرگونه تغییر یا بازنگری پس از تحویل اولیه، به صورت کاملاً رایگان اصلاحات مورد نیاز انجام خواهد شد.'
                    ),
                    array(
                        'icon' => 'chalkboard-teacher',
                        'title' => 'جلسه توجیهی قبل از دفاع',
                        'description' => 'قبل از دفاع از پایان‌نامه، یک جلسه توجیهی کامل با شما برگزار می‌شود تا با تمام جزئیات پروژه آشنا شوید.'
                    ),
                    array(
                        'icon' => 'hand-holding-usd',
                        'title' => 'پرداخت اقساطی و منعطف',
                        'description' => 'امکان پرداخت اقساطی برای پروژه‌های بلندمدت فراهم شده است تا فشار مالی کمتری به شما وارد شود.'
                    ),
                );
                
                foreach ($values as $value):
                ?>
                    <div class="value-item scroll-animate">
                        <div class="value-icon">
                            <i class="fa-solid fa-<?php echo $value['icon']; ?>"></i>
                        </div>
                        <h3><?php echo $value['title']; ?></h3>
                        <p><?php echo $value['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Process Steps Section -->
    <section class="process-steps">
        <div class="container">
            <div class="section-header">
                <h2>مراحل انجام پروژه‌ها</h2>
                <p>پروسه شفاف و حرفه‌ای انجام پروژه‌های دانشجویی</p>
            </div>
            
            <div class="steps-timeline">
                <?php
                $steps = array(
                    array('icon' => 'comments', 'title' => 'مشاوره اولیه', 'desc' => 'دریافت اطلاعات پروژه و ارائه مشاوره رایگان'),
                    array('icon' => 'file-signature', 'title' => 'قرارداد و پیش‌پرداخت', 'desc' => 'امضای قرارداد شفاف'),
                    array('icon' => 'user-tie', 'title' => 'تخصیص متخصص', 'desc' => 'انتساب پروژه به متخصص'),
                    array('icon' => 'cogs', 'title' => 'انجام پروژه', 'desc' => 'شروع انجام پروژه'),
                    array('icon' => 'check-circle', 'title' => 'تحویل نهایی', 'desc' => 'تحویل پروژه کامل'),
                    array('icon' => 'chalkboard-teacher', 'title' => 'جلسه توجیهی', 'desc' => 'آماده‌سازی برای دفاع'),
                    array('icon' => 'edit', 'title' => 'ویراستاری', 'desc' => 'اصلاحات پس از دفاع'),
                    array('icon' => 'life-ring', 'title' => 'پشتیبانی', 'desc' => 'پشتیبانی مستمر'),
                );
                
                $step_num = 1;
                foreach ($steps as $step):
                ?>
                    <div class="step-item scroll-animate">
                        <div class="step-number"><?php echo $step_num++; ?></div>
                        <div class="step-icon">
                            <i class="fa-solid fa-<?php echo $step['icon']; ?>"></i>
                        </div>
                        <div class="step-content">
                            <h3><?php echo $step['title']; ?></h3>
                            <p><?php echo $step['desc']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Pricing Philosophy -->
    <section class="pricing-philosophy">
        <div class="container">
            <div class="section-header">
                <h2>شیوه قیمت‌گذاری</h2>
                <p>قیمت‌گذاری شفاف و منصفانه برای تمامی خدمات</p>
            </div>
            
            <div class="pricing-content">
                <div class="pricing-text">
                    <p>
                        هزینه انجام پروژه‌های دانشجویی همیشه یکی از بزرگ‌ترین مشکلاتی بوده که دانشجویان هنگام سپردن پروژه‌های خود به موسسات با آن مواجه می‌شوند.
                    </p>
                    <p>
                        <strong>تز نویسان</strong> برخلاف موسسات سودجویی که اغلب قیمت انجام پروژه‌های دانشجویی را بسیار بالا می‌دهند و ادعای کیفیت به اندازه قیمت دارند، ما پروژه‌های دانشجویی را با قیمت مناسب و تضمین کیفیت انجام می‌دهیم.
                    </p>
                    <div class="guarantee-box">
                        <h3><i class="fa-solid fa-shield-alt"></i> ضمانت‌های ما</h3>
                        <ul>
                            <li><i class="fa-solid fa-check-circle"></i>اصلاحات رایگان در صورت نیاز</li>
                            <li><i class="fa-solid fa-check-circle"></i>بازپرداخت هزینه در صورت عدم رضایت</li>
                            <li><i class="fa-solid fa-check-circle"></i>محرمانگی کامل اطلاعات</li>
                            <li><i class="fa-solid fa-check-circle"></i>تحویل به موقع</li>
                        </ul>
                    </div>
                </div>
                <div class="pricing-visual">
                    <div class="pricing-card">
                        <h3>مزایای قیمت‌گذاری ما</h3>
                        <div class="pricing-features">
                            <div class="pricing-feature">
                                <i class="fa-solid fa-eye"></i>
                                <span>شفافیت کامل</span>
                            </div>
                            <div class="pricing-feature">
                                <i class="fa-solid fa-balance-scale"></i>
                                <span>قیمت منصفانه</span>
                            </div>
                            <div class="pricing-feature">
                                <i class="fa-solid fa-ban"></i>
                                <span>بدون هزینه پنهان</span>
                            </div>
                            <div class="pricing-feature">
                                <i class="fa-solid fa-handshake"></i>
                                <span>پرداخت امن</span>
                            </div>
                        </div>
                        <a href="<?php echo get_permalink(get_page_by_path('pricing')); ?>" class="btn btn-primary">
                            مشاهده تعرفه خدمات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2>نظرات دانشجویان</h2>
                <p>آنچه دانشجویان درباره تز نویسان می‌گویند</p>
            </div>
            
            <div class="testimonials-grid">
                <?php
                $testimonials = array(
                    array(
                        'text' => 'پایان‌نامه من در رشته مدیریت توسط تیم تز نویسان با کیفیت فوق‌العاده‌ای انجام شد. تمام مراحل به موقع انجام شد و نتیجه نهایی بسیار عالی بود.',
                        'name' => 'محمد رضایی',
                        'role' => 'دانشجوی کارشناسی ارشد مدیریت'
                    ),
                    array(
                        'text' => 'تحلیل آماری تحقیق من با استفاده از SPSS توسط متخصصان تز نویسان انجام شد. توضیحات کامل و جامع درباره نتایج به من داده شد.',
                        'name' => 'فاطمه احمدی',
                        'role' => 'دانشجوی دکتری روانشناسی'
                    ),
                    array(
                        'text' => 'پروژه برنامه‌نویسی من در زمینه یادگیری ماشین با بهترین کیفیت و کاملاً عملیاتی تحویل داده شد. از تیم تز نویسان بسیار راضی هستم.',
                        'name' => 'علی کریمی',
                        'role' => 'دانشجوی کارشناسی کامپیوتر'
                    ),
                );
                
                foreach ($testimonials as $testimonial):
                ?>
                    <div class="testimonial-card scroll-animate">
                        <div class="testimonial-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text"><?php echo $testimonial['text']; ?></p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h4><?php echo $testimonial['name']; ?></h4>
                                <span><?php echo $testimonial['role']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- FAQ & Lead Form Section -->
    <section id="order-form" class="faq-lead-section">
        <div class="container">
            <div class="faq-lead-content">
                <div class="faq-lead-text">
                    <div class="section-header-center">
                        <h2>سوالات متداول (FAQ)</h2>
                        <p>پاسخ به سوالات رایج درباره خدمات ما</p>
                    </div>
                    
                    <div class="faq-lead-items">
                        <?php
                        $faqs = array(
                            array(
                                'q' => 'چطور می‌توانم پروژه‌ام را به تز نویسان بسپارم؟',
                                'a' => 'برای شروع، شما می‌توانید از طریق فرم تماس آنلاین یا شماره تماس با ما ارتباط برقرار کنید.'
                            ),
                            array(
                                'q' => 'چقدر طول می‌کشد تا پروژه من آماده شود؟',
                                'a' => 'زمان انجام پروژه بستگی به نوع و حجم کار دارد. معمولاً پایان‌نامه‌ها بین ۳ تا ۶ ماه زمان می‌برد.'
                            ),
                            array(
                                'q' => 'آیا می‌توانم با محقق پروژه‌ام در ارتباط باشم؟',
                                'a' => 'بله، یکی از مزایای تز نویسان امکان ارتباط مستقیم با محقق پروژه است.'
                            ),
                            array(
                                'q' => 'چگونه از کیفیت کار اطمینان حاصل کنم؟',
                                'a' => 'تمامی پروژه‌ها توسط متخصصان انجام و از نظر Plagiarism بررسی می‌شوند.'
                            ),
                            array(
                                'q' => 'هزینه انجام پروژه چقدر است؟',
                                'a' => 'هزینه بستگی به نوع، حجم و پیچیدگی کار دارد. برای دریافت قیمت دقیق با ما تماس بگیرید.'
                            ),
                            array(
                                'q' => 'آیا امکان پرداخت اقساطی وجود دارد؟',
                                'a' => 'بله، برای پروژه‌های بلندمدت امکان پرداخت اقساطی فراهم است.'
                            ),
                        );
                        
                        foreach ($faqs as $faq):
                        ?>
                            <div class="faq-lead-item">
                                <button class="faq-lead-question">
                                    <?php echo $faq['q']; ?>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="faq-lead-answer">
                                    <p><?php echo $faq['a']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Lead Form -->
                <div class="lead-form-box">
                    <div class="form-header">
                        <div class="form-icon">
                            <i class="fa-solid fa-edit"></i>
                        </div>
                        <h3>درخواست مشاوره رایگان</h3>
                        <p>برای دریافت مشاوره تخصصی و برآورد قیمت پروژه خود، فرم زیر را تکمیل کنید</p>
                        <div class="form-benefits">
                            <div class="benefit-item">
                                <i class="fa-solid fa-clock"></i>
                                <span>پاسخ سریع</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fa-solid fa-shield-alt"></i>
                                <span>محرمانگی</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fa-solid fa-gift"></i>
                                <span>مشاوره رایگان</span>
                            </div>
                        </div>
                    </div>
                    
                    <form class="lead-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                        <input type="hidden" name="action" value="teznevisan_contact_form">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('teznevisan_nonce'); ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name"><i class="fa-solid fa-user"></i>نام و نام خانوادگی <span class="required">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone"><i class="fa-solid fa-phone"></i>شماره تماس <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email"><i class="fa-solid fa-envelope"></i>ایمیل (اختیاری)</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="service"><i class="fa-solid fa-list"></i>نوع خدمت <span class="required">*</span></label>
                            <select id="service" name="service" class="form-control" required>
                                <option value="">انتخاب کنید</option>
                                <option value="thesis">انجام پایان‌نامه</option>
                                <option value="proposal">نوشتن پروپوزال</option>
                                <option value="article">نگارش مقاله</option>
                                <option value="analysis">تحلیل آماری</option>
                                <option value="programming">پروژه برنامه‌نویسی</option>
                                <option value="translation">ترجمه تخصصی</option>
                                <option value="other">سایر موارد</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message"><i class="fa-solid fa-comment-alt"></i>توضیحات پروژه <span class="required">*</span></label>
                            <textarea id="message" name="message" class="form-control" rows="4" placeholder="لطفاً جزئیات پروژه خود را شرح دهید..." required></textarea>
                        </div>
                        
                        <div class="form-footer">
                            <div class="privacy-notice">
                                <i class="fa-solid fa-lock"></i>
                                <span>اطلاعات شما کاملاً محرمانه نگهداری می‌شود</span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-submit btn-block">
                                <i class="fa-solid fa-paper-plane"></i>
                                درخواست مشاوره
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Final CTA Section -->
    <section class="final-cta">
        <div class="container">
            <div class="cta-content">
                <h2>ثبت سفارش خدمات پروژه دانشجویی</h2>
                <p>
                    اگر به دنبال یک تیم متخصص برای انجام پروژه‌های دانشجویی خود هستید، تز نویسان بهترین انتخاب شماست. 
                    برای شروع همکاری و دریافت مشاوره رایگان، همین حالا با ما تماس بگیرید!
                </p>
                <div class="cta-buttons">
                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" class="btn btn-white btn-lg">
                        <i class="fa-solid fa-phone"></i> تماس مستقیم
                    </a>
                    <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="btn btn-outline-white btn-lg">
                        <i class="fa-solid fa-comments"></i> درخواست مشاوره
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</main>

<?php get_footer(); ?>
