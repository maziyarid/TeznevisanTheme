/**
 * Single Post Interactive Features
 * Vanilla JavaScript - No dependencies
 */

(function() {
    'use strict';

    // ==========================================
    // Copy Link Functionality
    // ==========================================
    function initCopyLink() {
        const copyButtons = document.querySelectorAll('.copy-link');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', async function() {
                const url = this.getAttribute('data-url');
                
                try {
                    await navigator.clipboard.writeText(url);
                    
                    // Visual feedback
                    const originalText = this.querySelector('.share-text').textContent;
                    this.querySelector('.share-text').textContent = 'کپی شد!';
                    this.style.backgroundColor = '#10b981';
                    
                    setTimeout(() => {
                        this.querySelector('.share-text').textContent = originalText;
                        this.style.backgroundColor = '';
                    }, 2000);
                    
                } catch (err) {
                    console.error('Failed to copy:', err);
                    alert('خطا در کپی کردن لینک');
                }
            });
        });
    }

    // ==========================================
    // Smooth Scroll for TOC
    // ==========================================
    function initSmoothScroll() {
        const tocLinks = document.querySelectorAll('.toc-link');
        
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 100;
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    
                    // Update URL without jumping
                    history.pushState(null, null, targetId);
                    
                    // Focus management for accessibility
                    targetElement.setAttribute('tabindex', '-1');
                    targetElement.focus();
                }
            });
        });
    }

    // ==========================================
    // Reading Progress Bar
    // ==========================================
    function initReadingProgress() {
        // Create progress bar element
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        progressBar.setAttribute('role', 'progressbar');
        progressBar.setAttribute('aria-label', 'پیشرفت خواندن مقاله');
        progressBar.setAttribute('aria-valuemin', '0');
        progressBar.setAttribute('aria-valuemax', '100');
        
        document.body.appendChild(progressBar);
        
        // Add CSS
        const style = document.createElement('style');
        style.textContent = `
            .reading-progress {
                position: fixed;
                top: 0;
                right: 0;
                width: 0%;
                height: 4px;
                background: linear-gradient(90deg, #1FA547 0%, #3b82f6 100%);
                z-index: 9999;
                transition: width 0.1s ease-out;
            }
        `;
        document.head.appendChild(style);
        
        // Update progress on scroll
        function updateProgress() {
            const article = document.querySelector('.entry-content');
            if (!article) return;
            
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            const scrolled = scrollTop - articleTop + windowHeight;
            const total = articleHeight + windowHeight;
            const progress = Math.min(Math.max((scrolled / total) * 100, 0), 100);
            
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', Math.round(progress));
        }
        
        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    }

    // ==========================================
    // Lazy Load Images (for older browsers)
    // ==========================================
    function initLazyLoad() {
        if ('loading' in HTMLImageElement.prototype) {
            return; // Native lazy loading supported
        }
        
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        images.forEach(img => imageObserver.observe(img));
    }

    // ==========================================
    // Active TOC Item Highlight
    // ==========================================
    function initActiveTOC() {
        const headings = document.querySelectorAll('.entry-content h2[id], .entry-content h3[id], .entry-content h4[id]');
        const tocLinks = document.querySelectorAll('.toc-link');
        
        if (headings.length === 0 || tocLinks.length === 0) return;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    
                    // Remove active class from all links
                    tocLinks.forEach(link => link.classList.remove('active'));
                    
                    // Add active class to current link
                    const activeLink = document.querySelector(`.toc-link[href="#${id}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                }
            });
        }, {
            rootMargin: '-100px 0px -66%',
            threshold: 0
        });
        
        headings.forEach(heading => observer.observe(heading));
        
        // Add CSS for active state
        const style = document.createElement('style');
        style.textContent = `
            .toc-link.active {
                color: var(--color-primary);
                font-weight: 600;
            }
        `;
        document.head.appendChild(style);
    }

    // ==========================================
    // Print Friendly
    // ==========================================
    function initPrintFriendly() {
        window.addEventListener('beforeprint', () => {
            // Expand all collapsed sections
            document.querySelectorAll('details').forEach(detail => {
                detail.setAttribute('open', '');
            });
        });
    }

    // ==========================================
    // Accessibility: Skip Links
    // ==========================================
    function initSkipLinks() {
        const skipLink = document.createElement('a');
        skipLink.href = '#primary';
        skipLink.className = 'skip-link';
        skipLink.textContent = 'پرش به محتوای اصلی';
        document.body.insertBefore(skipLink, document.body.firstChild);
    }



    // ==========================================
    // Initialize All Features
    // ==========================================
    function init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }
        
        initCopyLink();
        initSmoothScroll();
        initReadingProgress();
        initLazyLoad();
        initActiveTOC();
        initPrintFriendly();
        initSkipLinks();

        console.log('✅ Single post features initialized');
    }

    init();

})();
