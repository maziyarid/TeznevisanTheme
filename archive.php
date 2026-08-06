<?php 
// archive.php - General Archive Template
get_header(); ?>

<main id="main-content" class="archive-main">
    
    <!-- Archive Hero -->
    <section class="archive-hero">
        <div class="hero-bg-animation">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="archive-hero-content">
                <div class="archive-info">
                    <?php if (is_category()) : ?>
                        <div class="archive-type">
                            <i class="fas fa-folder-open"></i>
                            <span>دسته‌بندی</span>
                        </div>
                        <h1 class="archive-title"><?php single_cat_title(); ?></h1>
                        <?php if (category_description()) : ?>
                            <p class="archive-description"><?php echo category_description(); ?></p>
                        <?php endif; ?>
                    <?php elseif (is_tag()) : ?>
                        <div class="archive-type">
                            <i class="fas fa-tag"></i>
                            <span>برچسب</span>
                        </div>
                        <h1 class="archive-title">#<?php single_tag_title(); ?></h1>
                        <?php if (tag_description()) : ?>
                            <p class="archive-description"><?php echo tag_description(); ?></p>
                        <?php endif; ?>
                    <?php elseif (is_author()) : ?>
                        <div class="archive-type">
                            <i class="fas fa-user"></i>
                            <span>نویسنده</span>
                        </div>
                        <h1 class="archive-title"><?php echo get_the_author(); ?></h1>
                        <?php if (get_the_author_meta('description')) : ?>
                            <p class="archive-description"><?php echo get_the_author_meta('description'); ?></p>
                        <?php endif; ?>
                    <?php elseif (is_date()) : ?>
                        <div class="archive-type">
                            <i class="fas fa-calendar"></i>
                            <span>آرشیو تاریخ</span>
                        </div>
                        <h1 class="archive-title">
                            <?php
                            if (is_year()) {
                                echo get_the_date('Y');
                            } elseif (is_month()) {
                                echo get_the_date('F Y');
                            } elseif (is_day()) {
                                echo get_the_date('j F Y');
                            }
                            ?>
                        </h1>
                    <?php else : ?>
                        <div class="archive-type">
                            <i class="fas fa-archive"></i>
                            <span>آرشیو</span>
                        </div>
                        <h1 class="archive-title">آرشیو مطالب</h1>
                        <p class="archive-description">مجموعه کامل مقالات و مطالب منتشر شده</p>
                    <?php endif; ?>
                    
                    <div class="archive-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <span><?php echo $wp_query->found_posts; ?> مطلب</span>
                        </div>
                        <?php if (is_category()) : ?>
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span>محبوب‌ترین دسته</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="archive-visual">
                    <div class="archive-illustration">
                        <div class="illustration-bg">
                            <div class="bg-circle circle-1"></div>
                            <div class="bg-circle circle-2"></div>
                            <div class="bg-circle circle-3"></div>
                        </div>
                        <div class="illustration-content">
                            <div class="illustration-icon">
                                <?php if (is_category()) : ?>
                                    <i class="fas fa-folder-open"></i>
                                <?php elseif (is_tag()) : ?>
                                    <i class="fas fa-hashtag"></i>
                                <?php elseif (is_author()) : ?>
                                    <i class="fas fa-user-edit"></i>
                                <?php elseif (is_date()) : ?>
                                    <i class="fas fa-calendar-alt"></i>
                                <?php else : ?>
                                    <i class="fas fa-newspaper"></i>
                                <?php endif; ?>
                            </div>
                            <div class="illustration-text">
                                <span>مرور مطالب</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Archive Content -->
    <section class="archive-content">
        <div class="container">
            <div class="archive-layout">
                
                <!-- Main Content -->
                <div class="archive-main-content">
                    
                    <!-- Filter and Sort -->
                    <div class="archive-controls">
                        <div class="view-controls">
                            <button class="view-btn active" data-view="grid" title="نمایش شبکه‌ای">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list" title="نمایش فهرستی">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                        
                        <div class="sort-controls">
                            <label for="sort-posts">مرتب‌سازی:</label>
                            <select id="sort-posts">
                                <option value="date-desc">جدیدترین</option>
                                <option value="date-asc">قدیمی‌ترین</option>
                                <option value="title-asc">الفبایی (الف-ی)</option>
                                <option value="title-desc">الفبایی (ی-الف)</option>
                                <option value="views-desc">پربازدیدترین</option>
                                <option value="comments-desc">پردیدگاه‌ترین</option>
                            </select>
                        </div>
                        
                        <div class="results-info">
                            <span class="results-count">
                                نمایش <?php echo $wp_query->found_posts; ?> مطلب
                            </span>
                        </div>
                    </div>
                    
                    <?php if (have_posts()) : ?>
                        
                        <!-- Posts Grid -->
                        <div class="posts-container grid-view" id="posts-container">
                            <?php while (have_posts()) : the_post(); ?>
                                <article class="archive-post-card" data-date="<?php echo get_the_date('Y-m-d'); ?>" data-views="<?php echo teznevisan_get_post_views(); ?>" data-comments="<?php echo get_comments_number(); ?>">
                                    
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-image-wrapper">
                                            <a href="<?php the_permalink(); ?>" class="post-image-link">
                                                <?php the_post_thumbnail('medium_large', array(
                                                    'class' => 'post-image',
                                                    'loading' => 'lazy'
                                                )); ?>
                                            </a>
                                            
                                            <div class="post-overlay">
                                                <div class="post-meta-overlay">
                                                    <span class="post-date">
                                                        <i class="fas fa-calendar"></i>
                                                        <?php echo get_the_date(); ?>
                                                    </span>
                                                    <span class="post-views">
                                                        <i class="fas fa-eye"></i>
                                                        <?php echo teznevisan_get_post_views(); ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="post-actions-overlay">
                                                    <a href="<?php the_permalink(); ?>" class="quick-view-btn">
                                                        <i class="fas fa-eye"></i>
                                                        مطالعه
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <?php if (get_post_meta(get_the_ID(), 'featured_post', true)) : ?>
                                                <div class="featured-badge">
                                                    <i class="fas fa-star"></i>
                                                    ویژه
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content-wrapper">
                                        <div class="post-categories">
                                            <?php
                                            $categories = get_the_category();
                                            if ($categories) {
                                                foreach (array_slice($categories, 0, 2) as $category) {
                                                    $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
                                                    echo '<a href="' . esc_url(get_category_link($category)) . '" 
                                                          class="post-category" 
                                                          style="background-color: ' . esc_attr($cat_color) . '">' . 
                                                          esc_html($category->name) . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        
                                        <h3 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <div class="post-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <div class="post-footer">
                                            <div class="post-meta">
                                                <span class="post-author">
                                                    <i class="fas fa-user"></i>
                                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">تزنویسان</a>
                                                </span>
                                                <span class="post-comments">
                                                    <i class="fas fa-comments"></i>
                                                    <?php echo get_comments_number(); ?>
                                                </span>
                                                <span class="reading-time">
                                                    <i class="fas fa-clock"></i>
                                                    ۵ دقیقه
                                                </span>
                                            </div>
                                            
                                            <div class="post-rating">
                                                <?php
                                                $rating = teznevisan_get_post_rating();
                                                if ($rating > 0) :
                                                ?>
                                                    <div class="rating-stars">
                                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                            <i class="<?php echo $i <= $rating ? 'fas' : 'far'; ?> fa-star"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <span class="rating-score"><?php echo number_format($rating, 1); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="post-tags">
                                            <?php
                                            $tags = get_the_tags();
                                            if ($tags) {
                                                foreach (array_slice($tags, 0, 3) as $tag) {
                                                    $tag_color = get_term_meta($tag->term_id, 'tag_color', true) ?: '#007cba';
                                                    echo '<a href="' . esc_url(get_tag_link($tag)) . '" 
                                                          class="post-tag" 
                                                          style="background-color: ' . esc_attr($tag_color) . '">' . 
                                                          '#' . esc_html($tag->name) . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        
                                        <div class="post-actions">
                                            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                                <span>ادامه مطلب</span>
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                            
                                            <div class="post-share">
                                                <button class="share-btn" data-post-url="<?php the_permalink(); ?>" data-post-title="<?php the_title(); ?>">
                                                    <i class="fas fa-share-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </article>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Load More Button -->
                        <div class="load-more-section">
                            <?php
                            $next_page = get_next_posts_page_link();
                            if ($next_page) :
                            ?>
                                <button class="load-more-btn" data-next-page="<?php echo esc_url($next_page); ?>">
                                    <span class="btn-content">
                                        <i class="fas fa-plus"></i>
                                        بارگذاری مطالب بیشتر
                                    </span>
                                    <span class="btn-loading">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        در حال بارگذاری...
                                    </span>
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Traditional Pagination (fallback) -->
                        <div class="archive-pagination">
                            <?php
                            the_posts_pagination(array(
                                'mid_size' => 2,
                                'prev_text' => '<i class="fas fa-chevron-right"></i> قبلی',
                                'next_text' => 'بعدی <i class="fas fa-chevron-left"></i>',
                            ));
                            ?>
                        </div>
                        
                    <?php else : ?>
                        
                        <!-- No Posts Found -->
                        <div class="no-posts-found">
                            <div class="no-posts-icon">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h3>مطلبی در این دسته‌بندی یافت نشد</h3>
                            <p>متأسفانه هیچ مطلبی در این دسته‌بندی موجود نیست.</p>
                            
                            <div class="suggestions">
                                <h4>پیشنهادات:</h4>
                                <div class="suggestion-links">
                                    <a href="<?php echo esc_url(home_url()); ?>" class="suggestion-btn">
                                        <i class="fas fa-home"></i>
                                        صفحه اصلی
                                    </a>
                                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="suggestion-btn">
                                        <i class="fas fa-blog"></i>
                                        همه مطالب
                                    </a>
                                    <a href="<?php echo esc_url(get_post_type_archive_link('services')); ?>" class="suggestion-btn">
                                        <i class="fas fa-tools"></i>
                                        خدمات
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    <?php endif; ?>
                </div>
                
                <!-- Archive Sidebar -->
                <aside class="archive-sidebar">
                    
                    <!-- Archive Search -->
                    <div class="widget archive-search-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-search"></i>
                            جستجو در این دسته
                        </h3>
                        <form class="archive-search-form" method="get" action="<?php echo home_url('/'); ?>">
                            <?php if (is_category()) : ?>
                                <input type="hidden" name="cat" value="<?php echo get_queried_object_id(); ?>">
                            <?php elseif (is_tag()) : ?>
                                <input type="hidden" name="tag" value="<?php echo get_queried_object()->slug; ?>">
                            <?php endif; ?>
                            <div class="search-input-wrapper">
                                <input type="search" name="s" placeholder="جستجو در مطالب..." class="search-input">
                                <button type="submit" class="search-submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Related Categories -->
                    <?php if (is_category()) : ?>
                        <div class="widget related-categories-widget">
                            <h3 class="widget-title">
                                <i class="fas fa-sitemap"></i>
                                دسته‌های مرتبط
                            </h3>
                            <div class="related-categories">
                                <?php
                                $current_cat = get_queried_object();
                                $related_cats = get_categories(array(
                                    'exclude' => $current_cat->term_id,
                                    'number' => 6,
                                    'orderby' => 'count',
                                    'order' => 'DESC'
                                ));
                                
                                foreach ($related_cats as $cat) :
                                    $cat_color = get_term_meta($cat->term_id, 'category_color', true) ?: '#1FA547';
                                ?>
                                    <a href="<?php echo esc_url(get_category_link($cat)); ?>" 
                                       class="related-category-item"
                                       style="--cat-color: <?php echo esc_attr($cat_color); ?>">
                                        <div class="category-info">
                                            <span class="category-name"><?php echo esc_html($cat->name); ?></span>
                                            <span class="category-count"><?php echo $cat->count; ?> مطلب</span>
                                        </div>
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Popular in Category -->
                    <div class="widget popular-in-category-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-fire"></i>
                            محبوب در این دسته
                        </h3>
                        <div class="popular-posts-list">
                            <?php
                            $popular_args = array(
                                'posts_per_page' => 5,
                                'meta_key' => 'post_views',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'post__not_in' => array(get_the_ID())
                            );
                            
                            if (is_category()) {
                                $popular_args['cat'] = get_queried_object_id();
                            } elseif (is_tag()) {
                                $popular_args['tag_id'] = get_queried_object_id();
                            }
                            
                            $popular_posts = get_posts($popular_args);
                            
                            foreach ($popular_posts as $index => $popular_post) :
                                $views = get_post_meta($popular_post->ID, 'post_views', true) ?: 0;
                            ?>
                                <div class="popular-post-item">
                                    <div class="popular-rank">
                                        <span><?php echo $index + 1; ?></span>
                                    </div>
                                    
                                    <?php if (has_post_thumbnail($popular_post->ID)) : ?>
                                        <div class="popular-thumbnail">
                                            <a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
                                                <?php echo get_the_post_thumbnail($popular_post->ID, 'thumbnail'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="popular-content">
                                        <h4 class="popular-title">
                                            <a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
                                                <?php echo esc_html(get_the_title($popular_post)); ?>
                                            </a>
                                        </h4>
                                        
                                        <div class="popular-meta">
                                            <span class="popular-date">
                                                <i class="fas fa-calendar"></i>
                                                <?php echo get_the_date('j M', $popular_post); ?>
                                            </span>
                                            <span class="popular-views">
                                                <i class="fas fa-eye"></i>
                                                <?php echo number_format($views); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            endforeach;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    
                    <!-- Archive Newsletter -->
                    <div class="widget archive-newsletter-widget">
                        <div class="newsletter-content">
                            <div class="newsletter-icon">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <h3>عضویت در خبرنامه</h3>
                            <p>از جدیدترین مطالب این دسته باخبر شوید</p>
                            
                            <form class="newsletter-form">
                                <input type="email" placeholder="ایمیل شما..." required>
                                <button type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                    عضویت
                                </button>
                            </form>
                            
                            <div class="newsletter-benefits">
                                <div class="benefit">
                                    <i class="fas fa-bell"></i>
                                    <span>اطلاع از مطالب جدید</span>
                                </div>
                                <div class="benefit">
                                    <i class="fas fa-gift"></i>
                                    <span>محتوای اختصاصی</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php get_sidebar(); ?>
                </aside>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Archive Page Comprehensive Styles */
.archive-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: inherit;
}

/* Archive Hero */
.archive-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6a3093 100%);
    color: white;
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.hero-bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.1;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.floating-shapes .shape {
    position: absolute;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: shapeFloat 12s ease-in-out infinite;
}

.shape-1 {
    width: 150px;
    height: 150px;
    top: 15%;
    right: 15%;
    animation-delay: 0s;
}

.shape-2 {
    width: 100px;
    height: 100px;
    top: 65%;
    right: 75%;
    animation-delay: 4s;
}

.shape-3 {
    width: 120px;
    height: 120px;
    top: 75%;
    right: 25%;
    animation-delay: 8s;
}

@keyframes shapeFloat {
    0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
    33% { transform: translateY(-40px) scale(1.1) rotate(120deg); }
    66% { transform: translateY(-20px) scale(0.9) rotate(240deg); }
}

.archive-hero-content {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 3rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.archive-type {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: inline-flex;
    font-family: inherit;
}

.archive-title {
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.2;
    font-family: inherit;
}

.archive-description {
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 2rem;
    opacity: 0.9;
    font-family: inherit;
}

.archive-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.archive-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-family: inherit;
}

.archive-stats .stat-item i {
    font-size: 1.1rem;
}

.archive-visual {
    position: relative;
}

.archive-illustration {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.illustration-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.bg-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: bgCircleFloat 6s ease-in-out infinite;
}

.bg-circle.circle-1 {
    width: 80px;
    height: 80px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.bg-circle.circle-2 {
    width: 60px;
    height: 60px;
    top: 60%;
    right: 70%;
    animation-delay: 2s;
}

.bg-circle.circle-3 {
    width: 100px;
    height: 100px;
    top: 80%;
    right: 20%;
    animation-delay: 4s;
}

@keyframes bgCircleFloat {
    0%, 100% { transform: translateY(0px) scale(1); opacity: 0.3; }
    50% { transform: translateY(-20px) scale(1.1); opacity: 0.6; }
}

.illustration-content {
    position: relative;
    z-index: 2;
}

.illustration-icon {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2.5rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
    animation: illustrationPulse 3s ease-in-out infinite;
}

@keyframes illustrationPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); box-shadow: 0 0 30px rgba(255, 255, 255, 0.3); }
}

.illustration-text span {
    font-size: 1.1rem;
    font-weight: 600;
    font-family: inherit;
}

/* Archive Content */
.archive-content {
    padding: 4rem 0;
}

.archive-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    max-width: 1400px;
    margin: 0 auto;
}

