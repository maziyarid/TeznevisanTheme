<?php
/**
 * Single Post Template for Teznevisan Theme
 * Displays individual blog posts with proper styling
 */

get_header(); ?>

<div class="single-post-wrapper">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <!-- Post Header -->
        <header class="post-header">
            <div class="container">
                <div class="post-meta">
                    <span class="post-category">
                        <i class="fas fa-folder"></i>
                        <?php 
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . 
                                 esc_html($categories[0]->name) . '</a>';
                        } else {
                            echo 'عمومی';
                        }
                        ?>
                    </span>
                    <span class="post-date">
                        <i class="fas fa-calendar-alt"></i>
                        <?php echo get_the_date('j F Y'); ?>
                    </span>
                    <span class="post-author">
                        <i class="fas fa-user"></i>
                        <?php the_author(); ?>
                    </span>
                    <?php if (comments_open() || get_comments_number()) : ?>
                        <span class="post-comments">
                            <i class="fas fa-comments"></i>
                            <a href="#comments"><?php comments_number('۰ نظر', '۱ نظر', '% نظر'); ?></a>
                        </span>
                    <?php endif; ?>
                </div>
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <?php if (has_excerpt()) : ?>
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-featured-image">
                <div class="container">
                    <figure class="featured-image-container">
                        <?php 
                        the_post_thumbnail('large', array(
                            'class' => 'img-responsive',
                            'alt' => get_the_title()
                        )); 
                        ?>
                        <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                            <figcaption class="image-caption">
                                <?php echo wp_get_attachment_caption(get_post_thumbnail_id()); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="post-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <article class="post-article">
                            <div class="post-body">
                                <?php the_content(); ?>
                                
                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links"><span class="page-links-title">صفحات:</span>',
                                    'after' => '</div>',
                                    'link_before' => '<span>',
                                    'link_after' => '</span>',
                                    'pagelink' => '<span class="screen-reader-text">صفحه </span>%',
                                    'separator' => '<span class="screen-reader-text">, </span>',
                                ));
                                ?>
                            </div>
                            
                            <!-- Post Tags -->
                            <?php if (has_tag()) : ?>
                                <div class="post-tags">
                                    <h3 class="tags-title">
                                        <i class="fas fa-tags"></i>
                                        برچسب‌ها:
                                    </h3>
                                    <div class="tag-list">
                                        <?php 
                                        $tags = get_the_tags();
                                        foreach ($tags as $tag) {
                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-link">' . 
                                                 '<i class="fas fa-tag"></i>' . $tag->name . '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Post Navigation -->
                            <nav class="post-navigation">
                                <div class="nav-links">
                                    <?php
                                    $prev_post = get_previous_post();
                                    $next_post = get_next_post();
                                    ?>
                                    
                                    <?php if ($prev_post) : ?>
                                        <div class="nav-previous">
                                            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link prev-post">
                                                <div class="nav-icon">
                                                    <i class="fas fa-chevron-right"></i>
                                                </div>
                                                <div class="nav-content">
                                                    <span class="nav-subtitle">مطلب قبلی</span>
                                                    <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($next_post) : ?>
                                        <div class="nav-next">
                                            <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link next-post">
                                                <div class="nav-content">
                                                    <span class="nav-subtitle">مطلب بعدی</span>
                                                    <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                                </div>
                                                <div class="nav-icon">
                                                    <i class="fas fa-chevron-left"></i>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </nav>
                            
                            <!-- Author Bio -->
                            <?php 
                            $author_description = get_the_author_meta('description');
                            if ($author_description) : 
                            ?>
                                <div class="author-bio">
                                    <div class="author-avatar">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                                    </div>
                                    <div class="author-info">
                                        <h3 class="author-name">
                                            <i class="fas fa-user-circle"></i>
                                            درباره <?php the_author(); ?>
                                        </h3>
                                        <p class="author-description"><?php echo $author_description; ?></p>
                                        <div class="author-links">
                                            <?php if (get_the_author_meta('url')) : ?>
                                                <a href="<?php the_author_meta('url'); ?>" class="author-website" target="_blank">
                                                    <i class="fas fa-globe"></i>
                                                    وبسایت نویسنده
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author-posts">
                                                <i class="fas fa-pen-alt"></i>
                                                مطالب نویسنده
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Related Posts -->
                            <?php
                            $categories = get_the_category();
                            if ($categories) {
                                $category_ids = array();
                                foreach ($categories as $category) {
                                    $category_ids[] = $category->term_id;
                                }
                                
                                $related_posts = get_posts(array(
                                    'category__in' => $category_ids,
                                    'post__not_in' => array(get_the_ID()),
                                    'posts_per_page' => 3,
                                    'ignore_sticky_posts' => 1
                                ));
                                
                                if ($related_posts) :
                            ?>
                                <div class="related-posts">
                                    <h3 class="related-title">
                                        <i class="fas fa-newspaper"></i>
                                        مطالب مرتبط
                                    </h3>
                                    <div class="related-posts-grid">
                                        <?php foreach ($related_posts as $related_post) : ?>
                                            <article class="related-post-item">
                                                <?php if (has_post_thumbnail($related_post->ID)) : ?>
                                                    <div class="related-post-image">
                                                        <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                            <?php echo get_the_post_thumbnail($related_post->ID, 'medium'); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="related-post-content">
                                                    <h4 class="related-post-title">
                                                        <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                            <?php echo get_the_title($related_post->ID); ?>
                                                        </a>
                                                    </h4>
                                                    <div class="related-post-meta">
                                                        <span class="related-post-date">
                                                            <i class="fas fa-calendar"></i>
                                                            <?php echo get_the_date('j F Y', $related_post->ID); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </article>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php 
                                endif;
                                wp_reset_postdata();
                            }
                            ?>
                        </article>
                    </div>
                    
                    <!-- Sidebar -->
                    <aside class="col-lg-4 col-md-12">
                        <div class="post-sidebar">
                            <!-- Share Buttons -->
                            <div class="share-widget">
                                <h3 class="widget-title">
                                    <i class="fas fa-share-alt"></i>
                                    اشتراک‌گذاری
                                </h3>
                                <div class="share-buttons">
                                    <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       class="share-btn telegram" target="_blank">
                                        <i class="fab fa-telegram"></i>
                                        تلگرام
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                                       class="share-btn facebook" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                        فیسبوک
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       class="share-btn twitter" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                        توییتر
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" 
                                       class="share-btn linkedin" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                        لینکدین
                                    </a>
                                    <button class="share-btn copy-link" onclick="copyToClipboard('<?php echo get_permalink(); ?>')">
                                        <i class="fas fa-link"></i>
                                        کپی لینک
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Table of Contents (if post is long) -->
                            <?php if (str_word_count(strip_tags(get_the_content())) > 500) : ?>
                                <div class="toc-widget">
                                    <h3 class="widget-title">
                                        <i class="fas fa-list-ul"></i>
                                        فهرست مطالب
                                    </h3>
                                    <div id="table-of-contents">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- WordPress Sidebar -->
                            <?php if (is_active_sidebar('blog-sidebar')) : ?>
                                <?php dynamic_sidebar('blog-sidebar'); ?>
                            <?php endif; ?>
                            
                            <!-- Recent Posts Widget -->
                            <div class="recent-posts-widget">
                                <h3 class="widget-title">
                                    <i class="fas fa-clock"></i>
                                    آخرین مطالب
                                </h3>
                                <?php
                                $recent_posts = get_posts(array(
                                    'posts_per_page' => 5,
                                    'post__not_in' => array(get_the_ID())
                                ));
                                ?>
                                <ul class="recent-posts-list">
                                    <?php foreach ($recent_posts as $recent_post) : ?>
                                        <li class="recent-post-item">
                                            <?php if (has_post_thumbnail($recent_post->ID)) : ?>
                                                <div class="recent-post-thumb">
                                                    <a href="<?php echo get_permalink($recent_post->ID); ?>">
                                                        <?php echo get_the_post_thumbnail($recent_post->ID, 'thumbnail'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="recent-post-info">
                                                <h4 class="recent-post-title">
                                                    <a href="<?php echo get_permalink($recent_post->ID); ?>">
                                                        <?php echo get_the_title($recent_post->ID); ?>
                                                    </a>
                                                </h4>
                                                <span class="recent-post-date">
                                                    <i class="fas fa-calendar"></i>
                                                    <?php echo get_the_date('j F Y', $recent_post->ID); ?>
                                                </span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </main>

        <!-- Comments Section -->
        <?php if (comments_open() || get_comments_number()) : ?>
            <section class="post-comments">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; else : ?>
        <div class="container">
            <div class="no-post-found">
                <h2>مطلبی یافت نشد</h2>
                <p>متاسفانه مطلب مورد نظر شما پیدا نشد.</p>
                <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    بازگشت به صفحه اصلی
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Inline Styles for Post -->
<style>
.single-post-wrapper {
    font-family: 'IRANSans', Arial, sans-serif;
    direction: rtl;
    text-align: right;
    background: #f8fafc;
    min-height: 100vh;
}

.post-header {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 50%, #3182ce 100%);
    color: white;
    padding: 60px 0 40px;
    position: relative;
    overflow: hidden;
}

.post-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    z-index: 1;
}

.post-header .container {
    position: relative;
    z-index: 2;
}

.post-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
    font-size: 14px;
    opacity: 0.9;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.1);
    padding: 6px 12px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.post-meta a {
    color: inherit;
    text-decoration: none;
}

