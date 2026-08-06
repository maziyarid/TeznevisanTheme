<?php
/*
Template Name: Service Categories Hub
*/
get_header();
?>

<main id="main-content" class="service-categories-hub-main">
    
    <!-- Service Categories Hero -->
    <section class="service-categories-hero">
        <div class="hero-background">
            <div class="hero-network">
                <?php for ($i = 1; $i <= 15; $i++): ?>
                    <div class="network-node node-<?php echo $i; ?>"></div>
                <?php endfor; ?>
                <?php for ($i = 1; $i <= 20; $i++): ?>
                    <div class="network-connection connection-<?php echo $i; ?>"></div>
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
                            <a href="<?php echo get_post_type_archive_link('services'); ?>" itemprop="item">
                                <span itemprop="name">خدمات</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name">دسته‌بندی خدمات</span>
                            <meta itemprop="position" content="3" />
                        </li>
                    </ol>
                </nav>
                
                <div class="hero-info">
                    <div class="hero-badge">
                        <i class="fas fa-tools"></i>
                        <span>مرکز دسته‌بندی خدمات تزنویسان</span>
                    </div>
                    
                    <h1 class="hero-title">
                        دسته‌بندی‌های
                        <span class="highlight-text">خدمات تخصصی</span>
                    </h1>
                    
                    <p class="hero-description">
                        مجموعه کاملی از خدمات تخصصی نگارش، تحقیق و مشاوره که به دسته‌بندی‌های مختلف 
                        تقسیم شده‌اند. هر دسته‌بندی شامل خدمات ویژه‌ای است که توسط متخصصان مجرب ارائه می‌شود.
                    </p>
                    
                    <?php
                    $service_categories = get_terms(array(
                        'taxonomy' => 'service_category',
                        'hide_empty' => false
                    ));
                    
                    $total_services = wp_count_posts('services')->publish ?? 0;
                    $total_categories = count($service_categories);
                    ?>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <i class="fas fa-layer-group"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $total_categories; ?></span>
                                <span class="stat-label">دسته‌بندی</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-tools"></i>
                            <div class="stat-content">
                                <span class="stat-number"><?php echo $total_services; ?></span>
                                <span class="stat-label">خدمت</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <div class="stat-content">
                                <span class="stat-number">۴۵۰+</span>
                                <span class="stat-label">متخصص</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <div class="stat-content">
                                <span class="stat-number">۹۸%</span>
                                <span class="stat-label">رضایت</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="services-network-visual">
                        <div class="network-container">
                            <?php
                            $featured_service_cats = array_slice($service_categories, 0, 6);
                            $service_colors = [
                                '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD'
                            ];
                            
                            foreach ($featured_service_cats as $index => $service_cat):
                                $color = $service_colors[$index % count($service_colors)];
                                $angle = ($index / count($featured_service_cats)) * 360;
                                $radius = 100;
                                $x = 50 + ($radius * cos(deg2rad($angle)) / 3);
                                $y = 50 + ($radius * sin(deg2rad($angle)) / 3);
                            ?>
                                <div class="service-node" 
                                     style="top: <?php echo $y; ?>%; 
                                            left: <?php echo $x; ?>%;
                                            --service-color: <?php echo $color; ?>">
                                    <div class="service-icon">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <span class="service-name"><?php echo esc_html(wp_trim_words($service_cat->name, 2, '')); ?></span>
                                    <span class="service-count"><?php echo $service_cat->count; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="network-center">
                            <div class="center-hub">
                                <i class="fas fa-tools"></i>
                            </div>
                            <span class="center-label">خدمات</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Service Categories Grid -->
    <section class="service-categories-grid-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-th-large"></i>
                    همه دسته‌بندی‌های خدمات
                </h2>
                <p class="section-description">خدمات تخصصی ما در دسته‌بندی‌های مختلف ارائه می‌شود</p>
            </div>
            
            <!-- Filter Controls -->
            <div class="categories-filter">
                <div class="filter-left">
                    <div class="search-box">
                        <input type="text" 
                               id="service-categories-search" 
                               placeholder="جستجو در دسته‌بندی‌ها..."
                               class="search-input">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <div class="filter-right">
                    <div class="sort-control">
                        <label for="service-categories-sort">مرتب‌سازی:</label>
                        <select id="service-categories-sort">
                            <option value="count-desc">پرخدمات‌ترین</option>
                            <option value="count-asc">کم‌خدمات‌ترین</option>
                            <option value="name-asc">الفبایی</option>
                            <option value="popular">محبوب‌ترین</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="service-categories-grid">
                <?php
                $service_category_colors = [
                    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
                    '#FFEAA7', '#DDA0DD', '#74B9FF', '#FD79A8',
                    '#A29BFE', '#6C5CE7', '#00B894', '#00CEC9'
                ];
                
                foreach ($service_categories as $index => $service_category):
                    $color = $service_category_colors[$index % count($service_category_colors)];
                    
                    // Get services in this category
                    $category_services = get_posts(array(
                        'post_type' => 'services',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'service_category',
                                'field'    => 'term_id',
                                'terms'    => $service_category->term_id,
                            )
                        ),
                        'numberposts' => -1,
                        'post_status' => 'publish'
                    ));
                    
                    // Calculate average price range
                    $total_min_price = 0;
                    $total_max_price = 0;
                    $price_count = 0;
                    
                    foreach ($category_services as $service) {
                        $min_price = get_post_meta($service->ID, 'price_range_min', true);
                        $max_price = get_post_meta($service->ID, 'price_range_max', true);
                        if ($min_price) {
                            $total_min_price += (int)$min_price;
                            $price_count++;
                        }
                        if ($max_price) {
                            $total_max_price += (int)$max_price;
                        }
                    }
                    
                    $avg_min_price = $price_count > 0 ? round($total_min_price / $price_count) : 0;
                    $avg_max_price = $price_count > 0 ? round($total_max_price / $price_count) : 0;
                ?>
                    <div class="service-category-card" 
                         style="--service-color: <?php echo $color; ?>"
                         data-name="<?php echo esc_attr(strtolower($service_category->name)); ?>"
                         data-count="<?php echo $service_category->count; ?>"
                         data-price="<?php echo $avg_min_price; ?>">
                        
                        <div class="card-background">
                            <div class="card-pattern"></div>
                            <div class="card-glow"></div>
                        </div>
                        
                        <div class="card-header">
                            <div class="category-icon-wrapper">
                                <div class="category-icon">
                                    <?php
                                    // Icon mapping for different service categories
                                    $icons = [
                                        'نگارش پایان‌نامه' => 'fas fa-graduation-cap',
                                        'مقاله علمی' => 'fas fa-newspaper',
                                        'ترجمه' => 'fas fa-language',
                                        'ویرایش' => 'fas fa-edit',
                                        'تحلیل آماری' => 'fas fa-chart-bar',
                                        'برنامه‌نویسی' => 'fas fa-code'
                                    ];
                                    $icon = $icons[$service_category->name] ?? 'fas fa-cogs';
                                    ?>
                                    <i class="<?php echo $icon; ?>"></i>
                                </div>
                                <div class="icon-glow"></div>
                            </div>
                            
                            <h3 class="category-title">
                                <a href="<?php echo get_term_link($service_category); ?>">
                                    <?php echo esc_html($service_category->name); ?>
                                </a>
                            </h3>
                            
                            <?php if ($service_category->description): ?>
                                <p class="category-description">
                                    <?php echo wp_trim_words($service_category->description, 25); ?>
                                </p>
                            <?php else: ?>
                                <p class="category-description">
                                    خدمات تخصصی <?php echo esc_html($service_category->name); ?> 
                                    با کیفیت بالا و تضمین رضایت مشتری
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-stats">
                            <div class="stats-row">
                                <div class="stat-box">
                                    <i class="fas fa-tools"></i>
                                    <div class="stat-info">
                                        <span class="stat-number"><?php echo $service_category->count; ?></span>
                                        <span class="stat-label">خدمت</span>
                                    </div>
                                </div>
                                
                                <?php if ($avg_min_price > 0): ?>
                                    <div class="stat-box">
                                        <i class="fas fa-tag"></i>
                                        <div class="stat-info">
                                            <span class="stat-number">از <?php echo number_format($avg_min_price / 1000); ?>K</span>
                                            <span class="stat-label">تومان</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="popularity-bar">
                                <div class="popularity-fill" 
                                     style="width: <?php echo min(100, ($service_category->count / max(1, $total_services)) * 100 * 5); ?>%"></div>
                            </div>
                        </div>
                        
                        <!-- Services Preview -->
                        <div class="services-preview">
                            <h4 class="preview-title">
                                <i class="fas fa-list"></i>
                                خدمات این دسته
                            </h4>
                            
                            <?php if ($category_services): ?>
                                <div class="services-list">
                                    <?php foreach (array_slice($category_services, 0, 4) as $service): ?>
                                        <div class="service-item">
                                            <div class="service-info">
                                                <a href="<?php echo get_permalink($service); ?>" class="service-link">
                                                    <?php echo esc_html(get_the_title($service)); ?>
                                                </a>
                                                <?php
                                                $service_price = get_post_meta($service->ID, 'price_range_min', true);
                                                if ($service_price):
                                                ?>
                                                    <span class="service-price">از <?php echo number_format($service_price); ?> تومان</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <?php if (count($category_services) > 4): ?>
                                        <div class="more-services">
                                            <span>+ <?php echo count($category_services) - 4; ?> خدمت دیگر</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="no-services-preview">
                                    <span>به زودی خدمات این دسته اضافه خواهد شد</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-actions">
                            <a href="<?php echo get_term_link($service_category); ?>" class="btn-view-services">
                                <i class="fas fa-eye"></i>
                                مشاهده همه خدمات
                            </a>
                            
                            <div class="card-tools">
                                <button class="tool-btn contact-btn" 
                                        data-category="<?php echo esc_attr($service_category->name); ?>"
                                        title="مشاوره رایگان">
                                    <i class="fas fa-phone"></i>
                                </button>
                                <button class="tool-btn quote-btn" 
                                        data-category-id="<?php echo $service_category->term_id; ?>"
                                        title="درخواست قیمت">
                                    <i class="fas fa-calculator"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Quality Badges -->
                        <div class="quality-badges">
                            <div class="quality-badge">
                                <i class="fas fa-shield-check"></i>
                                <span>تضمین کیفیت</span>
                            </div>
                            <div class="quality-badge">
                                <i class="fas fa-clock"></i>
                                <span>تحویل سریع</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Services Overview -->
    <section class="services-overview-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    نمای کلی خدمات
                </h2>
                <p class="section-description">آمار و اطلاعات جامع از خدمات ارائه شده</p>
            </div>
            
            <div class="overview-dashboard">
                <div class="overview-widgets">
                    
                    <!-- Services Distribution -->
                    <div class="overview-widget">
                        <div class="widget-header">
                            <h3>
                                <i class="fas fa-chart-pie"></i>
                                توزیع خدمات
                            </h3>
                        </div>
                        <div class="widget-content">
                            <div class="distribution-chart">
                                <?php
                                foreach ($service_categories as $index => $cat):
                                    $percentage = $total_services > 0 ? ($cat->count / $total_services) * 100 : 0;
                                    $color = $service_category_colors[$index % count($service_category_colors)];
                                ?>
                                    <div class="chart-segment" 
                                         style="width: <?php echo $percentage; ?>%; background: <?php echo $color; ?>"
                                         title="<?php echo esc_attr($cat->name); ?>: <?php echo $cat->count; ?> خدمت (<?php echo round($percentage, 1); ?>%)">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="distribution-legend">
                                <?php foreach (array_slice($service_categories, 0, 6) as $index => $cat): ?>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background: <?php echo $service_category_colors[$index % count($service_category_colors)]; ?>"></div>
                                        <span class="legend-text"><?php echo esc_html($cat->name); ?></span>
                                        <span class="legend-count"><?php echo $cat->count; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Ranges -->
                    <div class="overview-widget">
                        <div class="widget-header">
                            <h3>
                                <i class="fas fa-money-bill-wave"></i>
                                محدوده قیمت‌ها
                            </h3>
                        </div>
                        <div class="widget-content">
                            <div class="price-ranges">
                                <?php
                                $price_ranges = [
                                    ['min' => 0, 'max' => 500000, 'label' => 'زیر ۵۰۰ هزار'],
                                    ['min' => 500000, 'max' => 1000000, 'label' => '۵۰۰ هزار - ۱ میلیون'],
                                    ['min' => 1000000, 'max' => 2000000, 'label' => '۱ - ۲ میلیون'],
                                    ['min' => 2000000, 'max' => 5000000, 'label' => '۲ - ۵ میلیون'],
                                    ['min' => 5000000, 'max' => PHP_INT_MAX, 'label' => 'بالای ۵ میلیون']
                                ];
                                
                                foreach ($price_ranges as $range):
                                    $range_count = 0;
                                    $all_services = get_posts(array(
                                        'post_type' => 'services',
                                        'numberposts' => -1,
                                        'post_status' => 'publish'
                                    ));
                                    
                                    foreach ($all_services as $service) {
                                        $min_price = (int)get_post_meta($service->ID, 'price_range_min', true);
                                        if ($min_price >= $range['min'] && $min_price < $range['max']) {
                                            $range_count++;
                                        }
                                    }
                                    
                                    $range_percentage = $total_services > 0 ? ($range_count / $total_services) * 100 : 0;
                                ?>
                                    <div class="price-range-item">
                                        <div class="range-info">
                                            <span class="range-label"><?php echo $range['label']; ?></span>
                                            <span class="range-count"><?php echo $range_count; ?> خدمت</span>
                                        </div>
                                        <div class="range-bar">
                                            <div class="range-fill" style="width: <?php echo $range_percentage; ?>%"></div>
                                        </div>
                                        <div class="range-percentage"><?php echo round($range_percentage, 1); ?>%</div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Popular Services -->
                    <div class="overview-widget">
                        <div class="widget-header">
                            <h3>
                                <i class="fas fa-fire"></i>
                                محبوب‌ترین خدمات
                            </h3>
                        </div>
                        <div class="widget-content">
                            <?php
                            $popular_services = get_posts(array(
                                'post_type' => 'services',
                                'numberposts' => 8,
                                'meta_key' => 'service_views',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'post_status' => 'publish'
                            ));
                            
                            if ($popular_services):
                            ?>
                                <div class="popular-services-list">
                                    <?php foreach ($popular_services as $rank => $popular_service): ?>
                                        <div class="popular-service-item">
                                            <div class="service-rank">
                                                <span><?php echo $rank + 1; ?></span>
                                            </div>
                                            
                                            <div class="service-details">
                                                <h4 class="service-title">
                                                    <a href="<?php echo get_permalink($popular_service); ?>">
                                                        <?php echo esc_html(get_the_title($popular_service)); ?>
                                                    </a>
                                                </h4>
                                                
                                                <?php
                                                $service_cats = get_the_terms($popular_service->ID, 'service_category');
                                                if ($service_cats && !is_wp_error($service_cats)):
                                                ?>
                                                    <div class="service-category-tags">
                                                        <?php foreach (array_slice($service_cats, 0, 2) as $cat): ?>
                                                            <span class="category-tag"><?php echo esc_html($cat->name); ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="service-metrics">
                                                <?php
                                                $service_views = get_post_meta($popular_service->ID, 'service_views', true) ?: 0;
                                                $service_orders = get_post_meta($popular_service->ID, 'service_orders', true) ?: 0;
                                                ?>
                                                <span class="metric views">
                                                    <i class="fas fa-eye"></i>
                                                    <?php echo number_format($service_views); ?>
                                                </span>
                                                <span class="metric orders">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <?php echo $service_orders; ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="services-cta-section">
        <div class="cta-background">
            <div class="cta-particles">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <div class="particle particle-<?php echo $i; ?>"></div>
                <?php endfor; ?>
            </div>
        </div>
        
        <div class="container">
            <div class="cta-content">
                <div class="cta-header">
                    <h2 class="cta-title">آماده شروع پروژه خود هستید؟</h2>
                    <p class="cta-description">
                        با تیم متخصص ما تماس بگیرید و بهترین خدمات نگارش را دریافت کنید
                    </p>
                </div>
                
                <div class="cta-features">
                    <div class="cta-feature">
                        <i class="fas fa-phone"></i>
                        <span>مشاوره رایگان</span>
                    </div>
                    <div class="cta-feature">
                        <i class="fas fa-shield-check"></i>
                        <span>تضمین کیفیت</span>
                    </div>
                    <div class="cta-feature">
                        <i class="fas fa-clock"></i>
                        <span>تحویل سریع</span>
                    </div>
                </div>
                
                <div class="cta-actions">
                    <a href="<?php echo home_url('/order'); ?>" class="btn-start-project">
                        <span class="btn-content">
                            <i class="fas fa-rocket"></i>
                            شروع پروژه
                        </span>
                        <div class="btn-shine"></div>
                    </a>
                    
                    <a href="<?php echo home_url('/contact'); ?>" class="btn-consultation">
                        <span class="btn-content">
                            <i class="fas fa-comments"></i>
                            مشاوره رایگان
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Service Categories Hub Comprehensive Styles */
.service-categories-hub-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    min-height: 100vh;
    font-family: inherit;
}

