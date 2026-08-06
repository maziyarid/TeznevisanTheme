<?php
/*
Template Name: Categories Hub
*/
get_header();
?>

<main id="main-content" class="categories-hub-main">
    
    <!-- Categories Hub Hero -->
    <section class="categories-hero">
        <div class="hero-background">
            <div class="hero-grid">
                <?php for ($i = 1; $i <= 20; $i++): ?>
                    <div class="grid-cell cell-<?php echo $i; ?>"></div>
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
                            <span itemprop="name">دسته‌بندی‌ها</span>
                            <meta itemprop="position" content="3" />
                        </li>
                    </ol>
                </nav>
                
                <div class="hero-info">
                    <div class="hero-badge">
                        <i class="fas fa-folder-tree"></i>
                        <span>مرکز دسته‌بندی‌های مقالات</span>
                    </div>
                    
                    <h1 class="hero-title">
                        دسته‌بندی‌های
                        <span class="highlight-text">مقالات تزنویسان</span>
                    </h1>
                    
                    <p class="hero-description">
                        مجموعه کاملی از دسته‌بندی‌های تخصصی مقالات ما که به موضوعات مختلف علمی، 
                        آکادمیک و کاربردی می‌پردازد. هر دسته‌بندی شامل مقالات متخصصانه و با کیفیت است.
                    </p>
                    
                    <?php
                    $categories = get_categories(array('hide_empty' => false));
                    $total_posts = wp_count_posts()->publish;
                    $total_categories = count($categories);
                    $total_views = 0;
                    
                    // Calculate total views across all categories
                    foreach ($categories as $category) {
                        $cat_posts = get_posts(array(
                            'category' => $category->term_id,
                            'numberposts' => -1,
                            'post_status' => 'publish'
                        ));
                        foreach ($cat_posts as $post) {
                            $total_views += (int)get_post_meta($post->ID, 'post_views', true);
                        }
                    }
                    ?>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <i class="fas fa-folder-open"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $total_categories; ?></span>
                                <span class="stat-label">دسته‌بندی</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo number_format($total_posts); ?></span>
                                <span class="stat-label">مقاله</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-eye"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo number_format($total_views); ?></span>
                                <span class="stat-label">بازدید</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-calendar"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo date('Y') - 2020; ?>+</span>
                                <span class="stat-label">سال فعالیت</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="categories-illustration">
                        <div class="illustration-bg">
                            <div class="category-nodes">
                                <?php 
                                $featured_cats = array_slice($categories, 0, 6);
                                $positions = [
                                    ['top' => '20%', 'left' => '20%'],
                                    ['top' => '30%', 'left' => '70%'],
                                    ['top' => '50%', 'left' => '15%'],
                                    ['top' => '65%', 'left' => '75%'],
                                    ['top' => '80%', 'left' => '35%'],
                                    ['top' => '15%', 'left' => '55%']
                                ];
                                
                                foreach ($featured_cats as $index => $cat):
                                    $position = $positions[$index] ?? $positions[0];
                                    $cat_color = get_term_meta($cat->term_id, 'category_color', true) ?: '#1FA547';
                                ?>
                                    <div class="category-node" 
                                         style="top: <?php echo $position['top']; ?>; 
                                                left: <?php echo $position['left']; ?>;
                                                --node-color: <?php echo $cat_color; ?>">
                                        <span class="node-name"><?php echo esc_html($cat->name); ?></span>
                                        <span class="node-count"><?php echo $cat->count; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="illustration-center">
                            <div class="center-icon">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <span class="center-text">دسته‌بندی‌ها</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Search & Filter -->
    <section class="categories-filter-section">
        <div class="container">
            <div class="filter-controls">
                <div class="search-container">
                    <div class="search-wrapper">
                        <input type="text" 
                               id="categories-search" 
                               placeholder="جستجو در دسته‌بندی‌ها..."
                               class="search-input">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="search-suggestions" id="search-suggestions"></div>
                </div>
                
                <div class="filter-options">
                    <div class="sort-control">
                        <label for="categories-sort">مرتب‌سازی:</label>
                        <select id="categories-sort">
                            <option value="count-desc">پرمحتواترین</option>
                            <option value="count-asc">کم‌محتواترین</option>
                            <option value="name-asc">الفبایی (الف-ی)</option>
                            <option value="name-desc">الفبایی (ی-الف)</option>
                            <option value="recent">جدیدترین مقالات</option>
                        </select>
                    </div>
                    
                    <div class="view-control">
                        <button class="view-btn active" data-view="grid" title="نمایش شبکه‌ای">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" data-view="list" title="نمایش فهرستی">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                
                <div class="filter-stats">
                    <span class="results-count">
                        <i class="fas fa-layer-group"></i>
                        <span id="visible-count"><?php echo $total_categories; ?></span> دسته‌بندی
                    </span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Grid -->
    <section class="categories-grid-section">
        <div class="container">
            <div class="categories-container grid-view" id="categories-container">
                <?php 
                $category_colors = [
                    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
                    '#FFEAA7', '#DDA0DD', '#74B9FF', '#FD79A8',
                    '#A29BFE', '#6C5CE7', '#00B894', '#00CEC9',
                    '#FDCB6E', '#E17055', '#81ECEC', '#FAB1A0'
                ];
                
                foreach ($categories as $index => $category):
                    $color = $category_colors[$index % count($category_colors)];
                    $cat_posts = get_posts(array(
                        'category' => $category->term_id,
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ));
                    
                    $cat_views = 0;
                    $latest_post_date = '';
                    foreach ($cat_posts as $post) {
                        $cat_views += (int)get_post_meta($post->ID, 'post_views', true);
                        if (empty($latest_post_date) || get_the_date('Y-m-d', $post) > $latest_post_date) {
                            $latest_post_date = get_the_date('Y-m-d', $post);
                        }
                    }
                ?>
                    <article class="category-card" 
                             style="--category-color: <?php echo $color; ?>"
                             data-name="<?php echo esc_attr(strtolower($category->name)); ?>"
                             data-count="<?php echo $category->count; ?>"
                             data-views="<?php echo $cat_views; ?>"
                             data-latest="<?php echo $latest_post_date; ?>">
                        
                        <div class="category-background">
                            <div class="category-pattern"></div>
                            <div class="category-gradient"></div>
                        </div>
                        
                        <div class="category-header">
                            <div class="category-icon-wrapper">
                                <div class="category-icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <div class="icon-pulse"></div>
                            </div>
                            
                            <h3 class="category-title">
                                <a href="<?php echo get_category_link($category); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </h3>
                            
                            <?php if ($category->description): ?>
                                <p class="category-description">
                                    <?php echo wp_trim_words($category->description, 20, '...'); ?>
                                </p>
                            <?php else: ?>
                                <p class="category-description">
                                    مجموعه مقالات تخصصی در زمینه <?php echo esc_html($category->name); ?> 
                                    با محتوای کیفی و به‌روز
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="category-stats">
                            <div class="stat-grid">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="stat-info">
                                        <span class="stat-number"><?php echo $category->count; ?></span>
                                        <span class="stat-label">مقاله</span>
                                    </div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="stat-info">
                                        <span class="stat-number"><?php echo number_format($cat_views); ?></span>
                                        <span class="stat-label">بازدید</span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($latest_post_date): ?>
                                <div class="last-activity">
                                    <i class="fas fa-clock"></i>
                                    <span>آخرین فعالیت: <?php echo date_i18n('j F Y', strtotime($latest_post_date)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Recent Posts Preview -->
                        <div class="category-preview">
                            <h4 class="preview-title">
                                <i class="fas fa-newspaper"></i>
                                آخرین مقالات
                            </h4>
                            
                            <?php if ($cat_posts): ?>
                                <div class="preview-posts">
                                    <?php foreach (array_slice($cat_posts, 0, 3) as $post): ?>
                                        <div class="preview-post">
                                            <a href="<?php echo get_permalink($post); ?>" class="preview-link">
                                                <span class="preview-title-text"><?php echo esc_html(get_the_title($post)); ?></span>
                                                <span class="preview-date"><?php echo get_the_date('j M', $post); ?></span>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="no-posts-preview">
                                    <span>هنوز مقاله‌ای منتشر نشده</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="category-actions">
                            <a href="<?php echo get_category_link($category); ?>" class="btn-primary">
                                <i class="fas fa-eye"></i>
                                مشاهده همه مقالات
                            </a>
                            
                            <div class="category-tools">
                                <button class="tool-btn rss-btn" 
                                        data-feed="<?php echo get_category_feed_link($category->term_id); ?>"
                                        title="خورد RSS">
                                    <i class="fas fa-rss"></i>
                                </button>
                                <button class="tool-btn share-btn" 
                                        data-url="<?php echo get_category_link($category); ?>"
                                        data-title="دسته‌بندی <?php echo esc_attr($category->name); ?>"
                                        title="اشتراک‌گذاری">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Categories Analytics -->
            <div class="categories-analytics">
                <div class="analytics-header">
                    <h2 class="analytics-title">
                        <i class="fas fa-chart-pie"></i>
                        آمار کلی دسته‌بندی‌ها
                    </h2>
                </div>
                
                <div class="analytics-grid">
                    <div class="analytics-card">
                        <div class="analytics-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="analytics-content">
                            <h4>کل دسته‌بندی‌ها</h4>
                            <div class="analytics-number"><?php echo $total_categories; ?></div>
                            <div class="analytics-detail">شامل زیردسته‌ها</div>
                        </div>
                    </div>
                    
                    <div class="analytics-card">
                        <div class="analytics-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="analytics-content">
                            <h4>مجموع مقالات</h4>
                            <div class="analytics-number"><?php echo number_format($total_posts); ?></div>
                            <div class="analytics-detail">در همه دسته‌ها</div>
                        </div>
                    </div>
                    
                    <div class="analytics-card">
                        <div class="analytics-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="analytics-content">
                            <h4>کل بازدیدها</h4>
                            <div class="analytics-number"><?php echo number_format($total_views); ?></div>
                            <div class="analytics-detail">از ابتدای فعالیت</div>
                        </div>
                    </div>
                    
                    <?php
                    // Most popular category
                    $popular_cat = $categories[0];
                    foreach ($categories as $cat) {
                        if ($cat->count > $popular_cat->count) {
                            $popular_cat = $cat;
                        }
                    }
                    ?>
                    
                    <div class="analytics-card">
                        <div class="analytics-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="analytics-content">
                            <h4>محبوب‌ترین دسته</h4>
                            <div class="analytics-number"><?php echo esc_html($popular_cat->name); ?></div>
                            <div class="analytics-detail"><?php echo $popular_cat->count; ?> مقاله</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Categories -->
            <div class="top-categories-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-fire"></i>
                        محبوب‌ترین دسته‌بندی‌ها
                    </h2>
                    <p class="section-description">دسته‌بندی‌هایی که بیشترین مقاله و بازدید را دارند</p>
                </div>
                
                <div class="top-categories-list">
                    <?php
                    $top_categories = array_slice($categories, 0, 8);
                    usort($top_categories, function($a, $b) {
                        return $b->count - $a->count;
                    });
                    
                    foreach ($top_categories as $rank => $top_cat):
                        $rank_color = $category_colors[$rank % count($category_colors)];
                        $cat_posts_count = $top_cat->count;
                        $cat_posts_recent = get_posts(array(
                            'category' => $top_cat->term_id,
                            'numberposts' => 1,
                            'post_status' => 'publish'
                        ));
                        $last_post_date = $cat_posts_recent ? get_the_date('Y-m-d', $cat_posts_recent[0]) : '';
                    ?>
                        <div class="top-category-item" style="--rank-color: <?php echo $rank_color; ?>">
                            <div class="rank-badge">
                                <span class="rank-number"><?php echo $rank + 1; ?></span>
                            </div>
                            
                            <div class="category-info">
                                <h3 class="category-name">
                                    <a href="<?php echo get_category_link($top_cat); ?>">
                                        <?php echo esc_html($top_cat->name); ?>
                                    </a>
                                </h3>
                                
                                <?php if ($top_cat->description): ?>
                                    <p class="category-desc">
                                        <?php echo wp_trim_words($top_cat->description, 15); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="category-metrics">
                                    <span class="metric">
                                        <i class="fas fa-file-alt"></i>
                                        <?php echo $cat_posts_count; ?> مقاله
                                    </span>
                                    <?php if ($last_post_date): ?>
                                        <span class="metric">
                                            <i class="fas fa-calendar"></i>
                                            آخرین: <?php echo date_i18n('j M', strtotime($last_post_date)); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="category-chart">
                                <div class="chart-circle">
                                    <div class="chart-progress" 
                                         style="--progress: <?php echo min(100, ($cat_posts_count / max(1, $popular_cat->count)) * 100); ?>%">
                                        <span class="chart-percentage"><?php echo round(($cat_posts_count / max(1, $total_posts)) * 100, 1); ?>%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="category-action">
                                <a href="<?php echo get_category_link($top_cat); ?>" class="explore-btn">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Network -->
    <section class="categories-network-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-project-diagram"></i>
                    شبکه دسته‌بندی‌ها
                </h2>
                <p class="section-description">ارتباط و سلسله‌مراتب دسته‌بندی‌های مختلف</p>
            </div>
            
            <div class="network-visualization">
                <div class="network-container">
                    <?php
                    // Get categories with hierarchy
                    $hierarchical_cats = get_categories(array(
                        'hide_empty' => true,
                        'orderby' => 'count',
                        'order' => 'DESC'
                    ));
                    
                    $parent_cats = array_filter($hierarchical_cats, function($cat) {
                        return $cat->parent == 0;
                    });
                    
                    foreach (array_slice($parent_cats, 0, 6) as $parent_index => $parent_cat):
                        $children = array_filter($hierarchical_cats, function($cat) use ($parent_cat) {
                            return $cat->parent == $parent_cat->term_id;
                        });
                        
                        $parent_color = $category_colors[$parent_index % count($category_colors)];
                    ?>
                        <div class="network-group">
                            <div class="parent-node" style="--node-color: <?php echo $parent_color; ?>">
                                <a href="<?php echo get_category_link($parent_cat); ?>" class="node-link">
                                    <div class="node-content">
                                        <span class="node-name"><?php echo esc_html($parent_cat->name); ?></span>
                                        <span class="node-count"><?php echo $parent_cat->count; ?> مقاله</span>
                                    </div>
                                </a>
                                
                                <?php if ($children): ?>
                                    <div class="child-connections">
                                        <?php foreach (array_slice($children, 0, 4) as $child_index => $child): ?>
                                            <div class="connection-line" style="--delay: <?php echo $child_index * 0.2; ?>s"></div>
                                            <div class="child-node" style="--delay: <?php echo $child_index * 0.2; ?>s">
                                                <a href="<?php echo get_category_link($child); ?>" class="child-link">
                                                    <span class="child-name"><?php echo esc_html($child->name); ?></span>
                                                    <span class="child-count"><?php echo $child->count; ?></span>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <?php if (count($children) > 4): ?>
                                            <div class="more-children" style="--delay: 0.8s">
                                                <span>+<?php echo count($children) - 4; ?> بیشتر</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Categories Hub Comprehensive Styles */
.categories-hub-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
    font-family: inherit;
}

