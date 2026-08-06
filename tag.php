<?php get_header(); ?>

<main id="main-content" class="tag-archive-main">
    
    <!-- Tag Hero -->
    <section class="tag-hero">
        <div class="hero-background">
            <div class="hero-constellation">
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <div class="constellation-star star-<?php echo $i; ?>"></div>
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
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="<?php echo home_url('/tag'); ?>" itemprop="item">
                                <span itemprop="name">برچسب‌ها</span>
                            </a>
                            <meta itemprop="position" content="3" />
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name">#<?php single_tag_title(); ?></span>
                            <meta itemprop="position" content="4" />
                        </li>
                    </ol>
                </nav>
                
                <!-- Tag Info -->
                <div class="tag-info">
                    <?php
                    $tag = get_queried_object();
                    $tag_color = get_term_meta($tag->term_id, 'tag_color', true) ?: '#667eea';
                    ?>
                    
                    <div class="tag-badge" style="--tag-color: <?php echo $tag_color; ?>">
                        <i class="fas fa-hashtag"></i>
                        <span>برچسب</span>
                    </div>
                    
                    <h1 class="tag-title" itemprop="name">
                        <span class="hashtag" style="color: <?php echo $tag_color; ?>">#</span><?php single_tag_title(); ?>
                    </h1>
                    
                    <?php if (tag_description()): ?>
                        <div class="tag-description" itemprop="description">
                            <?php echo tag_description(); ?>
                        </div>
                    <?php else: ?>
                        <div class="tag-description">
                            <p>مجموعه مقالاتی که با برچسب <strong><?php single_tag_title(); ?></strong> برچسب‌گذاری شده‌اند. این مطالب به موضوعات مرتبط با <?php single_tag_title(); ?> می‌پردازند.</p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Dynamic Tag Stats -->
                    <div class="tag-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <div class="stat-content">
                                <span class="stat-number" itemprop="numberOfItems"><?php echo $wp_query->found_posts; ?></span>
                                <span class="stat-label">مقاله</span>
                            </div>
                        </div>
                        
                        <?php
                        // Get tag usage frequency
                        $all_tags = wp_count_terms('post_tag');
                        $tag_rank = 0;
                        $tags_by_count = get_terms(array(
                            'taxonomy' => 'post_tag',
                            'orderby' => 'count',
                            'order' => 'DESC',
                            'number' => $all_tags
                        ));
                        
                        foreach ($tags_by_count as $index => $ranked_tag) {
                            if ($ranked_tag->term_id == $tag->term_id) {
                                $tag_rank = $index + 1;
                                break;
                            }
                        }
                        
                        $popularity = $tag_rank <= 10 ? 'محبوب' : ($tag_rank <= 50 ? 'متوسط' : 'تخصصی');
                        ?>
                        
                        <div class="stat-item">
                            <i class="fas fa-chart-line"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $tag_rank; ?></span>
                                <span class="stat-label">رتبه محبوبیت</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-tags"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $popularity; ?></span>
                                <span class="stat-label">دسته‌بندی</span>
                            </div>
                        </div>
                        
                        <?php
                        // First post with this tag
                        $first_post = get_posts(array(
                            'tag' => $tag->slug,
                            'numberposts' => 1,
                            'orderby' => 'date',
                            'order' => 'ASC'
                        ));
                        
                        if ($first_post):
                        ?>
                            <div class="stat-item">
                                <i class="fas fa-calendar-plus"></i>
                                <div class="stat-content">
                                    <span class="stat-number"><?php echo get_the_date('Y', $first_post[0]); ?></span>
                                    <span class="stat-label">اولین استفاده</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Tag Visual -->
                <div class="hero-visual">
                    <div class="tag-cloud-illustration">
                        <div class="illustration-bg">
                            <div class="tag-cloud">
                                <?php
                                // Get related tags
                                $related_tags = get_terms(array(
                                    'taxonomy' => 'post_tag',
                                    'exclude' => $tag->term_id,
                                    'number' => 8,
                                    'orderby' => 'count',
                                    'order' => 'DESC'
                                ));
                                
                                $positions = [
                                    ['top' => '10%', 'left' => '20%'],
                                    ['top' => '30%', 'left' => '70%'],
                                    ['top' => '50%', 'left' => '10%'],
                                    ['top' => '70%', 'left' => '60%'],
                                    ['top' => '20%', 'left' => '50%'],
                                    ['top' => '80%', 'left' => '30%'],
                                    ['top' => '40%', 'left' => '80%'],
                                    ['top' => '60%', 'left' => '40%']
                                ];
                                
                                foreach ($related_tags as $index => $related_tag):
                                    $position = $positions[$index] ?? $positions[0];
                                    $size = max(0.7, 1.2 - ($index * 0.1));
                                ?>
                                    <span class="tag-item" 
                                          style="top: <?php echo $position['top']; ?>; 
                                                 left: <?php echo $position['left']; ?>;
                                                 font-size: <?php echo $size; ?>rem;">
                                        #<?php echo esc_html($related_tag->name); ?>
                                    </span>
                                <?php endforeach; ?>
                                
                                <!-- Current tag (center and highlighted) -->
                                <span class="tag-item current-tag" 
                                      style="top: 45%; left: 45%; font-size: 1.4rem; color: <?php echo $tag_color; ?>">
                                    #<?php single_tag_title(); ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="illustration-icon" style="color: <?php echo $tag_color; ?>">
                            <i class="fas fa-hashtag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Tag Content Section -->
    <section class="tag-content-section">
        <div class="container">
            <div class="content-layout">
                
                <!-- Main Content -->
                <div class="main-content">
                    
                    <!-- Enhanced Tag Info Box -->
                    <div class="tag-info-box" style="--tag-color: <?php echo $tag_color; ?>">
                        <div class="info-header">
                            <div class="info-icon">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <h2>درباره برچسب «<?php single_tag_title(); ?>»</h2>
                        </div>
                        
                        <div class="info-content">
                            <?php
                            $tag_extended_desc = get_term_meta($tag->term_id, 'tag_extended_description', true);
                            if ($tag_extended_desc):
                            ?>
                                <div class="extended-description">
                                    <?php echo wpautop($tag_extended_desc); ?>
                                </div>
                            <?php else: ?>
                                <div class="auto-description">
                                    <p>برچسب <strong><?php single_tag_title(); ?></strong> برای دسته‌بندی و سازماندهی مطالب مرتبط استفاده می‌شود. این برچسب به شما کمک می‌کند تا به راحتی مقالات مرتبط با <?php single_tag_title(); ?> را پیدا کنید.</p>
                                    
                                    <?php if ($tag->count > 5): ?>
                                        <p>با <?php echo $tag->count; ?> مقاله مرتبط، این برچسب یکی از برچسب‌های پرکاربرد در سایت ما محسوب می‌شود.</p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Tag Timeline -->
                            <?php
                            $tag_timeline = get_posts(array(
                                'tag' => $tag->slug,
                                'numberposts' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'meta_query' => array(
                                    array(
                                        'key' => 'featured_post',
                                        'value' => '1',
                                        'compare' => '='
                                    )
                                )
                            ));
                            
                            if ($tag_timeline):
                            ?>
                                <div class="tag-timeline">
                                    <h4><i class="fas fa-timeline"></i> آخرین مقالات ویژه:</h4>
                                    <div class="timeline-list">
                                        <?php foreach ($tag_timeline as $timeline_post): ?>
                                            <div class="timeline-item">
                                                <div class="timeline-date"><?php echo get_the_date('j M', $timeline_post); ?></div>
                                                <div class="timeline-content">
                                                    <a href="<?php echo get_permalink($timeline_post); ?>">
                                                        <?php echo esc_html(get_the_title($timeline_post)); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Related Tags -->
                            <?php if ($related_tags): ?>
                                <div class="related-tags">
                                    <h4><i class="fas fa-link"></i> برچسب‌های مرتبط:</h4>
                                    <div class="related-tags-list">
                                        <?php foreach (array_slice($related_tags, 0, 6) as $related_tag): ?>
                                            <a href="<?php echo get_tag_link($related_tag); ?>" 
                                               class="related-tag-item">
                                                #<?php echo esc_html($related_tag->name); ?>
                                                <span class="tag-count">(<?php echo $related_tag->count; ?>)</span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Posts with this tag -->
                    <?php if (have_posts()): ?>
                        <div class="tag-posts-container">
                            <div class="posts-header">
                                <h3 class="posts-title">
                                    <i class="fas fa-list"></i>
                                    همه مقالات با برچسب «<?php single_tag_title(); ?>»
                                </h3>
                                
                                <div class="posts-meta">
                                    <span class="posts-count"><?php echo $wp_query->found_posts; ?> مقاله</span>
                                    <div class="view-options">
                                        <button class="view-btn active" data-view="grid">
                                            <i class="fas fa-th"></i>
                                        </button>
                                        <button class="view-btn" data-view="list">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="posts-grid grid-view" id="posts-container">
                                <?php while (have_posts()): the_post(); ?>
                                    <article class="tag-post-card" 
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
                                                    <div class="post-date-overlay">
                                                        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                                                            <i class="fas fa-calendar"></i>
                                                            <?php echo get_the_date(); ?>
                                                        </time>
                                                    </div>
                                                    
                                                    <div class="post-action-overlay">
                                                        <a href="<?php the_permalink(); ?>" class="read-post-btn">
                                                            <i class="fas fa-book-reader"></i>
                                                            مطالعه
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
                                                $categories = get_the_category();
                                                if ($categories) {
                                                    foreach (array_slice($categories, 0, 2) as $category) {
                                                        $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#1FA547';
                                                        echo '<a href="' . esc_url(get_category_link($category)) . '" 
                                                              class="post-category" 
                                                              style="background-color: ' . esc_attr($cat_color) . '"
                                                              itemprop="about">' . 
                                                              esc_html($category->name) . '</a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            
                                            <h4 class="post-title" itemprop="headline">
                                                <a href="<?php the_permalink(); ?>" itemprop="url">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h4>
                                            
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
                                                </div>
                                                
                                                <div class="meta-right">
                                                    <span class="post-views">
                                                        <i class="fas fa-eye"></i>
                                                        <?php echo number_format(get_post_meta(get_the_ID(), 'post_views', true) ?: 0); ?>
                                                    </span>
                                                    <span class="post-comments">
                                                        <i class="fas fa-comments"></i>
                                                        <span itemprop="commentCount"><?php echo get_comments_number(); ?></span>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Post Tags (highlighting current tag) -->
                                            <div class="post-tags-preview">
                                                <?php
                                                $post_tags = get_the_tags();
                                                if ($post_tags) {
                                                    foreach (array_slice($post_tags, 0, 4) as $post_tag) {
                                                        $is_current = ($post_tag->term_id == $tag->term_id);
                                                        $class = $is_current ? 'post-tag current' : 'post-tag';
                                                        echo '<a href="' . esc_url(get_tag_link($post_tag)) . '" 
                                                              class="' . $class . '"
                                                              itemprop="keywords">' . 
                                                              '#' . esc_html($post_tag->name) . '</a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            
                                            <div class="post-actions">
                                                <a href="<?php the_permalink(); ?>" class="btn-read-full">
                                                    <span>مطالعه کامل</span>
                                                    <i class="fas fa-arrow-left"></i>
                                                </a>
                                                
                                                <div class="post-interactions">
                                                    <button class="interaction-btn share-btn" 
                                                            data-url="<?php the_permalink(); ?>" 
                                                            data-title="<?php the_title_attribute(); ?>"
                                                            title="اشتراک‌گذاری">
                                                        <i class="fas fa-share-alt"></i>
                                                    </button>
                                                    <button class="interaction-btn like-btn" 
                                                            data-post-id="<?php echo get_the_ID(); ?>"
                                                            title="پسندیدن">
                                                        <i class="far fa-heart"></i>
                                                        <span class="like-count"><?php echo get_post_meta(get_the_ID(), 'post_likes', true) ?: 0; ?></span>
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
                            <div class="tag-pagination">
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
                        </div>
                        
                    <?php else: ?>
                        <div class="no-posts-found">
                            <div class="no-posts-illustration">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h3>مقاله‌ای با این برچسب یافت نشد</h3>
                            <p>متأسفانه هیچ مقاله‌ای با برچسب «<?php single_tag_title(); ?>» وجود ندارد.</p>
                            <div class="no-posts-actions">
                                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                    بازگشت به وبلاگ
                                </a>
                                <a href="<?php echo home_url('/tag'); ?>" class="btn-secondary">
                                    <i class="fas fa-tags"></i>
                                    مرور برچسب‌ها
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Enhanced Sidebar -->
                <aside class="tag-sidebar">
                    
                    <!-- Tag Quick Info -->
                    <div class="widget tag-quick-info" style="--tag-color: <?php echo $tag_color; ?>">
                        <div class="widget-content">
                            <div class="quick-info-header">
                                <div class="tag-icon">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <h3>#<?php single_tag_title(); ?></h3>
                            </div>
                            
                            <div class="tag-stats-detailed">
                                <div class="stat-row">
                                    <span class="stat-label">مقالات:</span>
                                    <span class="stat-value"><?php echo $wp_query->found_posts; ?></span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">رتبه محبوبیت:</span>
                                    <span class="stat-value"><?php echo $tag_rank; ?></span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">نوع:</span>
                                    <span class="stat-value"><?php echo $popularity; ?></span>
                                </div>
                            </div>
                            
                            <!-- Tag RSS Feed -->
                            <div class="tag-rss">
                                <a href="<?php echo get_tag_feed_link($tag->term_id); ?>" 
                                   class="rss-link" 
                                   title="خورد RSS این برچسب">
                                    <i class="fas fa-rss"></i>
                                    دنبال کردن RSS
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tag Search -->
                    <div class="widget tag-search-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-search"></i>
                            جستجو در این برچسب
                        </h3>
                        <div class="widget-content">
                            <form class="tag-search-form" method="get" action="<?php echo home_url('/'); ?>">
                                <input type="hidden" name="tag" value="<?php echo get_queried_object()->slug; ?>">
                                <div class="search-input-wrapper">
                                    <input type="search" 
                                           name="s" 
                                           placeholder="جستجو در مقالات #<?php single_tag_title(); ?>..." 
                                           class="search-input"
                                           value="<?php echo get_search_query(); ?>">
                                    <button type="submit" class="search-submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Popular Tags Cloud -->
                    <div class="widget popular-tags-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-fire"></i>
                            برچسب‌های محبوب
                        </h3>
                        <div class="widget-content">
                            <div class="tags-cloud">
                                <?php
                                $popular_tags = get_tags(array(
                                    'number' => 20,
                                    'orderby' => 'count',
                                    'order' => 'DESC'
                                ));
                                
                                $max_count = $popular_tags[0]->count ?? 1;
                                $min_count = end($popular_tags)->count ?? 1;
                                
                                foreach ($popular_tags as $popular_tag):
                                    $size_ratio = ($popular_tag->count - $min_count) / max(1, ($max_count - $min_count));
                                    $font_size = 0.8 + ($size_ratio * 0.8); // 0.8rem to 1.6rem
                                    $is_current = ($popular_tag->term_id == get_queried_object_id());
                                    $class = $is_current ? 'popular-tag current' : 'popular-tag';
                                ?>
                                    <a href="<?php echo get_tag_link($popular_tag); ?>" 
                                       class="<?php echo $class; ?>"
                                       style="font-size: <?php echo $font_size; ?>rem;"
                                       title="<?php echo $popular_tag->count; ?> مقاله">
                                        #<?php echo esc_html($popular_tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Posts by Tag -->
                    <div class="widget related-posts-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-link"></i>
                            مقالات مرتبط
                        </h3>
                        <div class="widget-content">
                            <?php
                            $related_posts = get_posts(array(
                                'tag__in' => array(get_queried_object_id()),
                                'posts_per_page' => 5,
                                'meta_key' => 'post_views',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'post_status' => 'publish'
                            ));
                            
                            if ($related_posts):
                            ?>
                                <div class="related-posts-list">
                                    <?php foreach ($related_posts as $index => $related_post): ?>
                                        <div class="related-post-item">
                                            <div class="related-rank">
                                                <span><?php echo $index + 1; ?></span>
                                            </div>
                                            
                                            <?php if (has_post_thumbnail($related_post->ID)): ?>
                                                <div class="related-thumbnail">
                                                    <a href="<?php echo get_permalink($related_post); ?>">
                                                        <?php echo get_the_post_thumbnail($related_post->ID, 'thumbnail', array(
                                                            'loading' => 'lazy'
                                                        )); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="related-content">
                                                <h4 class="related-title">
                                                    <a href="<?php echo get_permalink($related_post); ?>">
                                                        <?php echo esc_html(get_the_title($related_post)); ?>
                                                    </a>
                                                </h4>
                                                
                                                <div class="related-meta">
                                                    <span class="related-date">
                                                        <i class="fas fa-calendar"></i>
                                                        <?php echo get_the_date('j M Y', $related_post); ?>
                                                    </span>
                                                    <span class="related-views">
                                                        <i class="fas fa-eye"></i>
                                                        <?php echo number_format(get_post_meta($related_post->ID, 'post_views', true) ?: 0); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="no-related-posts">مقاله مرتبطی یافت نشد.</p>
                            <?php endif; ?>
                            
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                    
                    <!-- Tag Analytics -->
                    <div class="widget tag-analytics-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-chart-bar"></i>
                            آمار برچسب
                        </h3>
                        <div class="widget-content">
                            <?php
                            $total_tags_count = wp_count_terms('post_tag');
                            $total_posts = wp_count_posts()->publish;
                            $tag_percentage = $total_posts > 0 ? round(($tag->count / $total_posts) * 100, 1) : 0;
                            ?>
                            
                            <div class="analytics-stats">
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="analytics-content">
                                        <span class="analytics-number"><?php echo number_format($tag->count); ?></span>
                                        <span class="analytics-label">مقاله با این برچسب</span>
                                    </div>
                                </div>
                                
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="analytics-content">
                                        <span class="analytics-number"><?php echo number_format($total_tags_count); ?></span>
                                        <span class="analytics-label">کل برچسب‌ها</span>
                                    </div>
                                </div>
                                
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div class="analytics-content">
                                        <span class="analytics-number"><?php echo $tag_percentage; ?>%</span>
                                        <span class="analytics-label">از کل مقالات</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Usage Chart (simplified) -->
                            <div class="tag-usage-chart">
                                <div class="chart-bar">
                                    <div class="chart-progress" style="width: <?php echo min(100, ($tag->count / max(1, $max_count)) * 100); ?>%"></div>
                                </div>
                                <div class="chart-label">میزان استفاده نسبت به محبوب‌ترین برچسب</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tag Newsletter -->
                    <div class="widget tag-newsletter-widget">
                        <div class="widget-content">
                            <div class="newsletter-header">
                                <div class="newsletter-icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <h3>اطلاع‌رسانی برچسب</h3>
                                <p>از مقالات جدید با برچسب #<?php single_tag_title(); ?> باخبر شوید</p>
                            </div>
                            
                            <form class="newsletter-form" data-tag="<?php echo $tag->term_id; ?>">
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
                            
                            <div class="newsletter-note">
                                <i class="fas fa-info-circle"></i>
                                <span>فقط هنگام انتشار مقاله جدید با این برچسب ایمیل دریافت خواهید کرد</span>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (function_exists('dynamic_sidebar')) { 
                        dynamic_sidebar('tag-sidebar'); 
                    } ?>
                </aside>
            </div>
        </div>
    </section>
    
</main>

<!-- Enhanced CSS -->
<style>
/* Tag Archive Enhanced Styles */
.tag-archive-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
    font-family: inherit;
}

/* Admin bar adjustments */
body.admin-bar .tag-archive-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .tag-archive-main {
        padding-top: 116px;
    }
}

/* Enhanced Tag Hero */
.tag-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
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

.hero-constellation {
    position: absolute;
    width: 100%;
    height: 100%;
}

.constellation-star {
    position: absolute;
    width: 6px;
    height: 6px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: starTwinkle 3s ease-in-out infinite;
}

.star-1 { top: 15%; left: 20%; animation-delay: 0s; }
.star-2 { top: 25%; left: 70%; animation-delay: 0.5s; }
.star-3 { top: 45%; left: 15%; animation-delay: 1s; }
.star-4 { top: 60%; left: 80%; animation-delay: 1.5s; }
.star-5 { top: 75%; left: 30%; animation-delay: 2s; }
.star-6 { top: 30%; left: 90%; animation-delay: 2.5s; }
.star-7 { top: 85%; left: 75%; animation-delay: 3s; }
.star-8 { top: 10%; left: 50%; animation-delay: 3.5s; }

@keyframes starTwinkle {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.3); }
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
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    border-radius: 30px;
    border: 1px solid rgba(255, 255, 255, 0.25);
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

.tag-badge {
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

.tag-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--tag-color);
    opacity: 0.2;
    border-radius: 30px;
}

