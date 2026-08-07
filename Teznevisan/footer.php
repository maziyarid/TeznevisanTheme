<?php
/**
 * Footer Template - With Logo Fixed
 * Version: 3.0.3
 */
?>
    </div><!-- #primary -->
</div><!-- #page -->

<!-- Footer -->
<footer id="colophon" class="site-footer" role="contentinfo">
    
    <!-- Footer Main Content -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                
                <!-- Column 1: About Company -->
                <div class="footer-col footer-about">
                    <div class="footer-logo">
                        <?php
                        if (has_custom_logo()) {
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="footer-logo-image">';
                        } else {
                            // Always use white logo in footer
                            $white_logo_url = get_template_directory_uri() . '/assets/images/white.svg';
                            echo '<img src="' . esc_url($white_logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="footer-logo-svg">';
                        }
                        ?>
                    </div>
                    <p class="footer-description">
                        <?php echo wp_kses_post(get_theme_mod('footer_company_description', __('ما با ارائه خدمات حرفه‌ای و با کیفیت، همراه شما در مسیر موفقیت هستیم.', 'teznevisan'))); ?>
                    </p>
                    <div class="footer-social">
                        <?php
                        $socials = array(
                            'telegram' => ['icon' => 'fa-brands fa-telegram', 'color' => '#0088cc'],
                            'instagram' => ['icon' => 'fa-brands fa-instagram', 'color' => '#E4405F'],
                            'twitter' => ['icon' => 'fa-brands fa-x-twitter', 'color' => '#000000'],
                            'linkedin' => ['icon' => 'fa-brands fa-linkedin', 'color' => '#0077b5'],
                            'youtube' => ['icon' => 'fa-brands fa-youtube', 'color' => '#FF0000'],
                            'whatsapp' => ['icon' => 'fa-brands fa-whatsapp', 'color' => '#25D366'],
                        );

                        foreach ($socials as $network => $data) :
                            $url = get_theme_mod($network . '_url');
                            if ($url) :
                        ?>
                            <a href="<?php echo esc_url($url); ?>" 
                               class="social-link social-<?php echo esc_attr($network); ?>" 
                               style="--social-color: <?php echo esc_attr($data['color']); ?>"
                               target="_blank" 
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr(ucfirst($network)); ?>"
                               title="<?php echo esc_attr(ucfirst($network)); ?>">
                                <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                            </a>
                        <?php endif; endforeach; ?>
                    </div>
                </div>

                <!-- Column 2: Quick Links / Widget Area 1 -->
                <div class="footer-col footer-links">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <h3 class="widget-title"><?php _e('لینک‌های مفید', 'teznevisan'); ?></h3>
                        <ul class="footer-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-chevron-left"></i> <?php _e('صفحه اصلی', 'teznevisan'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>"><i class="fa-solid fa-chevron-left"></i> <?php _e('درباره ما', 'teznevisan'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/services')); ?>"><i class="fa-solid fa-chevron-left"></i> <?php _e('خدمات', 'teznevisan'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><i class="fa-solid fa-chevron-left"></i> <?php _e('وبلاگ', 'teznevisan'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><i class="fa-solid fa-chevron-left"></i> <?php _e('تماس با ما', 'teznevisan'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Column 3: Services / Widget Area 2 -->
                <div class="footer-col footer-services">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <h3 class="widget-title"><?php _e('خدمات ما', 'teznevisan'); ?></h3>
                        <ul class="footer-menu">
                            <?php
                            $services = get_posts(array(
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'category_name' => 'services'
                            ));
                            
                            if ($services) {
                                foreach ($services as $service) {
                                    echo '<li><a href="' . esc_url(get_permalink($service->ID)) . '"><i class="fa-solid fa-chevron-left"></i> ' . esc_html($service->post_title) . '</a></li>';
                                }
                            } else {
                                echo '<li><a href="#"><i class="fa-solid fa-chevron-left"></i> ' . __('خدمات طراحی', 'teznevisan') . '</a></li>';
                                echo '<li><a href="#"><i class="fa-solid fa-chevron-left"></i> ' . __('خدمات توسعه', 'teznevisan') . '</a></li>';
                                echo '<li><a href="#"><i class="fa-solid fa-chevron-left"></i> ' . __('خدمات مشاوره', 'teznevisan') . '</a></li>';
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Column 4: Contact Info -->
                <div class="footer-col footer-contact">
                    <h3 class="widget-title"><?php _e('تماس با ما', 'teznevisan'); ?></h3>
                    
                    <div class="contact-info">
                        <?php
                        $phone = get_theme_mod('phone_number', '09162352304');
                        $email = get_theme_mod('email_address', 'info@teznevisan3.com');
                        $address = get_theme_mod('site_address', 'تهران، میدان ونک');
                        ?>
                        
                        <?php if ($address) : ?>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="contact-details">
                                <strong><?php _e('آدرس', 'teznevisan'); ?></strong>
                                <p><?php echo esc_html($address); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($phone) : ?>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <strong><?php _e('تلفن', 'teznevisan'); ?></strong>
                                <a href="tel:<?php echo esc_attr($phone); ?>" dir="ltr">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($email) : ?>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <strong><?php _e('ایمیل', 'teznevisan'); ?></strong>
                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Newsletter Signup -->
                    <div class="newsletter-signup">
                        <h4><?php _e('عضویت در خبرنامه', 'teznevisan'); ?></h4>
                        <form class="newsletter-form" method="post" action="#">
                            <div class="newsletter-input-wrapper">
                                <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e('ایمیل شما', 'teznevisan'); ?>" required>
                                <button type="submit" aria-label="<?php esc_attr_e('عضویت', 'teznevisan'); ?>">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                
                <!-- Copyright -->
                <div class="site-info">
                    <p class="copyright">
                        <?php
                        $copyright = get_theme_mod('footer_copyright', sprintf(__('© %d %s. تمامی حقوق محفوظ است.', 'teznevisan'), date('Y'), get_bloginfo('name')));
                        echo wp_kses_post($copyright);
                        ?>
                    </p>
                </div>

                <!-- Footer Menu -->
                <nav class="footer-bottom-menu" aria-label="<?php esc_attr_e('منوی فوتر', 'teznevisan'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-links',
                        'menu_id' => 'footer-menu',
                        'menu_class' => 'footer-menu-list',
                        'container' => false,
                        'depth' => 1,
                        'fallback_cb' => function() {
                            echo '<ul class="footer-menu-list">
                                <li><a href="' . esc_url(home_url('/privacy-policy')) . '">' . __('حریم خصوصی', 'teznevisan') . '</a></li>
                                <li><a href="' . esc_url(home_url('/terms')) . '">' . __('قوانین و مقررات', 'teznevisan') . '</a></li>
                            </ul>';
                        },
                    ));
                    ?>
                </nav>

                <!-- Back to Top (Mobile) -->
                <button id="back-to-top-footer" class="back-to-top-footer mobile-only" aria-label="<?php esc_attr_e('بازگشت به بالا', 'teznevisan'); ?>">
                    <i class="fa-solid fa-chevron-up"></i>
                </button>

            </div>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>

<!-- Inline Scripts for Performance -->
<script>
// Remove page loader when fully loaded
window.addEventListener('load', function() {
    document.body.classList.add('page-loaded');
    const loader = document.querySelector('.page-loader');
    if (loader) {
        setTimeout(() => {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 300);
        }, 100);
    }
});

// Prevent FOUC (Flash of Unstyled Content)
document.documentElement.classList.add('js-enabled');
</script>

</body>
</html>
