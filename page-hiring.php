<?php
/*
Template Name: Hiring
*/
get_header(); ?>

<main id="main-content" class="hiring-page-main">
    
    <!-- Hiring Hero -->
    <section class="hiring-hero">
        <div class="container">
            <div class="hiring-hero-content">
                <div class="hero-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h1 class="hiring-title">دعوت به همکاری</h1>
                <p class="hiring-subtitle">
                    موسسه تز نویسان از فارغ‌التحصیلان مقطع ارشد و دکتری دعوت به همکاری می‌نماید
                </p>
                <div class="hiring-intro">
                    <p>
                        از علاقه‌مندان و واجدین شرایط درخواست می‌گردد لطفاً رزومه خود را از طریق 
                        فرم انتهای صفحه بارگذاری کرده تا از منابع انسانی با شما تماس حاصل گردد.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Requirements Section -->
    <section class="requirements-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">شرایط همکاری</h2>
                <p class="section-subtitle">
                    افرادی که قصد همکاری در زمینه انجام پایان‌نامه ارشد، رساله دکتری و مقاله را دارند
                </p>
            </div>
            
            <div class="requirements-grid">
                <?php
                $requirements = array(
                    array(
                        'title' => 'نمره پایان‌نامه',
                        'description' => 'نمره پایان‌نامه شما حداقل بالاتر از ۱۷ باشد',
                        'icon' => 'fas fa-chart-line',
                        'color' => '#e74c3c'
                    ),
                    array(
                        'title' => 'مدرک تحصیلی',
                        'description' => 'فارغ‌التحصیل مقطع ارشد و دکتری یا دانشجوی دکتری باشید',
                        'icon' => 'fas fa-graduation-cap',
                        'color' => '#3498db'
                    ),
                    array(
                        'title' => 'انتشارات علمی',
                        'description' => 'مقالات ISI با نام خود در ژورنال‌های خارج از کشور چاپ شده باشد',
                        'icon' => 'fas fa-newspaper',
                        'color' => '#2ecc71'
                    ),
                    array(
                        'title' => 'تسلط به زبان انگلیسی',
                        'description' => 'تسلط کامل به زبان انگلیسی برای ترجمه و نگارش',
                        'icon' => 'fas fa-language',
                        'color' => '#f39c12'
                    ),
                    array(
                        'title' => 'روش تحقیق',
                        'description' => 'تسلط کامل به روش‌های تحقیق کمی و کیفی',
                        'icon' => 'fas fa-microscope',
                        'color' => '#9b59b6'
                    ),
                    array(
                        'title' => 'نرم‌افزارهای تخصصی',
                        'description' => 'تسلط کامل به نرم‌افزارهای مربوط به رشته خودتان',
                        'icon' => 'fas fa-laptop-code',
                        'color' => '#1abc9c'
                    ),
                    array(
                        'title' => 'علاقه به پژوهش',
                        'description' => 'علاقه‌مند به مطالعه و انجام امور پژوهشی باشید',
                        'icon' => 'fas fa-heart',
                        'color' => '#e67e22'
                    ),
                    array(
                        'title' => 'پایبندی به ارزش‌ها',
                        'description' => 'ارزش‌های تز نویسان را ارزش‌های خود دانسته و پایبند باشید',
                        'icon' => 'fas fa-handshake',
                        'color' => '#34495e'
                    )
                );
                
                foreach ($requirements as $requirement) :
                ?>
                    <div class="requirement-card" style="--req-color: <?php echo esc_attr($requirement['color']); ?>">
                        <div class="requirement-icon">
                            <i class="<?php echo esc_attr($requirement['icon']); ?>"></i>
                        </div>
                        <div class="requirement-content">
                            <h4><?php echo esc_html($requirement['title']); ?></h4>
                            <p><?php echo esc_html($requirement['description']); ?></p>
                        </div>
                        <div class="requirement-check">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Positions Section -->
    <section class="positions-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">موقعیت‌های شغلی</h2>
                <p class="section-subtitle">پژوهشگران در نقش‌های زیر می‌توانند در تیم تز نویسان عضو شوند</p>
            </div>
            
            <div class="positions-grid">
                <?php
                $positions = array(
                    array(
                        'title' => 'پایان‌نامه‌نویس',
                        'description' => 'نگارش پایان‌نامه‌های کارشناسی ارشد و دکتری در رشته‌های مختلف',
                        'icon' => 'fas fa-pen-fancy',
                        'requirements' => array('مدرک ارشد یا دکتری', 'تجربه نگارش', 'تسلط به روش تحقیق'),
                        'type' => 'part-time'
                    ),
                    array(
                        'title' => 'مقاله‌نویس',
                        'description' => 'نگارش مقالات علمی ISI، ISC و کنفرانس‌های بین‌المللی',
                        'icon' => 'fas fa-file-alt',
                        'requirements' => array('انتشارات ISI', 'تسلط به انگلیسی', 'تجربه نگارش مقاله'),
                        'type' => 'freelance'
                    ),
                    array(
                        'title' => 'متخصص تحلیل آماری',
                        'description' => 'تحلیل داده‌ها با نرم‌افزارهای SPSS، R، Python و MATLAB',
                        'icon' => 'fas fa-chart-bar',
                        'requirements' => array('تسلط به SPSS/R', 'تجربه تحلیل', 'دانش آماری قوی'),
                        'type' => 'part-time'
                    ),
                    array(
                        'title' => 'متخصص شبیه‌سازی',
                        'description' => 'انجام شبیه‌سازی‌های پیشرفته در زمینه‌های مختلف مهندسی',
                        'icon' => 'fas fa-cogs',
                        'requirements' => array('تسلط به نرم‌افزارهای شبیه‌سازی', 'مدرک مهندسی', 'تجربه کاری'),
                        'type' => 'project-based'
                    ),
                    array(
                        'title' => 'مترجم متون آکادمیک',
                        'description' => 'ترجمه متون تخصصی، علمی و آکادمیک از انگلیسی به فارسی و برعکس',
                        'icon' => 'fas fa-language',
                        'requirements' => array('تسلط کامل انگلیسی', 'تجربه ترجمه', 'دانش تخصصی'),
                        'type' => 'freelance'
                    ),
                    array(
                        'title' => 'دستیار پژوهشگر',
                        'description' => 'تایپ، جدول‌سازی، نمودار، پاورپوینت و کارهای پشتیبانی پژوهش',
                        'icon' => 'fas fa-user-cog',
                        'requirements' => array('مهارت تایپ سریع', 'آشنایی با آفیس', 'دقت بالا'),
                        'type' => 'part-time'
                    )
                );
                
                foreach ($positions as $position) :
                    $type_labels = array(
                        'full-time' => 'تمام وقت',
                        'part-time' => 'پاره وقت',
                        'freelance' => 'فریلنسر',
                        'project-based' => 'پروژه‌ای'
                    );
                    $type_colors = array(
                        'full-time' => '#e74c3c',
                        'part-time' => '#3498db',
                        'freelance' => '#2ecc71',
                        'project-based' => '#f39c12'
                    );
                ?>
                    <div class="position-card">
                        <div class="position-header">
                            <div class="position-icon">
                                <i class="<?php echo esc_attr($position['icon']); ?>"></i>
                            </div>
                            <div class="position-type" 
                                 style="background: <?php echo esc_attr($type_colors[$position['type']]); ?>">
                                <?php echo esc_html($type_labels[$position['type']]); ?>
                            </div>
                        </div>
                        
                        <div class="position-content">
                            <h4><?php echo esc_html($position['title']); ?></h4>
                            <p><?php echo esc_html($position['description']); ?></p>
                            
                            <div class="position-requirements">
                                <h5>الزامات:</h5>
                                <ul>
                                    <?php foreach ($position['requirements'] as $req) : ?>
                                        <li>
                                            <i class="fas fa-check"></i>
                                            <?php echo esc_html($req); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="position-footer">
                            <a href="#application-form" class="apply-btn scroll-to">
                                <i class="fas fa-paper-plane"></i>
                                درخواست همکاری
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Application Form -->
    <section id="application-form" class="application-section">
        <div class="container">
            <div class="application-wrapper">
                <div class="application-header">
                    <h2>فرم درخواست همکاری</h2>
                    <p>لطفاً اطلاعات خود را کامل و دقیق وارد کنید</p>
                </div>
                
                <form class="hiring-application-form" id="hiring-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="applicant_name">
                                <i class="fas fa-user"></i>
                                نام و نام خانوادگی
                                <span class="required">*</span>
                            </label>
                            <input type="text" id="applicant_name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_phone">
                                <i class="fas fa-phone"></i>
                                شماره تماس
                                <span class="required">*</span>
                            </label>
                            <input type="tel" id="applicant_phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_email">
                                <i class="fas fa-envelope"></i>
                                آدرس ایمیل
                                <span class="required">*</span>
                            </label>
                            <input type="email" id="applicant_email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_position">
                                <i class="fas fa-briefcase"></i>
                                موقعیت مورد نظر
                                <span class="required">*</span>
                            </label>
                            <select id="applicant_position" name="position" required>
                                <option value="">انتخاب موقعیت</option>
                                <option value="thesis-writer">پایان‌نامه‌نویس</option>
                                <option value="article-writer">مقاله‌نویس</option>
                                <option value="statistical-analyst">متخصص تحلیل آماری</option>
                                <option value="simulation-expert">متخصص شبیه‌سازی</option>
                                <option value="translator">مترجم متون آکادمیک</option>
                                <option value="research-assistant">دستیار پژوهشگر</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_degree">
                                <i class="fas fa-graduation-cap"></i>
                                بالاترین مدرک تحصیلی
                                <span class="required">*</span>
                            </label>
                            <select id="applicant_degree" name="degree" required>
                                <option value="">انتخاب مدرک</option>
                                <option value="master">کارشناسی ارشد</option>
                                <option value="phd">دکتری</option>
                                <option value="postdoc">فوق دکتری</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_field">
                                <i class="fas fa-book"></i>
                                رشته تحصیلی
                                <span class="required">*</span>
                            </label>
                            <input type="text" id="applicant_field" name="field" placeholder="مثال: مهندسی کامپیوتر" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_university">
                                <i class="fas fa-university"></i>
                                دانشگاه محل تحصیل
                            </label>
                            <input type="text" id="applicant_university" name="university" placeholder="نام دانشگاه">
                        </div>
                        
                        <div class="form-group">
                            <label for="applicant_experience">
                                <i class="fas fa-clock"></i>
                                سال‌های تجربه
                            </label>
                            <select id="applicant_experience" name="experience">
                                <option value="">انتخاب تجربه</option>
                                <option value="0-1">کمتر از ۱ سال</option>
                                <option value="1-3">۱ تا ۳ سال</option>
                                <option value="3-5">۳ تا ۵ سال</option>
                                <option value="5+">بیش از ۵ سال</option>
                            </select>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="applicant_skills">
                                <i class="fas fa-cogs"></i>
                                مهارت‌ها و تخصص‌ها
                            </label>
                            <textarea id="applicant_skills" name="skills" rows="4" 
                                      placeholder="نرم‌افزارها، زبان‌ها، مهارت‌های تخصصی و سایر توانایی‌های خود را شرح دهید..."></textarea>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="applicant_publications">
                                <i class="fas fa-newspaper"></i>
                                سوابق انتشارات (در صورت وجود)
                            </label>
                            <textarea id="applicant_publications" name="publications" rows="3" 
                                      placeholder="مقالات ISI، ISC، کنفرانس‌ها و سایر انتشارات خود را ذکر کنید..."></textarea>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="applicant_resume">
                                <i class="fas fa-file-upload"></i>
                                بارگذاری رزومه
                                <span class="required">*</span>
                            </label>
                            <div class="file-upload-area" id="resume-upload">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>رزومه خود را اینجا بکشید یا کلیک کنید</p>
                                    <span class="upload-formats">فرمت‌های مجاز: PDF, DOC, DOCX</span>
                                </div>
                                <input type="file" id="resume-file" name="resume" accept=".pdf,.doc,.docx" required hidden>
                            </div>
                            <div class="uploaded-file" id="uploaded-file" style="display: none;">
                                <div class="file-info">
                                    <i class="fas fa-file-alt"></i>
                                    <span class="file-name"></span>
                                    <button type="button" class="remove-file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="applicant_motivation">
                                <i class="fas fa-heart"></i>
                                انگیزه همکاری
                                <span class="required">*</span>
                            </label>
                            <textarea id="applicant_motivation" name="motivation" rows="4" 
                                      placeholder="چرا می‌خواهید با تز نویسان همکاری کنید؟ انگیزه و اهداف خود را شرح دهید..." required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-submit-section">
                        <div class="privacy-agreement">
                            <label class="checkbox-label">
                                <input type="checkbox" name="privacy_agreement" required>
                                <span class="checkmark"></span>
                                <span class="agreement-text">
                                    با <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>" target="_blank">شرایط و قوانین</a> 
                                    همکاری موافقم و اطلاعات ارائه شده صحیح است
                                </span>
                            </label>
                        </div>
                        
                        <button type="submit" class="application-submit-btn">
                            <span class="btn-content">
                                <i class="fas fa-paper-plane"></i>
                                ارسال درخواست همکاری
                            </span>
                            <span class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                در حال ارسال...
                            </span>
                        </button>
                        
                        <div class="form-note">
                            <i class="fas fa-info-circle"></i>
                            <span>پس از بررسی، طی ۷۲ ساعت با شما تماس خواهیم گرفت</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Hiring Page Styles */