.tag-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    font-family: inherit;
}

.hashtag {
    font-weight: 300;
    opacity: 0.9;
}

.tag-description {
    font-size: 1.2rem;
    line-height: 1.8;
    margin-bottom: 3rem;
    opacity: 0.95;
    font-family: inherit;
}

.tag-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 2rem;
}

.tag-stats .stat-item {
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

.tag-stats .stat-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.tag-stats .stat-item i {
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

.tag-cloud-illustration {
    width: 280px;
    height: 280px;
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

.tag-cloud {
    position: absolute;
    width: 100%;
    height: 100%;
}

.tag-cloud .tag-item {
    position: absolute;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    animation: tagFloat 8s ease-in-out infinite;
    transform-origin: center;
    font-family: inherit;
}

.tag-cloud .tag-item.current-tag {
    color: white;
    font-weight: 700;
    text-shadow: 0 0 20px currentColor;
    z-index: 10;
}

@keyframes tagFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.6; }
    25% { transform: translateY(-10px) rotate(2deg); opacity: 0.8; }
    50% { transform: translateY(-20px) rotate(-1deg); opacity: 1; }
    75% { transform: translateY(-10px) rotate(1deg); opacity: 0.8; }
}

.illustration-icon {
    font-size: 4rem;
    z-index: 2;
    position: relative;
    animation: iconPulse 3s ease-in-out infinite;
    text-shadow: 0 0 30px currentColor;
}

@keyframes iconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Tag Content Section */
.tag-content-section {
    padding: 5rem 0;
}

.content-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Enhanced Tag Info Box */
.tag-info-box {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 3rem;
    margin-bottom: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.tag-info-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--tag-color), transparent);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--tag-color);
}

