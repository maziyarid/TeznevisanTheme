<?php get_header(); ?>

<main id="main-content" class="category-archive-main">
    
    <!-- Category Hero with Rich Content -->
    <section class="category-hero">
        <div class="hero-background">
            <div class="hero-particles">
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <div class="particle particle-<?php echo $i; ?>"></div>
                <?php endfor; ?>
            </div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <!-- Enhanced Breadcrumbs -->
                <nav class="breadcrumb-nav" aria-label="breadcrumb">
                    <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="<?php echo home_url(); ?>" itemprop="item">
                                <span itemprop="name">
                                    <i class="fas fa-home"></i>
                                    خانه
                                </span>
                            </a>
                            <meta itemprop="position" content="1" />
                        </li>
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" itemprop="item">
                                <span itemprop="name">وبلاگ</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name"><?php single_cat_title(); ?></span>
                            <meta itemprop="position" content="3" />
                        </li>
                    </ol>
                </nav>
                
                <!-- Category Info -->
                <div class="category-info">
                    <?php
                    $category = get_queried_object();
                    $category_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
                    $category_image = get_term_meta($category->term_id, 'category_image', true);
                    ?>
                    
                    <div class="category-badge" style="--cat-color: <?php echo $category_color; ?>">
                        <i class="fas fa-folder-open"></i>
                        <span>دسته‌بندی مقالات</span>
                    </div>
                    
                    <h1 class="category-title" itemprop="name">
                        <?php single_cat_title(); ?>
                    </h1>
                    
                    <?php if (category_description()): ?>
                        <div class="category-description" itemprop="description">
                            <?php echo category_description(); ?>
                        </div>
                    <?php else: ?>
                        <div class="category-description">
                            <p>مجموعه کاملی از مقالات و مطالب تخصصی در زمینه <?php single_cat_title(); ?> که توسط تیم متخصص تزنویسان تهیه شده است.</p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Dynamic Category Stats -->
                    <div class="category-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <div class="stat-content">
                                <span class="stat-number" itemprop="numberOfItems"><?php echo $wp_query->found_posts; ?></span>
                                <span class="stat-label">مقاله</span>
                            </div>
                        </div>
                        
                        <?php
                        // Get average reading time for category
                        $posts_in_cat = get_posts(array('category' => $category->term_id, 'numberposts' => -1));
                        $total_reading_time = 0;
                        foreach ($posts_in_cat as $post) {
                            $total_reading_time += (int)get_post_meta($post->ID, 'reading_time', true) ?: 5;
                        }
                        $avg_reading_time = count($posts_in_cat) > 0 ? round($total_reading_time / count($posts_in_cat)) : 5;
                        ?>
                        
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $avg_reading_time; ?></span>
                                <span class="stat-label">دقیقه مطالعه متوسط</span>
                            </div>
                        </div>
                        
                        <?php
                        // Get total views for category
                        $total_views = 0;
                        foreach ($posts_in_cat as $post) {
                            $total_views += (int)get_post_meta($post->ID, 'post_views', true);
                        }
                        ?>
                        
                        <div class="stat-item">
                            <i class="fas fa-eye"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo number_format($total_views); ?></span>
                                <span class="stat-label">مجموع بازدید</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-calendar"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo get_the_date('Y', get_posts(array('category' => $category->term_id, 'numberposts' => 1))[0]->ID); ?></span>
                                <span class="stat-label">سال شروع</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category Visual -->
                <div class="hero-visual">
                    <?php if ($category_image): ?>
                        <div class="category-image">
                            <img src="<?php echo esc_url($category_image); ?>" 
                                 alt="تصویر دسته‌بندی <?php single_cat_title(); ?>" 
                                 loading="lazy" />
                        </div>
                    <?php else: ?>
                        <div class="category-illustration">
                            <div class="illustration-bg">
                                <div class="bg-circle circle-1"></div>
                                <div class="bg-circle circle-2"></div>
                                <div class="bg-circle circle-3"></div>
                            </div>
                            <div class="illustration-icon" style="color: <?php echo $category_color; ?>">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Category Content Section -->
    <section class="category-content-section">
        <div class="container">
            <div class="content-layout">
                
                <!-- Main Content Area -->
                <div class="main-content">
                    
                    <!-- Enhanced Category Info Box -->
                    <div class="category-info-box" style="--cat-color: <?php echo $category_color; ?>">
                        <div class="info-header">
                            <div class="info-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h2>درباره دسته‌بندی «<?php single_cat_title(); ?>»</h2>
                        </div>
                        
                        <div class="info-content">
                            <?php
                            $category_extended_desc = get_term_meta($category->term_id, 'category_extended_description', true);
                            if ($category_extended_desc):
                            ?>
                                <div class="extended-description">
                                    <?php echo wpautop($category_extended_desc); ?>
                                </div>
                            <?php else: ?>
                                <div class="auto-description">
                                    <p>دسته‌بندی <strong><?php single_cat_title(); ?></strong> شامل مجموعه‌ای جامع از مقالات تخصصی، راهنماها و محتوای آموزشی است که توسط تیم متخصص تزنویسان تهیه شده است.</p>
                                    <p>در این بخش می‌توانید به بهترین مطالب در زمینه <?php single_cat_title(); ?> دسترسی پیدا کنید و از تجربه و دانش کارشناسان ما بهره‌مند شوید.</p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Related Categories -->
                            <?php
                            $related_cats = get_categories(array(
                                'exclude' => $category->term_id,
                                'number' => 5,
                                'orderby' => 'count',
                                'order' => 'DESC'
                            ));
                            
                            if ($related_cats):
                            ?>
                                <div class="related-categories">
                                    <h4><i class="fas fa-link"></i> دسته‌های مرتبط:</h4>
                                    <div class="related-cats-list">
                                        <?php foreach ($related_cats as $related_cat): ?>
                                            <a href="<?php echo get_category_link($related_cat); ?>" 
                                               class="related-cat-tag">
                                                <?php echo esc_html($related_cat->name); ?>
                                                <span class="cat-count">(<?php echo $related_cat->count; ?>)</span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Posts Controls -->
                    <div class="posts-controls">
                        <div class="controls-left">
                            <div class="view-controls">
                                <button class="view-btn active" data-view="grid" title="نمایش شبکه‌ای">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-btn" data-view="list" title="نمایش فهرستی">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            
                            <div class="filter-controls">
                                <select id="posts-filter" class="posts-filter-select">
                                    <option value="all">همه مقالات</option>
                                    <option value="featured">مقالات ویژه</option>
                                    <option value="recent">اخیر (۳۰ روز)</option>
                                    <option value="popular">پربازدیدترین</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="controls-right">
                            <div class="sort-controls">
                                <label for="posts-sort">مرتب‌سازی:</label>
                                <select id="posts-sort" class="posts-sort-select">
                                    <option value="date-desc">جدیدترین</option>
                                    <option value="date-asc">قدیمی‌ترین</option>
                                    <option value="views-desc">پربازدیدترین</option>
                                    <option value="comments-desc">پردیدگاه‌ترین</option>
                                    <option value="title-asc">الفبایی</option>
                                </select>
                            </div>
                            
                            <div class="results-info">
                                <span class="results-count">
                                    <i class="fas fa-list-alt"></i>
                                    <?php echo $wp_query->found_posts; ?> مقاله
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Posts Grid -->
                    <?php if (have_posts()): ?>
                        <div class="posts-container grid-view" id="posts-container">
                            <?php while (have_posts()): the_post(); ?>
                                <article class="post-card" 
                                         data-date="<?php echo get_the_date('Y-m-d'); ?>"
                                         data-views="<?php echo get_post_meta(get_the_ID(), 'post_views', true) ?: 0; ?>"
                                         data-comments="<?php echo get_comments_number(); ?>"
                                         data-featured="<?php echo get_post_meta(get_the_ID(), 'featured_post', true) ? 'true' : 'false'; ?>"
                                         itemscope itemtype="https://schema.org/Article">
                                    
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="post-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('large', array(
                                                    'class' => 'post-img',
                                                    'loading' => 'lazy',
                                                    'itemprop' => 'image'
                                                )); ?>
                                            </a>
                                            
                                            <div class="post-overlay">
                                                <div class="post-meta-overlay">
                                                    <span class="post-date">
                                                        <i class="fas fa-calendar"></i>
                                                        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                                                            <?php echo get_the_date(); ?>
                                                        </time>
                                                    </span>
                                                    <span class="post-views">
                                                        <i class="fas fa-eye"></i>
                                                        <?php echo number_format(get_post_meta(get_the_ID(), 'post_views', true) ?: 0); ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="read-more-overlay">
                                                    <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                                        <i class="fas fa-book-open"></i>
                                                        مطالعه مقاله
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <?php if (get_post_meta(get_the_ID(), 'featured_post', true)): ?>
                                                <div class="featured-badge">
                                                    <i class="fas fa-star"></i>
                                                    ویژه
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content">
                                        <!-- Post Categories -->
                                        <div class="post-categories">
                                            <?php
                                            $post_categories = get_the_category();
                                            if ($post_categories) {
                                                foreach (array_slice($post_categories, 0, 2) as $cat) {
                                                    $cat_color = get_term_meta($cat->term_id, 'category_color', true) ?: '#1FA547';
                                                    $is_current = ($cat->term_id == $category->term_id);
                                                    echo '<a href="' . esc_url(get_category_link($cat)) . '" 
                                                          class="post-category' . ($is_current ? ' current' : '') . '" 
                                                          style="background-color: ' . esc_attr($cat_color) . '"
                                                          itemprop="about">' . 
                                                          esc_html($cat->name) . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        
                                        <h3 class="post-title" itemprop="headline">
                                            <a href="<?php the_permalink(); ?>" itemprop="url">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <?php
                                        $subtitle = get_post_meta(get_the_ID(), 'post_subtitle', true);
                                        if ($subtitle):
                                        ?>
                                            <p class="post-subtitle" itemprop="alternativeHeadline">
                                                <?php echo esc_html($subtitle); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <div class="post-excerpt" itemprop="description">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <div class="post-meta">
                                            <div class="meta-left">
                                                <span class="post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                                    <i class="fas fa-user"></i>
                                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" itemprop="url">
                                                        <span itemprop="name"><?php the_author(); ?></span>
                                                    </a>
                                                </span>
                                                <span class="post-comments">
                                                    <i class="fas fa-comments"></i>
                                                    <span itemprop="commentCount"><?php echo get_comments_number(); ?></span>
                                                </span>
                                            </div>
                                            
                                            <div class="meta-right">
                                                <span class="reading-time">
                                                    <i class="fas fa-clock"></i>
                                                    <?php 
                                                    $reading_time = get_post_meta(get_the_ID(), 'reading_time', true) ?: 5;
                                                    echo $reading_time . ' دقیقه مطالعه';
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Post Tags -->
                                        <?php
                                        $post_tags = get_the_tags();
                                        if ($post_tags):
                                        ?>
                                            <div class="post-tags">
                                                <?php foreach (array_slice($post_tags, 0, 3) as $tag): ?>
                                                    <a href="<?php echo get_tag_link($tag); ?>" 
                                                       class="post-tag" 
                                                       itemprop="keywords">
                                                        #<?php echo esc_html($tag->name); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="post-actions">
                                            <a href="<?php the_permalink(); ?>" class="btn-read-more">
                                                <span>ادامه مطالعه</span>
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                            
                                            <div class="post-share">
                                                <button class="share-btn" 
                                                        data-url="<?php the_permalink(); ?>" 
                                                        data-title="<?php the_title_attribute(); ?>"
                                                        title="اشتراک‌گذاری">
                                                    <i class="fas fa-share-alt"></i>
                                                </button>
                                                <button class="bookmark-btn" 
                                                        data-post-id="<?php echo get_the_ID(); ?>"
                                                        title="نشان‌کردن">
                                                    <i class="far fa-bookmark"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Structured Data -->
                                    <meta itemprop="dateModified" content="<?php echo get_the_modified_date('c'); ?>">
                                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" style="display: none;">
                                        <span itemprop="name">تزنویسان</span>
                                        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                            <meta itemprop="url" content="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png">
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Enhanced Pagination -->
                        <div class="category-pagination">
                            <?php
                            $pagination = paginate_links(array(
                                'current' => max(1, get_query_var('paged')),
                                'total' => $wp_query->max_num_pages,
                                'prev_text' => '<i class="fas fa-chevron-right"></i> قبلی',
                                'next_text' => 'بعدی <i class="fas fa-chevron-left"></i>',
                                'type' => 'array',
                                'mid_size' => 2
                            ));
                            
                            if ($pagination):
                            ?>
                                <nav class="pagination-nav" aria-label="صفحه‌بندی مقالات">
                                    <div class="pagination-info">
                                        <span>صفحه <?php echo max(1, get_query_var('paged')); ?> از <?php echo $wp_query->max_num_pages; ?></span>
                                    </div>
                                    <div class="pagination-links">
                                        <?php foreach ($pagination as $page): ?>
                                            <?php echo $page; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </nav>
                            <?php endif; ?>
                        </div>
                        
                    <?php else: ?>
                        <div class="no-posts-found">
                            <div class="no-posts-illustration">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h3>مقاله‌ای در این دسته یافت نشد</h3>
                            <p>متأسفانه در حال حاضر مقاله‌ای در دسته‌بندی «<?php single_cat_title(); ?>» موجود نیست.</p>
                            <div class="no-posts-actions">
                                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                    بازگشت به وبلاگ
                                </a>
                                <a href="<?php echo home_url('/contact'); ?>" class="btn-secondary">
                                    <i class="fas fa-envelope"></i>
                                    درخواست مقاله
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Enhanced Sidebar -->
                <aside class="category-sidebar">
                    
                    <!-- Category Quick Info -->
                    <div class="widget category-quick-info" style="--cat-color: <?php echo $category_color; ?>">
                        <div class="widget-content">
                            <div class="quick-info-header">
                                <div class="category-icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <h3><?php single_cat_title(); ?></h3>
                            </div>
                            
                            <div class="quick-stats">
                                <div class="quick-stat">
                                    <span class="stat-number"><?php echo $wp_query->found_posts; ?></span>
                                    <span class="stat-label">مقاله</span>
                                </div>
                                <div class="quick-stat">
                                    <span class="stat-number"><?php echo number_format($total_views); ?></span>
                                    <span class="stat-label">بازدید</span>
                                </div>
                            </div>
                            
                            <!-- RSS Feed Link -->
                            <div class="category-rss">
                                <a href="<?php echo get_category_feed_link($category->term_id); ?>" 
                                   class="rss-link" 
                                   title="خورد RSS این دسته">
                                    <i class="fas fa-rss"></i>
                                    دنبال کردن با RSS
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Category Search -->
                    <div class="widget category-search-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-search"></i>
                            جستجو در این دسته
                        </h3>
                        <div class="widget-content">
                            <form class="category-search-form" method="get" action="<?php echo home_url('/'); ?>">
                                <input type="hidden" name="cat" value="<?php echo get_queried_object_id(); ?>">
                                <div class="search-input-wrapper">
                                    <input type="search" 
                                           name="s" 
                                           placeholder="جستجو در مقالات <?php single_cat_title(); ?>..." 
                                           class="search-input"
                                           value="<?php echo get_search_query(); ?>">
                                    <button type="submit" class="search-submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                
                                <!-- Advanced Search Options -->
                                <div class="advanced-search">
                                    <details>
                                        <summary>جستجوی پیشرفته</summary>
                                        <div class="advanced-options">
                                            <label>
                                                <input type="checkbox" name="search_title" value="1">
                                                فقط در عنوان جستجو کن
                                            </label>
                                            <label>
                                                <input type="checkbox" name="search_recent" value="1">
                                                فقط مقالات اخیر
                                            </label>
                                        </div>
                                    </details>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Popular Posts in Category -->
                    <div class="widget popular-posts-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-fire"></i>
                            محبوب‌ترین مقالات
                        </h3>
                        <div class="widget-content">
                            <?php
                            $popular_posts = get_posts(array(
                                'posts_per_page' => 5,
                                'meta_key' => 'post_views',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'cat' => get_queried_object_id(),
                                'post_status' => 'publish'
                            ));
                            
                            if ($popular_posts):
                            ?>
                                <div class="popular-posts-list">
                                    <?php foreach ($popular_posts as $index => $popular_post): ?>
                                        <div class="popular-post-item">
                                            <div class="popular-rank">
                                                <span><?php echo $index + 1; ?></span>
                                            </div>
                                            
                                            <?php if (has_post_thumbnail($popular_post->ID)): ?>
                                                <div class="popular-thumbnail">
                                                    <a href="<?php echo get_permalink($popular_post); ?>">
                                                        <?php echo get_the_post_thumbnail($popular_post->ID, 'thumbnail', array(
                                                            'loading' => 'lazy'
                                                        )); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="popular-content">
                                                <h4 class="popular-title">
                                                    <a href="<?php echo get_permalink($popular_post); ?>">
                                                        <?php echo esc_html(get_the_title($popular_post)); ?>
                                                    </a>
                                                </h4>
                                                
                                                <div class="popular-meta">
                                                    <span class="popular-date">
                                                        <i class="fas fa-calendar"></i>
                                                        <?php echo get_the_date('j M Y', $popular_post); ?>
                                                    </span>
                                                    <span class="popular-views">
                                                        <i class="fas fa-eye"></i>
                                                        <?php echo number_format(get_post_meta($popular_post->ID, 'post_views', true) ?: 0); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="no-popular-posts">هنوز مقاله محبوبی در این دسته وجود ندارد.</p>
                            <?php endif; ?>
                            
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                    
                    <!-- Related Categories -->
                    <div class="widget related-categories-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-sitemap"></i>
                            دسته‌های مرتبط
                        </h3>
                        <div class="widget-content">
                            <?php if ($related_cats): ?>
                                <div class="related-categories-list">
                                    <?php foreach ($related_cats as $related_cat): ?>
                                        <?php $rel_cat_color = get_term_meta($related_cat->term_id, 'category_color', true) ?: '#666'; ?>
                                        <a href="<?php echo get_category_link($related_cat); ?>" 
                                           class="related-category-item"
                                           style="--rel-cat-color: <?php echo $rel_cat_color; ?>">
                                            <div class="category-info">
                                                <span class="category-name"><?php echo esc_html($related_cat->name); ?></span>
                                                <span class="category-count"><?php echo $related_cat->count; ?> مقاله</span>
                                            </div>
                                            <div class="category-arrow">
                                                <i class="fas fa-arrow-left"></i>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Newsletter Subscription -->
                    <div class="widget newsletter-widget">
                        <div class="widget-content">
                            <div class="newsletter-header">
                                <div class="newsletter-icon">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <h3>خبرنامه <?php single_cat_title(); ?></h3>
                                <p>از جدیدترین مقالات این دسته باخبر شوید</p>
                            </div>
                            
                            <form class="newsletter-form" data-category="<?php echo $category->term_id; ?>">
                                <input type="email" 
                                       placeholder="ایمیل شما..." 
                                       required 
                                       class="newsletter-input">
                                <button type="submit" class="newsletter-submit">
                                    <span class="btn-text">
                                        <i class="fas fa-paper-plane"></i>
                                        عضویت
                                    </span>
                                    <span class="btn-loading" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </button>
                            </form>
                            
                            <div class="newsletter-benefits">
                                <div class="benefit">
                                    <i class="fas fa-bell"></i>
                                    <span>اطلاع فوری از مقالات جدید</span>
                                </div>
                                <div class="benefit">
                                    <i class="fas fa-gift"></i>
                                    <span>محتوای اختصاصی و رایگان</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Category Archives -->
                    <div class="widget category-archives-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-archive"></i>
                            آرشیو <?php single_cat_title(); ?>
                        </h3>
                        <div class="widget-content">
                            <?php
                            $archives = wp_get_archives(array(
                                'type' => 'monthly',
                                'limit' => 12,
                                'format' => 'custom',
                                'echo' => false,
                                'post_type' => 'post'
                            ));
                            
                            if ($archives):
                                echo '<div class="archives-list">' . $archives . '</div>';
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <?php if (function_exists('dynamic_sidebar')) { 
                        dynamic_sidebar('category-sidebar'); 
                    } ?>
                </aside>
            </div>
        </div>
    </section>
    
</main>

<!-- Enhanced CSS -->
<style>
/* Category Archive Enhanced Styles */
.category-archive-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
    font-family: inherit;
}

/* Admin bar adjustments */
body.admin-bar .category-archive-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .category-archive-main {
        padding-top: 116px;
    }
}

