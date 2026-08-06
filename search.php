<?php get_header(); ?>

<main id="main-content" class="search-page-main">
    
    <!-- Search Results Header -->
    <section class="search-header">
        <div class="container">
            <div class="search-header-content">
                <div class="search-info">
                    <h1 class="search-title">
                        <i class="fas fa-search"></i>
                        <?php printf(__('Search Results for: %s', 'teznevisan'), '<span class="search-term">' . get_search_query() . '</span>'); ?>
                    </h1>
                    
                    <div class="search-stats">
                        <?php
                        global $wp_query;
                        $total_results = $wp_query->found_posts;
                        printf(_n('%d result found', '%d results found', $total_results, 'teznevisan'), $total_results);
                        ?>
                    </div>
                </div>
                
                <!-- Enhanced Search Form -->
                <div class="search-form-wrapper">
                    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                        <div class="search-input-group">
                            <input type="search" 
                                   class="search-field" 
                                   placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'teznevisan'); ?>"
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s" />
                            <button type="submit" class="search-submit">
                                <i class="fas fa-search"></i>
                                <?php echo _x('Search', 'submit button', 'teznevisan'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Search Results Content -->
    <section class="search-results-section">
        <div class="container">
            <div class="search-layout">
                
                <!-- Search Filters -->
                <aside class="search-sidebar">
                    <div class="search-filters">
                        <h3 class="filters-title">
                            <i class="fas fa-filter"></i>
                            <?php _e('Filter Results', 'teznevisan'); ?>
                        </h3>
                        
                        <!-- Content Type Filter -->
                        <div class="filter-group">
                            <h4><?php _e('Content Type', 'teznevisan'); ?></h4>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="checkbox" name="post_type" value="post" checked>
                                    <span class="filter-label">
                                        <i class="fas fa-newspaper"></i>
                                        <?php _e('Blog Posts', 'teznevisan'); ?>
                                        <span class="result-count" id="posts-count">0</span>
                                    </span>
                                </label>
                                
                                <label class="filter-option">
                                    <input type="checkbox" name="post_type" value="services" checked>
                                    <span class="filter-label">
                                        <i class="fas fa-hammer"></i>
                                        <?php _e('Services', 'teznevisan'); ?>
                                        <span class="result-count" id="services-count">0</span>
                                    </span>
                                </label>
                                
                                <label class="filter-option">
                                    <input type="checkbox" name="post_type" value="page" checked>
                                    <span class="filter-label">
                                        <i class="fas fa-file"></i>
                                        <?php _e('Pages', 'teznevisan'); ?>
                                        <span class="result-count" id="pages-count">0</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Category Filter -->
                        <?php 
                        $categories = get_categories(array('hide_empty' => false));
                        if ($categories): ?>
                        <div class="filter-group">
                            <h4><?php _e('Categories', 'teznevisan'); ?></h4>
                            <div class="filter-options">
                                <?php foreach ($categories as $category): ?>
                                    <label class="filter-option">
                                        <input type="checkbox" name="category" value="<?php echo $category->slug; ?>">
                                        <span class="filter-label">
                                            <i class="fas fa-folder"></i>
                                            <?php echo $category->name; ?>
                                            <span class="result-count"><?php echo $category->count; ?></span>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Date Filter -->
                        <div class="filter-group">
                            <h4><?php _e('Date Range', 'teznevisan'); ?></h4>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="date_filter" value="all" checked>
                                    <span class="filter-label"><?php _e('All Time', 'teznevisan'); ?></span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="date_filter" value="week">
                                    <span class="filter-label"><?php _e('Last Week', 'teznevisan'); ?></span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="date_filter" value="month">
                                    <span class="filter-label"><?php _e('Last Month', 'teznevisan'); ?></span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="date_filter" value="year">
                                    <span class="filter-label"><?php _e('Last Year', 'teznevisan'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Sort Options -->
                        <div class="filter-group">
                            <h4><?php _e('Sort By', 'teznevisan'); ?></h4>
                            <select id="sort-results" class="sort-select">
                                <option value="relevance"><?php _e('Relevance', 'teznevisan'); ?></option>
                                <option value="date"><?php _e('Date (Newest)', 'teznevisan'); ?></option>
                                <option value="date-asc"><?php _e('Date (Oldest)', 'teznevisan'); ?></option>
                                <option value="title"><?php _e('Title (A-Z)', 'teznevisan'); ?></option>
                                <option value="title-desc"><?php _e('Title (Z-A)', 'teznevisan'); ?></option>
                            </select>
                        </div>
                        
                        <!-- Clear Filters -->
                        <button type="button" class="clear-filters-btn">
                            <i class="fas fa-times"></i>
                            <?php _e('Clear All Filters', 'teznevisan'); ?>
                        </button>
                    </div>
                </aside>
                
                <!-- Search Results -->
                <main class="search-results-main">
                    <?php if (have_posts()) : ?>
                        
                        <!-- Results Summary -->
                        <div class="results-summary">
                            <div class="results-info">
                                <span class="results-count">
                                    <?php printf(__('Showing %d results', 'teznevisan'), $total_results); ?>
                                </span>
                                <span class="search-term-info">
                                    <?php printf(__('for "%s"', 'teznevisan'), '<strong>' . get_search_query() . '</strong>'); ?>
                                </span>
                            </div>
                            
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="list" title="<?php _e('List View', 'teznevisan'); ?>">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button class="view-btn" data-view="grid" title="<?php _e('Grid View', 'teznevisan'); ?>">
                                    <i class="fas fa-th"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Results Container -->
                        <div class="search-results-container list-view" id="search-results">
                            
                            <?php while (have_posts()) : the_post(); 
                                $post_type = get_post_type();
                                $post_type_obj = get_post_type_object($post_type);
                            ?>
                                
                                <article class="search-result-item <?php echo $post_type; ?>-result" 
                                         data-post-type="<?php echo $post_type; ?>"
                                         data-date="<?php echo get_the_date('Y-m-d'); ?>"
                                         data-title="<?php echo esc_attr(get_the_title()); ?>">
                                    
                                    <div class="result-content">
                                        <!-- Result Header -->
                                        <div class="result-header">
                                            <div class="result-meta">
                                                <span class="result-type <?php echo $post_type; ?>-type">
                                                    <?php if ($post_type === 'post'): ?>
                                                        <i class="fas fa-newspaper"></i>
                                                    <?php elseif ($post_type === 'services'): ?>
                                                        <i class="fas fa-hammer"></i>
                                                    <?php elseif ($post_type === 'page'): ?>
                                                        <i class="fas fa-file"></i>
                                                    <?php else: ?>
                                                        <i class="fas fa-file-alt"></i>
                                                    <?php endif; ?>
                                                    <?php echo $post_type_obj->labels->singular_name; ?>
                                                </span>
                                                
                                                <?php if ($post_type === 'post'): ?>
                                                    <span class="result-date">
                                                        <i class="fas fa-calendar"></i>
                                                        <?php echo get_the_date(); ?>
                                                    </span>
                                                    
                                                    <?php if (get_the_category()): ?>
                                                        <span class="result-category">
                                                            <i class="fas fa-folder"></i>
                                                            <?php echo get_the_category()[0]->name; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
                                                <?php if ($post_type === 'services'): ?>
                                                    <?php 
                                                    $service_categories = get_the_terms(get_the_ID(), 'service-category');
                                                    if ($service_categories && !is_wp_error($service_categories)): ?>
                                                        <span class="result-category">
                                                            <i class="fas fa-tags"></i>
                                                            <?php echo $service_categories[0]->name; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    
                                                    <?php 
                                                    $service_price = get_post_meta(get_the_ID(), 'service_price', true);
                                                    if ($service_price): ?>
                                                        <span class="result-price">
                                                            <i class="fas fa-tag"></i>
                                                            <?php echo esc_html($service_price); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Breadcrumb -->
                                            <div class="result-breadcrumb">
                                                <a href="<?php echo home_url(); ?>">
                                                    <i class="fas fa-home"></i>
                                                    <?php _e('Home', 'teznevisan'); ?>
                                                </a>
                                                <span class="breadcrumb-separator">›</span>
                                                
                                                <?php if ($post_type === 'post' && get_the_category()): ?>
                                                    <a href="<?php echo get_category_link(get_the_category()[0]->term_id); ?>">
                                                        <?php echo get_the_category()[0]->name; ?>
                                                    </a>
                                                    <span class="breadcrumb-separator">›</span>
                                                <?php elseif ($post_type === 'services'): ?>
                                                    <a href="<?php echo get_post_type_archive_link('services'); ?>">
                                                        <?php _e('Services', 'teznevisan'); ?>
                                                    </a>
                                                    <span class="breadcrumb-separator">›</span>
                                                <?php endif; ?>
                                                
                                                <span class="current-page"><?php the_title(); ?></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Result Main Content -->
                                        <div class="result-main">
                                            <?php if (has_post_thumbnail()): ?>
                                                <div class="result-thumbnail">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="result-text">
                                                <h2 class="result-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>
                                                
                                                <div class="result-excerpt">
                                                    <?php 
                                                    $excerpt = get_the_excerpt();
                                                    if (!$excerpt) {
                                                        $content = get_the_content();
                                                        $excerpt = wp_trim_words(strip_tags($content), 30);
                                                    }
                                                    
                                                    // Highlight search term
                                                    $search_term = get_search_query();
                                                    if ($search_term) {
                                                        $excerpt = preg_replace('/(' . preg_quote($search_term, '/') . ')/i', '<mark>$1</mark>', $excerpt);
                                                    }
                                                    echo $excerpt;
                                                    ?>
                                                </div>
                                                
                                                <!-- Result Stats -->
                                                <div class="result-stats">
                                                    <?php if ($post_type === 'post'): ?>
                                                        <span class="stat-item">
                                                            <i class="fas fa-eye"></i>
                                                            <?php echo number_format(teznevisan_get_post_views()); ?>
                                                        </span>
                                                        <span class="stat-item">
                                                            <i class="fas fa-comments"></i>
                                                            <?php echo get_comments_number(); ?>
                                                        </span>
                                                        <span class="stat-item">
                                                            <i class="fas fa-clock"></i>
                                                            <?php echo teznevisan_reading_time_persian(); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($post_type === 'services'): ?>
                                                        <?php 
                                                        $featured = get_post_meta(get_the_ID(), 'featured_service', true);
                                                        if ($featured): ?>
                                                            <span class="stat-item featured">
                                                                <i class="fas fa-star"></i>
                                                                <?php _e('Featured', 'teznevisan'); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <span class="stat-item">
                                                            <i class="fas fa-calendar-plus"></i>
                                                            <?php printf(__('Added %s', 'teznevisan'), human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Result Actions -->
                                                <div class="result-actions">
                                                    <a href="<?php the_permalink(); ?>" class="result-read-more">
                                                        <i class="fas fa-arrow-left"></i>
                                                        <?php 
                                                        if ($post_type === 'services') {
                                                            _e('View Service', 'teznevisan');
                                                        } elseif ($post_type === 'post') {
                                                            _e('Read More', 'teznevisan');
                                                        } else {
                                                            _e('View Page', 'teznevisan');
                                                        }
                                                        ?>
                                                    </a>
                                                    
                                                    <span class="result-url">
                                                        <i class="fas fa-link"></i>
                                                        <?php echo esc_url(get_permalink()); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                
                            <?php endwhile; ?>
                            
                        </div>
                        
                        <!-- Pagination -->
                        <div class="search-pagination">
                            <?php
                            $big = 999999999;
                            echo paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $wp_query->max_num_pages,
                                'prev_text' => '<i class="fas fa-chevron-right"></i> ' . __('Previous', 'teznevisan'),
                                'next_text' => __('Next', 'teznevisan') . ' <i class="fas fa-chevron-left"></i>',
                                'type' => 'list',
                            ));
                            ?>
                        </div>
                        
                    <?php else : ?>
                        
                        <!-- No Results Found -->
                        <div class="no-results-found">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            
                            <h2 class="no-results-title">
                                <?php _e('No results found', 'teznevisan'); ?>
                            </h2>
                            
                            <p class="no-results-message">
                                <?php printf(__('Sorry, no results were found for "%s". Try adjusting your search terms or browse our categories below.', 'teznevisan'), '<strong>' . get_search_query() . '</strong>'); ?>
                            </p>
                            
                            <!-- Alternative Search Form -->
                            <div class="alternative-search">
                                <h3><?php _e('Try a different search:', 'teznevisan'); ?></h3>
                                <form role="search" method="get" class="alternative-search-form" action="<?php echo home_url('/'); ?>">
                                    <input type="search" 
                                           class="search-field" 
                                           placeholder="<?php echo esc_attr_x('Enter new search terms...', 'placeholder', 'teznevisan'); ?>"
                                           name="s" />
                                    <button type="submit" class="search-submit">
                                        <i class="fas fa-search"></i>
                                        <?php _e('Search', 'teznevisan'); ?>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Suggested Categories -->
                            <div class="suggested-categories">
                                <h3><?php _e('Browse by category:', 'teznevisan'); ?></h3>
                                <div class="categories-grid">
                                    <?php
                                    $categories = get_categories(array('number' => 6, 'orderby' => 'count', 'order' => 'DESC'));
                                    foreach ($categories as $category):
                                    ?>
                                        <a href="<?php echo get_category_link($category->term_id); ?>" class="category-link">
                                            <i class="fas fa-folder"></i>
                                            <?php echo $category->name; ?>
                                            <span class="category-count">(<?php echo $category->count; ?>)</span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Popular Services -->
                            <?php
                            $popular_services = get_posts(array(
                                'post_type' => 'services',
                                'posts_per_page' => 3,
                                'meta_key' => 'featured_service',
                                'meta_value' => '1'
                            ));
                            
                            if ($popular_services):
                            ?>
                                <div class="popular-services">
                                    <h3><?php _e('Popular Services:', 'teznevisan'); ?></h3>
                                    <div class="services-grid">
                                        <?php foreach ($popular_services as $service): ?>
                                            <div class="service-card">
                                                <?php if (has_post_thumbnail($service->ID)): ?>
                                                    <div class="service-thumbnail">
                                                        <?php echo get_the_post_thumbnail($service->ID, 'thumbnail'); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="service-content">
                                                    <h4>
                                                        <a href="<?php echo get_permalink($service); ?>">
                                                            <?php echo get_the_title($service); ?>
                                                        </a>
                                                    </h4>
                                                    <p><?php echo wp_trim_words(get_the_excerpt($service), 15); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                        
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </section>
</main>

<style>
/* Search Results Styles */
.search-page-main {
    background: var(--bg-secondary);
    padding-top: 70px;
    min-height: 100vh;
    font-family: 'IRANSans', sans-serif;
}

.search-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 3rem 0;
}

