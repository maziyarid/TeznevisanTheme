<aside id="secondary" class="widget-area enhanced-sidebar" role="complementary">
    
    <!-- Search Widget -->
    <div class="widget search-widget-enhanced">
        <h3 class="widget-title">
            <i class="fas fa-search"></i>
            <?php echo esc_html(get_theme_mod('sidebar_search_title', 'جستجو در سایت')); ?>
        </h3>
        <div class="search-form-wrapper">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" 
                       class="search-field" 
                       placeholder="<?php echo esc_attr(get_theme_mod('search_placeholder', 'جستجو در سایت...')); ?>" 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" />
                <button type="submit" class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Newsletter Widget -->
    <div class="widget newsletter-widget-enhanced">
        <div class="newsletter-header">
            <div class="newsletter-icon-wrapper">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <h3 class="widget-title"><?php echo esc_html(get_theme_mod('sidebar_newsletter_title', 'عضویت در خبرنامه')); ?></h3>
            <p class="newsletter-description"><?php echo esc_html(get_theme_mod('sidebar_newsletter_desc', 'آخرین مقالات و تخفیف‌های ویژه را دریافت کنید')); ?></p>
        </div>
        
        <form class="sidebar-newsletter-form" id="sidebar-newsletter">
            <div class="newsletter-input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="ایمیل شما..." required>
                <button type="submit">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="newsletter-benefits">
                <div class="benefit">
                    <i class="fas fa-gift"></i>
                    <span><?php echo esc_html(get_theme_mod('newsletter_benefit_1', 'تخفیف‌های ویژه')); ?></span>
                </div>
                <div class="benefit">
                    <i class="fas fa-star"></i>
                    <span><?php echo esc_html(get_theme_mod('newsletter_benefit_2', 'محتوای اختصاصی')); ?></span>
                </div>
            </div>
        </form>
        
        <div class="newsletter-stats-mini">
            <span class="subscriber-count">
                <i class="fas fa-users"></i>
                <?php echo esc_html(get_theme_mod('newsletter_subscribers_count', '۱۰,۰۰۰+')); ?> مشترک
            </span>
        </div>
    </div>

    <!-- Popular Posts Widget -->
    <div class="widget popular-posts-widget-enhanced">
        <h3 class="widget-title">
            <i class="fas fa-fire"></i>
            <?php echo esc_html(get_theme_mod('popular_posts_title', 'محبوب‌ترین مطالب')); ?>
        </h3>
        <div class="popular-posts-list-enhanced">
            <?php
            $popular_posts = get_posts(array(
                'posts_per_page' => 5,
                'meta_key' => 'post_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'post_status' => 'publish'
            ));
            
            if ($popular_posts) :
                foreach ($popular_posts as $index => $popular_post) :
                    $views = get_post_meta($popular_post->ID, 'post_views', true) ?: 0;
            ?>
                <article class="popular-post-item-enhanced">
                    <div class="post-rank">
                        <span class="rank-number"><?php echo $index + 1; ?></span>
                    </div>
                    
                    <?php if (has_post_thumbnail($popular_post->ID)) : ?>
                        <div class="post-thumbnail-sidebar">
                            <a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
                                <?php echo get_the_post_thumbnail($popular_post->ID, 'thumbnail'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-content-sidebar">
                        <div class="post-meta-sidebar">
                            <time class="post-date-sidebar">
                                <i class="fas fa-calendar"></i>
                                <?php echo get_the_date('j M', $popular_post); ?>
                            </time>
                            <span class="post-views-sidebar">
                                <i class="fas fa-eye"></i>
                                <?php echo number_format($views); ?>
                            </span>
                        </div>
                        
                        <h4 class="post-title-sidebar">
                            <a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
                                <?php echo esc_html(get_the_title($popular_post)); ?>
                            </a>
                        </h4>
                        
                        <div class="post-excerpt-sidebar">
                            <?php echo wp_trim_words(get_the_excerpt($popular_post), 12, '...'); ?>
                        </div>
                    </div>
                </article>
            <?php 
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- Contact CTA Widget -->
    <div class="widget contact-cta-widget-enhanced">
        <div class="contact-cta-content">
            <div class="cta-header">
                <div class="cta-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3><?php echo esc_html(get_theme_mod('sidebar_cta_title', 'نیاز به مشاوره دارید؟')); ?></h3>
                <p><?php echo esc_html(get_theme_mod('sidebar_cta_desc', 'کارشناسان ما آماده پاسخگویی به سوالات شما هستند')); ?></p>
            </div>
            
            <div class="cta-stats">
                <div class="stat-mini">
                    <span class="stat-number-mini"><?php echo esc_html(get_theme_mod('sidebar_stat_1', '۲۴/۷')); ?></span>
                    <span class="stat-label-mini"><?php echo esc_html(get_theme_mod('sidebar_stat_1_label', 'پشتیبانی')); ?></span>
                </div>
                <div class="stat-mini">
                    <span class="stat-number-mini"><?php echo esc_html(get_theme_mod('sidebar_stat_2', '< ۵ دقیقه')); ?></span>
                    <span class="stat-label-mini"><?php echo esc_html(get_theme_mod('sidebar_stat_2_label', 'زمان پاسخ')); ?></span>
                </div>
            </div>
            
            <div class="cta-actions">
                <a href="tel:<?php echo esc_attr(get_theme_mod('phone_number', '09162352304')); ?>" 
                   class="cta-btn primary">
                    <i class="fas fa-phone"></i>
                    <?php echo esc_html(get_theme_mod('sidebar_cta_btn_1', 'تماس فوری')); ?>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                   class="cta-btn secondary">
                    <i class="fas fa-comments"></i>
                    <?php echo esc_html(get_theme_mod('sidebar_cta_btn_2', 'مشاوره آنلاین')); ?>
                </a>
            </div>
            
            <div class="satisfaction-badge">
                <div class="satisfaction-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span class="satisfaction-text"><?php echo esc_html(get_theme_mod('sidebar_satisfaction', '۹۸% رضایت مشتریان')); ?></span>
            </div>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="widget categories-widget-enhanced">
        <h3 class="widget-title">
            <i class="fas fa-folder-open"></i>
            <?php echo esc_html(get_theme_mod('sidebar_categories_title', 'دسته‌بندی‌ها')); ?>
        </h3>
        <div class="categories-list-enhanced">
            <?php
            $categories = get_categories(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 8,
                'hide_empty' => true
            ));
            
            foreach ($categories as $category) :
                $post_count = $category->count;
            ?>
                <div class="category-item-enhanced">
                    <a href="<?php echo esc_url(get_category_link($category)); ?>" class="category-link-enhanced">
                        <div class="category-info">
                            <span class="category-name"><?php echo esc_html($category->name); ?></span>
                            <span class="category-count"><?php echo $post_count; ?> مطلب</span>
                        </div>
                        <div class="category-arrow">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recent Comments Widget -->
    <div class="widget recent-comments-widget-enhanced">
        <h3 class="widget-title">
            <i class="fas fa-comments"></i>
            <?php echo esc_html(get_theme_mod('sidebar_comments_title', 'آخرین دیدگاه‌ها')); ?>
        </h3>
        <div class="recent-comments-list">
            <?php
            $recent_comments = get_comments(array(
                'number' => 5,
                'status' => 'approve',
                'type' => 'comment'
            ));
            
            foreach ($recent_comments as $comment) :
                $post_title = get_the_title($comment->comment_post_ID);
                $comment_excerpt = wp_trim_words($comment->comment_content, 15, '...');
            ?>
                <div class="comment-item-sidebar">
                    <div class="comment-avatar">
                        <?php echo get_avatar($comment, 40); ?>
                    </div>
                    
                    <div class="comment-content-sidebar">
                        <div class="comment-author">
                            <strong><?php echo esc_html($comment->comment_author); ?></strong>
                            <time class="comment-date">
                                <?php echo human_time_diff(strtotime($comment->comment_date), current_time('timestamp')) . ' پیش'; ?>
                            </time>
                        </div>
                        
                        <div class="comment-text">
                            <?php echo esc_html($comment_excerpt); ?>
                        </div>
                        
                        <div class="comment-post-link">
                            <a href="<?php echo esc_url(get_permalink($comment->comment_post_ID)); ?>#comment-<?php echo $comment->comment_ID; ?>">
                                <i class="fas fa-external-link-alt"></i>
                                <?php echo esc_html($post_title); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- WordPress Default Widgets Area -->
    <?php if (is_active_sidebar('main-sidebar')) : ?>
        <?php dynamic_sidebar('main-sidebar'); ?>
    <?php endif; ?>