.post-meta a:hover {
    text-decoration: underline;
}

.post-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    line-height: 1.3;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.post-excerpt {
    font-size: 1.1rem;
    line-height: 1.6;
    opacity: 0.95;
    max-width: 800px;
}

.post-featured-image {
    margin: 40px 0;
}

.featured-image-container {
    margin: 0;
    text-align: center;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.featured-image-container img {
    width: 100%;
    height: auto;
    display: block;
}

.image-caption {
    padding: 15px 20px;
    background: #f8fafc;
    color: #4a5568;
    font-style: italic;
    font-size: 14px;
    border-top: 1px solid #e2e8f0;
}

.post-content {
    padding: 0 0 60px;
}

.post-article {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
    margin-bottom: 40px;
}

.post-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #2d3748;
}

.post-body h2,
.post-body h3,
.post-body h4 {
    color: #1a365d;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.post-body h2 {
    font-size: 1.8rem;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 10px;
}

.post-body h3 {
    font-size: 1.5rem;
}

.post-body h4 {
    font-size: 1.3rem;
}

.post-body p {
    margin-bottom: 1.5rem;
}

.post-body blockquote {
    background: #f7fafc;
    border-right: 4px solid #4299e1;
    padding: 20px 30px;
    margin: 30px 0;
    font-style: italic;
    color: #2d3748;
}