.hiring-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

.hiring-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
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
}

.hiring-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    font-family: inherit;
}

.hiring-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    font-family: inherit;
}

.hiring-intro p {
    font-size: 1rem;
    line-height: 1.7;
    max-width: 800px;
    margin: 0 auto;
    opacity: 0.9;
    font-family: inherit;
}

/* Requirements */
.requirements-section {
    padding: 5rem 0;
}

.requirements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.requirement-card {
    background: var(--bg-main);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.requirement-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--req-color);
}

.requirement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    border-color: var(--req-color);
}

.requirement-icon {
    width: 60px;
    height: 60px;
    background: var(--req-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.requirement-content h4 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    font-family: inherit;
}

.requirement-content p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.requirement-check {
    position: absolute;
    top: 1rem;
    left: 1rem;
    color: #28a745;
    font-size: 1.2rem;
}

/* Positions */
.positions-section {
    background: var(--bg-main);
    padding: 5rem 0;
}

.positions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.position-card {
    background: var(--bg-secondary);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.position-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
}

.position-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: var(--bg-main);
    border-bottom: 1px solid var(--border-color);
}

.position-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.position-type {
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

.position-content {
    padding: 2rem;
}

.position-content h4 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    font-family: inherit;
}

.position-content p {
    margin: 0 0 1.5rem 0;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.position-requirements h5 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 600;
    font-family: inherit;
}

