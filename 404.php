<?php get_header(); ?>

<main id="main-content" class="error-page-main">
    
    <!-- 404 Hero -->
    <section class="error-hero">
        <div class="error-animation-bg">
            <div class="floating-404">
                <span class="digit digit-4-1">4</span>
                <div class="digit digit-0">
                    <div class="zero-ring"></div>
                </div>
                <span class="digit digit-4-2">4</span>
            </div>
        </div>
        
        <div class="container">
            <div class="error-content">
                <div class="error-text">
                    <h1 class="error-title">صفحه پیدا نشد!</h1>
                    <p class="error-description">
                        متأسفانه صفحه مورد نظر شما وجود ندارد یا ممکن است آدرس آن تغییر کرده باشد.
                    </p>
                    
                    <div class="error-suggestions">
                        <h3>چه کاری می‌توانید انجام دهید؟</h3>
                        <div class="suggestions-list">
                            <div class="suggestion-item">
                                <i class="fas fa-search"></i>
                                <span>از جستجو استفاده کنید</span>
                            </div>
                            <div class="suggestion-item">
                                <i class="fas fa-home"></i>
                                <span>به صفحه اصلی بروید</span>
                            </div>
                            <div class="suggestion-item">
                                <i class="fas fa-phone"></i>
                                <span>با ما تماس بگیرید</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="error-actions">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="error-btn primary">
                            <i class="fas fa-home"></i>
                            صفحه اصلی
                        </a>
                        <button class="error-btn secondary" onclick="history.back()">
                            <i class="fas fa-arrow-right"></i>
                            صفحه قبل
                        </button>
                        <button class="error-btn secondary" onclick="document.getElementById('error-search').focus()">
                            <i class="fas fa-search"></i>
                            جستجو
                        </button>
                    </div>
                </div>
                
                <div class="error-search-section">
                    <div class="search-box">
                        <h3>جستجو در سایت</h3>
                        <form class="error-search-form" role="search" method="get" action="<?php echo home_url('/'); ?>">
                            <div class="search-input-wrapper">
                                <input type="search" 
                                       id="error-search"
                                       class="search-input" 
                                       placeholder="دنبال چه چیزی می‌گردید؟" 
                                       name="s" 
                                       required>
                                <button type="submit" class="search-submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        
                        <div class="popular-searches">
                            <h4>جستجوهای محبوب:</h4>
                            <div class="search-tags">
                                <a href="/?s=پایان‌نامه" class="search-tag">پایان‌نامه</a>
                                <a href="/?s=مقاله" class="search-tag">مقاله علمی</a>
                                <a href="/?s=پروپوزال" class="search-tag">پروپوزال</a>
                                <a href="/?s=ترجمه" class="search-tag">ترجمه</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="helpful-links">
                        <h3>لینک‌های مفید</h3>
                        <div class="helpful-links-grid">
                            <a href="<?php echo esc_url(get_post_type_archive_link('services')); ?>" class="helpful-link">
                                <i class="fas fa-tools"></i>
                                <span>خدمات</span>
                            </a>
                            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="helpful-link">
                                <i class="fas fa-blog"></i>
                                <span>وبلاگ</span>
                            </a>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="helpful-link">
                                <i class="fas fa-phone"></i>
                                <span>تماس</span>
                            </a>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="helpful-link">
                                <i class="fas fa-info"></i>
                                <span>درباره ما</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Popular Content -->
    <section class="popular-content-section">
        <div class="container">
            <h2 class="section-title">محبوب‌ترین محتوا</h2>
            <div class="popular-grid">
                
                <!-- Popular Services -->
                <div class="popular-services">
                    <h3>خدمات پرطرفدار</h3>
                    <div class="popular-items">
                        <?php
                        $popular_services = get_posts(array(
                            'post_type' => 'services',
                            'posts_per_page' => 4,
                            'meta_key' => 'service_views',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        ));
                        
                        foreach ($popular_services as $service) :
                        ?>
                            <a href="<?php echo esc_url(get_permalink($service)); ?>" class="popular-item">
                                <div class="item-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="item-content">
                                    <span class="item-title"><?php echo esc_html(get_the_title($service)); ?></span>
                                    <span class="item-desc">خدمت محبوب</span>
                                </div>
                            </a>
                        <?php 
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
                <!-- Popular Posts -->
                <div class="popular-posts">
                    <h3>مطالب پربازدید</h3>
                    <div class="popular-items">
                        <?php
                        $popular_posts = get_posts(array(
                            'posts_per_page' => 4,
                            'meta_key' => 'post_views',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        ));
                        
                        foreach ($popular_posts as $post) :
                        ?>
                            <a href="<?php echo esc_url(get_permalink($post)); ?>" class="popular-item">
                                <div class="item-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="item-content">
                                    <span class="item-title"><?php echo esc_html(get_the_title($post)); ?></span>
                                    <span class="item-desc"><?php echo get_the_date('j M', $post); ?></span>
                                </div>
                            </a>
                        <?php 
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
</main>