/* Admin bar adjustments */
body.admin-bar .categories-hub-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .categories-hub-main {
        padding-top: 116px;
    }
}

/* Categories Hero */
.categories-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #667eea 100%);
    color: white;
    padding: 5rem 0;
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

.hero-grid {
    position: absolute;
    width: 100%;
    height: 100%;
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    grid-template-rows: repeat(10, 1fr);
    opacity: 0.1;
}

.grid-cell {
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: gridPulse 4s ease-in-out infinite;
}

.grid-cell:nth-child(3n) { animation-delay: 0.5s; }
.grid-cell:nth-child(5n) { animation-delay: 1s; }
.grid-cell:nth-child(7n) { animation-delay: 1.5s; }

@keyframes gridPulse {
    0%, 100% { background: transparent; }
    50% { background: rgba(255, 255, 255, 0.1); }
}

.hero-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.hero-badge {
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
    font-family: inherit;
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    font-family: inherit;
}

.highlight-text {
    background: linear-gradient(45deg, #FFD700, #FFA500, #FF6347);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.hero-description {
    font-size: 1.2rem;
    line-height: 1.8;
    margin-bottom: 3rem;
    opacity: 0.95;
    font-family: inherit;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 2rem;
}

.hero-stats .stat-item {
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

.hero-stats .stat-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.hero-stats .stat-item i {
    font-size: 2rem;
    color: #FFD700;
    filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.5));
}

.hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
}

.categories-illustration {
    width: 320px;
    height: 320px;
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

.category-nodes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.category-node {
    position: absolute;
    background: var(--node-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    animation: nodeFloat 6s ease-in-out infinite;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    font-family: inherit;
}

@keyframes nodeFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.8; }
    50% { transform: translateY(-15px) rotate(5deg); opacity: 1; }
}

.node-name {
    font-size: 0.7rem;
    white-space: nowrap;
    font-family: inherit;
}

.node-count {
    font-size: 0.6rem;
    opacity: 0.8;
    font-family: inherit;
}

.illustration-center {
    position: relative;
    z-index: 10;
    text-align: center;
}

.center-icon {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    margin: 0 auto 1rem;
    animation: centerPulse 3s ease-in-out infinite;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

@keyframes centerPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); box-shadow: 0 0 30px rgba(255, 255, 255, 0.5); }
}

.center-text {
    font-size: 1.2rem;
    font-weight: 600;
    font-family: inherit;
}

/* Categories Filter Section */
.categories-filter-section {
    background: var(--bg-main);
    padding: 3rem 0;
    border-bottom: 1px solid var(--border-color);
}

.filter-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.search-container {
    flex: 1;
    max-width: 500px;
    position: relative;
}

.search-wrapper {
    display: flex;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 2px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.search-input {
    flex: 1;
    padding: 1.25rem 1.5rem;
    border: none;
    background: transparent;
    font-family: inherit;
    color: var(--text-primary);
    font-size: 1rem;
}

.search-input:focus {
    outline: none;
}

.search-btn {
    padding: 1.25rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
    font-size: 1rem;
}

.search-btn:hover {
    background: var(--primary-dark);
}

.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    margin-top: 0.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    z-index: 100;
    display: none;
}

.filter-options {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.sort-control {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sort-control label {
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.sort-control select {
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 0.9rem;
    min-width: 180px;
    transition: all 0.3s ease;
}

.sort-control select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.view-control {
    display: flex;
    gap: 0.5rem;
    background: var(--bg-secondary);
    padding: 0.5rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.view-btn {
    width: 50px;
    height: 50px;
    background: transparent;
    color: var(--text-primary);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.filter-stats {
    color: var(--text-secondary);
    font-weight: 500;
    background: var(--bg-secondary);
    padding: 1rem 1.5rem;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.results-count {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Categories Grid */
.categories-grid-section {
    padding: 5rem 0;
}

.categories-container {
    display: grid;
    gap: 2rem;
    margin-bottom: 5rem;
}

.categories-container.grid-view {
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
}

.categories-container.list-view {
    grid-template-columns: 1fr;
}

.categories-container.list-view .category-card {
    display: flex;
    align-items: stretch;
    gap: 2rem;
    max-height: 300px;
}

.categories-container.list-view .category-header {
    flex: 1;
}

.categories-container.list-view .category-stats,
.categories-container.list-view .category-preview {
    flex: 1;
}

/* Enhanced Category Cards */
.category-card {
    background: var(--bg-main);
    border-radius: 25px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.category-card:hover {
    transform: translateY(-15px) rotateX(2deg);
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
}

.category-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.category-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, var(--category-color) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, var(--category-color) 0%, transparent 50%);
    opacity: 0.05;
}

.category-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--category-color), transparent);
}

.category-header {
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.category-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 2rem;
}

.category-icon {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, var(--category-color), var(--category-color));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    position: relative;
    z-index: 1;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1) rotateY(10deg);
}

.icon-pulse {
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
    border: 3px solid var(--category-color);
    border-radius: 50%;
    animation: iconPulse 3s infinite;
    opacity: 0.6;
}

@keyframes iconPulse {
    0% { transform: scale(1); opacity: 0.6; }
    70% { transform: scale(1.3); opacity: 0; }
    100% { transform: scale(1.3); opacity: 0; }
}

.category-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    font-family: inherit;
}

.category-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-title a:hover {
    color: var(--category-color);
}

.category-description {
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
    font-family: inherit;
}

.category-stats {
    padding: 2rem;
    border-top: 1px solid var(--border-color);
    position: relative;
    z-index: 2;
}

.stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-secondary);
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.stat-icon {
    width: 40px;
    height: 40px;
    background: var(--category-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.last-activity {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
    color: var(--text-muted);
    font-size: 0.85rem;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.category-preview {
    padding: 2rem;
    border-top: 1px solid var(--border-color);
    position: relative;
    z-index: 2;
}

.preview-title {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.preview-posts {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.preview-post {
    background: var(--bg-secondary);
    border-radius: 10px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.preview-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    font-family: inherit;
}

.preview-link:hover {
    background: rgba(31, 165, 71, 0.05);
    color: var(--primary-color);
}

.preview-title-text {
    flex: 1;
    font-weight: 500;
    font-size: 0.9rem;
    line-height: 1.3;
    margin-left: 1rem;
}

.preview-date {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 500;
    background: var(--bg-main);
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-family: inherit;
}

.no-posts-preview {
    text-align: center;
    color: var(--text-muted);
    padding: 2rem;
    font-style: italic;
    font-family: inherit;
}

.category-actions {
    padding: 2rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 2;
}

.btn-primary {
    background: var(--category-color);
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

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    color: white;
    filter: brightness(1.1);
}

.category-tools {
    display: flex;
    gap: 0.5rem;
}

.tool-btn {
    width: 40px;
    height: 40px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.tool-btn:hover {
    background: var(--category-color);
    color: white;
    border-color: var(--category-color);
    transform: scale(1.1);
}

/* Categories Analytics */
.categories-analytics {
    background: var(--bg-main);
    border-radius: 25px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
    margin-bottom: 5rem;
}

.analytics-header {
    text-align: center;
    margin-bottom: 3rem;
}

.analytics-title {
    color: var(--text-primary);
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    font-family: inherit;
}

.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.analytics-card {
    background: var(--bg-secondary);
    padding: 2.5rem 2rem;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.analytics-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(31, 165, 71, 0.05), transparent);
    transition: left 0.6s ease;
}

.analytics-card:hover::before {
    left: 100%;
}

.analytics-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(31, 165, 71, 0.15);
    border-color: var(--primary-color);
}

.analytics-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
    transition: all 0.3s ease;
}

.analytics-card:hover .analytics-icon {
    transform: scale(1.1) rotateY(15deg);
}

.analytics-content h4 {
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0 0 1rem 0;
    font-family: inherit;
}

.analytics-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    display: block;
    font-family: inherit;
}

.analytics-detail {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-family: inherit;
}

/* Top Categories Section */
.top-categories-section {
    background: var(--bg-main);
    border-radius: 25px;
    padding: 4rem 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
    margin-bottom: 5rem;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

                            <meta itemprop="position" content="1" />
                        </li>
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" itemprop="item">
                                <span itemprop="name">وبلاگ</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name">برچسب‌ها</span>
                            <meta itemprop="position" content="3" />
                        </li>
                    </ol>
                </nav>
                
                <div class="hero-info">
                    <div class="hero-badge">
                        <i class="fas fa-hashtag"></i>
                        <span>مرکز برچسب‌های مقالات</span>
                    </div>
                    
                    <h1 class="hero-title">
                        برچسب‌های
                        <span class="highlight-text">مقالات تزنویسان</span>
                    </h1>
                    
                    <p class="hero-description">
                        مجموعه کاملی از برچسب‌های موضوعی که برای دسته‌بندی دقیق‌تر مقالات استفاده می‌شود. 
                        هر برچسب نشان‌دهنده موضوع یا مفهوم خاصی است که در مقالات مورد بررسی قرار گرفته.
                    </p>
                    
<?php
                    $tags = get_tags(array('hide_empty' => false));
                    $total_posts = wp_count_posts()->publish;
                    $total_tags = count($tags);
                    $total_tag_usage = 0;
                    
                    // Calculate total tag usage
                    foreach ($tags as $tag) {
                        $total_tag_usage += $tag->count;
                    }
                    ?>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <i class="fas fa-hashtag"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $total_tags; ?></span>
                                <span class="stat-label">برچسب</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo number_format($total_posts); ?></span>
                                <span class="stat-label">مقاله</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-tags"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo number_format($total_tag_usage); ?></span>
                                <span class="stat-label">کل استفاده</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-chart-line"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $total_posts > 0 ? round($total_tag_usage / $total_posts, 1) : 0; ?></span>
                                <span class="stat-label">میانگین برچسب</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="tags-cloud-visual">
                        <div class="cloud-container">
                            <?php
                            $featured_tags = array_slice($tags, 0, 15);
                            $max_count = $featured_tags[0]->count ?? 1;
                            $min_count = end($featured_tags)->count ?? 1;
                            
                            $positions = [
                                ['top' => '10%', 'left' => '20%'],
                                ['top' => '25%', 'left' => '70%'],
                                ['top' => '40%', 'left' => '15%'],
                                ['top' => '55%', 'left' => '80%'],
                                ['top' => '70%', 'left' => '25%'],
                                ['top' => '85%', 'left' => '65%'],
                                ['top' => '15%', 'left' => '50%'],
                                ['top' => '30%', 'left' => '90%'],
                                ['top' => '45%', 'left' => '5%'],
                                ['top' => '60%', 'left' => '45%'],
                                ['top' => '75%', 'left' => '85%'],
                                ['top' => '90%', 'left' => '35%'],
                                ['top' => '20%', 'left' => '75%'],
                                ['top' => '50%', 'left' => '60%'],
                                ['top' => '80%', 'left' => '10%']
                            ];
                            
                            foreach ($featured_tags as $index => $tag):
                                $position = $positions[$index] ?? $positions[0];
                                $size_ratio = ($tag->count - $min_count) / max(1, ($max_count - $min_count));
                                $font_size = 0.7 + ($size_ratio * 0.8);
                                $opacity = 0.6 + ($size_ratio * 0.4);
                            ?>
                                <div class="cloud-tag" 
                                     style="top: <?php echo $position['top']; ?>; 
                                            left: <?php echo $position['left']; ?>;
                                            font-size: <?php echo $font_size; ?>rem;
                                            opacity: <?php echo $opacity; ?>">
                                    <a href="<?php echo get_tag_link($tag); ?>" class="tag-link">
                                        #<?php echo esc_html($tag->name); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="cloud-center">
                            <div class="center-icon">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <span class="center-text">برچسب‌ها</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Tags Filter & Search -->
    <section class="tags-filter-section">
        <div class="container">
            <div class="filter-controls">
                <div class="search-container">
                    <div class="search-wrapper">
                        <input type="text" 
                               id="tags-search" 
                               placeholder="جستجو در برچسب‌ها..."
                               class="search-input">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="search-results-info">
                        <span id="search-results-count"><?php echo $total_tags; ?></span> برچسب یافت شد
                    </div>
                </div>
                
                <div class="filter-options">
                    <div class="sort-control">
                        <label for="tags-sort">مرتب‌سازی:</label>
                        <select id="tags-sort">
                            <option value="count-desc">پراستفاده‌ترین</option>
                            <option value="count-asc">کم‌استفاده‌ترین</option>
                            <option value="name-asc">الفبایی (الف-ی)</option>
                            <option value="name-desc">الفبایی (ی-الف)</option>
                            <option value="recent">جدیدترین</option>
                        </select>
                    </div>
                    
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">همه</button>
                        <button class="filter-btn" data-filter="popular">محبوب</button>
                        <button class="filter-btn" data-filter="recent">جدید</button>
                        <button class="filter-btn" data-filter="unused">بدون مقاله</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Tags Cloud Interactive -->
    <section class="tags-cloud-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-cloud"></i>
                    ابر برچسب‌های تعاملی
                </h2>
                <p class="section-description">برچسب‌ها بر اساس میزان استفاده اندازه‌گذاری شده‌اند</p>
            </div>
            
            <div class="interactive-tags-cloud" id="interactive-cloud">
                <?php
                usort($tags, function($a, $b) {
                    return $b->count - $a->count;
                });
                
                $max_count = $tags[0]->count ?? 1;
                $min_count = end($tags)->count ?? 1;
                
                foreach ($tags as $tag):
                    $size_ratio = ($tag->count - $min_count) / max(1, ($max_count - $min_count));
                    $font_size = 0.8 + ($size_ratio * 1.5); // 0.8rem to 2.3rem
                    $popularity = $tag->count >= ($max_count * 0.7) ? 'high' : ($tag->count >= ($max_count * 0.3) ? 'medium' : 'low');
                ?>
                    <a href="<?php echo get_tag_link($tag); ?>" 
                       class="interactive-tag <?php echo $popularity; ?>"
                       style="font-size: <?php echo $font_size; ?>rem;"
                       data-name="<?php echo esc_attr(strtolower($tag->name)); ?>"
                       data-count="<?php echo $tag->count; ?>"
                       data-popularity="<?php echo $popularity; ?>"
                       title="<?php echo $tag->count; ?> مقاله">
                        #<?php echo esc_html($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <!-- Cloud Legend -->
            <div class="cloud-legend">
                <div class="legend-item">
                    <span class="legend-indicator high"></span>
                    <span class="legend-text">پراستفاده (بیش از ۷۰% محبوبیت)</span>
                </div>
                <div class="legend-item">
                    <span class="legend-indicator medium"></span>
                    <span class="legend-text">متوسط (۳۰-۷۰% محبوبیت)</span>
                </div>
                <div class="legend-item">
                    <span class="legend-indicator low"></span>
                    <span class="legend-text">کم‌استفاده (کمتر از ۳۰% محبوبیت)</span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Top Tags List -->
    <section class="top-tags-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-fire"></i>
                    محبوب‌ترین برچسب‌ها
                </h2>
                <p class="section-description">برچسب‌هایی که بیشترین استفاده را در مقالات دارند</p>
            </div>
            
            <div class="top-tags-grid">
                <?php
                $top_tags = array_slice($tags, 0, 12);
                $tag_colors = [
                    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
                    '#FFEAA7', '#DDA0DD', '#74B9FF', '#FD79A8',
                    '#A29BFE', '#6C5CE7', '#00B894', '#00CEC9'
                ];
                
                foreach ($top_tags as $index => $top_tag):
                    $color = $tag_colors[$index % count($tag_colors)];
                    $percentage = $max_count > 0 ? round(($top_tag->count / $max_count) * 100) : 0;
                    
                    // Get recent posts with this tag
                    $tag_posts = get_posts(array(
                        'tag' => $top_tag->slug,
                        'numberposts' => 3,
                        'post_status' => 'publish'
                    ));
                ?>
                    <div class="top-tag-card" 
                         style="--tag-color: <?php echo $color; ?>"
                         data-name="<?php echo esc_attr(strtolower($top_tag->name)); ?>"
                         data-count="<?php echo $top_tag->count; ?>"
                         data-popularity="<?php echo $percentage >= 70 ? 'high' : ($percentage >= 30 ? 'medium' : 'low'); ?>">
                        
                        <div class="tag-card-header">
                            <div class="tag-rank">
                                <span class="rank-number"><?php echo $index + 1; ?></span>
                            </div>
                            
                            <div class="tag-info">
                                <h3 class="tag-name">
                                    <a href="<?php echo get_tag_link($top_tag); ?>">
                                        #<?php echo esc_html($top_tag->name); ?>
                                    </a>
                                </h3>
                                
                                <?php if ($top_tag->description): ?>
                                    <p class="tag-description">
                                        <?php echo wp_trim_words($top_tag->description, 15); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="tag-stats-mini">
                                <div class="usage-circle">
                                    <div class="usage-progress" style="--usage: <?php echo $percentage; ?>%">
                                        <span class="usage-text"><?php echo $percentage; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tag-metrics">
                            <div class="metric-item">
                                <i class="fas fa-file-alt"></i>
                                <span class="metric-value"><?php echo $top_tag->count; ?></span>
                                <span class="metric-label">مقاله</span>
                            </div>
                            
                            <?php
                            $tag_views = 0;
                            foreach ($tag_posts as $post) {
                                $tag_views += (int)get_post_meta($post->ID, 'post_views', true);
                            }
                            ?>
                            
                            <div class="metric-item">
                                <i class="fas fa-eye"></i>
                                <span class="metric-value"><?php echo number_format($tag_views); ?></span>
                                <span class="metric-label">بازدید</span>
                            </div>
                            
                            <?php if ($tag_posts): ?>
                                <div class="metric-item">
                                    <i class="fas fa-calendar"></i>
                                    <span class="metric-value"><?php echo get_the_date('j M', $tag_posts[0]); ?></span>
                                    <span class="metric-label">آخرین</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Recent Posts Preview -->
                        <?php if ($tag_posts): ?>
                            <div class="tag-recent-posts">
                                <h4 class="recent-title">
                                    <i class="fas fa-clock"></i>
                                    آخرین مقالات
                                </h4>
                                <div class="recent-list">
                                    <?php foreach ($tag_posts as $post): ?>
                                        <div class="recent-item">
                                            <a href="<?php echo get_permalink($post); ?>" class="recent-link">
                                                <span class="recent-post-title"><?php echo esc_html(wp_trim_words(get_the_title($post), 6)); ?></span>
                                                <span class="recent-date"><?php echo get_the_date('j M', $post); ?></span>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="tag-actions">
                            <a href="<?php echo get_tag_link($top_tag); ?>" class="btn-explore-tag">
                                <i class="fas fa-search"></i>
                                کاوش برچسب
                            </a>
                            
                            <div class="tag-tools">
                                <button class="tool-btn rss-btn" 
                                        data-feed="<?php echo get_tag_feed_link($top_tag->term_id); ?>"
                                        title="خورد RSS">
                                    <i class="fas fa-rss"></i>
                                </button>
                                <button class="tool-btn follow-btn" 
                                        data-tag-id="<?php echo $top_tag->term_id; ?>"
                                        title="دنبال کردن">
                                    <i class="fas fa-bell"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Tags Analytics -->
    <section class="tags-analytics-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    آمار و تحلیل برچسب‌ها
                </h2>
            </div>
            
            <div class="analytics-dashboard">
                <div class="analytics-widgets">
                    
                    <!-- Usage Distribution -->
                    <div class="analytics-widget">
                        <div class="widget-header">
                            <h3>
                                <i class="fas fa-chart-pie"></i>
                                توزیع استفاده
                            </h3>
                        </div>
                        <div class="widget-content">
                            <div class="distribution-chart">
                                <?php
                                $high_usage = 0;
                                $medium_usage = 0;
                                $low_usage = 0;
                                
                                foreach ($tags as $tag) {
                                    $percentage = $max_count > 0 ? ($tag->count / $max_count) * 100 : 0;
                                    if ($percentage >= 70) $high_usage++;
                                    elseif ($percentage >= 30) $medium_usage++;
                                    else $low_usage++;
                                }
                                
                                $total_for_chart = $high_usage + $medium_usage + $low_usage;
                                ?>
                                
                                <div class="chart-segments">
                                    <div class="segment high" 
                                         style="width: <?php echo $total_for_chart > 0 ? ($high_usage / $total_for_chart) * 100 : 0; ?>%"
                                         title="پراستفاده: <?php echo $high_usage; ?> برچسب">
                                    </div>
                                    <div class="segment medium" 
                                         style="width: <?php echo $total_for_chart > 0 ? ($medium_usage / $total_for_chart) * 100 : 0; ?>%"
                                         title="متوسط: <?php echo $medium_usage; ?> برچسب">
                                    </div>
                                    <div class="segment low" 
                                         style="width: <?php echo $total_for_chart > 0 ? ($low_usage / $total_for_chart) * 100 : 0; ?>%"
                                         title="کم‌استفاده: <?php echo $low_usage; ?> برچسب">
                                    </div>
                                </div>
                                
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-color high"></div>
                                        <span>پراستفاده (<?php echo $high_usage; ?>)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color medium"></div>
                                        <span>متوسط (<?php echo $medium_usage; ?>)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color low"></div>
                                        <span>کم‌استفاده (<?php echo $low_usage; ?>)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Most Active Tags -->
                    <div class="analytics-widget">
                        <div class="widget-header">
                            <h3>
                                <i class="fas fa-trophy"></i>
                                فعال‌ترین برچسب‌ها
                            </h3>
                        </div>
                        <div class="widget-content">
                            <div class="active-tags-list">
                                <?php foreach (array_slice($top_tags, 0, 8) as $rank => $active_tag): ?>
                                    <div class="active-tag-item">
                                        <div class="tag-rank-mini">
                                            <span><?php echo $rank + 1; ?></span>
                                        </div>
                                        <div class="tag-info-mini">
                                            <a href="<?php echo get_tag_link($active_tag); ?>" class="tag-link-mini">
                                                #<?php echo esc_html($active_tag->name); ?>
                                            </a>
                                            <div class="tag-usage-bar">
                                                <div class="usage-fill" 
                                                     style="width: <?php echo ($active_tag->count / $max_count) * 100; ?>%"></div>
                                            </div>
                                        </div>
                                        <div class="tag-count-mini">
                                            <?php echo $active_tag->count; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Growth Trends -->
                    <div class="analytics-widget">
                        <div class="widget-header">
                            <h3>
                                <i class="fas fa-chart-line"></i>
                                روند رشد
                            </h3>
                        </div>
                        <div class="widget-content">
                            <?php
                            // Simulate growth data based on recent posts
                            $growth_tags = array();
                            foreach (array_slice($tags, 0, 6) as $tag) {
                                $recent_posts = get_posts(array(
                                    'tag' => $tag->slug,
                                    'date_query' => array(
                                        array(
                                            'after' => '3 months ago'
                                        )
                                    ),
                                    'numberposts' => -1
                                ));
                                $growth_tags[] = array(
                                    'tag' => $tag,
                                    'growth' => count($recent_posts),
                                    'percentage' => $tag->count > 0 ? round((count($recent_posts) / $tag->count) * 100) : 0
                                );
                            }
                            
                            usort($growth_tags, function($a, $b) {
                                return $b['growth'] - $a['growth'];
                            });
                            ?>
                            
                            <div class="growth-list">
                                <?php foreach ($growth_tags as $growth_tag): ?>
                                    <div class="growth-item">
                                        <div class="growth-tag">
                                            <a href="<?php echo get_tag_link($growth_tag['tag']); ?>">
                                                #<?php echo esc_html($growth_tag['tag']->name); ?>
                                            </a>
                                        </div>
                                        <div class="growth-bar">
                                            <div class="growth-progress" 
                                                 style="width: <?php echo min(100, $growth_tag['percentage']); ?>%"></div>
                                        </div>
                                        <div class="growth-stats">
                                            <span class="growth-number">+<?php echo $growth_tag['growth']; ?></span>
                                            <span class="growth-period">۳ ماه اخیر</span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- All Tags Alphabetical -->
    <section class="all-tags-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list-ul"></i>
                    فهرست کامل برچسب‌ها
                </h2>
                <p class="section-description">تمام برچسب‌ها به ترتیب الفبایی</p>
            </div>
            
            <div class="alphabetical-tags">
                <?php
                // Group tags by first letter
                $tags_by_letter = array();
                foreach ($tags as $tag) {
                    $first_letter = mb_substr($tag->name, 0, 1);
                    if (!isset($tags_by_letter[$first_letter])) {
                        $tags_by_letter[$first_letter] = array();
                    }
                    $tags_by_letter[$first_letter][] = $tag;
                }
                
                // Sort by letter
                ksort($tags_by_letter);
                
                foreach ($tags_by_letter as $letter => $letter_tags):
                ?>
                    <div class="letter-group">
                        <div class="letter-header">
                            <div class="letter-badge">
                                <span class="letter"><?php echo esc_html($letter); ?></span>
                            </div>
                            <div class="letter-info">
                                <span class="letter-count"><?php echo count($letter_tags); ?> برچسب</span>
                            </div>
                        </div>
                        
                        <div class="letter-tags">
                            <?php foreach ($letter_tags as $letter_tag): ?>
                                <a href="<?php echo get_tag_link($letter_tag); ?>" 
                                   class="letter-tag"
                                   data-name="<?php echo esc_attr(strtolower($letter_tag->name)); ?>"
                                   data-count="<?php echo $letter_tag->count; ?>">
                                    <span class="tag-name">#<?php echo esc_html($letter_tag->name); ?></span>
                                    <span class="tag-count"><?php echo $letter_tag->count; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Tags Hub Comprehensive Styles */
.tags-hub-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
    font-family: inherit;
}

/* Admin bar adjustments */
body.admin-bar .tags-hub-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .tags-hub-main {
        padding-top: 116px;
    }
}

/* Tags Hero */
.tags-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    color: white;
    padding: 5rem 0;
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
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: starTwinkle 3s ease-in-out infinite;
}

