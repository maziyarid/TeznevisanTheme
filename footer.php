<?php
/**
 * Theme footer.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<footer id="site-footer" class="site-footer" role="contentinfo">
    <div class="container footer-grid">
        <section class="footer-column footer-brand">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="footer-site-title" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                </a>
            <?php endif; ?>
            <?php $description = get_theme_mod('footer_company_description', get_bloginfo('description')); ?>
            <?php if ($description) : ?>
                <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </section>

        <?php foreach (array('footer-1', 'footer-2', 'footer-3', 'footer-4') as $sidebar_id) : ?>
            <?php if (is_active_sidebar($sidebar_id)) : ?>
                <section class="footer-column footer-widget-area" aria-label="<?php echo esc_attr($sidebar_id); ?>">
                    <?php dynamic_sidebar($sidebar_id); ?>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="container footer-bottom">
        <p class="site-copyright">
            <?php
            echo esc_html(
                get_theme_mod(
                    'copyright_text',
                    sprintf(__('&copy; %s %s. All rights reserved.', 'teznevisan'), gmdate('Y'), get_bloginfo('name'))
                )
            );
            ?>
        </p>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => false,
                'menu_class'     => 'footer-menu',
            )
        );
        ?>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