/* Admin bar adjustments */
body.admin-bar .service-categories-hub-main {
    padding-top: 132px;
}

@media screen and (max-width: 782px) {
    body.admin-bar .service-categories-hub-main {
        padding-top: 116px;
    }
}

/* Service Categories Hero */
.service-categories-hero {
    background: linear-gradient(135deg, #1FA547 0%, #178A3A 50%, #0f5d2a 100%);
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

.hero-network {
    position: absolute;
    width: 100%;
    height: 100%;
}

.network-node {
    position: absolute;
    width: 8px;
    height: 8px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: nodeFlicker 3s ease-in-out infinite;
}

.network-connection {
    position: absolute;
    height: 1px;
    background: rgba(255, 255, 255, 0.2);
    animation: connectionPulse 4s ease-in-out infinite;
}

/* Generate network positions */
.node-1 { top: 15%; left: 20%; animation-delay: 0s; }
.node-2 { top: 25%; left: 70%; animation-delay: 0.5s; }
.node-3 { top: 45%; left: 15%; animation-delay: 1s; }
.node-4 { top: 65%; left: 80%; animation-delay: 1.5s; }
.node-5 { top: 85%; left: 30%; animation-delay: 2s; }
.node-6 { top: 30%; left: 90%; animation-delay: 2.5s; }
.node-7 { top: 50%; left: 50%; animation-delay: 3s; }
.node-8 { top: 70%; left: 10%; animation-delay: 3.5s; }
.node-9 { top: 10%; left: 60%; animation-delay: 4s; }
.node-10 { top: 40%; left: 40%; animation-delay: 4.5s; }
.node-11 { top: 60%; left: 95%; animation-delay: 5s; }
.node-12 { top: 80%; left: 55%; animation-delay: 5.5s; }
.node-13 { top: 20%; left: 35%; animation-delay: 6s; }
.node-14 { top: 90%; left: 75%; animation-delay: 6.5s; }
.node-15 { top: 35%; left: 65%; animation-delay: 7s; }

@keyframes nodeFlicker {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.5); }
}

