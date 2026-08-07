<?php get_header(); ?>

<main id="main-content" class="taxonomy-archive-main">
    
    <!-- Taxonomy Hero -->
    <section class="taxonomy-hero">
        <div class="hero-background">
            <div class="hero-mesh">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <div class="mesh-point point-<?php echo $i; ?>"></div>
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
                        <?php
                        $queried_object = get_queried_object();
                        $taxonomy = get_taxonomy($queried_object->taxonomy);
                        ?>
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="#" itemprop="item">
                                <span itemprop="name"><?php echo esc_html($taxonomy->labels->name); ?></span>
                            </a>
                            <meta itemprop="position" content="3" />
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name"><?php single_term_title(); ?></span>
                            <meta itemprop="position" content="4" />
                        </li>
                    </ol>
                </nav>
                
                <!-- Taxonomy Info -->
                <div class="taxonomy-info">
                    <?php
                    $term = get_queried_object();
                    $term_color = get_term_meta($term->term_id, 'term_color', true) ?: '#764ba2';
                    $term_icon = get_term_meta($term->term_id, 'term_icon', true) ?: 'fas fa-layer-group';
                    ?>
                    
                    <div class="taxonomy-badge" style="--term-color: <?php echo $term_color; ?>">
                        <i class="<?php echo esc_attr($term_icon); ?>"></i>
                        <span><?php echo esc_html($taxonomy->labels->singular_name); ?></span>
                    </div>
                    
                    <h1 class="taxonomy-title" itemprop="name">
                        <?php single_term_title(); ?>
                    </h1>
                    
                    <?php if (term_description()): ?>
                        <div class="taxonomy-description" itemprop="description">
                            <?php echo term_description(); ?>
                        </div>
                    <?php else: ?>
                        <div class="taxonomy-description">
                            <p>مجموعه‌ای جامع از مطالب و مقالات مرتبط با <?php echo esc_html($taxonomy->labels->singular_name); ?> <strong><?php single_term_title(); ?></strong> که توسط تیم متخصص تزنویسان تهیه شده است.</p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Dynamic Taxonomy Stats -->
                    <div class="taxonomy-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <div class="stat-content">
                                <span class="stat-number" itemprop="numberOfItems"><?php echo $wp_query->found_posts; ?></span>
                                <span class="stat-label">مطلب</span>
                            </div>
                        </div>
                        
                        <?php
                        // Get taxonomy hierarchy level
                        $hierarchy_level = 0;
                        if ($term->parent) {
                            $parent = get_term($term->parent);
                            $hierarchy_level = 1;
                            while ($parent && $parent->parent) {
                                $parent = get_term($parent->parent);
                                $hierarchy_level++;
                            }
                        }
                        ?>
                        
                        <div class="stat-item">
                            <i class="fas fa-sitemap"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $hierarchy_level; ?></span>
                                <span class="stat-label">سطح سلسله‌مراتب</span>
                            </div>
                        </div>
                        
                        <?php
                        // Get child terms count
                        $child_terms = get_terms(array(
                            'taxonomy' => $term->taxonomy,
                            'parent' => $term->term_id,
                            'hide_empty' => false
                        ));
                        ?>
                        
                        <div class="stat-item">
                            <i class="fas fa-code-branch"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo count($child_terms); ?></span>
                                <span class="stat-label">زیرمجموعه</span>
                            </div>
                        </div>
                        
                        <?php
                        // Creation date estimation
                        $first_post = get_posts(array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => $term->taxonomy,
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                )
                            ),
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
                                    <span class="stat-label">سال شروع</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Taxonomy Visual -->
                <div class="hero-visual">
                    <div class="taxonomy-illustration">
                        <div class="illustration-bg">
                            <div class="hierarchy-tree">
                                <!-- Parent Term -->
                                <?php if ($term->parent): ?>
                                    <?php $parent_term = get_term($term->parent); ?>
                                    <div class="tree-node parent-node">
                                        <div class="node-content">
                                            <i class="fas fa-layer-group"></i>
                                            <span><?php echo esc_html($parent_term->name); ?></span>
                                        </div>
                                        <div class="node-connection"></div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Current Term -->
                                <div class="tree-node current-node" style="--node-color: <?php echo $term_color; ?>">
                                    <div class="node-content">
                                        <i class="<?php echo esc_attr($term_icon); ?>"></i>
                                        <span><?php single_term_title(); ?></span>
                                    </div>
                                    <?php if ($child_terms): ?>
                                        <div class="node-connections">
                                            <?php foreach (array_slice($child_terms, 0, 3) as $child): ?>
                                                <div class="child-connection"></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Child Terms -->
                                <?php if ($child_terms): ?>
                                    <div class="child-nodes">
                                        <?php foreach (array_slice($child_terms, 0, 3) as $index => $child): ?>
                                            <div class="tree-node child-node" style="animation-delay: <?php echo ($index * 0.2); ?>s">
                                                <div class="node-content">
                                                    <i class="fas fa-folder"></i>
                                                    <span><?php echo esc_html($child->name); ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php if (count($child_terms) > 3): ?>
                                            <div class="tree-node more-node">
                                                <div class="node-content">
                                                    <i class="fas fa-plus"></i>
                                                    <span>+<?php echo count($child_terms) - 3; ?> مورد دیگر</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Taxonomy Content Section -->
    <section class="taxonomy-content-section">
        <div class="container">
            <div class="content-layout">
                
                <!-- Main Content -->
                <div class="main-content">
                    
                    <!-- Enhanced Taxonomy Info Box -->
                    <div class="taxonomy-info-box" style="--term-color: <?php echo $term_color; ?>">
                        <div class="info-header">
                            <div class="info-icon">
                                <i class="<?php echo esc_attr($term_icon); ?>"></i>
                            </div>
                            <h2>درباره <?php echo esc_html($taxonomy->labels->singular_name); ?> «<?php single_term_title(); ?>»</h2>
                        </div>
                        
                        <div class="info-content">
                            <?php
                            $term_extended_desc = get_term_meta($term->term_id, 'extended_description', true);
                            if ($term_extended_desc):
                            ?>
                                <div class="extended-description">
                                    <?php echo wpautop($term_extended_desc); ?>
                                </div>
                            <?php else: ?>
                                <div class="auto-description">
                                    <p><?php echo esc_html($taxonomy->labels->singular_name); ?> <strong><?php single_term_title(); ?></strong> شامل مجموعه‌ای از مطالب تخصصی است که به موضوعات مرتبط می‌پردازد و توسط تیم متخصص تزنویسان تهیه شده است.</p>
                                    
                                    <?php if ($child_terms): ?>
                                        <p>این <?php echo esc_html($taxonomy->labels->singular_name); ?> شامل <?php echo count($child_terms); ?> زیرمجموعه است که هر یک به جنبه‌های خاصی از موضوع اصلی می‌پردازد.</p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Taxonomy Hierarchy -->
                            <?php if ($term->parent || $child_terms): ?>
                                <div class="taxonomy-hierarchy">
                                    <h4><i class="fas fa-sitemap"></i> سلسله‌مراتب:</h4>
                                    
                                    <?php if ($term->parent): ?>
                                        <div class="hierarchy-section">
                                            <h5>والد:</h5>
                                            <div class="parent-term">
                                                <a href="<?php echo get_term_link($parent_term); ?>">
                                                    <i class="fas fa-level-up-alt"></i>
                                                    <?php echo esc_html($parent_term->name); ?>
                                                    <span class="term-count">(<?php echo $parent_term->count; ?> مطلب)</span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($child_terms): ?>
                                        <div class="hierarchy-section">
                                            <h5>زیرمجموعه‌ها:</h5>
                                            <div class="child-terms-grid">
                                                <?php foreach ($child_terms as $child): ?>
                                                    <a href="<?php echo get_term_link($child); ?>" class="child-term-item">
                                                        <i class="fas fa-folder"></i>
                                                        <span class="term-name"><?php echo esc_html($child->name); ?></span>
                                                        <span class="term-count"><?php echo $child->count; ?> مطلب</span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Posts in this taxonomy -->
                    <?php if (have_posts()): ?>
                        <div class="taxonomy-posts-container">
                            <div class="posts-header">
                                <h3 class="posts-title">
                                    <i class="fas fa-layer-group"></i>
                                    مطالب <?php echo esc_html($taxonomy->labels->singular_name); ?> «<?php single_term_title(); ?>»
                                </h3>
                                
                                <div class="posts-controls">
                                    <div class="sort-control">
                                        <label for="posts-sort">مرتب‌سازی:</label>
                                        <select id="posts-sort" class="posts-sort-select">
                                            <option value="date-desc">جدیدترین</option>
                                            <option value="date-asc">قدیمی‌ترین</option>
                                            <option value="title-asc">الفبایی</option>
                                            <option value="views-desc">پربازدیدترین</option>
                                        </select>
                                    </div>
                                    
                                    <div class="view-toggle">
                                        <button class="view-btn active" data-view="grid">
                                            <i class="fas fa-th"></i>
                                        </button>
                                        <button class="view-btn" data-view="list">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="posts-grid grid-view" id="taxonomy-posts-container">
                                <?php while (have_posts()): the_post(); ?>
                                    <article class="taxonomy-post-card" 
                                             data-date="<?php echo get_the_date('Y-m-d'); ?>"
                                             data-views="<?php echo get_post_meta(get_the_ID(), 'post_views', true) ?: 0; ?>"
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
                                                    <div class="overlay-info">
                                                        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                                                            <i class="fas fa-calendar"></i>
                                                            <?php echo get_the_date(); ?>
                                                        </time>
                                                    </div>
                                                    
                                                    <div class="overlay-action">
                                                        <a href="<?php the_permalink(); ?>" class="read-btn">
                                                            <i class="fas fa-book-open"></i>
                                                            مطالعه
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="post-content">
                                            <!-- Post Type Badge -->
                                            <div class="post-type-badge">
                                                <i class="fas fa-file-alt"></i>
                                                <span><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
                                            </div>
                                            
                                            <!-- Post Taxonomies -->
                                            <div class="post-taxonomies">
                                                <?php
                                                $post_terms = get_the_terms(get_the_ID(), $term->taxonomy);
                                                if ($post_terms && !is_wp_error($post_terms)) {
                                                    foreach (array_slice($post_terms, 0, 3) as $post_term) {
                                                        $is_current = ($post_term->term_id == $term->term_id);
                                                        $class = $is_current ? 'post-term current' : 'post-term';
                                                        echo '<a href="' . esc_url(get_term_link($post_term)) . '" 
                                                              class="' . $class . '"
                                                              itemprop="about">' . 
                                                              esc_html($post_term->name) . '</a>';
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
                                            
                                            <div class="post-actions">
                                                <a href="<?php the_permalink(); ?>" class="btn-read-more">
                                                    <span>مطالعه کامل</span>
                                                    <i class="fas fa-arrow-left"></i>
                                                </a>
                                                
                                                <div class="post-tools">
                                                    <button class="tool-btn share-btn" 
                                                            data-url="<?php the_permalink(); ?>" 
                                                            data-title="<?php the_title_attribute(); ?>"
                                                            title="اشتراک‌گذاری">
                                                        <i class="fas fa-share-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Structured Data -->
                                        <meta itemprop="dateModified" content="<?php echo get_the_modified_date('c'); ?>">
                                        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" style="display: none;">
                                            <span itemprop="name">تزنویسان</span>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                            
                            <!-- Enhanced Pagination -->
                            <div class="taxonomy-pagination">
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
                                    <nav class="pagination-nav" aria-label="صفحه‌بندی مطالب">
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
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3>مطلبی در این <?php echo esc_html($taxonomy->labels->singular_name); ?> یافت نشد</h3>
                            <p>متأسفانه در حال حاضر مطلبی در <?php echo esc_html($taxonomy->labels->singular_name); ?> «<?php single_term_title(); ?>» موجود نیست.</p>
                            <div class="no-posts-actions">
                                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                    بازگشت به وبلاگ
                                </a>
                                <?php if ($term->parent): ?>
                                    <a href="<?php echo get_term_link($term->parent); ?>" class="btn-secondary">
                                        <i class="fas fa-level-up-alt"></i>
                                        مراجعه به والد
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Enhanced Sidebar -->
                <aside class="taxonomy-sidebar">
                    
                    <!-- Taxonomy Quick Info -->
                    <div class="widget taxonomy-quick-info" style="--term-color: <?php echo $term_color; ?>">
                        <div class="widget-content">
                            <div class="quick-info-header">
                                <div class="taxonomy-icon">
                                    <i class="<?php echo esc_attr($term_icon); ?>"></i>
                                </div>
                                <h3><?php single_term_title(); ?></h3>
                                <p class="taxonomy-type"><?php echo esc_html($taxonomy->labels->singular_name); ?></p>
                            </div>
                            
                            <div class="quick-stats-grid">
                                <div class="quick-stat">
                                    <span class="stat-number"><?php echo $wp_query->found_posts; ?></span>
                                    <span class="stat-label">مطلب</span>
                                </div>
                                <div class="quick-stat">
                                    <span class="stat-number"><?php echo count($child_terms); ?></span>
                                    <span class="stat-label">زیرمجموعه</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Child Terms Navigation -->
                    <?php if ($child_terms): ?>
                        <div class="widget child-terms-widget">
                            <h3 class="widget-title">
                                <i class="fas fa-code-branch"></i>
                                زیرمجموعه‌ها
                            </h3>
                            <div class="widget-content">
                                <div class="child-terms-list">
                                    <?php foreach ($child_terms as $child_term): ?>
                                        <a href="<?php echo get_term_link($child_term); ?>" 
                                           class="child-term-link">
                                            <div class="term-info">
                                                <span class="term-name"><?php echo esc_html($child_term->name); ?></span>
                                                <?php if ($child_term->description): ?>
                                                    <span class="term-desc"><?php echo wp_trim_words($child_term->description, 8); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="term-meta">
                                                <span class="term-count"><?php echo $child_term->count; ?></span>
                                                <i class="fas fa-arrow-left"></i>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Related Taxonomies -->
                    <div class="widget related-taxonomies-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-sitemap"></i>
                            سایر <?php echo esc_html($taxonomy->labels->name); ?>
                        </h3>
                        <div class="widget-content">
                            <?php
                            $related_terms = get_terms(array(
                                'taxonomy' => $term->taxonomy,
                                'exclude' => $term->term_id,
                                'number' => 8,
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'hide_empty' => true
                            ));
                            
                            if ($related_terms && !is_wp_error($related_terms)):
                            ?>
                                <div class="related-terms-cloud">
                                    <?php foreach ($related_terms as $related_term): ?>
                                        <a href="<?php echo get_term_link($related_term); ?>" 
                                           class="related-term-item"
                                           title="<?php echo $related_term->count; ?> مطلب">
                                            <?php echo esc_html($related_term->name); ?>
                                            <span class="term-count"><?php echo $related_term->count; ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="no-related-terms">سایر مواردی یافت نشد.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Taxonomy Analytics -->
                    <div class="widget taxonomy-analytics-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-chart-pie"></i>
                            آمار و اطلاعات
                        </h3>
                        <div class="widget-content">
                            <div class="analytics-grid">
                                <?php
                                $total_terms = wp_count_terms($term->taxonomy, array('hide_empty' => false));
                                $total_posts_in_taxonomy = 0;
                                foreach (get_terms($term->taxonomy) as $t) {
                                    $total_posts_in_taxonomy += $t->count;
                                }
                                $percentage = $total_posts_in_taxonomy > 0 ? round(($term->count / $total_posts_in_taxonomy) * 100, 1) : 0;
                                ?>
                                
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div class="analytics-content">
                                        <span class="analytics-number"><?php echo $percentage; ?>%</span>
                                        <span class="analytics-label">از کل مطالب</span>
                                    </div>
                                </div>
                                
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="analytics-content">
                                        <span class="analytics-number"><?php echo $total_terms; ?></span>
                                        <span class="analytics-label">کل <?php echo esc_html($taxonomy->labels->name); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Usage Progress -->
                            <div class="usage-progress">
                                <div class="progress-label">میزان استفاده نسبی</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo min(100, $percentage * 2); ?>%"></div>
                                </div>
                                <div class="progress-text"><?php echo $percentage; ?>% از کل محتوا</div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (function_exists('dynamic_sidebar')) { 
                        dynamic_sidebar('taxonomy-sidebar'); 
                    } ?>
                </aside>
            </div>
        </div>
    </section>
    
</main>

<!-- Taxonomy Enhanced CSS -->
<style>
/* Taxonomy Archive Enhanced Styles */
.taxonomy-archive-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
    font-family: inherit;
}

/* Admin bar adjustments */
body.admin-bar .taxonomy-archive-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .taxonomy-archive-main {
        padding-top: 116px;
    }
}