.search-header-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
    align-items: center;
}

.search-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.search-term {
    color: #FFD700;
    font-weight: 800;
}

.search-stats {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
}

.search-form-wrapper {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
}

.search-input-group {
    display: flex;
    gap: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.search-field {
    flex: 1;
    padding: 1rem 1.25rem;
    border: none;
    background: white;
    color: var(--text-primary);
    font-family: 'IRANSans', sans-serif;
    font-size: 1rem;
}

.search-submit {
    background: var(--secondary-color);
    color: white;
    border: none;
    padding: 1rem 1.5rem;
    cursor: pointer;
    font-weight: 600;
    font-family: 'IRANSans', sans-serif;
    transition: all 0.3s ease;
}

.search-submit:hover {
    background: var(--primary-dark);
}

.search-results-section {
    padding: 4rem 0;
}

.search-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 3rem;
}

/* Search Sidebar */
.search-sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.search-filters {
    background: var(--bg-main);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.filters-title {
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 0.5rem;
}

.filter-group {
    margin-bottom: 2rem;
}

.filter-group h4 {
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.filter-options {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.filter-option {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.filter-option:hover {
    background: var(--bg-secondary);
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.filter-label i {
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

.result-count {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-left: auto;
}

.sort-select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: 'IRANSans', sans-serif;
}

.clear-filters-btn {
    width: 100%;
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'IRANSans', sans-serif;
    transition: all 0.3s ease;
}

.clear-filters-btn:hover {
    background: #c82333;
}

/* Search Results Main */
.results-summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--bg-main);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.results-info {
    color: var(--text-secondary);
}

.results-count {
    font-weight: 600;
    color: var(--primary-color);
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    width: 40px;
    height: 40px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.search-results-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.search-results-container.grid-view {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 2rem;
}

/* Search Result Item */
.search-result-item {
    background: var(--bg-main);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.search-result-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(31, 165, 71, 0.15);
    border-color: var(--primary-color);
}

.result-content {
    padding: 1.5rem;
}

.result-header {
    margin-bottom: 1rem;
}

.result-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
}

.result-type {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    color: white;
}

.post-type {
    background: var(--primary-color);
}

.services-type {
    background: #e74c3c;
}

.page-type {
    background: #3498db;
}

.result-date,
.result-category,
.result-price {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.result-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.result-breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.result-breadcrumb a:hover {
    color: var(--primary-dark);
}

.breadcrumb-separator {
    color: var(--text-muted);
}

.current-page {
    color: var(--text-secondary);
    font-weight: 500;
}

.result-main {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.result-thumbnail {
    flex-shrink: 0;
    width: 120px;
    height: 90px;
    overflow: hidden;
    border-radius: 8px;
}

.result-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.search-result-item:hover .result-thumbnail img {
    transform: scale(1.05);
}

.result-text {
    flex: 1;
}

.result-title {
    margin: 0 0 0.75rem 0;
    font-size: 1.2rem;
    font-weight: 600;
    line-height: 1.4;
}

.result-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.result-title a:hover {
    color: var(--primary-color);
}

.result-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.result-excerpt mark {
    background: rgba(255, 215, 0, 0.3);
    color: var(--text-primary);
    padding: 0.1rem 0.2rem;
    border-radius: 3px;
    font-weight: 600;
}

.result-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.8rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--text-muted);
}

.stat-item.featured {
    color: #FFD700;
    font-weight: 600;
}

.stat-item i {
    width: 14px;
    text-align: center;
}

.result-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border-color);
    padding-top: 1rem;
}

.result-read-more {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.result-read-more:hover {
    color: var(--primary-dark);
    transform: translateX(-3px);
}

.result-url {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.7rem;
    color: var(--text-muted);
}

/* Search Pagination */
.search-pagination {
    margin-top: 3rem;
    text-align: center;
}

.search-pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--bg-main);
    color: var(--text-primary);
    text-decoration: none;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin: 0 0.25rem;
    transition: all 0.3s ease;
}

.search-pagination .page-numbers:hover,
.search-pagination .page-numbers.current {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* No Results */
.no-results-found {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-main);
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.no-results-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

.no-results-title {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.no-results-message {
    color: var(--text-secondary);
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 3rem;
}

.alternative-search {
    margin-bottom: 3rem;
}

.alternative-search h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.alternative-search-form {
    display: flex;
    max-width: 500px;
    margin: 0 auto;
    gap: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.suggested-categories,
.popular-services {
    margin-bottom: 2rem;
}

.suggested-categories h3,
.popular-services h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.category-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.category-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.category-count {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-left: auto;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.service-card {
    background: var(--bg-secondary);
    border-radius: 10px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.service-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.service-thumbnail {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 50%;
    margin-bottom: 1rem;
}

.service-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.service-card h4 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
}

.service-card h4 a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.service-card h4 a:hover {
    color: var(--primary-color);
}

.service-card p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Grid view modifications */
.grid-view .search-result-item {
    height: fit-content;
}

.grid-view .result-main {
    flex-direction: column;
    text-align: center;
}

.grid-view .result-thumbnail {
    width: 100%;
    height: 150px;
    margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 1200px) {
    .search-layout {
        grid-template-columns: 280px 1fr;
        gap: 2rem;
    }
}

@media (max-width: 992px) {
    .search-header-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        text-align: center;
    }
    
    .search-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .search-sidebar {
        position: static;
        order: -1;
    }
    
    .search-filters {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .search-header {
        padding: 2rem 0;
    }
    
    .search-title {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .results-summary {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .result-main {
        flex-direction: column;
    }
    
    .result-thumbnail {
        width: 100%;
        height: 150px;
    }
    
    .result-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .result-actions {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .categories-grid,
    .services-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search filters functionality
    const filterCheckboxes = document.querySelectorAll('.filter-option input[type="checkbox"]');
    const filterRadios = document.querySelectorAll('.filter-option input[type="radio"]');
    const sortSelect = document.getElementById('sort-results');
    const viewToggle = document.querySelectorAll('.view-btn');
    const resultsContainer = document.getElementById('search-results');
    const clearFiltersBtn = document.querySelector('.clear-filters-btn');
    
    // Filter by post type
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            filterResults();
        });
    });
    
    // Filter by date
    filterRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            filterResults();
        });
    });
    
    // Sort results
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            sortResults(this.value);
        });
    }
    
    // View toggle
    viewToggle.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            
            viewToggle.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            resultsContainer.className = `search-results-container ${view}-view`;
        });
    });
    
    // Clear filters
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            filterCheckboxes.forEach(cb => cb.checked = true);
            filterRadios.forEach(radio => {
                if (radio.value === 'all') radio.checked = true;
            });
            sortSelect.value = 'relevance';
            filterResults();
        });
    }
    
    function filterResults() {
        const selectedTypes = Array.from(filterCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        const selectedDate = document.querySelector('input[name="date_filter"]:checked')?.value || 'all';
        
        const resultItems = document.querySelectorAll('.search-result-item');
        
        resultItems.forEach(item => {
            const postType = item.dataset.postType;
            const postDate = new Date(item.dataset.date);
            const now = new Date();
            
            let showByType = selectedTypes.includes(postType);
            let showByDate = true;
            
            if (selectedDate !== 'all') {
                const diff = now - postDate;
                const days = diff / (1000 * 60 * 60 * 24);
                
                switch (selectedDate) {
                    case 'week':
                        showByDate = days <= 7;
                        break;
                    case 'month':
                        showByDate = days <= 30;
                        break;
                    case 'year':
                        showByDate = days <= 365;
                        break;
                }
            }
            
            if (showByType && showByDate) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
        
        updateResultCounts();
    }
    
    function sortResults(criteria) {
        const resultsArray = Array.from(document.querySelectorAll('.search-result-item'));
        
        resultsArray.sort((a, b) => {
            switch (criteria) {
                case 'date':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'date-asc':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'title':
                    return a.dataset.title.localeCompare(b.dataset.title);
                case 'title-desc':
                    return b.dataset.title.localeCompare(a.dataset.title);
                default:
                    return 0;
            }
        });
        
        resultsArray.forEach(item => {
            resultsContainer.appendChild(item);
        });
    }
    
    function updateResultCounts() {
        const postTypes = ['post', 'services', 'page'];
        
        postTypes.forEach(type => {
            const count = document.querySelectorAll(`.${type}-result:not([style*="display: none"])`).length;
            const countElement = document.getElementById(`${type}s-count`);
            if (countElement) {
                countElement.textContent = count;
            }
        });
    }
    
    // Initial count update
    updateResultCounts();
    
    // Highlight search terms in results
    const searchTerm = new URLSearchParams(window.location.search).get('s');
    if (searchTerm) {
        highlightSearchTerms(searchTerm);
    }
    
    function highlightSearchTerms(term) {
        const resultExcerpts = document.querySelectorAll('.result-excerpt');
        const regex = new RegExp(`(${term.replace(/[.*+?^${}()|[\$\\$/g, '\\$&')})`, 'gi');
        
        resultExcerpts.forEach(excerpt => {
            if (excerpt.innerHTML.indexOf('<mark>') === -1) { // Don't double-highlight
                excerpt.innerHTML = excerpt.innerHTML.replace(regex, '<mark>$1</mark>');
            }
        });
    }
});
</script>

<?php get_footer(); ?>