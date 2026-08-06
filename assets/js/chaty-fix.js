/**
 * Chaty Widget Fixes - Remove Duplicates & Add Labels
 * Fix: Remove left floating widget, keep only #chaty-toggle on right
 * Add visible labels with proper hover behavior
 */
(function($) {
    'use strict';
    
    class ChatyWidgetFixer {
        constructor() {
            this.init();
        }
        
        init() {
            // Wait for DOM and other scripts to load
            setTimeout(() => {
                this.removeDuplicateWidgets();
                this.fixMainChatyWidget();
                this.setupObserver();
            }, 1000);
        }
        
        removeDuplicateWidgets() {
            console.log('Removing duplicate Chaty widgets...');
            
            // Find all chaty widgets
            const chatyWidgets = $('.chaty-widget, [id*="chaty"], [class*="chaty"]');
            
            // Keep only the one with ID chaty-toggle or the rightmost one
            let keepWidget = $('#chaty-toggle');
            
            if (!keepWidget.length) {
                // Find the rightmost positioned widget
                let rightmost = null;
                let maxRight = -1;
                
                chatyWidgets.each(function() {
                    const $widget = $(this);
                    const position = $widget.css('position');
                    
                    if (position === 'fixed' || position === 'absolute') {
                        const right = parseInt($widget.css('right')) || 0;
                        const left = parseInt($widget.css('left')) || 0;
                        
                        // Calculate effective right position
                        const effectiveRight = right || ($(window).width() - left);
                        
                        if (effectiveRight > maxRight) {
                            maxRight = effectiveRight;
                            rightmost = $widget;
                        }
                    }
                });
                
                if (rightmost) {
                    keepWidget = rightmost;
                    if (!keepWidget.attr('id')) {
                        keepWidget.attr('id', 'chaty-toggle');
                    }
                }
            }
            
            // Remove all other chaty widgets
            chatyWidgets.not(keepWidget).each(function() {
                console.log('Removing duplicate chaty widget:', this);
                $(this).remove();
            });
            
            // Ensure the kept widget has proper ID and class
            if (keepWidget.length) {
                keepWidget.attr('id', 'chaty-toggle');
                if (!keepWidget.hasClass('chaty-widget')) {
                    keepWidget.addClass('chaty-widget');
                }
            }
        }
        
        fixMainChatyWidget() {
            const $chatyWidget = $('#chaty-toggle');
            
            if (!$chatyWidget.length) {
                console.log('No chaty widget found to fix');
                return;
            }
            
            console.log('Fixing main Chaty widget...');
            
            // Ensure proper structure
            this.ensureWidgetStructure($chatyWidget);
            
            // Add labels to contact items
            this.addContactLabels($chatyWidget);
            
            // Apply proper styling
            this.applyChatyStyles($chatyWidget);
            
            // Setup hover/tap behavior
            this.setupChatyBehavior($chatyWidget);
        }
        
        ensureWidgetStructure($widget) {
            // Ensure widget has proper classes and structure
            $widget.addClass('tez-chaty-fixed');
            
            // Find or create contact items container
            let $container = $widget.find('.chaty-channels, .contact-channels, .chaty-items');
            
            if (!$container.length) {
                $container = $widget.children().first();
                if ($container.length) {
                    $container.addClass('chaty-channels');
                }
            }
            
            // Find individual contact items
            let $items = $container.find('a, .contact-item, .chaty-item, [data-contact]');
            
            if (!$items.length) {
                // Look for any links that might be contact items
                $items = $widget.find('a[href*="wa.me"], a[href*="t.me"], a[href*="tel:"], a[href*="mailto:"]');
            }
            
            $items.addClass('chaty-contact-item');
            
            return { $container, $items };
        }
        
        addContactLabels($widget) {
            const { $items } = this.ensureWidgetStructure($widget);
            
            $items.each((index, item) => {
                const $item = $(item);
                const platform = this.detectContactPlatform($item);
                
                // Check if label already exists
                if ($item.find('.chat-label, .contact-label').length) {
                    return; // Skip if label already exists
                }
                
                if (platform) {
                    const labelText = this.getPlatformLabel(platform);
                    const $label = $('<span class="chat-label"></span>').text(labelText);
                    
                    // Add label to item
                    $item.append($label);
                    
                    // Store platform data for styling
                    $item.attr('data-platform', platform);
                }
            });
        }
        
        detectContactPlatform($item) {
            const href = $item.attr('href') || '';
            const classes = $item.attr('class') || '';
            
            // URL-based detection
            if (href.includes('wa.me') || href.includes('whatsapp')) return 'whatsapp';
            if (href.includes('t.me') || href.includes('telegram')) return 'telegram';
            if (href.includes('tel:')) return 'phone';
            if (href.includes('mailto:')) return 'email';
            if (href.includes('instagram.com')) return 'instagram';
            if (href.includes('facebook.com')) return 'facebook';
            if (href.includes('twitter.com') || href.includes('x.com')) return 'twitter';
            
            // Class-based detection
            const lowerClasses = classes.toLowerCase();
            if (lowerClasses.includes('whatsapp')) return 'whatsapp';
            if (lowerClasses.includes('telegram')) return 'telegram';
            if (lowerClasses.includes('phone')) return 'phone';
            if (lowerClasses.includes('email')) return 'email';
            if (lowerClasses.includes('instagram')) return 'instagram';
            if (lowerClasses.includes('facebook')) return 'facebook';
            if (lowerClasses.includes('twitter')) return 'twitter';
            
            // Icon-based detection
            const $icon = $item.find('i, .icon, [class*="fa-"]');
            if ($icon.length) {
                const iconClasses = $icon.attr('class') || '';
                if (iconClasses.includes('whatsapp')) return 'whatsapp';
                if (iconClasses.includes('telegram')) return 'telegram';
                if (iconClasses.includes('phone')) return 'phone';
                if (iconClasses.includes('envelope') || iconClasses.includes('email')) return 'email';
            }
            
            return null;
        }
        
        getPlatformLabel(platform) {
            const labels = {
                'whatsapp': 'واتساپ',
                'telegram': 'تلگرام',
                'phone': 'تماس',
                'email': 'ایمیل',
                'instagram': 'اینستاگرام',
                'facebook': 'فیسبوک',
                'twitter': 'توییتر'
            };
            
            return labels[platform] || platform;
        }
        
        applyChatyStyles($widget) {
            // Apply base styles to widget
            const widgetCSS = `
                position: fixed !important;
                bottom: 100px !important;
                right: 20px !important;
                z-index: 9999 !important;
                direction: rtl !important;
            `;
            
            $widget.attr('style', widgetCSS);
            
            // Style contact items
            const { $items } = this.ensureWidgetStructure($widget);
            
            $items.each((index, item) => {
                const $item = $(item);
                const platform = $item.attr('data-platform');
                
                // Base styles for all items
                const baseStyles = {
                    'display': 'flex',
                    'flex-direction': 'column',
                    'align-items': 'center',
                    'justify-content': 'center',
                    'padding': '12px 8px',
                    'margin': '8px 0',
                    'width': '70px',
                    'min-height': '70px',
                    'border-radius': '12px',
                    'text-decoration': 'none',
                    'transition': 'all 0.3s ease',
                    'border': '2px solid #e0e0e0',
                    'font-family': 'IRANSans, Arial, sans-serif',
                    'font-size': '11px',
                    'font-weight': '600',
                    'line-height': '1.2'
                };
                
                // Default state: white background, black text, original icon color
                const defaultState = {
                    'background-color': '#ffffff',
                    'color': '#333333'
                };
                
                $item.css(Object.assign({}, baseStyles, defaultState));
                
                // Style the icon
                const $icon = $item.find('i, .icon');
                if ($icon.length && platform) {
                    const iconColor = this.getPlatformColor(platform);
                    $icon.css('color', iconColor);
                }
                
                // Style the label
                const $label = $item.find('.chat-label');
                $label.css({
                    'margin-top': '6px',
                    'font-size': '10px',
                    'text-align': 'center',
                    'font-weight': '600',
                    'color': 'inherit'
                });
            });
        }
        
        getPlatformColor(platform) {
            const colors = {
                'whatsapp': '#25D366',
                'telegram': '#0088cc',
                'phone': '#4CAF50',
                'email': '#EA4335',
                'instagram': '#E4405F',
                'facebook': '#1877F2',
                'twitter': '#1DA1F2'
            };
            
            return colors[platform] || '#666666';
        }
        
        setupChatyBehavior($widget) {
            const { $items } = this.ensureWidgetStructure($widget);
            
            $items.each((index, item) => {
                const $item = $(item);
                const platform = $item.attr('data-platform');
                const brandColor = this.getPlatformColor(platform);
                
                // Store original icon color
                const $icon = $item.find('i, .icon');
                const originalIconColor = $icon.css('color') || brandColor;
                
                // Hover/focus behavior
                $item.on('mouseenter focus', function() {
                    $(this).css({
                        'background-color': brandColor,
                        'color': '#ffffff',
                        'border-color': brandColor,
                        'transform': 'translateY(-2px)',
                        'box-shadow': `0 4px 12px ${brandColor}33`
                    });
                    
                    $icon.css('color', '#ffffff');
                });
                
                $item.on('mouseleave blur', function() {
                    $(this).css({
                        'background-color': '#ffffff',
                        'color': '#333333',
                        'border-color': '#e0e0e0',
                        'transform': 'translateY(0)',
                        'box-shadow': 'none'
                    });
                    
                    $icon.css('color', originalIconColor);
                });
                
                // Touch behavior for mobile
                $item.on('touchstart', function(e) {
                    $(this).trigger('mouseenter');
                });
                
                $item.on('touchend touchcancel', function(e) {
                    setTimeout(() => {
                        $(this).trigger('mouseleave');
                    }, 150);
                });
            });
        }
        
        setupObserver() {
            // Watch for dynamically added chaty widgets
            const observer = new MutationObserver((mutations) => {
                let shouldProcess = false;
                
                mutations.forEach((mutation) => {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach((node) => {
                            if (node.nodeType === 1) {
                                const $node = $(node);
                                
                                if ($node.is('[class*="chaty"], [id*="chaty"]') || 
                                    $node.find('[class*="chaty"], [id*="chaty"]').length) {
                                    shouldProcess = true;
                                }
                            }
                        });
                    }
                });
                
                if (shouldProcess) {
                    console.log('New chaty widget detected, processing...');
                    setTimeout(() => {
                        this.removeDuplicateWidgets();
                        this.fixMainChatyWidget();
                    }, 500);
                }
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }
    
    // Initialize when document is ready
    $(document).ready(() => {
        new ChatyWidgetFixer();
    });
    
    // Also initialize on window load for plugins that load later
    $(window).on('load', () => {
        setTimeout(() => {
            new ChatyWidgetFixer();
        }, 1500);
    });
    
})(jQuery);