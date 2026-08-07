<?php get_header(); ?>

<main id="main-content" class="single-post-stylish" role="main">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Post Hero Section -->
        <section class="post-hero-section">
            <div class="hero-background">
                <div class="hero-overlay"></div>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="hero-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="container">
                <div class="post-hero-content">
                    <!-- Breadcrumb -->
                    <nav class="post-breadcrumb">
                        <a href="<?php echo home_url(); ?>">خانه</a>
                        <span>←</span>
                        <?php
                        $categories = get_the_category();
                        if ($categories) {
                            echo '<a href="' . get_category_link($categories[0]) . '">' . $categories[0]->name . '</a>';
                            echo '<span>←</span>';
                        }
                        ?>
                        <span><?php the_title(); ?></span>
                    </nav>
                    
                    <!-- Post Categories -->
                    <?php if ($categories) : ?>
                        <div class="post-categories">
                            <?php foreach (array_slice($categories, 0, 2) as $category) : ?>
                                <a href="<?php echo esc_url(get_category_link($category)); ?>" class="post-category">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Post Title -->
                    <h1 class="post-hero-title"><?php the_title(); ?></h1>
                    
                    <!-- Post Excerpt -->
                    <?php if (has_excerpt()) : ?>
                        <div class="post-hero-excerpt">
                            <p><?php the_excerpt(); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Post Meta -->
                    <div class="post-hero-meta">
                        <div class="meta-left">
                            <span class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo get_the_date('j F Y'); ?>
                                </time>
                            </span>
                            
                            <span class="meta-item">
                                <i class="fas fa-user"></i>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">
                                    تزنویسان
                                </a>
                            </span>
                            
                            <span class="meta-item">
                                <i class="fas fa-clock"></i>
                                <?php echo teznevisan_reading_time_persian(); ?>
                            </span>
                        </div>
                        
                        <div class="meta-right">
                            <span class="meta-item">
                                <i class="fas fa-eye"></i>
                                <?php echo teznevisan_get_post_views(); ?> بازدید
                            </span>
                            
                                                        <span class="meta-item">
                                <i class="fas fa-eye"></i>
                                <?php echo teznevisan_get_post_views(); ?> بازدید
                            </span>
                            
                            <span class="meta-item">
                                <i class="fas fa-comments"></i>
                                <?php echo get_comments_number(); ?> دیدگاه
                            </span>
                            
                            <div class="post-rating-hero">
                                <div class="rating-stars">
                                    <?php
                                    $rating = teznevisan_get_post_rating();
                                    for ($i = 1; $i <= 5; $i++) {
                                        $filled = $i <= $rating ? 'fas' : 'far';
                                        echo '<i class="' . $filled . ' fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <span class="rating-score"><?php echo number_format($rating, 1); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Post Content Section -->
        <section class="post-content-section">
            <div class="container">
                <div class="post-content-wrapper">
                    
                    <!-- Table of Contents -->
                    <div class="table-of-contents-floating" id="toc-floating">
                        <div class="toc-header">
                            <h4>فهرست مطالب</h4>
                            <button class="toc-toggle" id="toc-toggle">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                        <nav class="toc-nav" id="toc-nav">
                            <ul id="toc-list"></ul>
                        </nav>
                    </div>
                    
                    <!-- Reading Progress -->
                    <div class="reading-progress-bar">
                        <div class="progress-fill" id="reading-progress"></div>
                        <span class="progress-percentage" id="progress-percentage">0%</span>
                    </div>
                    
                    <!-- Main Content -->
                    <article class="post-main-content">
                        <div class="content-body">
                            <?php the_content(); ?>
                        </div>
                        
                        <!-- Post Tags as Hashtags -->
                        <?php if (get_the_tags()) : ?>
                            <div class="post-hashtags-section">
                                <h4>برچسب‌ها</h4>
                                <div class="hashtags-container">
                                    <?php
                                    $tags = get_the_tags();
                                    $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98FB98', '#F0E68C'];
                                    foreach ($tags as $index => $tag) {
                                        $tag_color = $colors[$index % count($colors)];
                                        echo '<a href="' . esc_url(get_tag_link($tag)) . '" 
                                              class="hashtag-item" 
                                              style="background-color: ' . esc_attr($tag_color) . '">' . 
                                              '#' . esc_html($tag->name) . '</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Post Interaction -->
                        <div class="post-interaction-stylish">
                            <div class="interaction-left">
                                <div class="like-dislike-section">
                                    <button class="like-btn stylish" data-post-id="<?php echo get_the_ID(); ?>">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="count"><?php echo teznevisan_get_post_likes(); ?></span>
                                        <span class="label">پسندیدم</span>
                                    </button>
                                    <button class="dislike-btn stylish" data-post-id="<?php echo get_the_ID(); ?>">
                                        <i class="fas fa-thumbs-down"></i>
                                        <span class="count"><?php echo teznevisan_get_post_dislikes(); ?></span>
                                        <span class="label">نپسندیدم</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="interaction-center">
                                <div class="rating-section">
                                    <span class="rating-label">امتیاز شما:</span>
                                    <div class="star-rating-interactive" data-post-id="<?php echo get_the_ID(); ?>">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <input type="radio" id="star<?php echo $i; ?>" name="post_rating" value="<?php echo $i; ?>">
                                            <label for="star<?php echo $i; ?>">
                                                <i class="far fa-star"></i>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="interaction-right">
                                <div class="share-section">
                                    <button class="share-btn-stylish" data-post-url="<?php the_permalink(); ?>" data-post-title="<?php the_title(); ?>">
                                        <i class="fas fa-share-alt"></i>
                                        <span>اشتراک‌گذاری</span>
                                    </button>
                                    
                                    <div class="share-dropdown" id="share-dropdown">
                                        <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                           class="share-option telegram" target="_blank">
                                            <i class="fab fa-telegram"></i>
                                            <span>تلگرام</span>
                                        </a>
                                        <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" 
                                           class="share-option whatsapp" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                            <span>واتساپ</span>
                                        </a>
                                        <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" 
                                           class="share-option email">
                                            <i class="fas fa-envelope"></i>
                                            <span>ایمیل</span>
                                        </a>
                                        <button class="share-option copy-link" data-url="<?php the_permalink(); ?>">
                                            <i class="fas fa-link"></i>
                                            <span>کپی لینک</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Content -->
                        <?php teznevisan_render_content_recommendations(); ?>
                        <?php teznevisan_render_key_takeaways(); ?>
                        <?php teznevisan_render_statistics_box(); ?>
                        <?php teznevisan_render_faq_section(); ?>
                        <?php teznevisan_render_citations(); ?>
                        <?php teznevisan_render_related_service_cta(); ?>
                        
                    </article>
                </div>
            </div>
        </section>

        <!-- Stylish Author Box -->
        <section class="author-section-stylish">
            <div class="container">
                <div class="author-box-stylish">
                    <div class="author-background-pattern">
                        <div class="pattern-element element-1"></div>
                        <div class="pattern-element element-2"></div>
                        <div class="pattern-element element-3"></div>
                    </div>
                    
                    <div class="author-content-grid">
                        <div class="author-visual">
                            <div class="author-avatar-wrapper">
                                <div class="author-avatar">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" 
                                         alt="تزنویسان"
                                         onerror="this.src='<?php echo get_template_directory_uri(); ?>/assets/images/logo.png'">
                                </div>
                                <div class="author-badge">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="author-ring"></div>
                            </div>
                            
                            <div class="author-stats-visual">
                                <div class="stat-circle">
                                    <div class="stat-content">
                                        <span class="stat-number">۴۵۰+</span>
                                        <span class="stat-label">متخصص</span>
                                    </div>
                                </div>
                                <div class="stat-circle">
                                    <div class="stat-content">
                                        <span class="stat-number">۵۰۰۰+</span>
                                        <span class="stat-label">پروژه</span>
                                    </div>
                                </div>
                                <div class="stat-circle">
                                    <div class="stat-content">
                                        <span class="stat-number">۹۸%</span>
                                        <span class="stat-label">رضایت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="author-info-section">
                            <div class="author-header">
                                <h3 class="author-name">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">
                                        تزنویسان
                                    </a>
                                </h3>
                                <p class="author-title">مرکز تخصصی خدمات نگارش دانشگاهی</p>
                                
                                <div class="author-achievements">
                                    <div class="achievement-item">
                                        <i class="fas fa-award"></i>
                                        <span>برترین مرکز نگارش ۲۰۲۳</span>
                                    </div>
                                    <div class="achievement-item">
                                        <i class="fas fa-shield-check"></i>
                                        <span>تضمین کیفیت ۱۰۰%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="author-description">
                                <p>
                                    تیم متخصص تزنویسان با بیش از ۱۰ سال تجربه در زمینه نگارش دانشگاهی، 
                                    آماده ارائه بهترین خدمات در تمامی رشته‌ها و مقاطع تحصیلی با تضمین 
                                    کیفیت و اصالت است. ما با تکیه بر دانش تخصصی و تجربه عملی، 
                                    همراه شما در مسیر موفقیت تحصیلی هستیم.
                                </p>
                            </div>
                            
                            <div class="author-specialties">
                                <h4>تخصص‌های ما</h4>
                                <div class="specialties-tags">
                                    <span class="specialty-tag">نگارش پایان‌نامه</span>
                                    <span class="specialty-tag">مقالات علمی</span>
                                    <span class="specialty-tag">تحلیل آماری</span>
                                    <span class="specialty-tag">ترجمه تخصصی</span>
                                    <span class="specialty-tag">ویرایش حرفه‌ای</span>
                                </div>
                            </div>
                            
                            <div class="author-actions">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" 
                                   class="author-btn primary">
                                    <i class="fas fa-info-circle"></i>
                                    درباره ما
                                </a>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                                   class="author-btn secondary">
                                    <i class="fas fa-phone"></i>
                                    تماس با ما
                                </a>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('order'))); ?>" 
                                   class="author-btn cta">
                                    <i class="fas fa-rocket"></i>
                                    سفارش پروژه
                                </a>
                            </div>
                            
                            <div class="author-contact-quick">
                                <div class="quick-contact-header">
                                    <i class="fas fa-headset"></i>
                                    <span>تماس سریع</span>
                                </div>
                                <div class="quick-contact-methods">
                                    <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" 
                                       class="quick-contact-item phone-quick">
                                        <i class="fas fa-phone"></i>
                                        <span><?php echo esc_html(get_theme_mod('phone_number', '09162352304')); ?></span>
                                    </a>
                                    <a href="https://wa.me/<?php echo esc_attr(str_replace(['+', ' ', '-'], '', get_theme_mod('phone_number', '09162352304'))); ?>" 
                                       class="quick-contact-item whatsapp-quick" target="_blank">
                                        <i class="fab fa-whatsapp"></i>
                                        <span>واتساپ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Posts Section -->
        <section class="related-posts-stylish">
            <div class="container">
                <div class="related-header">
                    <h2 class="related-title">
                        <i class="fas fa-layer-group"></i>
                        مطالب مرتبط
                    </h2>
                    <p class="related-subtitle">مطالب مشابه که ممکن است مورد علاقه شما باشد</p>
                </div>
                
                <div class="related-posts-grid">
                    <?php
                    $related_posts = get_posts(array(
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'category__in' => wp_get_post_categories(get_the_ID()),
                        'orderby' => 'rand'
                    ));
                    
                    foreach ($related_posts as $related_post) :
                        $related_views = get_post_meta($related_post->ID, 'post_views', true) ?: 0;
                        $related_rating = teznevisan_get_post_rating($related_post->ID);
                    ?>
                        <article class="related-post-card">
                            <div class="related-post-image">
                                <a href="<?php echo esc_url(get_permalink($related_post)); ?>">
                                    <?php echo get_the_post_thumbnail($related_post->ID, 'medium_large'); ?>
                                </a>
                                <div class="related-post-overlay">
                                    <div class="overlay-meta">
                                        <span class="overlay-views">
                                            <i class="fas fa-eye"></i>
                                            <?php echo number_format($related_views); ?>
                                        </span>
                                        <?php if ($related_rating > 0) : ?>
                                            <span class="overlay-rating">
                                                <i class="fas fa-star"></i>
                                                <?php echo number_format($related_rating, 1); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="overlay-action">
                                        <a href="<?php echo esc_url(get_permalink($related_post)); ?>" class="read-post-btn">
                                            <i class="fas fa-book-open"></i>
                                            مطالعه
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="related-post-content">
                                <div class="related-post-meta">
                                    <span class="post-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo get_the_date('j M Y', $related_post); ?>
                                    </span>
                                    <?php
                                    $related_categories = get_the_category($related_post->ID);
                                    if ($related_categories) :
                                    ?>
                                        <span class="post-category-small">
                                            <?php echo esc_html($related_categories[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="related-post-title">
                                    <a href="<?php echo esc_url(get_permalink($related_post)); ?>">
                                        <?php echo esc_html(get_the_title($related_post)); ?>
                                    </a>
                                </h3>
                                
                                <div class="related-post-excerpt">
                                    <?php echo wp_trim_words(get_post_field('post_excerpt', $related_post) ?: get_post_field('post_content', $related_post), 20, '...'); ?>
                                </div>
                                
                                <div class="related-post-footer">
                                    <a href="<?php echo esc_url(get_permalink($related_post)); ?>" class="related-read-more">
                                        ادامه مطلب
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    
                                    <div class="related-post-stats">
                                        <span class="stat-item">
                                            <i class="fas fa-comments"></i>
                                            <?php echo get_comments_number($related_post->ID); ?>
                                        </span>
                                        <span class="stat-item">
                                            <i class="fas fa-clock"></i>
                                            ۵ دقیقه
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php 
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
                
                <div class="related-cta">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                       class="view-more-posts-btn">
                        <i class="fas fa-newspaper"></i>
                        مشاهده همه مطالب
                    </a>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <?php if (comments_open() || get_comments_number()) : ?>
            <section class="comments-section-stylish">
                <div class="container">
                    <div class="comments-wrapper">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<style>
/* Single Post Stylish Design */
.single-post-stylish {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

/* Post Hero Section */
.post-hero-section {
    position: relative;
    min-height: 60vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(31, 165, 71, 0.9) 0%, 
        rgba(23, 138, 58, 0.8) 50%, 
        rgba(15, 93, 42, 0.9) 100%);
    z-index: 2;
}

.hero-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.4) contrast(1.2);
}

