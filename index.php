<?php get_header(); ?>

<main id="main-content" class="home-page-main">
    
    <!-- Hero Section -->
    <!-- Replace the hero section in index.php/front-page.php -->

<!-- Minimal Hero Section -->
<section class="home-hero-minimal">
    <div class="hero-minimal-bg">
        <div class="gradient-overlay"></div>
        <div class="geometric-shapes">
            <div class="shape triangle-1"></div>
            <div class="shape circle-1"></div>
            <div class="shape triangle-2"></div>
        </div>
    </div>
    
    <div class="container">
        <div class="hero-minimal-content">
            
            <!-- Minimal Badge -->
            <div class="minimal-badge">
                <span class="badge-icon">✨</span>
                <span class="badge-text">بیش از ۱۰ سال تجربه موفق</span>
            </div>
            
            <!-- Main Title -->
            <h1 class="hero-minimal-title">
                انجام پروژه‌های 
                <span class="title-accent">دانشجویی</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="hero-minimal-subtitle">
                با تیم ۴۵۰+ پژوهشگر متخصص، بهترین کیفیت نگارش را تجربه کنید
            </p>
            
            <!-- Key Stats - Minimal -->
            <div class="hero-stats-minimal">
                <div class="stat-minimal">
                    <span class="stat-number-minimal">۵۰۰۰+</span>
                    <span class="stat-label-minimal">پروژه موفق</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-minimal">
                    <span class="stat-number-minimal">۹۸%</span>
                    <span class="stat-label-minimal">رضایت</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-minimal">
                    <span class="stat-number-minimal">۲۴/۷</span>
                    <span class="stat-label-minimal">پشتیبانی</span>
                </div>
            </div>
            
            <!-- Single CTA -->
            <div class="hero-cta-minimal">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>" 
                   class="cta-minimal-primary">
                    <span class="cta-text">شروع پروژه</span>
                    <span class="cta-arrow">←</span>
                    <div class="cta-ripple"></div>
                </a>
                
                <div class="cta-support-minimal">
                    <span class="support-text">یا تماس بگیرید:</span>
                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" 
                       class="phone-link-minimal">
                        <?php echo esc_html(get_theme_mod('phone_number', '09162352304')); ?>
                    </a>
                </div>
            </div>
            
            <!-- Trust Indicators - Minimal -->
            <div class="trust-minimal">
                <div class="trust-item-minimal">
                    <span class="trust-icon">🛡️</span>
                    <span class="trust-text">تضمین کیفیت</span>
                </div>
                <div class="trust-item-minimal">
                    <span class="trust-icon">⚡</span>
                    <span class="trust-text">تحویل سریع</span>
                </div>
                <div class="trust-item-minimal">
                    <span class="trust-icon">🔒</span>
                    <span class="trust-text">محرمانگی</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Minimal Hero Section */
.home-hero-minimal {
    background: #ffffff;
    color: #1a1a1a;
    padding: 6rem 0 4rem 0;
    position: relative;
    overflow: hidden;
    min-height: 80vh;
    display: flex;
    align-items: center;
}

.hero-minimal-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(31, 165, 71, 0.03) 0%, 
        rgba(255, 255, 255, 0.8) 30%, 
        rgba(31, 165, 71, 0.02) 70%, 
        rgba(255, 255, 255, 0.9) 100%);
}

.geometric-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0.05;
}

.shape {
    position: absolute;
    animation: minimalFloat 20s ease-in-out infinite;
}

.triangle-1 {
    width: 0;
    height: 0;
    border-left: 60px solid transparent;
    border-right: 60px solid transparent;
    border-bottom: 100px solid var(--primary-color);
    top: 20%;
    right: 15%;
    animation-delay: 0s;
}

.circle-1 {
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
    border-radius: 50%;
    top: 60%;
    right: 75%;
    animation-delay: 7s;
}

.triangle-2 {
    width: 0;
    height: 0;
    border-left: 40px solid transparent;
    border-right: 40px solid transparent;
    border-top: 70px solid var(--primary-light);
    bottom: 20%;
    right: 20%;
    animation-delay: 14s;
}

@keyframes minimalFloat {
    0%, 100% { 
        transform: translateY(0px) translateX(0px) rotate(0deg); 
        opacity: 0.05; 
    }
    25% { 
        transform: translateY(-20px) translateX(10px) rotate(90deg); 
        opacity: 0.1; 
    }
    50% { 
        transform: translateY(-40px) translateX(-10px) rotate(180deg); 
        opacity: 0.15; 
    }
    75% { 
        transform: translateY(-20px) translateX(15px) rotate(270deg); 
        opacity: 0.08; 
    }
}

.hero-minimal-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 700px;
    margin: 0 auto;
}

/* Minimal Badge */
.minimal-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(31, 165, 71, 0.1);
    color: var(--primary-color);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 2rem;
    border: 1px solid rgba(31, 165, 71, 0.2);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    font-family: inherit;
}

.minimal-badge:hover {
    background: rgba(31, 165, 71, 0.15);
    transform: translateY(-2px);
}

.badge-icon {
    font-size: 1.1rem;
    animation: badgeIconFloat 3s ease-in-out infinite;
}

@keyframes badgeIconFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-3px) rotate(10deg); }
}

.badge-text {
    font-family: inherit;
}

/* Minimal Title */
.hero-minimal-title {
    font-size: clamp(3rem, 7vw, 5.5rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    color: #1a1a1a;
    font-family: inherit;
    letter-spacing: -0.02em;
}

.title-accent {
    color: var(--primary-color);
    position: relative;
}

.title-accent::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    border-radius: 3px;
    animation: accentGlow 2s ease-in-out infinite;
}

@keyframes accentGlow {
    0%, 100% { opacity: 0.6; transform: scaleX(1); }
    50% { opacity: 1; transform: scaleX(1.05); }
}