/* Enhanced Category Hero */
.category-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6a3093 100%);
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
    animation: particleFloat 12s ease-in-out infinite;
}

.particle-1 { width: 20px; height: 20px; top: 20%; left: 10%; animation-delay: 0s; }
.particle-2 { width: 15px; height: 15px; top: 50%; left: 80%; animation-delay: 2s; }
.particle-3 { width: 25px; height: 25px; top: 70%; left: 15%; animation-delay: 4s; }
.particle-4 { width: 18px; height: 18px; top: 30%; left: 70%; animation-delay: 1s; }
.particle-5 { width: 22px; height: 22px; top: 80%; left: 60%; animation-delay: 3s; }
.particle-6 { width: 16px; height: 16px; top: 10%; left: 50%; animation-delay: 5s; }

@keyframes particleFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); opacity: 0.3; }
    25% { transform: translateY(-30px) rotate(90deg) scale(1.1); opacity: 0.7; }
    50% { transform: translateY(-60px) rotate(180deg) scale(0.9); opacity: 1; }
    75% { transform: translateY(-30px) rotate(270deg) scale(1.1); opacity: 0.5; }
}

.hero-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

/* Enhanced Breadcrumbs */
.breadcrumb-nav {
    margin-bottom: 2rem;
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 1rem 2rem;
    margin: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border-radius: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    display: inline-flex;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    font-weight: 500;
    font-family: inherit;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    margin: 0 1rem;
    opacity: 0.6;
    color: rgba(255, 255, 255, 0.6);
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
}