.post-hero-content {
    position: relative;
    z-index: 3;
    color: white;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    padding: 2rem 0;
}

.post-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.post-breadcrumb a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.post-breadcrumb a:hover {
    color: white;
}

.post-breadcrumb span {
    color: rgba(255, 255, 255, 0.6);
}

.post-categories {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 2rem;
    justify-content: center;
    flex-wrap: wrap;
}

.post-category {
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.post-category:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
    color: white;
}

.post-hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    font-family: inherit;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.post-hero-excerpt {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.post-hero-excerpt p {
    margin: 0;
    font-size: 1.1rem;
    line-height: 1.7;
    opacity: 0.95;
    font-family: inherit;
}

.post-hero-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1.5rem 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}
*, *::before, *::after {
    box-sizing: border-box;
    margin: -1px;
    padding: 0;
}

.meta-left,
.meta-right {
    display: flex;
    gap: 1.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    font-family: inherit;
}

.meta-item i {
    width: 16px;
    text-align: center;
    opacity: 0.8;
}

.meta-item a {
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: opacity 0.3s ease;
}

.meta-item a:hover {
    opacity: 0.8;
}

.post-rating-hero {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating-stars {
    display: flex;
    gap: 2px;
}

.rating-stars i {
    color: #FFD700;
    font-size: 0.9rem;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
}

.rating-score {
    font-weight: 700;
    color: #FFD700;
    font-size: 0.9rem;
    font-family: inherit;
}

/* Table of Contents Floating */
.table-of-contents-floating {
    position: fixed;
    top: 50%;
    left: 2rem;
    transform: translateY(-50%);
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    max-width: 250px;
    z-index: 100;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    display: none;
}

@media (min-width: 1400px) {
    .table-of-contents-floating {
        display: block;
    }
}

.toc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    background: var(--primary-color);
    color: white;
    border-radius: 12px 12px 0 0;
}

