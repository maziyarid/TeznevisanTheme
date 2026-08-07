<?php
/**
 * Template Name: Author Profile
 * @package Teznevisan
 */

get_header();

$author_id = isset($_GET['author']) ? absint($_GET['author']) : get_current_user_id();
$author = get_userdata($author_id);

if (!$author) {
    echo '<div class="container"><h1>نویسنده یافت نشد</h1></div>';
    get_footer();
    return;
}
?>

<style>
.author-profile-page {
    padding: 100px 0 4rem;
    background: var(--gray-50);
}

.author-profile-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    padding: 4rem 0 3rem;
    color: white;
    margin-bottom: 3rem;
    border-radius: 0 0 30px 30px;
}

.author-profile-info {
    display: flex;
    gap: 3rem;
    align-items: center;
}

.author-profile-avatar {
    flex-shrink: 0;
}

.author-profile-avatar img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    border: 6px solid white;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
}

.author-profile-details h1 {
    margin: 0 0 1rem 0;
    font-size: 3rem;
    color: white;
}

.author-profile-bio {
    font-size: 1.2rem;
    line-height: 1.7;
    margin-bottom: 2rem;
}

.author-stats {
    display: flex;
    gap: 3rem;
}

.author-stat {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    display: block;
}

.stat-label {
    font-size: 1rem;
    opacity: 0.9;
}

.author-posts-section {
    margin: 3rem 0;
}

.author-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}
</style>

<div class="author-profile-page">
    <div class="author-profile-header">
        <div class="container">
            <div class="author-profile-info">
                <div class="author-profile-avatar">
                    <?php echo get_avatar($author_id, 180); ?>
                </div>
                <div class="author-profile-details">
                    <h1><?php echo $author->display_name; ?></h1>
                    <p class="author-profile-bio">
                        <?php echo get_the_author_meta('description', $author_id) ?: 'نویسنده و عضو تیم تزنویسان'; ?>
                    </p>
                    <div class="author-stats">
                        <div class="author-stat">
                            <span class="stat-number"><?php echo count_user_posts($author_id); ?></span>
                            <span class="stat-label">مقاله منتشر شده</span>
                        </div>
                        <div class="author-stat">
                            <span class="stat-number">
                                <?php
                                $author_posts = get_posts(array('author' => $author_id, 'post_status' => 'publish'));
                                $total_views = 0;
                                foreach ($author_posts as $post) {
                                    $total_views += intval(get_post_meta($post->ID, 'post_views', true) ?: 0);
                                }
                                echo number_format($total_views);
                                ?>
                            </span>
                            <span class="stat-label">بازدید کل</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="author-posts-section">
            <h2>مقالات <?php echo $author->display_name; ?></h2>
            <div class="author-posts-grid">
                <?php
                $author_posts = new WP_Query(array(
                    'author' => $author_id,
                    'posts_per_page' => 12,
                    'post_status' => 'publish'
                ));
                
                if ($author_posts->have_posts()):
                    while ($author_posts->have_posts()): $author_posts->the_post();
                        get_template_part('template-parts/content', 'post-card');
                    endwhile;
                    wp_reset_postdata();
                else:
                ?>
                    <p>هنوز مقاله‌ای منتشر نشده است.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