/* Minimal Subtitle */
.hero-minimal-subtitle {
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.6;
    color: #4a5568;
    margin-bottom: 3rem;
    font-family: inherit;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Minimal Stats */
.hero-stats-minimal {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-bottom: 3rem;
    padding: 1.5rem 2rem;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 50px;
    border: 1px solid rgba(31, 165, 71, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
}

.stat-minimal {
    text-align: center;
}

.stat-number-minimal {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.stat-label-minimal {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
    font-family: inherit;
}

.stat-divider {
    width: 2px;
    height: 40px;
    background: linear-gradient(180deg, transparent, rgba(31, 165, 71, 0.3), transparent);
    border-radius: 1px;
}

/* Minimal CTA */
.hero-cta-minimal {
    margin-bottom: 3rem;
}

.cta-minimal-primary {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 3rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    box-shadow: 0 8px 32px rgba(31, 165, 71, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
    margin-bottom: 1rem;
}

.cta-minimal-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 12px 40px rgba(31, 165, 71, 0.4);
    color: white;
}

.cta-text {
    font-weight: 700;
    position: relative;
    z-index: 2;
}

.cta-arrow {
    font-size: 1.2rem;
    font-weight: 800;
    transition: transform 0.3s ease;
    position: relative;
    z-index: 2;
}

.cta-minimal-primary:hover .cta-arrow {
    transform: translateX(-5px);
}

.cta-ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.6s ease;
}

.cta-minimal-primary:hover .cta-ripple {
    width: 300px;
    height: 300px;
}

.cta-support-minimal {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-size: 0.95rem;
    color: #6b7280;
    font-family: inherit;
}

.support-text {
    font-weight: 500;
}

.phone-link-minimal {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 700;
    padding: 0.5rem 1rem;
    background: rgba(31, 165, 71, 0.1);
    border-radius: 20px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.phone-link-minimal:hover {
    background: rgba(31, 165, 71, 0.2);
    transform: scale(1.05);
}

/* Minimal Trust */
.trust-minimal {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.trust-item-minimal {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    color: #4a5568;
    font-family: inherit;
    transition: all 0.3s ease;
}

.trust-item-minimal:hover {
    color: var(--primary-color);
    transform: translateY(-2px);
}

.trust-icon {
    font-size: 1.2rem;
    opacity: 0.8;
}

.trust-text {
    font-size: 0.9rem;
}

/* Dark Theme Support */
[data-theme="dark"] .home-hero-minimal {
    background: #0d1117;
    color: #f0f6fc;
}

[data-theme="dark"] .hero-minimal-title {
    color: #f0f6fc;
}

[data-theme="dark"] .hero-minimal-subtitle {
    color: #c9d1d9;
}

[data-theme="dark"] .gradient-overlay {
    background: linear-gradient(135deg, 
        rgba(31, 165, 71, 0.05) 0%, 
        rgba(13, 17, 23, 0.9) 30%, 
        rgba(31, 165, 71, 0.03) 70%, 
        rgba(13, 17, 23, 0.95) 100%);
}

[data-theme="dark"] .hero-stats-minimal {
    background: rgba(22, 27, 34, 0.8);
    border-color: rgba(48, 54, 61, 0.3);
}

[data-theme="dark"] .cta-support-minimal {
    color: #8b949e;
}

[data-theme="dark"] .trust-item-minimal {
    color: #8b949e;
}

[data-theme="dark"] .trust-item-minimal:hover {
    color: var(--primary-light);
}

/* Sepia Theme Support */
[data-theme="sepia"] .home-hero-minimal {
    background: #f4ecd8;
    color: #3e2723;
}

[data-theme="sepia"] .hero-minimal-title {
    color: #3e2723;
}

[data-theme="sepia"] .hero-minimal-subtitle {
    color: #4e342e;
}

[data-theme="sepia"] .gradient-overlay {
    background: linear-gradient(135deg, 
        rgba(31, 165, 71, 0.03) 0%, 
        rgba(244, 236, 216, 0.9) 30%, 
        rgba(31, 165, 71, 0.02) 70%, 
        rgba(244, 236, 216, 0.95) 100%);
}

[data-theme="sepia"] .hero-stats-minimal {
    background: rgba(235, 227, 208, 0.8);
    border-color: rgba(188, 170, 164, 0.3);
}

[data-theme="sepia"] .cta-support-minimal {
    color: #5d4037;
}

[data-theme="sepia"] .trust-item-minimal {
    color: #5d4037;
}

/* Responsive Minimal Hero */
@media (max-width: 768px) {
    .home-hero-minimal {
        padding: 4rem 0 3rem 0;
        min-height: 70vh;
    }
    
    .hero-minimal-title {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .hero-minimal-subtitle {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .hero-stats-minimal {
        flex-direction: column;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-radius: 25px;
    }
    
    .stat-divider {
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(31, 165, 71, 0.3), transparent);
    }
    
    .cta-minimal-primary {
        padding: 1.125rem 2.5rem;
        font-size: 1rem;
    }
    
    .trust-minimal {
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
    }
    
    .geometric-shapes {
        opacity: 0.03;
    }
}

@media (max-width: 480px) {
    .home-hero-minimal {
        padding: 3rem 0 2rem 0;
        min-height: 60vh;
    }
    
    .hero-minimal-title {
        font-size: 2rem;
    }
    
    .hero-minimal-subtitle {
        font-size: 1rem;
        padding: 0 1rem;
    }
    
    .minimal-badge {
        font-size: 0.8rem;
        padding: 0.6rem 1.25rem;
    }
    
    .cta-minimal-primary {
        padding: 1rem 2rem;
        font-size: 0.95rem;
    }
    
    .hero-stats-minimal {
        margin: 0 1rem 2rem 1rem;
        padding: 1rem;
    }
    
    .stat-number-minimal {
        font-size: 1.5rem;
    }
    
    .cta-support-minimal {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .home-hero-minimal {
        background: #ffffff;
        color: #000000;
    }
    
    .hero-minimal-title {
        color: #000000;
    }
    
    .title-accent {
        color: #0066cc;
    }
    
    .cta-minimal-primary {
        background: #000000;
        color: #ffffff;
        border: 3px solid #000000;
    }
    
    .hero-stats-minimal {
        background: #f8f9fa;
        border: 2px solid #000000;
    }
    
    .minimal-badge {
        background: #f0f0f0;
        color: #000000;
        border: 2px solid #000000;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .geometric-shapes .shape {
        animation: none !important;
    }
    
    .badge-icon {
        animation: none !important;
    }
    
    .title-accent::after {
        animation: none !important;
    }
    
    .minimal-badge,
    .cta-minimal-primary,
    .trust-item-minimal {
        transition: none;
    }
}

/* Focus States for Accessibility */
.cta-minimal-primary:focus,
.phone-link-minimal:focus {
    outline: 3px solid var(--primary-color);
    outline-offset: 3px;
}

.cta-minimal-primary:focus-visible,
.phone-link-minimal:focus-visible {
    outline: 3px solid #0066cc;
    outline-offset: 3px;
}

/* Print Styles */
@media print {
    .home-hero-minimal {
        background: white !important;
        color: black !important;
        padding: 2rem 0;
    }
    
    .geometric-shapes,
    .cta-ripple {
        display: none !important;
    }
    
    .hero-minimal-title {
        color: black !important;
        font-size: 2rem !important;
    }
    
    .title-accent {
        color: black !important;
    }
    
    .title-accent::after {
        display: none !important;
    }
    
    .cta-minimal-primary {
        background: white !important;
        color: black !important;
        border: 2px solid black !important;
        box-shadow: none !important;
    }
}

/* Animation Performance Optimization */
.geometric-shapes {
    will-change: transform;
    contain: layout;
}

.shape {
    will-change: transform, opacity;
}

.cta-minimal-primary {
    will-change: transform;
}

/* Loading States */
.hero-minimal-content {
    opacity: 0;
    transform: translateY(30px);
    animation: heroContentAppear 1s ease 0.3s forwards;
}

@keyframes heroContentAppear {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

.minimal-badge {
    opacity: 0;
    animation: badgeAppear 0.8s ease 0.5s forwards;
}

@keyframes badgeAppear {
    0% { opacity: 0; transform: translateY(-20px) scale(0.8); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.hero-minimal-title {
    opacity: 0;
    animation: titleAppear 1s ease 0.7s forwards;
}

@keyframes titleAppear {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.hero-minimal-subtitle {
    opacity: 0;
    animation: subtitleAppear 0.8s ease 0.9s forwards;
}

@keyframes subtitleAppear {
    0% { opacity: 0; transform: translateY(15px); }
    100% { opacity: 1; transform: translateY(0); }
}

.hero-stats-minimal {
    opacity: 0;
    animation: statsAppear 0.8s ease 1.1s forwards;
}

@keyframes statsAppear {
    0% { opacity: 0; transform: translateY(20px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.hero-cta-minimal {
    opacity: 0;
    animation: ctaAppear 0.8s ease 1.3s forwards;
}

@keyframes ctaAppear {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.trust-minimal {
    opacity: 0;
    animation: trustAppear 0.8s ease 1.5s forwards;
}

@keyframes trustAppear {
    0% { opacity: 0; transform: translateY(15px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Hover Effects Enhancement */
.stat-minimal {
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 10px;
}

.stat-minimal:hover {
    background: rgba(31, 165, 71, 0.1);
    transform: scale(1.05);
}

.stat-minimal:hover .stat-number-minimal {
    color: var(--primary-dark);
    transform: scale(1.1);
}

/* Micro-interactions */
.minimal-badge,
.stat-minimal,
.trust-item-minimal {
    cursor: pointer;
}

.trust-item-minimal:hover .trust-icon {
    transform: scale(1.2) rotate(10deg);
}

/* Performance Optimizations */
.hero-minimal-bg {
    contain: layout style paint;
}

.geometric-shapes .shape {
    contain: layout;
}

/* Accessibility Improvements */
.hero-minimal-content {
    scroll-margin-top: 100px;
}

.cta-minimal-primary {
    min-height: 48px;
    min-width: 200px;
}

/* Loading Skeleton (Optional) */
.hero-loading .hero-minimal-title {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 8px;
    height: 60px;
    margin-bottom: 1rem;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced counter animation for minimal hero
    const counters = document.querySelectorAll('.stat-number-minimal');
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateMinimalCounter(entry.target);
            }
        });
    }, { threshold: 0.7 });
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
    
    function animateMinimalCounter(element) {
        const text = element.textContent;
        const hasPlus = text.includes('+');
        const hasPercent = text.includes('%');
        const hasSlash = text.includes('/');
        
        let number;
        if (hasSlash) {
            // Handle cases like "24/7"
            return; // Don't animate these
        } else {
            number = parseInt(text.replace(/[^\d]/g, ''));
        }
        
        if (isNaN(number)) return;
        
        let current = 0;
        const increment = number / 60;
        const duration = 2000;
        const stepTime = duration / 60;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= number) {
                current = number;
                clearInterval(timer);
            }
            
            let displayValue = Math.floor(current).toString();
            
            // Convert to Persian numbers
            const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            displayValue = displayValue.replace(/\d/g, d => persianNumbers[d]);
            
            if (hasPlus) displayValue += '+';
            if (hasPercent) displayValue += '%';
            
            element.textContent = displayValue;
        }, stepTime);
    }
    
    // Parallax effect for geometric shapes (subtle)
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.3;
        
        const shapes = document.querySelectorAll('.geometric-shapes .shape');
        shapes.forEach((shape, index) => {
            const speed = 0.1 + (index * 0.05);
            shape.style.transform = `translateY(${scrolled * speed}px)`;
        });
        
        ticking = false;
    }
    
    function requestParallaxTick() {
        if (!ticking && window.innerWidth > 768) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestParallaxTick);
    
    // Interactive stats on hover
    const statsMinimal = document.querySelectorAll('.stat-minimal');
    statsMinimal.forEach(stat => {
        stat.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.08) translateY(-2px)';
        });
        
        stat.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // Trust items interaction
    const trustItems = document.querySelectorAll('.trust-item-minimal');
    trustItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add subtle interaction feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
    
    // CTA interaction enhancement
    const ctaBtn = document.querySelector('.cta-minimal-primary');
    if (ctaBtn) {
        ctaBtn.addEventListener('mouseenter', function() {
            this.style.letterSpacing = '0.5px';
        });
        
        ctaBtn.addEventListener('mouseleave', function() {
            this.style.letterSpacing = '';
        });
    }
    
    // Intersection observer for reveal animations
    const revealElements = document.querySelectorAll('.minimal-badge, .hero-minimal-title, .hero-minimal-subtitle, .hero-stats-minimal, .hero-cta-minimal, .trust-minimal');
    
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, { threshold: 0.3 });
    
    revealElements.forEach(element => {
        element.style.animationPlayState = 'paused';
        revealObserver.observe(element);
    });
});
</script>

    
    <!-- Services Section -->
    <section class="home-services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدمات تز نویسان</h2>
                <p class="section-subtitle">در چه زمینه‌هایی می‌توانیم به شما کمک کنیم؟</p>
            </div>
            
                        <div class="services-showcase">
                <?php
                $service_categories = array(
                    array(
                        'name' => 'انجام پایان‌نامه ارشد و دکتری',
                        'description' => 'نگارش کامل پایان‌نامه از فصل اول تا دفاع نهایی',
                        'icon' => 'fa-solid fa-graduation-cap',
                        'color' => '#FF6B6B',
                        'link' => home_url('/services/thesis'),
                        'features' => array('نگارش کامل', 'تحلیل آماری', 'فرمت‌بندی', 'دفاع')
                    ),
                    array(
                        'name' => 'انجام پروپوزال‌های علمی و دانشگاهی',
                        'description' => 'نگارش پروپوزال با تضمین تایید از اساتید',
                        'icon' => 'fa-solid fa-file-contract',
                        'color' => '#4ECDC4',
                        'link' => home_url('/services/proposal'),
                        'features' => array('انتخاب موضوع', 'مرور ادبیات', 'روش‌شناسی', 'تایید')
                    ),
                    array(
                        'name' => 'تحلیل آماری پیشرفته',
                        'description' => 'تحلیل داده‌ها با SPSS، R، Python و MATLAB',
                        'icon' => 'fa-solid fa-chart-bar',
                        'color' => '#45B7D1',
                        'link' => home_url('/services/analysis'),
                        'features' => array('SPSS', 'R & Python', 'MATLAB', 'تفسیر نتایج')
                    ),
                    array(
                        'name' => 'نوشتن مقالات علمی',
                        'description' => 'مقالات ISI، ISC و کنفرانس‌های بین‌المللی',
                        'icon' => 'fa-solid fa-newspaper',
                        'color' => '#96CEB4',
                        'link' => home_url('/services/article'),
                        'features' => array('مقالات ISI', 'مقالات ISC', 'کنفرانس', 'انتشار')
                    ),
                    array(
                        'name' => 'پروژه‌های برنامه‌نویسی',
                        'description' => 'انجام پروژه‌های برنامه‌نویسی و طراحی نرم‌افزار',
                        'icon' => 'fa-solid fa-code',
                        'color' => '#FFEAA7',
                        'link' => home_url('/services/programming'),
                        'features' => array('وب سایت', 'اپلیکیشن', 'دسکتاپ', 'هوش مصنوعی')
                    ),
                    array(
                        'name' => 'ترجمه متون تخصصی',
                        'description' => 'ترجمه دقیق و تخصصی متون علمی و فنی',
                        'icon' => 'fa-solid fa-language',
                        'color' => '#DDA0DD',
                        'link' => home_url('/services/translation'),
                        'features' => array('ترجمه علمی', 'ترجمه فنی', 'ویرایش', 'تضمین کیفیت')
                    )
                );
                
                foreach ($service_categories as $category) :
                ?>
                    <div class="service-category-showcase" style="--category-color: <?php echo esc_attr($category['color']); ?>">
                        <div class="category-header">
                            <div class="category-icon-bg">
                                <div class="category-icon">
                                    <i class="<?php echo esc_attr($category['icon']); ?>"></i>
                                </div>
                                <div class="icon-pulse"></div>
                            </div>
                            <h3 class="category-name"><?php echo esc_html($category['name']); ?></h3>
                            <p class="category-description"><?php echo esc_html($category['description']); ?></p>
                        </div>
                        
                        <div class="category-features">
                            <?php foreach ($category['features'] as $feature) : ?>
                                <div class="feature-tag">
                                    <i class="fa-solid fa-check"></i>
                                    <span><?php echo esc_html($feature); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="category-actions">
                            <a href="<?php echo esc_url($category['link']); ?>" class="category-btn primary">
                                <i class="fa-solid fa-info-circle"></i>
                                جزئیات خدمت
                            </a>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=<?php echo urlencode($category['name']); ?>" 
                               class="category-btn secondary">
                                <i class="fa-solid fa-shopping-cart"></i>
                                سفارش
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="services-cta-section">
                <div class="services-cta-content">
                    <h3>بیش از ۶ دسته خدمات تخصصی</h3>
                    <p>ما در تمامی زمینه‌ها و رشته‌های تحصیلی آماده همکاری با شما هستیم</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('services')); ?>" class="view-all-services-btn">
                        <i class="fa-solid fa-eye"></i>
                        مشاهده تمام خدمات
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">چرا باید تز نویسان را انتخاب کنید؟</h2>
                <p class="section-subtitle">
                    <?php echo esc_html(get_theme_mod('why_choose_subtitle', 'پروژه خوب، با حرف‌های خوب نوشته نمی‌شود! ارائه خوب، بدون آموزش خوب اتفاق نمی‌افتد!')); ?>
                </p>
            </div>
            
            <div class="advantages-grid">
                <?php
                $advantages = array(
                    array(
                        'title' => 'تجربه و تخصص بی‌نظیر',
                        'description' => get_theme_mod('advantage_1_desc', 'با تیمی متشکل از بیش از 450 محقق و پژوهشگر متخصص، ما توانسته‌ایم پروژه‌های تحقیقاتی و پایان‌نامه‌های بسیاری را در تمامی رشته‌ها و مقاطع تحصیلی با موفقیت به پایان برسانیم.'),
                        'icon' => 'fa-solid fa-user-graduate',
                        'color' => '#3498db'
                    ),
                    array(
                        'title' => 'کیفیت بالا و دقت در انجام',
                        'description' => get_theme_mod('advantage_2_desc', 'تمامی پروژه‌ها تحت نظر متخصصین حوزه‌های مختلف انجام می‌شوند. ما با توجه به استانداردهای علمی و دانشگاهی، پروژه‌های شما را به دقیق‌ترین شکل ممکن تحویل می‌دهیم.'),
                        'icon' => 'fa-solid fa-award',
                        'color' => '#e74c3c'
                    ),
                    array(
                        'title' => 'پشتیبانی کامل و مشاوره',
                        'description' => get_theme_mod('advantage_3_desc', 'در تز نویسان، شما تنها نیستید! ما از انتخاب موضوع تا ویرایش نهایی با شما همراه خواهیم بود. مشاوره و آموزش‌های لازم در هر مرحله به شما ارائه می‌دهیم.'),
                        'icon' => 'fa-solid fa-headset',
                        'color' => '#2ecc71'
                    ),
                    array(
                        'title' => 'قیمت‌گذاری شفاف و منصفانه',
                        'description' => get_theme_mod('advantage_4_desc', 'برخلاف بسیاری از موسسات که قیمت‌های گزاف دارند، ما هزینه‌ها را شفاف و منصفانه ارائه می‌دهیم و تضمین می‌کنیم که با بهترین کیفیت و قیمت معقول انجام شود.'),
                        'icon' => 'fa-solid fa-dollar-sign',
                        'color' => '#f39c12'
                    ),
                    array(
                        'title' => 'تضمین رضایت و اصلاحات',
                        'description' => get_theme_mod('advantage_5_desc', 'اگر پس از تحویل پروژه نیاز به اصلاحات داشتید، تیم ما بدون هیچ‌گونه هزینه اضافی اصلاحات لازم را انجام خواهد داد تا رضایت کامل شما حاصل شود.'),
                        'icon' => 'fa-solid fa-shield-check',
                        'color' => '#9b59b6'
                    ),
                    array(
                        'title' => 'تعهد به زمان‌بندی',
                        'description' => get_theme_mod('advantage_6_desc', 'ما به‌دقت زمان‌بندی انجام پروژه‌ها را رعایت کرده و در اسرع وقت پروژه‌ها را تحویل می‌دهیم. پس از تکمیل هر بخش، گزارش مربوط به آن را ارسال می‌کنیم.'),
                        'icon' => 'fa-solid fa-clock',
                        'color' => '#1abc9c'
                    )
                );
                
                foreach ($advantages as $index => $advantage) :
                ?>
                    <div class="advantage-card" style="--advantage-color: <?php echo esc_attr($advantage['color']); ?>">
                        <div class="advantage-number"><?php echo $index + 1; ?></div>
                        <div class="advantage-icon">
                            <i class="<?php echo esc_attr($advantage['icon']); ?>"></i>
                        </div>
                        <div class="advantage-content">
                            <h4><?php echo esc_html($advantage['title']); ?></h4>
                            <p><?php echo esc_html($advantage['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Dynamic Services from Database -->
    <section class="dynamic-services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدمات ویژه ما</h2>
                <p class="section-subtitle">خدمات اختصاصی ارائه شده توسط تیم متخصص</p>
            </div>
            
            <div class="dynamic-services-grid">
                <?php
                $services = get_posts(array(
                    'post_type' => 'services',
                    'posts_per_page' => 6,
                    'meta_key' => 'featured_service',
                    'meta_value' => '1',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                if ($services) :
                    foreach ($services as $service) :
                        $price_min = get_post_meta($service->ID, 'price_range_min', true);
                        $price_max = get_post_meta($service->ID, 'price_range_max', true);
                        $service_excerpt = get_post_meta($service->ID, 'service_excerpt', true);
                ?>
                    <div class="dynamic-service-card">
                        <?php if (has_post_thumbnail($service->ID)) : ?>
                            <div class="service-image">
                                <a href="<?php echo esc_url(get_permalink($service)); ?>">
                                    <?php echo get_the_post_thumbnail($service->ID, 'service-thumbnail'); ?>
                                </a>
                                <div class="service-overlay">
                                    <a href="<?php echo esc_url(get_permalink($service)); ?>" class="view-service">
                                        <i class="fa-solid fa-eye"></i>
                                        مشاهده
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="service-content">
                            <h4 class="service-title">
                                <a href="<?php echo esc_url(get_permalink($service)); ?>">
                                    <?php echo esc_html(get_the_title($service)); ?>
                                </a>
                            </h4>
                            
                            <?php if ($service_excerpt) : ?>
                                <p class="service-excerpt"><?php echo esc_html($service_excerpt); ?></p>
                            <?php else : ?>
                                <p class="service-excerpt"><?php echo esc_html(wp_trim_words(get_post_field('post_content', $service), 15)); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($price_min) : ?>
                                <div class="service-price">
                                    <span class="price-label">قیمت از:</span>
                                    <span class="price-amount"><?php echo number_format((int)$price_min); ?> تومان</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="service-actions">
                                <a href="<?php echo esc_url(get_permalink($service)); ?>" class="service-btn details">
                                    <i class="fa-solid fa-info-circle"></i>
                                    جزئیات
                                </a>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>?service=<?php echo $service->ID; ?>" 
                                   class="service-btn order">
                                    <i class="fa-solid fa-shopping-cart"></i>
                                    سفارش
                                </a>
                            </div>
                        </div>
                    </div>
                <?php 
                    endforeach;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <!-- Blog Categories Section -->
    <section class="blog-categories-home">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">دسته‌بندی مطالب</h2>
                <p class="section-subtitle">مطالب آموزشی و مفید در زمینه‌های مختلف</p>
            </div>
            
            <div class="blog-categories-grid">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 8,
                    'hide_empty' => true
                ));
                
                $category_colors = array('#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF7675', '#74B9FF');
                
                foreach ($categories as $index => $category) :
                    $color = $category_colors[$index % count($category_colors)];
                    $recent_posts = get_posts(array(
                        'category' => $category->term_id,
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));
                ?>
                    <div class="blog-category-card" style="--cat-color: <?php echo esc_attr($color); ?>">
                        <div class="category-card-header">
                            <div class="category-card-icon">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <h4 class="category-card-title">
                                <a href="<?php echo esc_url(get_category_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </h4>
                            <p class="category-card-description">
                                <?php echo esc_html($category->description ?: 'مطالب مربوط به ' . $category->name); ?>
                            </p>
                            <div class="category-stats">
                                <span class="post-count"><?php echo $category->count; ?> مطلب</span>
                            </div>
                        </div>
                        
                        <div class="category-recent-posts">
                            <?php if ($recent_posts) : ?>
                                <?php foreach ($recent_posts as $recent_post) : ?>
                                    <div class="recent-post-item">
                                        <a href="<?php echo esc_url(get_permalink($recent_post)); ?>" class="recent-post-link">
                                            <i class="fa-solid fa-file-alt"></i>
                                            <span><?php echo esc_html(get_the_title($recent_post)); ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="category-card-footer">
                            <a href="<?php echo esc_url(get_category_link($category)); ?>" class="category-view-all">
                                مشاهده همه مطالب
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Process Section -->
    <section class="process-section-home">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">مراحل انجام پروژه‌ها</h2>
                <p class="section-subtitle">
                    <?php echo esc_html(get_theme_mod('process_subtitle', 'ما یک پروسه کاملاً شفاف برای انجام پروژه‌های خود داریم')); ?>
                </p>
            </div>
            
            <div class="process-timeline">
                <?php
                $process_steps = array(
                    array(
                        'title' => 'مشاوره اولیه',
                        'description' => get_theme_mod('process_step_1', 'بررسی نیازها و ارائه راهکار مناسب با مشاوره رایگان'),
                        'icon' => 'fa-solid fa-comments',
                        'duration' => '۳۰ دقیقه'
                    ),
                    array(
                        'title' => 'برنامه‌ریزی پروژه',
                        'description' => get_theme_mod('process_step_2', 'تعیین جزئیات، زمان‌بندی و هزینه‌ها با شفافیت کامل'),
                        'icon' => 'fa-solid fa-calendar-alt',
                        'duration' => '۱ روز'
                    ),
                    array(
                        'title' => 'تعیین متخصص',
                        'description' => get_theme_mod('process_step_3', 'انتخاب بهترین متخصص مناسب برای رشته و موضوع پروژه شما'),
                        'icon' => 'fa-solid fa-user-tie',
                        'duration' => '۲ روز'
                    ),
                    array(
                        'title' => 'شروع اجرا',
                        'description' => get_theme_mod('process_step_4', 'آغاز انجام پروژه با گزارش‌دهی مرحله‌ای و بازخورد مستمر'),
                        'icon' => 'fa-solid fa-play-circle',
                        'duration' => 'بر اساس پروژه'
                    ),
                    array(
                        'title' => 'بازبینی و کنترل',
                        'description' => get_theme_mod('process_step_5', 'بررسی دقیق کیفیت، اعمال اصلاحات و آماده‌سازی برای تحویل'),
                        'icon' => 'fa-solid fa-search',
                        'duration' => '۲-۳ روز'
                    ),
                    array(
                        'title' => 'تحویل نهایی',
                        'description' => get_theme_mod('process_step_6', 'ارائه پروژه کامل همراه با پشتیبانی و ضمانت اصلاحات'),
                        'icon' => 'fa-solid fa-check-circle',
                        'duration' => 'فوری'
                    )
                );
                
                foreach ($process_steps as $index => $step) :
                ?>
                    <div class="process-step-home" data-step="<?php echo $index + 1; ?>">
                        <div class="step-number">
                            <?php 
                            $persian_numbers = ['۱', '۲', '۳', '۴', '۵', '۶'];
                            echo $persian_numbers[$index];
                            ?>
                        </div>
                        <div class="step-icon">
                            <i class="<?php echo esc_attr($step['icon']); ?>"></i>
                        </div>
                        <div class="step-content">
                            <h4><?php echo esc_html($step['title']); ?></h4>
                            <p><?php echo esc_html($step['description']); ?></p>
                            <span class="step-duration"><?php echo esc_html($step['duration']); ?></span>
                        </div>
                        <?php if ($index < count($process_steps) - 1) : ?>
                            <div class="step-connector"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Pricing Section -->
    <section class="pricing-section-home">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">شیوه قیمت‌گذاری</h2>
                <p class="section-subtitle">
                    <?php echo esc_html(get_theme_mod('pricing_subtitle', 'تز نویسان برخلاف موسسات سودجویی، پروژه‌های دانشجویی را با قیمت مناسب و تضمین کیفیت انجام می‌دهد')); ?>
                </p>
            </div>
            
            <div class="pricing-features">
                <div class="pricing-feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h4>قیمت‌گذاری شفاف</h4>
                    <p>همیشه قیمت‌های شفاف و منصفانه ارائه می‌شود و از هزینه‌های پنهان خودداری می‌کنیم</p>
                </div>
                
                <div class="pricing-feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-undo"></i>
                    </div>
                    <h4>ضمانت بازگشت وجه</h4>
                    <p>در صورت عدم رضایت یا مشکل با استاد، هزینه به صورت کامل عودت داده می‌شود</p>
                </div>
                
                <div class="pricing-feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-edit"></i>
                    </div>
                    <h4>اصلاحات رایگان</h4>
                    <p>تمام اصلاحات مورد نیاز تا رسیدن به رضایت کامل، کاملاً رایگان انجام می‌شود</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-section-home">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">سوالات متداول (FAQ)</h2>
                <p class="section-subtitle">پاسخ سوالات رایج در مورد خدمات و نحوه همکاری</p>
            </div>
            
            <div class="faq-home-grid">
                <?php
                $faqs = array(
                    array(
                        'question' => 'چطور می‌توانم پروژه‌ام را به تز نویسان بسپارم؟',
                        'answer' => get_theme_mod('faq_1', 'برای شروع، شما می‌توانید از طریق فرم تماس آنلاین یا شماره تماس با ما ارتباط برقرار کنید. پس از دریافت اطلاعات پروژه، ما مشاوره رایگان به شما ارائه می‌دهیم.')
                    ),
                    array(
                        'question' => 'هزینه انجام پروژه‌های دانشجویی چگونه محاسبه می‌شود؟',
                        'answer' => get_theme_mod('faq_2', 'هزینه‌ها بر اساس نوع پروژه، مقطع تحصیلی و حجم کار محاسبه می‌شود. ما همیشه قیمت‌گذاری شفاف و منصفانه داریم و قبل از شروع هزینه‌ها را اعلام می‌کنیم.')
                    ),
                    array(
                        'question' => 'آیا تز نویسان خدمات اصلاحات رایگان ارائه می‌دهد؟',
                        'answer' => get_theme_mod('faq_3', 'بله، اگر پروژه شما نیاز به اصلاحات داشت یا با استاد خود مشکلی داشتید، ما اصلاحات لازم را به صورت رایگان انجام خواهیم داد.')
                    ),
                    array(
                        'question' => 'آیا شما خدمات پشتیبانی پس از تحویل پروژه دارید؟',
                        'answer' => get_theme_mod('faq_4', 'بله، تیم ما پس از تحویل پروژه نیز آماده پاسخگویی به سوالات شماست و در صورت نیاز پشتیبانی ارائه می‌دهیم.')
                    ),
                    array(
                        'question' => 'آیا تز نویسان برای تمامی رشته‌ها خدمات ارائه می‌دهد؟',
                        'answer' => get_theme_mod('faq_5', 'بله، موسسه ما خدمات انجام پروژه در تمامی رشته‌ها و مقاطع تحصیلی ارائه می‌دهد، از علوم انسانی تا مهندسی و علوم پایه.')
                    ),
                    array(
                        'question' => 'چطور از کیفیت پروژه‌ها مطمئن شوم؟',
                        'answer' => get_theme_mod('faq_6', 'تمامی پروژه‌ها تحت نظر تیم متخصص و با رعایت اصول علمی انجام می‌شوند. پس از تکمیل، شما می‌توانید بررسی کرده و درخواست اصلاحات کنید.')
                    )
                );
                
                foreach ($faqs as $index => $faq) :
                ?>
                    <div class="faq-home-item">
                        <button class="faq-home-question" onclick="toggleHomeFAQ(<?php echo $index; ?>)">
                            <span><?php echo esc_html($faq['question']); ?></span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="faq-home-answer" id="home-faq-<?php echo $index; ?>">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="faq-cta">
                <p>سوال دیگری دارید؟</p>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="faq-contact-btn">
                    <i class="fa-solid fa-phone"></i>
                    تماس با ما
                </a>
            </div>
        </div>
    </section>
    
    <!-- Final CTA Section -->
    <section class="final-cta-home">
        <div class="cta-background">
            <div class="cta-animation">
                <div class="animated-shape shape-1"></div>
                <div class="animated-shape shape-2"></div>
                <div class="animated-shape shape-3"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="final-cta-content">
                <h2 class="cta-title">ثبت سفارش خدمات پروژه دانشجویی</h2>
                <p class="cta-description">
                    <?php echo esc_html(get_theme_mod('final_cta_text', 'اگر به دنبال یک تیم متخصص برای انجام پروژه‌های دانشجویی خود هستید، تز نویسان بهترین انتخاب شماست. برای شروع همکاری و دریافت مشاوره رایگان، همین حالا با ما تماس بگیرید!')); ?>
                </p>
                
                <div class="cta-actions-final">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>" 
                       class="cta-btn-final primary">
                        <span class="btn-icon">
                            <i class="fa-solid fa-rocket"></i>
                        </span>
                        <span class="btn-text">
                            <span class="btn-main">شروع همین حالا</span>
                            <span class="btn-sub">مشاوره رایگان</span>
                        </span>
                        <div class="btn-shine"></div>
                    </a>
                    
                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" 
                       class="cta-btn-final secondary">
                        <span class="btn-icon">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <span class="btn-text">
                            <span class="btn-main">تماس مستقیم</span>
                            <span class="btn-sub">پاسخگویی فوری</span>
                        </span>
                    </a>
                </div>
                
                <div class="final-guarantees">
                    <div class="guarantee-final">
                        <i class="fa-solid fa-shield-alt"></i>
                        <span>تضمین کیفیت</span>
                    </div>
                    <div class="guarantee-final">
                        <i class="fa-solid fa-lock"></i>
                        <span>محرمانگی کامل</span>
                    </div>
                    <div class="guarantee-final">
                        <i class="fa-solid fa-undo"></i>
                        <span>ضمانت بازگشت وجه</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Home Page Comprehensive Styles */
.home-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    font-family: inherit;
}

/* Hero Section */
.home-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, #0f5d2a 100%);
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

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
    animation: heroPatternMove 20s ease-in-out infinite;
}

@keyframes heroPatternMove {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.1) rotate(5deg); }
}

.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
}

.float-element {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: heroFloat 8s ease-in-out infinite;
}

.element-1 {
    width: 150px;
    height: 150px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.element-2 {
    width: 100px;
    height: 100px;
    top: 70%;
    right: 80%;
    animation-delay: 2s;
}

.element-3 {
    width: 200px;
    height: 200px;
    top: 60%;
    right: 20%;
    animation-delay: 4s;
}

.element-4 {
    width: 80px;
    height: 80px;
    top: 30%;
    right: 60%;
    animation-delay: 6s;
}

@keyframes heroFloat {
    0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); opacity: 0.3; }
    25% { transform: translateY(-30px) scale(1.1) rotate(90deg); opacity: 0.6; }
    50% { transform: translateY(-60px) scale(0.9) rotate(180deg); opacity: 0.8; }
    75% { transform: translateY(-30px) scale(1.05) rotate(270deg); opacity: 0.4; }
}

