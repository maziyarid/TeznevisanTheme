        </div><!-- .main-content -->
    </div><!-- #page -->

    <!-- ENHANCED FOOTER WITH DYNAMIC MENUS -->
    <footer class="site-footer">
        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">
                    <!-- About Column -->
                    <div class="footer-col">
                        <div class="footer-logo-only">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" 
                                 alt="<?php bloginfo('name'); ?>" 
                                 class="footer-logo-image"
                                 onerror="this.src='<?php echo get_template_directory_uri(); ?>/assets/images/logo.png'">
                        </div>
                        <p><?php echo esc_html(get_theme_mod('footer_about_text', 'تیم متخصص تزنویسان با بیش از ۴۵۰ پژوهشگر و استاد مجرب، آماده ارائه بهترین خدمات در تمامی رشته‌ها و مقاطع تحصیلی با تضمین کیفیت و اصالت است.')); ?></p>
                        
                        <div class="footer-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>تضمین کیفیت و اصالت</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-clock"></i>
                                <span>تحویل به موقع</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-headset"></i>
                                <span>پشتیبانی ۲۴ ساعته</span>
                            </div>
                        </div>
                    </div>

                    <!-- DYNAMIC SERVICES COLUMN -->
                    <div class="footer-col">
                        <h4><i class="fas fa-tools"></i> <?php echo esc_html(get_theme_mod('footer_services_title', 'خدمات ما')); ?></h4>
                        
                        <?php
                        if (has_nav_menu('footer-services')) {
                            wp_nav_menu(array(
                                'theme_location' => 'footer-services',
                                'menu_class' => 'footer-menu dynamic-footer-menu',
                                'container' => false,
                                'depth' => 1
                            ));
                        } else {
                            // Fallback to services posts
                            $services = get_posts(array(
                                'post_type' => 'services',
                                'posts_per_page' => 5,
                                'orderby' => 'menu_order',
                                'order' => 'ASC'
                            ));
                            
                            if ($services) {
                                echo '<ul class="footer-menu fallback-services-menu">';
                                foreach ($services as $service) {
                                    echo '<li><a href="' . esc_url(get_permalink($service)) . '">' . esc_html(get_the_title($service)) . '</a></li>';
                                }
                                echo '</ul>';
                            } else {
                                // Final fallback
                                echo '<ul class="footer-menu static-fallback-menu">';
                                echo '<li><a href="' . esc_url(home_url('/services/thesis')) . '">نگارش پایان‌نامه</a></li>';
                                echo '<li><a href="' . esc_url(home_url('/services/proposal')) . '">نگارش پروپوزال</a></li>';
                                echo '<li><a href="' . esc_url(home_url('/services/article')) . '">نگارش مقاله علمی</a></li>';
                                echo '<li><a href="' . esc_url(home_url('/services/translation')) . '">ترجمه تخصصی</a></li>';
                                echo '<li><a href="' . esc_url(home_url('/services/editing')) . '">ویرایش و بازنویسی</a></li>';
                                echo '</ul>';
                            }
                        }
                        ?>
                        
                        <a href="<?php echo esc_url(get_post_type_archive_link('services')); ?>" class="view-all-services">
                             همه خدمات <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                    <!-- DYNAMIC QUICK LINKS COLUMN -->
                    <div class="footer-col">
                        <h4><i class="fas fa-link"></i> <?php echo esc_html(get_theme_mod('footer_links_title', 'لینک‌های مفید')); ?></h4>
                        
                        <?php
                        if (has_nav_menu('footer-links')) {
                            wp_nav_menu(array(
                                'theme_location' => 'footer-links',
                                'menu_class' => 'footer-menu dynamic-footer-menu',
                                'container' => false,
                                'depth' => 1
                            ));
                        } else {
                            // Fallback static menu
                            echo '<ul class="footer-menu static-fallback-menu">';
                            echo '<li><a href="' . esc_url(home_url('/')) . '">صفحه اصلی</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/about')) . '">درباره ما</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/blog')) . '">وبلاگ</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/contact')) . '">تماس با ما</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/privacy-policy')) . '">حریم خصوصی</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/sitemap')) . '">نقشه سایت</a></li>';
                            echo '</ul>';
                        }
                        ?>
                    </div>

                    <!-- Contact Column -->
                    <div class="footer-col">
                        <h4><i class="fas fa-mobile-alt"></i> <?php echo esc_html(get_theme_mod('footer_contact_title', 'اطلاع‌رسانی')); ?></h4>
                        <p><?php echo esc_html(get_theme_mod('footer_contact_desc', 'شماره خود را وارد کنید تا از تخفیف‌ها مطلع شوید')); ?></p>
                        <form class="footer-newsletter-form" data-newsletter-footer>
                            <input type="tel" name="phone" placeholder="شماره تماس..." required>
                            <button type="submit">عضویت</button>
                        </form>
                        
                        <div class="contact-info-footer">
                            <div class="contact-item-footer">
                                <i class="fas fa-phone"></i>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09331663849')); ?>">
                                    <?php echo esc_html(get_theme_mod('phone_number', '09331663849')); ?>
                                </a>
                            </div>
                            <div class="contact-item-footer">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address', 'setinco@gmail.com')); ?>">
                                    <?php echo esc_html(get_theme_mod('email_address', 'setinco@gmail.com')); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trust Badges Section -->
        <div class="trust-badges-section">
            <div class="container">
                <div class="trust-badges-row">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <div class="trust-badge">
                            <i class="fas fa-<?php echo $i === 1 ? 'shield-alt' : ($i === 2 ? 'certificate' : ($i === 3 ? 'shield-check' : ($i === 4 ? 'trophy' : 'headset'))); ?>"></i>
                            <div class="trust-content">
                                <strong><?php echo esc_html(get_theme_mod('trust_badge_' . $i . '_title', ($i === 1 ? 'پرداخت امن' : ($i === 2 ? 'مجوز رسمی' : ($i === 3 ? 'تضمین امنیت' : ($i === 4 ? 'جایزه کیفیت' : 'پشتیبانی ۲۴/۷')))))); ?></strong>
                                <small><?php echo esc_html(get_theme_mod('trust_badge_' . $i . '_desc', ($i === 1 ? 'SSL Certificate' : ($i === 2 ? 'Licensed Business' : ($i === 3 ? 'Security Guaranteed' : ($i === 4 ? 'Quality Award' : 'Always Available')))))); ?></small>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        
        <!-- Copyright Section -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. تمامی حقوق محفوظ است.</p>
                    <p class="copyright-note"><?php echo get_theme_mod('footer_copyright_text', 'طراحی و توسعه با 💚 توسط تیم تزنویسان'); ?></p>
                </div>
            </div>
        </div>
    </footer>

