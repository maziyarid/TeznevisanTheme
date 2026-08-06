<?php
/*
Template Name: Sitemap
*/
get_header(); ?>

<main id="main-content" class="sitemap-page-main">
    
    <!-- Sitemap Hero -->
    <section class="sitemap-hero">
        <div class="hero-bg">
            <div class="network-animation">
                <div class="network-node node-1"></div>
                <div class="network-node node-2"></div>
                <div class="network-node node-3"></div>
                <div class="network-node node-4"></div>
                <div class="network-connection con-1"></div>
                <div class="network-connection con-2"></div>
                <div class="network-connection con-3"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="sitemap-hero-content">
                <div class="hero-text">
                    <h1 class="sitemap-title">
                        <i class="fas fa-sitemap"></i>
                        نقشه سایت
                    </h1>
                    <p class="sitemap-description">
                        دسترسی آسان به تمام صفحات و بخش‌های سایت تزنویسان
                    </p>
                    
                    <div class="sitemap-stats">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo wp_count_posts()->publish + wp_count_posts('services')->publish; ?></span>
                            <span class="stat-label">صفحه و مطلب</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo count(get_categories()); ?></span>
                            <span class="stat-label">دسته‌بندی</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo wp_count_posts('services')->publish; ?></span>
                            <span class="stat-label">خدمت</span>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="sitemap-illustration">
                        <div class="site-structure">
                            <div class="structure-level level-1">
                                <div class="structure-item main">
                                    <i class="fas fa-home"></i>
                                    <span>خانه</span>
                                </div>
                            </div>
                            <div class="structure-level level-2">
                                <div class="structure-item">
                                    <i class="fas fa-tools"></i>
                                    <span>خدمات</span>
                                </div>
                                <div class="structure-item">
                                    <i class="fas fa-blog"></i>
                                    <span>وبلاگ</span>
                                </div>
                                <div class="structure-item">
                                    <i class="fas fa-info-circle"></i>
                                    <span>درباره ما</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Sitemap Content -->
    <section class="sitemap-content">
        <div class="container">
            <div class="sitemap-grid">
                
                <!-- Main Pages -->
                <div class="sitemap-section">
                    <div class="section-header">
                        <h2>
                            <i class="fas fa-file-alt"></i>
                            صفحات اصلی
                        </h2>
                    </div>
                    <div class="sitemap-links">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="sitemap-link main-page">
                            <div class="link-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">صفحه اصلی</span>
                                <span class="link-desc">معرفی خدمات و امکانات</span>
                            </div>
                        </a>
                        
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="sitemap-link">
                            <div class="link-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">درباره ما</span>
                                <span class="link-desc">معرفی تیم و تاریخچه</span>
                            </div>
                        </a>
                        
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="sitemap-link">
                            <div class="link-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">تماس با ما</span>
                                <span class="link-desc">راه‌های ارتباطی</span>
                            </div>
                        </a>
                        
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>" class="sitemap-link special">
                            <div class="link-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">ثبت سفارش</span>
                                <span class="link-desc">سفارش خدمات</span>
                            </div>
                        </a>
                        
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>" class="sitemap-link">
                            <div class="link-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">حریم خصوصی</span>
                                <span class="link-desc">قوانین و مقررات</span>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Services -->
                <div class="sitemap-section">
                    <div class="section-header">
                        <h2>
                            <i class="fas fa-tools"></i>
                            خدمات
                        </h2>
                    </div>
                    <div class="sitemap-links">
                        <a href="<?php echo esc_url(get_post_type_archive_link('services')); ?>" class="sitemap-link archive-link">
                            <div class="link-icon">
                                <i class="fas fa-th-large"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">همه خدمات</span>
                                <span class="link-desc">مشاهده تمام خدمات</span>
                            </div>
                        </a>
                        
                        <?php
                        $services = get_posts(array(
                            'post_type' => 'services',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        ));
                        
                        foreach ($services as $service) :
                        ?>
                            <a href="<?php echo esc_url(get_permalink($service)); ?>" class="sitemap-link">
                                <div class="link-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="link-content">
                                    <span class="link-title"><?php echo esc_html(get_the_title($service)); ?></span>
                                    <span class="link-desc"><?php echo wp_trim_words(get_post_field('post_excerpt', $service), 8); ?></span>
                                </div>
                            </a>
                        <?php 
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
                <!-- Blog Categories -->
                <div class="sitemap-section">
                    <div class="section-header">
                        <h2>
                            <i class="fas fa-folder-open"></i>
                            دسته‌بندی مطالب
                        </h2>
                    </div>
                    <div class="sitemap-links">
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="sitemap-link archive-link">
                            <div class="link-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">همه مطالب</span>
                                <span class="link-desc">آرشیو کامل وبلاگ</span>
                            </div>
                        </a>
                        
                        <?php
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'hide_empty' => false
                        ));
                        
                        foreach ($categories as $category) :
                            $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
                        ?>
                            <a href="<?php echo esc_url(get_category_link($category)); ?>" 
                               class="sitemap-link"
                               style="--link-color: <?php echo esc_attr($cat_color); ?>">
                                <div class="link-icon">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <div class="link-content">
                                    <span class="link-title"><?php echo esc_html($category->name); ?></span>
                                    <span class="link-desc"><?php echo $category->count; ?> مطلب</span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Recent Posts -->
                <div class="sitemap-section">
                    <div class="section-header">
                        <h2>
                            <i class="fas fa-clock"></i>
                            آخرین مطالب
                        </h2>
                    </div>
                    <div class="sitemap-links">
                        <?php
                        $recent_posts = get_posts(array(
                            'posts_per_page' => 10,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        foreach ($recent_posts as $post) :
                        ?>
                            <a href="<?php echo esc_url(get_permalink($post)); ?>" class="sitemap-link">
                                <div class="link-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="link-content">
                                    <span class="link-title"><?php echo esc_html(get_the_title($post)); ?></span>
                                    <span class="link-desc"><?php echo get_the_date('j F Y', $post); ?></span>
                                </div>
                            </a>
                        <?php 
                        endforeach;
                        wp_reset_postdata();
                        ?>
                        
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="sitemap-link view-more">
                            <div class="link-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="link-content">
                                <span class="link-title">مشاهده همه مطالب</span>
                                <span class="link-desc">آرشیو کامل</span>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Archive Pages -->
                <div class="sitemap-section">
                    <div class="section-header">
                        <h2>
                            <i class="fas fa-archive"></i>
                            آرشیو
                        </h2>
                    </div>
                    <div class="sitemap-links">
                        <?php
                        $archives = wp_get_archives(array(
                            'type' => 'monthly',
                            'limit' => 12,
                            'format' => 'custom',
                            'echo' => false
                        ));
                        
                        if ($archives) :
                            $archive_items = explode("\n", trim($archives));
                            foreach (array_slice($archive_items, 0, 6) as $archive_item) :
                                if (trim($archive_item)) :
                                    preg_match('/<a href="([^"]*)"[^>]*>([^<]*)<\/a>/', $archive_item, $matches);
                                    if ($matches) :
                        ?>
                                        <a href="<?php echo esc_url($matches[1]); ?>" class="sitemap-link">
                                            <div class="link-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="link-content">
                                                <span class="link-title"><?php echo esc_html($matches[2]); ?></span>
                                                <span class="link-desc">آرشیو ماهانه</span>
                                            </div>
                                        </a>
                        <?php 
                                    endif;
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
</main>

<style>
/* Sitemap Page Styles */
.sitemap-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

.sitemap-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.1;
}

.network-animation {
    position: absolute;
    width: 100%;
    height: 100%;
}

.network-node {
    position: absolute;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: nodeFloat 4s ease-in-out infinite;
}

.node-1 { top: 20%; right: 20%; animation-delay: 0s; }
.node-2 { top: 60%; right: 70%; animation-delay: 1s; }
.node-3 { top: 80%; right: 30%; animation-delay: 2s; }
.node-4 { top: 40%; right: 50%; animation-delay: 3s; }

@keyframes nodeFloat {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-20px) scale(1.2); }
}