@keyframes connectionPulse {
    0%, 100% { opacity: 0.1; }
    50% { opacity: 0.4; }
}

.hero-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.services-network-visual {
    width: 350px;
    height: 350px;
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

.network-container {
    position: absolute;
    width: 100%;
    height: 100%;
}

.service-node {
    position: absolute;
    background: var(--service-color);
    color: white;
    padding: 0.75rem;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    animation: serviceNodeFloat 8s ease-in-out infinite;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-family: inherit;
}

@keyframes serviceNodeFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.8; }
    33% { transform: translateY(-10px) rotate(2deg); opacity: 1; }
    66% { transform: translateY(-5px) rotate(-1deg); opacity: 0.9; }
}

.service-icon {
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.service-name {
    font-size: 0.6rem;
    white-space: nowrap;
    font-family: inherit;
}

.service-count {
    font-size: 0.5rem;
    opacity: 0.8;
    font-family: inherit;
}

.network-center {
    position: relative;
    z-index: 10;
    text-align: center;
}

.center-hub {
    width: 120px;
    height: 120px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    margin: 0 auto 1rem;
    animation: hubPulse 3s ease-in-out infinite;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

@keyframes hubPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); box-shadow: 0 0 40px rgba(255, 255, 255, 0.5); }
}

.center-label {
    font-size: 1.3rem;
    font-weight: 700;
    font-family: inherit;
}

