<?php
/**
 * Single Post Template - Complete Professional Implementation
 * All E-E-A-T, Helpful Content, and SEO Features
 * Version: 3.0.0 - Fully Responsive & Feature-Rich
 * 
 * @package Teznevisan
 */

get_header();

while (have_posts()) : the_post();
    
    // Get all post metadata
    $post_id = get_the_ID();
    $author_id = get_the_author_meta('ID');
    
    // Custom Fields - Post Settings
    $subtitle = get_post_meta($post_id, '_post_subtitle', true);
    $reading_time = get_post_meta($post_id, '_reading_time', true);
    if (!$reading_time) {
        $reading_time = estimate_reading_time();
    }
    $difficulty = get_post_meta($post_id, '_difficulty_level', true);
    $featured_video = get_post_meta($post_id, '_featured_video', true);
    $enable_toc = get_post_meta($post_id, '_enable_toc', true);
    
    // Story Highlights & Custom Sections
    $story_highlights = get_post_meta($post_id, '_story_highlights', true);
    $key_takeaways = get_post_meta($post_id, '_key_takeaways', true);
    $quick_summary = get_post_meta($post_id, '_quick_summary', true);
    $important_points = get_post_meta($post_id, '_important_points', true);
    $editor_notes = get_post_meta($post_id, '_editor_notes', true);
    $breaking_news = get_post_meta($post_id, '_breaking_news', true);
    $update_notice = get_post_meta($post_id, '_update_notice', true);
    $update_date = get_post_meta($post_id, '_last_update_date', true);
    $what_changed = get_post_meta($post_id, '_what_changed', true);
    
    // Source Attribution
    $source_name = get_post_meta($post_id, '_source_name', true);
    $source_url = get_post_meta($post_id, '_source_url', true);
    $via_name = get_post_meta($post_id, '_via_name', true);
    $via_url = get_post_meta($post_id, '_via_url', true);
    
    // E-E-A-T Elements
    $fact_checked = get_post_meta($post_id, '_fact_checked', true);
    $fact_checker_name = get_post_meta($post_id, '_fact_checker_name', true);
    $medical_review = get_post_meta($post_id, '_medical_review', true);
    $reviewer_name = get_post_meta($post_id, '_reviewer_name', true);
    $last_reviewed_date = get_post_meta($post_id, '_last_reviewed_date', true);
    $expert_reviewed = get_post_meta($post_id, '_expert_reviewed', true);
    $expert_name = get_post_meta($post_id, '_expert_name', true);
    
    // Author Information
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_bio = get_the_author_meta('description', $author_id);
    $author_job_title = get_user_meta($author_id, 'job_title', true);
    $author_expertise = get_user_meta($author_id, 'expertise', true);
    $author_credentials = get_user_meta($author_id, 'credentials', true);
    $author_experience = get_user_meta($author_id, 'years_experience', true);
    $author_education = get_user_meta($author_id, 'education', true);
    $author_certifications = get_user_meta($author_id, 'certifications', true);
    $author_awards = get_user_meta($author_id, 'awards', true);
    $author_website = get_the_author_meta('user_url', $author_id);
    $author_twitter = get_user_meta($author_id, 'twitter', true);
    $author_linkedin = get_user_meta($author_id, 'linkedin', true);
    $author_instagram = get_user_meta($author_id, 'instagram', true);
    
    // Post Data
    $categories = get_the_category();
    $tags = get_the_tags();
    $post_date = get_the_date('c');
    $post_modified = get_the_modified_date('c');
    $word_count = str_word_count(strip_tags(get_the_content()));
    
    // Rating Stats - SAFE VERSION
    $rating_stats = teznevisan_get_rating_stats($post_id);
    
    // Ensure rating_stats is always an array
    if (!is_array($rating_stats)) {
        $rating_stats = array(
            'likes' => 0,
            'dislikes' => 0,
            'star_average' => 0,
            'star_count' => 0
        );
    }
    
    $user_star_rating = teznevisan_user_has_rated($post_id, 'star');
    $user_liked = teznevisan_user_has_rated($post_id, 'like');
    $user_disliked = teznevisan_user_has_rated($post_id, 'dislike');
    
    // Difficulty Labels
    $difficulty_labels = array(
        'beginner' => array('label' => 'مبتدی', 'color' => '#10b981', 'icon' => 'fa-signal-bars-weak'),
        'intermediate' => array('label' => 'متوسط', 'color' => '#f59e0b', 'icon' => 'fa-signal-bars'),
        'advanced' => array('label' => 'پیشرفته', 'color' => '#ef4444', 'icon' => 'fa-signal-bars-strong')
    );
    
    // Update post views
    teznevisan_set_post_views($post_id);
    
    // Trending Badge
    $is_trending = get_post_meta($post_id, '_is_trending', true);
?>

<!-- Reading Progress Bar -->
<div class="reading-progress-bar">
    <div class="reading-progress-fill"></div>
</div>

<!-- Breaking News Banner -->
<?php if ($breaking_news) : ?>
<div class="breaking-news-banner">
    <div class="container">
        <div class="breaking-news-content">
            <span class="breaking-badge">
                <i class="fa-solid fa-bolt"></i>
                <?php _e('خبر فوری', 'teznevisan'); ?>
            </span>
            <p><?php echo esc_html($breaking_news); ?></p>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Continue with the rest of the template... -->


<!-- Breaking News Banner -->
<?php if ($breaking_news) : ?>
<div class="breaking-news-banner">
    <div class="container">
        <div class="breaking-news-content">
            <span class="breaking-badge">
                <i class="fa-solid fa-bolt"></i>
                <?php _e('خبر فوری', 'teznevisan'); ?>
            </span>
            <p><?php echo esc_html($breaking_news); ?></p>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Breadcrumb Navigation -->