.breadcrumb-item a:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-1px);
}

.breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem 2rem;
    border-radius: 30px;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 2rem;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    font-family: inherit;
}

.category-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--cat-color);
    opacity: 0.2;
    border-radius: 30px;
}

.category-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    font-family: inherit;
}

.category-description {
    font-size: 1.2rem;
    line-height: 1.8;
    margin-bottom: 3rem;
    opacity: 0.95;
    font-family: inherit;
}

.category-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
}

.category-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1.5rem;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.category-stats .stat-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.category-stats .stat-item i {
    font-size: 2rem;
    color: #FFD700;
    filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.5));
}

.stat-content {
    text-align: right;
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    font-family: inherit;
}

/* Hero Visual */
.hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
}

.category-image {
    width: 250px;
    height: 250px;
    border-radius: 20px;
    overflow: hidden;
    border: 3px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-illustration {
    width: 250px;
    height: 250px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
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
    animation: bgFloat 8s ease-in-out infinite;
}

.bg-circle.circle-1 { width: 80px; height: 80px; top: 20%; right: 20%; animation-delay: 0s; }
.bg-circle.circle-2 { width: 60px; height: 60px; top: 60%; right: 70%; animation-delay: 2s; }
.bg-circle.circle-3 { width: 100px; height: 100px; top: 70%; right: 10%; animation-delay: 4s; }

@keyframes bgFloat {
    0%, 100% { transform: translateY(0px) scale(1); opacity: 0.3; }
    50% { transform: translateY(-25px) scale(1.1); opacity: 0.6; }
}

.illustration-icon {
    font-size: 4rem;
    z-index: 2;
    position: relative;
    animation: iconGlow 3s ease-in-out infinite;
    text-shadow: 0 0 30px currentColor;
}

@keyframes iconGlow {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Category Content Section */
.category-content-section {
    padding: 5rem 0;
}

.content-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Enhanced Category Info Box */
.category-info-box {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 3rem;
    margin-bottom: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.category-info-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--cat-color), transparent);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--cat-color);
}