<style>
.error-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

.error-hero {
    background: linear-gradient(135deg, #FF6B6B, #FF4757);
    color: white;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.error-animation-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.1;
}

.floating-404 {
    display: flex;
    align-items: center;
    gap: 2rem;
    font-size: 8rem;
    font-weight: 800;
    animation: float404 4s ease-in-out infinite;
}

@keyframes float404 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
}

.digit {
    animation: digitWobble 2s ease-in-out infinite;
}

.digit-4-1 { animation-delay: 0s; }
.digit-0 { animation-delay: 0.5s; }
.digit-4-2 { animation-delay: 1s; }

@keyframes digitWobble {
    0%, 100% { transform: scale(1) rotate(0deg); }
    25% { transform: scale(1.05) rotate(1deg); }
    75% { transform: scale(0.95) rotate(-1deg); }
}

.zero-ring {
    width: 120px;
    height: 120px;
    border: 8px solid currentColor;
    border-radius: 50%;
    animation: zeroSpin 3s linear infinite;
}

@keyframes zeroSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.error-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.error-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    font-family: inherit;
}

.error-description {
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    opacity: 0.9;
    font-family: inherit;
}

.error-suggestions h3 {
    font-size: 1.3rem;
    margin-bottom: 1rem;
    font-family: inherit;
}

.suggestions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.suggestion-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 10px;
    font-family: inherit;
}

.suggestion-item i {
    font-size: 1.1rem;
}

.error-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.error-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    font-family: inherit;
}

.error-btn.primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.4);
}

.error-btn.secondary {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.error-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
}

.error-search-section {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
}

.search-box {
    margin-bottom: 2rem;
}

.search-box h3 {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    font-family: inherit;
}

.error-search-form {
    margin-bottom: 1.5rem;
}

.search-input-wrapper {
    display: flex;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    overflow: hidden;
}

.search-input {
    flex: 1;
    padding: 1rem;
    border: none;
    background: transparent;
    color: #333;
    font-family: inherit;
}

.search-submit {
    padding: 1rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
}

.popular-searches h4 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    font-family: inherit;
}

.search-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.search-tag {
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 15px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.search-tag:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

.helpful-links h3 {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    font-family: inherit;
}

.helpful-links-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.helpful-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    text-decoration: none;
    color: white;
    transition: all 0.3s ease;
    font-family: inherit;
}

.helpful-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.helpful-link i {
    font-size: 1.5rem;
}

.popular-content-section {
    background: var(--bg-main);
    padding: 4rem 0;
}

.section-title {
    text-align: center;
    color: var(--text-primary);
    font-size: 2rem;
    margin-bottom: 3rem;
    font-family: inherit;
}

.popular-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 3rem;
}

.popular-services,
.popular-posts {
    background: var(--bg-secondary);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid var(--border-color);
}

.popular-services h3,
.popular-posts h3 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    font-size: 1.3rem;
    font-family: inherit;
}

.popular-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.popular-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.popular-item:hover {
    border-color: var(--primary-color);
    background: rgba(31, 165, 71, 0.05);
    transform: translateX(-3px);
    color: var(--text-primary);
}

.item-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.item-content {
    flex: 1;
}

.item-title {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.item-desc {
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-family: inherit;
}

@media (max-width: 1024px) {
    .error-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .popular-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .error-hero {
        padding: 3rem 0;
    }
    
    .error-title {
        font-size: 2.5rem;
    }
    
    .floating-404 {
        font-size: 5rem;
    }
    
    .helpful-links-grid {
        grid-template-columns: 1fr;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php get_footer(); ?>