/* Service Categories Grid */
.service-categories-grid-section {
    padding: 5rem 0;
}

.categories-filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4rem;
    padding: 2rem;
    background: var(--bg-main);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    gap: 2rem;
    flex-wrap: wrap;
}

.filter-left {
    flex: 1;
    max-width: 400px;
}

.search-box {
    display: flex;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 2px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-box:focus-within {
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

.filter-right {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.service-categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
    gap: 2.5rem;
}

/* Enhanced Service Category Cards */
.service-category-card {
    background: var(--bg-main);
    border-radius: 25px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 12px 45px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.service-category-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
}

.card-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.card-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, var(--service-color) 0%, transparent 60%),
        radial-gradient(circle at 80% 80%, var(--service-color) 0%, transparent 60%);
    opacity: 0.03;
}

.card-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, var(--service-color), transparent);
}

.card-header {
    background: linear-gradient(135deg, var(--service-color), var(--service-color));
    color: white;
    padding: 3rem 2.5rem;
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
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(15px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.service-category-card:hover .category-icon {
    transform: scale(1.1) rotateY(15deg);
}

.icon-glow {
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    border: 3px solid rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    animation: iconGlow 3s infinite;
}

@keyframes iconGlow {
    0% { transform: scale(1); opacity: 0.6; }
    70% { transform: scale(1.4); opacity: 0; }
    100% { transform: scale(1.4); opacity: 0; }
}

.category-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 1.5rem 0;
    font-family: inherit;
}

.category-title a {
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-title a:hover {
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
    color: white;
}

.category-description {
    font-size: 1.1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0;
    font-family: inherit;
}

.card-stats {
    padding: 2rem 2.5rem;
    background: var(--bg-secondary);
    border-top: 1px solid var(--border-color);
    position: relative;
    z-index: 2;
}

.stats-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-main);
    padding: 1.5rem;
    border-radius: 15px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.stat-box:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-3px);
}

