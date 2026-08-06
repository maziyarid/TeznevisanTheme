<div class="service-card">
    <div class="service-icon">
        <i class="<?php echo esc_attr(get_field('service_icon') ?: 'fas fa-cog'); ?>"></i>
    </div>
    <div class="service-content">
        <h3 class="service-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="service-description"><?php the_excerpt(); ?></p>
        
        <?php if (get_field('service_features')) : ?>
            <ul class="service-features">
                <?php foreach (array_slice(get_field('service_features'), 0, 4) as $feature) : ?>
                    <li><i class="fas fa-check"></i> <?php echo esc_html($feature['feature_text']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <div class="service-footer">
            <?php if (get_field('service_price')) : ?>
                <div class="price-range">
                    <i class="fas fa-tags"></i>
                    <span><?php echo esc_html(get_field('service_price')); ?></span>
                </div>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>" class="service-btn">
                <?php _e('Learn More', 'teznevisan'); ?> <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</div>