/* Enhanced Taxonomy Hero */
.taxonomy-hero {
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

.hero-mesh {
    position: absolute;
    width: 100%;
    height: 100%;
}

.mesh-point {
    position: absolute;
    width: 8px;
    height: 8px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: meshFloat 6s ease-in-out infinite;
}

.point-1 { top: 10%; left: 15%; animation-delay: 0s; }
.point-2 { top: 20%; left: 85%; animation-delay: 0.5s; }
.point-3 { top: 30%; left: 25%; animation-delay: 1s; }
.point-4 { top: 40%; left: 75%; animation-delay: 1.5s; }
.point-5 { top: 50%; left: 10%; animation-delay: 2s; }
.point-6 { top: 60%; left: 90%; animation-delay: 2.5s; }
.point-7 { top: 70%; left: 35%; animation-delay: 3s; }
.point-8 { top: 80%; left: 65%; animation-delay: 3.5s; }
.point-9 { top: 15%; left: 55%; animation-delay: 4s; }
.point-10 { top: 25%; left: 45%; animation-delay: 4.5s; }
.point-11 { top: 85%; left: 20%; animation-delay: 5s; }
.point-12 { top: 95%; left: 80%; animation-delay: 5.5s; }

@keyframes meshFloat {
    0%, 100% { transform: translateY(0px) scale(1); opacity: 0.6; }
    33% { transform: translateY(-15px) scale(1.2); opacity: 0.9; }
    66% { transform: translateY(-8px) scale(0.8); opacity: 0.4; }
}

/* Rest of the CSS continues with the same enhanced styling patterns... */
/* For brevity, I'll continue with the key sections */

.hero-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.taxonomy-badge {
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

.taxonomy-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    font-family: inherit;
}

/* Hierarchy Tree Visualization */
.taxonomy-illustration {
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.hierarchy-tree {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
    position: relative;
}

.tree-node {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.node-content {
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem 1.5rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: nodeGlow 3s ease-in-out infinite;
    font-family: inherit;
}

.current-node .node-content {
    background: var(--node-color);
    color: white;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
}

.child-nodes {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
}

.child-node .node-content {
    font-size: 0.8rem;
    padding: 0.75rem 1rem;
    animation: childFloat 4s ease-in-out infinite;
}

@keyframes nodeGlow {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); box-shadow: 0 0 25px rgba(255, 255, 255, 0.6); }
}

@keyframes childFloat {
    0%, 100% { transform: translateY(0px); opacity: 0.8; }
    50% { transform: translateY(-10px); opacity: 1; }
}

.node-connection,
.child-connection {
    width: 2px;
    height: 30px;
    background: rgba(255, 255, 255, 0.4);
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
}

.node-connections {
    display: flex;
    gap: 2rem;
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
}

/* Content Layout */
.taxonomy-content-section {
    padding: 5rem 0;
}

.content-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 4rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Enhanced Taxonomy Info Box */
.taxonomy-info-box {
    background: var(--bg-main);
    border-radius: 20px;
    padding: 3rem;
    margin-bottom: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.taxonomy-info-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--term-color), transparent);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--term-color);
}

