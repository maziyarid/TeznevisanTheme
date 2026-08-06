<?php get_header(); ?>

<main id="main-content" class="site-main" role="main">
    <?php teznevisan_breadcrumbs(); ?>
    
    <div class="container">
        <div class="content-wrapper">
            <div class="main-content">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="page-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image">
                                <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php the_content(); ?>
                            
                            <?php wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('Pages:', 'teznevisan'),
                                'after' => '</div>',
                            )); ?>
                        </div>
                    </article>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                <?php endwhile; ?>
            </div>
            
            <aside class="sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>