/* Generate random positions for stars */
.star-1 { top: 15%; left: 20%; animation-delay: 0s; }
.star-2 { top: 25%; left: 70%; animation-delay: 0.5s; }
.star-3 { top: 35%; left: 15%; animation-delay: 1s; }
.star-4 { top: 45%; left: 85%; animation-delay: 1.5s; }
.star-5 { top: 55%; left: 30%; animation-delay: 2s; }
.star-6 { top: 65%; left: 75%; animation-delay: 2.5s; }
.star-7 { top: 75%; left: 10%; animation-delay: 3s; }
.star-8 { top: 85%; left: 60%; animation-delay: 3.5s; }
.star-9 { top: 10%; left: 50%; animation-delay: 4s; }
.star-10 { top: 20%; left: 80%; animation-delay: 4.5s; }
.star-11 { top: 30%; left: 40%; animation-delay: 5s; }
.star-12 { top: 40%; left: 95%; animation-delay: 5.5s; }
.star-13 { top: 50%; left: 5%; animation-delay: 6s; }
.star-14 { top: 60%; left: 55%; animation-delay: 0.2s; }
.star-15 { top: 70%; left: 25%; animation-delay: 0.7s; }
.star-16 { top: 80%; left: 90%; animation-delay: 1.2s; }
.star-17 { top: 90%; left: 35%; animation-delay: 1.7s; }
.star-18 { top: 12%; left: 65%; animation-delay: 2.2s; }
.star-19 { top: 22%; left: 12%; animation-delay: 2.7s; }
.star-20 { top: 32%; left: 88%; animation-delay: 3.2s; }
.star-21 { top: 42%; left: 22%; animation-delay: 3.7s; }
.star-22 { top: 52%; left: 78%; animation-delay: 4.2s; }
.star-23 { top: 62%; left: 42%; animation-delay: 4.7s; }
.star-24 { top: 72%; left: 68%; animation-delay: 5.2s; }
.star-25 { top: 82%; left: 48%; animation-delay: 5.7s; }

