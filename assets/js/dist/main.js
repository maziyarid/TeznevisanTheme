/**
 * Teznevisan Main JavaScript - Compiled from TypeScript
 * Production-ready version with all functionality
 */
(function() {
    'use strict';
    
    // Configuration
    const TeznevisanConfig = {
        theme: 'teznevisan',
        version: '1.0.0',
        debug: false
    };
    
    // Initialize all components
    class TeznevisanMain {
        constructor() {
            this.components = new Map();
            this.init();
        }
        
        init() {
            this.registerComponents();
            this.initializeComponents();
            this.bindGlobalEvents();
        }
        
        registerComponents() {
            // Register all main theme components
            this.components.set('accessibility', TeznevisanAccessibility);
            this.components.set('mobileMenu', TeznevisanMobileMenu);
            this.components.set('headerEnhanced', TeznevisanHeaderEnhanced);
            this.components.set('chatyFixer', ChatyWidgetFixer);
        }
        
        initializeComponents() {
            // Initialize components when their elements are found
            document.addEventListener('DOMContentLoaded', () => {
                this.components.forEach((ComponentClass, name) => {
                    try {
                        if (typeof ComponentClass === 'function') {
                            new ComponentClass();
                            console.log(`✓ ${name} component initialized`);
                        }
                    } catch (error) {
                        console.warn(`✗ Failed to initialize ${name}:`, error);
                    }
                });
            });
        }
        
        bindGlobalEvents() {
            // Global theme events
            window.addEventListener('resize', this.debounce(() => {
                this.handleResize();
            }, 250));
            
            window.addEventListener('orientationchange', () => {
                setTimeout(() => {
                    this.handleResize();
                }, 500);
            });
        }
        
        handleResize() {
            // Emit resize event for components
            const resizeEvent = new CustomEvent('teznevisanResize', {
                detail: {
                    width: window.innerWidth,
                    height: window.innerHeight,
                    isMobile: window.innerWidth <= 768
                }
            });
            
            document.dispatchEvent(resizeEvent);
        }
        
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    }
    
    // Utility functions
    window.TeznevisanUtils = {
        // Persian number conversion
        toPersianNumbers: function(str) {
            const english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            
            for (let i = 0; i < english.length; i++) {
                str = str.replace(new RegExp(english[i], 'g'), persian[i]);
            }
            
            return str;
        },
        
        // Accessibility announcer
        announce: function(message, priority = 'polite') {
            let announcer = document.getElementById('global-announcer');
            if (!announcer) {
                announcer = document.createElement('div');
                announcer.id = 'global-announcer';
                announcer.setAttribute('aria-live', priority);
                announcer.setAttribute('aria-atomic', 'true');
                announcer.className = 'sr-only';
                document.body.appendChild(announcer);
            }
            
            announcer.textContent = '';
            setTimeout(() => {
                announcer.textContent = message;
            }, 100);
        },
        
        // RTL detection
        isRTL: function() {
            return document.documentElement.dir === 'rtl' || 
                   document.documentElement.lang === 'fa' ||
                   document.body.classList.contains('rtl');
        },
        
        // Mobile detection
        isMobile: function() {
            return window.innerWidth <= 768;
        },
        
        // Touch detection
        isTouch: function() {
            return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        }
    };
    
    // Initialize main application
    window.TeznevisanApp = new TeznevisanMain();
    
    // Export for global access
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = TeznevisanMain;
    }
    
})();