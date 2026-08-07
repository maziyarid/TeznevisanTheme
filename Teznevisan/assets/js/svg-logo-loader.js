/**
 * SVG Logo Loader with Automatic Fallback System
 * Handles SVG display with WebP fallback for legacy browsers
 * @version 2.0.0 - Fixed viewBox for correct logo display
 */

(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        svgPath: 'https://teznevisan3.com/assets/images/logo.svg',
        // CORRECTED viewBox to show full logo (removed whitespace)
        viewBox: '3050 40 815 1116',
        logos: {
            header: {
                selector: '.site-branding',
                svgId: 'main',
                svgClass: 'logo-svg',
                fallbackSrc: 'https://teznevisan3.com/assets/images/logo.webp',
                fallbackClass: 'logo-image',
                alt: 'تزنویسان - انجام پایان نامه و پروژه های پژوهشی',
                width: 154,
                height: 40,
                fetchpriority: 'high'
            },
            mobile: {
                selector: '.mobile-menu-header',
                svgId: 'main',
                svgClass: 'mobile-logo-svg',
                fallbackSrc: 'https://teznevisan3.com/assets/images/logo.webp',
                fallbackClass: 'mobile-logo',
                alt: 'تزنویسان',
                width: 120,
                height: 31,
                preserveSelectors: ['.mobile-menu-close']
            },
            footer: {
                selector: '.footer-logo',
                svgId: 'white',
                svgClass: 'footer-logo-svg',
                fallbackSrc: 'https://teznevisan3.com/assets/images/white-logo.webp',
                fallbackClass: 'footer-logo-image',
                alt: 'تزنویسان',
                width: 50,
                height: 50,
                loading: 'lazy'
            }
        },
        fallbackCSS: [
            'https://teznevisan3.com/assets/fonts/iransans/iransans-font.css',
            'https://teznevisan3.com/assets/css/main.css',
            'https://teznevisan3.com/assets/css/components.css',
            'https://teznevisan3.com/assets/css/animations.css',
            'https://teznevisan3.com/assets/css/responsive.css',
            'https://teznevisan3.com/assets/fonts/fontawesome/css/all.css'
        ]
    };

    /**
     * Check SVG support
     */
    function supportsSVG() {
        return !!(
            document.createElementNS && 
            document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect
        );
    }

    /**
     * Load fallback CSS for no-JS environments
     */
    function loadFallbackCSS() {
        const head = document.head || document.getElementsByTagName('head')[0];
        
        CONFIG.fallbackCSS.forEach(function(href) {
            if (!document.querySelector('link[href="' + href + '"]')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = href;
                link.media = 'all';
                head.appendChild(link);
            }
        });
    }

    /**
     * Create fallback image
     */
    function createFallbackImage(logoConfig) {
        const img = document.createElement('img');
        img.src = logoConfig.fallbackSrc;
        img.alt = logoConfig.alt;
        img.className = logoConfig.fallbackClass;
        img.width = logoConfig.width;
        img.height = logoConfig.height;
        
        if (logoConfig.fetchpriority) {
            img.setAttribute('fetchpriority', logoConfig.fetchpriority);
        }
        if (logoConfig.loading) {
            img.loading = logoConfig.loading;
        }
        
        return img;
    }

    /**
     * Replace SVG with fallback for specific logo
     */
    function replaceLogo(logoType) {
        const config = CONFIG.logos[logoType];
        const container = document.querySelector(config.selector);
        
        if (!container) {
            console.warn('[SVG Loader] Container not found:', config.selector);
            return;
        }

        // Check if already replaced
        if (container.querySelector('img.' + config.fallbackClass)) {
            return;
        }

        // Preserve specific elements
        let preserved = [];
        if (config.preserveSelectors) {
            config.preserveSelectors.forEach(function(sel) {
                const el = container.querySelector(sel);
                if (el) preserved.push(el.cloneNode(true));
            });
        }

        // Create and insert fallback
        const img = createFallbackImage(config);
        container.innerHTML = '';
        container.appendChild(img);
        
        // Restore preserved elements
        preserved.forEach(function(el) {
            container.appendChild(el);
        });
    }

    /**
     * Replace all logos
     */
    function replaceAllLogos() {
        Object.keys(CONFIG.logos).forEach(replaceLogo);
    }

    /**
     * Initialize
     */
    function init() {
        // Mark JS as enabled
        document.documentElement.classList.add('js-enabled');

        if (!supportsSVG()) {
            console.info('[SVG Loader] SVG not supported, loading fallbacks...');
            
            // Mark no SVG support
            document.documentElement.classList.add('no-svg');
            
            // Load CSS
            loadFallbackCSS();
            
            // Replace logos
            replaceAllLogos();
            
            // Track fallback usage
            if (window.sessionStorage) {
                sessionStorage.setItem('svg-fallback-active', 'true');
                sessionStorage.setItem('svg-fallback-timestamp', Date.now());
            }
        } else {
            document.documentElement.classList.add('svg-supported');
            console.info('[SVG Loader] SVG supported, using native logos');
        }
    }

    /**
     * Safe init with DOM ready check
     */
    function safeInit() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    }

    // Start
    safeInit();

    // Expose API
    window.TeznevisanLogoLoader = {
        version: '2.0.0',
        config: CONFIG,
        replaceLogo: replaceLogo,
        replaceAllLogos: replaceAllLogos,
        supportsSVG: supportsSVG
    };

})();