.hero-content-grid {
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
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: badgeGlow 3s ease-in-out infinite;
}

@keyframes badgeGlow {
    0%, 100% { box-shadow: 0 0 15px rgba(255, 255, 255, 0.3); }
    50% { box-shadow: 0 0 25px rgba(255, 255, 255, 0.6), 0 0 35px rgba(255, 255, 255, 0.3); }
}

.hero-main-title {
    font-size: clamp(3rem, 6vw, 5rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    font-family: inherit;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.hero-subtitle {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    opacity: 0.95;
    font-family: inherit;
}

.hero-description p {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 2rem;
    opacity: 0.9;
    text-align: justify;
    font-family: inherit;
}

.hero-features {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2.5rem;
}

.feature-highlight {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.25rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.feature-highlight:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
}

.feature-highlight i {
    font-size: 1.2rem;
    opacity: 0.9;
}

.hero-actions {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.hero-cta-primary,
.hero-cta-secondary {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 2rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.hero-cta-primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.4);
    flex: 1;
}

.hero-cta-secondary {
    background: transparent;
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.6);
}

.cta-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.cta-content {
    text-align: right;
    flex: 1;
}

.cta-main {
    display: block;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.cta-sub {
    display: block;
    font-size: 0.8rem;
    opacity: 0.8;
    font-family: inherit;
}

.cta-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s ease;
}

.hero-cta-primary:hover .cta-shine {
    left: 100%;
}

.hero-cta-primary:hover,
.hero-cta-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    color: white;
}