<style>
/* CSS Variables */
:root {
    --primary-color: #1FA547;
    --primary-dark: #178A3A;
    --primary-light: #2FD65A;
    --bg-main: #FFFFFF;
    --bg-secondary: #F8F9FA;
    --text-primary: #212529;
    --text-secondary: #495057;
    --text-muted: #6C757D;
    --border-color: #DEE2E6;
}

[data-theme="dark"] {
    --bg-main: #0D1117;
    --bg-secondary: #161B22;
    --text-primary: #F0F6FC;
    --text-secondary: #C9D1D9;
    --text-muted: #8B949E;
    --border-color: #30363D;
}

[data-theme="sepia"] {
    --bg-main: #F4ECD8;
    --bg-secondary: #EBE3D0;
    --text-primary: #3E2723;
    --text-secondary: #4E342E;
    --text-muted: #5D4037;
    --border-color: #BCAAA4;
}

/* Enhanced Footer Styles with Dynamic Menu Support */
.site-footer {
    background: #252525;
    color: white;
    margin: 0;
    position: relative;
    font-family: inherit;
}

.footer-main {
    padding: 3rem 0 2rem;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 2.5rem;
    align-items: start;
}

.footer-col h4 {
    color: var(--primary-color);
    margin: 0 0 1.5rem 0;
    font-size: 1.2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.footer-col h4 i {
    font-size: 1.1rem;
    color: var(--primary-light);
}

/* Logo Only - No Text */
.footer-logo-only {
    text-align: center;
    margin-bottom: 1.5rem;
}

.footer-logo-image {
    height: 60px;
    width: auto;
    filter: brightness(0) invert(1);
    transition: transform 0.3s ease;
}

.footer-logo-only:hover .footer-logo-image {
    transform: scale(1.05);
}

.footer-col p {
    line-height: 1.7;
    margin-bottom: 1.5rem;
    color: #ccc;
    text-align: justify;
    font-family: inherit;
}

.footer-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.feature-item:hover {
    background: rgba(31, 165, 71, 0.1);
    transform: translateX(-3px);
}

.feature-item i {
    color: var(--primary-light);
    width: 18px;
    text-align: center;
}

/* ENHANCED DYNAMIC FOOTER MENU STYLES */
.footer-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-menu li {
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.footer-menu a {
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
    font-family: inherit;
    padding: 0.5rem 0;
    display: block;
    position: relative;
}

.footer-menu a::before {
    content: '';
    position: absolute;
    right: -10px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 2px;
    background: var(--primary-color);
    transition: width 0.3s ease;
}

.footer-menu a:hover {
    color: var(--primary-color);
    padding-right: 15px;
    transform: translateX(-3px);
}

.footer-menu a:hover::before {
    width: 10px;
}

/* Dynamic Menu Specific Styles */
.dynamic-footer-menu a {
    font-weight: 500;
}

.fallback-services-menu a {
    font-weight: 400;
    font-size: 0.95rem;
}

.static-fallback-menu a {
    color: #bbb;
    font-size: 0.9rem;
}

.view-all-services {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    margin-top: 1rem;
    padding: 0.75rem 1rem;
    background: rgba(31, 165, 71, 0.1);
    border-radius: 20px;
    border: 1px solid rgba(31, 165, 71, 0.3);
    transition: all 0.3s ease;
    font-family: inherit;
}

.view-all-services:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(-3px);
}

/* Newsletter Form */
.footer-newsletter-form {
    display: flex;
    gap: 0.5rem;
    margin: 1rem 0 1.5rem 0;
}

.footer-newsletter-form input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid #444;
    border-radius: 8px;
    background: transparent;
    color: white;
    font-size: 0.9rem;
    font-family: inherit;
    direction: rtl;
    text-align: right;
    transition: all 0.3s ease;
}

