/**
 * Theme Customizer Live Preview
 * 
 * @package Teznevisan
 */

(function($) {
    'use strict';
    
    // Site Title
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title').text(to);
        });
    });
    
    // Site Description
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });
    
    // Primary Color
    wp.customize('primary_color', function(value) {
        value.bind(function(to) {
            $(':root').css('--primary-color', to);
        });
    });
    
    // Secondary Color
    wp.customize('secondary_color', function(value) {
        value.bind(function(to) {
            $(':root').css('--secondary-color', to);
        });
    });
    
    // Accent Color
    wp.customize('accent_color', function(value) {
        value.bind(function(to) {
            $(':root').css('--accent-color', to);
        });
    });
    
    // Base Font Size
    wp.customize('base_font_size', function(value) {
        value.bind(function(to) {
            $('html').css('font-size', to + 'px');
        });
    });
    
    // Line Height
    wp.customize('base_line_height', function(value) {
        value.bind(function(to) {
            $('body').css('line-height', to);
        });
    });
    
    // Footer Text
    wp.customize('footer_text', function(value) {
        value.bind(function(to) {
            $('.copyright p').html(to);
        });
    });
    
})(jQuery);
