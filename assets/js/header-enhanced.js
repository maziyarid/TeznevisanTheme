(function() {
    'use strict';
    
    let searchTimeout;
    let searchCache = new Map();
    
    function log(message, type = 'info') {
        const prefix = 'Header Enhanced:';
        if (type === 'error') {
            console.error(`❌ ${prefix}`, message);
        } else {
            console.log(`✅ ${prefix}`, message);
        }
    }
    
    function initHeaderEnhanced() {
        log('Starting enhanced initialization');
        
        try {
            // Initialize AJAX search
            initAjaxSearch();
            
            // Initialize enhanced animations
            initEnhancedAnimations();
            
            // Initialize performance monitoring
            initPerformanceMonitoring();
            
            log('All enhanced features initialized');
            
        } catch (error) {
            log(error, 'error');
        }
    }
    
    // AJAX Search functionality
    function initAjaxSearch() {
        const searchField = document.querySelector('.search-field');
        const searchForm = document.querySelector('.search-form');
        const resultsContainer = document.getElementById('search-results');
        
        if (!searchField || !searchForm || !resultsContainer) {
            log('Search elements not found', 'error');
            return;
        }
        
        // Debounced search function
        const debouncedSearch = debounce(performSearch, 300);
        
        // Search input event
        searchField.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            if (query.length >= 2) {
                debouncedSearch(query);
            } else {
                clearSearchResults();
            }
        });
        
        // Form submit event
        searchForm.addEventListener('submit', function(e) {
            const query = searchField.value.trim();
            if (query.length < 2) {
                e.preventDefault();
                showSearchMessage('لطفاً حداقل 2 کاراکتر وارد کنید');
            }
        });
        
        log('AJAX search initialized');
    }
    
    function performSearch(query) {
        const resultsContainer = document.getElementById('search-results');
        if (!resultsContainer) return;
        
        // Check cache first
        if (searchCache.has(query)) {
            displaySearchResults(searchCache.get(query), resultsContainer);
            return;
        }
        
        // Show loading
        showSearchLoading(resultsContainer);
        
        // Prepare AJAX request
        const formData = new FormData();
        formData.append('action', 'ajax_search');
        formData.append('query', query);
        formData.append('nonce', window.teznevisanData?.nonce || '');
        
        // Perform AJAX request
        fetch(window.teznevisanData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cache results
                searchCache.set(query, data.data);
                displaySearchResults(data.data, resultsContainer);
            } else {
                showSearchMessage(data.data?.message || 'خطا در جستجو');
            }
        })
        .catch(error => {
            log(`Search error: ${error.message}`, 'error');
            showSearchMessage('خطا در برقراری ارتباط');
        });
    }
    
    function showSearchLoading(container) {
        container.innerHTML = `
            <div class="search-loading">
                <div class="loading-spinner"></div>
                <span>در حال جستجو...</span>
            </div>
        `;
        container.style.display = 'block';
        container.classList.add('animate-fadeIn');
    }
    
    function displaySearchResults(results, container) {
        if (!results || results.length === 0) {
            showSearchMessage('نتیجه‌ای یافت نشد');
            return;
        }
        
        const html = results.slice(0, 8).map((result, index) => `
            <div class="search-result-item" 
                 onclick="window.location.href='${result.url}'"
                 style="animation-delay: ${index * 50}ms">
                <div class="search-result-title">${result.title}</div>
                <div class="search-result-excerpt">${result.excerpt}</div>
                <div class="search-result-meta">
                    <span class="result-type">${result.type}</span>
                    <span class="result-date">${result.date}</span>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = html;
        container.style.display = 'block';
        
        // Animate results
        const items = container.querySelectorAll('.search-result-item');
        items.forEach(item => {
            item.classList.add('animate-slideInUp');
        });
        
        log(`Displayed ${results.length} search results`);
    }
    
    function showSearchMessage(message) {
        const container = document.getElementById('search-results');
        if (!container) return;
        
        container.innerHTML = `
            <div class="search-message">
                <i class="fa-solid fa-circle-info"></i>
                <span>${message}</span>
            </div>
        `;
        container.style.display = 'block';
        container.classList.add('animate-fadeIn');
    }
    
    function clearSearchResults() {
        const container = document.getElementById('search-results');
        if (container) {
            container.style.display = 'none';
            container.innerHTML = '';
        }
    }
    
    function initMobileMenu() {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu-overlay');
        const close = document.getElementById('mobile-menu-close');
        const body = document.body;
        
        if (!toggle || !menu) {
            log('Mobile menu elements not found', 'error');
            return;
        }
        
        function openMenu() {
            menu.classList.add('open');
            menu.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add('active');
            body.style.overflow = 'hidden';
            
            // Animate menu items
            const menuItems = menu.querySelectorAll('.mobile-menu');
            menuItems.forEach(menuList => {
                menuList.classList.add('animate');
            });
            
            log('Mobile menu opened');
        }
        
        function closeMenu() {
            menu.classList.remove('open');
            menu.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('active');
            body.style.overflow = '';
            
            // Reset animations
            const menuItems = menu.querySelectorAll('.mobile-menu');
            menuItems.forEach(menuList => {
                menuList.classList.remove('animate');
            });
            
            log('Mobile menu closed');
        }
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = menu.classList.contains('open');
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });
        
        if (close) {
            close.addEventListener('click', closeMenu);
        }
        
        menu.addEventListener('click', function(e) {
            if (e.target === menu) {
                closeMenu();
            }
        });
        
        // Expose globally
        window.TezMobile = { openMenu, closeMenu };
        
        log('Mobile menu functionality initialized');
    }
    
    function initSearch() {
        const toggle = document.getElementById('search-toggle');
        const modal = document.getElementById('search-modal');
        const close = document.getElementById('search-close');
        const field = document.querySelector('.search-field');
        const body = document.body;
        
        if (!toggle || !modal) {
            log('Search elements not found', 'error');
            return;
        }
        
        function openSearch() {
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            body.style.overflow = 'hidden';
            
            if (field) {
                setTimeout(() => field.focus(), 150);
            }
            
            log('Search opened');
        }
        
        function closeSearch() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            body.style.overflow = '';
            
            clearSearchResults();
            
            log('Search closed');
        }
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            openSearch();
        });
        
        if (close) {
            close.addEventListener('click', closeSearch);
        }
        
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeSearch();
            }
        });
        
        // Expose globally
        window.TezSearch = { openSearch, closeSearch };
        
        log('Search functionality initialized');
    }
    
    function initScrollBehavior() {
        const header = document.querySelector('.site-header');
        if (!header) return;
        
        let lastScrollTop = 0;
        let ticking = false;
        
        const handleScroll = throttle(function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    const scrollTop = window.pageYOffset;
                    
                    if (window.innerWidth <= 768) {
                        if (scrollTop > lastScrollTop && scrollTop > 100) {
                            header.style.transform = 'translateY(-100%)';
                        } else {
                            header.style.transform = 'translateY(0)';
                        }
                    } else {
                        header.style.transform = 'translateY(0)';
                        
                        // Add shadow on scroll
                        if (scrollTop > 50) {
                            header.style.boxShadow = 'var(--shadow-lg)';
                        } else {
                            header.style.boxShadow = 'var(--shadow-md)';
                        }
                    }
                    
                    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
                    ticking = false;
                });
            }
            ticking = true;
        }, 16);
        
        window.addEventListener('scroll', handleScroll, { passive: true });
        log('Scroll behavior initialized');
    }
    
    function initEnhancedAnimations() {
        // Add entrance animations to elements
        const animatedElements = document.querySelectorAll('.site-header, .accessibility-widget, .chaty-widget');
        
        animatedElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 200);
        });
        
        log('Enhanced animations initialized');
    }
    
    function initPerformanceMonitoring() {
        if (window.performance && window.performance.mark) {
            window.performance.mark('headerEnhanced:start');
            
            setTimeout(() => {
                window.performance.mark('headerEnhanced:end');
                window.performance.measure('headerEnhanced:duration', 'headerEnhanced:start', 'headerEnhanced:end');
                
                const measures = window.performance.getEntriesByType('measure');
                const headerMeasure = measures.find(m => m.name === 'headerEnhanced:duration');
                
                if (headerMeasure) {
                    log(`Initialization completed in ${headerMeasure.duration.toFixed(2)}ms`);
                }
            }, 100);
        }
    }
    
    function validateAriaControls() {
        const elementsWithControls = [
            { selector: '#mobile-menu-toggle', controls: 'mobile-menu-overlay' },
            { selector: '#search-toggle', controls: 'search-modal' },
            { selector: '#accessibility-toggle', controls: 'accessibility-panel' }
        ];
        
        elementsWithControls.forEach(item => {
            const element = document.querySelector(item.selector);
            if (element) {
                if (!element.hasAttribute('aria-controls')) {
                    element.setAttribute('aria-controls', item.controls);
                    log(`Fixed missing aria-controls for: ${item.selector}`);
                }
            }
        });
    }
    
    // Utility functions
    function debounce(func, wait) {
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
    
    function throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
    // Window resize handler
    window.addEventListener('resize', debounce(function() {
        if (window.innerWidth > 768) {
            // Close mobile menu on desktop resize
            if (window.TezMobile && document.getElementById('mobile-menu-overlay')?.classList.contains('open')) {
                window.TezMobile.closeMenu();
            }
            
            // Reset header position
            const header = document.querySelector('.site-header');
            if (header) {
                header.style.transform = 'translateY(0)';
                header.style.boxShadow = 'var(--shadow-md)';
            }
        }
        
        // Adjust accessibility panel on very small screens
        const accessibilityPanel = document.getElementById('accessibility-panel');
        if (accessibilityPanel && window.innerWidth < 400) {
            accessibilityPanel.style.width = 'calc(100vw - 70px)';
        }
    }, 250));
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeaderEnhanced);
    } else {
        initHeaderEnhanced();
    }
    
    // Global API
    window.TezHeaderEnhanced = {
        initAjaxSearch,
        performSearch,
        clearSearchResults,
        version: '2.0.0'
    };
    
    log('Header Enhanced JavaScript loaded');
    
})();