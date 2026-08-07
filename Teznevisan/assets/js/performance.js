/* ====================================
   Performance Optimization Script
   ==================================== */

(function() {
    'use strict';

    // 1. CRITICAL: Font Loading with swap
    if ('fonts' in document) {
        // Preload critical fonts
        const fontFace = new FontFace('IRANSans', 
            'url(https://teznevisan3.com/assets/fonts/iransans/woff2/IRANSansWeb.woff2)',
            { weight: '400', display: 'swap' }
        );
        
        fontFace.load().then(function(loadedFont) {
            document.fonts.add(loadedFont);
        });
    }

    // 2. Lazy Load Images
    function lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        images.forEach(img => imageObserver.observe(img));
    }

    // 3. Defer offscreen content
    function deferOffscreenContent() {
        const sections = document.querySelectorAll('.defer-section');
        
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('loaded');
                }
            });
        }, {
            rootMargin: '100px'
        });
        
        sections.forEach(section => sectionObserver.observe(section));
    }

    // 4. Preconnect to external domains
    function addPreconnects() {
        const domains = [
            'https://fonts.googleapis.com',
            'https://maps.googleapis.com'
        ];
        
        domains.forEach(domain => {
            const link = document.createElement('link');
            link.rel = 'preconnect';
            link.href = domain;
            link.crossOrigin = 'anonymous';
            document.head.appendChild(link);
        });
    }

    // 5. Optimize third-party scripts
    function loadThirdPartyScripts() {
        // Load comments widget after page load
        if (document.querySelector('[data-comments-app-website]')) {
            const script = document.createElement('script');
            script.src = 'https://comments.app/js/widget.js?3';
            script.async = true;
            document.body.appendChild(script);
        }
    }

    // 6. Service Worker for caching
    function registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW registered'))
                    .catch(err => console.log('SW error:', err));
            });
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        lazyLoadImages();
        deferOffscreenContent();
        addPreconnects();
        
        // Load third-party after 3 seconds
        setTimeout(loadThirdPartyScripts, 3000);
        
        // Register service worker
        registerServiceWorker();
        
        // Mark page as loaded
        document.body.classList.remove('loading');
        document.body.classList.add('loaded');
    }
})();
