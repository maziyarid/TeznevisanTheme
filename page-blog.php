<?php
/**
 * Blog Page Template - Fixed
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        <?php 
        // Use the fixed breadcrumbs function
        if (function_exists('teznevisan_breadcrumbs')) {
            teznevisan_breadcrumbs();
        }
        ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php _e('وبلاگ', 'teznevisan'); ?></h1>
            <p class="page-description"><?php _e('آخرین مقالات و اخبار تزنویسان', 'teznevisan'); ?></p>
        </header>

        <div class="blog-layout">
            <div class="blog-main">
                <!-- Featured Posts Section -->
                <?php
                $featured_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'meta_query' => array(
                        array(
                            'key' => '_featured_post',
                            'value' => '1',
                            'compare' => '='
                        )
                    )
                ));
                
                if ($featured_query->have_posts()): ?>
                    <section class="featured-posts">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            <?php _e('مقالات ویژه', 'teznevisan'); ?>
                        </h2>
                        <div class="featured-posts-grid">
                            <?php while ($featured_query->have_posts()): $featured_query->the_post(); ?>
                                <article class="featured-post-card">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('teznevisan-featured'); ?>
                                            </a>
                                            <span class="featured-badge">
                                                <i class="fas fa-star"></i>
                                                <?php _e('ویژه', 'teznevisan'); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="far fa-calendar"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <span class="post-author">
                                                <i class="far fa-user"></i>
                                                <?php the_author(); ?>
                                            </span>
                                        </div>
                                        
                                        <h3 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <div class="post-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <div class="post-footer">
                                            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                                <?php _e('ادامه مطلب', 'teznevisan'); ?>
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                            
                                            <?php if (function_exists('teznevisan_display_post_rating')): ?>
                                                <div class="post-rating-display">
                                                    <?php echo teznevisan_display_post_rating(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Regular Posts Section -->
                <section class="blog-posts">
                    <h2 class="section-title">
                        <i class="fas fa-newspaper"></i>
                        <?php _e('آخرین مقالات', 'teznevisan'); ?>
                    </h2>
                    
                    <?php
                    $blog_query = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 12,
                        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => '_featured_post',
                                'compare' => 'NOT EXISTS'
                            )
                        )
                    ));
                    
                    if ($blog_query->have_posts()): ?>
                        <div class="blog-posts-grid">
                            <?php while ($blog_query->have_posts()): $blog_query->the_post(); ?>
                                <article class="blog-post-card">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('teznevisan-thumbnail', array('alt' => get_the_title())); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="far fa-calendar"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <span class="post-author">
                                                <i class="far fa-user"></i>
                                                <?php the_author(); ?>
                                            </span>
                                            <?php if (get_comments_number() > 0): ?>
                                                <span class="post-comments">
                                                    <i class="far fa-comments"></i>
                                                    <?php comments_number('0', '1', '%'); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <h3 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <div class="post-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <div class="post-categories">
                                            <?php
                                            $categories = get_the_category();
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="post-category">' . esc_html($category->name) . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        
                                        <div class="post-footer">
                                            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                                <?php _e('ادامه مطلب', 'teznevisan'); ?>
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                            
                                            <?php if (function_exists('teznevisan_display_post_rating')): ?>
                                                <div class="post-rating-display">
                                                    <?php echo teznevisan_display_post_rating(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Pagination -->
                        <?php
                        $pagination = paginate_links(array(
                            'total' => $blog_query->max_num_pages,
                            'current' => max(1, get_query_var('paged')),
                            'prev_text' => '<i class="fas fa-chevron-right"></i> ' . __('قبلی', 'teznevisan'),
                            'next_text' => __('بعدی', 'teznevisan') . ' <i class="fas fa-chevron-left"></i>',
                            'type' => 'list',
                            'mid_size' => 2,
                            'end_size' => 1
                        ));
                        
                        if ($pagination) {
                            echo '<nav class="blog-pagination" aria-label="' . __('صفحه‌بندی مقالات', 'teznevisan') . '">';
                            echo $pagination;
                            echo '</nav>';
                        }
                        ?>
                        
                        <?php wp_reset_postdata(); ?>
                        
                    <?php else: ?>
                        <div class="no-posts-found">
                            <div class="no-posts-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3><?php _e('مقالهای یافت نشد', 'teznevisan'); ?></h3>
                            <p><?php _e('هنوز مقالهای در وبلاگ منتشر نشده است.', 'teznevisan'); ?></p>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                <i class="fas fa-home"></i>
                                <?php _e('بازگشت به صفحه اصلی', 'teznevisan'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
            
            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <?php if (is_active_sidebar('sidebar-1')): ?>
                    <?php dynamic_sidebar('sidebar-1'); ?>
                <?php else: ?>
                    <!-- Default sidebar content -->
                    <div class="widget">
                        <h3 class="widget-title">
                            <i class="fas fa-search"></i>
                            <?php _e('جستجو', 'teznevisan'); ?>
                        </h3>
                        <?php get_search_form(); ?>
                    </div>
                    
                    <div class="widget">
                        <h3 class="widget-title">
                            <i class="fas fa-clock"></i>
                            <?php _e('مقالات اخیر', 'teznevisan'); ?>
                        </h3>
                        <ul>
                            <?php
                            $recent_posts = wp_get_recent_posts(array(
                                'numberposts' => 5,
                                'post_status' => 'publish'
                            ));
                            foreach ($recent_posts as $post_item) {
                                echo '<li><a href="' . get_permalink($post_item['ID']) . '">' . $post_item['post_title'] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <div class="widget">
                        <h3 class="widget-title">
                            <i class="fas fa-folder"></i>
                            <?php _e('دسته‌بندی‌ها', 'teznevisan'); ?>
                        </h3>
                        <ul>
                            <?php
                            $categories = get_categories();
                            foreach ($categories as $category) {
                                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . ' (' . $category->count . ')</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <div class="widget">
                        <h3 class="widget-title">
                            <i class="fas fa-archive"></i>
                            <?php _e('آرشیو', 'teznevisan'); ?>
                        </h3>
                        <ul>
                            <?php wp_get_archives('type=monthly&limit=12'); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</main>

<style>
/* Blog Page Specific Styles */
.blog-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-top: 2rem;
}