<nav class="breadcrumb-wrapper" aria-label="<?php esc_attr_e('مسیر صفحه', 'teznevisan'); ?>">
    <div class="container">
        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>">
                    <i class="fa-solid fa-house"></i>
                    <span itemprop="name"><?php _e('خانه', 'teznevisan'); ?></span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <?php if (!empty($categories)) : ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>">
                        <span itemprop="name"><?php echo esc_html($categories[0]->name); ?></span>
                    </a>
                    <meta itemprop="position" content="2" />
                </li>
            <?php endif; ?>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?php the_title(); ?></span>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <div class="single-post-layout">
        
        <!-- Main Article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?> itemscope itemtype="https://schema.org/Article">
            
            <!-- Schema Markup (Hidden) -->
            <meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>" />
            <meta itemprop="datePublished" content="<?php echo esc_attr($post_date); ?>" />
            <meta itemprop="dateModified" content="<?php echo esc_attr($post_modified); ?>" />
            <meta itemprop="wordCount" content="<?php echo esc_attr($word_count); ?>" />
            <meta itemprop="inLanguage" content="fa-IR" />
            
            <!-- Article Header -->
            <header class="article-header">
                
                <!-- Category & Badges -->
                <div class="post-badges">
                    <?php if (!empty($categories)) : 
                        $primary_category = $categories[0];
                        $cat_color = get_term_meta($primary_category->term_id, 'category_color', true) ?: '#2563eb';
                    ?>
                        <a href="<?php echo esc_url(get_category_link($primary_category->term_id)); ?>" 
                           class="category-badge" 
                           style="--badge-color: <?php echo esc_attr($cat_color); ?>">
                            <i class="fa-solid fa-folder"></i>
                            <span itemprop="articleSection"><?php echo esc_html($primary_category->name); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($is_trending) : ?>
                        <span class="trending-badge">
                            <i class="fa-solid fa-fire"></i>
                            <?php _e('ترند', 'teznevisan'); ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($difficulty && isset($difficulty_labels[$difficulty])) : ?>
                        <span class="difficulty-badge" style="--badge-color: <?php echo $difficulty_labels[$difficulty]['color']; ?>">
                            <i class="fa-solid <?php echo $difficulty_labels[$difficulty]['icon']; ?>"></i>
                            <?php echo $difficulty_labels[$difficulty]['label']; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Post Title -->
                <h1 class="entry-title" itemprop="headline">
                    <?php the_title(); ?>
                </h1>
                
                <?php if ($subtitle) : ?>
                    <p class="post-subtitle" itemprop="alternativeHeadline">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <!-- Post Meta -->
                <div class="entry-meta">
                    <!-- Author Info -->
                    <div class="meta-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <?php echo get_avatar($author_id, 56, '', '', array('class' => 'author-avatar')); ?>
                        <div class="author-info-wrapper">
                            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" 
                               class="author-name" itemprop="url">
                                <span itemprop="name"><?php echo esc_html($author_name); ?></span>
                            </a>
                            <?php if ($author_job_title) : ?>
                                <span class="author-job-title" itemprop="jobTitle"><?php echo esc_html($author_job_title); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Meta Items -->
                    <div class="meta-items-wrapper">
                        <div class="meta-item">
                            <i class="fa-solid fa-calendar-days"></i>
                            <time datetime="<?php echo esc_attr($post_date); ?>" itemprop="datePublished">
                                <?php echo get_the_date('j F Y'); ?>
                            </time>
                        </div>
                        
                        <?php if ($reading_time) : ?>
                            <div class="meta-item">
                                <i class="fa-solid fa-clock"></i>
                                <span><?php echo esc_html($reading_time); ?> دقیقه</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="meta-item">
                            <i class="fa-solid fa-eye"></i>
                            <span><?php echo number_format_i18n(teznevisan_get_post_views($post_id)); ?> بازدید</span>
                        </div>
                        
                        <div class="meta-item">
                            <i class="fa-solid fa-comments"></i>
                            <span><?php comments_number('0', '1', '%'); ?> دیدگاه</span>
                        </div>
                    </div>
                </div>

                <!-- Star Rating Display -->
                <?php if (isset($rating_stats['star_average']) && isset($rating_stats['star_count'])) : ?>
                <div class="post-rating-header">
                    <div class="stars-display-large">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <i class="fa-solid fa-star <?php echo $i <= round($rating_stats['star_average']) ? 'active' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="rating-text-large">
                        <strong class="rating-number"><?php echo esc_html($rating_stats['star_average']); ?></strong>
                        <span class="rating-label">از 5 (<?php echo number_format_i18n($rating_stats['star_count']); ?> رأی)</span>
                    </div>
                </div>
                <?php endif; ?>


                <!-- E-E-A-T Badges -->
                <?php if ($fact_checked || $medical_review || $expert_reviewed || $last_reviewed_date) : ?>
                    <div class="eeat-badges">
                        <?php if ($fact_checked && $fact_checker_name) : ?>
                            <div class="eeat-badge fact-checked">
                                <i class="fa-solid fa-circle-check"></i>
                                <div class="eeat-content">
                                    <strong><?php _e('بررسی شده توسط:', 'teznevisan'); ?></strong>
                                    <span><?php echo esc_html($fact_checker_name); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($medical_review && $reviewer_name) : ?>
                            <div class="eeat-badge medical-review">
                                <i class="fa-solid fa-shield-check"></i>
                                <div class="eeat-content">
                                    <strong><?php _e('بررسی پزشکی:', 'teznevisan'); ?></strong>
                                    <span><?php echo esc_html($reviewer_name); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                                                <?php if ($expert_reviewed && $expert_name) : ?>
                            <div class="eeat-badge expert-review">
                                <i class="fa-solid fa-user-check"></i>
                                <div class="eeat-content">
                                    <strong><?php _e('بررسی کارشناس:', 'teznevisan'); ?></strong>
                                    <span><?php echo esc_html($expert_name); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($last_reviewed_date) : ?>
                            <div class="eeat-badge last-reviewed">
                                <i class="fa-solid fa-rotate-right"></i>
                                <div class="eeat-content">
                                    <strong><?php _e('آخرین بازبینی:', 'teznevisan'); ?></strong>
                                    <span><?php echo esc_html(date_i18n('j F Y', strtotime($last_reviewed_date))); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Update Notice -->
                <?php if ($update_notice || $what_changed) : ?>
                    <div class="update-notice-box">
                        <div class="update-notice-header">
                            <i class="fa-solid fa-bell"></i>
                            <strong><?php _e('به‌روزرسانی مقاله', 'teznevisan'); ?></strong>
                            <?php if ($update_date) : ?>
                                <time datetime="<?php echo esc_attr($update_date); ?>">
                                    <?php echo date_i18n('j F Y', strtotime($update_date)); ?>
                                </time>
                            <?php endif; ?>
                        </div>
                        <?php if ($update_notice) : ?>
                            <p class="update-notice-text"><?php echo esc_html($update_notice); ?></p>
                        <?php endif; ?>
                        <?php if ($what_changed) : ?>
                            <div class="what-changed">
                                <strong><?php _e('تغییرات:', 'teznevisan'); ?></strong>
                                <p><?php echo wp_kses_post($what_changed); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Editor Notes -->
                <?php if ($editor_notes) : ?>
                    <div class="editor-notes">
                        <div class="editor-notes-header">
                            <i class="fa-solid fa-circle-info"></i>
                            <strong><?php _e('یادداشت سردبیر', 'teznevisan'); ?></strong>
                        </div>
                        <div class="editor-notes-content">
                            <?php echo wp_kses_post($editor_notes); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Story Highlights -->
                <?php if ($story_highlights) : ?>
                    <div class="story-highlights">
                        <div class="highlights-header">
                            <i class="fa-solid fa-star"></i>
                            <strong><?php _e('نکات برجسته', 'teznevisan'); ?></strong>
                        </div>
                        <div class="highlights-content">
                            <?php echo wp_kses_post($story_highlights); ?>
                        </div>
                    </div>
                <?php endif; ?>

            </header>

            <!-- Social Share (Above Content) -->
            <div class="social-share social-share-top">
                <span class="share-label"><?php _e('اشتراک‌گذاری:', 'teznevisan'); ?></span>
                <div class="share-buttons">
                    <?php
                    $share_buttons = teznevisan_social_share_buttons($post_id);
                    foreach ($share_buttons as $network => $data) :
                        if ($network === 'copy') continue;
                        // Fix Twitter to X
                        $network_name = $network === 'twitter' ? 'x' : $network;
                    ?>
                        <a href="<?php echo esc_url($data['url']); ?>" 
                           class="share-button share-<?php echo esc_attr($network_name); ?>"
                           style="--share-color: <?php echo esc_attr($data['color']); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr($data['label']); ?>">
                            <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

           <!-- Featured Image -->