.archive-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    padding: 1.5rem;
    background: var(--bg-main);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    flex-wrap: wrap;
    gap: 1rem;
}

.view-controls {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    width: 40px;
    height: 40px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.sort-controls {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sort-controls label {
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.sort-controls select {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
}

.results-info {
    color: var(--text-secondary);
    font-weight: 500;
    font-family: inherit;
}

/* Posts Grid */
.posts-container {
    display: grid;
    gap: 2rem;
    margin-bottom: 3rem;
}

.posts-container.grid-view {
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
}

.posts-container.list-view {
    grid-template-columns: 1fr;
}

.posts-container.list-view .archive-post-card {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.posts-container.list-view .post-image-wrapper {
    width: 200px;
    height: 150px;
    flex-shrink: 0;
}

.posts-container.list-view .post-content-wrapper {
    flex: 1;
}

.archive-post-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
}

.archive-post-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
}

.post-image-wrapper {
    height: 220px;
    overflow: hidden;
    position: relative;
}

.post-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.archive-post-card:hover .post-image {
    transform: scale(1.1);
}

.post-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
}

.archive-post-card:hover .post-overlay {
    opacity: 1;
}

.post-meta-overlay {
    display: flex;
    justify-content: space-between;
    color: white;
    font-size: 0.85rem;
    font-family: inherit;
}

.post-meta-overlay span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 0.5rem 0.75rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.post-actions-overlay {
    text-align: center;
}

.quick-view-btn {
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
    font-family: inherit;
}

.quick-view-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
}

