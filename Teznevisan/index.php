<?php
/**
 * Main Blog Template
 * 
 * @package Teznevisan
 */

get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <h1><?php _e('وبلاگ تزنویسان', 'teznevisan'); ?></h1>
            <p><?php _e('آخرین مقالات و اخبار', 'teznevisan'); ?></p>
        </div>
    </div>
</section>

<section class="blog-content-section">
    <div class="container">
        <div class="blog-layout">
            <div class="posts-area">
                <?php if (have_posts()) : ?>
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('template-parts/content', 'post-card'); ?>
                        <?php endwhile; ?>
                    </div>
                    
                    <div class="pagination-wrapper">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => '<i class="fa-solid fa-chevron-right"></i> ' . __('قبلی', 'teznevisan'),
                            'next_text' => __('بعدی', 'teznevisan') . ' <i class="fa-solid fa-chevron-left"></i>',
                        ));
                        ?>
                    </div>
                <?php else : ?>
                    <div class="no-posts-found">
                        <i class="fa-solid fa-folder-open"></i>
                        <h2><?php _e('مطلبی یافت نشد', 'teznevisan'); ?></h2>
                        <p><?php _e('متأسفانه هیچ مطلبی برای نمایش وجود ندارد.', 'teznevisan'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <aside class="blog-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</section>

<style>
.blog-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
    margin: 3rem 0;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}

@media (max-width: 1024px) {
    .blog-layout {
        grid-template-columns: 1fr;
    }
    
    .blog-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