.info-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--tag-color), var(--tag-color));
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

.tag-timeline {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.tag-timeline h4 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.timeline-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.timeline-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-main);
    border-radius: 10px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.timeline-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateX(-5px);
}

.timeline-date {
    background: var(--tag-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
    font-family: inherit;
}

.timeline-content a {
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    font-family: inherit;
}

.timeline-content a:hover {
    color: var(--primary-color);
}

.related-tags {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.related-tags h4 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.related-tags-list {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.related-tag-item {
    background: var(--tag-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.related-tag-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    color: white;
}

.tag-count {
    opacity: 0.8;
    font-size: 0.8rem;
}

/* Tag Posts Container */
.tag-posts-container {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
}

.posts-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
    flex-wrap: wrap;
    gap: 2rem;
}

.posts-title {
    color: var(--text-primary);
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-family: inherit;
}

.posts-meta {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.posts-count {
    color: var(--text-secondary);
    font-weight: 500;
    background: var(--bg-secondary);
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.view-options {
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

/* Posts Grid */
.posts-grid {
    display: grid;
    gap: 2rem;
}

.posts-grid.grid-view {
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
}

.posts-grid.list-view {
    grid-template-columns: 1fr;
}

.posts-grid.list-view .tag-post-card {
    display: flex;
    align-items: stretch;
    gap: 2rem;
}

.posts-grid.list-view .post-image {
    width: 300px;
    height: 200px;
    flex-shrink: 0;
}

.posts-grid.list-view .post-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Enhanced Tag Post Cards */
.tag-post-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.tag-post-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.post-image {
    height: 250px;
    overflow: hidden;
    position: relative;
    background: var(--bg-main);
}

.post-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.tag-post-card:hover .post-img {
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

.tag-post-card:hover .post-overlay {
    opacity: 1;
}

.post-date-overlay {
    align-self: flex-start;
}

.post-date-overlay time {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    font-size: 0.9rem;
    font-weight: 500;
    font-family: inherit;
}

.post-action-overlay {
    text-align: center;
}

.read-post-btn {
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

.tag-post-card:hover .read-post-btn {
    transform: translateY(0);
}

.read-post-btn:hover {
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

.post-tags-preview {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.post-tag {
    background: var(--bg-main);
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

.post-tag.current {
    background: var(--tag-color);
    color: white;
    border-color: var(--tag-color);
    position: relative;
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.post-tag.current::after {
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

.post-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.btn-read-full {
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

.btn-read-full:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 5px 15px rgba(31, 165, 71, 0.3);
}

.post-interactions {
    display: flex;
    gap: 0.5rem;
}

.interaction-btn {
    width: 45px;
    height: 45px;
    background: var(--bg-main);
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

.interaction-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.1);
}

.like-btn .like-count {
    font-size: 0.8rem;
    margin-left: 0.25rem;
    font-family: inherit;
}

.like-btn.liked {
    background: #FF4444;
    color: white;
    border-color: #FF4444;
}

.like-btn.liked i {
    color: white;
}

/* Enhanced Pagination */
.tag-pagination {
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
    background: var(--bg-secondary);
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
    background: var(--bg-secondary);
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
    background: var(--bg-main);
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
.tag-sidebar {
    position: sticky;
    top: calc(100px + 2rem);
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

body.admin-bar .tag-sidebar {
    top: calc(132px + 2rem);
}

@media screen and (max-width: 782px) {
    body.admin-bar .tag-sidebar {
        top: calc(116px + 2rem);
    }
}

.tag-sidebar .widget {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.tag-sidebar .widget:hover {
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

/* Tag Quick Info Widget */
.tag-quick-info .widget-content {
    text-align: center;
}

.quick-info-header {
    margin-bottom: 2rem;
}

.quick-info-header .tag-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--tag-color), var(--tag-color));
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

.tag-stats-detailed {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.stat-row:last-child {
    border-bottom: none;
}

.stat-label {
    color: var(--text-secondary);
    font-weight: 500;
    font-family: inherit;
}

.stat-value {
    color: var(--text-primary);
    font-weight: 700;
    font-family: inherit;
}

.tag-rss {
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

/* Tag Search Widget */
.tag-search-form .search-input-wrapper {
    position: relative;
    display: flex;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 2px solid var(--border-color);
    overflow: hidden;
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

/* Popular Tags Widget */
.tags-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    justify-content: center;
}

.popular-tag {
    background: var(--bg-secondary);
    color: var(--text-primary);
    padding: 0.5rem 1rem;
    text-decoration: none;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-weight: 500;
    font-family: inherit;
}

.popular-tag:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.popular-tag.current {
    background: var(--tag-color);
    color: white;
    border-color: var(--tag-color);
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

/* Related Posts Widget */
.related-posts-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.related-post-item {
    display: flex;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.related-post-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.related-rank {
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

.related-thumbnail {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
}

.related-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-content {
    flex: 1;
    min-width: 0;
}

.related-title {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    line-height: 1.4;
    font-family: inherit;
}

.related-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-title a:hover {
    color: var(--primary-color);
}

.related-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.related-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-family: inherit;
}

.no-related-posts {
    color: var(--text-muted);
    text-align: center;
    padding: 2rem;
    font-style: italic;
    font-family: inherit;
}

/* Tag Analytics Widget */
.analytics-stats {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.analytics-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.analytics-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.analytics-content {
    flex: 1;
}

.analytics-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.analytics-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.tag-usage-chart {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.chart-bar {
    width: 100%;
    height: 10px;
    background: var(--border-color);
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.chart-progress {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    border-radius: 5px;
    transition: width 1s ease;
}

.chart-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    text-align: center;
    font-family: inherit;
}

/* Tag Newsletter Widget */
.tag-newsletter-widget {
    background: linear-gradient(135deg, #667eea, #f093fb) !important;
    color: white;
    border: none !important;
}

.tag-newsletter-widget .widget-title {
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
    margin: 0;
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

.newsletter-note {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.85rem;
    opacity: 0.8;
    line-height: 1.4;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-family: inherit;
}

.newsletter-note i {
    flex-shrink: 0;
    margin-top: 0.1rem;
    opacity: 0.7;
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
    
    .posts-grid.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
}

@media (max-width: 1024px) {
    .content-layout {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .tag-sidebar {
        position: static;
        order: -1;
    }
    
    .posts-grid.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .tag-archive-main {
        padding-top: 70px;
    }
    
    body.admin-bar .tag-archive-main {
        padding-top: 102px;
    }
    
    .tag-hero {
        padding: 3rem 0;
    }
    
    .tag-title {
        font-size: 2rem;
    }
    
    .tag-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .posts-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .posts-meta {
        justify-content: center;
    }
    
    .posts-grid.grid-view {
        grid-template-columns: 1fr;
    }
    
    .posts-grid.list-view .tag-post-card {
        flex-direction: column;
    }
    
    .posts-grid.list-view .post-image {
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
    .tag-hero {
        padding: 2rem 0;
    }
    
    .tag-title {
        font-size: 1.7rem;
    }
    
    .tag-description {
        font-size: 1rem;
    }
    
    .tag-stats {
        grid-template-columns: 1fr;
    }
    
    .tag-info-box {
        padding: 2rem 1.5rem;
    }
    
    .tag-posts-container {
        padding: 2rem 1.5rem;
    }
    
    .post-content {
        padding: 1.5rem;
    }
    
    .tag-stats .stat-item {
        padding: 1rem;
    }
    
    .related-post-item {
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
                postsContainer.className = `posts-grid ${view}-view`;
                
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
                    showToast('لینک کپی شد!');
                });
            }
        });
    });
    
    // Like functionality
    const likeBtns = document.querySelectorAll('.like-btn');
    likeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const isLiked = this.classList.contains('liked');
            const countSpan = this.querySelector('.like-count');
            let count = parseInt(countSpan.textContent) || 0;
            
            if (isLiked) {
                this.classList.remove('liked');
                this.innerHTML = '<i class="far fa-heart"></i><span class="like-count">' + Math.max(0, count - 1) + '</span>';
                removeLike(postId);
                showToast('پسند برداشته شد');
            } else {
                this.classList.add('liked');
                this.innerHTML = '<i class="fas fa-heart"></i><span class="like-count">' + (count + 1) + '</span>';
                addLike(postId);
                showToast('پسندیده شد!');
            }
        });
    });
    
    // Newsletter subscription
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('.newsletter-input').value;
            const tagId = this.getAttribute('data-tag');
            const submitBtn = this.querySelector('.newsletter-submit');
            
            submitBtn.classList.add('loading');
            
            // Simulate API call
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                showToast('با موفقیت در اطلاع‌رسانی عضو شدید!');
                this.reset();
            }, 2000);
        });
    });
    
    // Search form enhancements
    const searchForms = document.querySelectorAll('.tag-search-form');
    searchForms.forEach(form => {
        const searchInput = form.querySelector('.search-input');
        
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
    document.querySelectorAll('.tag-post-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Animate sidebar widgets
    document.querySelectorAll('.tag-sidebar .widget').forEach((widget, index) => {
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(30px)';
        widget.style.transition = `opacity 0.6s ease ${index * 0.2}s, transform 0.6s ease ${index * 0.2}s`;
        observer.observe(widget);
    });
    
    // Animate usage chart
    const chartProgress = document.querySelector('.chart-progress');
    if (chartProgress) {
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const width = entry.target.style.width;
                    entry.target.style.width = '0%';
                    setTimeout(() => {
                        entry.target.style.width = width;
                    }, 500);
                }
            });
        }, { threshold: 0.5 });
        
        progressObserver.observe(chartProgress);
    }
    
    // Utility functions
    function showToast(message) {
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
    
    function addLike(postId) {
        const likes = JSON.parse(localStorage.getItem('likedPosts') || '[]');
        if (!likes.includes(postId)) {
            likes.push(postId);
            localStorage.setItem('likedPosts', JSON.stringify(likes));
        }
    }
    
    function removeLike(postId) {
        const likes = JSON.parse(localStorage.getItem('likedPosts') || '[]');
        const index = likes.indexOf(postId);
        if (index > -1) {
            likes.splice(index, 1);
            localStorage.setItem('likedPosts', JSON.stringify(likes));
        }
    }
    
    // Initialize likes
    const likes = JSON.parse(localStorage.getItem('likedPosts') || '[]');
    likeBtns.forEach(btn => {
        const postId = btn.getAttribute('data-post-id');
        if (likes.includes(postId)) {
            btn.classList.add('liked');
            const countSpan = btn.querySelector('.like-count');
            btn.innerHTML = '<i class="fas fa-heart"></i>' + countSpan.outerHTML;
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