.toc-header h4 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
    font-family: inherit;
}

.toc-toggle {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.toc-toggle:hover {
    background: rgba(255, 255, 255, 0.3);
}

.toc-nav {
    max-height: 400px;
    /* overflow-y: auto; */
    padding: 1rem;
    transition: all 0.3s ease;
}

.toc-nav.collapsed {
    max-height: 0;
    padding: 0 1rem;
    overflow: hidden;
}

#toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

#toc-list li {
    margin-bottom: 0.5rem;
}

#toc-list a {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.85rem;
    line-height: 1.4;
    display: block;
    padding: 0.5rem;
    border-radius: 6px;
    transition: all 0.3s ease;
    font-family: inherit;
}

#toc-list a:hover,
#toc-list a.active {
    color: var(--primary-color);
    background: rgba(31, 165, 71, 0.1);
    font-weight: 500;
}

/* Reading Progress */
.reading-progress-bar {
    position: fixed;
    top: 85px;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(31, 165, 71, 0.1);
    z-index: 999;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    width: 0%;
    transition: width 0.1s ease;
}

.progress-percentage {
    position: absolute;
    top: 8px;
    right: 1rem;
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    font-family: inherit;
}

/* Post Content Section */
.post-content-section {
    padding: 4rem 0;
}

.post-content-wrapper {
    max-width: 800px;
    margin: 0 auto;
}