<?php if (has_post_thumbnail()) : ?>
    <figure class="post-thumbnail-wrapper" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <?php 
        $image_id = get_post_thumbnail_id();
        
        if ($image_id) :
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $image_caption = wp_get_attachment_caption($image_id);
            $image_full = wp_get_attachment_image_src($image_id, 'full');
            $image_large = wp_get_attachment_image_src($image_id, 'large');
            
            // Use large image if available, otherwise use full
            $image_src = ($image_large && is_array($image_large)) ? $image_large : $image_full;
            
            if ($image_src && is_array($image_src)) :
        ?>
            
            <img src="<?php echo esc_url($image_src[0]); ?>"
                 srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($image_id, 'full')); ?>"
                 sizes="(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 1200px"
                 alt="<?php echo esc_attr($image_alt ? $image_alt : get_the_title()); ?>"
                 class="post-thumbnail"
                 width="<?php echo isset($image_src[1]) ? esc_attr($image_src[1]) : ''; ?>"
                 height="<?php echo isset($image_src[2]) ? esc_attr($image_src[2]) : ''; ?>"
                 loading="eager"
                 fetchpriority="high"
                 itemprop="url" />
            
            <?php if ($image_full && is_array($image_full) && isset($image_full[1]) && isset($image_full[2])) : ?>
                <meta itemprop="width" content="<?php echo esc_attr($image_full[1]); ?>" />
                <meta itemprop="height" content="<?php echo esc_attr($image_full[2]); ?>" />
            <?php endif; ?>
            
            <?php if ($image_caption) : ?>
                <figcaption class="post-thumbnail-caption" itemprop="caption">
                    <?php echo esc_html($image_caption); ?>
                </figcaption>
            <?php endif; ?>
            
        <?php else : ?>
            <!-- Fallback: Use WordPress default thumbnail function -->
            <?php 
            the_post_thumbnail('large', array(
                'class' => 'post-thumbnail',
                'alt' => get_the_title(),
                'loading' => 'eager',
                'itemprop' => 'url'
            )); 
            ?>
        <?php 
            endif; // End image_src check
        endif; // End image_id check
        ?>
    </figure>
