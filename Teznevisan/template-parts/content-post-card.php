<?php
/**
 * Template part for displaying post cards in grid
 *
 * @package Teznevisan
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card-grid'); ?> 
         data-post-id="<?php echo get_the_ID(); ?>"
         data-category="<?php echo get_the_category()[0]->term_id ?? ''; ?>">
    
    <div class="card-wrapper">
        
        <!-- Card Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="card-image-wrapper">
                <a href="<?php the_permalink(); ?>" class="card-image-link">
                    <?php the_post_thumbnail('teznevisan-featured', array(
                        'class' => 'card-image',
                        'alt' => get_the_title(),
                        'loading' => 'lazy'
                    )); ?>
                </a>
                
                <div class="card-overlay">
                    <div class="overlay-content">
                        <span class="quick-read">
                            <i class="fas fa-book-reader"></i>
                            خواندن سریع
                        </span>
                    </div>
                </div>
                
                <?php if (get_post_meta(get_the_ID(), 'trending_post', true)) : ?>
                    <div class="trending-badge">
                        <i class="fas fa-fire"></i>
                        داغ
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Card Content -->
        <div class="card-content-wrapper">
            
            <!-- Categories -->
            <div class="card-categories">
                <?php
                $categories = get_the_category();
                if ($categories) :
                    $category = $categories[0];
                    $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
                ?>
                    <a href="<?php echo esc_url(get_category_link($category)); ?>" 
                       class="card-category"
                       style="background-color: <?php echo esc_attr($cat_color); ?>">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Title -->
            <h3 class="card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            
            <!-- Excerpt -->
            <div class="card-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
            </div>
            
            <!-- Meta -->
            <div class="card-meta">
                <div class="meta-items">
                    <span class="meta-item date">
                        <i class="fas fa-calendar"></i>
                        <?php echo get_the_date('j M'); ?>
                    </span>
                    
                    <span class="meta-item views">
                        <i class="fas fa-eye"></i>
                        <?php echo number_format(teznevisan_get_post_views()); ?>
                    </span>
                    
                    <span class="meta-item reading-time">
                        <i class="fas fa-clock"></i>
                        <?php echo teznevisan_reading_time_persian(); ?>
                    </span>
                </div>
                
                <?php
                $rating = teznevisan_get_post_rating();
                if ($rating > 0) :
                ?>
                    <div class="card-rating">
                        <div class="rating-stars-mini">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <i class="<?php echo $i <= $rating ? 'fas' : 'far'; ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="rating-number"><?php echo number_format($rating, 1); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Actions -->
            <div class="card-actions">
                <a href="<?php the_permalink(); ?>" class="card-btn-primary">
                    <span>مشاهده</span>
                    <i class="fas fa-arrow-left"></i>
                </a>
                
                <button class="card-btn-secondary share-post" 
                        data-url="<?php the_permalink(); ?>"
                        data-title="<?php the_title_attribute(); ?>"
                        title="اشتراک‌گذاری">
                    <i class="fas fa-share-alt"></i>
                </button>
                
                <button class="card-btn-secondary bookmark-post" 
                        data-post-id="<?php echo get_the_ID(); ?>"
                        title="نشانک">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
            
        </div>
        
    </div>
    
</article>

<style>
.post-card-grid {
    height: 100%;
}

.card-wrapper {
    height: 100%;
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.card-wrapper:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
}

.card-image-wrapper {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card-wrapper:hover .card-image {
    transform: scale(1.1);
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-wrapper:hover .card-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
}

.quick-read {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border-radius: 25px;
    font-weight: 600;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.card-wrapper:hover .quick-read {
    transform: translateY(0);
}

.trending-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #FF4757, #FF6B6B);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    animation: trendingPulse 2s infinite;
}

@keyframes trendingPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); box-shadow: 0 0 20px rgba(255, 71, 87, 0.5); }
}

.card-content-wrapper {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-categories {
    margin-bottom: 1rem;
}

.card-category {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.card-category:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    color: white;
}

.card-title {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    line-height: 1.4;
    flex-grow: 1;
}

.card-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: var(--primary-color);
}

.card-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 1rem;
}

.meta-items {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.card-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating-stars-mini {
    display: flex;
    gap: 1px;
}

.rating-stars-mini i {
    color: #FFD700;
    font-size: 0.7rem;
}

.rating-number {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 0.8rem;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.card-btn-primary {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.card-btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
}

.card-btn-secondary {
    width: 40px;
    height: 40px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.card-btn-secondary:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.1);
}

.card-btn-secondary.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

@media (max-width: 768px) {
    .card-image-wrapper {
        height: 180px;
    }
    
    .card-content-wrapper {
        padding: 1rem;
    }
    
    .meta-items {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
}
</style>