.position-requirements ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.position-requirements li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.position-requirements li i {
    color: #28a745;
    font-size: 0.9rem;
}

.position-footer {
    padding: 1.5rem 2rem;
    background: var(--bg-main);
    border-top: 1px solid var(--border-color);
    text-align: center;
}

.apply-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.apply-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
    color: white;
}

/* Application Form */
.application-section {
    background: var(--bg-secondary);
    padding: 5rem 0;
}

.application-wrapper {
    max-width: 800px;
    margin: 0 auto;
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.application-header {
    background: var(--primary-color);
    color: white;
    padding: 2.5rem;
    text-align: center;
}

.application-header h2 {
    margin: 0 0 1rem 0;
    font-size: 1.8rem;
    font-weight: 700;
    font-family: inherit;
}

.application-header p {
    margin: 0;
    opacity: 0.9;
    font-family: inherit;
}

.hiring-application-form {
    padding: 3rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
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
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(31, 165, 71, 0.1);
    outline: none;
    background: var(--bg-main);
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
    border-color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
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

.uploaded-file {
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-info i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.file-name {
    flex: 1;
    font-weight: 500;
    color: var(--text-primary);
    font-family: inherit;
}

.remove-file {
    background: #dc3545;
    color: white;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-submit-section {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.privacy-agreement {
    margin-bottom: 2rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-family: inherit;
    justify-content: center;
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

.agreement-text {
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

.agreement-text a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.application-submit-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 1.5rem 3rem;
    border-radius: 30px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.application-submit-btn:hover {
    background: linear-gradient(135deg, var(--primary-dark), #0f5d2a);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(31, 165, 71, 0.4);
}

.application-submit-btn .btn-content,
.application-submit-btn .btn-loading {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
}

.application-submit-btn .btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.application-submit-btn.loading .btn-content {
    opacity: 0;
}

.application-submit-btn.loading .btn-loading {
    opacity: 1;
}

.form-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    color: var(--text-muted);
    font-size: 0.9rem;
    font-family: inherit;
}

.form-note i {
    color: var(--primary-color);
}

@media (max-width: 768px) {
    .hiring-hero {
        padding: 3rem 0;
    }
    
    .hiring-title {
        font-size: 2.5rem;
    }
    
    .requirements-grid {
        grid-template-columns: 1fr;
    }
    
    .positions-grid {
        grid-template-columns: 1fr;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .hiring-application-form {
        padding: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload functionality
    const fileUploadArea = document.getElementById('resume-upload');
    const fileInput = document.getElementById('resume-file');
    const uploadedFile = document.getElementById('uploaded-file');
    
    if (fileUploadArea && fileInput) {
        fileUploadArea.addEventListener('click', () => fileInput.click());
        
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--primary-color)';
            this.style.background = 'rgba(31, 165, 71, 0.05)';
        });
        
        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '';
            this.style.background = '';
        });
        
        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '';
            this.style.background = '';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                displayUploadedFile(files[0]);
            }
        });
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                displayUploadedFile(this.files[0]);
            }
        });
    }
    
    function displayUploadedFile(file) {
        const fileName = uploadedFile.querySelector('.file-name');
        fileName.textContent = file.name;
        uploadedFile.style.display = 'block';
        fileUploadArea.style.display = 'none';
    }
    
    // Remove file
    const removeFileBtn = document.querySelector('.remove-file');
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            fileInput.value = '';
            uploadedFile.style.display = 'none';
            fileUploadArea.style.display = 'block';
        });
    }
    
    // Form submission
    const hiringForm = document.getElementById('hiring-form');
    if (hiringForm) {
        hiringForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.application-submit-btn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('درخواست همکاری شما ثبت شد! طی ۷۲ ساعت با شما تماس خواهیم گرفت.');
                this.reset();
                uploadedFile.style.display = 'none';
                fileUploadArea.style.display = 'block';
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }, 3000);
        });
    }
    
    // Smooth scroll for apply buttons
    document.querySelectorAll('.scroll-to').forEach(link => {
        link.addEventListener('click', function(e) {
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
});
</script>

<?php get_footer(); ?>