.post-main-content {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    position: relative;
}

.content-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-primary);
    font-family: inherit;
}

.content-body h2,
.content-body h3,
.content-body h4 {
    color: var(--text-primary);
    margin: 2.5rem 0 1.5rem 0;
    font-weight: 600;
    font-family: inherit;
    scroll-margin-top: 100px;
}

.content-body h2 {
    font-size: 1.8rem;
    border-bottom: 3px solid var(--primary-color);
    padding-bottom: 0.75rem;
}

.content-body h3 {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.content-body p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.content-body blockquote {
    background: var(--bg-secondary);
    border-right: 4px solid var(--primary-color);
    padding: 1.5rem 2rem;
    margin: 2rem 0;
    border-radius: 10px;
    font-style: italic;
    position: relative;
}

.content-body blockquote::before {
    content: '"';
    font-size: 4rem;
    color: var(--primary-color);
    position: absolute;
    top: 0;
    right: 1rem;
    line-height: 1;
    opacity: 0.3;
    font-family: serif;
}

/* Post Hashtags */
.post-hashtags-section {
    margin: 3rem 0;
    padding: 2rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.post-hashtags-section h4 {
    color: var(--text-primary);
    font-size: 1.2rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    font-family: inherit;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.post-hashtags-section h4::before {
    content: '#';
    color: var(--primary-color);
    font-size: 1.5rem;
}

.hashtags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.hashtag-item {
    padding: 0.75rem 1.25rem;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.hashtag-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.hashtag-item:hover::before {
    left: 100%;
}

.hashtag-item:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    color: white;
}

/* Post Interaction Stylish */
.post-interaction-stylish {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 2rem;
    align-items: center;
    padding: 2.5rem;
    background: linear-gradient(135deg, var(--bg-main), var(--bg-secondary));
    border-radius: 20px;
    margin: 3rem 0;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.like-dislike-section {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
}

.like-btn.stylish,
.dislike-btn.stylish {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    border: 2px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-secondary);
    border-radius: 15px;
    cursor: pointer;
    font-family: inherit;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 80px;
}

.like-btn.stylish:hover {
    border-color: #28a745;
    color: #28a745;
    background: rgba(40, 167, 69, 0.1);
    transform: translateY(-3px);
}

.dislike-btn.stylish:hover {
    border-color: #dc3545;
    color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
    transform: translateY(-3px);
}

.like-btn.stylish i,
.dislike-btn.stylish i {
    font-size: 1.2rem;
}

.like-btn.stylish .count,
.dislike-btn.stylish .count {
    font-size: 1.1rem;
    font-weight: 700;
}

.like-btn.stylish .label,
.dislike-btn.stylish .label {
    font-size: 0.8rem;
    opacity: 0.8;
}

.rating-section {
    text-align: center;
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.rating-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-family: inherit;
}

.star-rating-interactive {
    display: flex;
    justify-content: center;
    gap: 0.25rem;
}

.star-rating-interactive input {
    display: none;
}

.star-rating-interactive label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    transition: color 0.2s ease;
}

.star-rating-interactive label:hover,
.star-rating-interactive label:hover ~ label,
.star-rating-interactive input:checked ~ label {
    color: #FFD700;
}

.share-section {
    display: flex;
    justify-content: flex-end;
    position: relative;
}

.share-btn-stylish {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    font-family: inherit;
    font-weight: 600;
    transition: all 0.3s ease;
}

.share-btn-stylish:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
}

.share-btn-stylish i {
    font-size: 1.2rem;
}

.share-btn-stylish span {
    font-size: 0.8rem;
}

.share-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 10;
    min-width: 180px;
}