.hero-guarantees {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    justify-content: center;
}

.guarantee-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    opacity: 0.9;
    font-family: inherit;
}

.guarantee-item i {
    color: #FFD700;
    font-size: 1rem;
}

/* Hero Visual */
.hero-visual-content {
    position: relative;
}

.hero-stats-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
}

.stats-header h3 {
    margin: 0 0 2rem 0;
    font-size: 1.3rem;
    text-align: center;
    font-family: inherit;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 1.5rem 1rem;
    border-radius: 15px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.05);
}

.stat-card .stat-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.3rem;
}

.stat-card .stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.stat-card .stat-label {
    font-size: 0.8rem;
    opacity: 0.8;
    font-family: inherit;
}

.trust-indicators-mini {
    display: flex;
    justify-content: space-around;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.trust-mini-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

.trust-mini-item i {
    font-size: 1.2rem;
    color: #FFD700;
}

/* Services Showcase */
.home-services {
    background: var(--bg-main);
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

.section-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.services-showcase {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 3rem;
    margin-bottom: 3rem;
}

.service-category-showcase {
    background: var(--bg-secondary);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
}

.service-category-showcase::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--category-color);
}

.service-category-showcase:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.category-header {
    background: linear-gradient(135deg, var(--category-color), color-mix(in srgb, var(--category-color) 80%, black));
    color: white;
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
}