.info-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--cat-color), var(--cat-color));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
}

.info-header h2 {
    color: var(--text-primary);
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
    font-family: inherit;
}

.info-content {
    color: var(--text-secondary);
    line-height: 1.8;
    font-size: 1.1rem;
}

.extended-description,
.auto-description {
    margin-bottom: 2rem;
}

.extended-description p,
.auto-description p {
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.related-categories {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.related-categories h4 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.related-cats-list {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.related-cat-tag {
    background: var(--cat-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.related-cat-tag:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    color: white;
}

.cat-count {
    opacity: 0.8;
    font-size: 0.8rem;
}

/* Enhanced Posts Controls */
.posts-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    padding: 2rem;
    background: var(--bg-main);
    border-radius: 15px;
    border: 1px solid var(--border-color);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    flex-wrap: wrap;
    gap: 2rem;
}

.controls-left,
.controls-right {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.view-controls {
    display: flex;
    gap: 0.5rem;
    background: var(--bg-secondary);
    padding: 0.5rem;
    border-radius: 10px;
    border: 1px solid var(--border-color);
}

.view-btn {
    width: 45px;
    height: 45px;
    background: transparent;
    color: var(--text-primary);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.filter-controls,
.sort-controls {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.posts-filter-select,
.posts-sort-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 0.9rem;
    min-width: 150px;
    transition: all 0.3s ease;
}

.posts-filter-select:focus,
.posts-sort-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.sort-controls label {
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.results-info {
    color: var(--text-secondary);
    font-weight: 500;
    padding: 0.75rem 1rem;
    background: var(--bg-secondary);
    border-radius: 10px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.results-count {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Enhanced Posts Container */
.posts-container {
    display: grid;
    gap: 2rem;
    margin-bottom: 4rem;
}

.posts-container.grid-view {
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
}

.posts-container.list-view {
    grid-template-columns: 1fr;
}

.posts-container.list-view .post-card {
    display: flex;
    align-items: stretch;
    gap: 2rem;
}

.posts-container.list-view .post-image {
    width: 300px;
    height: 200px;
    flex-shrink: 0;
}

.posts-container.list-view .post-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Enhanced Post Cards */
.post-card {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.post-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.post-image {
    height: 250px;
    overflow: hidden;
    position: relative;
    background: var(--bg-secondary);
}

.post-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.post-card:hover .post-img {
    transform: scale(1.1);
}

.post-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 1.5rem;
}

.post-card:hover .post-overlay {
    opacity: 1;
}

.post-meta-overlay {
    display: flex;
    justify-content: space-between;
    color: white;
    font-size: 0.9rem;
}

.post-meta-overlay span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0, 0, 0, 0.6);
    padding: 0.75rem 1rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    font-family: inherit;
}

.read-more-overlay {
    text-align: center;
}

.read-more-btn {
    background: rgba(255, 255, 255, 0.9);
    color: var(--primary-color);
    padding: 1rem 2rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    transform: translateY(20px);
    font-family: inherit;
}

.post-card:hover .read-more-btn {
    transform: translateY(0);
}

.read-more-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.05);
}

.featured-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #1a1a1a;
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    z-index: 3;
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
    animation: featuredPulse 3s infinite;
}

@keyframes featuredPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); box-shadow: 0 8px 20px rgba(255, 215, 0, 0.6); }
}

