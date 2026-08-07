<?php
/**
 * Page Template
 * 
 * @package Teznevisan
 */

get_header();
?>

<main id="main-content" class="page-main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <section class="page-hero">
            <div class="container">
                <?php teznevisan_breadcrumbs(); ?>
                
                <h1 class="page-title"><?php the_title(); ?></h1>
                
                <?php if (has_excerpt()): ?>
                    <div class="page-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        
        <section class="page-content">
            <div class="container-narrow">
                <article class="page-article">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="page-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="page-body">
                        <?php the_content(); ?>
                    </div>
                </article>
            </div>
        </section>
        
        <?php if (comments_open() || get_comments_number()): ?>
            <section class="page-comments">
                <div class="container-narrow">
                    <?php comments_template(); ?>
                </div>
            </section>
        <?php endif; ?>
        
    <?php endwhile; ?>
    
</main>

<style>
.page-main {
    background: var(--bg-secondary);
    padding-top: 100px;
    font-family: inherit;
}

.page-hero {
    background: var(--bg-main);
    padding: 3rem 0;
    border-bottom: 1px solid var(--border-color);
}

.page-title {
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-family: inherit;
}

.page-excerpt {
    font-size: 1.2rem;
    color: var(--text-secondary);
    line-height: 1.6;
    font-family: inherit;
}

.page-content {
    padding: 4rem 0;
}

.page-article {
    background: var(--bg-main);
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.page-featured-image {
    margin-bottom: 2rem;
    border-radius: 15px;
    overflow: hidden;
}

.page-featured-image img {
    width: 100%;
    height: auto;
}

.page-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-primary);
}

.page-body h2,
.page-body h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    font-family: inherit;
}

.page-body p {
    margin-bottom: 1.5rem;
    font-family: inherit;
}

.page-comments {
    padding: 3rem 0;
}

@media (max-width: 768px) {
    .page-article {
        padding: 2rem 1.5rem;
    }
}
</style>

<?php get_footer(); ?>