.featured-posts {
    margin-bottom: 3rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color, #1fa547);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary-color, #1fa547);
}

.featured-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.featured-post-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.featured-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.featured-post-card .post-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.featured-post-card .post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.featured-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.featured-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--primary-color, #1fa547);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.blog-post-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.blog-post-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.blog-post-card .post-thumbnail {
    height: 180px;
    overflow: hidden;
}

.blog-post-card .post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-content {
    padding: 1.5rem;
}

.post-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.85rem;
    color: #666;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.post-title {
    margin-bottom: 1rem;
    font-size: 1.2rem;
    line-height: 1.4;
}

.post-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: var(--primary-color, #1fa547);
}

.post-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.post-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.post-category {
    background: rgba(31, 165, 71, 0.1);
    color: var(--primary-color, #1fa547);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.post-category:hover {
    background: var(--primary-color, #1fa547);
    color: white;
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color, #1fa547);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.read-more-btn:hover {
    color: #1e7e34;
    transform: translateX(-3px);
}

.post-rating-display {
    color: #ffc107;
}

.no-posts-found {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.no-posts-icon {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.blog-sidebar {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.blog-pagination {
    margin-top: 3rem;
    text-align: center;
}

.blog-pagination .page-numbers {
    display: inline-flex;
    padding: 0;
    margin: 0;
    list-style: none;
    gap: 0.5rem;
}

.blog-pagination .page-numbers li {
    display: inline-block;
}

.blog-pagination .page-numbers a,
.blog-pagination .page-numbers span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 1rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
}

.blog-pagination .page-numbers a:hover,
.blog-pagination .page-numbers .current {
    background: var(--primary-color, #1fa547);
    color: white;
    border-color: var(--primary-color, #1fa547);
}

@media (max-width: 768px) {
    .blog-layout {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .featured-posts-grid,
    .blog-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .post-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>

<?php get_footer(); ?>