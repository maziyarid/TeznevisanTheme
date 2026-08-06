<?php
/**
 * Single Services Template - Rewritten for Teznevisan Theme
 * Handles all service display with proper error handling
 */

get_header();

// Get service data with proper fallbacks
global $post;
$post_id = get_the_ID();

// Get all service meta with proper fallbacks
$service_data = array(
    // Basic info
    'service_subtitle' => get_post_meta($post_id, 'service_subtitle', true) ?: '',
    'service_excerpt' => get_post_meta($post_id, 'service_excerpt', true) ?: '',
    
    // Hero section
    'hero_headline' => get_post_meta($post_id, 'hero_headline', true) ?: get_post_meta($post_id, 'service_hero_title', true) ?: get_the_title(),
    'hero_description' => get_post_meta($post_id, 'hero_description', true) ?: get_post_meta($post_id, 'service_hero_subtitle', true) ?: '',
    'hero_image' => get_post_meta($post_id, 'service_hero_image', true) ?: '',
    'lottie_animation' => get_post_meta($post_id, 'lottie_animation_url', true) ?: '',
    
    // Content titles
    'content_title_1' => get_post_meta($post_id, 'content_title_1', true) ?: 'توضیحات خدمت',
    'content_title_2' => get_post_meta($post_id, 'content_title_2', true) ?: 'ویژگی‌های خدمت',
    
    // Pricing - Check both new and legacy fields
    'price_min' => get_post_meta($post_id, 'price_range_min', true) ?: get_post_meta($post_id, 'service_price_min', true) ?: 0,
    'price_max' => get_post_meta($post_id, 'price_range_max', true) ?: get_post_meta($post_id, 'service_price_max', true) ?: 0,
    'delivery_time' => get_post_meta($post_id, 'delivery_time', true) ?: '',
    'completed_projects' => get_post_meta($post_id, 'completed_projects', true) ?: '',
    'satisfaction_rate' => get_post_meta($post_id, 'satisfaction_rate', true) ?: '',
    
    // Features
    'service_features' => get_post_meta($post_id, 'service_features', true) ?: array(),
    
    // Process steps
    'process_steps' => get_post_meta($post_id, 'process_steps', true) ?: array(),
    'legacy_steps' => get_post_meta($post_id, 'service_steps', true) ?: array(),
    
    // FAQ
    'service_faq' => get_post_meta($post_id, 'service_faq', true) ?: array(),
    
    // Related services
    'related_services' => array_merge(
        (array)get_post_meta($post_id, 'related_services', true),
        (array)get_post_meta($post_id, 'service_related', true)
    ),
    
    // CTA
    'cta_text' => get_post_meta($post_id, 'service_cta_text', true) ?: 'سفارش این خدمت',
    'cta_url' => get_post_meta($post_id, 'service_cta_url', true) ?: '#contact',
);

// Extract variables for easier use
extract($service_data);
?>