.post-content {
    padding: 2rem;
}

.post-categories {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.post-category {
    padding: 0.4rem 1rem;
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.post-category:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    color: white;
}

.post-category.current {
    position: relative;
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.post-category.current::after {
    content: '✓';
    position: absolute;
    top: -5px;
    right: -5px;
    background: #FFD700;
    color: #1a1a1a;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
}

.post-title {
    margin: 0 0 1rem 0;
    font-size: 1.4rem;
    line-height: 1.4;
    font-weight: 700;
    font-family: inherit;
}

.post-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: var(--primary-color);
}

.post-subtitle {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1rem;
    font-style: italic;
    font-family: inherit;
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 2rem;
    font-family: inherit;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.meta-left,
.meta-right {
    display: flex;
    gap: 1.5rem;
    font-size: 0.9rem;
    color: var(--text-muted);
}

.meta-left span,
.meta-right span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.meta-left a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    font-family: inherit;
}

.meta-left a:hover {
    color: var(--primary-dark);
}

.post-tags {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.post-tag {
    background: var(--bg-secondary);
    color: var(--text-secondary);
    padding: 0.4rem 0.8rem;
    text-decoration: none;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.post-tag:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.post-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.btn-read-more {
    background: var(--primary-color);
    color: white;
    padding: 1rem 2rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.btn-read-more:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 5px 15px rgba(31, 165, 71, 0.3);
}

.post-share {
    display: flex;
    gap: 0.5rem;
}

.share-btn,
.bookmark-btn {
    width: 45px;
    height: 45px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.share-btn:hover,
.bookmark-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.1);
}

.bookmark-btn.bookmarked {
    background: #FFD700;
    color: #1a1a1a;
    border-color: #FFD700;
}

/* Enhanced Pagination */
.category-pagination {
    margin-top: 4rem;
    text-align: center;
}

.pagination-nav {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    align-items: center;
}

.pagination-info {
    background: var(--bg-main);
    padding: 1rem 2rem;
    border-radius: 25px;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    font-weight: 500;
    font-family: inherit;
}

.pagination-links {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.pagination-links a,
.pagination-links span {
    padding: 1rem 1.5rem;
    background: var(--bg-main);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    font-family: inherit;
    min-width: 50px;
    justify-content: center;
}

.pagination-links a:hover,
.pagination-links .current {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(31, 165, 71, 0.3);
}

/* No Posts Found */
.no-posts-found {
    text-align: center;
    padding: 5rem 2rem;
    background: var(--bg-main);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
}

.no-posts-illustration {
    font-size: 5rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
    opacity: 0.5;
}

.no-posts-found h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 2rem;
    font-weight: 700;
    font-family: inherit;
}

.no-posts-found p {
    color: var(--text-secondary);
    margin-bottom: 3rem;
    font-size: 1.2rem;
    font-family: inherit;
}

.no-posts-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-primary,
.btn-secondary {
    padding: 1rem 2rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
}

.btn-secondary {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

/* Enhanced Sidebar */
.category-sidebar {
    position: sticky;
    top: calc(100px + 2rem);
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

body.admin-bar .category-sidebar {
    top: calc(132px + 2rem);
}

@media screen and (max-width: 782px) {
    body.admin-bar .category-sidebar {
        top: calc(116px + 2rem);
    }
}

.category-sidebar .widget {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.category-sidebar .widget:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
}

.widget-title {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.5rem 2rem;
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.widget-content {
    padding: 2rem;
}

/* Category Quick Info Widget */
.category-quick-info .widget-content {
    text-align: center;
}

.quick-info-header {
    margin-bottom: 2rem;
}

.quick-info-header .category-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--cat-color), var(--cat-color));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.quick-info-header h3 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin: 0;
    font-family: inherit;
}

.quick-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.quick-stat {
    text-align: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.quick-stat .stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    font-family: inherit;
}

.quick-stat .stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.category-rss {
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.rss-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #FF6600;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.rss-link:hover {
    color: #FF4500;
    transform: translateY(-1px);
}

/* Category Search Widget */
.category-search-form .search-input-wrapper {
    position: relative;
    display: flex;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 2px solid var(--border-color);
    overflow: hidden;
    margin-bottom: 1rem;
}

.search-input {
    flex: 1;
    padding: 1rem 1.5rem;
    border: none;
    background: transparent;
    font-family: inherit;
    color: var(--text-primary);
    font-size: 1rem;
}

.search-input:focus {
    outline: none;
}

.search-input-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.search-submit {
    padding: 1rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
    font-size: 1rem;
}

.search-submit:hover {
    background: var(--primary-dark);
}

.advanced-search {
    margin-top: 1rem;
}

.advanced-search summary {
    color: var(--primary-color);
    font-weight: 500;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: background 0.3s ease;
    font-family: inherit;
}

.advanced-search summary:hover {
    background: var(--bg-secondary);
}

.advanced-options {
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 8px;
    margin-top: 0.5rem;
    border: 1px solid var(--border-color);
}

.advanced-options label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-size: 0.9rem;
    cursor: pointer;
    font-family: inherit;
}

.advanced-options input[type="checkbox"] {
    accent-color: var(--primary-color);
}

/* Popular Posts Widget */
.popular-posts-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.popular-post-item {
    display: flex;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.popular-post-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.popular-rank {
    width: 35px;
    height: 35px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
    font-family: inherit;
}

.popular-thumbnail {
    width: 70px;
    height: 70px;
    border-radius: 12px;
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
    font-size: 1rem;
    line-height: 1.4;
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
    font-size: 0.8rem;
    color: var(--text-muted);
}

.popular-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.no-popular-posts {
    color: var(--text-muted);
    text-align: center;
    padding: 2rem;
    font-style: italic;
    font-family: inherit;
}

/* Related Categories Widget */
.related-categories-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.related-category-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
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
    background: var(--rel-cat-color);
    transition: width 0.3s ease;
}

.related-category-item:hover::before {
    width: 4px;
}

.related-category-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--rel-cat-color);
    transform: translateX(-5px);
    color: var(--text-primary);
}