.share-btn-stylish:hover + .share-dropdown,
.share-dropdown:hover {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.share-option {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
    border: none;
    cursor: pointer;
    width: 100%;
}

.share-option:last-child {
    margin-bottom: 0;
}

.share-option:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(-3px);
}

.share-option i {
    width: 16px;
    text-align: center;
}

/* Author Section Stylish */
.author-section-stylish {
    background: var(--bg-main);
    padding: 5rem 0;
}

.author-box-stylish {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 25px;
    padding: 0;
    overflow: hidden;
    max-width: 1000px;
    margin: 0 auto;
    position: relative;
    box-shadow: 0 20px 60px rgba(31, 165, 71, 0.2);
    color: white;
}

.author-background-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.1;
}

.pattern-element {
    position: absolute;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: patternFloat 8s ease-in-out infinite;
}

.element-1 {
    width: 200px;
    height: 200px;
    top: -10%;
    right: -5%;
    animation-delay: 0s;
}

.element-2 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 70%;
    animation-delay: 3s;
}

.element-3 {
    width: 100px;
    height: 100px;
    top: 80%;
    right: 20%;
    animation-delay: 6s;
}

@keyframes patternFloat {
    0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
    33% { transform: translateY(-30px) scale(1.1) rotate(120deg); }
    66% { transform: translateY(-15px) scale(0.9) rotate(240deg); }
}