.category-icon-bg {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
}

.category-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 1;
}

.icon-pulse {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 2px solid rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    animation: iconPulse 2s infinite;
}

@keyframes iconPulse {
    0% { transform: scale(1); opacity: 0.7; }
    70% { transform: scale(1.3); opacity: 0; }
    100% { transform: scale(1.3); opacity: 0; }
}

.category-name {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: inherit;
}

.category-description {
    font-size: 1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0;
    font-family: inherit;
}

.category-features {
    padding: 1.5rem 2rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
}

.feature-tag {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--category-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

.category-actions {
    padding: 1.5rem 2rem 2rem;
    display: flex;
    gap: 1rem;
}

.category-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.category-btn.primary {
    background: var(--category-color);
    color: white;
}

.category-btn.secondary {
    background: transparent;
    color: var(--category-color);
    border: 2px solid var(--category-color);
}

.category-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.category-btn.primary:hover {
    background: color-mix(in srgb, var(--category-color) 80%, black);
    color: white;
}

.category-btn.secondary:hover {
    background: var(--category-color);
    color: white;
}

.services-cta-section {
    text-align: center;
    padding: 3rem 2rem;
    background: var(--bg-main);
    border-radius: 20px;
    border: 1px solid var(--border-color);
}

.services-cta-content h3 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin-bottom: 1rem;
    font-family: inherit;
}