.category-info .category-name {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.category-info .category-count {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-family: inherit;
}

.category-arrow {
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    color: var(--rel-cat-color);
}

.related-category-item:hover .category-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Newsletter Widget */
.newsletter-widget {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    color: white;
    border: none !important;
}

.newsletter-widget .widget-title {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.newsletter-header {
    text-align: center;
    margin-bottom: 2rem;
}

.newsletter-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.newsletter-header h3 {
    margin: 0 0 1rem 0;
    font-size: 1.3rem;
    font-weight: 700;
    font-family: inherit;
}

.newsletter-header p {
    margin: 0 0 0;
    opacity: 0.9;
    font-family: inherit;
}

.newsletter-form {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
}

.newsletter-input {
    flex: 1;
    padding: 1rem;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    font-family: inherit;
    font-size: 1rem;
}

.newsletter-submit {
    padding: 1rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: inherit;
    white-space: nowrap;
}

.newsletter-submit:hover {
    background: rgba(255, 255, 255, 0.3);
}

.newsletter-submit.loading .btn-text {
    display: none;
}

.newsletter-submit.loading .btn-loading {
    display: inline-block !important;
}

.newsletter-benefits {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.newsletter-benefits .benefit {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    opacity: 0.9;
    font-family: inherit;
}

.newsletter-benefits .benefit i {
    font-size: 1rem;
    color: #FFD700;
}

/* Category Archives Widget */
.archives-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.archives-list a {
    color: var(--text-primary);
    text-decoration: none;
    padding: 0.75rem 1rem;
    background: var(--bg-secondary);
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.archives-list a:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateX(-3px);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
    }
    
    .content-layout {
        grid-template-columns: 1fr 350px;
        gap: 3rem;
    }
    
    .posts-container.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
}

@media (max-width: 1024px) {
    .content-layout {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .category-sidebar {
        position: static;
        order: -1;
    }
    
    .posts-container.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .category-archive-main {
        padding-top: 70px;
    }
    
    body.admin-bar .category-archive-main {
        padding-top: 102px;
    }
    
    .category-hero {
        padding: 3rem 0;
    }
    
    .category-title {
        font-size: 2rem;
    }
    
    .category-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .posts-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .controls-left,
    .controls-right {
        justify-content: center;
    }
    
    .posts-container.grid-view {
        grid-template-columns: 1fr;
    }
    
    .posts-container.list-view .post-card {
        flex-direction: column;
    }
    
    .posts-container.list-view .post-image {
        width: 100%;
        height: 200px;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .no-posts-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .category-hero {
        padding: 2rem 0;
    }
    
    .category-title {
        font-size: 1.7rem;
    }
    
    .category-description {
        font-size: 1rem;
    }
    
    .category-stats {
        grid-template-columns: 1fr;
    }
    
    .category-info-box {
        padding: 2rem 1.5rem;
    }
    
    .posts-controls {
        padding: 1.5rem;
    }
    
    .post-content {
        padding: 1.5rem;
    }
    
    .category-stats .stat-item {
        padding: 1rem;
    }
    
    .popular-post-item {
        padding: 0.75rem;
    }
    
    .widget-content {
        padding: 1.5rem;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .pagination-links {
        gap: 0.25rem;
    }
    
    .pagination-links a,
    .pagination-links span {
        padding: 0.75rem 1rem;
        min-width: 45px;
    }
}
</style>

<!-- Enhanced JavaScript -->
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
                
                // Save preference
                localStorage.setItem('preferredView', view);
            }
        });
    });
    
    // Restore saved view preference
    const savedView = localStorage.getItem('preferredView');
    if (savedView) {
        const targetBtn = document.querySelector(`[data-view="${savedView}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
    
    // Filter functionality
    const filterSelect = document.getElementById('posts-filter');
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const filterValue = this.value;
            const posts = document.querySelectorAll('.post-card');
            
            posts.forEach(post => {
                let show = true;
                
                switch (filterValue) {
                    case 'featured':
                        show = post.getAttribute('data-featured') === 'true';
                        break;
                    case 'recent':
                        const postDate = new Date(post.getAttribute('data-date'));
                        const thirtyDaysAgo = new Date();
                        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                        show = postDate >= thirtyDaysAgo;
                        break;
                    case 'popular':
                        const views = parseInt(post.getAttribute('data-views') || '0');
                        show = views >= 100; // Adjust threshold as needed
                        break;
                    case 'all':
                    default:
                        show = true;
                        break;
                }
                
                post.style.display = show ? '' : 'none';
            });
        });
    }
    
    // Sort functionality
    const sortSelect = document.getElementById('posts-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const posts = Array.from(document.querySelectorAll('.post-card'));
            
            posts.sort((a, b) => {
                switch (sortValue) {
                    case 'date-desc':
                        return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                    case 'date-asc':
                        return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                    case 'views-desc':
                        return parseInt(b.getAttribute('data-views') || '0') - parseInt(a.getAttribute('data-views') || '0');
                    case 'comments-desc':
                        return parseInt(b.getAttribute('data-comments') || '0') - parseInt(a.getAttribute('data-comments') || '0');
                    case 'title-asc':
                        return a.querySelector('.post-title a').textContent.localeCompare(b.querySelector('.post-title a').textContent);
                    case 'title-desc':
                        return b.querySelector('.post-title a').textContent.localeCompare(a.querySelector('.post-title a').textContent);
                    default:
                        return 0;
                }
            });
            
            const container = postsContainer || document.querySelector('.posts-container');
            posts.forEach(post => container.appendChild(post));
        });
    }
    
    // Share functionality
    const shareBtns = document.querySelectorAll('.share-btn');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const title = this.getAttribute('data-title');
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                });
            } else {
                // Fallback to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    // Show toast notification
                    showToast('لینک کپی شد!');
                });
            }
        });
    });
    
    // Bookmark functionality
    const bookmarkBtns = document.querySelectorAll('.bookmark-btn');
    bookmarkBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const isBookmarked = this.classList.contains('bookmarked');
            
            if (isBookmarked) {
                this.classList.remove('bookmarked');
                this.innerHTML = '<i class="far fa-bookmark"></i>';
                removeBookmark(postId);
                showToast('از نشان‌شده‌ها حذف شد');
            } else {
                this.classList.add('bookmarked');
                this.innerHTML = '<i class="fas fa-bookmark"></i>';
                addBookmark(postId);
                showToast('به نشان‌شده‌ها اضافه شد');
            }
        });
    });
    
    // Newsletter subscription
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('.newsletter-input').value;
            const categoryId = this.getAttribute('data-category');
            const submitBtn = this.querySelector('.newsletter-submit');
            
            submitBtn.classList.add('loading');
            
            // Simulate API call
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                showToast('با موفقیت در خبرنامه عضو شدید!');
                this.reset();
            }, 2000);
        });
    });
    
    // Search form enhancements
    const searchForms = document.querySelectorAll('.category-search-form');
    searchForms.forEach(form => {
        const searchInput = form.querySelector('.search-input');
        
        // Add search suggestions (placeholder for future implementation)
        searchInput.addEventListener('input', function() {
            const query = this.value;
            if (query.length >= 3) {
                // Show search suggestions
                // This can be implemented with AJAX
            }
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
    
    // Animate post cards
    document.querySelectorAll('.post-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Animate sidebar widgets
    document.querySelectorAll('.category-sidebar .widget').forEach((widget, index) => {
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(30px)';
        widget.style.transition = `opacity 0.6s ease ${index * 0.2}s, transform 0.6s ease ${index * 0.2}s`;
        observer.observe(widget);
    });
    
    // Utility functions
    function showToast(message) {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            font-family: inherit;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    function addBookmark(postId) {
        const bookmarks = JSON.parse(localStorage.getItem('bookmarks') || '[]');
        if (!bookmarks.includes(postId)) {
            bookmarks.push(postId);
            localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
        }
    }
    
    function removeBookmark(postId) {
        const bookmarks = JSON.parse(localStorage.getItem('bookmarks') || '[]');
        const index = bookmarks.indexOf(postId);
        if (index > -1) {
            bookmarks.splice(index, 1);
            localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
        }
    }
    
    // Initialize bookmarks
    const bookmarks = JSON.parse(localStorage.getItem('bookmarks') || '[]');
    bookmarkBtns.forEach(btn => {
        const postId = btn.getAttribute('data-post-id');
        if (bookmarks.includes(postId)) {
            btn.classList.add('bookmarked');
            btn.innerHTML = '<i class="fas fa-bookmark"></i>';
        }
    });
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>

<?php get_footer(); ?>