.author-content-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 3rem;
    align-items: center;
    padding: 3rem;
    position: relative;
    z-index: 2;
}

.author-visual {
    text-align: center;
    position: relative;
}

.author-avatar-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 2rem;
}

.author-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 2;
    background: #1FA547;
    backdrop-filter: blur(10px);
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    background: white;
}

.author-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 35px;
    height: 35px;
    background: rgba(255, 215, 0, 0.9);
    border: 3px solid white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1a1a1a;
    font-size: 0.9rem;
    z-index: 3;
}

.author-ring {
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: authorRingPulse 3s infinite;
    z-index: 1;
}

@keyframes authorRingPulse {
    0% { transform: scale(1); opacity: 0.7; }
    70% { transform: scale(1.2); opacity: 0; }
    100% { transform: scale(1.2); opacity: 0; }
}

.author-stats-visual {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.stat-circle {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.stat-circle:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.05);
}

.stat-content {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: -0.75rem;
    font-family: inherit;
}

.stat-label {
    font-size: 0.7rem;
    opacity: 0.8;
    font-family: inherit;
}

.author-info-section {
    flex: 1;
}

.author-name {
    margin: 0 0 0.5rem 0;
    font-size: 2.2rem;
    font-weight: 800;
    font-family: inherit;
}

.author-name a {
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.author-name a:hover {
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
}

.author-title {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1.5rem;
    font-weight: 500;
    font-family: inherit;
}

.author-achievements {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.achievement-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 500;
    font-family: inherit;
}

.achievement-item i {
    color: #FFD700;
    font-size: 1.1rem;
}

.author-description p {
    font-size: 1rem;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    text-align: justify;
    font-family: inherit;
}

.author-specialties h4 {
    margin: 0 0 1rem 0;
    font-size: 1.1rem;
    font-weight: 600;
    font-family: inherit;
}

.specialties-tags {
    display: flex;
    flex-direction: row;flex-wrap: wrap;align-content: center;justify-content: center;align-items: center;flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.specialty-tag {
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid rgba(255, 255, 255, 0.3);
    font-family: inherit;
}

.author-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.author-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.author-btn.primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.author-btn.secondary {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.author-btn.cta {
    background: linear-gradient(135deg, #FF6B6B, #FF4757);
    color: white;
    border: 2px solid transparent;
    animation: ctaPulse 3s infinite;
}

@keyframes ctaPulse {
    0%, 100% { box-shadow: 0 0 15px rgba(255, 107, 107, 0.4); }
    50% { box-shadow: 0 0 25px rgba(255, 107, 107, 0.7), 0 0 35px rgba(255, 107, 107, 0.3); }
}

.author-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    color: white;
}

.author-btn.cta:hover {
    background: linear-gradient(135deg, #FF4757, #FF3742);
}

.author-contact-quick {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1.5rem;
}

.quick-contact-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
    font-family: inherit;
}

.quick-contact-methods {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.quick-contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.phone-quick {
    border: 1px solid rgba(0, 123, 255, 0.5);
}

.whatsapp-quick {
    border: 1px solid rgba(37, 211, 102, 0.5);
}

.quick-contact-item:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
}

/* Related Posts Stylish */
.related-posts-stylish {
    background: var(--bg-secondary);
    padding: 5rem 0;
}

.related-header {
    text-align: center;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.related-title {
    color: var(--text-primary);
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    font-family: inherit;
}

.related-title i {
    color: var(--primary-color);
    font-size: 2rem;
}

.related-subtitle {
    color: var(--text-secondary);
    font-size: 1.1rem;
    line-height: 1.6;
    font-family: inherit;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2.5rem;
    margin-bottom: 3rem;
}

.related-post-card {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
}

.related-post-card:hover {
    transform: translateY(-10px) rotateX(2deg);
    box-shadow: 0 25px 60px rgba(31, 165, 71, 0.15);
}

.related-post-image {
    height: 220px;
    overflow: hidden;
    position: relative;
}

.related-post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-post-card:hover .related-post-image img {
    transform: scale(1.1);
}

.related-post-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(31, 165, 71, 0.8) 0%, transparent 60%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.related-post-card:hover .related-post-overlay {
    opacity: 1;
}

.overlay-meta {
    display: flex;
    justify-content: space-between;
    color: white;
    font-size: 0.85rem;
    font-weight: 600;
}

.overlay-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 0.5rem 0.75rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.overlay-action {
    text-align: center;
}

.read-post-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    font-family: inherit;
}

.read-post-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

.related-post-content {
    padding: 2rem;
}

.related-post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.post-date {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.post-category-small {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.related-post-title {
    margin: 0 0 1rem 0;
    font-size: 1.3rem;
    font-weight: 600;
    line-height: 1.4;
    font-family: inherit;
}

.related-post-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-post-title a:hover {
    color: var(--primary-color);
}

.related-post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.related-post-footer {
    display: flex;
    flex-direction: row-reverse;
    justify-content: space-between;
    align-items: flex-start;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.related-read-more {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.related-read-more:hover {
    transform: translateX(-5px);
}

.related-post-stats {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.related-post-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.related-cta {
    text-align: center;
    margin-top: 3rem;
}

.view-more-posts-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 2.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.view-more-posts-btn:hover {
    background: linear-gradient(135deg, var(--primary-dark), #0f5d2a);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(31, 165, 71, 0.3);
    color: white;
}

/* Comments Section Stylish */
.comments-section-stylish {
    background: var(--bg-main);
    padding: 4rem 0;
}

.comments-wrapper {
    max-width: 800px;
    margin: 0 auto;
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

/* Responsive Single Post */
@media (max-width: 1400px) {
    .table-of-contents-floating {
        display: none;
    }
}

@media (max-width: 1024px) {
    .author-content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
    
    .author-stats-visual {
        justify-content: center;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .post-interaction-stylish {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .post-hero-section {
        min-height: 50vh;
    }
    
    .post-hero-title {
        font-size: 2.5rem;
    }
    
    .post-hero-meta {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .meta-left,
    .meta-right {
        justify-content: center;
    }
    
    .post-main-content {
        padding: 2rem;
    }
    
    .author-content-grid {
        padding: 2rem;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .author-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .like-dislike-section {
        justify-content: center;
    }
    
    .share-dropdown {
        right: auto;
        left: 50%;
        transform: translateX(-50%) translateY(-10px);
    }
    
    .share-dropdown.active {
        transform: translateX(-50%) translateY(0);
    }
}

@media (max-width: 480px) {
    .post-hero-content {
        padding: 1.5rem 0;
    }
    
    .post-hero-title {
        font-size: 2rem;
    }
    
    .post-main-content {
        padding: 1.5rem;
    }
    
    .author-content-grid {
        padding: 1.5rem;
    }
    
    .author-avatar {
        width: 100px;
        height: 100px;
    }
    
    .stat-circle {
        width: 60px;
        height: 60px;
    }
    
    .author-name {
        font-size: 1.8rem;
    }
    
    .hashtags-container {
        justify-content: center;
    }
    
    .comments-wrapper {
        padding: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Table of Contents generation
    function generateTOC() {
        const headings = document.querySelectorAll('.content-body h2, .content-body h3, .content-body h4');
        const tocList = document.getElementById('toc-list');
        
        if (!tocList || headings.length === 0) return;
        
        tocList.innerHTML = '';
        
        headings.forEach((heading, index) => {
            const id = 'heading-' + index;
            heading.id = id;
            
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#' + id;
            a.textContent = heading.textContent;
            a.className = heading.tagName.toLowerCase();
            li.appendChild(a);
            tocList.appendChild(li);
            
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById(id);
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    generateTOC();
    
    // TOC toggle
    const tocToggle = document.getElementById('toc-toggle');
    const tocNav = document.getElementById('toc-nav');
    
    if (tocToggle && tocNav) {
        tocToggle.addEventListener('click', function() {
            tocNav.classList.toggle('collapsed');
            this.querySelector('i').style.transform = tocNav.classList.contains('collapsed') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    }
    
    // Reading progress
    function updateReadingProgress() {
        const scrollTop = window.pageYOffset;
        const docHeight = document.body.offsetHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        
        const progressFill = document.getElementById('reading-progress');
        const progressPercentage = document.getElementById('progress-percentage');
        
        if (progressFill) {
            progressFill.style.width = Math.min(scrollPercent, 100) + '%';
        }
        
        if (progressPercentage) {
            progressPercentage.textContent = Math.round(scrollPercent) + '%';
        }
        
        // Update active TOC item
        const headings = document.querySelectorAll('.content-body h2, .content-body h3, .content-body h4');
        const tocLinks = document.querySelectorAll('#toc-list a');
        
        let activeHeading = null;
        headings.forEach(heading => {
            const rect = heading.getBoundingClientRect();
            if (rect.top <= 150 && rect.bottom >= 150) {
                activeHeading = heading;
            }
        });
        
        tocLinks.forEach(link => link.classList.remove('active'));
        
        if (activeHeading) {
            const activeLink = document.querySelector(`#toc-list a[href="#${activeHeading.id}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    }
    
    let progressTicking = false;
    function requestProgressTick() {
        if (!progressTicking) {
            requestAnimationFrame(updateReadingProgress);
            progressTicking = true;
            setTimeout(() => progressTicking = false, 16);
        }
    }
    
    window.addEventListener('scroll', requestProgressTick);
    
    // Share dropdown toggle
    const shareBtn = document.querySelector('.share-btn-stylish');
    const shareDropdown = document.getElementById('share-dropdown');
    
    if (shareBtn && shareDropdown) {
        shareBtn.addEventListener('click', function() {
            shareDropdown.classList.toggle('active');
        });
        
        document.addEventListener('click', function(e) {
            if (!shareBtn.contains(e.target) && !shareDropdown.contains(e.target)) {
                shareDropdown.classList.remove('active');
            }
        });
    }
    
    // Copy link functionality
    const copyLinkBtn = document.querySelector('.copy-link');
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                const originalText = this.querySelector('span').textContent;
                this.querySelector('span').textContent = 'کپی شد!';
                this.style.background = '#28a745';
                
                setTimeout(() => {
                    this.querySelector('span').textContent = originalText;
                    this.style.background = '';
                }, 2000);
            });
        });
    }
    
    // Like/Dislike functionality
    const likeBtns = document.querySelectorAll('.like-btn.stylish');
    const dislikeBtns = document.querySelectorAll('.dislike-btn.stylish');
    
    function handleLikeDislike(btn, action) {
        const postId = btn.getAttribute('data-post-id');
        const count = btn.querySelector('.count');
        const currentCount = parseInt(count.textContent) || 0;
        
        // Simulate API call
        setTimeout(() => {
            count.textContent = currentCount + 1;
            btn.style.borderColor = action === 'like' ? '#28a745' : '#dc3545';
            btn.style.color = action === 'like' ? '#28a745' : '#dc3545';
            btn.style.background = action === 'like' ? 'rgba(40, 167, 69, 0.1)' : 'rgba(220, 53, 69, 0.1)';
        }, 300);
    }
    
    likeBtns.forEach(btn => {
        btn.addEventListener('click', () => handleLikeDislike(btn, 'like'));
    });
    
    dislikeBtns.forEach(btn => {
        btn.addEventListener('click', () => handleLikeDislike(btn, 'dislike'));
    });
    
    // Star rating functionality
    const starRating = document.querySelector('.star-rating-interactive');
    if (starRating) {
        const stars = starRating.querySelectorAll('input');
        const labels = starRating.querySelectorAll('label i');
        
        stars.forEach((star, index) => {
            star.addEventListener('change', function() {
                if (this.checked) {
                    labels.forEach((label, labelIndex) => {
                        if (labelIndex <= index) {
                            label.className = 'fas fa-star';
                        } else {
                            label.className = 'far fa-star';
                        }
                    });
                    
                    // Simulate rating submission
                    setTimeout(() => {
                        alert('امتیاز شما ثبت شد! متشکریم.');
                    }, 500);
                }
            });
        });
    }
});
</script>

<?php get_footer(); ?>