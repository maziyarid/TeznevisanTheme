<?php
/**
 * Default page template.
 *
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main-content" class="site-main" role="main">
    <?php if (function_exists('teznevisan_breadcrumbs')) : ?>
        <?php teznevisan_breadcrumbs(); ?>
    <?php endif; ?>

    <div class="container">
        <div class="content-wrapper">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('page-entry'); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php echo esc_html(get_the_title()); ?></h1>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-thumbnail">
                            <?php the_post_thumbnail('large', array('loading' => 'eager')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();
                        wp_link_pages(
                            array(
                                'before' => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'teznevisan') . '">',
                                'after'  => '</nav>',
                            )
                        );
                        ?>
                    </div>
                </article>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