.stat-box i {
    font-size: 1.5rem;
    color: var(--service-color);
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
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.popularity-bar {
    width: 100%;
    height: 8px;
    background: var(--border-color);
    border-radius: 4px;
    overflow: hidden;
}

.popularity-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--service-color), var(--service-color));
    border-radius: 4px;
    transition: width 1.5s ease;
}

.services-preview {
    padding: 2rem 2.5rem;
    border-top: 1px solid var(--border-color);
    position: relative;
    z-index: 2;
}

.preview-title {
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.services-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.service-item {
    background: var(--bg-main);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.service-item:hover {
    background: rgba(31, 165, 71, 0.02);
    border-color: var(--service-color);
    transform: translateX(-3px);
}

.service-info {
    padding: 1rem 1.5rem;
}

.service-link {
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.3s ease;
    display: block;
    margin-bottom: 0.5rem;
    font-family: inherit;
}

.service-link:hover {
    color: var(--primary-color);
}

.service-price {
    color: var(--service-color);
    font-size: 0.9rem;
    font-weight: 600;
    font-family: inherit;
}

.more-services {
    text-align: center;
    padding: 1rem;
    color: var(--text-muted);
    font-style: italic;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px dashed var(--border-color);
    font-family: inherit;
}

.no-services-preview {
    text-align: center;
    padding: 2rem;
    color: var(--text-muted);
    font-style: italic;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px dashed var(--border-color);
    font-family: inherit;
}

.card-actions {
    padding: 2rem 2.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 2;
}

.btn-view-services {
    background: var(--service-color);
    color: white;
    padding: 1.25rem 2.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.btn-view-services:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    color: white;
    filter: brightness(1.1);
}

.card-tools {
    display: flex;
    gap: 0.75rem;
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
    background: var(--service-color);
    color: white;
    border-color: var(--service-color);
    transform: scale(1.1);
}

.quality-badges {
    padding: 2rem 2.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
}

.quality-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--service-color);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    font-family: inherit;
}