<div class="services-page-wrapper">
    <!-- Hero Section -->
    <section class="services-hero">
        <div class="hero-background">
            <?php if ($hero_image): ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="تصویر پس‌زمینه <?php echo esc_attr(get_the_title()); ?>" class="hero-bg-image">
                <div class="hero-overlay"></div>
            <?php endif; ?>
        </div>
        
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hero-text">
                        <?php if ($service_subtitle): ?>
                            <span class="hero-subtitle"><?php echo esc_html($service_subtitle); ?></span>
                        <?php endif; ?>
                        
                        <h1 class="hero-title"><?php echo esc_html($hero_headline); ?></h1>
                        
                        <?php if ($hero_description): ?>
                            <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
                        <?php endif; ?>
                        
                        <!-- Service Stats -->
                        <?php if ($price_min || $price_max || $delivery_time || $completed_projects || $satisfaction_rate): ?>
                            <div class="hero-stats">
                                <?php if ($price_min && $price_max): ?>
                                    <div class="stat-item">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span class="stat-label">قیمت:</span>
                                        <span class="stat-value"><?php echo number_format($price_min); ?> - <?php echo number_format($price_max); ?> تومان</span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($delivery_time): ?>
                                    <div class="stat-item">
                                        <i class="fas fa-clock"></i>
                                        <span class="stat-label">زمان تحویل:</span>
                                        <span class="stat-value"><?php echo esc_html($delivery_time); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($completed_projects): ?>
                                    <div class="stat-item">
                                        <i class="fas fa-chart-line"></i>
                                        <span class="stat-label">پروژه‌های انجام شده:</span>
                                        <span class="stat-value"><?php echo esc_html($completed_projects); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($satisfaction_rate): ?>
                                    <div class="stat-item">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="stat-label">رضایت مشتریان:</span>
                                        <span class="stat-value"><?php echo esc_html($satisfaction_rate); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="hero-cta">
                            <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-cart"></i>
                                <?php echo esc_html($cta_text); ?>
                            </a>
                            <a href="#service-content" class="btn btn-outline-primary btn-lg scroll-to">
                                <i class="fas fa-info-circle"></i>
                                اطلاعات بیشتر
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <div class="hero-visual">
                        <?php if ($lottie_animation): ?>
                            <div class="lottie-container" data-lottie="<?php echo esc_url($lottie_animation); ?>"></div>
                        <?php else: ?>
                            <div class="hero-placeholder">
                                <i class="fas fa-cogs hero-icon"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container services-content" id="service-content">
        <div class="row">
            <div class="col-lg-8">
                <!-- Service Description -->
                <section class="content-section">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        <?php echo esc_html($content_title_1); ?>
                    </h2>
                    
                    <div class="service-description">
                        <?php 
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                the_content();
                            endwhile;
                        endif;
                        ?>
                    </div>
                </section>

                <!-- Service Features -->
                <?php if (!empty($service_features) && is_array($service_features)): ?>
                    <section class="content-section features-section">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            <?php echo esc_html($content_title_2); ?>
                        </h2>
                        
                        <div class="features-grid">
                            <?php foreach ($service_features as $feature): ?>
                                <?php if (!empty($feature['title'])): ?>
                                    <div class="feature-card">
                                        <div class="feature-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="feature-content">
                                            <h4 class="feature-title"><?php echo esc_html($feature['title']); ?></h4>
                                            <?php if (!empty($feature['description'])): ?>
                                                <p class="feature-description"><?php echo esc_html($feature['description']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- How It Works -->
                <?php 
                $all_steps = array();
                
                // Add new format steps
                if (!empty($process_steps) && is_array($process_steps)) {
                    foreach ($process_steps as $step) {
                        if (!empty($step['title'])) {
                            $all_steps[] = array(
                                'title' => $step['title'],
                                'description' => $step['description'] ?? '',
                                'duration' => $step['duration'] ?? ''
                            );
                        }
                    }
                }
                
                // Add legacy steps
                if (!empty($legacy_steps) && is_array($legacy_steps)) {
                    foreach ($legacy_steps as $step) {
                        if (!empty($step)) {
                            $all_steps[] = array(
                                'title' => 'مرحله ' . (count($all_steps) + 1),
                                'description' => $step,
                                'duration' => ''
                            );
                        }
                    }
                }
                ?>
                
                <?php if (!empty($all_steps)): ?>
                    <section class="content-section process-section">
                        <h2 class="section-title">
                            <i class="fas fa-cogs"></i>
                            چگونه کار می‌کنیم؟
                        </h2>
                        
                        <div class="process-timeline">
                            <?php foreach ($all_steps as $index => $step): ?>
                                <div class="process-step">
                                    <div class="step-number"><?php echo $index + 1; ?></div>
                                    <div class="step-content">
                                        <h4 class="step-title"><?php echo esc_html($step['title']); ?></h4>
                                        <?php if (!empty($step['description'])): ?>
                                            <p class="step-description"><?php echo esc_html($step['description']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($step['duration'])): ?>
                                            <span class="step-duration">
                                                <i class="fas fa-clock"></i>
                                                <?php echo esc_html($step['duration']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- FAQ Section -->
                <?php if (!empty($service_faq) && is_array($service_faq)): ?>
                    <section class="content-section faq-section">
                        <h2 class="section-title">
                            <i class="fas fa-question-circle"></i>
                            سوالات متداول
                        </h2>
                        
                        <div class="faq-accordion">
                            <?php foreach ($service_faq as $index => $faq): ?>
                                <?php 
                                // Handle both new and legacy FAQ formats
                                $question = $faq['question'] ?? $faq['q'] ?? '';
                                $answer = $faq['answer'] ?? $faq['a'] ?? '';
                                ?>
                                <?php if (!empty($question) && !empty($answer)): ?>
                                    <div class="faq-item">
                                        <div class="faq-question" data-toggle="faq-<?php echo $index; ?>">
                                            <h4><?php echo esc_html($question); ?></h4>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="faq-answer" id="faq-<?php echo $index; ?>">
                                            <p><?php echo esc_html($answer); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="services-sidebar">
                    <!-- Quick Contact Card -->
                    <div class="sidebar-card contact-card">
                        <h3 class="card-title">
                            <i class="fas fa-phone"></i>
                            تماس سریع
                        </h3>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>۰۲۱-۸۸۳۶۴۸۵۸</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>info@teznevisan.com</span>
                            </div>
                            <div class="contact-item">
                                <i class="fab fa-whatsapp"></i>
                                <span>۰۹۱۲۳۴۵۶۷۸۹</span>
                            </div>
                        </div>
                        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-success btn-block">
                            <i class="fas fa-shopping-cart"></i>
                            <?php echo esc_html($cta_text); ?>
                        </a>
                    </div>

                    <!-- Service Info Card -->
                    <div class="sidebar-card info-card">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            اطلاعات خدمت
                        </h3>
                        <div class="info-list">
                            <?php if ($price_min && $price_max): ?>
                                <div class="info-item">
                                    <span class="info-label">محدوده قیمت:</span>
                                    <span class="info-value"><?php echo number_format($price_min); ?> - <?php echo number_format($price_max); ?> تومان</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($delivery_time): ?>
                                <div class="info-item">
                                    <span class="info-label">زمان تحویل:</span>
                                    <span class="info-value"><?php echo esc_html($delivery_time); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($completed_projects): ?>
                                <div class="info-item">
                                    <span class="info-label">پروژه‌های انجام شده:</span>
                                    <span class="info-value"><?php echo esc_html($completed_projects); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($satisfaction_rate): ?>
                                <div class="info-item">
                                    <span class="info-label">رضایت مشتریان:</span>
                                    <span class="info-value"><?php echo esc_html($satisfaction_rate); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Related Services -->
                    <?php 
                    $related_services = array_filter(array_unique($related_services));
                    if (!empty($related_services)): 
                        $related_posts = get_posts(array(
                            'post_type' => 'services',
                            'include' => $related_services,
                            'posts_per_page' => 3
                        ));
                    ?>
                        <?php if (!empty($related_posts)): ?>
                            <div class="sidebar-card related-services">
                                <h3 class="card-title">
                                    <i class="fas fa-link"></i>
                                    خدمات مرتبط
                                </h3>
                                <div class="related-services-list">
                                    <?php foreach ($related_posts as $related): ?>
                                        <div class="related-service-item">
                                            <h4 class="related-service-title">
                                                <a href="<?php echo get_permalink($related->ID); ?>">
                                                    <?php echo esc_html($related->post_title); ?>
                                                </a>
                                            </h4>
                                            <p class="related-service-excerpt">
                                                <?php echo wp_trim_words($related->post_excerpt ?: $related->post_content, 15); ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// FAQ Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const targetId = this.getAttribute('data-toggle');
            const answer = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-answer').forEach(otherAnswer => {
                if (otherAnswer.id !== targetId) {
                    otherAnswer.style.display = 'none';
                    otherAnswer.previousElementSibling.querySelector('i').className = 'fas fa-chevron-down';
                }
            });
            
            // Toggle current FAQ
            if (answer.style.display === 'block') {
                answer.style.display = 'none';
                icon.className = 'fas fa-chevron-down';
            } else {
                answer.style.display = 'block';
                icon.className = 'fas fa-chevron-up';
            }
        });
    });
    
    // Smooth scrolling for internal links
    document.querySelectorAll('.scroll-to').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    
    // Load Lottie animation if present
    const lottieContainer = document.querySelector('.lottie-container[data-lottie]');
    if (lottieContainer) {
        const animationUrl = lottieContainer.getAttribute('data-lottie');
        // You can add Lottie loading logic here if needed
        console.log('Lottie animation URL:', animationUrl);
    }
    // Service inquiry form enhanced
    const inquiryForm = document.getElementById('service-inquiry-form');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.inquiry-submit-btn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Collect form data
            const formData = new FormData(this);
            const inquiryData = {
                service_id: formData.get('service_id'),
                service_name: formData.get('service_name'),
                name: formData.get('name'),
                phone: formData.get('phone'),
                email: formData.get('email'),
                field: formData.get('field'),
                degree: formData.get('degree'),
                urgency: formData.get('urgency'),
                description: formData.get('description')
            };
            
            // Enhanced form submission simulation
            setTimeout(() => {
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'form-success-message';
                successMessage.innerHTML = `
                    <div class="success-content">
                        <i class="fa-sharp fa-solid fa-check-circle"></i>
                        <h4>درخواست شما با موفقیت ثبت شد!</h4>
                        <p>کارشناسان ما طی ۲ ساعت آینده با شما تماس خواهند گرفت.</p>
                    </div>
                `;
                successMessage.style.cssText = `
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: linear-gradient(135deg, #27ae60, #2ecc71);
                    color: white;
                    padding: 2rem;
                    border-radius: 20px;
                    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
                    z-index: 10000;
                    text-align: center;
                    min-width: 300px;
                    animation: successSlideIn 0.5s ease;
                `;
                
                document.body.appendChild(successMessage);
                
                // Remove success message after 4 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 4000);
                
                this.reset();
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                
                console.log('Service inquiry submitted:', inquiryData);
            }, 2500);
        });
        
        // Form validation enhancement
        const formInputs = inquiryForm.querySelectorAll('input, select, textarea');
        formInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.style.borderColor = 'rgba(46, 204, 113, 0.6)';
                    this.style.boxShadow = '0 0 0 3px rgba(46, 204, 113, 0.1)';
                } else if (this.required) {
                    this.style.borderColor = 'rgba(231, 76, 60, 0.6)';
                    this.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
                }
            });
            
            input.addEventListener('focus', function() {
                this.style.borderColor = 'rgba(255, 255, 255, 0.6)';
                this.style.boxShadow = '0 0 0 4px rgba(255, 255, 255, 0.1)';
            });
        });
    }
    
    // Enhanced FAQ functionality
    window.toggleServiceFAQ = function(index) {
        const question = document.querySelector(`.faq-card:nth-child(${index + 1}) .faq-card-question`);
        const answer = document.getElementById('service-faq-' + index);
        
        if (!question || !answer) return;
        
        const isActive = answer.classList.contains('active');
        
        // Close all other FAQs
        document.querySelectorAll('.faq-card-answer').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.faq-card-question').forEach(el => el.classList.remove('active'));
        
        if (!isActive) {
            answer.classList.add('active');
            question.classList.add('active');
        }
    };
    
    // Smooth scrolling enhancement
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                const headerOffset = 90;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Enhanced scroll animations
    const observerOptions = {
        threshold: 0.1,
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
    
    // Observe elements for scroll animation
    document.querySelectorAll('.feature-showcase-item, .process-step-item, .related-service-card, .trust-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
    
    // Enhanced loading states for buttons
    document.querySelectorAll('.hero-cta-primary, .hero-cta-secondary, .cta-call-btn, .cta-whatsapp-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add loading state for external links
            if (this.getAttribute('href').includes('wa.me') || this.getAttribute('href').includes('tel:')) {
                this.style.opacity = '0.7';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 1000);
            }
        });
    });
    
    // Add CSS for success message animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes successSlideIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }
        
        .form-success-message .success-content i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            color: #fff;
        }
        
        .form-success-message .success-content h4 {
            margin: 0 0 1rem 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .form-success-message .success-content p {
            margin: 0;
            opacity: 0.9;
            line-height: 1.6;
        }
    `;
    document.head.appendChild(style);
});
</script>

<?php get_footer(); ?>