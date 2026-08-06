<?php
/**
 * Services Widget
 */
class Teznevisan_Services_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'teznevisan_services',
            'خدمات تزنویسان',
            array('description' => 'نمایش لیست خدمات با لینک‌های مستقیم')
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'خدمات ما';
        $count = !empty($instance['count']) ? absint($instance['count']) : 6;
        $show_prices = !empty($instance['show_prices']);
        $layout = !empty($instance['layout']) ? $instance['layout'] : 'list';
        
        $services = get_posts(array(
            'post_type' => 'services',
            'posts_per_page' => $count,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish'
        ));
        
        if (empty($services)) return;
        
        echo $args['before_widget'];
        ?>
        <div class="services-widget-enhanced layout-<?php echo esc_attr($layout); ?>">
            <h3 class="widget-title">
                <i class="fa-solid fa-tools"></i>
                <?php echo esc_html($title); ?>
            </h3>
            
            <div class="services-grid">
                <?php foreach ($services as $service) : 
                    $price_min = get_post_meta($service->ID, 'price_range_min', true);
                    $price_max = get_post_meta($service->ID, 'price_range_max', true);
                    $service_excerpt = get_post_meta($service->ID, 'service_excerpt', true);
                ?>
                    <div class="service-widget-item">
                        <div class="service-icon">
                            <i class="fa-solid fa-<?php echo $this->get_service_icon($service->post_title); ?>"></i>
                        </div>
                        
                        <div class="service-details">
                            <h4 class="service-title">
                                <a href="<?php echo get_permalink($service); ?>">
                                    <?php echo esc_html(get_the_title($service)); ?>
                                </a>
                            </h4>
                            
                            <?php if ($service_excerpt) : ?>
                            <p class="service-excerpt"><?php echo esc_html(wp_trim_words($service_excerpt, 10)); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($show_prices && $price_min && $price_max) : ?>
                            <div class="service-price">
                                <i class="fa-solid fa-tag"></i>
                                <span><?php echo number_format($price_min); ?> - <?php echo number_format($price_max); ?> تومان</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="service-action">
                            <a href="<?php echo get_permalink($service); ?>" class="service-link">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="widget-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('services')); ?>" class="view-all-services">
                    <i class="fa-solid fa-th-large"></i>
                    مشاهده همه خدمات
                </a>
            </div>
        </div>
        
        <style>
        .services-widget-enhanced {
            background: var(--bg-main);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .services-widget-enhanced .widget-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0 1.5rem 0;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .services-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .service-widget-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .service-widget-item:hover {
            background: rgba(31, 165, 71, 0.05);
            border-color: var(--primary-color);
            transform: translateX(-3px);
        }
        
        .service-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .service-details {
            flex: 1;
            min-width: 0;
        }
        
        .service-title {
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.3;
        }
        
        .service-title a {
            color: var(--text-primary);
            text-decoration: none;
        }
        
        .service-title a:hover {
            color: var(--primary-color);
        }
        
        .service-excerpt {
            margin: 0 0 0.5rem 0;
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.4;
        }
        
        .service-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .service-action {
            flex-shrink: 0;
        }
        
        .service-link {
            width: 32px;
            height: 32px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .service-link:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }
        
        .view-all-services {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            border-radius: 20px;
            border: 1px solid var(--primary-color);
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .view-all-services:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        </style>
        <?php
        echo $args['after_widget'];
    }
    
    private function get_service_icon($title) {
        $title_lower = strtolower($title);
        
        $icon_mapping = array(
            'پایان‌نامه' => 'graduation-cap',
            'thesis' => 'graduation-cap',
            'مقاله' => 'newspaper',
            'article' => 'newspaper',
            'ترجمه' => 'language',
            'translation' => 'language',
            'ویرایش' => 'edit',
            'editing' => 'edit',
            'پروپوزال' => 'file-alt',
            'proposal' => 'file-alt',
            'مشاوره' => 'comments',
            'consultation' => 'comments'
        );
        
        foreach ($icon_mapping as $keyword => $icon) {
            if (strpos($title_lower, $keyword) !== false) {
                return $icon;
            }
        }
        
        return 'tools';
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'خدمات ما';
        $count = !empty($instance['count']) ? absint($instance['count']) : 6;
        $show_prices = !empty($instance['show_prices']);
        $layout = !empty($instance['layout']) ? $instance['layout'] : 'list';
        
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">عنوان:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">تعداد خدمات:</label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" 
                   type="number" min="1" max="12" value="<?php echo esc_attr($count); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('layout')); ?>">نوع نمایش:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('layout')); ?>" 
                    name="<?php echo esc_attr($this->get_field_name('layout')); ?>">
                <option value="list" <?php selected($layout, 'list'); ?>>لیستی</option>
                <option value="grid" <?php selected($layout, 'grid'); ?>>شبکه‌ای</option>
                <option value="compact" <?php selected($layout, 'compact'); ?>>فشرده</option>
            </select>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_prices); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_prices')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_prices')); ?>" value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_prices')); ?>">نمایش قیمت</label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 6;
        $instance['show_prices'] = (!empty($new_instance['show_prices'])) ? 1 : 0;
        $instance['layout'] = (!empty($new_instance['layout'])) ? sanitize_text_field($new_instance['layout']) : 'list';
        return $instance;
    }
}

/**
 * Register Enhanced Widgets
 */
function teznevisan_register_enhanced_widgets() {
    register_widget('Teznevisan_Enhanced_Newsletter_Widget');
    register_widget('Teznevisan_Popular_Posts_Widget');
    register_widget('Teznevisan_Services_Widget');
}
add_action('widgets_init', 'teznevisan_register_enhanced_widgets');