.services-cta-content p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-family: inherit;
}

.view-all-services-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 2.5rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 700;
    transition: all 0.3s ease;
    font-family: inherit;
}

.view-all-services-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(31, 165, 71, 0.4);
    color: white;
}

/* Dynamic Services */
.dynamic-services {
    background: var(--bg-secondary);
    padding: 5rem 0;
}

.dynamic-services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.dynamic-service-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.dynamic-service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
}

.service-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.dynamic-service-card:hover .service-image img {
    transform: scale(1.1);
}

.service-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(31, 165, 71, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.dynamic-service-card:hover .service-overlay {
    opacity: 1;
}

.view-service {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    font-family: inherit;
}

.view-service:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

.service-content {
    padding: 2rem;
}

.service-title {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    font-weight: 600;
    line-height: 1.4;
    font-family: inherit;
}

.service-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.service-title a:hover {
    color: var(--primary-color);
}

.service-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.service-price {
    margin-bottom: 1.5rem;
}

.price-label {
    color: var(--text-muted);
    font-size: 0.8rem;
    display: block;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.price-amount {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
    font-family: inherit;
}

.service-actions {
    display: flex;
    gap: 0.75rem;
}

.service-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-family: inherit;
}

.service-btn.details {
    background: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.service-btn.order {
    background: var(--primary-color);
    color: white;
    border: 1px solid var(--primary-color);
}

.service-btn.details:hover {
    background: var(--primary-color);
    color: white;
}

.service-btn.order:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    color: white;
}

/* Why Choose Us */
.why-choose-us {
    background: var(--bg-main);
    padding: 5rem 0;
}

.advantages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 3rem;
    margin-top: 3rem;
}

