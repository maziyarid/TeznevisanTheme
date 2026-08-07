<?php
/**
 * Template part for displaying posts
 *
 * @package Teznevisan
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-card'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('teznevisan-featured', array(
                    'alt' => get_the_title(),
                    'loading' => 'lazy'
                )); ?>
            </a>
            
            <?php if (get_post_meta(get_the_ID(), 'featured_post', true)) : ?>
                <span class="featured-badge">
                    <i class="fas fa-star"></i>
                    ویژه
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="post-content-card">
        
        <!-- Post Meta -->
        <div class="post-meta-top">
            <?php
            $categories = get_the_category();
            if ($categories) :
                foreach (array_slice($categories, 0, 2) as $category) :
                    $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
            ?>
                <a href="<?php echo esc_url(get_category_link($category)); ?>" 
                   class="post-category"
                   style="background-color: <?php echo esc_attr($cat_color); ?>">
                    <i class="fas fa-folder"></i>
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php 
                endforeach;
            endif; 
            ?>
            
            <time class="post-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <i class="fas fa-calendar"></i>
                <?php echo get_the_date('j F Y'); ?>
            </time>
        </div>
        
        <!-- Post Title -->
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <!-- Post Excerpt -->
        <div class="post-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <!-- Post Meta Bottom -->
        <div class="post-meta-bottom">
            <div class="meta-left">
                <span class="post-author">
                    <i class="fas fa-user"></i>
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php the_author(); ?>
                    </a>
                </span>
                
                <span class="post-views">
                    <i class="fas fa-eye"></i>
                    <?php echo number_format(teznevisan_get_post_views()); ?>
                </span>
                
                <span class="post-comments">
                    <i class="fas fa-comments"></i>
                    <?php echo get_comments_number(); ?>
                </span>
            </div>
            
            <div class="meta-right">
                <a href="<?php the_permalink(); ?>" class="read-more">
                    ادامه مطلب
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
        
    </div>
    
</article>

<style>
.blog-post-card {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.blog-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

.post-thumbnail {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
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
}

.post-content-card {
    padding: 1.5rem;
}

.post-meta-top {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.post-category {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.post-category:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    color: white;
}

.post-date {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--text-muted);
    font-size: 0.8rem;
}

.post-title {
    margin: 0 0 1rem 0;
    font-size: 1.3rem;
    line-height: 1.4;
}

.post-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: var(--primary-color);
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.post-meta-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.meta-left {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.meta-left span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.meta-left a {
    color: var(--primary-color);
    text-decoration: none;
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.read-more:hover {
    transform: translateX(-3px);
}

@media (max-width: 768px) {
    .post-meta-bottom {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>