.network-connection {
    position: absolute;
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
    animation: connectionPulse 6s ease-in-out infinite;
}

.con-1 { 
    top: 25%; right: 25%; width: 30%; 
    transform: rotate(45deg); 
    animation-delay: 0s; 
}
.con-2 { 
    top: 50%; right: 35%; width: 25%; 
    transform: rotate(-30deg); 
    animation-delay: 2s; 
}
.con-3 { 
    top: 70%; right: 45%; width: 20%; 
    transform: rotate(60deg); 
    animation-delay: 4s; 
}

@keyframes connectionPulse {
    0%, 100% { opacity: 0.2; }
    50% { opacity: 0.6; }
}

.sitemap-hero-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 3rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.sitemap-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-family: inherit;
}

.sitemap-description {
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    opacity: 0.9;
    font-family: inherit;
}

.sitemap-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.sitemap-stats .stat-item {
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem 1.5rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.sitemap-stats .stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.sitemap-stats .stat-label {
    font-size: 0.85rem;
    opacity: 0.8;
    font-family: inherit;
}

.sitemap-illustration {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.site-structure {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

.structure-level {
    display: flex;
    gap: 1.5rem;
    align-items: center;
}

.structure-item {
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem;
    border-radius: 10px;
    text-align: center;
    min-width: 80px;
    transition: all 0.3s ease;
}

.structure-item:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.structure-item.main {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.structure-item i {
    display: block;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.structure-item span {
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

.sitemap-content {
    padding: 4rem 0;
}

.sitemap-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 3rem;
}

.sitemap-section {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.section-header {
    background: var(--primary-color);
    color: white;
    padding: 1.5rem 2rem;
    text-align: center;
}

.section-header h2 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-family: inherit;
}

.sitemap-links {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.sitemap-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.sitemap-link::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: var(--link-color, var(--primary-color));
    transition: width 0.3s ease;
}

.sitemap-link:hover::before {
    width: 4px;
}

.sitemap-link:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--link-color, var(--primary-color));
    transform: translateX(-5px);
    color: var(--text-primary);
}

.sitemap-link.main-page {
    background: rgba(31, 165, 71, 0.1);
    border-color: var(--primary-color);
}

.sitemap-link.special {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(255, 71, 87, 0.1));
    border-color: #FF6B6B;
    --link-color: #FF6B6B;
}

.sitemap-link.archive-link {
    background: rgba(102, 126, 234, 0.1);
    border-color: #667eea;
    --link-color: #667eea;
}

.sitemap-link.view-more {
    background: rgba(255, 193, 7, 0.1);
    border-color: #ffc107;
    --link-color: #ffc107;
}

.link-icon {
    width: 45px;
    height: 45px;
    background: var(--link-color, var(--primary-color));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

.link-content {
    flex: 1;
}

.link-title {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
    font-family: inherit;
}

.link-desc {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-family: inherit;
}

@media (max-width: 1024px) {
    .sitemap-hero-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .sitemap-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .sitemap-hero {
        padding: 3rem 0;
    }
    
    .sitemap-title {
        font-size: 2.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .sitemap-stats {
        justify-content: center;
    }
    
    .sitemap-links {
        padding: 1.5rem;
    }
}
</style>

<?php get_footer(); ?>