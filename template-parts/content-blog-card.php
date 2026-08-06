<article class="blog-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="blog-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('blog-thumbnail', array('class' => 'img-responsive')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="blog-content">
        <div class="blog-meta">
            <span class="blog-date">
                <i class="fas fa-calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
            <span class="blog-author">
                <i class="fas fa-user"></i>
                <?php the_author(); ?>
            </span>
            <span class="reading-time">
                <i class="fas fa-clock"></i>
                <?php echo teznevisan_reading_time(); ?>
            </span>
        </div>
        
        <h3 class="blog-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="blog-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <div class="blog-footer">
            <a href="<?php the_permalink(); ?>" class="read-more">
                <?php _e('Read More', 'teznevisan'); ?> <i class="fas fa-arrow-left"></i>
            </a>
            
            <?php if (get_the_tags()) : ?>
                <div class="blog-tags">
                    <?php the_tags('<i class="fas fa-tags"></i> ', ', '); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>