.advantage-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2.5rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.advantage-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--advantage-color);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
}

.advantage-card:hover::before {
    transform: scaleX(1);
}

.advantage-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
}

.advantage-number {
    position: absolute;
    top: -15px;
    right: -15px;
    width: 50px;
    height: 50px;
    background: var(--advantage-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 800;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border: 3px solid var(--bg-main);
}

.advantage-icon {
    width: 70px;
    height: 70px;
    background: rgba(0, 0, 0, 0.05);
    color: var(--advantage-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 1rem 0 1.5rem 0;
    font-size: 1.8rem;
    transition: all 0.3s ease;
}

.advantage-card:hover .advantage-icon {
    background: var(--advantage-color);
    color: white;
    transform: scale(1.1) rotateY(180deg);
}

.advantage-card h4 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    font-family: inherit;
}

.advantage-card p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.7;
    text-align: justify;
    font-family: inherit;
}

/* Blog Categories */
.blog-categories-home {
    background: var(--bg-secondary);
    padding: 5rem 0;
}

.blog-categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.blog-category-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.blog-category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    border-color: var(--cat-color);
}

.category-card-header {
    background: var(--cat-color);
    color: white;
    padding: 2rem;
    text-align: center;
}

.category-card-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.category-card-title {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    font-family: inherit;
}

.category-card-title a {
    color: white;
    text-decoration: none;
    transition: opacity 0.3s ease;
}

.category-card-title a:hover {
    opacity: 0.8;
}

.category-card-description {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 1rem;
    font-family: inherit;
}

.category-stats {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

.category-recent-posts {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.recent-post-item {
    margin-bottom: 0.75rem;
}

.recent-post-item:last-child {
    margin-bottom: 0;
}

.recent-post-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--text-primary);
    text-decoration: none;
    padding: 0.5rem;
    border-radius: 6px;
    transition: all 0.3s ease;
    font-size: 0.85rem;
    font-family: inherit;
}

.recent-post-link:hover {
    background: var(--bg-secondary);
    color: var(--cat-color);
    transform: translateX(-3px);
}

.recent-post-link i {
    color: var(--cat-color);
    width: 16px;
    text-align: center;
}