.featured-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #1a1a1a;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    z-index: 2;
    animation: featuredBadgePulse 2s infinite;
}

@keyframes featuredBadgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); box-shadow: 0 0 15px rgba(255, 215, 0, 0.5); }
}

.post-content-wrapper {
    padding: 1.5rem;
}

.post-categories {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.post-category {
    padding: 0.25rem 0.75rem;
    color: white;
    text-decoration: none;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.post-category:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    color: white;
}

.archive-post-card .post-title {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    line-height: 1.4;
    font-family: inherit;
}

.archive-post-card .post-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.archive-post-card .post-title a:hover {
    color: var(--primary-color);
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
    margin-bottom: 1rem;
}

.post-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
    flex-wrap: wrap;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.post-meta i {
    width: 14px;
    text-align: center;
}

.post-meta a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    font-family: inherit;
}

.post-rating {
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
    font-size: 0.8rem;
}

.rating-score {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 0.85rem;
    font-family: inherit;
}

.post-tags {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.post-tag {
    padding: 0.25rem 0.75rem;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.post-tag:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    color: white;
}

.post-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.read-more-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    border: 1px solid var(--primary-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.read-more-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(-3px);
}

.share-btn {
    width: 35px;
    height: 35px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.share-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.1);
}

/* Load More */
.load-more-section {
    text-align: center;
    margin: 3rem 0;
}

