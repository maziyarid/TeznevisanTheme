<?php
/**
 * Sidebar Template
 * 
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="sidebar-widgets">
    
    <!-- Recent Posts Widget -->
    <div class="widget recent-posts-widget">
        <h3 class="widget-title">
            <i class="fas fa-clock"></i>
            آخرین مطالب
        </h3>
        <div class="widget-content">
            <?php
            $recent_posts = get_posts(array(
                'posts_per_page' => 5,
                'post_status' => 'publish'
            ));
            
            if ($recent_posts) :
            ?>
                <ul class="recent-posts-list">
                    <?php foreach ($recent_posts as $post) : ?>
                        <li class="recent-post-item">
                            <?php if (has_post_thumbnail($post->ID)) : ?>
                                <div class="recent-thumb">
                                    <a href="<?php echo get_permalink($post); ?>">
                                        <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="recent-content">
                                <h4>
                                    <a href="<?php echo get_permalink($post); ?>">
                                        <?php echo get_the_title($post); ?>
                                    </a>
                                </h4>
                                <span class="recent-date">
                                    <i class="fas fa-calendar"></i>
                                    <?php echo get_the_date('j F Y', $post); ?>
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </div>
    
    <!-- Categories Widget -->
    <div class="widget categories-widget">
        <h3 class="widget-title">
            <i class="fas fa-folder"></i>
            دسته‌بندی‌ها
        </h3>
        <div class="widget-content">
            <ul class="categories-list">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 10
                ));
                
                foreach ($categories as $category) :
                    $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
                ?>
                    <li>
                        <a href="<?php echo get_category_link($category); ?>" 
                           style="--cat-color: <?php echo $cat_color; ?>">
                            <span class="cat-name"><?php echo $category->name; ?></span>
                            <span class="cat-count"><?php echo $category->count; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <!-- Tags Cloud Widget -->
    <div class="widget tags-widget">
        <h3 class="widget-title">
            <i class="fas fa-tags"></i>
            برچسب‌ها
        </h3>
        <div class="widget-content">
            <div class="tags-cloud">
                <?php
                $tags = get_tags(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 20
                ));
                
                foreach ($tags as $tag) :
                    $tag_color = get_term_meta($tag->term_id, 'tag_color', true) ?: '#007cba';
                ?>
                    <a href="<?php echo get_tag_link($tag); ?>" 
                       class="tag-item"
                       style="background-color: <?php echo $tag_color; ?>">
                        #<?php echo $tag->name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- WordPress Dynamic Sidebars -->
    <?php if (is_active_sidebar('sidebar-main')) : ?>
        <?php dynamic_sidebar('sidebar-main'); ?>
    <?php endif; ?>
    
</div>

<style>
.sidebar-widgets {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.widget {
    background: var(--bg-main);
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.widget-title {
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

.widget-content {
    padding: 1.5rem;
}

.recent-posts-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-post-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.recent-post-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.recent-post-item:last-child {
    margin-bottom: 0;
}

.recent-thumb {
    width: 70px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.recent-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recent-content {
    flex: 1;
    min-width: 0;
}

.recent-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 0.95rem;
    line-height: 1.3;
    font-family: inherit;
}

.recent-content h4 a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.recent-content h4 a:hover {
    color: var(--primary-color);
}

.recent-date {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-family: inherit;
}

.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list li {
    margin-bottom: 0.75rem;
}

.categories-list li:last-child {
    margin-bottom: 0;
}

.categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-family: inherit;
}

.categories-list a::before {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: var(--cat-color);
    transition: width 0.3s ease;
}

.categories-list a:hover::before {
    width: 4px;
}

.categories-list a:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--cat-color);
    transform: translateX(-3px);
}

.cat-name {
    font-weight: 500;
}

.cat-count {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: inherit;
}

.tags-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag-item {
    padding: 0.5rem 1rem;
    color: white;
    text-decoration: none;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.tag-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    color: white;
}

@media (max-width: 768px) {
    .sidebar-widgets {
        gap: 1.5rem;
    }
    
    .widget-content {
        padding: 1rem;
    }
}
</style>
