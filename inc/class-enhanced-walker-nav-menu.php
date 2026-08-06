<?php
/**
 * Enhanced Walker Nav Menu Class
 * File: inc/class-enhanced-walker-nav-menu.php
 */

if (!class_exists('Enhanced_Walker_Nav_Menu')) {
    class Enhanced_Walker_Nav_Menu extends Walker_Nav_Menu {
        
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }

        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            
            $output .= $indent . '<li' . $id . $class_names .'>';
            
            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
            
            // Get menu item icon from custom field
            $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
            if (empty($icon_class)) {
                // Default icons based on menu item title
                $title_lower = strtolower($item->title);
                if (strpos($title_lower, 'خانه') !== false || strpos($title_lower, 'home') !== false) {
                    $icon_class = 'fa-solid fa-house';
                } elseif (strpos($title_lower, 'خدمات') !== false || strpos($title_lower, 'service') !== false) {
                    $icon_class = 'fa-solid fa-tools';
                } elseif (strpos($title_lower, 'وبلاگ') !== false || strpos($title_lower, 'blog') !== false) {
                    $icon_class = 'fa-solid fa-blog';
                } elseif (strpos($title_lower, 'درباره') !== false || strpos($title_lower, 'about') !== false) {
                    $icon_class = 'fa-solid fa-circle-info';
                } elseif (strpos($title_lower, 'تماس') !== false || strpos($title_lower, 'contact') !== false) {
                    $icon_class = 'fa-solid fa-phone';
                } else {
                    $icon_class = 'fa-solid fa-circle';
                }
            }
            
            $item_output = isset($args->before) ? $args->before : '';
            $item_output .= '<a class="nav-link"' . $attributes .'>';
            $item_output .= '<span class="nav-icon"><i class="' . esc_attr($icon_class) . '"></i></span>';
            $item_output .= '<span class="nav-text">';
            $item_output .= isset($args->link_before) ? $args->link_before : '';
            $item_output .= apply_filters('the_title', $item->title, $item->ID);
            $item_output .= isset($args->link_after) ? $args->link_after : '';
            $item_output .= '</span>';
            $item_output .= '<span class="nav-indicator"></span>';
            $item_output .= '</a>';
            $item_output .= isset($args->after) ? $args->after : '';
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= "</li>\n";
        }
    }
}

if (!class_exists('Enhanced_Mobile_Walker_Nav_Menu')) {
    class Enhanced_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
        
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'mobile-menu-item';
            
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $output .= $indent . '<li' . $class_names .'>';
            
            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
            
            // Get menu item icon
            $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
            if (empty($icon_class)) {
                // Default icons
                $title_lower = strtolower($item->title);
                if (strpos($title_lower, 'خانه') !== false || strpos($title_lower, 'home') !== false) {
                    $icon_class = 'fas fa-home';
                } elseif (strpos($title_lower, 'خدمات') !== false || strpos($title_lower, 'service') !== false) {
                    $icon_class = 'fas fa-tools';
                } elseif (strpos($title_lower, 'وبلاگ') !== false || strpos($title_lower, 'blog') !== false) {
                    $icon_class = 'fas fa-blog';
                } elseif (strpos($title_lower, 'درباره') !== false || strpos($title_lower, 'about') !== false) {
                    $icon_class = 'fas fa-info-circle';
                } elseif (strpos($title_lower, 'تماس') !== false || strpos($title_lower, 'contact') !== false) {
                    $icon_class = 'fas fa-phone';
                } else {
                    $icon_class = 'fas fa-circle';
                }
            }
            
            $item_output = '<a class="mobile-nav-link"' . $attributes .'>';
            $item_output .= '<div class="nav-icon"><i class="' . esc_attr($icon_class) . '"></i></div>';
            $item_output .= '<span class="nav-text">' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
            $item_output .= '<i class="fa-solid fa-chevron-left nav-arrow"></i>';
            $item_output .= '</a>';
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= "</li>\n";
        }
    }
}
?>