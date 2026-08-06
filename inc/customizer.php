<?php
/**
 * Extended Customizer Options
 */

function teznevisan_extended_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'teznevisan'),
        'panel' => 'teznevisan_options',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => __('Professional Academic Writing Services', 'teznevisan'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'teznevisan'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
        // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => __('Quality, Originality, and Complete Support', 'teznevisan'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'teznevisan'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default' => __('Expert team of TezNevisan with over 450 experienced researchers and scholars, ready to provide comprehensive thesis writing services in all fields and academic levels.', 'teznevisan'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label' => __('Hero Description', 'teznevisan'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));
    
    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label' => __('Hero Image', 'teznevisan'),
        'section' => 'hero_section',
    )));
    
    // Trust Statistics Section
    $wp_customize->add_section('trust_stats', array(
        'title' => __('Trust Statistics', 'teznevisan'),
        'panel' => 'teznevisan_options',
        'priority' => 20,
    ));
    
    $trust_stats = array(
        'researchers' => __('Expert Researchers', 'teznevisan'),
        'satisfaction' => __('Customer Satisfaction', 'teznevisan'),
        'originality' => __('Originality Guarantee', 'teznevisan'),
        'universities' => __('Reputable Universities', 'teznevisan'),
    );
    
    foreach ($trust_stats as $key => $label) {
        $wp_customize->add_setting('trust_' . $key, array(
            'default' => $key === 'researchers' ? '450+' : ($key === 'universities' ? '100+' : '98%'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('trust_' . $key, array(
            'label' => $label,
            'section' => 'trust_stats',
            'type' => 'text',
        ));
    }
    
    // About Page Stats
    $wp_customize->add_section('about_stats', array(
        'title' => __('About Page Statistics', 'teznevisan'),
        'panel' => 'teznevisan_options',
        'priority' => 30,
    ));
    
    $about_stats = array(
        'researchers' => array('label' => __('Expert Researchers', 'teznevisan'), 'default' => '450+'),
        'projects' => array('label' => __('Completed Projects', 'teznevisan'), 'default' => '5000+'),
        'satisfaction' => array('label' => __('Customer Satisfaction', 'teznevisan'), 'default' => '98%'),
        'experience' => array('label' => __('Years of Experience', 'teznevisan'), 'default' => '10+'),
    );
    
    foreach ($about_stats as $key => $data) {
        $wp_customize->add_setting('stat_' . $key, array(
            'default' => $data['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('stat_' . $key, array(
            'label' => $data['label'],
            'section' => 'about_stats',
            'type' => 'text',
        ));
    }
    
    // Colors Section
    $wp_customize->add_section('theme_colors', array(
        'title' => __('Theme Colors', 'teznevisan'),
        'panel' => 'teznevisan_options',
        'priority' => 40,
    ));
    
    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default' => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'teznevisan'),
        'section' => 'theme_colors',
    )));
    
    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default' => '#1e40af',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => __('Secondary Color', 'teznevisan'),
        'section' => 'theme_colors',
    )));
    
    // Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default' => '#10b981',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('Accent Color', 'teznevisan'),
        'section' => 'theme_colors',
    )));
}
add_action('customize_register', 'teznevisan_extended_customizer');

// Output custom CSS
function teznevisan_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#2563eb');
    $secondary_color = get_theme_mod('secondary_color', '#1e40af');
    $accent_color = get_theme_mod('accent_color', '#10b981');
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_html($primary_color); ?>;
            --secondary-color: <?php echo esc_html($secondary_color); ?>;
            --accent-color: <?php echo esc_html($accent_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'teznevisan_customizer_css');
?>