@keyframes starTwinkle {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.5); }
}

.hero-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.tags-cloud-visual {
    width: 350px;
    height: 350px;
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

.cloud-container {
    position: absolute;
    width: 100%;
    height: 100%;
}

.cloud-tag {
    position: absolute;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
    white-space: nowrap;
    animation: cloudFloat 8s ease-in-out infinite;
    transform-origin: center;
    font-family: inherit;
}

.cloud-tag .tag-link {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s ease;
}

.cloud-tag:hover {
    transform: scale(1.2);
    color: #FFD700;
    text-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
}

@keyframes cloudFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-10px) rotate(2deg); }
    50% { transform: translateY(-20px) rotate(-1deg); }
    75% { transform: translateY(-10px) rotate(1deg); }
}

.cloud-center {
    position: relative;
    z-index: 10;
    text-align: center;
}

.center-icon {
    width: 120px;
    height: 120px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    margin: 0 auto 1rem;
    animation: centerPulse 3s ease-in-out infinite;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

@keyframes centerPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); box-shadow: 0 0 40px rgba(255, 255, 255, 0.5); }
}

.center-text {
    font-size: 1.3rem;
    font-weight: 700;
    font-family: inherit;
}

/* Tags Filter Section */
.tags-filter-section {
    background: var(--bg-main);
    padding: 3rem 0;
    border-bottom: 1px solid var(--border-color);
}