.category-card-footer {
    padding: 1rem 1.5rem;
    background: var(--bg-secondary);
    text-align: center;
}

.category-view-all {
    color: var(--cat-color);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.category-view-all:hover {
    transform: translateX(-3px);
}

/* Process Section */
.process-section-home {
    background: var(--bg-main);
    padding: 5rem 0;
}

.process-timeline {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
    position: relative;
}

.process-step-home {
    background: var(--bg-secondary);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
}

.process-step-home:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
    border-color: var(--primary-color);
}

.step-number {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.2rem;
    border: 4px solid var(--bg-main);
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
}

.step-icon {
    width: 70px;
    height: 70px;
    background: rgba(31, 165, 71, 0.1);
    color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 1rem auto 1.5rem;
    font-size: 1.8rem;
    transition: all 0.3s ease;
}

.process-step-home:hover .step-icon {
    background: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

.step-content h4 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    font-family: inherit;
}

.step-content p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.step-duration {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    font-family: inherit;
}

/* Pricing Section */
.pricing-section-home {
    background: var(--bg-secondary);
    padding: 5rem 0;
}

.pricing-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.pricing-feature-card {
    background: var(--bg-main);
    border-radius: 15px;
    padding: 2.5rem 2rem;
    border: 1px solid var(--border-color);
    text-align: center;
    transition: all 0.3s ease;
}

.pricing-feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
    border-color: var(--primary-color);
}

.pricing-feature-card .feature-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
}

.pricing-feature-card h4 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    font-family: inherit;
}

.pricing-feature-card p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.7;
    font-family: inherit;
}

/* FAQ Section */
.faq-section-home {
    background: var(--bg-main);
    padding: 5rem 0;
}

.faq-home-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
}

.faq-home-item {
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-home-item:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.1);
}

.faq-home-question {
    width: 100%;
    padding: 1.5rem;
    background: transparent;
    border: none;
    text-align: right;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.faq-home-question:hover {
    color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
}

.faq-home-question i {
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.faq-home-question.active i {
    transform: rotate(180deg);
}

.faq-home-answer {
    max-height: 0;
    overflow: hidden;
    transition: all 0.4s ease;
    background: var(--bg-main);
}

.faq-home-answer.active {
    max-height: 200px;
    padding: 1.5rem;
}

.faq-home-answer p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.7;
    font-family: inherit;
}

.faq-cta {
    text-align: center;
    margin-top: 3rem;
    padding: 2rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.faq-cta p {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    font-family: inherit;
}

.faq-contact-btn {
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

.faq-contact-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.4);
    color: white;
}

/* Final CTA */
.final-cta-home {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6a3093 100%);
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

.cta-animation {
    position: absolute;
    width: 100%;
    height: 100%;
}

.animated-shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: shapeMove 12s ease-in-out infinite;
}

.shape-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 70%;
    animation-delay: 4s;
}

.shape-3 {
    width: 100px;
    height: 100px;
    top: 80%;
    right: 30%;
    animation-delay: 8s;
}

@keyframes shapeMove {
    0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
    33% { transform: translateY(-40px) scale(1.1) rotate(120deg); }
    66% { transform: translateY(-20px) scale(0.9) rotate(240deg); }
}

.final-cta-content {
    text-align: center;
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.cta-title {
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.3;
    font-family: inherit;
}

.cta-description {
    font-size: 1.2rem;
    line-height: 1.7;
    margin-bottom: 3rem;
    opacity: 0.95;
    font-family: inherit;
}

.cta-actions-final {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.cta-btn-final {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 2.5rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.cta-btn-final.primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.4);
}

.cta-btn-final.secondary {
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
    transition: left 0.8s ease;
}

.cta-btn-final.primary:hover .btn-shine {
    left: 100%;
}

.cta-btn-final:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    color: white;
}

.btn-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.btn-text {
    text-align: right;
    flex: 1;
}

.btn-main {
    display: block;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.btn-sub {
    display: block;
    font-size: 0.8rem;
    opacity: 0.8;
    font-family: inherit;
}

.final-guarantees {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.guarantee-final {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    font-family: inherit;
}

.guarantee-final i {
    color: #FFD700;
    font-size: 1.2rem;
}

/* Responsive Home */
@media (max-width: 1200px) {
    .hero-content-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
    }
    
    .services-showcase {
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    }
    
    .advantages-grid {
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    }
}

@media (max-width: 768px) {
    .home-hero {
        padding: 3rem 0;
    }
    
    .hero-main-title {
        font-size: 2.5rem;
    }
    
    .hero-features {
        grid-template-columns: 1fr;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-guarantees {
        flex-direction: column;
        align-items: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .services-showcase {
        grid-template-columns: 1fr;
    }
    
    .blog-categories-grid {
        grid-template-columns: 1fr;
    }
    
    .advantages-grid {
        grid-template-columns: 1fr;
    }
    
    .process-timeline {
        grid-template-columns: 1fr;
    }
    
    .pricing-features {
        grid-template-columns: 1fr;
    }
    
    .faq-home-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-actions-final {
        flex-direction: column;
        align-items: center;
    }
    
    .final-guarantees {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .home-hero {
        padding: 2rem 0;
    }
    
    .hero-main-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .advantage-card {
        padding: 2rem 1.5rem;
    }
    
    .process-step-home {
        padding: 1.5rem;
    }
    
    .pricing-feature-card {
        padding: 2rem 1.5rem;
    }
    
    .cta-btn-final {
        padding: 1.25rem 2rem;
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ functionality
    window.toggleHomeFAQ = function(index) {
        const question = document.querySelector(`.faq-home-item:nth-child(${index + 1}) .faq-home-question`);
        const answer = document.getElementById('home-faq-' + index);
        
        if (!question || !answer) return;
        
        const isActive = answer.classList.contains('active');
        
        // Close all other FAQs
        document.querySelectorAll('.faq-home-answer').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.faq-home-question').forEach(el => el.classList.remove('active'));
        
        if (!isActive) {
            answer.classList.add('active');
            question.classList.add('active');
        }
    };
    
    // Counter animation for statistics
    const counters = document.querySelectorAll('.stat-number');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
    
    function animateCounter(element) {
        const text = element.textContent;
        const hasPlus = text.includes('+');
        const hasPercent = text.includes('%');
        const number = parseInt(text.replace(/[^\d]/g, ''));
        
        if (isNaN(number)) return;
        
        let current = 0;
        const increment = number / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= number) {
                current = number;
                clearInterval(timer);
            }
            
            let displayValue = Math.floor(current).toString();
            
            // Convert to Persian numbers
            const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            displayValue = displayValue.replace(/\d/g, d => persianNumbers[d]);
            
            if (hasPlus) displayValue += '+';
            if (hasPercent) displayValue += '%';
            
            element.textContent = displayValue;
        }, 40);
    }
    
    // Scroll animations
    const animateElements = document.querySelectorAll('.service-category-showcase, .advantage-card, .blog-category-card, .process-step-home, .pricing-feature-card, .faq-home-item');
    
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    animateElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(50px)';
        element.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        scrollObserver.observe(element);
    });
});
</script>

<?php get_footer(); ?>