/* Services Overview */
.services-overview-section {
    background: var(--bg-main);
    padding: 5rem 0;
}

.overview-dashboard {
    background: var(--bg-secondary);
    border-radius: 25px;
    padding: 4rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
}

.overview-widgets {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 3rem;
}

.overview-widget {
    background: var(--bg-main);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.widget-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 2rem;
}

.widget-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.widget-content {
    padding: 2.5rem;
}

/* Distribution Chart */
.distribution-chart {
    display: flex;
    height: 25px;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1);
}

.chart-segment {
    transition: all 0.8s ease;
}

.distribution-legend {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    font-family: inherit;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    flex-shrink: 0;
}

.legend-text {
    flex: 1;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
    font-family: inherit;
}

.legend-count {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-weight: 500;
    background: var(--bg-main);
    padding: 0.25rem 0.75rem;
    border-radius: 10px;
    font-family: inherit;
}

/* Price Ranges */
.price-ranges {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.price-range-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.price-range-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.range-info {
    min-width: 150px;
}

.range-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-family: inherit;
}

.range-count {
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-family: inherit;
}

.range-bar {
    flex: 1;
    height: 10px;
    background: var(--border-color);
    border-radius: 5px;
    overflow: hidden;
}

.range-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    border-radius: 5px;
    transition: width 1.5s ease;
}