.filter-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.search-container {
    flex: 1;
    max-width: 500px;
}

.search-wrapper {
    display: flex;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 2px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.search-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.search-input {
    flex: 1;
    padding: 1.25rem 1.5rem;
    border: none;
    background: transparent;
    font-family: inherit;
    color: var(--text-primary);
    font-size: 1rem;
}

.search-input:focus {
    outline: none;
}

.search-btn {
    padding: 1.25rem 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
    font-size: 1rem;
}

.search-btn:hover {
    background: var(--primary-dark);
}

.search-results-info {
    color: var(--text-muted);
    font-size: 0.9rem;
    text-align: center;
    font-family: inherit;
}

.filter-options {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.sort-control {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sort-control label {
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.sort-control select {
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 0.9rem;
    min-width: 180px;
    transition: all 0.3s ease;
}

.sort-control select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    background: var(--bg-secondary);
    padding: 0.5rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    background: transparent;
    color: var(--text-primary);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: inherit;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* Interactive Tags Cloud */
.tags-cloud-section {
    padding: 5rem 0;
}

.interactive-tags-cloud {
    background: var(--bg-main);
    border-radius: 25px;
    padding: 4rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
    text-align: center;
    line-height: 2.5;
    margin-bottom: 3rem;
}

.interactive-tag {
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 600;
    margin: 0.5rem;
    display: inline-block;
    transition: all 0.3s ease;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    position: relative;
    font-family: inherit;
}

.interactive-tag:hover {
    transform: translateY(-3px) scale(1.1);
    text-shadow: 0 0 10px currentColor;
}

.interactive-tag.high {
    color: #FF6B6B;
    font-weight: 800;
}

.interactive-tag.high:hover {
    color: #FF5252;
    background: rgba(255, 107, 107, 0.1);
}

.interactive-tag.medium {
    color: #4ECDC4;
    font-weight: 700;
}

.interactive-tag.medium:hover {
    color: #26D0CE;
    background: rgba(78, 205, 196, 0.1);
}

.interactive-tag.low {
    color: #95A5A6;
    font-weight: 500;
}

.interactive-tag.low:hover {
    color: #7F8C8D;
    background: rgba(149, 165, 166, 0.1);
}

.cloud-legend {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--bg-secondary);
    padding: 1rem 1.5rem;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.legend-indicator {
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.legend-indicator.high { background: #FF6B6B; }
.legend-indicator.medium { background: #4ECDC4; }
.legend-indicator.low { background: #95A5A6; }

.legend-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
    font-family: inherit;
}

/* Top Tags Section */
.top-tags-section {
    padding: 5rem 0;
}

.top-tags-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

.top-tag-card {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    position: relative;
}

.top-tag-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--tag-color);
}

.top-tag-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.tag-card-header {
    background: linear-gradient(135deg, var(--tag-color), var(--tag-color));
    color: white;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.tag-rank {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    font-family: inherit;
}

.tag-info {
    flex: 1;
    min-width: 0;
}

.tag-name {
    margin: 0 0 0.75rem 0;
    font-size: 1.4rem;
    font-weight: 700;
    font-family: inherit;
}

.tag-name a {
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.tag-name a:hover {
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    color: white;
}

.tag-description {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.5;
    margin: 0;
    font-family: inherit;
}

.tag-stats-mini {
    flex-shrink: 0;
}

.usage-circle {
    width: 70px;
    height: 70px;
    position: relative;
}

.usage-progress {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(rgba(255,255,255,0.8) var(--usage), rgba(255,255,255,0.2) var(--usage));
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.usage-progress::before {
    content: '';
    position: absolute;
    top: 8px;
    left: 8px;
    right: 8px;
    bottom: 8px;
    background: var(--tag-color);
    border-radius: 50%;
}

.usage-text {
    position: relative;
    z-index: 1;
    font-size: 0.9rem;
    font-weight: 700;
    color: white;
    font-family: inherit;
}

.tag-metrics {
    padding: 1.5rem 2rem;
    background: var(--bg-secondary);
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    border-top: 1px solid var(--border-color);
}

.metric-item {
    text-align: center;
    padding: 1rem;
    background: var(--bg-main);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.metric-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.metric-item i {
    color: var(--tag-color);
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    display: block;
}

.metric-value {
    display: block;
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.metric-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.tag-recent-posts {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border-color);
}

.recent-title {
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.recent-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.recent-item {
    background: var(--bg-secondary);
    border-radius: 8px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.recent-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    font-family: inherit;
}

.recent-link:hover {
    background: rgba(31, 165, 71, 0.05);
    color: var(--primary-color);
}

.recent-post-title {
    flex: 1;
    font-weight: 500;
    font-size: 0.85rem;
    line-height: 1.3;
    margin-left: 1rem;
}

.recent-date {
    color: var(--text-muted);
    font-size: 0.75rem;
    font-weight: 500;
    background: var(--bg-main);
    padding: 0.25rem 0.75rem;
    border-radius: 10px;
    font-family: inherit;
}

.tag-actions {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-explore-tag {
    background: var(--tag-color);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.btn-explore-tag:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    color: white;
    filter: brightness(1.1);
}

.tag-tools {
    display: flex;
    gap: 0.5rem;
}

.tool-btn {
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
    font-size: 0.85rem;
}

.tool-btn:hover {
    background: var(--tag-color);
    color: white;
    border-color: var(--tag-color);
    transform: scale(1.1);
}

.follow-btn.following {
    background: #FFD700;
    color: #1a1a1a;
    border-color: #FFD700;
}

/* Tags Analytics Section */
.tags-analytics-section {
    background: var(--bg-main);
    padding: 5rem 0;
}

.analytics-dashboard {
    background: var(--bg-secondary);
    border-radius: 25px;
    padding: 4rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
}

.analytics-widgets {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 3rem;
}

.analytics-widget {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.widget-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.5rem 2rem;
}

.widget-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.widget-content {
    padding: 2rem;
}

/* Distribution Chart */
.distribution-chart {
    margin-bottom: 2rem;
}

.chart-segments {
    display: flex;
    height: 20px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
}

.segment {
    transition: all 0.5s ease;
}

.segment.high { background: #FF6B6B; }
.segment.medium { background: #4ECDC4; }
.segment.low { background: #95A5A6; }

.chart-legend {
    display: flex;
    justify-content: space-around;
    gap: 1rem;
    flex-wrap: wrap;
}

.chart-legend .legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-family: inherit;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
}

.legend-color.high { background: #FF6B6B; }
.legend-color.medium { background: #4ECDC4; }
.legend-color.low { background: #95A5A6; }

/* Active Tags List */
.active-tags-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.active-tag-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.active-tag-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.tag-rank-mini {
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

.tag-info-mini {
    flex: 1;
    min-width: 0;
}

.tag-link-mini {
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.3s ease;
    font-family: inherit;
}

.tag-link-mini:hover {
    color: var(--primary-color);
}

.tag-usage-bar {
    width: 100%;
    height: 6px;
    background: var(--border-color);
    border-radius: 3px;
    overflow: hidden;
    margin-top: 0.5rem;
}

.usage-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    border-radius: 3px;
    transition: width 1s ease;
}

.tag-count-mini {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.9rem;
    flex-shrink: 0;
    font-family: inherit;
}

/* Growth Trends */
.growth-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.growth-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.growth-item:hover {
    background: rgba(31, 165, 71, 0.05);
    transform: translateY(-2px);
}

.growth-tag {
    min-width: 120px;
}

.growth-tag a {
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
    font-family: inherit;
}

.growth-tag a:hover {
    color: var(--primary-color);
}

.growth-bar {
    flex: 1;
    height: 8px;
    background: var(--border-color);
    border-radius: 4px;
    overflow: hidden;
}

.growth-progress {
    height: 100%;
    background: linear-gradient(90deg, #4ECDC4, #26D0CE);
    border-radius: 4px;
    transition: width 1s ease;
}

.growth-stats {
    text-align: center;
    min-width: 80px;
}

.growth-number {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
    color: #4ECDC4;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.growth-period {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-family: inherit;
}

/* All Tags Alphabetical */
.all-tags-section {
    background: var(--bg-secondary);
    padding: 5rem 0;
}

.alphabetical-tags {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.letter-group {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.letter-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.letter-badge {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 800;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.letter {
    font-family: inherit;
}

.letter-info {
    flex: 1;
}

.letter-count {
    font-size: 1.1rem;
    font-weight: 600;
    opacity: 0.9;
    font-family: inherit;
}

.letter-tags {
    padding: 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.letter-tag {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.letter-tag:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
    color: var(--text-primary);
}

.letter-tag .tag-name {
    font-weight: 600;
    flex: 1;
}

.letter-tag .tag-count {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
    }
    
    .top-tags-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
    
    .analytics-widgets {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .tags-hub-main {
        padding-top: 70px;
    }
    
    body.admin-bar .tags-hub-main {
        padding-top: 102px;
    }
    
    .tags-hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .filter-controls {
        flex-direction: column;
        gap: 2rem;
        align-items: stretch;
    }
    
    .filter-options {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .top-tags-grid {
        grid-template-columns: 1fr;
    }
    
    .tag-metrics {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .letter-tags {
        grid-template-columns: 1fr;
    }
    
    .cloud-legend {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .tags-hero {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 1.7rem;
    }
    
    .hero-stats {
        grid-template-columns: 1fr;
    }
    
    .interactive-tags-cloud {
        padding: 2rem;
    }
    
    .analytics-dashboard {
        padding: 2rem;
    }
    
    .letter-header {
        padding: 1rem 1.5rem;
    }
    
    .letter-tags {
        padding: 1.5rem;
    }
    
    .tag-card-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('tags-search');
    const searchResultsCount = document.getElementById('search-results-count');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const tagCards = document.querySelectorAll('.top-tag-card');
            const letterTags = document.querySelectorAll('.letter-tag');
            const cloudTags = document.querySelectorAll('.interactive-tag');
            
            let visibleCount = 0;
            
            // Filter tag cards
            tagCards.forEach(card => {
                const tagName = card.getAttribute('data-name');
                const isVisible = !query || tagName.includes(query);
                card.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });
            
            // Filter alphabetical tags
            letterTags.forEach(tag => {
                const tagName = tag.getAttribute('data-name');
                const isVisible = !query || tagName.includes(query);
                tag.style.display = isVisible ? '' : 'none';
            });
            
            // Filter cloud tags
            cloudTags.forEach(tag => {
                const tagName = tag.getAttribute('data-name');
                const isVisible = !query || tagName.includes(query);
                tag.style.opacity = isVisible ? '' : '0.2';
                tag.style.pointerEvents = isVisible ? '' : 'none';
            });
            
            if (searchResultsCount) {
                searchResultsCount.textContent = query ? visibleCount : <?php echo $total_tags; ?>;
            }
        });
    }
    
    // Sort functionality
    const sortSelect = document.getElementById('tags-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const cards = Array.from(document.querySelectorAll('.top-tag-card'));
            
            cards.sort((a, b) => {
                switch (sortValue) {
                    case 'count-desc':
                        return parseInt(b.getAttribute('data-count')) - parseInt(a.getAttribute('data-count'));
                    case 'count-asc':
                        return parseInt(a.getAttribute('data-count')) - parseInt(b.getAttribute('data-count'));
                    case 'name-asc':
                        return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                    case 'name-desc':
                        return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                    default:
                        return 0;
                }
            });
            
            const container = document.querySelector('.top-tags-grid');
            cards.forEach(card => container.appendChild(card));
        });
    }
    
    // Filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const cards = document.querySelectorAll('.top-tag-card');
            cards.forEach(card => {
                const popularity = card.getAttribute('data-popularity');
                const count = parseInt(card.getAttribute('data-count'));
                
                let show = true;
                switch (filter) {
                    case 'popular':
                        show = popularity === 'high';
                        break;
                    case 'recent':
                        show = popularity === 'medium';
                        break;
                    case 'unused':
                        show = count === 0;
                        break;
                    case 'all':
                    default:
                        show = true;
                        break;
                }
                
                card.style.display = show ? '' : 'none';
            });
        });
    });
    
    // RSS and Follow buttons
    const rssBtns = document.querySelectorAll('.rss-btn');
    rssBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const feedUrl = this.getAttribute('data-feed');
            window.open(feedUrl, '_blank');
        });
    });
    
    const followBtns = document.querySelectorAll('.follow-btn');
    followBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tagId = this.getAttribute('data-tag-id');
            const isFollowing = this.classList.contains('following');
            
            if (isFollowing) {
                this.classList.remove('following');
                this.innerHTML = '<i class="fas fa-bell"></i>';
                removeFollow(tagId);
                alert('دنبال کردن لغو شد');
            } else {
                this.classList.add('following');
                this.innerHTML = '<i class="fas fa-bell-slash"></i>';
                addFollow(tagId);
                alert('برچسب دنبال شد!');
            }
        });
    });
    
    // Initialize following status
    const followedTags = JSON.parse(localStorage.getItem('followedTags') || '[]');
    followBtns.forEach(btn => {
        const tagId = btn.getAttribute('data-tag-id');
        if (followedTags.includes(tagId)) {
            btn.classList.add('following');
            btn.innerHTML = '<i class="fas fa-bell-slash"></i>';
        }
    });
    
    // Interactive cloud hover effects
    const cloudTags = document.querySelectorAll('.interactive-tag');
    cloudTags.forEach(tag => {
        tag.addEventListener('mouseenter', function() {
            // Highlight related tags (placeholder logic)
            const tagName = this.textContent.replace('#', '');
            cloudTags.forEach(otherTag => {
                if (otherTag !== this) {
                    otherTag.style.opacity = '0.3';
                }
            });
        });
        
        tag.addEventListener('mouseleave', function() {
            cloudTags.forEach(otherTag => {
                otherTag.style.opacity = '';
            });
        });
    });
    
    // Animations
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
    
    // Animate tag cards
    document.querySelectorAll('.top-tag-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Animate letter groups
    document.querySelectorAll('.letter-group').forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(30px)';
        group.style.transition = `opacity 0.6s ease ${index * 0.15}s, transform 0.6s ease ${index * 0.15}s`;
        observer.observe(group);
    });
    
    // Utility functions
    function addFollow(tagId) {
        const followedTags = JSON.parse(localStorage.getItem('followedTags') || '[]');
        if (!followedTags.includes(tagId)) {
            followedTags.push(tagId);
            localStorage.setItem('followedTags', JSON.stringify(followedTags));
        }
    }
    
    function removeFollow(tagId) {
        const followedTags = JSON.parse(localStorage.getItem('followedTags') || '[]');
        const index = followedTags.indexOf(tagId);
        if (index > -1) {
            followedTags.splice(index, 1);
            localStorage.setItem('followedTags', JSON.stringify(followedTags));
        }
    }
});
</script>

<?php get_footer(); ?>