.load-more-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 1.25rem 2.5rem;
    border-radius: 30px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.load-more-btn:hover {
    background: linear-gradient(135deg, var(--primary-dark), #0f5d2a);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(31, 165, 71, 0.4);
}

.load-more-btn .btn-content,
.load-more-btn .btn-loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.load-more-btn .btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.load-more-btn.loading .btn-content {
    opacity: 0;
}

.load-more-btn.loading .btn-loading {
    opacity: 1;
}

/* Archive Pagination */
.archive-pagination {
    text-align: center;
    margin: 3rem 0;
}

.archive-pagination .nav-links {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.archive-pagination a,
.archive-pagination span {
    padding: 0.75rem 1rem;
    background: var(--bg-main);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.archive-pagination a:hover,
.archive-pagination .current {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

/* No Posts */
.no-posts-found {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-main);
    border-radius: 20px;
    border: 1px solid var(--border-color);
}

.no-posts-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

.no-posts-found h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1.8rem;
    font-family: inherit;
}

.no-posts-found p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.1rem;
    font-family: inherit;
}

.suggestions h4 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-family: inherit;
}

.suggestion-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.suggestion-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.suggestion-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
}

/* Archive Sidebar */
.archive-sidebar {
    position: sticky;
    top: calc(70px + 2rem);
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.archive-sidebar .widget {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
}

.archive-sidebar .widget-title {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.25rem 1.5rem;
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

/* Archive Search Widget */
.archive-search-form {
    padding: 1.5rem;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    background: var(--bg-secondary);
    border-radius: 10px;
    border: 2px solid var(--border-color);
    overflow: hidden;
}

.search-input {
    flex: 1;
    padding: 1rem;
    border: none;
    background: transparent;
    font-family: inherit;
    color: var(--text-primary);
}

.search-input:focus {
    outline: none;
}

.search-submit {
    padding: 1rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

.search-submit:hover {
    background: var(--primary-dark);
}

/* Related Categories */
.related-categories {
    padding: 1.5rem;
}

.related-category-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    margin-bottom: 0.75rem;
    text-decoration: none;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.related-category-item::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: var(--cat-color);
    transition: width 0.3s ease;
}

.related-category-item:hover::before {
    width: 4px;
}

.related-category-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--cat-color);
    transform: translateX(-5px);
    color: var(--text-primary);
}

