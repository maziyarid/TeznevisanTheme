<?php get_header(); ?>

<main id="main-content" class="service-category-archive-main">
    
    <!-- Category Hero -->
    <section class="category-hero">
        <div class="hero-background">
            <div class="hero-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
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
                            <li class="breadcrumb-item">
                                <a href="<?php echo home_url('/service-category'); ?>">دسته‌بندی خدمات</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php single_term_title(); ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <h1 class="hero-title">
                    خدمات <?php single_term_title(); ?>
                </h1>
                
                <?php if (term_description()): ?>
                    <div class="hero-description">
                        <?php echo term_description(); ?>
                    </div>
                <?php endif; ?>
                
                <div class="category-stats">
                    <?php
                    $term = get_queried_object();
                    $services_count = $term->count;
                    ?>
                    <div class="stat-item">
                        <i class="fas fa-tools"></i>
                        <span><?php echo $services_count; ?> خدمت</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-star"></i>
                        <span>کیفیت تضمینی</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-headset"></i>
                        <span>پشتیبانی ۲۴/۷</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Category Content Box -->
    <section class="category-content-box">
        <div class="container">
            <div class="content-wrapper">
                <?php
                $term = get_queried_object();
                $category_content = get_term_meta($term->term_id, 'category_content', true);
                
                if ($category_content): ?>
                    <div class="category-rich-content">
                        <h2 class="content-title">
                            <i class="fas fa-info-circle"></i>
                            درباره <?php single_term_title(); ?>
                        </h2>
                        <div class="rich-content">
                            <?php echo wpautop($category_content); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="category-rich-content">
                        <h2 class="content-title">
                            <i class="fas fa-info-circle"></i>
                            خدمات <?php single_term_title(); ?> تزنویسان
                        </h2>
                        <div class="rich-content">
                            <p>مجموعه کاملی از خدمات تخصصی <?php single_term_title(); ?> را با بالاترین کیفیت و تضمین رضایت ارائه می‌دهیم.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Services Grid -->
    <section class="services-grid-section">
        <div class="container">
            <?php if (have_posts()): ?>
                <div class="services-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <article class="service-card">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="service-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('service-thumbnail', array(
                                            'class' => 'service-img',
                                            'loading' => 'lazy'
                                        )); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="service-content">
                                <h3 class="service-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php
                                $subtitle = get_post_meta(get_the_ID(), 'service_subtitle', true);
                                if ($subtitle):
                                ?>
                                    <p class="service-subtitle"><?php echo esc_html($subtitle); ?></p>
                                <?php endif; ?>
                                
                                <div class="service-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <?php
                                $price_min = get_post_meta(get_the_ID(), 'price_range_min', true);
                                $price_max = get_post_meta(get_the_ID(), 'price_range_max', true);
                                if ($price_min || $price_max):
                                ?>
                                    <div class="service-pricing">
                                        <i class="fas fa-tag"></i>
                                        <?php if ($price_min && $price_max): ?>
                                            از <?php echo number_format($price_min); ?> تا <?php echo number_format($price_max); ?> تومان
                                        <?php elseif ($price_min): ?>
                                            از <?php echo number_format($price_min); ?> تومان
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="service-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn-primary">
                                        <i class="fas fa-arrow-left"></i>
                                        مشاهده جزئیات
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-services-found">
                    <div class="no-services-icon">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <h3>خدمتی در این دسته‌بندی یافت نشد</h3>
                    <p>در حال حاضر هیچ خدمتی در این دسته‌بندی موجود نیست.</p>
                    <a href="<?php echo get_post_type_archive_link('services'); ?>" class="btn-primary">
                        <i class="fas fa-arrow-right"></i>
                        مشاهده تمام خدمات
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
</main>

<style>
/* Service Category Archive Styles */
.service-category-archive-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
}

/* Admin bar fix */
body.admin-bar .service-category-archive-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .service-category-archive-main {
        padding-top: 116px;
    }
}

/* Category Hero */
.category-hero {
    background: linear-gradient(135deg, #1FA547 0%, #178A3A 50%, #0f5d2a 100%);
    color: white;
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.1;
}

.hero-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.hero-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    animation: heroFloat 8s ease-in-out infinite;
}

.shape-1 { width: 100px; height: 100px; top: 20%; right: 15%; animation-delay: 0s; }
.shape-2 { width: 150px; height: 150px; top: 60%; right: 70%; animation-delay: 2s; }
.shape-3 { width: 80px; height: 80px; top: 80%; right: 20%; animation-delay: 4s; }

@keyframes heroFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.2; }
    50% { transform: translateY(-30px) rotate(180deg); opacity: 0.4; }
}

.hero-content {
    text-align: center;
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.breadcrumb {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0 0 2rem 0;
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
}

.breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-description {
    font-size: 1.2rem;
    line-height: 1.7;
    margin-bottom: 2rem;
    opacity: 0.95;
}

.category-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.category-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.5rem;
    border-radius: 30px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
}

/* Category Content Box */
.category-content-box {
    padding: 4rem 0;
    background: var(--bg-main);
}

.category-rich-content {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    max-width: 1000px;
    margin: 0 auto;
}

.content-title {
    color: var(--primary-color);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 3px solid var(--primary-color);
    padding-bottom: 1rem;
}

.rich-content {
    color: var(--text-primary);
    line-height: 1.8;
    font-size: 1.1rem;
}

.rich-content p {
    margin-bottom: 1.5rem;
}

/* Services Grid */
.services-grid-section {
    padding: 5rem 0;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.service-card {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.4s ease;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(31, 165, 71, 0.15);
    border-color: var(--primary-color);
}

.service-image {
    height: 250px;
    overflow: hidden;
}

.service-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.service-card:hover .service-img {
    transform: scale(1.1);
}

.service-content {
    padding: 2rem;
}

.service-title {
    margin: 0 0 1rem 0;
    font-size: 1.4rem;
    font-weight: 700;
    line-height: 1.3;
}

.service-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.service-title a:hover {
    color: var(--primary-color);
}

.service-subtitle {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 0.95rem;
}

.service-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.service-pricing {
    background: var(--primary-light);
    color: var(--primary-color);
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.service-actions {
    text-align: center;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
}

/* No Services */
.no-services-found {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-main);
    border-radius: 20px;
    border: 1px solid var(--border-color);
}

.no-services-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

.no-services-found h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1.8rem;
}

.no-services-found p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .service-category-archive-main {
        padding-top: 70px;
    }
    
    body.admin-bar .service-category-archive-main {
        padding-top: 102px;
    }
    
    .category-hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .category-stats {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .category-hero {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 1.7rem;
    }
    
    .category-rich-content {
        padding: 2rem 1.5rem;
    }
}
</style>

<?php get_footer(); ?>