.footer-newsletter-form input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(31, 165, 71, 0.2);
    outline: none;
}

.footer-newsletter-form button {
    padding: 0.75rem 1rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    font-family: inherit;
    transition: all 0.3s ease;
}

.footer-newsletter-form button:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.contact-info-footer {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.contact-item-footer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-family: inherit;
    transition: all 0.3s ease;
}

.contact-item-footer:hover {
    transform: translateX(-3px);
}

.contact-item-footer i {
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

.contact-item-footer a {
    color: #ccc;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.contact-item-footer a:hover {
    color: var(--primary-color);
}

/* Trust Badges */
.trust-badges-section {
    background: rgba(255, 255, 255, 0.05);
    padding: 2rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.trust-badges-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.trust-badge {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    transition: all 0.3s ease;
    min-width: 160px;
    justify-content: center;
    flex: 1;
    max-width: 220px;
}

.trust-badge:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.trust-badge i {
    font-size: 1.5rem;
    color: var(--primary-color);
    flex-shrink: 0;
}

.trust-content {
    text-align: center;
    flex: 1;
}

.trust-content strong {
    display: block;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    font-weight: 600;
    font-family: inherit;
    color: white;
}

.trust-content small {
    color: #ccc;
    font-size: 0.75rem;
    font-family: inherit;
}

/* Copyright */
.footer-bottom {
    background: rgba(0, 0, 0, 0.3);
    padding: 1.5rem 0;
    text-align: center;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-bottom-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.footer-bottom p {
    margin: 0;
    color: #ccc;
    font-size: 0.9rem;
    font-family: inherit;
}

.copyright-note {
    color: #999;
    font-size: 0.8rem;
    font-family: inherit;
}

/* Responsive Footer */
@media (max-width: 1024px) {
    .footer-grid {
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 2rem;
    }
    
    .trust-badges-row {
        gap: 1rem;
    }
    
    .trust-badge {
        min-width: 140px;
        padding: 0.875rem 1rem;
    }
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
    
    .footer-col p {
        text-align: center;
    }
    
    .footer-features {
        align-items: center;
    }
    
    .trust-badges-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .trust-badge {
        min-width: 120px;
        font-size: 0.85rem;
    }
    
    .footer-newsletter-form {
        flex-direction: column;
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .footer-main {
        padding: 2rem 0 1.5rem;
    }
    
    .footer-grid {
        gap: 1.5rem;
    }
    
    .trust-badges-row {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .trust-badge {
        padding: 0.75rem 1rem;
        min-width: auto;
    }
    
    .footer-col h4 {
        font-size: 1.1rem;
    }
    
    .footer-menu a {
        padding: 0.375rem 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Newsletter Form Handler
    const newsletterForm = document.querySelector('[data-newsletter-footer]');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const phoneInput = this.querySelector('input[name="phone"]');
            const submitBtn = this.querySelector('button[type="submit"]');
            const phone = phoneInput.value.trim();
            
            // Basic Iranian phone number validation
            if (!phone || !/^(\+98|0)?9\d{9}$/.test(phone)) {
                alert('لطفاً شماره تماس معتبر وارد کنید');
                phoneInput.focus();
                return;
            }
            
            // Show loading state
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'در حال ارسال...';
            submitBtn.disabled = true;
            
            // Simulate AJAX call (replace with actual implementation)
            const formData = new FormData();
            formData.append('action', 'newsletter_signup');
            formData.append('phone', phone);
            formData.append('nonce', teznevisanAjax?.nonce || '');
            
            fetch(teznevisanAjax?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('شماره شما در لیست اطلاع‌رسانی ثبت شد!');
                    phoneInput.value = '';
                } else {
                    alert(data.data || 'خطا در ثبت شماره');
                }
            })
            .catch(error => {
                console.error('Newsletter signup error:', error);
                alert('خطا در ارسال درخواست');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Enhanced footer animations
    const footerElements = document.querySelectorAll('.footer-col, .trust-badge');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    footerElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
});
</script>

<?php wp_footer(); ?>

</body>
</html>