<?php endif; ?>

            <!-- Featured Video -->
            <?php if ($featured_video) : ?>
                <div class="featured-video-wrapper">
                    <div class="featured-video-container">
                        <?php
                        if (strpos($featured_video, 'aparat.com') !== false) {
                            preg_match('/\/v\/([a-zA-Z0-9]+)/', $featured_video, $matches);
                            if (isset($matches[1])) {
                                echo '<iframe src="https://www.aparat.com/video/video/embed/videohash/' . esc_attr($matches[1]) . '/vt/frame" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" loading="lazy"></iframe>';
                            }
                        } elseif (strpos($featured_video, 'youtube.com') !== false || strpos($featured_video, 'youtu.be') !== false) {
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $featured_video, $matches);
                            if (isset($matches[1])) {
                                echo '<iframe src="https://www.youtube.com/embed/' . esc_attr($matches[1]) . '" allowfullscreen loading="lazy"></iframe>';
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Quick Summary -->
            <?php if ($quick_summary) : ?>
                <div class="quick-summary-box">
                    <div class="summary-header">
                        <i class="fa-solid fa-lightbulb"></i>
                        <strong><?php _e('خلاصه سریع', 'teznevisan'); ?></strong>
                    </div>
                    <div class="summary-content">
                        <?php echo wp_kses_post($quick_summary); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Key Takeaways -->
            <?php if ($key_takeaways) : ?>
                <div class="key-takeaways-box">
                    <div class="takeaways-header">
                        <i class="fa-solid fa-key"></i>
                        <strong><?php _e('نکات کلیدی', 'teznevisan'); ?></strong>
                    </div>
                    <div class="takeaways-content">
                        <?php echo wp_kses_post($key_takeaways); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Important Points -->
            <?php if ($important_points) : ?>
                <div class="important-points-box">
                    <div class="points-header">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        <strong><?php _e('نکات مهم', 'teznevisan'); ?></strong>
                    </div>
                    <div class="points-content">
                        <?php echo wp_kses_post($important_points); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Table of Contents -->
            <?php 
            $content = get_the_content();
            $toc_items = extract_headings_for_toc($content);
            if (!empty($toc_items) && $enable_toc == '1') :
            ?>
                <aside class="table-of-contents" role="navigation" aria-labelledby="toc-heading">
                    <div class="toc-header">
                        <h2 id="toc-heading" class="toc-title">
                            <i class="fa-solid fa-list-ul"></i>
                            <?php _e('فهرست مطالب', 'teznevisan'); ?>
                        </h2>
                        <button class="toc-toggle" aria-label="<?php esc_attr_e('بستن/باز کردن فهرست', 'teznevisan'); ?>">
                            <i class="fa-solid fa-chevron-up"></i>
                        </button>
                    </div>
                    <ol class="toc-list">
                        <?php foreach ($toc_items as $index => $item) : ?>
                            <li class="toc-item toc-level-<?php echo esc_attr($item['level']); ?>">
                                <a href="#heading-<?php echo esc_attr($index); ?>" class="toc-link">
                                    <span class="toc-number"><?php echo ($index + 1); ?></span>
                                    <span class="toc-text"><?php echo esc_html($item['text']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </aside>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="entry-content" itemprop="articleBody">
                <?php 
                $content_with_ids = add_heading_ids($content, $toc_items);
                echo wp_kses_post($content_with_ids);
                
                wp_link_pages(array(
                    'before' => '<div class="page-links"><span class="page-links-title">' . __('صفحات:', 'teznevisan') . '</span>',
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                ));
                ?>
            </div>

            <!-- Source Attribution -->
            <?php if ($source_name || $via_name) : ?>
                <div class="source-attribution">
                    <?php if ($source_name) : ?>
                        <div class="source-item">
                            <i class="fa-solid fa-link"></i>
                            <strong><?php _e('منبع:', 'teznevisan'); ?></strong>
                            <?php if ($source_url) : ?>
                                <a href="<?php echo esc_url($source_url); ?>" target="_blank" rel="noopener noreferrer nofollow">
                                    <?php echo esc_html($source_name); ?>
                                </a>
                            <?php else : ?>
                                <span><?php echo esc_html($source_name); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($via_name) : ?>
                        <div class="source-item">
                            <i class="fa-solid fa-share-from-square"></i>
                            <strong><?php _e('از طریق:', 'teznevisan'); ?></strong>
                            <?php if ($via_url) : ?>
                                <a href="<?php echo esc_url($via_url); ?>" target="_blank" rel="noopener noreferrer nofollow">
                                    <?php echo esc_html($via_name); ?>
                                </a>
                            <?php else : ?>
                                <span><?php echo esc_html($via_name); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Article Footer -->
            <footer class="article-footer">
                
                <!-- Rating Section -->
                <div class="post-rating-section">
                    <h3 class="rating-section-title">
                        <i class="fa-solid fa-star"></i>
                        <?php _e('این مقاله را امتیاز دهید', 'teznevisan'); ?>
                    </h3>
                    
                    <!-- Star Rating Widget -->
                    <div class="star-rating-widget" data-post-id="<?php echo esc_attr($post_id); ?>">
                        <div class="stars-input">
                            <?php for ($i = 5; $i >= 1; $i--) : ?>
                                <input type="radio" 
                                       id="star-<?php echo $i; ?>" 
                                       name="star-rating" 
                                       value="<?php echo $i; ?>"
                                       <?php checked($user_star_rating, $i); ?>
                                       <?php disabled($user_star_rating !== false); ?>>
                                <label for="star-<?php echo $i; ?>" 
                                       class="star-label"
                                       title="<?php echo esc_attr($i . ' ستاره'); ?>">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                            <?php endfor; ?>
                        </div>
                                                <div class="rating-result">
                            <?php if ($user_star_rating) : ?>
                                <span class="rating-message success">
                                    <i class="fa-solid fa-check-circle"></i>
                                    <?php _e('شما این مقاله را امتیاز داده‌اید', 'teznevisan'); ?>
                                </span>
                            <?php else : ?>
                                <span class="rating-message">
                                    <?php _e('روی ستاره‌ها کلیک کنید', 'teznevisan'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Like/Dislike Widget -->
                    <div class="like-dislike-widget" data-post-id="<?php echo esc_attr($post_id); ?>">
                        <button class="like-btn <?php echo $user_liked ? 'active' : ''; ?>" 
                                data-action="like"
                                <?php disabled($user_liked || $user_disliked); ?>>
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span class="like-count"><?php echo number_format_i18n(isset($rating_stats['likes']) ? $rating_stats['likes'] : 0); ?></span>
                            <span class="like-text"><?php _e('پسندیدم', 'teznevisan'); ?></span>
                        </button>
                        
                        <button class="dislike-btn <?php echo $user_disliked ? 'active' : ''; ?>" 
                                data-action="dislike"
                                <?php disabled($user_liked || $user_disliked); ?>>
                            <i class="fa-solid fa-thumbs-down"></i>
                            <span class="dislike-count"><?php echo number_format_i18n(isset($rating_stats['dislikes']) ? $rating_stats['dislikes'] : 0); ?></span>
                            <span class="dislike-text"><?php _e('نپسندیدم', 'teznevisan'); ?></span>
                        </button>
                    </div>


                <!-- Tags -->
                <?php if (!empty($tags)) : ?>
                    <div class="post-tags">
                        <h3 class="tags-title">
                            <i class="fa-solid fa-tags"></i>
                            <?php _e('برچسب‌ها:', 'teznevisan'); ?>
                        </h3>
                        <div class="tags-list" itemprop="keywords">
                            <?php foreach ($tags as $tag) : 
                                $tag_color = get_term_meta($tag->term_id, 'tag_color', true) ?: '#3b82f6';
                            ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                   class="tag-badge" 
                                   style="--tag-color: <?php echo esc_attr($tag_color); ?>"
                                   rel="tag">
                                    <i class="fa-solid fa-hashtag"></i>
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Social Share (Below Content) -->
                <div class="social-share social-share-bottom">
                    <h3 class="share-title">
                        <i class="fa-solid fa-share-nodes"></i>
                        <?php _e('اشتراک‌گذاری:', 'teznevisan'); ?>
                    </h3>
                    <div class="share-buttons">
                        <?php
                        $share_buttons = teznevisan_social_share_buttons($post_id);
                        foreach ($share_buttons as $network => $data) :
                            $network_name = $network === 'twitter' ? 'x' : $network;
                            if ($network === 'copy') :
                        ?>
                            <button type="button" 
                                    class="share-button share-<?php echo esc_attr($network_name); ?>" 
                                    data-url="<?php echo esc_url($data['url']); ?>"
                                    style="--share-color: <?php echo esc_attr($data['color']); ?>">
                                <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                                <span class="share-text"><?php echo esc_html($data['label']); ?></span>
                            </button>
                        <?php else : ?>
                            <a href="<?php echo esc_url($data['url']); ?>" 
                               class="share-button share-<?php echo esc_attr($network_name); ?>"
                               style="--share-color: <?php echo esc_attr($data['color']); ?>"
                               target="_blank"
                               rel="noopener noreferrer">
                                <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                                <span class="share-text"><?php echo esc_html($data['label']); ?></span>
                            </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>

                <!-- Last Modified Notice -->
                <?php if (get_the_time('U') !== get_the_modified_time('U')) : ?>
                    <div class="last-modified-notice">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>
                            <?php _e('آخرین به‌روزرسانی:', 'teznevisan'); ?>
                            <time datetime="<?php echo esc_attr($post_modified); ?>" itemprop="dateModified">
                                <?php echo get_the_modified_date('j F Y - H:i'); ?>
                            </time>
                        </span>
                    </div>
                <?php endif; ?>

            </footer>

            <!-- Enhanced Author Bio -->
            <?php if ($author_bio || $author_expertise) : ?>
                <aside class="author-bio-enhanced" itemprop="author" itemscope itemtype="https://schema.org/Person">
                    <div class="author-bio-inner">
                        <div class="author-bio-avatar-wrapper">
                            <?php echo get_avatar($author_id, 120, '', '', array('class' => 'author-bio-avatar', 'itemprop' => 'image')); ?>
                            <?php if ($author_credentials) : ?>
                                <div class="author-credentials-badge">
                                    <i class="fa-solid fa-certificate"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="author-bio-content">
                            <div class="author-bio-header">
                                <h3 class="author-bio-name" itemprop="name">
                                    <?php echo esc_html($author_name); ?>
                                </h3>
                                <?php if ($author_job_title) : ?>
                                    <span class="author-bio-job-title" itemprop="jobTitle">
                                        <?php echo esc_html($author_job_title); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Author Credentials Grid -->
                            <?php if ($author_expertise || $author_experience || $author_education || $author_certifications) : ?>
                                <div class="author-credentials-grid">
                                    <?php if ($author_expertise) : ?>
                                        <div class="credential-item">
                                            <i class="fa-solid fa-award"></i>
                                            <div class="credential-content">
                                                <strong><?php _e('تخصص:', 'teznevisan'); ?></strong>
                                                <span itemprop="knowsAbout"><?php echo esc_html($author_expertise); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($author_experience) : ?>
                                        <div class="credential-item">
                                            <i class="fa-solid fa-briefcase"></i>
                                            <div class="credential-content">
                                                <strong><?php _e('سابقه:', 'teznevisan'); ?></strong>
                                                <span><?php echo esc_html($author_experience); ?> سال</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($author_education) : ?>
                                        <div class="credential-item">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <div class="credential-content">
                                                <strong><?php _e('تحصیلات:', 'teznevisan'); ?></strong>
                                                <span itemprop="alumniOf"><?php echo esc_html($author_education); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($author_certifications) : ?>
                                        <div class="credential-item">
                                            <i class="fa-solid fa-certificate"></i>
                                            <div class="credential-content">
                                                <strong><?php _e('گواهینامه‌ها:', 'teznevisan'); ?></strong>
                                                <span><?php echo esc_html($author_certifications); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($author_bio) : ?>
                                <p class="author-bio-description" itemprop="description">
                                    <?php echo esc_html($author_bio); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($author_awards) : ?>
                                <div class="author-awards">
                                    <i class="fa-solid fa-trophy"></i>
                                    <strong><?php _e('جوایز و افتخارات:', 'teznevisan'); ?></strong>
                                    <span itemprop="award"><?php echo esc_html($author_awards); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Author Social Links -->
                            <?php if ($author_website || $author_twitter || $author_linkedin || $author_instagram) : ?>
                                <div class="author-social-links">
                                    <?php if ($author_website) : ?>
                                        <a href="<?php echo esc_url($author_website); ?>" 
                                           class="author-social-link website"
                                           target="_blank"
                                           rel="noopener noreferrer author"
                                           itemprop="url">
                                            <i class="fa-solid fa-globe"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($author_twitter) : ?>
                                        <a href="<?php echo esc_url($author_twitter); ?>" 
                                           class="author-social-link x"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           itemprop="sameAs">
                                            <i class="fa-brands fa-x-twitter"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($author_linkedin) : ?>
                                        <a href="<?php echo esc_url($author_linkedin); ?>" 
                                           class="author-social-link linkedin"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           itemprop="sameAs">
                                            <i class="fa-brands fa-linkedin"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($author_instagram) : ?>
                                        <a href="<?php echo esc_url($author_instagram); ?>" 
                                           class="author-social-link instagram"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           itemprop="sameAs">
                                            <i class="fa-brands fa-instagram"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" 
                               class="author-bio-link">
                                <?php _e('مشاهده تمام مقالات', 'teznevisan'); ?>
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>

            <!-- Publisher Schema (Hidden) -->
            <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" style="display:none;">
                <meta itemprop="name" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
                <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <meta itemprop="url" content="<?php echo esc_url(get_site_icon_url()); ?>" />
                </div>
            </div>

        </article>

                <!-- Sticky Sidebar -->
        <aside class="single-post-sidebar">
            
            <!-- Quick Info Card -->
            <div class="sidebar-card quick-info-card">
                <h3 class="sidebar-card-title">
                    <i class="fa-solid fa-circle-info"></i>
                    <?php _e('اطلاعات سریع', 'teznevisan'); ?>
                </h3>
                <ul class="quick-info-list">
                    <li>
                        <div class="info-label">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span><?php _e('تاریخ انتشار', 'teznevisan'); ?></span>
                        </div>
                        <strong><?php echo get_the_date('j F Y'); ?></strong>
                    </li>
                    <?php if ($reading_time) : ?>
                    <li>
                        <div class="info-label">
                            <i class="fa-solid fa-clock"></i>
                            <span><?php _e('زمان مطالعه', 'teznevisan'); ?></span>
                        </div>
                        <strong><?php echo esc_html($reading_time); ?> دقیقه</strong>
                    </li>
                    <?php endif; ?>
                    <li>
                        <div class="info-label">
                            <i class="fa-solid fa-eye"></i>
                            <span><?php _e('بازدید', 'teznevisan'); ?></span>
                        </div>
                        <strong><?php echo number_format_i18n(teznevisan_get_post_views($post_id)); ?></strong>
                    </li>
                    <li>
                    <div class="info-label">
                        <i class="fa-solid fa-star"></i>
                        <span><?php _e('امتیاز', 'teznevisan'); ?></span>
                    </div>
                    <strong><?php echo isset($rating_stats['star_average']) ? esc_html($rating_stats['star_average']) : '0'; ?>/5</strong>
                </li>

                    <?php if ($word_count) : ?>
                    <li>
                        <div class="info-label">
                            <i class="fa-solid fa-file-word"></i>
                            <span><?php _e('تعداد کلمات', 'teznevisan'); ?></span>
                        </div>
                        <strong><?php echo number_format_i18n($word_count); ?></strong>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Share Card -->
            <div class="sidebar-card share-card">
                <h3 class="sidebar-card-title">
                    <i class="fa-solid fa-share-nodes"></i>
                    <?php _e('اشتراک‌گذاری', 'teznevisan'); ?>
                </h3>
                <div class="sidebar-share-buttons">
                    <?php
                    $share_buttons = teznevisan_social_share_buttons($post_id);
                    foreach ($share_buttons as $network => $data) :
                        if ($network === 'copy') continue;
                        $network_name = $network === 'twitter' ? 'x' : $network;
                    ?>
                        <a href="<?php echo esc_url($data['url']); ?>" 
                           class="sidebar-share-btn sidebar-share-<?php echo esc_attr($network_name); ?>"
                           style="--share-color: <?php echo esc_attr($data['color']); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr($data['label']); ?>">
                            <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Categories Card -->
            <?php if (!empty($categories)) : ?>
            <div class="sidebar-card categories-card">
                <h3 class="sidebar-card-title">
                    <i class="fa-solid fa-folder-tree"></i>
                    <?php _e('دسته‌بندی‌ها', 'teznevisan'); ?>
                </h3>
                <ul class="sidebar-categories-list">
                    <?php foreach ($categories as $category) : 
                        $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#2563eb';
                    ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                               style="--cat-color: <?php echo esc_attr($cat_color); ?>">
                                <i class="fa-solid fa-folder"></i>
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Newsletter Signup -->
            <div class="sidebar-card newsletter-card">
                <div class="newsletter-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="sidebar-card-title">
                    <?php _e('عضویت در خبرنامه', 'teznevisan'); ?>
                </h3>
                <p class="newsletter-description">
                    <?php _e('آخرین مقالات را مستقیماً در ایمیل خود دریافت کنید', 'teznevisan'); ?>
                </p>
                <form class="newsletter-form" method="post" action="#">
                    <input type="email" 
                           name="newsletter_email" 
                           placeholder="<?php esc_attr_e('ایمیل شما', 'teznevisan'); ?>" 
                           required>
                    <button type="submit" class="newsletter-submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <?php _e('عضویت', 'teznevisan'); ?>
                    </button>
                </form>
            </div>

            <!-- Dynamic Sidebar -->
            <?php if (is_active_sidebar('sidebar-single')) : ?>
                <?php dynamic_sidebar('sidebar-single'); ?>
            <?php endif; ?>

        </aside>

            <!-- Share Card -->
            <div class="sidebar-card share-card">
                <h3 class="sidebar-card-title">
                    <i class="fa-solid fa-share-nodes"></i>
                    <?php _e('اشتراک‌گذاری', 'teznevisan'); ?>
                </h3>
                <div class="sidebar-share-buttons">
                    <?php
                    $share_buttons = teznevisan_social_share_buttons($post_id);
                    foreach ($share_buttons as $network => $data) :
                        if ($network === 'copy') continue;
                        $network_name = $network === 'twitter' ? 'x' : $network;
                    ?>
                        <a href="<?php echo esc_url($data['url']); ?>" 
                           class="sidebar-share-btn sidebar-share-<?php echo esc_attr($network_name); ?>"
                           style="--share-color: <?php echo esc_attr($data['color']); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr($data['label']); ?>">
                            <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Categories Card -->
            <?php if (!empty($categories)) : ?>
            <div class="sidebar-card categories-card">
                <h3 class="sidebar-card-title">
                    <i class="fa-solid fa-folder-tree"></i>
                    <?php _e('دسته‌بندی‌ها', 'teznevisan'); ?>
                </h3>
                <ul class="sidebar-categories-list">
                    <?php foreach ($categories as $category) : 
                        $cat_color = get_term_meta($category->term_id, 'category_color', true) ?: '#2563eb';
                    ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                               style="--cat-color: <?php echo esc_attr($cat_color); ?>">
                                <i class="fa-solid fa-folder"></i>
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Newsletter Signup -->
            <div class="sidebar-card newsletter-card">
                <div class="newsletter-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="sidebar-card-title">
                    <?php _e('عضویت در خبرنامه', 'teznevisan'); ?>
                </h3>
                <p class="newsletter-description">
                    <?php _e('آخرین مقالات را مستقیماً در ایمیل خود دریافت کنید', 'teznevisan'); ?>
                </p>
                <form class="newsletter-form" method="post" action="#">
                    <input type="email" 
                           name="newsletter_email" 
                           placeholder="<?php esc_attr_e('ایمیل شما', 'teznevisan'); ?>" 
                           required>
                    <button type="submit" class="newsletter-submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <?php _e('عضویت', 'teznevisan'); ?>
                    </button>
                </form>
            </div>

            <!-- Dynamic Sidebar -->
            <?php if (is_active_sidebar('sidebar-single')) : ?>
                <?php dynamic_sidebar('sidebar-single'); ?>
            <?php endif; ?>

        </aside>

    </div>
</div>

<!-- Related Posts Section -->
<?php
$related_posts = teznevisan_get_related_posts($post_id, 3);
if (!empty($related_posts)) :
?>
    <section class="related-posts-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-newspaper"></i>
                    <?php _e('مقالات مرتبط', 'teznevisan'); ?>
                </h2>
                <p class="section-description">
                    <?php _e('مقالات مشابه که ممکن است برای شما جالب باشد', 'teznevisan'); ?>
                </p>
            </div>
            
            <div class="related-posts-grid">
                <?php foreach ($related_posts as $related_post) : 
                    setup_postdata($related_post);
                    $related_reading_time = get_post_meta($related_post->ID, '_reading_time', true);
                    $related_rating = teznevisan_get_rating_stats($related_post->ID);
                ?>
                    <article class="related-post-card">
                        <?php if (has_post_thumbnail($related_post->ID)) : ?>
                            <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>" 
                               class="related-post-thumbnail">
                                <?php echo get_the_post_thumbnail($related_post->ID, 'medium', array(
                                    'alt' => get_the_title($related_post->ID),
                                    'loading' => 'lazy',
                                    'class' => 'related-post-image'
                                )); ?>
                                <div class="related-post-overlay">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </div>
                            </a>
                        <?php endif; ?>
                        
                        <div class="related-post-content">
                            <?php
                            $related_categories = get_the_category($related_post->ID);
                            if (!empty($related_categories)) :
                                $related_cat = $related_categories[0];
                                $related_cat_color = get_term_meta($related_cat->term_id, 'category_color', true) ?: '#2563eb';
                            ?>
                                <a href="<?php echo esc_url(get_category_link($related_cat->term_id)); ?>" 
                                   class="related-post-category"
                                   style="--cat-color: <?php echo esc_attr($related_cat_color); ?>">
                                    <?php echo esc_html($related_cat->name); ?>
                                </a>
                            <?php endif; ?>
                            
                            <h3 class="related-post-title">
                                <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>">
                                    <?php echo esc_html(get_the_title($related_post->ID)); ?>
                                </a>
                            </h3>
                            
                            <div class="related-post-meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c', $related_post->ID)); ?>">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <?php echo get_the_date('j F Y', $related_post->ID); ?>
                                </time>
                                <?php if ($related_reading_time) : ?>
                                    <span class="reading-time">
                                        <i class="fa-solid fa-clock"></i>
                                        <?php echo esc_html($related_reading_time); ?> دقیقه
                                    </span>
                                <?php endif; ?>
                                <span class="rating-display">
                                    <i class="fa-solid fa-star"></i>
                                    <?php echo $related_rating['star_average']; ?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Comments Section -->
<section class="comments-section" id="comments">
    <div class="container">
        <?php
        if (comments_open() || get_comments_number()) :
        ?>
            <div class="comments-wrapper">
                <h2 class="comments-title">
                    <i class="fa-solid fa-comments"></i>
                    <?php
                    $comments_number = get_comments_number();
                    if ($comments_number == 0) {
                        _e('هنوز دیدگاهی ثبت نشده', 'teznevisan');
                    } elseif ($comments_number == 1) {
                        _e('یک دیدگاه', 'teznevisan');
                    } else {
                        printf(
                            _n('%s دیدگاه', '%s دیدگاه', $comments_number, 'teznevisan'),
                            number_format_i18n($comments_number)
                        );
                    }
                    ?>
                </h2>

                <?php if (!is_user_logged_in()) : ?>
                    <div class="comment-login-required">
                        <div class="login-required-icon">
                            <i class="fa-brands fa-telegram"></i>
                        </div>
                        <h3><?php _e('برای ارسال دیدگاه وارد شوید', 'teznevisan'); ?></h3>
                        <p><?php _e('برای ثبت دیدگاه و تعامل با سایر کاربران، لطفاً با تلگرام وارد شوید.', 'teznevisan'); ?></p>
                        <button class="btn btn-primary btn-lg" id="comment-login-trigger">
                            <i class="fa-brands fa-telegram"></i>
                            <span><?php _e('ورود با تلگرام', 'teznevisan'); ?></span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (have_comments()) : ?>
                    <ol class="comment-list">
                        <?php
                        wp_list_comments(array(
                            'style' => 'ol',
                            'short_ping' => true,
                            'avatar_size' => 64,
                            'callback' => 'teznevisan_custom_comment',
                        ));
                        ?>
                    </ol>

                    <?php
                    the_comments_pagination(array(
                        'prev_text' => '<i class="fa-solid fa-chevron-right"></i> ' . __('قبلی', 'teznevisan'),
                        'next_text' => __('بعدی', 'teznevisan') . ' <i class="fa-solid fa-chevron-left"></i>',
                    ));
                    ?>
                <?php endif; ?>

                <?php if (is_user_logged_in()) : ?>
                    <?php
                    comment_form(array(
                        'title_reply' => '<i class="fa-solid fa-pen-to-square"></i> ' . __('دیدگاه خود را بنویسید', 'teznevisan'),
                        'title_reply_to' => '<i class="fa-solid fa-reply"></i> ' . __('پاسخ به %s', 'teznevisan'),
                        'cancel_reply_link' => '<i class="fa-solid fa-xmark"></i> ' . __('لغو پاسخ', 'teznevisan'),
                        'label_submit' => __('ارسال دیدگاه', 'teznevisan'),
                        'submit_button' => '<button type="submit" class="btn btn-primary btn-lg submit-comment"><i class="fa-solid fa-paper-plane"></i> %4$s</button>',
                        'comment_field' => '<div class="comment-form-comment"><label for="comment">' . __('دیدگاه شما', 'teznevisan') . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="' . esc_attr__('دیدگاه خود را بنویسید...', 'teznevisan') . '"></textarea></div>',
                        'logged_in_as' => '<div class="logged-in-as">' .
                            '<div class="logged-user-info">' .
                            get_avatar(get_current_user_id(), 48) .
                            '<span>' . sprintf(__('وارد شده به عنوان <strong>%s</strong>', 'teznevisan'), wp_get_current_user()->display_name) . '</span>' .
                            '</div>' .
                            '<a href="' . wp_logout_url(get_permalink()) . '" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> ' . __('خروج', 'teznevisan') . '</a>' .
                            '</div>',
                        'class_submit' => 'submit-comment',
                    ));
                    ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Previous/Next Post Navigation -->
<nav class="post-navigation">
    <div class="container">
        <div class="post-nav-links">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>
            
            <?php if ($prev_post) : ?>
                <div class="nav-previous">
                    <span class="nav-label">
                        <i class="fa-solid fa-chevron-right"></i>
                        <?php _e('مقاله قبلی', 'teznevisan'); ?>
                    </span>
                    <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-link">
                        <?php if (has_post_thumbnail($prev_post)) : ?>
                            <div class="nav-thumbnail">
                                <?php echo get_the_post_thumbnail($prev_post, 'thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        <span class="nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                    </a>
                </div>
            <?php endif; ?>
            
            <?php if ($next_post) : ?>
                <div class="nav-next">
                    <span class="nav-label">
                        <?php _e('مقاله بعدی', 'teznevisan'); ?>
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                    <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-link">
                        <?php if (has_post_thumbnail($next_post)) : ?>
                            <div class="nav-thumbnail">
                                <?php echo get_the_post_thumbnail($next_post, 'thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        <span class="nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php 
endwhile; // End of the loop
?>

<?php get_footer(); ?>