.range-percentage {
    min-width: 50px;
    text-align: center;
    font-weight: 600;
    color: var(--primary-color);
    font-family: inherit;
}

/* Popular Services */
.popular-services-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.popular-service-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.popular-service-item:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
    transform: translateY(-3px);
}

.service-rank {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
    font-family: inherit;
}

.service-details {
    flex: 1;
    min-width: 0;
}

.service-title {
    margin: 0 0 0.75rem 0;
    font-size: 1.1rem;
    font-weight: 600;
    font-family: inherit;
}

.service-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.service-title a:hover {
    color: var(--primary-color);
}

.service-category-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.category-tag {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    font-family: inherit;
}

.service-metrics {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.metric {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-family: inherit;
}

.metric.views i { color: #4ECDC4; }
.metric.orders i { color: #FF6B6B; }

/* CTA Section */
.services-cta-section {
    background: linear-gradient(135deg, #1FA547 0%, #178A3A 50%, #0f5d2a 100%);
    color: white;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.cta-particles {
    position: absolute;
    width: 100%;
    height: 100%;
}

.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: particleFloat 10s ease-in-out infinite;
}

.particle-1 { width: 20px; height: 20px; top: 20%; left: 10%; animation-delay: 0s; }
.particle-2 { width: 15px; height: 15px; top: 60%; left: 80%; animation-delay: 2s; }
.particle-3 { width: 25px; height: 25px; top: 80%; left: 20%; animation-delay: 4s; }
.particle-4 { width: 18px; height: 18px; top: 30%; left: 70%; animation-delay: 1s; }
.particle-5 { width: 22px; height: 22px; top: 50%; left: 40%; animation-delay: 3s; }
.particle-6 { width: 16px; height: 16px; top: 70%; left: 90%; animation-delay: 5s; }
.particle-7 { width: 24px; height: 24px; top: 90%; left: 60%; animation-delay: 6s; }
.particle-8 { width: 14px; height: 14px; top: 10%; left: 50%; animation-delay: 7s; }
.particle-9 { width: 26px; height: 26px; top: 40%; left: 15%; animation-delay: 8s; }
.particle-10 { width: 19px; height: 19px; top: 85%; left: 85%; animation-delay: 9s; }

@keyframes particleFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
    25% { transform: translateY(-30px) rotate(90deg); opacity: 0.7; }
    50% { transform: translateY(-60px) rotate(180deg); opacity: 1; }
    75% { transform: translateY(-30px) rotate(270deg); opacity: 0.5; }
}

.cta-content {
    text-align: center;
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.cta-header {
    margin-bottom: 3rem;
}

.cta-title {
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.cta-description {
    font-size: 1.3rem;
    line-height: 1.7;
    opacity: 0.95;
    font-family: inherit;
}

.cta-features {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.cta-feature {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1.25rem 2rem;
    border-radius: 25px;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-size: 1.1rem;
    font-family: inherit;
}

.cta-feature i {
    font-size: 1.3rem;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.btn-start-project,
.btn-consultation {
    padding: 1.5rem 3rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.btn-start-project {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.4);
}

.btn-consultation {
    background: transparent;
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.6);
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s ease;
}

.btn-start-project:hover .btn-shine {
    left: 100%;
}

.btn-start-project:hover,
.btn-consultation:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    color: white;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
    }
    
    .service-categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    }
    
    .overview-widgets {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 1024px) {
    .service-categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
    
    .categories-filter {
        flex-direction: column;
        gap: 2rem;
        align-items: stretch;
    }
    
    .filter-right {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .service-categories-hub-main {
        padding-top: 70px;
    }
    
    body.admin-bar .service-categories-hub-main {
        padding-top: 102px;
    }
    
    .service-categories-hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .service-categories-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .quality-badges {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-features {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .service-categories-hero {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 1.7rem;
    }
    
    .hero-stats {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        padding: 2rem 1.5rem;
    }
    
    .card-stats,
    .services-preview,
    .card-actions {
        padding: 1.5rem;
    }
    
    .overview-dashboard {
        padding: 2rem;
    }
    
    .widget-content {
        padding: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('service-categories-search');
    const categoriesContainer = document.querySelector('.service-categories-grid');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const categoryCards = document.querySelectorAll('.service-category-card');
            
            categoryCards.forEach(card => {
                const categoryName = card.getAttribute('data-name');
                const isVisible = !query || categoryName.includes(query);
                card.style.display = isVisible ? '' : 'none';
            });
        });
    }
    
    // Sort functionality
    const sortSelect = document.getElementById('service-categories-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const cards = Array.from(document.querySelectorAll('.service-category-card'));
            
            cards.sort((a, b) => {
                switch (sortValue) {
                    case 'count-desc':
                        return parseInt(b.getAttribute('data-count')) - parseInt(a.getAttribute('data-count'));
                    case 'count-asc':
                        return parseInt(a.getAttribute('data-count')) - parseInt(b.getAttribute('data-count'));
                    case 'name-asc':
                        return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                    case 'popular':
                        return parseInt(b.getAttribute('data-count')) - parseInt(a.getAttribute('data-count'));
                    default:
                        return 0;
                }
            });
            
            cards.forEach(card => categoriesContainer.appendChild(card));
        });
    }
    
    // Contact and Quote buttons
    const contactBtns = document.querySelectorAll('.contact-btn');
    contactBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            const phone = '<?php echo get_theme_mod("phone_number", "09162352304"); ?>';
            const message = `سلام، برای مشاوره در زمینه ${category} تماس گرفتم.`;
            const whatsappUrl = `https://wa.me/${phone.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        });
    });
    
    const quoteBtns = document.querySelectorAll('.quote-btn');
    quoteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            // Redirect to order page with category pre-selected
            window.location.href = '<?php echo home_url("/order"); ?>?category=' + categoryId;
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
    
    // Animate service category cards
    document.querySelectorAll('.service-category-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.15}s, transform 0.6s ease ${index * 0.15}s`;
        observer.observe(card);
    });
    
    // Animate charts and bars
    const chartSegments = document.querySelectorAll('.chart-segment');
    const rangeFills = document.querySelectorAll('.range-fill');
    const popularityFills = document.querySelectorAll('.popularity-fill');
    
    const chartObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.style.width;
                entry.target.style.width = '0%';
                setTimeout(() => {
                    entry.target.style.width = width;
                }, 300);
            }
        });
    }, { threshold: 0.5 });
    
    [...chartSegments, ...rangeFills, ...popularityFills].forEach(element => {
        chartObserver.observe(element);
    });
});
</script>

<?php get_footer(); ?>