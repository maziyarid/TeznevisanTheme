<?php
/**
 * Service card template part.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

$service_icon = get_post_meta(get_the_ID(), 'service_icon', true);
$service_icon = is_string($service_icon) && $service_icon !== '' ? $service_icon : 'fas fa-cog';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('service-card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="service-image">
            <a href="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php echo esc_attr(sprintf(__('View %s', 'teznevisan'), get_the_title())); ?>">
                <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="service-content">
        <div class="service-icon" aria-hidden="true">
            <i class="<?php echo esc_attr($service_icon); ?>"></i>
        </div>

        <h3 class="service-title">
            <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
        </h3>

        <div class="service-excerpt">
            <?php the_excerpt(); ?>
        </div>

        <a class="service-link" href="<?php echo esc_url(get_permalink()); ?>">
            <?php esc_html_e('Learn more', 'teznevisan'); ?>
            <span aria-hidden="true">&larr;</span>
        </a>
    </div>
</article>