</aside>

<style>
/* Enhanced Sidebar Styles with Theme Support */
.enhanced-sidebar {
    position: sticky;
    top: calc(70px + 2rem);
    height: fit-content;
    padding: 0;
    font-family: inherit;
}

.enhanced-sidebar .widget {
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    margin-bottom: 2rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.enhanced-sidebar .widget:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(31, 165, 71, 0.1);
}

.enhanced-sidebar .widget-title {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.25rem 1.5rem;
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.enhanced-sidebar .widget-title i {
    font-size: 1rem;
    opacity: 0.9;
}

/* Search Widget */
.search-widget-enhanced .search-form-wrapper {
    padding: 1.5rem;
}

.search-widget-enhanced .search-form {
    position: relative;
}

.search-widget-enhanced .search-field {
    width: 100%;
    padding: 1rem 3rem 1rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-secondary);
    font-family: inherit;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.search-widget-enhanced .search-field:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
    outline: none;
    background: var(--bg-main);
}

.search-widget-enhanced .search-submit {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-widget-enhanced .search-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-50%) scale(1.1);
}

/* Newsletter Widget */
.newsletter-widget-enhanced {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
    color: white;
    border: none !important;
}

.newsletter-widget-enhanced .widget-title {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.newsletter-header {
    text-align: center;
    padding: 2rem 1.5rem 1rem;
}

.newsletter-icon-wrapper {
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

.newsletter-description {
    font-size: 0.9rem;
    opacity: 0.9;
    line-height: 1.6;
    margin: 0;
    font-family: inherit;
}

.sidebar-newsletter-form {
    padding: 0 1.5rem 1.5rem;
}

.newsletter-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
}

.newsletter-input-wrapper i {
    position: absolute;
    right: 1rem;
    color: rgba(255, 255, 255, 0.7);
    z-index: 2;
}

.newsletter-input-wrapper input {
    flex: 1;
    padding: 1rem 3rem 1rem 3.5rem;
    background: transparent;
    border: none;
    color: white;
    font-family: inherit;
}

.newsletter-input-wrapper input:focus {
    outline: none;
}

.newsletter-input-wrapper input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.newsletter-input-wrapper button {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 1rem;
    border-radius: 0 8px 8px 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.newsletter-input-wrapper button:hover {
    background: rgba(255, 255, 255, 0.3);
}

.newsletter-benefits {
    display: flex;
    justify-content: space-around;
    gap: 1rem;
    margin-bottom: 1rem;
}

.newsletter-benefits .benefit {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 500;
    opacity: 0.9;
    font-family: inherit;
}

.newsletter-benefits .benefit i {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
}

.newsletter-stats-mini {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 0.85rem;
    opacity: 0.8;
    font-family: inherit;
}

/* Popular Posts Widget */
.popular-posts-widget-enhanced .popular-posts-list-enhanced {
    padding: 1.5rem;
}

.popular-post-item-enhanced {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.popular-post-item-enhanced:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.1);
}

.popular-post-item-enhanced:last-child {
    margin-bottom: 0;
}

.post-rank {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 24px;
    height: 24px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
    border: 2px solid var(--bg-main);
    box-shadow: 0 2px 8px rgba(31, 165, 71, 0.3);
}

.post-thumbnail-sidebar {
    flex-shrink: 0;
    width: 70px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
}

.post-thumbnail-sidebar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.popular-post-item-enhanced:hover .post-thumbnail-sidebar img {
    transform: scale(1.1);
}

.post-content-sidebar {
    flex: 1;
    min-width: 0;
}

.post-meta-sidebar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.post-date-sidebar,
.post-views-sidebar {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.post-title-sidebar {
    margin: 0 0 0.75rem 0;
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.4;
    font-family: inherit;
}

.post-title-sidebar a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title-sidebar a:hover {
    color: var(--primary-color);
}

.post-excerpt-sidebar {
    font-size: 0.8rem;
    color: var(--text-secondary);
    line-height: 1.5;
    font-family: inherit;
}

/* Contact CTA Widget */
.contact-cta-widget-enhanced {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white;
    border: none !important;
}

.contact-cta-widget-enhanced .widget-title {
    display: none;
}

.contact-cta-content {
    padding: 2rem 1.5rem;
    text-align: center;
}

.cta-header {
    margin-bottom: 1.5rem;
}

.cta-icon {
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

.cta-header h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    color: white;
    font-family: inherit;
}

.cta-header p {
    margin: 0;
    font-size: 0.9rem;
    opacity: 0.9;
    line-height: 1.5;
    font-family: inherit;
}

.cta-stats {
    display: flex;
    justify-content: space-around;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    backdrop-filter: blur(10px);
}

.stat-mini {
    text-align: center;
}

.stat-number-mini {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.stat-label-mini {
    font-size: 0.75rem;
    opacity: 0.8;
    font-family: inherit;
}

.cta-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.cta-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.cta-btn.primary {
    background: rgba(255, 255, 255, 0.2);
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.cta-btn.secondary {
    background: transparent;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.5);
}

.cta-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    color: white !important;
}

.satisfaction-badge {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.satisfaction-stars {
    margin-bottom: 0.5rem;
}

.satisfaction-stars i {
    color: #ffc107;
    font-size: 0.9rem;
    margin: 0 0.1rem;
}

.satisfaction-text {
    font-size: 0.8rem;
    opacity: 0.9;
    font-weight: 500;
    font-family: inherit;
}

/* Categories Widget */
.categories-widget-enhanced .categories-list-enhanced {
    padding: 1.5rem;
}

.category-item-enhanced {
    margin-bottom: 0.75rem;
}

.category-item-enhanced:last-child {
    margin-bottom: 0;
}

.category-link-enhanced {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.category-link-enhanced:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateX(-3px);
}

.category-info {
    flex: 1;
    min-width: 0;
}

.category-name {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.category-count {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-family: inherit;
}

.category-arrow {
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    color: var(--primary-color);
}

.category-link-enhanced:hover .category-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Recent Comments Widget */
.recent-comments-widget-enhanced .recent-comments-list {
    padding: 1.5rem;
}

.comment-item-sidebar {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.comment-item-sidebar:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.comment-item-sidebar:last-child {
    margin-bottom: 0;
}

.comment-avatar {
    flex-shrink: 0;
}

.comment-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid var(--border-color);
}

.comment-content-sidebar {
    flex: 1;
    min-width: 0;
}

.comment-author {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.comment-author strong {
    color: var(--text-primary);
    font-weight: 600;
    font-family: inherit;
}

.comment-date {
    color: var(--text-muted);
    font-size: 0.75rem;
    font-family: inherit;
}

.comment-text {
    font-size: 0.8rem;
    color: var(--text-secondary);
    line-height: 1.5;
    margin-bottom: 0.5rem;
    font-family: inherit;
}

.comment-post-link a {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    transition: color 0.3s ease;
    font-family: inherit;
}

.comment-post-link a:hover {
    color: var(--primary-dark);
}

/* Responsive Sidebar */
@media (max-width: 1024px) {
    .enhanced-sidebar {
        position: static;
        margin-top: 2rem;
    }
}

@media (max-width: 768px) {
    .enhanced-sidebar .widget {
        margin-bottom: 1.5rem;
    }
    
    .enhanced-sidebar .widget-title {
        padding: 1rem 1.25rem;
        font-size: 1rem;
    }
    
    .newsletter-header {
        padding: 1.5rem 1.25rem 1rem;
    }
    
    .newsletter-input-wrapper {
        flex-direction: column;
    }
    
    .newsletter-input-wrapper input {
        padding: 1rem;
        text-align: center;
        margin-bottom: 0.75rem;
    }
    
    .newsletter-input-wrapper button {
        border-radius: 8px;
        padding: 0.75rem;
    }
    
    .newsletter-benefits {
        flex-direction: column;
        gap: 0.5rem;
        align-items: center;
    }
    
    .cta-stats {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .popular-post-item-enhanced {
        flex-direction: column;
        text-align: center;
    }
    
    .post-thumbnail-sidebar {
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }
}

@media (max-width: 480px) {
    .enhanced-sidebar .widget {
        margin-bottom: 1rem;
    }
    
    .enhanced-sidebar .widget-title {
        padding: 1rem;
        font-size: 0.95rem;
    }
    
    .contact-cta-content {
        padding: 1.5rem 1rem;
    }
    
    .cta-actions {
        gap: 0.5rem;
    }
    
    .newsletter-benefits {
        gap: 0.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar newsletter form
    const sidebarNewsletter = document.getElementById('sidebar-newsletter');
    if (sidebarNewsletter) {
        sidebarNewsletter.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.email.value;
            const button = this.querySelector('button');
            const originalHTML = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            setTimeout(() => {
                alert('با تشکر! شما در خبرنامه عضو شدید.');
                this.reset();
                button.innerHTML = originalHTML;
                button.disabled = false;
            }, 1500);
        });
    }
});
</script>