.post-body ul,
.post-body ol {
    padding-right: 30px;
    margin-bottom: 1.5rem;
}

.post-body li {
    margin-bottom: 0.5rem;
}

.post-tags {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
}

.tags-title {
    color: #1a365d;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tag-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #e2e8f0;
    color: #4a5568;
    padding: 6px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s ease;
}

.tag-link:hover {
    background: #4299e1;
    color: white;
    transform: translateY(-1px);
}

.post-navigation {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
}

.nav-links {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.nav-previous,
.nav-next {
    flex: 1;
    max-width: 48%;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    text-decoration: none;
    color: #2d3748;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: white;
    border-color: #4299e1;
    color: #4299e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.nav-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: #4299e1;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.nav-content {
    flex: 1;
}

.nav-subtitle {
    display: block;
    font-size: 12px;
    color: #718096;
    margin-bottom: 5px;
    text-transform: uppercase;
    font-weight: 600;
}

.nav-title {
    display: block;
    font-weight: 600;
    line-height: 1.4;
}

.author-bio {
    display: flex;
    gap: 20px;
    margin-top: 40px;
    padding: 30px;
    background: #f7fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.author-avatar img {
    border-radius: 50%;
    border: 3px solid #4299e1;
}

.author-info {
    flex: 1;
}

.author-name {
    color: #1a365d;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.author-description {
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 15px;
}

.author-links {
    display: flex;
    gap: 15px;
}

.author-links a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #4299e1;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.author-links a:hover {
    text-decoration: underline;
}

