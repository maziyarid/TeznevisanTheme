<?php
/*
Template Name: Service Category Hub
*/
get_header();
?>

<main id="main-content" class="service-category-hub-main">
    
    <!-- Hub Hero -->
    <section class="hub-hero">
        <div class="hero-background">
            <div class="hero-particles">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <div class="breadcrumb-nav">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo home_url(); ?>">
                                    <i class="fas fa-home"></i>
                                    خانه
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo get_post_type_archive_link('services'); ?>">خدمات</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                دسته‌بندی خدمات
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <div class="hero-badge">
                    <i class="fas fa-sitemap"></i>
                    مرکز دسته‌بندی خدمات
                </div>
                
                <h1 class="hero-title">
                    دسته‌بندی‌های خدمات
                    <span class="highlight-text">نگارش تزنویسان</span>
                </h1>
                
                <p class="hero-description">
                    خدمات تخصصی نگارش ما به دسته‌بندی‌های مختلف تقسیم شده‌اند تا بتوانید به راحتی 
                    خدمت مورد نظر خود را پیدا کنید. هر دسته‌بندی شامل خدمات تخصصی و با کیفیت است.
                </p>
                
                <div class="hero-stats">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'service_category',
                        'hide_empty' => true
                    ));
                    $total_services = wp_count_posts('services')->publish ?? 0;
                    ?>
                    <div class="stat-item">
                        <i class="fas fa-layer-group"></i>
                        <div class="stat-content">
                            <span class="stat-number"><?php echo count($categories); ?></span>
                            <span class="stat-label">دسته‌بندی</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-tools"></i>
                        <div class="stat-content">
                            <span class="stat-number"><?php echo $total_services; ?></span>
                            <span class="stat-label">خدمت</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <div class="stat-content">
                            <span class="stat-number">۴۵۰+</span>
                            <span class="stat-label">متخصص</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Overview -->
    <section class="categories-overview">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list-ul"></i>
                    همه دسته‌بندی‌ها
                </h2>
                <p class="section-description">
                    مجموعه کاملی از دسته‌بندی‌های خدمات تخصصی ما
                </p>
            </div>
            
            <div class="categories-grid">
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'service_category',
                    'hide_empty' => true,
                    'orderby' => 'count',
                    'order' => 'DESC'
                ));
                
                $category_colors = array(
                    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
                    '#FFEAA7', '#DDA0DD', '#74B9FF', '#FD79A8'
                );
                
                foreach ($categories as $index => $category):
                    $color = $category_colors[$index % count($category_colors)];
                    $category_content = get_term_meta($category->term_id, 'category_content', true);
                ?>
                    <div class="category-card" style="--category-color: <?php echo $color; ?>">
                        <div class="category-background">
                            <div class="category-pattern"></div>
                        </div>
                        
                        <div class="category-header">
                            <div class="category-icon-wrapper">
                                <div class="category-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="icon-glow"></div>
                            </div>
                            <h3 class="category-title">
                                <a href="<?php echo get_term_link($category); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </h3>
                            <p class="category-count"><?php echo $category->count; ?> خدمت موجود</p>
                        </div>
                        
                        <div class="category-content">
                            <?php if ($category->description): ?>
                                <div class="category-description">
                                    <?php echo wpautop(wp_trim_words($category->description, 25)); ?>
                                </div>
                            <?php else: ?>
                                <div class="category-description">
                                    <p>مجموعه کاملی از خدمات تخصصی <?php echo esc_html($category->name); ?> 
                                    با کیفیت بالا و تضمین رضایت.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="category-footer">
                            <div class="category-features">
                                <span class="feature-badge">
                                    <i class="fas fa-shield-check"></i>
                                    تضمین کیفیت
                                </span>
                                <span class="feature-badge">
                                    <i class="fas fa-clock"></i>
                                    تحویل سریع
                                </span>
                            </div>
                            
                            <div class="category-actions">
                                <a href="<?php echo get_term_link($category); ?>" class="btn-category-primary">
                                    <i class="fas fa-eye"></i>
                                    مشاهده خدمات
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Service Category Hub Styles */
.service-category-hub-main {
    background: var(--bg-secondary);
    padding-top: 100px; /* Account for admin bar */
    min-height: 100vh;
}

/* Admin bar fix */
body.admin-bar .service-category-hub-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .service-category-hub-main {
        padding-top: 116px;
    }
}

/* Hub Hero */
.hub-hero {
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

.hero-particles {
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

.particle-1 { width: 20px; height: 20px; top: 20%; left: 10%; animation-delay: 0s; }
.particle-2 { width: 15px; height: 15px; top: 60%; left: 80%; animation-delay: 2s; }
.particle-3 { width: 25px; height: 25px; top: 80%; left: 20%; animation-delay: 4s; }
.particle-4 { width: 18px; height: 18px; top: 30%; left: 70%; animation-delay: 1s; }
.particle-5 { width: 22px; height: 22px; top: 50%; left: 40%; animation-delay: 3s; }

@keyframes particleFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
    50% { transform: translateY(-30px) rotate(180deg); opacity: 0.7; }
}

.hero-content {
    text-align: center;
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.breadcrumb-nav {
    margin-bottom: 2rem;
}

.breadcrumb {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: inline-flex;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    font-weight: 500;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    margin: 0 0.75rem;
    opacity: 0.6;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: white;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

.breadcrumb-item.active {
    color: white;
    font-weight: 600;
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
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
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
    margin-bottom: 3rem;
    opacity: 0.95;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.hero-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1.5rem 2rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.hero-stats .stat-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-5px);
}

.hero-stats .stat-item i {
    font-size: 2rem;
    color: #FFD700;
}

.stat-content {
    text-align: right;
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Categories Overview */
.categories-overview {
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
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.section-description {
    font-size: 1.2rem;
    color: var(--text-secondary);
    line-height: 1.6;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
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
    background: var(--category-color);
}

.category-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
    border-color: var(--category-color);
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
    background: radial-gradient(circle at 20% 20%, var(--category-color) 0%, transparent 70%);
    opacity: 0.05;
}

.category-header {
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
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--category-color), var(--category-color));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.icon-glow {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 3px solid var(--category-color);
    border-radius: 50%;
    opacity: 0;
    animation: iconPulse 3s infinite;
}

@keyframes iconPulse {
    0% { transform: scale(1); opacity: 0.7; }
    70% { transform: scale(1.3); opacity: 0; }
    100% { transform: scale(1.3); opacity: 0; }
}

.category-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    transition: all 0.3s ease;
}

.category-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-title a:hover {
    color: var(--category-color);
}

.category-count {
    color: var(--category-color);
    font-weight: 600;
    font-size: 1rem;
    margin: 0;
}

.category-content {
    padding: 2rem;
    position: relative;
    z-index: 2;
}

.category-description {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 2rem;
}

.category-footer {
    padding: 0 2rem 2rem;
    position: relative;
    z-index: 2;
}

.category-features {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.feature-badge {
    background: var(--category-color);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.category-actions {
    text-align: center;
}

.btn-category-primary {
    background: var(--category-color);
    color: white;
    padding: 1rem 2rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-category-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    color: white;
    filter: brightness(1.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .service-category-hub-main {
        padding-top: 70px;
    }
    
    body.admin-bar .service-category-hub-main {
        padding-top: 102px;
    }
    
    .hub-hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-stats {
        flex-direction: column;
        align-items: center;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hub-hero {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 1.7rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .category-card {
        margin: 0 1rem;
    }
    
    .category-header {
        padding: 2rem 1.5rem;
    }
    
    .category-content {
        padding: 1.5rem;
    }
}
</style>

<?php get_footer(); ?>