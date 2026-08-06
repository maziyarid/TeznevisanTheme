/**
 * Critical JavaScript - COMPLETELY FIXED VERSION
 */

(function() {
    'use strict';
    
    let isInitialized = false;
    
    function log(message, type = 'info') {
        const prefix = 'Critical JS:';
        if (type === 'error') {
            console.error(`❌ ${prefix}`, message);
        } else {
            console.log(`✅ ${prefix}`, message);
        }
    }
    
    function init() {
        if (isInitialized) return;
        
        try {
            log('Starting initialization');
            
            ensureFontAwesome();
            
            // Wait for complete DOM ready
            setTimeout(() => {
                initMobileMenuComplete();
                initSearchComplete();
                initChatyComplete();
                initScrollBehavior();
                
                isInitialized = true;
                log('ALL COMPONENTS INITIALIZED SUCCESSFULLY');
            }, 800);
            
        } catch (error) {
            log(error, 'error');
        }
    }
    
    function ensureFontAwesome() {
        const style = document.createElement('style');
        style.textContent = `
            .fa, .fas, .far, .fab, [class^=fa-], [class*=fa-] {
                font-family: "Font Awesome 7 Pro", "Font Awesome 7 Brands", FontAwesome !important;
                font-weight: 900 !important;
                direction: ltr !important;
                display: inline-block !important;
                -webkit-font-smoothing: antialiased !important;
            }
            /* Regular style (far) renamed to fa-regular in Font Awesome 7 Pro */
.fa-regular {
  font-weight: 400 !important;
}

/* Brands style with updated font-family naming */
.fa-brands {
  font-family: "Font Awesome 7 Brands" !important;
  font-weight: 400 !important;
}

/* FORCE SPECIFIC ICONS - Unicode content codes remain the same for FA7 Pro */
/* Use updated CSS selectors with new style prefix where applicable */

.fa-whatsapp:before {
  content: "\f232" !important;
}

.fa-telegram:before {
  content: "\f2c6" !important;
}

.fa-telegram-plane:before {
  content: "\f3fe" !important;
}

.fa-comment-sms:before {
  content: "\f7cd" !important;
}

.fa-paper-plane:before {
  content: "\f1d8" !important;
}`;
        document.head.appendChild(style);
        log('FontAwesome with ALL ICONS ensured');
    }
    
    // COMPLETELY FIXED MOBILE MENU
    function initMobileMenuComplete() {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu-overlay');
        const close = document.getElementById('mobile-menu-close');
        const body = document.body;
        
        log(`Mobile menu check: toggle=${!!toggle}, menu=${!!menu}, close=${!!close}`);
        
        if (!toggle || !menu) {
            log('❌ Mobile menu elements not found!', 'error');
            return;
        }
        
        let isMenuOpen = false;
        
        function openMenu() {
            log('🚀 OPENING MOBILE MENU...');
            
            try {
                isMenuOpen = true;
                
                // Force immediate visibility
                menu.style.right = '0px';
                menu.style.opacity = '1';
                menu.style.visibility = 'visible';
                menu.style.display = 'flex';
                
                // Add classes
                menu.classList.add('open');
                menu.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'true');
                toggle.classList.add('active');
                body.style.overflow = 'hidden';
                
                // Force wrapper animation
                const wrapper = menu.querySelector('.mobile-menu-wrapper');
                if (wrapper) {
                    wrapper.style.transform = 'translateX(0)';
                    wrapper.style.transition = 'transform 0.4s ease';
                }
                
                // Animate menu items
                setTimeout(() => {
                const menuItems = menu.querySelectorAll('.mobile-menu .menu-item');
                menuItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 100);
            });
            log('✅ Menu animation triggered');
        }, 200);
                
                log('✅ MOBILE MENU OPENED SUCCESSFULLY');
                
            } catch (error) {
                log('❌ Error opening mobile menu: ' + error.message, 'error');
            }
        }
        
        function closeMenu() {
            log('🔒 CLOSING MOBILE MENU...');
            
            try {
                isMenuOpen = false;
                
                // Remove classes
                menu.classList.remove('open');
                menu.setAttribute('aria-hidden', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.classList.remove('active');
                body.style.overflow = '';
                
                // Reset wrapper
                const wrapper = menu.querySelector('.mobile-menu-wrapper');
                if (wrapper) {
                    wrapper.style.transform = 'translateX(100%)';
                }
                
                // Reset animations
                const menuList = menu.querySelector('.mobile-menu');
                if (menuList) {
                    menuList.classList.remove('animate');
                }
                
                // Reset styles after animation
                setTimeout(() => {
                    menu.style.right = '';
                    menu.style.opacity = '';
                    menu.style.visibility = '';
                    menu.style.display = '';
                }, 400);
                
                log('✅ MOBILE MENU CLOSED SUCCESSFULLY');
                
            } catch (error) {
                log('❌ Error closing mobile menu: ' + error.message, 'error');
            }
        }
        
        // MULTIPLE EVENT HANDLERS FOR MAXIMUM COMPATIBILITY
        
        // Primary click handler
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            log('🖱️ MOBILE TOGGLE CLICKED - State: ' + (isMenuOpen ? 'OPEN' : 'CLOSED'));
            
            if (isMenuOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });
        
        // Touch handlers for mobile devices
        let touchStartTime = 0;
        
        toggle.addEventListener('touchstart', function(e) {
            touchStartTime = Date.now();
            log('👆 MOBILE TOGGLE TOUCH START');
        }, { passive: true });
        
        toggle.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const touchDuration = Date.now() - touchStartTime;
            
            log(`👆 MOBILE TOGGLE TOUCH END - Duration: ${touchDuration}ms`);
            
            // Only trigger if it's a quick tap
            if (touchDuration < 500) {
                if (isMenuOpen) {
                    closeMenu();
                } else {
                    openMenu();
                }
            }
        }, { passive: false });
        
        // Close button handlers
        if (close) {
            close.addEventListener('click', function(e) {
                e.preventDefault();
                log('❌ CLOSE BUTTON CLICKED');
                closeMenu();
            });
            
            close.addEventListener('touchend', function(e) {
                e.preventDefault();
                log('❌ CLOSE BUTTON TOUCHED');
                closeMenu();
            }, { passive: false });
        }
        
        // Overlay click to close
        menu.addEventListener('click', function(e) {
            if (e.target === menu) {
                log('📱 OVERLAY CLICKED');
                closeMenu();
            }
        });
        
        // Keyboard support
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen) {
                log('⌨️ ESCAPE KEY PRESSED');
                closeMenu();
            }
        });
        
        // Expose globally
        window.TezMobile = { 
            openMenu, 
            closeMenu, 
            isOpen: () => isMenuOpen,
            toggle: toggle,
            menu: menu,
            debug: () => log(`Mobile menu state: ${isMenuOpen}`)
        };
        
        log('🎉 MOBILE MENU INITIALIZED');
    }
    
    function initSearchComplete() {
        const toggle = document.getElementById('search-toggle');
        const modal = document.getElementById('search-modal');
        const close = document.getElementById('search-close');
        const field = document.querySelector('.search-field');
        const body = document.body;
        
        if (!toggle || !modal) {
            log('Search elements not found', 'error');
            return;
        }
        
        let isSearchOpen = false;
        
        function openSearch() {
            isSearchOpen = true;
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            body.style.overflow = 'hidden';
            
            if (field) {
                setTimeout(() => {
                    field.focus();
                    log('Search field focused');
                }, 200);
            }
            
            log('Search opened');
        }
        
        function closeSearch() {
            isSearchOpen = false;
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            body.style.overflow = '';
            
            clearSearchResults();
            log('Search closed');
        }
        
        // Click handler
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openSearch();
        });
        
        // Touch handler
        toggle.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openSearch();
        }, { passive: false });
        
        if (close) {
            close.addEventListener('click', closeSearch);
            close.addEventListener('touchend', closeSearch, { passive: false });
        }
        
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeSearch();
            }
        });
        
        // Popular search tags
        const searchTags = document.querySelectorAll('.search-tag');
        searchTags.forEach(tag => {
            tag.addEventListener('click', function() {
                const searchTerm = this.getAttribute('data-search');
                if (field && searchTerm) {
                    field.value = searchTerm;
                    field.focus();
                    performSearch(searchTerm);
                }
            });
        });
        
        // AJAX search
        if (field) {
            let searchTimeout;
            field.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length >= 2) {
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                } else {
                    clearSearchResults();
                }
            });
        }
        
        window.TezSearch = { 
            openSearch, 
            closeSearch, 
            isOpen: () => isSearchOpen 
        };
        
        log('Search initialized');
    }
    
    function performSearch(query) {
        const resultsContainer = document.getElementById('search-results');
        if (!resultsContainer) return;
        
        log('Performing AJAX search for: ' + query);
        
        // Show loading
        resultsContainer.innerHTML = '<div class="search-loading"><div class="loading-spinner"></div><span>در حال جستجو...</span></div>';
        resultsContainer.style.display = 'block';
        
        const formData = new FormData();
        formData.append('action', 'ajax_search');
        formData.append('query', query);
        formData.append('nonce', window.teznevisanData?.nonce || '');
        
        const ajaxUrl = window.teznevisanData?.ajaxUrl || '/wp-admin/admin-ajax.php';
        
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySearchResults(data.data);
            } else {
                showSearchMessage(data.data?.message || 'خطا در جستجو');
            }
        })
        .catch(error => {
            log('AJAX Error: ' + error.message, 'error');
            showSearchMessage('خطا در اتصال به سرور');
        });
    }
    
    function displaySearchResults(results) {
        const container = document.getElementById('search-results');
        if (!container) return;
        
        if (!results || results.length === 0) {
            showSearchMessage('نتیجه‌ای یافت نشد');
            return;
        }
        
        const html = results.map(result => `
            <div class="search-result-item" onclick="window.location.href='${result.url}'">
                <div class="search-result-title">${result.title}</div>
                <div class="search-result-excerpt">${result.excerpt}</div>
            </div>
        `).join('');
        
        container.innerHTML = html;
        container.style.display = 'block';
        
        log(`✅ Displayed ${results.length} search results`);
    }
    
    function showSearchMessage(message) {
        const container = document.getElementById('search-results');
        if (!container) return;
        
        container.innerHTML = `<div class="search-message"><i class="fas fa-info-circle"></i><span>${message}</span></div>`;
        container.style.display = 'block';
    }
    
    function clearSearchResults() {
        const container = document.getElementById('search-results');
        if (container) {
            container.style.display = 'none';
            container.innerHTML = '';
        }
    }
    
    // COMPLETELY FIXED CHATY
    function initChatyComplete() {
        const toggle = document.getElementById('chaty-toggle');
        const channels = document.getElementById('chaty-channels');
        
        log(`Chaty check: toggle=${!!toggle}, channels=${!!channels}`);
        
        if (!toggle || !channels) {
            log('Chaty elements not found', 'error');
            return;
        }
        
        let isChatyOpen = false;
        
        function openChaty() {
            log('🚀 OPENING CHATY...');
            
            try {
                isChatyOpen = true;
                
                // Update toggle
                toggle.classList.add('active');
                toggle.innerHTML = '<i class="fas fa-times"></i>';
                toggle.setAttribute('aria-expanded', 'true');
                
                // Show channels
                channels.classList.add('open');
                channels.setAttribute('aria-hidden', 'false');
                channels.style.opacity = '1';
                channels.style.visibility = 'visible';
                channels.style.transform = 'translateY(0)';
                
                log('✅ CHATY OPENED SUCCESSFULLY');
                
            } catch (error) {
                log('❌ Error opening chaty: ' + error.message, 'error');
            }
        }
        
        function closeChaty() {
            log('🔒 CLOSING CHATY...');
            
            try {
                isChatyOpen = false;
                
                // Update toggle
                toggle.classList.remove('active');
                toggle.innerHTML = '<i class="fas fa-comments"></i>';
                toggle.setAttribute('aria-expanded', 'false');
                
                // Hide channels
                channels.classList.remove('open');
                channels.setAttribute('aria-hidden', 'true');
                
                setTimeout(() => {
                    channels.style.opacity = '';
                    channels.style.visibility = '';
                    channels.style.transform = '';
                }, 300);
                
                log('✅ CHATY CLOSED SUCCESSFULLY');
                
            } catch (error) {
                log('❌ Error closing chaty: ' + error.message, 'error');
            }
        }
        
        // Click handler
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            log('🖱️ CHATY TOGGLE CLICKED');
            
            if (isChatyOpen) {
                closeChaty();
            } else {
                openChaty();
            }
        });
        
        // Touch handler
        toggle.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            log('👆 CHATY TOGGLE TOUCHED');
            
            if (isChatyOpen) {
                closeChaty();
            } else {
                openChaty();
            }
        }, { passive: false });
        
        // Close on outside click
        document.addEventListener('click', function(e) {
            const widget = document.getElementById('chaty-widget');
            if (isChatyOpen && widget && !widget.contains(e.target)) {
                closeChaty();
            }
        });
        
        window.TezChaty = { 
            openChaty, 
            closeChaty, 
            isOpen: () => isChatyOpen 
        };
        
        log('🎉 CHATY INITIALIZED');
    }
    
    function initScrollBehavior() {
        const header = document.querySelector('.site-header');
        if (!header) return;
        
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            
            if (window.innerWidth <= 768) {
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
            }
            
            lastScrollTop = scrollTop;
        }, { passive: true });
        
        log('Scroll behavior initialized');
    }
    
    // Global keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (window.TezMobile?.isOpen()) {
                window.TezMobile.closeMenu();
            }
            if (window.TezSearch?.isOpen()) {
                window.TezSearch.closeSearch();
            }
            if (window.TezChaty?.isOpen()) {
                window.TezChaty.closeChaty();
            }
        }
        
        if (e.key === '/' && !e.ctrlKey && !e.metaKey) {
            const activeElement = document.activeElement;
            if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
                e.preventDefault();
                if (window.TezSearch) {
                    window.TezSearch.openSearch();
                }
            }
        }
    });
    
    window.TezCritical = {
        init,
        log,
        isReady: () => isInitialized
    };
    
    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        setTimeout(init, 200);
    }
    
    log('🚀 CRITICAL JS LOADED');
})();