.related-posts {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
}

.related-title {
    color: #1a365d;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.related-post-item {
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.related-post-item:hover {
    background: white;
    border-color: #4299e1;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.related-post-image img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.related-post-content {
    padding: 20px;
}

.related-post-title {
    margin-bottom: 10px;
}

.related-post-title a {
    color: #1a365d;
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
}

.related-post-title a:hover {
    color: #4299e1;
}

.related-post-meta {
    color: #718096;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Sidebar Styles */
.post-sidebar {
    position: sticky;
    top: 100px;
}

.share-widget,
.toc-widget,
.recent-posts-widget {
    background: white;
    padding: 25px;
    margin-bottom: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.widget-title {
    color: #1a365d;
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.share-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    width: 100%;
    justify-content: flex-start;
}

.share-btn.telegram { background: #0088cc; color: white; }
.share-btn.facebook { background: #1877f2; color: white; }
.share-btn.twitter { background: #1da1f2; color: white; }
.share-btn.linkedin { background: #0077b5; color: white; }
.share-btn.copy-link { background: #6b7280; color: white; }

.share-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.recent-posts-list {
    list-style: none;
    padding: 0;
}

.recent-post-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.recent-post-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.recent-post-thumb {
    flex-shrink: 0;
}

.recent-post-thumb img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.recent-post-info {
    flex: 1;
}

.recent-post-title {
    margin-bottom: 8px;
}

.recent-post-title a {
    color: #2d3748;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
}

.recent-post-title a:hover {
    color: #4299e1;
}

.recent-post-date {
    color: #718096;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.post-comments {
    background: white;
    padding: 60px 0;
    border-top: 1px solid #e2e8f0;
}

/* Responsive Design */
@media (max-width: 992px) {
    .post-sidebar {
        position: static;
        margin-top: 40px;
    }
    
    .author-bio {
        flex-direction: column;
        text-align: center;
    }
    
    .nav-links {
        flex-direction: column;
    }
    
    .nav-previous,
    .nav-next {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .post-header {
        padding: 40px 0 30px;
    }
    
    .post-title {
        font-size: 1.8rem;
    }
    
    .post-article {
        padding: 25px 20px;
    }
    
    .post-meta {
        justify-content: center;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .share-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .post-header {
        padding: 30px 0 20px;
    }
    
    .post-title {
        font-size: 1.5rem;
    }
    
    .post-article {
        padding: 20px 15px;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .share-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- JavaScript for functionality -->
<script>
function copyToClipboard(url) {
    navigator.clipboard.writeText(url).then(function() {
        alert('لینک کپی شد!');
    });
}

// Table of Contents generation
document.addEventListener('DOMContentLoaded', function() {
    const tocContainer = document.getElementById('table-of-contents');
    if (tocContainer) {
        const headings = document.querySelectorAll('.post-body h2, .post-body h3, .post-body h4');
        if (headings.length > 2) {
            let tocHTML = '<ul>';
            headings.forEach(function(heading, index) {
                const id = 'heading-' + index;
                heading.id = id;
                const level = heading.tagName.toLowerCase();
                const indent = level === 'h3' ? 'style="margin-right: 20px;"' : level === 'h4' ? 'style="margin-right: 40px;"' : '';
                tocHTML += '<li ' + indent + '><a href="#' + id + '">' + heading.textContent + '</a></li>';
            });
            tocHTML += '</ul>';
            tocContainer.innerHTML = tocHTML;
        } else {
            tocContainer.parentElement.style.display = 'none';
        }
    }
    
    // Smooth scroll for TOC links
    document.querySelectorAll('#table-of-contents a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
</script>

<?php get_footer(); ?>