.info-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--term-color), var(--term-color));
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

.taxonomy-hierarchy {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
    margin-top: 2rem;
}

.taxonomy-hierarchy h4 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.hierarchy-section {
    margin-bottom: 2rem;
}

.hierarchy-section:last-child {
    margin-bottom: 0;
}

.hierarchy-section h5 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1rem;
    font-weight: 600;
    font-family: inherit;
}

.parent-term {
    background: var(--bg-main);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.parent-term a {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    font-family: inherit;
}

.parent-term a:hover {
    background: rgba(31, 165, 71, 0.05);
    color: var(--primary-color);
    transform: translateX(-3px);
}

.child-terms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.child-term-item {
    background: var(--bg-main);
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.child-term-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
    color: var(--text-primary);
}

.child-term-item .term-name {
    font-weight: 600;
    flex: 1;
}

.child-term-item .term-count {
    font-size: 0.85rem;
    color: var(--text-muted);
    background: var(--bg-secondary);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
}

/* Taxonomy Posts Container */
.taxonomy-posts-container {
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

.posts-controls {
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

.posts-sort-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.view-toggle {
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

.posts-grid.list-view .taxonomy-post-card {
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

/* Enhanced Taxonomy Post Cards */
.taxonomy-post-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.taxonomy-post-card:hover {
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

.taxonomy-post-card:hover .post-img {
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

.taxonomy-post-card:hover .post-overlay {
    opacity: 1;
}

.overlay-info {
    align-self: flex-start;
}

.overlay-info time {
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

.overlay-action {
    text-align: center;
}

.read-btn {
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

.taxonomy-post-card:hover .read-btn {
    transform: translateY(0);
}

.read-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.05);
}

.post-content {
    padding: 2rem;
}

.post-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 1rem;
    font-family: inherit;
}

.post-taxonomies {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.post-term {
    background: var(--bg-main);
    color: var(--text-secondary);
    padding: 0.4rem 1rem;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-family: inherit;
}

.post-term:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.post-term.current {
    background: var(--term-color);
    color: white;
    border-color: var(--term-color);
    position: relative;
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.post-term.current::after {
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
    margin-bottom: 2rem;
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

.post-tools {
    display: flex;
    gap: 0.5rem;
}

.tool-btn {
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

.tool-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.1);
}

/* Enhanced Pagination */
.taxonomy-pagination {
    margin-top: 4rem;
    text-align: center;
}

.pagination-nav {
    display: flex;
    justify-content: center;
    align-items: center;
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
.taxonomy-sidebar {
    position: sticky;
    top: calc(100px + 2rem);
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

body.admin-bar .taxonomy-sidebar {
    top: calc(132px + 2rem);
}

@media screen and (max-width: 782px) {
    body.admin-bar .taxonomy-sidebar {
        top: calc(116px + 2rem);
    }
}

.taxonomy-sidebar .widget {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.taxonomy-sidebar .widget:hover {
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

/* Taxonomy Quick Info Widget */
.taxonomy-quick-info .widget-content {
    text-align: center;
}

.quick-info-header {
    margin-bottom: 2rem;
}

.quick-info-header .taxonomy-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--term-color), var(--term-color));
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
    margin: 0 0 0.5rem 0;
    font-family: inherit;
}

.taxonomy-type {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0;
    font-family: inherit;
}

.quick-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.quick-stat {
    text-align: center;
    padding: 1.5rem 1rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.quick-stat .stat-number {
    display: block;
    font-size: 1.8rem;
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

/* Child Terms Widget */
.child-terms-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.child-term-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.child-term-link:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateX(-5px);
    color: var(--text-primary);
}

.term-info .term-name {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.term-info .term-desc {
    font-size: 0.85rem;
    color: var(--text-muted);
    line-height: 1.4;
    font-family: inherit;
}

.term-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
}

.term-meta .term-count {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: inherit;
}

/* Related Taxonomies Widget */
.related-terms-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    justify-content: center;
}

.related-term-item {
    background: var(--bg-secondary);
    color: var(--text-primary);
    padding: 0.6rem 1.2rem;
    text-decoration: none;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    font-weight: 500;
    position: relative;
    font-family: inherit;
}

.related-term-item:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.related-term-item .term-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #FFD700;
    color: #1a1a1a;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    min-width: 20px;
    text-align: center;
    font-family: inherit;
}

.no-related-terms {
    color: var(--text-muted);
    text-align: center;
    padding: 2rem;
    font-style: italic;
    font-family: inherit;
}

/* Taxonomy Analytics Widget */
.analytics-grid {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.analytics-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
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
    font-size: 1.6rem;
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

.usage-progress {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.progress-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
    text-align: center;
    font-family: inherit;
}

.progress-bar {
    width: 100%;
    height: 12px;
    background: var(--border-color);
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    border-radius: 6px;
    transition: width 1.5s ease;
}

.progress-text {
    font-size: 0.85rem;
    color: var(--text-muted);
    text-align: center;
    font-family: inherit;
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
    
    .taxonomy-sidebar {
        position: static;
        order: -1;
    }
    
    .posts-grid.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .taxonomy-archive-main {
        padding-top: 70px;
    }
    
    body.admin-bar .taxonomy-archive-main {
        padding-top: 102px;
    }
    
    .taxonomy-hero {
        padding: 3rem 0;
    }
    
    .taxonomy-title {
        font-size: 2rem;
    }
    
    .taxonomy-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .posts-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .posts-controls {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .posts-grid.grid-view {
        grid-template-columns: 1fr;
    }
    
    .posts-grid.list-view .taxonomy-post-card {
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
    
    .child-terms-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-stats-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .taxonomy-hero {
        padding: 2rem 0;
    }
    
    .taxonomy-title {
        font-size: 1.7rem;
    }
    
    .taxonomy-stats {
        grid-template-columns: 1fr;
    }
    
    .taxonomy-info-box {
        padding: 2rem 1.5rem;
    }
    
    .taxonomy-posts-container {
        padding: 2rem 1.5rem;
    }
    
    .post-content {
        padding: 1.5rem;
    }
    
    .widget-content {
        padding: 1.5rem;
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
    const postsContainer = document.getElementById('taxonomy-posts-container');
    
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
    
    // Sort functionality
    const sortSelect = document.getElementById('posts-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const posts = Array.from(document.querySelectorAll('.taxonomy-post-card'));
            
            posts.sort((a, b) => {
                switch (sortValue) {
                    case 'date-desc':
                        return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                    case 'date-asc':
                        return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                    case 'views-desc':
                        return parseInt(b.getAttribute('data-views') || '0') - parseInt(a.getAttribute('data-views') || '0');
                    case 'title-asc':
                        return a.querySelector('.post-title a').textContent.localeCompare(b.querySelector('.post-title a').textContent);
                    default:
                        return 0;
                }
            });
            
            const container = postsContainer || document.querySelector('.posts-grid');
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
                    showToast('لینک کپی شد!');
                });
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
    document.querySelectorAll('.taxonomy-post-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Animate sidebar widgets
    document.querySelectorAll('.taxonomy-sidebar .widget').forEach((widget, index) => {
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(30px)';
        widget.style.transition = `opacity 0.6s ease ${index * 0.2}s, transform 0.6s ease ${index * 0.2}s`;
        observer.observe(widget);
    });
    
    // Animate progress bar
    const progressFill = document.querySelector('.progress-fill');
    if (progressFill) {
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
        
        progressObserver.observe(progressFill);
    }
    
    // Utility function
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