.related-category-item:last-child {
    margin-bottom: 0;
}

.category-info .category-name {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.category-info .category-count {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: inherit;
}

.related-category-item i {
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    color: var(--cat-color);
}

.related-category-item:hover i {
    opacity: 1;
    transform: translateX(0);
}

/* Popular Posts */
.popular-posts-list {
    padding: 1.5rem;
}

.popular-post-item {
    display: flex;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
}

.popular-post-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.popular-post-item:last-child {
    margin-bottom: 0;
}

.popular-rank {
    width: 30px;
    height: 30px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
    font-family: inherit;
}

.popular-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.popular-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popular-content {
    flex: 1;
    min-width: 0;
}

.popular-title {
    margin: 0 0 0.5rem 0;
    font-size: 0.9rem;
    line-height: 1.3;
    font-family: inherit;
}

.popular-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.popular-title a:hover {
    color: var(--primary-color);
}

.popular-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.popular-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Archive Newsletter */
.archive-newsletter-widget {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    color: white;
    border: none !important;
}

.archive-newsletter-widget .widget-title {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.newsletter-content {
    padding: 2rem 1.5rem;
    text-align: center;
}

.newsletter-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.newsletter-content h3 {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    font-family: inherit;
}

.newsletter-content p {
    margin: 0 0 1.5rem 0;
    opacity: 0.9;
    font-family: inherit;
}

.newsletter-content .newsletter-form {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.newsletter-content .newsletter-form input {
    flex: 1;
    padding: 0.75rem;
    border: none;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    font-family: inherit;
}

.newsletter-content .newsletter-form button {
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
}

.newsletter-content .newsletter-form button:hover {
    background: rgba(255, 255, 255, 0.3);
}

.newsletter-benefits {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    align-items: center;
}

.newsletter-benefits .benefit {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    opacity: 0.9;
    font-family: inherit;
}

.newsletter-benefits .benefit i {
    font-size: 0.9rem;
}

/* Responsive Archive */
@media (max-width: 1200px) {
    .archive-hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
    
    .archive-layout {
        grid-template-columns: 1fr 350px;
        gap: 3rem;
    }
}

@media (max-width: 1024px) {
    .archive-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .archive-sidebar {
        position: static;
        order: -1;
    }
    
    .posts-container.grid-view {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .archive-hero {
        padding: 3rem 0;
    }
    
    .archive-title {
        font-size: 2rem;
    }
    
    .archive-stats {
        justify-content: center;
    }
    
    .archive-controls {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .view-controls,
    .sort-controls {
        justify-content: center;
    }
    
    .posts-container.grid-view {
        grid-template-columns: 1fr;
    }
    
    .posts-container.list-view .archive-post-card {
        flex-direction: column;
        text-align: center;
    }
    
    .posts-container.list-view .post-image-wrapper {
        width: 100%;
        height: 200px;
    }
    
    .post-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .suggestion-links {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .archive-hero {
        padding: 2rem 0;
    }
    
    .archive-title {
        font-size: 1.7rem;
    }
    
    .archive-controls {
        padding: 1rem;
    }
    
    .post-content-wrapper {
        padding: 1rem;
    }
    
    .archive-stats {
        flex-direction: column;
        align-items: center;
    }
    
    .popular-post-item {
        padding: 0.75rem;
    }
    
    .newsletter-content {
        padding: 1.5rem 1rem;
    }
    
    .newsletter-benefits {
        gap: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const viewBtns = document.querySelectorAll('.view-btn');
    const postsContainer = document.getElementById('posts-container');
    
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (postsContainer) {
                postsContainer.className = `posts-container ${view}-view`;
            }
        });
    });
    
    // Sort functionality
    const sortSelect = document.getElementById('sort-posts');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const posts = Array.from(document.querySelectorAll('.archive-post-card'));
            
            posts.sort((a, b) => {
                switch (sortValue) {
                    case 'date-desc':
                        return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                    case 'date-asc':
                        return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                    case 'title-asc':
                        return a.querySelector('.post-title a').textContent.localeCompare(b.querySelector('.post-title a').textContent);
                    case 'title-desc':
                        return b.querySelector('.post-title a').textContent.localeCompare(a.querySelector('.post-title a').textContent);
                    case 'views-desc':
                        return parseInt(b.getAttribute('data-views')) - parseInt(a.getAttribute('data-views'));
                    case 'comments-desc':
                        return parseInt(b.getAttribute('data-comments')) - parseInt(a.getAttribute('data-comments'));
                    default:
                        return 0;
                }
            });
            
            const container = document.getElementById('posts-container');
            posts.forEach(post => container.appendChild(post));
        });
    }
    
    // Load more functionality
    const loadMoreBtn = document.querySelector('.load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            this.classList.add('loading');
            this.disabled = true;
            
            // Simulate loading more posts
            setTimeout(() => {
                alert('قابلیت بارگذاری بیشتر به زودی اضافه خواهد شد');
                this.classList.remove('loading');
                this.disabled = false;
            }, 2000);
        });
    }
    
    // Share functionality
    const shareBtns = document.querySelectorAll('.share-btn');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const postUrl = this.getAttribute('data-post-url');
            const postTitle = this.getAttribute('data-post-title');
            
            if (navigator.share) {
                navigator.share({
                    title: postTitle,
                    url: postUrl
                });
            } else {
                // Fallback to clipboard
                navigator.clipboard.writeText(postUrl).then(() => {
                    alert('لینک کپی شد!');
                });
            }
        });
    });
    
    // Newsletter form
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            const button = this.querySelector('button');
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            setTimeout(() => {
                alert('با تشکر! شما در خبرنامه عضو شدید.');
                this.reset();
                button.innerHTML = '<i class="fas fa-paper-plane"></i> عضویت';
                button.disabled = false;
            }, 1500);
        });
    });
    
    // Animations on scroll
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
    
    // Animate archive posts
    document.querySelectorAll('.archive-post-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Animate sidebar widgets
    document.querySelectorAll('.archive-sidebar .widget').forEach((widget, index) => {
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(30px)';
        widget.style.transition = `opacity 0.6s ease ${index * 0.15}s, transform 0.6s ease ${index * 0.15}s`;
        observer.observe(widget);
    });
});
</script>

<?php get_footer(); ?>
